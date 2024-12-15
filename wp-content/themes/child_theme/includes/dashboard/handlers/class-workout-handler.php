<?php
/**
 * Workout Handler Class
 * 
 * Handles workout-related AJAX requests and data processing
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Workout_Handler {
    /**
     * Data manager instance
     */
    private $data_manager;

    /**
     * Initialize the handler
     */
    public function __construct() {
        $this->data_manager = new Athlete_Dashboard_Workout_Data_Manager();
        
        // AJAX actions for logged-in users
        add_action('wp_ajax_get_full_workout', array($this, 'handle_get_full_workout'));
        add_action('wp_ajax_nopriv_get_full_workout', array($this, 'handle_unauthorized_request'));
        add_action('wp_ajax_refresh_workout_nonce', array($this, 'handle_refresh_nonce'));
        add_action('wp_ajax_save_workout', array($this, 'handle_save_workout'));
        add_action('wp_ajax_delete_workout', array($this, 'handle_delete_workout'));
        add_action('wp_ajax_get_workout_history', array($this, 'handle_get_workout_history'));
        add_action('wp_ajax_get_workout_stats', array($this, 'handle_get_workout_stats'));
        add_action('wp_ajax_log_workout', array($this, 'handle_log_workout'));

        // Register post type and capabilities
        add_action('init', array($this, 'register_post_type'), 0);
    }

    /**
     * Register the workout post type and its capabilities
     */
    public function register_post_type() {
        $capabilities = array(
            'edit_post'          => 'edit_workout',
            'read_post'          => 'read_workout',
            'delete_post'        => 'delete_workout',
            'edit_posts'         => 'edit_workouts',
            'edit_others_posts'  => 'edit_others_workouts',
            'publish_posts'      => 'publish_workouts',
            'read_private_posts' => 'read_private_workouts',
        );

        register_post_type('workout', array(
            'labels' => array(
                'name'               => __('Workouts', 'athlete-dashboard'),
                'singular_name'      => __('Workout', 'athlete-dashboard'),
                'add_new'           => __('Add New', 'athlete-dashboard'),
                'add_new_item'      => __('Add New Workout', 'athlete-dashboard'),
                'edit_item'         => __('Edit Workout', 'athlete-dashboard'),
                'new_item'          => __('New Workout', 'athlete-dashboard'),
                'view_item'         => __('View Workout', 'athlete-dashboard'),
                'search_items'      => __('Search Workouts', 'athlete-dashboard'),
                'not_found'         => __('No workouts found', 'athlete-dashboard'),
                'not_found_in_trash'=> __('No workouts found in trash', 'athlete-dashboard'),
            ),
            'public'              => true,
            'has_archive'         => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt'),
            'hierarchical'       => false,
            'rewrite'           => array('slug' => 'workouts'),
            'capabilities'      => $capabilities,
            'map_meta_cap'      => true,
        ));

        // Add capabilities to roles
        $this->add_workout_capabilities();
    }

    /**
     * Add workout capabilities to roles
     */
    private function add_workout_capabilities() {
        $admin = get_role('administrator');
        $subscriber = get_role('subscriber');

        $capabilities = array(
            'read_workout',
            'read_private_workouts',
            'edit_workout',
            'edit_workouts',
            'edit_private_workouts',
            'edit_published_workouts',
            'publish_workouts',
            'delete_workout',
            'delete_workouts',
        );

        // Admin capabilities
        if ($admin) {
            foreach ($capabilities as $cap) {
                $admin->add_cap($cap);
            }
            $admin->add_cap('edit_others_workouts');
            $admin->add_cap('delete_others_workouts');
        }

        // Subscriber/Athlete capabilities
        if ($subscriber) {
            $subscriber->add_cap('read_workout');
            $subscriber->add_cap('edit_workout');
            $subscriber->add_cap('edit_workouts');
            $subscriber->add_cap('publish_workouts');
            $subscriber->add_cap('delete_workout');
        }
    }

    /**
     * Handle unauthorized requests
     */
    public function handle_unauthorized_request() {
        wp_send_json_error(array(
            'message' => __('You must be logged in to perform this action', 'athlete-dashboard'),
            'code' => 'unauthorized'
        ), 403);
    }

    /**
     * Handle nonce refresh
     */
    public function handle_refresh_nonce() {
        // Verify user is logged in
        if (!is_user_logged_in()) {
            $this->handle_unauthorized_request();
            return;
        }

        // Verify current nonce
        if (!check_ajax_referer('workout_nonce', 'nonce', false)) {
            wp_send_json_error(array(
                'message' => __('Security verification failed', 'athlete-dashboard'),
                'code' => 'invalid_nonce'
            ), 403);
            return;
        }

        // Generate new nonce
        $new_nonce = wp_create_nonce('workout_nonce');
        wp_send_json_success(array('nonce' => $new_nonce));
    }

    /**
     * Handle getting full workout data
     */
    public function handle_get_full_workout() {
        try {
            // Verify nonce
            if (!check_ajax_referer('workout_nonce', 'nonce', false)) {
                throw new Exception(__('Security verification failed', 'athlete-dashboard'), 403);
            }

            // Verify user is logged in
            if (!is_user_logged_in()) {
                throw new Exception(__('You must be logged in to view workouts', 'athlete-dashboard'), 403);
            }

            // Get and validate workout ID
            $workout_id = isset($_POST['workout_id']) ? intval($_POST['workout_id']) : 0;
            if (!$workout_id) {
                throw new Exception(__('Invalid workout ID', 'athlete-dashboard'), 400);
            }

            // Get workout data
            $workout = $this->data_manager->get_workout($workout_id);
            if (!$workout) {
                throw new Exception(__('Workout not found', 'athlete-dashboard'), 404);
            }

            // Check if user can view this workout
            if (!current_user_can('read_workout', $workout_id)) {
                throw new Exception(__('You do not have permission to view this workout', 'athlete-dashboard'), 403);
            }

            // Format the response data
            $response_data = array(
                'id' => $workout_id,
                'title' => get_the_title($workout_id),
                'date' => get_the_date('F j, Y', $workout_id),
                'type' => get_post_meta($workout_id, '_workout_type', true) ?: 'standard',
                'exercises' => get_post_meta($workout_id, '_workout_exercises', true) ?: array(),
                'content' => apply_filters('the_content', get_post_field('post_content', $workout_id)),
                'notes' => get_post_meta($workout_id, '_workout_notes', true),
                'can_edit' => current_user_can('edit_post', $workout_id),
                'can_delete' => current_user_can('delete_post', $workout_id)
            );

            wp_send_json_success($response_data);

        } catch (Exception $e) {
            wp_send_json_error(array(
                'message' => $e->getMessage(),
                'code' => $e->getCode() ?: 500
            ), $e->getCode() ?: 500);
        }
    }

    /**
     * Handle saving a workout
     */
    public function handle_save_workout() {
        try {
            if (!check_ajax_referer('workout_nonce', 'nonce', false)) {
                throw new Exception(__('Security verification failed', 'athlete-dashboard'), 403);
            }

            if (!is_user_logged_in()) {
                throw new Exception(__('You must be logged in to save workouts', 'athlete-dashboard'), 403);
            }

            // Get and validate workout ID
            $workout_id = isset($_POST['workout_id']) ? intval($_POST['workout_id']) : 0;
            if (!$workout_id) {
                throw new Exception(__('Invalid workout ID', 'athlete-dashboard'), 400);
            }

            // Get current workout data to verify permissions
            $current_workout = $this->data_manager->get_workout($workout_id);
            if (!$current_workout) {
                throw new Exception(__('Workout not found', 'athlete-dashboard'), 404);
            }

            // Verify ownership
            if ($current_workout['author'] != get_current_user_id() && !current_user_can('edit_others_posts')) {
                throw new Exception(__('You do not have permission to edit this workout', 'athlete-dashboard'), 403);
            }

            // Get and validate title
            $title = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';
            if (empty($title)) {
                throw new Exception(__('Workout title is required', 'athlete-dashboard'), 400);
            }

            // Parse and validate exercises
            $exercises = array();
            if (isset($_POST['exercises'])) {
                $exercises_data = json_decode(stripslashes($_POST['exercises']), true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $exercises = $exercises_data;
                } else {
                    throw new Exception(__('Invalid exercise data format', 'athlete-dashboard'), 400);
                }
            }

            // Prepare workout data for saving
            $workout_data = array(
                'id' => $workout_id,
                'title' => $title,
                'exercises' => $exercises
            );

            // Save workout using data manager
            $result = $this->data_manager->save_workout($workout_data);
            if (is_wp_error($result)) {
                throw new Exception($result->get_error_message(), 500);
            }

            wp_send_json_success(array(
                'message' => __('Workout saved successfully', 'athlete-dashboard'),
                'workout' => $result
            ));

        } catch (Exception $e) {
            $code = $e->getCode() ?: 500;
            wp_send_json_error(array(
                'message' => $e->getMessage(),
                'code' => $code
            ), $code);
        }
    }

    /**
     * Handle deleting a workout
     */
    public function handle_delete_workout() {
        check_ajax_referer('workout_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error(__('You must be logged in to delete workouts', 'athlete-dashboard'));
        }

        $workout_id = isset($_POST['workout_id']) ? intval($_POST['workout_id']) : 0;
        if (!$workout_id) {
            wp_send_json_error(__('Invalid workout ID', 'athlete-dashboard'));
        }

        if ($this->data_manager->delete_workout($workout_id)) {
            wp_send_json_success(__('Workout deleted successfully', 'athlete-dashboard'));
        } else {
            wp_send_json_error(__('Error deleting workout', 'athlete-dashboard'));
        }
    }

    /**
     * Handle getting workout history
     */
    public function handle_get_workout_history() {
        check_ajax_referer('workout_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error(__('You must be logged in to view workout history', 'athlete-dashboard'));
        }

        $date = isset($_GET['date']) ? sanitize_text_field($_GET['date']) : current_time('Y-m-d');
        $workouts = $this->data_manager->get_workouts($date);

        wp_send_json_success($workouts);
    }

    /**
     * Handle getting workout statistics
     */
    public function handle_get_workout_stats() {
        check_ajax_referer('workout_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error(__('You must be logged in to view workout statistics', 'athlete-dashboard'));
        }

        $stats = $this->data_manager->get_workout_stats();
        wp_send_json_success($stats);
    }

    /**
     * Handle logging a workout
     */
    public function handle_log_workout() {
        check_ajax_referer('workout_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error(__('You must be logged in to log workouts', 'athlete-dashboard'));
        }

        $workout_data = array(
            'date' => isset($_POST['date']) ? sanitize_text_field($_POST['date']) : current_time('Y-m-d'),
            'title' => isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '',
            'type' => isset($_POST['type']) ? sanitize_text_field($_POST['type']) : '',
            'exercises' => isset($_POST['exercises']) ? $this->sanitize_exercises($_POST['exercises']) : array(),
            'notes' => isset($_POST['notes']) ? sanitize_textarea_field($_POST['notes']) : ''
        );

        if ($this->data_manager->log_workout($workout_data)) {
            wp_send_json_success(array(
                'message' => __('Workout logged successfully', 'athlete-dashboard'),
                'workout' => $workout_data
            ));
        } else {
            wp_send_json_error(
                $this->data_manager->has_errors() 
                    ? $this->data_manager->get_errors()[0]->get_error_message() 
                    : __('Error logging workout', 'athlete-dashboard')
            );
        }
    }

    /**
     * Sanitize exercise data
     */
    private function sanitize_exercises($exercises) {
        if (!is_array($exercises)) {
            return array();
        }

        return array_map(function($exercise) {
            if (!isset($exercise['name']) || empty($exercise['name'])) {
                return null;
            }

            return array(
                'name' => sanitize_text_field($exercise['name']),
                'sets' => isset($exercise['sets']) ? absint($exercise['sets']) : 0,
                'reps' => isset($exercise['reps']) ? absint($exercise['reps']) : 0,
                'weight' => isset($exercise['weight']) ? floatval($exercise['weight']) : 0,
                'notes' => isset($exercise['notes']) ? sanitize_textarea_field($exercise['notes']) : ''
            );
        }, $exercises);
    }
} 