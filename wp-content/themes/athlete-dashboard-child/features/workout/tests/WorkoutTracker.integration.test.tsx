import React from 'react';
import { render, screen, waitFor, fireEvent } from '@testing-library/react';
import userEvent from '@testing-library/user-event';
import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import { WorkoutTracker } from '../components/WorkoutTracker';
import { apiFetch } from '@wordpress/api-fetch';

// Mock wp-api-fetch
jest.mock('@wordpress/api-fetch');
const mockedApiFetch = apiFetch as jest.MockedFunction<typeof apiFetch>;

// Mock data
const mockWorkouts = [
    {
        id: '1',
        date: '2024-01-01',
        type: 'strength',
        duration: 60,
        intensity: 'medium',
        exercises: [
            {
                name: 'Bench Press',
                sets: 3,
                reps: 10,
                weight: 135
            }
        ]
    }
];

const mockWorkoutTypes = [
    {
        id: 'strength',
        name: 'Strength Training',
        description: 'Build muscle and strength',
        category: 'resistance',
        defaultDuration: 60
    }
];

const mockStats = {
    totalWorkouts: 1,
    totalDuration: 60,
    averageIntensity: 2,
    workoutsByType: { strength: 1 },
    recentStreak: 1
};

// Test wrapper setup
const createWrapper = () => {
    const queryClient = new QueryClient({
        defaultOptions: {
            queries: {
                retry: false,
                cacheTime: 0
            }
        }
    });
    return ({ children }: { children: React.ReactNode }) => (
        <QueryClientProvider client={queryClient}>
            {children}
        </QueryClientProvider>
    );
};

describe('WorkoutTracker Integration', () => {
    beforeEach(() => {
        jest.clearAllMocks();
    });

    it('renders loading state initially', () => {
        mockedApiFetch
            .mockImplementation(() => new Promise(() => {})); // Never resolves

        render(<WorkoutTracker />, { wrapper: createWrapper() });
        expect(screen.getByTestId('loading-spinner')).toBeInTheDocument();
    });

    it('renders error state when data fetch fails', async () => {
        mockedApiFetch.mockRejectedValue(new Error('Failed to fetch'));

        render(<WorkoutTracker />, { wrapper: createWrapper() });

        await waitFor(() => {
            expect(screen.getByText(/failed to load workout data/i)).toBeInTheDocument();
        });
    });

    it('renders workout data and allows adding new workout', async () => {
        // Mock initial data fetch
        mockedApiFetch
            .mockResolvedValueOnce({ success: true, data: mockWorkouts })
            .mockResolvedValueOnce({ success: true, data: mockWorkoutTypes })
            .mockResolvedValueOnce({ success: true, data: mockStats });

        // Mock workout creation
        const newWorkout = {
            id: '2',
            date: '2024-01-02',
            type: 'strength',
            duration: 45,
            intensity: 'high',
            exercises: []
        };
        mockedApiFetch.mockResolvedValueOnce({ success: true, data: newWorkout });

        render(<WorkoutTracker />, { wrapper: createWrapper() });

        // Wait for data to load
        await waitFor(() => {
            expect(screen.getByText(/workout tracker/i)).toBeInTheDocument();
        });

        // Verify initial data is displayed
        expect(screen.getByText(/bench press/i)).toBeInTheDocument();
        expect(screen.getByText(/total workouts: 1/i)).toBeInTheDocument();

        // Fill out new workout form
        userEvent.type(screen.getByLabelText(/date/i), '2024-01-02');
        userEvent.selectOptions(screen.getByLabelText(/type/i), 'strength');
        userEvent.type(screen.getByLabelText(/duration/i), '45');
        userEvent.selectOptions(screen.getByLabelText(/intensity/i), 'high');

        // Submit form
        fireEvent.click(screen.getByText(/add workout/i));

        // Verify new workout is added
        await waitFor(() => {
            expect(mockedApiFetch).toHaveBeenCalledWith({
                path: '/wp/v2/workouts',
                method: 'POST',
                data: expect.objectContaining({
                    date: '2024-01-02',
                    type: 'strength',
                    duration: 45,
                    intensity: 'high'
                })
            });
        });
    });

    it('allows updating existing workout', async () => {
        // Mock initial data fetch
        mockedApiFetch
            .mockResolvedValueOnce({ success: true, data: mockWorkouts })
            .mockResolvedValueOnce({ success: true, data: mockWorkoutTypes })
            .mockResolvedValueOnce({ success: true, data: mockStats });

        // Mock workout update
        const updatedWorkout = {
            ...mockWorkouts[0],
            duration: 75
        };
        mockedApiFetch.mockResolvedValueOnce({ success: true, data: updatedWorkout });

        render(<WorkoutTracker />, { wrapper: createWrapper() });

        // Wait for data to load
        await waitFor(() => {
            expect(screen.getByText(/bench press/i)).toBeInTheDocument();
        });

        // Click edit button
        fireEvent.click(screen.getByTestId('edit-workout-1'));

        // Update duration
        const durationInput = screen.getByLabelText(/duration/i);
        userEvent.clear(durationInput);
        userEvent.type(durationInput, '75');

        // Save changes
        fireEvent.click(screen.getByText(/save/i));

        // Verify workout is updated
        await waitFor(() => {
            expect(mockedApiFetch).toHaveBeenCalledWith({
                path: '/wp/v2/workouts/1',
                method: 'PUT',
                data: expect.objectContaining({
                    duration: 75
                })
            });
        });
    });

    it('allows deleting workout', async () => {
        // Mock initial data fetch
        mockedApiFetch
            .mockResolvedValueOnce({ success: true, data: mockWorkouts })
            .mockResolvedValueOnce({ success: true, data: mockWorkoutTypes })
            .mockResolvedValueOnce({ success: true, data: mockStats });

        // Mock workout deletion
        mockedApiFetch.mockResolvedValueOnce({ success: true, message: 'Workout deleted' });

        render(<WorkoutTracker />, { wrapper: createWrapper() });

        // Wait for data to load
        await waitFor(() => {
            expect(screen.getByText(/bench press/i)).toBeInTheDocument();
        });

        // Click delete button
        fireEvent.click(screen.getByTestId('delete-workout-1'));

        // Confirm deletion
        fireEvent.click(screen.getByText(/confirm/i));

        // Verify workout is deleted
        await waitFor(() => {
            expect(mockedApiFetch).toHaveBeenCalledWith({
                path: '/wp/v2/workouts/1',
                method: 'DELETE'
            });
        });

        // Verify workout is removed from UI
        await waitFor(() => {
            expect(screen.queryByText(/bench press/i)).not.toBeInTheDocument();
        });
    });

    it('updates stats after workout operations', async () => {
        // Mock initial data fetch
        mockedApiFetch
            .mockResolvedValueOnce({ success: true, data: mockWorkouts })
            .mockResolvedValueOnce({ success: true, data: mockWorkoutTypes })
            .mockResolvedValueOnce({ success: true, data: mockStats });

        // Mock stats update after adding workout
        const updatedStats = {
            ...mockStats,
            totalWorkouts: 2,
            totalDuration: 105
        };
        mockedApiFetch
            .mockResolvedValueOnce({ success: true, data: { id: '2', date: '2024-01-02', type: 'strength', duration: 45 } })
            .mockResolvedValueOnce({ success: true, data: updatedStats });

        render(<WorkoutTracker />, { wrapper: createWrapper() });

        // Wait for initial data to load
        await waitFor(() => {
            expect(screen.getByText(/total workouts: 1/i)).toBeInTheDocument();
        });

        // Add new workout
        userEvent.type(screen.getByLabelText(/date/i), '2024-01-02');
        userEvent.selectOptions(screen.getByLabelText(/type/i), 'strength');
        userEvent.type(screen.getByLabelText(/duration/i), '45');
        fireEvent.click(screen.getByText(/add workout/i));

        // Verify stats are updated
        await waitFor(() => {
            expect(screen.getByText(/total workouts: 2/i)).toBeInTheDocument();
            expect(screen.getByText(/total duration: 105/i)).toBeInTheDocument();
        });
    });
}); 