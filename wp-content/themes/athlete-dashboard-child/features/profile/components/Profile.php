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
use AthleteDashboard\Features\Profile\Components\Modals\ProfileModal;

if (!defined('ABSPATH')) {
    exit;
}

class Profile {
    private ProfileService $service;
    private ProfileData $profile_data;
    private ProfileModal $modal;

    public function __construct() {
        $this->service = new ProfileService();
        try {
            $this->profile_data = $this->service->getProfileData();
            $this->modal = new ProfileModal('profile-modal', $this->profile_data->toArray());
            $this->init();
        } catch (\Exception $e) {
            error_log('Profile initialization failed: ' . $e->getMessage());
            $this->profile_data = new ProfileData();
            $this->modal = new ProfileModal('profile-modal', []);
        }
    }

    private function init(): void {
        add_action('wp_ajax_update_profile', [$this, 'handleProfileUpdate']);
        add_action('athlete_dashboard_profile_form', [$this, 'render_form']);
        add_action('athlete_dashboard_profile_modal', [$this, 'render_modal']);
    }

    public function render_form(): void {
        try {
            $form = new ProfileForm('profile-form', $this->profile_data->getFields(), $this->profile_data->toArray(), [
                'context' => 'page',
                'submitText' => __('Save Profile', 'athlete-dashboard-child')
            ]);
            $form->render();
        } catch (\Exception $e) {
            error_log('Failed to render profile form: ' . $e->getMessage());
            echo '<div class="error">Failed to load profile form. Please try again later.</div>';
        }
    }

    public function render_modal(): void {
        $this->modal->render();
    }

    public function handleProfileUpdate(): void {
        try {
            // Verify nonce
            if (!isset($_POST['profile_nonce']) || !wp_verify_nonce($_POST['profile_nonce'], 'profile_nonce')) {
                throw new \Exception('Invalid security token');
            }

            // Get current user ID
            $user_id = get_current_user_id();
            if (!$user_id) {
                throw new \Exception('User not logged in');
            }

            // Collect and sanitize form data
            $data = [];
            foreach ($this->profile_data->getFields() as $field => $config) {
                if (isset($_POST[$field])) {
                    $data[$field] = $_POST[$field];
                }
            }

            $result = $this->service->updateProfile($user_id, $data);
            if ($result) {
                $updated_data = $this->service->getProfileData($user_id)->toArray();
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