<?php
/**
 * Workout Post Type Class
 * 
 * Handles registration and management of the workout custom post type
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Workout_Post_Type {
    /**
     * Post type name
     */
    const POST_TYPE = 'workout';

    /**
     * Initialize the post type
     */
    public function __construct() {
        add_action('init', array($this, 'register_post_type'));
        add_action('init', array($this, 'register_meta'));
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post_' . self::POST_TYPE, array($this, 'save_meta_boxes'), 10, 2);
        add_filter('manage_' . self::POST_TYPE . '_posts_columns', array($this, 'set_custom_columns'));
        add_action('manage_' . self::POST_TYPE . '_posts_custom_column', array($this, 'render_custom_columns'), 10, 2);
    }

    /**
     * Register the workout post type
     */
    public function register_post_type() {
        $labels = array(
            'name'                  => _x('Workouts', 'Post type general name', 'athlete-dashboard'),
            'singular_name'         => _x('Workout', 'Post type singular name', 'athlete-dashboard'),
            'menu_name'            => _x('Workouts', 'Admin Menu text', 'athlete-dashboard'),
            'name_admin_bar'        => _x('Workout', 'Add New on Toolbar', 'athlete-dashboard'),
            'add_new'              => __('Add New', 'athlete-dashboard'),
            'add_new_item'         => __('Add New Workout', 'athlete-dashboard'),
            'new_item'             => __('New Workout', 'athlete-dashboard'),
            'edit_item'            => __('Edit Workout', 'athlete-dashboard'),
            'view_item'            => __('View Workout', 'athlete-dashboard'),
            'all_items'            => __('All Workouts', 'athlete-dashboard'),
            'search_items'         => __('Search Workouts', 'athlete-dashboard'),
            'not_found'            => __('No workouts found.', 'athlete-dashboard'),
            'not_found_in_trash'   => __('No workouts found in Trash.', 'athlete-dashboard'),
            'featured_image'       => _x('Workout Cover Image', 'Overrides the "Featured Image" phrase', 'athlete-dashboard'),
            'set_featured_image'   => _x('Set cover image', 'Overrides the "Set featured image" phrase', 'athlete-dashboard'),
            'remove_featured_image' => _x('Remove cover image', 'Overrides the "Remove featured image" phrase', 'athlete-dashboard'),
            'use_featured_image'   => _x('Use as cover image', 'Overrides the "Use as featured image" phrase', 'athlete-dashboard'),
            'archives'             => _x('Workout archives', 'The post type archive label used in nav menus', 'athlete-dashboard'),
            'insert_into_item'     => _x('Insert into workout', 'Overrides the "Insert into post" phrase', 'athlete-dashboard'),
            'uploaded_to_this_item' => _x('Uploaded to this workout', 'Overrides the "Uploaded to this post" phrase', 'athlete-dashboard'),
            'filter_items_list'    => _x('Filter workouts list', 'Screen reader text for the filter links', 'athlete-dashboard'),
            'items_list_navigation' => _x('Workouts list navigation', 'Screen reader text for the pagination', 'athlete-dashboard'),
            'items_list'           => _x('Workouts list', 'Screen reader text for the items list', 'athlete-dashboard'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'workout'),
            'capability_type'    => array('workout', 'workouts'),
            'map_meta_cap'       => true,
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 20,
            'menu_icon'          => 'dashicons-universal-access',
            'supports'           => array(
                'title',
                'editor',
                'author',
                'thumbnail',
                'excerpt',
                'custom-fields',
                'revisions'
            ),
            'show_in_rest'       => true,
            'rest_base'          => 'workouts',
            'template'           => array(
                array('core/paragraph', array(
                    'placeholder' => __('Add workout description...', 'athlete-dashboard')
                ))
            ),
            'template_lock'      => false
        );

        register_post_type(self::POST_TYPE, $args);
    }

    /**
     * Register custom meta fields
     */
    public function register_meta() {
        register_post_meta(self::POST_TYPE, '_workout_type', array(
            'type'              => 'string',
            'description'       => __('Type of workout', 'athlete-dashboard'),
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => array($this, 'auth_meta_callback'),
            'show_in_rest'      => true
        ));

        register_post_meta(self::POST_TYPE, '_workout_duration', array(
            'type'              => 'integer',
            'description'       => __('Duration in minutes', 'athlete-dashboard'),
            'single'            => true,
            'sanitize_callback' => 'absint',
            'auth_callback'     => array($this, 'auth_meta_callback'),
            'show_in_rest'      => true
        ));

        register_post_meta(self::POST_TYPE, '_workout_intensity', array(
            'type'              => 'integer',
            'description'       => __('Workout intensity (1-10)', 'athlete-dashboard'),
            'single'            => true,
            'sanitize_callback' => array($this, 'sanitize_intensity'),
            'auth_callback'     => array($this, 'auth_meta_callback'),
            'show_in_rest'      => true
        ));

        register_post_meta(self::POST_TYPE, '_workout_exercises', array(
            'type'              => 'array',
            'description'       => __('Workout exercises', 'athlete-dashboard'),
            'single'            => true,
            'sanitize_callback' => array($this, 'sanitize_exercises'),
            'auth_callback'     => array($this, 'auth_meta_callback'),
            'show_in_rest'      => array(
                'schema' => array(
                    'type'  => 'array',
                    'items' => array(
                        'type'       => 'object',
                        'properties' => array(
                            'id'     => array('type' => 'integer'),
                            'name'   => array('type' => 'string'),
                            'sets'   => array('type' => 'integer'),
                            'reps'   => array('type' => 'integer'),
                            'weight' => array('type' => 'number'),
                            'notes'  => array('type' => 'string')
                        )
                    )
                )
            )
        ));

        register_post_meta(self::POST_TYPE, '_workout_target_areas', array(
            'type'              => 'array',
            'description'       => __('Target muscle areas', 'athlete-dashboard'),
            'single'            => true,
            'sanitize_callback' => array($this, 'sanitize_target_areas'),
            'auth_callback'     => array($this, 'auth_meta_callback'),
            'show_in_rest'      => true
        ));
    }

    /**
     * Add meta boxes
     */
    public function add_meta_boxes() {
        add_meta_box(
            'workout_details',
            __('Workout Details', 'athlete-dashboard'),
            array($this, 'render_details_meta_box'),
            self::POST_TYPE,
            'normal',
            'high'
        );

        add_meta_box(
            'workout_exercises',
            __('Exercises', 'athlete-dashboard'),
            array($this, 'render_exercises_meta_box'),
            self::POST_TYPE,
            'normal',
            'high'
        );
    }

    /**
     * Render details meta box
     *
     * @param WP_Post $post Current post object
     */
    public function render_details_meta_box($post) {
        wp_nonce_field('workout_details_nonce', 'workout_details_nonce');

        $workout_type = get_post_meta($post->ID, '_workout_type', true);
        $duration = get_post_meta($post->ID, '_workout_duration', true);
        $intensity = get_post_meta($post->ID, '_workout_intensity', true);
        $target_areas = get_post_meta($post->ID, '_workout_target_areas', true);

        ?>
        <div class="workout-details">
            <p>
                <label for="workout_type"><?php esc_html_e('Workout Type:', 'athlete-dashboard'); ?></label>
                <select name="workout_type" id="workout_type">
                    <option value="strength" <?php selected($workout_type, 'strength'); ?>><?php esc_html_e('Strength', 'athlete-dashboard'); ?></option>
                    <option value="cardio" <?php selected($workout_type, 'cardio'); ?>><?php esc_html_e('Cardio', 'athlete-dashboard'); ?></option>
                    <option value="hiit" <?php selected($workout_type, 'hiit'); ?>><?php esc_html_e('HIIT', 'athlete-dashboard'); ?></option>
                    <option value="flexibility" <?php selected($workout_type, 'flexibility'); ?>><?php esc_html_e('Flexibility', 'athlete-dashboard'); ?></option>
                </select>
            </p>

            <p>
                <label for="workout_duration"><?php esc_html_e('Duration (minutes):', 'athlete-dashboard'); ?></label>
                <input type="number" id="workout_duration" name="workout_duration" value="<?php echo esc_attr($duration); ?>" min="1" max="300">
            </p>

            <p>
                <label for="workout_intensity"><?php esc_html_e('Intensity (1-10):', 'athlete-dashboard'); ?></label>
                <input type="range" id="workout_intensity" name="workout_intensity" value="<?php echo esc_attr($intensity); ?>" min="1" max="10">
                <span class="intensity-value"><?php echo esc_html($intensity); ?></span>
            </p>

            <p>
                <label for="workout_target_areas"><?php esc_html_e('Target Areas:', 'athlete-dashboard'); ?></label>
                <select name="workout_target_areas[]" id="workout_target_areas" multiple>
                    <?php
                    $areas = array(
                        'chest' => __('Chest', 'athlete-dashboard'),
                        'back' => __('Back', 'athlete-dashboard'),
                        'shoulders' => __('Shoulders', 'athlete-dashboard'),
                        'legs' => __('Legs', 'athlete-dashboard'),
                        'arms' => __('Arms', 'athlete-dashboard'),
                        'core' => __('Core', 'athlete-dashboard'),
                        'full_body' => __('Full Body', 'athlete-dashboard')
                    );

                    foreach ($areas as $value => $label) {
                        printf(
                            '<option value="%s" %s>%s</option>',
                            esc_attr($value),
                            in_array($value, (array) $target_areas) ? 'selected' : '',
                            esc_html($label)
                        );
                    }
                    ?>
                </select>
            </p>
        </div>

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('#workout_intensity').on('input', function() {
                    $('.intensity-value').text($(this).val());
                });
            });
        </script>
        <?php
    }

    /**
     * Render exercises meta box
     *
     * @param WP_Post $post Current post object
     */
    public function render_exercises_meta_box($post) {
        wp_nonce_field('workout_exercises_nonce', 'workout_exercises_nonce');

        $exercises = get_post_meta($post->ID, '_workout_exercises', true);
        if (!is_array($exercises)) {
            $exercises = array();
        }

        ?>
        <div class="workout-exercises" id="workout-exercises">
            <div class="exercises-list">
                <?php
                foreach ($exercises as $index => $exercise) {
                    $this->render_exercise_row($exercise, $index);
                }
                ?>
            </div>

            <button type="button" class="button add-exercise">
                <?php esc_html_e('Add Exercise', 'athlete-dashboard'); ?>
            </button>
        </div>

        <script type="text/template" id="exercise-row-template">
            <?php $this->render_exercise_row(array(), '{{index}}'); ?>
        </script>

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                var exerciseTemplate = $('#exercise-row-template').html();
                var exerciseCount = <?php echo count($exercises); ?>;

                $('.add-exercise').on('click', function() {
                    var newRow = exerciseTemplate.replace(/\{\{index\}\}/g, exerciseCount++);
                    $('.exercises-list').append(newRow);
                });

                $(document).on('click', '.remove-exercise', function() {
                    $(this).closest('.exercise-row').remove();
                });
            });
        </script>
        <?php
    }

    /**
     * Render a single exercise row
     *
     * @param array $exercise Exercise data
     * @param int|string $index Row index
     */
    private function render_exercise_row($exercise, $index) {
        ?>
        <div class="exercise-row">
            <input type="hidden" name="workout_exercises[<?php echo esc_attr($index); ?>][id]" 
                   value="<?php echo esc_attr($exercise['id'] ?? ''); ?>">
            
            <p>
                <label><?php esc_html_e('Exercise:', 'athlete-dashboard'); ?></label>
                <input type="text" name="workout_exercises[<?php echo esc_attr($index); ?>][name]" 
                       value="<?php echo esc_attr($exercise['name'] ?? ''); ?>" 
                       class="exercise-name" required>
            </p>

            <p>
                <label><?php esc_html_e('Sets:', 'athlete-dashboard'); ?></label>
                <input type="number" name="workout_exercises[<?php echo esc_attr($index); ?>][sets]" 
                       value="<?php echo esc_attr($exercise['sets'] ?? ''); ?>" 
                       min="1" class="small-text">

                <label><?php esc_html_e('Reps:', 'athlete-dashboard'); ?></label>
                <input type="number" name="workout_exercises[<?php echo esc_attr($index); ?>][reps]" 
                       value="<?php echo esc_attr($exercise['reps'] ?? ''); ?>" 
                       min="1" class="small-text">

                <label><?php esc_html_e('Weight (kg):', 'athlete-dashboard'); ?></label>
                <input type="number" name="workout_exercises[<?php echo esc_attr($index); ?>][weight]" 
                       value="<?php echo esc_attr($exercise['weight'] ?? ''); ?>" 
                       min="0" step="0.5" class="small-text">
            </p>

            <p>
                <label><?php esc_html_e('Notes:', 'athlete-dashboard'); ?></label>
                <textarea name="workout_exercises[<?php echo esc_attr($index); ?>][notes]" 
                          rows="2" class="large-text"><?php echo esc_textarea($exercise['notes'] ?? ''); ?></textarea>
            </p>

            <button type="button" class="button remove-exercise">
                <?php esc_html_e('Remove Exercise', 'athlete-dashboard'); ?>
            </button>
        </div>
        <?php
    }

    /**
     * Save meta box data
     *
     * @param int $post_id Post ID
     * @param WP_Post $post Post object
     */
    public function save_meta_boxes($post_id, $post) {
        // Verify nonces
        if (!isset($_POST['workout_details_nonce']) || 
            !wp_verify_nonce($_POST['workout_details_nonce'], 'workout_details_nonce')) {
            return;
        }

        if (!isset($_POST['workout_exercises_nonce']) || 
            !wp_verify_nonce($_POST['workout_exercises_nonce'], 'workout_exercises_nonce')) {
            return;
        }

        // Check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Check permissions
        if (!current_user_can('edit_workout', $post_id)) {
            return;
        }

        // Save workout details
        if (isset($_POST['workout_type'])) {
            update_post_meta($post_id, '_workout_type', sanitize_text_field($_POST['workout_type']));
        }

        if (isset($_POST['workout_duration'])) {
            update_post_meta($post_id, '_workout_duration', absint($_POST['workout_duration']));
        }

        if (isset($_POST['workout_intensity'])) {
            update_post_meta($post_id, '_workout_intensity', $this->sanitize_intensity($_POST['workout_intensity']));
        }

        if (isset($_POST['workout_target_areas'])) {
            update_post_meta($post_id, '_workout_target_areas', $this->sanitize_target_areas($_POST['workout_target_areas']));
        }

        // Save exercises
        if (isset($_POST['workout_exercises'])) {
            update_post_meta($post_id, '_workout_exercises', $this->sanitize_exercises($_POST['workout_exercises']));
        }
    }

    /**
     * Set custom columns for the workout list
     *
     * @param array $columns Existing columns
     * @return array Modified columns
     */
    public function set_custom_columns($columns) {
        $new_columns = array();
        
        // Add columns after title
        foreach ($columns as $key => $value) {
            $new_columns[$key] = $value;
            if ($key === 'title') {
                $new_columns['workout_type'] = __('Type', 'athlete-dashboard');
                $new_columns['workout_duration'] = __('Duration', 'athlete-dashboard');
                $new_columns['workout_intensity'] = __('Intensity', 'athlete-dashboard');
                $new_columns['target_areas'] = __('Target Areas', 'athlete-dashboard');
            }
        }

        return $new_columns;
    }

    /**
     * Render custom column content
     *
     * @param string $column Column name
     * @param int $post_id Post ID
     */
    public function render_custom_columns($column, $post_id) {
        switch ($column) {
            case 'workout_type':
                $type = get_post_meta($post_id, '_workout_type', true);
                echo esc_html(ucfirst($type));
                break;

            case 'workout_duration':
                $duration = get_post_meta($post_id, '_workout_duration', true);
                printf(
                    /* translators: %d: number of minutes */
                    esc_html__('%d min', 'athlete-dashboard'),
                    absint($duration)
                );
                break;

            case 'workout_intensity':
                $intensity = get_post_meta($post_id, '_workout_intensity', true);
                printf(
                    /* translators: %d: intensity value */
                    esc_html__('%d/10', 'athlete-dashboard'),
                    absint($intensity)
                );
                break;

            case 'target_areas':
                $areas = get_post_meta($post_id, '_workout_target_areas', true);
                if (is_array($areas)) {
                    echo esc_html(implode(', ', array_map('ucfirst', $areas)));
                }
                break;
        }
    }

    /**
     * Authorization callback for meta fields
     *
     * @param bool $allowed Whether the user can edit the post meta
     * @param string $meta_key The meta key
     * @param int $post_id Post ID
     * @param int $user_id User ID
     * @return bool
     */
    public function auth_meta_callback($allowed, $meta_key, $post_id, $user_id) {
        return current_user_can('edit_workout', $post_id);
    }

    /**
     * Sanitize workout intensity
     *
     * @param mixed $value The value to sanitize
     * @return int Sanitized intensity value
     */
    public function sanitize_intensity($value) {
        $intensity = absint($value);
        return max(1, min(10, $intensity));
    }

    /**
     * Sanitize target areas
     *
     * @param mixed $value The value to sanitize
     * @return array Sanitized target areas
     */
    public function sanitize_target_areas($value) {
        if (!is_array($value)) {
            return array();
        }

        $allowed_areas = array('chest', 'back', 'shoulders', 'legs', 'arms', 'core', 'full_body');
        return array_intersect($value, $allowed_areas);
    }

    /**
     * Sanitize exercises array
     *
     * @param mixed $value The value to sanitize
     * @return array Sanitized exercises
     */
    public function sanitize_exercises($value) {
        if (!is_array($value)) {
            return array();
        }

        return array_map(function($exercise) {
            return array(
                'id' => isset($exercise['id']) ? absint($exercise['id']) : 0,
                'name' => isset($exercise['name']) ? sanitize_text_field($exercise['name']) : '',
                'sets' => isset($exercise['sets']) ? absint($exercise['sets']) : 0,
                'reps' => isset($exercise['reps']) ? absint($exercise['reps']) : 0,
                'weight' => isset($exercise['weight']) ? floatval($exercise['weight']) : 0,
                'notes' => isset($exercise['notes']) ? sanitize_textarea_field($exercise['notes']) : ''
            );
        }, $value);
    }
} 