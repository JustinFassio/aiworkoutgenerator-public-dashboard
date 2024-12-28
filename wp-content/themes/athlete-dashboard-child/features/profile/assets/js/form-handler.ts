/**
 * Form Handler for Profile Feature
 * 
 * A form handler specifically for profile-related forms.
 */
import { ProfileFormConfig, ProfileData } from '../types/profile.types';
import { Events as DashboardEvents } from '@dashboard/js/events';

interface FormHandlerOptions {
    endpoint: string;
    additionalData?: Record<string, any>;
    customFields?: Record<string, (element: HTMLElement) => void>;
}

export class ProfileFormHandler {
    private formId: string;
    private form: HTMLFormElement | null;
    private options: FormHandlerOptions;

    constructor(formId: string, options: FormHandlerOptions) {
        this.formId = formId;
        this.form = document.getElementById(formId) as HTMLFormElement;
        this.options = options;
        this.init();
    }

    private init(): void {
        if (!this.form) {
            console.error(`Form with ID "${this.formId}" not found`);
            return;
        }

        // Initialize custom field handlers
        if (this.options.customFields) {
            Object.entries(this.options.customFields).forEach(([selector, handler]) => {
                const element = document.querySelector(selector);
                if (element) {
                    handler(element as HTMLElement);
                }
            });
        }

        // Bind form submission
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
    }

    private async handleSubmit(e: Event): Promise<void> {
        e.preventDefault();

        if (!this.form) return;

        const formData = new FormData(this.form);

        // Add additional data
        if (this.options.additionalData) {
            Object.entries(this.options.additionalData).forEach(([key, value]) => {
                formData.append(key, value);
            });
        }

        try {
            const response = await fetch(this.options.endpoint, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            });

            const data = await response.json();

            if (data.success) {
                this.handleSuccess(data);
            } else {
                this.handleError(data);
            }
        } catch (error) {
            console.error('Form submission error:', error);
            this.handleError({
                success: false,
                data: {
                    message: 'An unexpected error occurred'
                }
            });
        }
    }

    private handleSuccess(response: any): void {
        // Dispatch success event
        this.form?.dispatchEvent(new CustomEvent('form:submit:success', {
            detail: response
        }));
    }

    private handleError(response: any): void {
        // Dispatch error event
        this.form?.dispatchEvent(new CustomEvent('form:submit:error', {
            detail: response
        }));
    }

    public reset(): void {
        this.form?.reset();
    }
}

// Make the class available globally
declare global {
    interface Window {
        ProfileFormHandler: typeof ProfileFormHandler;
    }
}

window.ProfileFormHandler = ProfileFormHandler; 