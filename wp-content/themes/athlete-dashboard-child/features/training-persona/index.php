<?php
/**
 * Training Persona Feature
 * 
 * Initializes the training persona feature and sets up necessary hooks.
 */

namespace AthleteDashboard\Features\TrainingPersona;

use AthleteDashboard\Features\TrainingPersona\Components\TrainingPersona;

if (!defined('ABSPATH')) {
    exit;
}

// Load required files
require_once get_stylesheet_directory() . '/features/training-persona/models/TrainingPersonaData.php';
require_once get_stylesheet_directory() . '/features/training-persona/services/TrainingPersonaService.php';
require_once get_stylesheet_directory() . '/features/training-persona/components/TrainingPersona.php';

class TrainingPersonaFeature {
    private static ?TrainingPersona $instance = null;

    public static function init(): void {
        add_action('init', [self::class, 'setup']);
        add_action('admin_init', [self::class, 'admin_setup']);
    }

    public static function setup(): void {
        // Enqueue assets
        add_action('wp_enqueue_scripts', [self::class, 'enqueue_assets']);
        
        // Initialize AJAX handlers
        add_action('wp_ajax_update_training_persona', [self::getInstance(), 'handlePersonaUpdate']);
        add_action('wp_ajax_export_training_persona', [self::getInstance(), 'handle_export_request']);
        add_action('wp_ajax_track_goal_progress', [self::class, 'handle_goal_progress']);
        add_action('wp_ajax_get_goal_progress', [self::class, 'handle_get_progress']);
    }

    public static function admin_setup(): void {
        // Add admin hooks
        add_action('show_user_profile', [self::getInstance(), 'render_admin_fields']);
        add_action('edit_user_profile', [self::getInstance(), 'render_admin_fields']);
    }

    public static function handle_goal_progress(): void {
        check_ajax_referer('training_persona_nonce', 'training_persona_nonce');

        if (!isset($_POST['goal_id'], $_POST['progress'])) {
            wp_send_json_error('Missing required parameters');
            return;
        }

        $goal_id = sanitize_text_field($_POST['goal_id']);
        $progress = floatval($_POST['progress']);

        $result = self::getInstance()->track_goal_progress($goal_id, $progress);
        if ($result) {
            wp_send_json_success([
                'message' => __('Progress updated successfully', 'athlete-dashboard-child'),
                'goal_id' => $goal_id,
                'progress' => $progress
            ]);
        } else {
            wp_send_json_error([
                'message' => __('Failed to update progress', 'athlete-dashboard-child')
            ]);
        }
    }

    public static function handle_get_progress(): void {
        check_ajax_referer('training_persona_nonce', 'training_persona_nonce');

        $goal_id = isset($_GET['goal_id']) ? sanitize_text_field($_GET['goal_id']) : null;
        $progress = self::getInstance()->get_goal_progress($goal_id);

        wp_send_json_success([
            'progress' => $progress
        ]);
    }

    public static function enqueue_assets(): void {
        $version = '1.0.0';
        
        // Register and enqueue CSS
        wp_register_style(
            'training-persona-styles',
            get_stylesheet_directory_uri() . '/features/training-persona/assets/css/training-persona.css',
            [],
            $version
        );
        wp_enqueue_style('training-persona-styles');

        // Register and enqueue JavaScript
        wp_register_script(
            'training-persona-scripts',
            get_stylesheet_directory_uri() . '/features/training-persona/assets/js/training-persona.js',
            ['jquery', 'form-handler', 'tag-input'],
            $version,
            true
        );

        wp_localize_script('training-persona-scripts', 'trainingPersonaData', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('training_persona_nonce'),
            'i18n' => [
                'exportSuccess' => __('Data exported successfully', 'athlete-dashboard-child'),
                'exportError' => __('Failed to export data', 'athlete-dashboard-child'),
                'progressSuccess' => __('Progress updated successfully', 'athlete-dashboard-child'),
                'progressError' => __('Failed to update progress', 'athlete-dashboard-child')
            ]
        ]);

        wp_enqueue_script('training-persona-scripts');
    }

    public static function getInstance(): TrainingPersona {
        if (self::$instance === null) {
            self::$instance = new TrainingPersona();
        }
        return self::$instance;
    }
}

// Initialize the feature
TrainingPersonaFeature::init(); 

// Register frontend assets
add_action('wp_enqueue_scripts', function() {
    if (is_page_template('features/dashboard/templates/dashboard.php')) {
        // Enqueue shared assets
        wp_enqueue_style('athlete-shared-forms');
        wp_enqueue_script('athlete-form-handler');

        // Then load training-persona-specific assets
        wp_enqueue_style(
            'athlete-training-persona',
            get_stylesheet_directory_uri() . '/features/training-persona/assets/css/training-persona.css',
            ['athlete-shared-forms'],
            '1.0.0'
        );

        wp_enqueue_script(
            'athlete-training-persona',
            get_stylesheet_directory_uri() . '/features/training-persona/assets/js/training-persona.js',
            ['jquery', 'athlete-form-handler'],
            '1.0.0',
            true
        );

        // Localize script data
        wp_localize_script('athlete-training-persona', 'trainingPersonaData', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('training_persona_nonce'),
            'user_id' => get_current_user_id()
        ));
    }
}); 