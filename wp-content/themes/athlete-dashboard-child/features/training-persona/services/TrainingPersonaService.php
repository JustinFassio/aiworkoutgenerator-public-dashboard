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
            if ($config['type'] === 'tag_input') {
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

                if ($field_config['type'] === 'tag_input') {
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
        $persona = new TrainingPersonaData();
        $fields = $persona->getFields();
        
        foreach ($fields as $field => $config) {
            delete_user_meta($user_id, $this->meta_prefix . $field);
        }
        
        return true;
    }
} 