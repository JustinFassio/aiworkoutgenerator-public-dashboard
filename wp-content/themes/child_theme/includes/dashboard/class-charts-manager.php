<?php
/**
 * Charts Manager Class
 * Handles chart functionality for the athlete dashboard
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Charts_Manager {
    /**
     * @var Athlete_Dashboard_Charts_Data_Manager
     */
    private $data_manager;

    /**
     * Constructor
     */
    public function __construct() {
        $this->data_manager = new Athlete_Dashboard_Charts_Data_Manager();
    }

    /**
     * Get attendance data
     *
     * @param int $user_id User ID
     * @param string $period Time period
     * @return array
     */
    public function get_attendance_data($user_id, $period = '30days') {
        return $this->data_manager->get_attendance_data($user_id, $period);
    }

    /**
     * Get goals data
     *
     * @param int $user_id User ID
     * @return array
     */
    public function get_goals_data($user_id) {
        return $this->data_manager->get_goals_data($user_id);
    }

    /**
     * Get dashboard statistics
     *
     * @param int $user_id User ID
     * @return object
     */
    public function get_dashboard_stats($user_id) {
        return (object) $this->data_manager->get_dashboard_stats($user_id);
    }
} 