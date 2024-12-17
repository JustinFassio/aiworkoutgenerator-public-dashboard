<?php
/**
 * Membership Helper Functions
 * 
 * Helper functions for membership operations
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Get user's membership details
 *
 * @param int $user_id User ID
 * @return array Membership details
 */
function athlete_dashboard_get_user_membership($user_id) {
    $membership_manager = new Athlete_Dashboard_Membership_Data_Manager();
    return $membership_manager->get_user_membership($user_id);
} 