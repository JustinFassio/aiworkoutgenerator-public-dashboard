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

        foreach (array_keys($fields) as $field) {
            $value = get_user_meta($user_id, $this->meta_prefix . $field, true);
            if ($value !== '') {
                $data[$field] = $value;
            }
        }

        return new ProfileData($data);
    }

    public function updateProfile(int $user_id, array $data): bool {
        $profile = new ProfileData($data);
        $unit_preference = $profile->get('unit_preference');

        try {
            foreach ($profile->toArray() as $field => $value) {
                if ($value === null) {
                    continue;
                }

                // Handle unit conversions
                if ($unit_preference === 'imperial') {
                    if ($field === 'height_cm') {
                        $value = $this->convertHeightToMetric(
                            intval($profile->get('height_feet')),
                            intval($profile->get('height_inches'))
                        );
                    } elseif ($field === 'weight_kg') {
                        $value = $this->convertWeightToMetric(
                            floatval($profile->get('weight_lbs'))
                        );
                    }
                } elseif ($unit_preference === 'metric') {
                    if ($field === 'height_feet' || $field === 'height_inches') {
                        $imperial = $this->convertHeightToImperial(
                            intval($profile->get('height_cm'))
                        );
                        $value = $field === 'height_feet' ? $imperial['feet'] : $imperial['inches'];
                    } elseif ($field === 'weight_lbs') {
                        $value = $this->convertWeightToImperial(
                            floatval($profile->get('weight_kg'))
                        );
                    }
                }

                update_user_meta($user_id, $this->meta_prefix . $field, $value);
            }
            return true;
        } catch (\Exception $e) {
            error_log('Profile update failed: ' . $e->getMessage());
            return false;
        }
    }

    private function convertHeightToMetric(int $feet, int $inches): int {
        $total_inches = ($feet * 12) + $inches;
        return round($total_inches * 2.54);
    }

    private function convertHeightToImperial(int $cm): array {
        $total_inches = round($cm / 2.54);
        return [
            'feet' => floor($total_inches / 12),
            'inches' => $total_inches % 12
        ];
    }

    private function convertWeightToMetric(float $lbs): float {
        return round($lbs * 0.453592, 1);
    }

    private function convertWeightToImperial(float $kg): float {
        return round($kg * 2.20462, 1);
    }
} 