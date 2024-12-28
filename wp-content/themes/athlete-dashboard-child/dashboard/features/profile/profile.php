<?php
/**
 * Profile Feature Registration
 * 
 * Registers the Profile feature with the dashboard system.
 */

namespace AthleteDashboard\Dashboard\Features;

if (!defined('ABSPATH')) {
    exit;
}

class Profile {
    public function __construct() {
        add_filter('athlete_dashboard_features', [$this, 'registerFeature']);
        add_action('wp_ajax_update_profile', [$this, 'handleProfileUpdate']);
    }

    /**
     * Register the Profile feature
     */
    public function registerFeature(array $features): array {
        $current_user = wp_get_current_user();
        
        $features[] = [
            'id' => 'profile',
            'title' => __('Profile', 'athlete-dashboard'),
            'description' => __('Update your personal information and preferences.', 'athlete-dashboard'),
            'icon' => 'dashicons-admin-users',
            'react_component' => 'Profile',
            'props' => [
                'user' => [
                    'name' => $current_user->display_name,
                    'email' => $current_user->user_email,
                ],
                'onSave' => [
                    'action' => 'update_profile',
                    'nonce' => wp_create_nonce('update_profile')
                ]
            ]
        ];

        return $features;
    }

    /**
     * Handle profile update AJAX request
     */
    public function handleProfileUpdate(): void {
        check_ajax_referer('update_profile');

        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!current_user_can('edit_user', get_current_user_id())) {
            wp_send_json_error(['message' => __('Permission denied.', 'athlete-dashboard')]);
            return;
        }

        $user_data = [
            'ID' => get_current_user_id(),
            'display_name' => sanitize_text_field($data['name']),
            'user_email' => sanitize_email($data['email'])
        ];

        $result = wp_update_user($user_data);

        if (is_wp_error($result)) {
            wp_send_json_error([
                'message' => $result->get_error_message()
            ]);
            return;
        }

        wp_send_json_success([
            'message' => __('Profile updated successfully.', 'athlete-dashboard'),
            'user' => [
                'name' => $user_data['display_name'],
                'email' => $user_data['user_email']
            ]
        ]);
    }
}

// Initialize the feature
new Profile(); 