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
        // Generate height options in imperial format (4'0" to 8'0" in 1" increments)
        $height_options = [];
        for ($feet = 4; $feet <= 8; $feet++) {
            for ($inches = 0; $inches < 12; $inches++) {
                // Skip inches for 8 feet to cap at 8'0"
                if ($feet === 8 && $inches > 0) continue;
                
                $total_inches = ($feet * 12) + $inches;
                $height_options[$total_inches] = sprintf("%d'%d\"", $feet, $inches);
            }
        }

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
            'height' => [
                'type' => 'height_with_unit',
                'label' => 'Height',
                'required' => true,
                'imperial_options' => $height_options,
                'metric_range' => [
                    'min' => 120, // 4 feet in cm
                    'max' => 244  // 8 feet in cm
                ],
                'units' => [
                    'imperial' => 'in',
                    'metric' => 'cm'
                ],
                'validation' => function($value, $unit) {
                    if ($unit === 'imperial') {
                        return filter_var($value, FILTER_VALIDATE_INT) && $value >= 48 && $value <= 96;
                    } else {
                        return filter_var($value, FILTER_VALIDATE_INT) && $value >= 120 && $value <= 244;
                    }
                },
                'description' => 'Your height'
            ],
            'weight' => [
                'type' => 'weight_with_unit',
                'label' => 'Weight',
                'required' => true,
                'units' => [
                    'imperial' => 'lbs',
                    'metric' => 'kg'
                ],
                'validation' => function($value, $unit) {
                    $val = filter_var($value, FILTER_VALIDATE_FLOAT);
                    if (!$val) return false;
                    
                    if ($unit === 'imperial') {
                        return $val >= 50 && $val <= 500; // Reasonable lbs range
                    } else {
                        return $val >= 23 && $val <= 227; // Converted kg range
                    }
                },
                'description' => 'Your weight'
            ],
            'injuries' => [
                'type' => 'tag_input',
                'label' => 'Current Injuries',
                'required' => false,
                'predefined_options' => [
                    'lower_back' => 'Lower Back Pain or Injuries',
                    'knee' => 'Knee Pain or Injuries',
                    'shoulder' => 'Shoulder Pain or Injuries',
                    'hip' => 'Hip Pain or Injuries',
                    'neck' => 'Neck Pain or Injuries',
                    'wrist_elbow' => 'Wrist or Elbow Pain',
                    'ankle_foot' => 'Ankle or Foot Injuries'
                ],
                'validation' => function($value) {
                    if (empty($value)) return true;
                    
                    // Handle JSON string input
                    if (is_string($value)) {
                        $decoded = json_decode(stripslashes($value), true);
                        if (is_array($decoded)) {
                            $value = $decoded;
                        }
                    }
                    
                    if (!is_array($value)) return false;
                    
                    foreach ($value as $item) {
                        if (!is_array($item) || !isset($item['value'], $item['type'])) {
                            return false;
                        }
                        if ($item['type'] === 'predefined' && !isset($this->fields['injuries']['predefined_options'][$item['value']])) {
                            return false;
                        }
                    }
                    return true;
                },
                'description' => 'Select from common injuries or type your own. Press Enter or comma to add custom injuries.'
            ],
            'injuries_other' => [
                'type' => 'textarea',
                'label' => 'Describe Injuries',
                'required' => false,
                'validation' => fn($value) => empty($value) || (is_string($value) && strlen($value) <= 500),
                'maxlength' => 500,
                'rows' => 3,
                'description' => 'Provide additional details about your injuries, including severity and duration.'
            ]
        ];
    }

    private function validateData(array $data): array {
        $validated = [];
        foreach ($this->fields as $key => $field) {
            if (isset($data[$key])) {
                if (in_array($field['type'], ['height_with_unit', 'weight_with_unit'])) {
                    $value = $data[$key];
                    $unit = $data[$key . '_unit'] ?? 'imperial';
                    if (isset($field['validation']) && is_callable($field['validation'])) {
                        $validated[$key] = $field['validation']($value, $unit) ? $value : null;
                        $validated[$key . '_unit'] = $unit;
                    }
                } elseif ($field['type'] === 'multi_select') {
                    $value = is_array($data[$key]) ? $data[$key] : [$data[$key]];
                    $validated[$key] = $this->validateField($key, $value);
                } else {
                    $validated[$key] = $this->validateField($key, $data[$key]);
                }
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
            if (in_array($field['type'], ['height_with_unit', 'weight_with_unit'])) {
                return $field['validation']($value, $field['units']['imperial']) ? $value : null;
            }
            return $field['validation']($value) ? $value : null;
        }

        return $value;
    }
} 