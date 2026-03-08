<?php
header('Content-Type: text/css');
?>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:root {
    --color-bg: #121217;
    --color-surface: #1e1e24;
    --color-text-primary: #ffffff;
    --color-text-secondary: #a0a0a8;
    --color-neon-accent: #00e676;
    --color-border: #33333a;
}

[data-theme="light"] {
    --color-bg: #f0f2f5;
    --color-surface: #ffffff;
    --color-text-primary: #1a1a1d;
    --color-text-secondary: #5c5c68;
    --color-border: #e1e3e6;
}

body {
    font-family: "Inter", sans-serif;
    background: var(--color-bg);
    color: var(--color-text-primary);
    display: flex;
    height: 100vh;
    overflow-x: hidden;
    transition: background 0.3s, color 0.3s;
}


/* --- Sidebar Styles (Navigation) --- */

.sidebar {
    width: 280px;
    background: var(--color-surface);
    /* Lighter background for the panel */
    border-right: 1px solid var(--color-border);
    padding: 0;
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    overflow-y: auto;
    transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    /* Smoother transition */
    z-index: 1000;
    -ms-overflow-style: none;
    scrollbar-width: none;
    box-shadow: 5px 0 15px rgba(0, 0, 0, 0.5);
}

.sidebar.collapsed {
    width: 60px;
}

.sidebar-header {
    display: flex;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid var(--color-border);
    justify-content: flex-start;
    height: 70px;
    /* Match topbar height */
}

.sidebar.collapsed .sidebar-header {
    justify-content: center;
}

.logo-icon {
    font-size: 24px;
    color: #00e676;
    /* Neon accent */
    margin-right: 10px;
    transition: margin 0.3s;
}

.sidebar.collapsed .logo-icon {
    margin-right: 0;
}

.sidebar-header h2 {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--color-text-primary);
    /* Uses white */
    letter-spacing: 0.5px;
    white-space: nowrap;
    overflow: hidden;
    opacity: 1;
    transition: opacity 0.3s, width 0.3s;
}

.sidebar.collapsed .sidebar-header h2 {
    opacity: 0;
    width: 0;
    padding: 0;
    margin: 0;
}

.nav-list {
    list-style: none;
    padding: 10px 0;
}

.nav-item {
    position: relative;
}

.nav-link {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    padding: 12px 20px;
    text-decoration: none;
    color: var(--color-text-primary);
    /* Uses white */
    transition: background 0.2s, color 0.2s, transform 0.1s;
    cursor: pointer;
    border-radius: 8px;
    /* Slight rounding for a modern touch */
    margin: 0 10px;
}

.sidebar.collapsed .nav-link {
    justify-content: center;
    padding: 15px 0;
    margin: 0;
    /* Remove margin when collapsed */
}

.nav-link:hover {
    background: rgba(0, 230, 118, 0.1);
    /* Neon accent hover */
    color: var(--color-neon-accent);
    transform: translateY(-1px);
    /* Subtle lift */
}

.nav-link.active {
    background: rgba(0, 230, 118, 0.15);
    color: var(--color-neon-accent);
    border-left: 3px solid var(--color-neon-accent);
}

.sidebar.collapsed .nav-link.active {
    border-left: none;
    border-bottom: 2px solid var(--color-neon-accent);
}

.nav-link i {
    width: 20px;
    text-align: center;
    font-size: 18px;
}

.nav-link span {
    margin-left: 15px;
    font-weight: 500;
    white-space: nowrap;
    transition: opacity 0.3s, margin 0.3s;
}


/* Tooltip (Collapsed state) */

.nav-link::after {
    content: attr(data-tooltip);
    position: absolute;
    left: 100%;
    top: 50%;
    transform: translateY(-50%);
    background: #00e676;
    /* Neon background for impact */
    color: #121217;
    padding: 5px 12px;
    border-radius: 6px;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s, visibility 0.3s;
    font-size: 0.9rem;
    font-weight: 600;
    z-index: 1001;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.6);
    margin-left: 10px;
}

.sidebar.collapsed .nav-link:hover::after {
    opacity: 1;
    visibility: visible;
}

.sidebar.collapsed .nav-link span {
    opacity: 0;
    position: absolute;
    /* Keeps the layout clean */
    left: -9999px;
}

.sidebar::-webkit-scrollbar {
    display: none;
}


/* --- Topbar Styles --- */

.topbar {
    position: fixed;
    top: 0;
    left: 280px;
    right: 0;
    height: 70px;
    background: var(--color-surface);
    /* Match sidebar background */
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 30px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
    z-index: 900;
    transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border-bottom: 1px solid var(--color-border);
}

.sidebar.collapsed~.topbar {
    left: 60px;
}


/* Search Bar */

.search-container {
    background: var(--color-bg);
    padding: 8px 15px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    width: 380px;
    border: 1px solid transparent;
    transition: all 0.3s;
}

.search-container:focus-within {
    border-color: var(--color-neon-accent);
    box-shadow: 0 0 10px rgba(0, 230, 118, 0.4);
}

.search-container i {
    color: var(--color-text-secondary);
    margin-right: 10px;
}

.search-input {
    background: transparent;
    border: none;
    outline: none;
    color: var(--color-text-primary);
    /* Uses white */
    width: 100%;
    font-size: 1rem;
    padding: 2px 0;
}

.search-input::placeholder {
    color: var(--color-text-secondary);
}


/* Icons on the right */

.topbar-actions {
    display: flex;
    align-items: center;
    gap: 30px;
}

.top-icon,
.top-icon-btn {
    font-size: 20px;
    color: var(--color-text-primary);
    cursor: pointer;
    transition: color 0.3s, transform 0.2s;
    position: relative;
}

.top-icon-btn {
    background: none;
    border: none;
    padding: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
}

.top-icon:hover,
.top-icon-btn:hover {
    color: var(--color-neon-accent);
    transform: scale(1.1);
}

.settings-menu {
    position: relative;
}





.settings-menu {
    position: relative;
}

.settings-dropdown {
    position: absolute;
    right: 0;
    top: 100%;
    margin-top: 8px;
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: 12px;
    padding: 8px 0;
    min-width: 200px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.5);
    display: none;
    z-index: 950;
}

.settings-menu.open .settings-dropdown {
    display: block;
}

.settings-dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 16px;
    color: var(--color-text-primary);
    text-decoration: none;
    font-size: 0.95rem;
    transition: background 0.2s;
}

.settings-dropdown-item:hover {
    background: rgba(0, 230, 118, 0.1);
    color: var(--color-neon-accent);
}

.settings-dropdown-item i {
    width: 20px;
    color: var(--color-neon-accent);
}


/* Profile Menu */

.profile-menu {
    position: relative;
    cursor: pointer;
}

.profile-img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 3px solid var(--color-neon-accent);
    /* Neon ring */
    box-shadow: 0 0 5px rgba(0, 230, 118, 0.5);
    transition: all 0.3s;
}

.profile-menu:hover .profile-img {
    opacity: 0.8;
    transform: scale(1.05);
}

.profile-dropdown {
    position: absolute;
    right: 0;
    top: 55px;
    background: var(--color-surface);
    padding: 15px;
    width: 250px;
    border-radius: 12px;
    display: none;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.7);
    border: 1px solid var(--color-border);
    animation: fadeIn 0.3s ease-out forwards;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.profile-dropdown h3 {
    color: var(--color-text-primary);
    /* Uses white */
    margin-bottom: 2px;
    font-size: 1.1rem;
    font-weight: 600;
}

.profile-dropdown p {
    font-size: 0.85rem;
    color: var(--color-text-secondary);
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid var(--color-border);
}

.logout-btn {
    width: 100%;
    padding: 10px;
    background: var(--color-surface);
    border: none;
    color: var(--color-text-primary);
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: background 0.3s, transform 0.1s;
}

.profile-btn {
    width: 100%;
    padding: 10px;
    background: var(--color-surface);
    border: none;
    color: var(--color-text-primary);
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: background 0.3s, transform 0.1s;
}

.profile-btn:hover {
    background: #00b359;
    transform: translateY(-1px);
}

.logout-btn:hover {
    background: #00b359;
    transform: translateY(-1px);
}


/* Show dropdown on click/hover for better mobile compatibility */

.profile-menu.open .profile-dropdown {
    display: block;
}


/* --- Main Content Area --- */

.main-content {
    flex: 1;
    width: 100%;
    max-width: 100%;
    padding: 24px 32px;
    margin-top: 70px;
    margin-left: 280px;
    transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    min-height: calc(100vh - 70px);
}

.sidebar.collapsed~.main-content {
    margin-left: 60px;
}

.sidebar:not(.collapsed)~.main-content {
    margin-left: 280px;
}

.main-content h1 {
    color: var(--color-text-primary);
    /* Uses white */
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 10px;
    border-left: 4px solid var(--color-neon-accent);
    padding-left: 15px;
    letter-spacing: 1px;
}

.main-content p {
    color: var(--color-text-secondary);
    font-size: 1rem;
    margin-bottom: 30px;
}


/* --- Mobile / Responsiveness --- */

.hamburger {
    display: none;
    position: fixed;
    top: 15px;
    left: 15px;
    z-index: 1001;
    background: var(--color-neon-accent);
    color: #121217;
    border: none;
    padding: 10px 12px;
    border-radius: 8px;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
    transition: background 0.3s;
}

.hamburger:hover {
    background: #00b359;
}

@media (max-width: 1024px) {
    /* Collapse sidebar by default on smaller screens */
    .sidebar {
        width: 60px;
    }
    .topbar {
        left: 60px;
    }
    .main-content {
        margin-left: 60px;
    }
    /* Override collapsed behavior for mobile menu when open */
    .sidebar.open {
        width: 280px;
        transform: translateX(0);
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.8);
    }
    .sidebar.open~.topbar {
        left: 280px;
    }
    .search-container {
        width: 250px;
    }
}

@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
        width: 280px;
        /* Full width for sidebar on mobile when open */
    }
    .sidebar.open {
        transform: translateX(0);
    }
    .sidebar.collapsed {
        width: 280px;
        /* If collapsed class is still present, ensure it hides */
        transform: translateX(-100%);
    }
    .topbar {
        left: 0;
        padding: 0 15px;
        width: 100%;
        justify-content: flex-end;
        /* Move items to the right */
    }
    .sidebar.open~.topbar {
        left: 0;
        /* Topbar stays at 0 even when sidebar is open */
    }
    .search-container {
        display: none;
        /* Hide search bar on small mobile */
    }
    .topbar-actions {
        gap: 20px;
    }
    .main-content {
        margin-left: 0;
        padding: 20px;
    }
    .sidebar.collapsed+.main-content {
        margin-left: 0;
    }
    .hamburger {
        display: block;
    }
}

.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.stat-card {
    background: var(--color-surface);
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
    border: 1px solid var(--color-border);
    transition: transform 0.3s, box-shadow 0.3s;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 230, 118, 0.15);
}

.card-header {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.card-icon {
    font-size: 24px;
    color: var(--color-neon-accent);
    background: rgba(0, 230, 118, 0.1);
    padding: 10px;
    border-radius: 50%;
    margin-right: 15px;
}

.card-title {
    color: var(--color-text-secondary);
    font-size: 0.9rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.8px;
}

.card-value {
    font-size: 2.2rem;
    font-weight: 800;
    color: var(--color-text-primary);
    margin-bottom: 5px;
    display: flex;
    align-items: center;
}

.card-delta {
    font-size: 0.8rem;
    font-weight: 600;
    margin-left: 15px;
    padding: 4px 8px;
    border-radius: 6px;
}

.card-delta.up {
    background: rgba(0, 230, 118, 0.2);
    color: var(--color-neon-accent);
}

.card-delta.down {
    background: rgba(231, 76, 60, 0.2);
    color: #e74c3c;
}

.card-detail {
    color: var(--color-text-secondary);
    font-size: 0.85rem;
}




.main-content {
    max-width: 100%;
    box-sizing: border-box;
}


/* --- Additions for Main Content Styling --- */


/* Data Tables */

.table-container {
    background: var(--color-surface);
    border-radius: 12px;
    padding: 20px;
    border: 1px solid var(--color-border);
    overflow-x: auto;
    margin-top: 20px;
}

.content-table {
    width: 100%;
    border-collapse: collapse;
    color: var(--color-text-secondary);
}

.content-table thead tr {
    text-align: left;
    border-bottom: 2px solid var(--color-border);
}

.content-table th {
    padding: 15px;
    font-weight: 600;
    color: var(--color-neon-accent);
    text-transform: uppercase;
    font-size: 0.85rem;
}

.content-table td {
    padding: 15px;
    border-bottom: 1px solid var(--color-border);
}

.content-table tbody tr:hover {
    background: rgba(255, 255, 255, 0.02);
    color: var(--color-text-primary);
}


/* Status Badges */

.status {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status.active,
.status.completed {
    background: rgba(0, 230, 118, 0.15);
    color: #00e676;
}

.status.pending,
.status.warning {
    background: rgba(255, 193, 7, 0.15);
    color: #ffc107;
}

.status.inactive,
.status.error {
    background: rgba(231, 76, 60, 0.15);
    color: #e74c3c;
}

.status.available {
    background: rgba(0, 230, 118, 0.15);
    color: #00e676;
}

.status.in-use {
    background: rgba(52, 152, 219, 0.2);
    color: #3498db;
}


/* Action Buttons in Table */

.action-btn {
    background: transparent;
    border: 1px solid var(--color-border);
    color: var(--color-text-primary);
    padding: 5px 10px;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s;
    margin-right: 5px;
}

.action-btn:hover {
    border-color: var(--color-neon-accent);
    color: var(--color-neon-accent);
}


/* Forms (for Modules like Recruitment/Procurement) */

.module-form {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    background: var(--color-surface);
    padding: 30px;
    border-radius: 15px;
    border: 1px solid var(--color-border);
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    color: var(--color-text-secondary);
    font-size: 0.9rem;
}

.form-control {
    width: 100%;
    background: var(--color-bg);
    border: 1px solid var(--color-border);
    padding: 12px;
    border-radius: 8px;
    color: var(--color-text-primary);
    outline: none;
}

.form-control:focus {
    border-color: var(--color-neon-accent);
}

.full-width {
    grid-column: span 2;
}

.btn-primary {
    background: var(--color-neon-accent);
    color: #121217;
    border: none;
    padding: 12px 25px;
    border-radius: 8px;
    font-weight: 700;
    cursor: pointer;
    transition: transform 0.2s;
}

.btn-primary:hover {
    transform: translateY(-2px);
    background: #00b359;
}


/* Grid for Map/GPS placeholders */

.map-placeholder {
    width: 100%;
    height: 400px;
    background: var(--color-surface);
    border-radius: 15px;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 1px dashed var(--color-border);
    color: var(--color-text-secondary);
    flex-direction: column;
}

.map-placeholder i {
    font-size: 3rem;
    margin-bottom: 15px;
    color: var(--color-neon-accent);
}


/* Dashboard: two-column layout, panels */

.dashboard-two-col {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-top: 20px;
}

@media (max-width: 900px) {
    .dashboard-two-col {
        grid-template-columns: 1fr;
    }
}

.panel-card {
    background: var(--color-surface);
    border-radius: 12px;
    padding: 20px;
    border: 1px solid var(--color-border);
}

.panel-title {
    color: var(--color-text-primary);
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 16px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}


/* Revenue overview chart */

.revenue-overview {
    position: relative;
}

.chart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.chart-legend {
    display: flex;
    gap: 12px;
    font-size: 0.85rem;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 6px;
    color: var(--color-text-secondary);
}

.legend-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
}

.revenue-overview .chart-placeholder {
    height: 280px;
    display: flex;
    flex-direction: column;
    align-items: stretch;
    position: relative;
}

.chart-value-labels {
    position: absolute;
    top: 10px;
    left: 0;
    right: 0;
    height: 200px;
    display: flex;
    align-items: flex-end;
    justify-content: space-around;
    gap: 10px;
    padding: 0 10px;
    z-index: 1;
    font-size: 0.75rem;
    color: var(--color-neon-accent);
    font-weight: 600;
}

.chart-bars {
    flex: 1;
    display: flex;
    align-items: flex-end;
    justify-content: space-around;
    gap: 10px;
    padding: 20px 10px 10px 10px;
    position: relative;
    z-index: 2;
}

.chart-bar-wrapper {
    flex: 1;
    max-width: 48px;
    height: 100%;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    position: relative;
    cursor: pointer;
    transition: transform 0.2s ease;
}

.chart-bar-wrapper:hover {
    transform: translateY(-4px);
}

.chart-bar-wrapper:hover .chart-bar {
    box-shadow: 0 8px 20px rgba(0, 230, 118, 0.4);
}

.chart-bar {
    width: 100%;
    min-height: 20px;
    background: linear-gradient(180deg, var(--color-neon-accent) 0%, rgba(0, 230, 118, 0.6) 100%);
    border-radius: 6px 6px 0 0;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.chart-bar::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 6px 6px 0 0;
}

.chart-bar-wrapper:nth-child(7) .chart-bar {
    background: linear-gradient(180deg, var(--color-neon-accent) 0%, rgba(0, 230, 118, 0.5) 100%);
    box-shadow: 0 4px 12px rgba(0, 230, 118, 0.3);
}

.chart-labels {
    display: flex;
    justify-content: space-around;
    font-size: 0.8rem;
    color: var(--color-text-secondary);
    padding: 10px 10px 0 10px;
}

.chart-tooltip {
    position: absolute;
    background: var(--color-surface);
    border: 1px solid var(--color-neon-accent);
    color: var(--color-neon-accent);
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 600;
    z-index: 10;
    pointer-events: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    white-space: nowrap;
    animation: tooltipFadeIn 0.2s ease;
}

@keyframes tooltipFadeIn {
    from {
        opacity: 0;
        transform: translateY(-4px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}


/* Quick actions */

.quick-actions-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

.quick-action-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 14px;
    background: var(--color-bg);
    border: 1px solid var(--color-border);
    border-radius: 8px;
    color: var(--color-text-primary);
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s;
}

.quick-action-btn:hover {
    border-color: var(--color-neon-accent);
    color: var(--color-neon-accent);
}

.quick-action-btn i {
    color: var(--color-neon-accent);
}


/* Fleet status: Available, In use, Maintenance, Inactive */

.fleet-status-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.fleet-status-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid var(--color-border);
    font-size: 0.9rem;
    color: var(--color-text-secondary);
}

.fleet-status-row:last-child {
    border-bottom: none;
}

.fleet-status-row .status {
    min-width: 100px;
    text-align: center;
}

.fleet-count {
    font-weight: 700;
    color: var(--color-text-primary);
    min-width: 28px;
}

.fleet-vehicles {
    flex: 1;
    font-size: 0.85rem;
    opacity: 0.95;
}

.fleet-status .content-table.compact th,
.fleet-status .content-table.compact td {
    padding: 10px 12px;
    font-size: 0.9rem;
}


/* Recent activity */

.activity-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.activity-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid var(--color-border);
    font-size: 0.9rem;
    color: var(--color-text-secondary);
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(0, 230, 118, 0.15);
    color: var(--color-neon-accent);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.activity-icon.warning {
    background: rgba(255, 193, 7, 0.15);
    color: #ffc107;
}

.activity-meta {
    font-size: 0.8rem;
    opacity: 0.9;
}


/* Profile view */

.profile-view .profile-card {
    background: var(--color-surface);
    border-radius: 15px;
    border: 1px solid var(--color-border);
    overflow: hidden;
    max-width: 100%;
    width: 100%;
}

.profile-hero {
    display: flex;
    align-items: center;
    gap: 24px;
    padding: 30px;
    border-bottom: 1px solid var(--color-border);
}

.profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    border: 3px solid var(--color-neon-accent);
    object-fit: cover;
}

.profile-hero-text h2 {
    font-size: 1.5rem;
    color: var(--color-text-primary);
    margin-bottom: 4px;
}

.profile-email {
    color: var(--color-text-secondary);
    margin-bottom: 14px;
}

.profile-details {
    padding: 24px 30px;
}

.profile-details-title {
    font-size: 0.95rem;
    color: var(--color-neon-accent);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 16px;
}

.profile-detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid var(--color-border);
    font-size: 0.95rem;
}

.profile-detail-row:last-child {
    border-bottom: none;
}

.profile-label {
    color: var(--color-text-secondary);
    margin-right: 16px;
}


/* ========== Edit Profile modal (dashboard) ========== */

.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 2000;
    visibility: hidden;
    opacity: 0;
    transition: opacity 0.3s, visibility 0.3s;
}

.modal-backdrop.is-open {
    visibility: visible;
    opacity: 1;
}

.modal-content {
    background: var(--color-surface);
    padding: 30px;
    border-radius: 12px;
    width: 450px;
    max-width: 90%;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.8);
    position: relative;
    transform: scale(0.9);
    transition: transform 0.3s ease-out;
    border: 1px solid var(--color-border);
}

.modal-backdrop.is-open .modal-content {
    transform: scale(1);
}

.modal-content h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--color-text-primary);
    margin-bottom: 20px;
}

.modal-close {
    position: absolute;
    top: 15px;
    right: 15px;
    background: none;
    border: none;
    font-size: 24px;
    color: var(--color-text-secondary);
    cursor: pointer;
    line-height: 1;
    padding: 4px;
    transition: color 0.2s;
}

.modal-close:hover {
    color: var(--color-neon-accent);
}


/* ========== Settings panel ========== */

.settings-view {
    max-width: 100%;
    width: 100%;
}

.settings-block-full {
    max-width: 100%;
    width: 100%;
}

.settings-block {
    background: var(--color-surface);
    border-radius: 12px;
    border: 1px solid var(--color-border);
    padding: 24px;
    margin-bottom: 24px;
}

.settings-block h3 {
    font-size: 1.1rem;
    color: var(--color-neon-accent);
    margin-bottom: 18px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.settings-form .form-group {
    margin-bottom: 16px;
}

.settings-form .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.settings-form label {
    display: block;
    margin-bottom: 6px;
    color: var(--color-text-secondary);
    font-size: 0.9rem;
}

.settings-form .form-control {
    width: 100%;
    padding: 10px 14px;
}

.settings-form .btn-primary {
    margin-top: 8px;
}


/* Toggle switch */

.toggle-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid var(--color-border);
}

.toggle-row:last-child {
    border-bottom: none;
}

.toggle-label {
    font-size: 0.95rem;
    color: var(--color-text-primary);
}

.toggle-switch {
    position: relative;
    width: 48px;
    height: 26px;
    background: var(--color-border);
    border-radius: 13px;
    cursor: pointer;
    transition: background 0.3s;
}

.toggle-switch::after {
    content: "";
    position: absolute;
    top: 3px;
    left: 3px;
    width: 20px;
    height: 20px;
    background: var(--color-surface);
    border-radius: 50%;
    transition: transform 0.3s;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
}

.toggle-input {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
    pointer-events: none;
}

.toggle-input:checked+.toggle-switch {
    background: var(--color-neon-accent);
}

.toggle-input:checked+.toggle-switch::after {
    transform: translateX(22px);
}

.toggle-wrap {
    display: inline-flex;
    cursor: pointer;
}


/* Theme options */

.theme-options {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}

.theme-option {
    flex: 1;
    min-width: 100px;
    padding: 14px 18px;
    background: var(--color-bg);
    border: 2px solid var(--color-border);
    border-radius: 10px;
    color: var(--color-text-primary);
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.2s;
    text-align: center;
}

.theme-option:hover {
    border-color: var(--color-neon-accent);
}

.theme-option.active {
    border-color: var(--color-neon-accent);
    background: rgba(0, 230, 118, 0.1);
    color: var(--color-neon-accent);
}


/* System info */

.sysinfo-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sysinfo-list li {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid var(--color-border);
    font-size: 0.95rem;
}

.sysinfo-list li:last-child {
    border-bottom: none;
}

.sysinfo-list span:first-child {
    color: var(--color-text-secondary);
}

.sysinfo-list span:last-child {
    color: var(--color-text-primary);
    font-weight: 500;
}


/* ========== Responsive: all devices ========== */

@media (max-width: 1200px) {
    .dashboard-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .search-container {
        width: 280px;
    }
}

@media (max-width: 1024px) {
    .main-content h1 {
        font-size: 1.8rem;
    }
    .main-content {
        padding: 20px 16px;
    }
    .topbar {
        padding: 0 16px;
    }
    .topbar-actions {
        gap: 16px;
    }
}

@media (max-width: 900px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
        min-width: 0;
    }
    .stat-card {
        min-width: 0;
    }
    .quick-actions-grid {
        grid-template-columns: 1fr;
    }
    .profile-hero {
        flex-direction: column;
        text-align: center;
    }
    .theme-options {
        flex-direction: column;
    }
    .settings-form .form-row {
        display: grid;
        grid-template-columns: 1fr;
    }
    .settings-form .input-col {
        width: 100%;
    }
    /* Responsive chart adjustments */
    .revenue-overview .chart-placeholder {
        height: 240px;
    }
    .chart-bar {
        max-width: 40px;
    }
    .chart-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
}

@media (max-width: 768px) {
    .main-content {
        padding: 16px 12px;
        margin-top: 70px;
    }
    .main-content h1 {
        font-size: 1.5rem;
        padding-left: 10px;
    }
    .stat-card {
        padding: 18px;
    }
    .card-value {
        font-size: 1.75rem;
        flex-wrap: wrap;
    }
    .panel-card {
        padding: 16px;
    }
    .fleet-status-row {
        flex-wrap: wrap;
        gap: 8px;
    }
    .fleet-status-row .status {
        min-width: 80px;
    }
    .profile-avatar {
        width: 80px;
        height: 80px;
    }
    .profile-hero {
        padding: 20px;
    }
    .profile-details {
        padding: 18px 20px;
    }
    .profile-detail-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;
    }
    .settings-block {
        padding: 18px;
    }
    .sidebar-header img {
        max-width: 70px;
    }
    .hamburger {
        top: 12px;
        left: 12px;
        padding: 8px 10px;
    }
}

@media (max-width: 480px) {
    .main-content {
        padding: 12px 10px;
    }
    .main-content h1 {
        font-size: 1.3rem;
    }
    .main-content p {
        margin-bottom: 16px;
        font-size: 0.9rem;
    }
    .stat-card {
        padding: 14px;
    }
    .card-value {
        font-size: 1.5rem;
    }
    .chart-bars>div {
        max-width: 28px;
    }
    .chart-labels {
        font-size: 0.7rem;
    }
    .quick-action-btn {
        padding: 10px 12px;
        font-size: 0.85rem;
    }
    .activity-item {
        font-size: 0.85rem;
    }
    .activity-icon {
        width: 28px;
        height: 28px;
        font-size: 0.8rem;
    }
    .topbar-actions {
        gap: 10px;
    }
    .profile-img {
        width: 36px;
        height: 36px;
    }
    .profile-dropdown {
        width: 220px;
        right: -10px;
    }
    .toggle-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
}

@media (max-width: 360px) {
    .dashboard-two-col {
        gap: 12px;
    }
    .panel-title {
        font-size: 0.9rem;
    }
}


/* Toast notification slide animations */

@keyframes slideOutRight {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(400px);
        opacity: 0;
    }
}
