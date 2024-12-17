<?php
/**
 * Profile Component
 */

if (!defined('ABSPATH')) {
    exit;
}

class Profile {
    private $meta_prefix = '_athlete_';
    private $fields = array(
        'age' => array(
            'type' => 'number',
            'label' => 'Age',
            'required' => true
        ),
        'gender' => array(
            'type' => 'select',
            'label' => 'Gender',
            'options' => array('male', 'female', 'other'),
            'required' => true
        ),
        'height' => array(
            'type' => 'number',
            'label' => 'Height (cm)',
            'required' => true
        ),
        'weight' => array(
            'type' => 'number',
            'label' => 'Weight (kg)',
            'required' => true
        ),
        'primary_goal' => array(
            'type' => 'select',
            'label' => 'Primary Goal',
            'options' => array(
                'strength' => 'Build Strength',
                'muscle' => 'Build Muscle',
                'weight_loss' => 'Weight Loss',
                'endurance' => 'Improve Endurance',
                'general' => 'General Fitness'
            ),
            'required' => true
        ),
        'activity_level' => array(
            'type' => 'select',
            'label' => 'Current Activity Level',
            'options' => array(
                'beginner' => 'Beginner',
                'intermediate' => 'Intermediate',
                'advanced' => 'Advanced'
            ),
            'required' => true
        ),
        'preferred_intensity' => array(
            'type' => 'select',
            'label' => 'Preferred Intensity',
            'options' => array(
                'low' => 'Low',
                'moderate' => 'Moderate',
                'high' => 'High'
            ),
            'required' => true
        ),
        'equipment_access' => array(
            'type' => 'multiselect',
            'label' => 'Available Equipment',
            'options' => array(
                'none' => 'No Equipment',
                'dumbbells' => 'Dumbbells',
                'barbell' => 'Barbell',
                'bench' => 'Bench',
                'rack' => 'Power Rack',
                'cables' => 'Cable Machine',
                'kettlebells' => 'Kettlebells'
            ),
            'required' => true
        )
    );

    public function __construct() {
        $this->init();
    }

    private function init() {
        add_action('wp_ajax_save_profile', array($this, 'save_profile'));
        add_action('wp_ajax_get_profile', array($this, 'get_profile'));
    }

    public function get_profile_data($user_id = null) {
        if (!$user_id) {
            $user_id = get_current_user_id();
        }

        $profile_data = array();
        foreach ($this->fields as $field => $config) {
            $profile_data[$field] = get_user_meta($user_id, $this->meta_prefix . $field, true);
        }

        return $profile_data;
    }

    public function save_profile() {
        check_ajax_referer('profile_nonce', 'nonce');

        $user_id = get_current_user_id();
        if (!$user_id) {
            wp_send_json_error('User not logged in');
            return;
        }

        foreach ($this->fields as $field => $config) {
            if (isset($_POST[$field])) {
                $value = sanitize_text_field($_POST[$field]);
                if ($config['required'] && empty($value)) {
                    wp_send_json_error("Field {$config['label']} is required");
                    return;
                }
                update_user_meta($user_id, $this->meta_prefix . $field, $value);
            }
        }

        wp_send_json_success('Profile updated successfully');
    }

    public function render_form() {
        $profile_data = $this->get_profile_data();
        ob_start();
        ?>
        <form id="profile-form" class="profile-form">
            <?php wp_nonce_field('profile_nonce', 'profile_nonce'); ?>
            
            <?php foreach ($this->fields as $field => $config): ?>
                <div class="form-group">
                    <label for="<?php echo esc_attr($field); ?>">
                        <?php echo esc_html($config['label']); ?>
                        <?php if ($config['required']): ?>
                            <span class="required">*</span>
                        <?php endif; ?>
                    </label>

                    <?php if ($config['type'] === 'select'): ?>
                        <select name="<?php echo esc_attr($field); ?>" 
                                id="<?php echo esc_attr($field); ?>"
                                <?php echo $config['required'] ? 'required' : ''; ?>>
                            <option value="">Select <?php echo esc_html($config['label']); ?></option>
                            <?php foreach ($config['options'] as $value => $label): ?>
                                <option value="<?php echo esc_attr($value); ?>"
                                        <?php selected($profile_data[$field], $value); ?>>
                                    <?php echo esc_html($label); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                    <?php elseif ($config['type'] === 'multiselect'): ?>
                        <select name="<?php echo esc_attr($field); ?>[]" 
                                id="<?php echo esc_attr($field); ?>"
                                multiple
                                <?php echo $config['required'] ? 'required' : ''; ?>>
                            <?php 
                            $selected_values = explode(',', $profile_data[$field]);
                            foreach ($config['options'] as $value => $label): 
                            ?>
                                <option value="<?php echo esc_attr($value); ?>"
                                        <?php echo in_array($value, $selected_values) ? 'selected' : ''; ?>>
                                    <?php echo esc_html($label); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                    <?php else: ?>
                        <input type="<?php echo esc_attr($config['type']); ?>"
                               name="<?php echo esc_attr($field); ?>"
                               id="<?php echo esc_attr($field); ?>"
                               value="<?php echo esc_attr($profile_data[$field]); ?>"
                               <?php echo $config['required'] ? 'required' : ''; ?>>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <button type="submit" class="submit-button">Save Profile</button>
        </form>
        <?php
        return ob_get_clean();
    }
} 