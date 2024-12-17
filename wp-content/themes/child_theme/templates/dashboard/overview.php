<?php
/**
 * Dashboard Overview Template
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$current_user = wp_get_current_user();
?>

<div class="dashboard-content">
    <!-- Overview Cards -->
    <div class="card-grid">
        <div class="dashboard-card" id="trailhead">
            <div class="card-header">
                <h3 class="card-title"><?php esc_html_e('Trailhead', 'athlete-dashboard'); ?></h3>
            </div>
            <div class="card-content">
                <?php echo do_shortcode('[user_overview]'); ?>
            </div>
        </div>

        <div class="dashboard-card" id="current-workout">
            <div class="card-header">
                <h3 class="card-title"><?php esc_html_e('Current Workout', 'athlete-dashboard'); ?></h3>
                <div class="card-actions">
                    <button type="button" class="btn btn-secondary refresh-card" data-card="current-workout">
                        <?php esc_html_e('Refresh', 'athlete-dashboard'); ?>
                    </button>
                </div>
            </div>
            <div class="card-content">
                <?php echo do_shortcode('[user_workouts]'); ?>
            </div>
        </div>
    </div>

    <!-- Progress Cards -->
    <div class="card-grid">
        <div class="dashboard-card" id="squat-progress">
            <div class="card-header">
                <h3 class="card-title"><?php esc_html_e('Squat Progress', 'athlete-dashboard'); ?></h3>
                <div class="card-actions">
                    <button type="button" class="btn btn-primary add-entry-button">
                        <?php esc_html_e('Add Entry', 'athlete-dashboard'); ?>
                    </button>
                </div>
            </div>
            <div class="card-content">
                <?php echo do_shortcode('[user_squat_progress]'); ?>
            </div>
        </div>

        <div class="dashboard-card" id="upcoming-workouts">
            <div class="card-header">
                <h3 class="card-title"><?php esc_html_e('Upcoming Workouts', 'athlete-dashboard'); ?></h3>
            </div>
            <div class="card-content">
                <?php echo do_shortcode('[user_upcoming_workouts]'); ?>
            </div>
        </div>
    </div>
</div> 