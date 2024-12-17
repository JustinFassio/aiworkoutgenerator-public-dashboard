<?php
/**
 * Recommendations Helper Functions
 * 
 * Helper functions for recommendations operations
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Get user's personalized recommendations
 *
 * @param int $user_id User ID
 * @return array User recommendations
 */
function athlete_dashboard_get_user_recommendations($user_id) {
    $recommendations_manager = new Athlete_Dashboard_Recommendations_Data_Manager();
    return $recommendations_manager->get_user_recommendations($user_id);
} 