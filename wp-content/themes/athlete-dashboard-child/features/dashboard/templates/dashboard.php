<?php
/**
 * Template Name: Athlete Dashboard
 * Template Post Type: page
 */

use AthleteDashboard\Features\Dashboard\Components\Dashboard;
use AthleteDashboard\Features\Dashboard\Components\NavigationCards;
use AthleteDashboard\Features\Dashboard\Components\Modal;
use AthleteDashboard\Features\Profile\Components\Profile;

if (!defined('ABSPATH')) {
    exit;
}

require_once get_stylesheet_directory() . '/features/dashboard/index.php';
require_once get_stylesheet_directory() . '/features/profile/index.php';

$dashboard = new Dashboard();
$navigation = new NavigationCards();
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

                <?php $navigation->render(); ?>

                <?php
                // Render profile modal
                Modal::renderContainer('profile-modal', function() use ($profile) {
                    $profile->render_form();
                }, [
                    'size' => 'medium',
                    'title' => __('Your Profile', 'athlete-dashboard-child'),
                    'closeOnEscape' => true,
                    'closeOnBackdropClick' => true,
                    'showCloseButton' => true
                ]);
                ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?> 