<?php
/**
 * Membership Data Manager Class
 * Handles data operations for athlete memberships
 *
 * @package AthleteDashboard
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
     * Get membership details for a user
     *
     * @param int $user_id User ID
     * @return array Membership details
     */
    public function get_membership_details($user_id) {
        $membership = array(
            'status' => get_user_meta($user_id, 'membership_status', true),
            'type' => get_user_meta($user_id, 'membership_type', true),
            'start_date' => get_user_meta($user_id, 'membership_start_date', true),
            'end_date' => get_user_meta($user_id, 'membership_end_date', true),
            'payment_status' => get_user_meta($user_id, 'membership_payment_status', true),
            'last_payment_date' => get_user_meta($user_id, 'membership_last_payment_date', true),
            'recurring' => get_user_meta($user_id, 'membership_recurring', true),
            'access_level' => get_user_meta($user_id, 'membership_access_level', true)
        );

        return array_map(function($value) {
            return $value ?: '';
        }, $membership);
    }

    /**
     * Update membership details
     *
     * @param int $user_id User ID
     * @param array $data Membership data
     * @return bool True on success, false on failure
     */
    public function update_membership($user_id, $data) {
        $valid_fields = array(
            'status',
            'type',
            'start_date',
            'end_date',
            'payment_status',
            'last_payment_date',
            'recurring',
            'access_level'
        );

        $success = true;
        foreach ($data as $field => $value) {
            if (in_array($field, $valid_fields)) {
                $success = $success && update_user_meta($user_id, 'membership_' . $field, $value);
            }
        }

        if ($success) {
            do_action('athlete_dashboard_membership_updated', $user_id, $data);
        }

        return $success;
    }

    /**
     * Check if membership is active
     *
     * @param int $user_id User ID
     * @return bool True if active, false otherwise
     */
    public function is_membership_active($user_id) {
        $status = get_user_meta($user_id, 'membership_status', true);
        $end_date = get_user_meta($user_id, 'membership_end_date', true);
        
        if ($status !== 'active') {
            return false;
        }

        if ($end_date && strtotime($end_date) < time()) {
            $this->update_membership($user_id, array('status' => 'expired'));
            return false;
        }

        return true;
    }

    /**
     * Get available membership types
     *
     * @return array Array of membership types
     */
    public function get_membership_types() {
        return apply_filters('athlete_dashboard_membership_types', array(
            'basic' => array(
                'name' => __('Basic Membership', 'athlete-dashboard'),
                'price' => 29.99,
                'duration' => 30,
                'features' => array(
                    'workout_tracking',
                    'basic_analytics'
                )
            ),
            'premium' => array(
                'name' => __('Premium Membership', 'athlete-dashboard'),
                'price' => 49.99,
                'duration' => 30,
                'features' => array(
                    'workout_tracking',
                    'advanced_analytics',
                    'nutrition_planning',
                    'personal_coaching'
                )
            )
        ));
    }

    /**
     * Process membership renewal
     *
     * @param int $user_id User ID
     * @param string $type Membership type
     * @return bool True on success, false on failure
     */
    public function process_renewal($user_id, $type) {
        $types = $this->get_membership_types();
        if (!isset($types[$type])) {
            return false;
        }

        $current_date = current_time('mysql');
        $end_date = date('Y-m-d H:i:s', strtotime("+{$types[$type]['duration']} days"));

        $data = array(
            'status' => 'active',
            'type' => $type,
            'start_date' => $current_date,
            'end_date' => $end_date,
            'payment_status' => 'completed',
            'last_payment_date' => $current_date
        );

        $success = $this->update_membership($user_id, $data);

        if ($success) {
            do_action('athlete_dashboard_membership_renewed', $user_id, $type);
        }

        return $success;
    }

    /**
     * Get membership access features
     *
     * @param int $user_id User ID
     * @return array Array of features the user has access to
     */
    public function get_access_features($user_id) {
        if (!$this->is_membership_active($user_id)) {
            return array();
        }

        $type = get_user_meta($user_id, 'membership_type', true);
        $types = $this->get_membership_types();

        return isset($types[$type]) ? $types[$type]['features'] : array();
    }

    /**
     * Check if user has access to a specific feature
     *
     * @param int $user_id User ID
     * @param string $feature Feature to check
     * @return bool True if user has access, false otherwise
     */
    public function has_feature_access($user_id, $feature) {
        $features = $this->get_access_features($user_id);
        return in_array($feature, $features);
    }

    /**
     * Get membership statistics
     *
     * @param int $user_id User ID
     * @return array Membership statistics
     */
    public function get_membership_stats($user_id) {
        $details = $this->get_membership_details($user_id);
        
        $stats = array(
            'is_active' => $this->is_membership_active($user_id),
            'days_remaining' => 0,
            'total_paid' => 0,
            'membership_age' => 0
        );

        if ($details['end_date']) {
            $stats['days_remaining'] = ceil((strtotime($details['end_date']) - time()) / (60 * 60 * 24));
        }

        if ($details['start_date']) {
            $stats['membership_age'] = ceil((time() - strtotime($details['start_date'])) / (60 * 60 * 24));
        }

        // Get payment history and calculate total
        $payment_history = get_user_meta($user_id, 'membership_payment_history', true);
        if ($payment_history) {
            $stats['total_paid'] = array_sum(array_column($payment_history, 'amount'));
        }

        return $stats;
    }
} 