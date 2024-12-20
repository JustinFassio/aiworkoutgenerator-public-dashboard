<?php
/**
 * Training Persona Component
 * 
 * Handles training persona data management and synchronization between WordPress Admin
 * and Athlete Dashboard interfaces.
 */

namespace AthleteDashboard\Features\TrainingPersona\Components;

use AthleteDashboard\Features\TrainingPersona\Services\TrainingPersonaService;
use AthleteDashboard\Features\TrainingPersona\Models\TrainingPersonaData;
use AthleteDashboard\Features\Shared\Components\Form;

if (!defined('ABSPATH')) {
    exit;
}

// Load required files
require_once get_stylesheet_directory() . '/features/training-persona/services/TrainingPersonaService.php';
require_once get_stylesheet_directory() . '/features/training-persona/models/TrainingPersonaData.php';

class TrainingPersona {
    private TrainingPersonaService $service;
    private TrainingPersonaData $persona_data;

    public function __construct() {
        $this->service = new TrainingPersonaService();
        try {
            $this->persona_data = $this->service->getPersonaData();
            $this->init();
        } catch (\Exception $e) {
            error_log('Training Persona initialization failed: ' . $e->getMessage());
            $this->persona_data = new TrainingPersonaData();
        }
    }

    private function init(): void {
        add_action('wp_ajax_update_training_persona', [$this, 'handlePersonaUpdate']);
    }

    public function render_form(): void {
        try {
            $form = new Form('training-persona-form', 
                $this->persona_data->getFields(),
                $this->persona_data->toArray(),
                [
                    'context' => 'modal',
                    'submitText' => __('Save Training Persona', 'athlete-dashboard-child'),
                    'showLoader' => true,
                    'classes' => ['training-persona-form'],
                    'attributes' => [
                        'data-form-context' => 'modal'
                    ]
                ]
            );
            $form->render();
        } catch (\Exception $e) {
            error_log('Failed to render training persona form: ' . $e->getMessage());
            echo '<div class="error">Failed to load training persona form. Please try again later.</div>';
        }
    }

    public function handlePersonaUpdate(): void {
        check_ajax_referer('training_persona_nonce', 'training_persona_nonce');

        $user_id = get_current_user_id();
        if (!$user_id) {
            wp_send_json_error('User not logged in');
            return;
        }

        try {
            $data = [];
            foreach ($_POST as $key => $value) {
                if ($key !== 'action' && $key !== 'training_persona_nonce') {
                    if (is_array($value)) {
                        $data[$key] = array_map('sanitize_text_field', $value);
                    } else {
                        $data[$key] = sanitize_text_field($value);
                    }
                }
            }

            $result = $this->service->updatePersona($user_id, $data);
            if ($result) {
                $updated_data = $this->service->getPersonaData($user_id)->toArray();
                wp_send_json_success([
                    'message' => __('Training persona updated successfully', 'athlete-dashboard-child'),
                    'data' => $updated_data
                ]);
            } else {
                wp_send_json_error([
                    'message' => __('Failed to update training persona', 'athlete-dashboard-child')
                ]);
            }
        } catch (\Exception $e) {
            error_log('Training persona update failed: ' . $e->getMessage());
            wp_send_json_error([
                'message' => __('An error occurred while updating training persona', 'athlete-dashboard-child')
            ]);
        }
    }

    public function get_persona_data(): array {
        return $this->persona_data->toArray();
    }

    public function get_fields(): array {
        return $this->persona_data->getFields();
    }

    public function render_admin_fields($user): void {
        if (!current_user_can('edit_user', $user->ID)) {
            return;
        }

        try {
            $persona_data = $this->service->getPersonaData($user->ID);
            ?>
            <h3><?php _e('Training Persona Information', 'athlete-dashboard-child'); ?></h3>
            <p class="description" style="margin-bottom: 1rem;">
                <?php _e('This information is used to customize the athlete\'s training experience.', 'athlete-dashboard-child'); ?>
            </p>

            <!-- Goals & Experience Section -->
            <div class="training-persona-section">
                <h4><?php _e('Goals & Experience', 'athlete-dashboard-child'); ?></h4>
                <table class="form-table" role="presentation">
                    <?php $this->render_admin_section(['goals', 'experience_level', 'current_activity_level', 'preferred_activity_level', 'detailed_goals'], $persona_data); ?>
                </table>
            </div>

            <!-- Activities Section -->
            <div class="training-persona-section">
                <h4><?php _e('Activities & Interests', 'athlete-dashboard-child'); ?></h4>
                <table class="form-table" role="presentation">
                    <?php $this->render_admin_section(['current_activities'], $persona_data); ?>
                </table>
            </div>

            <!-- Lifestyle Section -->
            <div class="training-persona-section">
                <h4><?php _e('Lifestyle & Schedule', 'athlete-dashboard-child'); ?></h4>
                <table class="form-table" role="presentation">
                    <?php $this->render_admin_section(['occupation', 'work_schedule', 'stress_level'], $persona_data); ?>
                </table>
            </div>

            <!-- Health & Motivation Section -->
            <div class="training-persona-section">
                <h4><?php _e('Health & Motivation', 'athlete-dashboard-child'); ?></h4>
                <table class="form-table" role="presentation">
                    <?php $this->render_admin_section(['motivation_level', 'sleep_data'], $persona_data); ?>
                </table>
            </div>

            <style>
                .training-persona-section {
                    background: #fff;
                    border: 1px solid #c3c4c7;
                    border-radius: 4px;
                    padding: 1rem;
                    margin-bottom: 1.5rem;
                }
                .training-persona-section h4 {
                    margin: 0 0 1rem;
                    padding-bottom: 0.5rem;
                    border-bottom: 1px solid #c3c4c7;
                }
                .training-persona-section .form-table {
                    margin-top: 0;
                }
                .training-persona-section .form-table th {
                    padding-top: 0.75rem;
                    padding-bottom: 0.75rem;
                }
                .training-persona-value {
                    background: #f0f0f1;
                    border: 1px solid #c3c4c7;
                    border-radius: 4px;
                    padding: 0.75rem;
                    margin: 0.25rem 0;
                }
                .training-persona-value.multi-value {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 0.5rem;
                }
                .training-persona-value .tag-item {
                    display: inline-block;
                    padding: 0.25rem 0.75rem;
                    background: #fff;
                    border: 1px solid #c3c4c7;
                    border-radius: 16px;
                    font-size: 0.875rem;
                }
                .training-persona-value.textarea {
                    white-space: pre-wrap;
                }
            </style>
            <?php
        } catch (\Exception $e) {
            error_log('Failed to render admin fields: ' . $e->getMessage());
            ?>
            <div class="error">
                <p><?php _e('Failed to load training persona data. Please try again later.', 'athlete-dashboard-child'); ?></p>
            </div>
            <?php
        }
    }

    private function render_admin_section(array $fields, TrainingPersonaData $persona_data): void {
        $all_fields = $persona_data->getFields();
        foreach ($fields as $field) {
            if (!isset($all_fields[$field])) continue;
            $config = $all_fields[$field];
            ?>
            <tr>
                <th>
                    <label><?php echo esc_html($config['label']); ?></label>
                </th>
                <td>
                    <?php $this->render_admin_field_value($field, $config, $persona_data->get($field)); ?>
                    <?php if (!empty($config['description'])): ?>
                        <p class="description"><?php echo esc_html($config['description']); ?></p>
                    <?php endif; ?>
                </td>
            </tr>
            <?php
        }
    }

    private function render_admin_field_value(string $field, array $config, $value): void {
        switch ($config['type']) {
            case 'multi_select':
                if (empty($value) || !is_array($value)) {
                    echo '<div class="training-persona-value empty">No values selected</div>';
                    return;
                }
                ?>
                <div class="training-persona-value multi-value">
                    <?php foreach ($value as $val): ?>
                        <?php if (isset($config['options'][$val])): ?>
                            <span class="tag-item"><?php echo esc_html($config['options'][$val]); ?></span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <?php
                break;

            case 'tag_input':
                if (empty($value) || !is_array($value)) {
                    echo '<div class="training-persona-value empty">No items added</div>';
                    return;
                }
                ?>
                <div class="training-persona-value multi-value">
                    <?php foreach ($value as $item): ?>
                        <?php if (isset($item['label'])): ?>
                            <span class="tag-item"><?php echo esc_html($item['label']); ?></span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <?php
                break;

            case 'textarea':
                ?>
                <div class="training-persona-value textarea">
                    <?php
                    if ($field === 'goals_detail') {
                        $description = $value;
                        $lines = explode("\n", $description);
                        foreach ($lines as $line) {
                            if (strpos($line, ':') !== false) {
                                // This is a header line
                                echo '<strong>' . esc_html($line) . '</strong>';
                            } else {
                                echo esc_html($line) . "\n";
                            }
                        }
                    } else {
                        echo empty($value) ? 'No information provided' : nl2br(esc_html($value));
                    }
                    ?>
                </div>
                <?php
                break;

            case 'select':
                ?>
                <div class="training-persona-value">
                    <?php
                    if (empty($value)) {
                        echo 'Not selected';
                    } else {
                        echo isset($config['options'][$value]) ? esc_html($config['options'][$value]) : esc_html($value);
                    }
                    ?>
                </div>
                <?php
                break;

            default:
                ?>
                <div class="training-persona-value">
                    <?php echo empty($value) ? 'No value set' : esc_html($value); ?>
                </div>
                <?php
                break;
        }
    }

    public function export_persona_data(int $user_id = null): array {
        if (!$user_id) {
            $user_id = get_current_user_id();
        }

        try {
            $persona_data = $this->service->getPersonaData($user_id);
            $user = get_userdata($user_id);
            
            return [
                'athlete_info' => [
                    'name' => $user->display_name,
                    'email' => $user->user_email,
                    'export_date' => current_time('Y-m-d H:i:s')
                ],
                'goals' => $this->format_export_section('Goals & Experience', [
                    'goals',
                    'experience_level',
                    'current_activity_level',
                    'preferred_activity_level',
                    'detailed_goals'
                ], $persona_data),
                'activities' => $this->format_export_section('Activities & Interests', [
                    'current_activities'
                ], $persona_data),
                'lifestyle' => $this->format_export_section('Lifestyle & Schedule', [
                    'occupation',
                    'work_schedule',
                    'stress_level'
                ], $persona_data),
                'health' => $this->format_export_section('Health & Motivation', [
                    'motivation_level',
                    'sleep_data'
                ], $persona_data)
            ];
        } catch (\Exception $e) {
            error_log('Failed to export training persona data: ' . $e->getMessage());
            return [];
        }
    }

    private function format_export_section(string $title, array $fields, TrainingPersonaData $persona_data): array {
        $section_data = ['title' => $title, 'fields' => []];
        $all_fields = $persona_data->getFields();

        foreach ($fields as $field) {
            if (!isset($all_fields[$field])) continue;

            $config = $all_fields[$field];
            $value = $persona_data->get($field);
            $formatted_value = $this->format_export_value($value, $config);

            $section_data['fields'][] = [
                'label' => $config['label'],
                'value' => $formatted_value,
                'type' => $config['type']
            ];
        }

        return $section_data;
    }

    private function format_export_value($value, array $config): string {
        if (empty($value)) {
            return 'Not specified';
        }

        switch ($config['type']) {
            case 'multi_select':
                if (!is_array($value)) return 'None selected';
                $labels = array_map(function($val) use ($config) {
                    return $config['options'][$val] ?? $val;
                }, $value);
                return implode(', ', $labels);

            case 'tag_input':
                if (!is_array($value)) return 'None added';
                $labels = array_map(function($item) {
                    return $item['label'] ?? '';
                }, $value);
                return implode(', ', array_filter($labels));

            case 'select':
                return $config['options'][$value] ?? $value;

            default:
                return (string)$value;
        }
    }

    public function handle_export_request(): void {
        check_ajax_referer('training_persona_nonce', 'training_persona_nonce');

        $user_id = get_current_user_id();
        if (!$user_id) {
            wp_send_json_error('User not logged in');
            return;
        }

        $export_data = $this->export_persona_data($user_id);
        if (empty($export_data)) {
            wp_send_json_error('Failed to export data');
            return;
        }

        wp_send_json_success([
            'data' => $export_data,
            'filename' => 'training-persona-' . date('Y-m-d') . '.json'
        ]);
    }

    public function track_goal_progress(string $goal_id, float $progress_value): bool {
        try {
            $user_id = get_current_user_id();
            if (!$user_id) return false;

            $progress_data = get_user_meta($user_id, 'training_goals_progress', true);
            if (!is_array($progress_data)) {
                $progress_data = [];
            }

            $progress_data[$goal_id] = [
                'value' => $progress_value,
                'updated_at' => current_time('mysql')
            ];

            return update_user_meta($user_id, 'training_goals_progress', $progress_data);
        } catch (\Exception $e) {
            error_log('Failed to track goal progress: ' . $e->getMessage());
            return false;
        }
    }

    public function get_goal_progress(string $goal_id = null): array {
        try {
            $user_id = get_current_user_id();
            if (!$user_id) return [];

            $progress_data = get_user_meta($user_id, 'training_goals_progress', true);
            if (!is_array($progress_data)) {
                return [];
            }

            if ($goal_id) {
                return $progress_data[$goal_id] ?? [];
            }

            return $progress_data;
        } catch (\Exception $e) {
            error_log('Failed to get goal progress: ' . $e->getMessage());
            return [];
        }
    }
} 