<?php
/**
 * Profile Component
 * 
 * Handles profile data management and synchronization between WordPress Admin
 * and Athlete Dashboard interfaces.
 */

namespace AthleteDashboard\Features\Profile\Components;

use AthleteDashboard\Features\Profile\Services\ProfileService;
use AthleteDashboard\Features\Profile\Models\ProfileData;

if (!defined('ABSPATH')) {
    exit;
}

class Profile {
    private ProfileService $service;
    private ProfileData $profile_data;

    public function __construct() {
        $this->service = new ProfileService();
        try {
            $this->profile_data = $this->service->getProfileData();
            $this->init();
        } catch (\Exception $e) {
            error_log('Profile initialization failed: ' . $e->getMessage());
            $this->profile_data = new ProfileData(); // Fallback to empty profile
        }
    }

    private function init(): void {
        // Add AJAX handlers for dashboard updates
        add_action('wp_ajax_update_profile', [$this, 'handleProfileUpdate']);
    }

    public function render_form(): void {
        try {
            $fields = $this->profile_data->getFields();
            $data = $this->profile_data->toArray();
            $unit_preference = $data['unit_preference'] ?? 'imperial';
            
            include dirname(__DIR__) . '/templates/profile-form.php';
        } catch (\Exception $e) {
            error_log('Failed to render profile form: ' . $e->getMessage());
            echo '<div class="error">Failed to load profile form. Please try again later.</div>';
        }
    }

    /**
     * Render profile fields in WP Admin
     */
    public function render_admin_fields($user): void {
        if (!current_user_can('edit_user', $user->ID)) {
            return;
        }

        try {
            $profile_data = $this->service->getProfileData($user->ID);
            $fields = $profile_data->getFields();
            $data = $profile_data->toArray();
            ?>
            <h3><?php _e('Athlete Profile Information', 'athlete-dashboard-child'); ?></h3>
            <table class="form-table">
                <?php foreach ($fields as $field => $config): ?>
                    <?php
                    // Skip unit fields
                    if (strpos($field, '_unit') !== false) continue;
                    ?>
                    <tr>
                        <th>
                            <label for="<?php echo esc_attr($field); ?>">
                                <?php echo esc_html($config['label']); ?>
                            </label>
                        </th>
                        <td>
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
                                                style="margin-right: 8px; min-width: 200px;"
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
                                               style="margin-right: 8px; width: 100px;"
                                               <?php echo $config['required'] ? 'required' : ''; ?>>
                                    <?php endif; ?>
                                    
                                    <select name="<?php echo esc_attr($field); ?>_unit"
                                            id="<?php echo esc_attr($field); ?>_unit"
                                            class="unit-selector"
                                            style="width: 70px;">
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
                                           style="margin-right: 8px; width: 100px;"
                                           <?php echo $config['required'] ? 'required' : ''; ?>>
                                    
                                    <select name="<?php echo esc_attr($field); ?>_unit"
                                            id="<?php echo esc_attr($field); ?>_unit"
                                            class="unit-selector"
                                            style="width: 70px;">
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
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <script>
            jQuery(document).ready(function($) {
                // Handle unit changes in admin
                $('.unit-selector').on('change', function() {
                    const $selector = $(this);
                    const $group = $selector.closest('.measurement-group');
                    const $field = $group.closest('tr');
                    const fieldName = $selector.attr('name').replace('_unit', '');
                    const newUnit = $selector.val();
                    const oldUnit = $group.data('lastUnit') || 'imperial';
                    const currentValue = $group.find('.measurement-value').val();

                    if (currentValue && oldUnit !== newUnit) {
                        if (fieldName === 'height') {
                            if (newUnit === 'metric') {
                                // Convert from inches to cm
                                const cm = Math.round(currentValue * 2.54);
                                const $input = $('<input>', {
                                    type: 'number',
                                    name: fieldName,
                                    id: fieldName,
                                    class: 'measurement-value',
                                    value: cm,
                                    min: 120,
                                    max: 244,
                                    required: true,
                                    style: 'margin-right: 8px; width: 100px;'
                                });
                                $group.find('.measurement-value').replaceWith($input);
                            } else {
                                // Convert from cm to inches
                                const inches = Math.round(currentValue / 2.54);
                                const $select = $('<select>', {
                                    name: fieldName,
                                    id: fieldName,
                                    class: 'measurement-value',
                                    required: true,
                                    style: 'margin-right: 8px; min-width: 200px;'
                                }).append($('<option>', {
                                    value: '',
                                    text: 'Select height'
                                }));

                                // Add height options
                                for (let feet = 4; feet <= 8; feet++) {
                                    for (let inches = 0; inches < (feet === 8 ? 1 : 12); inches++) {
                                        const totalInches = (feet * 12) + inches;
                                        $select.append($('<option>', {
                                            value: totalInches,
                                            text: `${feet}'${inches}"`,
                                            selected: totalInches === inches
                                        }));
                                    }
                                }
                                $group.find('.measurement-value').replaceWith($select);
                            }
                        } else if (fieldName === 'weight') {
                            const $input = $group.find('.measurement-value');
                            if (newUnit === 'metric') {
                                // Convert from lbs to kg
                                const kg = Math.round(currentValue * 0.453592 * 10) / 10;
                                $input.val(kg);
                            } else {
                                // Convert from kg to lbs
                                const lbs = Math.round(currentValue * 2.20462 * 10) / 10;
                                $input.val(lbs);
                            }
                        }
                    }

                    // Update last unit
                    $group.data('lastUnit', newUnit);
                });
            });
            </script>
            <?php
        } catch (\Exception $e) {
            error_log('Failed to render admin fields: ' . $e->getMessage());
            ?>
            <div class="error">
                <p><?php _e('Failed to load profile data. Please try again later.', 'athlete-dashboard-child'); ?></p>
            </div>
            <?php
        }
    }

    /**
     * Save profile fields from WP Admin
     */
    public function save_admin_fields($user_id): void {
        if (!current_user_can('edit_user', $user_id)) {
            return;
        }

        try {
            $data = [];
            foreach (array_keys($this->profile_data->getFields()) as $field) {
                if (isset($_POST[$field])) {
                    $data[$field] = sanitize_text_field($_POST[$field]);
                }
            }

            $result = $this->service->updateProfile($user_id, $data);
            if (!$result) {
                add_settings_error(
                    'profile_update',
                    'profile_update_error',
                    __('Failed to update profile. Please try again.', 'athlete-dashboard-child'),
                    'error'
                );
            }
        } catch (\Exception $e) {
            error_log('Failed to save admin fields: ' . $e->getMessage());
            add_settings_error(
                'profile_update',
                'profile_update_error',
                __('An error occurred while saving profile data.', 'athlete-dashboard-child'),
                'error'
            );
        }
    }

    /**
     * Handle AJAX profile updates from dashboard
     */
    public function handleProfileUpdate(): void {
        check_ajax_referer('profile_nonce', 'profile_nonce');

        $user_id = get_current_user_id();
        if (!$user_id) {
            wp_send_json_error('User not logged in');
            return;
        }

        try {
            $data = [];
            foreach ($_POST as $key => $value) {
                if ($key !== 'action' && $key !== 'profile_nonce') {
                    $data[$key] = sanitize_text_field($value);
                }
            }

            $result = $this->service->updateProfile($user_id, $data);
            if ($result) {
                wp_send_json_success([
                    'message' => 'Profile updated successfully',
                    'data' => $this->service->getProfileData($user_id)->toArray()
                ]);
            } else {
                wp_send_json_error('Failed to update profile');
            }
        } catch (\Exception $e) {
            error_log('Profile update failed: ' . $e->getMessage());
            wp_send_json_error('An error occurred while updating profile');
        }
    }

    public function get_profile_data(): array {
        return $this->profile_data->toArray();
    }

    public function get_fields(): array {
        return $this->profile_data->getFields();
    }
} 