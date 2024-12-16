<?php
// functions.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define theme constants
define('ATHLETE_DASHBOARD_PATH', get_stylesheet_directory());
define('ATHLETE_DASHBOARD_URI', get_stylesheet_directory_uri());
define('ATHLETE_DASHBOARD_VERSION', '1.0.0');

// Load autoloader first
require_once ATHLETE_DASHBOARD_PATH . '/includes/class-autoloader.php';

// Initialize autoloader
$autoloader = new Athlete_Dashboard_Autoloader();
$autoloader->register();

// Load core files
require_once ATHLETE_DASHBOARD_PATH . '/functions/core/enqueue-scripts.php';

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

// Initialize after theme setup
add_action('after_setup_theme', 'athlete_dashboard_init');

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
add_action('after_switch_theme', 'athlete_dashboard_theme_activation');

/**
 * Register REST API endpoints for modular components
 */
function athlete_dashboard_register_rest_routes() {
    // Core endpoints
    register_rest_route('athlete-dashboard/v1', '/workouts', array(
        'methods' => 'GET',
        'callback' => 'athlete_dashboard_get_workouts',
        'permission_callback' => 'athlete_dashboard_rest_permission'
    ));
    
    // Module-specific endpoints
    register_rest_route('athlete-dashboard/v1', '/goals', array(
        'methods' => 'GET',
        'callback' => 'athlete_dashboard_get_goals',
        'permission_callback' => 'athlete_dashboard_rest_permission'
    ));
    
    register_rest_route('athlete-dashboard/v1', '/attendance', array(
        'methods' => 'GET',
        'callback' => 'athlete_dashboard_get_attendance',
        'permission_callback' => 'athlete_dashboard_rest_permission'
    ));
    
    register_rest_route('athlete-dashboard/v1', '/membership', array(
        'methods' => 'GET',
        'callback' => 'athlete_dashboard_get_membership',
        'permission_callback' => 'athlete_dashboard_rest_permission'
    ));
}
add_action('rest_api_init', 'athlete_dashboard_register_rest_routes');

/**
 * REST API permission callback
 */
function athlete_dashboard_rest_permission() {
    return is_user_logged_in();
}

// Register dashboard shortcode
function athlete_dashboard_shortcode() {
    global $dashboard;
    return $dashboard->render();
}
add_shortcode('athlete_dashboard', 'athlete_dashboard_shortcode');

// Add theme support
function athlete_dashboard_theme_setup() {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
}
add_action('after_setup_theme', 'athlete_dashboard_theme_setup');

// Register navigation menus
function athlete_dashboard_register_menus() {
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'athlete-dashboard'),
        'footer' => __('Footer Menu', 'athlete-dashboard'),
    ));
}
add_action('init', 'athlete_dashboard_register_menus');

// Add custom image sizes
function athlete_dashboard_add_image_sizes() {
    add_image_size('profile-picture', 150, 150, true);
    add_image_size('workout-thumbnail', 300, 200, true);
}
add_action('after_setup_theme', 'athlete_dashboard_add_image_sizes');

// Add custom capabilities for workout management
function athlete_dashboard_add_capabilities() {
    $roles = array('administrator', 'editor');
    
    $capabilities = array(
        // Workout capabilities
        'edit_workout' => true,
        'read_workout' => true,
        'delete_workout' => true,
        'edit_workouts' => true,
        'edit_others_workouts' => true,
        'publish_workouts' => true,
        'read_private_workouts' => true,
        'delete_workouts' => true,
        'delete_private_workouts' => true,
        'delete_published_workouts' => true,
        'delete_others_workouts' => true,
        'edit_private_workouts' => true,
        'edit_published_workouts' => true,
        
        // Workout log capabilities
        'edit_workout_log' => true,
        'read_workout_log' => true,
        'delete_workout_log' => true,
        'edit_workout_logs' => true,
        'edit_others_workout_logs' => true,
        'publish_workout_logs' => true,
        'read_private_workout_logs' => true,
        'delete_workout_logs' => true,
        'delete_private_workout_logs' => true,
        'delete_published_workout_logs' => true,
        'delete_others_workout_logs' => true,
        'edit_private_workout_logs' => true,
        'edit_published_workout_logs' => true
    );

    foreach ($roles as $role_name) {
        $role = get_role($role_name);
        if ($role) {
            foreach ($capabilities as $cap => $grant) {
                $role->add_cap($cap, $grant);
            }
        }
    }

    // Add limited capabilities for subscribers
    $subscriber = get_role('subscriber');
    if ($subscriber) {
        $subscriber_caps = array(
            'read_workout' => true,
            'edit_workout_log' => true,
            'read_workout_log' => true,
            'edit_workout_logs' => true,
            'publish_workout_logs' => true
        );

        foreach ($subscriber_caps as $cap => $grant) {
            $subscriber->add_cap($cap, $grant);
        }
    }
}
add_action('admin_init', 'athlete_dashboard_add_capabilities');
