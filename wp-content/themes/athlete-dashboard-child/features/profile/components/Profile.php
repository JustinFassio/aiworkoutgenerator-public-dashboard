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
                    'classes' => ['profile-form'],
                    'attributes' => [
                        'data-form-context' => 'modal'
                    ]
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
            <p class="description" style="margin-bottom: 1rem;">
                <?php _e('This information can only be edited by the athlete through their dashboard.', 'athlete-dashboard-child'); ?>
            </p>
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
                            </label>
                        </th>
                        <td>
                            <?php if ($config['type'] === 'multi_select'): ?>
                                <?php
                                $selected_values = $profile_data->get($field);
                                // Ensure we have an array and it's not empty
                                $selected_values = is_array($selected_values) ? $selected_values : [];
                                if (!empty($selected_values)): ?>
                                    <div class="selected-injuries-admin">
                                        <?php
                                        foreach ($selected_values as $value) {
                                            if (isset($config['options'][$value])) {
                                                echo '<div class="injury-item">' . esc_html($config['options'][$value]) . '</div>';
                                            }
                                        }
                                        ?>
                                    </div>
                                <?php else: ?>
                                    <div class="selected-injuries-admin empty">
                                        <?php _e('No injuries reported', 'athlete-dashboard-child'); ?>
                                    </div>
                                <?php endif; ?>

                            <?php elseif ($config['type'] === 'height_with_unit'): ?>
                                <?php
                                $current_unit = $profile_data->get($field . '_unit') ?? 'imperial';
                                $value = $profile_data->get($field);
                                if ($current_unit === 'imperial' && isset($config['imperial_options'][$value])) {
                                    echo esc_html($config['imperial_options'][$value]);
                                } else {
                                    echo esc_html($value . ' ' . strtoupper($config['units'][$current_unit]));
                                }
                                ?>

                            <?php elseif ($config['type'] === 'weight_with_unit'): ?>
                                <?php
                                $current_unit = $profile_data->get($field . '_unit') ?? 'imperial';
                                $value = $profile_data->get($field);
                                echo esc_html($value . ' ' . strtoupper($config['units'][$current_unit]));
                                ?>

                            <?php elseif ($config['type'] === 'textarea'): ?>
                                <div class="injury-description">
                                    <?php
                                    if ($field === 'injuries_other') {
                                        $description = $profile_data->get($field);
                                        $lines = explode("\n", $description);
                                        foreach ($lines as $line) {
                                            if (strpos($line, ':') !== false) {
                                                // This is a header line
                                                echo '<strong>' . esc_html($line) . '</strong>';
                                            } else {
                                                echo esc_html($line) . "\n";
                                            }
                                        }
                                    } else {
                                        echo nl2br(esc_html($profile_data->get($field)));
                                    }
                                    ?>
                                </div>

                            <?php elseif ($config['type'] === 'tag_input'): ?>
                                <?php
                                $injuries = $profile_data->get($field);
                                if (!empty($injuries) && is_array($injuries)): ?>
                                    <div class="selected-injuries-admin">
                                        <?php
                                        foreach ($injuries as $injury) {
                                            if (isset($injury['type']) && isset($injury['label'])) {
                                                echo '<div class="injury-item">' . esc_html($injury['label']) . '</div>';
                                            }
                                        }
                                        ?>
                                    </div>
                                <?php else: ?>
                                    <div class="selected-injuries-admin empty">
                                        <?php _e('No injuries reported', 'athlete-dashboard-child'); ?>
                                    </div>
                                <?php endif; ?>

                            <?php else: ?>
                                <?php 
                                $value = $profile_data->get($field);
                                if ($config['type'] === 'select' && isset($config['options'][$value])) {
                                    echo esc_html($config['options'][$value]);
                                } else {
                                    echo esc_html($value);
                                }
                                ?>
                            <?php endif; ?>

                            <?php if (!empty($config['description'])): ?>
                                <p class="description"><?php echo esc_html($config['description']); ?></p>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <style>
                .selected-injuries-admin {
                    background: #f0f0f1;
                    border: 1px solid #c3c4c7;
                    border-radius: 4px;
                    padding: 0.75rem;
                    min-height: 80px;
                }
                .selected-injuries-admin.empty {
                    color: #646970;
                    font-style: italic;
                }
                .selected-injuries-admin .injury-item {
                    margin-bottom: 0.5rem;
                    padding: 0.5rem;
                    background: #fff;
                    border: 1px solid #c3c4c7;
                    border-radius: 4px;
                }
                .injury-description {
                    background: #f0f0f1;
                    border: 1px solid #c3c4c7;
                    border-radius: 4px;
                    padding: 0.75rem;
                    min-height: 80px;
                    white-space: pre-wrap;
                }
            </style>
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
                    // Handle array data from multi-select fields
                    if (is_array($value)) {
                        $data[$key] = array_map('sanitize_text_field', $value);
                    } else {
                        $data[$key] = sanitize_text_field($value);
                    }
                }
            }

            error_log('Profile Update Data: ' . print_r($data, true)); // Debug log

            $result = $this->service->updateProfile($user_id, $data);
            if ($result) {
                $updated_data = $this->service->getProfileData($user_id)->toArray();
                error_log('Updated Profile Data: ' . print_r($updated_data, true)); // Debug log
                
                wp_send_json_success([
                    'message' => __('Profile updated successfully', 'athlete-dashboard-child'),
                    'data' => $updated_data
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