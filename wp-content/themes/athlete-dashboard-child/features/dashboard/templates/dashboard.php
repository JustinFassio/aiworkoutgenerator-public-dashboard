<?php
/**
 * Template Name: Athlete Dashboard
 * Template Post Type: page
 */

use AthleteDashboard\Features\Dashboard\Components\Dashboard;
use AthleteDashboard\Features\Profile\Components\Profile;

if (!defined('ABSPATH')) {
    exit;
}

require_once get_stylesheet_directory() . '/features/dashboard/components/Dashboard.php';
require_once get_stylesheet_directory() . '/features/profile/components/Profile.php';

$dashboard = new Dashboard();
$profile = new Profile();

get_header();
?>

<div id="main-content">
    <div class="container">
        <div id="content-area" class="clearfix">
            <div class="dashboard-container">
                <div class="dashboard-welcome">
                    <h1><?php echo esc_html__('Welcome to Your Fitness Dashboard', 'athlete-dashboard-child'); ?></h1>
                    <p><?php echo esc_html__('Track your workouts and monitor your fitness progress.', 'athlete-dashboard-child'); ?></p>
                </div>

                <div class="dashboard-sections">
                    <!-- Profile Section -->
                    <div class="dashboard-section">
                        <div class="section-header">
                            <h2><?php echo esc_html__('Your Profile', 'athlete-dashboard-child'); ?></h2>
                        </div>
                        <?php echo $profile->render_form(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?> 