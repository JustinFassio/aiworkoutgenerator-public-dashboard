# Training Persona Feature

## Overview
The Training Persona feature allows athletes to manage their training preferences, goals, and workout settings. It implements a hybrid PHP/React architecture for optimal performance and user experience.

## Architecture

### PHP Components
- `TrainingPersona` class extends `AbstractFeature`
  - Handles WordPress integration
  - Manages user data persistence
  - Provides fallback form rendering
- `TrainingPersonaForm` class extends core `Form` component
  - Server-side form rendering
  - Data validation and sanitization
  - Progressive enhancement support

### React Components
- `TrainingPersonaEditor` (React)
  - Interactive form interface
  - Real-time validation
  - Enhanced user experience
- `GoalsManager` (React)
  - Dynamic goal management
  - Tag-based input
  - Autocomplete suggestions
- `PreferencesPanel` (React)
  - Settings configuration
  - Visual feedback
  - Instant updates

## Data Flow

1. Server-Side:
   - User data retrieved from WordPress meta
   - Initial state rendered in PHP
   - React container prepared with props

2. Client-Side:
   - React components hydrate PHP-rendered content
   - State management via React hooks
   - AJAX/REST API for data persistence

## Progressive Enhancement

1. Base Functionality (PHP)
   - Form submission works without JavaScript
   - Basic validation and error handling
   - Complete feature accessibility

2. Enhanced Experience (React)
   - Real-time validation
   - Dynamic UI updates
   - Improved interactivity

## Directory Structure
```
training-persona/
├── index.php                 # Feature registration and PHP logic
├── components/              
│   ├── TrainingPersonaForm.php   # PHP form component
│   └── react/                    # React components
│       ├── TrainingPersonaEditor.tsx
│       ├── GoalsManager.tsx
│       └── PreferencesPanel.tsx
├── assets/
│   ├── css/                      # Styles
│   └── js/                       # Compiled React code
├── tests/
│   ├── php/                      # PHP unit tests
│   └── react/                    # React component tests
└── utils/                        # Shared utilities
```

## Usage

### PHP Implementation
```php
// Initialize feature
$trainingPersona = new TrainingPersona();

// Render form
$form = TrainingPersonaForm::create($userData);
echo $form->render();
```

### React Integration
```typescript
// Mount React components
const container = document.getElementById('training-persona-root');
if (container) {
    const props = JSON.parse(container.dataset.props || '{}');
    render(<TrainingPersonaEditor {...props} />, container);
}
```

## Testing

### PHP Tests
- Unit tests for form validation
- Integration tests for WordPress hooks
- Data persistence tests

### React Tests
- Component rendering tests
- User interaction tests
- State management tests

## Security

1. Server-Side:
   - WordPress nonce verification
   - Data sanitization
   - User capability checks

2. Client-Side:
   - Input validation
   - XSS prevention
   - CSRF protection

## Development

### Requirements
- WordPress 5.8+
- PHP 7.4+
- Node.js 14+
- React 17+

### Build Process
1. PHP files are loaded directly
2. React components require build:
   ```bash
   npm run build:training-persona
   ```

## Maintenance

1. Regular Tasks:
   - Update WordPress compatibility
   - React dependency updates
   - Security patches
   - Performance optimization

2. Monitoring:
   - Error logging
   - Performance metrics
   - User feedback

## Contributing
1. Follow WordPress coding standards
2. Maintain progressive enhancement
3. Update tests for new features
4. Document changes thoroughly
``` 