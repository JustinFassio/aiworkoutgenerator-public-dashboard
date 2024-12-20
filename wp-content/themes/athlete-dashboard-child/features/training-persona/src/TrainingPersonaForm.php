<?php

class TrainingPersonaForm extends BaseForm {

    protected function get_fields() {
        return [
            'goals' => [
                'type' => 'select',
                'label' => __('Goals', 'athlete-dashboard-child'),
                'multiple' => true,
                'options' => [
                    'STRENGTH' => __('Strength', 'athlete-dashboard-child'),
                    'ENDURANCE' => __('Endurance', 'athlete-dashboard-child'),
                    'SPEED' => __('Speed', 'athlete-dashboard-child'),
                    'POWER' => __('Power', 'athlete-dashboard-child'),
                    'FLEXIBILITY' => __('Flexibility', 'athlete-dashboard-child'),
                    'BALANCE' => __('Balance', 'athlete-dashboard-child'),
                    'COORDINATION' => __('Coordination', 'athlete-dashboard-child'),
                    'AGILITY' => __('Agility', 'athlete-dashboard-child'),
                    'RECOVERY' => __('Recovery', 'athlete-dashboard-child')
                ],
                'required' => true,
                'attributes' => [
                    'data-field' => 'goals'
                ]
            ],
            'goals_detail' => [
                'type' => 'textarea',
                'label' => __('Detailed Goals', 'athlete-dashboard-child'),
                'rows' => 8,
                'maxlength' => 1000,
                'attributes' => [
                    'data-field' => 'goals_detail'
                ]
            ],
            // ... rest of your fields ...
        ];
    }

    protected function enqueue_assets() {
        parent::enqueue_assets();
        
        // Localize the training persona data for JavaScript
        wp_localize_script(
            'training-persona-js',
            'trainingPersonaData',
            [
                'goals' => $this->get_value('goals', []),
                'goals_detail' => $this->get_value('goals_detail', ''),
            ]
        );
    }

    // ... rest of your existing code ...
} 