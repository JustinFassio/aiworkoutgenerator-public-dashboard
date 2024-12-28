import type { DashboardEventDetail } from './types/events';

export class DashboardEvents {
    private handlers: Map<string, Function[]>;

    constructor() {
        this.handlers = new Map();
        this.handlePHPEvent = this.handlePHPEvent.bind(this);
        this.setupEventListeners();
    }

    private setupEventListeners(): void {
        document.addEventListener('dashboard:event', this.handlePHPEvent);
    }

    private handlePHPEvent(e: CustomEvent<DashboardEventDetail>): void {
        const { type, data } = e.detail;
        this.emit(type, data);
    }

    public on(event: string, handler: Function): void {
        if (!this.handlers.has(event)) {
            this.handlers.set(event, []);
        }
        this.handlers.get(event)?.push(handler);
    }

    public off(event: string, handler: Function): void {
        if (!this.handlers.has(event)) return;

        const handlers = this.handlers.get(event);
        if (!handlers) return;

        const index = handlers.indexOf(handler);
        if (index > -1) {
            handlers.splice(index, 1);
        }
    }

    public emit(event: string, data?: any): void {
        if (!this.handlers.has(event)) return;

        const handlers = this.handlers.get(event);
        if (!handlers) return;

        handlers.forEach(handler => handler(data));
    }

    public destroy(): void {
        document.removeEventListener('dashboard:event', this.handlePHPEvent);
        this.handlers.clear();
    }
}

// Create a singleton instance
const events = new DashboardEvents();

// Add global event listener for feature events
document.addEventListener('dashboard:event', (e: CustomEvent<DashboardEventDetail>) => {
    const { type, data } = e.detail;
    events.emit(type, data);
});

// Add feature-specific event listeners
const features = document.querySelectorAll('[data-feature]');
features.forEach(feature => {
    const featureId = feature.getAttribute('data-feature');
    if (featureId) {
        document.addEventListener(`dashboard:feature:${featureId}:*`, (e: CustomEvent<DashboardEventDetail>) => {
            const { type, data } = e.detail;
            events.emit(`${featureId}:${type}`, data);
        });
    }
});

export default events; 