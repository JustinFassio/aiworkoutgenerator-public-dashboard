<?php
/**
 * Attendance Section Template
 * 
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$user_id = get_current_user_id();
$attendance_manager = new Athlete_Dashboard_Attendance_Manager();
$current_month = date('Y-m');
$attendance_data = $attendance_manager->get_monthly_attendance($user_id, $current_month);
$streak = $attendance_manager->get_current_streak($user_id);
?>

<div class="attendance-container">
    <div class="section-header">
        <h2><?php _e('Workout Attendance', 'athlete-dashboard'); ?></h2>
        <div class="attendance-stats">
            <div class="stat-item">
                <span class="stat-label"><?php _e('Current Streak', 'athlete-dashboard'); ?></span>
                <span class="stat-value"><?php echo esc_html($streak); ?> <?php _e('days', 'athlete-dashboard'); ?></span>
            </div>
            <div class="stat-item">
                <span class="stat-label"><?php _e('This Month', 'athlete-dashboard'); ?></span>
                <span class="stat-value"><?php echo esc_html(count($attendance_data)); ?> <?php _e('workouts', 'athlete-dashboard'); ?></span>
            </div>
        </div>
    </div>

    <div class="attendance-content">
        <div class="attendance-calendar">
            <?php
            $calendar = new Athlete_Dashboard_Workout_Calendar();
            echo $calendar->generate_calendar($current_month, $attendance_data);
            ?>
        </div>

        <div class="attendance-history">
            <h3><?php _e('Recent Activity', 'athlete-dashboard'); ?></h3>
            <?php
            $recent_activity = $attendance_manager->get_recent_activity($user_id, 5);
            if (!empty($recent_activity)) :
            ?>
                <ul class="activity-list">
                    <?php foreach ($recent_activity as $activity) : ?>
                        <li class="activity-item">
                            <div class="activity-date">
                                <?php echo esc_html(date_i18n(get_option('date_format'), strtotime($activity->date))); ?>
                            </div>
                            <div class="activity-details">
                                <span class="activity-type">
                                    <?php echo esc_html($activity->workout_type); ?>
                                </span>
                                <span class="activity-duration">
                                    <?php printf(__('%s minutes', 'athlete-dashboard'), esc_html($activity->duration)); ?>
                                </span>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p class="no-activity">
                    <?php _e('No recent workout activity recorded.', 'athlete-dashboard'); ?>
                </p>
            <?php endif; ?>
        </div>
    </div>

    <div class="attendance-insights">
        <h3><?php _e('Attendance Insights', 'athlete-dashboard'); ?></h3>
        <?php
        $insights = $attendance_manager->get_attendance_insights($user_id);
        if (!empty($insights)) :
        ?>
            <div class="insights-grid">
                <?php foreach ($insights as $insight) : ?>
                    <div class="insight-card">
                        <div class="insight-icon">
                            <i class="<?php echo esc_attr($insight->icon); ?>"></i>
                        </div>
                        <div class="insight-content">
                            <h4><?php echo esc_html($insight->title); ?></h4>
                            <p><?php echo esc_html($insight->description); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Check-in Form Template -->
<script type="text/template" id="checkin-form-template">
    <form id="checkin-form" class="checkin-form">
        <div class="form-group">
            <label for="workout-type"><?php _e('Workout Type', 'athlete-dashboard'); ?></label>
            <select id="workout-type" name="workout_type" required>
                <option value="strength"><?php _e('Strength Training', 'athlete-dashboard'); ?></option>
                <option value="cardio"><?php _e('Cardio', 'athlete-dashboard'); ?></option>
                <option value="hiit"><?php _e('HIIT', 'athlete-dashboard'); ?></option>
                <option value="yoga"><?php _e('Yoga', 'athlete-dashboard'); ?></option>
                <option value="other"><?php _e('Other', 'athlete-dashboard'); ?></option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="workout-duration"><?php _e('Duration (minutes)', 'athlete-dashboard'); ?></label>
            <input type="number" id="workout-duration" name="duration" min="1" required>
        </div>
        
        <div class="form-group">
            <label for="workout-notes"><?php _e('Notes', 'athlete-dashboard'); ?></label>
            <textarea id="workout-notes" name="notes"></textarea>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="save-checkin"><?php _e('Check In', 'athlete-dashboard'); ?></button>
            <button type="button" class="cancel-checkin"><?php _e('Cancel', 'athlete-dashboard'); ?></button>
        </div>
    </form>
</script> 