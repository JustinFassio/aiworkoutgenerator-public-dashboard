<?php
/**
 * Goals Data Manager Class
 * Handles data operations for athlete goals
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Goals_Data_Manager {
    /**
     * Get goals for a user
     *
     * @param int $user_id User ID
     * @return array Array of formatted goals
     */
    public function get_user_goals($user_id) {
        $args = array(
            'post_type' => 'athlete_goal',
            'author' => $user_id,
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC'
        );

        $goals = get_posts($args);
        return array_map(array($this, 'format_goal'), $goals);
    }

    /**
     * Save goal data
     *
     * @param array $data Goal data
     * @return int|false Post ID on success, false on failure
     */
    public function save_goal_data($data) {
        $post_data = array(
            'post_type' => 'athlete_goal',
            'post_status' => 'publish',
            'post_author' => get_current_user_id()
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

        $goal_id = wp_insert_post($post_data);

        if ($goal_id && !is_wp_error($goal_id)) {
            // Save category
            if (isset($data['category'])) {
                wp_set_object_terms($goal_id, $data['category'], 'goal_category');
            }

            // Save meta data
            $meta_fields = array('target', 'progress', 'deadline', 'status');
            foreach ($meta_fields as $field) {
                if (isset($data[$field])) {
                    update_post_meta($goal_id, 'goal_' . $field, $data[$field]);
                }
            }

            return $goal_id;
        }

        return false;
    }

    /**
     * Update goal progress
     *
     * @param int $goal_id Goal ID
     * @param float $progress Progress value
     * @return bool True on success, false on failure
     */
    public function update_goal_progress($goal_id, $progress) {
        return update_post_meta($goal_id, 'goal_progress', $progress);
    }

    /**
     * Delete goal
     *
     * @param int $goal_id Goal ID
     * @return bool True on success, false on failure
     */
    public function delete_goal($goal_id) {
        $post = get_post($goal_id);
        if (!$post || $post->post_type !== 'athlete_goal') {
            return false;
        }

        return wp_delete_post($goal_id, true);
    }

    /**
     * Format goal data for API response
     *
     * @param WP_Post $goal Goal post object
     * @return array Formatted goal data
     */
    private function format_goal($goal) {
        return array(
            'id' => $goal->ID,
            'title' => $goal->post_title,
            'description' => $goal->post_content,
            'date' => $goal->post_date,
            'modified' => $goal->post_modified,
            'category' => wp_get_post_terms($goal->ID, 'goal_category'),
            'target' => get_post_meta($goal->ID, 'goal_target', true),
            'progress' => get_post_meta($goal->ID, 'goal_progress', true),
            'deadline' => get_post_meta($goal->ID, 'goal_deadline', true),
            'status' => get_post_meta($goal->ID, 'goal_status', true)
        );
    }

    /**
     * Get goal by ID
     *
     * @param int $goal_id Goal ID
     * @return array|false Formatted goal data or false if not found
     */
    public function get_goal($goal_id) {
        $goal = get_post($goal_id);
        if (!$goal || $goal->post_type !== 'athlete_goal') {
            return false;
        }

        return $this->format_goal($goal);
    }

    /**
     * Get goals by category
     *
     * @param int $user_id User ID
     * @param string $category Category slug
     * @return array Array of formatted goals
     */
    public function get_goals_by_category($user_id, $category) {
        $args = array(
            'post_type' => 'athlete_goal',
            'author' => $user_id,
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'goal_category',
                    'field' => 'slug',
                    'terms' => $category
                )
            )
        );

        $goals = get_posts($args);
        return array_map(array($this, 'format_goal'), $goals);
    }

    /**
     * Get goal statistics
     *
     * @param int $user_id User ID
     * @return array Goal statistics
     */
    public function get_goal_stats($user_id) {
        $goals = $this->get_user_goals($user_id);
        
        $stats = array(
            'total' => count($goals),
            'completed' => 0,
            'in_progress' => 0,
            'not_started' => 0,
            'overdue' => 0
        );

        foreach ($goals as $goal) {
            $progress = floatval($goal['progress']);
            $target = floatval($goal['target']);
            $deadline = $goal['deadline'];

            if ($progress >= $target) {
                $stats['completed']++;
            } elseif ($progress > 0) {
                $stats['in_progress']++;
            } else {
                $stats['not_started']++;
            }

            if ($deadline && strtotime($deadline) < time() && $progress < $target) {
                $stats['overdue']++;
            }
        }

        return $stats;
    }
} 