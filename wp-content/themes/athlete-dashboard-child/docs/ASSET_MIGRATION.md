# Asset Migration Plan

## Overview

We are migrating assets from the old structure to a new feature-first architecture. This document outlines the migration process and directory structure.

## Directory Structure

### Old Structure
```
/assets
  /dist
    /css
      main.css
      profile.css
      workout.css
      training-persona.css
    /js
      /main
        index.js
      /profile
        index.js
      /workout
        index.js
      /training-persona
        index.js
```

### New Structure
```
/dashboard
  /assets
    /css
      dashboard.css
    /js
      dashboard.js
  /features
    /profile
      /assets
        /css
          styles.css
        /js
          index.js
    /workout
      /assets
        /css
          styles.css
        /js
          index.js
    /training-persona
      /assets
        /css
          styles.css
        /js
          index.js
```

## Migration Steps

1. Create new directory structure:
```bash
mkdir -p dashboard/assets/{css,js}
mkdir -p dashboard/features/{profile,workout,training-persona}/assets/{css,js}
```

2. Move and rename files:
```bash
# Core dashboard assets
mv assets/dist/css/main.css dashboard/assets/css/dashboard.css
mv assets/dist/js/main/index.js dashboard/assets/js/dashboard.js

# Feature assets
mv assets/dist/css/profile.css dashboard/features/profile/assets/css/styles.css
mv assets/dist/js/profile/index.js dashboard/features/profile/assets/js/index.js

mv assets/dist/css/workout.css dashboard/features/workout/assets/css/styles.css
mv assets/dist/js/workout/index.js dashboard/features/workout/assets/js/index.js

mv assets/dist/css/training-persona.css dashboard/features/training-persona/assets/css/styles.css
mv assets/dist/js/training-persona/index.js dashboard/features/training-persona/assets/js/index.js
```

3. Update build configuration:
   - Update Vite/Webpack configuration to output to new paths
   - Update source maps
   - Update import paths in JS files

4. Update asset loading:
   - Update `functions.php` to handle both old and new paths during migration
   - Add fallback to legacy paths
   - Remove legacy path support after migration is complete

## Verification

1. Check that all assets load correctly:
   - Dashboard core styles and scripts
   - Feature-specific styles and scripts
   - No 404 errors in browser console

2. Verify functionality:
   - All features work as expected
   - No styling issues
   - No JavaScript errors

3. Performance check:
   - Asset sizes remain the same or smaller
   - No duplicate asset loading
   - Proper caching headers

## Cleanup

After migration is complete and verified:

1. Remove legacy asset directories:
```bash
rm -rf assets/dist/css
rm -rf assets/dist/js
```

2. Remove legacy path support from `functions.php`
3. Update documentation to reflect new structure
4. Update any remaining references to old paths

## Timeline

1. Week 1: Setup new directory structure and update build config
2. Week 2: Migrate core dashboard assets
3. Week 3: Migrate feature assets
4. Week 4: Testing and verification
5. Week 5: Cleanup and documentation
``` 