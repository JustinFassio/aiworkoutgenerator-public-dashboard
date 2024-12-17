<?php
/**
 * Training Data Manager Class
 * 
 * Handles training session data operations
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Training_Data_Manager extends Athlete_Dashboard_Data_Manager {
    /**
     * Initialize the data manager
     */
    public function __construct() {
        parent::__construct('training_data');
    }

    /**
     * Get user's training sessions
     *
     * @param int $user_id User ID
     * @return array Array of training sessions
     */
    public function get_user_training_sessions($user_id) {
        $args = array(
            'post_type' => 'training_session',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => '_client_id',
                    'value' => $user_id,
                    'compare' => '='
                )
            ),
            'orderby' => 'meta_value',
            'meta_key' => '_session_date',
            'order' => 'ASC'
        );

        $sessions = get_posts($args);
        $formatted_sessions = array();

        foreach ($sessions as $session) {
            $trainer_id = get_post_meta($session->ID, '_trainer_id', true);
            $trainer = get_userdata($trainer_id);

            $formatted_sessions[] = array(
                'id' => $session->ID,
                'date' => get_post_meta($session->ID, '_session_date', true),
                'time' => get_post_meta($session->ID, '_session_time', true),
                'trainer_name' => $trainer ? $trainer->display_name : __('Unassigned', 'athlete-dashboard'),
                'status' => get_post_meta($session->ID, '_session_status', true),
                'notes' => get_post_meta($session->ID, '_session_notes', true)
            );
        }

        return $formatted_sessions;
    }
} 