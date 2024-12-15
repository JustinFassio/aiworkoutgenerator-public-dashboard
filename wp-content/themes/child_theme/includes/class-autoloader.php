<?php
/**
 * Autoloader Class
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Autoloader {
    /**
     * Class mapping
     */
    private $class_map = array(
        // Core classes
        'Athlete_Dashboard_Controller' => '/includes/dashboard/class-dashboard-controller.php',
        'Athlete_Dashboard_Asset_Manager' => '/includes/class-asset-manager.php',
        
        // Data managers
        'Athlete_Dashboard_Data_Manager' => '/includes/data/class-data-manager.php',
        'Athlete_Dashboard_Nutrition_Data_Manager' => '/includes/data/class-nutrition-data-manager.php',
        'Athlete_Dashboard_Workout_Data_Manager' => '/includes/data/class-workout-data-manager.php',
        
        // Database classes
        'Athlete_Food_Database' => '/includes/database/class-food-database.php',
        'Athlete_Workout_Database' => '/includes/database/class-workout-database.php',
        
        // Handlers
        'Athlete_Dashboard_Workout_Handler' => '/includes/dashboard/handlers/class-workout-handler.php',
        'Athlete_Dashboard_Account_Handler' => '/includes/dashboard/handlers/class-account-handler.php',
        
        // Components
        'Athlete_Dashboard_Food_Manager' => '/includes/dashboard/components/class-food-manager.php',
        'Athlete_Dashboard_Nutrition_Logger' => '/includes/dashboard/components/class-nutrition-logger.php',
        'Athlete_Dashboard_Nutrition_Tracker' => '/includes/dashboard/components/class-nutrition-tracker.php',
        'Athlete_Dashboard_Workout_Logger' => '/includes/dashboard/components/class-workout-logger.php',
        'Athlete_Dashboard_Progress_Tracker' => '/includes/dashboard/components/class-progress-tracker.php',
        'Athlete_Dashboard_Account_Details' => '/includes/dashboard/components/class-account-details.php',
        'Athlete_Dashboard_Welcome_Banner' => '/includes/dashboard/components/class-welcome-banner.php',
        'Athlete_Dashboard_Workout_Lightbox' => '/includes/dashboard/components/class-workout-lightbox.php'
    );

    /**
     * Register the autoloader
     */
    public function register() {
        spl_autoload_register(array($this, 'autoload'));
    }

    /**
     * Autoload callback
     */
    public function autoload($class) {
        // First check the class map
        if (isset($this->class_map[$class])) {
            $file = ATHLETE_DASHBOARD_PATH . $this->class_map[$class];
            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }

        // Convert class name to file path
        $path_parts = $this->get_file_path_from_class($class);
        if (!$path_parts) {
            return;
        }

        $file = ATHLETE_DASHBOARD_PATH . $path_parts;
        if (file_exists($file)) {
            require_once $file;
        }
    }

    /**
     * Convert class name to file path
     */
    private function get_file_path_from_class($class) {
        // Only handle our classes
        if (strpos($class, 'Athlete_Dashboard_') !== 0 && strpos($class, 'Athlete_') !== 0) {
            return false;
        }

        // Remove prefix
        $class = str_replace(array('Athlete_Dashboard_', 'Athlete_'), '', $class);

        // Convert to lowercase and add hyphens
        $file = 'class-' . str_replace('_', '-', strtolower($class)) . '.php';

        // Determine directory based on class type
        if (strpos($class, 'Data_') === 0) {
            return '/includes/data/' . $file;
        } elseif (strpos($class, 'Component_') === 0) {
            return '/includes/dashboard/components/' . $file;
        } elseif (strpos($class, 'Handler_') === 0) {
            return '/includes/dashboard/handlers/' . $file;
        } elseif (strpos($class, 'Database') !== false) {
            return '/includes/database/' . $file;
        }

        // Default to components directory
        return '/includes/dashboard/components/' . $file;
    }
} 