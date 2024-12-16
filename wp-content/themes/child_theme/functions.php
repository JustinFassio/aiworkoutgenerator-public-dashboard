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

// Load core files
require_once get_stylesheet_directory() . '/functions/core/enqueue-scripts.php';

/**
 * Register dashboard shortcode
 */
function athlete_dashboard_shortcode() {
    if (!is_user_logged_in()) {
        return 'Please log in to view your dashboard.';
    }

    ob_start();
    
    // Include template parts
    include_once get_stylesheet_directory() . '/templates/dashboard/header.php';
    include_once get_stylesheet_directory() . '/templates/dashboard/overview.php';
    include_once get_stylesheet_directory() . '/templates/dashboard/workouts.php';
    include_once get_stylesheet_directory() . '/templates/dashboard/progress.php';
    include_once get_stylesheet_directory() . '/templates/dashboard/nutrition.php';
    include_once get_stylesheet_directory() . '/templates/dashboard/footer.php';
    
    return ob_get_clean();
}
add_shortcode('athlete_dashboard', 'athlete_dashboard_shortcode');
