import React from 'react';
import { createRoot } from 'react-dom/client';
import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import { ReactQueryDevtools } from '@tanstack/react-query-devtools';
import { ProfileEditor } from './components/ProfileEditor';
import './assets/scss/styles.scss';

// Create a client
const queryClient = new QueryClient({
  defaultOptions: {
    queries: {
      staleTime: 5 * 60 * 1000, // 5 minutes
      cacheTime: 30 * 60 * 1000, // 30 minutes
      retry: 1,
    },
  },
});

// Initialize the profile feature
const initProfile = () => {
  const container = document.getElementById('profile-root');
  if (!container) return;

  const root = createRoot(container);
  root.render(
    <React.StrictMode>
      <QueryClientProvider client={queryClient}>
        <ProfileEditor />
        {process.env.NODE_ENV === 'development' && <ReactQueryDevtools />}
      </QueryClientProvider>
    </React.StrictMode>
  );
};

// Run initialization when DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initProfile);
} else {
  initProfile();
} 