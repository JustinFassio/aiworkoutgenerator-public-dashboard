# Development Guide

This guide covers the development workflow and best practices for the Athlete Dashboard theme.

## Getting Started

1. Clone the repository:
```bash
git clone [repository-url]
cd athlete-dashboard-child
```

2. Install dependencies:
```bash
npm install
```

3. Start development server:
```bash
npm run dev
```

## Project Structure

```
athlete-dashboard-child/
├── assets/
│   └── src/
│       └── dashboard/
│           ├── js/
│           │   ├── components/  # Reusable React components
│           │   ├── features/    # Feature-specific components
│           │   └── utils/       # Utility functions
│           └── scss/           # Styles
├── dashboard/
│   ├── components/   # PHP components
│   ├── contracts/    # PHP interfaces
│   ├── core/         # Core PHP functionality
│   ├── features/     # Feature implementations
│   └── templates/    # WordPress templates
└── docs/            # Documentation
```

## Development Workflow

### 1. Feature Development

1. Create a new feature branch:
```bash
git checkout -b feature/your-feature-name
```

2. Create necessary files:
   - React components in `assets/src/dashboard/js/features/`
   - PHP files in `dashboard/features/`
   - Tests in `__tests__` directories

3. Follow the feature template:
```typescript
// Feature component structure
/features/YourFeature/
├── components/     # Feature-specific components
├── hooks/         # Custom hooks
├── utils/         # Feature-specific utilities
├── __tests__/     # Tests
├── types.ts       # TypeScript interfaces
├── YourFeature.tsx # Main component
└── index.ts       # Barrel file
```

### 2. Testing

Run tests during development:
```bash
# Run tests in watch mode
npm test

# Run tests with coverage
npm run test:coverage
```

Write tests for:
- Components
- Utilities
- Hooks
- Integration scenarios

### 3. Code Quality

The project uses several tools to maintain code quality:

1. TypeScript:
   - Strict type checking
   - Interface-first development
   - No `any` types unless absolutely necessary

2. ESLint:
```bash
# Run linter
npm run lint

# Fix auto-fixable issues
npm run lint -- --fix
```

3. Prettier:
```bash
# Format code
npm run format
```

4. Pre-commit hooks:
   - Automatically run on `git commit`
   - Lint and format staged files
   - Run relevant tests

### 4. Building

Build for production:
```bash
npm run build
```

The build process:
1. Compiles TypeScript
2. Bundles with Vite
3. Generates CSS from SCSS
4. Creates source maps
5. Outputs to `assets/dist/`

### 5. WordPress Integration

#### Adding a New Feature

1. Create PHP registration:
```php
<?php
namespace AthleteDashboard\Dashboard\Features;

class YourFeature {
    public function __construct() {
        add_filter('athlete_dashboard_features', [$this, 'registerFeature']);
    }

    public function registerFeature(array $features): array {
        $features[] = [
            'id' => 'your-feature',
            'title' => __('Your Feature', 'athlete-dashboard'),
            'react_component' => 'YourFeature',
            'props' => [
                // Component props
            ]
        ];
        return $features;
    }
}
```

2. Create React component:
```typescript
export const YourFeature: React.FC<YourFeatureProps> = (props) => {
    return (
        <div className="dashboard-feature your-feature">
            {/* Feature content */}
        </div>
    );
};
```

#### Using WordPress Hooks

Access WordPress functionality through the global `wp` object:
```typescript
const handleSave = async (data: FormData) => {
    const response = await fetch(wp.ajax.settings.url, {
        method: 'POST',
        body: JSON.stringify({
            action: 'your_action',
            nonce: props.nonce,
            data
        })
    });
    // Handle response
};
```

### 6. Deployment

The CI/CD pipeline:
1. Runs on push to `main` branch
2. Executes tests and builds
3. Deploys to WordPress environment

Required secrets for deployment:
- `DEPLOY_KEY`: SSH private key
- `DEPLOY_HOST`: Server hostname
- `DEPLOY_PATH`: WordPress installation path
- `CODECOV_TOKEN`: Codecov.io token

## Best Practices

1. Component Design:
   - Keep components small and focused
   - Use TypeScript interfaces
   - Implement proper error handling
   - Add accessibility attributes

2. State Management:
   - Use React hooks for local state
   - Implement proper data fetching
   - Handle loading and error states

3. Styling:
   - Follow BEM methodology
   - Use CSS variables for theming
   - Implement responsive design
   - Keep styles modular

4. Testing:
   - Write unit tests for components
   - Test error scenarios
   - Mock external dependencies
   - Maintain good coverage

5. Performance:
   - Lazy load components
   - Optimize images
   - Minimize bundle size
   - Use code splitting

## Troubleshooting

Common issues and solutions:

1. Build Errors:
   - Clear `node_modules` and reinstall
   - Check TypeScript errors
   - Verify import paths

2. WordPress Integration:
   - Check AJAX endpoints
   - Verify nonces
   - Debug PHP errors

3. Testing:
   - Reset mocks between tests
   - Check test environment
   - Verify component rendering

## Resources

- [React Documentation](https://react.dev)
- [TypeScript Handbook](https://www.typescriptlang.org/docs)
- [WordPress REST API](https://developer.wordpress.org/rest-api)
- [Testing Library](https://testing-library.com/docs) 