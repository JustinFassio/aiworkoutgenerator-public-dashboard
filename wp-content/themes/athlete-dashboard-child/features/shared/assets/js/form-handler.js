/**
 * Form Handler
 * 
 * A reusable form handler that can be used across features.
 */
class FormHandler {
    constructor(formId, options = {}) {
        this.form = document.getElementById(formId);
        if (!this.form) {
            throw new Error(`Form with ID "${formId}" not found`);
        }

        this.options = {
            endpoint: options.endpoint || '',
            onSuccess: options.onSuccess || this.defaultSuccess.bind(this),
            onError: options.onError || this.defaultError.bind(this),
            beforeSubmit: options.beforeSubmit || (() => true),
            afterSubmit: options.afterSubmit || (() => {}),
            validationRules: options.validationRules || {},
            customFields: options.customFields || {},
            ...options
        };

        this.submitButton = this.form.querySelector('.submit-button');
        this.messageContainer = this.form.querySelector('.form-messages');
        this.init();
    }

    init() {
        this.bindEvents();
        this.setupCustomFields();
    }

    bindEvents() {
        this.form.addEventListener('submit', this.handleSubmit.bind(this));
    }

    setupCustomFields() {
        Object.entries(this.options.customFields).forEach(([selector, handler]) => {
            const elements = this.form.querySelectorAll(selector);
            elements.forEach(element => {
                if (typeof handler === 'function') {
                    handler(element);
                }
            });
        });
    }

    async handleSubmit(e) {
        e.preventDefault();

        // Run pre-submit validation
        if (!this.options.beforeSubmit()) {
            return;
        }

        // Show loading state
        this.setLoadingState(true);
        this.clearMessages();

        try {
            // Collect form data
            const formData = new FormData(this.form);
            
            // Add any additional data
            if (this.options.additionalData) {
                Object.entries(this.options.additionalData).forEach(([key, value]) => {
                    formData.append(key, value);
                });
            }

            // Send request
            const response = await fetch(this.options.endpoint, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            });

            const data = await response.json();

            if (data.success) {
                await this.options.onSuccess(data);
            } else {
                await this.options.onError(data);
            }
        } catch (error) {
            console.error('Form submission error:', error);
            this.showError('An unexpected error occurred. Please try again.');
        } finally {
            this.setLoadingState(false);
            this.options.afterSubmit();
        }
    }

    setLoadingState(isLoading) {
        if (this.submitButton) {
            this.submitButton.disabled = isLoading;
            const buttonText = this.submitButton.querySelector('.button-text');
            const buttonLoader = this.submitButton.querySelector('.button-loader');
            
            if (buttonText && buttonLoader) {
                buttonText.style.display = isLoading ? 'none' : '';
                buttonLoader.style.display = isLoading ? '' : 'none';
            }
        }
    }

    clearMessages() {
        if (this.messageContainer) {
            this.messageContainer.innerHTML = '';
        }
    }

    showMessage(message, type = 'success') {
        if (this.messageContainer) {
            const messageElement = document.createElement('div');
            messageElement.className = `${type}-message`;
            messageElement.textContent = message;
            this.messageContainer.appendChild(messageElement);
        }
    }

    showError(message) {
        this.showMessage(message, 'error');
    }

    showSuccess(message) {
        this.showMessage(message, 'success');
    }

    defaultSuccess(response) {
        this.showSuccess(response.data?.message || 'Successfully saved.');
        
        if (this.form.dataset.formContext === 'modal') {
            setTimeout(() => {
                const modal = this.form.closest('.dashboard-modal');
                if (modal) {
                    modal.classList.remove('is-active');
                }
            }, 1500);
        }
    }

    defaultError(response) {
        this.showError(response.data?.message || 'Failed to save. Please try again.');
    }

    validate() {
        let isValid = true;
        const errors = [];

        Object.entries(this.options.validationRules).forEach(([field, rules]) => {
            const element = this.form.querySelector(`[name="${field}"]`);
            if (element) {
                const value = element.value;
                rules.forEach(rule => {
                    if (!rule.validate(value)) {
                        isValid = false;
                        errors.push(rule.message);
                        element.classList.add('error');
                    }
                });
            }
        });

        if (!isValid) {
            this.showError(errors.join('<br>'));
        }

        return isValid;
    }
}

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = FormHandler;
} 