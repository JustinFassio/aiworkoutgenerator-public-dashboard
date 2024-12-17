<?php
/**
 * Training Helper Functions
 * 
 * Helper functions for training-related operations
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Get user's training sessions
 *
 * @param int $user_id User ID
 * @return array Array of training sessions
 */
function athlete_dashboard_get_user_training_sessions($user_id) {
    $training_manager = new Athlete_Dashboard_Training_Data_Manager();
    return $training_manager->get_user_training_sessions($user_id);
} 