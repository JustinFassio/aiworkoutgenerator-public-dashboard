<?php
/**
 * Template part for displaying account details
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

<form id="account-details-form" class="custom-form">
    <div class="user-profile">
        <div class="profile-picture">
            <?php echo get_avatar($current_user->ID, 150); ?>
            <input type="file" id="profile-picture-upload" name="profile_picture" accept="image/*" style="display: none;">
        </div>
        <div class="profile-info">
            <p>
                <strong><?php esc_html_e('Athlete Name:', 'athlete-dashboard'); ?></strong>
                <span id="display-name-text"><?php echo esc_html($current_user->display_name); ?></span>
            </p>
            <p>
                <strong><?php esc_html_e('Email:', 'athlete-dashboard'); ?></strong>
                <span id="email-text"><?php echo esc_html($current_user->user_email); ?></span>
            </p>
            <p>
                <strong><?php esc_html_e('Athlete Profile:', 'athlete-dashboard'); ?></strong>
                <span id="bio-text"><?php echo wp_kses_post($current_user->description); ?></span>
            </p>
        </div>
        <div class="edit-profile-fields" style="display: none;">
            <input type="text" name="display_name" id="edit-display-name" 
                value="<?php echo esc_attr($current_user->display_name); ?>" 
                placeholder="<?php esc_attr_e('Display Name', 'athlete-dashboard'); ?>">
            <input type="email" name="email" id="edit-email" 
                value="<?php echo esc_attr($current_user->user_email); ?>" 
                placeholder="<?php esc_attr_e('Email', 'athlete-dashboard'); ?>">
            <textarea name="bio" id="edit-bio" 
                placeholder="<?php esc_attr_e('Bio', 'athlete-dashboard'); ?>"><?php 
                echo esc_textarea($current_user->description); 
            ?></textarea>
        </div>
    </div>
    <div class="profile-actions">
        <button id="change-avatar" class="custom-button">
            <?php esc_html_e('Change Image', 'athlete-dashboard'); ?>
        </button>
        <button type="button" id="edit-profile" class="custom-button">
            <?php esc_html_e('Edit Profile', 'athlete-dashboard'); ?>
        </button>
        <button type="submit" id="save-profile" class="custom-button" style="display: none;">
            <?php esc_html_e('Save Profile', 'athlete-dashboard'); ?>
        </button>
        <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="custom-button logout-button">
            <?php esc_html_e('Logout', 'athlete-dashboard'); ?>
        </a>
    </div>
    <?php wp_nonce_field('athlete_dashboard_account_nonce', 'account_nonce'); ?>
</form> 