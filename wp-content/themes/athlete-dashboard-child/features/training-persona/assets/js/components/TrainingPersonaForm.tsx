import React, { useState } from 'react';
import { Form } from '@dashboard/components/Form';
import type { TrainingPersonaData } from '../../types/training-persona.types';

interface TrainingPersonaFormProps {
    data: TrainingPersonaData;
    onSubmit: (data: TrainingPersonaData) => Promise<void>;
    context?: 'modal' | 'admin';
}

export const TrainingPersonaForm: React.FC<TrainingPersonaFormProps> = ({
    data,
    onSubmit,
    context = 'modal'
}) => {
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [error, setError] = useState<string | null>(null);

    const handleSubmit = async (event: React.FormEvent) => {
        event.preventDefault();
        setIsSubmitting(true);
        setError(null);

        try {
            const formData = new FormData(event.target as HTMLFormElement);
            const formValues = Object.fromEntries(formData.entries());
            await onSubmit(formValues as TrainingPersonaData);
        } catch (err) {
            setError(err instanceof Error ? err.message : 'An error occurred');
        } finally {
            setIsSubmitting(false);
        }
    };

    return (
        <Form
            id="training-persona-form"
            className="training-persona-form"
            onSubmit={handleSubmit}
            data-form-context={context}
        >
            <div className="form-grid">
                <FormField
                    label="Training Level"
                    name="training_level"
                    type="select"
                    required
                    value={data.level}
                    options={{
                        beginner: 'Beginner',
                        intermediate: 'Intermediate',
                        advanced: 'Advanced'
                    }}
                />

                <FormField
                    label="Workout Duration"
                    name="workout_duration"
                    type="number"
                    required
                    value={data.preferences.workoutDuration}
                    min={15}
                    max={180}
                    step={15}
                />

                <FormField
                    label="Weekly Frequency"
                    name="workout_frequency"
                    type="number"
                    required
                    value={data.preferences.workoutFrequency}
                    min={1}
                    max={7}
                />

                <TagInput
                    label="Training Goals"
                    name="training_goals"
                    value={data.goals}
                    predefinedOptions={[
                        'Improve strength',
                        'Increase endurance',
                        'Weight loss',
                        'Muscle gain',
                        'General fitness'
                    ]}
                />

                <TagInput
                    label="Preferred Workout Types"
                    name="preferred_types"
                    value={data.preferences.preferredTypes}
                    predefinedOptions={[
                        'Strength',
                        'HIIT',
                        'Cardio',
                        'Yoga',
                        'Flexibility'
                    ]}
                />
            </div>

            {error && (
                <div className="form-error" role="alert">
                    {error}
                </div>
            )}

            <div className="form-actions">
                {context === 'modal' && (
                    <button
                        type="button"
                        className="button button-secondary modal-close"
                        disabled={isSubmitting}
                    >
                        Cancel
                    </button>
                )}
                <button
                    type="submit"
                    className="button button-primary"
                    disabled={isSubmitting}
                >
                    {isSubmitting ? (
                        <>
                            <span className="spinner" />
                            Saving...
                        </>
                    ) : (
                        'Save Changes'
                    )}
                </button>
            </div>
        </Form>
    );
};

interface FormFieldProps {
    label: string;
    name: string;
    type: string;
    value: any;
    required?: boolean;
    options?: Record<string, string>;
    min?: number;
    max?: number;
    step?: number;
}

const FormField: React.FC<FormFieldProps> = ({
    label,
    name,
    type,
    value,
    required,
    options,
    ...props
}) => {
    return (
        <div className={`form-field field-${name}`}>
            <label htmlFor={name}>
                {label}
                {required && <span className="required">*</span>}
            </label>

            {type === 'select' ? (
                <select
                    id={name}
                    name={name}
                    value={value}
                    required={required}
                >
                    <option value="">Select {label}</option>
                    {Object.entries(options || {}).map(([key, label]) => (
                        <option key={key} value={key}>
                            {label}
                        </option>
                    ))}
                </select>
            ) : (
                <input
                    type={type}
                    id={name}
                    name={name}
                    value={value}
                    required={required}
                    {...props}
                />
            )}
        </div>
    );
};

interface TagInputProps {
    label: string;
    name: string;
    value: string[];
    predefinedOptions: string[];
}

const TagInput: React.FC<TagInputProps> = ({
    label,
    name,
    value,
    predefinedOptions
}) => {
    const [tags, setTags] = useState<string[]>(value);
    const [input, setInput] = useState('');
    const [showSuggestions, setShowSuggestions] = useState(false);

    const handleAddTag = (tag: string) => {
        if (tag && !tags.includes(tag)) {
            const newTags = [...tags, tag];
            setTags(newTags);
            setInput('');
        }
    };

    const handleRemoveTag = (tagToRemove: string) => {
        setTags(tags.filter(tag => tag !== tagToRemove));
    };

    return (
        <div className="form-field field-tag-input">
            <label htmlFor={`${name}-input`}>{label}</label>
            <div className="tag-input-container">
                <div className="tag-list">
                    {tags.map(tag => (
                        <div key={tag} className="tag-item">
                            <span className="tag-text">{tag}</span>
                            <button
                                type="button"
                                className="remove-tag"
                                onClick={() => handleRemoveTag(tag)}
                                aria-label={`Remove ${tag}`}
                            >
                                ×
                            </button>
                        </div>
                    ))}
                </div>
                <input
                    type="text"
                    id={`${name}-input`}
                    value={input}
                    onChange={e => setInput(e.target.value)}
                    onFocus={() => setShowSuggestions(true)}
                    onBlur={() => setTimeout(() => setShowSuggestions(false), 200)}
                    placeholder="Type or select..."
                />
                <input
                    type="hidden"
                    name={name}
                    value={JSON.stringify(tags)}
                />
                {showSuggestions && (
                    <div className="tag-suggestions">
                        {predefinedOptions
                            .filter(option => 
                                !tags.includes(option) &&
                                option.toLowerCase().includes(input.toLowerCase())
                            )
                            .map(option => (
                                <div
                                    key={option}
                                    className="tag-suggestion"
                                    onClick={() => handleAddTag(option)}
                                >
                                    {option}
                                </div>
                            ))}
                    </div>
                )}
            </div>
        </div>
    );
}; 