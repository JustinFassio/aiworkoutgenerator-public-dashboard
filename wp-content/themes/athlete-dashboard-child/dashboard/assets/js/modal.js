(function($) {
    'use strict';

    class DashboardModalManager {
        constructor() {
            this.init();
        }

        init() {
            // Handle modal triggers
            $(document).on('click', '[data-modal-trigger]', (e) => {
                e.preventDefault();
                const modalId = $(e.currentTarget).data('modal-trigger');
                this.openModal(modalId);
            });

            // Handle modal close buttons
            $(document).on('click', '.close-modal, .modal-backdrop', (e) => {
                e.preventDefault();
                this.closeModal($(e.target).closest('.dashboard-modal'));
            });

            // Handle escape key
            $(document).on('keydown', (e) => {
                if (e.key === 'Escape') {
                    this.closeAllModals();
                }
            });

            // Listen for programmatic close requests
            $(document).on('dashboard_modal_close', (e, modalId) => {
                if (modalId) {
                    this.closeModal($(`#${modalId}`));
                } else {
                    this.closeAllModals();
                }
            });
        }

        openModal(modalId) {
            const $modal = $(`#${modalId}`);
            if ($modal.length) {
                // Close any open modals first
                this.closeAllModals();
                
                // Open the new modal
                $modal.addClass('is-active');
                $('body').addClass('modal-open');

                // Focus the first input/select in the modal
                setTimeout(() => {
                    $modal.find('input:visible, select:visible').first().focus();
                }, 100);
            }
        }

        closeModal($modal) {
            if ($modal && $modal.length) {
                $modal.removeClass('is-active');
                if ($('.dashboard-modal.is-active').length === 0) {
                    $('body').removeClass('modal-open');
                }
            }
        }

        closeAllModals() {
            $('.dashboard-modal.is-active').removeClass('is-active');
            $('body').removeClass('modal-open');
        }
    }

    // Initialize when document is ready
    $(document).ready(() => {
        new DashboardModalManager();
    });
})(jQuery); 