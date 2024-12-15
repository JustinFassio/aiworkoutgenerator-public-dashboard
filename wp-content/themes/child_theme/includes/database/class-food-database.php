<?php
/**
 * Food Database Class
 * 
 * Handles food database operations
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Food_Database {
    /**
     * The table name
     */
    private $table_name;

    /**
     * Initialize the database
     */
    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'athlete_foods';
        $this->init();
    }

    /**
     * Initialize the database table
     */
    private function init() {
        $this->create_table();
    }

    /**
     * Create the foods table if it doesn't exist
     */
    private function create_table() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS {$this->table_name} (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            serving_size varchar(100) NOT NULL,
            calories int(11) NOT NULL,
            protein float NOT NULL,
            carbs float NOT NULL,
            fat float NOT NULL,
            is_public tinyint(1) DEFAULT 0,
            user_id bigint(20) NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY  (id),
            KEY user_id (user_id),
            KEY is_public (is_public)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    /**
     * Add a new food item
     */
    public function add_food($data) {
        global $wpdb;

        $defaults = array(
            'is_public' => 0,
            'user_id' => get_current_user_id()
        );

        $data = wp_parse_args($data, $defaults);
        
        return $wpdb->insert($this->table_name, $data);
    }

    /**
     * Update a food item
     */
    public function update_food($id, $data) {
        global $wpdb;
        
        return $wpdb->update(
            $this->table_name,
            $data,
            array('id' => $id)
        );
    }

    /**
     * Delete a food item
     */
    public function delete_food($id) {
        global $wpdb;
        
        return $wpdb->delete(
            $this->table_name,
            array('id' => $id)
        );
    }

    /**
     * Get a food item by ID
     */
    public function get_food($id) {
        global $wpdb;
        
        return $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$this->table_name} WHERE id = %d",
                $id
            )
        );
    }

    /**
     * Search foods
     */
    public function search_foods($query, $user_id = null) {
        global $wpdb;

        if (!$user_id) {
            $user_id = get_current_user_id();
        }

        return $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$this->table_name} 
                WHERE (user_id = %d OR is_public = 1)
                AND name LIKE %s
                ORDER BY name ASC
                LIMIT 10",
                $user_id,
                '%' . $wpdb->esc_like($query) . '%'
            )
        );
    }

    /**
     * Get all foods for a user
     */
    public function get_user_foods($user_id = null) {
        global $wpdb;

        if (!$user_id) {
            $user_id = get_current_user_id();
        }

        return $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$this->table_name} 
                WHERE user_id = %d
                ORDER BY name ASC",
                $user_id
            )
        );
    }

    /**
     * Get public foods
     */
    public function get_public_foods() {
        global $wpdb;

        return $wpdb->get_results(
            "SELECT * FROM {$this->table_name} 
            WHERE is_public = 1
            ORDER BY name ASC"
        );
    }
} 