<?php
header('Content-Type: text/plain');
?>
<!-- Module Navigation Index -->
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BPM TNVS - Module Index</title>
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body {
        font-family: "Inter", sans-serif;
        background: #0a0a0a;
        color: #fff;
        padding: 40px 20px;
      }

      .container {
        max-width: 1200px;
        margin: 0 auto;
      }

      h1 {
        font-size: 2.5em;
        margin-bottom: 10px;
        color: #00e676;
      }

      .subtitle {
        color: #999;
        margin-bottom: 40px;
        font-size: 1.1em;
      }

      .modules-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
      }

      .module-card {
        background: rgba(0, 230, 118, 0.05);
        border: 1px solid rgba(0, 230, 118, 0.2);
        border-radius: 8px;
        padding: 24px;
        transition: all 0.3s;
      }

      .module-card:hover {
        background: rgba(0, 230, 118, 0.1);
        border-color: #00e676;
        transform: translateY(-2px);
      }

      .module-card h3 {
        color: #00e676;
        margin-bottom: 12px;
        font-size: 1.3em;
        display: flex;
        align-items: center;
        gap: 10px;
      }

      .module-card p {
        color: #aaa;
        margin-bottom: 16px;
        line-height: 1.5;
      }

      .file-list {
        background: rgba(0, 0, 0, 0.3);
        border-left: 3px solid #00e676;
        padding: 12px 16px;
        border-radius: 4px;
        font-size: 0.9em;
        color: #ccc;
      }

      .file-list div {
        margin: 6px 0;
      }

      .file-list \.php::before {
        content: "📄 ";
      }

      .file-list .js::before {
        content: "⚙️ ";
      }

      .file-list .css::before {
        content: "🎨 ";
      }

      .status {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 4px;
        font-size: 0.8em;
        font-weight: 600;
        margin-top: 12px;
      }

      .status.complete {
        background: rgba(0, 230, 118, 0.2);
        color: #00e676;
      }

      .status.pending {
        background: rgba(255, 193, 7, 0.2);
        color: #ffc107;
      }

      .docs-section {
        background: rgba(52, 152, 219, 0.05);
        border: 1px solid rgba(52, 152, 219, 0.2);
        border-radius: 8px;
        padding: 24px;
        margin-bottom: 20px;
      }

      .docs-section h2 {
        color: #3498db;
        margin-bottom: 16px;
      }

      .docs-section ul {
        list-style: none;
        margin-left: 0;
      }

      .docs-section li {
        padding: 8px 0;
        padding-left: 24px;
        position: relative;
        color: #aaa;
      }

      .docs-section li::before {
        content: "→";
        position: absolute;
        left: 0;
        color: #3498db;
      }

      a {
        color: #00e676;
        text-decoration: none;
      }

      a:hover {
        text-decoration: underline;
      }

      .progress-bar {
        background: #333;
        height: 8px;
        border-radius: 4px;
        overflow: hidden;
        margin: 20px 0;
      }

      .progress-fill {
        background: #00e676;
        height: 100%;
        width: 15%;
        transition: width 0.3s;
      }
    </style>
  </head>

  <body>
    <div class="container">
      <h1>🚀 BPM TNVS Modular System</h1>
      <p class="subtitle">Clean, organized, and scalable module structure</p>

      <h2 style="margin-top: 30px; margin-bottom: 15px">
        Modularization Progress
      </h2>
      <div class="progress-bar">
        <div class="progress-fill" style="width: 15%"></div>
      </div>
      <p style="color: #aaa; font-size: 0.9em">
        1 of 7 modules fully extracted • Infrastructure ready
      </p>

      <h2 style="margin-top: 40px; margin-bottom: 20px">📦 Modules</h2>
      <div class="modules-grid">
        <!-- Fuel Module -->
        <div class="module-card">
          <h3>⛽ Fuel Management</h3>
          <p>Track petrol/diesel stock, purchases and consumption.</p>
          <div class="file-list">
            <div class="html">fuel\.php</div>
            <div class="js">fuel.js</div>
            <div class="css">fuel.css</div>
          </div>
          <span class="status complete">✅ Complete</span>
        </div>

        <!-- CRM Module -->
        <div class="module-card">
          <h3>👥 CRM</h3>
          <p>Manage customers, support tickets, and feedback.</p>
          <div class="file-list">
            <div class="html">crm\.php</div>
            <div class="js">crm.js</div>
            <div class="css">crm.css</div>
          </div>
          <span class="status pending">📝 HTML Ready</span>
        </div>

        <!-- Storeroom Module -->
        <div class="module-card">
          <h3>📦 Storeroom</h3>
          <p>Manage inventory and procurement requests.</p>
          <div class="file-list">
            <div class="html">storeroom\.php</div>
            <div class="js">storeroom.js</div>
            <div class="css">storeroom.css</div>
          </div>
          <span class="status pending">📝 HTML Ready</span>
        </div>

        <!-- Driver Module -->
        <div class="module-card">
          <h3>🚗 Driver Info</h3>
          <p>Manage drivers and performance.</p>
          <div class="file-list">
            <div class="html">driver\.php</div>
            <div class="js">driver.js</div>
            <div class="css">driver.css</div>
          </div>
          <span class="status pending">📝 HTML Ready</span>
        </div>

        <!-- Analytics Module -->
        <div class="module-card">
          <h3>📊 Analytics</h3>
          <p>Financial, operational and safety metrics.</p>
          <div class="file-list">
            <div class="html">analytics\.php</div>
            <div class="js">analytics.js</div>
            <div class="css">analytics.css</div>
          </div>
          <span class="status pending">📝 HTML Ready</span>
        </div>

        <!-- Profile Module -->
        <div class="module-card">
          <h3>👤 Profile</h3>
          <p>User account details and preferences.</p>
          <div class="file-list">
            <div class="html">profile\.php</div>
            <div class="js">profile.js</div>
            <div class="css">profile.css</div>
          </div>
          <span class="status pending">📝 HTML Ready</span>
        </div>

        <!-- Settings Module -->
        <div class="module-card">
          <h3>⚙️ Settings</h3>
          <p>Application configuration and preferences.</p>
          <div class="file-list">
            <div class="html">settings\.php</div>
            <div class="js">settings.js</div>
            <div class="css">settings.css</div>
          </div>
          <span class="status pending">📝 HTML Ready</span>
        </div>
      </div>

      <!-- Documentation -->
      <div class="docs-section">
        <h2>📚 Documentation & Resources</h2>
        <ul>
          <li>
            <a href="MODULAR_ARCHITECTURE.md">Modular Architecture Guide</a> -
            Full technical documentation
          </li>
          <li>
            <a href="MODULARIZATION_SUMMARY.md">Modularization Summary</a> -
            Project overview & status
          </li>
          <li>
            <strong>Module Loader:</strong> Dynamic loading system in
            <code>modules/module-loader.js</code>
          </li>
          <li>
            <strong>Fuel Module:</strong> Complete reference implementation in
            <code>modules/fuel/</code>
          </li>
        </ul>
      </div>

      <!-- Next Steps -->
      <div
        class="docs-section"
        style="
          background: rgba(231, 76, 60, 0.05);
          border-color: rgba(231, 76, 60, 0.2);
        "
      >
        <h2 style="color: #e74c3c">🎯 Next Steps</h2>
        <ul>
          <li>Extract CRM logic from script.js → modules/crm/crm.js</li>
          <li>
            Extract Storeroom logic from script.js →
            modules/storeroom/storeroom.js
          </li>
          <li>
            Extract Driver logic from script.js → modules/driver/driver.js
          </li>
          <li>
            Extract Analytics logic from script.js →
            modules/analytics/analytics.js
          </li>
          <li>
            Extract Profile logic from script.js → modules/profile/profile.js
          </li>
          <li>
            Extract Settings logic from script.js → modules/settings/settings.js
          </li>
          <li>Update dashboard\.php to use module-loader.js</li>
          <li>Test all modules load correctly</li>
          <li>Remove inline templates from main script.js</li>
        </ul>
      </div>

      <!-- Key Benefits -->
      <div
        class="docs-section"
        style="
          background: rgba(0, 230, 118, 0.05);
          border-color: rgba(0, 230, 118, 0.2);
        "
      >
        <h2 style="color: #00e676">✨ Benefits of Modular Structure</h2>
        <ul>
          <li>
            <strong>Easier Maintenance</strong> - Find code faster, make changes
            with confidence
          </li>
          <li>
            <strong>Better Scalability</strong> - Add new modules without
            affecting existing code
          </li>
          <li>
            <strong>Faster Development</strong> - Multiple developers can work
            independently
          </li>
          <li>
            <strong>Improved Performance</strong> - Load modules on-demand,
            smaller bundle sizes
          </li>
          <li>
            <strong>Better Organization</strong> - Clear folder structure and
            file naming
          </li>
          <li>
            <strong>Easier Testing</strong> - Module-specific unit tests and
            isolated debugging
          </li>
        </ul>
      </div>

      <p
        style="
          margin-top: 40px;
          color: #666;
          text-align: center;
          font-size: 0.9em;
        "
      >
        BPM TNVS System v1.0 • Modularized Architecture • Last Updated:
        2026-01-25
      </p>
    </div>
  </body>
</html>
