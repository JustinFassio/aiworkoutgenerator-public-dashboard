<?php
/**
 * Profile Form Template
 * 
 * @var array $fields Field definitions from ProfileData
 * @var array $data Current profile data
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<form id="profile-form" class="profile-form">
    <?php wp_nonce_field('profile_nonce', 'profile_nonce'); ?>
    
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

            <?php elseif ($config['type'] === 'height_with_unit'): ?>
                <div class="measurement-group">
                    <?php 
                    $current_unit = $data[$field . '_unit'] ?? 'imperial';
                    $current_value = $data[$field] ?? '';
                    ?>
                    <?php if ($current_unit === 'imperial'): ?>
                        <select name="<?php echo esc_attr($field); ?>" 
                                id="<?php echo esc_attr($field); ?>"
                                class="measurement-value"
                                <?php echo $config['required'] ? 'required' : ''; ?>>
                            <option value="">Select height</option>
                            <?php foreach ($config['imperial_options'] as $value => $label): ?>
                                <option value="<?php echo esc_attr($value); ?>"
                                        <?php selected($current_value, $value); ?>>
                                    <?php echo esc_html($label); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php else: ?>
                        <input type="number" 
                               name="<?php echo esc_attr($field); ?>"
                               id="<?php echo esc_attr($field); ?>"
                               class="measurement-value"
                               value="<?php echo esc_attr($current_value); ?>"
                               min="<?php echo esc_attr($config['metric_range']['min']); ?>"
                               max="<?php echo esc_attr($config['metric_range']['max']); ?>"
                               <?php echo $config['required'] ? 'required' : ''; ?>>
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