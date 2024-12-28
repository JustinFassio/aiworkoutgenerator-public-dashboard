import React from 'react';
import { createRoot } from 'react-dom/client';
import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import { ReactQueryDevtools } from '@tanstack/react-query-devtools';
import { App } from './App';
import './styles/index.scss';

const queryClient = new QueryClient({
    defaultOptions: {
        queries: {
            gcTime: 30 * 60 * 1000, // 30 minutes
            staleTime: 5 * 60 * 1000, // 5 minutes
            retry: 1,
            refetchOnWindowFocus: false,
        },
    },
});

const initDashboard = () => {
    const container = document.getElementById('dashboard-root');
    if (!container) return;

    const root = createRoot(container);
    root.render(
        <React.StrictMode>
            <QueryClientProvider client={queryClient}>
                <App />
                {process.env.NODE_ENV === 'development' && (
                    <ReactQueryDevtools initialIsOpen={false} />
                )}
            </QueryClientProvider>
        </React.StrictMode>
    );
};

// Run initialization when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDashboard);
} else {
    initDashboard();
} 