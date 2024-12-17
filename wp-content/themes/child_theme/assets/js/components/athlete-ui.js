/**
 * Athlete UI Component
 * Handles UI interactions for the athlete dashboard
 */
class AthleteUI {
    constructor() {
        // Selectors
        this.selectors = {
            dashboard: '.athlete-dashboard',
            card: '.dashboard-card',
            dialog: 'dialog[role="dialog"]',
            form: 'form',
            closeButton: '.close-dialog',
            cancelButton: '.cancel-button'
        };

        this.initialize();
    }

    initialize() {
        this.bindEvents();
    }

    bindEvents() {
        // Dialog management
        document.querySelectorAll(this.selectors.dialog).forEach(dialog => {
            const closeBtn = dialog.querySelector(this.selectors.closeButton);
            const cancelBtn = dialog.querySelector(this.selectors.cancelButton);
            
            if (closeBtn) {
                closeBtn.addEventListener('click', () => this.closeDialog(dialog));
            }
            if (cancelBtn) {
                cancelBtn.addEventListener('click', () => this.closeDialog(dialog));
            }
        });

        // Form submissions
        document.querySelectorAll(this.selectors.form).forEach(form => {
            form.addEventListener('submit', (e) => this.handleFormSubmit(e));
        });
    }

    openDialog(dialogId) {
        const dialog = document.getElementById(dialogId);
        if (dialog) {
            dialog.showModal();
        }
    }

    closeDialog(dialog) {
        dialog.close();
        const form = dialog.querySelector('form');
        if (form) {
            form.reset();
        }
    }

    handleFormSubmit(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);

        // Add any additional form handling logic here
        this.submitFormData(form.action, formData);
    }

    async submitFormData(url, formData) {
        try {
            const response = await fetch(url, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();
            if (data.success) {
                // Handle successful submission
                this.handleSuccessfulSubmission(data);
            } else {
                // Handle error
                this.showError(data.message || 'An error occurred');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showError('An error occurred while submitting the form');
        }
    }

    handleSuccessfulSubmission(data) {
        // Implement success handling (e.g., close dialog, refresh data)
        const dialog = document.querySelector(this.selectors.dialog + '[open]');
        if (dialog) {
            this.closeDialog(dialog);
        }

        // Refresh the relevant card content if needed
        if (data.content && data.targetId) {
            const target = document.getElementById(data.targetId);
            if (target) {
                target.querySelector('.card-content').innerHTML = data.content;
            }
        }
    }

    showError(message) {
        // Implement error display logic
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.textContent = message;

        const activeDialog = document.querySelector(this.selectors.dialog + '[open]');
        if (activeDialog) {
            const form = activeDialog.querySelector('form');
            if (form) {
                form.insertBefore(errorDiv, form.firstChild);
                setTimeout(() => errorDiv.remove(), 5000);
            }
        }
    }
}

// Initialize when document is ready
document.addEventListener('DOMContentLoaded', () => {
    new AthleteUI();
}); 