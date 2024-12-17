<?php
/**
 * Squat Progress Data Manager Class
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Squat_Progress_Data {
    /**
     * @var string
     */
    private $table_name;

    /**
     * Constructor
     */
    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'athlete_squat_progress';
    }

    /**
     * Check if the table exists
     */
    public function table_exists() {
        global $wpdb;
        return $wpdb->get_var("SHOW TABLES LIKE '{$this->table_name}'") === $this->table_name;
    }

    /**
     * Create the database table
     */
    public function create_table() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS {$this->table_name} (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            user_id bigint(20) unsigned NOT NULL,
            date datetime NOT NULL,
            weight decimal(10,2) NOT NULL,
            reps int(11) NOT NULL,
            notes text,
            created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY  (id),
            KEY user_id (user_id),
            KEY date (date)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        if (!$this->table_exists()) {
            throw new Exception('Failed to create squat progress table');
        }
    }

    /**
     * Get progress data for a user
     */
    public function get_user_progress($user_id, $limit = 10) {
        global $wpdb;
        
        if (!$this->table_exists()) {
            throw new Exception('Squat progress table does not exist');
        }

        $results = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$this->table_name} 
            WHERE user_id = %d 
            ORDER BY date DESC 
            LIMIT %d",
            $user_id,
            $limit
        ));

        if ($results === null) {
            throw new Exception($wpdb->last_error);
        }

        return array_map(function($row) {
            return array(
                'id' => (int)$row->id,
                'date' => $row->date,
                'weight' => (float)$row->weight,
                'reps' => (int)$row->reps,
                'notes' => $row->notes
            );
        }, $results);
    }

    /**
     * Add a new progress entry
     */
    public function add_entry($user_id, $date, $weight, $reps, $notes = '') {
        global $wpdb;
        
        if (!$this->table_exists()) {
            throw new Exception('Squat progress table does not exist');
        }

        $result = $wpdb->insert(
            $this->table_name,
            array(
                'user_id' => $user_id,
                'date' => $date,
                'weight' => $weight,
                'reps' => $reps,
                'notes' => $notes
            ),
            array('%d', '%s', '%f', '%d', '%s')
        );

        if ($result === false) {
            throw new Exception($wpdb->last_error);
        }

        return $wpdb->insert_id;
    }

    /**
     * Delete an entry
     */
    public function delete_entry($entry_id, $user_id) {
        global $wpdb;
        
        if (!$this->table_exists()) {
            throw new Exception('Squat progress table does not exist');
        }

        $result = $wpdb->delete(
            $this->table_name,
            array(
                'id' => $entry_id,
                'user_id' => $user_id // Ensure user can only delete their own entries
            ),
            array('%d', '%d')
        );

        if ($result === false) {
            throw new Exception($wpdb->last_error);
        }

        return $result;
    }
} 