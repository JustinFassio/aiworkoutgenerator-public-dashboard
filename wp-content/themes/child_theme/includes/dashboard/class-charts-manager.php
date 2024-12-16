<?php
/**
 * Charts Manager Class
 * Handles chart data management functionality
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Charts_Manager {
    /**
     * Data manager instance
     *
     * @var Athlete_Dashboard_Charts_Data_Manager
     */
    private $data_manager;

    /**
     * Constructor
     */
    public function __construct() {
        $this->data_manager = new Athlete_Dashboard_Charts_Data_Manager();
        $this->init();
    }

    /**
     * Initialize charts manager
     */
    private function init() {
        // Add AJAX handlers
        add_action('wp_ajax_get_workout_stats', array($this, 'handle_get_workout_stats'));
        add_action('wp_ajax_get_progress_metrics', array($this, 'handle_get_progress_metrics'));
        add_action('wp_ajax_get_attendance_data', array($this, 'handle_get_attendance_data'));
        add_action('wp_ajax_get_goals_data', array($this, 'handle_get_goals_data'));
        
        // Add REST API endpoints
        add_action('rest_api_init', array($this, 'register_rest_routes'));
    }

    /**
     * Get workout statistics
     *
     * @param int $user_id User ID
     * @param string $period Time period
     * @return object Workout statistics
     */
    public function get_workout_statistics($user_id, $period = '30days') {
        $data = $this->data_manager->get_workout_progress_data($user_id, $period);
        
        return (object) array(
            'total_workouts' => count($data['workouts']['labels']),
            'avg_duration' => $this->calculate_average_duration($data['workouts']),
            'total_calories' => $this->calculate_total_calories($data['workouts'])
        );
    }

    /**
     * Get progress metrics
     *
     * @param int $user_id User ID
     * @param string $metric Metric type
     * @return object Progress metrics
     */
    public function get_progress_metrics($user_id, $metric = 'weight') {
        $data = $this->data_manager->get_workout_progress_data($user_id, '30days');
        $progress = $data['progress'];

        if (empty($progress['datasets'][0]['data'])) {
            return (object) array(
                'starting' => 0,
                'current' => 0,
                'change' => 0
            );
        }

        $values = $progress['datasets'][0]['data'];
        return (object) array(
            'starting' => reset($values),
            'current' => end($values),
            'change' => end($values) - reset($values)
        );
    }

    /**
     * Get attendance data
     *
     * @param int $user_id User ID
     * @param string $period Time period
     * @return object Attendance data
     */
    public function get_attendance_data($user_id, $period = '30days') {
        $data = $this->data_manager->get_attendance_data($user_id, $period);
        
        // Calculate attendance rate
        $total_days = count($data['labels']);
        $attended_days = array_sum($data['datasets'][0]['data']);
        $attendance_rate = $total_days > 0 ? round(($attended_days / $total_days) * 100, 1) : 0;

        // Find best streak
        $best_streak = $this->calculate_best_streak($data['datasets'][0]['data']);

        // Find most active day
        $most_active_day = $this->find_most_active_day($data);

        return (object) array(
            'attendance_rate' => $attendance_rate,
            'best_streak' => $best_streak,
            'most_active_day' => $most_active_day
        );
    }

    /**
     * Get goals data
     *
     * @param int $user_id User ID
     * @return object Goals data
     */
    public function get_goals_data($user_id) {
        $data = $this->data_manager->get_goals_data($user_id);
        
        $total = count($data['labels']);
        $completed = count(array_filter($data['datasets'][0]['data'], function($progress) {
            return $progress >= 100;
        }));

        return (object) array(
            'active_count' => $total - $completed,
            'completed_count' => $completed,
            'success_rate' => $total > 0 ? round(($completed / $total) * 100, 1) : 0
        );
    }

    /**
     * Handle get workout stats AJAX request
     */
    public function handle_get_workout_stats() {
        check_ajax_referer('athlete_dashboard_nonce', 'nonce');
        
        $user_id = get_current_user_id();
        $period = isset($_GET['period']) ? sanitize_text_field($_GET['period']) : '30days';

        $stats = $this->get_workout_statistics($user_id, $period);
        wp_send_json_success($stats);
    }

    /**
     * Handle get progress metrics AJAX request
     */
    public function handle_get_progress_metrics() {
        check_ajax_referer('athlete_dashboard_nonce', 'nonce');
        
        $user_id = get_current_user_id();
        $metric = isset($_GET['metric']) ? sanitize_text_field($_GET['metric']) : 'weight';

        $metrics = $this->get_progress_metrics($user_id, $metric);
        wp_send_json_success($metrics);
    }

    /**
     * Handle get attendance data AJAX request
     */
    public function handle_get_attendance_data() {
        check_ajax_referer('athlete_dashboard_nonce', 'nonce');
        
        $user_id = get_current_user_id();
        $period = isset($_GET['period']) ? sanitize_text_field($_GET['period']) : '30days';

        $data = $this->get_attendance_data($user_id, $period);
        wp_send_json_success($data);
    }

    /**
     * Handle get goals data AJAX request
     */
    public function handle_get_goals_data() {
        check_ajax_referer('athlete_dashboard_nonce', 'nonce');
        
        $user_id = get_current_user_id();
        $data = $this->get_goals_data($user_id);
        wp_send_json_success($data);
    }

    /**
     * Register REST API routes
     */
    public function register_rest_routes() {
        register_rest_route('athlete-dashboard/v1', '/charts/workout-stats', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'get_workout_stats_api'),
                'permission_callback' => array($this, 'get_charts_permission')
            )
        ));

        register_rest_route('athlete-dashboard/v1', '/charts/progress', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'get_progress_metrics_api'),
                'permission_callback' => array($this, 'get_charts_permission')
            )
        ));

        register_rest_route('athlete-dashboard/v1', '/charts/attendance', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'get_attendance_data_api'),
                'permission_callback' => array($this, 'get_charts_permission')
            )
        ));

        register_rest_route('athlete-dashboard/v1', '/charts/goals', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'get_goals_data_api'),
                'permission_callback' => array($this, 'get_charts_permission')
            )
        ));
    }

    /**
     * REST API permission callbacks
     */
    public function get_charts_permission() {
        return is_user_logged_in();
    }

    /**
     * REST API callbacks
     */
    public function get_workout_stats_api($request) {
        $user_id = get_current_user_id();
        $period = $request->get_param('period') ?: '30days';

        return rest_ensure_response(
            $this->get_workout_statistics($user_id, $period)
        );
    }

    public function get_progress_metrics_api($request) {
        $user_id = get_current_user_id();
        $metric = $request->get_param('metric') ?: 'weight';

        return rest_ensure_response(
            $this->get_progress_metrics($user_id, $metric)
        );
    }

    public function get_attendance_data_api($request) {
        $user_id = get_current_user_id();
        $period = $request->get_param('period') ?: '30days';

        return rest_ensure_response(
            $this->get_attendance_data($user_id, $period)
        );
    }

    public function get_goals_data_api($request) {
        $user_id = get_current_user_id();
        return rest_ensure_response(
            $this->get_goals_data($user_id)
        );
    }

    /**
     * Helper methods
     */
    private function calculate_average_duration($data) {
        if (empty($data['datasets'][0]['data'])) {
            return 0;
        }

        $total = array_sum($data['datasets'][0]['data']);
        $count = count($data['datasets'][0]['data']);
        return $count > 0 ? round($total / $count) : 0;
    }

    private function calculate_total_calories($data) {
        if (empty($data['datasets'][0]['data'])) {
            return 0;
        }

        return array_sum($data['datasets'][0]['data']);
    }

    private function calculate_best_streak($attendance_data) {
        $current_streak = 0;
        $best_streak = 0;

        foreach ($attendance_data as $attended) {
            if ($attended > 0) {
                $current_streak++;
                $best_streak = max($best_streak, $current_streak);
            } else {
                $current_streak = 0;
            }
        }

        return $best_streak;
    }

    private function find_most_active_day($data) {
        if (empty($data['labels']) || empty($data['datasets'][0]['data'])) {
            return '';
        }

        $max_value = max($data['datasets'][0]['data']);
        $max_index = array_search($max_value, $data['datasets'][0]['data']);
        
        return isset($data['labels'][$max_index]) ? 
            date_i18n('l', strtotime($data['labels'][$max_index])) : '';
    }
} 