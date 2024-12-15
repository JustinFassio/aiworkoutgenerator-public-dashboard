<?php
/**
 * Workout Stats Manager Class
 * 
 * Handles workout statistics and analytics
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Workout_Stats_Manager extends Athlete_Dashboard_Data_Manager {
    /**
     * Initialize the data manager
     */
    public function __construct() {
        parent::__construct('workout_stats');
    }

    /**
     * Get workout summary statistics
     *
     * @param int $user_id User ID
     * @param string $period Optional. Time period ('week', 'month', 'year', 'all')
     * @return array Summary statistics
     */
    public function get_summary_stats($user_id, $period = 'month') {
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
        
        $stats = array(
            'total_workouts' => count($logs),
            'total_duration' => 0,
            'avg_intensity' => 0,
            'total_volume' => 0,
            'workout_types' => array(),
            'muscle_groups' => array(),
            'equipment_used' => array()
        );

        $intensity_sum = 0;
        
        foreach ($logs as $log) {
            // Accumulate basic stats
            $stats['total_duration'] += get_post_meta($log->ID, '_workout_duration', true);
            $intensity_sum += get_post_meta($log->ID, '_workout_intensity', true);
            
            // Get workout details
            $workout_id = get_post_meta($log->ID, '_workout_id', true);
            $completed_exercises = get_post_meta($log->ID, '_completed_exercises', true);
            
            // Calculate volume and track exercise details
            if (is_array($completed_exercises)) {
                foreach ($completed_exercises as $exercise) {
                    $stats['total_volume'] += $exercise['sets_completed'] * $exercise['reps_completed'] * $exercise['weight_used'];
                }
            }
            
            // Track workout types
            $workout_type = get_post_meta($workout_id, '_workout_type', true);
            if (!isset($stats['workout_types'][$workout_type])) {
                $stats['workout_types'][$workout_type] = 0;
            }
            $stats['workout_types'][$workout_type]++;
            
            // Track muscle groups
            $muscle_groups = wp_get_post_terms($workout_id, 'exercise_muscle_group', array('fields' => 'names'));
            foreach ($muscle_groups as $group) {
                if (!isset($stats['muscle_groups'][$group])) {
                    $stats['muscle_groups'][$group] = 0;
                }
                $stats['muscle_groups'][$group]++;
            }
            
            // Track equipment
            $equipment = wp_get_post_terms($workout_id, 'exercise_equipment', array('fields' => 'names'));
            foreach ($equipment as $item) {
                if (!isset($stats['equipment_used'][$item])) {
                    $stats['equipment_used'][$item] = 0;
                }
                $stats['equipment_used'][$item]++;
            }
        }

        // Calculate averages
        $stats['avg_intensity'] = $stats['total_workouts'] > 0 ? $intensity_sum / $stats['total_workouts'] : 0;
        $stats['avg_duration'] = $stats['total_workouts'] > 0 ? $stats['total_duration'] / $stats['total_workouts'] : 0;

        // Sort arrays by value
        arsort($stats['workout_types']);
        arsort($stats['muscle_groups']);
        arsort($stats['equipment_used']);

        return $stats;
    }

    /**
     * Get workout trend data
     *
     * @param int $user_id User ID
     * @param string $metric Metric to analyze ('volume', 'intensity', 'duration')
     * @param string $period Optional. Time period ('week', 'month', 'year')
     * @return array Trend data
     */
    public function get_workout_trends($user_id, $metric, $period = 'month') {
        $args = array(
            'post_type' => 'workout_log',
            'author' => $user_id,
            'posts_per_page' => -1,
            'orderby' => 'meta_value',
            'meta_key' => '_workout_date',
            'order' => 'ASC'
        );

        switch ($period) {
            case 'week':
                $args['date_query'] = array(
                    array(
                        'after' => '1 week ago'
                    )
                );
                $group_by = 'day';
                break;
            case 'month':
                $args['date_query'] = array(
                    array(
                        'after' => '1 month ago'
                    )
                );
                $group_by = 'day';
                break;
            case 'year':
                $args['date_query'] = array(
                    array(
                        'after' => '1 year ago'
                    )
                );
                $group_by = 'month';
                break;
            default:
                $group_by = 'month';
        }

        $logs = get_posts($args);
        $trends = array();

        foreach ($logs as $log) {
            $date = get_post_meta($log->ID, '_workout_date', true);
            $group_key = $this->get_group_key($date, $group_by);
            
            if (!isset($trends[$group_key])) {
                $trends[$group_key] = array(
                    'count' => 0,
                    'value' => 0
                );
            }

            $trends[$group_key]['count']++;
            
            switch ($metric) {
                case 'volume':
                    $completed_exercises = get_post_meta($log->ID, '_completed_exercises', true);
                    if (is_array($completed_exercises)) {
                        foreach ($completed_exercises as $exercise) {
                            $trends[$group_key]['value'] += 
                                $exercise['sets_completed'] * 
                                $exercise['reps_completed'] * 
                                $exercise['weight_used'];
                        }
                    }
                    break;
                
                case 'intensity':
                    $trends[$group_key]['value'] += get_post_meta($log->ID, '_workout_intensity', true);
                    break;
                
                case 'duration':
                    $trends[$group_key]['value'] += get_post_meta($log->ID, '_workout_duration', true);
                    break;
            }
        }

        // Calculate averages for intensity
        if ($metric === 'intensity') {
            foreach ($trends as &$data) {
                $data['value'] = $data['count'] > 0 ? $data['value'] / $data['count'] : 0;
            }
        }

        return $trends;
    }

    /**
     * Get personal records
     *
     * @param int $user_id User ID
     * @return array Personal records
     */
    public function get_personal_records($user_id) {
        $logs = get_posts(array(
            'post_type' => 'workout_log',
            'author' => $user_id,
            'posts_per_page' => -1
        ));

        $records = array(
            'max_weights' => array(),
            'max_reps' => array(),
            'max_volume' => array()
        );

        foreach ($logs as $log) {
            $completed_exercises = get_post_meta($log->ID, '_completed_exercises', true);
            if (!is_array($completed_exercises)) {
                continue;
            }

            foreach ($completed_exercises as $exercise) {
                $name = $exercise['name'];
                
                // Track max weight
                if (!isset($records['max_weights'][$name]) || 
                    $exercise['weight_used'] > $records['max_weights'][$name]['value']) {
                    $records['max_weights'][$name] = array(
                        'value' => $exercise['weight_used'],
                        'date' => get_post_meta($log->ID, '_workout_date', true)
                    );
                }
                
                // Track max reps
                if (!isset($records['max_reps'][$name]) || 
                    $exercise['reps_completed'] > $records['max_reps'][$name]['value']) {
                    $records['max_reps'][$name] = array(
                        'value' => $exercise['reps_completed'],
                        'date' => get_post_meta($log->ID, '_workout_date', true)
                    );
                }
                
                // Track max volume (weight * reps * sets)
                $volume = $exercise['weight_used'] * $exercise['reps_completed'] * $exercise['sets_completed'];
                if (!isset($records['max_volume'][$name]) || 
                    $volume > $records['max_volume'][$name]['value']) {
                    $records['max_volume'][$name] = array(
                        'value' => $volume,
                        'date' => get_post_meta($log->ID, '_workout_date', true)
                    );
                }
            }
        }

        // Sort records by value
        foreach ($records as &$category) {
            uasort($category, function($a, $b) {
                return $b['value'] - $a['value'];
            });
        }

        return $records;
    }

    /**
     * Get workout frequency data
     *
     * @param int $user_id User ID
     * @param string $period Optional. Time period ('month', 'year')
     * @return array Frequency data
     */
    public function get_workout_frequency($user_id, $period = 'month') {
        $args = array(
            'post_type' => 'workout_log',
            'author' => $user_id,
            'posts_per_page' => -1,
            'orderby' => 'meta_value',
            'meta_key' => '_workout_date',
            'order' => 'ASC'
        );

        switch ($period) {
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
        $frequency = array(
            'weekday' => array_fill(0, 7, 0),
            'hour' => array_fill(0, 24, 0)
        );

        foreach ($logs as $log) {
            $date = get_post_meta($log->ID, '_workout_date', true);
            $timestamp = strtotime($date);
            
            // Track weekday frequency (0 = Sunday, 6 = Saturday)
            $weekday = date('w', $timestamp);
            $frequency['weekday'][$weekday]++;
            
            // Track hour frequency (0-23)
            $hour = date('G', $timestamp);
            $frequency['hour'][$hour]++;
        }

        return $frequency;
    }

    /**
     * Get group key for trend data
     *
     * @param string $date Date string
     * @param string $group_by Grouping period ('day', 'month')
     * @return string Group key
     */
    private function get_group_key($date, $group_by) {
        $timestamp = strtotime($date);
        switch ($group_by) {
            case 'day':
                return date('Y-m-d', $timestamp);
            case 'month':
                return date('Y-m', $timestamp);
            default:
                return date('Y-m-d', $timestamp);
        }
    }
} 