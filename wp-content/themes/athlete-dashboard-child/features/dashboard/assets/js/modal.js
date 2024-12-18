jQuery(document).ready(function($) {
    const modal = {
        init: function() {
            this.bindEvents();
        },

        bindEvents: function() {
            // Open modal
            $(document).on('click', '.dashboard-card.modal-trigger', this.openModal.bind(this));

            // Close modal
            $(document).on('click', '.modal-close', this.closeModal.bind(this));
            $(document).on('click', '.modal-backdrop', function(e) {
                if ($(e.target).hasClass('modal-backdrop')) {
                    const $modal = $(e.target).closest('.dashboard-modal');
                    if ($modal.data('close-on-backdrop') !== false) {
                        this.closeModal(e);
                    }
                }
            }.bind(this));

            // Handle escape key
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape') {
                    const $activeModal = $('.dashboard-modal.is-active');
                    if ($activeModal.length && $activeModal.data('close-on-escape') !== false) {
                        this.closeModal(e);
                    }
                }
            }.bind(this));
        },

        openModal: function(e) {
            e.preventDefault();
            const $trigger = $(e.currentTarget);
            const targetId = $trigger.data('modal-target');
            const $modal = $(`#${targetId}`);
            
            if ($modal.length) {
                // Store current focus
                this.lastFocusedElement = document.activeElement;

                // Close any open modals
                $('.dashboard-modal.is-active').removeClass('is-active');

                // Open new modal
                $modal.addClass('is-active');
                
                // Set focus to first focusable element
                const $firstFocusable = $modal.find('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])').first();
                if ($firstFocusable.length) {
                    setTimeout(() => {
                        $firstFocusable.focus();
                    }, 100);
                }

                // Prevent body scroll
                $('body').addClass('modal-open');

                // Trigger custom event
                $(document).trigger('modalOpened', [$modal]);
            }
        },

        closeModal: function(e) {
            if (e) {
                e.preventDefault();
            }
            const $modal = e ? $(e.target).closest('.dashboard-modal') : $('.dashboard-modal.is-active');
            
            if ($modal.length) {
                $modal.removeClass('is-active');
                
                // Restore focus
                if (this.lastFocusedElement) {
                    setTimeout(() => {
                        this.lastFocusedElement.focus();
                    }, 100);
                }

                // Restore body scroll if no other modals are open
                if (!$('.dashboard-modal.is-active').length) {
                    $('body').removeClass('modal-open');
                }

                // Trigger custom event
                $(document).trigger('modalClosed', [$modal]);
            }
        }
    };

    // Initialize modal functionality
    modal.init();

    // Expose modal API
    window.athleteDashboardModal = modal;
}); 