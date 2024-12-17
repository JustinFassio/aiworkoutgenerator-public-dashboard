<?php
/**
 * Membership Data Manager Class
 * 
 * Handles membership data operations
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Membership_Data_Manager extends Athlete_Dashboard_Data_Manager {
    /**
     * Initialize the data manager
     */
    public function __construct() {
        parent::__construct('membership_data');
    }

    /**
     * Get user's membership details
     *
     * @param int $user_id User ID
     * @return array Membership details
     */
    public function get_user_membership($user_id) {
        $membership_id = get_user_meta($user_id, '_membership_id', true);
        
        if (!$membership_id) {
            return array(
                'type' => __('No Active Membership', 'athlete-dashboard'),
                'status' => 'inactive',
                'expiry_date' => '',
                'benefits' => array()
            );
        }

        $membership = get_post($membership_id);
        if (!$membership) {
            return array(
                'type' => __('Invalid Membership', 'athlete-dashboard'),
                'status' => 'error',
                'expiry_date' => '',
                'benefits' => array()
            );
        }

        return array(
            'type' => $membership->post_title,
            'status' => get_post_meta($membership_id, '_membership_status', true),
            'expiry_date' => get_user_meta($user_id, '_membership_expiry', true),
            'benefits' => $this->get_membership_benefits($membership_id)
        );
    }

    /**
     * Get membership benefits
     *
     * @param int $membership_id Membership post ID
     * @return array Array of benefits
     */
    private function get_membership_benefits($membership_id) {
        $benefits = get_post_meta($membership_id, '_membership_benefits', true);
        return is_array($benefits) ? $benefits : array();
    }
} 