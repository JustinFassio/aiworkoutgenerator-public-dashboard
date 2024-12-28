<?php
/**
 * Profile Form Component
 * 
 * Handles rendering and validation of the profile form.
 */

namespace AthleteDashboard\Features\Profile\Components;

if (!defined('ABSPATH')) {
    exit;
}

class ProfileForm {
    private string $form_id;
    private array $fields;
    private array $data;
    private array $options;

    public function __construct(string $form_id, array $fields, array $data = [], array $options = []) {
        $this->form_id = $form_id;
        $this->fields = $fields;
        $this->data = $data;
        $this->options = array_merge([
            'context' => 'default',
            'submitText' => __('Submit', 'athlete-dashboard-child')
        ], $options);
    }

    public function render(): void {
        $form_id = esc_attr($this->form_id);
        $context = esc_attr($this->options['context']);
        ?>
        <form id="<?php echo $form_id; ?>" class="profile-form <?php echo $context; ?>-form" method="post">
            <?php wp_nonce_field('profile_nonce', 'profile_nonce'); ?>
            
            <div class="form-fields">
                <?php foreach ($this->fields as $field => $config): ?>
                    <?php $this->render_field($field, $config); ?>
                <?php endforeach; ?>
            </div>

            <div class="form-actions">
                <button type="submit" class="submit-button">
                    <?php echo esc_html($this->options['submitText']); ?>
                </button>
            </div>
        </form>
        <?php
    }

    private function render_field(string $field, array $config): void {
        $value = $this->data[$field] ?? '';
        $field_id = esc_attr($field);
        $required = !empty($config['required']);
        $label = esc_html($config['label']);
        $description = !empty($config['description']) ? esc_html($config['description']) : '';

        ?>
        <div class="form-field <?php echo $field_id; ?>-field">
            <label for="<?php echo $field_id; ?>" class="field-label">
                <?php echo $label; ?>
                <?php if ($required): ?>
                    <span class="required">*</span>
                <?php endif; ?>
            </label>

            <?php
            switch ($config['type']) {
                case 'text':
                case 'email':
                case 'tel':
                case 'number':
                    $this->render_input_field($field, $config, $value);
                    break;

                case 'textarea':
                    $this->render_textarea_field($field, $config, $value);
                    break;

                case 'select':
                    $this->render_select_field($field, $config, $value);
                    break;

                case 'multi_select':
                    $this->render_multi_select_field($field, $config, $value);
                    break;

                case 'height_with_unit':
                    $this->render_height_field($field, $config, $value);
                    break;

                case 'weight_with_unit':
                    $this->render_weight_field($field, $config, $value);
                    break;

                case 'tag_input':
                    $this->render_tag_input_field($field, $config, $value);
                    break;
            }

            if ($description): ?>
                <p class="field-description"><?php echo $description; ?></p>
            <?php endif; ?>
        </div>
        <?php
    }

    private function render_input_field(string $field, array $config, $value): void {
        $field_id = esc_attr($field);
        $type = esc_attr($config['type']);
        $required = !empty($config['required']) ? 'required' : '';
        $min = isset($config['min']) ? "min=\"{$config['min']}\"" : '';
        $max = isset($config['max']) ? "max=\"{$config['max']}\"" : '';
        $step = isset($config['step']) ? "step=\"{$config['step']}\"" : '';
        $pattern = isset($config['pattern']) ? "pattern=\"{$config['pattern']}\"" : '';
        
        ?>
        <input type="<?php echo $type; ?>" 
               id="<?php echo $field_id; ?>" 
               name="<?php echo $field_id; ?>" 
               value="<?php echo esc_attr($value); ?>"
               class="form-input"
               <?php echo $required; ?>
               <?php echo $min; ?>
               <?php echo $max; ?>
               <?php echo $step; ?>
               <?php echo $pattern; ?>>
        <?php
    }

    private function render_textarea_field(string $field, array $config, $value): void {
        $field_id = esc_attr($field);
        $required = !empty($config['required']) ? 'required' : '';
        $rows = isset($config['rows']) ? (int)$config['rows'] : 4;
        
        ?>
        <textarea id="<?php echo $field_id; ?>" 
                  name="<?php echo $field_id; ?>" 
                  class="form-textarea"
                  rows="<?php echo $rows; ?>"
                  <?php echo $required; ?>><?php echo esc_textarea($value); ?></textarea>
        <?php
    }

    private function render_select_field(string $field, array $config, $value): void {
        $field_id = esc_attr($field);
        $required = !empty($config['required']) ? 'required' : '';
        
        ?>
        <select id="<?php echo $field_id; ?>" 
                name="<?php echo $field_id; ?>" 
                class="form-select"
                <?php echo $required; ?>>
            <option value=""><?php _e('Select an option', 'athlete-dashboard-child'); ?></option>
            <?php foreach ($config['options'] as $option_value => $option_label): ?>
                <option value="<?php echo esc_attr($option_value); ?>" 
                        <?php selected($value, $option_value); ?>>
                    <?php echo esc_html($option_label); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php
    }

    private function render_multi_select_field(string $field, array $config, $value): void {
        $field_id = esc_attr($field);
        $required = !empty($config['required']) ? 'required' : '';
        $selected_values = is_array($value) ? $value : [];
        
        ?>
        <select id="<?php echo $field_id; ?>" 
                name="<?php echo $field_id; ?>[]" 
                class="form-multi-select"
                multiple
                <?php echo $required; ?>>
            <?php foreach ($config['options'] as $option_value => $option_label): ?>
                <option value="<?php echo esc_attr($option_value); ?>" 
                        <?php selected(in_array($option_value, $selected_values), true); ?>>
                    <?php echo esc_html($option_label); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php
    }

    private function render_height_field(string $field, array $config, $value): void {
        $field_id = esc_attr($field);
        $required = !empty($config['required']) ? 'required' : '';
        $current_unit = $this->data[$field . '_unit'] ?? 'imperial';
        
        ?>
        <div class="height-field-wrapper">
            <?php if ($current_unit === 'imperial'): ?>
                <select id="<?php echo $field_id; ?>" 
                        name="<?php echo $field_id; ?>" 
                        class="form-select height-select"
                        <?php echo $required; ?>>
                    <option value=""><?php _e('Select height', 'athlete-dashboard-child'); ?></option>
                    <?php foreach ($config['imperial_options'] as $option_value => $option_label): ?>
                        <option value="<?php echo esc_attr($option_value); ?>" 
                                <?php selected($value, $option_value); ?>>
                            <?php echo esc_html($option_label); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php else: ?>
                <input type="number" 
                       id="<?php echo $field_id; ?>" 
                       name="<?php echo $field_id; ?>" 
                       value="<?php echo esc_attr($value); ?>"
                       class="form-input height-input"
                       min="<?php echo esc_attr($config['min']); ?>"
                       max="<?php echo esc_attr($config['max']); ?>"
                       step="<?php echo esc_attr($config['step']); ?>"
                       <?php echo $required; ?>>
            <?php endif; ?>

            <select id="<?php echo $field_id; ?>_unit" 
                    name="<?php echo $field_id; ?>_unit" 
                    class="form-select unit-select">
                <?php foreach ($config['units'] as $unit_value => $unit_label): ?>
                    <option value="<?php echo esc_attr($unit_value); ?>" 
                            <?php selected($current_unit, $unit_value); ?>>
                        <?php echo esc_html(strtoupper($unit_label)); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php
    }

    private function render_weight_field(string $field, array $config, $value): void {
        $field_id = esc_attr($field);
        $required = !empty($config['required']) ? 'required' : '';
        $current_unit = $this->data[$field . '_unit'] ?? 'imperial';
        
        ?>
        <div class="weight-field-wrapper">
            <input type="number" 
                   id="<?php echo $field_id; ?>" 
                   name="<?php echo $field_id; ?>" 
                   value="<?php echo esc_attr($value); ?>"
                   class="form-input weight-input"
                   min="<?php echo esc_attr($config['min']); ?>"
                   max="<?php echo esc_attr($config['max']); ?>"
                   step="<?php echo esc_attr($config['step']); ?>"
                   <?php echo $required; ?>>

            <select id="<?php echo $field_id; ?>_unit" 
                    name="<?php echo $field_id; ?>_unit" 
                    class="form-select unit-select">
                <?php foreach ($config['units'] as $unit_value => $unit_label): ?>
                    <option value="<?php echo esc_attr($unit_value); ?>" 
                            <?php selected($current_unit, $unit_value); ?>>
                        <?php echo esc_html(strtoupper($unit_label)); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php
    }

    private function render_tag_input_field(string $field, array $config, $value): void {
        $field_id = esc_attr($field);
        $required = !empty($config['required']) ? 'required' : '';
        $tags = is_array($value) ? $value : [];
        
        ?>
        <div class="tag-input-wrapper" data-field="<?php echo $field_id; ?>">
            <div class="tag-input-container">
                <input type="text" 
                       class="tag-input"
                       placeholder="<?php echo esc_attr($config['placeholder'] ?? ''); ?>"
                       <?php echo $required; ?>>
                <button type="button" class="add-tag-button">
                    <?php _e('Add', 'athlete-dashboard-child'); ?>
                </button>
            </div>

            <div class="selected-tags">
                <?php foreach ($tags as $tag): ?>
                    <div class="tag-item" data-value="<?php echo esc_attr($tag['value']); ?>">
                        <span class="tag-label"><?php echo esc_html($tag['label']); ?></span>
                        <button type="button" class="remove-tag-button">&times;</button>
                        <input type="hidden" 
                               name="<?php echo $field_id; ?>[]" 
                               value="<?php echo esc_attr(json_encode($tag)); ?>">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
} 