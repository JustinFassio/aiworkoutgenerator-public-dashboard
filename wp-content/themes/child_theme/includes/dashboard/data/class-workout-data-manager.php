<?php
/**
 * Workout Data Manager Class
 *
 * Handles all workout data operations and caching
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Workout_Data_Manager {
    /**
     * Cache group for workouts
     */
    private $cache_group = 'athlete_workouts';

    /**
     * Initialize the data manager
     */
    public function __construct() {
        // Ensure cache group is registered
        wp_cache_add_non_persistent_groups($this->cache_group);
    }

    /**
     * Get a workout by ID
     *
     * @param int $workout_id The workout ID
     * @return array|false Workout data or false if not found
     */
    public function get_workout($workout_id) {
        // Try to get from cache first
        $cached = wp_cache_get($workout_id, $this->cache_group);
        if ($cached !== false) {
            return $cached;
        }

        // Get the workout post
        $workout = get_post($workout_id);
        if (!$workout) {
            return false;
        }

        // Build workout data
        $workout_data = $this->build_workout_data($workout);
        
        // Cache the result
        wp_cache_set($workout_id, $workout_data, $this->cache_group);

        return $workout_data;
    }

    /**
     * Build complete workout data from a post object
     *
     * @param WP_Post $workout The workout post object
     * @return array The complete workout data
     */
    private function build_workout_data($workout) {
        // Get workout metadata
        $workout_type = get_post_meta($workout->ID, '_workout_type', true) ?: 'standard';
        $exercises = get_post_meta($workout->ID, '_workout_exercises', true);
        $duration = get_post_meta($workout->ID, '_workout_duration', true);
        $intensity = get_post_meta($workout->ID, '_workout_intensity', true);
        $target_areas = get_post_meta($workout->ID, '_workout_target_areas', true);
        $notes = get_post_meta($workout->ID, '_workout_notes', true);
        
        // Ensure exercises is an array
        if (empty($exercises) || !is_array($exercises)) {
            $exercises = array();
        }

        // Process the content
        $processed_content = apply_filters('the_content', $workout->post_content);

        // Build the complete data structure
        return array(
            'id' => $workout->ID,
            'title' => $workout->post_title,
            'type' => $workout_type,
            'exercises' => $exercises,
            'content' => $processed_content,
            'author' => $workout->post_author,
            'date' => get_the_date('F j, Y', $workout),
            'duration' => $duration,
            'intensity' => $intensity,
            'target_areas' => $target_areas,
            'notes' => $notes,
            'raw_content' => $workout->post_content,
            'modified' => get_the_modified_date('c', $workout)
        );
    }

    /**
     * Save workout data
     *
     * @param array $data The workout data to save
     * @return array|WP_Error The saved workout data or WP_Error on failure
     */
    public function save_workout($data) {
        if (empty($data['id'])) {
            return new WP_Error('invalid_id', __('Invalid workout ID', 'athlete-dashboard'));
        }

        // Start transaction
        global $wpdb;
        $wpdb->query('START TRANSACTION');

        try {
            // Prepare post data
            $post_data = array(
                'ID' => $data['id'],
                'post_title' => sanitize_text_field($data['title']),
                'post_type' => 'workout',
                'post_status' => 'publish'
            );

            // Update the post
            $updated = wp_update_post($post_data, true);
            if (is_wp_error($updated)) {
                throw new Exception($updated->get_error_message());
            }

            // Update metadata
            if (isset($data['type'])) {
                update_post_meta($data['id'], '_workout_type', sanitize_text_field($data['type']));
            }
            
            if (isset($data['exercises'])) {
                update_post_meta($data['id'], '_workout_exercises', $this->sanitize_exercises($data['exercises']));
            }

            // Clear caches
            $this->clear_workout_cache($data['id']);

            // Get fresh workout data
            $workout_data = $this->get_workout($data['id']);
            
            $wpdb->query('COMMIT');
            return $workout_data;

        } catch (Exception $e) {
            $wpdb->query('ROLLBACK');
            return new WP_Error('save_failed', $e->getMessage());
        }
    }

    /**
     * Clear workout cache
     *
     * @param int $workout_id The workout ID
     */
    public function clear_workout_cache($workout_id) {
        wp_cache_delete($workout_id, $this->cache_group);
        wp_cache_delete($workout_id, 'posts');
        wp_cache_delete($workout_id, 'post_meta');
    }

    /**
     * Sanitize exercise data
     *
     * @param array $exercises Array of exercise data
     * @return array Sanitized exercise data
     */
    private function sanitize_exercises($exercises) {
        if (!is_array($exercises)) {
            return array();
        }

        return array_map(function($exercise) {
            if (!isset($exercise['name']) || empty($exercise['name'])) {
                return null;
            }

            return array(
                'name' => sanitize_text_field($exercise['name']),
                'sets' => isset($exercise['sets']) ? absint($exercise['sets']) : 0,
                'reps' => isset($exercise['reps']) ? absint($exercise['reps']) : 0,
                'weight' => isset($exercise['weight']) ? floatval($exercise['weight']) : 0,
                'notes' => isset($exercise['notes']) ? sanitize_textarea_field($exercise['notes']) : ''
            );
        }, array_filter($exercises));
    }
} 