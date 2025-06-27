document.addEventListener("DOMContentLoaded", function () {
    const lanjutkanPembayaranBtn = document.getElementById(
        "lanjutkanPembayaranBtn"
    );
    const paymentModalOverlay = document.getElementById("paymentModalOverlay");
    const paymentModal = document.getElementById("paymentModal");
    const closePaymentModalBtn = document.getElementById(
        "closePaymentModalBtn"
    );
    const cancelPaymentBtn = document.getElementById("cancelPaymentBtn");
    const submitPaymentBtn = document.getElementById("submitPaymentBtn");

    const addProductFromModalBtn = document.getElementById(
        "addProductFromModalBtn"
    );
    const addProductModalOverlay = document.getElementById(
        "addProductModalOverlay"
    );
    const addProductModal = document.getElementById("addProductModal");
    const closeAddProductModalBtn = document.getElementById(
        "closeAddProductModalBtn"
    );
    const cancelAddProductBtn = document.getElementById("cancelAddProductBtn");

    const paymentSuccessModalOverlay = document.getElementById(
        "paymentSuccessModalOverlay"
    );
    const backToPosFromSuccessBtn = document.getElementById(
        "backToPosFromSuccessBtn"
    );

    const payNowTab = document.getElementById("payNowTab");
    const payLaterTab = document.getElementById("payLaterTab");
    const payNowContent = document.getElementById("payNowContent");
    const payLaterContent = document.getElementById("payLaterContent");

    const settingsSidebarButton = document.getElementById(
        "settingsSidebarButton"
    );
    const posViewButton = document.getElementById("posViewButton");
    const posViewContainer = document.getElementById("posViewContainer");
    const settingsPageContainer = document.getElementById(
        "settingsPageContainer"
    );

    const settingsNavItems = document.querySelectorAll(".settings-nav-item");
    const settingsContentDivs = {
        kelolaDiskonContent: document.getElementById("kelolaDiskonContent"),
        kelolaPrinterContent: document.getElementById("kelolaPrinterContent"),
        perhitunganBiayaContent: document.getElementById(
            "perhitunganBiayaContent"
        ),
    };
    const settingsTabs = document.querySelectorAll(".settings-tab");
    const settingsTabContents = {
        layananContent: document.getElementById("layananContent"),
        pajakContent: document.getElementById("pajakContent"),
    };

    // Modal Biaya Layanan
    const addServiceFeeButton = document.getElementById("addServiceFeeButton");
    const serviceFeeModalOverlay = document.getElementById(
        "serviceFeeModalOverlay"
    );
    const serviceFeeModal = document.getElementById("serviceFeeModal");
    const closeServiceFeeModalBtn = document.getElementById(
        "closeServiceFeeModalBtn"
    );
    const saveServiceFeeBtn = document.getElementById("saveServiceFeeBtn");
    const serviceFeeListContainer = document.getElementById(
        "serviceFeeListContainer"
    );
    let serviceFees = [];

    // Modal Biaya Pajak
    const addTaxFeeButton = document.getElementById("addTaxFeeButton");
    const taxFeeModalOverlay = document.getElementById("taxFeeModalOverlay");
    const taxFeeModal = document.getElementById("taxFeeModal");
    const closeTaxFeeModalBtn = document.getElementById("closeTaxFeeModalBtn");
    const saveTaxFeeBtn = document.getElementById("saveTaxFeeBtn");
    const taxFeeListContainer = document.getElementById("taxFeeListContainer");
    let taxFees = [];

    // --- Modal Biaya Layanan ---
    if (addServiceFeeButton) {
        addServiceFeeButton.addEventListener("click", () =>
            serviceFeeModalOverlay.classList.remove("hidden")
        );
    }
    if (closeServiceFeeModalBtn) {
        closeServiceFeeModalBtn.addEventListener("click", () =>
            serviceFeeModalOverlay.classList.add("hidden")
        );
    }
    if (serviceFeeModalOverlay) {
        serviceFeeModalOverlay.addEventListener("click", (e) => {
            if (e.target === serviceFeeModalOverlay) {
                serviceFeeModalOverlay.classList.add("hidden");
            }
        });
    }
    if (saveServiceFeeBtn) {
        saveServiceFeeBtn.addEventListener("click", () => {
            const shippingCostEl = document.getElementById("shippingCost");
            const includeShippingCostEl = document.getElementById(
                "includeShippingCost"
            );
            const serviceChargeEl = document.getElementById("serviceCharge");
            const includeServiceChargeEl = document.getElementById(
                "includeServiceCharge"
            );

            const newFee = {};
            if (
                shippingCostEl &&
                shippingCostEl.value &&
                includeShippingCostEl &&
                includeShippingCostEl.checked
            ) {
                newFee.shipping = parseFloat(shippingCostEl.value);
            }
            if (
                serviceChargeEl &&
                serviceChargeEl.value &&
                includeServiceChargeEl &&
                includeServiceChargeEl.checked
            ) {
                newFee.service = parseFloat(serviceChargeEl.value);
            }

            if (Object.keys(newFee).length > 0) {
                serviceFees.push(newFee);
                updateServiceFeeList();
            }
            if (shippingCostEl) shippingCostEl.value = "";
            if (serviceChargeEl) serviceChargeEl.value = "";
            serviceFeeModalOverlay.classList.add("hidden");
        });
    }

    function updateServiceFeeList() {
        if (!serviceFeeListContainer) return;
        serviceFeeListContainer.innerHTML = ""; // Clear existing list
        if (serviceFees.length === 0) {
            // Optionally, show a placeholder if no fees are added yet
            // serviceFeeListContainer.innerHTML = '<p class="text-sm text-gray-500">Belum ada biaya layanan ditambahkan.</p>';
        } else {
            serviceFees.forEach((fee, index) => {
                const feeDiv = document.createElement("div");
                feeDiv.className =
                    "p-3 bg-gray-100 rounded-lg text-sm text-gray-700 flex justify-between items-center";
                let feeText = "";
                if (fee.shipping !== undefined) {
                    feeText += `Biaya Pengiriman: Rp ${fee.shipping.toLocaleString()}`;
                }
                if (fee.service !== undefined) {
                    if (feeText) feeText += " | ";
                    feeText += `Biaya Layanan: ${fee.service}%`;
                }
                feeDiv.textContent = feeText || "Biaya tidak valid";
                // Add edit/delete buttons later if needed
                serviceFeeListContainer.appendChild(feeDiv);
            });
        }
    }

    // --- Modal Biaya Pajak ---
    if (addTaxFeeButton) {
        addTaxFeeButton.addEventListener("click", () =>
            taxFeeModalOverlay.classList.remove("hidden")
        );
    }
    if (closeTaxFeeModalBtn) {
        closeTaxFeeModalBtn.addEventListener("click", () =>
            taxFeeModalOverlay.classList.add("hidden")
        );
    }
    if (taxFeeModalOverlay) {
        taxFeeModalOverlay.addEventListener("click", (e) => {
            if (e.target === taxFeeModalOverlay) {
                taxFeeModalOverlay.classList.add("hidden");
            }
        });
    }
    if (saveTaxFeeBtn) {
        saveTaxFeeBtn.addEventListener("click", () => {
            const taxAmountEl = document.getElementById("taxAmount");
            if (taxAmountEl && taxAmountEl.value) {
                const newTax = { amount: parseFloat(taxAmountEl.value) };
                taxFees.push(newTax);
                updateTaxFeeList();
                taxAmountEl.value = "";
            }
            taxFeeModalOverlay.classList.add("hidden");
        });
    }

    function updateTaxFeeList() {
        if (!taxFeeListContainer) return;
        taxFeeListContainer.innerHTML = ""; // Clear existing list
        if (taxFees.length === 0) {
            // taxFeeListContainer.innerHTML = '<p class="text-sm text-gray-500">Belum ada biaya pajak ditambahkan.</p>';
        } else {
            taxFees.forEach((tax, index) => {
                const taxDiv = document.createElement("div");
                taxDiv.className =
                    "p-3 bg-gray-100 rounded-lg text-sm text-gray-700 flex justify-between items-center";
                taxDiv.textContent = `Biaya Pajak: ${tax.amount}%`;
                // Add edit/delete buttons later if needed
                taxFeeListContainer.appendChild(taxDiv);
            });
        }
    }

    // --- Settings Page Logic ---
    if (settingsSidebarButton) {
        settingsSidebarButton.addEventListener("click", (e) => {
            e.preventDefault();
            posViewContainer.classList.add("hidden");
            settingsPageContainer.classList.remove("hidden");
            // Highlight settings icon (optional)
            settingsSidebarButton.classList.add("bg-white/30");
            posViewButton.classList.remove("bg-white/30");
            // Activate default settings content
            activateSettingsContent("perhitunganBiayaContent");
            activateSettingsNavItem(
                document.querySelector(
                    '.settings-nav-item[data-content="perhitunganBiayaContent"]'
                )
            );
            activateSettingsTab("tabLayanan");
        });
    }

    if (posViewButton) {
        posViewButton.addEventListener("click", (e) => {
            e.preventDefault();
            settingsPageContainer.classList.add("hidden");
            posViewContainer.classList.remove("hidden");
            posViewButton.classList.add("bg-white/30");
            settingsSidebarButton.classList.remove("bg-white/30");
        });
    }

    settingsNavItems.forEach((item) => {
        item.addEventListener("click", (e) => {
            e.preventDefault();
            const contentId = item.dataset.content;
            activateSettingsContent(contentId);
            activateSettingsNavItem(item);
        });
    });

    function activateSettingsContent(contentId) {
        Object.values(settingsContentDivs).forEach((div) =>
            div.classList.add("hidden")
        );
        if (settingsContentDivs[contentId]) {
            settingsContentDivs[contentId].classList.remove("hidden");
        }
    }

    function activateSettingsNavItem(activeItem) {
        settingsNavItems.forEach((item) => item.classList.remove("active"));
        if (activeItem) {
            activeItem.classList.add("active");
        }
    }

    settingsTabs.forEach((tab) => {
        tab.addEventListener("click", () => activateSettingsTab(tab.id));
    });

    function activateSettingsTab(activeTabId) {
        settingsTabs.forEach((t) => {
            t.classList.remove("active-tab");
            t.classList.add("inactive-tab");
            if (settingsTabContents[t.dataset.target]) {
                settingsTabContents[t.dataset.target].classList.add("hidden");
            }
        });
        const activeTab = document.getElementById(activeTabId);
        if (activeTab) {
            activeTab.classList.add("active-tab");
            activeTab.classList.remove("inactive-tab");
            if (settingsTabContents[activeTab.dataset.target]) {
                settingsTabContents[activeTab.dataset.target].classList.remove(
                    "hidden"
                );
            }
        }
    }

    // --- Payment Modal Logic ---
    if (lanjutkanPembayaranBtn) {
        lanjutkanPembayaranBtn.addEventListener("click", () =>
            paymentModalOverlay.classList.remove("hidden")
        );
    }
    if (closePaymentModalBtn) {
        closePaymentModalBtn.addEventListener("click", () =>
            paymentModalOverlay.classList.add("hidden")
        );
    }
    if (cancelPaymentBtn) {
        cancelPaymentBtn.addEventListener("click", () =>
            paymentModalOverlay.classList.add("hidden")
        );
    }
    if (paymentModalOverlay) {
        paymentModalOverlay.addEventListener("click", (e) => {
            if (e.target === paymentModalOverlay) {
                // Clicked on overlay, not modal content
                paymentModalOverlay.classList.add("hidden");
            }
        });
    }

    if (submitPaymentBtn) {
        submitPaymentBtn.addEventListener("click", () => {
            // Logic for submitting payment
            paymentModalOverlay.classList.add("hidden");
            if (
                payNowContent.style.display !== "none" ||
                !payNowContent.classList.contains("hidden")
            ) {
                // Check if Pay Now is active
                paymentSuccessModalOverlay.classList.remove("hidden");
            }
        });
    }

    // --- Add Product Modal Logic ---
    if (addProductFromModalBtn) {
        addProductFromModalBtn.addEventListener("click", () =>
            addProductModalOverlay.classList.remove("hidden")
        );
    }
    if (closeAddProductModalBtn) {
        closeAddProductModalBtn.addEventListener("click", () =>
            addProductModalOverlay.classList.add("hidden")
        );
    }
    if (cancelAddProductBtn) {
        cancelAddProductBtn.addEventListener("click", () =>
            addProductModalOverlay.classList.add("hidden")
        );
    }
    if (addProductModalOverlay) {
        addProductModalOverlay.addEventListener("click", (e) => {
            if (e.target === addProductModalOverlay) {
                addProductModalOverlay.classList.add("hidden");
            }
        });
    }

    // --- Payment Success Modal Logic ---
    if (backToPosFromSuccessBtn) {
        backToPosFromSuccessBtn.addEventListener("click", () => {
            paymentSuccessModalOverlay.classList.add("hidden");
            // Add any other logic needed to reset POS or order state
        });
    }
    if (paymentSuccessModalOverlay) {
        paymentSuccessModalOverlay.addEventListener("click", (e) => {
            if (e.target === paymentSuccessModalOverlay) {
                paymentSuccessModalOverlay.classList.add("hidden");
            }
        });
    }

    // --- Pay Now / Pay Later Tabs Logic ---
    if (payNowTab) {
        payNowTab.addEventListener("click", () => {
            payNowContent.classList.remove("hidden");
            payLaterContent.classList.add("hidden");
            payNowTab.classList.replace(
                "order-type-inactive",
                "order-type-active"
            );
            payLaterTab.classList.replace(
                "order-type-active",
                "order-type-inactive"
            );
        });
    }
    if (payLaterTab) {
        payLaterTab.addEventListener("click", () => {
            payLaterContent.classList.remove("hidden");
            payNowContent.classList.add("hidden");
            payLaterTab.classList.replace(
                "order-type-inactive",
                "order-type-active"
            );
            payNowTab.classList.replace(
                "order-type-active",
                "order-type-inactive"
            );
        });
    }

    // Initialize default views
    if (posViewContainer && settingsPageContainer) {
        settingsPageContainer.classList.add("hidden"); // Start with POS view
        posViewContainer.classList.remove("hidden");
        if (posViewButton) posViewButton.classList.add("bg-white/30");
    }
    if (settingsContentDivs.perhitunganBiayaContent) {
        activateSettingsContent("perhitunganBiayaContent"); // Default to Perhitungan Biaya
    }
    if (
        document.querySelector(
            '.settings-nav-item[data-content="perhitunganBiayaContent"]'
        )
    ) {
        activateSettingsNavItem(
            document.querySelector(
                '.settings-nav-item[data-content="perhitunganBiayaContent"]'
            )
        );
    }
    activateSettingsTab("tabLayanan"); // Default to Layanan tab
    updateServiceFeeList(); // Initial call to display empty or existing fees
    updateTaxFeeList(); // Initial call
});
