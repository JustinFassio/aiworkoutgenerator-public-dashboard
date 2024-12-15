<?php
/**
 * Template for displaying the current workout
 *
 * @package AthleteDashboard
 * @var array $current_workout The current workout data
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

<div class="current-workout">
    <div class="workout-header">
        <div class="workout-title-section">
            <h4 class="workout-title"><?php echo esc_html($current_workout['title']); ?></h4>
            <span class="workout-type"><?php echo esc_html($current_workout['type']); ?></span>
        </div>
        <div class="workout-actions">
            <button class="view-workout-button" data-workout-id="<?php echo esc_attr($current_workout['id']); ?>">
                <span class="dashicons dashicons-visibility"></span>
                <?php esc_html_e('View Details', 'athlete-dashboard'); ?>
            </button>
            <button class="start-workout-button" data-workout-id="<?php echo esc_attr($current_workout['id']); ?>">
                <span class="dashicons dashicons-controls-play"></span>
                <?php esc_html_e('Start Workout', 'athlete-dashboard'); ?>
            </button>
        </div>
    </div>

    <?php if (!empty($current_workout['exercises'])) : ?>
        <div class="workout-preview">
            <h5><?php esc_html_e('Exercises Overview', 'athlete-dashboard'); ?></h5>
            <div class="exercise-preview-list">
                <?php foreach (array_slice($current_workout['exercises'], 0, 3) as $exercise) : ?>
                    <div class="exercise-preview-item">
                        <span class="exercise-name"><?php echo esc_html($exercise['name']); ?></span>
                        <span class="exercise-meta">
                            <?php 
                            printf(
                                esc_html__('%1$d sets × %2$d reps', 'athlete-dashboard'),
                                esc_html($exercise['sets']),
                                esc_html($exercise['reps'])
                            );
                            ?>
                        </span>
                    </div>
                <?php endforeach; ?>
                
                <?php if (count($current_workout['exercises']) > 3) : ?>
                    <div class="exercise-preview-more">
                        <?php 
                        printf(
                            esc_html__('+ %d more exercises', 'athlete-dashboard'),
                            count($current_workout['exercises']) - 3
                        );
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="workout-meta">
        <div class="meta-item">
            <span class="meta-label"><?php esc_html_e('Estimated Duration', 'athlete-dashboard'); ?></span>
            <span class="meta-value"><?php echo esc_html($current_workout['duration']); ?></span>
        </div>
        <div class="meta-item">
            <span class="meta-label"><?php esc_html_e('Intensity', 'athlete-dashboard'); ?></span>
            <span class="meta-value"><?php echo esc_html($current_workout['intensity']); ?></span>
        </div>
        <div class="meta-item">
            <span class="meta-label"><?php esc_html_e('Target Areas', 'athlete-dashboard'); ?></span>
            <span class="meta-value"><?php echo esc_html($current_workout['target_areas']); ?></span>
        </div>
    </div>

    <?php if (!empty($current_workout['notes'])) : ?>
        <div class="workout-notes">
            <h5><?php esc_html_e('Notes', 'athlete-dashboard'); ?></h5>
            <p><?php echo wp_kses_post($current_workout['notes']); ?></p>
        </div>
    <?php endif; ?>
</div> 