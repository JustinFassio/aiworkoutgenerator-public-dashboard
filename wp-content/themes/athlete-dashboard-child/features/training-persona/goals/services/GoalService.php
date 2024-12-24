<?php
/**
 * Goal Service
 * 
 * Handles goal tracking operations and data management.
 */

namespace AthleteDashboard\Features\TrainingPersona\Goals\Services;

if (!defined('ABSPATH')) {
    exit;
}

class GoalService {
    public function trackProgress(int $user_id, string $goal_id, float $progress): bool {
        try {
            $progress_data = get_user_meta($user_id, 'training_goals_progress', true);
            if (!is_array($progress_data)) {
                $progress_data = [];
            }

            // Ensure progress is between 0 and 100
            $progress = min(100, max(0, $progress));

            $progress_data[$goal_id] = [
                'value' => $progress,
                'updated_at' => current_time('mysql')
            ];

            return update_user_meta($user_id, 'training_goals_progress', $progress_data);
        } catch (\Exception $e) {
            error_log('Failed to track goal progress: ' . $e->getMessage());
            return false;
        }
    }

    public function getProgress(int $user_id, ?string $goal_id = null): array {
        try {
            $progress_data = get_user_meta($user_id, 'training_goals_progress', true);
            if (!is_array($progress_data)) {
                return [];
            }

            if ($goal_id !== null) {
                return $progress_data[$goal_id] ?? [
                    'value' => 0,
                    'updated_at' => current_time('mysql')
                ];
            }

            return $progress_data;
        } catch (\Exception $e) {
            error_log('Failed to get goal progress: ' . $e->getMessage());
            return [];
        }
    }

    public function deleteProgress(int $user_id, string $goal_id): bool {
        try {
            $progress_data = get_user_meta($user_id, 'training_goals_progress', true);
            if (!is_array($progress_data)) {
                return true;
            }

            unset($progress_data[$goal_id]);
            return update_user_meta($user_id, 'training_goals_progress', $progress_data);
        } catch (\Exception $e) {
            error_log('Failed to delete goal progress: ' . $e->getMessage());
            return false;
        }
    }
} 