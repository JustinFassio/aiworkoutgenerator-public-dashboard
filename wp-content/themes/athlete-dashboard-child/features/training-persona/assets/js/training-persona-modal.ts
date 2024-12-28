import { TrainingPersonaData } from './types/training-persona.types';
import { Events as DashboardEvents } from '@dashboard/js/events';

class TrainingPersonaModalHandler {
    private modalId: string;
    private form: HTMLFormElement | null;

    constructor() {
        this.modalId = 'training-persona-modal';
        this.form = null;
        this.init();
    }

    private init(): void {
        // Wait for dashboard modal system
        DashboardEvents.on('dashboard:modals:ready', () => {
            this.initializeForm();
            this.bindEvents();
        });
    }

    private initializeForm(): void {
        this.form = document.getElementById(`${this.modalId}-form`) as HTMLFormElement;
        if (this.form) {
            this.form.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleSubmit();
            });
        }
    }

    private bindEvents(): void {
        // Listen for modal lifecycle events
        DashboardEvents.on('dashboard:modal:before_open', (e: CustomEvent) => {
            if (e.detail.modalId === this.modalId) {
                this.handleBeforeOpen();
            }
        });

        DashboardEvents.on('dashboard:modal:after_open', (e: CustomEvent) => {
            if (e.detail.modalId === this.modalId) {
                this.handleAfterOpen();
            }
        });

        DashboardEvents.on('dashboard:modal:before_close', (e: CustomEvent) => {
            if (e.detail.modalId === this.modalId) {
                this.handleBeforeClose();
            }
        });

        DashboardEvents.on('dashboard:modal:after_close', (e: CustomEvent) => {
            if (e.detail.modalId === this.modalId) {
                this.handleAfterClose();
            }
        });
    }

    private handleBeforeOpen(): void {
        // Reset form if exists
        if (this.form) {
            this.form.reset();
        }
    }

    private handleAfterOpen(): void {
        // Focus first input
        const firstInput = this.form?.querySelector('input:not([type="hidden"]), select');
        if (firstInput instanceof HTMLElement) {
            firstInput.focus();
        }
    }

    private handleBeforeClose(): void {
        // Trigger form reset event
        if (this.form) {
            DashboardEvents.emit('training-persona:form:reset', { form: this.form });
        }
    }

    private handleAfterClose(): void {
        // Additional cleanup if needed
    }

    private async handleSubmit(): Promise<void> {
        if (!this.form) return;

        const formData = new FormData(this.form);
        formData.append('action', 'update_training_persona');
        formData.append('training_persona_nonce', window.trainingPersonaConfig.nonce);

        // Show loading state
        this.form.classList.add('is-loading');

        try {
            const response = await fetch(window.trainingPersonaConfig.ajaxurl, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            });

            const data = await response.json();

            if (data.success) {
                this.showMessage(window.trainingPersonaConfig.i18n.saveSuccess, 'success');
                
                // Close modal using event system
                DashboardEvents.emit('dashboard:modal:close', { modalId: this.modalId });
                
                // Trigger success event
                DashboardEvents.emit('training-persona:update:success', { data: data.data });
            } else {
                this.showMessage(data.data?.message || window.trainingPersonaConfig.i18n.saveError, 'error');
            }
        } catch (error) {
            this.showMessage(window.trainingPersonaConfig.i18n.saveError, 'error');
            console.error('Training persona update error:', error);
        } finally {
            this.form.classList.remove('is-loading');
        }
    }

    private showMessage(message: string, type: 'success' | 'error' | 'info' = 'info'): void {
        DashboardEvents.emit('dashboard:notification', { message, type });
    }
}

// Initialize handler
document.addEventListener('DOMContentLoaded', () => {
    new TrainingPersonaModalHandler();
});

export default TrainingPersonaModalHandler; 