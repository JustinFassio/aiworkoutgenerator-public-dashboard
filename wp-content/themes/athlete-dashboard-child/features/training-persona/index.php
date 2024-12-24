<?php
/**
 * Training Persona Feature
 * 
 * Initializes the training persona feature and sets up necessary hooks.
 */

namespace AthleteDashboard\Features\TrainingPersona;

use AthleteDashboard\Features\TrainingPersona\Components\TrainingPersona;
use AthleteDashboard\Features\TrainingPersona\Models\TrainingPersonaData;
use AthleteDashboard\Features\TrainingPersona\Services\TrainingPersonaService;
use AthleteDashboard\Features\TrainingPersona\Goals\Components\GoalTracking;
use AthleteDashboard\Features\TrainingPersona\Goals\Models\Goal;
use AthleteDashboard\Features\TrainingPersona\Goals\Services\GoalService;

if (!defined('ABSPATH')) {
    exit;
}

// Load dependencies in correct order
require_once __DIR__ . '/models/TrainingPersonaData.php';
require_once __DIR__ . '/services/TrainingPersonaService.php';
require_once __DIR__ . '/components/TrainingPersona.php';

// Load goal tracking components
require_once __DIR__ . '/goals/models/Goal.php';
require_once __DIR__ . '/goals/services/GoalService.php';
require_once __DIR__ . '/goals/components/GoalTracking.php';

class TrainingPersonaFeature {
    private static ?TrainingPersona $instance = null;
    private static ?GoalTracking $goal_tracking = null;

    public static function init(): void {
        add_action('init', [self::class, 'setup']);
        add_action('admin_init', [self::class, 'admin_setup']);
    }

    public static function setup(): void {
        // Initialize components
        self::$goal_tracking = new GoalTracking();

        // Enqueue assets
        add_action('wp_enqueue_scripts', [self::class, 'enqueue_assets']);
        
        // Initialize AJAX handlers
        add_action('wp_ajax_update_training_persona', [self::getInstance(), 'handlePersonaUpdate']);
        add_action('wp_ajax_export_training_persona', [self::getInstance(), 'handle_export_request']);
        add_action('wp_ajax_track_goal_progress', [self::$goal_tracking, 'handleAjaxTrackGoal']);
        add_action('wp_ajax_get_goal_progress', [self::$goal_tracking, 'handleAjaxGetGoalProgress']);
        add_action('wp_ajax_delete_goal_progress', [self::$goal_tracking, 'handleAjaxDeleteGoalProgress']);

        // Add form render action
        add_action('athlete_dashboard_training_persona_form', [self::getInstance(), 'render_form']);
    }

    public static function admin_setup(): void {
        // Add admin hooks
        add_action('show_user_profile', [self::getInstance(), 'render_admin_fields']);
        add_action('edit_user_profile', [self::getInstance(), 'render_admin_fields']);
    }

    public static function enqueue_assets(): void {
        if (!is_page_template('features/dashboard/templates/dashboard.php')) {
            return;
        }

        $version = '1.0.0';
        
        // Enqueue shared styles
        wp_enqueue_style('athlete-shared-forms');
        
        // Register and enqueue feature styles
        wp_register_style(
            'athlete-training-persona',
            get_stylesheet_directory_uri() . '/features/training-persona/assets/css/training-persona.css',
            ['athlete-shared-forms'],
            $version
        );
        wp_enqueue_style('athlete-training-persona');

        // Register form handler first
        wp_register_script(
            'athlete-training-persona-form-handler',
            get_stylesheet_directory_uri() . '/features/training-persona/assets/js/form-handler.js',
            ['jquery'],
            $version,
            true
        );

        // Register goal tracking script
        wp_register_script(
            'athlete-goal-tracking',
            get_stylesheet_directory_uri() . '/features/training-persona/assets/js/goal-tracking.js',
            ['jquery', 'athlete-training-persona-form-handler'],
            $version,
            true
        );

        // Register main script with dependencies
        wp_register_script(
            'athlete-training-persona',
            get_stylesheet_directory_uri() . '/features/training-persona/assets/js/training-persona.js',
            ['jquery', 'athlete-training-persona-form-handler', 'athlete-goal-tracking'],
            $version,
            true
        );

        // Localize scripts
        wp_localize_script('athlete-training-persona', 'trainingPersonaData', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('training_persona_nonce'),
            'user_id' => get_current_user_id(),
            'i18n' => [
                'saveSuccess' => __('Training persona saved successfully', 'athlete-dashboard-child'),
                'saveError' => __('Failed to save training persona', 'athlete-dashboard-child'),
                'exportSuccess' => __('Data exported successfully', 'athlete-dashboard-child'),
                'exportError' => __('Failed to export data', 'athlete-dashboard-child')
            ]
        ]);

        wp_localize_script('athlete-goal-tracking', 'goalData', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('goal_nonce')
        ]);

        // Enqueue scripts in correct order
        wp_enqueue_script('athlete-training-persona-form-handler');
        wp_enqueue_script('athlete-goal-tracking');
        wp_enqueue_script('athlete-training-persona');
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