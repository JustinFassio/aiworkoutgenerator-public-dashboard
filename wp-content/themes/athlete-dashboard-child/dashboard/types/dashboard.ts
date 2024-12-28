import type { FC } from 'react';

export interface DashboardFeature {
    identifier: string;
    enabled: boolean;
    metadata: {
        title: string;
        description?: string;
        icon?: string;
    };
}

export interface DashboardUser {
    id: number;
    roles: string[];
}

export interface DashboardData {
    features: Record<string, DashboardFeature>;
    user: DashboardUser;
}

// Component types
export interface FeatureProps {
    user: DashboardUser;
    data?: any;
    features?: any[];
    currentUser?: DashboardUser;
    onSaveWorkout?: (workout: any) => Promise<void>;
    onUpdateWorkout?: (workout: any) => Promise<void>;
    onDeleteWorkout?: (workoutId: string) => Promise<void>;
}

export type FeatureComponent = FC<FeatureProps>;
export type FeatureComponents = Record<string, FeatureComponent>; 