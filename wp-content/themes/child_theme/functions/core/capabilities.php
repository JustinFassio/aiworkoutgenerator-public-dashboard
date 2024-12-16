<?php
/**
 * User Capabilities Management
 * 
 * Handles the setup and management of custom capabilities for the Athlete Dashboard.
 * Defines role-specific capabilities for workout management and other features.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Add custom capabilities for workout management
 */
function athlete_dashboard_add_capabilities() {
    $roles = array('administrator', 'editor');
    
    $capabilities = array(
        // Workout capabilities
        'edit_workout' => true,
        'read_workout' => true,
        'delete_workout' => true,
        'edit_workouts' => true,
        'edit_others_workouts' => true,
        'publish_workouts' => true,
        'read_private_workouts' => true,
        'delete_workouts' => true,
        'delete_private_workouts' => true,
        'delete_published_workouts' => true,
        'delete_others_workouts' => true,
        'edit_private_workouts' => true,
        'edit_published_workouts' => true,
        
        // Workout log capabilities
        'edit_workout_log' => true,
        'read_workout_log' => true,
        'delete_workout_log' => true,
        'edit_workout_logs' => true,
        'edit_others_workout_logs' => true,
        'publish_workout_logs' => true,
        'read_private_workout_logs' => true,
        'delete_workout_logs' => true,
        'delete_private_workout_logs' => true,
        'delete_published_workout_logs' => true,
        'delete_others_workout_logs' => true,
        'edit_private_workout_logs' => true,
        'edit_published_workout_logs' => true
    );

    foreach ($roles as $role_name) {
        $role = get_role($role_name);
        if ($role) {
            foreach ($capabilities as $cap => $grant) {
                $role->add_cap($cap, $grant);
            }
        }
    }

    // Add limited capabilities for subscribers
    $subscriber = get_role('subscriber');
    if ($subscriber) {
        $subscriber_caps = array(
            'read_workout' => true,
            'edit_workout_log' => true,
            'read_workout_log' => true,
            'edit_workout_logs' => true,
            'publish_workout_logs' => true
        );

        foreach ($subscriber_caps as $cap => $grant) {
            $subscriber->add_cap($cap, $grant);
        }
    }
}
add_action('admin_init', 'athlete_dashboard_add_capabilities'); 