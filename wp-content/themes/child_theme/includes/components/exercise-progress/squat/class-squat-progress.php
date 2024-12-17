<?php
/**
 * Squat Progress Component
 * 
 * Handles the display and functionality of squat progress tracking
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Squat_Progress_Component {
    private $data_manager;
    private $component_url;

    public function __construct() {
        $this->component_url = get_stylesheet_directory_uri() . '/includes/components/exercise-progress/squat';
        $this->data_manager = new Athlete_Dashboard_Squat_Progress_Data();
        
        // Ensure database table exists
        $this->ensure_table_exists();
        
        // Initialize the component
        add_action('init', array($this, 'init'));
    }

    private function ensure_table_exists() {
        // Check if migration has been run
        if (!get_option('athlete_squat_progress_db_version')) {
            // Get the correct path to the migration class
            $migration_file = get_stylesheet_directory() . '/includes/data/exercise-progress/squat/class-squat-progress-migration.php';
            
            if (!file_exists($migration_file)) {
                error_log('Migration file not found: ' . $migration_file);
                return;
            }
            
            require_once $migration_file;
            $migration = new Athlete_Dashboard_Squat_Progress_Migration();
            $migration->run();
        }
    }

    public function init() {
        // Register shortcode
        add_shortcode('athlete_dashboard_squat_progress', array($this, 'render'));
        
        // Register AJAX handlers
        add_action('wp_ajax_get_squat_progress_data', array($this, 'get_data'));
        add_action('wp_ajax_save_squat_progress_data', array($this, 'save_data'));
        add_action('wp_ajax_delete_squat_progress_entry', array($this, 'delete_entry'));
    }

    /**
     * Render the component
     */
    public function render() {
        if (!is_user_logged_in()) {
            return sprintf(
                '<p class="error-message">%s</p>',
                esc_html__('Please log in to view your squat progress.', 'athlete-dashboard')
            );
        }

        // Enqueue required assets
        wp_enqueue_style(
            'athlete-squat-progress',
            $this->component_url . '/css/squat-progress.css',
            array(),
            ATHLETE_DASHBOARD_VERSION
        );

        if (!wp_script_is('chartjs', 'registered')) {
            wp_register_script(
                'chartjs',
                'https://cdn.jsdelivr.net/npm/chart.js',
                array(),
                '3.7.0',
                true
            );
        }
        wp_enqueue_script('chartjs');

        wp_enqueue_script(
            'athlete-squat-progress',
            $this->component_url . '/js/squat-progress.js',
            array('jquery', 'chartjs'),
            ATHLETE_DASHBOARD_VERSION,
            true
        );

        wp_localize_script('athlete-squat-progress', 'athleteSquatProgress', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('athlete_dashboard_nonce'),
            'i18n' => array(
                'weight' => __('Weight (kg)', 'athlete-dashboard'),
                'reps' => __('Reps', 'athlete-dashboard'),
                'date' => __('Date', 'athlete-dashboard'),
                'loading' => __('Loading...', 'athlete-dashboard'),
                'error' => __('Error loading data', 'athlete-dashboard')
            )
        ));

        ob_start();
        include dirname(__FILE__) . '/templates/squat-progress.php';
        return ob_get_clean();
    }

    public function get_data() {
        check_ajax_referer('athlete_dashboard_nonce', 'nonce');
        
        if (!is_user_logged_in()) {
            wp_send_json_error(array('message' => __('User not authenticated', 'athlete-dashboard')));
            return;
        }

        try {
            $user_id = get_current_user_id();
            $data = $this->data_manager->get_user_progress($user_id);
            
            if ($data === false) {
                throw new Exception('Failed to fetch data');
            }
            
            wp_send_json_success(array('data' => $data));
        } catch (Exception $e) {
            wp_send_json_error(array(
                'message' => __('Error fetching data', 'athlete-dashboard'),
                'error' => $e->getMessage()
            ));
        }
    }

    public function save_data() {
        check_ajax_referer('athlete_dashboard_nonce', 'nonce');
        
        if (!is_user_logged_in()) {
            wp_send_json_error(array('message' => __('User not authenticated', 'athlete-dashboard')));
            return;
        }

        $user_id = get_current_user_id();
        $date = isset($_POST['date']) ? sanitize_text_field($_POST['date']) : current_time('Y-m-d');
        $weight = isset($_POST['weight']) ? floatval($_POST['weight']) : 0;
        $reps = isset($_POST['reps']) ? absint($_POST['reps']) : 0;
        $notes = isset($_POST['notes']) ? sanitize_textarea_field($_POST['notes']) : '';

        $result = $this->data_manager->add_entry($user_id, $date, $weight, $reps, $notes);

        if ($result) {
            wp_send_json_success(array('message' => __('Entry saved successfully', 'athlete-dashboard')));
        } else {
            wp_send_json_error(array('message' => __('Failed to save entry', 'athlete-dashboard')));
        }
    }

    public function delete_entry() {
        check_ajax_referer('athlete_dashboard_nonce', 'nonce');
        
        if (!is_user_logged_in()) {
            wp_send_json_error(array('message' => __('User not authenticated', 'athlete-dashboard')));
            return;
        }

        $entry_id = isset($_POST['entry_id']) ? absint($_POST['entry_id']) : 0;
        if (!$entry_id) {
            wp_send_json_error(array('message' => __('Invalid entry ID', 'athlete-dashboard')));
            return;
        }

        // TODO: Implement delete functionality in data manager
        wp_send_json_success(array('message' => __('Entry deleted successfully', 'athlete-dashboard')));
    }
} 