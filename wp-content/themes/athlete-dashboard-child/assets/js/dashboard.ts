import '@/css/dashboard.scss';

// Event system for inter-feature communication
class DashboardEvents {
    static emit(eventName: string, detail: any = {}) {
        document.dispatchEvent(new CustomEvent(eventName, { detail }));
    }

    static on(eventName: string, callback: (event: CustomEvent) => void) {
        document.addEventListener(eventName, callback as EventListener);
    }
}

// Modal system
class DashboardModals {
    private static instance: DashboardModals;
    private activeModal: HTMLElement | null = null;

    private constructor() {
        this.initializeModals();
    }

    static getInstance(): DashboardModals {
        if (!DashboardModals.instance) {
            DashboardModals.instance = new DashboardModals();
        }
        return DashboardModals.instance;
    }

    private initializeModals() {
        // Listen for modal events
        DashboardEvents.on('dashboard:modal:open', (e: CustomEvent) => this.openModal(e.detail.modalId));
        DashboardEvents.on('dashboard:modal:close', () => this.closeModal());

        // Initialize modal triggers
        document.querySelectorAll('[data-modal-trigger]').forEach(trigger => {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                const modalId = (e.currentTarget as HTMLElement).dataset.modalTrigger;
                if (modalId) {
                    this.openModal(modalId);
                }
            });
        });

        // Emit ready event
        DashboardEvents.emit('dashboard:modals:ready');
    }

    private openModal(modalId: string) {
        const modal = document.getElementById(modalId);
        if (!modal) return;

        DashboardEvents.emit('dashboard:modal:before_open', { modalId });
        
        modal.classList.add('is-active');
        this.activeModal = modal;
        
        DashboardEvents.emit('dashboard:modal:after_open', { modalId });
    }

    private closeModal() {
        if (!this.activeModal) return;

        const modalId = this.activeModal.id;
        DashboardEvents.emit('dashboard:modal:before_close', { modalId });
        
        this.activeModal.classList.remove('is-active');
        this.activeModal = null;
        
        DashboardEvents.emit('dashboard:modal:after_close', { modalId });
    }
}

// Initialize dashboard functionality
document.addEventListener('DOMContentLoaded', () => {
    // Initialize modal system
    DashboardModals.getInstance();
    
    console.log('Athlete Dashboard initialized');
});

// Export for type checking
export { DashboardEvents, DashboardModals }; 