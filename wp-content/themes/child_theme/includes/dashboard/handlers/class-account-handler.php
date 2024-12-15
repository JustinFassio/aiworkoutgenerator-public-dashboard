<?php
/**
 * Account Handler Class
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Account_Handler {
    /**
     * Initialize the handler
     */
    public function __construct() {
        add_action('wp_ajax_save_account_settings', array($this, 'save_account_settings'));
        add_action('wp_ajax_update_notification_preferences', array($this, 'update_notification_preferences'));
        add_action('wp_ajax_update_privacy_settings', array($this, 'update_privacy_settings'));
    }

    /**
     * Save account settings
     */
    public function save_account_settings() {
        check_ajax_referer('account_settings_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error(__('You must be logged in to update settings', 'athlete-dashboard'));
        }

        $user_id = get_current_user_id();
        $settings = $this->validate_account_settings($_POST);

        if (is_wp_error($settings)) {
            wp_send_json_error($settings->get_error_message());
        }

        // Update user settings
        foreach ($settings as $key => $value) {
            update_user_meta($user_id, '_athlete_' . $key, $value);
        }

        wp_send_json_success(__('Account settings saved successfully', 'athlete-dashboard'));
    }

    /**
     * Update notification preferences
     */
    public function update_notification_preferences() {
        check_ajax_referer('notification_prefs_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error(__('You must be logged in to update preferences', 'athlete-dashboard'));
        }

        $user_id = get_current_user_id();
        $preferences = $this->validate_notification_preferences($_POST);

        if (is_wp_error($preferences)) {
            wp_send_json_error($preferences->get_error_message());
        }

        update_user_meta($user_id, '_athlete_notification_preferences', $preferences);
        wp_send_json_success(__('Notification preferences updated successfully', 'athlete-dashboard'));
    }

    /**
     * Update privacy settings
     */
    public function update_privacy_settings() {
        check_ajax_referer('privacy_settings_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error(__('You must be logged in to update privacy settings', 'athlete-dashboard'));
        }

        $user_id = get_current_user_id();
        $settings = $this->validate_privacy_settings($_POST);

        if (is_wp_error($settings)) {
            wp_send_json_error($settings->get_error_message());
        }

        update_user_meta($user_id, '_athlete_privacy_settings', $settings);
        wp_send_json_success(__('Privacy settings updated successfully', 'athlete-dashboard'));
    }

    /**
     * Validate account settings
     *
     * @param array $data Raw settings data
     * @return array|WP_Error Validated settings or error
     */
    private function validate_account_settings($data) {
        $settings = array();
        $required_fields = array('timezone', 'language', 'measurement_unit');

        foreach ($required_fields as $field) {
            if (empty($data[$field])) {
                return new WP_Error(
                    'missing_field',
                    sprintf(__('Missing required field: %s', 'athlete-dashboard'), $field)
                );
            }
            $settings[$field] = sanitize_text_field($data[$field]);
        }

        return $settings;
    }

    /**
     * Validate notification preferences
     *
     * @param array $data Raw preferences data
     * @return array|WP_Error Validated preferences or error
     */
    private function validate_notification_preferences($data) {
        $preferences = array();
        $valid_types = array('email', 'push', 'sms');

        foreach ($valid_types as $type) {
            $preferences[$type] = !empty($data[$type]) && $data[$type] === 'on';
        }

        return $preferences;
    }

    /**
     * Validate privacy settings
     *
     * @param array $data Raw privacy settings data
     * @return array|WP_Error Validated settings or error
     */
    private function validate_privacy_settings($data) {
        $settings = array();
        $valid_settings = array(
            'profile_visibility' => array('public', 'private', 'friends'),
            'workout_visibility' => array('public', 'private', 'friends'),
            'progress_visibility' => array('public', 'private', 'friends')
        );

        foreach ($valid_settings as $setting => $allowed_values) {
            if (empty($data[$setting]) || !in_array($data[$setting], $allowed_values)) {
                return new WP_Error(
                    'invalid_setting',
                    sprintf(__('Invalid value for setting: %s', 'athlete-dashboard'), $setting)
                );
            }
            $settings[$setting] = sanitize_text_field($data[$setting]);
        }

        return $settings;
    }
} 