<?php
/**
 * Messaging Manager Class
 * Handles messaging functionality
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Messaging_Manager {
    /**
     * Data manager instance
     *
     * @var Athlete_Dashboard_Messaging_Data_Manager
     */
    private $data_manager;

    /**
     * Constructor
     */
    public function __construct() {
        $this->data_manager = new Athlete_Dashboard_Messaging_Data_Manager();
        $this->init();
    }

    /**
     * Initialize messaging manager
     */
    private function init() {
        // Add AJAX handlers
        add_action('wp_ajax_send_message', array($this, 'handle_send_message'));
        add_action('wp_ajax_get_messages', array($this, 'handle_get_messages'));
        add_action('wp_ajax_mark_message_read', array($this, 'handle_mark_message_read'));
        add_action('wp_ajax_delete_message', array($this, 'handle_delete_message'));
        
        // Add REST API endpoints
        add_action('rest_api_init', array($this, 'register_rest_routes'));
    }

    /**
     * Get unread count
     *
     * @param int $user_id User ID
     * @return int Number of unread messages
     */
    public function get_unread_count($user_id) {
        return $this->data_manager->get_unread_count($user_id);
    }

    /**
     * Get recent messages
     *
     * @param int $user_id User ID
     * @param int $limit Number of messages to return
     * @return array Array of recent messages
     */
    public function get_recent_messages($user_id, $limit = 5) {
        $messages = $this->data_manager->get_messages($user_id, 'inbox', array(
            'posts_per_page' => $limit
        ));

        return array_map(function($message) {
            return (object) array(
                'ID' => $message['id'],
                'sender' => (object) $message['sender'],
                'subject' => $message['subject'],
                'content' => $message['content'],
                'date' => $message['date'],
                'read' => $message['read_status'] === 'read'
            );
        }, $messages);
    }

    /**
     * Get notifications
     *
     * @param int $user_id User ID
     * @return array Array of notifications
     */
    public function get_notifications($user_id) {
        // Get system notifications
        $notifications = array();
        
        // Add workout reminders
        $last_workout = $this->get_last_workout_date($user_id);
        if ($last_workout && (time() - strtotime($last_workout)) > (7 * 24 * 60 * 60)) {
            $notifications[] = (object) array(
                'ID' => 'workout_reminder',
                'icon' => 'fas fa-dumbbell',
                'content' => __('It\'s been a while since your last workout. Time to get back on track!', 'athlete-dashboard'),
                'date' => current_time('mysql'),
                'read' => false
            );
        }

        // Add goal notifications
        $goals = $this->get_goal_notifications($user_id);
        $notifications = array_merge($notifications, $goals);

        // Add membership notifications
        $membership = $this->get_membership_notifications($user_id);
        $notifications = array_merge($notifications, $membership);

        return $notifications;
    }

    /**
     * Get available recipients
     *
     * @param int $user_id User ID
     * @return array Array of available recipients
     */
    public function get_available_recipients($user_id) {
        // Get trainers and admins
        $args = array(
            'role__in' => array('administrator', 'trainer'),
            'exclude' => array($user_id)
        );

        $users = get_users($args);
        return array_map(function($user) {
            return (object) array(
                'ID' => $user->ID,
                'display_name' => $user->display_name
            );
        }, $users);
    }

    /**
     * Handle send message AJAX request
     */
    public function handle_send_message() {
        check_ajax_referer('athlete_dashboard_nonce', 'nonce');
        
        if (!isset($_POST['message_data'])) {
            wp_send_json_error('No message data provided');
        }

        $message_data = json_decode(stripslashes($_POST['message_data']), true);
        $message_id = $this->data_manager->send_message($message_data);

        if ($message_id) {
            wp_send_json_success(array('id' => $message_id));
        } else {
            wp_send_json_error('Failed to send message');
        }
    }

    /**
     * Handle get messages AJAX request
     */
    public function handle_get_messages() {
        check_ajax_referer('athlete_dashboard_nonce', 'nonce');
        
        $user_id = get_current_user_id();
        $box = isset($_GET['box']) ? sanitize_text_field($_GET['box']) : 'inbox';
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        $messages = $this->data_manager->get_messages($user_id, $box, array(
            'paged' => $page
        ));

        wp_send_json_success($messages);
    }

    /**
     * Handle mark message read AJAX request
     */
    public function handle_mark_message_read() {
        check_ajax_referer('athlete_dashboard_nonce', 'nonce');
        
        if (!isset($_POST['message_id'])) {
            wp_send_json_error('No message ID provided');
        }

        $message_id = intval($_POST['message_id']);
        if ($this->data_manager->mark_as_read($message_id)) {
            wp_send_json_success();
        } else {
            wp_send_json_error('Failed to mark message as read');
        }
    }

    /**
     * Handle delete message AJAX request
     */
    public function handle_delete_message() {
        check_ajax_referer('athlete_dashboard_nonce', 'nonce');
        
        if (!isset($_POST['message_id'])) {
            wp_send_json_error('No message ID provided');
        }

        $message_id = intval($_POST['message_id']);
        if ($this->data_manager->delete_message($message_id)) {
            wp_send_json_success();
        } else {
            wp_send_json_error('Failed to delete message');
        }
    }

    /**
     * Register REST API routes
     */
    public function register_rest_routes() {
        register_rest_route('athlete-dashboard/v1', '/messages', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'get_messages_api'),
                'permission_callback' => array($this, 'get_messages_permission')
            ),
            array(
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => array($this, 'send_message_api'),
                'permission_callback' => array($this, 'send_message_permission')
            )
        ));

        register_rest_route('athlete-dashboard/v1', '/messages/(?P<id>\d+)', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'get_message_api'),
                'permission_callback' => array($this, 'get_messages_permission')
            ),
            array(
                'methods' => WP_REST_Server::DELETABLE,
                'callback' => array($this, 'delete_message_api'),
                'permission_callback' => array($this, 'send_message_permission')
            )
        ));
    }

    /**
     * REST API permission callbacks
     */
    public function get_messages_permission() {
        return is_user_logged_in();
    }

    public function send_message_permission() {
        return is_user_logged_in();
    }

    /**
     * REST API callbacks
     */
    public function get_messages_api($request) {
        $user_id = get_current_user_id();
        $box = $request->get_param('box') ?: 'inbox';
        $page = $request->get_param('page') ?: 1;

        return rest_ensure_response(
            $this->data_manager->get_messages($user_id, $box, array('paged' => $page))
        );
    }

    public function get_message_api($request) {
        $message_id = $request->get_param('id');
        $thread = $this->data_manager->get_thread($message_id);

        if (empty($thread)) {
            return new WP_Error(
                'message_not_found',
                'Message not found',
                array('status' => 404)
            );
        }

        return rest_ensure_response($thread);
    }

    public function send_message_api($request) {
        $message_data = $request->get_json_params();
        $message_id = $this->data_manager->send_message($message_data);

        if ($message_id) {
            return rest_ensure_response(array(
                'id' => $message_id,
                'message' => 'Message sent successfully'
            ));
        }

        return new WP_Error(
            'send_failed',
            'Failed to send message',
            array('status' => 500)
        );
    }

    public function delete_message_api($request) {
        $message_id = $request->get_param('id');
        
        if ($this->data_manager->delete_message($message_id)) {
            return rest_ensure_response(array(
                'message' => 'Message deleted successfully'
            ));
        }

        return new WP_Error(
            'delete_failed',
            'Failed to delete message',
            array('status' => 500)
        );
    }

    /**
     * Helper methods
     */
    private function get_last_workout_date($user_id) {
        // Implement last workout date retrieval
        return null;
    }

    private function get_goal_notifications($user_id) {
        $notifications = array();
        
        // Get goals that are close to deadline
        $goals_manager = new Athlete_Dashboard_Goals_Data_Manager();
        $goals = $goals_manager->get_user_goals($user_id);

        foreach ($goals as $goal) {
            if (!empty($goal['deadline'])) {
                $days_left = ceil((strtotime($goal['deadline']) - time()) / (60 * 60 * 24));
                
                if ($days_left <= 7 && $days_left > 0) {
                    $notifications[] = (object) array(
                        'ID' => 'goal_' . $goal['id'],
                        'icon' => 'fas fa-bullseye',
                        'content' => sprintf(
                            __('Your goal "%s" is due in %d days', 'athlete-dashboard'),
                            $goal['title'],
                            $days_left
                        ),
                        'date' => current_time('mysql'),
                        'read' => false
                    );
                }
            }
        }

        return $notifications;
    }

    private function get_membership_notifications($user_id) {
        $notifications = array();
        
        // Get membership expiration notifications
        $membership_manager = new Athlete_Dashboard_Membership_Data_Manager();
        $details = $membership_manager->get_membership_details($user_id);

        if (!empty($details['end_date'])) {
            $days_left = ceil((strtotime($details['end_date']) - time()) / (60 * 60 * 24));
            
            if ($days_left <= 7 && $days_left > 0) {
                $notifications[] = (object) array(
                    'ID' => 'membership_expiring',
                    'icon' => 'fas fa-clock',
                    'content' => sprintf(
                        __('Your membership expires in %d days', 'athlete-dashboard'),
                        $days_left
                    ),
                    'date' => current_time('mysql'),
                    'read' => false
                );
            }
        }

        return $notifications;
    }
} 