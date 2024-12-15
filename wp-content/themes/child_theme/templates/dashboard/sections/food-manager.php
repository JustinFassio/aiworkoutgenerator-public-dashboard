<?php
/**
 * Template part for displaying the food manager
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

<div class="food-manager">
    <div class="food-manager-header">
        <h3><?php esc_html_e('Food Database', 'athlete-dashboard'); ?></h3>
        <button type="button" class="primary-button" id="add-food-button">
            <?php esc_html_e('Add New Food', 'athlete-dashboard'); ?>
        </button>
    </div>

    <!-- Add/Edit Food Form -->
    <div class="food-form-container" style="display: none;">
        <form id="food-form" class="custom-form">
            <input type="hidden" name="food_id" id="food-id">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="food-name"><?php esc_html_e('Food Name', 'athlete-dashboard'); ?></label>
                    <input type="text" id="food-name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="serving-size"><?php esc_html_e('Serving Size', 'athlete-dashboard'); ?></label>
                    <input type="text" id="serving-size" name="serving_size" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="calories"><?php esc_html_e('Calories', 'athlete-dashboard'); ?></label>
                    <input type="number" id="calories" name="calories" min="0" required>
                </div>
                <div class="form-group">
                    <label for="protein"><?php esc_html_e('Protein (g)', 'athlete-dashboard'); ?></label>
                    <input type="number" id="protein" name="protein" min="0" step="0.1" required>
                </div>
                <div class="form-group">
                    <label for="carbs"><?php esc_html_e('Carbs (g)', 'athlete-dashboard'); ?></label>
                    <input type="number" id="carbs" name="carbs" min="0" step="0.1" required>
                </div>
                <div class="form-group">
                    <label for="fat"><?php esc_html_e('Fat (g)', 'athlete-dashboard'); ?></label>
                    <input type="number" id="fat" name="fat" min="0" step="0.1" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="is_public" id="is-public">
                        <?php esc_html_e('Make this food public (visible to all users)', 'athlete-dashboard'); ?>
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="primary-button">
                    <?php esc_html_e('Save Food', 'athlete-dashboard'); ?>
                </button>
                <button type="button" class="secondary-button cancel-food-form">
                    <?php esc_html_e('Cancel', 'athlete-dashboard'); ?>
                </button>
            </div>
        </form>
    </div>

    <!-- Foods List -->
    <div class="foods-list">
        <?php if (empty($user_foods)) : ?>
            <p class="no-foods"><?php esc_html_e('No foods found. Add your first food item!', 'athlete-dashboard'); ?></p>
        <?php else : ?>
            <div class="foods-grid">
                <div class="foods-header">
                    <div class="food-col"><?php esc_html_e('Food Name', 'athlete-dashboard'); ?></div>
                    <div class="food-col"><?php esc_html_e('Serving Size', 'athlete-dashboard'); ?></div>
                    <div class="food-col"><?php esc_html_e('Calories', 'athlete-dashboard'); ?></div>
                    <div class="food-col"><?php esc_html_e('Protein', 'athlete-dashboard'); ?></div>
                    <div class="food-col"><?php esc_html_e('Carbs', 'athlete-dashboard'); ?></div>
                    <div class="food-col"><?php esc_html_e('Fat', 'athlete-dashboard'); ?></div>
                    <div class="food-col actions"><?php esc_html_e('Actions', 'athlete-dashboard'); ?></div>
                </div>
                <?php foreach ($user_foods as $food) : ?>
                    <div class="food-item" data-food-id="<?php echo esc_attr($food['id']); ?>">
                        <div class="food-col"><?php echo esc_html($food['name']); ?></div>
                        <div class="food-col"><?php echo esc_html($food['serving_size']); ?></div>
                        <div class="food-col"><?php echo esc_html($food['calories']); ?></div>
                        <div class="food-col"><?php echo esc_html($food['protein']); ?>g</div>
                        <div class="food-col"><?php echo esc_html($food['carbs']); ?>g</div>
                        <div class="food-col"><?php echo esc_html($food['fat']); ?>g</div>
                        <div class="food-col actions">
                            <button type="button" class="edit-food secondary-button" title="<?php esc_attr_e('Edit', 'athlete-dashboard'); ?>">
                                <span class="dashicons dashicons-edit"></span>
                            </button>
                            <button type="button" class="delete-food danger-button" title="<?php esc_attr_e('Delete', 'athlete-dashboard'); ?>">
                                <span class="dashicons dashicons-trash"></span>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div> 