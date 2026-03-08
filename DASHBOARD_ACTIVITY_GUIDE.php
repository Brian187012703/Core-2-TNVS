<?php
header('Content-Type: text/plain');
?>
# Dashboard Real-Time Activity Integration

## Overview

Your dashboard is now connected to real activities happening in your modules. All actions are automatically tracked and displayed on the dashboard overview.

## What's Connected

### 1. **Dashboard Overview Stats** (Automatically Updated)

- **Total Vehicles** - Calculated from fuel purchases (unique vehicles recorded)
- **Active Drivers** - Pulled from driver module data
- **Today's Revenue** - Calculated from today's fuel purchases and transactions
- **Fuel Cost** - Sum of today's fuel expenses

### 2. **Recent Activity Log** (Real-Time Updates)

The activity section now shows:

- ✅ Fuel purchases with vehicle ID and quantity
- ✅ Driver shift start/end activities
- ✅ Maintenance alerts
- ✅ Trip completions
- ✅ All activities timestamped with "X minutes ago" format

### 3. **Fleet Status** (Dynamic)

The fleet status section automatically updates to show:

- Available vehicles
- In-use vehicles
- Vehicles under maintenance
- Inactive vehicles
  All pulled from module data

---

## How It Works

### Activity Logging Flow

```
User performs action in module
    ↓
Module records data to localStorage
    ↓
Module logs activity via logDashboardActivity()
    ↓
Dashboard Analytics captures activity
    ↓
Dashboard displays in Recent Activity list
```

### Data Flow Diagram

```
Fuel Module              Driver Module
    ↓                        ↓
localStorage         localStorage
(tnvs_purchases)     (tnvs_drivers)
    ↓                        ↓
Dashboard Analytics (pulls all data)
    ↓
Updates:
- Stats Cards
- Recent Activity
- Fleet Status
- Revenue Metrics
```

---

## Module Activity Integration

### Fuel Module

**When**: User records a fuel purchase
**Logs**:

```javascript
logDashboardActivity(
  "fuel_purchase",
  "fuel",
  "TNVS-001 refueled with 50 liters at ₱60/L",
);
```

**Updates**:

- Total fuel cost stat
- Fuel Cost card
- Recent Activity list
- Fleet status (if vehicle in list)

### Driver Module (Ready to integrate)

**When**: Driver shift starts/ends
**Logs**:

```javascript
logDashboardActivity("driver_shift", "driver", "Maria Clara started shift");
```

### CRM Module (Ready to integrate)

**When**: New ticket created
**Logs**:

```javascript
logDashboardActivity(
  "ticket_created",
  "crm",
  "Ticket #T-2024-001 from John Doe",
);
```

### Storeroom Module (Ready to integrate)

**When**: Inventory item added/removed
**Logs**:

```javascript
logDashboardActivity(
  "inventory_transaction",
  "storeroom",
  "Added 100 units of Engine Oil",
);
```

---

## Files Created/Modified

### New Files

- `js/dashboard-analytics.js` - Core dashboard analytics and activity tracking engine

### Modified Files

- `dashboard\.php` - Added script reference to dashboard-analytics.js
- `modules/fuel/fuel.js` - Added activity logging to fuel purchases
- `modules/fuel/fuel\.php` - Added Vehicle ID field to track which vehicle

---

## Dashboard Analytics Class

### Methods Available

```javascript
// Log activity from any module
logDashboardActivity(action, module, details);

// Example from Fuel module:
if (window.logDashboardActivity) {
  window.logDashboardActivity(
    "fuel_purchase",
    "fuel",
    `TNVS-001 refueled with 50 liters`,
  );
}

// Dashboard auto-updates every 10 seconds
```

---

## Real-Time Updates

The dashboard automatically refreshes every 10 seconds to show:

1. **Latest stats** - Total vehicles, active drivers, revenue, fuel cost
2. **Recent activities** - Last 8 activities with timestamps
3. **Fleet status** - Current vehicle availability breakdown

### Update Cycle

```
Every 10 seconds:
├─ Read all localStorage data
├─ Calculate metrics
├─ Update stat cards
├─ Fetch recent activities
├─ Update fleet status
└─ Display on dashboard
```

---

## Activity Types Tracked

### Current (Implemented)

- ✅ `fuel_purchase` - Fuel refueling
- ✅ `driver_shift` - Driver start/end shift
- ✅ `maintenance_alert` - Vehicle maintenance
- ✅ `trip_completed` - Trip finished

### Ready to Add

- 🔄 `ticket_created` - New CRM ticket
- 🔄 `customer_feedback` - Customer feedback received
- 🔄 `inventory_change` - Inventory adjustment
- 🔄 `driver_performance` - Driver metrics update
- 🔄 `vehicle_tracking` - GPS location update

---

## How to Integrate Other Modules

### Step 1: Add logging to module

In your module's action handler (e.g., when saving data):

```javascript
// After saving data
if (window.logDashboardActivity) {
  window.logDashboardActivity("action_type", "module_name", "description");
}
```

### Step 2: Define activity types

Common patterns:

- `module_action` format (e.g., `fuel_purchase`, `crm_ticket`)
- Clear, user-friendly descriptions
- Include specific details (vehicle ID, customer name, etc.)

### Step 3: Test on dashboard

After action in module, check Recent Activity on dashboard
Should appear within 10 seconds

---

## Example Implementation

### Adding to CRM Module

In `modules/crm/crm.js`:

```javascript
function saveTicket(ticketData) {
  const tickets = getTickets();
  tickets.push(ticketData);
  saveTickets(tickets);

  // Log to dashboard
  if (window.logDashboardActivity) {
    window.logDashboardActivity(
      "ticket_created",
      "crm",
      `Ticket #${ticketData.id} from ${ticketData.customerName}`,
    );
  }
}
```

---

## Storage Structure

### Activity Log Storage

```javascript
localStorage.getItem('tnvs_activity_log')
// Returns: Array of activity objects
[
    {
        id: 1704067200000,
        action: 'fuel_purchase',
        module: 'fuel',
        details: 'TNVS-001 refueled with 50 liters at ₱60/L',
        timestamp: '2024-01-01T10:00:00.000Z'
    },
    ...
]
```

### Data Sources

- `tnvs_purchases` → Fuel module
- `tnvs_drivers` → Driver module
- `tnvs_customers` → CRM module
- `tnvs_inventory` → Storeroom module
- `tnvs_activity_log` → Activity tracking

---

## Performance Notes

- Dashboard updates every 10 seconds
- Activities are stored in localStorage (max ~5-10MB per browser)
- Old activities are kept but can be archived manually
- No real-time websocket needed (polling at 10s intervals)

---

## Next Steps

1. **Test Fuel Module** - Record a fuel purchase, watch dashboard update
2. **Extract Driver Module** - Add activity logging for driver activities
3. **Integrate CRM** - Add ticket creation logging
4. **Connect Storeroom** - Add inventory transaction logging
5. **Performance Dashboard** - Add weekly/monthly charts pulling from activity log

---

## Troubleshooting

### Dashboard not updating?

1. Check if `logDashboardActivity` is defined
2. Verify data is saved to localStorage
3. Check browser console for errors
4. Refresh dashboard after action

### Activities not showing?

1. Make sure module calls `logDashboardActivity()`
2. Check localStorage for `tnvs_activity_log` key
3. Verify timestamp format is ISO string

### Stats showing wrong numbers?

1. Check localStorage data format
2. Ensure vehicle IDs are numeric
3. Verify purchase dates are valid

---

## Success Indicators

✅ When you record a fuel purchase:

- "Fuel Cost" stat card increases
- New activity appears in Recent Activity
- Vehicle appears in Fleet Status (if not already there)

✅ Real-time updating:

- Dashboard refreshes every 10 seconds
- New activities appear within seconds of action
- Stats reflect latest data

✅ Data persistence:

- Refresh page → data still there
- Activities survive browser restart
- Full activity history maintained
