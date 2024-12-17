<?php
/**
 * Add temporary admin page to trigger migration
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function athlete_dashboard_add_migration_page() {
    add_submenu_page(
        null, // Hidden from menu
        'Run Squat Progress Migration',
        'Run Migration',
        'manage_options',
        'run-squat-migration',
        'athlete_dashboard_run_squat_migration_page'
    );
}
add_action('admin_menu', 'athlete_dashboard_add_migration_page');

function athlete_dashboard_run_squat_migration_page() {
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    // Run migration
    $migration = new Athlete_Dashboard_Squat_Progress_Migration();
    $migration->run();

    // Verify table creation
    global $wpdb;
    $table_name = $wpdb->prefix . 'athlete_squat_progress';
    $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'") === $table_name;

    echo '<div class="wrap">';
    echo '<h1>Squat Progress Migration</h1>';
    
    if ($table_exists) {
        echo '<div class="notice notice-success"><p>Migration completed successfully. Database table created.</p></div>';
    } else {
        echo '<div class="notice notice-error"><p>Failed to create database table.</p></div>';
    }
    
    echo '</div>';
} 