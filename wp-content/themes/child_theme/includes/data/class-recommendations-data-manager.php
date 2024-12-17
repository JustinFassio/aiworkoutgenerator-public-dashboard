<?php
/**
 * Recommendations Data Manager Class
 * 
 * Handles personalized recommendations data operations
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Recommendations_Data_Manager extends Athlete_Dashboard_Data_Manager {
    /**
     * Initialize the data manager
     */
    public function __construct() {
        parent::__construct('recommendations_data');
    }

    /**
     * Get user's personalized recommendations
     *
     * @param int $user_id User ID
     * @return array Array of recommendations
     */
    public function get_user_recommendations($user_id) {
        // Get user's recent activity
        $workout_manager = new Athlete_Dashboard_Workout_Data_Manager();
        $goals_manager = new Athlete_Dashboard_Goals_Data_Manager();
        $attendance_manager = new Athlete_Dashboard_Attendance_Data_Manager();

        $recent_workouts = $workout_manager->get_user_workouts($user_id, array('posts_per_page' => 5));
        $goals = $goals_manager->get_user_goals($user_id);
        $attendance = $attendance_manager->get_user_attendance_stats($user_id);

        $recommendations = array();

        // Workout frequency recommendation
        if ($attendance['monthly_visits'] < 12) { // Less than 3 visits per week
            $recommendations[] = array(
                'type' => 'workout_frequency',
                'content' => __('Increase your workout frequency to at least 3 times per week for optimal results.', 'athlete-dashboard'),
                'action' => 'view_schedule',
                'action_text' => __('View Training Schedule', 'athlete-dashboard')
            );
        }

        // Goal progress recommendations
        foreach ($goals as $goal) {
            if ($goal['progress'] < 50) {
                $recommendations[] = array(
                    'type' => 'goal_progress',
                    'content' => sprintf(
                        __('Your progress towards %s is below 50%%. Schedule a session with a trainer to accelerate your progress.', 'athlete-dashboard'),
                        $goal['title']
                    ),
                    'action' => 'book_trainer',
                    'action_text' => __('Book a Trainer', 'athlete-dashboard')
                );
            }
        }

        // Workout variety recommendation
        $workout_types = array();
        foreach ($recent_workouts as $workout) {
            $type = get_post_meta($workout['id'], '_workout_type', true);
            if ($type) {
                $workout_types[$type] = true;
            }
        }
        
        if (count($workout_types) < 3) {
            $recommendations[] = array(
                'type' => 'workout_variety',
                'content' => __('Try incorporating more variety in your workouts for better overall fitness.', 'athlete-dashboard'),
                'action' => 'explore_workouts',
                'action_text' => __('Explore Workouts', 'athlete-dashboard')
            );
        }

        // Streak-based recommendation
        if ($attendance['current_streak'] > 0) {
            $recommendations[] = array(
                'type' => 'streak',
                'content' => sprintf(
                    __('Great job maintaining a %d day streak! Keep it going!', 'athlete-dashboard'),
                    $attendance['current_streak']
                ),
                'action' => 'view_streak',
                'action_text' => __('View Streak Details', 'athlete-dashboard')
            );
        }

        // If no specific recommendations, provide a default one
        if (empty($recommendations)) {
            $recommendations[] = array(
                'type' => 'general',
                'content' => __('Keep up the great work! Check out our new workout programs to continue your fitness journey.', 'athlete-dashboard'),
                'action' => 'view_programs',
                'action_text' => __('View Programs', 'athlete-dashboard')
            );
        }

        return $recommendations;
    }
} 