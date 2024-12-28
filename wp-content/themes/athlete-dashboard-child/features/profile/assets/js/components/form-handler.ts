import { ProfileFormConfig, ProfileData } from '../types/profile.types';
import { DashboardEvents } from '@dashboard/js/events';

export class ProfileFormHandler {
    private formId: string;
    private config: ProfileFormConfig;
    private form: HTMLFormElement | null;

    constructor(formId: string, config: ProfileFormConfig) {
        this.formId = formId;
        this.config = config;
        this.form = document.getElementById(formId) as HTMLFormElement;
        
        if (!this.form) {
            throw new Error(`Form with ID "${formId}" not found`);
        }

        this.init();
    }

    private init(): void {
        this.bindEvents();
        this.initializeCustomFields();
    }

    private bindEvents(): void {
        this.form?.addEventListener('submit', (e) => {
            e.preventDefault();
            this.handleSubmit();
        });
    }

    private initializeCustomFields(): void {
        if (!this.config.customFields) return;

        Object.entries(this.config.customFields).forEach(([selector, handler]) => {
            const element = document.querySelector(selector);
            if (element instanceof HTMLElement) {
                handler(element);
            }
        });
    }

    private async handleSubmit(): Promise<void> {
        if (!this.form) return;

        try {
            const formData = new FormData(this.form);
            const data = {
                ...Object.fromEntries(formData),
                ...this.config.additionalData
            };

            const response = await fetch(this.config.endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams(data as Record<string, string>).toString()
            });

            const result = await response.json();

            if (result.success) {
                DashboardEvents.emit('profile:save:success', result.data as ProfileData);
            } else {
                throw new Error(result.message || 'Failed to save profile');
            }
        } catch (error) {
            DashboardEvents.emit('profile:save:error', {
                message: error instanceof Error ? error.message : 'An unknown error occurred'
            });
        }
    }

    public getFormData(): ProfileData | null {
        if (!this.form) return null;

        const formData = new FormData(this.form);
        return Object.fromEntries(formData) as unknown as ProfileData;
    }

    public setFormData(data: Partial<ProfileData>): void {
        if (!this.form) return;

        Object.entries(data).forEach(([key, value]) => {
            const element = this.form?.elements.namedItem(key);
            if (element instanceof HTMLInputElement || element instanceof HTMLSelectElement) {
                element.value = value?.toString() ?? '';
            }
        });
    }
} 