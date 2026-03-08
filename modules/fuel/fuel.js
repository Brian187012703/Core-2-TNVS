// Fuel Management Module
// Handles all fuel-related operations

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

    renderPurchasesTable();
    renderConsumptionTable();
    updateFuelSummary();
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
        const mm = String(d.getMonth() + 1).padStart(2, '0');
        const dd = String(d.getDate()).padStart(2, '0');
        date = `${d.getFullYear()}-${mm}-${dd}`;
    }
    const supplier = document.getElementById("supplierName").value.trim();
    const fuelType = document.getElementById("fuelTypeSelect").value;
    const qty = parseFloat(document.getElementById("quantityLiters").value);
    const unitPrice = parseFloat(document.getElementById("unitPrice").value);
    const total = parseFloat(document.getElementById("totalAmount").value);
    const vehicleId = (document.getElementById("vehicleId") && document.getElementById("vehicleId").value) || "001";

    if (!invoice || !supplier || isNaN(qty) || isNaN(unitPrice)) {
        alert("Please fill all required fields");
        return;
    }

    const purchases = getPurchases();
    const newPurchase = { date, invoice, supplier, fuelType, quantity: qty, unitPrice, total, vehicleId, totalCost: total };
    purchases.push(newPurchase);
    savePurchases(purchases);

    // Log to dashboard
    if (window.logDashboardActivity) {
        window.logDashboardActivity('fuel_purchase', 'fuel',
            `TNVS-${String(vehicleId).padStart(3, '0')} refueled with ${qty} liters at ₱${unitPrice}/L`
        );
    }

    closeModal("modalRecordPurchase");
    renderPurchasesTable();
    updateFuelSummary();
}

function renderConsumptionTable() {
    const tbl = document.querySelector("#consumptionTable tbody");
    if (!tbl) return;
    tbl.innerHTML = '<tr><td colspan="5" style="color:var(--color-text-secondary)">Consumption data synced from trip records.</td></tr>';
}

function updateFuelSummary() {
    const purchases = getPurchases();
    const now = new Date();
    const currentMonth = now.getMonth();
    const currentYear = now.getFullYear();

    const petrolQty = purchases
        .filter(p => p.fuelType === "petrol")
        .reduce((sum, p) => sum + (parseFloat(p.quantity) || 0), 0);

    const dieselQty = purchases
        .filter(p => p.fuelType === "diesel")
        .reduce((sum, p) => sum + (parseFloat(p.quantity) || 0), 0);

    const monthPurchases = purchases
        .filter(p => {
            const d = new Date(p.date);
            return d.getMonth() === currentMonth && d.getFullYear() === currentYear;
        })
        .reduce((sum, p) => sum + (parseFloat(p.quantity) || 0), 0);

    document.getElementById("petrolStockValue").textContent = petrolQty.toFixed(2) + " L";
    document.getElementById("dieselStockValue").textContent = dieselQty.toFixed(2) + " L";
    document.getElementById("monthPurchaseValue").textContent = monthPurchases.toFixed(2) + " L";
    document.getElementById("avgDailyValue").textContent = (monthPurchases / Math.max(now.getDate(), 1)).toFixed(2) + " L/day";
}

// Helper functions (shared utilities)
function escapeHtml(str) {
    if (!str) return "";
    const div = document.createElement("div");
    div.textContent = str;
    return div.innerHTML;
}

function capitalize(str) {
    if (!str) return "";
    return str.charAt(0).toUpperCase() + str.slice(1);
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