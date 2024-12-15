<?php
/**
 * Template for displaying recent workouts
 *
 * @package AthleteDashboard
 * @var array $recent_workouts List of recent workouts
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

<div class="recent-workouts">
    <?php foreach ($recent_workouts as $workout) : ?>
        <div class="workout-card">
            <div class="workout-header">
                <div class="workout-info">
                    <h4 class="workout-date">
                        <?php echo esc_html(date_i18n('F j, Y', strtotime($workout['date']))); ?>
                    </h4>
                    <span class="workout-completion">
                        <?php 
                        if ($workout['completed']) {
                            printf(
                                '<span class="completion-status completed"><span class="dashicons dashicons-yes"></span> %s</span>',
                                esc_html__('Completed', 'athlete-dashboard')
                            );
                        } else {
                            printf(
                                '<span class="completion-status incomplete"><span class="dashicons dashicons-minus"></span> %s</span>',
                                esc_html__('Incomplete', 'athlete-dashboard')
                            );
                        }
                        ?>
                    </span>
                </div>
                <span class="workout-type"><?php echo esc_html($workout['type']); ?></span>
            </div>

            <div class="workout-summary">
                <?php if (!empty($workout['exercises'])) : ?>
                    <div class="exercise-stats">
                        <div class="stat-item">
                            <span class="stat-label"><?php esc_html_e('Exercises', 'athlete-dashboard'); ?></span>
                            <span class="stat-value"><?php echo count($workout['exercises']); ?></span>
                        </div>
                        <?php if (isset($workout['duration'])) : ?>
                            <div class="stat-item">
                                <span class="stat-label"><?php esc_html_e('Duration', 'athlete-dashboard'); ?></span>
                                <span class="stat-value"><?php echo esc_html($workout['duration']); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($workout['calories_burned'])) : ?>
                            <div class="stat-item">
                                <span class="stat-label"><?php esc_html_e('Calories', 'athlete-dashboard'); ?></span>
                                <span class="stat-value"><?php echo esc_html($workout['calories_burned']); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($workout['notes'])) : ?>
                    <div class="workout-notes">
                        <p><?php echo wp_kses_post($workout['notes']); ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="workout-actions">
                <button class="view-workout-button" data-workout-id="<?php echo esc_attr($workout['id']); ?>">
                    <span class="dashicons dashicons-visibility"></span>
                    <?php esc_html_e('View Details', 'athlete-dashboard'); ?>
                </button>
                <?php if (!$workout['completed']) : ?>
                    <button class="log-workout-button" data-workout-id="<?php echo esc_attr($workout['id']); ?>">
                        <span class="dashicons dashicons-edit"></span>
                        <?php esc_html_e('Log Workout', 'athlete-dashboard'); ?>
                    </button>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div> 