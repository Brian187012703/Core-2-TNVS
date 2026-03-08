<?php
// PHP generated page
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, viewport-fit=cover"
    />
    <script>
      (function () {
        var t = localStorage.getItem("tnvs_theme") || "dark";
        if (t === "system") t = "dark";
        document.documentElement.setAttribute("data-theme", t);
      })();
    </script>
    <title>Core Services 2</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght=100..900&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
    <link rel="stylesheet" href="design.php" />
  </head>

  <body>
    <button class="hamburger" id="hamburger">
      <i class="fas fa-bars"></i>
    </button>

    <nav class="sidebar collapsed" id="sidebar">
      <div class="sidebar-header">
        <img src="logo.png" alt="" width="100px" />
        <h2>Bya<span style="color: #00e676">HERO</span></h2>
      </div>

      <ul class="nav-list">
        <li class="nav-item">
          <a
            class="nav-link active"
            href="#"
            data-section="dashboard"
            data-tooltip="Dashboard"
            ><i class="fas fa-chart-line"></i>
            <span>Dashboard Overview</span></a
          >
        </li>

        <li class="nav-item">
          <a
            class="nav-link"
            href="#"
            data-section="fuel"
            data-tooltip="Fuel Management"
            ><i class="fas fa-gas-pump"></i> <span>Fuel Management</span></a
          >
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#" data-section="crm" data-tooltip="CRM"
            ><i class="fas fa-address-book"></i> <span>CRM</span></a
          >
        </li>

        <li class="nav-item">
          <a
            class="nav-link"
            href="#"
            data-section="storeroom"
            data-tooltip="Storeroom"
            ><i class="fas fa-boxes"></i> <span>Storeroom</span></a
          >
        </li>

        <li class="nav-item">
          <a
            class="nav-link"
            href="#"
            data-section="driver"
            data-tooltip="Driver Info"
            ><i class="fas fa-id-card"></i> <span>Driver Info</span></a
          >
        </li>

        <li class="nav-item">
          <a
            class="nav-link"
            href="#"
            data-section="analytics"
            data-tooltip="Analytics"
            ><i class="fas fa-chart-bar"></i> <span>Analytics</span></a
          >
        </li>
      </ul>
    </nav>

    <header class="topbar">
      <div class="search-container">
        <i class="fas fa-search"></i>
        <input
          type="text"
          placeholder="Search for drivers, reports, or settings…"
          class="search-input"
        />
      </div>

      <div class="topbar-actions">
        <div class="settings-menu" id="settingsMenu">
          <button
            type="button"
            class="top-icon-btn"
            id="settingsIcon"
            title="Settings"
            aria-label="Settings"
          >
            <i class="fas fa-cog"></i>
          </button>
          <div class="settings-dropdown" id="settingsDropdown">
            <a
              href="#"
              class="settings-dropdown-item"
              data-section="settings-company"
              ><i class="fas fa-building"></i> Company</a
            >
            <a
              href="#"
              class="settings-dropdown-item"
              data-section="settings-appearance"
              ><i class="fas fa-palette"></i> Appearance</a
            >
            <a
              href="#"
              class="settings-dropdown-item"
              data-section="settings-system"
              ><i class="fas fa-info-circle"></i> System Information</a
            >
          </div>
        </div>
        <div class="profile-menu" id="profileMenu">
          <img src="mukhako.jpg" class="profile-img" />

          <div class="profile-dropdown">
            <h3>Brian Joshua Tanael</h3>
            <p>bj.tanael@tnvscorp.com</p>
            <button class="profile-btn">Profile</button>
            <button class="logout-btn">Sign Out</button>
          </div>
        </div>
      </div>
    </header>
    <main class="main-content" id="mainContent">
      <div id="default-view">
        <h1>Dashboard Overview</h1>

        <div class="dashboard-grid">
          <div class="stat-card">
            <div class="card-header">
              <i class="fas fa-taxi card-icon"></i>
              <span class="card-title">Total Vehicles</span>
            </div>
            <div class="card-value">
              0
              <span class="card-delta up"
                ><i class="fas fa-arrow-up"></i> 0</span
              >
            </div>
            <div class="card-detail">Vehicles on board</div>
          </div>
          <div class="stat-card">
            <div class="card-header">
              <i class="fas fa-id-card card-icon"></i>
              <span class="card-title">Active Drivers</span>
            </div>
            <div class="card-value">
              0
              <span class="card-delta up"
                ><i class="fas fa-arrow-up"></i> 0%</span
              >
            </div>
            <div class="card-detail">Currently on duty</div>
          </div>
          <div class="stat-card">
            <div class="card-header">
              <i class="fas fa-wallet card-icon"></i>
              <span class="card-title">Today's Revenue</span>
            </div>
            <div class="card-value">
              ₱0
              <span class="card-delta up"
                ><i class="fas fa-arrow-up"></i> 0%</span
              >
            </div>
            <div class="card-detail">Gross earnings (24h)</div>
          </div>
          <div class="stat-card">
            <div class="card-header">
              <i class="fas fa-gas-pump card-icon"></i>
              <span class="card-title">Fuel Cost</span>
            </div>
            <div class="card-value">
              ₱0
              <span class="card-delta down"
                ><i class="fas fa-arrow-down"></i> 0%</span
              >
            </div>
            <div class="card-detail">Daily consumption avg</div>
          </div>
        </div>

        <div class="dashboard-two-col">
          <div class="panel-card revenue-overview">
            <div class="chart-header">
              <h3 class="panel-title">Weekly Performance</h3>
              <div class="chart-legend">
                <span class="legend-item"
                  ><i
                    class="legend-dot"
                    style="background: var(--color-neon-accent)"
                  ></i
                  >Performance</span
                >
              </div>
            </div>
            <div class="chart-placeholder">
              <div class="chart-value-labels" id="chartValueLabels">
                <!-- Dynamic value labels will be added here -->
              </div>
              <div class="chart-bars" id="performanceChartBars">
                <div class="chart-bar-wrapper" data-day="Mon" data-value="45">
                  <div class="chart-bar" style="height: 45%"></div>
                </div>
                <div class="chart-bar-wrapper" data-day="Tue" data-value="62">
                  <div class="chart-bar" style="height: 62%"></div>
                </div>
                <div class="chart-bar-wrapper" data-day="Wed" data-value="55">
                  <div class="chart-bar" style="height: 55%"></div>
                </div>
                <div class="chart-bar-wrapper" data-day="Thu" data-value="78">
                  <div class="chart-bar" style="height: 78%"></div>
                </div>
                <div class="chart-bar-wrapper" data-day="Fri" data-value="85">
                  <div class="chart-bar" style="height: 85%"></div>
                </div>
                <div class="chart-bar-wrapper" data-day="Sat" data-value="70">
                  <div class="chart-bar" style="height: 70%"></div>
                </div>
                <div class="chart-bar-wrapper" data-day="Sun" data-value="92">
                  <div class="chart-bar" style="height: 92%"></div>
                </div>
              </div>
              <div class="chart-labels">
                <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span
                ><span>Fri</span><span>Sat</span><span>Sun</span>
              </div>
              <div
                class="chart-tooltip"
                id="chartTooltip"
                style="display: none"
              ></div>
            </div>
          </div>
          <div class="panel-card quick-actions">
            <h3 class="panel-title">Quick Actions</h3>
            <div class="quick-actions-grid">
              <button class="quick-action-btn" data-action="driver">
                <i class="fas fa-user-plus"></i> Add Driver
              </button>
              <button class="quick-action-btn" data-action="fuel">
                <i class="fas fa-gas-pump"></i> Record Fuel
              </button>
              <button class="quick-action-btn" data-action="storeroom">
                <i class="fas fa-shopping-cart"></i> Procurement
              </button>
              <button class="quick-action-btn" data-action="crm">
                <i class="fas fa-address-book"></i> Add Contact
              </button>
            </div>
          </div>
        </div>

        <div class="dashboard-two-col">
          <div class="panel-card fleet-status">
            <h3 class="panel-title">Fleet Status</h3>
            <ul class="fleet-status-list">
              <!-- Fleet status populated by dashboard analytics -->
            </ul>
          </div>
          <div class="panel-card recent-activity">
            <h3 class="panel-title">Recent Activity</h3>
            <ul class="activity-list">
              <!-- Recent activities populated by dashboard analytics -->
            </ul>
          </div>
        </div>
      </div>

      <!-- DRIVER INFO SECTION -->
      <div id="driver-section" style="display: none;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
          <h1>👤 Driver Information</h1>
          <div style="display: flex; gap: 10px;">
            <button id="refreshDrivers" class="quick-action-btn" style="background: #1976d2; color: white; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer;">
              <i class="fas fa-sync"></i> Refresh
            </button>
            <button id="sendToLaptop2" class="quick-action-btn" style="background: #00e676; color: #000; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold;">
              <i class="fas fa-send"></i> Send to Laptop 2
            </button>
          </div>
        </div>

        <div style="background: #1e1e1e; border-radius: 12px; padding: 20px; color: #fff;">
          <div id="driverStatus" style="margin-bottom: 20px; display: flex; gap: 20px;">
            <div style="flex: 1; background: #2a2a2a; padding: 15px; border-radius: 8px; border-left: 4px solid #00e676;">
              <div style="font-size: 12px; color: #999; text-transform: uppercase;">Total Drivers</div>
              <div style="font-size: 28px; font-weight: bold; color: #00e676;" id="totalDriversCount">0</div>
            </div>
            <div style="flex: 1; background: #2a2a2a; padding: 15px; border-radius: 8px; border-left: 4px solid #1976d2;">
              <div style="font-size: 12px; color: #999; text-transform: uppercase;">Active Drivers</div>
              <div style="font-size: 28px; font-weight: bold; color: #1976d2;" id="activeDriversCount">0</div>
            </div>
            <div style="flex: 1; background: #2a2a2a; padding: 15px; border-radius: 8px; border-left: 4px solid #ff9800;">
              <div style="font-size: 12px; color: #999; text-transform: uppercase;">On Trip</div>
              <div style="font-size: 28px; font-weight: bold; color: #ff9800;" id="onTripDriversCount">0</div>
            </div>
            <div style="flex: 1; background: #2a2a2a; padding: 15px; border-radius: 8px; border-left: 4px solid #f44336;">
              <div style="font-size: 12px; color: #999; text-transform: uppercase;">Suspended</div>
              <div style="font-size: 28px; font-weight: bold; color: #f44336;" id="suspendedDriversCount">0</div>
            </div>
          </div>

          <div style="margin-bottom: 20px;">
            <div style="display: flex; gap: 15px; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #3a3a3a; font-weight: bold; color: #00e676; font-size: 12px; text-transform: uppercase;">
              <span style="flex: 0.3;">ID</span>
              <span style="flex: 1.2;">NAME</span>
              <span style="flex: 1;">LICENSE</span>
              <span style="flex: 1;">CONTACT</span>
              <span style="flex: 0.8;">STATUS</span>
              <span style="flex: 0.8;">ACTION</span>
            </div>
            <div id="driversListContainer" style="max-height: 500px; overflow-y: auto;">
              <div style="text-align: center; color: #999; padding: 30px;">Loading drivers...</div>
            </div>
          </div>

          <div id="sendStatus" style="display: none; padding: 15px; border-radius: 8px; margin-top: 15px; font-weight: bold;">
          </div>
        </div>
      </div>
    </main>

    <script src="js/settings.php"></script>
    <script src="js/profile.php"></script>
    <script src="js/fuel.php"></script>
    <script src="modules/module-loader.php"></script>
    <script src="script.php"></script>
    <script src="js/dashboard-analytics.php"></script>

    <!-- DRIVER SYSTEM INTEGRATION SCRIPT -->
    <script>
      // Configuration
      const LAPTOP2_IP = '192.168.1.5'; // Change to your Laptop 2 IP
      const LAPTOP1_API = 'api_send_drivers.php';

      // Load drivers when Driver Info section is clicked
      document.addEventListener('DOMContentLoaded', function() {
        const driverLink = document.querySelector('[data-section="driver"]');
        if (driverLink) {
          driverLink.addEventListener('click', function(e) {
            e.preventDefault();
            loadDriversList();
          });
        }

        // Refresh button
        const refreshBtn = document.getElementById('refreshDrivers');
        if (refreshBtn) {
          refreshBtn.addEventListener('click', loadDriversList);
        }

        // Send to Laptop 2 button
        const sendBtn = document.getElementById('sendToLaptop2');
        if (sendBtn) {
          sendBtn.addEventListener('click', sendDriversToLaptop2);
        }
      });

      // Load drivers from local database
      async function loadDriversList() {
        try {
          // Hide other sections
          const defaultView = document.getElementById('default-view');
          const driverSection = document.getElementById('driver-section');
          if (defaultView) defaultView.style.display = 'none';
          if (driverSection) driverSection.style.display = 'block';

          // Fetch drivers from API
          const response = await fetch(LAPTOP1_API + '?action=get_drivers');
          const data = await response.json();

          if (!data.success) {
            document.getElementById('driversListContainer').innerHTML = 
              '<div style="text-align: center; color: #f44336; padding: 20px;">Error: ' + data.message + '</div>';
            return;
          }

          const drivers = data.drivers || [];

          // Update stats
          document.getElementById('totalDriversCount').textContent = drivers.length;
          document.getElementById('activeDriversCount').textContent = drivers.filter(d => d.status === 'active').length;
          document.getElementById('onTripDriversCount').textContent = drivers.filter(d => d.status === 'on_trip').length;
          document.getElementById('suspendedDriversCount').textContent = drivers.filter(d => d.status === 'suspended').length;

          // Build drivers list
          if (drivers.length === 0) {
            document.getElementById('driversListContainer').innerHTML = 
              '<div style="text-align: center; color: #999; padding: 30px;">No drivers available</div>';
            return;
          }

          let html = '';
          drivers.forEach(driver => {
            const statusColor = driver.status === 'active' ? '#00e676' : 
                               driver.status === 'on_trip' ? '#1976d2' : '#f44336';
            const statusText = driver.status === 'active' ? '✓ Active' :
                              driver.status === 'on_trip' ? '🚗 On Trip' : '⛔ Suspended';

            html += `
              <div style="display: flex; gap: 15px; padding: 12px; border-bottom: 1px solid #2a2a2a; align-items: center; font-size: 13px;">
                <span style="flex: 0.3; color: #909090;">${driver.id}</span>
                <span style="flex: 1.2; color: #fff; font-weight: 500;">${driver.name}</span>
                <span style="flex: 1; color: #909090;">${driver.license_number}</span>
                <span style="flex: 1; color: #909090;">📞 ${driver.contact_number}</span>
                <span style="flex: 0.8;">
                  <span style="background: ${statusColor}20; color: ${statusColor}; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold;">
                    ${statusText}
                  </span>
                </span>
                <span style="flex: 0.8;">
                  <button onclick="viewDriver(${driver.id})" style="background: #1976d2; color: white; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer; font-size: 11px;">View</button>
                </span>
              </div>
            `;
          });

          document.getElementById('driversListContainer').innerHTML = html;

        } catch (error) {
          console.error('Error loading drivers:', error);
          document.getElementById('driversListContainer').innerHTML = 
            '<div style="text-align: center; color: #f44336; padding: 20px;">Error: ' + error.message + '</div>';
        }
      }

      // Send drivers to Laptop 2
      async function sendDriversToLaptop2() {
        const statusDiv = document.getElementById('sendStatus');
        
        try {
          statusDiv.style.display = 'block';
          statusDiv.textContent = '📤 Fetching drivers...';
          statusDiv.style.background = '#1976d2';
          statusDiv.style.color = '#fff';

          // Get drivers
          const response = await fetch(LAPTOP1_API + '?action=get_drivers');
          const data = await response.json();

          if (!data.success) {
            throw new Error(data.message);
          }

          const drivers = data.drivers;

          // Send to Laptop 2
          statusDiv.textContent = '📡 Sending to Laptop 2...';

          const sendResponse = await fetch(
            'http://' + LAPTOP2_IP + '/driver_profile.php?action=receive_drivers',
            {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify(drivers)
            }
          );

          const sendResult = await sendResponse.json();

          if (sendResult.success) {
            statusDiv.textContent = '✅ Success! ' + sendResult.message;
            statusDiv.style.background = '#00e67620';
            statusDiv.style.color = '#00e676';
            console.log('Drivers sent successfully:', sendResult);
          } else {
            throw new Error(sendResult.message);
          }

        } catch (error) {
          console.error('Send error:', error);
          statusDiv.textContent = '❌ Error: ' + error.message;
          statusDiv.style.background = '#f4433620';
          statusDiv.style.color = '#f44336';
        }
      }

      // View driver details
      function viewDriver(driverId) {
        alert('View details for driver ID: ' + driverId);
        // Can be extended to show a modal with full details
      }
    </script>
  </body>
</html>
