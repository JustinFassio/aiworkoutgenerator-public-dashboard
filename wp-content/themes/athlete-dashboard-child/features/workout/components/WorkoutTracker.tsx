import React from 'react';
import { useWorkoutTracker } from '../hooks/useWorkoutTracker';
import { LoadingSpinner } from '@/components/LoadingSpinner';
import { ErrorMessage } from '@/components/ErrorMessage';
import { WorkoutList } from './WorkoutList';
import { WorkoutForm } from './WorkoutForm';
import { WorkoutStats } from './WorkoutStats';

export const WorkoutTracker: React.FC = () => {
    const {
        workouts,
        workoutTypes,
        stats,
        isLoading,
        isError,
        addWorkout,
        updateWorkout,
        deleteWorkout,
        isAddingWorkout,
        isUpdatingWorkout,
        isDeletingWorkout
    } = useWorkoutTracker({
        onError: (error) => {
            console.error('Workout operation failed:', error);
        }
    });

    if (isLoading) {
        return <LoadingSpinner />;
    }

    if (isError) {
        return <ErrorMessage message="Failed to load workout data. Please try again later." />;
    }

    return (
        <div className="workout-tracker">
            <h1>Workout Tracker</h1>
            
            {stats && <WorkoutStats stats={stats} />}
            
            <WorkoutForm
                workoutTypes={workoutTypes || []}
                onSubmit={addWorkout}
                isSubmitting={isAddingWorkout}
            />
            
            <WorkoutList
                workouts={workouts || []}
                onUpdate={updateWorkout}
                onDelete={deleteWorkout}
                isUpdating={isUpdatingWorkout}
                isDeleting={isDeletingWorkout}
            />
        </div>
    );
}; 