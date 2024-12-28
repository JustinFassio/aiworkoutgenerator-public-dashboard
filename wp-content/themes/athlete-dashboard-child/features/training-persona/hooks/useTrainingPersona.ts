import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query';
import { apiFetch } from '@wordpress/api-fetch';
import type { TrainingPersonaData, ApiResponse } from '../types/training-persona.types';

const QUERY_KEY = 'training-persona';

interface UseTrainingPersonaOptions {
    onError?: (error: Error) => void;
    onSuccess?: (data: TrainingPersonaData) => void;
}

export function useTrainingPersona(options: UseTrainingPersonaOptions = {}) {
    const queryClient = useQueryClient();
    const endpoints = (window as any).trainingPersonaData?.endpoints || {};

    // Fetch training persona data
    const { data, isLoading, error } = useQuery<TrainingPersonaData, Error>({
        queryKey: [QUERY_KEY],
        queryFn: async () => {
            const response = await apiFetch<TrainingPersonaData>({
                path: endpoints.get,
                method: 'GET'
            });
            return response;
        },
        retry: 1,
        staleTime: 5 * 60 * 1000, // 5 minutes
        onError: options.onError
    });

    // Update training persona data
    const { mutate: updateTrainingPersona, isLoading: isUpdating } = useMutation<
        ApiResponse,
        Error,
        TrainingPersonaData
    >({
        mutationFn: async (newData) => {
            const response = await apiFetch<ApiResponse>({
                path: endpoints.save,
                method: 'POST',
                data: newData
            });
            return response;
        },
        onSuccess: (response) => {
            // Update cache with new data
            queryClient.setQueryData([QUERY_KEY], response.data);
            options.onSuccess?.(response.data);
        },
        onError: options.onError
    });

    return {
        data,
        isLoading,
        error,
        updateTrainingPersona,
        isUpdating
    };
} 