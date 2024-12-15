<?php
/**
 * Workout Data Manager Class
 * 
 * Handles workout data operations and queries
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Workout_Data_Manager extends Athlete_Dashboard_Data_Manager {
    /**
     * Initialize the data manager
     */
    public function __construct() {
        parent::__construct('workout_data');
    }

    /**
     * Get user's workouts
     *
     * @param int $user_id User ID
     * @param array $args Optional. Query arguments
     * @return array Array of workout posts
     */
    public function get_user_workouts($user_id, $args = array()) {
        $default_args = array(
            'post_type' => 'workout',
            'posts_per_page' => -1,
            'author' => $user_id,
            'orderby' => 'date',
            'order' => 'DESC'
        );

        $args = wp_parse_args($args, $default_args);
        return get_posts($args);
    }

    /**
     * Get workout details
     *
     * @param int $workout_id Workout post ID
     * @return array|WP_Error Workout details or error object
     */
    public function get_workout_details($workout_id) {
        $workout = get_post($workout_id);
        if (!$workout || $workout->post_type !== 'workout') {
            return new WP_Error('invalid_workout', __('Invalid workout ID', 'athlete-dashboard'));
        }

        return array(
            'id' => $workout->ID,
            'title' => $workout->post_title,
            'description' => $workout->post_content,
            'type' => get_post_meta($workout_id, '_workout_type', true),
            'duration' => get_post_meta($workout_id, '_workout_duration', true),
            'intensity' => get_post_meta($workout_id, '_workout_intensity', true),
            'target_areas' => get_post_meta($workout_id, '_workout_target_areas', true),
            'exercises' => get_post_meta($workout_id, '_workout_exercises', true),
            'categories' => wp_get_post_terms($workout_id, 'exercise_category', array('fields' => 'names')),
            'equipment' => wp_get_post_terms($workout_id, 'exercise_equipment', array('fields' => 'names')),
            'muscle_groups' => wp_get_post_terms($workout_id, 'exercise_muscle_group', array('fields' => 'names')),
            'difficulty' => wp_get_post_terms($workout_id, 'exercise_difficulty', array('fields' => 'names'))
        );
    }

    /**
     * Create a new workout
     *
     * @param array $workout_data Workout data
     * @param int $user_id User ID
     * @return int|WP_Error Created workout ID or error object
     */
    public function create_workout($workout_data, $user_id) {
        if (!$this->user_can('publish_workouts')) {
            return new WP_Error('permission_denied', __('You do not have permission to create workouts', 'athlete-dashboard'));
        }

        $workout = array(
            'post_title' => sanitize_text_field($workout_data['title']),
            'post_content' => wp_kses_post($workout_data['description']),
            'post_status' => 'publish',
            'post_type' => 'workout',
            'post_author' => $user_id
        );

        $workout_id = wp_insert_post($workout, true);
        if (is_wp_error($workout_id)) {
            return $workout_id;
        }

        // Update workout meta
        $this->update_workout_meta($workout_id, $workout_data);

        // Set taxonomies
        if (!empty($workout_data['categories'])) {
            wp_set_object_terms($workout_id, $workout_data['categories'], 'exercise_category');
        }
        if (!empty($workout_data['equipment'])) {
            wp_set_object_terms($workout_id, $workout_data['equipment'], 'exercise_equipment');
        }
        if (!empty($workout_data['muscle_groups'])) {
            wp_set_object_terms($workout_id, $workout_data['muscle_groups'], 'exercise_muscle_group');
        }
        if (!empty($workout_data['difficulty'])) {
            wp_set_object_terms($workout_id, $workout_data['difficulty'], 'exercise_difficulty');
        }

        return $workout_id;
    }

    /**
     * Update an existing workout
     *
     * @param int $workout_id Workout ID
     * @param array $workout_data Updated workout data
     * @return bool|WP_Error True on success, error object on failure
     */
    public function update_workout($workout_id, $workout_data) {
        if (!$this->user_can('edit_workout', $workout_id)) {
            return new WP_Error('permission_denied', __('You do not have permission to edit this workout', 'athlete-dashboard'));
        }

        $workout = array(
            'ID' => $workout_id,
            'post_title' => sanitize_text_field($workout_data['title']),
            'post_content' => wp_kses_post($workout_data['description'])
        );

        $updated = wp_update_post($workout, true);
        if (is_wp_error($updated)) {
            return $updated;
        }

        // Update workout meta
        $this->update_workout_meta($workout_id, $workout_data);

        // Update taxonomies
        if (isset($workout_data['categories'])) {
            wp_set_object_terms($workout_id, $workout_data['categories'], 'exercise_category');
        }
        if (isset($workout_data['equipment'])) {
            wp_set_object_terms($workout_id, $workout_data['equipment'], 'exercise_equipment');
        }
        if (isset($workout_data['muscle_groups'])) {
            wp_set_object_terms($workout_id, $workout_data['muscle_groups'], 'exercise_muscle_group');
        }
        if (isset($workout_data['difficulty'])) {
            wp_set_object_terms($workout_id, $workout_data['difficulty'], 'exercise_difficulty');
        }

        return true;
    }

    /**
     * Delete a workout
     *
     * @param int $workout_id Workout ID
     * @return bool|WP_Error True on success, error object on failure
     */
    public function delete_workout($workout_id) {
        if (!$this->user_can('delete_workout', $workout_id)) {
            return new WP_Error('permission_denied', __('You do not have permission to delete this workout', 'athlete-dashboard'));
        }

        $result = wp_delete_post($workout_id, true);
        return $result ? true : new WP_Error('delete_failed', __('Failed to delete workout', 'athlete-dashboard'));
    }

    /**
     * Search workouts
     *
     * @param array $args Search arguments
     * @return array Array of workout posts
     */
    public function search_workouts($args) {
        $default_args = array(
            'post_type' => 'workout',
            'posts_per_page' => 10,
            'orderby' => 'date',
            'order' => 'DESC'
        );

        // Add taxonomy queries if provided
        $tax_query = array();
        
        if (!empty($args['categories'])) {
            $tax_query[] = array(
                'taxonomy' => 'exercise_category',
                'field' => 'slug',
                'terms' => $args['categories']
            );
        }
        
        if (!empty($args['equipment'])) {
            $tax_query[] = array(
                'taxonomy' => 'exercise_equipment',
                'field' => 'slug',
                'terms' => $args['equipment']
            );
        }
        
        if (!empty($args['muscle_groups'])) {
            $tax_query[] = array(
                'taxonomy' => 'exercise_muscle_group',
                'field' => 'slug',
                'terms' => $args['muscle_groups']
            );
        }
        
        if (!empty($args['difficulty'])) {
            $tax_query[] = array(
                'taxonomy' => 'exercise_difficulty',
                'field' => 'slug',
                'terms' => $args['difficulty']
            );
        }

        if (!empty($tax_query)) {
            $tax_query['relation'] = 'AND';
            $args['tax_query'] = $tax_query;
        }

        // Add meta queries if provided
        $meta_query = array();
        
        if (!empty($args['type'])) {
            $meta_query[] = array(
                'key' => '_workout_type',
                'value' => $args['type']
            );
        }
        
        if (!empty($args['duration'])) {
            $meta_query[] = array(
                'key' => '_workout_duration',
                'value' => $args['duration'],
                'type' => 'NUMERIC',
                'compare' => '<='
            );
        }
        
        if (!empty($args['intensity'])) {
            $meta_query[] = array(
                'key' => '_workout_intensity',
                'value' => $args['intensity'],
                'type' => 'NUMERIC',
                'compare' => '<='
            );
        }

        if (!empty($meta_query)) {
            $meta_query['relation'] = 'AND';
            $args['meta_query'] = $meta_query;
        }

        $query_args = wp_parse_args($args, $default_args);
        return get_posts($query_args);
    }

    /**
     * Update workout meta data
     *
     * @param int $workout_id Workout ID
     * @param array $workout_data Workout data
     */
    private function update_workout_meta($workout_id, $workout_data) {
        if (isset($workout_data['type'])) {
            update_post_meta($workout_id, '_workout_type', sanitize_text_field($workout_data['type']));
        }
        if (isset($workout_data['duration'])) {
            update_post_meta($workout_id, '_workout_duration', absint($workout_data['duration']));
        }
        if (isset($workout_data['intensity'])) {
            update_post_meta($workout_id, '_workout_intensity', $this->sanitize_intensity($workout_data['intensity']));
        }
        if (isset($workout_data['target_areas'])) {
            update_post_meta($workout_id, '_workout_target_areas', $this->sanitize_target_areas($workout_data['target_areas']));
        }
        if (isset($workout_data['exercises'])) {
            update_post_meta($workout_id, '_workout_exercises', $this->sanitize_exercises($workout_data['exercises']));
        }
    }

    /**
     * Get recommended workouts for user
     *
     * @param int $user_id User ID
     * @param int $limit Number of recommendations to return
     * @return array Array of recommended workouts
     */
    public function get_recommended_workouts($user_id, $limit = 5) {
        // Get user's completed workouts
        $completed_workouts = get_posts(array(
            'post_type' => 'workout_log',
            'author' => $user_id,
            'posts_per_page' => -1,
            'fields' => 'ids'
        ));

        // Get workout IDs from logs
        $workout_ids = array();
        foreach ($completed_workouts as $log_id) {
            $workout_id = get_post_meta($log_id, '_workout_id', true);
            if ($workout_id) {
                $workout_ids[] = $workout_id;
            }
        }

        // Get most common categories and muscle groups from completed workouts
        $categories = array();
        $muscle_groups = array();
        foreach ($workout_ids as $workout_id) {
            $cats = wp_get_post_terms($workout_id, 'exercise_category', array('fields' => 'slugs'));
            $muscles = wp_get_post_terms($workout_id, 'exercise_muscle_group', array('fields' => 'slugs'));
            
            $categories = array_merge($categories, $cats);
            $muscle_groups = array_merge($muscle_groups, $muscles);
        }

        // Count occurrences
        $category_counts = array_count_values($categories);
        $muscle_group_counts = array_count_values($muscle_groups);

        // Get top categories and muscle groups
        arsort($category_counts);
        arsort($muscle_group_counts);
        $top_categories = array_slice(array_keys($category_counts), 0, 3);
        $top_muscle_groups = array_slice(array_keys($muscle_group_counts), 0, 3);

        // Query for recommended workouts
        $args = array(
            'post_type' => 'workout',
            'posts_per_page' => $limit,
            'post__not_in' => $workout_ids,
            'orderby' => 'rand',
            'tax_query' => array(
                'relation' => 'OR',
                array(
                    'taxonomy' => 'exercise_category',
                    'field' => 'slug',
                    'terms' => $top_categories
                ),
                array(
                    'taxonomy' => 'exercise_muscle_group',
                    'field' => 'slug',
                    'terms' => $top_muscle_groups
                )
            )
        );

        return get_posts($args);
    }
} 