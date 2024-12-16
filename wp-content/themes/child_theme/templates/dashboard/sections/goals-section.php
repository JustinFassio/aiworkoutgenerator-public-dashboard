<?php
/**
 * Goals Section Template
 * 
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$user_id = get_current_user_id();
$goals_manager = new Athlete_Dashboard_Goals_Manager();
$active_goals = $goals_manager->get_active_goals($user_id);
$completed_goals = $goals_manager->get_completed_goals($user_id);
?>

<div class="goals-container">
    <div class="section-header">
        <h2><?php _e('Fitness Goals', 'athlete-dashboard'); ?></h2>
        <button class="add-goal-btn" data-action="add-goal">
            <?php _e('Add New Goal', 'athlete-dashboard'); ?>
        </button>
    </div>

    <div class="goals-content">
        <?php if (!empty($active_goals)) : ?>
            <div class="active-goals">
                <h3><?php _e('Active Goals', 'athlete-dashboard'); ?></h3>
                <div class="goals-grid">
                    <?php foreach ($active_goals as $goal) : ?>
                        <div class="goal-card" data-goal-id="<?php echo esc_attr($goal->ID); ?>">
                            <div class="goal-header">
                                <h4><?php echo esc_html($goal->post_title); ?></h4>
                                <span class="goal-type"><?php echo esc_html($goals_manager->get_goal_type($goal->ID)); ?></span>
                            </div>
                            
                            <div class="goal-progress">
                                <?php 
                                $progress = $goals_manager->get_goal_progress($goal->ID);
                                $target = $goals_manager->get_goal_target($goal->ID);
                                $percentage = ($target > 0) ? min(100, ($progress / $target) * 100) : 0;
                                ?>
                                <div class="progress-bar">
                                    <div class="progress" style="width: <?php echo esc_attr($percentage); ?>%"></div>
                                </div>
                                <div class="progress-text">
                                    <?php printf(__('%s of %s', 'athlete-dashboard'), 
                                        esc_html($progress), 
                                        esc_html($target)
                                    ); ?>
                                </div>
                            </div>
                            
                            <div class="goal-footer">
                                <span class="goal-deadline">
                                    <?php 
                                    $deadline = $goals_manager->get_goal_deadline($goal->ID);
                                    if ($deadline) {
                                        printf(__('Due by: %s', 'athlete-dashboard'), 
                                            esc_html(date_i18n(get_option('date_format'), strtotime($deadline)))
                                        );
                                    }
                                    ?>
                                </span>
                                <div class="goal-actions">
                                    <button class="edit-goal" data-action="edit-goal" data-goal-id="<?php echo esc_attr($goal->ID); ?>">
                                        <?php _e('Edit', 'athlete-dashboard'); ?>
                                    </button>
                                    <button class="update-progress" data-action="update-progress" data-goal-id="<?php echo esc_attr($goal->ID); ?>">
                                        <?php _e('Update Progress', 'athlete-dashboard'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else : ?>
            <div class="no-goals-message">
                <p><?php _e('You haven\'t set any goals yet. Click the button above to add your first goal!', 'athlete-dashboard'); ?></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($completed_goals)) : ?>
            <div class="completed-goals">
                <h3><?php _e('Completed Goals', 'athlete-dashboard'); ?></h3>
                <div class="goals-grid">
                    <?php foreach ($completed_goals as $goal) : ?>
                        <div class="goal-card completed" data-goal-id="<?php echo esc_attr($goal->ID); ?>">
                            <div class="goal-header">
                                <h4><?php echo esc_html($goal->post_title); ?></h4>
                                <span class="goal-type"><?php echo esc_html($goals_manager->get_goal_type($goal->ID)); ?></span>
                            </div>
                            
                            <div class="goal-completion">
                                <span class="completion-date">
                                    <?php 
                                    $completion_date = $goals_manager->get_goal_completion_date($goal->ID);
                                    printf(__('Completed on: %s', 'athlete-dashboard'), 
                                        esc_html(date_i18n(get_option('date_format'), strtotime($completion_date)))
                                    );
                                    ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Goal Form Template -->
<script type="text/template" id="goal-form-template">
    <form id="goal-form" class="goal-form">
        <div class="form-group">
            <label for="goal-title"><?php _e('Goal Title', 'athlete-dashboard'); ?></label>
            <input type="text" id="goal-title" name="title" required>
        </div>
        
        <div class="form-group">
            <label for="goal-type"><?php _e('Goal Type', 'athlete-dashboard'); ?></label>
            <select id="goal-type" name="type" required>
                <option value="weight"><?php _e('Weight Goal', 'athlete-dashboard'); ?></option>
                <option value="strength"><?php _e('Strength Goal', 'athlete-dashboard'); ?></option>
                <option value="cardio"><?php _e('Cardio Goal', 'athlete-dashboard'); ?></option>
                <option value="custom"><?php _e('Custom Goal', 'athlete-dashboard'); ?></option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="goal-target"><?php _e('Target Value', 'athlete-dashboard'); ?></label>
            <input type="number" id="goal-target" name="target" required>
        </div>
        
        <div class="form-group">
            <label for="goal-deadline"><?php _e('Deadline', 'athlete-dashboard'); ?></label>
            <input type="date" id="goal-deadline" name="deadline">
        </div>
        
        <div class="form-group">
            <label for="goal-description"><?php _e('Description', 'athlete-dashboard'); ?></label>
            <textarea id="goal-description" name="description"></textarea>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="save-goal"><?php _e('Save Goal', 'athlete-dashboard'); ?></button>
            <button type="button" class="cancel-goal"><?php _e('Cancel', 'athlete-dashboard'); ?></button>
        </div>
    </form>
</script>

<!-- Progress Update Form Template -->
<script type="text/template" id="progress-form-template">
    <form id="progress-form" class="progress-form">
        <div class="form-group">
            <label for="progress-value"><?php _e('Current Progress', 'athlete-dashboard'); ?></label>
            <input type="number" id="progress-value" name="progress" required>
        </div>
        
        <div class="form-group">
            <label for="progress-notes"><?php _e('Notes', 'athlete-dashboard'); ?></label>
            <textarea id="progress-notes" name="notes"></textarea>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="save-progress"><?php _e('Update Progress', 'athlete-dashboard'); ?></button>
            <button type="button" class="cancel-progress"><?php _e('Cancel', 'athlete-dashboard'); ?></button>
        </div>
    </form>
</script> 