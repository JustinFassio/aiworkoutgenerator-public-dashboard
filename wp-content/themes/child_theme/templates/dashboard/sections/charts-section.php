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
                <option value="workout"><?php _e('Workout Stats', 'athlete-dashboard'); ?></option>
                <option value="progress"><?php _e('Body Progress', 'athlete-dashboard'); ?></option>
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
        <!-- Workout Stats Chart -->
        <div class="chart-panel active" id="workout-stats-chart">
            <div class="chart-header">
                <h3><?php _e('Workout Statistics', 'athlete-dashboard'); ?></h3>
                <div class="chart-legend"></div>
            </div>
            <div class="chart-container">
                <canvas id="workout-stats-canvas"></canvas>
            </div>
            <div class="chart-summary">
                <?php
                $workout_stats = $charts_manager->get_workout_statistics($user_id, '30days');
                if (!empty($workout_stats)) :
                ?>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <span class="stat-label"><?php _e('Total Workouts', 'athlete-dashboard'); ?></span>
                            <span class="stat-value"><?php echo esc_html($workout_stats->total_workouts); ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label"><?php _e('Average Duration', 'athlete-dashboard'); ?></span>
                            <span class="stat-value"><?php echo esc_html($workout_stats->avg_duration); ?> min</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label"><?php _e('Calories Burned', 'athlete-dashboard'); ?></span>
                            <span class="stat-value"><?php echo esc_html($workout_stats->total_calories); ?></span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Progress Chart -->
        <div class="chart-panel" id="progress-chart">
            <div class="chart-header">
                <h3><?php _e('Body Progress', 'athlete-dashboard'); ?></h3>
                <select id="progress-metric-selector">
                    <option value="weight"><?php _e('Weight', 'athlete-dashboard'); ?></option>
                    <option value="body_fat"><?php _e('Body Fat %', 'athlete-dashboard'); ?></option>
                    <option value="muscle_mass"><?php _e('Muscle Mass', 'athlete-dashboard'); ?></option>
                    <option value="waist"><?php _e('Waist', 'athlete-dashboard'); ?></option>
                </select>
            </div>
            <div class="chart-container">
                <canvas id="progress-canvas"></canvas>
            </div>
            <div class="chart-summary">
                <?php
                $progress_stats = $charts_manager->get_progress_metrics($user_id, 'weight');
                if (!empty($progress_stats)) :
                ?>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <span class="stat-label"><?php _e('Starting', 'athlete-dashboard'); ?></span>
                            <span class="stat-value"><?php echo esc_html($progress_stats->starting); ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label"><?php _e('Current', 'athlete-dashboard'); ?></span>
                            <span class="stat-value"><?php echo esc_html($progress_stats->current); ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label"><?php _e('Change', 'athlete-dashboard'); ?></span>
                            <span class="stat-value <?php echo $progress_stats->change >= 0 ? 'positive' : 'negative'; ?>">
                                <?php echo esc_html($progress_stats->change); ?>
                            </span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Attendance Chart -->
        <div class="chart-panel" id="attendance-chart">
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
        "workout_stats": {
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
        "progress": {
            "type": "line",
            "options": {
                "responsive": true,
                "maintainAspectRatio": false,
                "tension": 0.4
            }
        },
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