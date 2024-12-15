<?php
/**
 * Workout View Component
 * 
 * Handles the display and interaction of workouts
 */

class Athlete_Dashboard_Workout_View {
    private $parser;
    
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        $this->parser = new Athlete_Dashboard_Workout_Parser();
    }
    
    public function enqueue_assets() {
        // Enqueue main component script
        wp_enqueue_script(
            'workout-view',
            ATHLETE_DASHBOARD_URI . '/assets/js/components/workout-view.js',
            array('jquery'),
            ATHLETE_DASHBOARD_VERSION,
            true
        );
        
        // Enqueue sub-component scripts
        $components = array('parser', 'header', 'section', 'exercise', 'progress', 'logger');
        foreach ($components as $component) {
            wp_enqueue_script(
                "workout-{$component}",
                ATHLETE_DASHBOARD_URI . "/assets/js/components/workout-{$component}.js",
                array('workout-view'),
                ATHLETE_DASHBOARD_VERSION,
                true
            );
        }
        
        // Localize script with necessary data
        wp_localize_script('workout-view', 'workoutViewData', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('workout_view_nonce'),
            'strings' => array(
                'loading' => __('Loading workout...', 'athlete-dashboard'),
                'error' => __('Error loading workout', 'athlete-dashboard'),
                'saveProgress' => __('Save Progress', 'athlete-dashboard'),
                'logWorkout' => __('Log Workout', 'athlete-dashboard')
            )
        ));
    }
    
    public function render($workout_id) {
        // Get workout content
        $workout = get_post($workout_id);
        if (!$workout) {
            return '';
        }
        
        // Parse the content
        $parsed_content = $this->parser->parse_workout_content($workout->post_content);
        
        // Set up template data
        $data = array(
            'workout_id' => $workout_id,
            'content' => $workout->post_content,
            'parsed_content' => $parsed_content
        );
        
        // Load template
        ob_start();
        include ATHLETE_DASHBOARD_PATH . '/templates/workout-view.php';
        return ob_get_clean();
    }
} 