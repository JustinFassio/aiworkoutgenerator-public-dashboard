import React from 'react';
import type { PreferencesPanelProps } from '../../types/training-persona.types';

const WORKOUT_TYPES = [
    'Strength',
    'HIIT',
    'Cardio',
    'Yoga',
    'Flexibility',
    'Bodyweight',
    'CrossFit',
    'Pilates'
];

export const PreferencesPanel: React.FC<PreferencesPanelProps> = ({
    preferences,
    onChange
}) => {
    const handleWorkoutTypeToggle = (type: string) => {
        const updatedTypes = preferences.preferredTypes.includes(type)
            ? preferences.preferredTypes.filter(t => t !== type)
            : [...preferences.preferredTypes, type];

        onChange({
            ...preferences,
            preferredTypes: updatedTypes
        });
    };

    return (
        <div className="preferences-panel">
            <h3>Training Preferences</h3>

            <div className="preference-section">
                <label htmlFor="workout-duration">
                    Workout Duration (minutes)
                </label>
                <input
                    type="number"
                    id="workout-duration"
                    value={preferences.workoutDuration}
                    onChange={e => onChange({
                        ...preferences,
                        workoutDuration: Math.max(15, Math.min(180, parseInt(e.target.value) || 0))
                    })}
                    min={15}
                    max={180}
                    step={15}
                />
                <div className="input-description">
                    Choose between 15 and 180 minutes
                </div>
            </div>

            <div className="preference-section">
                <label htmlFor="workout-frequency">
                    Weekly Workout Frequency
                </label>
                <input
                    type="number"
                    id="workout-frequency"
                    value={preferences.workoutFrequency}
                    onChange={e => onChange({
                        ...preferences,
                        workoutFrequency: Math.max(1, Math.min(7, parseInt(e.target.value) || 0))
                    })}
                    min={1}
                    max={7}
                />
                <div className="input-description">
                    Choose between 1 and 7 days per week
                </div>
            </div>

            <div className="preference-section">
                <label className="workout-types-label">
                    Preferred Workout Types
                </label>
                <div className="workout-types-grid">
                    {WORKOUT_TYPES.map(type => (
                        <div
                            key={type}
                            className="workout-type-option"
                        >
                            <input
                                type="checkbox"
                                id={`workout-type-${type}`}
                                checked={preferences.preferredTypes.includes(type)}
                                onChange={() => handleWorkoutTypeToggle(type)}
                            />
                            <label htmlFor={`workout-type-${type}`}>
                                {type}
                            </label>
                        </div>
                    ))}
                </div>
                <div className="input-description">
                    Select all that interest you
                </div>
            </div>

            <div className="preferences-summary">
                <h4>Your Training Schedule</h4>
                <p>
                    You prefer {preferences.workoutDuration}-minute workouts,{' '}
                    {preferences.workoutFrequency} times per week
                </p>
                {preferences.preferredTypes.length > 0 && (
                    <p>
                        Focusing on: {preferences.preferredTypes.join(', ')}
                    </p>
                )}
            </div>
        </div>
    );
}; 