<?php
/**
 * Core Components Manager Class
 * Handles initialization and management of core dashboard components
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Core_Components {
    /**
     * Constructor
     */
    public function __construct() {
        $this->init();
    }

    /**
     * Initialize core components
     */
    private function init() {
        // Initialize core UI components
        add_action('wp_loaded', array($this, 'init_ui_components'));
        
        // Initialize core data handlers
        add_action('init', array($this, 'init_data_handlers'));
        
        // Add AJAX handlers
        add_action('wp_ajax_get_dashboard_data', array($this, 'get_dashboard_data'));
        add_action('wp_ajax_update_dashboard_settings', array($this, 'update_dashboard_settings'));
    }

    /**
     * Initialize UI components
     */
    public function init_ui_components() {
        // Register core template paths
        add_filter('athlete_dashboard_template_paths', array($this, 'register_template_paths'));
        
        // Add core assets
        add_filter('athlete_dashboard_core_assets', array($this, 'register_core_assets'));
    }

    /**
     * Initialize data handlers
     */
    public function init_data_handlers() {
        // Register core data stores
        add_filter('athlete_dashboard_data_stores', array($this, 'register_data_stores'));
        
        // Initialize caching
        $this->init_caching();
    }

    /**
     * Register core template paths
     */
    public function register_template_paths($paths) {
        $core_paths = array(
            'dashboard' => ATHLETE_DASHBOARD_PATH . '/templates/dashboard',
            'components' => ATHLETE_DASHBOARD_PATH . '/templates/components',
            'partials' => ATHLETE_DASHBOARD_PATH . '/templates/partials'
        );
        
        return array_merge($paths, $core_paths);
    }

    /**
     * Register core assets
     */
    public function register_core_assets($assets) {
        $core_assets = array(
            'styles' => array(
                'dashboard-core' => '/assets/css/dashboard-core.css',
                'components-core' => '/assets/css/components-core.css'
            ),
            'scripts' => array(
                'dashboard-core' => '/assets/js/dashboard-core.js',
                'components-core' => '/assets/js/components-core.js'
            )
        );
        
        return array_merge($assets, $core_assets);
    }

    /**
     * Register core data stores
     */
    public function register_data_stores($stores) {
        $core_stores = array(
            'settings' => new Athlete_Dashboard_Settings_Store(),
            'user_preferences' => new Athlete_Dashboard_User_Preferences_Store()
        );
        
        return array_merge($stores, $core_stores);
    }

    /**
     * Initialize caching
     */
    private function init_caching() {
        // Set up object cache groups
        wp_cache_add_global_groups(array(
            'athlete_dashboard_core',
            'athlete_dashboard_user_data'
        ));
        
        // Set up transient cleanup
        add_action('wp_scheduled_delete', array($this, 'cleanup_expired_transients'));
    }

    /**
     * AJAX handler for getting dashboard data
     */
    public function get_dashboard_data() {
        check_ajax_referer('athlete_dashboard_nonce', 'nonce');
        
        $user_id = get_current_user_id();
        if (!$user_id) {
            wp_send_json_error('User not logged in');
        }
        
        $data = array(
            'settings' => $this->get_dashboard_settings($user_id),
            'preferences' => $this->get_user_preferences($user_id)
        );
        
        wp_send_json_success($data);
    }

    /**
     * AJAX handler for updating dashboard settings
     */
    public function update_dashboard_settings() {
        check_ajax_referer('athlete_dashboard_nonce', 'nonce');
        
        $user_id = get_current_user_id();
        if (!$user_id) {
            wp_send_json_error('User not logged in');
        }
        
        $settings = isset($_POST['settings']) ? $_POST['settings'] : array();
        $updated = $this->save_dashboard_settings($user_id, $settings);
        
        if ($updated) {
            wp_send_json_success('Settings updated');
        } else {
            wp_send_json_error('Failed to update settings');
        }
    }

    /**
     * Get dashboard settings for a user
     */
    private function get_dashboard_settings($user_id) {
        $settings = get_user_meta($user_id, 'athlete_dashboard_settings', true);
        return $settings ? $settings : array();
    }

    /**
     * Get user preferences
     */
    private function get_user_preferences($user_id) {
        $preferences = get_user_meta($user_id, 'athlete_dashboard_preferences', true);
        return $preferences ? $preferences : array();
    }

    /**
     * Save dashboard settings for a user
     */
    private function save_dashboard_settings($user_id, $settings) {
        return update_user_meta($user_id, 'athlete_dashboard_settings', $settings);
    }

    /**
     * Clean up expired transients
     */
    public function cleanup_expired_transients() {
        global $wpdb;
        
        $wpdb->query(
            "DELETE FROM {$wpdb->options} 
            WHERE option_name LIKE '%_transient_athlete_dashboard_%' 
            AND option_value < " . time()
        );
    }
} 