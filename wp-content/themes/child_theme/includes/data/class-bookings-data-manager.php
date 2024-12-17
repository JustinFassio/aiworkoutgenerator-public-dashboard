<?php
/**
 * Bookings Data Manager Class
 * 
 * Handles class booking data operations
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Bookings_Data_Manager extends Athlete_Dashboard_Data_Manager {
    /**
     * Initialize the data manager
     */
    public function __construct() {
        parent::__construct('bookings_data');
    }

    /**
     * Get user's class bookings
     *
     * @param int $user_id User ID
     * @return array Array of class bookings
     */
    public function get_user_class_bookings($user_id) {
        $args = array(
            'post_type' => 'class_booking',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => '_attendee_id',
                    'value' => $user_id,
                    'compare' => '='
                ),
                array(
                    'key' => '_class_date',
                    'value' => current_time('Y-m-d'),
                    'compare' => '>=',
                    'type' => 'DATE'
                )
            ),
            'orderby' => 'meta_value',
            'meta_key' => '_class_date',
            'order' => 'ASC'
        );

        $bookings = get_posts($args);
        $formatted_bookings = array();

        foreach ($bookings as $booking) {
            $class_id = get_post_meta($booking->ID, '_class_id', true);
            $class = get_post($class_id);
            $instructor_id = get_post_meta($class_id, '_instructor_id', true);
            $instructor = get_userdata($instructor_id);

            $formatted_bookings[] = array(
                'id' => $booking->ID,
                'class_name' => $class ? $class->post_title : __('Class Removed', 'athlete-dashboard'),
                'date' => get_post_meta($booking->ID, '_class_date', true),
                'time' => get_post_meta($booking->ID, '_class_time', true),
                'instructor' => $instructor ? $instructor->display_name : __('TBA', 'athlete-dashboard'),
                'status' => get_post_meta($booking->ID, '_booking_status', true)
            );
        }

        return $formatted_bookings;
    }
} 