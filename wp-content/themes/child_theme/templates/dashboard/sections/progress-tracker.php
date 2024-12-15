<?php
/**
 * Template part for displaying progress tracking
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

<div class="progress-section">
    <div class="progress-cards">
        <div class="progress-card">
            <h3><?php echo esc_html($title . ' ' . __('Progress', 'athlete-dashboard')); ?></h3>
            <div class="progress-chart-container">
                <canvas id="<?php echo esc_attr($chart_id); ?>"></canvas>
            </div>
        </div>
        <div class="progress-card">
            <h3><?php esc_html_e('Add New Entry', 'athlete-dashboard'); ?></h3>
            <form id="<?php echo esc_attr($form_id); ?>" class="progress-input-form custom-form">
                <div class="form-group">
                    <label for="<?php echo esc_attr($weight_field_name); ?>">
                        <?php echo esc_html($title); ?> <?php esc_html_e('Weight:', 'athlete-dashboard'); ?>
                    </label>
                    <div class="weight-input-group">
                        <input type="number" 
                            id="<?php echo esc_attr($weight_field_name); ?>" 
                            name="<?php echo esc_attr($weight_field_name); ?>" 
                            required 
                            step="0.1">
                        <select id="<?php echo esc_attr($weight_unit_field_name); ?>" 
                            name="<?php echo esc_attr($weight_unit_field_name); ?>">
                            <option value="kg"><?php esc_html_e('kg', 'athlete-dashboard'); ?></option>
                            <option value="lbs"><?php esc_html_e('lbs', 'athlete-dashboard'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="<?php echo esc_attr($form_id); ?>_date">
                        <?php esc_html_e('Date:', 'athlete-dashboard'); ?>
                    </label>
                    <input type="date" 
                        id="<?php echo esc_attr($form_id); ?>_date" 
                        name="date" 
                        required>
                </div>
                <div class="form-group">
                    <label for="<?php echo esc_attr($form_id); ?>_notes">
                        <?php esc_html_e('Notes:', 'athlete-dashboard'); ?>
                    </label>
                    <textarea id="<?php echo esc_attr($form_id); ?>_notes" 
                        name="notes" 
                        rows="3"></textarea>
                </div>
                <button type="submit" class="custom-button">
                    <?php esc_html_e('Add Progress', 'athlete-dashboard'); ?>
                </button>
                <?php wp_nonce_field('progress_tracker_nonce', $nonce_name); ?>
            </form>
        </div>
    </div>
    <div class="progress-history">
        <h3><?php esc_html_e('History', 'athlete-dashboard'); ?></h3>
        <div class="progress-table-container">
            <table class="progress-table">
                <thead>
                    <tr>
                        <th><?php esc_html_e('Date', 'athlete-dashboard'); ?></th>
                        <th><?php esc_html_e('Weight', 'athlete-dashboard'); ?></th>
                        <th><?php esc_html_e('Notes', 'athlete-dashboard'); ?></th>
                        <th><?php esc_html_e('Actions', 'athlete-dashboard'); ?></th>
                    </tr>
                </thead>
                <tbody id="<?php echo esc_attr($form_id); ?>_history">
                    <!-- Progress history will be loaded dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div> 