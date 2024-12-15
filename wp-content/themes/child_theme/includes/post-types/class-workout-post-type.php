<?php
/**
 * Workout Post Type Class
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Workout_Post_Type {
    /**
     * Initialize the post type
     */
    public function __construct() {
        add_action('init', array($this, 'register_post_type'), 0);
        add_action('init', array($this, 'register_capabilities'), 0);
        add_action('admin_init', array($this, 'add_capabilities_to_roles'));
        
        // Handle activation
        register_activation_hook(__FILE__, array($this, 'activation'));
    }

    /**
     * Register the workout post type
     */
    public function register_post_type() {
        $labels = array(
            'name'               => __('Workouts', 'athlete-dashboard'),
            'singular_name'      => __('Workout', 'athlete-dashboard'),
            'add_new'           => __('Add New', 'athlete-dashboard'),
            'add_new_item'      => __('Add New Workout', 'athlete-dashboard'),
            'edit_item'         => __('Edit Workout', 'athlete-dashboard'),
            'new_item'          => __('New Workout', 'athlete-dashboard'),
            'view_item'         => __('View Workout', 'athlete-dashboard'),
            'search_items'      => __('Search Workouts', 'athlete-dashboard'),
            'not_found'         => __('No workouts found', 'athlete-dashboard'),
            'not_found_in_trash'=> __('No workouts found in trash', 'athlete-dashboard'),
            'parent_item_colon' => '',
            'menu_name'         => __('Workouts', 'athlete-dashboard')
        );

        $capabilities = array(
            'edit_post'          => 'edit_workout',
            'read_post'          => 'read_workout',
            'delete_post'        => 'delete_workout',
            'edit_posts'         => 'edit_workouts',
            'edit_others_posts'  => 'edit_others_workouts',
            'publish_posts'      => 'publish_workouts',
            'read_private_posts' => 'read_private_workouts',
            'delete_posts'       => 'delete_workouts',
            'delete_others_posts'=> 'delete_others_workouts'
        );

        $args = array(
            'labels'              => $labels,
            'public'              => true,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'query_var'           => true,
            'rewrite'             => array('slug' => 'workouts'),
            'capability_type'     => 'workout',
            'capabilities'        => $capabilities,
            'map_meta_cap'        => true,
            'has_archive'         => true,
            'hierarchical'        => false,
            'menu_position'       => null,
            'supports'            => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields'),
            'show_in_rest'        => true,
            'rest_base'           => 'workouts',
            'menu_icon'           => 'dashicons-universal-access'
        );

        register_post_type('workout', $args);
    }

    /**
     * Register capabilities
     */
    public function register_capabilities() {
        global $wp_roles;

        if (!isset($wp_roles)) {
            $wp_roles = new WP_Roles();
        }

        $capabilities = array(
            'read_workout',
            'read_private_workouts',
            'edit_workout',
            'edit_workouts',
            'edit_others_workouts',
            'edit_private_workouts',
            'edit_published_workouts',
            'publish_workouts',
            'delete_workout',
            'delete_workouts',
            'delete_others_workouts',
            'delete_private_workouts',
            'delete_published_workouts'
        );

        // Add capabilities to roles
        $this->add_capabilities_to_roles($capabilities);
    }

    /**
     * Add capabilities to roles
     */
    private function add_capabilities_to_roles($capabilities = array()) {
        // Get roles
        $admin = get_role('administrator');
        $subscriber = get_role('subscriber');

        if ($admin) {
            // Add all capabilities to admin
            foreach ($capabilities as $cap) {
                $admin->add_cap($cap);
            }
        }

        if ($subscriber) {
            // Add limited capabilities to subscriber/athlete
            $subscriber->add_cap('read_workout');
            $subscriber->add_cap('edit_workout');
            $subscriber->add_cap('edit_workouts');
            $subscriber->add_cap('publish_workouts');
            $subscriber->add_cap('delete_workout');
            $subscriber->add_cap('delete_workouts');
            $subscriber->add_cap('edit_published_workouts');
            $subscriber->add_cap('delete_published_workouts');
        }
    }

    /**
     * Handle plugin activation
     */
    public function activation() {
        // Register post type
        $this->register_post_type();
        
        // Register capabilities
        $this->register_capabilities();
        
        // Flush rewrite rules
        flush_rewrite_rules();
    }
} 