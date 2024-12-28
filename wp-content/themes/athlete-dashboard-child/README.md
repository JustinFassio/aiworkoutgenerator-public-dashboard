# Athlete Dashboard

A WordPress child theme for tracking athlete workouts and progress, built with a Feature-First architecture, TypeScript, and interface-based dashboard integration.

## Overview

The Athlete Dashboard is a modular, feature-focused WordPress child theme that helps athletes track their workouts, progress, and fitness goals. Built on top of Divi, it follows a Feature-First architecture pattern with interface-based dashboard integration for maintainability and scalability. The codebase is written in TypeScript for enhanced type safety and developer experience.

## Architecture

### Feature-First Design
- Each feature is fully self-contained
- Features implement dashboard interfaces
- No shared code between features
- Event-driven communication
- TypeScript for type safety

### Dashboard Integration
- Interface-based contracts
- Event system for communication
- Style tokens for consistency
- No shared implementations
- Type-safe event handling

### Style System
- Dashboard provides style tokens
- Features maintain independent styles
- Consistent look and feel
- No global stylesheets
- SCSS modules for scoped styling

## Features

Each feature is independently packaged with:
- Custom UI components
- Feature-specific modals
- Independent styling
- Dedicated assets
- TypeScript modules

Available features:
- Training Persona Management
- Profile Configuration
- Workout Tracking
- Progress Analytics
- Goal Setting

## Directory Structure

```
athlete-dashboard-child/
├── dashboard/                # Dashboard framework
│   ├── contracts/           # Interface definitions
│   ├── components/          # Core components
│   └── assets/             # Style tokens
├── features/               # Feature modules
│   ├── training-persona/   # Training persona feature
│   └── profile/           # Profile feature
├── assets/                # Compiled assets
│   ├── src/              # Source files
│   └── dist/             # Built files
├── core/                 # WordPress integration
└── vendor/              # Third-party dependencies
```

## Requirements

- WordPress 6.0+
- PHP 8.0+
- Divi Theme 4.0+
- MySQL 5.7+ or MariaDB 10.3+
- Node.js 16+
- npm 8+

## Development

### Setup

```bash
# Install dependencies
npm install

# Start development server
npm run dev

# Build for production
npm run build
```

### Creating a New Feature

1. Create feature directory:
```bash
features/
└── your-feature/
    ├── components/
    │   └── modals/
    ├── services/
    ├── assets/
    │   ├── js/
    │   └── scss/
    └── index.php
```

2. Implement required interfaces:
```typescript
class YourFeatureModal implements ModalInterface {
    public getId(): string;
    public getTitle(): string;
    public renderContent(): void;
    public getAttributes(): Record<string, string>;
    public getDependencies(): string[];
}
```

3. Set up event handlers:
```typescript
import { DashboardEvents } from '@dashboard/events';

document.addEventListener(DashboardEvents.MODALS_READY, () => {
    // Initialize feature
});
```

4. Create feature-specific styles:
```scss
.your-feature-modal {
    /* Use dashboard tokens */
    background: var(--dashboard-modal-bg);
}
```

### Testing

```bash
# Run all tests
composer test

# Test specific feature
composer test -- --filter=FeatureName

# Run TypeScript type checking
npm run check
```

## Contributing

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/new-feature`
3. Implement the feature:
   - Follow Feature-First principles
   - Implement required interfaces
   - Use event-based communication
   - Maintain independent styling
   - Write TypeScript code
4. Submit a Pull Request

## License

GPL v2 or later. See [LICENSE](LICENSE) for details. 