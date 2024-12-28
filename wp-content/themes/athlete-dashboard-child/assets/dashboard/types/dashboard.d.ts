import { FC } from 'react';
import { ProfileProps, ProfileUser } from '../features/Profile/types';
import { OverviewProps, FeatureCard } from '../features/Overview/types';
import { WorkoutTrackerProps, Workout, WorkoutType } from '../features/WorkoutTracker/types';

export interface DashboardFeature extends FeatureCard {
    id: string;
    title: string;
    description?: string;
    icon?: string;
    isActive?: boolean;
    react_component: keyof FeatureComponents;
    props: Record<string, any>;
}

export interface DashboardUser extends ProfileUser {
    id: number;
    name: string;
    email: string;
    roles: string[];
    meta: Record<string, any>;
}

export interface DashboardData {
    features: DashboardFeature[];
    user: DashboardUser;
    workouts?: Workout[];
    workoutTypes?: WorkoutType[];
}

export interface FeatureComponents {
    Profile: FC<ProfileProps>;
    Overview: FC<OverviewProps>;
    WorkoutTracker: FC<WorkoutTrackerProps>;
}

declare global {
    interface Window {
        dashboardData: DashboardData;
        dashboardEvents: any;
    }
}

export type { ProfileProps, OverviewProps, WorkoutTrackerProps }; 