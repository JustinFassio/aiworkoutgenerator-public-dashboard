import { renderHook, act } from '@testing-library/react-hooks';
import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import { useProfile, ProfileData, ProfileUpdateData } from '../useProfile';
import { apiFetch } from '@wordpress/api-fetch';

// Mock wp-api-fetch
jest.mock('@wordpress/api-fetch');
const mockedApiFetch = apiFetch as jest.MockedFunction<typeof apiFetch>;

// Mock profile data
const mockProfileData: ProfileData = {
    id: 1,
    name: 'John Doe',
    email: 'john@example.com',
    avatar_url: 'https://example.com/avatar.jpg',
    preferences: {
        notifications: true,
        emailUpdates: false,
        theme: 'light'
    },
    meta: {}
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

describe('useProfile', () => {
    beforeEach(() => {
        // Clear all mocks before each test
        jest.clearAllMocks();
    });

    it('fetches profile data successfully', async () => {
        mockedApiFetch.mockResolvedValueOnce(mockProfileData);

        const { result, waitFor } = renderHook(() => useProfile(), {
            wrapper: createWrapper()
        });

        // Initial state should be loading
        expect(result.current.isLoading).toBe(true);
        expect(result.current.data).toBeUndefined();

        // Wait for the query to complete
        await waitFor(() => !result.current.isLoading);

        // Verify data is loaded
        expect(result.current.data).toEqual(mockProfileData);
        expect(result.current.error).toBeNull();
        expect(mockedApiFetch).toHaveBeenCalledTimes(1);
    });

    it('handles fetch error correctly', async () => {
        const error = new Error('Failed to fetch profile');
        mockedApiFetch.mockRejectedValueOnce(error);

        const onError = jest.fn();
        const { result, waitFor } = renderHook(() => useProfile({ onError }), {
            wrapper: createWrapper()
        });

        // Wait for the query to fail
        await waitFor(() => !result.current.isLoading);

        // Verify error handling
        expect(result.current.error).toBeTruthy();
        expect(result.current.data).toBeUndefined();
        expect(onError).toHaveBeenCalledWith(error);
    });

    it('updates profile successfully', async () => {
        const updateData: ProfileUpdateData = {
            name: 'Jane Doe',
            preferences: {
                notifications: false,
                emailUpdates: true,
                theme: 'dark'
            }
        };

        const updatedProfile = { ...mockProfileData, ...updateData };
        mockedApiFetch
            .mockResolvedValueOnce(mockProfileData) // Initial fetch
            .mockResolvedValueOnce({ success: true, message: 'Updated', data: updatedProfile }); // Update

        const onSuccess = jest.fn();
        const { result, waitFor } = renderHook(() => useProfile({ onSuccess }), {
            wrapper: createWrapper()
        });

        // Wait for initial fetch
        await waitFor(() => !result.current.isLoading);

        // Perform update
        act(() => {
            result.current.updateProfile(updateData);
        });

        // Wait for update to complete
        await waitFor(() => !result.current.isUpdating);

        // Verify update
        expect(result.current.data).toEqual(updatedProfile);
        expect(onSuccess).toHaveBeenCalledWith(updatedProfile);
        expect(mockedApiFetch).toHaveBeenCalledTimes(2);
    });

    it('updates avatar successfully', async () => {
        const formData = new FormData();
        formData.append('avatar', new Blob(), 'avatar.jpg');

        const updatedProfile = {
            ...mockProfileData,
            avatar_url: 'https://example.com/new-avatar.jpg'
        };

        mockedApiFetch
            .mockResolvedValueOnce(mockProfileData) // Initial fetch
            .mockResolvedValueOnce({ success: true, message: 'Updated', data: updatedProfile }); // Avatar update

        const onSuccess = jest.fn();
        const { result, waitFor } = renderHook(() => useProfile({ onSuccess }), {
            wrapper: createWrapper()
        });

        // Wait for initial fetch
        await waitFor(() => !result.current.isLoading);

        // Perform avatar update
        act(() => {
            result.current.updateAvatar(formData);
        });

        // Wait for update to complete
        await waitFor(() => !result.current.isUpdatingAvatar);

        // Verify avatar update
        expect(result.current.data?.avatar_url).toBe(updatedProfile.avatar_url);
        expect(onSuccess).toHaveBeenCalledWith(updatedProfile);
    });

    it('updates password successfully', async () => {
        const passwordData = {
            current: 'oldpass',
            new: 'newpass',
            confirm: 'newpass'
        };

        mockedApiFetch
            .mockResolvedValueOnce(mockProfileData) // Initial fetch
            .mockResolvedValueOnce({ success: true, message: 'Password updated', data: mockProfileData });

        const onSuccess = jest.fn();
        const { result, waitFor } = renderHook(() => useProfile({ onSuccess }), {
            wrapper: createWrapper()
        });

        // Wait for initial fetch
        await waitFor(() => !result.current.isLoading);

        // Perform password update
        act(() => {
            result.current.updatePassword(passwordData);
        });

        // Wait for update to complete
        await waitFor(() => !result.current.isUpdatingPassword);

        // Verify password update
        expect(onSuccess).toHaveBeenCalledWith(mockProfileData);
        expect(mockedApiFetch).toHaveBeenCalledWith(expect.objectContaining({
            path: expect.stringContaining('/password'),
            method: 'POST',
            data: passwordData
        }));
    });

    it('handles update errors correctly', async () => {
        const error = new Error('Update failed');
        mockedApiFetch
            .mockResolvedValueOnce(mockProfileData) // Initial fetch
            .mockRejectedValueOnce(error); // Update error

        const onError = jest.fn();
        const { result, waitFor } = renderHook(() => useProfile({ onError }), {
            wrapper: createWrapper()
        });

        // Wait for initial fetch
        await waitFor(() => !result.current.isLoading);

        // Attempt update
        act(() => {
            result.current.updateProfile({ name: 'New Name' });
        });

        // Wait for update to fail
        await waitFor(() => !result.current.isUpdating);

        // Verify error handling
        expect(onError).toHaveBeenCalledWith(error);
        expect(result.current.data).toEqual(mockProfileData); // Data should remain unchanged
    });
}); 