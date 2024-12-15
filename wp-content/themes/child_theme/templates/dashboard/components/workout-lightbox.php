<?php
/**
 * Template for the Workout Lightbox Component
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

<div class="workout-lightbox-overlay">
    <div class="workout-lightbox-content">
        <!-- Edit mode indicator -->
        <div class="edit-mode-indicator hidden">
            <span class="dashicons dashicons-edit"></span>
            <?php esc_html_e('Edit Mode', 'athlete-dashboard'); ?>
        </div>

        <!-- Loading state -->
        <div class="workout-lightbox-loading">
            <div class="loading-spinner"></div>
            <p><?php esc_html_e('Loading workout details...', 'athlete-dashboard'); ?></p>
        </div>

        <!-- Main content container - populated by JavaScript -->
        <div class="workout-content-container hidden">
            <!-- Header section -->
            <div class="workout-lightbox-header">
                <h2 class="workout-lightbox-title"></h2>
                <p class="workout-lightbox-date"></p>
            </div>

            <!-- Details section -->
            <div class="workout-lightbox-details">
                <div class="workout-lightbox-detail">
                    <span class="workout-lightbox-detail-label"><?php esc_html_e('Type', 'athlete-dashboard'); ?></span>
                    <p class="workout-lightbox-detail-value"></p>
                </div>
            </div>

            <!-- Exercises section -->
            <div class="workout-lightbox-exercises">
                <h3 class="workout-lightbox-subtitle"><?php esc_html_e('Exercises', 'athlete-dashboard'); ?></h3>
                <div class="exercise-list"></div>
            </div>

            <!-- Content section -->
            <div class="workout-content"></div>

            <!-- Button container -->
            <div class="modal-button-container">
                <button class="edit-workout hidden">
                    <span class="dashicons dashicons-edit"></span>
                    <?php esc_html_e('Edit', 'athlete-dashboard'); ?>
                </button>
                <button class="save-workout hidden">
                    <span class="dashicons dashicons-saved"></span>
                    <?php esc_html_e('Save', 'athlete-dashboard'); ?>
                </button>
                <button class="add-exercise hidden">
                    <span class="dashicons dashicons-plus"></span>
                    <?php esc_html_e('Add Exercise', 'athlete-dashboard'); ?>
                </button>
                <button class="print-workout">
                    <span class="dashicons dashicons-printer"></span>
                    <?php esc_html_e('Print', 'athlete-dashboard'); ?>
                </button>
                <button class="workout-lightbox-close">
                    <span class="dashicons dashicons-no-alt"></span>
                    <?php esc_html_e('Close', 'athlete-dashboard'); ?>
                </button>
            </div>
        </div>

        <!-- Error state -->
        <div class="workout-lightbox-error hidden">
            <p class="error-message"></p>
            <button class="workout-lightbox-close">
                <span class="dashicons dashicons-no-alt"></span>
                <?php esc_html_e('Close', 'athlete-dashboard'); ?>
            </button>
        </div>

        <!-- Message states -->
        <div class="save-success-message hidden"></div>
        <div class="save-error-message hidden"></div>
    </div>
</div> 