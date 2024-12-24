<?php
/**
 * Training Persona Data Model
 * 
 * Defines the structure and validation for training persona fields.
 */

namespace AthleteDashboard\Features\TrainingPersona\Models;

if (!defined('ABSPATH')) {
    exit;
}

class TrainingPersonaData {
    private array $data;
    private array $fields;

    public function __construct(array $data = []) {
        $this->fields = $this->defineFields();
        $this->data = $this->validateData($data);
    }

    public function get(string $key) {
        return $this->data[$key] ?? null;
    }

    public function set(string $key, $value): void {
        if (isset($this->fields[$key])) {
            $this->data[$key] = $this->validateField($key, $value);
        }
    }

    public function toArray(): array {
        return $this->data;
    }

    public function getFields(): array {
        return $this->fields;
    }

    private function defineFields(): array {
        return [
            'goals' => [
                'type' => 'tag_input',
                'label' => 'Goals',
                'required' => false,
                'predefined_options' => [
                    'strength' => 'Increase Overall Strength',
                    'muscle' => 'Build Muscle Mass',
                    'endurance' => 'Improve Endurance',
                    'weight_loss' => 'Weight Loss',
                    'flexibility' => 'Enhance Flexibility',
                    'speed' => 'Increase Speed',
                    'power' => 'Develop Power'
                ],
                'validation' => function($value) {
                    if (empty($value)) return true;
                    
                    // Handle JSON string input
                    if (is_string($value)) {
                        $decoded = json_decode(stripslashes($value), true);
                        if (is_array($decoded)) {
                            $value = $decoded;
                        }
                    }
                    
                    if (!is_array($value)) return false;
                    
                    foreach ($value as $item) {
                        if (!is_array($item) || !isset($item['value'], $item['type'])) {
                            return false;
                        }
                        if ($item['type'] === 'predefined' && !isset($this->fields['goals']['predefined_options'][$item['value']])) {
                            return false;
                        }
                    }
                    return true;
                },
                'description' => 'Select from common fitness goals or add your own. Press Enter or comma to add custom goals.'
            ],
            'goals_detail' => [
                'type' => 'textarea',
                'label' => 'Detailed Goals',
                'required' => false,
                'validation' => fn($value) => empty($value) || (is_string($value) && strlen($value) <= 500),
                'maxlength' => 500,
                'rows' => 3,
                'description' => 'For each goal, provide specific targets, timeframes, and any relevant metrics you want to track.'
            ],
            'experience_level' => [
                'type' => 'select',
                'label' => 'Experience Level',
                'options' => [
                    'beginner' => 'Beginner',
                    'intermediate' => 'Intermediate',
                    'advanced' => 'Advanced'
                ],
                'required' => true,
                'description' => 'Your current fitness experience level'
            ],
            'current_activity_level' => [
                'type' => 'select',
                'label' => 'Current Activity Level',
                'options' => [
                    'sedentary' => 'Sedentary',
                    'lightly_active' => 'Lightly Active',
                    'moderately_active' => 'Moderately Active',
                    'very_active' => 'Very Active',
                    'extremely_active' => 'Extremely Active'
                ],
                'required' => true,
                'description' => 'Your current daily activity level'
            ],
            'preferred_activity_level' => [
                'type' => 'select',
                'label' => 'Preferred Activity Level',
                'options' => [
                    'light' => 'Light',
                    'moderate' => 'Moderate',
                    'active' => 'Active',
                    'very_active' => 'Very Active'
                ],
                'required' => true,
                'description' => 'Your desired activity level'
            ],
            'current_activities' => [
                'type' => 'tag_input',
                'label' => 'Current Activities',
                'required' => false,
                'predefined_options' => [
                    'yoga' => 'Yoga',
                    'weightlifting' => 'Weightlifting',
                    'running' => 'Running',
                    'swimming' => 'Swimming',
                    'cycling' => 'Cycling',
                    'hiit' => 'HIIT',
                    'pilates' => 'Pilates'
                ],
                'description' => 'Select or type your current fitness activities'
            ],
            'occupation' => [
                'type' => 'select',
                'label' => 'Occupation Type',
                'options' => [
                    'sedentary' => 'Sedentary (Office Work)',
                    'light_activity' => 'Light Activity',
                    'moderate_activity' => 'Moderate Activity',
                    'heavy_activity' => 'Heavy Activity'
                ],
                'required' => true,
                'description' => 'Your typical work activity level'
            ],
            'work_schedule' => [
                'type' => 'textarea',
                'label' => 'Work Schedule',
                'required' => false,
                'maxlength' => 200,
                'description' => 'Brief description of your work schedule'
            ],
            'stress_level' => [
                'type' => 'select',
                'label' => 'Stress Level',
                'options' => [
                    'low' => 'Low',
                    'moderate' => 'Moderate',
                    'high' => 'High',
                    'very_high' => 'Very High'
                ],
                'required' => true,
                'description' => 'Your typical stress level'
            ],
            'motivation_level' => [
                'type' => 'select',
                'label' => 'Motivation Level',
                'options' => [
                    '1' => '1 - Very Low',
                    '2' => '2 - Low',
                    '3' => '3 - Below Average',
                    '4' => '4 - Slightly Below Average',
                    '5' => '5 - Average',
                    '6' => '6 - Slightly Above Average',
                    '7' => '7 - Above Average',
                    '8' => '8 - High',
                    '9' => '9 - Very High',
                    '10' => '10 - Extremely High'
                ],
                'required' => true,
                'description' => 'Rate your current motivation level'
            ],
            'sleep_data' => [
                'type' => 'textarea',
                'label' => 'Sleep Information',
                'required' => false,
                'maxlength' => 200,
                'description' => 'Describe your typical sleep pattern (hours and quality)'
            ],
            'barriers' => [
                'type' => 'select',
                'label' => 'Training Barriers',
                'options' => [
                    'time_constraints' => 'Time Constraints',
                    'previous_injury' => 'Previous Injury',
                    'equipment_access' => 'Limited Equipment Access',
                    'location_access' => 'Location/Facility Access',
                    'energy_levels' => 'Energy Levels',
                    'motivation' => 'Motivation Issues',
                    'schedule_conflicts' => 'Schedule Conflicts',
                    'recovery_time' => 'Recovery Time'
                ],
                'required' => false,
                'description' => 'Select your primary training barrier'
            ],
            'support_needs' => [
                'type' => 'select',
                'label' => 'Support Needed',
                'options' => [
                    'flexible_scheduling' => 'Flexible Scheduling',
                    'modified_exercises' => 'Modified Exercises',
                    'equipment_alternatives' => 'Equipment Alternatives',
                    'recovery_guidance' => 'Recovery Guidance',
                    'motivation_support' => 'Motivation Support',
                    'technique_guidance' => 'Technique Guidance'
                ],
                'required' => false,
                'description' => 'Select your primary support need'
            ],
            'schedule_availability' => [
                'type' => 'schedule_grid',
                'label' => 'Weekly Availability',
                'required' => false,
                'days' => [
                    'monday' => 'Monday',
                    'tuesday' => 'Tuesday',
                    'wednesday' => 'Wednesday',
                    'thursday' => 'Thursday',
                    'friday' => 'Friday',
                    'saturday' => 'Saturday',
                    'sunday' => 'Sunday'
                ],
                'timeSlots' => [
                    'early_morning' => '5:00 AM - 8:00 AM',
                    'morning' => '8:00 AM - 11:00 AM',
                    'midday' => '11:00 AM - 2:00 PM',
                    'afternoon' => '2:00 PM - 5:00 PM',
                    'evening' => '5:00 PM - 8:00 PM',
                    'late_evening' => '8:00 PM - 11:00 PM'
                ],
                'description' => 'Select your available time slots for training'
            ],
            'meal_timing' => [
                'type' => 'meal_schedule',
                'label' => 'Meal Schedule',
                'required' => false,
                'meals' => [
                    'pre_workout' => [
                        'label' => 'Pre-Workout Meal',
                        'options' => [
                            '30min' => '30 minutes before',
                            '1hour' => '1 hour before',
                            '2hours' => '2 hours before',
                            '3hours' => '3 hours before'
                        ]
                    ],
                    'post_workout' => [
                        'label' => 'Post-Workout Meal',
                        'options' => [
                            'immediate' => 'Immediately after',
                            '30min' => '30 minutes after',
                            '1hour' => '1 hour after',
                            '2hours' => '2 hours after'
                        ]
                    ]
                ],
                'description' => 'Select your preferred meal timing around workouts'
            ],
            'barriers_notes' => [
                'type' => 'textarea',
                'label' => 'Additional Barrier Details',
                'required' => false,
                'maxlength' => 500,
                'description' => 'Provide any additional details about your training barriers'
            ]
        ];
    }

    private function validateData(array $data): array {
        $validated = [];
        foreach ($this->fields as $key => $field) {
            if (isset($data[$key])) {
                if ($field['type'] === 'multi_select') {
                    $value = is_array($data[$key]) ? $data[$key] : [$data[$key]];
                    $validated[$key] = $this->validateField($key, $value);
                } else {
                    $validated[$key] = $this->validateField($key, $data[$key]);
                }
            } elseif (isset($field['default'])) {
                $validated[$key] = $field['default'];
            } elseif ($field['required']) {
                $validated[$key] = null;
            }
        }
        return $validated;
    }

    private function validateField(string $key, $value) {
        if (!isset($this->fields[$key])) {
            return null;
        }

        $field = $this->fields[$key];
        
        // Basic validation based on field type
        switch ($field['type']) {
            case 'multi_select':
                if (!is_array($value)) return [];
                return array_intersect($value, array_keys($field['options']));
            
            case 'select':
                return isset($field['options'][$value]) ? $value : null;
            
            case 'textarea':
                return is_string($value) && strlen($value) <= ($field['maxlength'] ?? 500) ? $value : null;
            
            case 'tag_input':
                if (empty($value)) return [];
                if (is_string($value)) {
                    $decoded = json_decode(stripslashes($value), true);
                    return is_array($decoded) ? $decoded : [];
                }
                return is_array($value) ? $value : [];
            
            default:
                return $value;
        }
    }
} 