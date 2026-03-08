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
    </main>

    <script src="js/settings.php"></script>
    <script src="js/profile.php"></script>
    <script src="js/fuel.php"></script>
    <script src="modules/module-loader.php"></script>
    <script src="script.php"></script>
    <script src="js/dashboard-analytics.php"></script>
  </body>
</html>
