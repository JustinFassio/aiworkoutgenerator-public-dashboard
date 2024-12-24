<?php
/**
 * Goal Tracking Template
 * 
 * Displays goal progress tracking interface.
 */

if (!defined('ABSPATH')) {
    exit;
}

$goals = isset($goals) ? $goals : [];
?>

<div class="goal-tracking-container">
    <div class="goal-tracking-messages"></div>
    
    <?php if (!empty($goals)): ?>
        <div class="goals-list">
            <?php foreach ($goals as $goal): ?>
                <div class="goal-item" data-goal-id="<?php echo esc_attr($goal['id']); ?>">
                    <div class="goal-header">
                        <h4 class="goal-title"><?php echo esc_html($goal['label']); ?></h4>
                        <div class="goal-progress-input-container">
                            <input type="number"
                                   class="goal-progress-input"
                                   data-goal-id="<?php echo esc_attr($goal['id']); ?>"
                                   min="0"
                                   max="100"
                                   value="<?php echo esc_attr($goal['progress'] ?? 0); ?>"
                            >
                            <span class="progress-unit">%</span>
                        </div>
                    </div>
                    
                    <div class="goal-progress-bar">
                        <div class="progress-track">
                            <div class="progress-fill" 
                                 id="goal-progress-<?php echo esc_attr($goal['id']); ?>"
                                 style="width: <?php echo esc_attr($goal['progress'] ?? 0); ?>%">
                            </div>
                        </div>
                    </div>
                    
                    <?php if (!empty($goal['description'])): ?>
                        <div class="goal-description">
                            <?php echo wp_kses_post($goal['description']); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="no-goals-message">
            <?php _e('No goals have been set yet. Add goals in your Training Persona to start tracking progress.', 'athlete-dashboard-child'); ?>
        </div>
    <?php endif; ?>
</div> 