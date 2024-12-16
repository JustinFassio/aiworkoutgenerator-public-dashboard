<?php
/**
 * Main Dashboard Template
 * 
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

<div class="athlete-dashboard" id="athlete-dashboard">
    <div class="dashboard-header">
        <?php do_action('athlete_dashboard_before_header'); ?>
        
        <div class="welcome-banner">
            <?php do_action('athlete_dashboard_welcome_banner'); ?>
        </div>
        
        <div class="quick-stats">
            <?php do_action('athlete_dashboard_quick_stats'); ?>
        </div>
        
        <?php do_action('athlete_dashboard_after_header'); ?>
    </div>

    <div class="dashboard-main">
        <div class="dashboard-content">
            <?php do_action('athlete_dashboard_before_content'); ?>
            
            <div class="dashboard-section workout-section">
                <?php 
                do_action('athlete_dashboard_before_workout_section');
                include(ATHLETE_DASHBOARD_PATH . '/templates/dashboard/sections/workout-section.php');
                do_action('athlete_dashboard_after_workout_section');
                ?>
            </div>

            <div class="dashboard-section goals-section">
                <?php 
                do_action('athlete_dashboard_before_goals_section');
                include(ATHLETE_DASHBOARD_PATH . '/templates/dashboard/sections/goals-section.php');
                do_action('athlete_dashboard_after_goals_section');
                ?>
            </div>

            <div class="dashboard-section attendance-section">
                <?php 
                do_action('athlete_dashboard_before_attendance_section');
                include(ATHLETE_DASHBOARD_PATH . '/templates/dashboard/sections/attendance-section.php');
                do_action('athlete_dashboard_after_attendance_section');
                ?>
            </div>

            <?php do_action('athlete_dashboard_after_content'); ?>
        </div>

        <div class="dashboard-sidebar">
            <?php do_action('athlete_dashboard_before_sidebar'); ?>
            
            <div class="dashboard-section membership-section">
                <?php 
                do_action('athlete_dashboard_before_membership_section');
                include(ATHLETE_DASHBOARD_PATH . '/templates/dashboard/sections/membership-section.php');
                do_action('athlete_dashboard_after_membership_section');
                ?>
            </div>

            <div class="dashboard-section messaging-section">
                <?php 
                do_action('athlete_dashboard_before_messaging_section');
                include(ATHLETE_DASHBOARD_PATH . '/templates/dashboard/sections/messaging-section.php');
                do_action('athlete_dashboard_after_messaging_section');
                ?>
            </div>

            <div class="dashboard-section charts-section">
                <?php 
                do_action('athlete_dashboard_before_charts_section');
                include(ATHLETE_DASHBOARD_PATH . '/templates/dashboard/sections/charts-section.php');
                do_action('athlete_dashboard_after_charts_section');
                ?>
            </div>
            
            <?php do_action('athlete_dashboard_after_sidebar'); ?>
        </div>
    </div>

    <div class="dashboard-footer">
        <?php do_action('athlete_dashboard_footer'); ?>
    </div>
</div> 