import React, { useState } from 'react';
import type {
    TrainingPersonaData,
    TrainingPersonaEditorProps,
    ValidationErrors
} from '../../types/training-persona.types';
import { useTrainingPersona } from '../../hooks/useTrainingPersona';
import { GoalsManager } from './GoalsManager';
import { PreferencesPanel } from './PreferencesPanel';
import { LoadingSpinner } from '@core/components/LoadingSpinner';

export const TrainingPersonaEditor: React.FC<TrainingPersonaEditorProps> = ({
    userData,
    onSave,
    onCancel
}) => {
    const {
        data: savedData,
        isLoading: isLoadingData,
        error: loadError,
        updateTrainingPersona,
        isUpdating
    } = useTrainingPersona({
        onError: (error) => {
            setErrors({
                submit: error.message
            });
        }
    });

    const [data, setData] = useState<TrainingPersonaData>(userData || savedData);
    const [errors, setErrors] = useState<ValidationErrors>({});

    // Show loading state while fetching initial data
    if (isLoadingData) {
        return <LoadingSpinner />;
    }

    // Show error state if data fetch failed
    if (loadError) {
        return (
            <div className="error-message">
                Failed to load training persona data: {loadError.message}
            </div>
        );
    }

    const validateData = (): boolean => {
        const newErrors: ValidationErrors = {};

        if (!data.level) {
            newErrors.level = 'Training level is required';
        }

        if (!data.goals.length) {
            newErrors.goals = 'At least one goal is required';
        }

        if (data.preferences.workoutDuration < 15 || data.preferences.workoutDuration > 180) {
            newErrors.preferences = {
                ...newErrors.preferences,
                workoutDuration: 'Duration must be between 15 and 180 minutes'
            };
        }

        if (data.preferences.workoutFrequency < 1 || data.preferences.workoutFrequency > 7) {
            newErrors.preferences = {
                ...newErrors.preferences,
                workoutFrequency: 'Frequency must be between 1 and 7 days per week'
            };
        }

        if (!data.preferences.preferredTypes.length) {
            newErrors.preferences = {
                ...newErrors.preferences,
                preferredTypes: 'At least one preferred workout type is required'
            };
        }

        setErrors(newErrors);
        return Object.keys(newErrors).length === 0;
    };

    const handleSubmit = async (event: React.FormEvent) => {
        event.preventDefault();

        if (!validateData()) {
            return;
        }

        try {
            if (onSave) {
                await onSave(data);
            } else {
                await updateTrainingPersona(data);
            }
        } catch (error) {
            setErrors({
                ...errors,
                submit: error instanceof Error ? error.message : 'Failed to save changes'
            });
        }
    };

    return (
        <form
            className="training-persona-editor"
            onSubmit={handleSubmit}
            data-testid="training-persona-form"
        >
            <div className="form-section">
                <label htmlFor="training-level">Training Level</label>
                <select
                    id="training-level"
                    value={data.level}
                    onChange={e => setData({ ...data, level: e.target.value as any })}
                    aria-invalid={!!errors.level}
                    disabled={isUpdating}
                >
                    <option value="beginner">Beginner</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="advanced">Advanced</option>
                </select>
                {errors.level && (
                    <div className="error-message" role="alert">
                        {errors.level}
                    </div>
                )}
            </div>

            <GoalsManager
                goals={data.goals}
                suggestions={[
                    'Improve strength',
                    'Increase endurance',
                    'Weight loss',
                    'Muscle gain',
                    'General fitness'
                ]}
                onChange={goals => setData({ ...data, goals })}
                disabled={isUpdating}
            />
            {errors.goals && (
                <div className="error-message" role="alert">
                    {errors.goals}
                </div>
            )}

            <PreferencesPanel
                preferences={data.preferences}
                onChange={preferences => setData({ ...data, preferences })}
                disabled={isUpdating}
            />
            {errors.preferences && (
                <div className="error-message" role="alert">
                    {Object.values(errors.preferences).join(', ')}
                </div>
            )}

            <div className="form-actions">
                {onCancel && (
                    <button
                        type="button"
                        className="button button-secondary"
                        onClick={onCancel}
                        disabled={isUpdating}
                    >
                        Cancel
                    </button>
                )}
                <button
                    type="submit"
                    className="button button-primary"
                    disabled={isUpdating}
                >
                    {isUpdating ? 'Saving...' : 'Save Changes'}
                </button>
            </div>

            {errors.submit && (
                <div className="error-message submit-error" role="alert">
                    {errors.submit}
                </div>
            )}
        </form>
    );
}; 