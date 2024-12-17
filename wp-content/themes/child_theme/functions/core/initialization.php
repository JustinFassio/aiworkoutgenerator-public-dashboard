<?php
/**
 * Theme Initialization
 * 
 * Handles core initialization of the Athlete Dashboard theme.
 * Includes data manager initialization, store setup, and component initialization.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Initialize the athlete dashboard functionality
 */
function athlete_dashboard_init() {
    try {
        // Initialize data managers first
        $data_managers = array(
            'Athlete_Dashboard_Data_Manager',
            'Athlete_Dashboard_Workout_Data_Manager',
            'Athlete_Dashboard_Exercise_Data_Manager',
            'Athlete_Dashboard_Workout_Progress_Manager',
            'Athlete_Dashboard_Workout_Stats_Manager',
            'Athlete_Dashboard_Goals_Data_Manager',
            'Athlete_Dashboard_Attendance_Data_Manager',
            'Athlete_Dashboard_Membership_Data_Manager',
            'Athlete_Dashboard_Messaging_Data_Manager',
            'Athlete_Dashboard_Charts_Data_Manager',
            'Athlete_Dashboard_Squat_Progress_Data'
        );

        // Initialize progress components
        $progress_components = array(
            'Athlete_Dashboard_Squat_Progress'
        );

        foreach ($progress_components as $component) {
            if (class_exists($component)) {
                new $component();
            }
        }

        foreach ($data_managers as $manager) {
            if (!class_exists($manager)) {
                error_log("Required data manager class not found: {$manager}");
                return;
            }
        }

        // Initialize store classes
        $store_classes = array(
            'Athlete_Dashboard_Settings_Store',
            'Athlete_Dashboard_User_Preferences_Store'
        );

        foreach ($store_classes as $store) {
            if (!class_exists($store)) {
                error_log("Required store class not found: {$store}");
                return;
            }
            new $store();
        }
        
        // Initialize core components
        if (!class_exists('Athlete_Dashboard_Core_Components')) {
            error_log('Core Components class not found');
            return;
        }
        $core = new Athlete_Dashboard_Core_Components();
        
        // Initialize manager classes with dependency checks
        $manager_classes = array(
            'Athlete_Dashboard_UI_Manager',
            'Athlete_Dashboard_Workout_Manager',
            'Athlete_Dashboard_Goals_Manager',
            'Athlete_Dashboard_Attendance_Manager',
            'Athlete_Dashboard_Membership_Manager',
            'Athlete_Dashboard_Messaging_Manager',
            'Athlete_Dashboard_Charts_Manager'
        );

        foreach ($manager_classes as $manager) {
            if (!class_exists($manager)) {
                error_log("Manager class not found: {$manager}");
                continue;
            }
            new $manager();
        }
        
        // Initialize dashboard controller last
        if (!class_exists('Athlete_Dashboard_Controller')) {
            error_log('Dashboard Controller class not found');
            return;
        }
        new Athlete_Dashboard_Controller();
        
    } catch (Exception $e) {
        error_log('Athlete Dashboard initialization error: ' . $e->getMessage());
        error_log('Stack trace: ' . $e->getTraceAsString());
    }
}

/**
 * Handle theme activation
 */
function athlete_dashboard_theme_activation() {
    // Initialize post types and taxonomies
    $workout_post_type = new Athlete_Dashboard_Workout_Post_Type();
    $workout_log_post_type = new Athlete_Dashboard_Workout_Log_Post_Type();
    $exercise_taxonomy = new Athlete_Dashboard_Exercise_Taxonomy();
    
    // Add default terms
    $exercise_taxonomy->add_default_terms();
    
    // Run progress migrations
    Athlete_Dashboard_Progress_Migration::run_migrations();
    
    // Flush rewrite rules
    flush_rewrite_rules();
}

/**
 * Initialize AJAX handlers
 */
function athlete_dashboard_init_ajax_handlers() {
    add_action('wp_ajax_get_section_content', 'athlete_dashboard_get_section_content');
    add_action('wp_ajax_nopriv_get_section_content', 'athlete_dashboard_get_section_content');
    add_action('wp_ajax_do_shortcode', 'athlete_dashboard_do_shortcode_ajax');
    add_action('wp_ajax_nopriv_do_shortcode', 'athlete_dashboard_do_shortcode_ajax');
}
add_action('init', 'athlete_dashboard_init_ajax_handlers');

/**
 * AJAX handler for getting section content
 */
function athlete_dashboard_get_section_content() {
    check_ajax_referer('athlete_dashboard_nonce', 'nonce');
    
    $section = isset($_POST['section']) ? sanitize_text_field($_POST['section']) : '';
    if (empty($section)) {
        wp_send_json_error('No section specified');
    }

    ob_start();
    do_action('athlete_dashboard_section_content_' . $section);
    $content = ob_get_clean();

    if (!empty($content)) {
        wp_send_json_success($content);
    } else {
        wp_send_json_error('No content found for section: ' . $section);
    }
}

/**
 * AJAX handler for processing shortcodes
 */
function athlete_dashboard_do_shortcode_ajax() {
    check_ajax_referer('athlete_dashboard_nonce', 'nonce');
    
    $shortcode = isset($_POST['shortcode']) ? sanitize_text_field($_POST['shortcode']) : '';
    if (empty($shortcode)) {
        wp_send_json_error('No shortcode specified');
    }

    $content = do_shortcode('[' . $shortcode . ']');
    wp_send_json_success($content);
}

// Initialize after theme setup
add_action('after_setup_theme', 'athlete_dashboard_init');
add_action('after_switch_theme', 'athlete_dashboard_theme_activation'); 