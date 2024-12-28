import React, { useState } from 'react';
import type { FeatureProps } from '@dashboard/types/dashboard';

interface WorkoutFormData {
    title: string;
    description: string;
    date: string;
    duration: number;
    type: string;
    intensity: 'low' | 'medium' | 'high';
}

interface Workout extends WorkoutFormData {
    id: string;
    userId: number;
    createdAt: string;
    updatedAt: string;
}

interface WorkoutTrackerProps extends FeatureProps {
    onSaveWorkout: (workout: WorkoutFormData) => Promise<void>;
    onUpdateWorkout: (workout: Workout) => Promise<void>;
    onDeleteWorkout: (workoutId: string) => Promise<void>;
}

export const WorkoutTracker: React.FC<WorkoutTrackerProps> = ({
    onSaveWorkout,
    onUpdateWorkout,
    onDeleteWorkout
}) => {
    const [workouts] = useState<Workout[]>([]);

    return (
        <div className="workout-tracker">
            <h1>Workout Tracker</h1>
            <div className="workout-actions">
                <button 
                    className="button button-primary"
                    onClick={() => {
                        const newWorkout: WorkoutFormData = {
                            title: 'New Workout',
                            description: '',
                            date: new Date().toISOString().split('T')[0],
                            duration: 60,
                            type: 'General',
                            intensity: 'medium'
                        };
                        onSaveWorkout(newWorkout);
                    }}
                >
                    Add New Workout
                </button>
            </div>
            <div className="workouts-list">
                {workouts.map(workout => (
                    <div key={workout.id} className="workout-card">
                        <h3>{workout.title}</h3>
                        <p>{workout.description}</p>
                        <div className="workout-meta">
                            <span>Date: {workout.date}</span>
                            <span>Duration: {workout.duration} minutes</span>
                            <span>Type: {workout.type}</span>
                            <span>Intensity: {workout.intensity}</span>
                        </div>
                        <div className="workout-actions">
                            <button onClick={() => onUpdateWorkout(workout)}>
                                Edit
                            </button>
                            <button onClick={() => onDeleteWorkout(workout.id)}>
                                Delete
                            </button>
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
}; 