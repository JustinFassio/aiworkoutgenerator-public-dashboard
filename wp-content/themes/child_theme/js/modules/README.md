# Module Dependencies

## Core Modules

### ui.js
- Core UI functionality
- No dependencies
- Required by: all other modules

### workout.js
- Dependencies:
  - ui.js
  - chart.js (external)

### goals.js
- Dependencies:
  - ui.js
  - chart.js (external)

### attendance.js
- Dependencies:
  - ui.js

### membership.js
- Dependencies:
  - ui.js
  - stripe.js (external)

### messaging.js
- Dependencies:
  - ui.js

### charts.js
- Dependencies:
  - ui.js
  - chart.js (external)
  - chart-js-adapter (external)

## Loading Order
1. External Dependencies (jQuery, Chart.js, Stripe)
2. ui.js (core module)
3. Feature modules (workout.js, goals.js, etc.)
4. Legacy scripts
5. dashboard.js (main initialization)

## Legacy Scripts (To Be Migrated)
Located in `/js/legacy/`:
- nutrition-logger.js (depends on jQuery)
- nutrition-tracker.js (depends on jQuery, Chart.js)
- food-manager.js (depends on jQuery, jQuery UI)

## Migration Notes
- All new modules should use ES6 module syntax
- Legacy scripts to be gradually migrated to modern format
- jQuery dependencies to be replaced with native JavaScript
- All modules should initialize through dashboard.js 