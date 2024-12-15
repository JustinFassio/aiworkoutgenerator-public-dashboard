<?php
/**
 * Workout Dashboard Controller Class
 * 
 * Handles workout-specific dashboard operations and coordination between components
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Workout_Dashboard_Controller {
    /**
     * The workout data manager instance
     *
     * @var Athlete_Dashboard_Workout_Data_Manager
     */
    private $workout_manager;

    /**
     * The exercise data manager instance
     *
     * @var Athlete_Dashboard_Exercise_Data_Manager
     */
    private $exercise_manager;

    /**
     * The workout progress manager instance
     *
     * @var Athlete_Dashboard_Workout_Progress_Manager
     */
    private $progress_manager;

    /**
     * The workout stats manager instance
     *
     * @var Athlete_Dashboard_Workout_Stats_Manager
     */
    private $stats_manager;

    /**
     * Initialize the controller
     */
    public function __construct() {
        $this->workout_manager = new Athlete_Dashboard_Workout_Data_Manager();
        $this->exercise_manager = new Athlete_Dashboard_Exercise_Data_Manager();
        $this->progress_manager = new Athlete_Dashboard_Workout_Progress_Manager();
        $this->stats_manager = new Athlete_Dashboard_Workout_Stats_Manager();

        // Initialize hooks
        $this->init_hooks();
    }

    /**
     * Initialize WordPress hooks
     */
    private function init_hooks() {
        add_action('wp_ajax_get_workout_dashboard_data', array($this, 'get_dashboard_data'));
        add_action('wp_ajax_save_workout_progress', array($this, 'handle_save_progress'));
        add_action('wp_ajax_get_workout_stats', array($this, 'handle_get_stats'));
        add_action('wp_ajax_get_exercise_stats', array($this, 'handle_get_exercise_stats'));
    }

    /**
     * Get all necessary dashboard data for the current user
     */
    public function get_dashboard_data() {
        // Verify nonce and user permissions
        check_ajax_referer('workout_dashboard_nonce', 'nonce');
        
        if (!is_user_logged_in()) {
            wp_send_json_error('User not logged in');
            return;
        }

        $user_id = get_current_user_id();
        
        try {
            $data = array(
                'recent_workouts' => $this->get_recent_workouts($user_id),
                'workout_stats' => $this->get_user_stats($user_id),
                'progress_summary' => $this->get_progress_summary($user_id),
                'upcoming_workouts' => $this->get_upcoming_workouts($user_id)
            );

            wp_send_json_success($data);
        } catch (Exception $e) {
            wp_send_json_error($e->getMessage());
        }
    }

    /**
     * Get recent workouts for a user
     *
     * @param int $user_id User ID
     * @return array Recent workouts data
     */
    private function get_recent_workouts($user_id) {
        $recent_workouts = array();
        $logs = $this->workout_manager->get_workouts(array(
            'author' => $user_id,
            'posts_per_page' => 5,
            'orderby' => 'date',
            'order' => 'DESC'
        ));

        foreach ($logs as $log) {
            $workout = $this->workout_manager->get_workout($log['id']);
            if ($workout) {
                $progress = $this->progress_manager->get_workout_progress($user_id, $log['id']);
                $recent_workouts[] = array(
                    'workout' => $workout,
                    'progress' => !is_wp_error($progress) ? $progress : null,
                    'log' => $log
                );
            }
        }

        return $recent_workouts;
    }

    /**
     * Get user's workout statistics
     *
     * @param int $user_id User ID
     * @return array User statistics
     */
    private function get_user_stats($user_id) {
        return $this->stats_manager->get_workout_stats($user_id, array(
            'start_date' => date('Y-m-d', strtotime('-30 days')),
            'end_date' => date('Y-m-d')
        ));
    }

    /**
     * Get progress summary for a user
     *
     * @param int $user_id User ID
     * @return array Progress summary data
     */
    private function get_progress_summary($user_id) {
        $history = $this->progress_manager->get_workout_progress_history($user_id, array(
            'limit' => 10
        ));

        return array(
            'recent_progress' => $history,
            'completion_rate' => $this->calculate_completion_rate($history),
            'streak' => $this->calculate_workout_streak($user_id)
        );
    }

    /**
     * Get upcoming workouts for a user
     *
     * @param int $user_id User ID
     * @return array Upcoming workouts
     */
    private function get_upcoming_workouts($user_id) {
        return $this->workout_manager->get_workouts(array(
            'author' => $user_id,
            'meta_query' => array(
                array(
                    'key' => '_scheduled_date',
                    'value' => date('Y-m-d'),
                    'compare' => '>=',
                    'type' => 'DATE'
                )
            ),
            'posts_per_page' => 5,
            'orderby' => 'meta_value',
            'meta_key' => '_scheduled_date',
            'order' => 'ASC'
        ));
    }

    /**
     * Calculate workout completion rate from history
     *
     * @param array $history Workout history
     * @return float Completion rate percentage
     */
    private function calculate_completion_rate($history) {
        if (empty($history)) {
            return 0;
        }

        $completed = 0;
        foreach ($history as $entry) {
            if (isset($entry['completed']) && $entry['completed']) {
                $completed++;
            }
        }

        return ($completed / count($history)) * 100;
    }

    /**
     * Calculate current workout streak
     *
     * @param int $user_id User ID
     * @return int Current streak count
     */
    private function calculate_workout_streak($user_id) {
        $streak = 0;
        $current_date = new DateTime();
        $logs = $this->workout_manager->get_workouts(array(
            'author' => $user_id,
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => 30 // Check last 30 days max
        ));

        if (empty($logs)) {
            return 0;
        }

        $last_workout_date = null;
        foreach ($logs as $log) {
            $workout_date = new DateTime($log['date']);
            
            if ($last_workout_date === null) {
                $last_workout_date = $workout_date;
                $streak = 1;
                continue;
            }

            $days_difference = $last_workout_date->diff($workout_date)->days;
            if ($days_difference <= 1) {
                $streak++;
                $last_workout_date = $workout_date;
            } else {
                break;
            }
        }

        return $streak;
    }

    /**
     * Handle saving workout progress via AJAX
     */
    public function handle_save_progress() {
        check_ajax_referer('workout_progress_nonce', 'nonce');
        
        if (!is_user_logged_in()) {
            wp_send_json_error('User not logged in');
            return;
        }

        $user_id = get_current_user_id();
        $progress_data = isset($_POST['progress']) ? json_decode(stripslashes($_POST['progress']), true) : null;

        if (!$progress_data) {
            wp_send_json_error('Invalid progress data');
            return;
        }

        $result = $this->progress_manager->save_workout_progress($user_id, $progress_data);
        
        if (is_wp_error($result)) {
            wp_send_json_error($result->get_error_message());
        } else {
            wp_send_json_success($result);
        }
    }

    /**
     * Handle getting workout stats via AJAX
     */
    public function handle_get_stats() {
        check_ajax_referer('workout_stats_nonce', 'nonce');
        
        if (!is_user_logged_in()) {
            wp_send_json_error('User not logged in');
            return;
        }

        $user_id = get_current_user_id();
        $args = isset($_GET['args']) ? $_GET['args'] : array();

        $stats = $this->stats_manager->get_workout_stats($user_id, $args);
        wp_send_json_success($stats);
    }

    /**
     * Handle getting exercise stats via AJAX
     */
    public function handle_get_exercise_stats() {
        check_ajax_referer('exercise_stats_nonce', 'nonce');
        
        if (!is_user_logged_in()) {
            wp_send_json_error('User not logged in');
            return;
        }

        $user_id = get_current_user_id();
        $exercise_id = isset($_GET['exercise_id']) ? absint($_GET['exercise_id']) : 0;

        if (!$exercise_id) {
            wp_send_json_error('Invalid exercise ID');
            return;
        }

        $stats = $this->stats_manager->get_exercise_stats($user_id, $exercise_id);
        wp_send_json_success($stats);
    }
} 