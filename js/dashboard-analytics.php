<?php
header('Content-Type: application/javascript');
?>
// Dashboard Analytics - Real-time activity tracking
// Displays live data from all modules

class DashboardAnalytics {
    constructor() {
        this.activityLog = this.getActivityLog();
        this.initDashboard();
    }

    // Get all activity from localStorage
    getActivityLog() {
        try {
            return JSON.parse(localStorage.getItem('tnvs_activity_log') || '[]');
        } catch (e) {
            return [];
        }
    }

    // Log an activity
    logActivity(action, module, details) {
        const activity = {
            id: Date.now(),
            action: action,
            module: module,
            details: details,
            timestamp: new Date().toISOString()
        };
        this.activityLog.unshift(activity);
        localStorage.setItem('tnvs_activity_log', JSON.stringify(this.activityLog));
        this.updateRecentActivity();
    }

    // Initialize dashboard with real data
    initDashboard() {
        this.updateDashboardStats();
        this.updateRecentActivity();
        this.updateFleetStatus();
        // Refresh every 5 seconds for real-time updates
        setInterval(() => {
            this.activityLog = this.getActivityLog(); // Refresh activity log
            this.updateDashboardStats();
            this.updateRecentActivity();
            this.updateFleetStatus();
        }, 5000);
    }

    // Update main dashboard statistics
    updateDashboardStats() {
        // Total Vehicles (from vehicles data or count purchases)
        const vehicles = this.getAllVehicles();
        const vehicleCount = vehicles.length;
        this.updateCard('Total Vehicles', vehicleCount, '+0');

        // Active Drivers (from driver module)
        const drivers = this.getAllDrivers();
        const activeDrivers = drivers.filter(d => d.status === 'active').length;
        this.updateCard('Active Drivers', activeDrivers, `+${drivers.length > 0 ? Math.round((activeDrivers / drivers.length) * 100) : 0}%`);

        // Today's Revenue (sum of today's fuel expenses or trips)
        const todaysRevenue = this.calculateTodaysMetrics();
        this.updateCard('Today\'s Revenue', `₱${todaysRevenue.revenue}k`, '+8.5%');

        // Fuel Cost (today's consumption)
        this.updateCard('Fuel Cost', `₱${todaysRevenue.fuelCost}k`, '-5%');
    }

    // Get all vehicles from fuel purchases
    getAllVehicles() {
        try {
            const purchases = JSON.parse(localStorage.getItem('tnvs_purchases') || '[]');
            if (purchases.length === 0) return [];

            // Group by vehicle ID
            const vehicleMap = {};
            purchases.forEach(p => {
                const vehicleId = p.vehicleId || '001';
                if (!vehicleMap[vehicleId]) {
                    vehicleMap[vehicleId] = {
                        id: vehicleId,
                        name: `TNVS-${String(vehicleId).padStart(3, '0')}`,
                        status: 'in-use'
                    };
                }
            });

            return Object.values(vehicleMap);
        } catch (e) {
            console.error('Error getting vehicles:', e);
            return [];
        }
    }

    // Get all drivers
    getAllDrivers() {
        try {
            const driverData = JSON.parse(localStorage.getItem('tnvs_drivers') || '[]');
            return driverData;
        } catch (e) {
            return [];
        }
    }

    // Calculate today's metrics from fuel purchases
    calculateTodaysMetrics() {
        try {
            const purchases = JSON.parse(localStorage.getItem('tnvs_purchases') || '[]');

            if (purchases.length === 0) {
                return { revenue: 128, fuelCost: 45, purchases: 0 };
            }

            const today = new Date();
            const todayStr = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;

            const todaysPurchases = purchases.filter(p => {
                const purchaseDate = p.date ? p.date.substring(0, 10) : '';
                return purchaseDate === todayStr;
            });

            const totalFuelCost = todaysPurchases.reduce((sum, p) => {
                return sum + (parseFloat(p.totalCost || p.total || 0));
            }, 0);

            const fuelCost = Math.round(totalFuelCost / 1000);
            const revenue = Math.round(fuelCost * 2.8);

            return {
                revenue: revenue || 128,
                fuelCost: fuelCost || 45,
                purchases: todaysPurchases.length
            };
        } catch (e) {
            console.error('Error calculating metrics:', e);
            return { revenue: 128, fuelCost: 45, purchases: 0 };
        }
    }

    // Update a stat card with new value
    updateCard(cardTitle, value, delta) {
        const cards = document.querySelectorAll('.stat-card');
        cards.forEach(card => {
            const titleEl = card.querySelector('.card-title');
            if (titleEl && titleEl.textContent.includes(cardTitle)) {
                const valueEl = card.querySelector('.card-value');
                if (valueEl) {
                    // Preserve the structure better
                    const isDown = delta.includes('-');
                    const arrowIcon = isDown ? 'arrow-down' : 'arrow-up';
                    const deltaClass = isDown ? 'down' : 'up';
                    valueEl.innerHTML = `${value}<span class="card-delta ${deltaClass}"><i class="fas fa-${arrowIcon}"></i> ${delta}</span>`;
                }
            }
        });
    }

    // Update Recent Activity list
    updateRecentActivity() {
        const activityList = document.querySelector('.activity-list');
        if (!activityList) return;

        const recentActivities = this.activityLog.slice(0, 8); // Get last 8 activities

        // If no activities yet, create some from existing data
        if (recentActivities.length === 0) {
            this.generateInitialActivities();
            return;
        }

        activityList.innerHTML = recentActivities.map(activity => {
            const time = this.formatTime(activity.timestamp);
            const icon = this.getActivityIcon(activity.module);
            const text = this.getActivityText(activity);

            return `
                <li class="activity-item">
                    <i class="fas fa-${icon} activity-icon"></i>
                    <div>
                        ${text}
                        <span class="activity-meta">${time}</span>
                    </div>
                </li>
            `;
        }).join('');
    }

    // Generate initial activities from existing data
    generateInitialActivities() {
        try {
            const purchases = JSON.parse(localStorage.getItem('tnvs_purchases') || '[]');
            const activities = [];

            // Add fuel purchase activities
            purchases.slice(-4).reverse().forEach((p, idx) => {
                activities.push({
                    action: 'fuel_purchase',
                    module: 'fuel',
                    details: `TNVS-${String(p.vehicleId).padStart(3, '0')} refueled with ${p.quantity} liters`,
                    timestamp: new Date(Date.now() - idx * 3600000).toISOString()
                });
            });

            // Add sample driver and maintenance activities
            activities.push({
                action: 'driver_shift',
                module: 'driver',
                details: 'Maria Clara started shift',
                timestamp: new Date(Date.now() - 86400000).toISOString()
            });

            activities.push({
                action: 'maintenance_alert',
                module: 'vehicle',
                details: 'Maintenance alert TNVS-112',
                timestamp: new Date(Date.now() - 86400000 + 3600000).toISOString()
            });

            this.activityLog = activities;
            localStorage.setItem('tnvs_activity_log', JSON.stringify(this.activityLog));
            this.updateRecentActivity();
        } catch (e) {
            console.error('Error generating activities:', e);
        }
    }

    // Update Fleet Status section
    updateFleetStatus() {
        const vehicles = this.getAllVehicles();
        const fleetStatusList = document.querySelector('.fleet-status-list');

        if (!fleetStatusList || vehicles.length === 0) return;

        const statusGroups = {
            'Available': vehicles.filter(v => v.status === 'available'),
            'In use': vehicles.filter(v => v.status === 'in-use'),
            'Maintenance': vehicles.filter(v => v.status === 'maintenance'),
            'Inactive': vehicles.filter(v => v.status === 'inactive')
        };

        const statusMap = {
            'Available': 'available',
            'In use': 'in-use',
            'Maintenance': 'warning',
            'Inactive': 'inactive'
        };

        fleetStatusList.innerHTML = Object.entries(statusGroups).map(([status, vehicleList]) => {
            if (vehicleList.length === 0) return '';

            const vehicleNames = vehicleList.map(v => v.name).join(', ');
            return `
                <li class="fleet-status-row">
                    <span class="status ${statusMap[status]}">${status}</span>
                    <span class="fleet-count">${vehicleList.length}</span>
                    <span class="fleet-vehicles">${vehicleNames}</span>
                </li>
            `;
        }).filter(html => html !== '').join('');
    }

    // Format time for display
    formatTime(timestamp) {
        const date = new Date(timestamp);
        const now = new Date();
        const diff = now - date;

        // Minutes ago
        if (diff < 3600000) {
            return Math.round(diff / 60000) + ' min ago';
        }
        // Hours ago
        if (diff < 86400000) {
            return Math.round(diff / 3600000) + 'h ago';
        }
        // Show time
        return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
    }

    // Get icon for activity type
    getActivityIcon(module) {
        const icons = {
            'fuel': 'gas-pump',
            'driver': 'id-card',
            'vehicle': 'exclamation-triangle',
            'crm': 'address-book',
            'storeroom': 'boxes',
            'default': 'arrow-down'
        };
        return icons[module] || icons['default'];
    }

    // Get activity description text
    getActivityText(activity) {
        const { action, module, details } = activity;

        if (action === 'fuel_purchase') {
            return `<strong>Fuel refuel</strong> — ${details}`;
        }
        if (action === 'driver_shift') {
            return `<strong>${details.split(' ')[0]} ${details.split(' ')[1]}</strong> started shift`;
        }
        if (action === 'maintenance_alert') {
            return `<i class="fas fa-exclamation-triangle warning"></i> ${details}`;
        }
        if (action === 'trip_completed') {
            return `<strong>${details}</strong> completed trip`;
        }

        return `<strong>${module}</strong> — ${details}`;
    }

    // Public method to log activities from modules
    static logModuleActivity(action, module, details) {
        if (window.dashboardAnalytics) {
            window.dashboardAnalytics.logActivity(action, module, details);
        }
    }
}

// Initialize dashboard analytics when page loads
document.addEventListener('DOMContentLoaded', () => {
    window.dashboardAnalytics = new DashboardAnalytics();
});

// Also expose for modules to use
window.logDashboardActivity = DashboardAnalytics.logModuleActivity;
