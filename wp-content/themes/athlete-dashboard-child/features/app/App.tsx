import React from 'react';
import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import { ReactQueryDevtools } from '@tanstack/react-query-devtools';
import { WorkoutTracker } from '../workout/components/WorkoutTracker';
import { ProfileEditor } from '../profile/components/ProfileEditor';
import { TrainingPersonaEditor } from '../training/components/TrainingPersonaEditor';

const queryClient = new QueryClient({
    defaultOptions: {
        queries: {
            staleTime: 5 * 60 * 1000, // 5 minutes
            cacheTime: 30 * 60 * 1000, // 30 minutes
            retry: 2,
            refetchOnWindowFocus: true
        }
    }
});

export const App: React.FC = () => {
    return (
        <QueryClientProvider client={queryClient}>
            <div className="app">
                <ProfileEditor />
                <TrainingPersonaEditor />
                <WorkoutTracker />
            </div>
            {process.env.NODE_ENV === 'development' && <ReactQueryDevtools initialIsOpen={false} />}
        </QueryClientProvider>
    );
}; 