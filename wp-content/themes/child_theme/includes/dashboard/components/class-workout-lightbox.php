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
        // Enqueue the lightbox script
        wp_enqueue_script(
            'athlete-dashboard-workout-lightbox',
            get_stylesheet_directory_uri() . '/assets/js/components/workout-lightbox.js',
            array('jquery'),
            filemtime(get_stylesheet_directory() . '/assets/js/components/workout-lightbox.js'),
            true
        );

        // Enqueue the lightbox styles
        wp_enqueue_style(
            'athlete-dashboard-workout-lightbox',
            get_stylesheet_directory_uri() . '/assets/css/components/workout-lightbox.css',
            array(),
            filemtime(get_stylesheet_directory() . '/assets/css/components/workout-lightbox.css')
        );

        // Localize script with necessary data
        wp_localize_script('athlete-dashboard-workout-lightbox', 'workoutLightboxData', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('workout_nonce'),
            'loginUrl' => wp_login_url(get_permalink()),
            'strings' => array(
                'loading' => __('Loading workout details...', 'athlete-dashboard'),
                'error' => __('Error loading workout', 'athlete-dashboard'),
                'close' => __('Close', 'athlete-dashboard'),
                'print' => __('Print Workout', 'athlete-dashboard'),
                'edit' => __('Edit', 'athlete-dashboard'),
                'save' => __('Save', 'athlete-dashboard'),
                'cancel' => __('Cancel', 'athlete-dashboard'),
                'addExercise' => __('Add Exercise', 'athlete-dashboard'),
                'deleteExercise' => __('Delete Exercise', 'athlete-dashboard'),
                'confirmDelete' => __('Are you sure you want to delete this exercise?', 'athlete-dashboard'),
                'unsavedChanges' => __('You have unsaved changes. Are you sure you want to exit?', 'athlete-dashboard')
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