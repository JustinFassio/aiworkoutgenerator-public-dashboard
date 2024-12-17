<?php
/**
 * Dashboard Component
 */

if (!defined('ABSPATH')) {
    exit;
}

class Dashboard {
    public function __construct() {
        add_action('init', array($this, 'register_workout_post_type'));
    }

    public function register_workout_post_type() {
        $labels = array(
            'name'               => __('Workouts', 'athlete-dashboard-child'),
            'singular_name'      => __('Workout', 'athlete-dashboard-child'),
            'menu_name'          => __('Workouts', 'athlete-dashboard-child'),
            'add_new'           => __('Add New', 'athlete-dashboard-child'),
            'add_new_item'      => __('Add New Workout', 'athlete-dashboard-child'),
            'edit_item'         => __('Edit Workout', 'athlete-dashboard-child'),
            'new_item'          => __('New Workout', 'athlete-dashboard-child'),
            'view_item'         => __('View Workout', 'athlete-dashboard-child'),
            'search_items'      => __('Search Workouts', 'athlete-dashboard-child'),
            'not_found'         => __('No workouts found', 'athlete-dashboard-child'),
            'not_found_in_trash'=> __('No workouts found in trash', 'athlete-dashboard-child')
        );

        $args = array(
            'labels'              => $labels,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-universal-access',
            'hierarchical'        => false,
            'supports'            => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields'),
            'has_archive'         => true,
            'rewrite'            => array('slug' => 'workouts'),
            'capability_type'    => 'post'
        );

        register_post_type('workout', $args);
    }

    public function get_dashboard_stats() {
        $user_id = get_current_user_id();
        
        // Get total workouts generated
        $generated_args = array(
            'post_type' => 'workout',
            'author' => $user_id,
            'posts_per_page' => -1,
            'post_status' => 'publish'
        );
        $generated_query = new WP_Query($generated_args);
        $workouts_generated = $generated_query->found_posts;

        // Get completed workouts
        $completed_args = array(
            'post_type' => 'workout',
            'author' => $user_id,
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => '_workout_completed',
                    'value' => '1',
                    'compare' => '='
                )
            )
        );
        $completed_query = new WP_Query($completed_args);
        $workouts_completed = $completed_query->found_posts;

        // Calculate progress (completed vs generated)
        $progress = $workouts_generated > 0 
            ? round(($workouts_completed / $workouts_generated) * 100) 
            : 0;

        return array(
            'workouts_generated' => $workouts_generated,
            'workouts_completed' => $workouts_completed,
            'progress' => $progress
        );
    }

    public function get_recent_workouts($limit = 3) {
        $args = array(
            'post_type' => 'workout',
            'author' => get_current_user_id(),
            'posts_per_page' => $limit,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC'
        );

        $query = new WP_Query($args);
        return $query->posts;
    }

    public function mark_workout_completed($workout_id) {
        if (!current_user_can('edit_post', $workout_id)) {
            return false;
        }

        update_post_meta($workout_id, '_workout_completed', '1');
        update_post_meta($workout_id, '_workout_completed_date', current_time('mysql'));
        
        return true;
    }
} 