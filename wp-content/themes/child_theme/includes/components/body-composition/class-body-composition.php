<?php
/**
 * Body Composition Component
 * 
 * Handles the display and functionality of body composition tracking
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Body_Composition_Component {
    /**
     * @var Athlete_Dashboard_Body_Composition_Data
     */
    private $data_manager;

    /**
     * @var string
     */
    private $component_url;

    /**
     * Constructor
     */
    public function __construct() {
        $this->component_url = get_stylesheet_directory_uri() . '/includes/components/body-composition';
        $this->data_manager = new Athlete_Dashboard_Body_Composition_Data();
        $this->init();
    }

    /**
     * Initialize the component
     */
    public function init() {
        // Register scripts and styles
        add_action('wp_enqueue_scripts', array($this, 'register_assets'));
        
        // Register AJAX handlers
        add_action('wp_ajax_get_body_composition_data', array($this, 'get_data'));
        add_action('wp_ajax_save_body_composition_data', array($this, 'save_data'));
        add_action('wp_ajax_delete_body_composition_entry', array($this, 'delete_entry'));
        
        // Register shortcode
        add_shortcode('athlete_dashboard_body_composition', array($this, 'render_shortcode'));
    }

    /**
     * Register and enqueue assets
     */
    public function register_assets() {
        // Register styles
        wp_register_style(
            'athlete-body-composition',
            $this->component_url . '/css/body-composition.css',
            array(),
            ATHLETE_DASHBOARD_VERSION
        );

        // Register Chart.js if not already registered
        if (!wp_script_is('chartjs', 'registered')) {
            wp_register_script(
                'chartjs',
                'https://cdn.jsdelivr.net/npm/chart.js',
                array(),
                '3.7.0',
                true
            );
        }

        // Register component script
        wp_register_script(
            'athlete-body-composition',
            $this->component_url . '/js/body-composition.js',
            array('jquery', 'chartjs'),
            ATHLETE_DASHBOARD_VERSION,
            true
        );

        // Localize script
        wp_localize_script('athlete-body-composition', 'athleteDashboardData', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('athlete_dashboard_nonce'),
            'i18n' => array(
                'weight' => __('Weight', 'athlete-dashboard'),
                'body_fat' => __('Body Fat %', 'athlete-dashboard'),
                'muscle_mass' => __('Muscle Mass', 'athlete-dashboard'),
                'waist' => __('Waist', 'athlete-dashboard')
            )
        ));
    }

    /**
     * Enqueue required assets
     */
    private function enqueue_assets() {
        wp_enqueue_style('athlete-body-composition');
        wp_enqueue_script('chartjs');
        wp_enqueue_script('athlete-body-composition');
    }

    /**
     * Render the component via shortcode
     *
     * @return string
     */
    public function render_shortcode() {
        if (!is_user_logged_in()) {
            return sprintf(
                '<p class="error-message">%s</p>',
                esc_html__('Please log in to view your body composition data.', 'athlete-dashboard')
            );
        }

        // Enqueue required assets
        $this->enqueue_assets();

        ob_start();
        try {
            include dirname(__FILE__) . '/templates/body-composition.php';
        } catch (Exception $e) {
            if (WP_DEBUG) {
                error_log('Body Composition Component Error: ' . $e->getMessage());
            }
            return sprintf(
                '<p class="error-message">%s</p>',
                esc_html__('Error loading body composition component.', 'athlete-dashboard')
            );
        }
        return ob_get_clean();
    }

    /**
     * Handle AJAX request for body composition data
     */
    public function get_data() {
        try {
            check_ajax_referer('athlete_dashboard_nonce', 'nonce');
            
            if (!is_user_logged_in()) {
                throw new Exception(__('User not authenticated', 'athlete-dashboard'));
            }

            $user_id = get_current_user_id();
            $metric = isset($_GET['metric']) ? sanitize_text_field($_GET['metric']) : 'weight';
            $period = isset($_GET['period']) ? sanitize_text_field($_GET['period']) : '30days';

            // Calculate date range
            $end_date = current_time('Y-m-d');
            switch ($period) {
                case '7days':
                    $start_date = date('Y-m-d', strtotime('-7 days'));
                    break;
                case '90days':
                    $start_date = date('Y-m-d', strtotime('-90 days'));
                    break;
                case '12months':
                    $start_date = date('Y-m-d', strtotime('-12 months'));
                    break;
                default: // 30days
                    $start_date = date('Y-m-d', strtotime('-30 days'));
            }

            $data = $this->data_manager->get_user_data($user_id, array(
                'metric' => $metric,
                'start_date' => $start_date,
                'end_date' => $end_date
            ));

            $stats = $this->data_manager->get_summary_stats($user_id, $metric);

            wp_send_json_success(array(
                'data' => $data,
                'stats' => $stats
            ));

        } catch (Exception $e) {
            wp_send_json_error(array(
                'message' => $e->getMessage()
            ));
        }
    }

    /**
     * Handle AJAX request to save body composition data
     */
    public function save_data() {
        try {
            check_ajax_referer('athlete_dashboard_nonce', 'nonce');
            
            if (!is_user_logged_in()) {
                throw new Exception(__('User not authenticated', 'athlete-dashboard'));
            }

            $data = array(
                'user_id' => get_current_user_id(),
                'date' => isset($_POST['date']) ? sanitize_text_field($_POST['date']) : current_time('Y-m-d'),
                'weight' => isset($_POST['weight']) ? floatval($_POST['weight']) : null,
                'body_fat' => isset($_POST['body_fat']) ? floatval($_POST['body_fat']) : null,
                'muscle_mass' => isset($_POST['muscle_mass']) ? floatval($_POST['muscle_mass']) : null,
                'waist' => isset($_POST['waist']) ? floatval($_POST['waist']) : null,
                'notes' => isset($_POST['notes']) ? sanitize_textarea_field($_POST['notes']) : ''
            );

            $result = $this->data_manager->save_data($data);

            if (!$result) {
                throw new Exception(__('Failed to save data', 'athlete-dashboard'));
            }

            wp_send_json_success(array(
                'message' => __('Data saved successfully', 'athlete-dashboard'),
                'entry_id' => $result
            ));

        } catch (Exception $e) {
            wp_send_json_error(array(
                'message' => $e->getMessage()
            ));
        }
    }

    /**
     * Handle AJAX request to delete an entry
     */
    public function delete_entry() {
        try {
            check_ajax_referer('athlete_dashboard_nonce', 'nonce');
            
            if (!is_user_logged_in()) {
                throw new Exception(__('User not authenticated', 'athlete-dashboard'));
            }

            $entry_id = isset($_POST['entry_id']) ? absint($_POST['entry_id']) : 0;
            if (!$entry_id) {
                throw new Exception(__('Invalid entry ID', 'athlete-dashboard'));
            }

            $result = $this->data_manager->delete_entry($entry_id, get_current_user_id());

            if (!$result) {
                throw new Exception(__('Failed to delete entry', 'athlete-dashboard'));
            }

            wp_send_json_success(array(
                'message' => __('Entry deleted successfully', 'athlete-dashboard')
            ));

        } catch (Exception $e) {
            wp_send_json_error(array(
                'message' => $e->getMessage()
            ));
        }
    }
} 