<?php
/**
 * Dashboard Feature Initialization
 */

if (!defined('ABSPATH')) {
    exit;
}

// Load feature components
require_once __DIR__ . '/components/Dashboard.php';
require_once __DIR__ . '/hooks/dashboard-hooks.php';

// Initialize the feature
function init_dashboard_feature() {
    // Register styles
    add_action('wp_enqueue_scripts', function() {
        if (is_page_template('features/dashboard/templates/dashboard.php')) {
            wp_enqueue_style(
                'athlete-dashboard-feature',
                get_stylesheet_directory_uri() . '/features/dashboard/styles/dashboard.css',
                array(),
                '1.0.0'
            );
        }
    });
}
add_action('init', 'init_dashboard_feature'); 