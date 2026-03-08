<?php
header('Content-Type: text/plain');
?>
# 📦 Modules Directory - Quick Start Guide

## Overview

This directory contains all the modular components of the BPM TNVS system. Each module is self-contained with its own HTML, JavaScript, and CSS files.

## Directory Layout

```
modules/
├── fuel/                    # Fuel Management Module
│   ├── fuel\.php           # UI Template
│   ├── fuel.js             # Logic & Handlers
│   └── fuel.css            # Styles
│
├── crm/                     # Customer Relationship Management
│   ├── crm\.php
│   ├── crm.js
│   └── crm.css
│
├── storeroom/              # Inventory Management
│   ├── storeroom\.php
│   ├── storeroom.js
│   └── storeroom.css
│
├── driver/                 # Driver Management
│   ├── driver\.php
│   ├── driver.js
│   └── driver.css
│
├── analytics/              # Reports & Analytics
│   ├── analytics\.php
│   ├── analytics.js
│   └── analytics.css
│
├── profile/                # User Profile
│   ├── profile\.php
│   ├── profile.js
│   └── profile.css
│
├── settings/               # Application Settings
│   ├── settings\.php
│   ├── settings.js
│   └── settings.css
│
└── module-loader.js        # Dynamic Module Loader
```

## Module Components Explained

### HTML (\.php)

- **Purpose**: Contains the UI structure and markup
- **Characteristics**:
  - Pure HTML5
  - No inline JavaScript
  - Responsive design
  - Uses semantic HTML elements
  - Compatible with main design system

### JavaScript (.js)

- **Purpose**: Contains all logic and event handlers
- **Key Functions**:
  - `init[ModuleName]Handlers()` - Module initialization
  - Data getters/setters (localStorage)
  - Event handlers
  - DOM manipulation
  - Business logic

### CSS (.css)

- **Purpose**: Module-specific styling
- **Characteristics**:
  - Inherits from main design.css
  - Uses CSS custom properties (--color-\*, etc.)
  - Scoped styles to avoid conflicts
  - Optional (can be minimal if using main styles)

## Module Loader System

### How It Works

The `module-loader.js` file provides dynamic module loading:

```javascript
// Load a module
moduleLoader.loadAndRender("fuel");

// Load and render HTML template
const html = await moduleLoader.loadModuleTemplate("crm");

// Load module resources (CSS + JS)
await moduleLoader.loadModule("driver");
```

### Features

- Caches loaded modules
- Lazy loading (load on demand)
- Automatic initialization
- Error handling

## Complete Module - Fuel (Reference)

The **Fuel** module is 100% complete and serves as a reference:

```
modules/fuel/
├── fuel\.php              # ✅ 100% Complete
├── fuel.js                # ✅ 100% Complete
└── fuel.css               # ✅ 100% Complete
```

### Fuel Module Functions

**Main Handler:**

```javascript
initFuelHandlers(); // Initialize module
```

**Data Management:**

```javascript
getPurchases(); // Get all purchases
savePurchases(arr); // Save purchases to localStorage
```

**UI Rendering:**

```javascript
renderPurchasesTable(); // Render purchases table
renderConsumptionTable(); // Render consumption table
updateFuelSummary(); // Update summary stats
```

**Utilities:**

```javascript
openModal(id); // Open modal dialog
closeModal(id); // Close modal dialog
escapeHtml(str); // HTML escape
capitalize(str); // Capitalize text
```

## Extracting Modules from Main Script

### Step-by-Step Process

**1. Locate the handler function in script.js**

```javascript
// Find: function initCrmHandlers()
// Line: ~1377 (example)
```

**2. Copy the entire function and related functions**

```javascript
function initCrmHandlers() { ... }
function getCustomers() { ... }
function saveCustomers(arr) { ... }
function renderCustomersTable() { ... }
// etc...
```

**3. Paste into module JS file**

```javascript
// modules/crm/crm.js
function initCrmHandlers() { ... }
// ... all related functions
```

**4. Test the module**

```javascript
// In browser console:
moduleLoader.loadAndRender("crm");
```

**5. Remove from main script.js** (after testing)

## Shared Utilities

These are globally available in all modules:

```javascript
// Modal Management
openModal(modalId); // Open modal
closeModal(modalId); // Close modal

// String Utilities
escapeHtml(str); // Escape HTML special chars
capitalize(str); // Capitalize first letter

// Data Management (per module)
// Fuel
getPurchases();
savePurchases(arr);

// CRM
getCustomers();
saveCustomers(arr);
getTickets();
saveTickets(arr);

// Storeroom
getAssets();
saveAssets(arr);

// Driver
getDrivers();
saveDrivers(arr);

// etc...
```

## Adding a New Module

### 1. Create Module Directory

```bash
mkdir modules/mymodule
```

### 2. Create Three Files

**mymodule\.php** - UI Template

```html
<div class="content-view" data-section="mymodule">
  <h1>My Module</h1>
  <!-- UI here -->
</div>
```

**mymodule.js** - Logic

```javascript
function initMytmoduleHandlers() {
  // Initialize module
  console.log("My Module initialized");
}
```

**mymodule.css** - Styling

```css
/* Module-specific styles */
.mymodule {
}
```

### 3. Use the Module

```javascript
// In dashboard\.php or script.js
moduleLoader.loadAndRender("mymodule");
```

## Best Practices

### ✅ DO

- Keep modules self-contained
- Use consistent naming conventions
- Include descriptive comments
- Use localStorage for persistence
- Follow the Fuel module pattern
- Test modules independently
- Document your functions

### ❌ DON'T

- Mix logic across modules
- Use global variables excessively
- Hardcode values (use config instead)
- Ignore error handling
- Create circular dependencies
- Skip documentation

## Module Status

| Module    | HTML | JS  | CSS | Status               |
| --------- | ---- | --- | --- | -------------------- |
| Fuel      | ✅   | ✅  | ✅  | Complete             |
| CRM       | ✅   | 🔄  | ✅  | Ready for extraction |
| Storeroom | ✅   | 🔄  | ✅  | Ready for extraction |
| Driver    | ✅   | 🔄  | ✅  | Ready for extraction |
| Analytics | ✅   | 🔄  | ✅  | Ready for extraction |
| Profile   | ✅   | 🔄  | ✅  | Ready for extraction |
| Settings  | ✅   | 🔄  | ✅  | Ready for extraction |

Legend: ✅ Complete • 🔄 In Progress • ⏳ Pending

## File Sizes (Approx.)

- **Old script.js**: ~3000+ lines (700KB with logic)
- **Fuel module**: ~150 lines + 50 lines CSS
- **Average module**: 150-300 lines each
- **Total savings**: Much cleaner, easier to maintain

## Testing Modules

### In Browser Console

```javascript
// Load a module
moduleLoader.loadAndRender("fuel");

// Check if loaded
moduleLoader.loadedModules.has("fuel"); // true/false

// Get template
const html = await moduleLoader.loadModuleTemplate("crm");
console.log(html);
```

### Unit Testing

Create `modules/fuel/fuel.test.js`:

```javascript
describe("Fuel Module", () => {
  it("should initialize handlers", () => {
    initFuelHandlers();
    expect(document.getElementById("tabPurchases")).toBeTruthy();
  });
});
```

## Troubleshooting

### Module not loading?

1. Check browser console for errors
2. Verify file paths are correct
3. Ensure HTML file exists
4. Check module-loader.js CORS settings

### Handler not initializing?

1. Verify function name follows pattern: `init[ModuleName]Handlers()`
2. Check that function exists in module JS
3. Ensure module-loader calls the function

### Data not persisting?

1. Check localStorage keys are correct
2. Verify getSave functions are called
3. Check browser storage limits

## Performance Tips

1. **Lazy Load** - Load modules only when needed
2. **Cache** - Module loader caches loaded modules
3. **Minimize** - Remove unused CSS
4. **Bundle** - Group related utilities

## Contributing

When adding to modules:

1. Follow the established pattern
2. Use consistent naming
3. Add comments for complex logic
4. Test thoroughly
5. Update documentation
6. Keep modules focused and small

## Resources

- See: `MODULAR_ARCHITECTURE.md` - Technical details
- See: `MODULARIZATION_SUMMARY.md` - Project overview
- View: `MODULE_INDEX\.php` - Visual dashboard
- Ref: `modules/fuel/` - Complete example

## Support

For questions or issues:

1. Check the documentation files
2. Review the Fuel module example
3. Check browser console for errors
4. Verify file structure and naming

---

**Ready to modularize?** Start by extracting the CRM module following the Fuel module as your template! 🚀
