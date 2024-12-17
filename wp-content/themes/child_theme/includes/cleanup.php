<?php
/**
 * Cleanup Script
 * 
 * Removes old progress-related database tables and options
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function athlete_dashboard_cleanup_progress_data() {
    global $wpdb;

    // Tables to remove
    $tables = array(
        'athlete_squat_progress',
        'athlete_bench_progress',
        'athlete_deadlift_progress',
        'athlete_exercise_progress'
    );

    // Drop tables
    foreach ($tables as $table) {
        $table_name = $wpdb->prefix . $table;
        $wpdb->query("DROP TABLE IF EXISTS {$table_name}");
    }

    // Remove options
    $options = array(
        'athlete_progress_db_version',
        'athlete_squat_progress_settings',
        'athlete_bench_progress_settings',
        'athlete_deadlift_progress_settings'
    );

    foreach ($options as $option) {
        delete_option($option);
    }

    // Remove user meta
    $meta_keys = array(
        'athlete_squat_progress_preferences',
        'athlete_bench_progress_preferences',
        'athlete_deadlift_progress_preferences'
    );

    foreach ($meta_keys as $meta_key) {
        $wpdb->delete($wpdb->usermeta, array('meta_key' => $meta_key));
    }
}

// Run cleanup
athlete_dashboard_cleanup_progress_data(); 