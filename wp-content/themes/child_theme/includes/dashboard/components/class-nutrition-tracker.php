<?php
/**
 * Nutrition Tracker Component Class
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Nutrition_Tracker {
    /**
     * Data manager instance
     */
    private $data_manager;

    /**
     * Initialize the component
     */
    public function __construct() {
        $this->data_manager = new Athlete_Dashboard_Nutrition_Data_Manager('athlete_nutrition');
        
        add_action('wp_ajax_save_nutrition_goals', array($this, 'handle_save_nutrition_goals'));
        add_action('wp_ajax_get_daily_nutrition', array($this, 'handle_get_daily_nutrition'));
    }

    /**
     * Render the nutrition tracker
     */
    public function render() {
        $user_id = get_current_user_id();
        $nutrition_goals = $this->data_manager->get_nutrition_goals($user_id);
        $daily_totals = $this->data_manager->get_daily_totals(current_time('Y-m-d'), $user_id);
        
        include ATHLETE_DASHBOARD_PATH . '/templates/dashboard/sections/nutrition-tracker.php';
    }

    /**
     * Handle saving nutrition goals via AJAX
     */
    public function handle_save_nutrition_goals() {
        check_ajax_referer('nutrition_tracker_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error(__('You must be logged in to save nutrition goals', 'athlete-dashboard'));
        }

        $goals = array(
            'calories' => isset($_POST['calories']) ? (int)$_POST['calories'] : 0,
            'protein' => isset($_POST['protein']) ? (float)$_POST['protein'] : 0,
            'carbs' => isset($_POST['carbs']) ? (float)$_POST['carbs'] : 0,
            'fat' => isset($_POST['fat']) ? (float)$_POST['fat'] : 0
        );

        if ($this->data_manager->save_nutrition_goals($goals)) {
            wp_send_json_success(array(
                'message' => __('Nutrition goals saved successfully', 'athlete-dashboard'),
                'goals' => $goals
            ));
        } else {
            wp_send_json_error(
                $this->data_manager->has_errors() 
                    ? $this->data_manager->get_errors()[0]->get_error_message() 
                    : __('Error saving nutrition goals', 'athlete-dashboard')
            );
        }
    }

    /**
     * Handle getting daily nutrition data via AJAX
     */
    public function handle_get_daily_nutrition() {
        check_ajax_referer('nutrition_tracker_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error(__('You must be logged in to view nutrition data', 'athlete-dashboard'));
        }

        $user_id = get_current_user_id();
        $date = isset($_POST['date']) ? sanitize_text_field($_POST['date']) : current_time('Y-m-d');

        try {
            $data = array(
                'goals' => $this->data_manager->get_nutrition_goals($user_id),
                'totals' => $this->data_manager->get_daily_totals($date, $user_id),
                'meals' => $this->data_manager->get_meals($date, $user_id),
                'weekly_calories' => $this->data_manager->get_weekly_calories($user_id)
            );

            wp_send_json_success($data);
        } catch (Exception $e) {
            wp_send_json_error(__('Error loading nutrition data', 'athlete-dashboard'));
        }
    }
} 