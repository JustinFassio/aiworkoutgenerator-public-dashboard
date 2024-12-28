<?php
/**
 * Training Persona Service
 * 
 * Handles data operations for training persona management.
 */

namespace AthleteDashboard\Features\TrainingPersona\Services;

use AthleteDashboard\Features\TrainingPersona\Models\TrainingPersonaData;

if (!defined('ABSPATH')) {
    exit;
}

class TrainingPersonaService {
    private const META_KEY = 'training_persona_data';

    public function getTrainingPersonaData(int $user_id = null): TrainingPersonaData {
        if (!$user_id) {
            $user_id = get_current_user_id();
        }

        if (!$user_id) {
            throw new \Exception('User not logged in');
        }

        $data = get_user_meta($user_id, self::META_KEY, true);
        if (!is_array($data)) {
            $data = [];
        }

        return new TrainingPersonaData($data);
    }

    public function updateTrainingPersona(int $user_id, array $data): bool {
        if (!$user_id) {
            throw new \Exception('Invalid user ID');
        }

        try {
            // Validate data against the model
            $persona_data = new TrainingPersonaData($data);
            
            // Save the validated data
            return update_user_meta($user_id, self::META_KEY, $persona_data->toArray());
        } catch (\Exception $e) {
            error_log('Failed to update training persona: ' . $e->getMessage());
            return false;
        }
    }

    public function deleteTrainingPersona(int $user_id): bool {
        if (!$user_id) {
            throw new \Exception('Invalid user ID');
        }

        return delete_user_meta($user_id, self::META_KEY);
    }
} 