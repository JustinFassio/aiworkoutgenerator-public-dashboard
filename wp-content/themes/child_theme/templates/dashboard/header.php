<?php
/**
 * Dashboard Header Template
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$current_user = wp_get_current_user();
?>

<div class="athlete-dashboard-wrapper">
    <header class="dashboard-header">
        <div class="welcome-message">
            <h1>Welcome back, <?php echo esc_html($current_user->display_name); ?></h1>
        </div>
        <nav class="dashboard-nav">
            <ul>
                <li><a href="#overview" class="active">Overview</a></li>
                <li><a href="#workouts">Workouts</a></li>
                <li><a href="#progress">Progress</a></li>
                <li><a href="#nutrition">Nutrition</a></li>
                <li><a href="#messages">Messages</a></li>
            </ul>
        </nav>
    </header>
    
    <div class="dashboard-content"> 