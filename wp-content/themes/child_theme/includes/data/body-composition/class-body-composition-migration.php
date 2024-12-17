<?php
/**
 * Body Composition Migration Class
 * 
 * Handles database table creation and updates for body composition tracking
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Body_Composition_Migration {
    /**
     * @var string
     */
    private $version_option = 'athlete_body_composition_db_version';

    /**
     * @var string
     */
    private $current_version = '1.0.0';

    /**
     * Run migrations if necessary
     */
    public function run() {
        $installed_version = get_option($this->version_option);

        if ($installed_version !== $this->current_version) {
            $this->create_tables();
            update_option($this->version_option, $this->current_version);
        }
    }

    /**
     * Create necessary database tables
     */
    private function create_tables() {
        $data_manager = new Athlete_Dashboard_Body_Composition_Data();
        $data_manager->create_table();
    }

    /**
     * Drop tables and clean up
     */
    public function cleanup() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'athlete_body_composition';
        
        $wpdb->query("DROP TABLE IF EXISTS {$table_name}");
        delete_option($this->version_option);
    }
} 