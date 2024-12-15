<?php
/**
 * Asset Manager Class
 * 
 * Handles all asset loading and dependency management for the theme
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Asset_Manager {
    /**
     * Component dependencies
     */
    private $component_dependencies = array(
        'nutrition-tracker' => array('jquery', 'chart-js'),
        'nutrition-logger' => array('jquery', 'jquery-ui-autocomplete'),
        'food-manager' => array('jquery'),
        'workout-logger' => array('jquery'),
        'progress-tracker' => array('jquery', 'chart-js'),
        'workout-lightbox' => array('jquery'),
        'account-details' => array('jquery')
    );

    /**
     * Third-party dependencies
     */
    private $third_party_scripts = array(
        'chart-js' => array(
            'src' => 'https://cdn.jsdelivr.net/npm/chart.js',
            'version' => '4.4.1'
        )
    );

    /**
     * Initialize the asset manager
     */
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
    }

    /**
     * Enqueue all necessary assets
     */
    public function enqueue_assets() {
        // Only load on dashboard page
        if (!is_page('dashboard')) {
            return;
        }

        // Enqueue third-party dependencies
        foreach ($this->third_party_scripts as $handle => $script) {
            wp_enqueue_script(
                $handle,
                $script['src'],
                array(),
                $script['version'],
                true
            );
        }

        // Enqueue component scripts
        foreach ($this->component_dependencies as $component => $deps) {
            wp_enqueue_script(
                $component,
                ATHLETE_DASHBOARD_URI . "/assets/js/components/{$component}.js",
                $deps,
                filemtime(ATHLETE_DASHBOARD_PATH . "/assets/js/components/{$component}.js"),
                true
            );

            // Localize script data if needed
            $this->localize_component_data($component);
        }

        // Enqueue styles
        wp_enqueue_style(
            'athlete-dashboard-components',
            ATHLETE_DASHBOARD_URI . '/assets/css/components.css',
            array(),
            filemtime(ATHLETE_DASHBOARD_PATH . '/assets/css/components.css')
        );
    }

    /**
     * Localize data for components
     */
    private function localize_component_data($component) {
        switch ($component) {
            case 'nutrition-tracker':
                wp_localize_script('nutrition-tracker', 'nutritionTrackerData', array(
                    'ajaxurl' => admin_url('admin-ajax.php'),
                    'nonce' => wp_create_nonce('nutrition_tracker_nonce'),
                    'strings' => array(
                        'saveSuccess' => __('Nutrition goals saved successfully', 'athlete-dashboard'),
                        'saveError' => __('Error saving nutrition goals', 'athlete-dashboard')
                    )
                ));
                break;

            case 'nutrition-logger':
                wp_localize_script('nutrition-logger', 'nutritionLoggerData', array(
                    'ajaxurl' => admin_url('admin-ajax.php'),
                    'nonce' => wp_create_nonce('nutrition_logger_nonce'),
                    'strings' => array(
                        'noFoods' => __('Please add at least one food to log', 'athlete-dashboard'),
                        'saveError' => __('Error saving meal log', 'athlete-dashboard'),
                        'remove' => __('Remove', 'athlete-dashboard')
                    )
                ));
                break;

            case 'food-manager':
                wp_localize_script('food-manager', 'foodManagerData', array(
                    'ajaxurl' => admin_url('admin-ajax.php'),
                    'nonce' => wp_create_nonce('food_manager_nonce'),
                    'strings' => array(
                        'saveError' => __('Error saving food', 'athlete-dashboard'),
                        'deleteError' => __('Error deleting food', 'athlete-dashboard'),
                        'confirmDelete' => __('Are you sure you want to delete this food?', 'athlete-dashboard')
                    )
                ));
                break;

            // Add other component localizations as needed
        }
    }
} 