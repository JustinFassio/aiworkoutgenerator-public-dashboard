<?php
/**
 * Workout Lightbox Component Class
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Workout_Lightbox {
    /**
     * Initialize the component
     */
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    /**
     * Enqueue component-specific scripts
     */
    public function enqueue_scripts() {
        wp_enqueue_script(
            'workout-lightbox',
            ATHLETE_DASHBOARD_URI . '/assets/js/components/workout-lightbox.js',
            array('jquery'),
            ATHLETE_DASHBOARD_VERSION,
            true
        );

        wp_localize_script('workout-lightbox', 'workoutLightboxData', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('workout_nonce'),
            'loginUrl' => wp_login_url(),
            'strings' => array(
                'loading' => __('Loading workout...', 'athlete-dashboard'),
                'error' => __('Error loading workout', 'athlete-dashboard'),
                'close' => __('Close', 'athlete-dashboard')
            )
        ));
    }

    /**
     * Render the workout lightbox
     */
    public function render() {
        $template_path = get_stylesheet_directory() . '/templates/dashboard/components/workout-lightbox.php';
        if (!file_exists($template_path)) {
            error_log('Workout lightbox template not found: ' . $template_path);
            return;
        }
        include $template_path;
    }
} 