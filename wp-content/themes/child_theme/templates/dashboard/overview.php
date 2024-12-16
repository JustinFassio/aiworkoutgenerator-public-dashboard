<?php
/**
 * Dashboard Overview Template
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$current_user = wp_get_current_user();
?>

<div class="dashboard-section overview-section">
    <h2>Trailhead</h2>
    <div class="overview-content">
        <?php echo do_shortcode('[user_overview]'); ?>
    </div>
</div>

<div class="dashboard-section current-workout-section">
    <h2>Current Workout</h2>
    <div class="current-workout-content">
        <?php echo do_shortcode('[user_workouts]'); ?>
    </div>
</div>

<div class="dashboard-section log-workout-section">
    <h2>Log Workout</h2>
    <div class="log-workout-content">
        <?php echo do_shortcode('[athlete_dashboard_log_workout_content]'); ?>
    </div>
</div>

<div class="dashboard-section upcoming-workouts-section">
    <h2>Upcoming Workouts</h2>
    <div class="upcoming-workouts-content">
        <?php echo do_shortcode('[user_upcoming_workouts]'); ?>
    </div>
</div> 