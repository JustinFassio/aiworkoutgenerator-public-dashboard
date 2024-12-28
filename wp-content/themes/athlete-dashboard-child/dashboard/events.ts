type EventCallback<T = any> = (detail: T) => void;

class EventSystem {
    private listeners: Map<string, Set<EventCallback>> = new Map();

    on<T = any>(event: string, callback: EventCallback<T>) {
        if (!this.listeners.has(event)) {
            this.listeners.set(event, new Set());
        }
        this.listeners.get(event)!.add(callback);

        return () => {
            this.off(event, callback);
        };
    }

    off(event: string, callback: EventCallback) {
        const callbacks = this.listeners.get(event);
        if (callbacks) {
            callbacks.delete(callback);
            if (callbacks.size === 0) {
                this.listeners.delete(event);
            }
        }
    }

    emit<T = any>(event: string, detail?: T) {
        const callbacks = this.listeners.get(event);
        if (callbacks) {
            callbacks.forEach(callback => {
                try {
                    callback(detail);
                } catch (error) {
                    console.error(`Error in event listener for ${event}:`, error);
                }
            });
        }

        // Also dispatch DOM event for PHP listeners
        const domEvent = new CustomEvent(`dashboard:${event}`, {
            detail,
            bubbles: true
        });
        document.dispatchEvent(domEvent);
    }

    once<T = any>(event: string, callback: EventCallback<T>) {
        const wrappedCallback: EventCallback<T> = (detail) => {
            this.off(event, wrappedCallback);
            callback(detail);
        };
        this.on(event, wrappedCallback);
    }
}

export const Events = new EventSystem();
export default Events; 