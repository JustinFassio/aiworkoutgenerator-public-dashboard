<?php
/**
 * Exercise Data Manager Class
 * 
 * Handles exercise data operations and queries
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Exercise_Data_Manager extends Athlete_Dashboard_Data_Manager {
    /**
     * Initialize the data manager
     */
    public function __construct() {
        parent::__construct('exercise_data');
    }

    /**
     * Get exercise categories
     *
     * @param array $args Optional. Query arguments
     * @return array Array of exercise categories
     */
    public function get_exercise_categories($args = array()) {
        $default_args = array(
            'taxonomy' => 'exercise_category',
            'hide_empty' => false,
            'orderby' => 'name',
            'order' => 'ASC'
        );

        $args = wp_parse_args($args, $default_args);
        return get_terms($args);
    }

    /**
     * Get exercise equipment
     *
     * @param array $args Optional. Query arguments
     * @return array Array of exercise equipment
     */
    public function get_exercise_equipment($args = array()) {
        $default_args = array(
            'taxonomy' => 'exercise_equipment',
            'hide_empty' => false,
            'orderby' => 'name',
            'order' => 'ASC'
        );

        $args = wp_parse_args($args, $default_args);
        return get_terms($args);
    }

    /**
     * Get muscle groups
     *
     * @param array $args Optional. Query arguments
     * @return array Array of muscle groups
     */
    public function get_muscle_groups($args = array()) {
        $default_args = array(
            'taxonomy' => 'exercise_muscle_group',
            'hide_empty' => false,
            'orderby' => 'name',
            'order' => 'ASC'
        );

        $args = wp_parse_args($args, $default_args);
        return get_terms($args);
    }

    /**
     * Get difficulty levels
     *
     * @param array $args Optional. Query arguments
     * @return array Array of difficulty levels
     */
    public function get_difficulty_levels($args = array()) {
        $default_args = array(
            'taxonomy' => 'exercise_difficulty',
            'hide_empty' => false,
            'orderby' => 'name',
            'order' => 'ASC'
        );

        $args = wp_parse_args($args, $default_args);
        return get_terms($args);
    }

    /**
     * Search exercises
     *
     * @param array $args Search arguments
     * @return array Array of exercises
     */
    public function search_exercises($args) {
        $default_args = array(
            'post_type' => 'workout',
            'posts_per_page' => 10,
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => '_workout_exercises',
                    'compare' => 'EXISTS'
                )
            )
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

        $query_args = wp_parse_args($args, $default_args);
        $posts = get_posts($query_args);
        
        // Extract exercises from workout posts
        $exercises = array();
        foreach ($posts as $post) {
            $post_exercises = get_post_meta($post->ID, '_workout_exercises', true);
            if (is_array($post_exercises)) {
                foreach ($post_exercises as $exercise) {
                    $exercise['workout_id'] = $post->ID;
                    $exercise['workout_title'] = $post->post_title;
                    $exercises[] = $exercise;
                }
            }
        }

        return $exercises;
    }

    /**
     * Get exercise history for a user
     *
     * @param int $user_id User ID
     * @param string $exercise_name Exercise name
     * @return array Array of exercise history
     */
    public function get_exercise_history($user_id, $exercise_name) {
        $logs = get_posts(array(
            'post_type' => 'workout_log',
            'author' => $user_id,
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC'
        ));

        $history = array();
        foreach ($logs as $log) {
            $completed_exercises = get_post_meta($log->ID, '_completed_exercises', true);
            if (!is_array($completed_exercises)) {
                continue;
            }

            foreach ($completed_exercises as $exercise) {
                if (isset($exercise['name']) && $exercise['name'] === $exercise_name) {
                    $history[] = array(
                        'date' => get_post_meta($log->ID, '_workout_date', true),
                        'sets_completed' => $exercise['sets_completed'],
                        'reps_completed' => $exercise['reps_completed'],
                        'weight_used' => $exercise['weight_used'],
                        'notes' => $exercise['notes']
                    );
                }
            }
        }

        return $history;
    }

    /**
     * Get exercise statistics for a user
     *
     * @param int $user_id User ID
     * @param string $exercise_name Exercise name
     * @return array Exercise statistics
     */
    public function get_exercise_stats($user_id, $exercise_name) {
        $history = $this->get_exercise_history($user_id, $exercise_name);
        
        if (empty($history)) {
            return array(
                'total_sets' => 0,
                'total_reps' => 0,
                'max_weight' => 0,
                'avg_weight' => 0,
                'progress' => array()
            );
        }

        $total_sets = 0;
        $total_reps = 0;
        $max_weight = 0;
        $total_weight = 0;
        $weight_count = 0;
        $progress = array();

        foreach ($history as $entry) {
            $total_sets += $entry['sets_completed'];
            $total_reps += $entry['reps_completed'];
            
            if ($entry['weight_used'] > 0) {
                $max_weight = max($max_weight, $entry['weight_used']);
                $total_weight += $entry['weight_used'];
                $weight_count++;
            }

            $progress[] = array(
                'date' => $entry['date'],
                'weight' => $entry['weight_used'],
                'reps' => $entry['reps_completed']
            );
        }

        return array(
            'total_sets' => $total_sets,
            'total_reps' => $total_reps,
            'max_weight' => $max_weight,
            'avg_weight' => $weight_count > 0 ? $total_weight / $weight_count : 0,
            'progress' => $progress
        );
    }

    /**
     * Get most used exercises for a user
     *
     * @param int $user_id User ID
     * @param int $limit Optional. Number of exercises to return
     * @return array Array of most used exercises
     */
    public function get_most_used_exercises($user_id, $limit = 5) {
        $logs = get_posts(array(
            'post_type' => 'workout_log',
            'author' => $user_id,
            'posts_per_page' => -1
        ));

        $exercise_counts = array();
        foreach ($logs as $log) {
            $completed_exercises = get_post_meta($log->ID, '_completed_exercises', true);
            if (!is_array($completed_exercises)) {
                continue;
            }

            foreach ($completed_exercises as $exercise) {
                if (!isset($exercise['name'])) {
                    continue;
                }

                $name = $exercise['name'];
                if (!isset($exercise_counts[$name])) {
                    $exercise_counts[$name] = array(
                        'count' => 0,
                        'total_sets' => 0,
                        'total_reps' => 0,
                        'max_weight' => 0
                    );
                }

                $exercise_counts[$name]['count']++;
                $exercise_counts[$name]['total_sets'] += $exercise['sets_completed'];
                $exercise_counts[$name]['total_reps'] += $exercise['reps_completed'];
                $exercise_counts[$name]['max_weight'] = max(
                    $exercise_counts[$name]['max_weight'],
                    $exercise['weight_used']
                );
            }
        }

        // Sort by count
        uasort($exercise_counts, function($a, $b) {
            return $b['count'] - $a['count'];
        });

        // Return top exercises
        return array_slice($exercise_counts, 0, $limit, true);
    }

    /**
     * Get exercise recommendations for a user
     *
     * @param int $user_id User ID
     * @param int $limit Optional. Number of recommendations to return
     * @return array Array of recommended exercises
     */
    public function get_exercise_recommendations($user_id, $limit = 5) {
        // Get user's most used muscle groups
        $logs = get_posts(array(
            'post_type' => 'workout_log',
            'author' => $user_id,
            'posts_per_page' => -1,
            'fields' => 'ids'
        ));

        $muscle_groups = array();
        foreach ($logs as $log_id) {
            $workout_id = get_post_meta($log_id, '_workout_id', true);
            if (!$workout_id) {
                continue;
            }

            $terms = wp_get_post_terms($workout_id, 'exercise_muscle_group', array('fields' => 'slugs'));
            $muscle_groups = array_merge($muscle_groups, $terms);
        }

        // Count muscle group occurrences
        $muscle_group_counts = array_count_values($muscle_groups);
        arsort($muscle_group_counts);
        $top_muscle_groups = array_slice(array_keys($muscle_group_counts), 0, 3);

        // Get exercises targeting similar muscle groups
        $exercises = $this->search_exercises(array(
            'muscle_groups' => $top_muscle_groups,
            'posts_per_page' => $limit * 2 // Get more than needed to filter
        ));

        // Filter out exercises the user has already done
        $used_exercises = array_keys($this->get_most_used_exercises($user_id, -1));
        $recommendations = array_filter($exercises, function($exercise) use ($used_exercises) {
            return !in_array($exercise['name'], $used_exercises);
        });

        return array_slice($recommendations, 0, $limit);
    }
} 