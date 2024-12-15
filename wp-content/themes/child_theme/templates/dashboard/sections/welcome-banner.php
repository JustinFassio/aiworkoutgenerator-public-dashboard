<?php
/**
 * Template part for displaying the welcome banner
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

<div class="welcome-banner" id="welcomeBanner">
    <div class="welcome-content">
        <span class="user-icon" aria-hidden="true">&#128100;</span>
        <span class="welcome-message">
            <?php
            printf(
                /* translators: %s: user display name */
                esc_html__('Welcome back, %s', 'athlete-dashboard'),
                '<strong>' . esc_html($current_user->display_name) . '</strong>'
            );
            ?>
        </span>
    </div>
    <button class="welcome-toggle" aria-label="<?php esc_attr_e('Toggle welcome message', 'athlete-dashboard'); ?>">
        <span class="toggle-icon" aria-hidden="true">&#9650;</span>
    </button>
</div> 