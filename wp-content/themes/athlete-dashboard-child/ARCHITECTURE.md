# Athlete Dashboard Architecture

## Overview
This document outlines the architecture of the Athlete Dashboard WordPress child theme, following a Feature-First architecture pattern.

## Directory Structure

```
athlete-dashboard/
├── core/                           # Core framework functionality
│   ├── auth/                      # Authentication and authorization
│   ├── database/                  # Database abstractions and migrations
│   ├── wordpress/                 # WordPress integration utilities
│   └── divi/                      # DIVI builder integration
├── features/                      # Feature modules
│   ├── squat-progress/           # Squat progress tracking feature
│   │   ├── components/           # UI components
│   │   ├── services/            # Business logic
│   │   ├── models/             # Data models
│   │   ├── hooks/              # WordPress hooks
│   │   ├── api/                # API endpoints
│   │   ├── tests/             # Feature-specific tests
│   │   ├── styles/            # Feature-specific styles
│   │   └── index.php          # Feature entry point
│   ├── bench-press/            # Bench press tracking feature
│   ├── deadlift/              # Deadlift tracking feature
│   ├── body-composition/      # Body composition tracking
│   ├── workout-log/           # Workout logging feature
│   └── goals/                 # Goals tracking feature
├── shared/                     # Shared utilities and components
│   ├── components/            # Reusable UI components
│   ├── helpers/              # Utility functions
│   ├── styles/               # Global styles
│   └── scripts/              # Global scripts
├── tests/                     # Global test configuration
├── vendor/                    # Third-party dependencies
└── assets/                    # Compiled assets

```

## Feature Module Structure
Each feature follows this standard structure:

```
feature-name/
├── components/                # UI Components
│   ├── Feature.php           # Main feature component
│   └── FeatureWidget.php     # WordPress widget if needed
├── services/                 # Business Logic
│   ├── FeatureService.php    # Main service class
│   └── DataCalculator.php    # Calculations/processing
├── models/                   # Data Models
│   └── FeatureModel.php      # Data structure and validation
├── hooks/                    # WordPress Integration
│   └── feature-hooks.php     # Actions and filters
├── api/                      # REST API
│   └── feature-endpoints.php # API routes
├── tests/                    # Tests
│   ├── Unit/
│   └── Integration/
├── styles/                   # Styles
│   └── feature.scss
├── scripts/                  # JavaScript
│   └── feature.js
└── index.php                # Feature registration
```

## Naming Conventions

### Files and Directories
- Feature directories: `kebab-case`
- PHP classes: `PascalCase`
- PHP files: `PascalCase.php`
- JavaScript files: `kebab-case.js`
- SCSS files: `kebab-case.scss`

### Code
- Classes: `PascalCase`
- Methods: `camelCase`
- Properties: `camelCase`
- Constants: `UPPER_SNAKE_CASE`
- Hooks: `feature_name_action_name`
- Database tables: `wp_athlete_feature_name`

## WordPress Integration

### Custom Post Types
- Registered in feature's `hooks/feature-hooks.php`
- Named with prefix: `ad_feature_name`

### Meta Fields
- Prefixed with underscore: `_ad_feature_field`
- Registered in feature's model class

### REST API Endpoints
- Base: `athlete-dashboard/v1`
- Feature endpoints: `athlete-dashboard/v1/feature-name/*`

## Database Structure

### Core Tables
```sql
-- Feature specific tables follow this pattern
CREATE TABLE wp_athlete_feature_name (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED,
    date_recorded DATETIME,
    -- feature specific fields
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (user_id) REFERENCES wp_users(ID)
);
```

## Testing Strategy

### Unit Tests
- Located in feature's `tests/Unit` directory
- Test individual components and services
- Follow pattern: `FeatureTest.php`

### Integration Tests
- Located in feature's `tests/Integration` directory
- Test feature as a whole
- Follow pattern: `FeatureIntegrationTest.php`

## Performance Considerations

### Caching
- WordPress transients for API responses
- Object caching for frequent queries
- Page caching where appropriate

### Asset Loading
- Feature-specific assets loaded only when needed
- Shared assets loaded globally
- SCSS compilation and JS bundling per feature

## Security

### Data Protection
- WordPress nonce verification
- Input sanitization in models
- Output escaping in templates
- Role-based access control

### API Security
- WP REST API authentication
- Rate limiting
- Data validation

## Development Workflow

### Version Control
- Feature branches: `feature/feature-name`
- Bug fixes: `fix/issue-description`
- Release branches: `release/x.x.x`

### Deployment
- Development -> Staging -> Production
- Feature-based deployments
- Database migration handling

## Documentation
- Feature README in each feature directory
- PHPDoc for classes and methods
- Inline comments for complex logic
- API documentation in feature's api directory 