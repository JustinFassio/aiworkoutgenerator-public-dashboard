<?php
/**
 * Profile Data Model
 * 
 * Defines the structure and validation for profile fields.
 */

namespace AthleteDashboard\Features\Profile\Models;

if (!defined('ABSPATH')) {
    exit;
}

class ProfileData {
    private array $data;
    private array $fields;

    public function __construct(array $data = []) {
        $this->fields = $this->defineFields();
        $this->data = $this->validateData($data);
    }

    public function get(string $key) {
        return $this->data[$key] ?? null;
    }

    public function set(string $key, $value): void {
        if (isset($this->fields[$key])) {
            $this->data[$key] = $this->validateField($key, $value);
        }
    }

    public function toArray(): array {
        return $this->data;
    }

    public function getFields(): array {
        return $this->fields;
    }

    private function defineFields(): array {
        return [
            'age' => [
                'type' => 'number',
                'label' => 'Age',
                'required' => true,
                'validation' => fn($value) => filter_var($value, FILTER_VALIDATE_INT),
                'description' => 'Your current age'
            ],
            'gender' => [
                'type' => 'select',
                'label' => 'Gender',
                'options' => [
                    'male' => 'Male',
                    'female' => 'Female',
                    'other' => 'Other'
                ],
                'required' => true,
                'validation' => fn($value) => in_array($value, ['male', 'female', 'other']),
                'description' => 'Your gender'
            ],
            'height_feet' => [
                'type' => 'select',
                'label' => 'Height (ft)',
                'options' => array_combine(
                    range(4, 8),
                    array_map(fn($ft) => $ft . ' ft', range(4, 8))
                ),
                'required' => true,
                'group' => 'height',
                'validation' => fn($value) => filter_var($value, FILTER_VALIDATE_INT) && $value >= 4 && $value <= 8,
                'description' => 'Your height in feet'
            ],
            'height_inches' => [
                'type' => 'select',
                'label' => 'Height (in)',
                'options' => array_combine(
                    range(0, 11),
                    array_map(fn($in) => $in . ' in', range(0, 11))
                ),
                'required' => true,
                'group' => 'height',
                'validation' => fn($value) => filter_var($value, FILTER_VALIDATE_INT) && $value >= 0 && $value <= 11,
                'description' => 'Additional inches'
            ],
            'weight_lbs' => [
                'type' => 'number',
                'label' => 'Weight (lbs)',
                'required' => true,
                'group' => 'weight',
                'validation' => fn($value) => filter_var($value, FILTER_VALIDATE_FLOAT) && $value > 0,
                'description' => 'Your weight in pounds'
            ],
            'unit_preference' => [
                'type' => 'select',
                'label' => 'Preferred Units',
                'options' => [
                    'imperial' => 'Imperial (lbs/ft)',
                    'metric' => 'Metric (kg/cm)'
                ],
                'required' => true,
                'default' => 'imperial',
                'validation' => fn($value) => in_array($value, ['imperial', 'metric']),
                'description' => 'Your preferred unit system'
            ]
        ];
    }

    private function validateData(array $data): array {
        $validated = [];
        foreach ($this->fields as $key => $field) {
            if (isset($data[$key])) {
                $validated[$key] = $this->validateField($key, $data[$key]);
            } elseif (isset($field['default'])) {
                $validated[$key] = $field['default'];
            } elseif ($field['required']) {
                $validated[$key] = null;
            }
        }
        return $validated;
    }

    private function validateField(string $key, $value) {
        if (!isset($this->fields[$key])) {
            return null;
        }

        $field = $this->fields[$key];
        if (isset($field['validation']) && is_callable($field['validation'])) {
            return $field['validation']($value) ? $value : null;
        }

        return $value;
    }
} 