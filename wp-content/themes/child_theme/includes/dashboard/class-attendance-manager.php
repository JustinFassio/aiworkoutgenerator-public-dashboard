<?php
/**
 * Attendance Manager Class
 * Handles attendance management functionality
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Attendance_Manager {
    /**
     * Data manager instance
     *
     * @var Athlete_Dashboard_Attendance_Data_Manager
     */
    private $data_manager;

    /**
     * Constructor
     */
    public function __construct() {
        $this->data_manager = new Athlete_Dashboard_Attendance_Data_Manager();
        $this->init();
    }

    /**
     * Initialize attendance manager
     */
    private function init() {
        // Add AJAX handlers
        add_action('wp_ajax_record_attendance', array($this, 'handle_record_attendance'));
        add_action('wp_ajax_get_attendance', array($this, 'handle_get_attendance'));
        add_action('wp_ajax_get_attendance_stats', array($this, 'handle_get_attendance_stats'));
        
        // Add REST API endpoints
        add_action('rest_api_init', array($this, 'register_rest_routes'));
    }

    /**
     * Get monthly attendance
     *
     * @param int $user_id User ID
     * @param string $month Month in Y-m format
     * @return array Array of attendance records
     */
    public function get_monthly_attendance($user_id, $month) {
        $start_date = date('Y-m-01', strtotime($month));
        $end_date = date('Y-m-t', strtotime($month));
        return $this->data_manager->get_attendance_records($user_id, $start_date, $end_date);
    }

    /**
     * Get current streak
     *
     * @param int $user_id User ID
     * @return int Current streak count
     */
    public function get_current_streak($user_id) {
        $stats = $this->data_manager->calculate_attendance_stats($user_id);
        return $stats['current_streak'];
    }

    /**
     * Get recent activity
     *
     * @param int $user_id User ID
     * @param int $limit Number of records to return
     * @return array Array of recent activity
     */
    public function get_recent_activity($user_id, $limit = 5) {
        $records = $this->data_manager->get_attendance_records($user_id);
        $records = array_slice($records, 0, $limit);

        return array_map(function($record) {
            return (object) array(
                'date' => $record['date'],
                'workout_type' => get_post_meta($record['id'], 'workout_type', true),
                'duration' => get_post_meta($record['id'], 'duration', true)
            );
        }, $records);
    }

    /**
     * Get attendance insights
     *
     * @param int $user_id User ID
     * @return array Array of insights
     */
    public function get_attendance_insights($user_id) {
        $stats = $this->data_manager->calculate_attendance_stats($user_id);
        $insights = array();

        // Streak insight
        if ($stats['current_streak'] > 0) {
            $insights[] = (object) array(
                'icon' => 'fas fa-fire',
                'title' => __('Current Streak', 'athlete-dashboard'),
                'description' => sprintf(
                    __('You\'re on a %d day streak! Keep it up!', 'athlete-dashboard'),
                    $stats['current_streak']
                )
            );
        }

        // Monthly comparison
        if ($stats['this_month'] > $stats['last_month']) {
            $increase = $stats['this_month'] - $stats['last_month'];
            $insights[] = (object) array(
                'icon' => 'fas fa-chart-line',
                'title' => __('Monthly Improvement', 'athlete-dashboard'),
                'description' => sprintf(
                    __('You\'ve attended %d more sessions than last month!', 'athlete-dashboard'),
                    $increase
                )
            );
        }

        // Best streak
        if ($stats['longest_streak'] > $stats['current_streak']) {
            $insights[] = (object) array(
                'icon' => 'fas fa-trophy',
                'title' => __('Best Streak', 'athlete-dashboard'),
                'description' => sprintf(
                    __('Your best streak was %d days. Can you beat it?', 'athlete-dashboard'),
                    $stats['longest_streak']
                )
            );
        }

        return $insights;
    }

    /**
     * Handle record attendance AJAX request
     */
    public function handle_record_attendance() {
        check_ajax_referer('athlete_dashboard_nonce', 'nonce');
        
        if (!isset($_POST['attendance_data'])) {
            wp_send_json_error('No attendance data provided');
        }

        $attendance_data = json_decode(stripslashes($_POST['attendance_data']), true);
        $record_id = $this->data_manager->save_attendance_record($attendance_data);

        if ($record_id) {
            wp_send_json_success(array('id' => $record_id));
        } else {
            wp_send_json_error('Failed to record attendance');
        }
    }

    /**
     * Handle get attendance AJAX request
     */
    public function handle_get_attendance() {
        check_ajax_referer('athlete_dashboard_nonce', 'nonce');
        
        $user_id = get_current_user_id();
        $start_date = isset($_GET['start_date']) ? sanitize_text_field($_GET['start_date']) : '';
        $end_date = isset($_GET['end_date']) ? sanitize_text_field($_GET['end_date']) : '';

        $records = $this->data_manager->get_attendance_records($user_id, $start_date, $end_date);
        wp_send_json_success($records);
    }

    /**
     * Handle get attendance stats AJAX request
     */
    public function handle_get_attendance_stats() {
        check_ajax_referer('athlete_dashboard_nonce', 'nonce');
        
        $user_id = get_current_user_id();
        $stats = $this->data_manager->calculate_attendance_stats($user_id);
        wp_send_json_success($stats);
    }

    /**
     * Register REST API routes
     */
    public function register_rest_routes() {
        register_rest_route('athlete-dashboard/v1', '/attendance', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'get_attendance_api'),
                'permission_callback' => array($this, 'get_attendance_permission')
            ),
            array(
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => array($this, 'record_attendance_api'),
                'permission_callback' => array($this, 'record_attendance_permission')
            )
        ));

        register_rest_route('athlete-dashboard/v1', '/attendance/stats', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'get_attendance_stats_api'),
                'permission_callback' => array($this, 'get_attendance_permission')
            )
        ));
    }

    /**
     * REST API permission callbacks
     */
    public function get_attendance_permission() {
        return is_user_logged_in();
    }

    public function record_attendance_permission() {
        return is_user_logged_in();
    }

    /**
     * REST API callbacks
     */
    public function get_attendance_api($request) {
        $user_id = get_current_user_id();
        $start_date = $request->get_param('start_date');
        $end_date = $request->get_param('end_date');

        return rest_ensure_response(
            $this->data_manager->get_attendance_records($user_id, $start_date, $end_date)
        );
    }

    public function record_attendance_api($request) {
        $attendance_data = $request->get_json_params();
        $record_id = $this->data_manager->save_attendance_record($attendance_data);

        if ($record_id) {
            return rest_ensure_response(array(
                'id' => $record_id,
                'message' => 'Attendance recorded successfully'
            ));
        }

        return new WP_Error(
            'attendance_record_failed',
            'Failed to record attendance',
            array('status' => 500)
        );
    }

    public function get_attendance_stats_api($request) {
        $user_id = get_current_user_id();
        return rest_ensure_response(
            $this->data_manager->calculate_attendance_stats($user_id)
        );
    }
} 