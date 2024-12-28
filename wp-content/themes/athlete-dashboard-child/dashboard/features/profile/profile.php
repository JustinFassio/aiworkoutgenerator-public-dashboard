<?php
/**
 * Profile Feature Registration
 * 
 * Registers the Profile feature with the dashboard system.
 */

namespace AthleteDashboard\Features\Profile;

use AthleteDashboard\Dashboard\Contracts\FeatureInterface;

if (!defined('ABSPATH')) {
    exit;
}

class Profile implements FeatureInterface {
    private static ?Profile $instance = null;
    private string $identifier = 'profile';

    /**
     * Register the feature
     */
    public static function register(): void {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        self::$instance->init();
    }

    /**
     * Initialize the feature
     */
    public function init(): void {
        // Register feature with dashboard
        add_filter('athlete_dashboard_features', [$this, 'registerFeature']);
        
        // Handle AJAX updates
        add_action('wp_ajax_update_profile', [$this, 'handleProfileUpdate']);
        
        // Add admin profile fields
        add_action('show_user_profile', [$this, 'render_admin_fields']);
        add_action('edit_user_profile', [$this, 'render_admin_fields']);
        add_action('personal_options_update', [$this, 'save_admin_fields']);
        add_action('edit_user_profile_update', [$this, 'save_admin_fields']);
    }

    /**
     * Get the feature identifier
     */
    public function getIdentifier(): string {
        return $this->identifier;
    }

    /**
     * Get feature metadata
     */
    public function getMetadata(): array {
        $current_user = wp_get_current_user();
        
        return [
            'id' => $this->identifier,
            'title' => __('Profile', 'athlete-dashboard'),
            'description' => __('Update your personal information and preferences.', 'athlete-dashboard'),
            'icon' => 'dashicons-admin-users',
            'react_component' => 'Profile',
            'props' => [
                'user' => [
                    'name' => $current_user->display_name,
                    'email' => $current_user->user_email,
                    'athlete_type' => get_user_meta($current_user->ID, 'athlete_type', true) ?: 'beginner'
                ],
                'onSave' => [
                    'action' => 'update_profile',
                    'nonce' => wp_create_nonce('update_profile')
                ]
            ]
        ];
    }

    /**
     * Check if the feature is enabled
     */
    public function isEnabled(): bool {
        return true;
    }

    /**
     * Register the Profile feature with the dashboard
     */
    public function registerFeature(array $features): array {
        if ($this->isEnabled()) {
            $features[] = $this->getMetadata();
        }
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

        // Update athlete type if provided
        if (isset($data['athlete_type'])) {
            update_user_meta($user_data['ID'], 'athlete_type', sanitize_text_field($data['athlete_type']));
        }

        wp_send_json_success([
            'message' => __('Profile updated successfully.', 'athlete-dashboard'),
            'user' => [
                'name' => $user_data['display_name'],
                'email' => $user_data['user_email'],
                'athlete_type' => get_user_meta($user_data['ID'], 'athlete_type', true)
            ]
        ]);
    }

    /**
     * Render additional fields in the WordPress admin user profile
     * 
     * @param WP_User $user The user object being edited
     */
    public function render_admin_fields($user): void {
        if (!current_user_can('edit_user', $user->ID)) {
            return;
        }
        ?>
        <h2><?php _e('Athlete Dashboard Settings', 'athlete-dashboard'); ?></h2>
        <table class="form-table">
            <tr>
                <th><label for="athlete_type"><?php _e('Athlete Type', 'athlete-dashboard'); ?></label></th>
                <td>
                    <select name="athlete_type" id="athlete_type">
                        <option value="beginner" <?php selected(get_user_meta($user->ID, 'athlete_type', true), 'beginner'); ?>><?php _e('Beginner', 'athlete-dashboard'); ?></option>
                        <option value="intermediate" <?php selected(get_user_meta($user->ID, 'athlete_type', true), 'intermediate'); ?>><?php _e('Intermediate', 'athlete-dashboard'); ?></option>
                        <option value="advanced" <?php selected(get_user_meta($user->ID, 'athlete_type', true), 'advanced'); ?>><?php _e('Advanced', 'athlete-dashboard'); ?></option>
                    </select>
                    <p class="description"><?php _e('Select the athlete\'s experience level', 'athlete-dashboard'); ?></p>
                </td>
            </tr>
        </table>
        <?php
    }

    /**
     * Save the custom admin fields
     * 
     * @param int $user_id The ID of the user being edited
     */
    public function save_admin_fields($user_id): void {
        if (!current_user_can('edit_user', $user_id)) {
            return;
        }

        if (isset($_POST['athlete_type'])) {
            update_user_meta($user_id, 'athlete_type', sanitize_text_field($_POST['athlete_type']));
        }
    }
}

// Initialize the feature using the proper registration method
Profile::register(); 