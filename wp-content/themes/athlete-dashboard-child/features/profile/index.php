<?php
/**
 * Profile Feature Initialization
 */

if (!defined('ABSPATH')) {
    exit;
}

// Load feature components
require_once __DIR__ . '/components/Profile.php';

// Initialize the feature
function init_profile_feature() {
    $profile = new Profile();

    // Add profile fields to WP Admin User Profile
    add_action('show_user_profile', array($profile, 'render_admin_fields'));
    add_action('edit_user_profile', array($profile, 'render_admin_fields'));
    add_action('personal_options_update', array($profile, 'save_admin_fields'));
    add_action('edit_user_profile_update', array($profile, 'save_admin_fields'));

    // Register frontend assets
    add_action('wp_enqueue_scripts', function() {
        if (is_page_template('features/dashboard/templates/dashboard.php')) {
            wp_enqueue_style(
                'athlete-profile',
                get_stylesheet_directory_uri() . '/features/profile/assets/css/profile.css',
                array(),
                '1.0.0'
            );

            wp_enqueue_script(
                'athlete-profile',
                get_stylesheet_directory_uri() . '/features/profile/assets/js/profile.js',
                array('jquery'),
                '1.0.0',
                true
            );

            wp_localize_script('athlete-profile', 'profileData', array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('profile_nonce'),
                'user_id' => get_current_user_id()
            ));
        }
    });
}
add_action('init', 'init_profile_feature'); 