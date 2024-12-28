interface DashboardEventDetail<T = any> {
    feature?: string;
    event: string;
    data: T;
    timestamp: number;
}

interface DashboardEventOptions {
    bubbles?: boolean;
    cancelable?: boolean;
}

class DashboardEventSystem {
    private static instance: DashboardEventSystem;
    private readonly debug: boolean;
    private readonly features: Record<string, any>;

    private constructor() {
        const config = (window as any).dashboardEvents || {};
        this.debug = config.debug || false;
        this.features = config.features || {};
        
        this.initialize();
    }

    public static getInstance(): DashboardEventSystem {
        if (!DashboardEventSystem.instance) {
            DashboardEventSystem.instance = new DashboardEventSystem();
        }
        return DashboardEventSystem.instance;
    }

    private initialize(): void {
        // Listen for PHP-emitted events
        document.addEventListener('dashboard:event', this.handlePHPEvent.bind(this));
        
        if (this.debug) {
            this.setupDebugListeners();
        }
    }

    public emit<T>(event: string, data: T, options: DashboardEventOptions = {}): void {
        const detail: DashboardEventDetail<T> = {
            event,
            data,
            timestamp: Date.now()
        };

        const customEvent = new CustomEvent('dashboard:event', {
            bubbles: options.bubbles ?? true,
            cancelable: options.cancelable ?? true,
            detail
        });

        document.dispatchEvent(customEvent);

        if (this.debug) {
            console.debug(`[Dashboard] Event emitted: ${event}`, detail);
        }
    }

    public on<T>(event: string, callback: (detail: DashboardEventDetail<T>) => void): void {
        document.addEventListener('dashboard:event', ((e: CustomEvent<DashboardEventDetail<T>>) => {
            if (e.detail.event === event) {
                callback(e.detail);
            }
        }) as EventListener);
    }

    public emitFeatureEvent<T>(feature: string, event: string, data: T, options: DashboardEventOptions = {}): void {
        const detail: DashboardEventDetail<T> = {
            feature,
            event,
            data,
            timestamp: Date.now()
        };

        const customEvent = new CustomEvent(`dashboard:feature:${feature}:${event}`, {
            bubbles: options.bubbles ?? true,
            cancelable: options.cancelable ?? true,
            detail
        });

        document.dispatchEvent(customEvent);

        if (this.debug) {
            console.debug(`[Dashboard] Feature event emitted: ${feature}:${event}`, detail);
        }
    }

    public onFeature<T>(feature: string, event: string, callback: (detail: DashboardEventDetail<T>) => void): void {
        document.addEventListener(`dashboard:feature:${feature}:${event}`, ((e: CustomEvent<DashboardEventDetail<T>>) => {
            callback(e.detail);
        }) as EventListener);
    }

    private handlePHPEvent(e: CustomEvent<DashboardEventDetail>): void {
        if (this.debug) {
            console.debug('[Dashboard] PHP event received:', e.detail);
        }
    }

    private setupDebugListeners(): void {
        document.addEventListener('dashboard:event', (e: CustomEvent<DashboardEventDetail>) => {
            console.debug('[Dashboard] Event intercepted:', e.detail);
        });

        Object.keys(this.features).forEach(feature => {
            document.addEventListener(`dashboard:feature:${feature}:*`, (e: CustomEvent<DashboardEventDetail>) => {
                console.debug(`[Dashboard] Feature event intercepted (${feature}):`, e.detail);
            });
        });
    }
}

// Export singleton instance
export const Events = DashboardEventSystem.getInstance();

// Export types
export type { DashboardEventDetail, DashboardEventOptions }; 