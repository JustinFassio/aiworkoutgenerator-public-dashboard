<?php
/**
 * Template for displaying upcoming workouts
 *
 * @package AthleteDashboard
 * @var array $upcoming_workouts List of upcoming workouts
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

<div class="upcoming-workouts">
    <?php foreach ($upcoming_workouts as $workout) : ?>
        <div class="workout-card">
            <div class="workout-header">
                <div class="workout-info">
                    <h4 class="workout-date">
                        <?php echo esc_html(date_i18n('l, F j', strtotime($workout['date']))); ?>
                    </h4>
                    <span class="workout-time">
                        <?php echo esc_html(date_i18n('g:i a', strtotime($workout['time']))); ?>
                    </span>
                </div>
                <span class="workout-type"><?php echo esc_html($workout['type']); ?></span>
            </div>

            <div class="workout-preview">
                <?php if (!empty($workout['exercises'])) : ?>
                    <div class="exercise-count">
                        <?php 
                        printf(
                            esc_html(_n('%d exercise', '%d exercises', count($workout['exercises']), 'athlete-dashboard')),
                            count($workout['exercises'])
                        );
                        ?>
                    </div>
                    <div class="exercise-preview">
                        <?php 
                        $preview_exercises = array_slice($workout['exercises'], 0, 2);
                        echo esc_html(implode(', ', array_column($preview_exercises, 'name')));
                        if (count($workout['exercises']) > 2) {
                            echo esc_html(sprintf(__(' and %d more', 'athlete-dashboard'), count($workout['exercises']) - 2));
                        }
                        ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="workout-actions">
                <button class="view-workout-button" data-workout-id="<?php echo esc_attr($workout['id']); ?>">
                    <span class="dashicons dashicons-visibility"></span>
                    <?php esc_html_e('View Details', 'athlete-dashboard'); ?>
                </button>
                <?php if (isset($workout['can_reschedule']) && $workout['can_reschedule']) : ?>
                    <button class="reschedule-workout-button" data-workout-id="<?php echo esc_attr($workout['id']); ?>">
                        <span class="dashicons dashicons-calendar-alt"></span>
                        <?php esc_html_e('Reschedule', 'athlete-dashboard'); ?>
                    </button>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div> 