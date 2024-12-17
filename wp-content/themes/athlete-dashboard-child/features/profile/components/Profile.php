<?php
/**
 * Profile Component
 */

if (!defined('ABSPATH')) {
    exit;
}

class Profile {
    private $meta_prefix = '_athlete_';
    private $fields;

    public function __construct() {
        $this->init_fields();
        $this->init();
    }

    private function init_fields() {
        $this->fields = array(
            'age' => array(
                'type' => 'number',
                'label' => 'Age',
                'required' => true,
                'description' => 'Your current age'
            ),
            'gender' => array(
                'type' => 'select',
                'label' => 'Gender',
                'options' => array(
                    'male' => 'Male',
                    'female' => 'Female',
                    'other' => 'Other'
                ),
                'required' => true,
                'description' => 'Your gender'
            ),
            'height_feet' => array(
                'type' => 'select',
                'label' => 'Height (ft)',
                'options' => array_combine(
                    range(4, 8),
                    array_map(function($ft) { return $ft . ' ft'; }, range(4, 8))
                ),
                'required' => true,
                'group' => 'height',
                'description' => 'Your height in feet'
            ),
            'height_inches' => array(
                'type' => 'select',
                'label' => 'Height (in)',
                'options' => array_combine(
                    range(0, 11),
                    array_map(function($in) { return $in . ' in'; }, range(0, 11))
                ),
                'required' => true,
                'group' => 'height',
                'description' => 'Additional inches'
            ),
            'height_cm' => array(
                'type' => 'number',
                'label' => 'Height (cm)',
                'required' => true,
                'group' => 'height',
                'hidden' => true,
                'description' => 'Your height in centimeters'
            ),
            'weight_lbs' => array(
                'type' => 'number',
                'label' => 'Weight (lbs)',
                'required' => true,
                'group' => 'weight',
                'description' => 'Your weight in pounds'
            ),
            'weight_kg' => array(
                'type' => 'number',
                'label' => 'Weight (kg)',
                'required' => true,
                'group' => 'weight',
                'hidden' => true,
                'description' => 'Your weight in kilograms'
            ),
            'unit_preference' => array(
                'type' => 'select',
                'label' => 'Preferred Units',
                'options' => array(
                    'imperial' => 'Imperial (lbs/ft)',
                    'metric' => 'Metric (kg/cm)'
                ),
                'required' => true,
                'default' => 'imperial',
                'description' => 'Your preferred unit system'
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
                'required' => true,
                'description' => 'Your main fitness goal'
            ),
            'activity_level' => array(
                'type' => 'select',
                'label' => 'Current Activity Level',
                'options' => array(
                    'beginner' => 'Beginner',
                    'intermediate' => 'Intermediate',
                    'advanced' => 'Advanced'
                ),
                'required' => true,
                'description' => 'Your current fitness level'
            ),
            'preferred_intensity' => array(
                'type' => 'select',
                'label' => 'Preferred Intensity',
                'options' => array(
                    'low' => 'Low',
                    'moderate' => 'Moderate',
                    'high' => 'High'
                ),
                'required' => true,
                'description' => 'Your preferred workout intensity'
            ),
            'equipment_access' => array(
                'type' => 'equipment',
                'label' => 'Available Equipment',
                'options' => array(
                    'commercial_gym' => 'Commercial Gym',
                    'hotel_gym' => 'Hotel/Condo Gym',
                    'outdoor_park' => 'Outdoor Park',
                    'dumbbells' => 'Dumbbells',
                    'barbell' => 'Barbell',
                    'bench' => 'Bench',
                    'rack' => 'Power Rack',
                    'cables' => 'Cable Machine',
                    'kettlebells' => 'Kettlebells',
                    'resistance_bands' => 'Resistance Bands',
                    'pull_up_bar' => 'Pull-up Bar'
                ),
                'required' => true,
                'description' => 'Select from the list or add custom equipment'
            )
        );
    }

    private function init() {
        add_action('wp_ajax_save_profile', array($this, 'save_profile'));
        add_action('wp_ajax_get_profile', array($this, 'get_profile'));
    }

    public function render_admin_fields($user) {
        if (!current_user_can('edit_user', $user->ID)) {
            return;
        }

        $profile_data = $this->get_profile_data($user->ID);
        ?>
        <h3><?php _e('Athlete Profile Information', 'athlete-dashboard-child'); ?></h3>
        <table class="form-table">
            <?php foreach ($this->fields as $field => $config): ?>
                <?php if (isset($config['hidden']) && $config['hidden']) continue; ?>
                <tr>
                    <th>
                        <label for="<?php echo esc_attr($field); ?>">
                            <?php echo esc_html($config['label']); ?>
                        </label>
                    </th>
                    <td>
                        <?php if ($config['type'] === 'select'): ?>
                            <select name="<?php echo esc_attr($field); ?>" 
                                    id="<?php echo esc_attr($field); ?>">
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
                                    multiple>
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
                        <?php elseif ($config['type'] === 'equipment'): ?>
                            <div class="equipment-selector">
                                <div class="equipment-options">
                                    <select class="equipment-select" multiple>
                                        <?php foreach ($config['options'] as $value => $label): ?>
                                            <option value="<?php echo esc_attr($label); ?>">
                                                <?php echo esc_html($label); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="button" class="add-equipment">Add Selected</button>
                                </div>
                                <div class="equipment-input">
                                    <textarea name="<?php echo esc_attr($field); ?>" 
                                             id="<?php echo esc_attr($field); ?>"
                                             class="equipment-list"
                                             placeholder="Your available equipment will appear here. Add custom equipment by typing and pressing Enter."
                                             <?php echo $config['required'] ? 'required' : ''; ?>><?php 
                                        echo esc_textarea($profile_data[$field]); 
                                    ?></textarea>
                                </div>
                            </div>
                        <?php else: ?>
                            <input type="<?php echo esc_attr($config['type']); ?>"
                                   name="<?php echo esc_attr($field); ?>"
                                   id="<?php echo esc_attr($field); ?>"
                                   value="<?php echo esc_attr($profile_data[$field]); ?>">
                        <?php endif; ?>
                        <p class="description"><?php echo esc_html($config['description']); ?></p>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php
    }

    public function save_admin_fields($user_id) {
        if (!current_user_can('edit_user', $user_id)) {
            return false;
        }

        foreach ($this->fields as $field => $config) {
            if (isset($_POST[$field])) {
                $value = $config['type'] === 'multiselect' 
                    ? implode(',', array_map('sanitize_text_field', $_POST[$field]))
                    : sanitize_text_field($_POST[$field]);
                update_user_meta($user_id, $this->meta_prefix . $field, $value);
            }
        }
    }

    public function get_profile_data($user_id = null) {
        if (!$user_id) {
            $user_id = get_current_user_id();
        }

        $profile_data = array();
        foreach ($this->fields as $field => $config) {
            $value = get_user_meta($user_id, $this->meta_prefix . $field, true);
            $profile_data[$field] = !empty($value) ? $value : 
                (isset($config['default']) ? $config['default'] : '');
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

        // Get unit preference first
        $unit_preference = isset($_POST['unit_preference']) ? sanitize_text_field($_POST['unit_preference']) : 'imperial';

        foreach ($this->fields as $field => $config) {
            if (isset($_POST[$field])) {
                $value = sanitize_text_field($_POST[$field]);
                
                // Skip empty required fields
                if ($config['required'] && empty($value)) {
                    wp_send_json_error("Field {$config['label']} is required");
                    return;
                }

                // Handle unit conversions
                if ($config['group'] === 'height') {
                    if ($unit_preference === 'imperial' && $field === 'height_cm') {
                        // Convert feet/inches to cm
                        $feet = intval($_POST['height_feet']);
                        $inches = intval($_POST['height_inches']);
                        $value = round(($feet * 30.48) + ($inches * 2.54));
                    } elseif ($unit_preference === 'metric' && $field === 'height_feet') {
                        // Convert cm to feet/inches
                        $cm = intval($_POST['height_cm']);
                        $total_inches = round($cm / 2.54);
                        $value = floor($total_inches / 12);
                        update_user_meta($user_id, $this->meta_prefix . 'height_inches', $total_inches % 12);
                    }
                } elseif ($config['group'] === 'weight') {
                    if ($unit_preference === 'imperial' && $field === 'weight_kg') {
                        // Convert lbs to kg
                        $value = round(intval($_POST['weight_lbs']) * 0.453592);
                    } elseif ($unit_preference === 'metric' && $field === 'weight_lbs') {
                        // Convert kg to lbs
                        $value = round(intval($_POST['weight_kg']) * 2.20462);
                    }
                }

                if ($config['type'] === 'equipment') {
                    $value = sanitize_textarea_field($_POST[$field]);
                }

                update_user_meta($user_id, $this->meta_prefix . $field, $value);
            }
        }

        wp_send_json_success(array(
            'message' => 'Profile updated successfully',
            'data' => $this->get_profile_data($user_id)
        ));
    }

    public function render_form() {
        $profile_data = $this->get_profile_data();
        $unit_preference = !empty($profile_data['unit_preference']) ? $profile_data['unit_preference'] : 'imperial';
        
        ob_start();
        ?>
        <form id="profile-form" class="profile-form" data-unit-preference="<?php echo esc_attr($unit_preference); ?>">
            <?php wp_nonce_field('profile_nonce', 'profile_nonce'); ?>
            
            <?php foreach ($this->fields as $field => $config): ?>
                <?php
                // Skip hidden fields based on unit preference
                if (isset($config['hidden']) && $config['hidden']) {
                    continue;
                }
                
                // Skip height/weight fields based on unit preference
                if (isset($config['group'])) {
                    if ($config['group'] === 'height' && $unit_preference === 'metric' && $field !== 'height_cm') {
                        continue;
                    }
                    if ($config['group'] === 'height' && $unit_preference === 'imperial' && $field === 'height_cm') {
                        continue;
                    }
                    if ($config['group'] === 'weight' && $unit_preference === 'metric' && $field === 'weight_lbs') {
                        continue;
                    }
                    if ($config['group'] === 'weight' && $unit_preference === 'imperial' && $field === 'weight_kg') {
                        continue;
                    }
                }
                ?>
                <div class="form-group" data-field="<?php echo esc_attr($field); ?>">
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

                    <?php elseif ($config['type'] === 'equipment'): ?>
                        <div class="equipment-selector">
                            <div class="equipment-options">
                                <select class="equipment-select" multiple>
                                    <?php foreach ($config['options'] as $value => $label): ?>
                                        <option value="<?php echo esc_attr($label); ?>">
                                            <?php echo esc_html($label); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="button" class="add-equipment">Add Selected</button>
                            </div>
                            <div class="equipment-input">
                                <textarea name="<?php echo esc_attr($field); ?>" 
                                         id="<?php echo esc_attr($field); ?>"
                                         class="equipment-list"
                                         placeholder="Your available equipment will appear here. Add custom equipment by typing and pressing Enter."
                                         <?php echo $config['required'] ? 'required' : ''; ?>><?php 
                                    echo esc_textarea($profile_data[$field]); 
                                ?></textarea>
                            </div>
                        </div>

                    <?php else: ?>
                        <input type="<?php echo esc_attr($config['type']); ?>"
                               name="<?php echo esc_attr($field); ?>"
                               id="<?php echo esc_attr($field); ?>"
                               value="<?php echo esc_attr($profile_data[$field]); ?>"
                               <?php echo $config['required'] ? 'required' : ''; ?>>
                    <?php endif; ?>

                    <?php if (!empty($config['description'])): ?>
                        <p class="description"><?php echo esc_html($config['description']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <button type="submit" class="submit-button">Save Profile</button>
        </form>
        <?php
        return ob_get_clean();
    }
} 