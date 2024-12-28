<?php
/**
 * Feature Name: Workout Tracker
 * Description: Track and manage your workouts
 * Icon: dashicons-calendar-alt
 * Permissions: subscriber, trainer, administrator
 * Enabled: true
 */

namespace AthleteDashboard\Dashboard\Features;

if (!defined('ABSPATH')) {
    exit;
}

class WorkoutTracker {
    private $workout_types = [
        ['id' => 'strength', 'name' => 'Strength Training'],
        ['id' => 'cardio', 'name' => 'Cardio'],
        ['id' => 'hiit', 'name' => 'HIIT'],
        ['id' => 'flexibility', 'name' => 'Flexibility'],
        ['id' => 'sports', 'name' => 'Sports Training']
    ];

    public function __construct() {
        add_filter('athlete_dashboard_features', [$this, 'registerFeature']);
        add_action('wp_ajax_save_workout', [$this, 'handleSaveWorkout']);
        add_action('wp_ajax_update_workout', [$this, 'handleUpdateWorkout']);
        add_action('wp_ajax_delete_workout', [$this, 'handleDeleteWorkout']);
        add_action('init', [$this, 'registerPostType']);
    }

    /**
     * Register the Workout Tracker feature
     */
    public function registerFeature(array $features): array {
        $features[] = [
            'id' => 'workout-tracker',
            'title' => __('Workout Tracker', 'athlete-dashboard'),
            'description' => __('Track and manage your workouts', 'athlete-dashboard'),
            'icon' => 'dashicons-calendar-alt',
            'react_component' => 'WorkoutTracker',
            'props' => [
                'workouts' => $this->getUserWorkouts(),
                'workoutTypes' => $this->workout_types,
                'onSaveWorkout' => [
                    'action' => 'save_workout',
                    'nonce' => wp_create_nonce('save_workout')
                ],
                'onUpdateWorkout' => [
                    'action' => 'update_workout',
                    'nonce' => wp_create_nonce('update_workout')
                ],
                'onDeleteWorkout' => [
                    'action' => 'delete_workout',
                    'nonce' => wp_create_nonce('delete_workout')
                ]
            ]
        ];

        return $features;
    }

    /**
     * Register workout post type
     */
    public function registerPostType(): void {
        register_post_type('workout', [
            'labels' => [
                'name' => __('Workouts', 'athlete-dashboard'),
                'singular_name' => __('Workout', 'athlete-dashboard')
            ],
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'supports' => ['title', 'author'],
            'capability_type' => 'post'
        ]);
    }

    /**
     * Get workouts for current user
     */
    private function getUserWorkouts(): array {
        $args = [
            'post_type' => 'workout',
            'posts_per_page' => -1,
            'author' => get_current_user_id(),
            'orderby' => 'date',
            'order' => 'DESC'
        ];

        $posts = get_posts($args);
        $workouts = [];

        foreach ($posts as $post) {
            $meta = get_post_meta($post->ID);
            $workouts[] = [
                'id' => $post->ID,
                'title' => $post->post_title,
                'date' => get_post_meta($post->ID, 'workout_date', true),
                'type' => get_post_meta($post->ID, 'workout_type', true),
                'duration' => (int) get_post_meta($post->ID, 'workout_duration', true),
                'exercises' => json_decode(get_post_meta($post->ID, 'workout_exercises', true), true) ?? [],
                'notes' => get_post_meta($post->ID, 'workout_notes', true),
                'status' => get_post_meta($post->ID, 'workout_status', true) ?? 'planned'
            ];
        }

        return $workouts;
    }

    /**
     * Handle workout save request
     */
    public function handleSaveWorkout(): void {
        check_ajax_referer('save_workout');

        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!current_user_can('edit_posts')) {
            wp_send_json_error(['message' => __('Permission denied.', 'athlete-dashboard')]);
            return;
        }

        $post_data = [
            'post_title' => sanitize_text_field($data['title']),
            'post_type' => 'workout',
            'post_status' => 'publish',
            'post_author' => get_current_user_id()
        ];

        $post_id = wp_insert_post($post_data);

        if (is_wp_error($post_id)) {
            wp_send_json_error([
                'message' => $post_id->get_error_message()
            ]);
            return;
        }

        // Save workout metadata
        update_post_meta($post_id, 'workout_date', sanitize_text_field($data['date']));
        update_post_meta($post_id, 'workout_type', sanitize_text_field($data['type']));
        update_post_meta($post_id, 'workout_duration', (int) $data['duration']);
        update_post_meta($post_id, 'workout_exercises', wp_json_encode($data['exercises']));
        update_post_meta($post_id, 'workout_notes', sanitize_textarea_field($data['notes'] ?? ''));
        update_post_meta($post_id, 'workout_status', 'planned');

        wp_send_json_success([
            'message' => __('Workout saved successfully.', 'athlete-dashboard'),
            'workout' => [
                'id' => $post_id,
                'title' => $data['title'],
                'date' => $data['date'],
                'type' => $data['type'],
                'duration' => (int) $data['duration'],
                'exercises' => $data['exercises'],
                'notes' => $data['notes'] ?? '',
                'status' => 'planned'
            ]
        ]);
    }

    /**
     * Handle workout update request
     */
    public function handleUpdateWorkout(): void {
        check_ajax_referer('update_workout');

        $data = json_decode(file_get_contents('php://input'), true);
        $workout_id = (int) $data['id'];
        
        if (!current_user_can('edit_post', $workout_id)) {
            wp_send_json_error(['message' => __('Permission denied.', 'athlete-dashboard')]);
            return;
        }

        foreach ($data as $key => $value) {
            if ($key === 'id') continue;
            update_post_meta($workout_id, "workout_{$key}", $value);
        }

        wp_send_json_success([
            'message' => __('Workout updated successfully.', 'athlete-dashboard')
        ]);
    }

    /**
     * Handle workout delete request
     */
    public function handleDeleteWorkout(): void {
        check_ajax_referer('delete_workout');

        $data = json_decode(file_get_contents('php://input'), true);
        $workout_id = (int) $data['id'];
        
        if (!current_user_can('delete_post', $workout_id)) {
            wp_send_json_error(['message' => __('Permission denied.', 'athlete-dashboard')]);
            return;
        }

        $result = wp_delete_post($workout_id, true);

        if (!$result) {
            wp_send_json_error([
                'message' => __('Failed to delete workout.', 'athlete-dashboard')
            ]);
            return;
        }

        wp_send_json_success([
            'message' => __('Workout deleted successfully.', 'athlete-dashboard')
        ]);
    }
}

// Initialize the feature
new WorkoutTracker(); 