import { ProfileModalConfig, ProfileData } from '../types/profile.types';
import { DashboardEvents } from '@dashboard/js/events';
import { ProfileFormHandler } from './form-handler';

export class ProfileModal {
    private config: ProfileModalConfig;
    private formHandler: ProfileFormHandler | null = null;
    private modal: HTMLElement | null = null;

    constructor(config: ProfileModalConfig) {
        this.config = config;
        this.init();
    }

    private init(): void {
        // Wait for dashboard modal system
        DashboardEvents.on('dashboard:modals:ready', () => {
            this.modal = document.getElementById(this.config.id);
            if (!this.modal) {
                throw new Error(`Modal with ID "${this.config.id}" not found`);
            }

            this.initializeForm();
            this.bindEvents();
        });
    }

    private initializeForm(): void {
        const formId = `${this.config.id}-form`;
        const form = document.getElementById(formId);
        
        if (!form) {
            throw new Error(`Form with ID "${formId}" not found`);
        }

        this.formHandler = new ProfileFormHandler(formId, {
            endpoint: window.profileConfig.ajaxurl,
            additionalData: {
                action: 'update_profile',
                profile_nonce: window.profileConfig.nonce
            }
        });
    }

    private bindEvents(): void {
        // Listen for modal lifecycle events
        DashboardEvents.on('dashboard:modal:before_open', (e: CustomEvent) => {
            if (e.detail.modalId === this.config.id) {
                this.handleBeforeOpen();
            }
        });

        DashboardEvents.on('dashboard:modal:after_open', (e: CustomEvent) => {
            if (e.detail.modalId === this.config.id) {
                this.handleAfterOpen();
            }
        });

        DashboardEvents.on('dashboard:modal:before_close', (e: CustomEvent) => {
            if (e.detail.modalId === this.config.id) {
                this.handleBeforeClose();
            }
        });

        DashboardEvents.on('profile:save:success', (e: CustomEvent<ProfileData>) => {
            this.handleSaveSuccess(e.detail);
        });

        DashboardEvents.on('profile:save:error', (e: CustomEvent<{message: string}>) => {
            this.handleSaveError(e.detail.message);
        });
    }

    private handleBeforeOpen(): void {
        // Reset form state
        this.formHandler?.setFormData({});
        
        // Remove any previous error states
        this.modal?.querySelectorAll('.error').forEach(el => {
            el.classList.remove('error');
        });
    }

    private handleAfterOpen(): void {
        // Focus first input
        const firstInput = this.modal?.querySelector('input:not([type="hidden"])') as HTMLInputElement;
        firstInput?.focus();
    }

    private handleBeforeClose(): void {
        // Clean up any temporary state
        this.modal?.querySelectorAll('.error').forEach(el => {
            el.classList.remove('error');
        });
    }

    private handleSaveSuccess(data: ProfileData): void {
        // Update form with new data
        this.formHandler?.setFormData(data);
        
        // Show success message
        const message = window.profileConfig.i18n.saveSuccess;
        this.showMessage(message, 'success');
        
        // Close modal after delay
        setTimeout(() => {
            DashboardEvents.emit('dashboard:modal:close');
        }, 1500);
    }

    private handleSaveError(message: string): void {
        this.showMessage(message, 'error');
    }

    private showMessage(message: string, type: 'success' | 'error'): void {
        const messageEl = document.createElement('div');
        messageEl.className = `message message--${type}`;
        messageEl.textContent = message;

        const container = this.modal?.querySelector('.modal-body');
        container?.insertBefore(messageEl, container.firstChild);

        setTimeout(() => messageEl.remove(), 3000);
    }
} 