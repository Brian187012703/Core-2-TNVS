<?php
header('Content-Type: application/javascript');
?>
// Settings module
function initSettingsHandlers() {
    const companyForm = document.getElementById("settingsCompanyForm");
    const companyKeys = [
        "companyName",
        "companyEmail",
        "companyPhone",
        "companyAddress",
        "companyCurrency",
        "companyTimezone",
    ];
    const notifIds = [
        "notif_email",
        "notif_fuel",
        "notif_maint",
        "notif_driver",
        "notif_daily",
    ];

    // ====== COMPANY SETTINGS ======
    try {
        const co = JSON.parse(localStorage.getItem("tnvs_company") || "{}");
        companyKeys.forEach((k) => {
            const el = document.getElementById(k);
            if (el && co[k] != null) el.value = co[k];
        });
    } catch (_) {}

    if (companyForm) {
        companyForm.onsubmit = (e) => {
            e.preventDefault();
            const o = {};
            companyKeys.forEach((k) => {
                const el = document.getElementById(k);
                if (el) o[k] = el.value;
            });
            localStorage.setItem("tnvs_company", JSON.stringify(o));
            alert("Company details saved.");
        };
    }

    // ====== NOTIFICATION SETTINGS ======
    // Initialize all notification preference checkboxes
    const prefMapping = {
        'notif_email': 'systemNotifications',
        'notif_fuel': 'fuelUpdates',
        'notif_maint': 'maintenanceReminders',
        'notif_driver': 'driverMessages',
        'notif_daily': 'vehicleAlerts'
    };

    // 1. Load preferences from localStorage on init
    try {
        const savedPrefs = JSON.parse(localStorage.getItem("tnvs_notification_prefs") || "{}");
        notifIds.forEach((id) => {
            const el = document.getElementById(id);
            if (el) {
                const prefKey = prefMapping[id];
                el.checked = savedPrefs[prefKey] !== undefined ? savedPrefs[prefKey] : true;
            }
        });
    } catch (_) {}

    // 2. Also load from old tnvs_notif format for backward compatibility
    try {
        const oldPrefs = JSON.parse(localStorage.getItem("tnvs_notif") || "{}");
        notifIds.forEach((id) => {
            const el = document.getElementById(id);
            if (el && oldPrefs[id] !== undefined) {
                el.checked = !!oldPrefs[id];
            }
        });
    } catch (_) {}

    // 3. Sync with NotificationSystem if available
    if (typeof notificationSystem !== 'undefined' && notificationSystem) {
        const prefs = notificationSystem.preferences;
        Object.entries(prefMapping).forEach(([checkboxId, prefKey]) => {
            const el = document.getElementById(checkboxId);
            if (el) {
                el.checked = prefs[prefKey] === true;
            }
        });
    }

    // 4. Add real-time change listeners
    notifIds.forEach((id) => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('change', (e) => {
                const prefKey = prefMapping[id];

                // Update NotificationSystem immediately
                if (typeof notificationSystem !== 'undefined' && notificationSystem) {
                    notificationSystem.preferences[prefKey] = e.target.checked;
                    notificationSystem.savePreferences();
                }
            });
        }
    });

    // 5. Add Save button handler
    const saveNotif = document.querySelector(".settings-save-notif");
    if (saveNotif) {
        saveNotif.onclick = () => {
            const prefs = {};
            const oldPrefs = {};

            notifIds.forEach((id) => {
                const el = document.getElementById(id);
                if (el) {
                    const prefKey = prefMapping[id];
                    prefs[prefKey] = el.checked;
                    oldPrefs[id] = el.checked;
                }
            });

            // Save to new format
            localStorage.setItem("tnvs_notification_prefs", JSON.stringify(prefs));

            // Save to old format for backward compatibility
            localStorage.setItem("tnvs_notif", JSON.stringify(oldPrefs));

            // Update NotificationSystem
            if (typeof notificationSystem !== 'undefined' && notificationSystem) {
                notificationSystem.preferences = {...notificationSystem.preferences, ...prefs };
                notificationSystem.savePreferences();
            }

            alert("Notification preferences saved.");
        };
    }

    // ====== THEME SETTINGS ======
    let theme = localStorage.getItem("tnvs_theme") || "dark";
    if (theme === "system") theme = "dark";
    document.querySelectorAll(".theme-option").forEach((btn) => {
        btn.classList.toggle("active", btn.getAttribute("data-theme") === theme);
    });

    const sb = document.getElementById("sysinfoBrowser");
    if (sb)
        sb.textContent =
        navigator.userAgent.split(" ").pop() || navigator.appVersion || "—";

    document.querySelectorAll(".theme-option").forEach((btn) => {
        btn.onclick = () => {
            const v = btn.getAttribute("data-theme");
            if (v === "system") return;
            document.documentElement.setAttribute("data-theme", v);
            localStorage.setItem("tnvs_theme", v);
            document
                .querySelectorAll(".theme-option")
                .forEach((b) =>
                    b.classList.toggle("active", b.getAttribute("data-theme") === v),
                );
        };
    });
}
