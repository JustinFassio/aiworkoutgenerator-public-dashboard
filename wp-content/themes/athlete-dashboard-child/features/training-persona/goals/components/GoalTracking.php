<?php
/**
 * Goal Tracking Component
 * 
 * Handles goal tracking functionality and rendering.
 */

namespace AthleteDashboard\Features\TrainingPersona\Goals\Components;

use AthleteDashboard\Features\TrainingPersona\Goals\Services\GoalService;
use AthleteDashboard\Features\TrainingPersona\Goals\Models\Goal;

if (!defined('ABSPATH')) {
    exit;
}

class GoalTracking {
    private GoalService $service;

    public function __construct() {
        $this->service = new GoalService();
    }

    public function render(array $goals): void {
        try {
            include get_stylesheet_directory() . '/features/training-persona/goals/templates/goal-tracking.php';
        } catch (\Exception $e) {
            error_log('Failed to render goal tracking: ' . $e->getMessage());
            echo '<div class="error">Failed to load goal tracking. Please try again later.</div>';
        }
    }

    public function handleAjaxTrackGoal(): void {
        check_ajax_referer('goal_nonce', 'nonce');

        $user_id = get_current_user_id();
        if (!$user_id) {
            wp_send_json_error([
                'message' => __('User not logged in', 'athlete-dashboard-child')
            ]);
            return;
        }

        if (!isset($_POST['goal_id'], $_POST['progress'])) {
            wp_send_json_error([
                'message' => __('Missing required parameters', 'athlete-dashboard-child')
            ]);
            return;
        }

        $goal_id = sanitize_text_field($_POST['goal_id']);
        $progress = floatval($_POST['progress']);

        try {
            $result = $this->service->trackProgress($user_id, $goal_id, $progress);
            if ($result) {
                wp_send_json_success([
                    'message' => __('Progress updated successfully', 'athlete-dashboard-child'),
                    'goal_id' => $goal_id,
                    'progress' => $progress
                ]);
            } else {
                wp_send_json_error([
                    'message' => __('Failed to update progress', 'athlete-dashboard-child')
                ]);
            }
        } catch (\Exception $e) {
            error_log('Failed to track goal progress: ' . $e->getMessage());
            wp_send_json_error([
                'message' => __('Failed to update progress', 'athlete-dashboard-child')
            ]);
        }
    }

    public function handleAjaxGetGoalProgress(): void {
        check_ajax_referer('goal_nonce', 'nonce');

        $user_id = get_current_user_id();
        if (!$user_id) {
            wp_send_json_error([
                'message' => __('User not logged in', 'athlete-dashboard-child')
            ]);
            return;
        }

        $goal_id = isset($_GET['goal_id']) ? sanitize_text_field($_GET['goal_id']) : null;

        try {
            $progress = $this->service->getProgress($user_id, $goal_id);
            wp_send_json_success([
                'progress' => $progress
            ]);
        } catch (\Exception $e) {
            error_log('Failed to get goal progress: ' . $e->getMessage());
            wp_send_json_error([
                'message' => __('Failed to get progress', 'athlete-dashboard-child')
            ]);
        }
    }

    public function handleAjaxDeleteGoalProgress(): void {
        check_ajax_referer('goal_nonce', 'nonce');

        $user_id = get_current_user_id();
        if (!$user_id) {
            wp_send_json_error([
                'message' => __('User not logged in', 'athlete-dashboard-child')
            ]);
            return;
        }

        if (!isset($_POST['goal_id'])) {
            wp_send_json_error([
                'message' => __('Missing goal ID', 'athlete-dashboard-child')
            ]);
            return;
        }

        $goal_id = sanitize_text_field($_POST['goal_id']);

        try {
            $result = $this->service->deleteProgress($user_id, $goal_id);
            if ($result) {
                wp_send_json_success([
                    'message' => __('Progress deleted successfully', 'athlete-dashboard-child'),
                    'goal_id' => $goal_id
                ]);
            } else {
                wp_send_json_error([
                    'message' => __('Failed to delete progress', 'athlete-dashboard-child')
                ]);
            }
        } catch (\Exception $e) {
            error_log('Failed to delete goal progress: ' . $e->getMessage());
            wp_send_json_error([
                'message' => __('Failed to delete progress', 'athlete-dashboard-child')
            ]);
        }
    }
} 