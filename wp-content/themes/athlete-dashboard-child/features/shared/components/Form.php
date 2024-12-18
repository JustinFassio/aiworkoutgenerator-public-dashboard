<?php
/**
 * Form Component
 * 
 * A reusable form builder component that can be used across features.
 */

namespace AthleteDashboard\Features\Shared\Components;

if (!defined('ABSPATH')) {
    exit;
}

class Form {
    private string $id;
    private array $fields;
    private array $data;
    private array $options;

    public function __construct(string $id, array $fields = [], array $data = [], array $options = []) {
        $this->id = $id;
        $this->fields = $fields;
        $this->data = $data;
        $this->options = array_merge([
            'context' => 'default',
            'submitText' => 'Save',
            'showLoader' => true,
            'classes' => [],
            'attributes' => []
        ], $options);
    }

    public function render(): void {
        $form_classes = array_merge(['dynamic-form'], $this->options['classes']);
        if ($this->options['context']) {
            $form_classes[] = "form-context-{$this->options['context']}";
        }
        ?>
        <form id="<?php echo esc_attr($this->id); ?>" 
              class="<?php echo esc_attr(implode(' ', $form_classes)); ?>"
              <?php foreach ($this->options['attributes'] as $attr => $value): ?>
                  <?php echo esc_attr($attr); ?>="<?php echo esc_attr($value); ?>"
              <?php endforeach; ?>
        >
            <?php if ($this->options['context'] === 'modal'): ?>
                <?php wp_nonce_field($this->id . '_nonce', $this->id . '_nonce'); ?>
            <?php endif; ?>
            
            <div class="form-grid">
                <?php foreach ($this->fields as $field => $config): ?>
                    <?php if (isset($config['type'])): ?>
                        <?php $this->renderField($field, $config); ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <div class="form-actions">
                <button type="submit" class="submit-button">
                    <span class="button-text"><?php echo esc_html($this->options['submitText']); ?></span>
                    <?php if ($this->options['showLoader']): ?>
                        <span class="button-loader" style="display: none;">
                            <span class="dashicons dashicons-update-alt spin"></span>
                            Saving...
                        </span>
                    <?php endif; ?>
                </button>
            </div>

            <div class="form-messages"></div>
        </form>
        <?php
    }

    private function renderField(string $field, array $config): void {
        $value = $this->data[$field] ?? '';
        ?>
        <div class="form-group" data-field="<?php echo esc_attr($field); ?>">
            <label for="<?php echo esc_attr($field); ?>">
                <?php echo esc_html($config['label']); ?>
                <?php if (!empty($config['required'])): ?>
                    <span class="required">*</span>
                <?php endif; ?>
            </label>

            <?php
            switch ($config['type']) {
                case 'select':
                    $this->renderSelect($field, $config, $value);
                    break;
                case 'height_with_unit':
                    $this->renderHeightWithUnit($field, $config, $value);
                    break;
                case 'weight_with_unit':
                    $this->renderWeightWithUnit($field, $config, $value);
                    break;
                default:
                    $this->renderInput($field, $config, $value);
                    break;
            }
            ?>

            <?php if (!empty($config['description'])): ?>
                <p class="description"><?php echo esc_html($config['description']); ?></p>
            <?php endif; ?>
        </div>
        <?php
    }

    private function renderSelect(string $field, array $config, $value): void {
        ?>
        <select name="<?php echo esc_attr($field); ?>" 
                id="<?php echo esc_attr($field); ?>"
                <?php echo !empty($config['required']) ? 'required' : ''; ?>>
            <option value="">Select <?php echo esc_html($config['label']); ?></option>
            <?php foreach ($config['options'] as $option_value => $label): ?>
                <option value="<?php echo esc_attr($option_value); ?>"
                        <?php selected($value, $option_value); ?>>
                    <?php echo esc_html($label); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php
    }

    private function renderHeightWithUnit(string $field, array $config, $value): void {
        $current_unit = $this->data[$field . '_unit'] ?? 'imperial';
        ?>
        <div class="measurement-group">
            <?php if ($current_unit === 'imperial'): ?>
                <select name="<?php echo esc_attr($field); ?>" 
                        id="<?php echo esc_attr($field); ?>"
                        class="measurement-value"
                        <?php echo !empty($config['required']) ? 'required' : ''; ?>>
                    <option value="">Select height</option>
                    <?php foreach ($config['imperial_options'] as $option_value => $label): ?>
                        <option value="<?php echo esc_attr($option_value); ?>"
                                <?php selected($value, $option_value); ?>>
                            <?php echo esc_html($label); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php else: ?>
                <input type="number" 
                       name="<?php echo esc_attr($field); ?>"
                       id="<?php echo esc_attr($field); ?>"
                       class="measurement-value"
                       value="<?php echo esc_attr($value); ?>"
                       min="<?php echo esc_attr($config['metric_range']['min']); ?>"
                       max="<?php echo esc_attr($config['metric_range']['max']); ?>"
                       <?php echo !empty($config['required']) ? 'required' : ''; ?>>
            <?php endif; ?>
            
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
        <?php
    }

    private function renderWeightWithUnit(string $field, array $config, $value): void {
        $current_unit = $this->data[$field . '_unit'] ?? 'imperial';
        ?>
        <div class="measurement-group">
            <input type="number" 
                   name="<?php echo esc_attr($field); ?>"
                   id="<?php echo esc_attr($field); ?>"
                   class="measurement-value"
                   value="<?php echo esc_attr($value); ?>"
                   step="0.1"
                   <?php echo !empty($config['required']) ? 'required' : ''; ?>>
            
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
        <?php
    }

    private function renderInput(string $field, array $config, $value): void {
        ?>
        <input type="<?php echo esc_attr($config['type']); ?>"
               name="<?php echo esc_attr($field); ?>"
               id="<?php echo esc_attr($field); ?>"
               value="<?php echo esc_attr($value); ?>"
               <?php if (!empty($config['required'])): ?>required<?php endif; ?>
               <?php if (isset($config['min'])): ?>min="<?php echo esc_attr($config['min']); ?>"<?php endif; ?>
               <?php if (isset($config['max'])): ?>max="<?php echo esc_attr($config['max']); ?>"<?php endif; ?>
               <?php if (isset($config['step'])): ?>step="<?php echo esc_attr($config['step']); ?>"<?php endif; ?>>
        <?php
    }
} 