<?php
/**
 * Training Persona Form Component
 * 
 * Handles the rendering and functionality of training persona forms.
 */

namespace AthleteDashboard\Features\TrainingPersona\Components;

use AthleteDashboard\Dashboard\Components\Form;

class TrainingPersonaForm extends Form {
    private $data;
    private $context;

    public function __construct(array $data = [], string $context = 'modal') {
        $this->data = $data;
        $this->context = $context;
        parent::__construct(
            'training-persona-form',
            [
                'method' => 'post',
                'action' => admin_url('admin-ajax.php'),
                'data-form-context' => $context
            ],
            'training-persona-form'
        );
    }

    protected function getContent(): string {
        wp_nonce_field('training_persona_action', 'training_persona_nonce');
        
        $fields = $this->renderFields();
        $actions = $this->renderActions();

        return sprintf(
            '<div class="form-grid">%s</div><div class="form-actions">%s</div>',
            $fields,
            $actions
        );
    }

    private function renderFields(): string {
        $level = $this->data['level'] ?? 'beginner';
        $duration = $this->data['preferences']['workoutDuration'] ?? 60;
        $frequency = $this->data['preferences']['workoutFrequency'] ?? 3;
        
        return sprintf(
            '<div class="form-field">
                <label for="training_level">%s</label>
                <select name="training_level" id="training_level" required>
                    <option value="beginner" %s>%s</option>
                    <option value="intermediate" %s>%s</option>
                    <option value="advanced" %s>%s</option>
                </select>
            </div>
            <div class="form-field">
                <label for="workout_duration">%s</label>
                <input type="number" name="workout_duration" id="workout_duration"
                    value="%d" min="15" max="180" step="15" required>
            </div>
            <div class="form-field">
                <label for="workout_frequency">%s</label>
                <input type="number" name="workout_frequency" id="workout_frequency"
                    value="%d" min="1" max="7" required>
            </div>',
            esc_html__('Training Level', 'athlete-dashboard'),
            selected($level, 'beginner', false),
            esc_html__('Beginner', 'athlete-dashboard'),
            selected($level, 'intermediate', false),
            esc_html__('Intermediate', 'athlete-dashboard'),
            selected($level, 'advanced', false),
            esc_html__('Advanced', 'athlete-dashboard'),
            esc_html__('Workout Duration (minutes)', 'athlete-dashboard'),
            esc_attr($duration),
            esc_html__('Weekly Frequency', 'athlete-dashboard'),
            esc_attr($frequency)
        );
    }

    private function renderActions(): string {
        $actions = [];

        if ($this->context === 'modal') {
            $actions[] = sprintf(
                '<button type="button" class="button button-secondary modal-close">%s</button>',
                esc_html__('Cancel', 'athlete-dashboard')
            );
        }

        $actions[] = sprintf(
            '<button type="submit" class="button button-primary">%s</button>',
            esc_html__('Save Changes', 'athlete-dashboard')
        );

        return implode('', $actions);
    }

    public static function create(array $data = [], string $context = 'modal'): self {
        return new static($data, $context);
    }
} 