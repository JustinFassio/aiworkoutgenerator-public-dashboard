# Style System Documentation

## Overview

The dashboard uses a token-based style system with SCSS. Features maintain their own styles while using shared tokens for consistency.

## Style Tokens

### Colors

```scss
// Base Colors
$color-primary: #007bff;
$color-secondary: #6c757d;
$color-success: #28a745;
$color-info: #17a2b8;
$color-warning: #ffc107;
$color-danger: #dc3545;
$color-light: #f8f9fa;
$color-dark: #343a40;

// Semantic Colors
$color-text: $color-dark;
$color-text-muted: $color-secondary;
$color-link: $color-primary;
$color-border: #dee2e6;
$color-focus: rgba($color-primary, .25);

// State Colors
$color-success-light: lighten($color-success, 40%);
$color-warning-light: lighten($color-warning, 40%);
$color-danger-light: lighten($color-danger, 40%);
```

### Typography

```scss
// Font Families
$font-family-base: -apple-system, system-ui, sans-serif;
$font-family-heading: $font-family-base;
$font-family-monospace: SFMono-Regular, Menlo, Monaco, Consolas;

// Font Sizes
$font-size-base: 1rem;
$font-size-lg: $font-size-base * 1.25;
$font-size-sm: $font-size-base * .875;

// Font Weights
$font-weight-light: 300;
$font-weight-normal: 400;
$font-weight-bold: 700;

// Line Heights
$line-height-base: 1.5;
$line-height-sm: 1.25;
$line-height-lg: 2;
```

### Spacing

```scss
// Base Spacing
$spacing-unit: .25rem;

// Spacing Scale
$spacing: (
    0: 0,
    1: $spacing-unit,
    2: $spacing-unit * 2,
    3: $spacing-unit * 4,
    4: $spacing-unit * 6,
    5: $spacing-unit * 8
);

// Component Spacing
$spacing-modal: map-get($spacing, 3);
$spacing-card: map-get($spacing, 2);
$spacing-section: map-get($spacing, 4);
```

### Breakpoints

```scss
// Breakpoint Scale
$breakpoints: (
    xs: 0,
    sm: 576px,
    md: 768px,
    lg: 992px,
    xl: 1200px,
    xxl: 1400px
);

// Container Widths
$container-max-widths: (
    sm: 540px,
    md: 720px,
    lg: 960px,
    xl: 1140px,
    xxl: 1320px
);
```

## Using Tokens

### In SCSS

```scss
.feature-component {
    // Colors
    color: $color-text;
    background: $color-light;
    border: 1px solid $color-border;

    // Typography
    font-family: $font-family-base;
    font-size: $font-size-base;
    line-height: $line-height-base;

    // Spacing
    padding: map-get($spacing, 3);
    margin-bottom: map-get($spacing, 2);
}
```

### With Mixins

```scss
.feature-component {
    // Responsive
    @include media-breakpoint-up(md) {
        display: flex;
    }

    // Typography
    @include font-size($font-size-lg, $line-height-lg);

    // Flexbox
    @include flex-center;

    // Grid
    @include grid(3, map-get($spacing, 2));
}
```

## Component Patterns

### Cards

```scss
.card {
    @include card-base;
    padding: $spacing-card;
    background: $color-light;
    border: 1px solid $color-border;
    
    &--primary {
        @include card-variant($color-primary);
    }
}
```

### Modals

```scss
.modal {
    @include modal-base;
    
    &__header {
        padding: $spacing-modal;
        border-bottom: 1px solid $color-border;
    }
    
    &__body {
        padding: $spacing-modal;
    }
    
    &__footer {
        padding: $spacing-modal;
        border-top: 1px solid $color-border;
    }
}
```

### Forms

```scss
.form {
    &__group {
        margin-bottom: map-get($spacing, 3);
    }
    
    &__label {
        font-weight: $font-weight-bold;
        margin-bottom: map-get($spacing, 1);
    }
    
    &__input {
        @include form-control;
        
        &:focus {
            @include form-control-focus;
        }
    }
}
```

## Responsive Design

### Media Queries

```scss
// Mobile First
@include media-breakpoint-up(md) {
    .feature {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
    }
}

// Desktop First
@include media-breakpoint-down(sm) {
    .feature {
        display: block;
    }
}
```

### Container Classes

```scss
.container {
    @include make-container;
    
    // Responsive containers
    @each $breakpoint, $width in $container-max-widths {
        @include media-breakpoint-up($breakpoint) {
            max-width: $width;
        }
    }
}
```

## Best Practices

### File Organization

```
assets/
├── scss/
│   ├── abstracts/
│   │   ├── _variables.scss
│   │   ├── _functions.scss
│   │   └── _mixins.scss
│   ├── base/
│   │   ├── _reset.scss
│   │   └── _typography.scss
│   ├── components/
│   │   ├── _buttons.scss
│   │   └── _forms.scss
│   └── main.scss
```

### Naming Conventions

```scss
// BEM Methodology
.block {
    &__element {
        &--modifier {
            // Styles
        }
    }
}

// Namespacing
.feature-name {
    &__component {
        // Styles
    }
}
```

### Performance

1. Use CSS Custom Properties for dynamic values
2. Minimize nesting (max 3 levels)
3. Use appropriate selectors
4. Avoid `@extend` in components

### Maintainability

1. Document complex calculations
2. Use meaningful variable names
3. Group related properties
4. Keep components focused

## Testing

### Visual Regression

```bash
# Run visual tests
npm run test:visual

# Update snapshots
npm run test:visual:update
```

### Accessibility

```bash
# Check contrast ratios
npm run test:a11y

# Validate ARIA usage
npm run test:aria
```

## Troubleshooting

### Common Issues

1. Styles not applying
   - Check specificity
   - Verify compilation
   - Check import order
   - Validate syntax

2. Responsive issues
   - Test breakpoints
   - Check media queries
   - Verify viewport settings
   - Test different devices

3. Performance issues
   - Audit CSS size
   - Check selector complexity
   - Minimize animations
   - Profile rendering
``` 