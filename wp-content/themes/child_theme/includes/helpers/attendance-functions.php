<?php
/**
 * Attendance Helper Functions
 * 
 * Helper functions for attendance operations
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Get user's attendance statistics
 *
 * @param int $user_id User ID
 * @return array Attendance statistics
 */
function athlete_dashboard_get_user_attendance_stats($user_id) {
    $attendance_manager = new Athlete_Dashboard_Attendance_Data_Manager();
    return $attendance_manager->get_user_attendance_stats($user_id);
} 