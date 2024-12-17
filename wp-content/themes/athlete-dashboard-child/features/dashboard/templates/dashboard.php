<?php
/**
 * Template Name: Athlete Dashboard
 * Template Post Type: page
 */

if (!defined('ABSPATH')) {
    exit;
}

$dashboard = new Dashboard();
$profile = new Profile();
$workout_generator = new WorkoutGenerator();

get_header();
?>

<div id="main-content">
    <div class="container">
        <div id="content-area" class="clearfix">
            <div class="dashboard-container">
                <div class="dashboard-welcome">
                    <h1><?php echo esc_html__('Welcome to Your Fitness Dashboard', 'athlete-dashboard-child'); ?></h1>
                    <p><?php echo esc_html__('Track your workouts, monitor progress, and achieve your fitness goals.', 'athlete-dashboard-child'); ?></p>
                </div>

                <div class="dashboard-sections">
                    <!-- Profile Section -->
                    <div class="dashboard-section">
                        <div class="section-header">
                            <h2><?php echo esc_html__('Your Profile', 'athlete-dashboard-child'); ?></h2>
                        </div>
                        <?php echo $profile->render_form(); ?>
                    </div>

                    <!-- Workout Generator Section -->
                    <div class="dashboard-section">
                        <div class="section-header">
                            <h2><?php echo esc_html__('AI Workout Generator', 'athlete-dashboard-child'); ?></h2>
                        </div>
                        <?php echo $workout_generator->render_generator_form(); ?>
                    </div>

                    <!-- Quick Stats Section -->
                    <div class="dashboard-section">
                        <div class="section-header">
                            <h2><?php echo esc_html__('Quick Stats', 'athlete-dashboard-child'); ?></h2>
                        </div>
                        <div class="stats-container">
                            <?php $stats = $dashboard->get_dashboard_stats(); ?>
                            <div class="stat-box">
                                <h3><?php echo esc_html__('Workouts Generated', 'athlete-dashboard-child'); ?></h3>
                                <p class="stat-number"><?php echo esc_html($stats['workouts_generated']); ?></p>
                            </div>
                            <div class="stat-box">
                                <h3><?php echo esc_html__('Workouts Completed', 'athlete-dashboard-child'); ?></h3>
                                <p class="stat-number"><?php echo esc_html($stats['workouts_completed']); ?></p>
                            </div>
                            <div class="stat-box">
                                <h3><?php echo esc_html__('Progress', 'athlete-dashboard-child'); ?></h3>
                                <p class="stat-number"><?php echo esc_html($stats['progress']); ?>%</p>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Workouts Section -->
                    <div class="dashboard-section">
                        <div class="section-header">
                            <h2><?php echo esc_html__('Recent Workouts', 'athlete-dashboard-child'); ?></h2>
                            <a href="<?php echo esc_url(home_url('/workouts/')); ?>" class="view-all-link">
                                <?php echo esc_html__('View All', 'athlete-dashboard-child'); ?>
                            </a>
                        </div>
                        <div class="recent-workouts">
                            <?php
                            $recent_workouts = $dashboard->get_recent_workouts(3);
                            if (!empty($recent_workouts)) {
                                foreach ($recent_workouts as $workout) {
                                    echo '<div class="workout-card">';
                                    echo '<h4>' . esc_html($workout->post_title) . '</h4>';
                                    echo '<p class="workout-date">' . get_the_date('F j, Y', $workout) . '</p>';
                                    echo '<a href="' . esc_url(get_permalink($workout)) . '" class="view-workout-link">';
                                    echo esc_html__('View Workout', 'athlete-dashboard-child');
                                    echo '</a>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<p class="no-workouts">' . esc_html__('No workouts generated yet. Use the AI Workout Generator to create your first workout!', 'athlete-dashboard-child') . '</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?> 