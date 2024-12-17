<?php
/**
 * Dashboard Feature Hooks
 */

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
    $dashboard = new Dashboard();
}
add_action('init', 'init_dashboard_feature_hooks'); 