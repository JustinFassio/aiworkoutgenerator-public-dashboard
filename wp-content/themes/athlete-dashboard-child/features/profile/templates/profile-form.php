<?php
/**
 * Profile Form Template
 * 
 * @var array $fields Field definitions from ProfileData
 * @var array $data Current profile data
 * @var string $unit_preference Current unit preference
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<form id="profile-form" class="profile-form" data-unit-preference="<?php echo esc_attr($unit_preference); ?>">
    <?php wp_nonce_field('profile_nonce', 'profile_nonce'); ?>
    
    <?php foreach ($fields as $field => $config): ?>
        <?php
        // Skip hidden fields
        if (isset($config['hidden']) && $config['hidden']) {
            continue;
        }
        
        // Skip fields based on unit preference
        if (isset($config['group'])) {
            if ($config['group'] === 'height' && $unit_preference === 'metric' && $field !== 'height_cm') {
                continue;
            }
            if ($config['group'] === 'height' && $unit_preference === 'imperial' && $field === 'height_cm') {
                continue;
            }
            if ($config['group'] === 'weight' && $unit_preference === 'metric' && $field === 'weight_lbs') {
                continue;
            }
            if ($config['group'] === 'weight' && $unit_preference === 'imperial' && $field === 'weight_kg') {
                continue;
            }
        }
        ?>
        <div class="form-group" data-field="<?php echo esc_attr($field); ?>">
            <label for="<?php echo esc_attr($field); ?>">
                <?php echo esc_html($config['label']); ?>
                <?php if ($config['required']): ?>
                    <span class="required">*</span>
                <?php endif; ?>
            </label>

            <?php if ($config['type'] === 'select'): ?>
                <select name="<?php echo esc_attr($field); ?>" 
                        id="<?php echo esc_attr($field); ?>"
                        <?php echo $config['required'] ? 'required' : ''; ?>>
                    <option value="">Select <?php echo esc_html($config['label']); ?></option>
                    <?php foreach ($config['options'] as $value => $label): ?>
                        <option value="<?php echo esc_attr($value); ?>"
                                <?php selected($data[$field] ?? '', $value); ?>>
                            <?php echo esc_html($label); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

            <?php elseif ($config['type'] === 'equipment'): ?>
                <div class="equipment-selector">
                    <div class="equipment-options">
                        <select class="equipment-select" multiple>
                            <?php foreach ($config['options'] as $value => $label): ?>
                                <option value="<?php echo esc_attr($label); ?>">
                                    <?php echo esc_html($label); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="button" class="add-equipment">Add Selected</button>
                    </div>
                    <div class="equipment-input">
                        <textarea name="<?php echo esc_attr($field); ?>" 
                                 id="<?php echo esc_attr($field); ?>"
                                 class="equipment-list"
                                 placeholder="Your available equipment will appear here. Add custom equipment by typing and pressing Enter."
                                 <?php echo $config['required'] ? 'required' : ''; ?>><?php 
                            echo esc_textarea($data[$field] ?? ''); 
                        ?></textarea>
                    </div>
                </div>

            <?php else: ?>
                <input type="<?php echo esc_attr($config['type']); ?>"
                       name="<?php echo esc_attr($field); ?>"
                       id="<?php echo esc_attr($field); ?>"
                       value="<?php echo esc_attr($data[$field] ?? ''); ?>"
                       <?php echo $config['required'] ? 'required' : ''; ?>>
            <?php endif; ?>

            <?php if (!empty($config['description'])): ?>
                <p class="description"><?php echo esc_html($config['description']); ?></p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <button type="submit" class="submit-button">Save Profile</button>
</form> 