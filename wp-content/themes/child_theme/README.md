# Athlete Dashboard Theme Structure

## Directory Structure

### /assets
- `/css`: Stylesheet files
- `/js`: JavaScript files
- `/images`: Image assets
- `/fonts`: Custom fonts

### /includes
- `/classes`: PHP classes organized by feature
- `/traits`: Reusable trait files
- `/interfaces`: Interface definitions

### /functions
- `/core`: Core functionality (autoloader, enqueue, database)
- `/dashboard`: Dashboard-specific functions
- `/user`: User management functions
- `/exercise`: Exercise-related functions
- `/messaging`: Messaging system functions
- `/api`: API and AJAX handlers

### /templates
- `/dashboard`: Dashboard template files
- `/messaging`: Messaging template files
- `/auth`: Authentication template files

## File Organization Guidelines

1. Each feature should be self-contained in its directory
2. Use classes for complex functionality
3. Keep templates separate from logic
4. Follow WordPress coding standards
5. Document all functions and classes

## Development

1. Use feature branches for development
2. Test thoroughly before merging
3. Keep functions small and focused
4. Document any breaking changes 