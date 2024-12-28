import React from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import { WorkoutTracker } from '../WorkoutTracker';
import type { DashboardUser } from '@dashboard/types/dashboard';

describe('WorkoutTracker Component', () => {
    const mockUser: DashboardUser = {
        id: 1,
        roles: ['athlete']
    };

    const mockWorkout = {
        id: 1,
        title: 'Full Body Strength',
        type: 'Strength',
        duration: 60,
        exercises: [
            { name: 'Squats', sets: 3, reps: 12, weight: 135 },
            { name: 'Bench Press', sets: 3, reps: 10, weight: 155 },
            { name: 'Deadlifts', sets: 3, reps: 8, weight: 225 }
        ],
        notes: 'Focus on form and controlled movements',
        completed: false,
        date: new Date().toISOString()
    };

    it('renders without crashing', () => {
        render(<WorkoutTracker user={mockUser} workout={mockWorkout} />);
        expect(screen.getByText('Workout Tracker')).toBeInTheDocument();
    });

    it('displays workout details correctly', () => {
        render(<WorkoutTracker user={mockUser} workout={mockWorkout} />);
        expect(screen.getByText(mockWorkout.title)).toBeInTheDocument();
        expect(screen.getByText(mockWorkout.type)).toBeInTheDocument();
        expect(screen.getByText(`${mockWorkout.duration} minutes`)).toBeInTheDocument();
    });

    it('displays exercise list correctly', () => {
        render(<WorkoutTracker user={mockUser} workout={mockWorkout} />);
        mockWorkout.exercises.forEach(exercise => {
            expect(screen.getByText(exercise.name)).toBeInTheDocument();
            expect(screen.getByText(`${exercise.sets}x${exercise.reps}`)).toBeInTheDocument();
            expect(screen.getByText(`${exercise.weight} lbs`)).toBeInTheDocument();
        });
    });

    it('displays workout notes', () => {
        render(<WorkoutTracker user={mockUser} workout={mockWorkout} />);
        expect(screen.getByText(mockWorkout.notes)).toBeInTheDocument();
    });

    it('opens edit modal when clicking edit button', () => {
        render(<WorkoutTracker user={mockUser} workout={mockWorkout} />);
        fireEvent.click(screen.getByText('Edit Workout'));
        expect(screen.getByRole('dialog')).toBeInTheDocument();
        expect(screen.getByText('Edit Workout')).toBeInTheDocument();
    });

    describe('Edit Form', () => {
        beforeEach(() => {
            render(<WorkoutTracker user={mockUser} workout={mockWorkout} />);
            fireEvent.click(screen.getByText('Edit Workout'));
        });

        it('pre-fills form with current workout data', () => {
            expect(screen.getByDisplayValue(mockWorkout.title)).toBeInTheDocument();
            expect(screen.getByDisplayValue(mockWorkout.type)).toBeInTheDocument();
            expect(screen.getByDisplayValue(mockWorkout.duration.toString())).toBeInTheDocument();
        });

        it('shows all workout type options', () => {
            const select = screen.getByLabelText('Workout Type');
            expect(select).toBeInTheDocument();
            ['Strength', 'Cardio', 'HIIT', 'Flexibility'].forEach(type => {
                expect(screen.getByText(type)).toBeInTheDocument();
            });
        });

        it('allows updating workout duration', () => {
            const input = screen.getByLabelText('Duration (minutes)');
            fireEvent.change(input, { target: { value: '45' } });
            expect(input).toHaveValue(45);
        });

        it('displays exercise list with edit options', () => {
            mockWorkout.exercises.forEach(exercise => {
                expect(screen.getByDisplayValue(exercise.name)).toBeInTheDocument();
                expect(screen.getByDisplayValue(exercise.sets.toString())).toBeInTheDocument();
                expect(screen.getByDisplayValue(exercise.reps.toString())).toBeInTheDocument();
                expect(screen.getByDisplayValue(exercise.weight.toString())).toBeInTheDocument();
            });
        });

        it('allows adding new exercises', () => {
            fireEvent.click(screen.getByText('Add Exercise'));
            const newExerciseInputs = screen.getAllByPlaceholderText('Exercise Name');
            expect(newExerciseInputs.length).toBe(mockWorkout.exercises.length + 1);
        });

        it('allows removing exercises', () => {
            const removeButtons = screen.getAllByText('Remove');
            fireEvent.click(removeButtons[0]);
            expect(screen.queryByDisplayValue(mockWorkout.exercises[0].name)).not.toBeInTheDocument();
        });

        it('allows updating workout notes', () => {
            const notesInput = screen.getByLabelText('Workout Notes');
            fireEvent.change(notesInput, { target: { value: 'Updated notes' } });
            expect(notesInput).toHaveValue('Updated notes');
        });

        it('closes modal when clicking cancel', () => {
            fireEvent.click(screen.getByText('Cancel'));
            expect(screen.queryByRole('dialog')).not.toBeInTheDocument();
        });

        it('shows loading state when saving', async () => {
            fireEvent.click(screen.getByText('Save Changes'));
            expect(screen.getByText('Saving...')).toBeInTheDocument();
            await waitFor(() => {
                expect(screen.queryByText('Saving...')).not.toBeInTheDocument();
            });
        });
    });

    describe('Workout Completion', () => {
        it('allows marking workout as complete', async () => {
            render(<WorkoutTracker user={mockUser} workout={mockWorkout} />);
            fireEvent.click(screen.getByText('Complete Workout'));
            expect(screen.getByText('Completing...')).toBeInTheDocument();
            await waitFor(() => {
                expect(screen.getByText('Workout Completed')).toBeInTheDocument();
            });
        });

        it('shows completion time when workout is marked as complete', async () => {
            const completedWorkout = { ...mockWorkout, completed: true };
            render(<WorkoutTracker user={mockUser} workout={completedWorkout} />);
            expect(screen.getByText('Completed')).toBeInTheDocument();
            expect(screen.getByText(/Completed at/)).toBeInTheDocument();
        });
    });
}); 