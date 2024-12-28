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
                const $modal = $(e.target).closest('.dashboard-modal');
                if ($modal.length) {
                    this.closeModal($modal);
                }
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

            // Trigger ready event for features
            $(document).trigger('dashboard_modals_ready', [this]);
        }

        openModal(modalId) {
            const $modal = $(`#${modalId}`);
            if ($modal.length) {
                // Close any open modals first
                this.closeAllModals();
                
                // Trigger before open event
                $(document).trigger('dashboard_modal_before_open', [modalId, $modal]);
                
                // Open the new modal
                $modal.addClass('is-active');
                $('body').addClass('modal-open');

                // Focus the first input/select in the modal
                setTimeout(() => {
                    $modal.find('input:visible, select:visible').first().focus();
                }, 100);

                // Trigger after open event
                $(document).trigger('dashboard_modal_after_open', [modalId, $modal]);
            }
        }

        closeModal($modal) {
            if ($modal && $modal.length) {
                const modalId = $modal.attr('id');
                
                // Trigger before close event
                $(document).trigger('dashboard_modal_before_close', [modalId, $modal]);

                $modal.removeClass('is-active');
                if ($('.dashboard-modal.is-active').length === 0) {
                    $('body').removeClass('modal-open');
                }

                // Trigger after close event
                $(document).trigger('dashboard_modal_after_close', [modalId, $modal]);
            }
        }

        closeAllModals() {
            $('.dashboard-modal.is-active').each((_, modal) => {
                this.closeModal($(modal));
            });
        }
    }

    // Create global instance
    window.dashboardModalManager = null;

    // Initialize when document is ready
    $(document).ready(() => {
        window.dashboardModalManager = new DashboardModalManager();
    });
})(jQuery); 