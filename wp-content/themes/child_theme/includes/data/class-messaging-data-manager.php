<?php
/**
 * Messaging Data Manager Class
 * 
 * Handles messaging data operations
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Messaging_Data_Manager extends Athlete_Dashboard_Data_Manager {
    /**
     * Initialize the data manager
     */
    public function __construct() {
        parent::__construct('messaging_data');
    }

    /**
     * Get user's recent messages
     *
     * @param int $user_id User ID
     * @param int $limit Number of messages to return
     * @return array Array of recent messages
     */
    public function get_recent_messages($user_id, $limit = 5) {
        $args = array(
            'post_type' => 'message',
            'posts_per_page' => $limit,
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key' => '_recipient_id',
                    'value' => $user_id,
                    'compare' => '='
                ),
                array(
                    'key' => '_sender_id',
                    'value' => $user_id,
                    'compare' => '='
                )
            ),
            'orderby' => 'date',
            'order' => 'DESC'
        );

        $messages = get_posts($args);
        $formatted_messages = array();

        foreach ($messages as $message) {
            $sender_id = get_post_meta($message->ID, '_sender_id', true);
            $sender = get_userdata($sender_id);
            
            $formatted_messages[] = array(
                'id' => $message->ID,
                'sender' => $sender ? $sender->display_name : __('Unknown', 'athlete-dashboard'),
                'sender_id' => $sender_id,
                'content' => $message->post_content,
                'timestamp' => $message->post_date,
                'is_read' => (bool) get_post_meta($message->ID, '_is_read', true),
                'type' => get_post_meta($message->ID, '_message_type', true),
                'subject' => $message->post_title
            );
        }

        return $formatted_messages;
    }

    /**
     * Mark message as read
     *
     * @param int $message_id Message ID
     * @param int $user_id User ID
     * @return bool Success status
     */
    public function mark_as_read($message_id, $user_id) {
        $message = get_post($message_id);
        if (!$message || $message->post_type !== 'message') {
            return false;
        }

        $recipient_id = get_post_meta($message_id, '_recipient_id', true);
        if ($recipient_id != $user_id) {
            return false;
        }

        return update_post_meta($message_id, '_is_read', true);
    }

    /**
     * Get unread message count
     *
     * @param int $user_id User ID
     * @return int Number of unread messages
     */
    public function get_unread_count($user_id) {
        $args = array(
            'post_type' => 'message',
            'posts_per_page' => -1,
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => '_recipient_id',
                    'value' => $user_id,
                    'compare' => '='
                ),
                array(
                    'key' => '_is_read',
                    'value' => '1',
                    'compare' => '!='
                )
            ),
            'fields' => 'ids'
        );

        $unread_messages = get_posts($args);
        return count($unread_messages);
    }

    /**
     * Send a new message
     *
     * @param array $data Message data
     * @return int|WP_Error Message ID on success, WP_Error on failure
     */
    public function send_message($data) {
        $required_fields = array('sender_id', 'recipient_id', 'content');
        foreach ($required_fields as $field) {
            if (empty($data[$field])) {
                return new WP_Error('missing_field', sprintf(__('Missing required field: %s', 'athlete-dashboard'), $field));
            }
        }

        $post_data = array(
            'post_type' => 'message',
            'post_status' => 'publish',
            'post_title' => !empty($data['subject']) ? $data['subject'] : __('New Message', 'athlete-dashboard'),
            'post_content' => wp_kses_post($data['content']),
            'post_author' => $data['sender_id']
        );

        $message_id = wp_insert_post($post_data, true);

        if (is_wp_error($message_id)) {
            return $message_id;
        }

        // Save message meta
        update_post_meta($message_id, '_sender_id', $data['sender_id']);
        update_post_meta($message_id, '_recipient_id', $data['recipient_id']);
        update_post_meta($message_id, '_is_read', false);
        update_post_meta($message_id, '_message_type', !empty($data['type']) ? $data['type'] : 'standard');

        do_action('athlete_dashboard_message_sent', $message_id, $data);

        return $message_id;
    }
} 