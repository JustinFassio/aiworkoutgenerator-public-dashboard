<?php
/**
 * Workout Data Manager Class
 * 
 * Handles workout-related data operations and caching
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Workout_Data_Manager extends Athlete_Dashboard_Data_Manager {
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
        if (!$workout || $workout->post_type !== 'workout') {
            return false;
        }

        // Check if user can read this workout
        if (!current_user_can('read_workout', $workout_id)) {
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
            'modified' => get_the_modified_date('c', $workout),
            'can_edit' => current_user_can('edit_workout', $workout->ID),
            'can_delete' => current_user_can('delete_workout', $workout->ID)
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

        // Check if user can edit this workout
        if (!current_user_can('edit_workout', $data['id'])) {
            return new WP_Error('permission_denied', __('You do not have permission to edit this workout', 'athlete-dashboard'));
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
        }, $exercises);
    }

    /**
     * Log a workout
     */
    public function log_workout($workout_data) {
        if (!$this->validate_required_fields($workout_data, $this->required_workout_fields)) {
            return false;
        }

        return $this->transaction(function() use ($workout_data) {
            $post_data = array(
                'post_title' => sanitize_text_field($workout_data['title']),
                'post_type' => 'workout_log',
                'post_status' => 'publish',
                'post_author' => get_current_user_id()
            );

            $post_id = wp_insert_post($post_data);
            if (!$post_id) {
                $this->add_error('insert_failed', __('Failed to create workout log entry', 'athlete-dashboard'));
                return false;
            }

            // Save workout metadata
            update_post_meta($post_id, '_workout_type', sanitize_text_field($workout_data['type']));
            update_post_meta($post_id, '_workout_exercises', $workout_data['exercises']);
            update_post_meta($post_id, '_workout_notes', sanitize_textarea_field($workout_data['notes']));
            update_post_meta($post_id, '_workout_date', sanitize_text_field($workout_data['date']));

            // Clear cached data
            $date = substr($workout_data['date'], 0, 10);
            $user_id = get_current_user_id();
            $this->delete_cached_data("workouts_{$user_id}_{$date}");
            $this->delete_cached_data("stats_{$user_id}");

            return $post_id;
        });
    }

    /**
     * Delete a workout
     */
    public function delete_workout($workout_id) {
        $post = get_post($workout_id);
        if (!$post || ($post->post_author != get_current_user_id() && !current_user_can('delete_others_posts'))) {
            $this->add_error('permission_denied', __('You do not have permission to delete this workout', 'athlete-dashboard'));
            return false;
        }

        return wp_delete_post($workout_id, true);
    }

    /**
     * Get workouts for a specific date
     */
    public function get_workouts($date, $user_id = null) {
        if (!$user_id) {
            $user_id = get_current_user_id();
        }

        return $this->get_cached_data("workouts_{$user_id}_{$date}", function() use ($user_id, $date) {
            $args = array(
                'post_type' => 'workout_log',
                'post_status' => 'publish',
                'author' => $user_id,
                'date_query' => array(
                    array(
                        'year' => date('Y', strtotime($date)),
                        'month' => date('m', strtotime($date)),
                        'day' => date('d', strtotime($date))
                    )
                ),
                'posts_per_page' => -1
            );

            $query = new WP_Query($args);
            $workouts = array();

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $workouts[] = array(
                        'id' => get_the_ID(),
                        'title' => get_the_title(),
                        'type' => get_post_meta(get_the_ID(), '_workout_type', true),
                        'exercises' => get_post_meta(get_the_ID(), '_workout_exercises', true),
                        'notes' => get_post_meta(get_the_ID(), '_workout_notes', true),
                        'date' => get_post_meta(get_the_ID(), '_workout_date', true)
                    );
                }
                wp_reset_postdata();
            }

            return $workouts;
        });
    }

    /**
     * Get workout statistics
     */
    public function get_workout_stats($user_id = null) {
        if (!$user_id) {
            $user_id = get_current_user_id();
        }

        return $this->get_cached_data("stats_{$user_id}", function() use ($user_id) {
            $args = array(
                'post_type' => 'workout_log',
                'post_status' => 'publish',
                'author' => $user_id,
                'posts_per_page' => -1
            );

            $query = new WP_Query($args);
            $stats = array(
                'total_workouts' => $query->found_posts,
                'workout_types' => array(),
                'recent_workouts' => array()
            );

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $type = get_post_meta(get_the_ID(), '_workout_type', true);
                    
                    // Count workout types
                    if (!isset($stats['workout_types'][$type])) {
                        $stats['workout_types'][$type] = 0;
                    }
                    $stats['workout_types'][$type]++;

                    // Get recent workouts
                    if (count($stats['recent_workouts']) < 5) {
                        $stats['recent_workouts'][] = array(
                            'id' => get_the_ID(),
                            'title' => get_the_title(),
                            'type' => $type,
                            'date' => get_post_meta(get_the_ID(), '_workout_date', true)
                        );
                    }
                }
                wp_reset_postdata();
            }

            return $stats;
        });
    }
} 