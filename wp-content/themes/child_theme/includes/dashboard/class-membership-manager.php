<?php
/**
 * Membership Manager Class
 * Handles membership management functionality
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Membership_Manager {
    /**
     * Data manager instance
     *
     * @var Athlete_Dashboard_Membership_Data_Manager
     */
    private $data_manager;

    /**
     * Constructor
     */
    public function __construct() {
        $this->data_manager = new Athlete_Dashboard_Membership_Data_Manager();
        $this->init();
    }

    /**
     * Initialize membership manager
     */
    private function init() {
        // Add AJAX handlers
        add_action('wp_ajax_get_membership', array($this, 'handle_get_membership'));
        add_action('wp_ajax_update_membership', array($this, 'handle_update_membership'));
        add_action('wp_ajax_process_renewal', array($this, 'handle_process_renewal'));
        
        // Add REST API endpoints
        add_action('rest_api_init', array($this, 'register_rest_routes'));
    }

    /**
     * Get user membership
     *
     * @param int $user_id User ID
     * @return object|false Membership object or false
     */
    public function get_user_membership($user_id) {
        $details = $this->data_manager->get_membership_details($user_id);
        if (empty($details['type'])) {
            return false;
        }

        $types = $this->data_manager->get_membership_types();
        $type = $details['type'];

        if (!isset($types[$type])) {
            return false;
        }

        return (object) array(
            'is_active' => $this->data_manager->is_membership_active($user_id),
            'plan_name' => $types[$type]['name'],
            'plan_description' => sprintf(
                __('Access to %s features and benefits', 'athlete-dashboard'),
                $types[$type]['name']
            ),
            'features' => $this->format_membership_features($types[$type]['features'])
        );
    }

    /**
     * Get user subscription
     *
     * @param int $user_id User ID
     * @return object|false Subscription object or false
     */
    public function get_user_subscription($user_id) {
        $details = $this->data_manager->get_membership_details($user_id);
        if (!$this->data_manager->is_membership_active($user_id)) {
            return false;
        }

        $types = $this->data_manager->get_membership_types();
        $type = $details['type'];

        return (object) array(
            'next_payment_date' => $details['end_date'],
            'amount' => $types[$type]['price'],
            'trial_end_date' => null, // Implement trial logic if needed
            'can_upgrade' => $type === 'basic'
        );
    }

    /**
     * Format price
     *
     * @param float $price Price to format
     * @return string Formatted price
     */
    public function format_price($price) {
        return sprintf('$%.2f', $price);
    }

    /**
     * Get available plans
     *
     * @return array Array of available plans
     */
    public function get_available_plans() {
        $types = $this->data_manager->get_membership_types();
        $plans = array();

        foreach ($types as $type => $data) {
            $plans[] = (object) array(
                'ID' => $type,
                'name' => $data['name'],
                'price' => $data['price'],
                'billing_period' => sprintf(
                    __('per %d days', 'athlete-dashboard'),
                    $data['duration']
                ),
                'features' => $this->format_membership_features($data['features'])
            );
        }

        return $plans;
    }

    /**
     * Format membership features
     *
     * @param array $features Array of feature keys
     * @return array Formatted features
     */
    private function format_membership_features($features) {
        $feature_details = array(
            'workout_tracking' => array(
                'icon' => 'fas fa-dumbbell',
                'description' => __('Workout Tracking', 'athlete-dashboard')
            ),
            'basic_analytics' => array(
                'icon' => 'fas fa-chart-bar',
                'description' => __('Basic Analytics', 'athlete-dashboard')
            ),
            'advanced_analytics' => array(
                'icon' => 'fas fa-chart-line',
                'description' => __('Advanced Analytics', 'athlete-dashboard')
            ),
            'nutrition_planning' => array(
                'icon' => 'fas fa-apple-alt',
                'description' => __('Nutrition Planning', 'athlete-dashboard')
            ),
            'personal_coaching' => array(
                'icon' => 'fas fa-user-friends',
                'description' => __('Personal Coaching', 'athlete-dashboard')
            )
        );

        return array_map(function($feature) use ($feature_details) {
            return (object) $feature_details[$feature];
        }, $features);
    }

    /**
     * Get usage statistics
     *
     * @param int $user_id User ID
     * @return array Array of usage statistics
     */
    public function get_usage_statistics($user_id) {
        $stats = array();
        $features = $this->data_manager->get_access_features($user_id);

        foreach ($features as $feature) {
            switch ($feature) {
                case 'workout_tracking':
                    $stats[] = (object) array(
                        'label' => __('Workouts Logged', 'athlete-dashboard'),
                        'value' => $this->get_workout_count($user_id),
                        'limit' => null
                    );
                    break;
                case 'nutrition_planning':
                    $stats[] = (object) array(
                        'label' => __('Meal Plans', 'athlete-dashboard'),
                        'value' => $this->get_meal_plan_count($user_id),
                        'limit' => 10
                    );
                    break;
                case 'personal_coaching':
                    $stats[] = (object) array(
                        'label' => __('Coaching Sessions', 'athlete-dashboard'),
                        'value' => $this->get_coaching_session_count($user_id),
                        'limit' => 4
                    );
                    break;
            }
        }

        return $stats;
    }

    /**
     * Get workout count
     *
     * @param int $user_id User ID
     * @return int Number of workouts
     */
    private function get_workout_count($user_id) {
        // Implement workout counting logic
        return 0;
    }

    /**
     * Get meal plan count
     *
     * @param int $user_id User ID
     * @return int Number of meal plans
     */
    private function get_meal_plan_count($user_id) {
        // Implement meal plan counting logic
        return 0;
    }

    /**
     * Get coaching session count
     *
     * @param int $user_id User ID
     * @return int Number of coaching sessions
     */
    private function get_coaching_session_count($user_id) {
        // Implement coaching session counting logic
        return 0;
    }

    /**
     * Handle get membership AJAX request
     */
    public function handle_get_membership() {
        check_ajax_referer('athlete_dashboard_nonce', 'nonce');
        
        $user_id = get_current_user_id();
        $membership = $this->get_user_membership($user_id);

        if ($membership) {
            wp_send_json_success($membership);
        } else {
            wp_send_json_error('No active membership found');
        }
    }

    /**
     * Handle update membership AJAX request
     */
    public function handle_update_membership() {
        check_ajax_referer('athlete_dashboard_nonce', 'nonce');
        
        if (!isset($_POST['membership_data'])) {
            wp_send_json_error('No membership data provided');
        }

        $user_id = get_current_user_id();
        $membership_data = json_decode(stripslashes($_POST['membership_data']), true);

        if ($this->data_manager->update_membership($user_id, $membership_data)) {
            wp_send_json_success();
        } else {
            wp_send_json_error('Failed to update membership');
        }
    }

    /**
     * Handle process renewal AJAX request
     */
    public function handle_process_renewal() {
        check_ajax_referer('athlete_dashboard_nonce', 'nonce');
        
        if (!isset($_POST['type'])) {
            wp_send_json_error('No membership type provided');
        }

        $user_id = get_current_user_id();
        $type = sanitize_text_field($_POST['type']);

        if ($this->data_manager->process_renewal($user_id, $type)) {
            wp_send_json_success();
        } else {
            wp_send_json_error('Failed to process renewal');
        }
    }

    /**
     * Register REST API routes
     */
    public function register_rest_routes() {
        register_rest_route('athlete-dashboard/v1', '/membership', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'get_membership_api'),
                'permission_callback' => array($this, 'get_membership_permission')
            ),
            array(
                'methods' => WP_REST_Server::EDITABLE,
                'callback' => array($this, 'update_membership_api'),
                'permission_callback' => array($this, 'update_membership_permission')
            )
        ));

        register_rest_route('athlete-dashboard/v1', '/membership/renew', array(
            array(
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => array($this, 'process_renewal_api'),
                'permission_callback' => array($this, 'update_membership_permission')
            )
        ));
    }

    /**
     * REST API permission callbacks
     */
    public function get_membership_permission() {
        return is_user_logged_in();
    }

    public function update_membership_permission() {
        return is_user_logged_in();
    }

    /**
     * REST API callbacks
     */
    public function get_membership_api($request) {
        $user_id = get_current_user_id();
        $membership = $this->get_user_membership($user_id);

        if (!$membership) {
            return new WP_Error(
                'no_membership',
                'No active membership found',
                array('status' => 404)
            );
        }

        return rest_ensure_response($membership);
    }

    public function update_membership_api($request) {
        $user_id = get_current_user_id();
        $membership_data = $request->get_json_params();

        if ($this->data_manager->update_membership($user_id, $membership_data)) {
            return rest_ensure_response(array(
                'message' => 'Membership updated successfully'
            ));
        }

        return new WP_Error(
            'update_failed',
            'Failed to update membership',
            array('status' => 500)
        );
    }

    public function process_renewal_api($request) {
        $user_id = get_current_user_id();
        $type = $request->get_param('type');

        if ($this->data_manager->process_renewal($user_id, $type)) {
            return rest_ensure_response(array(
                'message' => 'Membership renewed successfully'
            ));
        }

        return new WP_Error(
            'renewal_failed',
            'Failed to process renewal',
            array('status' => 500)
        );
    }
} 