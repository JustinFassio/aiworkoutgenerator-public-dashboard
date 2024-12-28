interface DashboardEventDetail<T = any> {
    type: string;
    data?: T;
    event: string;
    timestamp: number;
}

declare global {
    interface DocumentEventMap {
        'dashboard:event': CustomEvent<DashboardEventDetail>;
        [key: `dashboard:feature:${string}:*`]: CustomEvent<DashboardEventDetail>;
    }

    interface WindowEventMap {
        'dashboard:event': CustomEvent<DashboardEventDetail>;
        [key: `dashboard:feature:${string}:*`]: CustomEvent<DashboardEventDetail>;
    }
}

export type { DashboardEventDetail }; 