<?php
header('Content-Type: application/javascript');
?>
// Fuel management module
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
