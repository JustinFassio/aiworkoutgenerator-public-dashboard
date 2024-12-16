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
        'Athlete_Dashboard_Core_Components' => '/includes/dashboard/class-core-components.php',
        'Athlete_Dashboard_Settings_Store' => '/includes/stores/class-settings-store.php',
        'Athlete_Dashboard_User_Preferences_Store' => '/includes/stores/class-user-preferences-store.php',
        'Athlete_Dashboard_Controller' => '/includes/dashboard/class-dashboard-controller.php',
        
        // Manager classes
        'Athlete_Dashboard_UI_Manager' => '/includes/dashboard/class-ui-manager.php',
        'Athlete_Dashboard_Workout_Manager' => '/includes/dashboard/class-workout-manager.php',
        'Athlete_Dashboard_Goals_Manager' => '/includes/dashboard/class-goals-manager.php',
        'Athlete_Dashboard_Attendance_Manager' => '/includes/dashboard/class-attendance-manager.php',
        'Athlete_Dashboard_Membership_Manager' => '/includes/dashboard/class-membership-manager.php',
        'Athlete_Dashboard_Messaging_Manager' => '/includes/dashboard/class-messaging-manager.php',
        'Athlete_Dashboard_Charts_Manager' => '/includes/dashboard/class-charts-manager.php',
        
        // Data managers
        'Athlete_Dashboard_Data_Manager' => '/includes/data/class-data-manager.php',
        'Athlete_Dashboard_Workout_Data_Manager' => '/includes/data/class-workout-data-manager.php',
        'Athlete_Dashboard_Exercise_Data_Manager' => '/includes/data/class-exercise-data-manager.php',
        'Athlete_Dashboard_Workout_Progress_Manager' => '/includes/data/class-workout-progress-manager.php',
        'Athlete_Dashboard_Workout_Stats_Manager' => '/includes/data/class-workout-stats-manager.php',
        'Athlete_Dashboard_Nutrition_Data_Manager' => '/includes/data/class-nutrition-data-manager.php',
        'Athlete_Dashboard_Food_Data_Manager' => '/includes/data/class-food-data-manager.php',
        'Athlete_Dashboard_Goals_Data_Manager' => '/includes/data/class-goals-data-manager.php',
        'Athlete_Dashboard_Attendance_Data_Manager' => '/includes/data/class-attendance-data-manager.php',
        'Athlete_Dashboard_User_Data_Manager' => '/includes/data/class-user-data-manager.php',

        // Dashboard Components
        'Athlete_Dashboard_Welcome_Banner' => '/includes/dashboard/components/class-welcome-banner.php',
        'Athlete_Dashboard_Account_Details' => '/includes/dashboard/components/class-account-details.php',
        'Athlete_Dashboard_Workout_Detail' => '/includes/dashboard/components/class-workout-detail.php',
        'Athlete_Dashboard_Workout_Logger' => '/includes/dashboard/components/class-workout-logger.php',
        'Athlete_Dashboard_Nutrition_Logger' => '/includes/dashboard/components/class-nutrition-logger.php',
        'Athlete_Dashboard_Nutrition_Tracker' => '/includes/dashboard/components/class-nutrition-tracker.php',
        'Athlete_Dashboard_Food_Manager' => '/includes/dashboard/components/class-food-manager.php',
        'Athlete_Dashboard_Workout_Stats_Display' => '/includes/dashboard/components/class-workout-stats-display.php',
        'Athlete_Dashboard_Progress_Tracker' => '/includes/dashboard/components/class-progress-tracker.php',

        // Handlers
        'Athlete_Dashboard_Workout_Handler' => '/includes/dashboard/handlers/class-workout-handler.php',
        'Athlete_Dashboard_Account_Handler' => '/includes/dashboard/handlers/class-account-handler.php',
        'Athlete_Dashboard_Nutrition_Handler' => '/includes/dashboard/handlers/class-nutrition-handler.php'
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
        // Only handle our classes
        if (strpos($class, 'Athlete_Dashboard_') !== 0) {
            return;
        }

        // First check the class map
        if (isset($this->class_map[$class])) {
            $file = ATHLETE_DASHBOARD_PATH . $this->class_map[$class];
            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }

        // Convert class name to file path
        $path = $this->get_file_path_from_class($class);
        if ($path) {
            $file = ATHLETE_DASHBOARD_PATH . $path;
            if (file_exists($file)) {
                require_once $file;
            }
        }
    }

    /**
     * Convert class name to file path
     */
    private function get_file_path_from_class($class) {
        // Remove prefix
        $class = str_replace('Athlete_Dashboard_', '', $class);

        // Convert to lowercase and add hyphens
        $file = 'class-' . str_replace('_', '-', strtolower($class)) . '.php';

        // Determine directory based on class type
        if (strpos($class, 'Manager') !== false) {
            return '/includes/dashboard/' . $file;
        } elseif (strpos($class, 'Data') !== false) {
            return '/includes/data/' . $file;
        } elseif (strpos($class, 'Store') !== false) {
            return '/includes/stores/' . $file;
        } elseif (strpos($class, 'Component') !== false || strpos($class, 'Display') !== false) {
            return '/includes/dashboard/components/' . $file;
        } elseif (strpos($class, 'Handler') !== false) {
            return '/includes/dashboard/handlers/' . $file;
        }

        // Default to dashboard directory
        return '/includes/dashboard/' . $file;
    }
} 