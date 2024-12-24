<?php
/**
 * Injury Service
 * 
 * Handles injury-related data operations and business logic.
 */

namespace AthleteDashboard\Features\Profile\Injuries\Services;

use AthleteDashboard\Features\Profile\Injuries\Models\Injury;

if (!defined('ABSPATH')) {
    exit;
}

class InjuryService {
    private string $meta_key = '_athlete_injury_progress';

    public function trackInjury(array $injury_data): bool {
        try {
            $user_id = get_current_user_id();
            if (!$user_id) {
                return false;
            }

            $injuries = $this->getInjuryProgress();
            
            // If injury has an ID, update existing entry
            if (isset($injury_data['id'])) {
                $injuries = array_map(function($injury) use ($injury_data) {
                    if ($injury['id'] === $injury_data['id']) {
                        return $injury_data;
                    }
                    return $injury;
                }, $injuries);
            } else {
                // Add new injury with unique ID
                $injury_data['id'] = $this->generateUniqueId($injuries);
                $injuries[] = $injury_data;
            }

            return update_user_meta($user_id, $this->meta_key, $injuries);
        } catch (\Exception $e) {
            error_log('Failed to track injury: ' . $e->getMessage());
            return false;
        }
    }

    public function getInjuryProgress(): array {
        try {
            $user_id = get_current_user_id();
            if (!$user_id) {
                return [];
            }

            $injuries = get_user_meta($user_id, $this->meta_key, true);
            return is_array($injuries) ? $injuries : [];
        } catch (\Exception $e) {
            error_log('Failed to get injury progress: ' . $e->getMessage());
            return [];
        }
    }

    public function deleteInjuryProgress(int $injury_id): bool {
        try {
            $user_id = get_current_user_id();
            if (!$user_id) {
                return false;
            }

            $injuries = $this->getInjuryProgress();
            $filtered_injuries = array_filter($injuries, function($injury) use ($injury_id) {
                return $injury['id'] !== $injury_id;
            });

            if (count($filtered_injuries) === count($injuries)) {
                return false; // No injury was removed
            }

            return update_user_meta($user_id, $this->meta_key, array_values($filtered_injuries));
        } catch (\Exception $e) {
            error_log('Failed to delete injury progress: ' . $e->getMessage());
            return false;
        }
    }

    private function generateUniqueId(array $injuries): int {
        $max_id = 0;
        foreach ($injuries as $injury) {
            if (isset($injury['id']) && $injury['id'] > $max_id) {
                $max_id = $injury['id'];
            }
        }
        return $max_id + 1;
    }
} 