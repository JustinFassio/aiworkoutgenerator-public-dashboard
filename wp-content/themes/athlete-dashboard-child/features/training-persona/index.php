<?php
/**
 * Feature Name: Training Persona
 * Description: Manage your training preferences and goals
 * Icon: dashicons-universal-access
 */

namespace AthleteDashboard\Features\TrainingPersona;

use AthleteDashboard\Dashboard\Components\Dashboard;
use AthleteDashboard\Features\TrainingPersona\Components\Modals\TrainingPersonaModal;

if (!defined('ABSPATH')) {
    exit;
}

// Load feature components
require_once __DIR__ . '/components/TrainingPersona.php';
require_once __DIR__ . '/components/TrainingPersonaForm.php';
require_once __DIR__ . '/components/modals/TrainingPersonaModal.php';

// Initialize feature
class TrainingPersona {
    private static ?TrainingPersona $instance = null;

    public static function getInstance(): TrainingPersona {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->init();
    }

    private function init(): void {
        // Register feature modal
        add_action('init', [$this, 'registerModal']);

        // Add AJAX handlers
        add_action('wp_ajax_update_training_persona', [$this, 'handleUpdate']);
        add_action('wp_ajax_nopriv_update_training_persona', [$this, 'handleUnauthorized']);
    }

    public function registerModal(): void {
        if (!is_page_template('dashboard.php')) {
            return;
        }

        // Create and register modal
        $modal = new TrainingPersonaModal('training-persona-modal');
        Dashboard::getInstance()->registerModal($modal);
    }

    public function handleUpdate(): void {
        // Verify nonce
        if (!check_ajax_referer('training_persona_nonce', 'training_persona_nonce', false)) {
            wp_send_json_error([
                'message' => __('Invalid security token.', 'athlete-dashboard-child')
            ]);
        }

        // Verify user is logged in
        if (!is_user_logged_in()) {
            wp_send_json_error([
                'message' => __('You must be logged in to update your training persona.', 'athlete-dashboard-child')
            ]);
        }

        // Get form data
        $training_level = sanitize_text_field($_POST['training_level'] ?? '');
        $training_frequency = sanitize_text_field($_POST['training_frequency'] ?? '');
        $training_goals = array_map('sanitize_text_field', $_POST['training_goals'] ?? []);
        $preferred_training_time = sanitize_text_field($_POST['preferred_training_time'] ?? '');
        $additional_notes = sanitize_textarea_field($_POST['additional_notes'] ?? '');

        // Validate required fields
        if (empty($training_level) || empty($training_frequency) || empty($training_goals)) {
            wp_send_json_error([
                'message' => __('Please fill in all required fields.', 'athlete-dashboard-child')
            ]);
        }

        // Update user meta
        $user_id = get_current_user_id();
        update_user_meta($user_id, '_training_level', $training_level);
        update_user_meta($user_id, '_training_frequency', $training_frequency);
        update_user_meta($user_id, '_training_goals', $training_goals);
        update_user_meta($user_id, '_preferred_training_time', $preferred_training_time);
        update_user_meta($user_id, '_additional_notes', $additional_notes);

        // Send success response
        wp_send_json_success([
            'message' => __('Training persona updated successfully.', 'athlete-dashboard-child'),
            'data' => [
                'training_level' => $training_level,
                'training_frequency' => $training_frequency,
                'training_goals' => $training_goals,
                'preferred_training_time' => $preferred_training_time,
                'additional_notes' => $additional_notes
            ]
        ]);
    }

    public function handleUnauthorized(): void {
        wp_send_json_error([
            'message' => __('You must be logged in to update your training persona.', 'athlete-dashboard-child')
        ]);
    }

    public function enqueue_assets(): void
    {
        if (!$this->is_dashboard_page()) {
            return;
        }

        // Enqueue styles
        wp_enqueue_style(
            'training-persona-styles',
            get_stylesheet_directory_uri() . '/assets/dist/css/features/training-persona/training-persona.css',
            [],
            filemtime(get_stylesheet_directory() . '/assets/dist/css/features/training-persona/training-persona.css')
        );

        wp_enqueue_style(
            'training-persona-modal-styles',
            get_stylesheet_directory_uri() . '/assets/dist/css/features/training-persona/modal.css',
            [],
            filemtime(get_stylesheet_directory() . '/assets/dist/css/features/training-persona/modal.css')
        );

        // Enqueue scripts
        wp_enqueue_script(
            'training-persona-scripts',
            get_stylesheet_directory_uri() . '/assets/dist/js/features/training-persona/training-persona.js',
            ['wp-api'],
            filemtime(get_stylesheet_directory() . '/assets/dist/js/features/training-persona/training-persona.js'),
            true
        );
        wp_script_add_data('training-persona-scripts', 'type', 'module');

        wp_enqueue_script(
            'training-persona-form-handler',
            get_stylesheet_directory_uri() . '/assets/dist/js/features/training-persona/form-handler.js',
            ['wp-api'],
            filemtime(get_stylesheet_directory() . '/assets/dist/js/features/training-persona/form-handler.js'),
            true
        );
        wp_script_add_data('training-persona-form-handler', 'type', 'module');

        wp_enqueue_script(
            'training-persona-modal',
            get_stylesheet_directory_uri() . '/assets/dist/js/features/training-persona/modal.js',
            ['wp-api'],
            filemtime(get_stylesheet_directory() . '/assets/dist/js/features/training-persona/modal.js'),
            true
        );
        wp_script_add_data('training-persona-modal', 'type', 'module');
    }
}

// Initialize feature
TrainingPersona::getInstance(); 