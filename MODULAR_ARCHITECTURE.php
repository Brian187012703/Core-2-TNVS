<?php
header('Content-Type: text/plain');
?>
# TNVS BPM System - Modular Architecture

## Overview

The system has been reorganized into a clean, modular structure to improve maintainability and organization. Each module is now self-contained with its own HTML template, JavaScript logic, and CSS styles.

## Directory Structure

```
modules/
├── fuel/
│   ├── fuel\.php      (UI Template)
│   ├── fuel.js        (Logic & Handlers)
│   └── fuel.css       (Styles)
├── crm/
│   ├── crm\.php
│   ├── crm.js
│   └── crm.css
├── storeroom/
│   ├── storeroom\.php
│   ├── storeroom.js
│   └── storeroom.css
├── driver/
│   ├── driver\.php
│   ├── driver.js
│   └── driver.css
├── analytics/
│   ├── analytics\.php
│   ├── analytics.js
│   └── analytics.css
├── profile/
│   ├── profile\.php
│   ├── profile.js
│   └── profile.css
├── settings/
│   ├── settings\.php
│   ├── settings.js
│   └── settings.css
└── module-loader.js   (Dynamic Module Loader)
```

## Module Components

### HTML Template (\.php)

- Contains only the UI structure for the module
- No inline JavaScript
- Uses standard HTML5 markup
- Responsive design compatible with main CSS

### JavaScript (.js)

- Module initialization function: `init[ModuleName]Handlers()`
- Data management functions: getters and setters
- Event handlers and DOM manipulation
- Business logic and calculations
- Uses localStorage for persistence

### CSS (.css)

- Module-specific styling
- Follows main design system (CSS variables)
- Uses same color scheme and theme
- Optional (inherits from main design.css)

## Loading Modules

### Method 1: Dynamic Loading (Recommended)

```javascript
// Load and render a module dynamically
moduleLoader.loadAndRender("fuel");
```

### Method 2: Direct HTML Inclusion

```html
<div id="mainContent"></div>
<script src="modules/fuel/fuel.js"></script>
```

## Data Persistence

Each module stores data in localStorage:

- `tnvs_purchases` - Fuel purchases
- `tnvs_customers` - CRM customers
- `tnvs_tickets` - Support tickets
- `tnvs_assets` - Storeroom inventory
- `tnvs_drivers` - Driver information

## Shared Utilities

Common functions available globally:

- `openModal(id)` - Open modal dialog
- `closeModal(id)` - Close modal dialog
- `escapeHtml(str)` - HTML escape string
- `capitalize(str)` - Capitalize string

## Benefits

✅ **Better Organization** - Each module is self-contained
✅ **Easier Maintenance** - Find and modify code faster
✅ **Scalability** - Easy to add new modules
✅ **Reusability** - Shared utilities across modules
✅ **Performance** - Load modules on demand
✅ **Collaboration** - Multiple developers can work on different modules

## Adding a New Module

1. Create a new folder: `modules/[module-name]/`
2. Create three files:
   - `[module-name]\.php` - UI template
   - `[module-name].js` - Logic and handlers
   - `[module-name].css` - Styles (optional)
3. Implement `init[ModuleName]Handlers()` function
4. Update main navigation with the new module
5. Load using: `moduleLoader.loadAndRender('[module-name]')`

## Migration Status

### ✅ Completed

- Fuel module (HTML, JS created)
- Module loader system

### 🔄 In Progress

- CRM module
- Storeroom module
- Driver module
- Analytics module
- Profile module
- Settings module

### 📝 Next Steps

1. Extract remaining module content from script.js
2. Create module-specific CSS files
3. Test all modules in new structure
4. Update dashboard\.php to use module loader
5. Remove inline templates from script.js
