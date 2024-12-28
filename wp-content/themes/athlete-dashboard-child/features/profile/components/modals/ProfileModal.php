<?php
/**
 * Profile Modal Component
 * 
 * Implements the dashboard modal interface for the profile feature.
 */

namespace AthleteDashboard\Features\Profile\Components\Modals;

use AthleteDashboard\Dashboard\Contracts\ModalInterface;

if (!defined('ABSPATH')) {
    exit;
}

class ProfileModal implements ModalInterface {
    private string $modal_id;
    private array $data;
    private array $options;

    public function __construct(string $modal_id, array $data = [], array $options = []) {
        $this->modal_id = $modal_id;
        $this->data = $data;
        $this->options = array_merge([
            'title' => __('Your Profile', 'athlete-dashboard-child'),
            'submitText' => __('Save Profile', 'athlete-dashboard-child'),
            'closeText' => __('Close', 'athlete-dashboard-child')
        ], $options);
    }

    public function getId(): string {
        return $this->modal_id;
    }

    public function getTitle(): string {
        return $this->options['title'];
    }

    public function renderContent(): void {
        ?>
        <div class="profile-modal-content">
            <form id="<?php echo esc_attr($this->modal_id); ?>-form" class="profile-form">
                <?php wp_nonce_field('profile_nonce', 'profile_nonce'); ?>
                <div class="form-fields">
                    <?php $this->render_fields(); ?>
                </div>
            </form>
        </div>
        <?php
    }

    public function getAttributes(): array {
        return [
            'size' => 'large',
            'class' => 'profile-feature-modal',
            'buttons' => [
                [
                    'text' => $this->options['closeText'],
                    'class' => 'close-modal button button-secondary',
                    'attrs' => ''
                ],
                [
                    'text' => $this->options['submitText'],
                    'class' => 'submit-modal button button-primary',
                    'attrs' => 'form="' . esc_attr($this->modal_id) . '-form"'
                ]
            ]
        ];
    }

    public function getDependencies(): array {
        return [
            'styles' => ['profile-feature', 'profile-modal'],
            'scripts' => ['profile-modal']
        ];
    }

    private function render_fields(): void {
        // Add your form fields here
        ?>
        <div class="form-field">
            <label for="first_name" class="field-label">
                <?php _e('First Name', 'athlete-dashboard-child'); ?>
                <span class="required">*</span>
            </label>
            <input type="text" 
                   id="first_name" 
                   name="first_name" 
                   value="<?php echo esc_attr($this->data['first_name'] ?? ''); ?>"
                   class="form-input"
                   required>
        </div>

        <div class="form-field">
            <label for="last_name" class="field-label">
                <?php _e('Last Name', 'athlete-dashboard-child'); ?>
                <span class="required">*</span>
            </label>
            <input type="text" 
                   id="last_name" 
                   name="last_name" 
                   value="<?php echo esc_attr($this->data['last_name'] ?? ''); ?>"
                   class="form-input"
                   required>
        </div>

        <div class="form-field">
            <label for="email" class="field-label">
                <?php _e('Email', 'athlete-dashboard-child'); ?>
                <span class="required">*</span>
            </label>
            <input type="email" 
                   id="email" 
                   name="email" 
                   value="<?php echo esc_attr($this->data['email'] ?? ''); ?>"
                   class="form-input"
                   required>
        </div>

        <div class="form-field">
            <label for="phone" class="field-label">
                <?php _e('Phone', 'athlete-dashboard-child'); ?>
            </label>
            <input type="tel" 
                   id="phone" 
                   name="phone" 
                   value="<?php echo esc_attr($this->data['phone'] ?? ''); ?>"
                   class="form-input">
        </div>

        <div class="form-field">
            <label for="height" class="field-label">
                <?php _e('Height', 'athlete-dashboard-child'); ?>
                <span class="required">*</span>
            </label>
            <div class="height-field-wrapper">
                <?php 
                $current_unit = $this->data['height_unit'] ?? 'imperial';
                if ($current_unit === 'imperial'): 
                    $height_options = [
                        '4-8' => "4'8\"", '4-9' => "4'9\"", '4-10' => "4'10\"", '4-11' => "4'11\"",
                        '5-0' => "5'0\"", '5-1' => "5'1\"", '5-2' => "5'2\"", '5-3' => "5'3\"",
                        '5-4' => "5'4\"", '5-5' => "5'5\"", '5-6' => "5'6\"", '5-7' => "5'7\"",
                        '5-8' => "5'8\"", '5-9' => "5'9\"", '5-10' => "5'10\"", '5-11' => "5'11\"",
                        '6-0' => "6'0\"", '6-1' => "6'1\"", '6-2' => "6'2\"", '6-3' => "6'3\"",
                        '6-4' => "6'4\"", '6-5' => "6'5\"", '6-6' => "6'6\"", '6-7' => "6'7\""
                    ];
                ?>
                    <select id="height" 
                            name="height" 
                            class="form-select height-select"
                            required>
                        <option value=""><?php _e('Select height', 'athlete-dashboard-child'); ?></option>
                        <?php foreach ($height_options as $value => $label): ?>
                            <option value="<?php echo esc_attr($value); ?>" 
                                    <?php selected($this->data['height'] ?? '', $value); ?>>
                                <?php echo esc_html($label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                    <input type="number" 
                           id="height" 
                           name="height" 
                           value="<?php echo esc_attr($this->data['height'] ?? ''); ?>"
                           class="form-input height-input"
                           min="100"
                           max="250"
                           step="1"
                           required>
                <?php endif; ?>

                <select id="height_unit" 
                        name="height_unit" 
                        class="form-select unit-select">
                    <option value="imperial" <?php selected($current_unit, 'imperial'); ?>>
                        <?php _e('FT/IN', 'athlete-dashboard-child'); ?>
                    </option>
                    <option value="metric" <?php selected($current_unit, 'metric'); ?>>
                        <?php _e('CM', 'athlete-dashboard-child'); ?>
                    </option>
                </select>
            </div>
        </div>

        <div class="form-field">
            <label for="weight" class="field-label">
                <?php _e('Weight', 'athlete-dashboard-child'); ?>
                <span class="required">*</span>
            </label>
            <div class="weight-field-wrapper">
                <input type="number" 
                       id="weight" 
                       name="weight" 
                       value="<?php echo esc_attr($this->data['weight'] ?? ''); ?>"
                       class="form-input weight-input"
                       min="1"
                       max="500"
                       step="0.1"
                       required>

                <select id="weight_unit" 
                        name="weight_unit" 
                        class="form-select unit-select">
                    <option value="imperial" <?php selected($this->data['weight_unit'] ?? 'imperial', 'imperial'); ?>>
                        <?php _e('LBS', 'athlete-dashboard-child'); ?>
                    </option>
                    <option value="metric" <?php selected($this->data['weight_unit'] ?? 'imperial', 'metric'); ?>>
                        <?php _e('KG', 'athlete-dashboard-child'); ?>
                    </option>
                </select>
            </div>
        </div>

        <div class="form-field">
            <label for="date_of_birth" class="field-label">
                <?php _e('Date of Birth', 'athlete-dashboard-child'); ?>
                <span class="required">*</span>
            </label>
            <input type="date" 
                   id="date_of_birth" 
                   name="date_of_birth" 
                   value="<?php echo esc_attr($this->data['date_of_birth'] ?? ''); ?>"
                   class="form-input"
                   required>
        </div>

        <div class="form-field">
            <label for="gender" class="field-label">
                <?php _e('Gender', 'athlete-dashboard-child'); ?>
            </label>
            <select id="gender" name="gender" class="form-select">
                <option value=""><?php _e('Select gender', 'athlete-dashboard-child'); ?></option>
                <option value="male" <?php selected($this->data['gender'] ?? '', 'male'); ?>>
                    <?php _e('Male', 'athlete-dashboard-child'); ?>
                </option>
                <option value="female" <?php selected($this->data['gender'] ?? '', 'female'); ?>>
                    <?php _e('Female', 'athlete-dashboard-child'); ?>
                </option>
                <option value="other" <?php selected($this->data['gender'] ?? '', 'other'); ?>>
                    <?php _e('Other', 'athlete-dashboard-child'); ?>
                </option>
                <option value="prefer_not_to_say" <?php selected($this->data['gender'] ?? '', 'prefer_not_to_say'); ?>>
                    <?php _e('Prefer not to say', 'athlete-dashboard-child'); ?>
                </option>
            </select>
        </div>
        <?php
    }

    public function render(): void {
        // Render the complete modal structure
        ?>
        <div id="<?php echo esc_attr($this->getId()); ?>" 
             class="dashboard-modal <?php echo esc_attr($this->getAttributes()['class']); ?>" 
             aria-hidden="true">
            <div class="modal-backdrop"></div>
            <div class="modal-container" 
                 data-size="<?php echo esc_attr($this->getAttributes()['size']); ?>" 
                 role="dialog" 
                 aria-modal="true" 
                 aria-labelledby="<?php echo esc_attr($this->getId()); ?>-title">
                <div class="modal-header">
                    <h2 id="<?php echo esc_attr($this->getId()); ?>-title">
                        <?php echo esc_html($this->getTitle()); ?>
                    </h2>
                    <button type="button" 
                            class="close-modal" 
                            aria-label="<?php esc_attr_e('Close', 'athlete-dashboard-child'); ?>">
                        <span class="dashicons dashicons-no-alt"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php $this->renderContent(); ?>
                </div>
                <?php if (!empty($this->getAttributes()['buttons'])): ?>
                    <div class="modal-footer">
                        <?php foreach ($this->getAttributes()['buttons'] as $button): ?>
                            <button type="button" 
                                    class="<?php echo esc_attr($button['class']); ?>"
                                    <?php echo $button['attrs']; ?>>
                                <?php echo esc_html($button['text']); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    public function enqueueAssets(): void {
        // Assets are now handled by ProfileFeature::enqueue_assets()
        return;
    }
} 