<?php
/**
 * Messaging Data Manager Class
 * Handles data operations for athlete messaging system
 *
 * @package AthleteDashboard
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
     * Send a message
     *
     * @param array $data Message data
     * @return int|false Message ID on success, false on failure
     */
    public function send_message($data) {
        $post_data = array(
            'post_type' => 'athlete_message',
            'post_status' => 'publish',
            'post_author' => get_current_user_id(),
            'post_title' => isset($data['subject']) ? sanitize_text_field($data['subject']) : '',
            'post_content' => isset($data['content']) ? wp_kses_post($data['content']) : '',
        );

        $message_id = wp_insert_post($post_data);

        if ($message_id && !is_wp_error($message_id)) {
            // Save recipient
            if (isset($data['recipient_id'])) {
                update_post_meta($message_id, 'message_recipient', $data['recipient_id']);
            }

            // Save additional meta
            $meta_fields = array(
                'read_status' => 'unread',
                'priority' => isset($data['priority']) ? $data['priority'] : 'normal',
                'thread_id' => isset($data['thread_id']) ? $data['thread_id'] : $message_id
            );

            foreach ($meta_fields as $field => $value) {
                update_post_meta($message_id, 'message_' . $field, $value);
            }

            do_action('athlete_dashboard_message_sent', $message_id, $data);
            return $message_id;
        }

        return false;
    }

    /**
     * Get messages for a user
     *
     * @param int $user_id User ID
     * @param string $box Inbox or sent
     * @param array $args Additional arguments
     * @return array Array of messages
     */
    public function get_messages($user_id, $box = 'inbox', $args = array()) {
        $default_args = array(
            'post_type' => 'athlete_message',
            'posts_per_page' => 20,
            'paged' => 1,
            'orderby' => 'date',
            'order' => 'DESC'
        );

        if ($box === 'inbox') {
            $default_args['meta_query'] = array(
                array(
                    'key' => 'message_recipient',
                    'value' => $user_id
                )
            );
        } else {
            $default_args['author'] = $user_id;
        }

        $args = wp_parse_args($args, $default_args);
        $messages = get_posts($args);

        return array_map(array($this, 'format_message'), $messages);
    }

    /**
     * Format message for API response
     *
     * @param WP_Post $message Message post object
     * @return array Formatted message data
     */
    private function format_message($message) {
        $recipient_id = get_post_meta($message->ID, 'message_recipient', true);
        
        return array(
            'id' => $message->ID,
            'subject' => $message->post_title,
            'content' => $message->post_content,
            'sender' => array(
                'id' => $message->post_author,
                'name' => get_the_author_meta('display_name', $message->post_author)
            ),
            'recipient' => array(
                'id' => $recipient_id,
                'name' => get_the_author_meta('display_name', $recipient_id)
            ),
            'date' => $message->post_date,
            'read_status' => get_post_meta($message->ID, 'message_read_status', true),
            'priority' => get_post_meta($message->ID, 'message_priority', true),
            'thread_id' => get_post_meta($message->ID, 'message_thread_id', true)
        );
    }

    /**
     * Mark message as read
     *
     * @param int $message_id Message ID
     * @return bool True on success, false on failure
     */
    public function mark_as_read($message_id) {
        return update_post_meta($message_id, 'message_read_status', 'read');
    }

    /**
     * Delete message
     *
     * @param int $message_id Message ID
     * @return bool True on success, false on failure
     */
    public function delete_message($message_id) {
        $message = get_post($message_id);
        if (!$message || $message->post_type !== 'athlete_message') {
            return false;
        }

        return wp_delete_post($message_id, true);
    }

    /**
     * Get message thread
     *
     * @param int $thread_id Thread ID
     * @return array Array of messages in thread
     */
    public function get_thread($thread_id) {
        $args = array(
            'post_type' => 'athlete_message',
            'posts_per_page' => -1,
            'meta_key' => 'message_thread_id',
            'meta_value' => $thread_id,
            'orderby' => 'date',
            'order' => 'ASC'
        );

        $messages = get_posts($args);
        return array_map(array($this, 'format_message'), $messages);
    }

    /**
     * Get unread message count
     *
     * @param int $user_id User ID
     * @return int Number of unread messages
     */
    public function get_unread_count($user_id) {
        $args = array(
            'post_type' => 'athlete_message',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'message_recipient',
                    'value' => $user_id
                ),
                array(
                    'key' => 'message_read_status',
                    'value' => 'unread'
                )
            ),
            'posts_per_page' => -1
        );

        $messages = get_posts($args);
        return count($messages);
    }

    /**
     * Search messages
     *
     * @param int $user_id User ID
     * @param string $query Search query
     * @return array Array of matching messages
     */
    public function search_messages($user_id, $query) {
        $args = array(
            'post_type' => 'athlete_message',
            's' => $query,
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key' => 'message_recipient',
                    'value' => $user_id
                ),
                array(
                    'key' => 'post_author',
                    'value' => $user_id
                )
            )
        );

        $messages = get_posts($args);
        return array_map(array($this, 'format_message'), $messages);
    }
} 