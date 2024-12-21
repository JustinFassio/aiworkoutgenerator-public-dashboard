<?php
/**
 * Shared Components Initialization
 */

if (!defined('ABSPATH')) {
    exit;
}

// Load shared components
require_once __DIR__ . '/components/Form.php';

// Register shared assets
function init_shared_components() {
    add_action('wp_enqueue_scripts', function() {
        // Register shared styles
        wp_register_style(
            'athlete-shared-forms',
            get_stylesheet_directory_uri() . '/features/shared/assets/css/forms.css',
            [],
            '1.0.0'
        );
    });
}

add_action('init', 'init_shared_components'); 