# Build Process and Asset Management

## Overview

This document outlines the build process and asset management for the Athlete Dashboard theme. We use Vite for building our TypeScript/React components and managing assets.

## Directory Structure

```
athlete-dashboard-child/
├── assets/
│   └── dist/           # Build output directory
│       ├── js/
│       │   ├── dashboard/
│       │   └── features/
│       └── css/
│           ├── dashboard/
│           └── features/
├── dashboard/          # Core dashboard components
│   ├── components/
│   ├── hooks/
│   ├── styles/
│   └── index.tsx
└── features/          # Feature-specific components
    ├── profile/
    │   ├── assets/
    │   ├── components/
    │   └── index.tsx
    └── workout/
        ├── assets/
        ├── components/
        └── index.tsx
```

## Build Configuration

### Entry Points

- Dashboard core: `dashboard/index.tsx`
- Feature entries: `features/[feature-name]/index.tsx`
- Feature styles: `features/[feature-name]/assets/scss/styles.scss`

### Output Structure

```
assets/dist/
├── js/
│   ├── dashboard/
│   │   └── core.js
│   ├── features/
│   │   ├── profile/
│   │   └── workout/
│   └── _chunks/        # Shared chunks
├── css/
│   ├── dashboard/
│   │   └── core.css
│   └── features/
│       ├── profile/
│       └── workout/
└── manifest.json       # Asset manifest
```

## Development

### Starting Development Server

```bash
npm run dev
```

This will:
- Start Vite dev server on port 5173
- Enable HMR for fast updates
- Watch for file changes

### Building for Production

```bash
npm run build
```

This will:
- Clean the dist directory
- Build all TypeScript/React components
- Generate CSS from SCSS
- Create source maps
- Generate asset manifest

## Asset Loading

### PHP Integration

Assets are loaded through WordPress enqueue functions in `functions.php`:

```php
// Core dashboard assets
wp_enqueue_style('dashboard-core', get_stylesheet_directory_uri() . '/assets/dist/css/dashboard/core.css');
wp_enqueue_script('dashboard-core', get_stylesheet_directory_uri() . '/assets/dist/js/dashboard/core.js');

// Feature-specific assets
wp_enqueue_style('feature-profile', get_stylesheet_directory_uri() . '/assets/dist/css/features/profile/styles.css');
wp_enqueue_script('feature-profile', get_stylesheet_directory_uri() . '/assets/dist/js/features/profile/index.js');
```

### Asset Manifest

The build process generates a `manifest.json` file that maps source files to their hashed output files. This is used for cache busting and asset versioning.

## SCSS Structure

### Global Styles

Core dashboard styles are in `dashboard/styles/`:
- `variables.scss`: Global variables
- `mixins.scss`: Reusable mixins
- `global.scss`: Base styles

### Feature Styles

Feature-specific styles are in `features/[feature-name]/assets/scss/`:
- `styles.scss`: Main feature stylesheet
- `_variables.scss`: Feature-specific variables
- `_components.scss`: Feature component styles

## Module Resolution

Vite is configured with aliases for easy imports:

```typescript
import { Button } from '@components/Button';
import { useProfile } from '@features/profile/hooks';
import { DashboardLayout } from '@dashboard/components';
```

## Testing

Run tests with:
```bash
npm run test
```

Coverage reports are generated in:
- `coverage/text/`: Text report
- `coverage/html/`: HTML report
- `coverage/json/`: JSON data

## Troubleshooting

### Common Issues

1. Missing Assets
   - Check if the file exists in the correct location
   - Verify the build output in `assets/dist/`
   - Check the asset manifest

2. HMR Not Working
   - Ensure dev server is running
   - Check browser console for errors
   - Verify port 5173 is available

3. Build Failures
   - Check TypeScript errors
   - Verify all required dependencies are installed
   - Check for circular dependencies

## Best Practices

1. Asset Organization
   - Keep feature assets close to their components
   - Use the appropriate directory structure
   - Follow naming conventions

2. Performance
   - Use code splitting where appropriate
   - Optimize images and other assets
   - Minimize CSS and JavaScript

3. Development
   - Use TypeScript for type safety
   - Follow the component structure
   - Write tests for new components
``` 