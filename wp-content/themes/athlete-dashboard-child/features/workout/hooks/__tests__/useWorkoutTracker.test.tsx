import { renderHook, act } from '@testing-library/react-hooks';
import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import { useWorkoutTracker, Workout, WorkoutType, WorkoutStats } from '../useWorkoutTracker';
import { apiFetch } from '@wordpress/api-fetch';

// Mock wp-api-fetch
jest.mock('@wordpress/api-fetch');
const mockedApiFetch = apiFetch as jest.MockedFunction<typeof apiFetch>;

// Mock data
const mockWorkouts: Workout[] = [
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

const mockWorkoutTypes: WorkoutType[] = [
    {
        id: 'strength',
        name: 'Strength Training',
        description: 'Build muscle and strength',
        category: 'resistance',
        defaultDuration: 60
    }
];

const mockStats: WorkoutStats = {
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

describe('useWorkoutTracker', () => {
    beforeEach(() => {
        jest.clearAllMocks();
    });

    it('fetches all workout data successfully', async () => {
        mockedApiFetch
            .mockResolvedValueOnce({ success: true, data: mockWorkouts })
            .mockResolvedValueOnce({ success: true, data: mockWorkoutTypes })
            .mockResolvedValueOnce({ success: true, data: mockStats });

        const { result, waitFor } = renderHook(() => useWorkoutTracker(), {
            wrapper: createWrapper()
        });

        // Initial state should be loading
        expect(result.current.isLoading).toBe(true);

        // Wait for all queries to complete
        await waitFor(() => !result.current.isLoading);

        // Verify data is loaded
        expect(result.current.workouts).toEqual(mockWorkouts);
        expect(result.current.workoutTypes).toEqual(mockWorkoutTypes);
        expect(result.current.stats).toEqual(mockStats);
        expect(mockedApiFetch).toHaveBeenCalledTimes(3);
    });

    it('handles fetch errors correctly', async () => {
        const error = new Error('Failed to fetch workouts');
        mockedApiFetch
            .mockRejectedValueOnce(error)
            .mockResolvedValueOnce({ success: true, data: mockWorkoutTypes })
            .mockResolvedValueOnce({ success: true, data: mockStats });

        const onError = jest.fn();
        const { result, waitFor } = renderHook(() => useWorkoutTracker({ onError }), {
            wrapper: createWrapper()
        });

        // Wait for queries to complete
        await waitFor(() => !result.current.isLoadingWorkouts);

        // Verify error handling
        expect(result.current.workoutsError).toBeTruthy();
        expect(onError).toHaveBeenCalledWith(error);
    });

    it('adds workout successfully', async () => {
        const newWorkout: Omit<Workout, 'id'> = {
            date: '2024-01-02',
            type: 'strength',
            duration: 45,
            intensity: 'high',
            exercises: [
                {
                    name: 'Squats',
                    sets: 4,
                    reps: 8,
                    weight: 185
                }
            ]
        };

        const createdWorkout: Workout = { id: '2', ...newWorkout };

        mockedApiFetch
            .mockResolvedValueOnce({ success: true, data: mockWorkouts })
            .mockResolvedValueOnce({ success: true, data: mockWorkoutTypes })
            .mockResolvedValueOnce({ success: true, data: mockStats })
            .mockResolvedValueOnce({ success: true, data: createdWorkout });

        const onSuccess = jest.fn();
        const { result, waitFor } = renderHook(() => useWorkoutTracker({ onSuccess }), {
            wrapper: createWrapper()
        });

        // Wait for initial data load
        await waitFor(() => !result.current.isLoading);

        // Add new workout
        act(() => {
            result.current.addWorkout(newWorkout);
        });

        // Wait for mutation to complete
        await waitFor(() => !result.current.isAddingWorkout);

        // Verify workout was added
        expect(result.current.workouts).toContainEqual(createdWorkout);
        expect(onSuccess).toHaveBeenCalledWith(createdWorkout);
    });

    it('updates workout successfully', async () => {
        const updatedWorkout: Workout = {
            ...mockWorkouts[0],
            duration: 75,
            notes: 'Updated workout'
        };

        mockedApiFetch
            .mockResolvedValueOnce({ success: true, data: mockWorkouts })
            .mockResolvedValueOnce({ success: true, data: mockWorkoutTypes })
            .mockResolvedValueOnce({ success: true, data: mockStats })
            .mockResolvedValueOnce({ success: true, data: updatedWorkout });

        const onSuccess = jest.fn();
        const { result, waitFor } = renderHook(() => useWorkoutTracker({ onSuccess }), {
            wrapper: createWrapper()
        });

        // Wait for initial data load
        await waitFor(() => !result.current.isLoading);

        // Update workout
        act(() => {
            result.current.updateWorkout(updatedWorkout);
        });

        // Wait for mutation to complete
        await waitFor(() => !result.current.isUpdatingWorkout);

        // Verify workout was updated
        expect(result.current.workouts?.[0]).toEqual(updatedWorkout);
        expect(onSuccess).toHaveBeenCalledWith(updatedWorkout);
    });

    it('deletes workout successfully', async () => {
        mockedApiFetch
            .mockResolvedValueOnce({ success: true, data: mockWorkouts })
            .mockResolvedValueOnce({ success: true, data: mockWorkoutTypes })
            .mockResolvedValueOnce({ success: true, data: mockStats })
            .mockResolvedValueOnce({ success: true, message: 'Workout deleted' });

        const onSuccess = jest.fn();
        const { result, waitFor } = renderHook(() => useWorkoutTracker({ onSuccess }), {
            wrapper: createWrapper()
        });

        // Wait for initial data load
        await waitFor(() => !result.current.isLoading);

        // Delete workout
        act(() => {
            result.current.deleteWorkout('1');
        });

        // Wait for mutation to complete
        await waitFor(() => !result.current.isDeletingWorkout);

        // Verify workout was deleted
        expect(result.current.workouts).toHaveLength(0);
        expect(onSuccess).toHaveBeenCalledWith('1');
    });

    it('handles mutation errors correctly', async () => {
        const error = new Error('Failed to add workout');
        mockedApiFetch
            .mockResolvedValueOnce({ success: true, data: mockWorkouts })
            .mockResolvedValueOnce({ success: true, data: mockWorkoutTypes })
            .mockResolvedValueOnce({ success: true, data: mockStats })
            .mockRejectedValueOnce(error);

        const onError = jest.fn();
        const { result, waitFor } = renderHook(() => useWorkoutTracker({ onError }), {
            wrapper: createWrapper()
        });

        // Wait for initial data load
        await waitFor(() => !result.current.isLoading);

        // Attempt to add workout
        act(() => {
            result.current.addWorkout({
                date: '2024-01-02',
                type: 'strength',
                duration: 45,
                intensity: 'high',
                exercises: []
            });
        });

        // Wait for mutation to fail
        await waitFor(() => !result.current.isAddingWorkout);

        // Verify error handling
        expect(onError).toHaveBeenCalledWith(error);
        expect(result.current.workouts).toEqual(mockWorkouts); // Data should remain unchanged
    });
}); 