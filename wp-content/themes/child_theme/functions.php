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
$autoloader = new Athlete_Dashboard_Autoloader();
$autoloader->register();

// Load core files
require_once ATHLETE_DASHBOARD_PATH . '/functions/core/enqueue-scripts.php';

// Load feature-specific files
$required_files = array(
    // Core functionality
    '/functions/custom-post-types.php',
    '/functions/ajax-handlers.php',
    
    // User functionality
    '/functions/user-profile.php',
    '/functions/user-data.php',
    
    // Dashboard functionality
    '/functions/progress-tracking.php',
    '/functions/exercise-ajax-handlers.php',
    '/functions/exercise-data.php',
    
    // Utility functions
    '/functions/utilities.php',
    '/functions/debug.php',
    
    // Feature-specific functions
    '/functions/messaging-functions.php',
    '/functions/database-setup.php',
    '/functions/athlete-dashboard-functions.php',
    '/functions/shortcodes.php',
);

// Include each required file with error checking
foreach ($required_files as $file) {
    $file_path = ATHLETE_DASHBOARD_PATH . $file;
    if (file_exists($file_path)) {
        require_once $file_path;
    } else {
        error_log('Missing required file: ' . $file_path);
    }
}

/**
 * Initialize the workout functionality
 */
function athlete_dashboard_init() {
    // Initialize post types and taxonomies first
    new Athlete_Dashboard_Workout_Post_Type();
    new Athlete_Dashboard_Workout_Log_Post_Type();
    new Athlete_Dashboard_Exercise_Taxonomy();
    
    // Initialize data managers
    new Athlete_Dashboard_Workout_Data_Manager();
    new Athlete_Dashboard_Exercise_Data_Manager();
    new Athlete_Dashboard_Workout_Progress_Manager();
    new Athlete_Dashboard_Workout_Stats_Manager();
    
    // Initialize handlers
    new Athlete_Dashboard_Workout_Handler();
    
    // Initialize components
    new Athlete_Dashboard_Workout_Lightbox();
    new Athlete_Dashboard_Workout_Logger();
    new Athlete_Dashboard_Progress_Tracker();
    new Athlete_Dashboard_Workout_Stats_Display();
    
    // Initialize dashboard controller
    new Athlete_Dashboard_Workout_Dashboard_Controller();

    // Initialize asset manager
    new Athlete_Dashboard_Asset_Manager();
}
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

// Initialize dashboard after components are loaded
function athlete_dashboard_late_init() {
    global $dashboard;
    $dashboard = new Athlete_Dashboard_Controller();
}
add_action('init', 'athlete_dashboard_late_init');

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
