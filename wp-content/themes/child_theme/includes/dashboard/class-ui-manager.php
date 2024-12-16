<?php
/**
 * UI Manager Class
 * Handles initialization and management of UI components
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_UI_Manager {
    /**
     * Components registry
     */
    private $components;

    /**
     * Constructor
     */
    public function __construct() {
        $this->init();
    }

    /**
     * Initialize UI manager
     */
    private function init() {
        // Add UI-specific hooks
        add_action('wp_loaded', array($this, 'init_ui_components'));
        add_action('wp_ajax_get_ui_component', array($this, 'get_ui_component'));
        add_action('wp_ajax_update_ui_state', array($this, 'update_ui_state'));
        
        // Add template filters
        add_filter('athlete_dashboard_template_data', array($this, 'add_ui_template_data'));
        add_filter('athlete_dashboard_component_classes', array($this, 'add_ui_component_classes'));
    }

    /**
     * Initialize UI components
     */
    public function init_ui_components() {
        // Register UI components
        $this->register_ui_components();
        
        // Add UI-specific assets
        add_action('wp_enqueue_scripts', array($this, 'enqueue_ui_assets'));
        
        // Add UI state management
        add_action('wp_footer', array($this, 'add_ui_state_management'));
    }

    /**
     * Register UI components
     */
    private function register_ui_components() {
        // Register core UI components
        $this->components = array(
            'notifications' => array(
                'class' => 'Athlete_Dashboard_Notifications_Component',
                'template' => 'components/notifications.php'
            ),
            'modal' => array(
                'class' => 'Athlete_Dashboard_Modal_Component',
                'template' => 'components/modal.php'
            ),
            'loader' => array(
                'class' => 'Athlete_Dashboard_Loader_Component',
                'template' => 'components/loader.php'
            )
        );

        // Allow modules to register their UI components
        $this->components = apply_filters('athlete_dashboard_ui_components', $this->components);
    }

    /**
     * Enqueue UI assets
     */
    public function enqueue_ui_assets() {
        // Enqueue UI-specific styles
        wp_enqueue_style(
            'athlete-dashboard-ui',
            ATHLETE_DASHBOARD_URI . '/assets/css/components/ui.css',
            array(),
            ATHLETE_DASHBOARD_VERSION
        );

        // Enqueue UI-specific scripts
        wp_enqueue_script(
            'athlete-dashboard-ui',
            ATHLETE_DASHBOARD_URI . '/assets/js/athlete-ui.js',
            array(),
            ATHLETE_DASHBOARD_VERSION,
            true
        );

        // Add UI configuration
        wp_localize_script('athlete-dashboard-ui', 'athleteDashboardUI', array(
            'components' => array_keys($this->components),
            'templates' => $this->get_template_urls(),
            'nonce' => wp_create_nonce('athlete_dashboard_ui_nonce')
        ));
    }

    /**
     * Add UI state management
     */
    public function add_ui_state_management() {
        // Add UI state container
        echo '<div id="athlete-dashboard-ui-state" style="display: none;"></div>';
        
        // Add UI components container
        echo '<div id="athlete-dashboard-ui-components"></div>';
    }

    /**
     * Get UI component via AJAX
     */
    public function get_ui_component() {
        check_ajax_referer('athlete_dashboard_ui_nonce', 'nonce');
        
        $component = isset($_POST['component']) ? sanitize_text_field($_POST['component']) : '';
        if (!$component || !isset($this->components[$component])) {
            wp_send_json_error('Invalid component');
        }
        
        $html = $this->render_component($component);
        wp_send_json_success(array('html' => $html));
    }

    /**
     * Update UI state via AJAX
     */
    public function update_ui_state() {
        check_ajax_referer('athlete_dashboard_ui_nonce', 'nonce');
        
        $state = isset($_POST['state']) ? $_POST['state'] : array();
        $user_id = get_current_user_id();
        
        if ($user_id) {
            update_user_meta($user_id, 'athlete_dashboard_ui_state', $state);
            wp_send_json_success('UI state updated');
        } else {
            wp_send_json_error('User not logged in');
        }
    }

    /**
     * Add UI template data
     */
    public function add_ui_template_data($data) {
        $user_id = get_current_user_id();
        
        // Add UI state
        $data['ui_state'] = get_user_meta($user_id, 'athlete_dashboard_ui_state', true);
        
        // Add UI components
        $data['ui_components'] = $this->components;
        
        return $data;
    }

    /**
     * Add UI component classes
     */
    public function add_ui_component_classes($classes) {
        // Add UI-specific classes
        $ui_classes = array(
            'athlete-dashboard-ui-component',
            'athlete-dashboard-ui-initialized'
        );
        
        return array_merge($classes, $ui_classes);
    }

    /**
     * Render a UI component
     */
    private function render_component($component) {
        if (!isset($this->components[$component])) {
            return '';
        }
        
        $component_data = $this->components[$component];
        $template_path = ATHLETE_DASHBOARD_PATH . '/templates/' . $component_data['template'];
        
        if (!file_exists($template_path)) {
            return '';
        }
        
        ob_start();
        include $template_path;
        return ob_get_clean();
    }

    /**
     * Get template URLs for components
     */
    private function get_template_urls() {
        $urls = array();
        foreach ($this->components as $name => $data) {
            $urls[$name] = ATHLETE_DASHBOARD_URI . '/templates/' . $data['template'];
        }
        return $urls;
    }
} 