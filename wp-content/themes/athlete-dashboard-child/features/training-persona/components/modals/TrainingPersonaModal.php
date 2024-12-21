<?php
/**
 * Training Persona Modal Component
 * 
 * Handles the rendering and functionality of the training persona modal.
 */

namespace AthleteDashboard\Features\TrainingPersona\Components\Modals;

use AthleteDashboard\Features\Dashboard\Components\Modals\BaseModal;
use AthleteDashboard\Features\TrainingPersona\Components\TrainingPersonaForm;
use AthleteDashboard\Features\Shared\AssetVersion;

if (!defined('ABSPATH')) {
    exit;
}

class TrainingPersonaModal extends BaseModal {
    private TrainingPersonaForm $form;

    public function __construct() {
        $this->form = new TrainingPersonaForm('training-persona-form', [], [], [
            'context' => 'modal',
            'submitText' => __('Save Training Persona', 'athlete-dashboard-child')
        ]);
        parent::__construct('training-persona-modal');
    }

    /**
     * Get the modal's title
     */
    protected function getModalTitle(): string {
        return __('Training Persona', 'athlete-dashboard-child');
    }

    /**
     * Render the modal's content
     */
    protected function renderModalContent(): void {
        ?>
        <div id="training-persona-form-description" class="screen-reader-text">
            <?php _e('Update your training preferences and fitness goals.', 'athlete-dashboard-child'); ?>
        </div>
        <?php
        $this->form->render();
    }

    /**
     * Get modal-specific options
     */
    protected function getModalOptions(): array {
        return [
            'size' => 'medium',
            'animation' => 'slide',
            'initialFocus' => '#training-persona-form select:first',
            'classes' => ['training-persona-modal'],
            'role' => 'dialog',
            'describedBy' => 'training-persona-form-description'
        ];
    }

    /**
     * Enqueue feature-specific assets
     */
    protected function enqueueFeatureAssets(): void {
        // Training persona-specific styles
        wp_enqueue_style(
            'training-persona-modal',
            get_stylesheet_directory_uri() . '/features/training-persona/assets/css/training-persona-modal.css',
            ['base-modal'],
            AssetVersion::getDev('training-persona-modal')
        );

        // Training persona-specific scripts
        wp_enqueue_script(
            'training-persona-modal',
            get_stylesheet_directory_uri() . '/features/training-persona/assets/js/training-persona-modal.js',
            ['base-modal'],
            AssetVersion::getDev('training-persona-modal-js'),
            true
        );
    }
} 