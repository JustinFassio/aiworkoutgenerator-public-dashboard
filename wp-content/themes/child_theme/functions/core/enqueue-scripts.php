<?php
// functions/core/enqueue-scripts.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Enqueue scripts and styles for the athlete dashboard
 */
function athlete_dashboard_enqueue_scripts() {
    // Core dependencies
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-tabs');
    
    // Base styles
    wp_enqueue_style(
        'athlete-dashboard-variables',
        get_stylesheet_directory_uri() . '/assets/css/variables.css',
        array(),
        ATHLETE_DASHBOARD_VERSION
    );

    wp_enqueue_style(
        'athlete-dashboard-base',
        get_stylesheet_directory_uri() . '/assets/css/style.css',
        array('athlete-dashboard-variables'),
        ATHLETE_DASHBOARD_VERSION
    );

    // UI Components
    wp_enqueue_script(
        'athlete-dashboard-ui',
        get_stylesheet_directory_uri() . '/assets/js/components/athlete-ui.js',
        array('jquery', 'jquery-ui-core', 'jquery-ui-tabs'),
        ATHLETE_DASHBOARD_VERSION,
        true
    );

    wp_enqueue_style(
        'athlete-dashboard-ui',
        get_stylesheet_directory_uri() . '/assets/css/components/ui.css',
        array('athlete-dashboard-base'),
        ATHLETE_DASHBOARD_VERSION
    );

    // Squat Progress Component
    wp_enqueue_script(
        'athlete-dashboard-squat-progress',
        get_stylesheet_directory_uri() . '/includes/components/exercise-progress/squat/js/squat-progress.js',
        array('jquery', 'athlete-dashboard-ui'),
        ATHLETE_DASHBOARD_VERSION,
        true
    );

    wp_enqueue_style(
        'athlete-dashboard-squat-progress',
        get_stylesheet_directory_uri() . '/includes/components/exercise-progress/squat/css/squat-progress.css',
        array('athlete-dashboard-ui'),
        ATHLETE_DASHBOARD_VERSION
    );

    // Main dashboard script
    wp_enqueue_script(
        'athlete-dashboard-main',
        get_stylesheet_directory_uri() . '/assets/js/dashboard.js',
        array('jquery', 'athlete-dashboard-ui', 'athlete-dashboard-squat-progress'),
        ATHLETE_DASHBOARD_VERSION,
        true
    );

    // Localize script data
    $localize_data = array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('athlete_dashboard_nonce'),
        'user_id' => get_current_user_id(),
        'strings' => array(
            'loading' => __('Loading...', 'athlete-dashboard'),
            'error' => __('An error occurred', 'athlete-dashboard'),
            'success' => __('Success!', 'athlete-dashboard')
        )
    );

    // Localize for both UI and main scripts
    wp_localize_script('athlete-dashboard-ui', 'athleteDashboardData', $localize_data);
    wp_localize_script('athlete-dashboard-main', 'athleteDashboardData', $localize_data);
}
add_action('wp_enqueue_scripts', 'athlete_dashboard_enqueue_scripts');
  