/**
 * Training Persona Types
 * 
 * TypeScript interfaces for the Training Persona feature components.
 */

export type TrainingLevel = 'beginner' | 'intermediate' | 'advanced';

export interface TrainingPreferences {
    workoutDuration: number;
    workoutFrequency: number;
    preferredTypes: string[];
}

export interface TrainingPersonaData {
    level: TrainingLevel;
    goals: string[];
    preferences: TrainingPreferences;
}

export interface TrainingPersonaEditorProps {
    userData?: TrainingPersonaData;
    onSave?: (data: TrainingPersonaData) => Promise<void>;
    onCancel?: () => void;
}

export interface GoalsManagerProps {
    goals: string[];
    suggestions: string[];
    onChange: (goals: string[]) => void;
    maxGoals?: number;
    disabled?: boolean;
}

export interface PreferencesPanelProps {
    preferences: TrainingPreferences;
    onChange: (preferences: TrainingPreferences) => void;
    disabled?: boolean;
}

export interface ValidationErrors {
    level?: string;
    goals?: string;
    preferences?: {
        workoutDuration?: string;
        workoutFrequency?: string;
        preferredTypes?: string;
    };
    submit?: string;
}

export interface ApiResponse {
    success: boolean;
    message: string;
    data?: TrainingPersonaData;
}

export interface ApiEndpoints {
    get: string;
    save: string;
}

declare global {
    interface Window {
        trainingPersonaData: {
            endpoints: ApiEndpoints;
            nonce: string;
        };
    }
} 