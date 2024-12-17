<?php
/**
 * Run Squat Progress Migration
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Run the migration
$migration = new Athlete_Dashboard_Squat_Progress_Migration();
$migration->run();

// Verify table creation
global $wpdb;
$table_name = $wpdb->prefix . 'athlete_squat_progress';
$table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'") === $table_name;

if ($table_exists) {
    error_log('Squat Progress table created successfully.');
} else {
    error_log('Failed to create Squat Progress table.');
} 