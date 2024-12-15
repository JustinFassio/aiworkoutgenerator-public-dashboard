<?php
/**
 * Workout Logger Component Class
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Workout_Logger {
    /**
     * Initialize the component
     */
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_ajax_save_workout_log', array($this, 'handle_workout_log'));
        add_action('wp_ajax_get_workout_history', array($this, 'get_workout_history'));
    }

    /**
     * Enqueue component-specific scripts
     */
    public function enqueue_scripts() {
        wp_enqueue_script(
            'workout-logger',
            ATHLETE_DASHBOARD_URI . '/assets/js/components/workout-logger.js',
            array('jquery'),
            filemtime(ATHLETE_DASHBOARD_PATH . '/assets/js/components/workout-logger.js'),
            true
        );

        wp_localize_script('workout-logger', 'workoutLoggerData', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('workout_logger_nonce'),
            'strings' => array(
                'saveSuccess' => __('Workout logged successfully', 'athlete-dashboard'),
                'saveError' => __('Error logging workout', 'athlete-dashboard'),
                'confirmDelete' => __('Are you sure you want to delete this workout log?', 'athlete-dashboard')
            )
        ));
    }

    /**
     * Render the workout logger form
     */
    public function render() {
        include ATHLETE_DASHBOARD_PATH . '/templates/dashboard/sections/workout-logger.php';
    }

    /**
     * Handle workout log submission via AJAX
     */
    public function handle_workout_log() {
        check_ajax_referer('workout_logger_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error(__('You must be logged in to log workouts', 'athlete-dashboard'));
        }

        $workout_data = $this->validate_workout_data($_POST);
        if (is_wp_error($workout_data)) {
            wp_send_json_error($workout_data->get_error_message());
        }

        $post_data = array(
            'post_title' => $workout_data['title'],
            'post_content' => $workout_data['notes'],
            'post_type' => 'log_workout',
            'post_status' => 'publish',
            'post_author' => get_current_user_id()
        );

        $post_id = wp_insert_post($post_data);
        if (is_wp_error($post_id)) {
            wp_send_json_error($post_id->get_error_message());
        }

        // Save workout meta data
        update_post_meta($post_id, '_workout_date', $workout_data['date']);
        update_post_meta($post_id, '_workout_type', $workout_data['type']);
        update_post_meta($post_id, '_workout_duration', $workout_data['duration']);
        update_post_meta($post_id, '_workout_intensity', $workout_data['intensity']);
        
        if (!empty($workout_data['exercises'])) {
            update_post_meta($post_id, '_workout_exercises', $workout_data['exercises']);
        }

        wp_send_json_success(array(
            'message' => __('Workout logged successfully', 'athlete-dashboard'),
            'workout_id' => $post_id
        ));
    }

    /**
     * Get workout history via AJAX
     */
    public function get_workout_history() {
        check_ajax_referer('workout_logger_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error(__('You must be logged in to view workout history', 'athlete-dashboard'));
        }

        $args = array(
            'post_type' => 'log_workout',
            'posts_per_page' => 10,
            'author' => get_current_user_id(),
            'orderby' => 'meta_value',
            'meta_key' => '_workout_date',
            'order' => 'DESC'
        );

        $query = new WP_Query($args);
        $workouts = array();

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $workouts[] = array(
                    'id' => get_the_ID(),
                    'date' => get_post_meta(get_the_ID(), '_workout_date', true),
                    'type' => get_post_meta(get_the_ID(), '_workout_type', true),
                    'duration' => get_post_meta(get_the_ID(), '_workout_duration', true),
                    'intensity' => get_post_meta(get_the_ID(), '_workout_intensity', true),
                    'exercises' => get_post_meta(get_the_ID(), '_workout_exercises', true),
                    'notes' => get_the_content()
                );
            }
        }
        wp_reset_postdata();

        wp_send_json_success(array(
            'workouts' => $workouts
        ));
    }

    /**
     * Validate workout data
     *
     * @param array $data Raw workout data
     * @return array|WP_Error Validated data or error
     */
    private function validate_workout_data($data) {
        $required_fields = array(
            'title' => __('Workout Title', 'athlete-dashboard'),
            'date' => __('Date', 'athlete-dashboard'),
            'type' => __('Workout Type', 'athlete-dashboard'),
            'duration' => __('Duration', 'athlete-dashboard'),
            'intensity' => __('Intensity', 'athlete-dashboard')
        );

        $workout_data = array();
        foreach ($required_fields as $field => $label) {
            if (empty($data[$field])) {
                return new WP_Error(
                    'missing_field',
                    sprintf(__('%s is required', 'athlete-dashboard'), $label)
                );
            }
            $workout_data[$field] = sanitize_text_field($data[$field]);
        }

        // Validate and sanitize exercises if present
        if (!empty($data['exercises'])) {
            $workout_data['exercises'] = array();
            foreach ($data['exercises'] as $exercise) {
                if (!empty($exercise['name'])) {
                    $workout_data['exercises'][] = array(
                        'name' => sanitize_text_field($exercise['name']),
                        'sets' => absint($exercise['sets']),
                        'reps' => absint($exercise['reps']),
                        'weight' => floatval($exercise['weight']),
                        'notes' => sanitize_textarea_field($exercise['notes'])
                    );
                }
            }
        }

        $workout_data['notes'] = !empty($data['notes']) ? 
            wp_kses_post($data['notes']) : '';

        return $workout_data;
    }
} 