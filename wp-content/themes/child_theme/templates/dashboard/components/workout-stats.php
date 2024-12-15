<?php
/**
 * Template for displaying workout statistics
 *
 * @package AthleteDashboard
 * @var array $stats Workout statistics data
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

<div class="workout-statistics">
    <div class="stat-card">
        <span class="stat-label"><?php esc_html_e('Total Workouts', 'athlete-dashboard'); ?></span>
        <div class="stat-number"><?php echo esc_html($stats['total_workouts']); ?></div>
        <div class="stat-trend <?php echo esc_attr($stats['workout_trend'] >= 0 ? 'positive' : 'negative'); ?>">
            <?php 
            $trend_icon = $stats['workout_trend'] >= 0 ? 'arrow-up-alt' : 'arrow-down-alt';
            printf(
                '<span class="dashicons dashicons-%s"></span> %d%%',
                esc_attr($trend_icon),
                abs($stats['workout_trend'])
            );
            ?>
        </div>
    </div>

    <div class="stat-card">
        <span class="stat-label"><?php esc_html_e('Completion Rate', 'athlete-dashboard'); ?></span>
        <div class="stat-number"><?php echo esc_html($stats['completion_rate']); ?>%</div>
        <div class="completion-bar">
            <div class="completion-progress" style="width: <?php echo esc_attr($stats['completion_rate']); ?>%"></div>
        </div>
    </div>

    <div class="stat-card">
        <span class="stat-label"><?php esc_html_e('Total Time', 'athlete-dashboard'); ?></span>
        <div class="stat-number">
            <?php 
            $hours = floor($stats['total_minutes'] / 60);
            $minutes = $stats['total_minutes'] % 60;
            printf(
                esc_html__('%dh %dm', 'athlete-dashboard'),
                $hours,
                $minutes
            );
            ?>
        </div>
        <div class="stat-trend <?php echo esc_attr($stats['time_trend'] >= 0 ? 'positive' : 'negative'); ?>">
            <?php 
            $trend_icon = $stats['time_trend'] >= 0 ? 'arrow-up-alt' : 'arrow-down-alt';
            printf(
                '<span class="dashicons dashicons-%s"></span> %d%%',
                esc_attr($trend_icon),
                abs($stats['time_trend'])
            );
            ?>
        </div>
    </div>

    <div class="stat-card">
        <span class="stat-label"><?php esc_html_e('Calories Burned', 'athlete-dashboard'); ?></span>
        <div class="stat-number">
            <?php echo number_format($stats['total_calories']); ?>
        </div>
        <div class="stat-trend <?php echo esc_attr($stats['calories_trend'] >= 0 ? 'positive' : 'negative'); ?>">
            <?php 
            $trend_icon = $stats['calories_trend'] >= 0 ? 'arrow-up-alt' : 'arrow-down-alt';
            printf(
                '<span class="dashicons dashicons-%s"></span> %d%%',
                esc_attr($trend_icon),
                abs($stats['calories_trend'])
            );
            ?>
        </div>
    </div>

    <?php if (!empty($stats['favorite_workouts'])) : ?>
        <div class="stat-card wide">
            <span class="stat-label"><?php esc_html_e('Most Popular Workouts', 'athlete-dashboard'); ?></span>
            <div class="favorite-workouts">
                <?php foreach ($stats['favorite_workouts'] as $workout) : ?>
                    <div class="favorite-workout-item">
                        <span class="workout-name"><?php echo esc_html($workout['name']); ?></span>
                        <span class="workout-count">
                            <?php 
                            printf(
                                esc_html(_n('%d time', '%d times', $workout['count'], 'athlete-dashboard')),
                                $workout['count']
                            );
                            ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div> 