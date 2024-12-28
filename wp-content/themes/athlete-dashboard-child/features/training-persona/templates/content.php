<?php
/**
 * Training Persona Content Template
 * 
 * Main content template for the training persona feature.
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get user's training persona data
$user_id = get_current_user_id();
$training_level = get_user_meta($user_id, '_training_level', true);
$training_frequency = get_user_meta($user_id, '_training_frequency', true);
$training_goals = get_user_meta($user_id, '_training_goals', true);
$preferred_training_time = get_user_meta($user_id, '_preferred_training_time', true);
$additional_notes = get_user_meta($user_id, '_additional_notes', true);
?>

<div class="training-persona-feature">
    <header class="feature-header">
        <h1><?php _e('Training Persona', 'athlete-dashboard-child'); ?></h1>
        <p class="feature-description">
            <?php _e('Customize your training preferences and goals to get personalized workout recommendations.', 'athlete-dashboard-child'); ?>
        </p>
    </header>

    <div class="feature-content">
        <?php if ($training_level): ?>
            <div class="training-persona-summary">
                <div class="summary-section">
                    <h2><?php _e('Current Training Profile', 'athlete-dashboard-child'); ?></h2>
                    <dl class="summary-list">
                        <dt><?php _e('Training Level:', 'athlete-dashboard-child'); ?></dt>
                        <dd><?php echo esc_html(ucfirst($training_level)); ?></dd>

                        <dt><?php _e('Training Frequency:', 'athlete-dashboard-child'); ?></dt>
                        <dd><?php echo esc_html($training_frequency); ?> <?php _e('times per week', 'athlete-dashboard-child'); ?></dd>

                        <?php if ($preferred_training_time): ?>
                            <dt><?php _e('Preferred Time:', 'athlete-dashboard-child'); ?></dt>
                            <dd><?php echo esc_html(ucfirst($preferred_training_time)); ?></dd>
                        <?php endif; ?>
                    </dl>
                </div>

                <?php if ($training_goals): ?>
                    <div class="summary-section">
                        <h2><?php _e('Training Goals', 'athlete-dashboard-child'); ?></h2>
                        <ul class="goals-list">
                            <?php foreach ($training_goals as $goal): ?>
                                <li><?php echo esc_html(ucfirst(str_replace('_', ' ', $goal))); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if ($additional_notes): ?>
                    <div class="summary-section">
                        <h2><?php _e('Additional Notes', 'athlete-dashboard-child'); ?></h2>
                        <p><?php echo esc_html($additional_notes); ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="feature-actions">
                <button type="button" 
                        class="button button-primary"
                        data-modal-trigger="training-persona-modal">
                    <?php _e('Update Training Persona', 'athlete-dashboard-child'); ?>
                </button>
            </div>
        <?php else: ?>
            <div class="training-persona-empty">
                <p><?php _e('You haven\'t set up your training persona yet.', 'athlete-dashboard-child'); ?></p>
                <button type="button" 
                        class="button button-primary"
                        data-modal-trigger="training-persona-modal">
                    <?php _e('Set Up Training Persona', 'athlete-dashboard-child'); ?>
                </button>
            </div>
        <?php endif; ?>
    </div>
</div> 