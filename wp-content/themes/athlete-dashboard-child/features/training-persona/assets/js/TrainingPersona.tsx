import React, { useState } from 'react';
import type { FeatureProps } from '@dashboard/types/dashboard';
import { Modal } from '@dashboard/components/Modal';

interface TrainingPersonaData {
    level: 'beginner' | 'intermediate' | 'advanced';
    goals: string[];
    preferences: {
        workoutDuration: number;
        workoutFrequency: number;
        preferredTypes: string[];
    };
}

interface TrainingPersonaProps extends FeatureProps {
    data: TrainingPersonaData;
}

export const TrainingPersona: React.FC<TrainingPersonaProps> = ({ data }) => {
    const [isModalOpen, setIsModalOpen] = useState(false);

    const handleEditClick = () => {
        setIsModalOpen(true);
    };

    const handleModalClose = () => {
        setIsModalOpen(false);
    };

    return (
        <div className="training-persona">
            <h1>Training Persona</h1>
            <div className="persona-content">
                <div className="persona-section">
                    <h2>Your Training Level</h2>
                    <div className="level-indicator">
                        <span className={`level ${data.level}`}>{data.level}</span>
                    </div>
                </div>

                <div className="persona-section">
                    <h2>Your Goals</h2>
                    <ul className="goals-list">
                        {data.goals.map((goal, index) => (
                            <li key={index}>{goal}</li>
                        ))}
                    </ul>
                </div>

                <div className="persona-section">
                    <h2>Training Preferences</h2>
                    <div className="preferences-grid">
                        <div className="preference-item">
                            <label>Workout Duration</label>
                            <div>{data.preferences.workoutDuration} minutes</div>
                        </div>
                        <div className="preference-item">
                            <label>Weekly Frequency</label>
                            <div>{data.preferences.workoutFrequency} times per week</div>
                        </div>
                        <div className="preference-item">
                            <label>Preferred Workout Types</label>
                            <div>{data.preferences.preferredTypes.join(', ')}</div>
                        </div>
                    </div>
                </div>

                <div className="persona-actions">
                    <button 
                        className="button button-primary"
                        onClick={handleEditClick}
                    >
                        Edit Training Persona
                    </button>
                </div>
            </div>

            <Modal
                isOpen={isModalOpen}
                onClose={handleModalClose}
                title="Edit Training Persona"
            >
                <form className="training-persona-form">
                    <div className="form-field">
                        <label htmlFor="level">Training Level</label>
                        <select 
                            id="level" 
                            name="level" 
                            defaultValue={data.level}
                        >
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="advanced">Advanced</option>
                        </select>
                    </div>

                    <div className="form-field">
                        <label htmlFor="workoutDuration">Workout Duration (minutes)</label>
                        <input 
                            type="number" 
                            id="workoutDuration" 
                            name="workoutDuration"
                            defaultValue={data.preferences.workoutDuration}
                            min={15}
                            max={180}
                            step={15}
                        />
                    </div>

                    <div className="form-field">
                        <label htmlFor="workoutFrequency">Weekly Frequency</label>
                        <input 
                            type="number" 
                            id="workoutFrequency" 
                            name="workoutFrequency"
                            defaultValue={data.preferences.workoutFrequency}
                            min={1}
                            max={7}
                        />
                    </div>

                    <div className="form-field">
                        <label>Preferred Workout Types</label>
                        <div className="checkbox-group">
                            {['Strength', 'HIIT', 'Cardio', 'Yoga', 'Flexibility'].map(type => (
                                <label key={type} className="checkbox-label">
                                    <input 
                                        type="checkbox" 
                                        name="preferredTypes" 
                                        value={type}
                                        defaultChecked={data.preferences.preferredTypes.includes(type)}
                                    />
                                    {type}
                                </label>
                            ))}
                        </div>
                    </div>

                    <div className="form-actions">
                        <button 
                            type="button" 
                            className="button button-secondary"
                            onClick={handleModalClose}
                        >
                            Cancel
                        </button>
                        <button 
                            type="submit" 
                            className="button button-primary"
                        >
                            Save Changes
                        </button>
                    </div>
                </form>
            </Modal>
        </div>
    );
}; 