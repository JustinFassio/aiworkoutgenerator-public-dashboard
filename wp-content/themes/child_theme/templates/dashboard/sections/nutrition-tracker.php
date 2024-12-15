<?php
/**
 * Template part for displaying the nutrition tracker
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

<div class="nutrition-tracker">
    <div class="nutrition-overview">
        <div class="nutrition-goals">
            <h3><?php esc_html_e('Nutrition Goals', 'athlete-dashboard'); ?></h3>
            <form id="nutrition-goals-form" class="custom-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="calories"><?php esc_html_e('Daily Calories', 'athlete-dashboard'); ?></label>
                        <input type="number" id="calories" name="calories" value="<?php echo esc_attr($nutrition_goals['calories']); ?>" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="protein"><?php esc_html_e('Protein (g)', 'athlete-dashboard'); ?></label>
                        <input type="number" id="protein" name="protein" value="<?php echo esc_attr($nutrition_goals['protein']); ?>" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="carbs"><?php esc_html_e('Carbs (g)', 'athlete-dashboard'); ?></label>
                        <input type="number" id="carbs" name="carbs" value="<?php echo esc_attr($nutrition_goals['carbs']); ?>" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="fat"><?php esc_html_e('Fat (g)', 'athlete-dashboard'); ?></label>
                        <input type="number" id="fat" name="fat" value="<?php echo esc_attr($nutrition_goals['fat']); ?>" min="0" required>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="primary-button">
                        <?php esc_html_e('Save Goals', 'athlete-dashboard'); ?>
                    </button>
                </div>
                <?php wp_nonce_field('nutrition_tracker_nonce', 'nutrition_nonce'); ?>
            </form>
        </div>

        <div class="daily-nutrition">
            <h3><?php esc_html_e('Daily Progress', 'athlete-dashboard'); ?></h3>
            <div class="date-selector">
                <input type="date" id="nutrition-date" value="<?php echo esc_attr(current_time('Y-m-d')); ?>">
            </div>
            <div class="macro-progress">
                <div class="macro-item">
                    <label><?php esc_html_e('Calories', 'athlete-dashboard'); ?></label>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <?php echo esc_attr(min(100, ($daily_totals['calories'] / $nutrition_goals['calories']) * 100)); ?>%"></div>
                    </div>
                    <div class="progress-text">
                        <span class="current"><?php echo esc_html($daily_totals['calories']); ?></span>
                        <span class="separator">/</span>
                        <span class="goal"><?php echo esc_html($nutrition_goals['calories']); ?></span>
                    </div>
                </div>
                <div class="macro-item">
                    <label><?php esc_html_e('Protein', 'athlete-dashboard'); ?></label>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <?php echo esc_attr(min(100, ($daily_totals['protein'] / $nutrition_goals['protein']) * 100)); ?>%"></div>
                    </div>
                    <div class="progress-text">
                        <span class="current"><?php echo esc_html($daily_totals['protein']); ?>g</span>
                        <span class="separator">/</span>
                        <span class="goal"><?php echo esc_html($nutrition_goals['protein']); ?>g</span>
                    </div>
                </div>
                <div class="macro-item">
                    <label><?php esc_html_e('Carbs', 'athlete-dashboard'); ?></label>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <?php echo esc_attr(min(100, ($daily_totals['carbs'] / $nutrition_goals['carbs']) * 100)); ?>%"></div>
                    </div>
                    <div class="progress-text">
                        <span class="current"><?php echo esc_html($daily_totals['carbs']); ?>g</span>
                        <span class="separator">/</span>
                        <span class="goal"><?php echo esc_html($nutrition_goals['carbs']); ?>g</span>
                    </div>
                </div>
                <div class="macro-item">
                    <label><?php esc_html_e('Fat', 'athlete-dashboard'); ?></label>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <?php echo esc_attr(min(100, ($daily_totals['fat'] / $nutrition_goals['fat']) * 100)); ?>%"></div>
                    </div>
                    <div class="progress-text">
                        <span class="current"><?php echo esc_html($daily_totals['fat']); ?>g</span>
                        <span class="separator">/</span>
                        <span class="goal"><?php echo esc_html($nutrition_goals['fat']); ?>g</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="nutrition-charts">
        <div class="chart-container">
            <canvas id="macro-distribution-chart"></canvas>
        </div>
        <div class="chart-container">
            <canvas id="weekly-calories-chart"></canvas>
        </div>
    </div>

    <div class="daily-meals">
        <h3><?php esc_html_e('Today\'s Meals', 'athlete-dashboard'); ?></h3>
        <div id="daily-meals-list">
            <!-- Meals will be loaded dynamically -->
        </div>
    </div>
</div> 