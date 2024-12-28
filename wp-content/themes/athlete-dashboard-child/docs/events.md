# Event System Documentation

## Overview

The dashboard uses a unified event system that works across PHP and JavaScript. Events are namespaced by feature and provide type-safe communication between dashboard components.

## Event Structure

### Event Names

Events follow the format: `feature:action[:detail]`

Examples:
- `profile:updated`
- `workout:completed:set`
- `injury:added:knee`

### Event Data

Events include standardized metadata:

```typescript
interface DashboardEventDetail<T = any> {
    feature?: string;    // Source feature
    event: string;       // Event name
    data: T;            // Event-specific data
    timestamp: number;   // Event timestamp
}
```

## Using Events

### In JavaScript

```typescript
// Emitting events
Events.emit('profile:update', {
    height: 180,
    weight: 75
});

// Feature-specific events
Events.emitFeatureEvent('profile', 'update', {
    height: 180,
    weight: 75
});

// Listening for events
Events.on('profile:update', (detail) => {
    console.log('Profile updated:', detail.data);
});

// Feature-specific listeners
Events.onFeature('profile', 'update', (detail) => {
    console.log('Profile updated:', detail.data);
});
```

### In PHP

```php
// Emitting events
EventManager::getInstance()->emit('profile:update', [
    'height' => 180,
    'weight' => 75
]);

// Listening for events
add_action('dashboard_event_profile:update', function($data) {
    error_log('Profile updated: ' . json_encode($data));
});
```

## Core Events

### System Events

| Event | Description | Data |
|-------|-------------|------|
| `system:initialized` | Dashboard core initialized | `{ version: string }` |
| `system:ready` | All features loaded | `{ features: string[] }` |
| `system:error` | System error occurred | `{ error: string, context: any }` |

### Feature Events

| Event | Description | Data |
|-------|-------------|------|
| `feature:registered` | Feature registered | `{ identifier: string }` |
| `feature:initialized` | Feature initialized | `{ identifier: string }` |
| `feature:enabled` | Feature enabled | `{ identifier: string }` |
| `feature:disabled` | Feature disabled | `{ identifier: string }` |

### Modal Events

| Event | Description | Data |
|-------|-------------|------|
| `modal:open` | Modal opened | `{ id: string, data?: any }` |
| `modal:close` | Modal closed | `{ id: string }` |
| `modal:action` | Modal action triggered | `{ id: string, action: string }` |

## Feature Events

### Profile Feature

| Event | Description | Data |
|-------|-------------|------|
| `profile:update` | Profile updated | `{ height: number, weight: number }` |
| `profile:injury:add` | Injury added | `{ type: string, severity: string }` |
| `profile:goals:update` | Goals updated | `{ goals: string[] }` |

### Training Feature

| Event | Description | Data |
|-------|-------------|------|
| `training:workout:start` | Workout started | `{ id: string, type: string }` |
| `training:workout:complete` | Workout completed | `{ id: string, stats: any }` |
| `training:plan:update` | Training plan updated | `{ plan: any }` |

## Debug Mode

Enable debug mode to log all events:

```php
// In wp-config.php
define('WP_DEBUG', true);
```

Debug output includes:
- Event name and timestamp
- Event data
- Source feature
- Stack trace (for errors)

## Best Practices

### Event Names

1. Use clear, descriptive names
2. Follow the namespace pattern
3. Use past tense for completed actions
4. Be specific about the action

### Event Data

1. Include all necessary context
2. Use typed interfaces
3. Validate data structure
4. Include timestamps

### Event Handling

1. Handle events defensively
2. Validate event data
3. Handle errors gracefully
4. Document event contracts

### Performance

1. Use event delegation
2. Batch related events
3. Clean up listeners
4. Profile event handlers

## Security

### Event Validation

```php
// Validate event source
if (!current_user_can('edit_profile')) {
    return;
}

// Sanitize event data
$data = sanitize_text_field($data);
```

### Event Permissions

```php
// Check permissions before emitting
if (current_user_can('edit_profile')) {
    Events::emit('profile:update', $data);
}

// Check permissions in listener
Events::on('profile:update', function($detail) {
    if (!current_user_can('edit_profile')) {
        return;
    }
    // Handle event
});
```

## Testing

### Unit Testing Events

```php
public function testEventEmitted(): void {
    // Arrange
    $data = ['height' => 180];
    
    // Assert
    $this->assertEventEmitted('profile:update', $data);
}
```

### Integration Testing Events

```php
public function testEventPropagation(): void {
    // Arrange
    $this->loadFeature('profile');
    $this->loadFeature('training');
    
    // Act & Assert
    $this->assertFeatureInteraction(
        'profile',
        'training',
        'profile:update',
        ['height' => 180]
    );
}
```

## Troubleshooting

### Common Issues

1. Events not firing
   - Check event name spelling
   - Verify listener registration
   - Check permissions
   - Enable debug mode

2. Event data missing
   - Check data structure
   - Verify serialization
   - Check sanitization
   - Log raw event data

3. Event handlers not executing
   - Check handler registration
   - Verify dependencies loaded
   - Check error logs
   - Test in isolation 