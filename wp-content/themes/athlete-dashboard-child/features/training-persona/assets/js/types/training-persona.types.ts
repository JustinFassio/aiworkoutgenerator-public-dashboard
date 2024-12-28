export interface TrainingPersonaConfig {
    ajaxurl: string;
    nonce: string;
    i18n: {
        saveSuccess: string;
        saveError: string;
        invalidForm: string;
    };
}

export interface TrainingPersonaData {
    training_level: string;
    training_frequency: string;
    training_goals: string[];
    preferred_training_time: string;
    additional_notes: string;
}

export interface TrainingPersonaModalConfig {
    id: string;
    title: string;
    submitText: string;
    closeText: string;
}

export interface GoalTrackingData {
    goal_id: string;
    goal_name: string;
    goal_description: string;
    target_value: number;
    current_value: number;
    unit: string;
    start_date: string;
    end_date: string;
    status: 'in_progress' | 'completed' | 'failed';
}

// Extend the Window interface to include our global config
declare global {
    interface Window {
        trainingPersonaConfig: TrainingPersonaConfig;
    }
} 