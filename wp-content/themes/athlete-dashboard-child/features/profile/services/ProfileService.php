<?php
/**
 * Profile Service
 * 
 * Handles all profile-related business logic including data operations
 * and unit conversions.
 */

namespace AthleteDashboard\Features\Profile\Services;

use AthleteDashboard\Features\Profile\Models\ProfileData;

if (!defined('ABSPATH')) {
    exit;
}

class ProfileService {
    private string $meta_prefix = '_athlete_';
    
    public function getProfileData(int $user_id = null): ProfileData {
        if (!$user_id) {
            $user_id = get_current_user_id();
        }

        $data = [];
        $profile = new ProfileData();
        $fields = $profile->getFields();

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
            else {
                $value = get_user_meta($user_id, $this->meta_prefix . $field, true);
                if ($value !== '') {
                    $data[$field] = $value;
                }
            }
        }

        return new ProfileData($data);
    }

    public function updateProfile(int $user_id, array $data): bool {
        $profile = new ProfileData($data);
        
        try {
            foreach ($profile->toArray() as $field => $value) {
                if ($value === null) {
                    continue;
                }

                // Handle unit conversions and storage
                if (strpos($field, '_unit') !== false) {
                    continue; // Skip unit fields, they're handled with their main field
                }

                $field_config = $profile->getFields()[$field] ?? null;
                if (!$field_config) {
                    continue;
                }

                if ($field_config['type'] === 'height_with_unit') {
                    $unit = $data[$field . '_unit'] ?? 'imperial';
                    $stored_value = $value;
                    
                    // Always store both imperial and metric values
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
                    
                    // Always store both imperial and metric values
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
                else {
                    update_user_meta($user_id, $this->meta_prefix . $field, $value);
                }
            }
            return true;
        } catch (\Exception $e) {
            error_log('Profile update failed: ' . $e->getMessage());
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