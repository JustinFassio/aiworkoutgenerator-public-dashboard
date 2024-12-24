<?php
/**
 * Injury Tracking Form Template
 * 
 * @var array $injuries Current injury progress data
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="injury-tracking-form">
    <?php wp_nonce_field('injury_nonce', 'injury_nonce'); ?>

    <div class="form-group">
        <label for="injury_type">Type of Injury</label>
        <select id="injury_type" name="injury_type" required>
            <option value="">Select injury type</option>
            <option value="acute">Acute (Sudden onset)</option>
            <option value="chronic">Chronic (Long-term)</option>
            <option value="recurring">Recurring</option>
        </select>
    </div>

    <div class="form-group">
        <label for="injury_label">Injury Description</label>
        <div class="tag-input-container">
            <input type="text" 
                   id="injury_label" 
                   class="tag-input" 
                   placeholder="Type injury description and press Enter"
                   autocomplete="off">
            <div class="tag-suggestions"></div>
            <div class="tag-list"></div>
            <input type="hidden" name="injuries" value="<?php echo esc_attr(json_encode($injuries)); ?>">
        </div>
        <p class="description">Select from common injuries or type your own. Press Enter or comma to add.</p>
    </div>

    <div class="form-group">
        <label for="injury_details">Additional Details</label>
        <textarea id="injury_details" 
                  name="injury_details" 
                  class="auto-expand"
                  rows="3" 
                  maxlength="500"
                  placeholder="Provide more details about your injury..."></textarea>
        <p class="description">Include information about severity, duration, and any relevant medical history.</p>
    </div>

    <?php if (!empty($injuries)): ?>
        <div class="injury-progress">
            <h3>Current Injuries</h3>
            <?php foreach ($injuries as $injury): ?>
                <div class="injury-item" data-id="<?php echo esc_attr($injury['id']); ?>">
                    <div class="injury-header">
                        <span class="injury-label"><?php echo esc_html($injury['label']); ?></span>
                        <span class="injury-type"><?php echo esc_html($injury['type']); ?></span>
                    </div>
                    <div class="injury-description">
                        <?php echo esc_html($injury['description']); ?>
                    </div>
                    <div class="injury-meta">
                        <span class="injury-date">Updated: <?php echo esc_html($injury['updated_at']); ?></span>
                        <button type="button" class="delete-injury" aria-label="Delete injury">
                            <span class="dashicons dashicons-trash"></span>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="form-actions">
        <button type="submit" class="submit-button">
            <span class="button-text">Track Injury</span>
            <span class="button-loader" style="display: none;">
                <span class="dashicons dashicons-update-alt spin"></span>
                Saving...
            </span>
        </button>
    </div>

    <div class="form-messages"></div>
</div> 