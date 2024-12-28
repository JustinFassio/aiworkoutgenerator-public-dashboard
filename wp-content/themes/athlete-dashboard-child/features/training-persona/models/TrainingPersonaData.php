<?php
/**
 * Training Persona Data Model
 * 
 * Defines the structure and validation for training persona data.
 */

namespace AthleteDashboard\Features\TrainingPersona\Models;

if (!defined('ABSPATH')) {
    exit;
}

class TrainingPersonaData {
    private array $data;
    private array $fields;

    public function __construct(array $data = []) {
        $this->fields = $this->defineFields();
        $this->data = $this->validateData($data);
    }

    private function defineFields(): array {
        return [
            'training_level' => [
                'type' => 'select',
                'label' => __('Training Level', 'athlete-dashboard-child'),
                'required' => true,
                'options' => [
                    'beginner' => __('Beginner', 'athlete-dashboard-child'),
                    'intermediate' => __('Intermediate', 'athlete-dashboard-child'),
                    'advanced' => __('Advanced', 'athlete-dashboard-child')
                ]
            ],
            'training_frequency' => [
                'type' => 'select',
                'label' => __('Training Frequency', 'athlete-dashboard-child'),
                'required' => true,
                'options' => [
                    '1-2' => __('1-2 times per week', 'athlete-dashboard-child'),
                    '3-4' => __('3-4 times per week', 'athlete-dashboard-child'),
                    '5+' => __('5+ times per week', 'athlete-dashboard-child')
                ]
            ],
            'training_goals' => [
                'type' => 'multi_select',
                'label' => __('Training Goals', 'athlete-dashboard-child'),
                'required' => true,
                'options' => [
                    'strength' => __('Build Strength', 'athlete-dashboard-child'),
                    'endurance' => __('Improve Endurance', 'athlete-dashboard-child'),
                    'flexibility' => __('Increase Flexibility', 'athlete-dashboard-child'),
                    'weight_loss' => __('Weight Loss', 'athlete-dashboard-child'),
                    'muscle_gain' => __('Muscle Gain', 'athlete-dashboard-child'),
                    'overall_fitness' => __('Overall Fitness', 'athlete-dashboard-child')
                ]
            ],
            'preferred_training_time' => [
                'type' => 'select',
                'label' => __('Preferred Training Time', 'athlete-dashboard-child'),
                'required' => false,
                'options' => [
                    'morning' => __('Morning', 'athlete-dashboard-child'),
                    'afternoon' => __('Afternoon', 'athlete-dashboard-child'),
                    'evening' => __('Evening', 'athlete-dashboard-child')
                ]
            ],
            'additional_notes' => [
                'type' => 'textarea',
                'label' => __('Additional Notes', 'athlete-dashboard-child'),
                'required' => false,
                'rows' => 4
            ]
        ];
    }

    private function validateData(array $data): array {
        $validated = [];

        foreach ($this->fields as $field => $config) {
            // Initialize with empty value if not set
            if (!isset($data[$field])) {
                $data[$field] = '';
            }

            $value = $data[$field];

            // Skip validation for empty values if not required
            if (empty($value) && empty($config['required'])) {
                continue;
            }

            // Validate based on field type
            switch ($config['type']) {
                case 'select':
                    if (!empty($value) && isset($config['options'][$value])) {
                        $validated[$field] = $value;
                    } elseif (!empty($config['required'])) {
                        $validated[$field] = array_key_first($config['options']);
                    }
                    break;

                case 'multi_select':
                    if (is_array($value)) {
                        $valid_values = array_intersect($value, array_keys($config['options']));
                        if (!empty($valid_values)) {
                            $validated[$field] = array_values($valid_values);
                        } elseif (!empty($config['required'])) {
                            $validated[$field] = [array_key_first($config['options'])];
                        }
                    } elseif (!empty($config['required'])) {
                        $validated[$field] = [array_key_first($config['options'])];
                    }
                    break;

                case 'textarea':
                    if (is_string($value)) {
                        $validated[$field] = sanitize_textarea_field($value);
                    } elseif (!empty($config['required'])) {
                        $validated[$field] = '';
                    }
                    break;
            }

            // Handle required fields that weren't set
            if (!empty($config['required']) && !isset($validated[$field])) {
                switch ($config['type']) {
                    case 'select':
                        $validated[$field] = array_key_first($config['options']);
                        break;
                    case 'multi_select':
                        $validated[$field] = [array_key_first($config['options'])];
                        break;
                    default:
                        $validated[$field] = '';
                }
            }
        }

        return $validated;
    }

    public function get(string $field) {
        return $this->data[$field] ?? null;
    }

    public function getFields(): array {
        return $this->fields;
    }

    public function toArray(): array {
        return $this->data;
    }
} 