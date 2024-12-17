<?php
/**
 * Workout Feature Initialization
 */

if (!defined('ABSPATH')) {
    exit;
}

// Load feature components
require_once __DIR__ . '/components/Workout.php';
require_once __DIR__ . '/components/WorkoutGenerator.php';

// Initialize the feature
function init_workout_feature() {
    // Register styles and scripts
    add_action('wp_enqueue_scripts', function() {
        if (is_page_template('features/dashboard/templates/dashboard.php')) {
            // Workout viewer assets
            wp_enqueue_style(
                'workout-viewer',
                get_stylesheet_directory_uri() . '/features/workout/assets/css/workout-viewer.css',
                array(),
                '1.0.0'
            );

            wp_enqueue_script(
                'workout-viewer',
                get_stylesheet_directory_uri() . '/features/workout/assets/js/workout-viewer.js',
                array('jquery'),
                '1.0.0',
                true
            );

            // Workout generator assets
            wp_enqueue_style(
                'workout-generator',
                get_stylesheet_directory_uri() . '/features/workout/assets/css/workout-generator.css',
                array(),
                '1.0.0'
            );

            wp_enqueue_script(
                'workout-generator',
                get_stylesheet_directory_uri() . '/features/workout/assets/js/workout-generator.js',
                array('jquery'),
                '1.0.0',
                true
            );

            wp_localize_script('workout-generator', 'workoutGenerator', array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('workout_generator_nonce')
            ));
        }
    });
}
add_action('init', 'init_workout_feature'); 