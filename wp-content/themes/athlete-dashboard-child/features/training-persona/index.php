<?php

namespace AthleteDashboard\Features\TrainingPersona;

use AthleteDashboard\Dashboard\Abstracts\AbstractFeature;
use AthleteDashboard\Features\TrainingPersona\Components\TrainingPersonaForm;
use AthleteDashboard\Features\TrainingPersona\Api\TrainingPersonaController;

class TrainingPersona extends AbstractFeature {
    protected const FEATURE_ID = 'training-persona';
    protected const FEATURE_TITLE = 'Training Persona';
    protected const FEATURE_DESCRIPTION = 'Manage your training preferences and goals';

    private ?TrainingPersonaController $api_controller = null;

    public function __construct() {
        $this->identifier = self::FEATURE_ID;
        add_action('rest_api_init', [$this, 'register_rest_routes']);
        add_action('wp_ajax_save_training_persona', [$this, 'handleSave']); // Legacy AJAX support
    }

    public function init(): void {
        $this->enqueueAssets();
        $this->register_rest_routes();
    }

    protected function getFeatureFile(): string {
        return __FILE__;
    }

    public function register_rest_routes(): void {
        $this->api_controller = new TrainingPersonaController();
        $this->api_controller->register_routes();
    }

    public function enqueueAssets(): void {
        if (!is_user_logged_in() || !$this->isEnabled()) {
            return;
        }

        // Enqueue PHP-based styles
        wp_enqueue_style(
            'training-persona-styles',
            $this->getAssetUrl('css/training-persona.css'),
            [],
            filemtime($this->getAssetPath('css/training-persona.css'))
        );

        // Enqueue React component
        wp_enqueue_script(
            'training-persona-react',
            $this->getAssetUrl('js/index.js'),
            ['wp-element', 'wp-api-fetch'],
            filemtime($this->getAssetPath('js/index.js')),
            true
        );

        // Localize script with REST API endpoints
        wp_localize_script('training-persona-react', 'trainingPersonaData', [
            'endpoints' => [
                'get' => rest_url('athlete-dashboard/v1/training-persona'),
                'save' => rest_url('athlete-dashboard/v1/training-persona')
            ],
            'nonce' => wp_create_nonce('wp_rest')
        ]);
    }

    public function render(): void {
        if (!is_user_logged_in() || !$this->isEnabled()) {
            return;
        }

        $user_id = get_current_user_id();
        $data = $this->getUserData($user_id);

        // Render PHP form for non-JS fallback
        if (!wp_script_is('training-persona-react', 'done')) {
            $form = TrainingPersonaForm::create($data);
            echo $form->render();
            return;
        }

        // Render React container
        $this->renderReactContainer('training-persona-root', [
            'userData' => $data
        ]);
    }

    public function handleSave(): void {
        check_ajax_referer('training_persona_action', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error('User not logged in');
            return;
        }

        $user_id = get_current_user_id();
        $data = $this->sanitizeData($_POST);

        update_user_meta($user_id, 'training_persona', $data);
        wp_send_json_success('Training persona updated successfully');
    }

    private function getUserData(int $user_id): array {
        $default_data = [
            'level' => 'beginner',
            'goals' => [],
            'preferences' => [
                'workoutDuration' => 60,
                'workoutFrequency' => 3,
                'preferredTypes' => []
            ]
        ];

        $saved_data = get_user_meta($user_id, 'training_persona', true);
        return is_array($saved_data) ? array_merge($default_data, $saved_data) : $default_data;
    }

    private function sanitizeData(array $data): array {
        return [
            'level' => sanitize_text_field($data['training_level'] ?? 'beginner'),
            'goals' => isset($data['training_goals']) ? json_decode(stripslashes($data['training_goals']), true) : [],
            'preferences' => [
                'workoutDuration' => absint($data['workout_duration'] ?? 60),
                'workoutFrequency' => absint($data['workout_frequency'] ?? 3),
                'preferredTypes' => isset($data['preferred_types']) ? json_decode(stripslashes($data['preferred_types']), true) : []
            ]
        ];
    }
}

// Initialize the feature
new TrainingPersona(); 