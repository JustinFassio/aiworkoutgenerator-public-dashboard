import { useMutation, useQueryClient } from '@tanstack/react-query';
import type { Profile, ProfileFormData, ProfileUpdateResponse } from '../types/Profile';

interface UseProfileMutationsOptions {
    onUpdateSuccess?: (data: ProfileUpdateResponse) => void;
    onUpdateError?: (error: Error) => void;
}

async function updateProfileData(data: ProfileFormData): Promise<ProfileUpdateResponse> {
    const response = await fetch('/wp-json/athlete/v1/profile', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    });

    if (!response.ok) {
        const error = await response.json();
        throw new Error(error.message || 'Failed to update profile');
    }

    return response.json();
}

async function updateProfileAvatar(file: File): Promise<ProfileUpdateResponse> {
    const formData = new FormData();
    formData.append('avatar', file);

    const response = await fetch('/wp-json/athlete/v1/profile/avatar', {
        method: 'POST',
        body: formData,
    });

    if (!response.ok) {
        const error = await response.json();
        throw new Error(error.message || 'Failed to update avatar');
    }

    return response.json();
}

export function useProfileMutations(options: UseProfileMutationsOptions = {}) {
    const queryClient = useQueryClient();
    const queryKey = ['profile'];

    const updateProfile = useMutation<ProfileUpdateResponse, Error, ProfileFormData>({
        mutationFn: updateProfileData,
        onSuccess: (data) => {
            if (data.profile) {
                queryClient.setQueryData<Profile>(queryKey, data.profile);
            }
            options.onUpdateSuccess?.(data);
        },
        onError: (error) => {
            options.onUpdateError?.(error);
        },
    });

    const updateAvatar = useMutation<ProfileUpdateResponse, Error, File>({
        mutationFn: updateProfileAvatar,
        onSuccess: (data) => {
            if (data.profile) {
                queryClient.setQueryData<Profile>(queryKey, data.profile);
            }
        },
    });

    return {
        updateProfile: {
            mutate: updateProfile.mutate,
            isLoading: updateProfile.isLoading,
            error: updateProfile.error,
        },
        updateAvatar: {
            mutate: updateAvatar.mutate,
            isLoading: updateAvatar.isLoading,
            error: updateAvatar.error,
        },
    };
} 