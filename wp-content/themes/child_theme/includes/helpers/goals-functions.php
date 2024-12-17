<?php
/**
 * Goals Helper Functions
 * 
 * Helper functions for goals operations
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Get user's goals
 *
 * @param int $user_id User ID
 * @return array User goals
 */
function athlete_dashboard_get_user_goals($user_id) {
    $goals_manager = new Athlete_Dashboard_Goals_Data_Manager();
    return $goals_manager->get_user_goals($user_id);
} 