import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query';
import { apiFetch } from '@wordpress/api-fetch';

const QUERY_KEYS = {
    workouts: 'workouts',
    workoutTypes: 'workout-types',
    stats: 'workout-stats'
} as const;

export interface Workout {
    id: string;
    date: string;
    type: string;
    duration: number;
    intensity: 'low' | 'medium' | 'high';
    notes?: string;
    exercises: Array<{
        name: string;
        sets: number;
        reps: number;
        weight?: number;
        notes?: string;
    }>;
}

export interface WorkoutType {
    id: string;
    name: string;
    description?: string;
    category: string;
    defaultDuration?: number;
}

export interface WorkoutStats {
    totalWorkouts: number;
    totalDuration: number;
    averageIntensity: number;
    workoutsByType: Record<string, number>;
    recentStreak: number;
}

interface UseWorkoutTrackerOptions {
    onError?: (error: Error) => void;
    onSuccess?: (data: any) => void;
}

interface ApiResponse<T = any> {
    success: boolean;
    message: string;
    data?: T;
}

export function useWorkoutTracker(options: UseWorkoutTrackerOptions = {}) {
    const queryClient = useQueryClient();
    const endpoints = (window as any).workoutTrackerData?.endpoints || {
        workouts: '/wp-json/athlete-dashboard/v1/workouts',
        types: '/wp-json/athlete-dashboard/v1/workout-types',
        stats: '/wp-json/athlete-dashboard/v1/workout-stats'
    };

    // Fetch workouts
    const {
        data: workouts,
        isLoading: isLoadingWorkouts,
        error: workoutsError
    } = useQuery<Workout[], Error>({
        queryKey: [QUERY_KEYS.workouts],
        queryFn: async () => {
            const response = await apiFetch<ApiResponse<Workout[]>>({
                path: endpoints.workouts,
                method: 'GET'
            });
            return response.data || [];
        },
        retry: 1,
        staleTime: 5 * 60 * 1000, // 5 minutes
        onError: options.onError
    });

    // Fetch workout types
    const {
        data: workoutTypes,
        isLoading: isLoadingTypes,
        error: typesError
    } = useQuery<WorkoutType[], Error>({
        queryKey: [QUERY_KEYS.workoutTypes],
        queryFn: async () => {
            const response = await apiFetch<ApiResponse<WorkoutType[]>>({
                path: endpoints.types,
                method: 'GET'
            });
            return response.data || [];
        },
        staleTime: 24 * 60 * 60 * 1000, // 24 hours
        onError: options.onError
    });

    // Fetch workout stats
    const {
        data: stats,
        isLoading: isLoadingStats,
        error: statsError
    } = useQuery<WorkoutStats, Error>({
        queryKey: [QUERY_KEYS.stats],
        queryFn: async () => {
            const response = await apiFetch<ApiResponse<WorkoutStats>>({
                path: endpoints.stats,
                method: 'GET'
            });
            return response.data;
        },
        staleTime: 5 * 60 * 1000, // 5 minutes
        onError: options.onError
    });

    // Add workout
    const { mutate: addWorkout, isLoading: isAddingWorkout } = useMutation<
        ApiResponse<Workout>,
        Error,
        Omit<Workout, 'id'>
    >({
        mutationFn: async (newWorkout) => {
            const response = await apiFetch<ApiResponse<Workout>>({
                path: endpoints.workouts,
                method: 'POST',
                data: newWorkout
            });
            return response;
        },
        onSuccess: (response) => {
            // Update workouts cache
            queryClient.setQueryData<Workout[]>([QUERY_KEYS.workouts], (old = []) => [
                ...old,
                response.data
            ]);
            // Invalidate stats
            queryClient.invalidateQueries([QUERY_KEYS.stats]);
            options.onSuccess?.(response.data);
        },
        onError: options.onError
    });

    // Update workout
    const { mutate: updateWorkout, isLoading: isUpdatingWorkout } = useMutation<
        ApiResponse<Workout>,
        Error,
        Workout
    >({
        mutationFn: async (workout) => {
            const response = await apiFetch<ApiResponse<Workout>>({
                path: `${endpoints.workouts}/${workout.id}`,
                method: 'PUT',
                data: workout
            });
            return response;
        },
        onSuccess: (response) => {
            // Update workouts cache
            queryClient.setQueryData<Workout[]>([QUERY_KEYS.workouts], (old = []) =>
                old.map((w) => (w.id === response.data.id ? response.data : w))
            );
            // Invalidate stats
            queryClient.invalidateQueries([QUERY_KEYS.stats]);
            options.onSuccess?.(response.data);
        },
        onError: options.onError
    });

    // Delete workout
    const { mutate: deleteWorkout, isLoading: isDeletingWorkout } = useMutation<
        ApiResponse,
        Error,
        string
    >({
        mutationFn: async (workoutId) => {
            const response = await apiFetch<ApiResponse>({
                path: `${endpoints.workouts}/${workoutId}`,
                method: 'DELETE'
            });
            return response;
        },
        onSuccess: (_, workoutId) => {
            // Update workouts cache
            queryClient.setQueryData<Workout[]>([QUERY_KEYS.workouts], (old = []) =>
                old.filter((w) => w.id !== workoutId)
            );
            // Invalidate stats
            queryClient.invalidateQueries([QUERY_KEYS.stats]);
            options.onSuccess?.(workoutId);
        },
        onError: options.onError
    });

    return {
        // Data
        workouts,
        workoutTypes,
        stats,

        // Loading states
        isLoading: isLoadingWorkouts || isLoadingTypes || isLoadingStats,
        isLoadingWorkouts,
        isLoadingTypes,
        isLoadingStats,

        // Error states
        error: workoutsError || typesError || statsError,
        workoutsError,
        typesError,
        statsError,

        // Mutations
        addWorkout,
        isAddingWorkout,
        updateWorkout,
        isUpdatingWorkout,
        deleteWorkout,
        isDeletingWorkout
    };
} 