<?php
/**
 * Dashboard Feature Initialization
 */

if (!defined('ABSPATH')) {
    exit;
}

// Load dependencies in correct order
require_once __DIR__ . '/models/NavigationCard.php';
require_once __DIR__ . '/components/NavigationCards.php';
require_once __DIR__ . '/components/Modal.php';
require_once __DIR__ . '/components/Dashboard.php';

// Initialize the feature
function init_dashboard_feature() {
    // Register scripts and styles
    add_action('wp_enqueue_scripts', function() {
        if (is_page_template('features/dashboard/templates/dashboard.php')) {
            // Navigation cards styles
            wp_enqueue_style(
                'athlete-dashboard-navigation',
                get_stylesheet_directory_uri() . '/features/dashboard/assets/css/navigation-cards.css',
                [],
                '1.0.0'
            );

            // Modal styles
            wp_enqueue_style(
                'athlete-dashboard-modal',
                get_stylesheet_directory_uri() . '/features/dashboard/assets/css/modal.css',
                [],
                '1.0.0'
            );

            // Modal JavaScript
            wp_enqueue_script(
                'athlete-dashboard-modal',
                get_stylesheet_directory_uri() . '/features/dashboard/assets/js/modal.js',
                ['jquery'],
                '1.0.0',
                true
            );

            // Dashicons
            wp_enqueue_style('dashicons');
        }
    });
}

add_action('init', 'init_dashboard_feature'); 