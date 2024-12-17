<?php
/**
 * Charts Data Manager Class
 * Handles data operations for athlete dashboard charts
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Charts_Data_Manager extends Athlete_Dashboard_Data_Manager {
    /**
     * Initialize the data manager
     */
    public function __construct() {
        parent::__construct('charts_data');
    }

    /**
     * Get attendance data for charts
     *
     * @param int $user_id User ID
     * @param string $period Time period (week, month, year)
     * @return array Chart data
     */
    public function get_attendance_data($user_id, $period = 'month') {
        $attendance_manager = new Athlete_Dashboard_Attendance_Data_Manager();
        
        // Get date range based on period
        $end_date = current_time('Y-m-d');
        switch ($period) {
            case 'week':
                $start_date = date('Y-m-d', strtotime('-1 week'));
                break;
            case 'year':
                $start_date = date('Y-m-d', strtotime('-1 year'));
                break;
            default: // month
                $start_date = date('Y-m-d', strtotime('-1 month'));
        }

        $records = $attendance_manager->get_attendance_records($user_id, $start_date, $end_date);
        return $this->format_attendance_data($records, $period);
    }

    /**
     * Get goals progress data for charts
     *
     * @param int $user_id User ID
     * @return array Chart data
     */
    public function get_goals_data($user_id) {
        $goals_manager = new Athlete_Dashboard_Goals_Data_Manager();
        $goals = $goals_manager->get_user_goals($user_id);

        return $this->format_goals_data($goals);
    }

    /**
     * Format attendance data for charts
     *
     * @param array $records Attendance records
     * @param string $period Time period
     * @return array Formatted chart data
     */
    private function format_attendance_data($records, $period) {
        $data = array(
            'labels' => array(),
            'datasets' => array(
                array(
                    'label' => __('Attendance', 'athlete-dashboard'),
                    'data' => array()
                )
            )
        );

        $grouped_data = array();
        foreach ($records as $record) {
            $date = date('Y-m-d', strtotime($record['date']));
            if (!isset($grouped_data[$date])) {
                $grouped_data[$date] = 0;
            }
            $grouped_data[$date]++;
        }

        // Fill in missing dates with zeros
        $current = strtotime($period === 'week' ? '-1 week' : ($period === 'year' ? '-1 year' : '-1 month'));
        $end = time();
        while ($current <= $end) {
            $date = date('Y-m-d', $current);
            if (!isset($grouped_data[$date])) {
                $grouped_data[$date] = 0;
            }
            $current = strtotime('+1 day', $current);
        }

        ksort($grouped_data);
        foreach ($grouped_data as $date => $count) {
            $data['labels'][] = $date;
            $data['datasets'][0]['data'][] = $count;
        }

        return $data;
    }

    /**
     * Format goals data for charts
     *
     * @param array $goals Goals data
     * @return array Formatted chart data
     */
    private function format_goals_data($goals) {
        $data = array(
            'labels' => array(),
            'datasets' => array(
                array(
                    'label' => __('Progress (%)', 'athlete-dashboard'),
                    'data' => array()
                )
            )
        );

        foreach ($goals as $goal) {
            $progress = floatval($goal['progress']);
            $target = floatval($goal['target']);
            
            if ($target > 0) {
                $percentage = min(100, ($progress / $target) * 100);
            } else {
                $percentage = 0;
            }

            $data['labels'][] = $goal['title'];
            $data['datasets'][0]['data'][] = round($percentage, 1);
        }

        return $data;
    }

    /**
     * Get combined dashboard stats
     *
     * @param int $user_id User ID
     * @return array Dashboard statistics
     */
    public function get_dashboard_stats($user_id) {
        $attendance_manager = new Athlete_Dashboard_Attendance_Data_Manager();
        $goals_manager = new Athlete_Dashboard_Goals_Data_Manager();

        return array(
            'attendance' => $attendance_manager->calculate_attendance_stats($user_id),
            'goals' => $goals_manager->get_goal_stats($user_id)
        );
    }
} 