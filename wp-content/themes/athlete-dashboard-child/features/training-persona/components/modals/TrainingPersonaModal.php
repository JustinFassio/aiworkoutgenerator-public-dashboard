<?php
/**
 * Training Persona Modal Component
 * 
 * Implements the dashboard modal interface for the training persona feature.
 */

namespace AthleteDashboard\Features\TrainingPersona\Components\Modals;

use AthleteDashboard\Dashboard\Contracts\ModalInterface;

if (!defined('ABSPATH')) {
    exit;
}

class TrainingPersonaModal implements ModalInterface {
    private string $modal_id;
    private array $data;
    private array $options;

    public function __construct(string $modal_id, array $data = [], array $options = []) {
        $this->modal_id = $modal_id;
        $this->data = $data;
        $this->options = array_merge([
            'title' => __('Training Persona', 'athlete-dashboard-child'),
            'submitText' => __('Save Training Persona', 'athlete-dashboard-child'),
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
        <div class="training-persona-modal-content">
            <form id="<?php echo esc_attr($this->modal_id); ?>-form" class="training-persona-form">
                <?php wp_nonce_field('training_persona_nonce', 'training_persona_nonce'); ?>
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
            'class' => 'training-persona-feature-modal',
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
            'styles' => ['training-persona-feature', 'training-persona-modal'],
            'scripts' => ['training-persona-modal']
        ];
    }

    private function render_fields(): void {
        ?>
        <div class="form-field">
            <label for="training_level" class="field-label">
                <?php _e('Training Level', 'athlete-dashboard-child'); ?>
                <span class="required">*</span>
            </label>
            <select id="training_level" name="training_level" class="form-select" required>
                <option value=""><?php _e('Select your training level', 'athlete-dashboard-child'); ?></option>
                <option value="beginner" <?php selected($this->data['training_level'] ?? '', 'beginner'); ?>>
                    <?php _e('Beginner', 'athlete-dashboard-child'); ?>
                </option>
                <option value="intermediate" <?php selected($this->data['training_level'] ?? '', 'intermediate'); ?>>
                    <?php _e('Intermediate', 'athlete-dashboard-child'); ?>
                </option>
                <option value="advanced" <?php selected($this->data['training_level'] ?? '', 'advanced'); ?>>
                    <?php _e('Advanced', 'athlete-dashboard-child'); ?>
                </option>
            </select>
        </div>

        <div class="form-field">
            <label for="training_frequency" class="field-label">
                <?php _e('Training Frequency', 'athlete-dashboard-child'); ?>
                <span class="required">*</span>
            </label>
            <select id="training_frequency" name="training_frequency" class="form-select" required>
                <option value=""><?php _e('Select training frequency', 'athlete-dashboard-child'); ?></option>
                <option value="1-2" <?php selected($this->data['training_frequency'] ?? '', '1-2'); ?>>
                    <?php _e('1-2 times per week', 'athlete-dashboard-child'); ?>
                </option>
                <option value="3-4" <?php selected($this->data['training_frequency'] ?? '', '3-4'); ?>>
                    <?php _e('3-4 times per week', 'athlete-dashboard-child'); ?>
                </option>
                <option value="5+" <?php selected($this->data['training_frequency'] ?? '', '5+'); ?>>
                    <?php _e('5+ times per week', 'athlete-dashboard-child'); ?>
                </option>
            </select>
        </div>

        <div class="form-field">
            <label for="training_goals" class="field-label">
                <?php _e('Training Goals', 'athlete-dashboard-child'); ?>
                <span class="required">*</span>
            </label>
            <select id="training_goals" name="training_goals[]" class="form-multi-select" multiple required>
                <?php
                $goals = [
                    'strength' => __('Build Strength', 'athlete-dashboard-child'),
                    'endurance' => __('Improve Endurance', 'athlete-dashboard-child'),
                    'flexibility' => __('Increase Flexibility', 'athlete-dashboard-child'),
                    'weight_loss' => __('Weight Loss', 'athlete-dashboard-child'),
                    'muscle_gain' => __('Muscle Gain', 'athlete-dashboard-child'),
                    'overall_fitness' => __('Overall Fitness', 'athlete-dashboard-child')
                ];
                $selected_goals = $this->data['training_goals'] ?? [];
                foreach ($goals as $value => $label):
                ?>
                    <option value="<?php echo esc_attr($value); ?>" 
                            <?php selected(in_array($value, $selected_goals), true); ?>>
                        <?php echo esc_html($label); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-field">
            <label for="preferred_training_time" class="field-label">
                <?php _e('Preferred Training Time', 'athlete-dashboard-child'); ?>
            </label>
            <select id="preferred_training_time" name="preferred_training_time" class="form-select">
                <option value=""><?php _e('Select preferred time', 'athlete-dashboard-child'); ?></option>
                <option value="morning" <?php selected($this->data['preferred_training_time'] ?? '', 'morning'); ?>>
                    <?php _e('Morning', 'athlete-dashboard-child'); ?>
                </option>
                <option value="afternoon" <?php selected($this->data['preferred_training_time'] ?? '', 'afternoon'); ?>>
                    <?php _e('Afternoon', 'athlete-dashboard-child'); ?>
                </option>
                <option value="evening" <?php selected($this->data['preferred_training_time'] ?? '', 'evening'); ?>>
                    <?php _e('Evening', 'athlete-dashboard-child'); ?>
                </option>
            </select>
        </div>

        <div class="form-field">
            <label for="additional_notes" class="field-label">
                <?php _e('Additional Notes', 'athlete-dashboard-child'); ?>
            </label>
            <textarea id="additional_notes" 
                      name="additional_notes" 
                      class="form-textarea" 
                      rows="4"><?php echo esc_textarea($this->data['additional_notes'] ?? ''); ?></textarea>
        </div>
        <?php
    }

    public function render(): void {
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
        if (!is_page_template('dashboard.php')) {
            return;
        }

        // Enqueue feature-specific styles
        wp_enqueue_style(
            'training-persona-feature',
            get_stylesheet_directory_uri() . '/features/training-persona/assets/css/training-persona.css',
            [],
            '1.0.0'
        );

        // Enqueue modal-specific styles
        wp_enqueue_style(
            'training-persona-modal',
            get_stylesheet_directory_uri() . '/features/training-persona/assets/css/training-persona-modal.css',
            [],
            '1.0.0'
        );

        // Enqueue modal-specific scripts
        wp_enqueue_script(
            'training-persona-modal',
            get_stylesheet_directory_uri() . '/features/training-persona/assets/js/training-persona-modal.js',
            ['jquery'],
            '1.0.0',
            true
        );

        // Localize script
        wp_localize_script('training-persona-modal', 'trainingPersonaConfig', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('training_persona_nonce')
        ]);
    }
} 