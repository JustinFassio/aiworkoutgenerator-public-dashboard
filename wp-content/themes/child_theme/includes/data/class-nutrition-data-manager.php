<?php
/**
 * Nutrition Data Manager Class
 * 
 * Handles nutrition-related data operations and caching
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Nutrition_Data_Manager extends Athlete_Dashboard_Data_Manager {
    /**
     * Required fields for meal logging
     */
    private $required_meal_fields = array(
        'title',
        'type',
        'date',
        'foods'
    );

    /**
     * Required fields for food items
     */
    private $required_food_fields = array(
        'name',
        'serving_size',
        'calories',
        'protein',
        'carbs',
        'fat'
    );

    /**
     * Initialize the nutrition data manager
     */
    protected function init() {
        $this->cache_group = 'athlete_nutrition';
        $this->cache_expiration = 1800; // 30 minutes
    }

    /**
     * Get user's nutrition goals
     */
    public function get_nutrition_goals($user_id = null) {
        if (!$user_id) {
            $user_id = get_current_user_id();
        }

        return $this->get_cached_data("goals_{$user_id}", function() use ($user_id) {
            $goals = get_user_meta($user_id, '_nutrition_goals', true);
            return !empty($goals) ? $goals : array(
                'calories' => 2000,
                'protein' => 150,
                'carbs' => 200,
                'fat' => 65
            );
        });
    }

    /**
     * Save user's nutrition goals
     */
    public function save_nutrition_goals($goals, $user_id = null) {
        if (!$user_id) {
            $user_id = get_current_user_id();
        }

        $required_fields = array('calories', 'protein', 'carbs', 'fat');
        if (!$this->validate_required_fields($goals, $required_fields)) {
            return false;
        }

        $goals = $this->sanitize_data($goals, array(
            'calories' => '%d',
            'protein' => '%f',
            'carbs' => '%f',
            'fat' => '%f'
        ));

        $updated = update_user_meta($user_id, '_nutrition_goals', $goals);
        if ($updated) {
            $this->delete_cached_data("goals_{$user_id}");
            return true;
        }

        $this->add_error('save_failed', __('Failed to save nutrition goals', 'athlete-dashboard'));
        return false;
    }

    /**
     * Get daily nutrition totals
     */
    public function get_daily_totals($date, $user_id = null) {
        if (!$user_id) {
            $user_id = get_current_user_id();
        }

        return $this->get_cached_data("totals_{$user_id}_{$date}", function() use ($user_id, $date) {
            global $wpdb;

            $query = $wpdb->prepare(
                "SELECT 
                    SUM(pm_calories.meta_value) as calories,
                    SUM(pm_protein.meta_value) as protein,
                    SUM(pm_carbs.meta_value) as carbs,
                    SUM(pm_fat.meta_value) as fat
                FROM {$wpdb->posts} p
                LEFT JOIN {$wpdb->postmeta} pm_calories ON p.ID = pm_calories.post_id AND pm_calories.meta_key = '_calories'
                LEFT JOIN {$wpdb->postmeta} pm_protein ON p.ID = pm_protein.post_id AND pm_protein.meta_key = '_protein'
                LEFT JOIN {$wpdb->postmeta} pm_carbs ON p.ID = pm_carbs.post_id AND pm_carbs.meta_key = '_carbs'
                LEFT JOIN {$wpdb->postmeta} pm_fat ON p.ID = pm_fat.post_id AND pm_fat.meta_key = '_fat'
                WHERE p.post_type = 'meal'
                AND p.post_author = %d
                AND p.post_date LIKE %s",
                $user_id,
                $date . '%'
            );

            $totals = $wpdb->get_row($query, ARRAY_A);
            return array(
                'calories' => (int)$totals['calories'] ?: 0,
                'protein' => (float)$totals['protein'] ?: 0,
                'carbs' => (float)$totals['carbs'] ?: 0,
                'fat' => (float)$totals['fat'] ?: 0
            );
        });
    }

    /**
     * Log a meal
     */
    public function log_meal($meal_data) {
        if (!$this->validate_required_fields($meal_data, $this->required_meal_fields)) {
            return false;
        }

        return $this->transaction(function() use ($meal_data) {
            $post_data = array(
                'post_title' => sanitize_text_field($meal_data['title']),
                'post_type' => 'meal',
                'post_status' => 'publish',
                'post_author' => get_current_user_id()
            );

            $post_id = wp_insert_post($post_data);
            if (!$post_id) {
                $this->add_error('insert_failed', __('Failed to create meal entry', 'athlete-dashboard'));
                return false;
            }

            // Calculate and save meal totals
            $totals = array(
                'calories' => 0,
                'protein' => 0,
                'carbs' => 0,
                'fat' => 0
            );

            foreach ($meal_data['foods'] as $food) {
                $totals['calories'] += $food['calories'] * $food['servings'];
                $totals['protein'] += $food['protein'] * $food['servings'];
                $totals['carbs'] += $food['carbs'] * $food['servings'];
                $totals['fat'] += $food['fat'] * $food['servings'];
            }

            // Save meal metadata
            update_post_meta($post_id, '_meal_type', sanitize_text_field($meal_data['type']));
            update_post_meta($post_id, '_foods', $meal_data['foods']);
            update_post_meta($post_id, '_calories', $totals['calories']);
            update_post_meta($post_id, '_protein', $totals['protein']);
            update_post_meta($post_id, '_carbs', $totals['carbs']);
            update_post_meta($post_id, '_fat', $totals['fat']);

            // Clear cached data
            $date = substr($meal_data['date'], 0, 10);
            $user_id = get_current_user_id();
            $this->delete_cached_data("totals_{$user_id}_{$date}");
            $this->delete_cached_data("meals_{$user_id}_{$date}");

            return $post_id;
        });
    }

    /**
     * Get meals for a specific date
     */
    public function get_meals($date, $user_id = null) {
        if (!$user_id) {
            $user_id = get_current_user_id();
        }

        return $this->get_cached_data("meals_{$user_id}_{$date}", function() use ($user_id, $date) {
            $args = array(
                'post_type' => 'meal',
                'post_status' => 'publish',
                'author' => $user_id,
                'date_query' => array(
                    array(
                        'year' => date('Y', strtotime($date)),
                        'month' => date('m', strtotime($date)),
                        'day' => date('d', strtotime($date))
                    )
                ),
                'posts_per_page' => -1
            );

            $query = new WP_Query($args);
            $meals = array();

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $meals[] = array(
                        'id' => get_the_ID(),
                        'title' => get_the_title(),
                        'type' => get_post_meta(get_the_ID(), '_meal_type', true),
                        'foods' => get_post_meta(get_the_ID(), '_foods', true),
                        'calories' => get_post_meta(get_the_ID(), '_calories', true),
                        'protein' => get_post_meta(get_the_ID(), '_protein', true),
                        'carbs' => get_post_meta(get_the_ID(), '_carbs', true),
                        'fat' => get_post_meta(get_the_ID(), '_fat', true)
                    );
                }
                wp_reset_postdata();
            }

            return $meals;
        });
    }

    /**
     * Get weekly calories data
     */
    public function get_weekly_calories($user_id = null) {
        if (!$user_id) {
            $user_id = get_current_user_id();
        }

        $end_date = current_time('Y-m-d');
        $start_date = date('Y-m-d', strtotime('-6 days', strtotime($end_date)));

        return $this->get_cached_data("weekly_calories_{$user_id}", function() use ($user_id, $start_date, $end_date) {
            global $wpdb;

            $query = $wpdb->prepare(
                "SELECT 
                    DATE(p.post_date) as date,
                    SUM(pm.meta_value) as calories
                FROM {$wpdb->posts} p
                LEFT JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
                WHERE p.post_type = 'meal'
                AND p.post_author = %d
                AND p.post_date BETWEEN %s AND %s
                AND pm.meta_key = '_calories'
                GROUP BY DATE(p.post_date)
                ORDER BY date ASC",
                $user_id,
                $start_date,
                $end_date . ' 23:59:59'
            );

            $results = $wpdb->get_results($query);
            $data = array();

            // Fill in any missing dates with zero calories
            $current = strtotime($start_date);
            $end = strtotime($end_date);
            
            while ($current <= $end) {
                $date = date('Y-m-d', $current);
                $calories = 0;

                foreach ($results as $row) {
                    if ($row->date === $date) {
                        $calories = (int)$row->calories;
                        break;
                    }
                }

                $data[] = array(
                    'date' => $date,
                    'calories' => $calories
                );

                $current = strtotime('+1 day', $current);
            }

            return $data;
        });
    }
} 