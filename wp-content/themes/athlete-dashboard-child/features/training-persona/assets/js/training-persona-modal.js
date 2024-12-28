/**
 * Training Persona Modal Handler
 * 
 * Handles training persona modal-specific functionality using the dashboard event system.
 */
(function($) {
    'use strict';

    class TrainingPersonaModalHandler {
        constructor() {
            this.modalId = 'training-persona-modal';
            this.form = null;
            this.init();
        }

        init() {
            // Wait for dashboard modal system
            document.addEventListener('dashboard:modals:ready', () => {
                this.initializeForm();
                this.bindEvents();
            });
        }

        initializeForm() {
            this.form = document.getElementById(`${this.modalId}-form`);
            if (this.form) {
                this.form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.handleSubmit();
                });
            }
        }

        bindEvents() {
            // Listen for modal lifecycle events
            document.addEventListener('dashboard:modal:before_open', (e) => {
                if (e.detail.modalId === this.modalId) {
                    this.handleBeforeOpen();
                }
            });

            document.addEventListener('dashboard:modal:after_open', (e) => {
                if (e.detail.modalId === this.modalId) {
                    this.handleAfterOpen();
                }
            });

            document.addEventListener('dashboard:modal:before_close', (e) => {
                if (e.detail.modalId === this.modalId) {
                    this.handleBeforeClose();
                }
            });

            document.addEventListener('dashboard:modal:after_close', (e) => {
                if (e.detail.modalId === this.modalId) {
                    this.handleAfterClose();
                }
            });
        }

        handleBeforeOpen() {
            // Reset form if exists
            if (this.form) {
                this.form.reset();
            }
        }

        handleAfterOpen() {
            // Focus first input
            const firstInput = this.form?.querySelector('input:not([type="hidden"]), select');
            if (firstInput) {
                firstInput.focus();
            }
        }

        handleBeforeClose() {
            // Trigger form reset event
            if (this.form) {
                document.dispatchEvent(new CustomEvent('training-persona:form:reset', {
                    detail: { form: this.form }
                }));
            }
        }

        handleAfterClose() {
            // Additional cleanup if needed
        }

        handleSubmit() {
            if (!this.form) return;

            const formData = new FormData(this.form);
            formData.append('action', 'update_training_persona');
            formData.append('training_persona_nonce', trainingPersonaConfig.nonce);

            // Show loading state
            this.form.classList.add('is-loading');

            fetch(trainingPersonaConfig.ajaxurl, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(response => {
                if (response.success) {
                    this.showMessage(trainingPersonaConfig.i18n.saveSuccess, 'success');
                    
                    // Close modal using event system
                    document.dispatchEvent(new CustomEvent('dashboard:modal:close', {
                        detail: { modalId: this.modalId }
                    }));
                    
                    // Trigger success event
                    document.dispatchEvent(new CustomEvent('training-persona:update:success', {
                        detail: { data: response.data }
                    }));
                } else {
                    this.showMessage(response.data.message || trainingPersonaConfig.i18n.saveError, 'error');
                }
            })
            .catch(() => {
                this.showMessage(trainingPersonaConfig.i18n.saveError, 'error');
            })
            .finally(() => {
                this.form.classList.remove('is-loading');
            });
        }

        showMessage(message, type = 'info') {
            // Implement message display logic
            console.log(`${type}: ${message}`);
        }
    }

    // Initialize handler
    $(document).ready(() => {
        new TrainingPersonaModalHandler();
    });
})(jQuery); 