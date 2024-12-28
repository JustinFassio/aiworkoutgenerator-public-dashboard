<?php
/**
 * Profile Feature
 * 
 * Initializes the profile feature and sets up necessary hooks.
 */

namespace AthleteDashboard\Features\Profile;

use AthleteDashboard\Features\Profile\Components\Profile;
use AthleteDashboard\Features\Profile\Models\ProfileData;
use AthleteDashboard\Features\Profile\Services\ProfileService;
use AthleteDashboard\Features\Profile\Components\Modals\ProfileModal;
use AthleteDashboard\Features\Profile\Injuries\Components\InjuryTracking;
use AthleteDashboard\Features\Profile\Injuries\Models\Injury;
use AthleteDashboard\Features\Profile\Injuries\Services\InjuryService;

if (!defined('ABSPATH')) {
    exit;
}

// Load dependencies in correct order
require_once __DIR__ . '/models/ProfileData.php';
require_once __DIR__ . '/services/ProfileService.php';
require_once __DIR__ . '/components/modals/ProfileModal.php';
require_once __DIR__ . '/components/Profile.php';

// Load injury tracking components
require_once __DIR__ . '/injuries/models/Injury.php';
require_once __DIR__ . '/injuries/services/InjuryService.php';
require_once __DIR__ . '/injuries/components/InjuryTracking.php';

class ProfileFeature {
    private static ?Profile $instance = null;
    private static ?InjuryTracking $injury_tracking = null;

    public static function init(): void {
        add_action('init', [self::class, 'setup']);
        add_action('admin_init', [self::class, 'admin_setup']);
        
        // Register profile modal
        add_action('init', function() {
            $dashboard = \AthleteDashboard\Dashboard\Components\Dashboard::getInstance();
            $modal = new ProfileModal('profile-modal', [], [
                'title' => __('Your Profile', 'athlete-dashboard-child')
            ]);
            $dashboard->registerModal($modal);
        });
    }

    public static function setup(): void {
        // Initialize components
        self::$injury_tracking = new InjuryTracking();

        // Enqueue assets
        add_action('wp_enqueue_scripts', [self::class, 'enqueue_assets']);
        
        // Initialize AJAX handlers
        add_action('wp_ajax_update_profile', [self::getInstance(), 'handleProfileUpdate']);
        add_action('wp_ajax_track_injury', [self::$injury_tracking, 'handleAjaxTrackInjury']);
        add_action('wp_ajax_get_injury_progress', [self::$injury_tracking, 'handleAjaxGetInjuryProgress']);
        add_action('wp_ajax_delete_injury_progress', [self::$injury_tracking, 'handleAjaxDeleteInjuryProgress']);

        // Add form render action
        add_action('athlete_dashboard_profile_form', [self::getInstance(), 'render_form']);
    }

    public static function admin_setup(): void {
        // Add admin hooks
        add_action('show_user_profile', [self::getInstance(), 'render_admin_fields']);
        add_action('edit_user_profile', [self::getInstance(), 'render_admin_fields']);
        add_action('personal_options_update', [self::getInstance(), 'save_admin_fields']);
        add_action('edit_user_profile_update', [self::getInstance(), 'save_admin_fields']);
    }

    public static function enqueue_assets(): void {
        if (!is_page_template('dashboard.php')) {
            return;
        }

        $version = '1.0.0';
        
        // Register and enqueue feature styles
        wp_register_style(
            'athlete-profile',
            get_stylesheet_directory_uri() . '/assets/dist/css/features/profile/profile.css',
            ['athlete-dashboard-styles'],
            $version
        );
        wp_enqueue_style('athlete-profile');

        wp_register_style(
            'athlete-profile-modal',
            get_stylesheet_directory_uri() . '/assets/dist/css/features/profile/profile-modal.css',
            ['athlete-profile', 'athlete-dashboard-styles'],
            $version
        );
        wp_enqueue_style('athlete-profile-modal');

        // Register form handler first as a module
        wp_register_script(
            'athlete-profile-form-handler',
            get_stylesheet_directory_uri() . '/assets/dist/js/features/profile/form-handler.js',
            ['jquery', 'dashboard-scripts'],
            $version,
            true
        );
        wp_script_add_data('athlete-profile-form-handler', 'type', 'module');

        // Register main script with dependencies
        wp_register_script(
            'athlete-profile',
            get_stylesheet_directory_uri() . '/assets/dist/js/features/profile/profile.js',
            ['jquery', 'athlete-profile-form-handler', 'dashboard-scripts'],
            $version,
            true
        );
        wp_script_add_data('athlete-profile', 'type', 'module');

        // Register modal script
        wp_register_script(
            'athlete-profile-modal',
            get_stylesheet_directory_uri() . '/assets/dist/js/features/profile/profile-modal.js',
            ['jquery', 'athlete-profile', 'dashboard-scripts'],
            $version,
            true
        );
        wp_script_add_data('athlete-profile-modal', 'type', 'module');

        // Localize scripts
        wp_localize_script('athlete-profile', 'profileConfig', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('profile_nonce'),
            'user_id' => get_current_user_id(),
            'i18n' => [
                'saveSuccess' => __('Profile saved successfully', 'athlete-dashboard-child'),
                'saveError' => __('Failed to save profile', 'athlete-dashboard-child')
            ]
        ]);

        // Enqueue scripts in correct order
        wp_enqueue_script('athlete-profile-form-handler');
        wp_enqueue_script('athlete-profile');
        wp_enqueue_script('athlete-profile-modal');
    }

    public static function getInstance(): Profile {
        if (self::$instance === null) {
            self::$instance = new Profile();
        }
        return self::$instance;
    }
}

// Initialize the feature
ProfileFeature::init(); 