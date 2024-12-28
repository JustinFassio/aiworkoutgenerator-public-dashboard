import { rest } from 'msw';
import { setupServer } from 'msw/node';
import { renderHookWithClient, mockProfile } from './test-utils';
import { useProfile } from '../useProfile';

const server = setupServer(
    rest.get('/wp-json/athlete/v1/profile', (req, res, ctx) => {
        return res(ctx.json(mockProfile));
    })
);

beforeAll(() => server.listen());
afterEach(() => server.resetHandlers());
afterAll(() => server.close());

describe('useProfile', () => {
    it('fetches profile data successfully', async () => {
        const { result, waitFor } = renderHookWithClient(() => useProfile());

        await waitFor(() => result.current.isSuccess);

        expect(result.current.data).toEqual(mockProfile);
    });

    it('handles error when fetching profile fails', async () => {
        server.use(
            rest.get('/wp-json/athlete/v1/profile', (req, res, ctx) => {
                return res(ctx.status(500), ctx.json({ message: 'Server error' }));
            })
        );

        const { result, waitFor } = renderHookWithClient(() => useProfile());

        await waitFor(() => result.current.isError);

        expect(result.current.error?.message).toBe('Server error');
    });

    it('respects enabled option', () => {
        const { result } = renderHookWithClient(() => useProfile({ enabled: false }));

        expect(result.current.isFetching).toBe(false);
    });
}); 