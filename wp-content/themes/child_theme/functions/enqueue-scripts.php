<?php
// functions/enqueue-scripts.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!function_exists('divi_child_enqueue_styles_and_scripts')) {
    function divi_child_enqueue_styles_and_scripts() {
        // Enqueue styles
        enqueue_styles();
        
        // Enqueue scripts
        enqueue_scripts();
        
        // Localize script
        localize_script();
    }
}

function enqueue_font_awesome() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome');

function enqueue_styles() {
    // Enqueue parent (Divi) style
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    
    // Enqueue variables.css
    wp_enqueue_style(
        'variables-style',
        get_stylesheet_directory_uri() . '/assets/css/variables.css',
        array(),
        wp_get_theme()->get('Version')
    );
    
    // Enqueue child style with dependency on parent style and variables
    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style', 'variables-style'),
        wp_get_theme()->get('Version')
    );

    // Enqueue module-specific CSS files
    $css_files = array(
        'workout-detail' => array('deps' => array()),
        'workout-calendar' => array('deps' => array()),
        'progress-charts' => array('deps' => array()),
        'workout-recommendations' => array('deps' => array()),
        'utils' => array('deps' => array())
    );

    foreach ($css_files as $handle => $css) {
        $file_path = get_stylesheet_directory() . '/assets/css/components/' . $handle . '.css';
        $version = file_exists($file_path) ? filemtime($file_path) : wp_get_theme()->get('Version');
        
        wp_enqueue_style(
            $handle,
            get_stylesheet_directory_uri() . '/assets/css/components/' . $handle . '.css',
            $css['deps'],
            $version
        );
    }
    
    // Enqueue utils.css
    wp_enqueue_style(
        'utils-styles',
        get_stylesheet_directory_uri() . '/assets/css/utils.css',
        array('parent-style'),
        wp_get_theme()->get('Version')
    );
    
    // Enqueue custom CSS file
    wp_enqueue_style(
        'custom-styles', 
        get_stylesheet_directory_uri() . '/assets/css/custom-styles.css', 
        array('parent-style'), 
        wp_get_theme()->get('Version')
    );

    // Enqueue jQuery UI CSS
    wp_enqueue_style('jquery-ui-css', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
}

function enqueue_scripts() {
    // Enqueue jQuery and its dependencies first
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-tabs');
    wp_enqueue_script('jquery-effects-core');
    
    // Register athlete-ui first and make it a jQuery dependency
    $athlete_ui_path = get_stylesheet_directory() . '/assets/js/components/athlete-ui.js';
    if (file_exists($athlete_ui_path)) {
        $version = filemtime($athlete_ui_path);
        
        wp_register_script(
            'athlete-ui',
            get_stylesheet_directory_uri() . '/assets/js/components/athlete-ui.js',
            array('jquery', 'jquery-ui-core'),
            $version,
            true
        );
        
        // Ensure it's loaded in the body
        wp_enqueue_script('athlete-ui');
        
        // Add it to Divi's body scripts early
        if (function_exists('et_core_is_fb_enabled')) {
            et_builder_add_body_script('athlete-ui');
        }
    }
    
    // Enqueue Chart.js after athlete-ui
    wp_enqueue_script(
        'chartjs', 
        'https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js', 
        array('athlete-ui'), 
        '4.3.0', 
        true
    );
    
    wp_enqueue_script(
        'chartjs-adapter-date-fns',
        'https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3.0.0/dist/chartjs-adapter-date-fns.bundle.min.js',
        array('chartjs'),
        '3.0.0',
        true
    );

    // Define module dependencies including athlete-ui
    $module_dependencies = array('jquery', 'jquery-ui-core', 'jquery-ui-tabs', 'athlete-ui', 'chartjs');

    // Athlete Dashboard Module Scripts
    $modules = array(
        'athlete-workout' => array(
            'path' => 'assets/js/components/athlete-workout.js',
            'deps' => $module_dependencies
        ),
        'athlete-goals' => array(
            'path' => 'assets/js/components/athlete-goals.js',
            'deps' => $module_dependencies
        ),
        'athlete-attendance' => array(
            'path' => 'assets/js/components/athlete-attendance.js',
            'deps' => $module_dependencies
        ),
        'athlete-membership' => array(
            'path' => 'assets/js/components/athlete-membership.js',
            'deps' => $module_dependencies
        ),
        'athlete-messaging' => array(
            'path' => 'assets/js/components/athlete-messaging.js',
            'deps' => $module_dependencies
        ),
        'athlete-charts' => array(
            'path' => 'assets/js/components/athlete-charts.js',
            'deps' => array_merge($module_dependencies, array('chartjs-adapter-date-fns'))
        )
    );

    // Register and enqueue remaining modules
    foreach ($modules as $handle => $module) {
        $file_path = get_stylesheet_directory() . '/' . $module['path'];
        
        if (file_exists($file_path)) {
            $version = filemtime($file_path);
            
            wp_register_script(
                $handle,
                get_stylesheet_directory_uri() . '/' . $module['path'],
                $module['deps'],
                $version,
                true
            );
            
            wp_enqueue_script($handle);
            
            // Add to Divi's body scripts
            if (function_exists('et_core_is_fb_enabled')) {
                et_builder_add_body_script($handle);
            }
        }
    }
    
    // Enqueue custom JS file with dynamic version
    $custom_js_file = get_stylesheet_directory() . '/assets/js/custom-scripts.js';
    if (file_exists($custom_js_file)) {
        $custom_js_version = filemtime($custom_js_file);
        wp_enqueue_script(
            'custom-scripts', 
            get_stylesheet_directory_uri() . '/assets/js/custom-scripts.js', 
            array_merge(array('athlete-ui'), array_keys($modules)), 
            $custom_js_version, 
            true
        );
        
        // Add custom scripts to Divi's body scripts
        if (function_exists('et_core_is_fb_enabled')) {
            et_builder_add_body_script('custom-scripts');
        }
    }
}

// Remove the register_with_divi_builder function since we're handling it directly
remove_action('wp_enqueue_scripts', 'register_with_divi_builder', 21);

// Ensure our scripts are loaded after Divi's core scripts
remove_action('wp_enqueue_scripts', 'divi_child_enqueue_styles_and_scripts', 20);
add_action('wp_enqueue_scripts', 'divi_child_enqueue_styles_and_scripts', 15);

function localize_script() {
    wp_localize_script('custom-scripts', 'athleteDashboard', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('athlete_dashboard_nonce'),
        'exerciseTests' => function_exists('get_exercise_tests') ? get_exercise_tests() : array(),
        'current_user_id' => get_current_user_id()
    ));

    // Localize the messaging script
    wp_localize_script('messaging-scripts', 'athleteDashboardMessaging', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('athlete_dashboard_messaging_nonce'),
        'admin_nonce' => wp_create_nonce('athlete_dashboard_admin_nonce'),
        'current_user_id' => get_current_user_id(),
        'is_admin' => current_user_can('edit_users') || in_array('author', wp_get_current_user()->roles)
    ));
}

/**
 * Enqueue styles and scripts for the Athlete Dashboard.
 */
function athlete_dashboard_enqueue_styles_and_scripts() {
    // This function is now empty as its contents have been merged into the existing functions above.
    // We keep it here for backward compatibility in case it's called elsewhere in the theme.
}
add_action('wp_enqueue_scripts', 'athlete_dashboard_enqueue_styles_and_scripts', 21);

// Add the Stripe.js enqueue function
function enqueue_stripe_js() {
    wp_enqueue_script('stripe-js', 'https://js.stripe.com/v3/buy-button.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_stripe_js');

/**
 * Enqueue reCAPTCHA v3 script
 */
function enqueue_recaptcha_v3_script() {
    $recaptcha_site_key = '6Lc1Ly0qAAAAAF37K-Y8vkcCJQsiPrGADWD4T137';
    wp_enqueue_script('recaptcha-v3', "https://www.google.com/recaptcha/api.js?render=$recaptcha_site_key", array(), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_recaptcha_v3_script');
