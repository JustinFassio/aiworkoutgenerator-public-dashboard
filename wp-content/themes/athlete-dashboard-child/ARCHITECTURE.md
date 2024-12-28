# Athlete Dashboard Architecture

## Overview

The Athlete Dashboard is built on a modular, event-driven architecture that emphasizes feature independence and clean separation of concerns. Each feature is self-contained and communicates with other features through a standardized event system. The codebase is written in TypeScript for enhanced type safety and developer experience.

## Core Concepts

### Feature System

Features are independent modules that implement the `FeatureInterface`. Each feature:
- Has its own directory structure
- Manages its own assets and dependencies
- Handles its own modals and UI components
- Emits and listens to events for inter-feature communication
- Uses TypeScript for type safety

```typescript
interface FeatureInterface {
    register(): void;
    init(): void;
    getIdentifier(): string;
    getMetadata(): Record<string, unknown>;
    isEnabled(): boolean;
}
```

### Event System

The dashboard uses a unified event system for feature communication:
- Events are namespaced by feature
- Both PHP and TypeScript events are supported
- Events are typed with TypeScript interfaces
- Debug mode provides event logging
- Type-safe event handling

```typescript
// Event type definitions
interface ProfileUpdateEvent {
    height: number;
    weight: number;
    goals: string[];
}

// Event constants
export const DashboardEvents = {
    PROFILE_UPDATE: 'profile:update' as const,
    MODALS_READY: 'dashboard:modals:ready' as const,
} as const;

// Emit typed events
Events.emit<ProfileUpdateEvent>(DashboardEvents.PROFILE_UPDATE, {
    height: 180,
    weight: 75,
    goals: ['strength', 'endurance']
});

// Listen for typed events
Events.on<ProfileUpdateEvent>(DashboardEvents.PROFILE_UPDATE, (detail) => {
    // TypeScript knows the shape of detail
    console.log(detail.height, detail.weight, detail.goals);
});
```

### Asset Management

Assets are managed using Vite:
- Feature-specific assets are co-located with features
- TypeScript for enhanced development experience
- SCSS modules for scoped styling
- Shared styles use CSS custom properties
- Development includes HMR support
- Production builds are optimized and hashed

## Directory Structure

```
athlete-dashboard-child/
├── dashboard/
│   ├── core/           # Core system classes
│   ├── contracts/      # TypeScript interfaces
│   ├── abstracts/      # Abstract base classes
│   ├── assets/         # Shared assets
│   └── templates/      # Base templates
├── features/
│   ├── profile/        # Profile feature
│   │   ├── assets/     # Feature assets
│   │   │   ├── js/    # TypeScript modules
│   │   │   └── scss/  # SCSS modules
│   │   ├── components/ # UI components
│   │   ├── templates/  # Feature templates
│   │   ├── tests/      # Feature tests
│   │   ├── index.php   # Feature registration
│   │   └── README.md   # Feature documentation
│   └── training/       # Training feature
├── assets/            # Compiled assets
│   ├── src/          # Source files
│   └── dist/         # Built files
└── tests/            # Global tests
```

## Feature Development

### Creating a New Feature

1. Create feature directory structure
2. Implement `FeatureInterface`
3. Create TypeScript modules
4. Register feature assets and templates
5. Add feature documentation
6. Implement feature tests

### Feature Guidelines

- Keep features independent
- Use event system for communication
- Co-locate related code and assets
- Document public APIs and events
- Include feature-specific tests
- Write type-safe TypeScript code

## Event Guidelines

### Naming Conventions

- Use `feature:event` format
- Be specific and descriptive
- Use past tense for completed actions
- Include relevant data
- Define TypeScript interfaces

Examples:
```typescript
// Event type definitions
interface WorkoutCompletedEvent {
    id: string;
    duration: number;
    exercises: Exercise[];
    timestamp: string;
}

// Event constants
export const WorkoutEvents = {
    COMPLETED: 'workout:completed' as const,
    STARTED: 'workout:started' as const,
} as const;
```

### Event Data

- Use TypeScript interfaces
- Include timestamp
- Provide complete context
- Validate data structure
- Type-safe event handling

## Style Guidelines

### Custom Properties

```scss
:root {
    /* Colors */
    --color-primary: #007bff;
    --color-secondary: #6c757d;
    
    /* Typography */
    --font-family-base: -apple-system, system-ui, sans-serif;
    --font-size-base: 1rem;
    
    /* Spacing */
    --spacing-unit: 0.25rem;
    --spacing-large: calc(var(--spacing-unit) * 4);
}
```

### SCSS Modules

```scss
@use 'sass:math';

@mixin flex-center {
    display: flex;
    align-items: center;
    justify-content: center;
}

@mixin responsive($breakpoint) {
    @media (min-width: map-get($breakpoints, $breakpoint)) {
        @content;
    }
}
```

## Testing

### Unit Tests

- Test feature registration
- Test event handling
- Test asset loading
- Test template rendering
- Test TypeScript types

### Integration Tests

- Test feature interactions
- Test event propagation
- Test asset dependencies
- Test template integration
- Test type safety

## Build System

### Development

```bash
# Install dependencies
npm install

# Start development server
npm run dev

# Run tests
npm run test

# Type checking
npm run check

# Lint TypeScript
npm run lint
```

### Production

```bash
# Build for production
npm run build

# Preview production build
npm run preview
```

## Troubleshooting

### Common Issues

1. Feature not loading
   - Check feature registration
   - Verify dependencies
   - Check console for errors
   - Verify TypeScript compilation

2. Events not firing
   - Verify event names
   - Check event listeners
   - Enable debug mode
   - Check type definitions

3. Assets not loading
   - Check build configuration
   - Verify asset paths
   - Clear cache
   - Check Vite config

### Debug Mode

Enable debug mode to:
- Log all events
- Track feature initialization
- Monitor asset loading
- Profile performance
- Debug TypeScript issues
``` 