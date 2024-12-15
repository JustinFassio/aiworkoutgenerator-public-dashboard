<?php
/**
 * Template for the Workout Detail Component
 * 
 * @var array $workout_data Contains the workout information to display
 */

if (!defined('ABSPATH')) exit;
?>

<div class="workout-detail">
    <div class="workout-detail__header">
        <h2 class="workout-detail__title"><?php echo esc_html($workout_data['title']); ?></h2>
        <p class="workout-detail__date"><?php echo esc_html($workout_data['date']); ?></p>
    </div>

    <div class="workout-detail__meta">
        <div class="workout-detail__type">
            <span class="workout-detail__label"><?php esc_html_e('Type', 'athlete-dashboard'); ?></span>
            <p class="workout-detail__value"><?php echo esc_html($workout_data['type'] ?: __('Standard', 'athlete-dashboard')); ?></p>
        </div>
    </div>

    <div class="workout-detail__content">
        <h3 class="workout-detail__subtitle"><?php esc_html_e('Exercises', 'athlete-dashboard'); ?></h3>
        
        <?php if (!empty($workout_data['exercises'])): ?>
            <div class="workout-detail__exercises">
                <?php foreach ($workout_data['exercises'] as $exercise): ?>
                    <div class="workout-detail__exercise">
                        <h4 class="workout-detail__exercise-name">
                            <?php echo esc_html($exercise['name']); ?>
                        </h4>
                        <div class="workout-detail__exercise-details">
                            <?php if (!empty($exercise['sets'])): ?>
                                <span class="workout-detail__exercise-sets">
                                    <?php echo esc_html(sprintf(__('Sets: %s', 'athlete-dashboard'), $exercise['sets'])); ?>
                                </span>
                            <?php endif; ?>
                            
                            <?php if (!empty($exercise['reps'])): ?>
                                <span class="workout-detail__exercise-reps">
                                    <?php echo esc_html(sprintf(__('Reps: %s', 'athlete-dashboard'), $exercise['reps'])); ?>
                                </span>
                            <?php endif; ?>
                            
                            <?php if (!empty($exercise['weight'])): ?>
                                <span class="workout-detail__exercise-weight">
                                    <?php echo esc_html(sprintf(__('Weight: %s', 'athlete-dashboard'), $exercise['weight'])); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($exercise['notes'])): ?>
                            <p class="workout-detail__exercise-notes">
                                <?php echo esc_html($exercise['notes']); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="workout-detail__no-exercises">
                <?php esc_html_e('No exercises found for this workout.', 'athlete-dashboard'); ?>
            </p>
        <?php endif; ?>
    </div>

    <div class="workout-detail__actions">
        <button type="button" class="button print-workout">
            <?php esc_html_e('Print Workout', 'athlete-dashboard'); ?>
        </button>
        <button type="button" class="button close-detail">
            <?php esc_html_e('Close', 'athlete-dashboard'); ?>
        </button>
    </div>
</div> 