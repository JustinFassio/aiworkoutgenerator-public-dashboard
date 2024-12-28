// Core event types
export interface DashboardEventDetail<T = any> {
    type: string;
    data: T;
}

// Feature-specific event types
export interface FeatureEventDetail<T = any> {
    feature: string;
    type: string;
    data: T;
}

// Event constants
export const DashboardEvents = {
    // Core events
    READY: 'dashboard:ready',
    ERROR: 'dashboard:error',
    
    // Feature events
    FEATURE_LOADED: 'feature:loaded',
    FEATURE_ERROR: 'feature:error',
    
    // Modal events
    MODAL_OPEN: 'modal:open',
    MODAL_CLOSE: 'modal:close',
    
    // User events
    USER_UPDATE: 'user:update',
    USER_ERROR: 'user:error',
} as const;

export type DashboardEventTypes = typeof DashboardEvents[keyof typeof DashboardEvents]; 