<?php
/**
 * Template part for displaying the nutrition logger
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

<div class="nutrition-logger">
    <div class="meal-log-form">
        <h3><?php esc_html_e('Log a Meal', 'athlete-dashboard'); ?></h3>
        <form id="meal-log-form" class="custom-form">
            <div class="form-row">
                <div class="form-group">
                    <label for="meal-type"><?php esc_html_e('Meal Type', 'athlete-dashboard'); ?></label>
                    <select id="meal-type" name="meal_type" required>
                        <option value="breakfast"><?php esc_html_e('Breakfast', 'athlete-dashboard'); ?></option>
                        <option value="lunch"><?php esc_html_e('Lunch', 'athlete-dashboard'); ?></option>
                        <option value="dinner"><?php esc_html_e('Dinner', 'athlete-dashboard'); ?></option>
                        <option value="snack"><?php esc_html_e('Snack', 'athlete-dashboard'); ?></option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="meal-date"><?php esc_html_e('Date', 'athlete-dashboard'); ?></label>
                    <input type="date" id="meal-date" name="meal_date" value="<?php echo esc_attr(current_time('Y-m-d')); ?>" required>
                </div>
            </div>

            <div class="foods-container">
                <h4><?php esc_html_e('Add Foods', 'athlete-dashboard'); ?></h4>
                <div class="food-search">
                    <div class="form-group">
                        <label for="food-search"><?php esc_html_e('Search Foods', 'athlete-dashboard'); ?></label>
                        <input type="text" id="food-search" placeholder="<?php esc_attr_e('Start typing to search...', 'athlete-dashboard'); ?>">
                    </div>
                    <button type="button" class="secondary-button" id="manage-foods-button">
                        <?php esc_html_e('Manage Foods', 'athlete-dashboard'); ?>
                    </button>
                </div>

                <div class="selected-foods">
                    <div class="selected-foods-header">
                        <div class="food-col"><?php esc_html_e('Food', 'athlete-dashboard'); ?></div>
                        <div class="food-col"><?php esc_html_e('Serving Size', 'athlete-dashboard'); ?></div>
                        <div class="food-col"><?php esc_html_e('Servings', 'athlete-dashboard'); ?></div>
                        <div class="food-col"><?php esc_html_e('Calories', 'athlete-dashboard'); ?></div>
                        <div class="food-col"><?php esc_html_e('Protein', 'athlete-dashboard'); ?></div>
                        <div class="food-col"><?php esc_html_e('Carbs', 'athlete-dashboard'); ?></div>
                        <div class="food-col"><?php esc_html_e('Fat', 'athlete-dashboard'); ?></div>
                        <div class="food-col actions"><?php esc_html_e('Actions', 'athlete-dashboard'); ?></div>
                    </div>
                    <div id="selected-foods-list">
                        <!-- Selected foods will be added here dynamically -->
                    </div>
                </div>

                <div class="meal-totals">
                    <h4><?php esc_html_e('Meal Totals', 'athlete-dashboard'); ?></h4>
                    <div class="totals-grid">
                        <div class="total-item">
                            <label><?php esc_html_e('Calories', 'athlete-dashboard'); ?></label>
                            <span id="total-calories">0</span>
                        </div>
                        <div class="total-item">
                            <label><?php esc_html_e('Protein', 'athlete-dashboard'); ?></label>
                            <span id="total-protein">0</span>g
                        </div>
                        <div class="total-item">
                            <label><?php esc_html_e('Carbs', 'athlete-dashboard'); ?></label>
                            <span id="total-carbs">0</span>g
                        </div>
                        <div class="total-item">
                            <label><?php esc_html_e('Fat', 'athlete-dashboard'); ?></label>
                            <span id="total-fat">0</span>g
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="meal-notes"><?php esc_html_e('Notes', 'athlete-dashboard'); ?></label>
                    <textarea id="meal-notes" name="notes" rows="3"></textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="primary-button">
                    <?php esc_html_e('Log Meal', 'athlete-dashboard'); ?>
                </button>
            </div>
        </form>
    </div>

    <div class="meal-history">
        <h3><?php esc_html_e('Recent Meals', 'athlete-dashboard'); ?></h3>
        <div id="meal-history-list">
            <!-- Meal history will be loaded dynamically -->
        </div>
    </div>

    <!-- Food Manager Modal -->
    <div id="food-manager-modal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3><?php esc_html_e('Manage Foods', 'athlete-dashboard'); ?></h3>
                <button type="button" class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <?php
                $food_manager = new Athlete_Dashboard_Food_Manager();
                $food_manager->render();
                ?>
            </div>
        </div>
    </div>
</div> 