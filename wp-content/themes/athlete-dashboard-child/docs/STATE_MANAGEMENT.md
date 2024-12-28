# State Management Patterns

## Overview

This application uses React Query for server state management and local React state for UI-specific state. This document outlines our state management patterns and best practices.

## React Query Usage

### Custom Hooks

Each feature has its own custom hook that encapsulates React Query logic:

- `useProfile` - Profile management
- `useTrainingPersona` - Training persona management
- `useWorkoutTracker` - Workout tracking

These hooks provide a consistent interface for:
- Data fetching
- Mutations (create, update, delete)
- Loading and error states
- Cache management

Example usage:
```typescript
const {
    data,
    isLoading,
    isError,
    error,
    mutate
} = useFeatureHook();
```

### Caching Strategy

- `staleTime`: 5 minutes - Data is considered fresh for 5 minutes
- `cacheTime`: 30 minutes - Cached data is kept for 30 minutes
- `retry`: 2 attempts for failed queries
- `refetchOnWindowFocus`: Enabled to keep data fresh

### Error Handling

All hooks accept an `onError` callback for custom error handling:

```typescript
const { data } = useFeatureHook({
    onError: (error) => {
        console.error('Operation failed:', error);
        // Custom error handling
    }
});
```

### Optimistic Updates

For better UX, mutations use optimistic updates:

```typescript
const { mutate } = useFeatureHook({
    onMutate: async (newData) => {
        // Cancel outgoing refetches
        await queryClient.cancelQueries(['key']);
        
        // Snapshot previous value
        const previousData = queryClient.getQueryData(['key']);
        
        // Optimistically update
        queryClient.setQueryData(['key'], newData);
        
        // Return snapshot for rollback
        return { previousData };
    },
    onError: (err, newData, context) => {
        // Rollback on error
        queryClient.setQueryData(['key'], context.previousData);
    }
});
```

### Dev Tools

React Query Dev Tools are available in development mode for debugging:
- Query status
- Cache contents
- Background refetches
- Query timing

Access Dev Tools via the floating button in the bottom-right corner.

## Local State Management

Local state is used for UI-specific concerns:
- Form state
- Modal visibility
- Selected items
- UI animations

Example:
```typescript
const [isEditing, setIsEditing] = useState(false);
const [selectedId, setSelectedId] = useState<string | null>(null);
```

## Best Practices

1. **Use Custom Hooks**
   - Create feature-specific hooks
   - Encapsulate React Query logic
   - Provide consistent interfaces

2. **Cache Management**
   - Set appropriate stale times
   - Implement optimistic updates
   - Handle cache invalidation

3. **Error Handling**
   - Provide error callbacks
   - Implement retry logic
   - Show user-friendly error messages

4. **Performance**
   - Use `select` to transform data
   - Implement pagination where needed
   - Optimize refetch intervals

5. **Testing**
   - Test hooks in isolation
   - Write integration tests
   - Mock API responses

## Examples

### Basic Query
```typescript
const { data, isLoading } = useQuery({
    queryKey: ['feature'],
    queryFn: fetchData
});
```

### Mutation with Optimistic Update
```typescript
const { mutate } = useMutation({
    mutationFn: updateData,
    onMutate: optimisticUpdate,
    onError: rollback,
    onSettled: refetchQueries
});
```

### Infinite Query
```typescript
const {
    data,
    fetchNextPage,
    hasNextPage
} = useInfiniteQuery({
    queryKey: ['feature'],
    queryFn: fetchPage,
    getNextPageParam: (lastPage) => lastPage.nextCursor
});
```

## Migration Guide

When migrating existing features to React Query:

1. Create a custom hook
2. Move API calls to query/mutation functions
3. Update components to use the hook
4. Add loading and error states
5. Implement optimistic updates
6. Add tests

## Resources

- [React Query Documentation](https://tanstack.com/query/latest)
- [Best Practices Guide](https://tanstack.com/query/latest/docs/react/guides/important-defaults)
- [TypeScript Guide](https://tanstack.com/query/latest/docs/react/typescript) 