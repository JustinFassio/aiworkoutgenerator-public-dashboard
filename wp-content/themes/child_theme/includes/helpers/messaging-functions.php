<?php
/**
 * Messaging Helper Functions
 * 
 * Helper functions for messaging operations
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Get user's recent messages
 *
 * @param int $user_id User ID
 * @param int $limit Number of messages to return
 * @return array Recent messages
 */
function athlete_dashboard_get_recent_messages($user_id, $limit = 5) {
    $messaging_manager = new Athlete_Dashboard_Messaging_Data_Manager();
    return $messaging_manager->get_recent_messages($user_id, $limit);
} 