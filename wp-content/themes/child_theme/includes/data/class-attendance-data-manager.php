<?php
/**
 * Attendance Data Manager Class
 * Handles data operations for athlete attendance
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Attendance_Data_Manager extends Athlete_Dashboard_Data_Manager {
    /**
     * Initialize the data manager
     */
    public function __construct() {
        parent::__construct('attendance_data');
    }

    /**
     * Save attendance record
     *
     * @param array $data Attendance data
     * @return int|false Post ID on success, false on failure
     */
    public function save_attendance_record($data) {
        $post_data = array(
            'post_type' => 'athlete_attendance',
            'post_status' => 'publish',
            'post_author' => get_current_user_id(),
            'post_title' => sprintf(
                __('Attendance Record - %s', 'athlete-dashboard'),
                isset($data['date']) ? $data['date'] : current_time('Y-m-d')
            )
        );

        $attendance_id = wp_insert_post($post_data);

        if ($attendance_id && !is_wp_error($attendance_id)) {
            // Save meta data
            $meta_fields = array(
                'date' => current_time('Y-m-d'),
                'type' => 'check-in',
                'notes' => ''
            );

            foreach ($meta_fields as $field => $default) {
                $value = isset($data[$field]) ? $data[$field] : $default;
                update_post_meta($attendance_id, 'attendance_' . $field, $value);
            }

            return $attendance_id;
        }

        return false;
    }

    /**
     * Get attendance records
     *
     * @param int $user_id User ID
     * @param string $start_date Start date (Y-m-d)
     * @param string $end_date End date (Y-m-d)
     * @return array Array of attendance records
     */
    public function get_attendance_records($user_id, $start_date = '', $end_date = '') {
        $args = array(
            'post_type' => 'athlete_attendance',
            'author' => $user_id,
            'posts_per_page' => -1,
            'orderby' => 'meta_value',
            'meta_key' => 'attendance_date',
            'order' => 'DESC'
        );

        // Add date range filter if provided
        if ($start_date || $end_date) {
            $args['meta_query'] = array(
                array(
                    'key' => 'attendance_date',
                    'value' => array($start_date ?: '0000-00-00', $end_date ?: current_time('Y-m-d')),
                    'type' => 'DATE',
                    'compare' => 'BETWEEN'
                )
            );
        }

        $records = get_posts($args);
        return array_map(array($this, 'format_attendance_record'), $records);
    }

    /**
     * Format attendance record for API response
     *
     * @param WP_Post $record Attendance record post object
     * @return array Formatted attendance data
     */
    private function format_attendance_record($record) {
        return array(
            'id' => $record->ID,
            'date' => get_post_meta($record->ID, 'attendance_date', true),
            'type' => get_post_meta($record->ID, 'attendance_type', true),
            'notes' => get_post_meta($record->ID, 'attendance_notes', true),
            'created' => $record->post_date,
            'modified' => $record->post_modified
        );
    }

    /**
     * Calculate attendance statistics
     *
     * @param int $user_id User ID
     * @return array Attendance statistics
     */
    public function calculate_attendance_stats($user_id) {
        $records = $this->get_attendance_records($user_id);
        
        $stats = array(
            'total_sessions' => count($records),
            'current_streak' => 0,
            'longest_streak' => 0,
            'this_month' => 0,
            'last_month' => 0
        );

        if (empty($records)) {
            return $stats;
        }

        // Calculate current and longest streaks
        $current_streak = 0;
        $longest_streak = 0;
        $last_date = null;
        $this_month = date('Y-m');
        $last_month = date('Y-m', strtotime('-1 month'));

        foreach ($records as $record) {
            $record_date = date('Y-m-d', strtotime($record['date']));
            $record_month = date('Y-m', strtotime($record['date']));

            // Count monthly attendance
            if ($record_month === $this_month) {
                $stats['this_month']++;
            } elseif ($record_month === $last_month) {
                $stats['last_month']++;
            }

            // Calculate streaks
            if ($last_date === null) {
                $current_streak = 1;
                $last_date = $record_date;
                continue;
            }

            $days_diff = (strtotime($last_date) - strtotime($record_date)) / (60 * 60 * 24);

            if ($days_diff === 1) {
                $current_streak++;
                $longest_streak = max($longest_streak, $current_streak);
            } else {
                $current_streak = 1;
            }

            $last_date = $record_date;
        }

        $stats['current_streak'] = $current_streak;
        $stats['longest_streak'] = $longest_streak;

        return $stats;
    }

    /**
     * Get attendance record by ID
     *
     * @param int $record_id Record ID
     * @return array|false Formatted attendance data or false if not found
     */
    public function get_attendance_record($record_id) {
        $record = get_post($record_id);
        if (!$record || $record->post_type !== 'athlete_attendance') {
            return false;
        }

        return $this->format_attendance_record($record);
    }

    /**
     * Delete attendance record
     *
     * @param int $record_id Record ID
     * @return bool True on success, false on failure
     */
    public function delete_attendance_record($record_id) {
        $record = get_post($record_id);
        if (!$record || $record->post_type !== 'athlete_attendance') {
            return false;
        }

        return wp_delete_post($record_id, true);
    }

    /**
     * Get user's attendance statistics
     *
     * @param int $user_id User ID
     * @return array Attendance statistics
     */
    public function get_user_attendance_stats($user_id) {
        // Get check-ins from the last 30 days
        $args = array(
            'post_type' => 'check_in',
            'posts_per_page' => -1,
            'author' => $user_id,
            'date_query' => array(
                array(
                    'after' => '30 days ago'
                )
            )
        );

        $check_ins = get_posts($args);
        
        // Calculate monthly visits
        $monthly_visits = count($check_ins);

        // Calculate total visits (all time)
        $total_args = array(
            'post_type' => 'check_in',
            'posts_per_page' => -1,
            'author' => $user_id,
            'fields' => 'ids'
        );
        $total_visits = count(get_posts($total_args));

        // Calculate current streak
        $current_streak = $this->calculate_current_streak($user_id);

        return array(
            'total_visits' => $total_visits,
            'monthly_visits' => $monthly_visits,
            'current_streak' => $current_streak,
            'recent_check_ins' => $this->format_check_ins($check_ins)
        );
    }

    /**
     * Calculate user's current attendance streak
     *
     * @param int $user_id User ID
     * @return int Current streak count
     */
    private function calculate_current_streak($user_id) {
        $streak = 0;
        $current_date = current_time('Y-m-d');
        $checking_date = $current_date;
        $has_current_day = false;

        while (true) {
            $args = array(
                'post_type' => 'check_in',
                'posts_per_page' => 1,
                'author' => $user_id,
                'date_query' => array(
                    array(
                        'year' => date('Y', strtotime($checking_date)),
                        'month' => date('m', strtotime($checking_date)),
                        'day' => date('d', strtotime($checking_date)),
                    ),
                )
            );

            $check_in = get_posts($args);

            if (!empty($check_in)) {
                if ($checking_date === $current_date) {
                    $has_current_day = true;
                }
                $streak++;
                $checking_date = date('Y-m-d', strtotime($checking_date . ' -1 day'));
            } else {
                // If we don't have the current day, but we have a streak from previous days
                if (!$has_current_day && $streak > 0) {
                    // Check if we missed just one day
                    $yesterday = date('Y-m-d', strtotime('-1 day', strtotime($current_date)));
                    if ($checking_date === $yesterday) {
                        break; // Keep the streak
                    }
                }
                break;
            }
        }

        return $streak;
    }

    /**
     * Format check-ins for display
     *
     * @param array $check_ins Array of check-in posts
     * @return array Formatted check-ins
     */
    private function format_check_ins($check_ins) {
        $formatted = array();

        foreach ($check_ins as $check_in) {
            $formatted[] = array(
                'id' => $check_in->ID,
                'date' => get_the_date('Y-m-d', $check_in->ID),
                'time' => get_post_meta($check_in->ID, '_check_in_time', true),
                'location' => get_post_meta($check_in->ID, '_check_in_location', true),
                'type' => get_post_meta($check_in->ID, '_check_in_type', true)
            );
        }

        return $formatted;
    }
} 