import { useQuery } from '@tanstack/react-query';
import type { Profile, ProfileError } from '../types/Profile';

interface UseProfileOptions {
    enabled?: boolean;
}

async function fetchProfile(): Promise<Profile> {
    const response = await fetch('/wp-json/athlete/v1/profile');
    if (!response.ok) {
        const error = await response.json();
        throw new Error(error.message || 'Failed to fetch profile');
    }
    return response.json();
}

export function useProfile(options: UseProfileOptions = {}) {
    return useQuery<Profile, Error>({
        queryKey: ['profile'],
        queryFn: fetchProfile,
        ...options,
        retry: 1,
        staleTime: 5 * 60 * 1000, // 5 minutes
        gcTime: 30 * 60 * 1000, // 30 minutes
    });
} 