<?php
/**
 * Workout Detail Component Class
 *
 * Handles the display and interaction of workout details in a modern component-based approach
 */
class Athlete_Dashboard_Workout_Detail {
    /**
     * Initialize the component
     */
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        add_action('wp_ajax_get_workout_detail', array($this, 'get_workout_detail'));
        add_action('wp_ajax_nopriv_get_workout_detail', array($this, 'get_workout_detail'));
    }

    /**
     * Enqueue necessary assets
     */
    public function enqueue_assets() {
        wp_enqueue_script(
            'workout-detail',
            get_stylesheet_directory_uri() . '/assets/js/components/workout-detail.js',
            array('jquery'),
            filemtime(get_stylesheet_directory() . '/assets/js/components/workout-detail.js'),
            true
        );

        wp_localize_script('workout-detail', 'workoutDetailData', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('workout_detail_nonce'),
            'strings' => array(
                'error' => esc_html__('An error occurred while loading the workout.', 'athlete-dashboard'),
                'loading' => esc_html__('Loading workout details...', 'athlete-dashboard')
            )
        ));
    }

    /**
     * AJAX handler for getting workout details
     */
    public function get_workout_detail() {
        check_ajax_referer('workout_detail_nonce', 'nonce');

        $workout_id = isset($_POST['workout_id']) ? intval($_POST['workout_id']) : 0;
        if (!$workout_id) {
            wp_send_json_error(array('message' => __('Invalid workout ID', 'athlete-dashboard')));
        }

        // Get workout data
        $workout = get_post($workout_id);
        if (!$workout) {
            wp_send_json_error(array('message' => __('Workout not found', 'athlete-dashboard')));
        }

        // Build workout data
        $workout_data = array(
            'title' => get_the_title($workout),
            'date' => get_the_date('F j, Y', $workout),
            'type' => get_post_meta($workout_id, 'workout_type', true),
            'exercises' => $this->get_workout_exercises($workout_id)
        );

        ob_start();
        $this->render_workout_detail($workout_data);
        $html = ob_get_clean();

        wp_send_json_success(array(
            'html' => $html,
            'workout' => $workout_data
        ));
    }

    /**
     * Get exercises for a workout
     */
    private function get_workout_exercises($workout_id) {
        return get_post_meta($workout_id, 'exercises', true) ?: array();
    }

    /**
     * Render the workout detail template
     */
    public function render_workout_detail($workout_data) {
        include get_stylesheet_directory() . '/templates/dashboard/components/workout-detail.php';
    }

    /**
     * Render the initial component container
     */
    public function render() {
        echo '<div id="workout-detail-component" class="athlete-dashboard-component"></div>';
    }
} 