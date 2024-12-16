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
            'Athlete_Dashboard_Charts_Data_Manager'
        );

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
    
    // Flush rewrite rules
    flush_rewrite_rules();
}

// Initialize after theme setup
add_action('after_setup_theme', 'athlete_dashboard_init');
add_action('after_switch_theme', 'athlete_dashboard_theme_activation'); 