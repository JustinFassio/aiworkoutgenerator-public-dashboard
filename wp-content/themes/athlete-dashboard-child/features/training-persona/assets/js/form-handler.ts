import { TrainingPersonaData } from './types/training-persona.types';
import { Events as DashboardEvents } from '@dashboard/js/events';

interface ValidationRule {
    validate: (value: string) => boolean;
    message: string;
}

interface FormHandlerOptions {
    endpoint: string;
    onSuccess?: (response: any) => void;
    onError?: (response: any) => void;
    beforeSubmit?: () => boolean;
    afterSubmit?: () => void;
    validationRules?: Record<string, ValidationRule[]>;
    customFields?: Record<string, (element: HTMLElement) => void>;
    additionalData?: Record<string, any>;
}

export class TrainingPersonaFormHandler {
    private form: HTMLFormElement;
    private options: Required<FormHandlerOptions>;
    private submitButton: HTMLButtonElement | null;
    private messageContainer: HTMLElement | null;

    constructor(formId: string, options: Partial<FormHandlerOptions> = {}) {
        const form = document.getElementById(formId);
        if (!(form instanceof HTMLFormElement)) {
            throw new Error(`Form with ID "${formId}" not found`);
        }
        this.form = form;

        this.options = {
            endpoint: options.endpoint || '',
            onSuccess: options.onSuccess || this.defaultSuccess.bind(this),
            onError: options.onError || this.defaultError.bind(this),
            beforeSubmit: options.beforeSubmit || (() => true),
            afterSubmit: options.afterSubmit || (() => {}),
            validationRules: options.validationRules || {},
            customFields: options.customFields || {},
            additionalData: options.additionalData || {},
        };

        this.submitButton = this.form.querySelector('.submit-button');
        this.messageContainer = this.form.querySelector('.form-messages');
        this.init();
    }

    private init(): void {
        this.bindEvents();
        this.setupCustomFields();
    }

    private bindEvents(): void {
        this.form.addEventListener('submit', this.handleSubmit.bind(this));
    }

    private setupCustomFields(): void {
        Object.entries(this.options.customFields).forEach(([selector, handler]) => {
            const elements = this.form.querySelectorAll(selector);
            elements.forEach(element => {
                if (typeof handler === 'function') {
                    handler(element as HTMLElement);
                }
            });
        });
    }

    private async handleSubmit(e: Event): Promise<void> {
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
            Object.entries(this.options.additionalData).forEach(([key, value]) => {
                formData.append(key, value);
            });

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

    private setLoadingState(isLoading: boolean): void {
        if (this.submitButton) {
            this.submitButton.disabled = isLoading;
            const buttonText = this.submitButton.querySelector('.button-text');
            const buttonLoader = this.submitButton.querySelector('.button-loader');
            
            if (buttonText instanceof HTMLElement && buttonLoader instanceof HTMLElement) {
                buttonText.style.display = isLoading ? 'none' : '';
                buttonLoader.style.display = isLoading ? '' : 'none';
            }
        }
    }

    private clearMessages(): void {
        if (this.messageContainer) {
            this.messageContainer.innerHTML = '';
        }
    }

    private showMessage(message: string, type: 'success' | 'error' = 'success'): void {
        if (this.messageContainer) {
            const messageElement = document.createElement('div');
            messageElement.className = `${type}-message`;
            messageElement.textContent = message;
            this.messageContainer.appendChild(messageElement);
        }
    }

    private showError(message: string): void {
        this.showMessage(message, 'error');
    }

    private showSuccess(message: string): void {
        this.showMessage(message, 'success');
    }

    private defaultSuccess(response: any): void {
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

    private defaultError(response: any): void {
        this.showError(response.data?.message || 'Failed to save. Please try again.');
    }

    public validate(): boolean {
        let isValid = true;
        const errors: string[] = [];

        Object.entries(this.options.validationRules).forEach(([field, rules]) => {
            const element = this.form.querySelector(`[name="${field}"]`);
            if (element instanceof HTMLInputElement) {
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

// Make the class available globally
declare global {
    interface Window {
        TrainingPersonaFormHandler: typeof TrainingPersonaFormHandler;
    }
}

window.TrainingPersonaFormHandler = TrainingPersonaFormHandler; 