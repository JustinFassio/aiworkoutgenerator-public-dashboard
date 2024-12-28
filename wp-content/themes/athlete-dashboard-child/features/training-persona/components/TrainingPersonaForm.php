<?php
/**
 * Training Persona Form Component
 * 
 * Handles the rendering and functionality of training persona forms.
 */

namespace AthleteDashboard\Features\TrainingPersona\Components;

if (!defined('ABSPATH')) {
    exit;
}

class TrainingPersonaForm {
    private string $form_id;
    private array $fields;
    private array $data;
    private array $options;

    public function __construct(string $form_id, array $fields = [], array $data = [], array $options = []) {
        $this->form_id = $form_id;
        $this->fields = $fields;
        $this->data = $data;
        $this->options = array_merge([
            'context' => 'default',
            'submitText' => __('Save', 'athlete-dashboard-child')
        ], $options);
    }

    public function render(): void {
        try {
            $template_path = get_stylesheet_directory() . '/features/training-persona/templates/training-persona-form.php';
            if (!file_exists($template_path)) {
                throw new \Exception('Training persona form template not found');
            }

            // Setup template variables
            $fields = $this->fields;
            $data = $this->data;
            $context = $this->options['context'];
            
            // Include the template
            include $template_path;
        } catch (\Exception $e) {
            error_log('Failed to render training persona form: ' . $e->getMessage());
            echo '<div class="error">Failed to load training persona form. Please try again later.</div>';
        }
    }

    public function getFormId(): string {
        return $this->form_id;
    }

    public function getFields(): array {
        return $this->fields;
    }

    public function getData(): array {
        return $this->data;
    }

    public function getOptions(): array {
        return $this->options;
    }
} 