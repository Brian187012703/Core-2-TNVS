<?php
header('Content-Type: application/javascript');
?>
// Profile module
function initProfileHandlers() {
    const def = {
        fullName: "Brian Joshua Tanael",
        email: "bj.tanael@tnvscorp.com",
        phone: "+63 912 345 6789",
    };
    let data = def;
    try {
        data = {
            ...def,
            ...JSON.parse(localStorage.getItem("tnvs_profile") || "{}"),
        };
    } catch (_) {}
    const setDisplays = () => {
        const name = data.fullName || def.fullName;
        const email = data.email || def.email;
        const phone = data.phone || def.phone;
        const n = document.getElementById("profileDisplayName");
        const e = document.getElementById("profileDisplayEmail");
        const p = document.getElementById("profileDisplayPhone");
        if (n) n.textContent = name;
        if (e) e.textContent = email;
        if (p) p.textContent = phone;
        const dh = document.querySelector(".profile-dropdown h3");
        const dp = document.querySelector(".profile-dropdown p");
        if (dh) dh.textContent = name;
        if (dp) dp.textContent = email;
    };
    setDisplays();
    const modal = document.getElementById("editProfileModal");
    const form = document.getElementById("editProfileForm");
    const openBtn = document.getElementById("profileEditBtn");
    if (openBtn && modal) {
        openBtn.onclick = () => {
            const fn = document.getElementById("editFullName");
            const em = document.getElementById("editEmail");
            const ph = document.getElementById("editPhone");
            if (fn) fn.value = data.fullName || "";
            if (em) em.value = data.email || "";
            if (ph) ph.value = data.phone || "";
            modal.classList.add("is-open");
            document.body.style.overflow = "hidden";
        };
    }
    if (form && modal) {
        form.onsubmit = (e) => {
            e.preventDefault();
            const fn = document.getElementById("editFullName");
            const em = document.getElementById("editEmail");
            const ph = document.getElementById("editPhone");
            data = {
                fullName: (fn && fn.value) || "",
                email: (em && em.value) || "",
                phone: (ph && ph.value) || "",
            };
            localStorage.setItem("tnvs_profile", JSON.stringify(data));
            setDisplays();
            modal.classList.remove("is-open");
            document.body.style.overflow = "";
        };
    }
    const closeBtn = document.querySelector('[data-close="editProfileModal"]');
    if (closeBtn && modal)
        closeBtn.onclick = () => {
            modal.classList.remove("is-open");
            document.body.style.overflow = "";
        };
    if (modal)
        modal.onclick = (e) => {
            if (e.target === modal) {
                modal.classList.remove("is-open");
                document.body.style.overflow = "";
            }
        };
}
