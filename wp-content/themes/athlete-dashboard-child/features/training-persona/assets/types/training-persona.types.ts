import type { DashboardUser } from '@dashboard/types/dashboard';

export interface Goal {
    id: string;
    title: string;
    progress: number;
}

export interface ProgressItem {
    label: string;
    value: number;
}

export interface TrainingPersonaData {
    title: string;
    goals: Goal[];
    progress: ProgressItem[];
}

export interface TrainingPersonaProps {
    user: DashboardUser;
    data: TrainingPersonaData;
} 