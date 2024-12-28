<?php
/**
 * Training Persona Component
 * 
 * Handles training persona data management and synchronization.
 */

namespace AthleteDashboard\Features\TrainingPersona\Components;

use AthleteDashboard\Features\TrainingPersona\Services\TrainingPersonaService;
use AthleteDashboard\Features\TrainingPersona\Models\TrainingPersonaData;
use AthleteDashboard\Features\TrainingPersona\Components\Modals\TrainingPersonaModal;

if (!defined('ABSPATH')) {
    exit;
}

class TrainingPersona {
    private TrainingPersonaService $service;
    private TrainingPersonaData $persona_data;
    private TrainingPersonaModal $modal;

    public function __construct() {
        $this->service = new TrainingPersonaService();
        try {
            $this->persona_data = $this->service->getTrainingPersonaData();
        } catch (\Exception $e) {
            error_log('Training persona initialization failed: ' . $e->getMessage());
            $this->persona_data = new TrainingPersonaData();
        }
        
        $this->modal = new TrainingPersonaModal('training-persona-modal', $this->persona_data->toArray());
        $this->init();
    }

    private function init(): void {
        add_action('wp_ajax_update_training_persona', [$this, 'handleTrainingPersonaUpdate']);
        add_action('athlete_dashboard_training_persona_form', [$this, 'render_form']);
        add_action('athlete_dashboard_training_persona_modal', [$this, 'render_modal']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueAssets']);
    }

    public function enqueueAssets(): void {
        if (!is_page_template('dashboard.php')) {
            return;
        }

        // Enqueue training persona-specific styles
        wp_enqueue_style(
            'training-persona-form',
            get_stylesheet_directory_uri() . '/features/training-persona/assets/css/training-persona-form.css',
            [],
            '1.0.0'
        );

        // Enqueue training persona-specific scripts
        wp_register_script(
            'training-persona-form-handler',
            get_stylesheet_directory_uri() . '/features/training-persona/assets/js/form-handler.js',
            ['jquery'],
            '1.0.0',
            true
        );

        wp_register_script(
            'training-persona-form',
            get_stylesheet_directory_uri() . '/features/training-persona/assets/js/training-persona-form.js',
            ['jquery', 'training-persona-form-handler'],
            '1.0.0',
            true
        );

        wp_enqueue_script('training-persona-form-handler');
        wp_enqueue_script('training-persona-form');

        // Enqueue modal assets
        $this->modal->enqueueAssets();
    }

    public function render_form(): void {
        try {
            $form = new TrainingPersonaForm('training-persona-form', $this->persona_data->getFields(), $this->persona_data->toArray(), [
                'context' => 'page',
                'submitText' => __('Save Training Persona', 'athlete-dashboard-child')
            ]);
            $form->render();
        } catch (\Exception $e) {
            error_log('Failed to render training persona form: ' . $e->getMessage());
            echo '<div class="error">Failed to load training persona form. Please try again later.</div>';
        }
    }

    public function render_modal(): void {
        $this->modal->render();
    }

    public function handleTrainingPersonaUpdate(): void {
        try {
            // Verify nonce
            if (!isset($_POST['training_persona_nonce']) || !wp_verify_nonce($_POST['training_persona_nonce'], 'training_persona_nonce')) {
                throw new \Exception('Invalid security token');
            }

            // Get current user ID
            $user_id = get_current_user_id();
            if (!$user_id) {
                throw new \Exception('User not logged in');
            }

            // Collect and sanitize form data
            $data = [];
            foreach ($this->persona_data->getFields() as $field => $config) {
                if (isset($_POST[$field])) {
                    $data[$field] = $_POST[$field];
                }
            }

            $result = $this->service->updateTrainingPersona($user_id, $data);
            if ($result) {
                $updated_data = $this->service->getTrainingPersonaData($user_id)->toArray();
                wp_send_json_success([
                    'message' => __('Training persona updated successfully', 'athlete-dashboard-child'),
                    'data' => $updated_data
                ]);
            } else {
                wp_send_json_error([
                    'message' => __('Failed to update training persona', 'athlete-dashboard-child')
                ]);
            }
        } catch (\Exception $e) {
            error_log('Training persona update failed: ' . $e->getMessage());
            wp_send_json_error([
                'message' => __('An error occurred while updating training persona', 'athlete-dashboard-child')
            ]);
        }
    }

    public function get_training_persona_data(): array {
        return $this->persona_data->toArray();
    }

    public function get_fields(): array {
        return $this->persona_data->getFields();
    }
} 