<?php
/**
 * Profile Modal Component
 * 
 * Handles the rendering and functionality of the profile modal.
 */

namespace AthleteDashboard\Features\Profile\Components\Modals;

use AthleteDashboard\Features\Dashboard\Components\Modals\BaseModal;
use AthleteDashboard\Features\Profile\Components\ProfileForm;
use AthleteDashboard\Features\Shared\AssetVersion;

if (!defined('ABSPATH')) {
    exit;
}

class ProfileModal extends BaseModal {
    private ProfileForm $form;

    public function __construct() {
        $this->form = new ProfileForm('profile-form', [], [], [
            'context' => 'modal',
            'submitText' => __('Save Profile', 'athlete-dashboard-child')
        ]);
        parent::__construct('profile-modal');
    }

    /**
     * Get the modal's title
     */
    protected function getModalTitle(): string {
        return __('Your Profile', 'athlete-dashboard-child');
    }

    /**
     * Render the modal's content
     */
    protected function renderModalContent(): void {
        $this->form->render();
    }

    /**
     * Get modal-specific options
     */
    protected function getModalOptions(): array {
        return [
            'size' => 'medium',
            'animation' => 'slide',
            'initialFocus' => '#profile-form input:first',
            'classes' => ['profile-modal'],
            'role' => 'dialog',
            'describedBy' => 'profile-form-description'
        ];
    }

    /**
     * Enqueue feature-specific assets
     */
    protected function enqueueFeatureAssets(): void {
        // Profile-specific styles
        wp_enqueue_style(
            'profile-modal',
            get_stylesheet_directory_uri() . '/features/profile/assets/css/profile-modal.css',
            ['base-modal'],
            AssetVersion::getDev('profile-modal')
        );

        // Profile-specific scripts
        wp_enqueue_script(
            'profile-modal',
            get_stylesheet_directory_uri() . '/features/profile/assets/js/profile-modal.js',
            ['base-modal'],
            AssetVersion::getDev('profile-modal-js'),
            true
        );
    }
} 