import { rest } from 'msw';
import { setupServer } from 'msw/node';
import { renderHookWithClient, mockProfile } from './test-utils';
import { useProfileMutations } from '../useProfileMutations';
import type { ProfileFormData } from '../../types/Profile';

const mockFormData: ProfileFormData = {
    name: 'John Doe',
    email: 'john@example.com',
    bio: 'Updated bio',
    notifications: true,
    weeklyGoal: 4,
    preferredWorkoutTypes: ['strength', 'cardio'],
    availableDays: ['monday', 'wednesday', 'friday'],
    timePreference: 'morning',
};

const server = setupServer(
    rest.post('/wp-json/athlete/v1/profile', (req, res, ctx) => {
        return res(ctx.json({ success: true, profile: { ...mockProfile, ...req.body } }));
    }),
    rest.post('/wp-json/athlete/v1/profile/avatar', (req, res, ctx) => {
        return res(ctx.json({ success: true, profile: { ...mockProfile, avatarUrl: 'new-avatar.jpg' } }));
    })
);

beforeAll(() => server.listen());
afterEach(() => server.resetHandlers());
afterAll(() => server.close());

describe('useProfileMutations', () => {
    it('updates profile data successfully', async () => {
        const onSuccess = jest.fn();
        const { result, waitFor } = renderHookWithClient(() =>
            useProfileMutations({ onUpdateSuccess: onSuccess })
        );

        result.current.updateProfile.mutate(mockFormData);

        await waitFor(() => !result.current.updateProfile.isLoading);

        expect(onSuccess).toHaveBeenCalledWith(
            expect.objectContaining({
                success: true,
                profile: expect.objectContaining(mockFormData),
            })
        );
    });

    it('handles profile update error', async () => {
        server.use(
            rest.post('/wp-json/athlete/v1/profile', (req, res, ctx) => {
                return res(
                    ctx.status(400),
                    ctx.json({ success: false, message: 'Invalid data' })
                );
            })
        );

        const onError = jest.fn();
        const { result, waitFor } = renderHookWithClient(() =>
            useProfileMutations({ onUpdateError: onError })
        );

        result.current.updateProfile.mutate(mockFormData);

        await waitFor(() => result.current.updateProfile.error !== null);

        expect(onError).toHaveBeenCalledWith(expect.any(Error));
        expect(result.current.updateProfile.error?.message).toBe('Invalid data');
    });

    it('updates avatar successfully', async () => {
        const { result, waitFor } = renderHookWithClient(() => useProfileMutations());

        const mockFile = new File(['test'], 'test.jpg', { type: 'image/jpeg' });
        result.current.updateAvatar.mutate(mockFile);

        await waitFor(() => !result.current.updateAvatar.isLoading);

        expect(result.current.updateAvatar.error).toBeNull();
    });

    it('handles avatar update error', async () => {
        server.use(
            rest.post('/wp-json/athlete/v1/profile/avatar', (req, res, ctx) => {
                return res(
                    ctx.status(400),
                    ctx.json({ success: false, message: 'Invalid file' })
                );
            })
        );

        const { result, waitFor } = renderHookWithClient(() => useProfileMutations());

        const mockFile = new File(['test'], 'test.jpg', { type: 'image/jpeg' });
        result.current.updateAvatar.mutate(mockFile);

        await waitFor(() => result.current.updateAvatar.error !== null);

        expect(result.current.updateAvatar.error?.message).toBe('Invalid file');
    });
}); 