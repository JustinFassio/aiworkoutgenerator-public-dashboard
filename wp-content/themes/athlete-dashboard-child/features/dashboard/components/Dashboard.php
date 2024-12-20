<?php
/**
 * Dashboard Component
 */

namespace AthleteDashboard\Features\Dashboard\Components;

use AthleteDashboard\Features\Profile\Components\Profile;
use AthleteDashboard\Features\TrainingPersona\Components\TrainingPersona;

if (!defined('ABSPATH')) {
    exit;
}

require_once dirname(__FILE__) . '/NavigationCards.php';
require_once get_stylesheet_directory() . '/features/profile/components/Profile.php';
require_once get_stylesheet_directory() . '/features/training-persona/components/TrainingPersona.php';

class Dashboard {
    private $navigation;
    private $version = '1.0.0';
    private $profile;
    private $training_persona;

    public function __construct() {
        $this->navigation = new NavigationCards();
        $this->profile = new Profile();
        $this->training_persona = new TrainingPersona();
        
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        add_action('wp_ajax_get_dashboard_data', array($this, 'get_dashboard_data'));
    }

    public function enqueue_assets() {
        // Navigation styles and scripts
        wp_enqueue_style(
            'dashboard-navigation',
            get_stylesheet_directory_uri() . '/features/dashboard/assets/css/navigation-cards.css',
            array(),
            $this->version
        );

        wp_enqueue_script(
            'dashboard-navigation',
            get_stylesheet_directory_uri() . '/features/dashboard/assets/js/navigation.js',
            array('jquery'),
            $this->version,
            true
        );

        wp_localize_script('dashboard-navigation', 'navigationData', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('dashboard_nonce')
        ));
    }

    public function render() {
        ?>
        <div class="athlete-dashboard">
            <div class="dashboard-header">
                <h1><?php _e('Athlete Dashboard', 'athlete-dashboard-child'); ?></h1>
                <div class="dashboard-actions">
                    <button class="action-button" data-modal="profile">
                        <?php _e('Update Profile', 'athlete-dashboard-child'); ?>
                    </button>
                    <button class="action-button" data-modal="training-persona">
                        <?php _e('Training Persona', 'athlete-dashboard-child'); ?>
                    </button>
                </div>
            </div>

            <div class="dashboard-content">
                <!-- Profile Summary -->
                <div class="dashboard-section profile-summary">
                    <h2><?php _e('Profile Summary', 'athlete-dashboard-child'); ?></h2>
                    <?php $this->render_profile_summary(); ?>
                </div>

                <!-- Training Persona Summary -->
                <div class="dashboard-section training-persona-summary">
                    <h2><?php _e('Training Persona', 'athlete-dashboard-child'); ?></h2>
                    <?php $this->render_training_persona_summary(); ?>
                </div>

                <!-- Navigation Cards -->
                <div class="dashboard-section navigation-cards">
                    <h2><?php _e('Quick Actions', 'athlete-dashboard-child'); ?></h2>
                    <?php $this->navigation->render(); ?>
                </div>
            </div>

            <!-- Modals -->
            <div id="profile-modal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2><?php _e('Update Profile', 'athlete-dashboard-child'); ?></h2>
                        <button class="close-modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php $this->profile->render_form(); ?>
                    </div>
                </div>
            </div>

            <div id="training-persona-modal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2><?php _e('Training Persona', 'athlete-dashboard-child'); ?></h2>
                        <button class="close-modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php $this->training_persona->render_form(); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    private function render_profile_summary() {
        $profile_data = $this->profile->get_profile_data();
        ?>
        <div class="summary-grid">
            <div class="summary-item">
                <span class="label"><?php _e('Age', 'athlete-dashboard-child'); ?></span>
                <span class="value"><?php echo esc_html($profile_data['age'] ?? '--'); ?></span>
            </div>
            <div class="summary-item">
                <span class="label"><?php _e('Height', 'athlete-dashboard-child'); ?></span>
                <span class="value">
                    <?php
                    if (isset($profile_data['height'])) {
                        $unit = $profile_data['height_unit'] ?? 'imperial';
                        if ($unit === 'imperial') {
                            $feet = floor($profile_data['height'] / 12);
                            $inches = $profile_data['height'] % 12;
                            echo sprintf('%d\'%d"', $feet, $inches);
                        } else {
                            echo sprintf('%d cm', $profile_data['height']);
                        }
                    } else {
                        echo '--';
                    }
                    ?>
                </span>
            </div>
            <div class="summary-item">
                <span class="label"><?php _e('Weight', 'athlete-dashboard-child'); ?></span>
                <span class="value">
                    <?php
                    if (isset($profile_data['weight'])) {
                        $unit = $profile_data['weight_unit'] ?? 'imperial';
                        echo sprintf('%s %s', $profile_data['weight'], $unit === 'imperial' ? 'lbs' : 'kg');
                    } else {
                        echo '--';
                    }
                    ?>
                </span>
            </div>
        </div>
        <?php
    }

    private function render_training_persona_summary() {
        $persona_data = $this->training_persona->get_persona_data();
        ?>
        <div class="summary-grid">
            <div class="summary-item">
                <span class="label"><?php _e('Experience Level', 'athlete-dashboard-child'); ?></span>
                <span class="value"><?php echo esc_html($this->format_persona_field('experience_level', $persona_data)); ?></span>
            </div>
            <div class="summary-item">
                <span class="label"><?php _e('Current Activity Level', 'athlete-dashboard-child'); ?></span>
                <span class="value"><?php echo esc_html($this->format_persona_field('current_activity_level', $persona_data)); ?></span>
            </div>
            <div class="summary-item goals">
                <span class="label"><?php _e('Goals', 'athlete-dashboard-child'); ?></span>
                <div class="goals-list">
                    <?php
                    if (!empty($persona_data['goals'])) {
                        foreach ($persona_data['goals'] as $goal) {
                            echo '<span class="goal-tag">' . esc_html($this->get_goal_label($goal)) . '</span>';
                        }
                    } else {
                        echo '<span class="empty">No goals set</span>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }

    private function format_persona_field($field, $data) {
        if (empty($data[$field])) {
            return '--';
        }

        $fields = $this->training_persona->get_fields();
        if (!isset($fields[$field])) {
            return $data[$field];
        }

        $field_config = $fields[$field];
        if ($field_config['type'] === 'select' && isset($field_config['options'][$data[$field]])) {
            return $field_config['options'][$data[$field]];
        }

        return $data[$field];
    }

    private function get_goal_label($goal_key) {
        $goals = [
            'build_strength' => 'Build Strength',
            'increase_flexibility' => 'Increase Flexibility',
            'weight_management' => 'Weight Management'
        ];

        return $goals[$goal_key] ?? $goal_key;
    }

    public function get_dashboard_data() {
        check_ajax_referer('dashboard_nonce', 'nonce');

        $profile_data = $this->profile->get_profile_data();
        $persona_data = $this->training_persona->get_persona_data();

        wp_send_json_success([
            'profile' => $profile_data,
            'training_persona' => $persona_data
        ]);
    }
} 