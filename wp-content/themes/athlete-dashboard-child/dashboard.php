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
            <div class="dashboard-container">
                <div class="dashboard-welcome">
                    <h1><?php echo esc_html__('Welcome to Your Fitness Dashboard', 'athlete-dashboard-child'); ?></h1>
                    <p><?php echo esc_html__('Track your workouts and monitor your fitness progress.', 'athlete-dashboard-child'); ?></p>
                </div>

                <div class="navigation-cards">
                    <?php
                    // Profile Card
                    ?>
                    <div class="nav-card" data-action="openModal" data-target="profile-modal">
                        <div class="card-icon">
                            <span class="dashicons dashicons-admin-users"></span>
                        </div>
                        <div class="card-content">
                            <h3><?php echo esc_html__('Profile', 'athlete-dashboard-child'); ?></h3>
                            <p><?php echo esc_html__('Update your personal information and preferences.', 'athlete-dashboard-child'); ?></p>
                        </div>
                    </div>

                    <?php
                    // Training Persona Card
                    ?>
                    <div class="nav-card" data-action="openModal" data-target="training-persona-modal">
                        <div class="card-icon">
                            <span class="dashicons dashicons-universal-access"></span>
                        </div>
                        <div class="card-content">
                            <h3><?php echo esc_html__('Training Persona', 'athlete-dashboard-child'); ?></h3>
                            <p><?php echo esc_html__('Set your training goals and preferences.', 'athlete-dashboard-child'); ?></p>
                        </div>
                    </div>
                </div>

                <?php
                // Profile Modal
                $profile = new AthleteDashboard\Features\Profile\Components\Profile();
                ?>
                <div id="profile-modal" class="dashboard-modal" data-size="medium">
                    <div class="modal-backdrop"></div>
                    <div class="modal-container">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2><?php echo esc_html__('Your Profile', 'athlete-dashboard-child'); ?></h2>
                                <button class="close-modal">
                                    <span class="dashicons dashicons-no-alt"></span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <?php $profile->render_form(); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                // Training Persona Modal
                ?>
                <div id="training-persona-modal" class="dashboard-modal" data-size="medium">
                    <div class="modal-backdrop"></div>
                    <div class="modal-container">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2><?php echo esc_html__('Training Persona', 'athlete-dashboard-child'); ?></h2>
                                <button class="close-modal">
                                    <span class="dashicons dashicons-no-alt"></span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <?php do_action('athlete_dashboard_training_persona_form'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?> 