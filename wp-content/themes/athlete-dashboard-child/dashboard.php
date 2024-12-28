<?php
/**
 * Template Name: Dashboard
 * Template Post Type: page
 * 
 * This is the main dashboard template that serves as a container for all dashboard features.
 */

if (!defined('ABSPATH')) {
    exit;
}

// Load required features
require_once get_stylesheet_directory() . '/features/profile/index.php';
require_once get_stylesheet_directory() . '/features/training-persona/index.php';

get_header();
?>

<div id="main-content">
    <div class="container">
        <div id="content-area" class="clearfix">
            <div class="athlete-dashboard">
                <div class="athlete-dashboard__header">
                    <div class="athlete-dashboard__header-content">
                        <h1><?php echo esc_html__('Welcome to Your Fitness Dashboard', 'athlete-dashboard-child'); ?></h1>
                    </div>
                    <p><?php echo esc_html__('Track your workouts and monitor your fitness progress.', 'athlete-dashboard-child'); ?></p>
                </div>

                <div class="athlete-dashboard__content">
                    <div class="navigation-cards">
                        <div class="nav-card" data-modal-trigger="profile-modal">
                            <div class="card-icon">
                                <span class="dashicons dashicons-admin-users"></span>
                            </div>
                            <div class="card-content">
                                <h3><?php echo esc_html__('Profile', 'athlete-dashboard-child'); ?></h3>
                                <p><?php echo esc_html__('Update your personal information and preferences.', 'athlete-dashboard-child'); ?></p>
                            </div>
                        </div>

                        <div class="nav-card" data-modal-trigger="training-persona-modal">
                            <div class="card-icon">
                                <span class="dashicons dashicons-universal-access"></span>
                            </div>
                            <div class="card-content">
                                <h3><?php echo esc_html__('Training Persona', 'athlete-dashboard-child'); ?></h3>
                                <p><?php echo esc_html__('Set your training goals and preferences.', 'athlete-dashboard-child'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?> 