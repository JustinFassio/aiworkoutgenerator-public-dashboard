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

// Include required files
require_once get_stylesheet_directory() . '/includes/post-types/class-workout-post-type.php';
require_once get_stylesheet_directory() . '/includes/data/class-workout-data-manager.php';
require_once get_stylesheet_directory() . '/includes/dashboard/handlers/class-workout-handler.php';
require_once get_stylesheet_directory() . '/includes/dashboard/components/class-workout-lightbox.php';
require_once get_stylesheet_directory() . '/includes/dashboard/components/class-workout-logger.php';
require_once get_stylesheet_directory() . '/includes/dashboard/sections/class-workout-manager.php';

/**
 * Initialize the workout functionality
 */
function athlete_dashboard_init() {
    // Initialize post type first
    new Athlete_Dashboard_Workout_Post_Type();
    
    // Initialize handlers
    new Athlete_Dashboard_Workout_Handler();
    
    // Initialize components
    new Athlete_Dashboard_Workout_Lightbox();
    new Athlete_Dashboard_Workout_Logger();
    
    // Initialize sections
    new Athlete_Dashboard_Workout_Manager();
}
add_action('after_setup_theme', 'athlete_dashboard_init');

/**
 * Handle theme activation
 */
function athlete_dashboard_theme_activation() {
    // Initialize post type
    $post_type = new Athlete_Dashboard_Workout_Post_Type();
    
    // Run activation routine
    $post_type->activation();
    
    // Flush rewrite rules
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'athlete_dashboard_theme_activation');

// Initialize components
function athlete_dashboard_init() {
    // Initialize asset manager
    new Athlete_Dashboard_Asset_Manager();

    // Load components
    $component_files = glob(ATHLETE_DASHBOARD_PATH . '/includes/dashboard/components/class-*.php');
    foreach ($component_files as $component_file) {
        require_once $component_file;
    }
}
add_action('after_setup_theme', 'athlete_dashboard_init');

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
