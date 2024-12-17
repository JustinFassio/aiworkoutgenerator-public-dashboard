<?php
/**
 * Squat Progress Migration Class
 * 
 * Handles database table creation and updates for squat progress tracking
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Squat_Progress_Migration {
    /**
     * @var string
     */
    private $version_option = 'athlete_squat_progress_db_version';

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
        $data_manager = new Athlete_Dashboard_Squat_Progress_Data();
        $data_manager->create_table();
    }
} 