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
    private const META_KEY = 'training_persona_data';

    public function getPersonaData(int $user_id = null): TrainingPersonaData {
        if (!$user_id) {
            $user_id = get_current_user_id();
        }

        $data = get_user_meta($user_id, self::META_KEY, true);
        return new TrainingPersonaData(is_array($data) ? $data : []);
    }

    public function updatePersona(int $user_id, array $data): bool {
        try {
            $persona_data = new TrainingPersonaData($data);
            return update_user_meta($user_id, self::META_KEY, $persona_data->toArray());
        } catch (\Exception $e) {
            error_log('Failed to update training persona: ' . $e->getMessage());
            return false;
        }
    }

    public function deletePersona(int $user_id): bool {
        return delete_user_meta($user_id, self::META_KEY);
    }
} 