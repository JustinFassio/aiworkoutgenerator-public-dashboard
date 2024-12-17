<?php
/**
 * Profile Component
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
        $this->profile_data = $this->service->getProfileData();
        $this->init();
    }

    private function init(): void {
        // Add AJAX handlers for dashboard updates
        add_action('wp_ajax_update_profile', [$this, 'handleProfileUpdate']);
    }

    public function render_form(): void {
        $fields = $this->profile_data->getFields();
        $data = $this->profile_data->toArray();
        $unit_preference = $data['unit_preference'] ?? 'imperial';
        
        include dirname(__DIR__) . '/templates/profile-form.php';
    }

    /**
     * Render profile fields in WP Admin
     */
    public function render_admin_fields($user): void {
        if (!current_user_can('edit_user', $user->ID)) {
            return;
        }

        $profile_data = $this->service->getProfileData($user->ID);
        $fields = $profile_data->getFields();
        $data = $profile_data->toArray();
        ?>
        <h3><?php _e('Athlete Profile Information', 'athlete-dashboard-child'); ?></h3>
        <table class="form-table">
            <?php foreach ($fields as $field => $config): ?>
                <?php if (isset($config['hidden']) && $config['hidden']) continue; ?>
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
                        <?php elseif ($config['type'] === 'equipment'): ?>
                            <div class="equipment-selector">
                                <div class="equipment-input">
                                    <textarea name="<?php echo esc_attr($field); ?>" 
                                             id="<?php echo esc_attr($field); ?>"
                                             class="equipment-list"
                                             placeholder="Enter equipment, one per line"
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
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php
    }

    /**
     * Save profile fields from WP Admin
     */
    public function save_admin_fields($user_id): void {
        if (!current_user_can('edit_user', $user_id)) {
            return;
        }

        $data = [];
        foreach (array_keys($this->profile_data->getFields()) as $field) {
            if (isset($_POST[$field])) {
                $data[$field] = sanitize_text_field($_POST[$field]);
            }
        }

        $this->service->updateProfile($user_id, $data);
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

        $data = [];
        foreach ($_POST as $key => $value) {
            if ($key !== 'action' && $key !== 'profile_nonce') {
                $data[$key] = sanitize_text_field($value);
            }
        }

        if ($this->service->updateProfile($user_id, $data)) {
            wp_send_json_success([
                'message' => 'Profile updated successfully',
                'data' => $this->service->getProfileData($user_id)->toArray()
            ]);
        } else {
            wp_send_json_error('Failed to update profile');
        }
    }

    public function get_profile_data(): array {
        return $this->profile_data->toArray();
    }

    public function get_fields(): array {
        return $this->profile_data->getFields();
    }
} 