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
use AthleteDashboard\Features\Shared\Components\Form;

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
            $this->profile_data = new ProfileData();
        }
    }

    private function init(): void {
        add_action('wp_ajax_update_profile', [$this, 'handleProfileUpdate']);
    }

    public function render_form(): void {
        try {
            $form = new Form('profile-form', 
                $this->profile_data->getFields(),
                $this->profile_data->toArray(),
                [
                    'context' => 'modal',
                    'submitText' => __('Save Profile', 'athlete-dashboard-child'),
                    'showLoader' => true,
                    'classes' => ['profile-form']
                ]
            );
            $form->render();
        } catch (\Exception $e) {
            error_log('Failed to render profile form: ' . $e->getMessage());
            echo '<div class="error">Failed to load profile form. Please try again later.</div>';
        }
    }

    public function render_admin_fields($user): void {
        if (!current_user_can('edit_user', $user->ID)) {
            return;
        }

        try {
            $profile_data = $this->service->getProfileData($user->ID);
            ?>
            <h3><?php _e('Athlete Profile Information', 'athlete-dashboard-child'); ?></h3>
            <table class="form-table" role="presentation">
                <?php foreach ($profile_data->getFields() as $field => $config): ?>
                    <?php
                    // Skip unit fields as they're handled with their parent fields
                    if (strpos($field, '_unit') !== false) continue;
                    ?>
                    <tr>
                        <th>
                            <label for="<?php echo esc_attr($field); ?>">
                                <?php echo esc_html($config['label']); ?>
                                <?php if ($config['required']): ?>
                                    <span class="required">*</span>
                                <?php endif; ?>
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
                                                <?php selected($profile_data->get($field), $value); ?>>
                                            <?php echo esc_html($label); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                            <?php elseif ($config['type'] === 'height_with_unit'): ?>
                                <div class="measurement-group">
                                    <?php 
                                    $current_unit = $profile_data->get($field . '_unit') ?? 'imperial';
                                    $current_value = $profile_data->get($field) ?? '';
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
                                    $current_unit = $profile_data->get($field . '_unit') ?? 'imperial';
                                    $current_value = $profile_data->get($field) ?? '';
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
                                       value="<?php echo esc_attr($profile_data->get($field)); ?>"
                                       <?php echo $config['required'] ? 'required' : ''; ?>>
                            <?php endif; ?>

                            <?php if (!empty($config['description'])): ?>
                                <p class="description"><?php echo esc_html($config['description']); ?></p>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
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
                    'message' => __('Profile updated successfully', 'athlete-dashboard-child'),
                    'data' => $this->service->getProfileData($user_id)->toArray()
                ]);
            } else {
                wp_send_json_error([
                    'message' => __('Failed to update profile', 'athlete-dashboard-child')
                ]);
            }
        } catch (\Exception $e) {
            error_log('Profile update failed: ' . $e->getMessage());
            wp_send_json_error([
                'message' => __('An error occurred while updating profile', 'athlete-dashboard-child')
            ]);
        }
    }

    public function get_profile_data(): array {
        return $this->profile_data->toArray();
    }

    public function get_fields(): array {
        return $this->profile_data->getFields();
    }
} 