import { Events } from '@dashboard/events';

interface FormHandlerConfig {
    endpoint: string;
    additionalData?: Record<string, any>;
}

export class FormHandler {
    private form: HTMLFormElement;
    private config: FormHandlerConfig;

    constructor(formId: string, config: FormHandlerConfig) {
        const form = document.getElementById(formId);
        if (!(form instanceof HTMLFormElement)) {
            throw new Error(`Form with ID "${formId}" not found`);
        }

        this.form = form;
        this.config = config;
        this.init();
    }

    private init(): void {
        this.form.addEventListener('submit', this.handleSubmit.bind(this));
    }

    private async handleSubmit(e: Event): Promise<void> {
        e.preventDefault();

        try {
            const formData = new FormData(this.form);
            const data = {
                ...Object.fromEntries(formData),
                ...this.config.additionalData
            };

            Events.emit('form:submit:start', { formId: this.form.id });

            const response = await fetch(this.config.endpoint, {
                method: 'POST',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();
            Events.emit('form:submit:success', { formId: this.form.id, result });

        } catch (error) {
            console.error('Form submission error:', error);
            Events.emit('form:submit:error', { 
                formId: this.form.id, 
                error: error instanceof Error ? error.message : 'Unknown error' 
            });
        }
    }
} 