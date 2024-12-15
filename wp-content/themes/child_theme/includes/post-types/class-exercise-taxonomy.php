<?php
/**
 * Exercise Taxonomy Class
 * 
 * Handles registration and management of exercise taxonomies
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Exercise_Taxonomy {
    /**
     * Taxonomy names
     */
    const CATEGORY_TAX = 'exercise_category';
    const EQUIPMENT_TAX = 'exercise_equipment';
    const MUSCLE_GROUP_TAX = 'exercise_muscle_group';
    const DIFFICULTY_TAX = 'exercise_difficulty';

    /**
     * Initialize the taxonomies
     */
    public function __construct() {
        add_action('init', array($this, 'register_taxonomies'));
        add_action('admin_init', array($this, 'add_default_terms'));
        add_filter('term_updated_messages', array($this, 'customize_taxonomy_messages'));
    }

    /**
     * Register exercise taxonomies
     */
    public function register_taxonomies() {
        // Exercise Category Taxonomy
        register_taxonomy(self::CATEGORY_TAX, 'workout', array(
            'labels' => array(
                'name'              => _x('Exercise Categories', 'taxonomy general name', 'athlete-dashboard'),
                'singular_name'     => _x('Exercise Category', 'taxonomy singular name', 'athlete-dashboard'),
                'search_items'      => __('Search Categories', 'athlete-dashboard'),
                'all_items'         => __('All Categories', 'athlete-dashboard'),
                'parent_item'       => __('Parent Category', 'athlete-dashboard'),
                'parent_item_colon' => __('Parent Category:', 'athlete-dashboard'),
                'edit_item'         => __('Edit Category', 'athlete-dashboard'),
                'update_item'       => __('Update Category', 'athlete-dashboard'),
                'add_new_item'      => __('Add New Category', 'athlete-dashboard'),
                'new_item_name'     => __('New Category Name', 'athlete-dashboard'),
                'menu_name'         => __('Categories', 'athlete-dashboard'),
            ),
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'exercise-category'),
            'show_in_rest'      => true
        ));

        // Exercise Equipment Taxonomy
        register_taxonomy(self::EQUIPMENT_TAX, 'workout', array(
            'labels' => array(
                'name'              => _x('Equipment', 'taxonomy general name', 'athlete-dashboard'),
                'singular_name'     => _x('Equipment', 'taxonomy singular name', 'athlete-dashboard'),
                'search_items'      => __('Search Equipment', 'athlete-dashboard'),
                'all_items'         => __('All Equipment', 'athlete-dashboard'),
                'edit_item'         => __('Edit Equipment', 'athlete-dashboard'),
                'update_item'       => __('Update Equipment', 'athlete-dashboard'),
                'add_new_item'      => __('Add New Equipment', 'athlete-dashboard'),
                'new_item_name'     => __('New Equipment Name', 'athlete-dashboard'),
                'menu_name'         => __('Equipment', 'athlete-dashboard'),
            ),
            'hierarchical'      => false,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'exercise-equipment'),
            'show_in_rest'      => true
        ));

        // Exercise Muscle Group Taxonomy
        register_taxonomy(self::MUSCLE_GROUP_TAX, 'workout', array(
            'labels' => array(
                'name'              => _x('Muscle Groups', 'taxonomy general name', 'athlete-dashboard'),
                'singular_name'     => _x('Muscle Group', 'taxonomy singular name', 'athlete-dashboard'),
                'search_items'      => __('Search Muscle Groups', 'athlete-dashboard'),
                'all_items'         => __('All Muscle Groups', 'athlete-dashboard'),
                'parent_item'       => __('Parent Muscle Group', 'athlete-dashboard'),
                'parent_item_colon' => __('Parent Muscle Group:', 'athlete-dashboard'),
                'edit_item'         => __('Edit Muscle Group', 'athlete-dashboard'),
                'update_item'       => __('Update Muscle Group', 'athlete-dashboard'),
                'add_new_item'      => __('Add New Muscle Group', 'athlete-dashboard'),
                'new_item_name'     => __('New Muscle Group Name', 'athlete-dashboard'),
                'menu_name'         => __('Muscle Groups', 'athlete-dashboard'),
            ),
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'muscle-group'),
            'show_in_rest'      => true
        ));

        // Exercise Difficulty Taxonomy
        register_taxonomy(self::DIFFICULTY_TAX, 'workout', array(
            'labels' => array(
                'name'              => _x('Difficulty Levels', 'taxonomy general name', 'athlete-dashboard'),
                'singular_name'     => _x('Difficulty Level', 'taxonomy singular name', 'athlete-dashboard'),
                'search_items'      => __('Search Difficulty Levels', 'athlete-dashboard'),
                'all_items'         => __('All Difficulty Levels', 'athlete-dashboard'),
                'edit_item'         => __('Edit Difficulty Level', 'athlete-dashboard'),
                'update_item'       => __('Update Difficulty Level', 'athlete-dashboard'),
                'add_new_item'      => __('Add New Difficulty Level', 'athlete-dashboard'),
                'new_item_name'     => __('New Difficulty Level Name', 'athlete-dashboard'),
                'menu_name'         => __('Difficulty Levels', 'athlete-dashboard'),
            ),
            'hierarchical'      => false,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'difficulty-level'),
            'show_in_rest'      => true
        ));
    }

    /**
     * Add default taxonomy terms
     */
    public function add_default_terms() {
        // Default Exercise Categories
        $categories = array(
            'strength' => __('Strength Training', 'athlete-dashboard'),
            'cardio' => __('Cardio', 'athlete-dashboard'),
            'flexibility' => __('Flexibility', 'athlete-dashboard'),
            'bodyweight' => __('Bodyweight', 'athlete-dashboard'),
            'hiit' => __('HIIT', 'athlete-dashboard'),
            'compound' => __('Compound Exercises', 'athlete-dashboard'),
            'isolation' => __('Isolation Exercises', 'athlete-dashboard')
        );

        foreach ($categories as $slug => $name) {
            if (!term_exists($slug, self::CATEGORY_TAX)) {
                wp_insert_term($name, self::CATEGORY_TAX, array('slug' => $slug));
            }
        }

        // Default Equipment
        $equipment = array(
            'barbell' => __('Barbell', 'athlete-dashboard'),
            'dumbbell' => __('Dumbbell', 'athlete-dashboard'),
            'kettlebell' => __('Kettlebell', 'athlete-dashboard'),
            'resistance-band' => __('Resistance Band', 'athlete-dashboard'),
            'bodyweight' => __('Bodyweight', 'athlete-dashboard'),
            'machine' => __('Machine', 'athlete-dashboard'),
            'cable' => __('Cable', 'athlete-dashboard'),
            'bench' => __('Bench', 'athlete-dashboard'),
            'foam-roller' => __('Foam Roller', 'athlete-dashboard'),
            'medicine-ball' => __('Medicine Ball', 'athlete-dashboard')
        );

        foreach ($equipment as $slug => $name) {
            if (!term_exists($slug, self::EQUIPMENT_TAX)) {
                wp_insert_term($name, self::EQUIPMENT_TAX, array('slug' => $slug));
            }
        }

        // Default Muscle Groups
        $muscle_groups = array(
            'chest' => array(
                'name' => __('Chest', 'athlete-dashboard'),
                'children' => array(
                    'upper-chest' => __('Upper Chest', 'athlete-dashboard'),
                    'middle-chest' => __('Middle Chest', 'athlete-dashboard'),
                    'lower-chest' => __('Lower Chest', 'athlete-dashboard')
                )
            ),
            'back' => array(
                'name' => __('Back', 'athlete-dashboard'),
                'children' => array(
                    'upper-back' => __('Upper Back', 'athlete-dashboard'),
                    'lats' => __('Latissimus Dorsi', 'athlete-dashboard'),
                    'lower-back' => __('Lower Back', 'athlete-dashboard')
                )
            ),
            'legs' => array(
                'name' => __('Legs', 'athlete-dashboard'),
                'children' => array(
                    'quadriceps' => __('Quadriceps', 'athlete-dashboard'),
                    'hamstrings' => __('Hamstrings', 'athlete-dashboard'),
                    'calves' => __('Calves', 'athlete-dashboard'),
                    'glutes' => __('Glutes', 'athlete-dashboard')
                )
            ),
            'shoulders' => array(
                'name' => __('Shoulders', 'athlete-dashboard'),
                'children' => array(
                    'front-deltoids' => __('Front Deltoids', 'athlete-dashboard'),
                    'side-deltoids' => __('Side Deltoids', 'athlete-dashboard'),
                    'rear-deltoids' => __('Rear Deltoids', 'athlete-dashboard')
                )
            ),
            'arms' => array(
                'name' => __('Arms', 'athlete-dashboard'),
                'children' => array(
                    'biceps' => __('Biceps', 'athlete-dashboard'),
                    'triceps' => __('Triceps', 'athlete-dashboard'),
                    'forearms' => __('Forearms', 'athlete-dashboard')
                )
            ),
            'core' => array(
                'name' => __('Core', 'athlete-dashboard'),
                'children' => array(
                    'abs' => __('Abs', 'athlete-dashboard'),
                    'obliques' => __('Obliques', 'athlete-dashboard'),
                    'lower-abs' => __('Lower Abs', 'athlete-dashboard')
                )
            )
        );

        foreach ($muscle_groups as $parent_slug => $group) {
            $parent = term_exists($parent_slug, self::MUSCLE_GROUP_TAX);
            if (!$parent) {
                $parent = wp_insert_term($group['name'], self::MUSCLE_GROUP_TAX, array('slug' => $parent_slug));
            }

            if (is_array($parent) && isset($group['children'])) {
                foreach ($group['children'] as $child_slug => $child_name) {
                    if (!term_exists($child_slug, self::MUSCLE_GROUP_TAX)) {
                        wp_insert_term($child_name, self::MUSCLE_GROUP_TAX, array(
                            'slug' => $child_slug,
                            'parent' => $parent['term_id']
                        ));
                    }
                }
            }
        }

        // Default Difficulty Levels
        $difficulty_levels = array(
            'beginner' => __('Beginner', 'athlete-dashboard'),
            'intermediate' => __('Intermediate', 'athlete-dashboard'),
            'advanced' => __('Advanced', 'athlete-dashboard'),
            'expert' => __('Expert', 'athlete-dashboard')
        );

        foreach ($difficulty_levels as $slug => $name) {
            if (!term_exists($slug, self::DIFFICULTY_TAX)) {
                wp_insert_term($name, self::DIFFICULTY_TAX, array('slug' => $slug));
            }
        }
    }

    /**
     * Customize taxonomy messages
     *
     * @param array $messages Existing messages
     * @return array Modified messages
     */
    public function customize_taxonomy_messages($messages) {
        $messages[self::CATEGORY_TAX] = array(
            0 => '', // Unused
            1 => __('Exercise category updated.', 'athlete-dashboard'),
            2 => __('Custom field updated.', 'athlete-dashboard'),
            3 => __('Custom field deleted.', 'athlete-dashboard'),
            4 => __('Exercise category updated.', 'athlete-dashboard'),
            5 => '', // Unused
            6 => __('Exercise category created.', 'athlete-dashboard'),
            7 => __('Exercise category saved.', 'athlete-dashboard'),
            8 => __('Exercise category submitted.', 'athlete-dashboard')
        );

        $messages[self::EQUIPMENT_TAX] = array(
            0 => '',
            1 => __('Equipment updated.', 'athlete-dashboard'),
            2 => __('Custom field updated.', 'athlete-dashboard'),
            3 => __('Custom field deleted.', 'athlete-dashboard'),
            4 => __('Equipment updated.', 'athlete-dashboard'),
            5 => '',
            6 => __('Equipment created.', 'athlete-dashboard'),
            7 => __('Equipment saved.', 'athlete-dashboard'),
            8 => __('Equipment submitted.', 'athlete-dashboard')
        );

        $messages[self::MUSCLE_GROUP_TAX] = array(
            0 => '',
            1 => __('Muscle group updated.', 'athlete-dashboard'),
            2 => __('Custom field updated.', 'athlete-dashboard'),
            3 => __('Custom field deleted.', 'athlete-dashboard'),
            4 => __('Muscle group updated.', 'athlete-dashboard'),
            5 => '',
            6 => __('Muscle group created.', 'athlete-dashboard'),
            7 => __('Muscle group saved.', 'athlete-dashboard'),
            8 => __('Muscle group submitted.', 'athlete-dashboard')
        );

        $messages[self::DIFFICULTY_TAX] = array(
            0 => '',
            1 => __('Difficulty level updated.', 'athlete-dashboard'),
            2 => __('Custom field updated.', 'athlete-dashboard'),
            3 => __('Custom field deleted.', 'athlete-dashboard'),
            4 => __('Difficulty level updated.', 'athlete-dashboard'),
            5 => '',
            6 => __('Difficulty level created.', 'athlete-dashboard'),
            7 => __('Difficulty level saved.', 'athlete-dashboard'),
            8 => __('Difficulty level submitted.', 'athlete-dashboard')
        );

        return $messages;
    }

    /**
     * Get all terms for a specific taxonomy
     *
     * @param string $taxonomy Taxonomy name
     * @return array Array of terms
     */
    public function get_terms($taxonomy) {
        $terms = get_terms(array(
            'taxonomy' => $taxonomy,
            'hide_empty' => false
        ));

        if (is_wp_error($terms)) {
            return array();
        }

        return $terms;
    }

    /**
     * Get hierarchical terms for a taxonomy
     *
     * @param string $taxonomy Taxonomy name
     * @return array Hierarchical array of terms
     */
    public function get_hierarchical_terms($taxonomy) {
        $terms = $this->get_terms($taxonomy);
        $hierarchy = array();

        // Build hierarchy
        foreach ($terms as $term) {
            if ($term->parent == 0) {
                $hierarchy[$term->term_id] = array(
                    'term' => $term,
                    'children' => array()
                );
            } else {
                if (isset($hierarchy[$term->parent])) {
                    $hierarchy[$term->parent]['children'][] = $term;
                }
            }
        }

        return $hierarchy;
    }

    /**
     * Get formatted term list for select fields
     *
     * @param string $taxonomy Taxonomy name
     * @param bool $hierarchical Whether to format hierarchically
     * @return array Array of terms formatted for select fields
     */
    public function get_terms_for_select($taxonomy, $hierarchical = false) {
        if ($hierarchical) {
            $hierarchy = $this->get_hierarchical_terms($taxonomy);
            $options = array();

            foreach ($hierarchy as $parent) {
                $options[$parent['term']->term_id] = $parent['term']->name;
                foreach ($parent['children'] as $child) {
                    $options[$child->term_id] = '— ' . $child->name;
                }
            }

            return $options;
        }

        $terms = $this->get_terms($taxonomy);
        $options = array();

        foreach ($terms as $term) {
            $options[$term->term_id] = $term->name;
        }

        return $options;
    }
} 