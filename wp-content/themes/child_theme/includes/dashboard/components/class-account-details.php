<?php
/**
 * Account Details Component Class
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Account_Details {
    /**
     * Initialize the component
     */
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_ajax_update_account_details', array($this, 'handle_account_update'));
        add_action('wp_ajax_update_profile_picture', array($this, 'handle_profile_picture_update'));
    }

    /**
     * Enqueue component-specific scripts
     */
    public function enqueue_scripts() {
        wp_enqueue_media();
        wp_enqueue_script(
            'account-details',
            ATHLETE_DASHBOARD_URI . '/assets/js/components/account-details.js',
            array('jquery'),
            filemtime(ATHLETE_DASHBOARD_PATH . '/assets/js/components/account-details.js'),
            true
        );

        wp_localize_script('account-details', 'accountDetailsData', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('account_details_nonce'),
            'strings' => array(
                'updateSuccess' => __('Profile updated successfully', 'athlete-dashboard'),
                'updateError' => __('Error updating profile', 'athlete-dashboard'),
                'imageSuccess' => __('Profile picture updated successfully', 'athlete-dashboard'),
                'imageError' => __('Error updating profile picture', 'athlete-dashboard')
            )
        ));
    }

    /**
     * Render the account details section
     *
     * @param WP_User $current_user The current user object.
     */
    public function render($current_user) {
        if (!$current_user instanceof WP_User) {
            return;
        }

        include ATHLETE_DASHBOARD_PATH . '/templates/dashboard/sections/account-details.php';
    }

    /**
     * Handle account details update via AJAX
     */
    public function handle_account_update() {
        check_ajax_referer('account_details_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error(__('You must be logged in to update your profile', 'athlete-dashboard'));
        }

        $user_id = get_current_user_id();
        $display_name = isset($_POST['display_name']) ? sanitize_text_field($_POST['display_name']) : '';
        $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
        $bio = isset($_POST['bio']) ? wp_kses_post($_POST['bio']) : '';

        if (empty($display_name) || empty($email)) {
            wp_send_json_error(__('Name and email are required', 'athlete-dashboard'));
        }

        // Update user data
        $user_data = array(
            'ID' => $user_id,
            'display_name' => $display_name,
            'user_email' => $email,
            'description' => $bio
        );

        $result = wp_update_user($user_data);

        if (is_wp_error($result)) {
            wp_send_json_error($result->get_error_message());
        }

        wp_send_json_success(array(
            'message' => __('Profile updated successfully', 'athlete-dashboard'),
            'user_data' => array(
                'display_name' => $display_name,
                'email' => $email,
                'bio' => $bio
            )
        ));
    }

    /**
     * Handle profile picture update via AJAX
     */
    public function handle_profile_picture_update() {
        check_ajax_referer('account_details_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error(__('You must be logged in to update your profile picture', 'athlete-dashboard'));
        }

        if (!isset($_FILES['profile_picture'])) {
            wp_send_json_error(__('No file was uploaded', 'athlete-dashboard'));
        }

        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');

        $user_id = get_current_user_id();
        $attachment_id = media_handle_upload('profile_picture', 0);

        if (is_wp_error($attachment_id)) {
            wp_send_json_error($attachment_id->get_error_message());
        }

        // Update user meta with new avatar
        update_user_meta($user_id, 'athlete_profile_picture', $attachment_id);

        wp_send_json_success(array(
            'message' => __('Profile picture updated successfully', 'athlete-dashboard'),
            'avatar_url' => wp_get_attachment_image_url($attachment_id, 'thumbnail')
        ));
    }
} 