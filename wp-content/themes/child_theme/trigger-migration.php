<?php
require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/wp-load.php');

// Run the migration
Athlete_Dashboard_Progress_Migration::run_migrations();

// Check the table again
global $wpdb;
$table_name = $wpdb->prefix . 'athlete_squat_progress';
$table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'") === $table_name;

echo "Migration completed.\n";
echo "Table status for: $table_name\n";
echo "Exists: " . ($table_exists ? "Yes" : "No") . "\n";

if ($table_exists) {
    echo "\nTable structure:\n";
    $results = $wpdb->get_results("DESCRIBE $table_name");
    print_r($results);
} 