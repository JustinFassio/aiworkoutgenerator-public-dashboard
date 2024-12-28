# Core Form Component

## Overview
The Form component is a core component that provides a standardized way to create and handle forms across features. Like the Modal component, it is one of the justified exceptions to our feature-first architecture.

## Usage

### Basic Usage
```php
use AthleteDashboard\Dashboard\Components\Form;

$form = Form::create('my-form', [
    'method' => 'post',
    'action' => '/submit',
    'data-form-context' => 'modal'
], 'custom-class');

echo $form->render();
```

### Extending for Feature-Specific Forms
```php
use AthleteDashboard\Dashboard\Components\Form;

class TrainingPersonaForm extends Form {
    protected function getContent(): string {
        // Return feature-specific form content
        return '<div class="form-fields">...</div>';
    }
}
```

## Features
- Standardized form structure
- Secure attribute handling
- Extensible for feature-specific needs
- Built-in XSS protection
- Consistent styling hooks

## Best Practices

1. **Do**
   - Extend the base Form class for feature-specific forms
   - Use semantic class names
   - Follow WordPress security practices
   - Keep form logic in the feature's directory

2. **Don't**
   - Modify core Form component for feature-specific needs
   - Skip security measures like nonce verification
   - Mix form styles between features

## Security

The Form component:
- Escapes all attributes and content
- Follows WordPress security best practices
- Provides hooks for CSRF protection

## Styling

Forms use a consistent class structure:
```css
.form {
    /* Base form styles */
}

.form-fields {
    /* Field container styles */
}

.form-field {
    /* Individual field styles */
}

.form-actions {
    /* Action button container styles */
}
```

## Testing

1. **Core Testing**
   - Base form rendering
   - Attribute handling
   - Security measures

2. **Feature Testing**
   - Feature-specific form validation
   - Custom field behavior
   - Form submission handling

## Maintenance

Regular review ensures:
1. Security best practices are followed
2. Compatibility with WordPress updates
3. Consistent implementation across features
4. Performance optimization 