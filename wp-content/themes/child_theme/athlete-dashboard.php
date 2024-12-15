<?php
/**
 * Template Name: Athlete Dashboard
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include required functions
require_once get_stylesheet_directory() . '/functions/dashboard-rendering.php';

get_header();

if (is_user_logged_in()) :
    $current_user = wp_get_current_user();
    ?>
    <div class="athlete-dashboard-container">
        <?php athlete_dashboard_render_welcome_banner($current_user); ?>
        <div class="athlete-dashboard">
            <?php echo athlete_dashboard_render_all_sections(); ?>
        </div>
    </div>
    <?php
else :
    athlete_dashboard_render_login_message();
endif;

get_footer();
