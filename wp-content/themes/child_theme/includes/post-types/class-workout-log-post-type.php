<?php
/**
 * Workout Log Post Type Class
 * 
 * Handles registration and management of the workout log custom post type
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Workout_Log_Post_Type {
    /**
     * Post type name
     */
    const POST_TYPE = 'workout_log';

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
     * Register the workout log post type
     */
    public function register_post_type() {
        $labels = array(
            'name'                  => _x('Workout Logs', 'Post type general name', 'athlete-dashboard'),
            'singular_name'         => _x('Workout Log', 'Post type singular name', 'athlete-dashboard'),
            'menu_name'            => _x('Workout Logs', 'Admin Menu text', 'athlete-dashboard'),
            'name_admin_bar'        => _x('Workout Log', 'Add New on Toolbar', 'athlete-dashboard'),
            'add_new'              => __('Add New', 'athlete-dashboard'),
            'add_new_item'         => __('Add New Log', 'athlete-dashboard'),
            'new_item'             => __('New Log', 'athlete-dashboard'),
            'edit_item'            => __('Edit Log', 'athlete-dashboard'),
            'view_item'            => __('View Log', 'athlete-dashboard'),
            'all_items'            => __('All Logs', 'athlete-dashboard'),
            'search_items'         => __('Search Logs', 'athlete-dashboard'),
            'not_found'            => __('No workout logs found.', 'athlete-dashboard'),
            'not_found_in_trash'   => __('No workout logs found in Trash.', 'athlete-dashboard'),
            'filter_items_list'    => _x('Filter workout logs list', 'Screen reader text for the filter links', 'athlete-dashboard'),
            'items_list_navigation' => _x('Workout logs list navigation', 'Screen reader text for the pagination', 'athlete-dashboard'),
            'items_list'           => _x('Workout logs list', 'Screen reader text for the items list', 'athlete-dashboard'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => 'edit.php?post_type=workout',
            'query_var'          => true,
            'rewrite'            => false,
            'capability_type'    => array('workout_log', 'workout_logs'),
            'map_meta_cap'       => true,
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array(
                'title',
                'author',
                'custom-fields'
            ),
            'show_in_rest'       => true,
            'rest_base'          => 'workout-logs'
        );

        register_post_type(self::POST_TYPE, $args);
    }

    /**
     * Register custom meta fields
     */
    public function register_meta() {
        register_post_meta(self::POST_TYPE, '_workout_id', array(
            'type'              => 'integer',
            'description'       => __('Associated workout ID', 'athlete-dashboard'),
            'single'            => true,
            'sanitize_callback' => 'absint',
            'auth_callback'     => array($this, 'auth_meta_callback'),
            'show_in_rest'      => true
        ));

        register_post_meta(self::POST_TYPE, '_workout_date', array(
            'type'              => 'string',
            'description'       => __('Date of workout completion', 'athlete-dashboard'),
            'single'            => true,
            'sanitize_callback' => array($this, 'sanitize_date'),
            'auth_callback'     => array($this, 'auth_meta_callback'),
            'show_in_rest'      => true
        ));

        register_post_meta(self::POST_TYPE, '_workout_duration', array(
            'type'              => 'integer',
            'description'       => __('Actual duration in minutes', 'athlete-dashboard'),
            'single'            => true,
            'sanitize_callback' => 'absint',
            'auth_callback'     => array($this, 'auth_meta_callback'),
            'show_in_rest'      => true
        ));

        register_post_meta(self::POST_TYPE, '_workout_intensity', array(
            'type'              => 'integer',
            'description'       => __('Actual intensity (1-10)', 'athlete-dashboard'),
            'single'            => true,
            'sanitize_callback' => array($this, 'sanitize_intensity'),
            'auth_callback'     => array($this, 'auth_meta_callback'),
            'show_in_rest'      => true
        ));

        register_post_meta(self::POST_TYPE, '_completed_exercises', array(
            'type'              => 'array',
            'description'       => __('Completed exercises data', 'athlete-dashboard'),
            'single'            => true,
            'sanitize_callback' => array($this, 'sanitize_completed_exercises'),
            'auth_callback'     => array($this, 'auth_meta_callback'),
            'show_in_rest'      => array(
                'schema' => array(
                    'type'  => 'array',
                    'items' => array(
                        'type'       => 'object',
                        'properties' => array(
                            'id'             => array('type' => 'integer'),
                            'sets_completed' => array('type' => 'integer'),
                            'reps_completed' => array('type' => 'integer'),
                            'weight_used'    => array('type' => 'number'),
                            'notes'          => array('type' => 'string')
                        )
                    )
                )
            )
        ));

        register_post_meta(self::POST_TYPE, '_notes', array(
            'type'              => 'string',
            'description'       => __('Workout notes', 'athlete-dashboard'),
            'single'            => true,
            'sanitize_callback' => 'sanitize_textarea_field',
            'auth_callback'     => array($this, 'auth_meta_callback'),
            'show_in_rest'      => true
        ));
    }

    /**
     * Add meta boxes
     */
    public function add_meta_boxes() {
        add_meta_box(
            'workout_log_details',
            __('Workout Log Details', 'athlete-dashboard'),
            array($this, 'render_details_meta_box'),
            self::POST_TYPE,
            'normal',
            'high'
        );

        add_meta_box(
            'completed_exercises',
            __('Completed Exercises', 'athlete-dashboard'),
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
        wp_nonce_field('workout_log_details_nonce', 'workout_log_details_nonce');

        $workout_id = get_post_meta($post->ID, '_workout_id', true);
        $workout_date = get_post_meta($post->ID, '_workout_date', true);
        $duration = get_post_meta($post->ID, '_workout_duration', true);
        $intensity = get_post_meta($post->ID, '_workout_intensity', true);
        $notes = get_post_meta($post->ID, '_notes', true);

        ?>
        <div class="workout-log-details">
            <p>
                <label for="workout_id"><?php esc_html_e('Workout:', 'athlete-dashboard'); ?></label>
                <?php
                wp_dropdown_posts(array(
                    'post_type' => 'workout',
                    'selected' => $workout_id,
                    'name' => 'workout_id',
                    'show_option_none' => __('Select a workout', 'athlete-dashboard'),
                    'option_none_value' => '',
                ));
                ?>
            </p>

            <p>
                <label for="workout_date"><?php esc_html_e('Date:', 'athlete-dashboard'); ?></label>
                <input type="date" id="workout_date" name="workout_date" 
                       value="<?php echo esc_attr($workout_date); ?>" required>
            </p>

            <p>
                <label for="workout_duration"><?php esc_html_e('Duration (minutes):', 'athlete-dashboard'); ?></label>
                <input type="number" id="workout_duration" name="workout_duration" 
                       value="<?php echo esc_attr($duration); ?>" min="1" max="300">
            </p>

            <p>
                <label for="workout_intensity"><?php esc_html_e('Intensity (1-10):', 'athlete-dashboard'); ?></label>
                <input type="range" id="workout_intensity" name="workout_intensity" 
                       value="<?php echo esc_attr($intensity); ?>" min="1" max="10">
                <span class="intensity-value"><?php echo esc_html($intensity); ?></span>
            </p>

            <p>
                <label for="workout_notes"><?php esc_html_e('Notes:', 'athlete-dashboard'); ?></label>
                <textarea id="workout_notes" name="workout_notes" rows="3" 
                          class="large-text"><?php echo esc_textarea($notes); ?></textarea>
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

        $completed_exercises = get_post_meta($post->ID, '_completed_exercises', true);
        if (!is_array($completed_exercises)) {
            $completed_exercises = array();
        }

        $workout_id = get_post_meta($post->ID, '_workout_id', true);
        $workout_exercises = array();
        
        if ($workout_id) {
            $workout_exercises = get_post_meta($workout_id, '_workout_exercises', true);
            if (!is_array($workout_exercises)) {
                $workout_exercises = array();
            }
        }

        ?>
        <div class="completed-exercises" id="completed-exercises">
            <?php if (empty($workout_exercises)): ?>
                <p><?php esc_html_e('Please select a workout first to load its exercises.', 'athlete-dashboard'); ?></p>
            <?php else: ?>
                <div class="exercises-list">
                    <?php
                    foreach ($workout_exercises as $exercise) {
                        $completed = $this->find_completed_exercise($completed_exercises, $exercise['id']);
                        $this->render_exercise_row($exercise, $completed);
                    }
                    ?>
                </div>
            <?php endif; ?>
        </div>

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('#workout_id').on('change', function() {
                    // Reload the page when workout changes
                    $(this).closest('form').submit();
                });
            });
        </script>
        <?php
    }

    /**
     * Render a single exercise row
     *
     * @param array $exercise Exercise data from workout
     * @param array $completed Completed exercise data
     */
    private function render_exercise_row($exercise, $completed) {
        ?>
        <div class="exercise-row">
            <h4><?php echo esc_html($exercise['name']); ?></h4>
            <input type="hidden" name="completed_exercises[<?php echo esc_attr($exercise['id']); ?>][id]" 
                   value="<?php echo esc_attr($exercise['id']); ?>">

            <p>
                <label><?php esc_html_e('Sets Completed:', 'athlete-dashboard'); ?></label>
                <input type="number" name="completed_exercises[<?php echo esc_attr($exercise['id']); ?>][sets_completed]" 
                       value="<?php echo esc_attr($completed['sets_completed'] ?? ''); ?>" 
                       min="0" max="<?php echo esc_attr($exercise['sets']); ?>" class="small-text">
                <span class="target">/ <?php echo esc_html($exercise['sets']); ?></span>
            </p>

            <p>
                <label><?php esc_html_e('Reps Completed:', 'athlete-dashboard'); ?></label>
                <input type="number" name="completed_exercises[<?php echo esc_attr($exercise['id']); ?>][reps_completed]" 
                       value="<?php echo esc_attr($completed['reps_completed'] ?? ''); ?>" 
                       min="0" max="<?php echo esc_attr($exercise['reps']); ?>" class="small-text">
                <span class="target">/ <?php echo esc_html($exercise['reps']); ?></span>
            </p>

            <p>
                <label><?php esc_html_e('Weight Used (kg):', 'athlete-dashboard'); ?></label>
                <input type="number" name="completed_exercises[<?php echo esc_attr($exercise['id']); ?>][weight_used]" 
                       value="<?php echo esc_attr($completed['weight_used'] ?? $exercise['weight']); ?>" 
                       min="0" step="0.5" class="small-text">
            </p>

            <p>
                <label><?php esc_html_e('Notes:', 'athlete-dashboard'); ?></label>
                <textarea name="completed_exercises[<?php echo esc_attr($exercise['id']); ?>][notes]" 
                          rows="2" class="large-text"><?php echo esc_textarea($completed['notes'] ?? ''); ?></textarea>
            </p>
        </div>
        <?php
    }

    /**
     * Find completed exercise data by ID
     *
     * @param array $completed_exercises Array of completed exercises
     * @param int $exercise_id Exercise ID to find
     * @return array|null Found exercise data or null
     */
    private function find_completed_exercise($completed_exercises, $exercise_id) {
        foreach ($completed_exercises as $exercise) {
            if (isset($exercise['id']) && $exercise['id'] == $exercise_id) {
                return $exercise;
            }
        }
        return null;
    }

    /**
     * Save meta box data
     *
     * @param int $post_id Post ID
     * @param WP_Post $post Post object
     */
    public function save_meta_boxes($post_id, $post) {
        // Verify nonces
        if (!isset($_POST['workout_log_details_nonce']) || 
            !wp_verify_nonce($_POST['workout_log_details_nonce'], 'workout_log_details_nonce')) {
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
        if (!current_user_can('edit_workout_log', $post_id)) {
            return;
        }

        // Save workout details
        if (isset($_POST['workout_id'])) {
            update_post_meta($post_id, '_workout_id', absint($_POST['workout_id']));
        }

        if (isset($_POST['workout_date'])) {
            update_post_meta($post_id, '_workout_date', $this->sanitize_date($_POST['workout_date']));
        }

        if (isset($_POST['workout_duration'])) {
            update_post_meta($post_id, '_workout_duration', absint($_POST['workout_duration']));
        }

        if (isset($_POST['workout_intensity'])) {
            update_post_meta($post_id, '_workout_intensity', $this->sanitize_intensity($_POST['workout_intensity']));
        }

        if (isset($_POST['workout_notes'])) {
            update_post_meta($post_id, '_notes', sanitize_textarea_field($_POST['workout_notes']));
        }

        // Save completed exercises
        if (isset($_POST['completed_exercises'])) {
            update_post_meta($post_id, '_completed_exercises', $this->sanitize_completed_exercises($_POST['completed_exercises']));
        }
    }

    /**
     * Set custom columns for the workout log list
     *
     * @param array $columns Existing columns
     * @return array Modified columns
     */
    public function set_custom_columns($columns) {
        $new_columns = array();
        
        foreach ($columns as $key => $value) {
            if ($key === 'title') {
                $new_columns[$key] = __('Log Entry', 'athlete-dashboard');
                $new_columns['workout'] = __('Workout', 'athlete-dashboard');
                $new_columns['date'] = __('Date', 'athlete-dashboard');
                $new_columns['duration'] = __('Duration', 'athlete-dashboard');
                $new_columns['intensity'] = __('Intensity', 'athlete-dashboard');
            } else if ($key !== 'date') { // Skip the default date column
                $new_columns[$key] = $value;
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
            case 'workout':
                $workout_id = get_post_meta($post_id, '_workout_id', true);
                if ($workout_id) {
                    $workout = get_post($workout_id);
                    if ($workout) {
                        printf(
                            '<a href="%s">%s</a>',
                            esc_url(get_edit_post_link($workout_id)),
                            esc_html($workout->post_title)
                        );
                    }
                }
                break;

            case 'date':
                $date = get_post_meta($post_id, '_workout_date', true);
                echo esc_html(date_i18n(get_option('date_format'), strtotime($date)));
                break;

            case 'duration':
                $duration = get_post_meta($post_id, '_workout_duration', true);
                printf(
                    /* translators: %d: number of minutes */
                    esc_html__('%d min', 'athlete-dashboard'),
                    absint($duration)
                );
                break;

            case 'intensity':
                $intensity = get_post_meta($post_id, '_workout_intensity', true);
                printf(
                    /* translators: %d: intensity value */
                    esc_html__('%d/10', 'athlete-dashboard'),
                    absint($intensity)
                );
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
        return current_user_can('edit_workout_log', $post_id);
    }

    /**
     * Sanitize date
     *
     * @param string $date Date string
     * @return string Sanitized date in Y-m-d format
     */
    public function sanitize_date($date) {
        return date('Y-m-d', strtotime($date));
    }

    /**
     * Sanitize intensity
     *
     * @param mixed $value The value to sanitize
     * @return int Sanitized intensity value
     */
    public function sanitize_intensity($value) {
        $intensity = absint($value);
        return max(1, min(10, $intensity));
    }

    /**
     * Sanitize completed exercises array
     *
     * @param mixed $value The value to sanitize
     * @return array Sanitized completed exercises
     */
    public function sanitize_completed_exercises($value) {
        if (!is_array($value)) {
            return array();
        }

        return array_map(function($exercise) {
            return array(
                'id' => isset($exercise['id']) ? absint($exercise['id']) : 0,
                'sets_completed' => isset($exercise['sets_completed']) ? absint($exercise['sets_completed']) : 0,
                'reps_completed' => isset($exercise['reps_completed']) ? absint($exercise['reps_completed']) : 0,
                'weight_used' => isset($exercise['weight_used']) ? floatval($exercise['weight_used']) : 0,
                'notes' => isset($exercise['notes']) ? sanitize_textarea_field($exercise['notes']) : ''
            );
        }, $value);
    }
} 