<?php
/**
 * Workout Progress Manager Class
 * 
 * Handles workout progress tracking and analysis
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Workout_Progress_Manager extends Athlete_Dashboard_Data_Manager {
    /**
     * Initialize the data manager
     */
    public function __construct() {
        parent::__construct('workout_progress');
    }

    /**
     * Get user's workout logs
     *
     * @param int $user_id User ID
     * @param array $args Optional. Query arguments
     * @return array Array of workout logs
     */
    public function get_workout_logs($user_id, $args = array()) {
        $default_args = array(
            'post_type' => 'workout_log',
            'author' => $user_id,
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC'
        );

        $args = wp_parse_args($args, $default_args);
        return get_posts($args);
    }

    /**
     * Get workout log details
     *
     * @param int $log_id Log post ID
     * @return array|WP_Error Log details or error object
     */
    public function get_log_details($log_id) {
        $log = get_post($log_id);
        if (!$log || $log->post_type !== 'workout_log') {
            return new WP_Error('invalid_log', __('Invalid workout log ID', 'athlete-dashboard'));
        }

        return array(
            'id' => $log->ID,
            'workout_id' => get_post_meta($log_id, '_workout_id', true),
            'date' => get_post_meta($log_id, '_workout_date', true),
            'duration' => get_post_meta($log_id, '_workout_duration', true),
            'intensity' => get_post_meta($log_id, '_workout_intensity', true),
            'completed_exercises' => get_post_meta($log_id, '_completed_exercises', true),
            'notes' => get_post_meta($log_id, '_notes', true)
        );
    }

    /**
     * Log a completed workout
     *
     * @param array $log_data Log data
     * @param int $user_id User ID
     * @return int|WP_Error Created log ID or error object
     */
    public function create_workout_log($log_data, $user_id) {
        if (!$this->user_can('publish_workout_logs')) {
            return new WP_Error('permission_denied', __('You do not have permission to create workout logs', 'athlete-dashboard'));
        }

        // Validate workout ID
        $workout_id = absint($log_data['workout_id']);
        $workout = get_post($workout_id);
        if (!$workout || $workout->post_type !== 'workout') {
            return new WP_Error('invalid_workout', __('Invalid workout ID', 'athlete-dashboard'));
        }

        // Create log entry
        $log = array(
            'post_title' => sprintf(
                /* translators: %1$s: workout title, %2$s: date */
                __('%1$s - %2$s', 'athlete-dashboard'),
                $workout->post_title,
                date_i18n(get_option('date_format'), strtotime($log_data['date']))
            ),
            'post_type' => 'workout_log',
            'post_status' => 'publish',
            'post_author' => $user_id
        );

        $log_id = wp_insert_post($log, true);
        if (is_wp_error($log_id)) {
            return $log_id;
        }

        // Update log meta
        update_post_meta($log_id, '_workout_id', $workout_id);
        update_post_meta($log_id, '_workout_date', $this->sanitize_date($log_data['date']));
        update_post_meta($log_id, '_workout_duration', absint($log_data['duration']));
        update_post_meta($log_id, '_workout_intensity', $this->sanitize_intensity($log_data['intensity']));
        update_post_meta($log_id, '_completed_exercises', $this->sanitize_completed_exercises($log_data['completed_exercises']));
        update_post_meta($log_id, '_notes', sanitize_textarea_field($log_data['notes']));

        return $log_id;
    }

    /**
     * Update a workout log
     *
     * @param int $log_id Log ID
     * @param array $log_data Updated log data
     * @return bool|WP_Error True on success, error object on failure
     */
    public function update_workout_log($log_id, $log_data) {
        if (!$this->user_can('edit_workout_log', $log_id)) {
            return new WP_Error('permission_denied', __('You do not have permission to edit this workout log', 'athlete-dashboard'));
        }

        // Update log meta
        if (isset($log_data['workout_id'])) {
            update_post_meta($log_id, '_workout_id', absint($log_data['workout_id']));
        }
        if (isset($log_data['date'])) {
            update_post_meta($log_id, '_workout_date', $this->sanitize_date($log_data['date']));
        }
        if (isset($log_data['duration'])) {
            update_post_meta($log_id, '_workout_duration', absint($log_data['duration']));
        }
        if (isset($log_data['intensity'])) {
            update_post_meta($log_id, '_workout_intensity', $this->sanitize_intensity($log_data['intensity']));
        }
        if (isset($log_data['completed_exercises'])) {
            update_post_meta($log_id, '_completed_exercises', $this->sanitize_completed_exercises($log_data['completed_exercises']));
        }
        if (isset($log_data['notes'])) {
            update_post_meta($log_id, '_notes', sanitize_textarea_field($log_data['notes']));
        }

        return true;
    }

    /**
     * Delete a workout log
     *
     * @param int $log_id Log ID
     * @return bool|WP_Error True on success, error object on failure
     */
    public function delete_workout_log($log_id) {
        if (!$this->user_can('delete_workout_log', $log_id)) {
            return new WP_Error('permission_denied', __('You do not have permission to delete this workout log', 'athlete-dashboard'));
        }

        $result = wp_delete_post($log_id, true);
        return $result ? true : new WP_Error('delete_failed', __('Failed to delete workout log', 'athlete-dashboard'));
    }

    /**
     * Get workout completion rate
     *
     * @param int $user_id User ID
     * @param string $period Optional. Time period ('week', 'month', 'year')
     * @return array Completion rate statistics
     */
    public function get_completion_rate($user_id, $period = 'month') {
        $args = array(
            'post_type' => 'workout_log',
            'author' => $user_id,
            'posts_per_page' => -1,
            'date_query' => array()
        );

        switch ($period) {
            case 'week':
                $args['date_query'] = array(
                    array(
                        'after' => '1 week ago'
                    )
                );
                break;
            case 'month':
                $args['date_query'] = array(
                    array(
                        'after' => '1 month ago'
                    )
                );
                break;
            case 'year':
                $args['date_query'] = array(
                    array(
                        'after' => '1 year ago'
                    )
                );
                break;
        }

        $logs = get_posts($args);
        $total_exercises = 0;
        $completed_exercises = 0;

        foreach ($logs as $log) {
            $workout_id = get_post_meta($log->ID, '_workout_id', true);
            $planned_exercises = get_post_meta($workout_id, '_workout_exercises', true);
            $completed = get_post_meta($log->ID, '_completed_exercises', true);

            if (is_array($planned_exercises)) {
                foreach ($planned_exercises as $exercise) {
                    $total_exercises++;
                    
                    // Find matching completed exercise
                    if (is_array($completed)) {
                        foreach ($completed as $done) {
                            if ($done['id'] == $exercise['id']) {
                                if ($done['sets_completed'] >= $exercise['sets'] &&
                                    $done['reps_completed'] >= $exercise['reps']) {
                                    $completed_exercises++;
                                }
                                break;
                            }
                        }
                    }
                }
            }
        }

        return array(
            'total' => $total_exercises,
            'completed' => $completed_exercises,
            'rate' => $total_exercises > 0 ? ($completed_exercises / $total_exercises) * 100 : 0
        );
    }

    /**
     * Get workout progress over time
     *
     * @param int $user_id User ID
     * @param string $metric Optional. Progress metric ('volume', 'intensity', 'duration')
     * @param int $limit Optional. Number of data points to return
     * @return array Progress data
     */
    public function get_progress_over_time($user_id, $metric = 'volume', $limit = 10) {
        $logs = get_posts(array(
            'post_type' => 'workout_log',
            'author' => $user_id,
            'posts_per_page' => $limit,
            'orderby' => 'date',
            'order' => 'ASC'
        ));

        $progress = array();
        foreach ($logs as $log) {
            $date = get_post_meta($log->ID, '_workout_date', true);
            $completed_exercises = get_post_meta($log->ID, '_completed_exercises', true);

            switch ($metric) {
                case 'volume':
                    $value = 0;
                    if (is_array($completed_exercises)) {
                        foreach ($completed_exercises as $exercise) {
                            $value += $exercise['sets_completed'] * $exercise['reps_completed'] * $exercise['weight_used'];
                        }
                    }
                    break;

                case 'intensity':
                    $value = get_post_meta($log->ID, '_workout_intensity', true);
                    break;

                case 'duration':
                    $value = get_post_meta($log->ID, '_workout_duration', true);
                    break;

                default:
                    $value = 0;
            }

            $progress[] = array(
                'date' => $date,
                'value' => $value
            );
        }

        return $progress;
    }

    /**
     * Get workout streaks
     *
     * @param int $user_id User ID
     * @return array Streak information
     */
    public function get_workout_streaks($user_id) {
        $logs = get_posts(array(
            'post_type' => 'workout_log',
            'author' => $user_id,
            'posts_per_page' => -1,
            'orderby' => 'meta_value',
            'meta_key' => '_workout_date',
            'order' => 'DESC'
        ));

        if (empty($logs)) {
            return array(
                'current_streak' => 0,
                'longest_streak' => 0,
                'last_workout' => null
            );
        }

        $dates = array();
        foreach ($logs as $log) {
            $date = get_post_meta($log->ID, '_workout_date', true);
            $dates[] = strtotime($date);
        }

        sort($dates);
        $current_streak = 0;
        $longest_streak = 0;
        $streak = 0;
        $last_date = null;

        foreach ($dates as $date) {
            if ($last_date === null) {
                $streak = 1;
            } else {
                $diff = ($date - $last_date) / (60 * 60 * 24); // Difference in days
                if ($diff <= 1) {
                    $streak++;
                } else {
                    $longest_streak = max($longest_streak, $streak);
                    $streak = 1;
                }
            }
            $last_date = $date;
        }

        // Check if current streak is still active
        $today = strtotime('today');
        $diff = ($today - end($dates)) / (60 * 60 * 24);
        $current_streak = ($diff <= 1) ? $streak : 0;
        $longest_streak = max($longest_streak, $streak);

        return array(
            'current_streak' => $current_streak,
            'longest_streak' => $longest_streak,
            'last_workout' => date('Y-m-d', end($dates))
        );
    }

    /**
     * Sanitize completed exercises array
     *
     * @param array $exercises Array of completed exercises
     * @return array Sanitized exercises
     */
    private function sanitize_completed_exercises($exercises) {
        if (!is_array($exercises)) {
            return array();
        }

        return array_map(function($exercise) {
            return array(
                'id' => isset($exercise['id']) ? absint($exercise['id']) : 0,
                'sets_completed' => isset($exercise['sets_completed']) ? absint($exercise['sets_completed']) : 0,
                'reps_completed' => isset($exercise['reps_completed']) ? absint($exercise['reps_completed']) : 0,
                'weight_used' => isset($exercise['weight_used']) ? floatval($exercise['weight_used']) : 0,
                'notes' => isset($exercise['notes']) ? sanitize_textarea_field($exercise['notes']) : ''
            );
        }, $exercises);
    }

    /**
     * Sanitize date
     *
     * @param string $date Date string
     * @return string Sanitized date in Y-m-d format
     */
    private function sanitize_date($date) {
        return date('Y-m-d', strtotime($date));
    }

    /**
     * Sanitize intensity value
     *
     * @param mixed $value Intensity value
     * @return int Sanitized intensity (1-10)
     */
    private function sanitize_intensity($value) {
        return max(1, min(10, absint($value)));
    }
} 