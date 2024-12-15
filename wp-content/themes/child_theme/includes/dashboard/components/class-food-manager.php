<?php
/**
 * Food Manager Component Class
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Food_Manager {
    /**
     * Food database instance
     *
     * @var Athlete_Food_Database
     */
    private $food_db;

    /**
     * Initialize the component
     */
    public function __construct() {
        $this->food_db = new Athlete_Food_Database();
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    /**
     * Enqueue component-specific scripts
     */
    public function enqueue_scripts() {
        wp_enqueue_script(
            'food-manager',
            ATHLETE_DASHBOARD_URI . '/assets/js/components/food-manager.js',
            array('jquery', 'jquery-ui-autocomplete'),
            filemtime(ATHLETE_DASHBOARD_PATH . '/assets/js/components/food-manager.js'),
            true
        );

        wp_localize_script('food-manager', 'foodManagerData', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('nutrition_tracker_nonce'),
            'strings' => array(
                'saveSuccess' => __('Food saved successfully', 'athlete-dashboard'),
                'saveError' => __('Error saving food', 'athlete-dashboard'),
                'deleteSuccess' => __('Food deleted successfully', 'athlete-dashboard'),
                'deleteError' => __('Error deleting food', 'athlete-dashboard'),
                'confirmDelete' => __('Are you sure you want to delete this food?', 'athlete-dashboard')
            )
        ));
    }

    /**
     * Render the food manager
     */
    public function render() {
        $user_id = get_current_user_id();
        $user_foods = $this->food_db->search_foods('', $user_id, 100); // Get user's foods
        
        include ATHLETE_DASHBOARD_PATH . '/templates/dashboard/sections/food-manager.php';
    }
} 