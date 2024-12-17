<?php
/**
 * Charts Section Template
 * 
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$user_id = get_current_user_id();
$charts_manager = new Athlete_Dashboard_Charts_Manager();
?>

<div class="charts-container">
    <div class="section-header">
        <h2><?php _e('Progress Charts', 'athlete-dashboard'); ?></h2>
        <div class="chart-controls">
            <select id="chart-type-selector">
                <option value="attendance"><?php _e('Attendance', 'athlete-dashboard'); ?></option>
                <option value="goals"><?php _e('Goals Progress', 'athlete-dashboard'); ?></option>
            </select>
            <select id="chart-period-selector">
                <option value="7days"><?php _e('Last 7 Days', 'athlete-dashboard'); ?></option>
                <option value="30days" selected><?php _e('Last 30 Days', 'athlete-dashboard'); ?></option>
                <option value="90days"><?php _e('Last 90 Days', 'athlete-dashboard'); ?></option>
                <option value="12months"><?php _e('Last 12 Months', 'athlete-dashboard'); ?></option>
            </select>
        </div>
    </div>

    <div class="charts-content">
        <!-- Attendance Chart -->
        <div class="chart-panel active" id="attendance-chart">
            <div class="chart-header">
                <h3><?php _e('Workout Attendance', 'athlete-dashboard'); ?></h3>
            </div>
            <div class="chart-container">
                <canvas id="attendance-canvas"></canvas>
            </div>
            <div class="chart-summary">
                <?php
                $attendance_stats = $charts_manager->get_attendance_data($user_id, '30days');
                if (!empty($attendance_stats)) :
                ?>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <span class="stat-label"><?php _e('Attendance Rate', 'athlete-dashboard'); ?></span>
                            <span class="stat-value"><?php echo esc_html($attendance_stats->attendance_rate); ?>%</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label"><?php _e('Best Streak', 'athlete-dashboard'); ?></span>
                            <span class="stat-value"><?php echo esc_html($attendance_stats->best_streak); ?> days</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label"><?php _e('Most Active Day', 'athlete-dashboard'); ?></span>
                            <span class="stat-value"><?php echo esc_html($attendance_stats->most_active_day); ?></span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Goals Progress Chart -->
        <div class="chart-panel" id="goals-chart">
            <div class="chart-header">
                <h3><?php _e('Goals Progress', 'athlete-dashboard'); ?></h3>
                <select id="goals-category-selector">
                    <option value=""><?php _e('All Goals', 'athlete-dashboard'); ?></option>
                    <option value="strength"><?php _e('Strength', 'athlete-dashboard'); ?></option>
                    <option value="cardio"><?php _e('Cardio', 'athlete-dashboard'); ?></option>
                    <option value="weight"><?php _e('Weight', 'athlete-dashboard'); ?></option>
                </select>
            </div>
            <div class="chart-container">
                <canvas id="goals-canvas"></canvas>
            </div>
            <div class="chart-summary">
                <?php
                $goals_stats = $charts_manager->get_goals_data($user_id);
                if (!empty($goals_stats)) :
                ?>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <span class="stat-label"><?php _e('Active Goals', 'athlete-dashboard'); ?></span>
                            <span class="stat-value"><?php echo esc_html($goals_stats->active_count); ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label"><?php _e('Completed', 'athlete-dashboard'); ?></span>
                            <span class="stat-value"><?php echo esc_html($goals_stats->completed_count); ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label"><?php _e('Success Rate', 'athlete-dashboard'); ?></span>
                            <span class="stat-value"><?php echo esc_html($goals_stats->success_rate); ?>%</span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Chart Configuration Template -->
<script type="text/template" id="chart-config-template">
    {
        "attendance": {
            "type": "bar",
            "options": {
                "responsive": true,
                "maintainAspectRatio": false,
                "scales": {
                    "y": {
                        "beginAtZero": true
                    }
                }
            }
        },
        "goals": {
            "type": "doughnut",
            "options": {
                "responsive": true,
                "maintainAspectRatio": false,
                "cutout": "70%"
            }
        }
    }
</script> 