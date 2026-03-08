<?php
header('Content-Type: application/javascript');
?>
const checkAuthentication = () => {
    const isLoggedIn = localStorage.getItem("tnvs_logged_in");
    if (isLoggedIn !== "true") {
        window.location.replace("index\.php");
    }
};
checkAuthentication();

document.documentElement.style.setProperty("--color-neon-accent", "#00e676");

const sidebar = document.getElementById("sidebar");
const hamburger = document.getElementById("hamburger");
const navLinks = document.querySelectorAll(".nav-link");
const profileMenu = document.getElementById("profileMenu");
const mainContent = document.getElementById("mainContent");

// --- Store dashboard HTML on load (initial content) ---
let dashboardHTML = "";

function initDashboardTemplate() {
    const view = mainContent.querySelector("#default-view");
    if (view) {
        dashboardHTML = view.outerHTML;
    }
}

// --- Section content templates ---
function getSectionHTML(section) {
    const templates = {
        fuel: `
      <div class="content-view" data-section="fuel">
        <h1>Fuel Management</h1>
        <p>Track petrol/diesel stock, purchases and consumption.</p>

        <div class="dashboard-grid">
          <div class="stat-card">
            <div class="card-header">
              <i class="fas fa-oil-can card-icon"></i>
              <span class="card-title">Petrol Stock</span>
            </div>
            <div class="card-value" id="petrolStockValue">0 L</div>
            <div class="card-detail">Available in storage</div>
          </div>
          <div class="stat-card">
            <div class="card-header">
              <i class="fas fa-gas-pump card-icon"></i>
              <span class="card-title">Diesel Stock</span>
            </div>
            <div class="card-value" id="dieselStockValue">0 L</div>
            <div class="card-detail">Available in storage</div>
          </div>
          <div class="stat-card">
            <div class="card-header">
              <i class="fas fa-calendar-check card-icon"></i>
              <span class="card-title">This Month's Purchases</span>
            </div>
            <div class="card-value" id="monthPurchaseValue">0 L</div>
            <div class="card-detail">Total liters purchased this month</div>
          </div>
          <div class="stat-card">
            <div class="card-header">
              <i class="fas fa-chart-line card-icon"></i>
              <span class="card-title">Avg. Consumption Daily</span>
            </div>
            <div class="card-value" id="avgDailyValue">0 L/day</div>
            <div class="card-detail">Based on consumption records</div>
          </div>
        </div>

        <div style="margin-top:20px; display:flex; justify-content:space-between; align-items:center; gap:12px;">
          <div class="segmented-control" style="display:flex; gap:8px;">
            <button class="btn-primary" id="tabPurchases">Purchases</button>
            <button class="btn-primary" id="tabConsumption" style="background:transparent; color:var(--color-text-primary); border:1px solid var(--color-border);">Consumption</button>
          </div>
          <button class="btn-primary" id="btnAddPurchase">+ Record Purchase</button>
        </div>

        <div class="table-container" id="purchasesView" style="margin-top:14px;">
          <h3 style="margin-bottom: 12px; color: white">Purchases</h3>
          <table class="content-table" id="purchasesTable">
            <thead><tr><th>Date</th><th>Invoice #</th><th>Supplier</th><th>Fuel Type</th><th>Quantity (L)</th><th>Unit Price</th><th>Total</th></tr></thead>
            <tbody></tbody>
          </table>
        </div>

        <div class="table-container" id="consumptionView" style="display:none; margin-top:14px;">
          <h3 style="margin-bottom: 12px; color: white">Consumption Tracking</h3>
          <p style="color:var(--color-text-secondary); margin-bottom:10px;">Connected to vehicle trips and GPS distance tracking.</p>
          <table class="content-table" id="consumptionTable">
            <thead><tr><th>Date</th><th>Vehicle</th><th>Distance (km)</th><th>Fuel Consumed (L)</th><th>Fuel Type</th></tr></thead>
            <tbody></tbody>
          </table>
        </div>

        <div class="modal-backdrop" id="modalRecordPurchase">
          <div class="modal-content">
            <button type="button" class="modal-close" data-close="modalRecordPurchase">&times;</button>
            <h3>Recording Fuel Purchase</h3>
            <form id="formRecordPurchase">
              <div class="form-group">
                <label for="invoiceNumber">Invoice Number</label>
                <input id="invoiceNumber" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="purchaseDate">Purchase Date</label>
                <input id="purchaseDate" type="date" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="supplierName">Supplier Name</label>
                <input id="supplierName" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="fuelTypeSelect">Fuel Type</label>
                <select id="fuelTypeSelect" class="form-control">
                  <option value="petrol">Petrol</option>
                  <option value="diesel">Diesel</option>
                </select>
              </div>
              <div class="form-group">
                <label for="quantityLiters">Quantity (L)</label>
                <input id="quantityLiters" type="number" min="0" step="0.01" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="unitPrice">Unit Price</label>
                <input id="unitPrice" type="number" min="0" step="0.01" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="totalAmount">Total Amount</label>
                <input id="totalAmount" type="number" min="0" step="0.01" class="form-control" readonly />
              </div>
              <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:12px;">
                <button type="submit" class="btn-primary" id="recordPurchaseBtn">Record Purchase</button>
                <button type="button" class="action-btn" id="cancelPurchaseBtn">Cancel</button>
              </div>
            </form>
          </div>
        </div>

      </div>
    `,
        crm: `
      <div class="content-view" data-section="crm">
        <h1>CRM</h1>
        <p>Manage customers, support tickets, and feedback.</p>

        <div class="dashboard-grid">
          <div class="stat-card">
            <div class="card-header">
              <i class="fas fa-users card-icon"></i>
              <span class="card-title">Total Customers</span>
            </div>
            <div class="card-value" id="totalCustomersValue">0</div>
            <div class="card-detail">Active customers</div>
          </div>
          <div class="stat-card">
            <div class="card-header">
              <i class="fas fa-ticket-alt card-icon"></i>
              <span class="card-title">Open Tickets</span>
            </div>
            <div class="card-value" id="openTicketsValue">0</div>
            <div class="card-detail">Awaiting response</div>
          </div>
          <div class="stat-card">
            <div class="card-header">
              <i class="fas fa-star card-icon"></i>
              <span class="card-title">Avg. Rating</span>
            </div>
            <div class="card-value" id="avgRatingValue">0.0</div>
            <div class="card-detail">Out of 5.0</div>
          </div>
          <div class="stat-card">
            <div class="card-header">
              <i class="fas fa-check-circle card-icon"></i>
              <span class="card-title">Resolution Rate</span>
            </div>
            <div class="card-value" id="resolutionRateValue">0%</div>
            <div class="card-detail">Tickets resolved</div>
          </div>
        </div>

        <div style="margin-top:20px; display:flex; justify-content:space-between; align-items:center; gap:12px;">
          <div class="segmented-control" style="display:flex; gap:8px;">
            <button class="btn-primary" id="tabCustomers">Customers</button>
            <button class="btn-primary" id="tabTickets" style="background:transparent; color:var(--color-text-primary); border:1px solid var(--color-border);">Support Tickets</button>
            <button class="btn-primary" id="tabFeedback" style="background:transparent; color:var(--color-text-primary); border:1px solid var(--color-border);">Feedback</button>
          </div>
          <div style="display: flex; gap: 8px;">
            <button class="btn-primary" id="btnAddCustomer">+ Add Customer</button>
            <button class="btn-primary" id="btnNewTicket" style="display:none;">+ New Ticket</button>
          </div>
        </div>

        <!-- Customers Table -->
        <div class="table-container" id="customersView" style="margin-top:14px;">
          <h3 style="margin-bottom: 12px; color: white">Customers</h3>
          <table class="content-table" id="customersTable">
            <thead><tr><th>Customer</th><th>Code</th><th>Type</th><th>Total Trips</th><th>Total Spent</th><th>Rating</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody></tbody>
          </table>
        </div>

        <!-- Support Tickets Table -->
        <div class="table-container" id="ticketsView" style="display:none; margin-top:14px;">
          <h3 style="margin-bottom: 12px; color: white">Support Tickets</h3>
          <table class="content-table" id="ticketsTable">
            <thead><tr><th>Ticket #</th><th>Subject</th><th>Category</th><th>Priority</th><th>Status</th><th>Created</th><th>Actions</th></tr></thead>
            <tbody></tbody>
          </table>
        </div>

        <!-- Feedback View -->
        <div class="table-container" id="feedbackView" style="display:none; margin-top:14px;">
          <h3 style="margin-bottom: 12px; color: white">Feedback & Ratings</h3>
          <p style="color:var(--color-text-secondary); margin-bottom:10px;">Aggregated from completed trips.</p>
          <table class="content-table" id="feedbackTable">
            <thead><tr><th>Customer</th><th>Trip ID</th><th>Feedback</th><th>Rating</th><th>Date</th></tr></thead>
            <tbody></tbody>
          </table>
        </div>

        <!-- Add Customer Modal -->
        <div class="modal-backdrop" id="modalAddCustomer">
          <div class="modal-content">
            <button type="button" class="modal-close" data-close="modalAddCustomer">&times;</button>
            <h3>Add New Customer</h3>
            <form id="formAddCustomer">
              <div class="form-group">
                <label for="customerName">Name</label>
                <input id="customerName" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="customerEmail">Email</label>
                <input id="customerEmail" type="email" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="customerPhone">Phone</label>
                <input id="customerPhone" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="customerType">Customer Type</label>
                <select id="customerType" class="form-control" required>
                  <option value="">Select Type</option>
                  <option value="individual">Individual</option>
                  <option value="corporate">Corporate</option>
                </select>
              </div>
              <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:12px;">
                <button type="submit" class="btn-primary" id="addCustomerBtn">Add Customer</button>
                <button type="button" class="action-btn" id="cancelAddCustomerBtn">Cancel</button>
              </div>
            </form>
          </div>
        </div>

        <!-- New Ticket Modal -->
        <div class="modal-backdrop" id="modalNewTicket">
          <div class="modal-content">
            <button type="button" class="modal-close" data-close="modalNewTicket">&times;</button>
            <h3>Create New Support Ticket</h3>
            <form id="formNewTicket">
              <div class="form-group">
                <label for="ticketSubject">Subject</label>
                <input id="ticketSubject" class="form-control" placeholder="Brief description of the issue" required />
              </div>
              <div class="form-group">
                <label for="ticketDescription">Description</label>
                <textarea id="ticketDescription" class="form-control" placeholder="Detailed description" rows="4" required></textarea>
              </div>
              <div class="form-group">
                <label for="ticketPriority">Priority</label>
                <select id="ticketPriority" class="form-control" required>
                  <option value="">Select Priority</option>
                  <option value="low">Low</option>
                  <option value="medium">Medium</option>
                  <option value="high">High</option>
                  <option value="urgent">Urgent</option>
                </select>
              </div>
              <div class="form-group">
                <label for="ticketCategory">Category</label>
                <select id="ticketCategory" class="form-control" required>
                  <option value="">Select Category</option>
                  <option value="complaint">Complaint</option>
                  <option value="inquiry">Inquiry</option>
                  <option value="feedback">Feedback</option>
                  <option value="refund">Refund</option>
                  <option value="lost-item">Lost Item</option>
                  <option value="other">Other</option>
                </select>
              </div>
              <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:12px;">
                <button type="submit" class="btn-primary" id="createTicketBtn">Create Ticket</button>
                <button type="button" class="action-btn" id="cancelNewTicketBtn">Cancel</button>
              </div>
            </form>
          </div>
        </div>

        <!-- View Customer Detail Modal -->
        <div class="modal-backdrop" id="modalViewCustomer">
          <div class="modal-content">
            <button type="button" class="modal-close" data-close="modalViewCustomer">&times;</button>
            <h3>Customer Details</h3>
            <div id="customerDetailContent" style="padding:20px 0;">
              <!-- Content populated by JavaScript -->
            </div>
            <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:12px;">
              <button type="button" class="action-btn" id="closeCustomerDetailBtn">Close</button>
            </div>
          </div>
        </div>

        <!-- View Ticket Detail Modal -->
        <div class="modal-backdrop" id="modalViewTicket">
          <div class="modal-content">
            <button type="button" class="modal-close" data-close="modalViewTicket">&times;</button>
            <h3>Ticket Details</h3>
            <div id="ticketDetailContent" style="padding:20px 0;">
              <!-- Content populated by JavaScript -->
            </div>
            <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:12px; border-top:1px solid var(--color-border); padding-top:12px;">
              <select id="ticketStatusSelect" class="form-control" style="width:200px; margin-right:auto;">
                <option value="">Update Status</option>
                <option value="open">Open</option>
                <option value="in-progress">In Progress</option>
                <option value="resolved">Resolved</option>
              </select>
              <button type="button" class="btn-primary" id="updateTicketStatusBtn">Update</button>
              <button type="button" class="action-btn" id="closeTicketDetailBtn">Close</button>
            </div>
          </div>
        </div>

        <!-- View Feedback Detail Modal -->
        <div class="modal-backdrop" id="modalViewFeedback">
          <div class="modal-content">
            <button type="button" class="modal-close" data-close="modalViewFeedback">&times;</button>
            <h3>Feedback Details</h3>
            <div id="feedbackDetailContent" style="padding:20px 0;">
              <!-- Content populated by JavaScript -->
            </div>
            <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:12px;">
              <button type="button" class="action-btn" id="closeFeedbackDetailBtn">Close</button>
            </div>
          </div>
        </div>

      </div>
    `,
        storeroom: `
      <div class="content-view" data-section="storeroom">
        <h1>Storeroom Management</h1>
        <p>Manage inventory, track assets, and procurement requests.</p>
        <div class="dashboard-grid">
          <div class="stat-card">
            <div class="card-header"><i class="fas fa-boxes card-icon"></i><span class="card-title">Total Assets</span></div>
            <div class="card-value" id="totalAssetsValue">0</div>
            <div class="card-detail">Items in inventory</div>
          </div>
          <div class="stat-card">
            <div class="card-header"><i class="fas fa-exclamation-triangle card-icon"></i><span class="card-title">Low Stock Items</span></div>
            <div class="card-value" id="lowStockValue">0</div>
            <div class="card-detail">Below reorder level</div>
          </div>
          <div class="stat-card">
            <div class="card-header"><i class="fas fa-ban card-icon"></i><span class="card-title">Out of Stock</span></div>
            <div class="card-value" id="outOfStockValue">0</div>
            <div class="card-detail">Needs immediate restock</div>
          </div>
          <div class="stat-card">
            <div class="card-header"><i class="fas fa-clock card-icon"></i><span class="card-title">Pending Requests</span></div>
            <div class="card-value" id="pendingRequestsValue">0</div>
            <div class="card-detail">Awaiting fulfillment</div>
          </div>
        </div>

        <div style="margin-top:20px; display:flex; justify-content:space-between; align-items:center; gap:12px;">
          <div class="segmented-control" style="display:flex; gap:8px;">
            <button class="btn-primary" id="tabStoreroomInventory">Inventory</button>
            <button class="btn-primary" id="tabStoreroomProcurement" style="background:transparent; color:var(--color-text-primary); border:1px solid var(--color-border);">Procurement</button>
          </div>
          <div style="display: flex; gap: 8px;">
            <button class="btn-primary" id="btnAddAsset">+ Add Asset</button>
            <button class="btn-primary" id="btnNewRequest" style="display:none;">+ New Request</button>
          </div>
        </div>

        <!-- Inventory Table -->
        <div class="table-container" id="inventoryView" style="margin-top:14px;">
          <h3 style="margin-bottom: 12px; color: white">Inventory</h3>
          <table class="content-table" id="inventoryTable">
            <thead><tr><th>Asset</th><th>Code</th><th>Category</th><th>Quantity</th><th>Unit Cost</th><th>Location</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody></tbody>
          </table>
        </div>

        <!-- Procurement Table -->
        <div class="table-container" id="procurementView" style="display:none; margin-top:14px;">
          <h3 style="margin-bottom: 12px; color: white">Procurement Requests</h3>
          <table class="content-table" id="procurementTable">
            <thead><tr><th>Request #</th><th>Asset</th><th>Quantity</th><th>Requested By</th><th>Status</th><th>Created</th><th>Actions</th></tr></thead>
            <tbody></tbody>
          </table>
        </div>

        <!-- Add Asset Modal -->
        <div class="modal-backdrop" id="modalAddAsset">
          <div class="modal-content">
            <button type="button" class="modal-close" data-close="modalAddAsset">&times;</button>
            <h3>Add New Asset</h3>
            <form id="formAddAsset">
              <div class="form-group">
                <label for="assetName">Asset Name</label>
                <input id="assetName" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="assetCategory">Category</label>
                <select id="assetCategory" class="form-control" required>
                  <option value="">Select Category</option>
                  <option value="spare-parts">Spare Parts</option>
                  <option value="tires">Tires</option>
                  <option value="fluids">Fluids</option>
                  <option value="electronics">Electronics</option>
                  <option value="safety">Safety Equipments</option>
                  <option value="other">Other Supplies</option>
                </select>
              </div>
              <div class="form-group">
                <label for="assetLocation">Location</label>
                <input id="assetLocation" class="form-control" placeholder="e.g., Warehouse A, Rack 5" required />
              </div>
              <div class="form-group">
                <label for="assetQuantity">Quantity</label>
                <input id="assetQuantity" type="number" min="0" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="assetUnit">Unit</label>
                <select id="assetUnit" class="form-control" required>
                  <option value="">Select Unit</option>
                  <option value="pieces">Pieces</option>
                  <option value="liters">Liters</option>
                  <option value="kilograms">Kilograms</option>
                  <option value="sets">Sets</option>
                </select>
              </div>
              <div class="form-group">
                <label for="assetUnitCost">Unit Cost (₱)</label>
                <input id="assetUnitCost" type="number" min="0" step="0.01" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="assetReorderLevel">Reorder Level</label>
                <input id="assetReorderLevel" type="number" min="0" class="form-control" required />
              </div>
              <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:12px;">
                <button type="submit" class="btn-primary" id="addAssetBtn">Add Asset</button>
                <button type="button" class="action-btn" id="cancelAddAssetBtn">Cancel</button>
              </div>
            </form>
          </div>
        </div>

        <!-- New Request Modal -->
        <div class="modal-backdrop" id="modalNewRequest">
          <div class="modal-content">
            <button type="button" class="modal-close" data-close="modalNewRequest">&times;</button>
            <h3>Submit Procurement Request</h3>
            <form id="formNewRequest">
              <div class="form-group">
                <label for="requestAsset">Asset</label>
                <select id="requestAsset" class="form-control" required>
                  <option value="">Select Asset</option>
                </select>
              </div>
              <div class="form-group">
                <label for="requestQuantity">Quantity</label>
                <input id="requestQuantity" type="number" min="1" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="requestReason">Reason</label>
                <textarea id="requestReason" class="form-control" placeholder="Reason for request" rows="3" required></textarea>
              </div>
              <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:12px;">
                <button type="submit" class="btn-primary" id="submitRequestBtn">Submit Request</button>
                <button type="button" class="action-btn" id="cancelNewRequestBtn">Cancel</button>
              </div>
            </form>
          </div>
        </div>

        <!-- View Asset Detail Modal -->
        <div class="modal-backdrop" id="modalViewAsset">
          <div class="modal-content">
            <button type="button" class="modal-close" data-close="modalViewAsset">&times;</button>
            <h3>Asset Details</h3>
            <div id="assetDetailContent" style="padding:20px 0;"></div>
            <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:12px;">
              <button type="button" class="action-btn" id="closeAssetDetailBtn">Close</button>
            </div>
          </div>
        </div>

        <!-- View Request Detail Modal -->
        <div class="modal-backdrop" id="modalViewRequest">
          <div class="modal-content">
            <button type="button" class="modal-close" data-close="modalViewRequest">&times;</button>
            <h3>Request Details</h3>
            <div id="requestDetailContent" style="padding:20px 0;"></div>
            <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:12px; border-top:1px solid var(--color-border); padding-top:12px;">
              <select id="requestStatusSelect" class="form-control" style="width:200px; margin-right:auto;">
                <option value="">Update Status</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="fulfilled">Fulfilled</option>
                <option value="rejected">Rejected</option>
              </select>
              <button type="button" class="btn-primary" id="updateRequestStatusBtn">Update</button>
              <button type="button" class="action-btn" id="closeRequestDetailBtn">Close</button>
            </div>
          </div>
        </div>

      </div>
    `,
        driver: `
      <div class="content-view" data-section="driver">
        <h1>Driver Information</h1>
        <p>Manage drivers and performance metrics.</p>
        <div class="dashboard-grid">
          <div class="stat-card">
            <div class="card-header"><i class="fas fa-users card-icon"></i><span class="card-title">Total Drivers</span></div>
            <div class="card-value" id="totalDriversValue">0</div>
            <div class="card-detail">Registered drivers</div>
          </div>
          <div class="stat-card">
            <div class="card-header"><i class="fas fa-star card-icon"></i><span class="card-title">Average Rating</span></div>
            <div class="card-value" id="avgDriverRatingValue">0.0</div>
            <div class="card-detail">Out of 5.0</div>
          </div>
          <div class="stat-card">
            <div class="card-header"><i class="fas fa-road card-icon"></i><span class="card-title">Avg Trips/Driver</span></div>
            <div class="card-value" id="avgTripsValue">0</div>
            <div class="card-detail">Per driver this month</div>
          </div>
        </div>

        <div style="margin-top:20px; display:flex; justify-content:space-between; align-items:center; gap:12px;">
          <div class="segmented-control" style="display:flex; gap:8px;">
            <button class="btn-primary" id="tabDrivers">Drivers</button>
            <button class="btn-primary" id="tabPerformance" style="background:transparent; color:var(--color-text-primary); border:1px solid var(--color-border);">Performance</button>
          </div>
          <button class="btn-primary" id="btnAddDriver">+ Add Driver</button>
        </div>

        <!-- Drivers Table -->
        <div class="table-container" id="driversView" style="margin-top:14px;">
          <h3 style="margin-bottom: 12px; color: white">Drivers</h3>
          <table class="content-table" id="driversTable">
            <thead><tr><th>Employee ID</th><th>License</th><th>Total Trips</th><th>Rating</th><th>Vehicle</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody></tbody>
          </table>
        </div>


        <!-- Performance Table -->
        <div class="table-container" id="performanceView" style="display:none; margin-top:14px;">
          <h3 style="margin-bottom: 12px; color: white">Performance Metrics</h3>
          <table class="content-table" id="performanceTable">
            <thead><tr><th>Driver</th><th>Trips (Month)</th><th>Avg Rating</th><th>Completion %</th><th>Earnings</th><th>Safety Score</th><th>Actions</th></tr></thead>
            <tbody></tbody>
          </table>
        </div>

        <!-- Add Driver Modal -->
        <div class="modal-backdrop" id="modalAddDriver">
          <div class="modal-content" style="max-height: 80vh; overflow-y: auto;">
            <button type="button" class="modal-close" data-close="modalAddDriver">&times;</button>
            <h3>Add New Driver</h3>
            <form id="formAddDriver">
              <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div class="form-group">
                  <label for="driverFirstName">First Name</label>
                  <input id="driverFirstName" class="form-control" required />
                </div>
                <div class="form-group">
                  <label for="driverLastName">Last Name</label>
                  <input id="driverLastName" class="form-control" required />
                </div>
              </div>
              <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div class="form-group">
                  <label for="driverEmail">Email</label>
                  <input id="driverEmail" type="email" class="form-control" required />
                </div>
                <div class="form-group">
                  <label for="driverPhone">Phone</label>
                  <input id="driverPhone" class="form-control" required />
                </div>
              </div>
              <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div class="form-group">
                  <label for="driverLicense">License Number</label>
                  <input id="driverLicense" class="form-control" required />
                </div>
                <div class="form-group">
                  <label for="driverLicenseExpiry">License Expiry</label>
                  <input id="driverLicenseExpiry" type="date" class="form-control" required />
                </div>
              </div>
              <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div class="form-group">
                  <label for="driverHireDate">Hire Date</label>
                  <input id="driverHireDate" type="date" class="form-control" required />
                </div>
                <div class="form-group">
                  <label for="driverAddress">Address</label>
                  <input id="driverAddress" class="form-control" required />
                </div>
              </div>
              <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div class="form-group">
                  <label for="driverEmergencyContact">Emergency Contact</label>
                  <input id="driverEmergencyContact" class="form-control" required />
                </div>
                <div class="form-group">
                  <label for="driverEmergencyPhone">Emergency Phone</label>
                  <input id="driverEmergencyPhone" class="form-control" required />
                </div>
              </div>
              <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:12px;">
                <button type="submit" class="btn-primary" id="addDriverBtn">Add Driver</button>
                <button type="button" class="action-btn" id="cancelAddDriverBtn">Cancel</button>
              </div>
            </form>
          </div>
        </div>

        <!-- View Driver Detail Modal -->
        <div class="modal-backdrop" id="modalViewDriver">
          <div class="modal-content">
            <button type="button" class="modal-close" data-close="modalViewDriver">&times;</button>
            <h3>Driver Details</h3>
            <div id="driverDetailContent" style="padding:20px 0;"></div>
            <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:12px;">
              <button type="button" class="action-btn" id="closeDriverDetailBtn">Close</button>
            </div>
          </div>
        </div>


      </div>
    `,
        analytics: `
      <div class="content-view" data-section="analytics">
        <h1>Analytics & Reports</h1>
        <p>Performance metrics, trends, and business intelligence.</p>
        <div class="dashboard-grid">
          <div class="stat-card">
            <div class="card-header"><i class="fas fa-money-bill card-icon"></i><span class="card-title">Monthly Revenue</span></div>
            <div class="card-value" id="monthlyRevenueValue">₱0</div>
            <div class="card-detail">Current month</div>
          </div>
          <div class="stat-card">
            <div class="card-header"><i class="fas fa-taxi card-icon"></i><span class="card-title">Fleet Utilization</span></div>
            <div class="card-value" id="fleetUtilValue">0%</div>
            <div class="card-detail">Vehicles in use</div>
          </div>
          <div class="stat-card">
            <div class="card-header"><i class="fas fa-check card-icon"></i><span class="card-title">Trip Completion Rate</span></div>
            <div class="card-value" id="completionRateValue">0%</div>
            <div class="card-detail">Completed trips</div>
          </div>
          <div class="stat-card">
            <div class="card-header"><i class="fas fa-gas-pump card-icon"></i><span class="card-title">Fuel Efficiency</span></div>
            <div class="card-value" id="fuelEfficiencyValue">0 km/L</div>
            <div class="card-detail">Average consumption</div>
          </div>
        </div>

        <div style="margin-top:20px; display:flex; gap:8px; margin-bottom:20px;">
          <button class="btn-primary" id="tabFinancial">Financial</button>
          <button class="btn-primary" id="tabOperational" style="background:transparent; color:var(--color-text-primary); border:1px solid var(--color-border);">Operational</button>
          <button class="btn-primary" id="tabSafety" style="background:transparent; color:var(--color-text-primary); border:1px solid var(--color-border);">Safety & Risk</button>
        </div>

        <!-- Financial View -->
        <div id="financialView" class="table-container" style="margin-top:14px;">
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div>
              <h3 style="margin-bottom: 16px; color: white; display: flex; align-items: center; gap: 8px;"><i class="fas fa-chart-bar"></i>Revenue vs Expenses (Monthly Trend)</h3>
              <div style="position: relative; height: 300px;">
                <canvas id="revenueExpenseChart"></canvas>
              </div>
              <div style="margin-top: 12px; display: flex; gap: 16px; justify-content: center; font-size: 0.9em;">
                <div style="display: flex; align-items: center; gap: 6px;">
                  <span style="width: 16px; height: 16px; background: #00e676; border-radius: 2px;"></span>
                  <span>Revenue: <strong>₱425K</strong></span>
                </div>
                <div style="display: flex; align-items: center; gap: 6px;">
                  <span style="width: 16px; height: 16px; background: #e74c3c; border-radius: 2px;"></span>
                  <span>Expenses: <strong>₱285K</strong></span>
                </div>
              </div>
            </div>
            <div>
              <h3 style="margin-bottom: 16px; color: white; display: flex; align-items: center; gap: 8px;"><i class="fas fa-pie-chart"></i>Expense Breakdown</h3>
              <div style="position: relative; height: 300px;">
                <canvas id="expenseBreakdownChart"></canvas>
              </div>
              <div style="margin-top: 12px; padding: 12px; background: rgba(0,230,118,0.05); border-radius: 4px; border-left: 4px solid #00e676;">
                <div style="font-size: 0.85em; line-height: 1.6;">
                  <div style="display: flex; justify-content: space-between;"><span>Net Profit:</span><strong style="color: #00e676;">₱140K (33%)</strong></div>
                  <div style="color: var(--color-text-secondary); font-size: 0.8em;">Profit margin improved by 5% this month</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Operational View -->
        <div id="operationalView" style="display:none; margin-top:14px;">
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="table-container">
              <h3 style="margin-bottom: 16px; color: white; display: flex; align-items: center; gap: 8px;"><i class="fas fa-calendar-alt"></i>Daily Trip Volume (This Week)</h3>
              <div style="position: relative; height: 300px;">
                <canvas id="tripVolumeChart"></canvas>
              </div>
              <div style="margin-top: 12px; padding: 12px; background: rgba(0,230,118,0.05); border-radius: 4px; border-left: 4px solid #00e676;">
                <div style="font-size: 0.85em;">
                  <div>Total Trips: <strong style="color: #00e676;">1,073</strong></div>
                  <div style="color: var(--color-text-secondary); font-size: 0.8em;">Average: 153 trips/day | Peak: Thursday (180 trips)</div>
                </div>
              </div>
            </div>
            <div class="table-container">
              <h3 style="margin-bottom: 16px; color: white; display: flex; align-items: center; gap: 8px;"><i class="fas fa-taxi"></i>Fleet Status Overview</h3>
              <div style="position: relative; height: 300px;">
                <canvas id="fleetStatusChart"></canvas>
              </div>
              <div style="margin-top: 12px; display: grid; gap: 8px;">
                <div style="display: flex; justify-content: space-between; padding: 8px; background: rgba(0,230,118,0.05); border-radius: 4px;">
                  <span>Active Vehicles</span>
                  <span style="font-weight: 600; color: #00e676;">24</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px; background: rgba(52,152,219,0.05); border-radius: 4px;">
                  <span>In Use</span>
                  <span style="font-weight: 600; color: #3498db;">18</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Safety & Risk View -->
        <div id="safetyView" style="display:none; margin-top:14px;">
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="table-container">
              <h3 style="margin-bottom: 16px; color: white; display: flex; align-items: center; gap: 8px;"><i class="fas fa-shield-alt"></i>Safety Metrics Dashboard</h3>
              <div style="position: relative; height: 300px;">
                <canvas id="safetyMetricsChart"></canvas>
              </div>
              <div style="margin-top: 12px; display: grid; gap: 8px;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px; background: rgba(0,230,118,0.05); border-radius: 4px;">
                  <span>Overall Safety Score</span>
                  <span style="font-weight: 600; color: #00e676;">92/100</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px; background: rgba(230,126,34,0.05); border-radius: 4px;">
                  <span>Incidents This Month</span>
                  <span style="font-weight: 600; color: #e67e22;">3</span>
                </div>
              </div>
            </div>
            <div class="table-container">
              <h3 style="margin-bottom: 16px; color: white; display: flex; align-items: center; gap: 8px;"><i class="fas fa-exclamation-triangle"></i>Risk Assessment Summary</h3>
              <div style="display: grid; gap: 12px; max-height: 320px; overflow-y: auto;">
                <div style="padding: 12px; border-left: 4px solid #00e676; background: rgba(0,230,118,0.05); border-radius: 4px;">
                  <div style="font-weight: 500; margin-bottom: 4px; display: flex; align-items: center; gap: 8px;"><i class="fas fa-graduation-cap" style="color: #00e676;"></i>Driver Training</div>
                  <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.85em; color: var(--color-text-secondary);">95% compliance</span>
                    <span style="background: #00e676; color: #121217; padding: 2px 8px; border-radius: 4px; font-size: 0.7em; font-weight: 600;">✓ LOW RISK</span>
                  </div>
                </div>
                <div style="padding: 12px; border-left: 4px solid #f39c12; background: rgba(243,156,18,0.05); border-radius: 4px;">
                  <div style="font-weight: 500; margin-bottom: 4px; display: flex; align-items: center; gap: 8px;"><i class="fas fa-car" style="color: #f39c12;"></i>Vehicle Age</div>
                  <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.85em; color: var(--color-text-secondary);">Avg 4.2 years</span>
                    <span style="background: #f39c12; color: #121217; padding: 2px 8px; border-radius: 4px; font-size: 0.7em; font-weight: 600;">⚠ MEDIUM RISK</span>
                  </div>
                </div>
                <div style="padding: 12px; border-left: 4px solid #00e676; background: rgba(0,230,118,0.05); border-radius: 4px;">
                  <div style="font-weight: 500; margin-bottom: 4px; display: flex; align-items: center; gap: 8px;"><i class="fas fa-lock" style="color: #00e676;"></i>Insurance Coverage</div>
                  <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.85em; color: var(--color-text-secondary);">100% covered</span>
                    <span style="background: #00e676; color: #121217; padding: 2px 8px; border-radius: 4px; font-size: 0.7em; font-weight: 600;">✓ LOW RISK</span>
                  </div>
                </div>
                <div style="padding: 12px; border-left: 4px solid #00e676; background: rgba(0,230,118,0.05); border-radius: 4px;">
                  <div style="font-weight: 500; margin-bottom: 4px; display: flex; align-items: center; gap: 8px;"><i class="fas fa-wrench" style="color: #00e676;"></i>Maintenance Compliance</div>
                  <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.85em; color: var(--color-text-secondary);">98% schedule adherence</span>
                    <span style="background: #00e676; color: #121217; padding: 2px 8px; border-radius: 4px; font-size: 0.7em; font-weight: 600;">✓ LOW RISK</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    `,
        profile: `
      <div class="content-view profile-view" data-section="profile">
        <h1>Profile</h1>
        <p>Your account details and preferences.</p>
        <div class="profile-card">
          <div class="profile-hero">
            <img src="mukhako.jpg" class="profile-avatar" alt="" />
            <div class="profile-hero-text">
              <h2 id="profileDisplayName">Brian Joshua Tanael</h2>
              <p class="profile-email" id="profileDisplayEmail">bj.tanael@tnvscorp.com</p>
              <button type="button" class="btn-primary" id="profileEditBtn"><i class="fas fa-pen"></i> Edit Profile</button>
            </div>
          </div>
          <div class="profile-details">
            <h3 class="profile-details-title">Account Details</h3>
            <div class="profile-detail-row"><span class="profile-label">Role</span><span>Fleet Administrator</span></div>
            <div class="profile-detail-row"><span class="profile-label">Department</span><span>Operations</span></div>
            <div class="profile-detail-row"><span class="profile-label">Employee ID</span><span>EMP-2047</span></div>
            <div class="profile-detail-row"><span class="profile-label">Phone</span><span id="profileDisplayPhone">+63 912 345 6789</span></div>
            <div class="profile-detail-row"><span class="profile-label">Join Date</span><span>March 15, 2023</span></div>
          </div>
        </div>
        <div class="modal-backdrop" id="editProfileModal">
          <div class="modal-content">
            <button type="button" class="modal-close" data-close="editProfileModal">&times;</button>
            <h3>Edit Profile</h3>
            <form id="editProfileForm">
              <div class="form-group">
                <label for="editFullName">Full Name</label>
                <input type="text" id="editFullName" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="editEmail">Email</label>
                <input type="email" id="editEmail" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="editPhone">Phone</label>
                <input type="tel" id="editPhone" class="form-control">
              </div>
              <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Save</button>
            </form>
          </div>
        </div>
      </div>
    `,
        "settings-company": `
      <div class="content-view settings-view" data-section="settings-company">
        <h1>Company</h1>
        <p>Company information and contact details.</p>
        <div class="settings-block settings-block-full">
          <form class="settings-form" id="settingsCompanyForm">
            <div class="form-group">
              <label for="companyName">Company name</label>
              <input type="text" id="companyName" class="form-control" placeholder="ByaHERO Fleet Services">
            </div>
            <div class="form-group">
              <label for="companyEmail">Email</label>
              <input type="email" id="companyEmail" class="form-control" placeholder="contact@company.com">
            </div>
            <div class="form-group">
              <label for="companyPhone">Phone</label>
              <input type="tel" id="companyPhone" class="form-control" placeholder="+63 2 1234 5678">
            </div>
            <div class="form-group">
              <label for="companyAddress">Address</label>
              <input type="text" id="companyAddress" class="form-control" placeholder="123 Example St, City, Philippines">
            </div>
            <div class="form-row">
              <div class="form-group input-col">
                <label for="companyCurrency">Currency</label>
                <select id="companyCurrency" class="form-control">
                  <option value="PHP">PHP (₱)</option>
                  <option value="USD">USD ($)</option>
                </select>
              </div>
              <div class="form-group input-col">
                <label for="companyTimezone">Timezone</label>
                <select id="companyTimezone" class="form-control">
                  <option value="Asia/Manila">Asia/Manila</option>
                  <option value="UTC">UTC</option>
                </select>
              </div>
            </div>
            <button type="submit" class="btn-primary settings-save-company"><i class="fas fa-save"></i> Save Changes</button>
          </form>
        </div>
      </div>
    `,

        "settings-appearance": `
      <div class="content-view settings-view" data-section="settings-appearance">
        <h1>Appearance</h1>
        <p>Theme — applies across the system.</p>
        <div class="settings-block settings-block-full">
          <div class="theme-options">
            <button type="button" class="theme-option active" data-theme="dark"><i class="fas fa-moon"></i> Dark</button>
            <button type="button" class="theme-option" data-theme="light"><i class="fas fa-sun"></i> Light</button>
          </div>
        </div>
      </div>
    `,
        "settings-system": `
      <div class="content-view settings-view" data-section="settings-system">
        <h1>System Information</h1>
        <p>Application version and environment.</p>
        <div class="settings-block settings-block-full">
          <ul class="sysinfo-list">
            <li><span>Version</span><span>1.0.0</span></li>
            <li><span>Last updated</span><span>Jan 2025</span></li>
            <li><span>Browser</span><span id="sysinfoBrowser">—</span></li>
          </ul>
        </div>
      </div>
    `,
    };
    return templates[section] || "";
}

function loadSection(section) {
    if (section === "dashboard") {
        mainContent.innerHTML = dashboardHTML;
    } else if (["fuel","crm","storeroom","driver","analytics","profile","settings"].includes(section)) {
        // use module loader for module templates and resources
        if (typeof moduleLoader !== 'undefined') {
            moduleLoader.loadAndRender(section);
        } else {
            const html = getSectionHTML(section);
            if (html) mainContent.innerHTML = html;
        }
    } else {
        const html = getSectionHTML(section);
        if (html) mainContent.innerHTML = html;
    }
    navLinks.forEach((link) => {
        const isActive =
            section !== "profile" &&
            !section.startsWith("settings") &&
            section !== "notifications" &&
            link.getAttribute("data-section") === section;
        link.classList.toggle("active", isActive);
    });
    if (window.innerWidth <= 1024) sidebar.classList.remove("open");
    if (section.startsWith("settings")) initSettingsHandlers();
    if (section === "profile") initProfileHandlers();
    if (section === "fuel") initFuelHandlers();
    if (section === "crm") initCrmHandlers();
    if (section === "storeroom") initStoreroomHandlers();
    if (section === "driver") initDriverHandlers();
    if (section === "analytics") initAnalyticsHandlers();
}

// --- Sidebar Logic ---
const checkCollapseState = () => {
    if (window.innerWidth > 1024) {
        sidebar.classList.add("collapsed");
        sidebar.classList.remove("open");
    } else {
        sidebar.classList.remove("collapsed");
        sidebar.classList.remove("open");
    }
};
checkCollapseState();
window.addEventListener("resize", checkCollapseState);

sidebar.addEventListener("mouseenter", () => {
    if (window.innerWidth > 1024) sidebar.classList.remove("collapsed");
});
sidebar.addEventListener("mouseleave", () => {
    if (window.innerWidth > 1024) sidebar.classList.add("collapsed");
});

hamburger.addEventListener("click", () => {
    sidebar.classList.toggle("open");
    if (sidebar.classList.contains("open") && window.innerWidth < 1024) {
        sidebar.classList.remove("collapsed");
    }
});

// --- Navigation: load section on click ---
initDashboardTemplate();

navLinks.forEach((link) => {
    link.addEventListener("click", (e) => {
        e.preventDefault();
        const section = link.getAttribute("data-section");
        if (section) loadSection(section);
    });
});

// --- Quick Actions: navigate to section ---
mainContent.addEventListener("click", (e) => {
    const btn = e.target.closest(".quick-action-btn");
    if (btn) {
        e.preventDefault();
        const action = btn.getAttribute("data-action");
        if (action) loadSection(action);
    }
});

// --- Settings: dropdown from icon, item click loads that section in main panel ---
const settingsMenu = document.getElementById("settingsMenu");
const settingsIcon = document.getElementById("settingsIcon");
if (settingsIcon) {
    settingsIcon.addEventListener("click", (e) => {
        e.stopPropagation();
        profileMenu.classList.remove("open");
        settingsMenu.classList.toggle("open");
    });
}
document.querySelectorAll(".settings-dropdown-item").forEach((item) => {
    item.addEventListener("click", (e) => {
        e.preventDefault();
        const sec = item.getAttribute("data-section");
        settingsMenu.classList.remove("open");
        if (sec) loadSection(sec);
    });
});
document.addEventListener("click", (e) => {
    if (settingsMenu && !settingsMenu.contains(e.target))
        settingsMenu.classList.remove("open");
});



// Render notification dropdown

// --- Settings: init handlers and prefill (run after settings HTML is loaded) ---
// initSettingsHandlers moved to js/settings.js

// --- Profile: prefill from localStorage, Edit Profile modal ---
// initProfileHandlers moved to js/profile.js

// --- Profile & Logout ---
profileMenu.addEventListener("click", (e) => {
    e.stopPropagation();
    profileMenu.classList.toggle("open");
});

document.addEventListener("click", (e) => {
    if (!profileMenu.contains(e.target)) {
        profileMenu.classList.remove("open");
    }
});

const profileBtn = document.querySelector(".profile-btn");
if (profileBtn) {
    profileBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        profileMenu.classList.remove("open");
        if (settingsMenu) settingsMenu.classList.remove("open");
        loadSection("profile");
    });
}

const logoutButton = document.querySelector(".logout-btn");
if (logoutButton) {
    logoutButton.addEventListener("click", (e) => {
        e.stopPropagation();
        localStorage.removeItem("tnvs_logged_in");
        window.location.href = "index\.php";
    });
}

// --- Fuel management handlers ---
function initFuelHandlers() {
    // Elements
    const tabPurchases = document.getElementById("tabPurchases");
    const tabConsumption = document.getElementById("tabConsumption");
    const purchasesView = document.getElementById("purchasesView");
    const consumptionView = document.getElementById("consumptionView");
    const btnAddPurchase = document.getElementById("btnAddPurchase");

    if (tabPurchases && tabConsumption) {
        tabPurchases.onclick = () => {
            purchasesView.style.display = "block";
            consumptionView.style.display = "none";
            tabPurchases.style.background = "var(--color-neon-accent)";
            tabPurchases.style.color = "#121217";
            tabConsumption.style.background = "transparent";
            tabConsumption.style.color = "var(--color-text-primary)";
        };
        tabConsumption.onclick = () => {
            purchasesView.style.display = "none";
            consumptionView.style.display = "block";
            tabConsumption.style.background = "var(--color-neon-accent)";
            tabConsumption.style.color = "#121217";
            tabPurchases.style.background = "transparent";
            tabPurchases.style.color = "var(--color-text-primary)";
        };
    }

    if (btnAddPurchase) {
        btnAddPurchase.onclick = () => {
            // prefill purchase date with today for immediate month aggregation
            const pd = document.getElementById('purchaseDate');
            if (pd) {
                const d = new Date();
                const mm = String(d.getMonth() + 1).padStart(2, '0');
                const dd = String(d.getDate()).padStart(2, '0');
                pd.value = `${d.getFullYear()}-${mm}-${dd}`;
            }
            openModal("modalRecordPurchase");
        };
    }

    // Modal form handlers
    const modal = document.getElementById("modalRecordPurchase");
    const form = document.getElementById("formRecordPurchase");
    const qty = document.getElementById("quantityLiters");
    const price = document.getElementById("unitPrice");
    const total = document.getElementById("totalAmount");
    const cancel = document.getElementById("cancelPurchaseBtn");

    if (qty && price && total) {
        const recompute = () => {
            const q = parseFloat(qty.value) || 0;
            const p = parseFloat(price.value) || 0;
            total.value = (q * p).toFixed(2);
        };
        qty.addEventListener("input", recompute);
        price.addEventListener("input", recompute);
    }

    if (cancel) cancel.onclick = () => closeModal("modalRecordPurchase");
    document.querySelectorAll('[data-close="modalRecordPurchase"]').forEach((b) => {
        b.onclick = () => closeModal("modalRecordPurchase");
    });

    if (form) {
        form.onsubmit = (e) => {
            e.preventDefault();
            recordPurchaseFromForm();
        };
    }

    // Render initial data
    renderPurchasesTable();
    renderConsumptionTable();
    updateFuelSummary();
}

function openModal(id) {
    const m = document.getElementById(id);
    if (!m) return;
    m.classList.add("is-open");
    document.body.style.overflow = "hidden";
}

function closeModal(id) {
    const m = document.getElementById(id);
    if (!m) return;
    m.classList.remove("is-open");
    document.body.style.overflow = "";
    const form = m.querySelector("form");
    if (form) form.reset();
    const total = m.querySelector("#totalAmount");
    if (total) total.value = "";
}

function getPurchases() {
    try {
        return JSON.parse(localStorage.getItem("tnvs_purchases") || "[]");
    } catch (_) {
        return [];
    }
}

function savePurchases(arr) {
    localStorage.setItem("tnvs_purchases", JSON.stringify(arr));
}

function renderPurchasesTable() {
    const tbl = document.querySelector("#purchasesTable tbody");
    if (!tbl) return;
    const purchases = getPurchases();
    tbl.innerHTML = "";
    if (purchases.length === 0) {
        tbl.innerHTML = '<tr><td colspan="7" style="color:var(--color-text-secondary)">No purchases recorded.</td></tr>';
        return;
    }
    purchases.forEach((p) => {
        const tr = document.createElement("tr");
        tr.innerHTML = `<td>${escapeHtml(p.date || "-")}</td><td>${escapeHtml(p.invoice || "-")}</td><td>${escapeHtml(p.supplier || "-")}</td><td>${escapeHtml(capitalize(p.fuelType || "-"))}</td><td>${Number(p.quantity || 0).toFixed(2)}</td><td>${Number(p.unitPrice || 0).toFixed(2)}</td><td>${Number(p.total || 0).toFixed(2)}</td>`;
        tbl.appendChild(tr);
    });
}

function recordPurchaseFromForm() {
    const invoice = document.getElementById("invoiceNumber").value.trim();
    let date = document.getElementById("purchaseDate").value;
    if (!date) {
        const d = new Date();
        // YYYY-MM-DD format
        const mm = String(d.getMonth() + 1).padStart(2, '0');
        const dd = String(d.getDate()).padStart(2, '0');
        date = `${d.getFullYear()}-${mm}-${dd}`;
    }
    const supplier = document.getElementById("supplierName").value.trim();
    const fuelType = document.getElementById("fuelTypeSelect").value;
    const quantity = parseFloat(document.getElementById("quantityLiters").value) || 0;
    const unitPrice = parseFloat(document.getElementById("unitPrice").value) || 0;
    const total = parseFloat(document.getElementById("totalAmount").value) || quantity * unitPrice;

    const purchases = getPurchases();
    purchases.unshift({ invoice, date, supplier, fuelType, quantity, unitPrice, total });
    savePurchases(purchases);
    closeModal("modalRecordPurchase");
    renderPurchasesTable();
    updateFuelSummary();
}

function escapeHtml(s) {
    return String(s).replace(/[&<>"']/g, function(c) {
        return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
    });
}

function capitalize(s) {
    if (!s) return s;
    return s.charAt(0).toUpperCase() + s.slice(1);
}

// helper to apply common badge styles (background/text color can be specified)
function styleBadge(elem, bgColor, textColor = 'white') {
    if (!elem) return;
    elem.style.background = bgColor;
    elem.style.color = textColor;
    elem.style.padding = '4px 8px';
    elem.style.borderRadius = '4px';
    elem.style.fontSize = '0.85em';
}

function updateFuelSummary() {
    const purchases = getPurchases();
    const consumptions = getConsumptions();
    // Stocks: sum purchases by type minus consumption by type
    const petrolPurchased = purchases.filter(p => p.fuelType === 'petrol').reduce((s, i) => s + (Number(i.quantity) || 0), 0);
    const dieselPurchased = purchases.filter(p => p.fuelType === 'diesel').reduce((s, i) => s + (Number(i.quantity) || 0), 0);
    const petrolConsumed = consumptions.filter(c => c.fuelType === 'petrol').reduce((s, i) => s + (Number(i.fuelConsumed) || 0), 0);
    const dieselConsumed = consumptions.filter(c => c.fuelType === 'diesel').reduce((s, i) => s + (Number(i.fuelConsumed) || 0), 0);

    const petrolStock = petrolPurchased - petrolConsumed;
    const dieselStock = dieselPurchased - dieselConsumed;

    const petrolEl = document.getElementById('petrolStockValue');
    const dieselEl = document.getElementById('dieselStockValue');
    const monthEl = document.getElementById('monthPurchaseValue');
    const avgEl = document.getElementById('avgDailyValue');

    if (petrolEl) petrolEl.textContent = `${petrolStock.toFixed(2)} L`;
    if (dieselEl) dieselEl.textContent = `${dieselStock.toFixed(2)} L`;

    // This month's purchases (liters)
    const now = new Date();
    const month = now.getMonth();
    const year = now.getFullYear();
    const monthSum = purchases.filter(p => {
        try {
            const d = new Date(p.date);
            return d.getMonth() === month && d.getFullYear() === year;
        } catch (_) { return false; }
    }).reduce((s, i) => s + (Number(i.quantity) || 0), 0);
    if (monthEl) monthEl.textContent = `${monthSum.toFixed(2)} L`;

    // Avg daily consumption: total consumed this month divided by day number
    const consThisMonth = consumptions.filter(c => {
        try { const d = new Date(c.date); return d.getMonth() === month && d.getFullYear() === year; } catch (_) { return false; }
    }).reduce((s, i) => s + (Number(i.fuelConsumed) || 0), 0);
    const dayOfMonth = now.getDate() || 1;
    const avgDaily = dayOfMonth ? (consThisMonth / dayOfMonth) : 0;
    if (avgEl) avgEl.textContent = `${avgDaily.toFixed(2)} L/day`;
}

function getConsumptions() {
    try {
        return JSON.parse(localStorage.getItem('tnvs_consumptions') || '[]');
    } catch (_) { return []; }
}

function renderConsumptionTable() {
    const tbl = document.querySelector('#consumptionTable tbody');
    if (!tbl) return;
    const rows = getConsumptions();
    tbl.innerHTML = '';
    if (!rows.length) {
        tbl.innerHTML = '<tr><td colspan="5" style="color:var(--color-text-secondary)">No consumption records. This table will populate from vehicle trips and GPS distance tracking.</td></tr>';
        return;
    }
    rows.forEach(r => {
        const tr = document.createElement('tr');
        tr.innerHTML = `<td>${escapeHtml(r.date||'')}</td><td>${escapeHtml(r.vehicle||'')}</td><td>${Number(r.distance||0).toFixed(2)}</td><td>${Number(r.fuelConsumed||0).toFixed(2)}</td><td>${capitalize(r.fuelType||'')}</td>`;
        tbl.appendChild(tr);
    });
}

// --- CRM Module Handlers ---
function initCrmHandlers() {
    const tabCustomers = document.getElementById("tabCustomers");
    const tabTickets = document.getElementById("tabTickets");
    const tabFeedback = document.getElementById("tabFeedback");
    const customersView = document.getElementById("customersView");
    const ticketsView = document.getElementById("ticketsView");
    const feedbackView = document.getElementById("feedbackView");
    const btnAddCustomer = document.getElementById("btnAddCustomer");
    const btnNewTicket = document.getElementById("btnNewTicket");

    // Tab switching
    if (tabCustomers && tabTickets && tabFeedback) {
        tabCustomers.onclick = () => {
            customersView.style.display = "block";
            ticketsView.style.display = "none";
            feedbackView.style.display = "none";
            tabCustomers.style.background = "var(--color-neon-accent)";
            tabCustomers.style.color = "#121217";
            tabTickets.style.background = "transparent";
            tabTickets.style.color = "var(--color-text-primary)";
            tabFeedback.style.background = "transparent";
            tabFeedback.style.color = "var(--color-text-primary)";
            btnAddCustomer.style.display = "block";
            btnNewTicket.style.display = "none";
        };
        tabTickets.onclick = () => {
            customersView.style.display = "none";
            ticketsView.style.display = "block";
            feedbackView.style.display = "none";
            tabTickets.style.background = "var(--color-neon-accent)";
            tabTickets.style.color = "#121217";
            tabCustomers.style.background = "transparent";
            tabCustomers.style.color = "var(--color-text-primary)";
            tabFeedback.style.background = "transparent";
            tabFeedback.style.color = "var(--color-text-primary)";
            btnAddCustomer.style.display = "none";
            btnNewTicket.style.display = "block";
        };
        tabFeedback.onclick = () => {
            customersView.style.display = "none";
            ticketsView.style.display = "none";
            feedbackView.style.display = "block";
            tabFeedback.style.background = "var(--color-neon-accent)";
            tabFeedback.style.color = "#121217";
            tabCustomers.style.background = "transparent";
            tabCustomers.style.color = "var(--color-text-primary)";
            tabTickets.style.background = "transparent";
            tabTickets.style.color = "var(--color-text-primary)";
            btnAddCustomer.style.display = "none";
            btnNewTicket.style.display = "none";
        };
    }

    // Add Customer Modal
    if (btnAddCustomer) {
        btnAddCustomer.onclick = () => {
            openModal("modalAddCustomer");
        };
    }

    const formAddCustomer = document.getElementById("formAddCustomer");
    const cancelAddCustomerBtn = document.getElementById("cancelAddCustomerBtn");
    if (cancelAddCustomerBtn) cancelAddCustomerBtn.onclick = () => closeModal("modalAddCustomer");
    document.querySelectorAll('[data-close="modalAddCustomer"]').forEach((b) => {
        b.onclick = () => closeModal("modalAddCustomer");
    });
    if (formAddCustomer) {
        formAddCustomer.onsubmit = (e) => {
            e.preventDefault();
            addCustomerFromForm();
        };
    }

    // New Ticket Modal
    if (btnNewTicket) {
        btnNewTicket.onclick = () => {
            openModal("modalNewTicket");
        };
    }

    const formNewTicket = document.getElementById("formNewTicket");
    const cancelNewTicketBtn = document.getElementById("cancelNewTicketBtn");
    if (cancelNewTicketBtn) cancelNewTicketBtn.onclick = () => closeModal("modalNewTicket");
    document.querySelectorAll('[data-close="modalNewTicket"]').forEach((b) => {
        b.onclick = () => closeModal("modalNewTicket");
    });
    if (formNewTicket) {
        formNewTicket.onsubmit = (e) => {
            e.preventDefault();
            createTicketFromForm();
        };
    }

    // Render initial data
    renderCustomersTable();
    renderTicketsTable();
    renderFeedbackTable();
    updateCrmSummary();
    attachDetailModalHandlers();
}

function getCustomers() {
    try {
        return JSON.parse(localStorage.getItem("tnvs_customers") || "[]");
    } catch (_) {
        return [];
    }
}

function saveCustomers(arr) {
    localStorage.setItem("tnvs_customers", JSON.stringify(arr));
}

function getTickets() {
    try {
        return JSON.parse(localStorage.getItem("tnvs_tickets") || "[]");
    } catch (_) {
        return [];
    }
}

function saveTickets(arr) {
    localStorage.setItem("tnvs_tickets", JSON.stringify(arr));
}

function getFeedback() {
    try {
        return JSON.parse(localStorage.getItem("tnvs_feedback") || "[]");
    } catch (_) {
        return [];
    }
}

function saveFeedback(arr) {
    localStorage.setItem("tnvs_feedback", JSON.stringify(arr));
}

function addCustomerFromForm() {
    const name = document.getElementById("customerName").value.trim();
    const email = document.getElementById("customerEmail").value.trim();
    const phone = document.getElementById("customerPhone").value.trim();
    const type = document.getElementById("customerType").value;

    if (!name || !email || !phone || !type) {
        alert("Please fill in all fields");
        return;
    }

    const customers = getCustomers();
    const code = "CUST-" + String(customers.length + 1).padStart(5, '0');

    const newCustomer = {
        id: Date.now(),
        code,
        name,
        email,
        phone,
        type,
        totalTrips: 0,
        totalSpent: 0,
        rating: 5.0,
        status: "active",
        createdAt: new Date().toISOString()
    };

    customers.unshift(newCustomer);
    saveCustomers(customers);
    closeModal("modalAddCustomer");
    renderCustomersTable();
    updateCrmSummary();
}

function createTicketFromForm() {
    const subject = document.getElementById("ticketSubject").value.trim();
    const description = document.getElementById("ticketDescription").value.trim();
    const priority = document.getElementById("ticketPriority").value;
    const category = document.getElementById("ticketCategory").value;

    if (!subject || !description || !priority || !category) {
        alert("Please fill in all fields");
        return;
    }

    const tickets = getTickets();
    const ticketNumber = "TKT-" + String(tickets.length + 1).padStart(6, '0');

    const newTicket = {
        id: Date.now(),
        ticketNumber,
        subject,
        description,
        category,
        priority,
        status: "open",
        createdAt: new Date().toISOString()
    };

    tickets.unshift(newTicket);
    saveTickets(tickets);
    closeModal("modalNewTicket");
    renderTicketsTable();
    updateCrmSummary();
}

function renderCustomersTable() {
    const tbl = document.querySelector("#customersTable tbody");
    if (!tbl) return;
    const customers = getCustomers();
    tbl.innerHTML = "";
    if (customers.length === 0) {
        tbl.innerHTML = '<tr><td colspan="8" style="color:var(--color-text-secondary)">No customers yet. Add one to get started.</td></tr>';
        return;
    }
    customers.forEach((c, idx) => {
        const tr = document.createElement("tr");
        const ratingStars = c.rating ? '⭐ ' + c.rating.toFixed(1) : '⭐ N/A';
        tr.innerHTML = `<td>${escapeHtml(c.name)}</td><td>${escapeHtml(c.code)}</td><td>${capitalize(c.type)}</td><td>${c.totalTrips || 0}</td><td>₱${Number(c.totalSpent || 0).toFixed(2)}</td><td>${ratingStars}</td><td><span class="status-badge">${capitalize(c.status)}</span></td><td><button class="action-btn" data-customer-id="${c.id}">View</button></td>`;
        tbl.appendChild(tr);
        const badge = tr.querySelector('.status-badge');
        styleBadge(badge, c.status === 'active' ? '#00e676' : '#999', '#121217');

        const viewBtn = tr.querySelector('button');
        viewBtn.onclick = () => viewCustomerDetails(c.id);
    });
}

function renderTicketsTable() {
    const tbl = document.querySelector("#ticketsTable tbody");
    if (!tbl) return;
    const tickets = getTickets();
    tbl.innerHTML = "";
    if (tickets.length === 0) {
        tbl.innerHTML = '<tr><td colspan="7" style="color:var(--color-text-secondary)">No support tickets yet.</td></tr>';
        return;
    }
    tickets.forEach((t) => {
        const tr = document.createElement("tr");
        const priorityColor = t.priority === 'urgent' ? '#e74c3c' : t.priority === 'high' ? '#f39c12' : t.priority === 'medium' ? '#3498db' : '#95a5a6';
        const statusColor = t.status === 'open' ? '#e74c3c' : t.status === 'in-progress' ? '#f39c12' : '#00e676';
        tr.innerHTML = `<td>${escapeHtml(t.ticketNumber)}</td><td>${escapeHtml(t.subject)}</td><td>${capitalize(t.category)}</td><td><span class="priority-badge">${capitalize(t.priority)}</span></td><td><span class="status-badge">${capitalize(t.status)}</span></td><td>${new Date(t.createdAt).toLocaleDateString()}</td><td><button class="action-btn" data-ticket-id="${t.id}">View</button></td>`;
        tbl.appendChild(tr);
        const prio = tr.querySelector('.priority-badge');
        const stat = tr.querySelector('.status-badge');
        styleBadge(prio, priorityColor);
        styleBadge(stat, statusColor);

        const viewBtn = tr.querySelector('button');
        viewBtn.onclick = () => viewTicketDetails(t.id);
    });
}

function renderFeedbackTable() {
    const tbl = document.querySelector("#feedbackTable tbody");
    if (!tbl) return;
    const feedback = getFeedback();
    tbl.innerHTML = "";
    if (feedback.length === 0) {
        tbl.innerHTML = '<tr><td colspan="5" style="color:var(--color-text-secondary)">No feedback yet. Feedback will appear after completed trips.</td></tr>';
        return;
    }
    feedback.forEach((f) => {
        const tr = document.createElement("tr");
        const stars = f.rating ? '⭐ '.repeat(Math.round(f.rating)) : '⭐';
        tr.innerHTML = `<td>${escapeHtml(f.customerName)}</td><td>${escapeHtml(f.tripId)}</td><td>${escapeHtml(f.feedback)}</td><td>${stars}</td><td><button class="action-btn" data-feedback-id="${f.id}" style="padding: 2px 8px; font-size: 0.85em;">View</button></td>`;
        tbl.appendChild(tr);

        const viewBtn = tr.querySelector('button');
        viewBtn.onclick = () => viewFeedbackDetails(f.id);
    });
}

function updateCrmSummary() {
    const customers = getCustomers();
    const tickets = getTickets();
    const feedback = getFeedback();

    const totalCustomersEl = document.getElementById('totalCustomersValue');
    const openTicketsEl = document.getElementById('openTicketsValue');
    const avgRatingEl = document.getElementById('avgRatingValue');
    const resolutionRateEl = document.getElementById('resolutionRateValue');

    if (totalCustomersEl) totalCustomersEl.textContent = customers.length;

    const openCount = tickets.filter(t => t.status === 'open').length;
    if (openTicketsEl) openTicketsEl.textContent = openCount;

    let avgRating = 0;
    if (feedback.length > 0) {
        avgRating = feedback.reduce((sum, f) => sum + (f.rating || 0), 0) / feedback.length;
    } else if (customers.length > 0) {
        avgRating = customers.reduce((sum, c) => sum + (c.rating || 5), 0) / customers.length;
    }
    if (avgRatingEl) avgRatingEl.textContent = avgRating.toFixed(1);

    let resolutionRate = 0;
    if (tickets.length > 0) {
        const resolvedCount = tickets.filter(t => t.status === 'resolved').length;
        resolutionRate = (resolvedCount / tickets.length) * 100;
    }
    if (resolutionRateEl) resolutionRateEl.textContent = resolutionRate.toFixed(0) + '%';
}

// --- View Functions for CRM Details ---
function viewCustomerDetails(customerId) {
    const customers = getCustomers();
    const customer = customers.find(c => c.id === customerId);
    if (!customer) return;

    const content = document.getElementById('customerDetailContent');
    if (!content) return;

    content.innerHTML = `
        <div style="display: grid; gap: 16px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Name</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500;">${escapeHtml(customer.name)}</p>
                </div>
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Customer Code</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500;">${escapeHtml(customer.code)}</p>
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Email</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500;">${escapeHtml(customer.email)}</p>
                </div>
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Phone</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500;">${escapeHtml(customer.phone)}</p>
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Type</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500;">${capitalize(customer.type)}</p>
                </div>
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Status</label>
                    <p style="margin: 8px 0 0 0;"><span class="status-badge">${capitalize(customer.status)}</span></p>
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; border-top: 1px solid var(--color-border); padding-top: 16px;">
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Total Trips</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500; font-size: 1.2em;">${customer.totalTrips || 0}</p>
                </div>
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Total Spent</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500; font-size: 1.2em;">₱${Number(customer.totalSpent || 0).toFixed(2)}</p>
                </div>
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Rating</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500; font-size: 1.2em;">⭐ ${customer.rating ? customer.rating.toFixed(1) : 'N/A'}</p>
                </div>
            </div>
            <div style="border-top: 1px solid var(--color-border); padding-top: 16px;">
                <label style="color: var(--color-text-secondary); font-size: 0.9em;">Member Since</label>
                <p style="margin: 8px 0 0 0; font-weight: 500;">${new Date(customer.createdAt).toLocaleDateString()}</p>
            </div>
        </div>
    `;
    const custBadge = content.querySelector('.status-badge');
    styleBadge(custBadge, customer.status === 'active' ? '#00e676' : '#999', '#121217');
    openModal('modalViewCustomer');

    openModal('modalViewCustomer');
}

function viewTicketDetails(ticketId) {
    const tickets = getTickets();
    const ticket = tickets.find(t => t.id === ticketId);
    if (!ticket) return;

    const content = document.getElementById('ticketDetailContent');
    if (!content) return;

    const priorityColor = ticket.priority === 'urgent' ? '#e74c3c' : ticket.priority === 'high' ? '#f39c12' : ticket.priority === 'medium' ? '#3498db' : '#95a5a6';
    const statusColor = ticket.status === 'open' ? '#e74c3c' : ticket.status === 'in-progress' ? '#f39c12' : '#00e676';

    content.innerHTML = `
        <div style="display: grid; gap: 16px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Ticket Number</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500; font-size: 1.1em;">${escapeHtml(ticket.ticketNumber)}</p>
                </div>
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Created</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500;">${new Date(ticket.createdAt).toLocaleDateString()}</p>
                </div>
            </div>
            <div>
                <label style="color: var(--color-text-secondary); font-size: 0.9em;">Subject</label>
                <p style="margin: 8px 0 0 0; font-weight: 500;">${escapeHtml(ticket.subject)}</p>
            </div>
            <div>
                <label style="color: var(--color-text-secondary); font-size: 0.9em;">Description</label>
                <p style="margin: 8px 0 0 0; color: var(--color-text-secondary); line-height: 1.5;">${escapeHtml(ticket.description)}</p>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; border-top: 1px solid var(--color-border); padding-top: 16px;">
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Category</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500;">${capitalize(ticket.category)}</p>
                </div>
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Priority</label>
                    <p style="margin: 8px 0 0 0;"><span class="priority-badge">${capitalize(ticket.priority)}</span></p>
                </div>
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Status</label>
                    <p style="margin: 8px 0 0 0;"><span class="status-badge">${capitalize(ticket.status)}</span></p>
                </div>
            </div>
        </div>
    `;

    // Store current ticket ID for status update
    document.getElementById('ticketDetailContent').setAttribute('data-ticket-id', ticketId);

    openModal('modalViewTicket');
}

function viewFeedbackDetails(feedbackId) {
    const feedback = getFeedback();
    const fb = feedback.find(f => f.id === feedbackId);
    if (!fb) return;

    const content = document.getElementById('feedbackDetailContent');
    if (!content) return;

    const stars = fb.rating ? '⭐ '.repeat(Math.round(fb.rating)) : '⭐';

    content.innerHTML = `
        <div style="display: grid; gap: 16px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Customer</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500;">${escapeHtml(fb.customerName)}</p>
                </div>
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Trip ID</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500;">${escapeHtml(fb.tripId)}</p>
                </div>
            </div>
            <div>
                <label style="color: var(--color-text-secondary); font-size: 0.9em;">Rating</label>
                <p style="margin: 8px 0 0 0; font-weight: 500; font-size: 1.5em;">${stars} (${fb.rating || 0}/5)</p>
            </div>
            <div>
                <label style="color: var(--color-text-secondary); font-size: 0.9em;">Feedback</label>
                <p style="margin: 8px 0 0 0; color: var(--color-text-secondary); line-height: 1.5; background: rgba(0,230,118,0.05); padding: 12px; border-radius: 4px; border-left: 3px solid var(--color-neon-accent);">${escapeHtml(fb.feedback)}</p>
            </div>
            <div style="border-top: 1px solid var(--color-border); padding-top: 16px;">
                <label style="color: var(--color-text-secondary); font-size: 0.9em;">Date</label>
                <p style="margin: 8px 0 0 0; font-weight: 500;">${new Date(fb.date).toLocaleDateString()}</p>
            </div>
        </div>
    `;

    openModal('modalViewFeedback');
}

// Add event listeners for detail modal close buttons
function attachDetailModalHandlers() {
    const closeCustomerBtn = document.getElementById('closeCustomerDetailBtn');
    const closeTicketBtn = document.getElementById('closeTicketDetailBtn');
    const closeFeedbackBtn = document.getElementById('closeFeedbackDetailBtn');
    const updateTicketStatusBtn = document.getElementById('updateTicketStatusBtn');
    const ticketStatusSelect = document.getElementById('ticketStatusSelect');

    if (closeCustomerBtn) closeCustomerBtn.onclick = () => closeModal('modalViewCustomer');
    if (closeTicketBtn) closeTicketBtn.onclick = () => closeModal('modalViewTicket');
    if (closeFeedbackBtn) closeFeedbackBtn.onclick = () => closeModal('modalViewFeedback');

    document.querySelectorAll('[data-close="modalViewCustomer"]').forEach(b => {
        b.onclick = () => closeModal('modalViewCustomer');
    });
    document.querySelectorAll('[data-close="modalViewTicket"]').forEach(b => {
        b.onclick = () => closeModal('modalViewTicket');
    });
    document.querySelectorAll('[data-close="modalViewFeedback"]').forEach(b => {
        b.onclick = () => closeModal('modalViewFeedback');
    });

    if (updateTicketStatusBtn && ticketStatusSelect) {
        updateTicketStatusBtn.onclick = () => {
            const newStatus = ticketStatusSelect.value;
            if (!newStatus) {
                alert('Please select a status');
                return;
            }
            const ticketContent = document.getElementById('ticketDetailContent');
            const ticketId = parseInt(ticketContent.getAttribute('data-ticket-id'));
            updateTicketStatus(ticketId, newStatus);
            ticketStatusSelect.value = '';
        };
    }
}

function updateTicketStatus(ticketId, newStatus) {
    const tickets = getTickets();
    const ticket = tickets.find(t => t.id === ticketId);
    if (!ticket) return;

    ticket.status = newStatus;
    saveTickets(tickets);
    closeModal('modalViewTicket');
    renderTicketsTable();
    updateCrmSummary();
    alert('Ticket status updated to: ' + capitalize(newStatus));
}

// --- STOREROOM MODULE HANDLERS ---
function initStoreroomHandlers() {
    const tabInventory = document.getElementById("tabStoreroomInventory");
    const tabProcurement = document.getElementById("tabStoreroomProcurement");
    const inventoryView = document.getElementById("inventoryView");
    const procurementView = document.getElementById("procurementView");
    const btnAddAsset = document.getElementById("btnAddAsset");
    const btnNewRequest = document.getElementById("btnNewRequest");

    if (tabInventory && tabProcurement) {
        tabInventory.onclick = () => {
            inventoryView.style.display = "block";
            procurementView.style.display = "none";
            tabInventory.style.background = "var(--color-neon-accent)";
            tabInventory.style.color = "#121217";
            tabProcurement.style.background = "transparent";
            tabProcurement.style.color = "var(--color-text-primary)";
            btnAddAsset.style.display = "block";
            btnNewRequest.style.display = "none";
        };
        tabProcurement.onclick = () => {
            inventoryView.style.display = "none";
            procurementView.style.display = "block";
            tabProcurement.style.background = "var(--color-neon-accent)";
            tabProcurement.style.color = "#121217";
            tabInventory.style.background = "transparent";
            tabInventory.style.color = "var(--color-text-primary)";
            btnAddAsset.style.display = "none";
            btnNewRequest.style.display = "block";
        };
    }

    if (btnAddAsset) btnAddAsset.onclick = () => openModal("modalAddAsset");
    if (btnNewRequest) btnNewRequest.onclick = () => openModal("modalNewRequest");

    const formAddAsset = document.getElementById("formAddAsset");
    const formNewRequest = document.getElementById("formNewRequest");

    if (formAddAsset) {
        formAddAsset.onsubmit = (e) => {
            e.preventDefault();
            addAssetFromForm();
        };
    }
    if (formNewRequest) {
        formNewRequest.onsubmit = (e) => {
            e.preventDefault();
            submitRequestFromForm();
        };
    }

    document.querySelectorAll('[data-close="modalAddAsset"], [data-close="modalNewRequest"], [data-close="modalViewAsset"], [data-close="modalViewRequest"]').forEach(b => {
        b.onclick = () => closeModal(b.getAttribute('data-close'));
    });

    document.getElementById("cancelAddAssetBtn").onclick = () => closeModal("modalAddAsset");
    document.getElementById("cancelNewRequestBtn").onclick = () => closeModal("modalNewRequest");
    document.getElementById("closeAssetDetailBtn").onclick = () => closeModal("modalViewAsset");
    document.getElementById("closeRequestDetailBtn").onclick = () => closeModal("modalViewRequest");

    document.getElementById("updateRequestStatusBtn").onclick = () => {
        const newStatus = document.getElementById("requestStatusSelect").value;
        if (!newStatus) return;
        const requestContent = document.getElementById("requestDetailContent");
        const requestId = parseInt(requestContent.getAttribute("data-request-id"));
        updateRequestStatus(requestId, newStatus);
    };

    renderInventoryTable();
    renderProcurementTable();
    updateStoreroomSummary();
    populateRequestAssetDropdown();
}

function getAssets() {
    try {
        return JSON.parse(localStorage.getItem("tnvs_assets") || "[]");
    } catch (_) {
        return [];
    }
}

function saveAssets(arr) {
    localStorage.setItem("tnvs_assets", JSON.stringify(arr));
}

function getProcurementRequests() {
    try {
        return JSON.parse(localStorage.getItem("tnvs_procurement_requests") || "[]");
    } catch (_) {
        return [];
    }
}

function saveProcurementRequests(arr) {
    localStorage.setItem("tnvs_procurement_requests", JSON.stringify(arr));
}

function addAssetFromForm() {
    const name = document.getElementById("assetName").value.trim();
    const category = document.getElementById("assetCategory").value;
    const location = document.getElementById("assetLocation").value.trim();
    const quantity = parseFloat(document.getElementById("assetQuantity").value) || 0;
    const unit = document.getElementById("assetUnit").value;
    const unitCost = parseFloat(document.getElementById("assetUnitCost").value) || 0;
    const reorderLevel = parseFloat(document.getElementById("assetReorderLevel").value) || 0;

    const assets = getAssets();
    const code = "AST-" + String(assets.length + 1).padStart(5, '0');

    const newAsset = {
        id: Date.now(),
        code,
        name,
        category,
        location,
        quantity,
        unit,
        unitCost,
        reorderLevel,
        status: quantity > reorderLevel ? "in-stock" : quantity > 0 ? "low-stock" : "out-of-stock",
        createdAt: new Date().toISOString()
    };

    assets.unshift(newAsset);
    saveAssets(assets);
    closeModal("modalAddAsset");
    renderInventoryTable();
    updateStoreroomSummary();
    populateRequestAssetDropdown();
    document.getElementById("formAddAsset").reset();
}

function submitRequestFromForm() {
    const assetId = document.getElementById("requestAsset").value;
    const quantity = parseFloat(document.getElementById("requestQuantity").value) || 0;
    const reason = document.getElementById("requestReason").value.trim();

    if (!assetId || !quantity || !reason) {
        alert("Please fill in all fields");
        return;
    }

    const assets = getAssets();
    const asset = assets.find(a => a.id == assetId);
    if (!asset) return;

    const requests = getProcurementRequests();
    const requestNumber = "REQ-" + String(requests.length + 1).padStart(6, '0');

    const newRequest = {
        id: Date.now(),
        requestNumber,
        assetId,
        assetName: asset.name,
        quantity,
        reason,
        requestedBy: "Current User",
        status: "pending",
        createdAt: new Date().toISOString()
    };

    requests.unshift(newRequest);
    saveProcurementRequests(requests);
    closeModal("modalNewRequest");
    renderProcurementTable();
    updateStoreroomSummary();
    document.getElementById("formNewRequest").reset();
}

function populateRequestAssetDropdown() {
    const select = document.getElementById("requestAsset");
    const assets = getAssets();
    select.innerHTML = '<option value="">Select Asset</option>';
    assets.forEach(a => {
        const option = document.createElement("option");
        option.value = a.id;
        option.textContent = a.name + " (" + a.code + ")";
        select.appendChild(option);
    });
}

function renderInventoryTable() {
    const tbl = document.querySelector("#inventoryTable tbody");
    if (!tbl) return;
    const assets = getAssets();
    tbl.innerHTML = "";
    if (assets.length === 0) {
        tbl.innerHTML = '<tr><td colspan="8" style="color:var(--color-text-secondary)">No assets added yet.</td></tr>';
        return;
    }
    assets.forEach(a => {
        const tr = document.createElement("tr");
        const statusColor = a.status === "out-of-stock" ? "#e74c3c" : a.status === "low-stock" ? "#f39c12" : "#00e676";
        tr.innerHTML = `<td>${escapeHtml(a.name)}</td><td>${escapeHtml(a.code)}</td><td>${capitalize(a.category)}</td><td>${a.quantity} ${a.unit}</td><td>₱${a.unitCost.toFixed(2)}</td><td>${escapeHtml(a.location)}</td><td><span class="status-badge">${capitalize(a.status.replace('-',' '))}</span></td><td><button class="action-btn" data-asset-id="${a.id}">View</button></td>`;
        tbl.appendChild(tr);
        const badge = tr.querySelector('.status-badge');
        styleBadge(badge, statusColor);
        const viewBtn = tr.querySelector("button");
        viewBtn.onclick = () => viewAssetDetails(a.id);
    });
}

function renderProcurementTable() {
    const tbl = document.querySelector("#procurementTable tbody");
    if (!tbl) return;
    const requests = getProcurementRequests();
    tbl.innerHTML = "";
    if (requests.length === 0) {
        tbl.innerHTML = '<tr><td colspan="7" style="color:var(--color-text-secondary)">No procurement requests yet.</td></tr>';
        return;
    }
    requests.forEach(r => {
        const tr = document.createElement("tr");
        const statusColor = r.status === "pending" ? "#f39c12" : r.status === "approved" ? "#3498db" : r.status === "fulfilled" ? "#00e676" : "#e74c3c";
        tr.innerHTML = `<td>${escapeHtml(r.requestNumber)}</td><td>${escapeHtml(r.assetName)}</td><td>${r.quantity}</td><td>${escapeHtml(r.requestedBy)}</td><td><span class="status-badge">${capitalize(r.status)}</span></td><td>${new Date(r.createdAt).toLocaleDateString()}</td><td><button class="action-btn" data-request-id="${r.id}">View</button></td>`;
        tbl.appendChild(tr);
        const badge = tr.querySelector('.status-badge');
        styleBadge(badge, statusColor);
        const viewBtn = tr.querySelector("button");
        viewBtn.onclick = () => viewRequestDetails(r.id);
    });
}

function viewAssetDetails(assetId) {
    const assets = getAssets();
    const asset = assets.find(a => a.id === assetId);
    if (!asset) return;

    const content = document.getElementById("assetDetailContent");
    content.innerHTML = `
        <div style="display: grid; gap: 16px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Asset Name</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500;">${escapeHtml(asset.name)}</p>
                </div>
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Code</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500;">${escapeHtml(asset.code)}</p>
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Category</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500;">${capitalize(asset.category)}</p>
                </div>
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Location</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500;">${escapeHtml(asset.location)}</p>
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; border-top: 1px solid var(--color-border); padding-top: 16px;">
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Quantity</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500; font-size: 1.2em;">${asset.quantity} ${asset.unit}</p>
                </div>
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Unit Cost</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500; font-size: 1.2em;">₱${asset.unitCost.toFixed(2)}</p>
                </div>
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Total Value</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500; font-size: 1.2em;">₱${(asset.quantity * asset.unitCost).toFixed(2)}</p>
                </div>
            </div>
            <div style="border-top: 1px solid var(--color-border); padding-top: 16px;">
                <label style="color: var(--color-text-secondary); font-size: 0.9em;">Status</label>
                <p style="margin: 8px 0 0 0;"><span class="status-badge">${capitalize(asset.status.replace('-',' '))}</span></p>
            </div>
        </div>
    `;
    // style badge added dynamically
    const assetBadge = content.querySelector('.status-badge');
    const bgColor = asset.status === "out-of-stock" ? "#e74c3c" : asset.status === "low-stock" ? "#f39c12" : "#00e676";
    styleBadge(assetBadge, bgColor);
    openModal("modalViewAsset");
}

function viewRequestDetails(requestId) {
    const requests = getProcurementRequests();
    const request = requests.find(r => r.id === requestId);
    if (!request) return;

    const content = document.getElementById("requestDetailContent");
    const statusColor = request.status === "pending" ? "#f39c12" : request.status === "approved" ? "#3498db" : request.status === "fulfilled" ? "#00e676" : "#e74c3c";
    content.innerHTML = `
        <div style="display: grid; gap: 16px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Request Number</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500; font-size: 1.1em;">${escapeHtml(request.requestNumber)}</p>
                </div>
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Created</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500;">${new Date(request.createdAt).toLocaleDateString()}</p>
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Asset</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500;">${escapeHtml(request.assetName)}</p>
                </div>
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Quantity</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500;">${request.quantity}</p>
                </div>
            </div>
            <div>
                <label style="color: var(--color-text-secondary); font-size: 0.9em;">Reason</label>
                <p style="margin: 8px 0 0 0; color: var(--color-text-secondary);">${escapeHtml(request.reason)}</p>
            </div>
            <div style="border-top: 1px solid var(--color-border); padding-top: 16px;">
                <label style="color: var(--color-text-secondary); font-size: 0.9em;">Status</label>
                <p style="margin: 8px 0 0 0;"><span class="status-badge">${capitalize(request.status)}</span></p>
            </div>
        </div>
    `;
    // badge style
    const reqBadge = document.getElementById("requestDetailContent").querySelector('.status-badge');
    styleBadge(reqBadge, statusColor);
    document.getElementById("requestDetailContent").setAttribute("data-request-id", requestId);
    openModal("modalViewRequest");
}

function updateRequestStatus(requestId, newStatus) {
    const requests = getProcurementRequests();
    const request = requests.find(r => r.id === requestId);
    if (!request) return;

    request.status = newStatus;
    saveProcurementRequests(requests);
    closeModal("modalViewRequest");
    renderProcurementTable();
    updateStoreroomSummary();
}

function updateStoreroomSummary() {
    const assets = getAssets();
    const requests = getProcurementRequests();

    const lowStock = assets.filter(a => a.quantity <= a.reorderLevel && a.quantity > 0).length;
    const outOfStock = assets.filter(a => a.quantity === 0).length;
    const pendingRequests = requests.filter(r => r.status === "pending").length;

    document.getElementById("totalAssetsValue").textContent = assets.length;
    document.getElementById("lowStockValue").textContent = lowStock;
    document.getElementById("outOfStockValue").textContent = outOfStock;
    document.getElementById("pendingRequestsValue").textContent = pendingRequests;
}

// --- DRIVER MODULE HANDLERS ---
function initDriverHandlers() {
    const tabDrivers = document.getElementById("tabDrivers");
    const tabPerformance = document.getElementById("tabPerformance");
    const driversView = document.getElementById("driversView");
    const performanceView = document.getElementById("performanceView");
    const btnAddDriver = document.getElementById("btnAddDriver");

    if (tabDrivers && tabPerformance) {
        tabDrivers.onclick = () => {
            driversView.style.display = "block";
            performanceView.style.display = "none";
            tabDrivers.style.background = "var(--color-neon-accent)";
            tabDrivers.style.color = "#121217";
            tabPerformance.style.background = "transparent";
            tabPerformance.style.color = "var(--color-text-primary)";
        };
        tabPerformance.onclick = () => {
            driversView.style.display = "none";
            performanceView.style.display = "block";
            tabPerformance.style.background = "var(--color-neon-accent)";
            tabPerformance.style.color = "#121217";
            tabDrivers.style.background = "transparent";
            tabDrivers.style.color = "var(--color-text-primary)";
        };
    }

    if (btnAddDriver) btnAddDriver.onclick = () => openModal("modalAddDriver");

    const formAddDriver = document.getElementById("formAddDriver");
    if (formAddDriver) {
        formAddDriver.onsubmit = (e) => {
            e.preventDefault();
            addDriverFromForm();
        };
    }

    document.getElementById("cancelAddDriverBtn").onclick = () => closeModal("modalAddDriver");
    document.getElementById("closeDriverDetailBtn").onclick = () => closeModal("modalViewDriver");

    document.querySelectorAll('[data-close="modalAddDriver"], [data-close="modalViewDriver"]').forEach(b => {
        b.onclick = () => closeModal(b.getAttribute('data-close'));
    });

    renderDriversTable();
    renderPerformanceTable();
    updateDriverSummary();
}

function getDrivers() {
    try {
        return JSON.parse(localStorage.getItem("tnvs_drivers") || "[]");
    } catch (_) {
        return [];
    }
}

function saveDrivers(arr) {
    localStorage.setItem("tnvs_drivers", JSON.stringify(arr));
}


function addDriverFromForm() {
    const firstName = document.getElementById("driverFirstName").value.trim();
    const lastName = document.getElementById("driverLastName").value.trim();
    const email = document.getElementById("driverEmail").value.trim();
    const phone = document.getElementById("driverPhone").value.trim();
    const license = document.getElementById("driverLicense").value.trim();
    const licenseExpiry = document.getElementById("driverLicenseExpiry").value;
    const hireDate = document.getElementById("driverHireDate").value;
    const address = document.getElementById("driverAddress").value.trim();
    const emergencyContact = document.getElementById("driverEmergencyContact").value.trim();
    const emergencyPhone = document.getElementById("driverEmergencyPhone").value.trim();

    const drivers = getDrivers();
    const employeeId = "DRV-" + String(drivers.length + 1).padStart(5, '0');

    const newDriver = {
        id: Date.now(),
        employeeId,
        firstName,
        lastName,
        email,
        phone,
        license,
        licenseExpiry,
        hireDate,
        address,
        emergencyContact,
        emergencyPhone,
        totalTrips: 0,
        rating: 5.0,
        vehicle: "Unassigned",
        status: "active",
        createdAt: new Date().toISOString()
    };

    drivers.unshift(newDriver);
    saveDrivers(drivers);
    closeModal("modalAddDriver");
    renderDriversTable();
    updateDriverSummary();
    document.getElementById("formAddDriver").reset();
}

function renderDriversTable() {
    const tbl = document.querySelector("#driversTable tbody");
    if (!tbl) return;
    const drivers = getDrivers();
    tbl.innerHTML = "";
    if (drivers.length === 0) {
        tbl.innerHTML = '<tr><td colspan="7" style="color:var(--color-text-secondary)">No drivers registered yet.</td></tr>';
        return;
    }
    drivers.forEach(d => {
        const tr = document.createElement("tr");
        const statusColor = d.status === "active" ? "#00e676" : "#95a5a6";
        tr.innerHTML = `<td>${escapeHtml(d.employeeId)}</td><td>${escapeHtml(d.license)}</td><td>${d.totalTrips}</td><td>⭐ ${d.rating.toFixed(1)}</td><td>${escapeHtml(d.vehicle)}</td><td><span class="status-badge">${capitalize(d.status)}</span></td><td><button class="action-btn" data-driver-id="${d.id}">View</button></td>`;
        tbl.appendChild(tr);
        const badge = tr.querySelector('.status-badge');
        styleBadge(badge, statusColor, '#121217');
        const viewBtn = tr.querySelector("button");
        viewBtn.onclick = () => viewDriverDetails(d.id);
    });
}


function renderPerformanceTable() {
    const tbl = document.querySelector("#performanceTable tbody");
    if (!tbl) return;
    const drivers = getDrivers();
    tbl.innerHTML = "";
    if (drivers.length === 0) {
        tbl.innerHTML = '<tr><td colspan="7" style="color:var(--color-text-secondary)">No driver performance data yet.</td></tr>';
        return;
    }
    drivers.forEach(d => {
        const tr = document.createElement("tr");
        tr.innerHTML = `<td>${escapeHtml(d.firstName + ' ' + d.lastName)}</td><td>${d.totalTrips}</td><td>⭐ ${d.rating.toFixed(1)}</td><td>95%</td><td>₱${(d.totalTrips * 250).toFixed(2)}</td><td><span style="background:#00e676; color:#121217; padding:4px 8px; border-radius:4px; font-size:0.85em; font-weight:500;">92/100</span></td><td><button class="action-btn" data-driver-id="${d.id}">Details</button></td>`;
        tbl.appendChild(tr);
    });
}

function viewDriverDetails(driverId) {
    const drivers = getDrivers();
    const driver = drivers.find(d => d.id === driverId);
    if (!driver) return;

    const content = document.getElementById("driverDetailContent");
    content.innerHTML = `
        <div style="display: grid; gap: 16px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Employee ID</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500;">${escapeHtml(driver.employeeId)}</p>
                </div>
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Full Name</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500;">${escapeHtml(driver.firstName + ' ' + driver.lastName)}</p>
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Email</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500;">${escapeHtml(driver.email)}</p>
                </div>
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Phone</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500;">${escapeHtml(driver.phone)}</p>
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">License Number</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500;">${escapeHtml(driver.license)}</p>
                </div>
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">License Expiry</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500;">${new Date(driver.licenseExpiry).toLocaleDateString()}</p>
                </div>
            </div>
            <div style="border-top: 1px solid var(--color-border); padding-top: 16px; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Total Trips</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500; font-size: 1.2em;">${driver.totalTrips}</p>
                </div>
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Rating</label>
                    <p style="margin: 8px 0 0 0; font-weight: 500; font-size: 1.2em;">⭐ ${driver.rating.toFixed(1)}</p>
                </div>
                <div>
                    <label style="color: var(--color-text-secondary); font-size: 0.9em;">Status</label>
                    <p style="margin: 8px 0 0 0;"><span style="background: #00e676; color: #121217; padding: 4px 12px; border-radius: 4px; font-weight: 500;">${capitalize(driver.status)}</span></p>
                </div>
            </div>
        </div>
    `;
    openModal("modalViewDriver");
}



function updateDriverSummary() {
    const drivers = getDrivers();

    const avgRating = drivers.length > 0 ? (drivers.reduce((s, d) => s + d.rating, 0) / drivers.length).toFixed(1) : 0;
    const avgTrips = drivers.length > 0 ? Math.round(drivers.reduce((s, d) => s + d.totalTrips, 0) / drivers.length) : 0;

    document.getElementById("totalDriversValue").textContent = drivers.length;
    document.getElementById("avgDriverRatingValue").textContent = avgRating;
    document.getElementById("avgTripsValue").textContent = avgTrips;
}

// --- ANALYTICS MODULE HANDLERS ---
function initAnalyticsHandlers() {
    // Load Chart.js library if not already loaded
    if (typeof Chart === 'undefined') {
        const script = document.createElement('script');
        script.src = 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js';
        script.onload = () => initCharts();
        document.head.appendChild(script);
    } else {
        initCharts();
    }

    const tabFinancial = document.getElementById("tabFinancial");
    const tabOperational = document.getElementById("tabOperational");
    const tabSafety = document.getElementById("tabSafety");
    const financialView = document.getElementById("financialView");
    const operationalView = document.getElementById("operationalView");
    const safetyView = document.getElementById("safetyView");

    if (tabFinancial && tabOperational && tabSafety) {
        tabFinancial.onclick = () => {
            financialView.style.display = "block";
            operationalView.style.display = "none";
            safetyView.style.display = "none";
            tabFinancial.style.background = "var(--color-neon-accent)";
            tabFinancial.style.color = "#121217";
            tabOperational.style.background = "transparent";
            tabOperational.style.color = "var(--color-text-primary)";
            tabSafety.style.background = "transparent";
            tabSafety.style.color = "var(--color-text-primary)";
            setTimeout(() => {
                if (revenueExpenseChart) revenueExpenseChart.resize();
                if (expenseBreakdownChart) expenseBreakdownChart.resize();
            }, 100);
        };
        tabOperational.onclick = () => {
            financialView.style.display = "none";
            operationalView.style.display = "block";
            safetyView.style.display = "none";
            tabOperational.style.background = "var(--color-neon-accent)";
            tabOperational.style.color = "#121217";
            tabFinancial.style.background = "transparent";
            tabFinancial.style.color = "var(--color-text-primary)";
            tabSafety.style.background = "transparent";
            tabSafety.style.color = "var(--color-text-primary)";
            setTimeout(() => {
                if (tripVolumeChart) tripVolumeChart.resize();
                if (fleetStatusChart) fleetStatusChart.resize();
            }, 100);
        };
        tabSafety.onclick = () => {
            financialView.style.display = "none";
            operationalView.style.display = "none";
            safetyView.style.display = "block";
            tabSafety.style.background = "var(--color-neon-accent)";
            tabSafety.style.color = "#121217";
            tabFinancial.style.background = "transparent";
            tabFinancial.style.color = "var(--color-text-primary)";
            tabOperational.style.background = "transparent";
            tabOperational.style.color = "var(--color-text-primary)";
            setTimeout(() => {
                if (safetyMetricsChart) safetyMetricsChart.resize();
            }, 100);
        };
    }

    updateAnalyticsSummary();
}

let revenueExpenseChart, expenseBreakdownChart, tripVolumeChart, fleetStatusChart, safetyMetricsChart;

function initCharts() {
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: '#999',
                    font: { size: 11 }
                },
                grid: {
                    color: 'rgba(255,255,255,0.05)',
                    drawBorder: false
                }
            },
            x: {
                ticks: {
                    color: '#999',
                    font: { size: 11 }
                },
                grid: {
                    display: false,
                    drawBorder: false
                }
            }
        }
    };

    // Revenue vs Expenses Chart
    const revenueCtx = document.getElementById('revenueExpenseChart');
    if (revenueCtx) {
        revenueExpenseChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [{
                        label: 'Revenue',
                        data: [380000, 410000, 425000, 420000],
                        borderColor: '#00e676',
                        backgroundColor: 'rgba(0,230,118,0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointBackgroundColor: '#00e676',
                        pointBorderColor: '#121217',
                        pointBorderWidth: 2,
                        pointHoverRadius: 7
                    },
                    {
                        label: 'Expenses',
                        data: [250000, 270000, 285000, 280000],
                        borderColor: '#e74c3c',
                        backgroundColor: 'rgba(231,76,60,0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointBackgroundColor: '#e74c3c',
                        pointBorderColor: '#121217',
                        pointBorderWidth: 2,
                        pointHoverRadius: 7
                    }
                ]
            },
            options: {
                ...chartOptions,
                scales: {
                    ...chartOptions.scales,
                    y: {
                        ...chartOptions.scales.y,
                        ticks: {
                            ...chartOptions.scales.y.ticks,
                            callback: (value) => '₱' + (value / 1000).toFixed(0) + 'K'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: (context) => {
                                return context.dataset.label + ': ₱' + context.parsed.y.toLocaleString();
                            }
                        }
                    },
                    ...chartOptions.plugins
                }
            }
        });
    }

    // Expense Breakdown Pie Chart
    const expenseCtx = document.getElementById('expenseBreakdownChart');
    if (expenseCtx) {
        expenseBreakdownChart = new Chart(expenseCtx, {
            type: 'doughnut',
            data: {
                labels: ['Fuel (35%)', 'Payroll (30%)', 'Maintenance (25%)', 'Other (10%)'],
                datasets: [{
                    data: [35, 30, 25, 10],
                    backgroundColor: [
                        '#00e676',
                        '#3498db',
                        '#e67e22',
                        '#95a5a6'
                    ],
                    borderColor: '#121217',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#ccc',
                            font: { size: 12 },
                            padding: 15,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: (context) => {
                                return context.label + ': ₱' + (285000 * context.parsed / 100).toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }

    // Trip Volume Chart
    const tripCtx = document.getElementById('tripVolumeChart');
    if (tripCtx) {
        tripVolumeChart = new Chart(tripCtx, {
            type: 'bar',
            data: {
                labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                datasets: [{
                    label: 'Trips',
                    data: [153, 168, 147, 180, 170, 136, 119],
                    backgroundColor: [
                        '#00e676',
                        '#00e676',
                        '#00e676',
                        '#00e676',
                        '#00e676',
                        '#3498db',
                        '#95a5a6'
                    ],
                    borderColor: '#00e676',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                ...chartOptions,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: (context) => 'Trips: ' + context.parsed.y
                        }
                    },
                    ...chartOptions.plugins
                }
            }
        });
    }

    // Fleet Status Doughnut Chart
    const fleetCtx = document.getElementById('fleetStatusChart');
    if (fleetCtx) {
        fleetStatusChart = new Chart(fleetCtx, {
            type: 'doughnut',
            data: {
                labels: ['In Use (18)', 'Maintenance (4)', 'Idle (2)', 'Reserved (0)'],
                datasets: [{
                    data: [18, 4, 2, 0],
                    backgroundColor: [
                        '#00e676',
                        '#f39c12',
                        '#95a5a6',
                        '#555'
                    ],
                    borderColor: '#121217',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#ccc',
                            font: { size: 12 },
                            padding: 15,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: (context) => {
                                return context.label + ': ' + context.parsed + ' vehicles';
                            }
                        }
                    }
                }
            }
        });
    }

    // Safety Metrics Radar Chart
    const safetyCtx = document.getElementById('safetyMetricsChart');
    if (safetyCtx) {
        safetyMetricsChart = new Chart(safetyCtx, {
            type: 'radar',
            data: {
                labels: ['Training', 'Maintenance', 'Insurance', 'Compliance', 'Safety Score'],
                datasets: [{
                    label: 'Safety Metrics',
                    data: [95, 98, 100, 94, 92],
                    borderColor: '#00e676',
                    backgroundColor: 'rgba(0,230,118,0.15)',
                    pointBackgroundColor: '#00e676',
                    pointBorderColor: '#121217',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            color: '#999',
                            font: { size: 10 }
                        },
                        grid: {
                            color: 'rgba(255,255,255,0.05)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#ccc'
                        }
                    }
                }
            }
        });
    }
}

function updateAnalyticsSummary() {
    document.getElementById("monthlyRevenueValue").textContent = "₱425,000";
    document.getElementById("fleetUtilValue").textContent = "75%";
    document.getElementById("completionRateValue").textContent = "94%";
    document.getElementById("fuelEfficiencyValue").textContent = "8.5 km/L";
}

// --- SEARCH FUNCTIONALITY ---
function initSearchFunctionality() {
    const searchInput = document.querySelector(".search-input");
    if (!searchInput) return;

    // Create search results container
    const searchContainer = document.querySelector(".search-container");
    const resultsContainer = document.createElement("div");
    resultsContainer.id = "searchResultsDropdown";
    resultsContainer.style.cssText = `
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: var(--color-surface);
        border: 1px solid var(--color-border);
        border-radius: 8px;
        max-height: 400px;
        overflow-y: auto;
        display: none;
        margin-top: 8px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        z-index: 1000;
    `;
    searchContainer.style.position = "relative";
    searchContainer.appendChild(resultsContainer);

    searchInput.addEventListener("input", (e) => {
        const query = e.target.value.toLowerCase().trim();

        if (query.length === 0) {
            resultsContainer.style.display = "none";
            resultsContainer.innerHTML = "";
            return;
        }

        const results = performGlobalSearch(query);
        displaySearchResults(results, resultsContainer, searchInput);
    });

    searchInput.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            searchInput.value = "";
            resultsContainer.style.display = "none";
            resultsContainer.innerHTML = "";
        }
    });

    // Hide results when clicking outside
    document.addEventListener("click", (e) => {
        if (!searchContainer.contains(e.target)) {
            resultsContainer.style.display = "none";
        }
    });
}

function performGlobalSearch(query) {
    const results = [];

    // Search in drivers
    try {
        const drivers = getDrivers();
        drivers.forEach(d => {
            if (d.firstName.toLowerCase().includes(query) ||
                d.lastName.toLowerCase().includes(query) ||
                d.employeeId.toLowerCase().includes(query)) {
                results.push({
                    type: "driver",
                    title: d.firstName + " " + d.lastName,
                    subtitle: d.employeeId,
                    data: d,
                    icon: "fa-id-card"
                });
            }
        });
    } catch (e) {
        console.error("Error searching drivers:", e);
    }

    // Search in assets
    try {
        const assets = getAssets();
        assets.forEach(a => {
            if (a.name.toLowerCase().includes(query) || a.code.toLowerCase().includes(query)) {
                results.push({
                    type: "asset",
                    title: a.name,
                    subtitle: a.code + " - " + capitalize(a.category),
                    data: a,
                    icon: "fa-boxes"
                });
            }
        });
    } catch (e) {
        console.error("Error searching assets:", e);
    }

    // Search in tickets
    try {
        const tickets = getTickets();
        tickets.forEach(t => {
            if (t.subject.toLowerCase().includes(query) || t.ticketNumber.toLowerCase().includes(query)) {
                results.push({
                    type: "ticket",
                    title: t.ticketNumber + " - " + t.subject,
                    subtitle: capitalize(t.category),
                    data: t,
                    icon: "fa-ticket-alt"
                });
            }
        });
    } catch (e) {
        console.error("Error searching tickets:", e);
    }

    // Search in customers
    try {
        const customers = getCustomers();
        customers.forEach(c => {
            if (c.name.toLowerCase().includes(query) || c.code.toLowerCase().includes(query)) {
                results.push({
                    type: "customer",
                    title: c.name,
                    subtitle: c.code + " - " + capitalize(c.type),
                    data: c,
                    icon: "fa-user"
                });
            }
        });
    } catch (e) {
        console.error("Error searching customers:", e);
    }

    return results.slice(0, 8);
}

function displaySearchResults(results, container, searchInput) {
    container.innerHTML = "";

    if (results.length === 0) {
        container.innerHTML = `
            <div style="padding: 16px; color: var(--color-text-secondary); text-align: center;">
                <i class="fas fa-search" style="display: block; font-size: 24px; margin-bottom: 8px; opacity: 0.5;"></i>
                No results found
            </div>
        `;
        container.style.display = "block";
        return;
    }

    results.forEach(result => {
        const resultItem = document.createElement("div");
        resultItem.style.cssText = `
            padding: 12px 16px;
            border-bottom: 1px solid var(--color-border);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: background 0.2s;
        `;

        resultItem.onmouseover = () => {
            resultItem.style.background = "rgba(0,230,118,0.05)";
        };

        resultItem.onmouseout = () => {
            resultItem.style.background = "transparent";
        };

        resultItem.onclick = () => {
            handleSearchResultClick(result);
            searchInput.value = "";
            container.style.display = "none";
        };

        const icon = document.createElement("i");
        icon.className = `fas ${result.icon}`;
        icon.style.color = "var(--color-neon-accent)";
        icon.style.width = "24px";

        const textContainer = document.createElement("div");
        textContainer.innerHTML = `
            <div style="font-weight: 500; color: var(--color-text-primary);">${escapeHtml(result.title)}</div>
            <div style="font-size: 0.85em; color: var(--color-text-secondary);">${escapeHtml(result.subtitle)}</div>
        `;

        resultItem.appendChild(icon);
        resultItem.appendChild(textContainer);
        container.appendChild(resultItem);
    });

    container.style.display = "block";
}

function handleSearchResultClick(result) {
    switch (result.type) {
        case "driver":
            loadSection("driver");
            setTimeout(() => viewDriverDetails(result.data.id), 500);
            break;
        case "asset":
            loadSection("storeroom");
            setTimeout(() => viewAssetDetails(result.data.id), 500);
            break;
        case "ticket":
            loadSection("crm");
            setTimeout(() => {
                // Switch to tickets tab
                document.getElementById("tabTickets").click();
                viewTicketDetails(result.data.id);
            }, 500);
            break;
        case "customer":
            loadSection("crm");
            setTimeout(() => viewCustomerDetails(result.data.id), 500);
            break;
    }
}

// --- Weekly Performance Chart Enhancement ---
class PerformanceChart {
    constructor() {
        this.chartBars = document.getElementById('performanceChartBars');
        this.tooltip = document.getElementById('chartTooltip');
        this.valueLabels = document.getElementById('chartValueLabels');
        this.initChart();
    }

    initChart() {
        if (!this.chartBars) return;

        // Initialize value labels
        this.updateValueLabels();

        // Add hover and click listeners to each bar
        this.chartBars.querySelectorAll('.chart-bar-wrapper').forEach((wrapper, index) => {
            wrapper.addEventListener('mouseenter', (e) => this.showTooltip(e, wrapper));
            wrapper.addEventListener('mousemove', (e) => this.updateTooltipPosition(e));
            wrapper.addEventListener('mouseleave', () => this.hideTooltip());
            wrapper.addEventListener('click', () => this.handleBarClick(wrapper, index));
        });
    }

    updateValueLabels() {
        const bars = this.chartBars.querySelectorAll('.chart-bar-wrapper');
        let labelHtml = '';

        bars.forEach(bar => {
            const value = bar.dataset.value;
            labelHtml += `<div class="chart-value-label" style="flex: 1; max-width: 48px; text-align: center;">${value}%</div>`;
        });

        this.valueLabels.innerHTML = labelHtml;
    }

    showTooltip(e, wrapper) {
        const day = wrapper.dataset.day;
        const value = wrapper.dataset.value;
        const performance = this.getPerformanceMetric(value);

        this.tooltip.innerHTML = `
            <div style="font-weight: 600; margin-bottom: 4px;">${day}</div>
            <div>Performance: ${value}%</div>
            <div style="font-size: 0.75rem; color: var(--color-text-secondary); margin-top: 4px;">${performance}</div>
        `;
        this.tooltip.style.display = 'block';
        this.updateTooltipPosition(e);
    }

    updateTooltipPosition(e) {
        if (this.tooltip.style.display === 'none') return;

        const rect = e.target.getBoundingClientRect();
        const tooltipWidth = 120;
        const tooltipHeight = 80;

        let left = rect.left - tooltipWidth / 2 + rect.width / 2;
        let top = rect.top - tooltipHeight - 10;

        // Keep tooltip within viewport
        if (left < 0) left = 10;
        if (left + tooltipWidth > window.innerWidth) left = window.innerWidth - tooltipWidth - 10;
        if (top < 0) top = rect.bottom + 10;

        this.tooltip.style.left = left + 'px';
        this.tooltip.style.top = top + 'px';
    }

    hideTooltip() {
        this.tooltip.style.display = 'none';
    }

    getPerformanceMetric(value) {
        const numValue = parseInt(value);
        if (numValue >= 85) return '🟢 Excellent';
        if (numValue >= 70) return '🟡 Good';
        if (numValue >= 50) return '🟠 Moderate';
        return '🔴 Low';
    }

    handleBarClick(wrapper, index) {
        const day = wrapper.dataset.day;
        const value = wrapper.dataset.value;

        // Add animation effect
        wrapper.style.transform = 'scale(0.95)';
        setTimeout(() => {
            wrapper.style.transform = 'translateY(-4px)';
        }, 100);

        // Log the click (can be extended with actual data viewing)
        console.log(`Performance data for ${day}: ${value}%`);
    }
}

// Initialize performance chart when dashboard is loaded
function initPerformanceChart() {
    const chart = new PerformanceChart();
    window.performanceChart = chart;
}

// Call initialization when the page loads or when dashboard section is activated
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPerformanceChart);
} else {
    initPerformanceChart();
}

document.addEventListener("DOMContentLoaded", () => {
    initSearchFunctionality();
    initPerformanceChart();
});
