<?php
/**
 * Training Persona Form Template
 * 
 * @var array $fields Field definitions from TrainingPersonaData
 * @var array $data Current training persona data
 * @var string $context Form context ('modal' or 'admin')
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<form id="training-persona-form" class="training-persona-form" data-form-context="<?php echo esc_attr($context); ?>">
    <?php wp_nonce_field('training_persona_nonce', 'training_persona_nonce'); ?>
    
    <div class="form-grid">
        <?php foreach ($fields as $field => $config): ?>
            <?php
            // Skip unit fields
            if (strpos($field, '_unit') !== false) continue;
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

                <?php elseif ($config['type'] === 'weight_with_unit'): ?>
                    <div class="measurement-group">
                        <?php 
                        $current_unit = $data[$field . '_unit'] ?? 'imperial';
                        $current_value = $data[$field] ?? '';
                        ?>
                        <input type="number" 
                               name="<?php echo esc_attr($field); ?>"
                               id="<?php echo esc_attr($field); ?>"
                               class="measurement-value"
                               value="<?php echo esc_attr($current_value); ?>"
                               step="0.1"
                               <?php echo $config['required'] ? 'required' : ''; ?>>
                        
                        <select name="<?php echo esc_attr($field); ?>_unit"
                                id="<?php echo esc_attr($field); ?>_unit"
                                class="unit-selector">
                            <?php foreach ($config['units'] as $unit_key => $unit_label): ?>
                                <option value="<?php echo esc_attr($unit_key); ?>"
                                        <?php selected($current_unit, $unit_key); ?>>
                                    <?php echo esc_html(strtoupper($unit_label)); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                <?php elseif ($config['type'] === 'textarea'): ?>
                    <textarea name="<?php echo esc_attr($field); ?>"
                             id="<?php echo esc_attr($field); ?>"
                             class="auto-expand"
                             rows="3"
                             <?php echo $config['required'] ? 'required' : ''; ?>><?php echo esc_textarea($data[$field] ?? ''); ?></textarea>

                <?php elseif ($config['type'] === 'tag_input'): ?>
                    <div class="tag-input-container">
                        <div class="tag-input-wrapper">
                            <div class="tag-list">
                                <?php
                                $current_tags = $data[$field] ?? [];
                                if (is_string($current_tags)) {
                                    $current_tags = json_decode(stripslashes($current_tags), true) ?? [];
                                }
                                if (!empty($current_tags) && is_array($current_tags)):
                                    foreach ($current_tags as $tag):
                                        if (isset($tag['label'])):
                                ?>
                                    <div class="tag-item" data-value='<?php echo esc_attr(json_encode($tag)); ?>'>
                                        <span class="tag-text"><?php echo esc_html($tag['label']); ?></span>
                                        <button type="button" class="remove-tag" aria-label="Remove <?php echo esc_attr($tag['label']); ?>">×</button>
                                    </div>
                                <?php
                                        endif;
                                    endforeach;
                                endif;
                                ?>
                            </div>
                            <input type="text" 
                                   class="tag-input" 
                                   placeholder="<?php echo esc_attr($config['placeholder'] ?? 'Type or select...'); ?>"
                                   autocomplete="off"
                                   aria-label="<?php echo esc_attr($config['aria_label'] ?? 'Add or select items'); ?>">
                        </div>
                        
                        <div class="tag-suggestions" role="listbox" aria-label="<?php echo esc_attr($config['label']); ?> suggestions">
                            <?php foreach ($config['predefined_options'] as $key => $label): ?>
                                <div class="tag-suggestion" 
                                     role="option"
                                     data-value="<?php echo esc_attr($key); ?>"
                                     data-type="predefined">
                                    <?php echo esc_html($label); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <input type="hidden" 
                               name="<?php echo esc_attr($field); ?>" 
                               id="<?php echo esc_attr($field); ?>"
                               value="<?php echo esc_attr(is_array($current_tags) ? json_encode($current_tags) : '[]'); ?>"
                               <?php echo !empty($config['required']) ? 'required' : ''; ?>>
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
    </div>

    <?php if ($context !== 'admin'): ?>
    <div class="form-actions">
        <button type="submit" class="submit-button">
            <span class="button-text">Save Training Persona</span>
            <span class="button-loader" style="display: none;">
                <span class="dashicons dashicons-update-alt spin"></span>
                Saving...
            </span>
        </button>
    </div>

    <div class="form-messages"></div>
    <?php endif; ?>
</form> 