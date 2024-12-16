<?php
/**
 * Goals Manager Class
 * Handles goal management functionality
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Goals_Manager {
    /**
     * Data manager instance
     *
     * @var Athlete_Dashboard_Goals_Data_Manager
     */
    private $data_manager;

    /**
     * Constructor
     */
    public function __construct() {
        $this->data_manager = new Athlete_Dashboard_Goals_Data_Manager();
        $this->init();
    }

    /**
     * Initialize goals manager
     */
    private function init() {
        // Add AJAX handlers
        add_action('wp_ajax_save_goal', array($this, 'handle_save_goal'));
        add_action('wp_ajax_update_goal_progress', array($this, 'handle_update_progress'));
        add_action('wp_ajax_delete_goal', array($this, 'handle_delete_goal'));
        
        // Add REST API endpoints
        add_action('rest_api_init', array($this, 'register_rest_routes'));
    }

    /**
     * Get active goals for a user
     *
     * @param int $user_id User ID
     * @return array Array of active goals
     */
    public function get_active_goals($user_id) {
        return $this->data_manager->get_user_goals($user_id);
    }

    /**
     * Get completed goals for a user
     *
     * @param int $user_id User ID
     * @return array Array of completed goals
     */
    public function get_completed_goals($user_id) {
        return array_filter($this->data_manager->get_user_goals($user_id), function($goal) {
            return $this->calculate_goal_progress($goal) >= 100;
        });
    }

    /**
     * Calculate goal progress percentage
     *
     * @param array $goal Goal data
     * @return float Progress percentage
     */
    public function calculate_goal_progress($goal) {
        $progress = floatval($goal['progress']);
        $target = floatval($goal['target']);
        
        if ($target <= 0) {
            return 0;
        }

        return min(100, ($progress / $target) * 100);
    }

    /**
     * Get goal type
     *
     * @param int $goal_id Goal ID
     * @return string Goal type
     */
    public function get_goal_type($goal_id) {
        $goal = $this->data_manager->get_goal($goal_id);
        return $goal ? $goal['type'] : '';
    }

    /**
     * Get goal progress
     *
     * @param int $goal_id Goal ID
     * @return float Current progress value
     */
    public function get_goal_progress($goal_id) {
        $goal = $this->data_manager->get_goal($goal_id);
        return $goal ? floatval($goal['progress']) : 0;
    }

    /**
     * Get goal target
     *
     * @param int $goal_id Goal ID
     * @return float Target value
     */
    public function get_goal_target($goal_id) {
        $goal = $this->data_manager->get_goal($goal_id);
        return $goal ? floatval($goal['target']) : 0;
    }

    /**
     * Get goal deadline
     *
     * @param int $goal_id Goal ID
     * @return string|null Deadline date or null
     */
    public function get_goal_deadline($goal_id) {
        $goal = $this->data_manager->get_goal($goal_id);
        return $goal ? $goal['deadline'] : null;
    }

    /**
     * Get goal completion date
     *
     * @param int $goal_id Goal ID
     * @return string|null Completion date or null
     */
    public function get_goal_completion_date($goal_id) {
        $goal = $this->data_manager->get_goal($goal_id);
        if (!$goal) {
            return null;
        }

        // If progress meets or exceeds target, return the last modified date
        if ($this->calculate_goal_progress($goal) >= 100) {
            return $goal['modified'];
        }

        return null;
    }

    /**
     * Handle goal save AJAX request
     */
    public function handle_save_goal() {
        check_ajax_referer('athlete_dashboard_nonce', 'nonce');
        
        if (!isset($_POST['goal_data'])) {
            wp_send_json_error('No goal data provided');
        }

        $goal_data = json_decode(stripslashes($_POST['goal_data']), true);
        $goal_id = $this->data_manager->save_goal_data($goal_data);

        if ($goal_id) {
            wp_send_json_success(array('id' => $goal_id));
        } else {
            wp_send_json_error('Failed to save goal');
        }
    }

    /**
     * Handle progress update AJAX request
     */
    public function handle_update_progress() {
        check_ajax_referer('athlete_dashboard_nonce', 'nonce');
        
        if (!isset($_POST['goal_id']) || !isset($_POST['progress'])) {
            wp_send_json_error('Missing required data');
        }

        $goal_id = intval($_POST['goal_id']);
        $progress = floatval($_POST['progress']);

        if ($this->data_manager->update_goal_progress($goal_id, $progress)) {
            wp_send_json_success();
        } else {
            wp_send_json_error('Failed to update progress');
        }
    }

    /**
     * Handle goal deletion AJAX request
     */
    public function handle_delete_goal() {
        check_ajax_referer('athlete_dashboard_nonce', 'nonce');
        
        if (!isset($_POST['goal_id'])) {
            wp_send_json_error('No goal ID provided');
        }

        $goal_id = intval($_POST['goal_id']);
        if ($this->data_manager->delete_goal($goal_id)) {
            wp_send_json_success();
        } else {
            wp_send_json_error('Failed to delete goal');
        }
    }

    /**
     * Register REST API routes
     */
    public function register_rest_routes() {
        register_rest_route('athlete-dashboard/v1', '/goals', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'get_goals_api'),
                'permission_callback' => array($this, 'get_goals_permission')
            ),
            array(
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => array($this, 'save_goal_api'),
                'permission_callback' => array($this, 'save_goal_permission')
            )
        ));

        register_rest_route('athlete-dashboard/v1', '/goals/(?P<id>\d+)', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'get_goal_api'),
                'permission_callback' => array($this, 'get_goals_permission')
            ),
            array(
                'methods' => WP_REST_Server::EDITABLE,
                'callback' => array($this, 'update_goal_api'),
                'permission_callback' => array($this, 'save_goal_permission')
            ),
            array(
                'methods' => WP_REST_Server::DELETABLE,
                'callback' => array($this, 'delete_goal_api'),
                'permission_callback' => array($this, 'save_goal_permission')
            )
        ));
    }

    /**
     * REST API permission callbacks
     */
    public function get_goals_permission() {
        return is_user_logged_in();
    }

    public function save_goal_permission() {
        return is_user_logged_in();
    }

    /**
     * REST API callbacks
     */
    public function get_goals_api($request) {
        $user_id = get_current_user_id();
        return rest_ensure_response($this->data_manager->get_user_goals($user_id));
    }

    public function get_goal_api($request) {
        $goal_id = $request->get_param('id');
        $goal = $this->data_manager->get_goal($goal_id);
        
        if (!$goal) {
            return new WP_Error('goal_not_found', 'Goal not found', array('status' => 404));
        }

        return rest_ensure_response($goal);
    }

    public function save_goal_api($request) {
        $goal_data = $request->get_json_params();
        $goal_id = $this->data_manager->save_goal_data($goal_data);

        if ($goal_id) {
            return rest_ensure_response(array(
                'id' => $goal_id,
                'message' => 'Goal saved successfully'
            ));
        }

        return new WP_Error('goal_save_failed', 'Failed to save goal', array('status' => 500));
    }

    public function update_goal_api($request) {
        $goal_id = $request->get_param('id');
        $goal_data = $request->get_json_params();
        $goal_data['id'] = $goal_id;

        if ($this->data_manager->save_goal_data($goal_data)) {
            return rest_ensure_response(array(
                'message' => 'Goal updated successfully'
            ));
        }

        return new WP_Error('goal_update_failed', 'Failed to update goal', array('status' => 500));
    }

    public function delete_goal_api($request) {
        $goal_id = $request->get_param('id');
        
        if ($this->data_manager->delete_goal($goal_id)) {
            return rest_ensure_response(array(
                'message' => 'Goal deleted successfully'
            ));
        }

        return new WP_Error('goal_delete_failed', 'Failed to delete goal', array('status' => 500));
    }
} 