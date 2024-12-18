<?php
/**
 * Profile Feature Initialization
 */

use AthleteDashboard\Features\Profile\Components\Profile;
use AthleteDashboard\Features\Profile\Models\ProfileData;
use AthleteDashboard\Features\Profile\Services\ProfileService;

if (!defined('ABSPATH')) {
    exit;
}

// Load shared components first
require_once get_stylesheet_directory() . '/features/shared/index.php';

// Load dependencies in correct order
require_once __DIR__ . '/models/ProfileData.php';
require_once __DIR__ . '/services/ProfileService.php';
require_once __DIR__ . '/components/Profile.php';

// Initialize the feature
function init_profile_feature() {
    $profile = new Profile();

    // Add profile fields to WP Admin User Profile
    add_action('show_user_profile', [$profile, 'render_admin_fields']);
    add_action('edit_user_profile', [$profile, 'render_admin_fields']);
    add_action('personal_options_update', [$profile, 'save_admin_fields']);
    add_action('edit_user_profile_update', [$profile, 'save_admin_fields']);

    // Register frontend assets
    add_action('wp_enqueue_scripts', function() {
        if (is_page_template('features/dashboard/templates/dashboard.php')) {
            // Enqueue shared assets
            wp_enqueue_style('athlete-shared-forms');
            wp_enqueue_script('athlete-form-handler');

            // Then load profile-specific assets
            wp_enqueue_style(
                'athlete-profile',
                get_stylesheet_directory_uri() . '/features/profile/assets/css/profile.css',
                ['athlete-shared-forms'],
                '1.0.0'
            );

            wp_enqueue_script(
                'athlete-profile',
                get_stylesheet_directory_uri() . '/features/profile/assets/js/profile.js',
                ['jquery', 'athlete-form-handler'],
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