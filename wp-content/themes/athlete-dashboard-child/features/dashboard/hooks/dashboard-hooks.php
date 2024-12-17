<?php
/**
 * Dashboard Feature Hooks
 */

use AthleteDashboard\Features\Dashboard\Components\Dashboard;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register dashboard page template
 */
function register_dashboard_template($templates) {
    $templates['features/dashboard/templates/dashboard.php'] = 'Athlete Dashboard';
    return $templates;
}
add_filter('theme_page_templates', 'register_dashboard_template');

/**
 * Initialize dashboard feature
 */
function init_dashboard_feature_hooks() {
    require_once get_stylesheet_directory() . '/features/dashboard/components/Dashboard.php';
    $dashboard = new Dashboard();
}
add_action('init', 'init_dashboard_feature_hooks'); 