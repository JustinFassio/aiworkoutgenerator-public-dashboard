/**
 * Dashboard Modal Manager
 * 
 * Coordinates modal events and handles modal display within the dashboard.
 */
(function($) {
    'use strict';

    class DashboardModalManager {
        constructor() {
            this.activeModal = null;
            this.init();
        }

        init() {
            // Listen for modal events
            document.addEventListener('dashboard:modal:open', (e) => {
                const { modalId, props } = e.detail;
                this.openModal(modalId, props);
            });

            document.addEventListener('dashboard:modal:close', (e) => {
                const { modalId } = e.detail;
                this.closeModal(modalId);
            });

            // Handle modal triggers
            $(document).on('click', '[data-modal-trigger]', (e) => {
                e.preventDefault();
                const modalId = $(e.currentTarget).data('modal-trigger');
                this.triggerModalOpen(modalId);
            });

            // Handle close buttons and backdrop
            $(document).on('click', '.close-modal, .modal-backdrop', (e) => {
                e.preventDefault();
                const $modal = $(e.target).closest('.dashboard-modal');
                if ($modal.length) {
                    this.triggerModalClose($modal.attr('id'));
                }
            });

            // Handle escape key
            $(document).on('keydown', (e) => {
                if (e.key === 'Escape' && this.activeModal) {
                    this.triggerModalClose(this.activeModal);
                }
            });

            // Notify features that modal system is ready
            document.dispatchEvent(new CustomEvent('dashboard:modals:ready'));
        }

        triggerModalOpen(modalId) {
            document.dispatchEvent(new CustomEvent('dashboard:modal:open', {
                detail: { modalId }
            }));
        }

        triggerModalClose(modalId) {
            document.dispatchEvent(new CustomEvent('dashboard:modal:close', {
                detail: { modalId }
            }));
        }

        openModal(modalId) {
            const $modal = $(`#${modalId}`);
            if ($modal.length) {
                // Close any open modals first
                if (this.activeModal) {
                    this.closeModal(this.activeModal);
                }

                // Trigger before open event
                document.dispatchEvent(new CustomEvent('dashboard:modal:before_open', {
                    detail: { modalId }
                }));

                // Open the modal
                $modal.addClass('is-active');
                $('body').addClass('modal-open');
                this.activeModal = modalId;

                // Focus first input if exists
                setTimeout(() => {
                    $modal.find('input:visible, select:visible').first().focus();
                }, 100);

                // Trigger after open event
                document.dispatchEvent(new CustomEvent('dashboard:modal:after_open', {
                    detail: { modalId }
                }));
            }
        }

        closeModal(modalId) {
            const $modal = $(`#${modalId}`);
            if ($modal.length) {
                // Trigger before close event
                document.dispatchEvent(new CustomEvent('dashboard:modal:before_close', {
                    detail: { modalId }
                }));

                // Close the modal
                $modal.removeClass('is-active');
                if ($('.dashboard-modal.is-active').length === 0) {
                    $('body').removeClass('modal-open');
                }
                if (this.activeModal === modalId) {
                    this.activeModal = null;
                }

                // Trigger after close event
                document.dispatchEvent(new CustomEvent('dashboard:modal:after_close', {
                    detail: { modalId }
                }));
            }
        }
    }

    // Initialize when document is ready
    $(document).ready(() => {
        window.dashboardModalManager = new DashboardModalManager();
    });
})(jQuery); 