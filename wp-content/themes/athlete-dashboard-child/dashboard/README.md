# Athlete Dashboard

A modern WordPress dashboard built with React and TypeScript, providing a seamless integration between WordPress and modern frontend technologies.

## Architecture Overview

The dashboard uses a hybrid approach:
- React components for interactive UI elements
- WordPress backend for data management and routing
- TypeScript for type safety and modern JavaScript features
- SCSS for maintainable styling

### Directory Structure

```
dashboard/
├── components/         # PHP components (legacy)
├── contracts/         # PHP interfaces
├── core/             # Core PHP functionality
├── features/         # Feature implementations
├── templates/        # WordPress templates
└── assets/
    └── src/
        └── dashboard/
            ├── js/
            │   ├── components/  # React components
            │   └── features/    # React feature components
            └── scss/           # SCSS styles
```

## Adding New Features

### 1. Create React Component

Create a new feature component in `assets/src/dashboard/js/features`:

```typescript
// features/MyFeature/types.ts
export interface MyFeatureProps {
  // Define props
}

// features/MyFeature/MyFeature.tsx
import React from 'react';
import { MyFeatureProps } from './types';

export const MyFeature: React.FC<MyFeatureProps> = (props) => {
  return (
    <div className="dashboard-feature my-feature">
      {/* Feature content */}
    </div>
  );
};
```

### 2. Register Feature

Create a PHP registration file in `dashboard/features`:

```php
<?php
namespace AthleteDashboard\Dashboard\Features;

class MyFeature {
    public function __construct() {
        add_filter('athlete_dashboard_features', [$this, 'registerFeature']);
    }

    public function registerFeature(array $features): array {
        $features[] = [
            'id' => 'my-feature',
            'title' => __('My Feature', 'athlete-dashboard'),
            'description' => __('Feature description', 'athlete-dashboard'),
            'icon' => 'dashicons-icon-name',
            'react_component' => 'MyFeature',
            'props' => [
                // Component props
            ]
        ];
        return $features;
    }
}
```

## Modal System

The dashboard includes a modal system that can be used from both PHP and React:

### Using Modals in React

```typescript
import { Modal } from '../components/Modal';

// In your component:
<Modal
  id="my-modal"
  title="Modal Title"
  isOpen={isModalOpen}
  onClose={() => setIsModalOpen(false)}
>
  Modal content
</Modal>
```

### Using Modals in PHP

```php
use AthleteDashboard\Dashboard\Core\ModalBridge;

// Render modal:
ModalBridge::render('my-modal', [
    'title' => 'Modal Title',
    'children' => 'Modal content'
]);
```

## Styling

The dashboard uses SCSS with CSS variables for theming:

```scss
// Example usage
.my-feature {
  background: var(--dashboard-bg);
  color: var(--dashboard-text);
  padding: var(--dashboard-content-padding);
}
```

## Development

1. Install dependencies:
```bash
npm install
```

2. Start development server:
```bash
npm run dev
```

3. Build for production:
```bash
npm run build
```

## Testing

Before deploying changes:
1. Test feature registration
2. Verify React component mounting
3. Check modal system integration
4. Test responsive design
5. Verify WordPress integration

## WordPress Integration

The dashboard integrates with WordPress through:
- Template system (`dashboard.php`)
- AJAX endpoints for data
- WordPress hooks and filters
- Asset management

## Security

The dashboard implements security best practices:
- WordPress nonces for AJAX
- Capability checks
- Data sanitization
- XSS prevention
- CSRF protection 