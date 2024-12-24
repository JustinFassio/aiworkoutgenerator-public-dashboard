<?php
/**
 * Injury Tracking Component
 * 
 * Handles injury tracking functionality including form rendering and AJAX operations.
 */

namespace AthleteDashboard\Features\Profile\Injuries\Components;

use AthleteDashboard\Features\Profile\Injuries\Services\InjuryService;
use AthleteDashboard\Features\Profile\Injuries\Models\Injury;

if (!defined('ABSPATH')) {
    exit;
}

class InjuryTracking {
    private InjuryService $service;

    public function __construct(InjuryService $service = null) {
        $this->service = $service ?? new InjuryService();
        $this->init();
    }

    private function init(): void {
        add_action('wp_ajax_track_injury', [$this, 'handleAjaxTrackInjury']);
        add_action('wp_ajax_get_injury_progress', [$this, 'handleAjaxGetInjuryProgress']);
        add_action('wp_ajax_delete_injury_progress', [$this, 'handleAjaxDeleteInjuryProgress']);
    }

    public function render_form(): void {
        try {
            $injuries = $this->service->getInjuryProgress();
            include dirname(__DIR__) . '/templates/injury-tracking.php';
        } catch (\Exception $e) {
            error_log('Failed to render injury tracking form: ' . $e->getMessage());
            echo '<div class="error">Failed to load injury tracking form. Please try again later.</div>';
        }
    }

    public function handleAjaxTrackInjury(): void {
        check_ajax_referer('injury_nonce', 'nonce');

        try {
            $injury_data = json_decode(stripslashes($_POST['injury_data']), true);
            if (!$injury_data || !is_array($injury_data)) {
                wp_send_json_error('Invalid injury data');
                return;
            }

            $injury_data['updated_at'] = current_time('mysql');
            $result = $this->service->trackInjury($injury_data);

            if ($result) {
                wp_send_json_success(['message' => 'Injury tracked successfully']);
            } else {
                wp_send_json_error(['message' => 'Failed to track injury']);
            }
        } catch (\Exception $e) {
            error_log('Failed to track injury: ' . $e->getMessage());
            wp_send_json_error(['message' => 'An error occurred while tracking injury']);
        }
    }

    public function handleAjaxGetInjuryProgress(): void {
        try {
            $injuries = $this->service->getInjuryProgress();
            wp_send_json_success($injuries);
        } catch (\Exception $e) {
            error_log('Failed to get injury progress: ' . $e->getMessage());
            wp_send_json_error(['message' => 'Failed to get injury progress']);
        }
    }

    public function handleAjaxDeleteInjuryProgress(): void {
        check_ajax_referer('injury_nonce', 'nonce');

        try {
            $injury_id = intval($_POST['injury_id']);
            $result = $this->service->deleteInjuryProgress($injury_id);

            if ($result) {
                wp_send_json_success(['message' => 'Injury progress deleted successfully']);
            } else {
                wp_send_json_error(['message' => 'Failed to delete injury progress']);
            }
        } catch (\Exception $e) {
            error_log('Failed to delete injury progress: ' . $e->getMessage());
            wp_send_json_error(['message' => 'An error occurred while deleting injury progress']);
        }
    }

    public function formatInjuryDescription(array $injuries): string {
        if (empty($injuries)) {
            return '';
        }

        $description = '';
        foreach ($injuries as $injury) {
            $description .= strtoupper($injury['label']) . ":\n";
            $description .= ($injury['description'] ?? '[Add description here]') . "\n\n";
        }

        return rtrim($description);
    }
} 