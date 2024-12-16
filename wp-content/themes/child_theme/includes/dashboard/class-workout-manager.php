<?php
/**
 * Workout Manager Class
 * Handles initialization and management of workout-related functionality
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Workout_Manager {
    /**
     * Constructor
     */
    public function __construct() {
        $this->init();
    }

    /**
     * Initialize workout manager
     */
    private function init() {
        // Add workout-specific hooks
        add_action('init', array($this, 'register_workout_post_type'));
        add_action('init', array($this, 'register_workout_taxonomies'));
        
        // Add AJAX handlers
        add_action('wp_ajax_get_workouts', array($this, 'get_workouts'));
        add_action('wp_ajax_save_workout', array($this, 'save_workout'));
        add_action('wp_ajax_delete_workout', array($this, 'delete_workout'));
        add_action('wp_ajax_log_workout', array($this, 'log_workout'));
        
        // Add REST API endpoints
        add_action('rest_api_init', array($this, 'register_rest_routes'));
    }

    /**
     * Register workout post type
     */
    public function register_workout_post_type() {
        $labels = array(
            'name' => __('Workouts', 'athlete-dashboard'),
            'singular_name' => __('Workout', 'athlete-dashboard'),
            'add_new' => __('Add New', 'athlete-dashboard'),
            'add_new_item' => __('Add New Workout', 'athlete-dashboard'),
            'edit_item' => __('Edit Workout', 'athlete-dashboard'),
            'new_item' => __('New Workout', 'athlete-dashboard'),
            'view_item' => __('View Workout', 'athlete-dashboard'),
            'search_items' => __('Search Workouts', 'athlete-dashboard'),
            'not_found' => __('No workouts found', 'athlete-dashboard'),
            'not_found_in_trash' => __('No workouts found in Trash', 'athlete-dashboard'),
            'parent_item_colon' => __('Parent Workout:', 'athlete-dashboard'),
            'menu_name' => __('Workouts', 'athlete-dashboard')
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => false,
            'description' => 'Workout posts',
            'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'has_archive' => true,
            'query_var' => true,
            'can_export' => true,
            'rewrite' => array('slug' => 'workouts'),
            'capability_type' => 'workout',
            'show_in_rest' => true
        );

        register_post_type('workout', $args);
    }

    /**
     * Register workout taxonomies
     */
    public function register_workout_taxonomies() {
        // Register workout categories
        $category_labels = array(
            'name' => __('Workout Categories', 'athlete-dashboard'),
            'singular_name' => __('Category', 'athlete-dashboard'),
            'search_items' => __('Search Categories', 'athlete-dashboard'),
            'all_items' => __('All Categories', 'athlete-dashboard'),
            'parent_item' => __('Parent Category', 'athlete-dashboard'),
            'parent_item_colon' => __('Parent Category:', 'athlete-dashboard'),
            'edit_item' => __('Edit Category', 'athlete-dashboard'),
            'update_item' => __('Update Category', 'athlete-dashboard'),
            'add_new_item' => __('Add New Category', 'athlete-dashboard'),
            'new_item_name' => __('New Category Name', 'athlete-dashboard'),
            'menu_name' => __('Categories', 'athlete-dashboard')
        );

        register_taxonomy('workout_category', 'workout', array(
            'hierarchical' => true,
            'labels' => $category_labels,
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'workout-category')
        ));

        // Register workout tags
        $tag_labels = array(
            'name' => __('Workout Tags', 'athlete-dashboard'),
            'singular_name' => __('Tag', 'athlete-dashboard'),
            'search_items' => __('Search Tags', 'athlete-dashboard'),
            'popular_items' => __('Popular Tags', 'athlete-dashboard'),
            'all_items' => __('All Tags', 'athlete-dashboard'),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => __('Edit Tag', 'athlete-dashboard'),
            'update_item' => __('Update Tag', 'athlete-dashboard'),
            'add_new_item' => __('Add New Tag', 'athlete-dashboard'),
            'new_item_name' => __('New Tag Name', 'athlete-dashboard'),
            'menu_name' => __('Tags', 'athlete-dashboard')
        );

        register_taxonomy('workout_tag', 'workout', array(
            'hierarchical' => false,
            'labels' => $tag_labels,
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'workout-tag')
        ));
    }

    /**
     * Register REST API routes
     */
    public function register_rest_routes() {
        register_rest_route('athlete-dashboard/v1', '/workouts', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'get_workouts_api'),
                'permission_callback' => array($this, 'get_workouts_permission')
            ),
            array(
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => array($this, 'create_workout_api'),
                'permission_callback' => array($this, 'create_workout_permission')
            )
        ));

        register_rest_route('athlete-dashboard/v1', '/workouts/(?P<id>\d+)', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'get_workout_api'),
                'permission_callback' => array($this, 'get_workout_permission')
            ),
            array(
                'methods' => WP_REST_Server::EDITABLE,
                'callback' => array($this, 'update_workout_api'),
                'permission_callback' => array($this, 'update_workout_permission')
            ),
            array(
                'methods' => WP_REST_Server::DELETABLE,
                'callback' => array($this, 'delete_workout_api'),
                'permission_callback' => array($this, 'delete_workout_permission')
            )
        ));
    }

    /**
     * AJAX handler for getting workouts
     */
    public function get_workouts() {
        check_ajax_referer('athlete_dashboard_nonce', 'nonce');
        
        $args = array(
            'post_type' => 'workout',
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC'
        );
        
        $workouts = get_posts($args);
        $formatted_workouts = array_map(array($this, 'format_workout'), $workouts);
        
        wp_send_json_success($formatted_workouts);
    }

    /**
     * AJAX handler for saving workout
     */
    public function save_workout() {
        check_ajax_referer('athlete_dashboard_nonce', 'nonce');
        
        $workout_data = isset($_POST['workout']) ? $_POST['workout'] : array();
        if (empty($workout_data)) {
            wp_send_json_error('No workout data provided');
        }
        
        $workout_id = $this->save_workout_data($workout_data);
        if ($workout_id) {
            wp_send_json_success(array('id' => $workout_id));
        } else {
            wp_send_json_error('Failed to save workout');
        }
    }

    /**
     * AJAX handler for deleting workout
     */
    public function delete_workout() {
        check_ajax_referer('athlete_dashboard_nonce', 'nonce');
        
        $workout_id = isset($_POST['workout_id']) ? intval($_POST['workout_id']) : 0;
        if (!$workout_id) {
            wp_send_json_error('No workout ID provided');
        }
        
        if (wp_delete_post($workout_id, true)) {
            wp_send_json_success('Workout deleted');
        } else {
            wp_send_json_error('Failed to delete workout');
        }
    }

    /**
     * AJAX handler for logging workout
     */
    public function log_workout() {
        check_ajax_referer('athlete_dashboard_nonce', 'nonce');
        
        $log_data = isset($_POST['log']) ? $_POST['log'] : array();
        if (empty($log_data)) {
            wp_send_json_error('No log data provided');
        }
        
        $log_id = $this->save_workout_log($log_data);
        if ($log_id) {
            wp_send_json_success(array('id' => $log_id));
        } else {
            wp_send_json_error('Failed to log workout');
        }
    }

    /**
     * Format workout data for API response
     */
    private function format_workout($workout) {
        return array(
            'id' => $workout->ID,
            'title' => $workout->post_title,
            'description' => $workout->post_content,
            'date' => $workout->post_date,
            'modified' => $workout->post_modified,
            'categories' => wp_get_post_terms($workout->ID, 'workout_category'),
            'tags' => wp_get_post_terms($workout->ID, 'workout_tag'),
            'meta' => get_post_meta($workout->ID)
        );
    }

    /**
     * Save workout data
     */
    private function save_workout_data($data) {
        $post_data = array(
            'post_type' => 'workout',
            'post_status' => 'publish'
        );
        
        if (isset($data['id'])) {
            $post_data['ID'] = $data['id'];
        }
        
        if (isset($data['title'])) {
            $post_data['post_title'] = sanitize_text_field($data['title']);
        }
        
        if (isset($data['description'])) {
            $post_data['post_content'] = wp_kses_post($data['description']);
        }
        
        $workout_id = wp_insert_post($post_data);
        
        if ($workout_id && !is_wp_error($workout_id)) {
            // Save categories
            if (isset($data['categories'])) {
                wp_set_object_terms($workout_id, $data['categories'], 'workout_category');
            }
            
            // Save tags
            if (isset($data['tags'])) {
                wp_set_object_terms($workout_id, $data['tags'], 'workout_tag');
            }
            
            // Save meta data
            if (isset($data['meta']) && is_array($data['meta'])) {
                foreach ($data['meta'] as $key => $value) {
                    update_post_meta($workout_id, $key, $value);
                }
            }
            
            return $workout_id;
        }
        
        return false;
    }

    /**
     * Save workout log
     */
    private function save_workout_log($data) {
        $post_data = array(
            'post_type' => 'workout_log',
            'post_status' => 'publish',
            'post_author' => get_current_user_id()
        );
        
        if (isset($data['workout_id'])) {
            $post_data['post_parent'] = $data['workout_id'];
        }
        
        if (isset($data['notes'])) {
            $post_data['post_content'] = wp_kses_post($data['notes']);
        }
        
        $log_id = wp_insert_post($post_data);
        
        if ($log_id && !is_wp_error($log_id)) {
            // Save log meta data
            if (isset($data['meta']) && is_array($data['meta'])) {
                foreach ($data['meta'] as $key => $value) {
                    update_post_meta($log_id, $key, $value);
                }
            }
            
            return $log_id;
        }
        
        return false;
    }

    /**
     * REST API permission callbacks
     */
    public function get_workouts_permission() {
        return current_user_can('read_workouts');
    }
    
    public function create_workout_permission() {
        return current_user_can('publish_workouts');
    }
    
    public function get_workout_permission() {
        return current_user_can('read_workouts');
    }
    
    public function update_workout_permission() {
        return current_user_can('edit_workouts');
    }
    
    public function delete_workout_permission() {
        return current_user_can('delete_workouts');
    }
} 