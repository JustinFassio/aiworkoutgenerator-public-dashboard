<?php
/**
 * Template part for displaying the workout logger form
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

<div class="workout-logger">
    <form id="workout-log-form" class="custom-form">
        <div class="form-row">
            <div class="form-group">
                <label for="workout_title"><?php esc_html_e('Workout Title', 'athlete-dashboard'); ?></label>
                <input type="text" id="workout_title" name="title" required>
            </div>
            <div class="form-group">
                <label for="workout_date"><?php esc_html_e('Date', 'athlete-dashboard'); ?></label>
                <input type="date" id="workout_date" name="date" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="workout_type"><?php esc_html_e('Workout Type', 'athlete-dashboard'); ?></label>
                <select id="workout_type" name="type" required>
                    <option value=""><?php esc_html_e('Select Type', 'athlete-dashboard'); ?></option>
                    <option value="strength"><?php esc_html_e('Strength Training', 'athlete-dashboard'); ?></option>
                    <option value="cardio"><?php esc_html_e('Cardio', 'athlete-dashboard'); ?></option>
                    <option value="hiit"><?php esc_html_e('HIIT', 'athlete-dashboard'); ?></option>
                    <option value="flexibility"><?php esc_html_e('Flexibility', 'athlete-dashboard'); ?></option>
                    <option value="other"><?php esc_html_e('Other', 'athlete-dashboard'); ?></option>
                </select>
            </div>
            <div class="form-group">
                <label for="workout_duration"><?php esc_html_e('Duration (minutes)', 'athlete-dashboard'); ?></label>
                <input type="number" id="workout_duration" name="duration" min="1" required>
            </div>
            <div class="form-group">
                <label for="workout_intensity"><?php esc_html_e('Intensity (1-10)', 'athlete-dashboard'); ?></label>
                <input type="number" id="workout_intensity" name="intensity" min="1" max="10" required>
            </div>
        </div>

        <div class="form-group">
            <label><?php esc_html_e('Exercises', 'athlete-dashboard'); ?></label>
            <div id="exercise-list">
                <!-- Exercise entries will be added here dynamically -->
            </div>
            <button type="button" id="add-exercise" class="secondary-button">
                <?php esc_html_e('Add Exercise', 'athlete-dashboard'); ?>
            </button>
        </div>

        <div class="form-group">
            <label for="workout_notes"><?php esc_html_e('Notes', 'athlete-dashboard'); ?></label>
            <textarea id="workout_notes" name="notes" rows="3"></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="primary-button">
                <?php esc_html_e('Log Workout', 'athlete-dashboard'); ?>
            </button>
        </div>
        <?php wp_nonce_field('workout_logger_nonce', 'workout_nonce'); ?>
    </form>

    <div class="workout-history">
        <h3><?php esc_html_e('Recent Workouts', 'athlete-dashboard'); ?></h3>
        <div id="workout-history-list">
            <!-- Workout history will be loaded here -->
        </div>
    </div>
</div>

<!-- Exercise Template -->
<template id="exercise-template">
    <div class="exercise-entry">
        <div class="form-row">
            <div class="form-group">
                <label><?php esc_html_e('Exercise Name', 'athlete-dashboard'); ?></label>
                <input type="text" name="exercises[][name]" required>
            </div>
            <div class="form-group">
                <label><?php esc_html_e('Sets', 'athlete-dashboard'); ?></label>
                <input type="number" name="exercises[][sets]" min="1" required>
            </div>
            <div class="form-group">
                <label><?php esc_html_e('Reps', 'athlete-dashboard'); ?></label>
                <input type="number" name="exercises[][reps]" min="1" required>
            </div>
            <div class="form-group">
                <label><?php esc_html_e('Weight (lbs)', 'athlete-dashboard'); ?></label>
                <input type="number" name="exercises[][weight]" step="0.5">
            </div>
            <div class="form-group">
                <button type="button" class="remove-exercise danger-button">
                    <?php esc_html_e('Remove', 'athlete-dashboard'); ?>
                </button>
            </div>
        </div>
        <div class="form-group">
            <label><?php esc_html_e('Notes', 'athlete-dashboard'); ?></label>
            <textarea name="exercises[][notes]" rows="2"></textarea>
        </div>
    </div>
</template> 