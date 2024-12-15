<?php
/**
 * Workout Progress Handler Class
 * 
 * Handles AJAX requests for workout progress tracking and logging
 */

class Athlete_Dashboard_Workout_Progress_Handler {
    /**
     * Data manager instance
     */
    private $data_manager;

    /**
     * Initialize the handler
     */
    public function __construct() {
        $this->data_manager = new Athlete_Dashboard_Workout_Data_Manager();
        
        // Register AJAX actions
        add_action('wp_ajax_save_workout_progress', array($this, 'handle_save_progress'));
        add_action('wp_ajax_log_workout', array($this, 'handle_log_workout'));
        add_action('wp_ajax_get_workout_progress', array($this, 'handle_get_progress'));
    }

    /**
     * Handle saving workout progress
     */
    public function handle_save_progress() {
        try {
            // Verify nonce
            check_ajax_referer('workout_view_nonce', 'nonce');

            // Verify user is logged in
            if (!is_user_logged_in()) {
                throw new Exception(__('You must be logged in to save progress', 'athlete-dashboard'));
            }

            // Get and validate progress data
            $progress = json_decode(stripslashes($_POST['progress']), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception(__('Invalid progress data format', 'athlete-dashboard'));
            }

            // Save progress using data manager
            $user_id = get_current_user_id();
            $saved = $this->data_manager->save_workout_progress($user_id, $progress);

            if (is_wp_error($saved)) {
                throw new Exception($saved->get_error_message());
            }

            wp_send_json_success(array(
                'message' => __('Progress saved successfully', 'athlete-dashboard'),
                'timestamp' => current_time('mysql')
            ));

        } catch (Exception $e) {
            wp_send_json_error(array(
                'message' => $e->getMessage()
            ));
        }
    }

    /**
     * Handle logging completed workout
     */
    public function handle_log_workout() {
        try {
            // Verify nonce
            check_ajax_referer('workout_view_nonce', 'nonce');

            // Verify user is logged in
            if (!is_user_logged_in()) {
                throw new Exception(__('You must be logged in to log workouts', 'athlete-dashboard'));
            }

            // Get and validate log data
            $log_data = json_decode(stripslashes($_POST['log_data']), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception(__('Invalid log data format', 'athlete-dashboard'));
            }

            // Add user ID and timestamp
            $log_data['user_id'] = get_current_user_id();
            $log_data['logged_at'] = current_time('mysql');

            // Save log using data manager
            $saved = $this->data_manager->log_workout($log_data);

            if (is_wp_error($saved)) {
                throw new Exception($saved->get_error_message());
            }

            // Clear progress data after successful logging
            $this->data_manager->clear_workout_progress(
                get_current_user_id(),
                $log_data['sections'][0]['workout_id']
            );

            wp_send_json_success(array(
                'message' => __('Workout logged successfully', 'athlete-dashboard'),
                'log_id' => $saved
            ));

        } catch (Exception $e) {
            wp_send_json_error(array(
                'message' => $e->getMessage()
            ));
        }
    }

    /**
     * Handle getting saved progress
     */
    public function handle_get_progress() {
        try {
            // Verify nonce
            check_ajax_referer('workout_view_nonce', 'nonce');

            // Verify user is logged in
            if (!is_user_logged_in()) {
                throw new Exception(__('You must be logged in to view progress', 'athlete-dashboard'));
            }

            // Get workout ID
            $workout_id = isset($_GET['workout_id']) ? intval($_GET['workout_id']) : 0;
            if (!$workout_id) {
                throw new Exception(__('Invalid workout ID', 'athlete-dashboard'));
            }

            // Get progress using data manager
            $progress = $this->data_manager->get_workout_progress(
                get_current_user_id(),
                $workout_id
            );

            if (is_wp_error($progress)) {
                throw new Exception($progress->get_error_message());
            }

            wp_send_json_success($progress);

        } catch (Exception $e) {
            wp_send_json_error(array(
                'message' => $e->getMessage()
            ));
        }
    }
} 