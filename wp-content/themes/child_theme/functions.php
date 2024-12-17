<?php
/**
 * Athlete Dashboard Theme Functions
 * 
 * This is the main functions file that bootstraps the theme.
 * All specific functionality has been modularized into separate files.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Load autoloader first
require_once get_stylesheet_directory() . '/includes/class-autoloader.php';

// Initialize autoloader
$autoloader = new Athlete_Dashboard_Autoloader();
$autoloader->register();

// Load core functionality
require_once get_stylesheet_directory() . '/functions/core/constants.php';
require_once get_stylesheet_directory() . '/functions/core/initialization.php';
require_once get_stylesheet_directory() . '/functions/core/theme-setup.php';
require_once get_stylesheet_directory() . '/functions/core/capabilities.php';
require_once get_stylesheet_directory() . '/functions/api/rest-routes.php';
require_once get_stylesheet_directory() . '/functions/shortcodes.php';
require_once get_stylesheet_directory() . '/functions/dashboard-rendering.php';

// Load helper functions
require_once get_stylesheet_directory() . '/includes/helpers/training-functions.php';
require_once get_stylesheet_directory() . '/includes/helpers/bookings-functions.php';
require_once get_stylesheet_directory() . '/includes/helpers/membership-functions.php';
require_once get_stylesheet_directory() . '/includes/helpers/attendance-functions.php';
require_once get_stylesheet_directory() . '/includes/helpers/goals-functions.php';
require_once get_stylesheet_directory() . '/includes/helpers/recommendations-functions.php';
require_once get_stylesheet_directory() . '/includes/helpers/messaging-functions.php';

// Load core files
require_once get_stylesheet_directory() . '/functions/core/enqueue-scripts.php';

// Include migration trigger
require_once get_stylesheet_directory() . '/includes/data/exercise-progress/squat/trigger-migration.php';

/**
 * Register dashboard shortcode
 */
function athlete_dashboard_shortcode() {
    return athlete_dashboard_render_dashboard();
}
add_shortcode('athlete_dashboard', 'athlete_dashboard_shortcode');

/**
 * Run database migrations on theme activation
 */
function athlete_dashboard_run_migrations() {
    // Run squat progress migration
    require_once get_stylesheet_directory() . '/includes/data/exercise-progress/squat/class-squat-progress-migration.php';
    $migration = new Athlete_Dashboard_Squat_Progress_Migration();
    $migration->run();
}
add_action('after_switch_theme', 'athlete_dashboard_run_migrations');

/**
 * Initialize components
 */
function athlete_dashboard_init_components() {
    // Initialize squat progress component
    new Athlete_Dashboard_Squat_Progress_Component();
}
add_action('init', 'athlete_dashboard_init_components');
