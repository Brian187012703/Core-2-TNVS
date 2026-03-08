<?php
header('Content-Type: text/plain');
?>
# BPM TNVS CORE 2 - Complete Component & Function Presentation Script

## Project Overview

**ByaHERO** - An intelligent fleet management platform built with HTML5, CSS3, and Vanilla JavaScript. A comprehensive system for managing vehicles, fuel, drivers, maintenance, analytics, and customer relationships.

---

## ARCHITECTURE OVERVIEW

### System Architecture

```
├── Frontend UI Layer (HTML/CSS)
│   ├── Authentication (index\.php, login-script.js)
│   ├── Dashboard (dashboard\.php, script.js)
│   └── Modular Components
├── JavaScript Core System
│   ├── Module Loader (modules/module-loader.js)
│   ├── Dashboard Analytics (js/dashboard-analytics.js)
│   ├── Notification System (modules/notifications/)
│   └── Module Handlers (js/*.js)
└── CSS Styling
    ├── Global Styles (design.css)
    ├── Login Styles (login-styles.css)
    └── Module-specific Styles
```

---

## SECTION 1: AUTHENTICATION & LOGIN SYSTEM

### 1.1 Login Page (index\.php)

**Purpose:** Initial user authentication interface

#### Key Components:

- **Logo Section**: ByaHERO branding with neon accent
- **Promotional Stats Grid**:
  - 24/7 Real-Time Tracking
  - 94% Fleet Utilization
  - 35% Cost Savings
  - 99.9% Uptime
- **Login Form**:
  - Email input field with icon validation
  - Password input with toggle visibility
  - Remember me checkbox
  - Forgot password link

#### Modal Dialogs:

- **Forgot Password Modal**: Reset email submission
- **Reset Success Modal**: Confirmation with instructions
- **Contact Admin Modal**: Support contact form

---

### 1.2 Login Script Functions (login-script.js)

#### Core Functions:

**1. Password Visibility Toggle**

```
Function: togglePasswordVisibility()
- Toggles password field between text and password type
- Updates icon between fa-eye and fa-eye-slash
- Triggered on eye icon click
```

**2. Modal Management System**

```
Function: openModal(modal)
- Opens specified modal with fade-in animation
- Disables body scroll overflow
- Sets is-open class

Function: closeModal(modal)
- Closes modal with fade-out animation
- Re-enables body scroll if no modals open
- Removes is-open class
```

**3. Reset Link Handler**

```
Function: sendResetLink()
- Captures reset email from input
- Closes forgot password modal
- Shows success modal with email confirmation
- Displays toast notification: "Password reset email sent successfully"
- Updates success message dynamically
```

**4. Modal Trigger Handlers**

```
Function: initForgotPasswordLink()
- Opens forgot password modal on link click

Function: initContactAdminLink()
- Opens contact admin modal

Function: initTryDifferentEmail()
- Switches from success modal back to forgot password
```

**5. Form Submission**

```
Function: handleLoginSubmit()
- Validates email and password fields
- Sets localStorage flag: tnvs_logged_in = "true"
- Redirects to dashboard\.php on success
- Shows error toast on validation failure
```

---

## SECTION 2: DASHBOARD & MAIN APPLICATION

### 2.1 Dashboard Layout (dashboard\.php)

#### Page Structure:

**Header Section:**

- Hamburger menu toggle (responsive)
- Navigation sidebar with collapse
- Top navigation bar with:
  - Application title
  - User profile dropdown
  - Settings button
  - Notification center

**Sidebar Navigation:**

```
Navigation Items:
├── Dashboard Overview (default view)
├── Fuel Management
├── CRM (Customer Relations)
├── Storeroom (Inventory)
├── Driver Info
├── Analytics
└── Settings
```

**Main Content Area:**

- Dynamic content section that loads modules
- Real-time dashboard with stat cards
- Activity feed
- Fleet status overview

---

### 2.2 Main Script System (script.js)

**Total Functions: 50+**

#### Core Authentication Functions:

**1. checkAuthentication()**

```
- Validates if user is logged in via localStorage
- Checks for: tnvs_logged_in = "true"
- Redirects to index\.php if not authenticated
- Called on page load (first execution)
```

**2. initDashboardTemplate()**

```
- Stores initial dashboard HTML on first load
- Retrieves default-view element
- Saves to dashboardHTML global variable
- Allows restoration to home view
```

#### Navigation & UI Functions:

**3. toggleSidebar()**

```
- Toggles sidebar.collapsed class
- Shows/hides sidebar navigation
- Updates hamburger icon state
- Triggered by hamburger button click
```

**4. handleNavigation()**

```
- Listens for nav-link clicks
- Extracts data-section attribute
- Prevents default link behavior
- Calls loadSection(sectionName)
- Highlights active navigation item
```

**5. updateActiveNav(sectionName)**

```
- Removes active class from all nav items
- Applies active class to clicked nav item
- Updates visual highlight state
- Ensures only one active item at a time
```

#### Module Loading Functions:

**6. loadSection(section)**

```
- Main module loader function
- Supports: fuel, crm, storeroom, driver, analytics, settings
- Calls moduleLoader.loadAndRender(section)
- Handles special case for dashboard (restores dashboardHTML)
```

**7. loadDashboard()**

```
- Restores dashboard home view
- Resets mainContent to dashboardHTML
- Re-initializes dashboard analytics
- Updates nav to show Dashboard as active
```

#### Fuel Management Functions:

**8. initFuelHandlers()**

```
- Sets up fuel module event listeners
- Loads fuel data from localStorage
- Initializes table displays (purchases, consumption)
```

**9. recordFuelPurchase()**

```
Parameters:
  - date: purchase date
  - invoiceNumber: invoice reference
  - supplier: fuel supplier name
  - fuelType: petrol or diesel
  - quantity: liters purchased
  - unitPrice: price per liter
  - totalCost: total transaction cost

Actions:
  - Validates all fields
  - Generates unique ID
  - Stores in localStorage.tnvs_purchases
  - Updates dashboard stats
  - Displays success toast
  - Refreshes purchases table
```

**10. recordFuelConsumption()**

```
Parameters:
  - date: consumption date
  - vehicleId: vehicle identifier
  - distance: kilometers traveled
  - fuelConsumed: liters used
  - fuelType: petrol or diesel

Actions:
  - Validates consumption data
  - Calculates fuel efficiency (L/100km)
  - Stores in localStorage.tnvs_consumption
  - Updates analytics dashboard
```

**11. updateFuelStats()**

```
Updates card values:
  - petrolStockValue: total petrol available
  - dieselStockValue: total diesel available
  - monthPurchaseValue: liters purchased this month
  - avgDailyValue: average daily consumption

Calculation Logic:
  - Sums all purchase quantities by type
  - Filters consumption for current month
  - Averages daily consumption rate
```

**12. displayPurchasesTable()**

```
- Renders purchases table with columns:
  - Date
  - Invoice #
  - Supplier
  - Fuel Type
  - Quantity (L)
  - Unit Price
  - Total

- Adds delete button for each row
- Shows empty state if no purchases
```

**13. displayConsumptionTable()**

```
- Renders consumption table with columns:
  - Date
  - Vehicle
  - Distance (km)
  - Fuel Consumed (L)
  - Fuel Type

- Calculates efficiency metrics
- Shows trends and patterns
```

#### CRM Functions:

**14. initCrmHandlers()**

```
- Initializes customer relationship management module
- Sets up contact list, notes, interaction tracking
- Loads CRM data from localStorage.tnvs_crm_contacts
```

**15. addCrmContact()**

```
Parameters:
  - name: customer/contact name
  - email: email address
  - phone: phone number
  - company: company name
  - lastInteraction: last contact date
  - notes: additional notes

Actions:
  - Validates contact data
  - Generates contact ID
  - Stores in localStorage.tnvs_crm_contacts
  - Updates contact list display
```

**16. searchCrmContact(keyword)**

```
- Filters contacts by name, email, or company
- Performs case-insensitive search
- Returns matching contacts
- Updates table in real-time
```

**17. updateCrmNotes(contactId, notes)**

```
- Updates notes for specific contact
- Saves to localStorage
- Shows timestamp of last update
```

#### Storeroom/Inventory Functions:

**18. initStoreroomHandlers()**

```
- Initializes inventory management module
- Loads stock items from localStorage.tnvs_storeroom
- Sets up inventory tables and forms
```

**19. addInventoryItem()**

```
Parameters:
  - itemName: name of inventory item
  - category: item category
  - quantity: current stock quantity
  - minimumStock: reorder level
  - unitCost: cost per unit
  - supplier: supplier information

Actions:
  - Validates inventory data
  - Generates item ID
  - Stores in localStorage.tnvs_storeroom
  - Flags low stock items
```

**20. updateStockQuantity(itemId, newQuantity)**

```
- Updates quantity for specific item
- Checks if quantity falls below minimum
- Triggers low stock notification
- Logs transaction to activity log
```

**21. generateLowStockReport()**

```
- Identifies items below minimum stock
- Generates reorder list
- Shows critical vs warning levels
- Exports report if needed
```

#### Driver Management Functions:

**22. initDriverHandlers()**

```
- Initializes driver information module
- Loads driver data from localStorage.tnvs_drivers
- Sets up driver list and profile views
```

**23. addDriver()**

```
Parameters:
  - name: driver full name
  - licenseNumber: driver license ID
  - licenseExpiry: license expiration date
  - phoneNumber: contact number
  - email: email address
  - status: active/inactive/suspended
  - hireDate: employment date
  - emergencyContact: emergency contact info

Actions:
  - Validates driver information
  - Checks license expiry dates
  - Generates driver ID
  - Stores in localStorage.tnvs_drivers
```

**24. updateDriverStatus(driverId, newStatus)**

```
- Updates driver status (active/inactive/suspended)
- Affects vehicle assignment eligibility
- Triggers notification if suspended
- Logs status change
```

**25. getDriverPerformanceMetrics(driverId)**

```
- Calculates driver safety rating
- Counts trips and kilometers
- Calculates fuel efficiency metrics
- Returns performance report
```

**26. generateDriverReport()**

```
- Creates comprehensive driver listing
- Shows status, performance, trips
- Groups by department/vehicle
- Exportable format
```

#### Analytics Functions:

**27. initAnalyticsHandlers()**

```
- Initializes analytics module
- Aggregates data from all other modules
- Sets up chart rendering
```

**28. calculateFleetMetrics()**

```
Returns:
  - Total vehicles in fleet
  - Total drivers
  - Average fleet utilization percentage
  - Total kilometers traveled
  - Total fuel consumed
  - Total operational cost
```

**29. generateRevenueReport(dateRange)**

```
Parameters:
  - dateRange: week/month/year/custom

Returns:
  - Total revenue in period
  - Revenue by vehicle
  - Revenue by driver
  - Trends and projections
```

**30. calculateFuelCostAnalysis()**

```
- Total fuel expenditure by type
- Cost per kilometer
- Monthly spending trends
- Cost per vehicle
- Efficiency ratings
```

**31. generateMaintenanceReport()**

```
- Lists all maintenance records
- Calculates preventive maintenance schedule
- Shows maintenance history by vehicle
- Identifies overdue maintenance
```

**32. createDashboardCharts()**

```
Creates visualization for:
  - Fleet utilization pie chart
  - Revenue trend line chart
  - Fuel consumption bar chart
  - Driver performance gauge
  - Vehicle status dashboard
```

#### Settings Module Functions:

**33. initSettingsHandlers()**

```
- Initializes user settings module
- Loads user preferences from localStorage
- Sets up preferences forms
```

**34. updateUserProfile()**

```
Parameters:
  - displayName: user's display name
  - email: user email
  - phone: phone number
  - preferences: user settings object

Actions:
  - Validates user data
  - Updates localStorage.tnvs_user_profile
  - Reflects changes across UI
```

**35. updateTheme(themeName)**

```
Parameters:
  - themeName: "dark" or "light"

Actions:
  - Sets data-theme attribute on html element
  - Saves preference to localStorage.tnvs_theme
  - Updates CSS variables
  - Applies across all pages
```

**36. manageNotificationPreferences()**

```
Updates preferences for:
  - System notifications
  - Fuel updates
  - Maintenance reminders
  - Driver messages
  - Vehicle alerts
  - Revenue reports
  - Sound enable/disable
```

#### Profile Module Functions:

**37. initProfileHandlers()**

```
- Initializes user profile module
- Loads user data from localStorage
- Sets up profile view and editing
```

**38. displayUserProfile()**

```
- Shows user information
- Displays user avatar
- Shows activity history
- Lists assigned vehicles/responsibilities
```

**39. updateUserProfileData(userData)**

```
- Updates all user profile fields
- Saves to localStorage.tnvs_user_profile
- Triggers UI refresh
```

#### Activity Logging Functions:

**40. logActivity(action, module, details)**

```
Parameters:
  - action: action type (created, updated, deleted, viewed)
  - module: module name where action occurred
  - details: description of action

Actions:
  - Creates activity object with timestamp
  - Stores in localStorage.tnvs_activity_log
  - Triggers activity feed update
```

**41. updateActivityFeed()**

```
- Fetches latest 20 activities
- Renders activity list with:
  - Icon for module type
  - Action description
  - Timestamp (relative time)
  - User who performed action
```

**42. getActivityLog(filter, dateRange)**

```
- Retrieves activities with optional filtering
- Filters by module or user
- Filters by date range
- Returns array of activities
```

#### Theme & Styling Functions:

**43. initThemeSystem()**

```
- Checks for saved theme preference
- Defaults to dark mode
- Applies theme on page load
- Sets data-theme attribute
```

**44. toggleTheme()**

```
- Switches between dark and light themes
- Updates CSS variables
- Saves preference
- Shows toast notification
```

#### Storage & Data Functions:

**45. initializeLocalStorage()**

```
- Creates default data structures if missing:
  - tnvs_logged_in
  - tnvs_purchases
  - tnvs_consumption
  - tnvs_drivers
  - tnvs_crm_contacts
  - tnvs_storeroom
  - tnvs_activity_log
  - tnvs_notification_prefs
  - tnvs_user_profile
```

**46. exportDataAsJSON()**

```
- Exports all application data
- Creates downloadable JSON file
- Includes timestamp
- Can be used for backup
```

**47. importDataFromJSON(file)**

```
- Imports data from JSON file
- Validates data structure
- Merges with existing data
- Shows success notification
```

#### UI Helper Functions:

**48. showToast(message, duration, type)**

```
Parameters:
  - message: notification text
  - duration: display time in ms (default: 3000)
  - type: "success", "error", "warning", "info"

Actions:
  - Shows temporary notification
  - Auto-dismisses after duration
  - Supports multiple toasts stacking
```

**49. updateDashboardCards()**

```
- Updates stat cards with live data
- Calculates deltas (trends)
- Shows up/down arrows
- Color codes positive/negative trends
```

**50. formatCurrency(amount)**

```
- Formats number as currency
- Default: Philippine Peso (₱)
- Returns formatted string
```

---

## SECTION 3: NOTIFICATION SYSTEM

### 3.1 Notification System Architecture

#### Core Class: NotificationSystem (notifications.js)

**Constructor & Initialization:**

```
Property: notifications[]
- Array of notification objects
- Max 50 stored notifications
- Persisted in localStorage.tnvs_notifications

Property: preferences{}
- User notification preferences
- Saved in localStorage.tnvs_notification_prefs
```

#### Notification System Functions:

**1. addNotification(notificationData)**

```
Parameters:
  - type: notification type (fuel, driver, system, maintenance, alert)
  - title: notification title
  - message: notification message
  - timestamp: when notification occurred
  - read: read status (true/false)
  - actions: optional action buttons

Actions:
  - Checks if notification type is enabled in preferences
  - Generates unique ID from timestamp
  - Adds to beginning of notifications array
  - Keeps only last 50 notifications
  - Saves to localStorage
  - Renders notification to dropdown/list
  - Plays sound if enabled
  - Updates unread badge count
```

**2. shouldShowNotification(type)**

```
Parameters:
  - type: notification type

Returns:
  - Boolean based on user preferences

Types Checked:
  - vehicleAlerts
  - driverMessages
  - fuelUpdates
  - maintenanceReminders
  - revenueReports
  - systemNotifications
```

**3. markAsRead(notificationId)**

```
- Sets notification.read = true
- Updates in localStorage
- Decrements unread badge
- Triggers visual update
```

**4. markAllAsRead()**

```
- Sets all notifications.read = true
- Updates localStorage
- Clears unread badge
- Shows confirmation toast
```

**5. deleteNotification(notificationId)**

```
- Removes notification from array
- Updates localStorage
- Triggers re-render
- Updates badge count
```

**6. renderNotifications()**

```
- Builds HTML for notification dropdown
- Shows unread badge for unread count
- Displays time stamps as relative time
- Shows notification icons by type
- Makes read notifications slightly dimmed
```

**7. updateNotificationBadge()**

```
- Counts unread notifications
- Updates badge element with count
- Hides badge if count is 0
- Uses notification-badge class
```

**8. saveNotifications()**

```
- Serializes notifications array to JSON
- Saves to localStorage.tnvs_notifications
- Includes timestamp of save
```

**9. savePreferences()**

```
- Serializes preferences object to JSON
- Saves to localStorage.tnvs_notification_prefs
- Called after any preference change
```

**10. getUnreadCount()**

```
Returns:
  - Number of unread notifications
- Used for badge display
- Cached for performance
```

#### Notification Types & Examples:

```
FUEL_UPDATE:
{
  type: 'fuel',
  title: 'Fuel Purchased',
  message: 'Vehicle TNVS-001 refueled with 50 liters',
  read: false
}

DRIVER_MESSAGE:
{
  type: 'driver',
  title: 'Driver Status Change',
  message: 'Driver John Doe is now inactive',
  read: false
}

MAINTENANCE_REMINDER:
{
  type: 'maintenance',
  title: 'Maintenance Due',
  message: 'Vehicle TNVS-005 maintenance is overdue',
  read: false
}

VEHICLE_ALERT:
{
  type: 'alert',
  title: 'Critical Alert',
  message: 'Vehicle offline for 2 hours',
  read: false
}

SYSTEM_NOTIFICATION:
{
  type: 'system',
  title: 'System Ready',
  message: 'Notification system fully initialized',
  read: false
}
```

---

### 3.2 Notification System Initialization (notification-system-init.js)

#### Initialization Functions:

**1. initializeNotificationSystemCompletely()**

```
- Main initialization function
- Waits for NotificationSystem to be ready
- Calls setup functions in sequence
- Tests system functionality
```

**2. setupDefaultPreferences()**

```
Actions:
- Checks if preferences exist in localStorage
- Creates defaults if missing:
  - systemNotifications: true
  - fuelUpdates: true
  - maintenanceReminders: true
  - driverMessages: true
  - vehicleAlerts: true
  - revenueReports: true
  - soundEnabled: true
- Loads preferences into notificationSystem object
```

**3. setupNotificationSettingsHandlers()**

```
Maps checkboxes to preferences:
- notif_email → systemNotifications
- notif_fuel → fuelUpdates
- notif_maint → maintenanceReminders
- notif_driver → driverMessages
- notif_daily → vehicleAlerts

Actions:
- Loads current preference state into checkboxes
- Adds change event listeners
- Updates preferences object on change
- Persists changes to localStorage
```

**4. testNotificationSystem()**

```
Tests:
1. Check notifications array exists
2. Check preferences object exists
3. Try adding test notification
4. Verify badge updates correctly
5. Logs results to console with emojis

Outputs:
- ✅ for successful checks
- ❌ for errors
- ⚠️ for warnings
```

---

## SECTION 4: MODULE LOADER SYSTEM

### 4.1 Module Loader Class (modules/module-loader.js)

#### Core Class: ModuleLoader

**Constructor:**

```
Property: modules[]
- Array of available module names:
  ['fuel', 'crm', 'storeroom', 'driver', 'analytics', 'profile', 'settings']

Property: loadedModules (Set)
- Tracks which modules have been loaded
- Prevents duplicate loading
- Persists during session
```

#### Module Loader Functions:

**1. loadModule(moduleName)**

```
Async function for loading module resources

Actions:
1. Checks if module already loaded
2. If loaded, returns early
3. Creates <link> element for CSS file
4. Appends link to document.head
5. Creates <script> element for JS file
6. Sets onload callback to mark as loaded
7. Appends script to document.body
8. Handles errors with console logging
```

**2. loadModuleTemplate(moduleName)**

```
Async function for fetching module HTML

Process:
- Fetches modules/[moduleName]/[moduleName]\.php
- Uses fetch API with error handling
- Parses response as text
- Returns HTML template string
- Logs error if fetch fails

Returns:
- HTML string on success
- Empty string on error
```

**3. loadAndRender(moduleName)**

```
Main function combining loading and rendering

Sequence:
1. Calls loadModule(moduleName)
2. Calls loadModuleTemplate(moduleName)
3. Gets mainContent element
4. Sets mainContent.innerHTML to template
5. Checks for init handler function
6. Calls init[ModuleName]Handlers() if exists
7. Example: initFuelHandlers(), initCrmHandlers()

Error Handling:
- Catches load failures
- Logs errors
- Shows user-friendly message
```

**4. capitalize(str)**

```
Helper function

Input: 'fuel'
Output: 'Fuel'

Used for:
- Building handler function names
- Module name capitalization
```

---

## SECTION 5: DASHBOARD ANALYTICS

### 5.1 Dashboard Analytics Class (js/dashboard-analytics.js)

#### Core Class: DashboardAnalytics

**Constructor & Initialization:**

```
Property: activityLog[]
- Stores all user activities
- Loaded from localStorage.tnvs_activity_log
- Maximum 100 entries

Init Process:
1. Loads activity log from storage
2. Calls initDashboard()
3. Sets up 5-second refresh interval
4. Updates stats in real-time
```

#### Dashboard Analytics Functions:

**1. getActivityLog()**

```
Returns:
- Array of activity objects from localStorage
- Parses JSON from localStorage.tnvs_activity_log
- Returns empty array if not found or parse error
```

**2. logActivity(action, module, details)**

```
Parameters:
- action: action type (created, updated, deleted, etc.)
- module: module name (fuel, crm, driver, etc.)
- details: description of activity

Creates activity object:
{
  id: timestamp,
  action: action,
  module: module,
  details: details,
  timestamp: ISO date string
}

Actions:
- Adds to beginning of activityLog array
- Persists to localStorage
- Triggers activity feed update
```

**3. initDashboard()**

```
Initialization sequence:
1. Calls updateDashboardStats()
2. Calls updateRecentActivity()
3. Calls updateFleetStatus()
4. Sets setInterval for 5-second refresh
5. Re-fetches activity log on each interval
```

**4. updateDashboardStats()**

```
Updates four main stat cards:

1. Total Vehicles
   - Counts unique vehicles from purchases
   - Displays count + trend

2. Active Drivers
   - Gets drivers with status='active'
   - Calculates percentage of total drivers
   - Shows count + percentage

3. Today's Revenue
   - Sums today's fuel expenses
   - Converts to thousands
   - Estimates revenue at 2.8x cost
   - Shows with +8.5% trend

4. Fuel Cost
   - Calculates today's total fuel cost
   - Converts to thousands (₱k)
   - Shows with -5% trend
```

**5. getAllVehicles()**

```
Returns:
- Array of vehicle objects extracted from purchases

Process:
1. Gets all purchases from localStorage
2. Groups by vehicleId
3. Creates vehicle object for each ID:
   {
     id: vehicleId,
     name: 'TNVS-XXX' (padded),
     status: 'in-use'
   }
4. Returns array of unique vehicles
```

**6. getAllDrivers()**

```
Returns:
- Array of driver objects from localStorage.tnvs_drivers
- Returns empty array if none found
```

**7. calculateTodaysMetrics()**

```
Returns:
{
  revenue: calculated revenue,
  fuelCost: fuel cost in thousands,
  purchases: number of purchases
}

Calculation:
1. Gets all purchases from localStorage
2. Filters purchases for today's date
3. Sums total cost of today's purchases
4. Divides by 1000 to get thousands (₱k)
5. Calculates revenue as fuelCost × 2.8
6. Returns calculated or default values
```

**8. updateCard(cardTitle, value, delta)**

```
Parameters:
- cardTitle: title to match in cards
- value: new value to display
- delta: change indicator (e.g., '+8.5%', '-5%')

Actions:
1. Finds card with matching title
2. Updates card-value element
3. Renders new HTML with:
   - Value text
   - Delta value
   - Up/down arrow icon
   - Color coded (up=green, down=red)
```

**9. updateRecentActivity()**

```
Updates activity list display:

Process:
1. Gets .activity-list element
2. Retrieves last 8 activities from activityLog
3. Maps activities to list items with:
   - Module icon (from getActivityIcon)
   - Activity description (from getActivityText)
   - Relative time (from formatTime)
4. Renders HTML into activity list
5. Shows empty state if no activities
```

**10. generateInitialActivities()**

```
Generates initial activities from existing data:

Process:
1. Gets purchases from localStorage
2. Takes last 4 purchases
3. Creates activity for each:
   {
     action: 'fuel_purchase',
     module: 'fuel',
     details: 'TNVS-XXX refueled with Y liters',
     timestamp: staggered past times
   }
4. Stores in activityLog
5. Updates activity display
```

**11. getActivityIcon(module)**

```
Returns Font Awesome icon for module:
- 'fuel' → 'gas-pump'
- 'driver' → 'id-card'
- 'crm' → 'address-book'
- 'storeroom' → 'boxes'
- 'analytics' → 'chart-bar'
- 'system' → 'cog'
- default → 'bell'
```

**12. getActivityText(activity)**

```
Returns human-readable activity text:

Examples:
- action: 'fuel_purchase' → 'TNVS-001 refueled with 50 liters'
- action: 'driver_added' → 'New driver John Doe added'
- action: 'storeroom_update' → 'Inventory updated: Oil filter'
```

**13. formatTime(timestamp)**

```
Converts ISO timestamp to relative time:

Returns:
- 'just now' (< 1 minute)
- 'X minutes ago'
- 'X hours ago'
- 'X days ago'
- Date string for older entries
```

**14. updateFleetStatus()**

```
Updates fleet status display:

Shows:
- Total vehicles online/offline
- Total trips today
- Total distance covered
- Total fuel consumed
- Average efficiency
- Fleet utilization percentage
```

---

## SECTION 6: MODULE STRUCTURE

Each module follows this structure:

```
modules/[moduleName]/
├── [moduleName]\.php       (UI template)
├── [moduleName].css        (Module styles)
├── [moduleName].js         (Module logic & handlers)
└── README.md              (Module documentation)
```

### Available Modules:

**1. Fuel Module** (modules/fuel/)

- Manages fuel purchases and consumption
- Tracks inventory by fuel type
- Records vehicle consumption
- Generates reports

**2. CRM Module** (modules/crm/)

- Customer/contact management
- Interaction tracking
- Notes and follow-ups
- Contact search and filtering

**3. Storeroom Module** (modules/storeroom/)

- Inventory management
- Stock tracking
- Low stock alerts
- Reorder management

**4. Driver Module** (modules/driver/)

- Driver information
- License management
- Status tracking
- Performance metrics

**5. Analytics Module** (modules/analytics/)

- Fleet analytics
- Revenue reports
- Fuel consumption analysis
- Performance dashboards

**6. Profile Module** (modules/profile/)

- User profile management
- Settings preferences
- User activity history
- Account settings

**7. Settings Module** (modules/settings/)

- Application settings
- Theme preferences
- Notification preferences
- Data export/import

---

## SECTION 7: DATA STORAGE STRUCTURE

### LocalStorage Keys:

**User Authentication:**

```
tnvs_logged_in: "true" | "false"
tnvs_user_profile: {
  displayName: string,
  email: string,
  phone: string,
  preferences: object
}
```

**Fuel Management:**

```
tnvs_purchases: [
  {
    id: number,
    date: string,
    invoiceNumber: string,
    supplier: string,
    fuelType: "petrol" | "diesel",
    quantity: number,
    unitPrice: number,
    totalCost: number,
    vehicleId: string
  }
]

tnvs_consumption: [
  {
    id: number,
    date: string,
    vehicleId: string,
    distance: number,
    fuelConsumed: number,
    fuelType: "petrol" | "diesel"
  }
]
```

**Driver Management:**

```
tnvs_drivers: [
  {
    id: string,
    name: string,
    licenseNumber: string,
    licenseExpiry: string,
    phoneNumber: string,
    email: string,
    status: "active" | "inactive" | "suspended",
    hireDate: string,
    emergencyContact: string
  }
]
```

**CRM:**

```
tnvs_crm_contacts: [
  {
    id: number,
    name: string,
    email: string,
    phone: string,
    company: string,
    lastInteraction: string,
    notes: string
  }
]
```

**Inventory:**

```
tnvs_storeroom: [
  {
    id: string,
    itemName: string,
    category: string,
    quantity: number,
    minimumStock: number,
    unitCost: number,
    supplier: string,
    lastRestocked: string
  }
]
```

**Notifications:**

```
tnvs_notifications: [
  {
    id: number,
    type: string,
    title: string,
    message: string,
    timestamp: string,
    read: boolean,
    actions: object | null
  }
]

tnvs_notification_prefs: {
  systemNotifications: boolean,
  fuelUpdates: boolean,
  maintenanceReminders: boolean,
  driverMessages: boolean,
  vehicleAlerts: boolean,
  revenueReports: boolean,
  soundEnabled: boolean
}
```

**Activity Logging:**

```
tnvs_activity_log: [
  {
    id: number,
    action: string,
    module: string,
    details: string,
    timestamp: string
  }
]
```

**Preferences:**

```
tnvs_theme: "dark" | "light" | "system"
tnvs_language: "en" | other language codes
tnvs_timezone: timezone string
```

---

## SECTION 8: CSS CLASSES & STYLING

### Global CSS Classes:

**Utility Classes:**

```
.hidden - display: none
.active - active state
.disabled - disabled state
.loading - show loading spinner
.error - error styling
.success - success styling
.warning - warning styling
```

**Layout Classes:**

```
.dashboard-grid - responsive grid for stat cards
.content-view - main content container
.sidebar - left navigation sidebar
.sidebar.collapsed - collapsed state
.topbar - top navigation bar
.modal-backdrop - modal overlay
.modal-content - modal dialog box
.table-container - table wrapper
```

**Card Classes:**

```
.stat-card - stat display card
.card-header - card title area
.card-icon - icon in card
.card-title - title text
.card-value - main value display
.card-detail - supporting detail
.card-delta - change indicator
```

**Button Classes:**

```
.btn-primary - primary button style
.btn-secondary - secondary button style
.btn-danger - destructive action button
.btn-small - compact button size
```

---

## SECTION 9: KEY FEATURES SUMMARY

### Real-Time Dashboard

- Live statistics from all modules
- Auto-refreshing every 5 seconds
- Activity feed showing recent actions
- Fleet status overview

### Multi-Module System

- Modular architecture for scalability
- Lazy-loading of module resources
- Isolated module functionality
- Easy to add new modules

### Comprehensive Notification System

- Multiple notification types
- User preference filtering
- Sound notifications optional
- Persistent storage
- Read/unread tracking

### Robust Data Management

- LocalStorage persistence
- Activity logging
- Data export/import capability
- Backup and restore functionality

### Theme Support

- Dark/Light theme toggle
- Persistent theme preference
- Real-time theme switching
- CSS variable-based theming

### Responsive Design

- Mobile-friendly layout
- Collapsible sidebar
- Touch-friendly interactions
- Adaptive content views

---

## SECTION 10: USER WORKFLOW

### Login Flow

1. User visits index\.php
2. Sees login form with promotional content
3. Enters email and password
4. System validates credentials (demo: accepts any valid email/password)
5. Sets localStorage.tnvs_logged_in = "true"
6. Redirects to dashboard\.php

### Dashboard Navigation Flow

1. User lands on dashboard\.php
2. Authentication check passes
3. Dashboard initializes with:
   - Sidebar navigation
   - Default home view with stats
   - Activity feed
   - Real-time updates
4. User clicks navigation link
5. Module loads dynamically:
   - CSS loads
   - JavaScript loads
   - HTML template loads
   - Init handler called
6. Module displays with its data

### Fuel Purchase Recording Flow

1. User navigates to Fuel module
2. Clicks "Record Purchase" button
3. Modal form opens
4. User fills in:
   - Date
   - Invoice number
   - Supplier
   - Fuel type
   - Quantity
   - Unit price
5. Submits form
6. Data validated and stored
7. Activity logged
8. Dashboard stats updated
9. Toast notification shown
10. Table refreshed with new entry

### Notification Flow

1. System event occurs (e.g., fuel purchase)
2. logActivity() called with event details
3. addNotification() creates notification
4. Checks user preferences for notification type
5. Updates notification badge count
6. Plays sound if enabled
7. Stores in localStorage
8. Renders in notification dropdown
9. User can mark as read
10. User can delete notification

---

## SECTION 11: ERROR HANDLING & VALIDATION

### Form Validation Functions (implicit in handlers)

- Email format validation
- Required field checks
- Numeric value validation
- Date format validation
- Password strength checking

### Error States

- Network errors logged to console
- Invalid data shows toast error
- Missing modules show user message
- LocalStorage errors fallback to defaults

### Recovery Mechanisms

- Automatic localStorage fallback
- Default empty states
- Graceful degradation
- Error logging for debugging

---

## SECTION 12: PERFORMANCE OPTIMIZATIONS

### Lazy Loading

- Modules load only when needed
- CSS/JS loaded dynamically
- Templates fetched on demand

### Caching

- Modules cached in loadedModules Set
- Activity log cached for quick access
- Dashboard stats cached between refreshes

### Efficiency

- 5-second refresh interval (not too frequent)
- Array slicing to limit stored items (50 notifications, 100 activities)
- Efficient DOM queries and updates

---

## CONCLUSION

The BPM TNVS CORE 2 system is a comprehensive, modular fleet management application built on:

1. **Clean Architecture** - Modular, extensible design
2. **User-Centric Features** - Intuitive UI with real-time updates
3. **Robust Notifications** - Intelligent notification system with preferences
4. **Data Persistence** - LocalStorage-based data management
5. **Responsive Design** - Works on all device sizes
6. **Scalable Structure** - Easy to add new modules and features

**Total Components:** 7 Modules + Core System
**Total Functions:** 50+ Core Functions + Module-Specific Functions
**Data Storage:** 10+ LocalStorage Keys
**Authentication:** Email/Password-based access control
**Theme Support:** Dark/Light mode toggle
**Real-Time Updates:** 5-second dashboard refresh cycle

---

_This script covers the comprehensive architecture, components, and functionality of the BPM TNVS application system for presentation purposes._
