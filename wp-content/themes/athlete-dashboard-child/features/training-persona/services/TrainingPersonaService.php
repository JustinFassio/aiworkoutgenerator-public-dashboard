<?php
/**
 * Training Persona Service
 * 
 * Handles data operations for the training persona feature.
 */

namespace AthleteDashboard\Features\TrainingPersona\Services;

use AthleteDashboard\Features\TrainingPersona\Models\TrainingPersonaData;

if (!defined('ABSPATH')) {
    exit;
}

class TrainingPersonaService {
    private string $meta_prefix = '_training_persona_';
    
    public function getPersonaData(int $user_id = null): TrainingPersonaData {
        if (!$user_id) {
            $user_id = get_current_user_id();
        }

        $data = [];
        $persona = new TrainingPersonaData();
        $fields = $persona->getFields();

        foreach ($fields as $field => $config) {
            if ($config['type'] === 'height_with_unit') {
                $unit = get_user_meta($user_id, $this->meta_prefix . 'height_unit', true) ?: 'imperial';
                if ($unit === 'imperial') {
                    $data[$field] = get_user_meta($user_id, $this->meta_prefix . 'height_imperial', true);
                } else {
                    $data[$field] = get_user_meta($user_id, $this->meta_prefix . 'height_cm', true);
                }
                $data[$field . '_unit'] = $unit;
            }
            elseif ($config['type'] === 'weight_with_unit') {
                $unit = get_user_meta($user_id, $this->meta_prefix . 'weight_unit', true) ?: 'imperial';
                if ($unit === 'imperial') {
                    $data[$field] = get_user_meta($user_id, $this->meta_prefix . 'weight_lbs', true);
                } else {
                    $data[$field] = get_user_meta($user_id, $this->meta_prefix . 'weight_kg', true);
                }
                $data[$field . '_unit'] = $unit;
            }
            elseif ($config['type'] === 'tag_input') {
                // Get raw meta value first
                $raw_value = get_user_meta($user_id, $this->meta_prefix . $field, true);
                error_log('Raw meta value for ' . $field . ': ' . print_r($raw_value, true)); // Debug log
                
                // Handle potential JSON string
                if (is_string($raw_value) && !empty($raw_value)) {
                    $decoded = json_decode($raw_value, true);
                    $data[$field] = is_array($decoded) ? $decoded : [$raw_value];
                } else {
                    $data[$field] = is_array($raw_value) ? $raw_value : [];
                }
                
                error_log('Processed value for ' . $field . ': ' . print_r($data[$field], true)); // Debug log
            }
            elseif ($config['type'] === 'multi_select') {
                // Get raw meta value first
                $raw_value = get_user_meta($user_id, $this->meta_prefix . $field, true);
                error_log('Raw meta value for ' . $field . ': ' . print_r($raw_value, true)); // Debug log
                
                // Handle potential serialized data
                if (is_string($raw_value) && !empty($raw_value)) {
                    $unserialized = maybe_unserialize($raw_value);
                    $data[$field] = is_array($unserialized) ? $unserialized : [$raw_value];
                } else {
                    $data[$field] = is_array($raw_value) ? $raw_value : [];
                }
                
                error_log('Processed value for ' . $field . ': ' . print_r($data[$field], true)); // Debug log
            }
            else {
                $value = get_user_meta($user_id, $this->meta_prefix . $field, true);
                if ($value !== '') {
                    $data[$field] = $value;
                }
            }
        }

        return new TrainingPersonaData($data);
    }

    public function updatePersona(int $user_id, array $data): bool {
        try {
            $persona = new TrainingPersonaData($data);
            
            foreach ($persona->toArray() as $field => $value) {
                if ($value === null) {
                    continue;
                }

                $field_config = $persona->getFields()[$field] ?? null;
                if (!$field_config) {
                    continue;
                }

                if ($field_config['type'] === 'height_with_unit') {
                    $unit = $data[$field . '_unit'] ?? 'imperial';
                    $stored_value = $value;
                    
                    if ($unit === 'imperial') {
                        update_user_meta($user_id, $this->meta_prefix . 'height_imperial', $value);
                        $stored_value = $this->convertHeightToMetric($value);
                    } else {
                        update_user_meta($user_id, $this->meta_prefix . 'height_imperial', $this->convertHeightToImperial($value)['total_inches']);
                        $stored_value = $value;
                    }
                    update_user_meta($user_id, $this->meta_prefix . 'height_cm', $stored_value);
                    update_user_meta($user_id, $this->meta_prefix . 'height_unit', $unit);
                }
                elseif ($field_config['type'] === 'weight_with_unit') {
                    $unit = $data[$field . '_unit'] ?? 'imperial';
                    $stored_value = $value;
                    
                    if ($unit === 'imperial') {
                        update_user_meta($user_id, $this->meta_prefix . 'weight_lbs', $value);
                        $stored_value = $this->convertWeightToMetric($value);
                    } else {
                        update_user_meta($user_id, $this->meta_prefix . 'weight_lbs', $this->convertWeightToImperial($value));
                        $stored_value = $value;
                    }
                    update_user_meta($user_id, $this->meta_prefix . 'weight_kg', $stored_value);
                    update_user_meta($user_id, $this->meta_prefix . 'weight_unit', $unit);
                }
                elseif ($field_config['type'] === 'tag_input') {
                    // Ensure we have a clean value
                    if (is_string($value) && !empty($value)) {
                        // Try to decode if it's a JSON string
                        $decoded = json_decode(stripslashes($value), true);
                        $clean_value = is_array($decoded) ? $decoded : [$value];
                    } else {
                        $clean_value = is_array($value) ? array_values(array_filter($value)) : [];
                    }
                    
                    error_log('Saving tag input value: ' . print_r($clean_value, true)); // Debug log
                    
                    // Delete existing meta first to ensure clean state
                    delete_user_meta($user_id, $this->meta_prefix . $field);
                    
                    // Save as JSON string
                    if (!empty($clean_value)) {
                        update_user_meta($user_id, $this->meta_prefix . $field, json_encode($clean_value));
                    }
                }
                elseif ($field_config['type'] === 'multi_select') {
                    // Ensure we have an array and clean it
                    $clean_value = is_array($value) ? array_values(array_filter($value)) : [];
                    error_log('Saving multi-select value: ' . print_r($clean_value, true)); // Debug log
                    
                    // Delete existing meta first to ensure clean state
                    delete_user_meta($user_id, $this->meta_prefix . $field);
                    
                    // Save as a single serialized value
                    if (!empty($clean_value)) {
                        update_user_meta($user_id, $this->meta_prefix . $field, $clean_value);
                    }
                }
                else {
                    update_user_meta($user_id, $this->meta_prefix . $field, $value);
                }
            }
            return true;
        } catch (\Exception $e) {
            error_log('Failed to update training persona: ' . $e->getMessage());
            return false;
        }
    }

    public function deletePersona(int $user_id): bool {
        try {
            $persona = new TrainingPersonaData();
            $fields = $persona->getFields();
            
            foreach ($fields as $field => $config) {
                delete_user_meta($user_id, $this->meta_prefix . $field);
                
                // Clean up unit-specific fields
                if ($config['type'] === 'height_with_unit') {
                    delete_user_meta($user_id, $this->meta_prefix . 'height_unit');
                    delete_user_meta($user_id, $this->meta_prefix . 'height_imperial');
                    delete_user_meta($user_id, $this->meta_prefix . 'height_cm');
                }
                elseif ($config['type'] === 'weight_with_unit') {
                    delete_user_meta($user_id, $this->meta_prefix . 'weight_unit');
                    delete_user_meta($user_id, $this->meta_prefix . 'weight_lbs');
                    delete_user_meta($user_id, $this->meta_prefix . 'weight_kg');
                }
            }
            return true;
        } catch (\Exception $e) {
            error_log('Failed to delete training persona: ' . $e->getMessage());
            return false;
        }
    }

    private function convertHeightToMetric(int $total_inches): int {
        return round($total_inches * 2.54);
    }

    private function convertHeightToImperial(int $cm): array {
        $total_inches = round($cm / 2.54);
        return [
            'feet' => floor($total_inches / 12),
            'inches' => $total_inches % 12,
            'total_inches' => $total_inches
        ];
    }

    private function convertWeightToMetric(float $lbs): float {
        return round($lbs * 0.453592, 1);
    }

    private function convertWeightToImperial(float $kg): float {
        return round($kg * 2.20462, 1);
    }
} 