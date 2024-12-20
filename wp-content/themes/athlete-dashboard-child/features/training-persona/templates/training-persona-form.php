<?php
/**
 * Training Persona Form Template
 */

if (!defined('ABSPATH')) {
    exit;
}

use AthleteDashboard\Features\Shared\Components\Form;

try {
    $form = new Form('training-persona-form', 
        $fields,
        $data,
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