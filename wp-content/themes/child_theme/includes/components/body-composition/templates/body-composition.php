<?php
/**
 * Body Composition Template
 * 
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$user_id = get_current_user_id();
?>

<div class="athlete-body-composition" id="athlete-body-composition">
    <div class="body-composition-header">
        <h2><?php _e('Body Composition Tracking', 'athlete-dashboard'); ?></h2>
        <div class="tracking-controls">
            <select id="metric-selector" class="metric-selector">
                <option value="weight"><?php _e('Weight', 'athlete-dashboard'); ?></option>
                <option value="body_fat"><?php _e('Body Fat %', 'athlete-dashboard'); ?></option>
                <option value="muscle_mass"><?php _e('Muscle Mass', 'athlete-dashboard'); ?></option>
                <option value="waist"><?php _e('Waist', 'athlete-dashboard'); ?></option>
            </select>
            <select id="period-selector" class="period-selector">
                <option value="7days"><?php _e('Last 7 Days', 'athlete-dashboard'); ?></option>
                <option value="30days" selected><?php _e('Last 30 Days', 'athlete-dashboard'); ?></option>
                <option value="90days"><?php _e('Last 90 Days', 'athlete-dashboard'); ?></option>
                <option value="12months"><?php _e('Last 12 Months', 'athlete-dashboard'); ?></option>
            </select>
            <button type="button" class="add-entry-button" id="add-entry-button">
                <?php _e('Add Entry', 'athlete-dashboard'); ?>
            </button>
        </div>
    </div>

    <div class="body-composition-content">
        <!-- Progress Chart -->
        <div class="chart-container">
            <canvas id="body-composition-chart"></canvas>
        </div>

        <!-- Summary Stats -->
        <div class="stats-summary">
            <div class="stat-card">
                <span class="stat-label"><?php _e('Current', 'athlete-dashboard'); ?></span>
                <span class="stat-value" id="current-value">-</span>
            </div>
            <div class="stat-card">
                <span class="stat-label"><?php _e('Change', 'athlete-dashboard'); ?></span>
                <span class="stat-value" id="total-change">-</span>
            </div>
            <div class="stat-card">
                <span class="stat-label"><?php _e('Average', 'athlete-dashboard'); ?></span>
                <span class="stat-value" id="average-value">-</span>
            </div>
        </div>

        <!-- Entry Form Modal -->
        <div class="modal" id="entry-modal">
            <div class="modal-content">
                <span class="close-button">&times;</span>
                <h3><?php _e('Add Body Composition Entry', 'athlete-dashboard'); ?></h3>
                <form id="body-composition-form">
                    <div class="form-group">
                        <label for="entry-date"><?php _e('Date', 'athlete-dashboard'); ?></label>
                        <input type="date" id="entry-date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="entry-weight"><?php _e('Weight (kg)', 'athlete-dashboard'); ?></label>
                        <input type="number" id="entry-weight" name="weight" step="0.1" min="0">
                    </div>
                    <div class="form-group">
                        <label for="entry-body-fat"><?php _e('Body Fat %', 'athlete-dashboard'); ?></label>
                        <input type="number" id="entry-body-fat" name="body_fat" step="0.1" min="0" max="100">
                    </div>
                    <div class="form-group">
                        <label for="entry-muscle-mass"><?php _e('Muscle Mass (kg)', 'athlete-dashboard'); ?></label>
                        <input type="number" id="entry-muscle-mass" name="muscle_mass" step="0.1" min="0">
                    </div>
                    <div class="form-group">
                        <label for="entry-waist"><?php _e('Waist (cm)', 'athlete-dashboard'); ?></label>
                        <input type="number" id="entry-waist" name="waist" step="0.1" min="0">
                    </div>
                    <div class="form-group">
                        <label for="entry-notes"><?php _e('Notes', 'athlete-dashboard'); ?></label>
                        <textarea id="entry-notes" name="notes"></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="save-button"><?php _e('Save Entry', 'athlete-dashboard'); ?></button>
                        <button type="button" class="cancel-button"><?php _e('Cancel', 'athlete-dashboard'); ?></button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Recent Entries Table -->
        <div class="recent-entries">
            <h3><?php _e('Recent Entries', 'athlete-dashboard'); ?></h3>
            <div class="table-container">
                <table class="entries-table">
                    <thead>
                        <tr>
                            <th><?php _e('Date', 'athlete-dashboard'); ?></th>
                            <th><?php _e('Weight', 'athlete-dashboard'); ?></th>
                            <th><?php _e('Body Fat %', 'athlete-dashboard'); ?></th>
                            <th><?php _e('Muscle Mass', 'athlete-dashboard'); ?></th>
                            <th><?php _e('Waist', 'athlete-dashboard'); ?></th>
                            <th><?php _e('Actions', 'athlete-dashboard'); ?></th>
                        </tr>
                    </thead>
                    <tbody id="entries-table-body">
                        <!-- Entries will be populated via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 