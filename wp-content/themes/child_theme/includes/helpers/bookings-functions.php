<?php
/**
 * Bookings Helper Functions
 * 
 * Helper functions for class booking operations
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Get user's class bookings
 *
 * @param int $user_id User ID
 * @return array Array of class bookings
 */
function athlete_dashboard_get_user_class_bookings($user_id) {
    $bookings_manager = new Athlete_Dashboard_Bookings_Data_Manager();
    return $bookings_manager->get_user_class_bookings($user_id);
} 