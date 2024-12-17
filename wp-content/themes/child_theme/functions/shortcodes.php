<?php
// functions/shortcodes.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Shortcode to display user's email
function display_user_email() {
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        return esc_html($current_user->user_email);
    } else {
        return 'Not logged in.';
    }
}
add_shortcode('user_email', 'display_user_email');

// Shortcode to display user's username
function display_user_name() {
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        return esc_html($current_user->user_login);
    } else {
        return 'Not logged in.';
    }
}
add_shortcode('user_name', 'display_user_name');

function display_user_workouts() {
    if (!is_user_logged_in()) {
        return 'Please log in to view your workouts.';
    }
    $current_user = wp_get_current_user();
    $args = array(
        'post_type' => 'workout',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'assigned_subscriber',
                'value' => $current_user->ID,
                'compare' => '='
            )
        )
    );
    $workouts = new WP_Query($args);
    if ($workouts->have_posts()) {
        $output = '<div class="user-workouts">';
        while ($workouts->have_posts()) {
            $workouts->the_post();
            $output .= '<div class="workout-entry">';
            $output .= '<h3>' . esc_html(get_the_title()) . '</h3>';
            $output .= '<div>' . wp_kses_post(get_the_excerpt()) . '</div>';
            $output .= '<button class="view-workout-button" data-workout-id="' . get_the_ID() . '">View Workout</button>';
            $output .= '</div>';
        }
        $output .= '</div>';
        wp_reset_postdata();
        return $output;
    } else {
        return 'Your workout is being reviewed by a certified personal trainer and will be added soon, email trainers@aiworkoutgenerator.com with questions.';
    }
}
add_shortcode('user_workouts', 'display_user_workouts');

// Shortcode to display user's weight progress
function display_user_progress() {
    if (!is_user_logged_in()) {
        return 'Please log in to view your progress.';
    }

    $current_user = wp_get_current_user();
    $args = array(
        'post_type' => 'progress',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'assigned_subscriber',
                'value' => $current_user->ID,
                'compare' => '='
            )
        )
    );
    $progress = new WP_Query($args);

    if ($progress->have_posts()) {
        $progress_data = array();
        while ($progress->have_posts()) {
            $progress->the_post();
            $progress_data[] = array(
                'date' => get_the_date('Y-m-d'),
                'weight' => get_post_meta(get_the_ID(), 'weight', true),
                'unit' => get_post_meta(get_the_ID(), 'unit', true)
            );
        }
        wp_reset_postdata();
        return '<div id="user-progress-data" style="display:none;" data-progress="' . esc_attr(json_encode($progress_data)) . '"></div>';
    } else {
        return '<div id="user-progress-data" style="display:none;" data-progress="[]"></div>';
    }
}
add_shortcode('user_progress', 'display_user_progress');

// Shortcode to display user's squat progress
function display_user_squat_progress() {
    if (!is_user_logged_in()) {
        return 'Please log in to view your squat progress.';
    }

    $current_user = wp_get_current_user();
    $progress = get_user_meta($current_user->ID, 'squat_progress', true);

    if (!empty($progress) && is_array($progress)) {
        return '<div id="user-squat-progress-data" style="display:none;" data-progress="' . esc_attr(json_encode($progress)) . '"></div>';
    } else {
        return '<div id="user-squat-progress-data" style="display:none;" data-progress="[]"></div>';
    }
}
add_shortcode('user_squat_progress', 'display_user_squat_progress');

// Shortcode to display user's bench press progress
function display_user_bench_press_progress() {
    if (!is_user_logged_in()) {
        return 'Please log in to view your bench press progress.';
    }

    $current_user = wp_get_current_user();
    $progress = get_user_meta($current_user->ID, 'bench_press_progress', true);

    if (!empty($progress) && is_array($progress)) {
        return '<div id="user-bench-press-progress-data" style="display:none;" data-progress="' . esc_attr(json_encode($progress)) . '"></div>';
    } else {
        return '<div id="user-bench-press-progress-data" style="display:none;" data-progress="[]"></div>';
    }
}
add_shortcode('user_bench_press_progress', 'display_user_bench_press_progress');

/**
 * Shortcode to display user's deadlift progress
 */
function display_user_deadlift_progress() {
    if (!is_user_logged_in()) {
        return 'Please log in to view your deadlift progress.';
    }

    $current_user = wp_get_current_user();
    $progress = get_user_meta($current_user->ID, 'deadlift_progress', true);

    if (!empty($progress) && is_array($progress)) {
        return '<div id="user-deadlift-progress-data" style="display:none;" data-progress="' . esc_attr(json_encode($progress)) . '"></div>';
    } else {
        return '<div id="user-deadlift-progress-data" style="display:none;" data-progress="[]"></div>';
    }
}
add_shortcode('user_deadlift_progress', 'display_user_deadlift_progress');

// Shortcode to display user's trailhead
function display_user_overview() {
    if (!is_user_logged_in()) {
        return 'Please log in to view your trailhead.';
    }

    $args = array(
        'post_type' => 'overview',
        'posts_per_page' => 1,
        'meta_query' => array(
            array(
                'key' => '_assigned_user',
                'value' => get_current_user_id(),
            ),
        ),
    );

    $overview = new WP_Query($args);

    if ($overview->have_posts()) {
        $overview->the_post();
        $output = '<div class="user-overview">';
        $output .= get_the_content();
        $output .= '</div>';
        wp_reset_postdata();
        return $output;
    }

    return 'Your trainer is being assigned and your trailhead will be added shortly.';
}
add_shortcode('user_overview', 'display_user_overview');

// Shortcode to display user's fitness plan
function display_user_fitness_plan() {
    if (!is_user_logged_in()) {
        return 'Please log in to view your fitness plan.';
    }

    $current_user = wp_get_current_user();
    $args = array(
        'post_type' => 'fitness_plan',
        'posts_per_page' => 1,
        'meta_query' => array(
            array(
                'key' => 'assigned_subscriber',
                'value' => $current_user->ID,
                'compare' => '='
            )
        )
    );
    $fitness_plan = new WP_Query($args);

    if ($fitness_plan->have_posts()) {
        $fitness_plan->the_post();
        $output = '<div class="user-fitness-plan">';
        $output .= '<h3>' . esc_html(get_the_title()) . '</h3>';
        $output .= '<div>' . wp_kses_post(get_the_content()) . '</div>';
        $output .= '</div>';
        wp_reset_postdata();
        return $output;
    } else {
        return 'Your assigned trainer is reviewing your workout and will be addin a plan shortly.';
    }
}
add_shortcode('user_fitness_plan', 'display_user_fitness_plan');

// Shortcode to display user's nutrition
function display_user_nutrition() {
    if (!is_user_logged_in()) {
        return 'Please log in to view your nutrition plan.';
    }

    $current_user = wp_get_current_user();
    $args = array(
        'post_type' => 'nutrition',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'assigned_subscriber',
                'value' => $current_user->ID,
                'compare' => '='
            )
        )
    );
    $nutrition = new WP_Query($args);

    if ($nutrition->have_posts()) {
        $output = '<div class="user-nutrition">';
        while ($nutrition->have_posts()) {
            $nutrition->the_post();
            $output .= '<div class="nutrition-entry">';
            $output .= '<h3>' . esc_html(get_the_title()) . '</h3>';
            $output .= '<div>' . wp_kses_post(get_the_content()) . '</div>';
            $output .= '</div>';
        }
        $output .= '</div>';
        wp_reset_postdata();
        return $output;
    } else {
        return 'Please subscribe to the appropriate membership to receive a personalized nutrition program.';
    }
}
add_shortcode('user_nutrition', 'display_user_nutrition');
// Shortcode to display user's upcoming workouts
function display_user_upcoming_workouts() {
    if (!is_user_logged_in()) {
        return 'Please log in to view your upcoming workouts.';
    }

    $current_user = wp_get_current_user();
    $args = array(
        'post_type' => 'upcoming_workouts',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'assigned_subscriber',
                'value' => $current_user->ID,
                'compare' => '='
            )
        ),
        'orderby' => 'meta_value',
        'meta_key' => 'workout_date',
        'order' => 'ASC'
    );
    $upcoming_workouts = new WP_Query($args);

    if ($upcoming_workouts->have_posts()) {
        $output = '<div class="user-upcoming-workouts">';
        while ($upcoming_workouts->have_posts()) {
            $upcoming_workouts->the_post();
            $output .= '<div class="upcoming-workout">';
            $output .= '<h3>' . esc_html(get_the_title()) . '</h3>';
            $output .= '<div>' . wp_kses_post(get_the_content()) . '</div>';
            $workout_date = get_post_meta(get_the_ID(), 'workout_date', true);
            if ($workout_date) {
                $output .= '<p>Date: ' . esc_html(date('F j, Y', strtotime($workout_date))) . '</p>';
            }
            $output .= '</div>';
        }
        $output .= '</div>';
        wp_reset_postdata();
        return $output;
    } else {
        return 'Subscribe to receive a workout plan with progressions and unlimited workouts.';
    }
}
add_shortcode('user_upcoming_workouts', 'display_user_upcoming_workouts');

/**
 * Shortcode to display user's logged workouts
 */
function display_user_logged_workouts($atts) {
    $atts = shortcode_atts(array(
        'limit' => 5
    ), $atts, 'user_logged_workouts');

    if (!is_user_logged_in()) {
        return 'Please log in to view your logged workouts.';
    }

    $current_user = wp_get_current_user();
    $workout_logs = athlete_dashboard_get_user_workout_logs($current_user->ID, array('posts_per_page' => $atts['limit']));

    if (empty($workout_logs)) {
        return 'No logged workouts found.';
    }

    $output = '<div class="user-logged-workouts">';
    foreach ($workout_logs as $log) {
        $output .= '<div class="workout-log-entry">';
        $output .= '<h4>' . esc_html($log['date']) . ' - ' . esc_html($log['type']) . '</h4>';
        $output .= '<p>Duration: ' . esc_html($log['duration']) . ' minutes</p>';
        $output .= '<p>Intensity: ' . esc_html($log['intensity']) . '/10</p>';
        if (!empty($log['notes'])) {
            $output .= '<p>Notes: ' . esc_html($log['notes']) . '</p>';
        }
        $output .= '</div>';
    }
    $output .= '</div>';

    return $output;
}
add_shortcode('user_logged_workouts', 'display_user_logged_workouts');

/**
 * Shortcode to display user's logged meals
 */
function display_user_logged_meals($atts) {
    $atts = shortcode_atts(array(
        'limit' => 5
    ), $atts, 'user_logged_meals');

    if (!is_user_logged_in()) {
        return 'Please log in to view your logged meals.';
    }

    $current_user = wp_get_current_user();
    $meal_logs = athlete_dashboard_get_user_meal_logs($current_user->ID, array('posts_per_page' => $atts['limit']));

    if (empty($meal_logs)) {
        return 'No logged meals found.';
    }

    $output = '<div class="user-logged-meals">';
    foreach ($meal_logs as $log) {
        $output .= '<div class="meal-log-entry">';
        $output .= '<h4>' . esc_html($log['date']) . ' - ' . esc_html($log['type']) . ': ' . esc_html($log['name']) . '</h4>';
        
        // Protein
        if (!empty($log['protein']['type'])) {
            $output .= '<p><strong>Protein:</strong> ' . esc_html($log['protein']['type']) . ' - ' . 
                       esc_html($log['protein']['quantity']) . ' ' . esc_html($log['protein']['unit']) . '</p>';
        }
        
        // Fat
        if (!empty($log['fat']['type'])) {
            $output .= '<p><strong>Fat:</strong> ' . esc_html($log['fat']['type']) . ' - ' . 
                       esc_html($log['fat']['quantity']) . ' ' . esc_html($log['fat']['unit']) . '</p>';
        }
        
        // Carbohydrates: Starches & Grains
        if (!empty($log['carb_starch']['type'])) {
            $output .= '<p><strong>Starch/Grain:</strong> ' . esc_html($log['carb_starch']['type']) . ' - ' . 
                       esc_html($log['carb_starch']['quantity']) . ' ' . esc_html($log['carb_starch']['unit']) . '</p>';
        }
        
        // Carbohydrates: Fruits
        if (!empty($log['carb_fruit']['type'])) {
            $output .= '<p><strong>Fruit:</strong> ' . esc_html($log['carb_fruit']['type']) . ' - ' . 
                       esc_html($log['carb_fruit']['quantity']) . ' ' . esc_html($log['carb_fruit']['unit']) . '</p>';
        }
        
        // Carbohydrates: Vegetables
        if (!empty($log['carb_vegetable']['type'])) {
            $output .= '<p><strong>Vegetable:</strong> ' . esc_html($log['carb_vegetable']['type']) . ' - ' . 
                       esc_html($log['carb_vegetable']['quantity']) . ' ' . esc_html($log['carb_vegetable']['unit']) . '</p>';
        }
        
        $output .= '<p><strong>Calories:</strong> ' . esc_html($log['calories']) . '</p>';
        
        if (!empty($log['description'])) {
            $output .= '<p><strong>Description:</strong> ' . esc_html($log['description']) . '</p>';
        }
        
        $output .= '</div>';
    }
    $output .= '</div>';

    return $output;
}
add_shortcode('user_logged_meals', 'display_user_logged_meals');

/**
 * Shortcode to display the messaging interface
 */
function athlete_dashboard_messaging_shortcode() {
    if (!is_user_logged_in()) {
        return 'Please log in to view your messages.';
    }

    ob_start();
    ?>
    <div class="athlete-messaging-container">
        <div class="conversation-list">
            <h3><?php esc_html_e('Conversations', 'athlete-dashboard'); ?></h3>
            <ul id="conversation-list-items">
                <!-- Conversations will be loaded here dynamically -->
            </ul>
        </div>
        <div class="message-area">
            <div id="message-container">
                <!-- Messages will be loaded here dynamically -->
            </div>
            <div class="message-input-area">
                <input type="text" id="message-input" placeholder="<?php esc_attr_e('Type your message...', 'athlete-dashboard'); ?>">
                <button id="send-message"><?php esc_html_e('Send', 'athlete-dashboard'); ?></button>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('athlete_messaging', 'athlete_dashboard_messaging_shortcode');

/**
 * Shortcode to display recent messages preview
 */
function athlete_dashboard_recent_messages_shortcode($atts) {
    $atts = shortcode_atts(array(
        'user_id' => get_current_user_id(),
    ), $atts, 'athlete_recent_messages');

    $user_id = intval($atts['user_id']);
    $conversations = athlete_dashboard_get_conversations($user_id);

    ob_start();
    ?>
    <div class="athlete-recent-messages">
        <h3><?php esc_html_e('Recent Messages', 'athlete-dashboard'); ?></h3>
        <?php if (!empty($conversations)) : ?>
            <ul class="recent-messages-list">
                <?php foreach ($conversations as $conversation) : 
                    $latest_message = athlete_dashboard_get_latest_message($conversation->id);
                    if ($latest_message) :
                ?>
                    <li class="message-preview">
                        <strong><?php echo esc_html($conversation->name); ?>:</strong>
                        <?php echo wp_trim_words($latest_message->message_content, 10); ?>
                        <span class="message-time">(<?php echo esc_html(human_time_diff(strtotime($latest_message->created_at), current_time('timestamp'))); ?> ago)</span>
                    </li>
                <?php 
                    endif;
                endforeach; 
                ?>
            </ul>
        <?php else : ?>
            <p><?php esc_html_e('No recent messages.', 'athlete-dashboard'); ?></p>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('athlete_recent_messages', 'athlete_dashboard_recent_messages_shortcode');

/**
 * Shortcode to display workout logging form
 */
function athlete_dashboard_log_workout_content() {
    ob_start();
    include get_stylesheet_directory() . '/templates/dashboard/sections/workout-logger.php';
    return ob_get_clean();
}
add_shortcode('athlete_dashboard_log_workout_content', 'athlete_dashboard_log_workout_content');

/**
 * Shortcode to display body weight progress
 */
function athlete_dashboard_body_weight_progress_content() {
    ob_start();
    $template_vars = array(
        'title' => __('Body Weight', 'athlete-dashboard'),
        'chart_id' => 'bodyWeightChart',
        'form_id' => 'bodyWeightProgressForm',
        'weight_field_name' => 'body_weight',
        'weight_unit_field_name' => 'body_weight_unit',
        'nonce_name' => 'body_weight_progress_nonce'
    );
    extract($template_vars);
    include get_stylesheet_directory() . '/templates/dashboard/sections/progress-tracker.php';
    return ob_get_clean();
}
add_shortcode('athlete_dashboard_body_weight_progress_content', 'athlete_dashboard_body_weight_progress_content');

/**
 * Shortcode to display comprehensive body composition
 */
function athlete_dashboard_comprehensive_body_composition_content() {
    ob_start();
    include get_stylesheet_directory() . '/templates/dashboard/sections/charts-section.php';
    return ob_get_clean();
}
add_shortcode('athlete_dashboard_comprehensive_body_composition_content', 'athlete_dashboard_comprehensive_body_composition_content');

/**
 * Shortcode to display squat progress
 */
function athlete_dashboard_squat_progress_content() {
    ob_start();
    $template_vars = array(
        'title' => __('Squat', 'athlete-dashboard'),
        'chart_id' => 'squatChart',
        'form_id' => 'squatProgressForm',
        'weight_field_name' => 'squat_weight',
        'weight_unit_field_name' => 'squat_weight_unit',
        'nonce_name' => 'squat_progress_nonce'
    );
    extract($template_vars);
    include get_stylesheet_directory() . '/templates/dashboard/sections/progress-tracker.php';
    return ob_get_clean();
}
add_shortcode('athlete_dashboard_squat_progress_content', 'athlete_dashboard_squat_progress_content');

/**
 * Shortcode to display bench press progress
 */
function athlete_dashboard_bench_press_progress_content() {
    ob_start();
    $template_vars = array(
        'title' => __('Bench Press', 'athlete-dashboard'),
        'chart_id' => 'benchPressChart',
        'form_id' => 'benchPressProgressForm',
        'weight_field_name' => 'bench_press_weight',
        'weight_unit_field_name' => 'bench_press_weight_unit',
        'nonce_name' => 'bench_press_progress_nonce'
    );
    extract($template_vars);
    include get_stylesheet_directory() . '/templates/dashboard/sections/progress-tracker.php';
    return ob_get_clean();
}
add_shortcode('athlete_dashboard_bench_press_progress_content', 'athlete_dashboard_bench_press_progress_content');

/**
 * Shortcode to display deadlift progress
 */
function athlete_dashboard_deadlift_progress_content() {
    ob_start();
    $template_vars = array(
        'title' => __('Deadlift', 'athlete-dashboard'),
        'chart_id' => 'deadliftChart',
        'form_id' => 'deadliftProgressForm',
        'weight_field_name' => 'deadlift_weight',
        'weight_unit_field_name' => 'deadlift_weight_unit',
        'nonce_name' => 'deadlift_progress_nonce'
    );
    extract($template_vars);
    include get_stylesheet_directory() . '/templates/dashboard/sections/progress-tracker.php';
    return ob_get_clean();
}
add_shortcode('athlete_dashboard_deadlift_progress_content', 'athlete_dashboard_deadlift_progress_content');

/**
 * Shortcode for exercise progress benchmarks
 */
function athlete_dashboard_exercise_progress_content() {
    if (!is_user_logged_in()) {
        return 'Please log in to view your exercise progress.';
    }

    ob_start();
    ?>
    <div class="benchmark-tests-section">
        <h3><?php _e('Your Benchmark Progress', 'athlete-dashboard'); ?></h3>
        <div class="benchmark-grid">
            <?php
            $exercises = array('squat', 'bench_press', 'deadlift');
            foreach ($exercises as $exercise) {
                echo do_shortcode("[athlete_dashboard_{$exercise}_progress_content]");
            }
            ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('athlete_dashboard_exercise_progress_content', 'athlete_dashboard_exercise_progress_content');

/**
 * Shortcode for meal logging interface
 */
function athlete_dashboard_meal_log_content() {
    if (!is_user_logged_in()) {
        return 'Please log in to log your meals.';
    }

    ob_start();
    ?>
    <div class="meal-log-section">
        <h3><?php _e('Log Your Meal', 'athlete-dashboard'); ?></h3>
        <form id="meal-log-form" class="meal-log-form">
            <?php wp_nonce_field('log_meal_nonce', 'meal_nonce'); ?>
            <div class="form-group">
                <label for="meal-type"><?php _e('Meal Type', 'athlete-dashboard'); ?></label>
                <select id="meal-type" name="meal_type" required>
                    <option value="breakfast"><?php _e('Breakfast', 'athlete-dashboard'); ?></option>
                    <option value="lunch"><?php _e('Lunch', 'athlete-dashboard'); ?></option>
                    <option value="dinner"><?php _e('Dinner', 'athlete-dashboard'); ?></option>
                    <option value="snack"><?php _e('Snack', 'athlete-dashboard'); ?></option>
                </select>
            </div>
            <div class="form-group">
                <label for="meal-description"><?php _e('Description', 'athlete-dashboard'); ?></label>
                <textarea id="meal-description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="calories"><?php _e('Calories', 'athlete-dashboard'); ?></label>
                <input type="number" id="calories" name="calories" min="0" required>
            </div>
            <button type="submit" class="submit-button"><?php _e('Log Meal', 'athlete-dashboard'); ?></button>
        </form>
        <div id="meal-log-message" class="message-container"></div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('athlete_dashboard_meal_log_content', 'athlete_dashboard_meal_log_content');

/**
 * Shortcode for personal training sessions
 */
function athlete_dashboard_personal_training_sessions_content() {
    if (!is_user_logged_in()) {
        return 'Please log in to view your personal training sessions.';
    }

    ob_start();
    ?>
    <div class="personal-training-section">
        <h3><?php _e('Your Personal Training Sessions', 'athlete-dashboard'); ?></h3>
        <?php
        $sessions = athlete_dashboard_get_user_training_sessions(get_current_user_id());
        if (!empty($sessions)) {
            ?>
            <div class="training-sessions-grid">
                <?php foreach ($sessions as $session): ?>
                    <div class="training-session-card">
                        <div class="session-date"><?php echo esc_html(date_i18n(get_option('date_format'), strtotime($session['date']))); ?></div>
                        <div class="session-time"><?php echo esc_html($session['time']); ?></div>
                        <div class="trainer-name"><?php echo esc_html($session['trainer_name']); ?></div>
                        <div class="session-status"><?php echo esc_html($session['status']); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php
        } else {
            echo '<p>' . __('No upcoming personal training sessions scheduled.', 'athlete-dashboard') . '</p>';
        }
        ?>
        <button class="book-session-button"><?php _e('Book a Session', 'athlete-dashboard'); ?></button>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('athlete_dashboard_personal_training_sessions_content', 'athlete_dashboard_personal_training_sessions_content');

/**
 * Shortcode for class bookings
 */
function athlete_dashboard_class_bookings_content() {
    if (!is_user_logged_in()) {
        return 'Please log in to view your class bookings.';
    }

    ob_start();
    ?>
    <div class="class-bookings-section">
        <h3><?php _e('Your Class Bookings', 'athlete-dashboard'); ?></h3>
        <?php
        $bookings = athlete_dashboard_get_user_class_bookings(get_current_user_id());
        if (!empty($bookings)) {
            ?>
            <div class="class-bookings-grid">
                <?php foreach ($bookings as $booking): ?>
                    <div class="class-booking-card">
                        <div class="class-name"><?php echo esc_html($booking['class_name']); ?></div>
                        <div class="class-date"><?php echo esc_html(date_i18n(get_option('date_format'), strtotime($booking['date']))); ?></div>
                        <div class="class-time"><?php echo esc_html($booking['time']); ?></div>
                        <div class="instructor"><?php echo esc_html($booking['instructor']); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php
        } else {
            echo '<p>' . __('No upcoming class bookings.', 'athlete-dashboard') . '</p>';
        }
        ?>
        <button class="book-class-button"><?php _e('Book a Class', 'athlete-dashboard'); ?></button>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('athlete_dashboard_class_bookings_content', 'athlete_dashboard_class_bookings_content');

/**
 * Shortcode for membership status
 */
function athlete_dashboard_membership_status_content() {
    if (!is_user_logged_in()) {
        return 'Please log in to view your membership status.';
    }

    ob_start();
    ?>
    <div class="membership-status-section">
        <h3><?php _e('Your Membership', 'athlete-dashboard'); ?></h3>
        <?php
        $membership = athlete_dashboard_get_user_membership(get_current_user_id());
        ?>
        <div class="membership-card">
            <div class="membership-type"><?php echo esc_html($membership['type']); ?></div>
            <div class="membership-status"><?php echo esc_html($membership['status']); ?></div>
            <div class="membership-expiry">
                <?php echo sprintf(__('Valid until: %s', 'athlete-dashboard'), 
                    esc_html(date_i18n(get_option('date_format'), strtotime($membership['expiry_date'])))); ?>
            </div>
            <div class="membership-benefits">
                <h4><?php _e('Benefits', 'athlete-dashboard'); ?></h4>
                <ul>
                    <?php foreach ($membership['benefits'] as $benefit): ?>
                        <li><?php echo esc_html($benefit); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <button class="upgrade-membership-button"><?php _e('Upgrade Membership', 'athlete-dashboard'); ?></button>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('athlete_dashboard_membership_status_content', 'athlete_dashboard_membership_status_content');

/**
 * Shortcode for check-ins and attendance
 */
function athlete_dashboard_check_ins_attendance_content() {
    if (!is_user_logged_in()) {
        return 'Please log in to view your attendance record.';
    }

    ob_start();
    ?>
    <div class="attendance-section">
        <h3><?php _e('Check-Ins & Attendance', 'athlete-dashboard'); ?></h3>
        <div class="attendance-stats">
            <?php
            $attendance = athlete_dashboard_get_user_attendance_stats(get_current_user_id());
            ?>
            <div class="stat-card">
                <div class="stat-value"><?php echo esc_html($attendance['total_visits']); ?></div>
                <div class="stat-label"><?php _e('Total Visits', 'athlete-dashboard'); ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?php echo esc_html($attendance['current_streak']); ?></div>
                <div class="stat-label"><?php _e('Current Streak', 'athlete-dashboard'); ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?php echo esc_html($attendance['monthly_visits']); ?></div>
                <div class="stat-label"><?php _e('This Month', 'athlete-dashboard'); ?></div>
            </div>
        </div>
        <div class="attendance-calendar">
            <!-- Calendar will be populated by JavaScript -->
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('athlete_dashboard_check_ins_attendance_content', 'athlete_dashboard_check_ins_attendance_content');

/**
 * Shortcode for goal tracking and progress
 */
function athlete_dashboard_goal_tracking_progress_content() {
    if (!is_user_logged_in()) {
        return 'Please log in to view your goals and progress.';
    }

    ob_start();
    ?>
    <div class="goals-section">
        <h3><?php _e('Your Goals & Progress', 'athlete-dashboard'); ?></h3>
        <?php
        $goals = athlete_dashboard_get_user_goals(get_current_user_id());
        if (!empty($goals)) {
            ?>
            <div class="goals-grid">
                <?php foreach ($goals as $goal): ?>
                    <div class="goal-card">
                        <div class="goal-title"><?php echo esc_html($goal['title']); ?></div>
                        <div class="goal-progress">
                            <div class="progress-bar" style="width: <?php echo esc_attr($goal['progress']); ?>%"></div>
                        </div>
                        <div class="goal-stats">
                            <span class="current"><?php echo esc_html($goal['current']); ?></span>
                            <span class="target"><?php echo esc_html($goal['target']); ?></span>
                        </div>
                        <div class="goal-deadline">
                            <?php echo sprintf(__('Target Date: %s', 'athlete-dashboard'), 
                                esc_html(date_i18n(get_option('date_format'), strtotime($goal['deadline'])))); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php
        } else {
            echo '<p>' . __('No goals set yet.', 'athlete-dashboard') . '</p>';
        }
        ?>
        <button class="add-goal-button"><?php _e('Add New Goal', 'athlete-dashboard'); ?></button>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('athlete_dashboard_goal_tracking_progress_content', 'athlete_dashboard_goal_tracking_progress_content');

/**
 * Shortcode for personalized recommendations
 */
function athlete_dashboard_personalized_recommendations_content() {
    if (!is_user_logged_in()) {
        return 'Please log in to view your personalized recommendations.';
    }

    ob_start();
    ?>
    <div class="recommendations-section">
        <h3><?php _e('Personalized Recommendations', 'athlete-dashboard'); ?></h3>
        <?php
        $recommendations = athlete_dashboard_get_user_recommendations(get_current_user_id());
        if (!empty($recommendations)) {
            ?>
            <div class="recommendations-grid">
                <?php foreach ($recommendations as $recommendation): ?>
                    <div class="recommendation-card">
                        <div class="recommendation-type"><?php echo esc_html($recommendation['type']); ?></div>
                        <div class="recommendation-content"><?php echo wp_kses_post($recommendation['content']); ?></div>
                        <div class="recommendation-action">
                            <button class="action-button" data-action="<?php echo esc_attr($recommendation['action']); ?>">
                                <?php echo esc_html($recommendation['action_text']); ?>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php
        } else {
            echo '<p>' . __('No recommendations available yet.', 'athlete-dashboard') . '</p>';
        }
        ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('athlete_dashboard_personalized_recommendations_content', 'athlete_dashboard_personalized_recommendations_content');

/**
 * Shortcode for messaging preview
 */
function athlete_dashboard_render_messaging_preview() {
    if (!is_user_logged_in()) {
        return 'Please log in to view your messages.';
    }

    ob_start();
    ?>
    <div class="messaging-preview-section">
        <h3><?php _e('Recent Messages', 'athlete-dashboard'); ?></h3>
        <?php
        $messages = athlete_dashboard_get_recent_messages(get_current_user_id(), 5);
        if (!empty($messages)) {
            ?>
            <div class="messages-preview">
                <?php foreach ($messages as $message): ?>
                    <div class="message-preview-card">
                        <div class="sender"><?php echo esc_html($message['sender']); ?></div>
                        <div class="preview"><?php echo wp_trim_words($message['content'], 10); ?></div>
                        <div class="timestamp"><?php echo esc_html(human_time_diff(strtotime($message['timestamp']), current_time('timestamp'))); ?> ago</div>
                    </div>
                <?php endforeach; ?>
            </div>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('messages'))); ?>" class="view-all-messages">
                <?php _e('View All Messages', 'athlete-dashboard'); ?>
            </a>
            <?php
        } else {
            echo '<p>' . __('No recent messages.', 'athlete-dashboard') . '</p>';
        }
        ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('athlete_dashboard_render_messaging_preview', 'athlete_dashboard_render_messaging_preview');

/**
 * Shortcode for account details
 */
function athlete_dashboard_account_details_content() {
    if (!is_user_logged_in()) {
        return 'Please log in to view your account details.';
    }

    ob_start();
    ?>
    <div class="account-details-section">
        <h3><?php _e('Account Details', 'athlete-dashboard'); ?></h3>
        <?php
        $user = wp_get_current_user();
        $user_meta = get_user_meta($user->ID);
        ?>
        <div class="account-info">
            <div class="profile-section">
                <div class="profile-picture">
                    <?php echo get_avatar($user->ID, 150); ?>
                    <button class="update-profile-picture"><?php _e('Update Picture', 'athlete-dashboard'); ?></button>
                </div>
                <div class="profile-details">
                    <h4><?php echo esc_html($user->display_name); ?></h4>
                    <p class="email"><?php echo esc_html($user->user_email); ?></p>
                    <p class="member-since">
                        <?php echo sprintf(__('Member since: %s', 'athlete-dashboard'), 
                            date_i18n(get_option('date_format'), strtotime($user->user_registered))); ?>
                    </p>
                </div>
            </div>
            <div class="account-actions">
                <button class="edit-profile"><?php _e('Edit Profile', 'athlete-dashboard'); ?></button>
                <button class="change-password"><?php _e('Change Password', 'athlete-dashboard'); ?></button>
                <button class="notification-settings"><?php _e('Notification Settings', 'athlete-dashboard'); ?></button>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('athlete_dashboard_account_details_content', 'athlete_dashboard_account_details_content');