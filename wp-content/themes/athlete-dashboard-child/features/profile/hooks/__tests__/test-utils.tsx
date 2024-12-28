import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import { renderHook } from '@testing-library/react-hooks';
import type { Profile } from '../../types/Profile';

export const mockProfile: Profile = {
    id: 1,
    name: 'John Doe',
    email: 'john@example.com',
    bio: 'Test bio',
    avatarUrl: 'https://example.com/avatar.jpg',
    stats: {
        workoutsCompleted: 10,
        totalMinutes: 600,
        averageIntensity: 7.5,
        streakDays: 5,
    },
    preferences: {
        notifications: true,
        weeklyGoal: 3,
        preferredWorkoutTypes: ['strength', 'cardio'],
        availableDays: ['monday', 'wednesday', 'friday'],
        timePreference: 'morning',
    },
};

export function createWrapper() {
    const queryClient = new QueryClient({
        defaultOptions: {
            queries: {
                retry: false,
            },
        },
    });
    return ({ children }: { children: React.ReactNode }) => (
        <QueryClientProvider client={queryClient}>{children}</QueryClientProvider>
    );
}

export function renderHookWithClient<TProps, TResult>(
    callback: (props: TProps) => TResult,
) {
    return renderHook(callback, {
        wrapper: createWrapper(),
    });
} 