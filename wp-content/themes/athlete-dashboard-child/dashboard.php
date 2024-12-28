<?php
/**
 * Template Name: Dashboard
 * 
 * This template is used to render the athlete dashboard.
 */

get_header('minimal');

// Ensure user is logged in
if (!is_user_logged_in()) {
    wp_redirect(wp_login_url(get_permalink()));
    exit;
}
?>

<div id="dashboard-root"></div>

<?php get_footer('minimal'); ?> 