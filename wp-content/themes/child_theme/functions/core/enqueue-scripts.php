<?php
// functions/core/enqueue-scripts.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Enqueue scripts and styles for the theme
 */
function athlete_dashboard_enqueue_scripts() {
    // Get theme directories
    $parent_theme_dir = get_template_directory_uri();
    $child_theme_dir = get_stylesheet_directory_uri();

    // Enqueue parent (Divi) style with correct path
    wp_enqueue_style('parent-style', $parent_theme_dir . '/style.css');
    
    // Enqueue child theme's main style.css
    wp_enqueue_style(
        'child-style',
        $child_theme_dir . '/style.css',
        array('parent-style')
    );

    // Core WordPress scripts
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-tabs');
    wp_enqueue_script('jquery-effects-core');
    wp_enqueue_script('jquery-ui-autocomplete');
    
    // Third-party libraries
    wp_enqueue_style('jquery-ui-css', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');
    wp_enqueue_script('stripe-js', 'https://js.stripe.com/v3/buy-button.js', array(), null, true);
    wp_enqueue_script('chart-js', 'https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js', array(), '3.7.0', true);
    wp_enqueue_script('chart-js-adapter', 'https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@2.0.0/dist/chartjs-adapter-date-fns.bundle.min.js', array('chart-js'), '2.0.0', true);

    // Theme styles with updated dependencies
    $css_files = array(
        'variables-style' => array(
            'path' => '/assets/css/variables.css',
            'deps' => array('parent-style', 'child-style')
        ),
        'custom-styles' => array(
            'path' => '/assets/css/custom-styles.css',
            'deps' => array('parent-style', 'child-style')
        ),
        'athlete-dashboard' => array(
            'path' => '/assets/css/dashboard.css',
            'deps' => array('parent-style', 'child-style')
        )
    );

    // Enqueue each CSS file
    foreach ($css_files as $handle => $file) {
        $file_path = ATHLETE_DASHBOARD_PATH . $file['path'];
        $file_uri = ATHLETE_DASHBOARD_URI . $file['path'];
        
        if (file_exists($file_path)) {
            wp_enqueue_style(
                $handle,
                $file_uri,
                $file['deps'],
                filemtime($file_path)
            );
        }
    }

    // Component scripts
    $component_scripts = array(
        'athlete-dashboard-account' => array(
            'path' => '/assets/js/components/account-details.js',
            'deps' => array('jquery')
        ),
        'athlete-dashboard-progress' => array(
            'path' => '/assets/js/components/progress-tracker.js',
            'deps' => array('jquery', 'chart-js', 'chart-js-adapter')
        ),
        'athlete-dashboard-workout-logger' => array(
            'path' => '/assets/js/components/workout-logger.js',
            'deps' => array('jquery')
        ),
        'athlete-dashboard-workout-lightbox' => array(
            'path' => '/assets/js/components/workout-lightbox.js',
            'deps' => array('jquery')
        ),
        'athlete-dashboard-nutrition-logger' => array(
            'path' => '/assets/js/components/nutrition-logger.js',
            'deps' => array('jquery')
        ),
        'athlete-dashboard-nutrition-tracker' => array(
            'path' => '/assets/js/components/nutrition-tracker.js',
            'deps' => array('jquery', 'chart-js')
        ),
        'athlete-dashboard-food-manager' => array(
            'path' => '/assets/js/components/food-manager.js',
            'deps' => array('jquery', 'jquery-ui-autocomplete')
        )
    );

    // Enqueue component scripts
    foreach ($component_scripts as $handle => $script) {
        $file_path = ATHLETE_DASHBOARD_PATH . $script['path'];
        $file_uri = ATHLETE_DASHBOARD_URI . $script['path'];
        
        if (file_exists($file_path)) {
            wp_enqueue_script(
                $handle,
                $file_uri,
                $script['deps'],
                filemtime($file_path),
                true
            );
        }
    }

    // Main dashboard script (load last)
    wp_enqueue_script(
        'athlete-dashboard-main',
        ATHLETE_DASHBOARD_URI . '/assets/js/dashboard.js',
        array_merge(
            array('jquery'),
            array_keys($component_scripts)
        ),
        filemtime(ATHLETE_DASHBOARD_PATH . '/assets/js/dashboard.js'),
        true
    );

    // Localize script data
    wp_localize_script('athlete-dashboard-main', 'athleteDashboardData', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('athlete_dashboard_nonce'),
        'user_id' => get_current_user_id(),
        'strings' => array(
            'loading' => __('Loading...', 'athlete-dashboard'),
            'error' => __('An error occurred', 'athlete-dashboard'),
            'success' => __('Success', 'athlete-dashboard'),
            'confirm' => __('Are you sure?', 'athlete-dashboard'),
            'save' => __('Save', 'athlete-dashboard'),
            'cancel' => __('Cancel', 'athlete-dashboard'),
            'delete' => __('Delete', 'athlete-dashboard'),
            'edit' => __('Edit', 'athlete-dashboard')
        )
    ));
}

// Remove old enqueue functions
remove_action('wp_enqueue_scripts', 'divi_child_enqueue_styles_and_scripts', 20);
remove_action('wp_enqueue_scripts', 'enqueue_stripe_js');
remove_action('wp_enqueue_scripts', 'enqueue_font_awesome');

// Add consolidated enqueue function
add_action('wp_enqueue_scripts', 'athlete_dashboard_enqueue_scripts', 20);
  