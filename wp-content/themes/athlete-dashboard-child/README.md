# Athlete Dashboard

A WordPress child theme for tracking athlete workouts and progress, built with a Feature-First architecture.

## Overview

The Athlete Dashboard is a modular, feature-focused WordPress child theme that helps athletes track their workouts, progress, and fitness goals. Built on top of Divi, it follows a Feature-First architecture pattern for maintainability and scalability.

## Features

- **Squat Progress Tracking**: Track and visualize squat progression over time
- **Bench Press Tracking**: Monitor bench press improvements
- **Deadlift Analytics**: Track deadlift progress and form
- **Body Composition**: Track body measurements and composition
- **Workout Logging**: Log and review workout sessions
- **Goal Setting**: Set and track fitness goals

## Architecture

This theme follows a Feature-First architecture where:
- Each feature is self-contained with its own components, services, and styles
- Core functionality is separated from feature-specific code
- Shared components and utilities are centralized
- Features can be enabled/disabled independently

See [ARCHITECTURE.md](ARCHITECTURE.md) for detailed architecture documentation.

## Directory Structure

```
athlete-dashboard-child/
├── core/                     # Core framework functionality
├── features/                 # Feature modules
├── shared/                   # Shared utilities and components
├── tests/                    # Global test configuration
├── vendor/                   # Third-party dependencies
└── assets/                   # Compiled assets
```

## Requirements

- WordPress 6.0+
- PHP 8.0+
- Divi Theme 4.0+
- MySQL 5.7+ or MariaDB 10.3+

## Installation

1. Install and activate the Divi parent theme
2. Upload the `athlete-dashboard-child` theme to `/wp-content/themes/`
3. Activate the Athlete Dashboard child theme
4. Navigate to Appearance > Athlete Dashboard to configure features

## Development

### Getting Started

1. Clone the repository
2. Install dependencies: `composer install`
3. Build assets: `npm install && npm run build`

### Feature Development

To create a new feature:

1. Create a new directory in `features/`
2. Follow the feature structure from ARCHITECTURE.md
3. Register the feature in `core/feature-loader.php`

### Coding Standards

- Follow WordPress Coding Standards
- Use PHP 8.0+ features
- Follow Feature-First architecture patterns
- Write tests for new features

### Testing

```bash
# Run all tests
composer test

# Run feature-specific tests
composer test -- --filter=FeatureName
```

## Contributing

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/new-feature`
3. Commit changes: `git commit -am 'Add new feature'`
4. Push to the branch: `git push origin feature/new-feature`
5. Submit a Pull Request

## License

GPL v2 or later. See [LICENSE](LICENSE) for details. 