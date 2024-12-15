<?php
/**
 * Template for the Workout Manager Section
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

<div class="workout-manager-section">
    <!-- Current Workout Section -->
    <div class="current-workout-container">
        <h3><?php esc_html_e('Current Workout', 'athlete-dashboard'); ?></h3>
        <div class="current-workout-content">
            <?php do_action('athlete_dashboard_current_workout'); ?>
        </div>
    </div>

    <!-- Workout Logger Section -->
    <div class="workout-logger-container">
        <h3><?php esc_html_e('Log Workout', 'athlete-dashboard'); ?></h3>
        <?php 
        // Load the workout logger component
        do_action('athlete_dashboard_workout_logger'); 
        ?>
    </div>

    <!-- Upcoming Workouts Section -->
    <div class="upcoming-workouts-container">
        <h3><?php esc_html_e('Upcoming Workouts', 'athlete-dashboard'); ?></h3>
        <div class="upcoming-workouts-list">
            <?php do_action('athlete_dashboard_upcoming_workouts'); ?>
        </div>
    </div>

    <!-- Recent Workouts Section -->
    <div class="recent-workouts-container">
        <h3><?php esc_html_e('Recent Workouts', 'athlete-dashboard'); ?></h3>
        <div class="recent-workouts-list">
            <?php do_action('athlete_dashboard_recent_workouts'); ?>
        </div>
    </div>

    <!-- Workout Statistics Section -->
    <div class="workout-stats-container">
        <h3><?php esc_html_e('Workout Statistics', 'athlete-dashboard'); ?></h3>
        <div class="workout-stats-content">
            <?php do_action('athlete_dashboard_workout_stats'); ?>
        </div>
    </div>
</div> 