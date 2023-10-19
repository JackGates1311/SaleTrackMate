let activeTabIndex = 1;
let invoiceItemIndex = 1;
let numberOfTabs;

window.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById("invoice_date").value === null ||
        document.getElementById("invoice_date").value === "") {
        document.getElementById("invoice_date").valueAsDate = new Date();
        document.getElementById("invoice_date").min = new Date().toISOString().split("T")[0];
    }
});

window.addEventListener('DOMContentLoaded', () => {
    let dueDate = new Date();
    dueDate.setDate(dueDate.getDate() + 14);
    dueDate.setMinutes(dueDate.getMinutes() - dueDate.getTimezoneOffset());

    let todayDate = new Date();
    todayDate.setDate(todayDate.getDate());

    if (document.getElementById('due_date').value === null ||
        document.getElementById("due_date").value === "") {
        document.getElementById('due_date').value = dueDate.toISOString().slice(0, -8);
    }

    document.getElementById('due_date').min = todayDate.toISOString().slice(0, -8);

    if (document.getElementById('payment_deadline').value === null ||
        document.getElementById("payment_deadline").value === "") {
        document.getElementById('payment_deadline').value = dueDate.toISOString().slice(0, -8);
    }

    document.getElementById('payment_deadline').min = todayDate.toISOString().slice(0, -8);
});

window.addEventListener('DOMContentLoaded', () => {
    let deliveryDate = new Date();
    deliveryDate.setDate(deliveryDate.getDate());
    deliveryDate.setMinutes(deliveryDate.getMinutes() - deliveryDate.getTimezoneOffset());

    if (document.getElementById('delivery_date').value === null ||
        document.getElementById('delivery_date').value === "") {
        document.getElementById('delivery_date').value = deliveryDate.toISOString().slice(0, -8);
    }
});

function validateDates() {
    const invoiceDateInput = document.getElementById('invoice_date');
    const invoiceDateValue = new Date(invoiceDateInput.value);

    const dueDateInput = document.getElementById('due_date');
    const dueDateValue = new Date(dueDateInput.value);

    const paymentDeadlineInput = document.getElementById('payment_deadline');
    const paymentDeadlineValue = new Date(paymentDeadlineInput.value);

    const deliveryDateInput = document.getElementById('delivery_date');
    const deliveryDateValue = new Date(deliveryDateInput.value);
    new Date();

    if (dueDateValue < invoiceDateValue) {
        dueDateInput.value = invoiceDateValue.toISOString().slice(0, -8);
    }

    if (deliveryDateValue < invoiceDateValue) {
        deliveryDateInput.value = invoiceDateValue.toISOString().slice(0, -8);
    }

    if (deliveryDateValue > paymentDeadlineValue) {
        deliveryDateInput.value = paymentDeadlineValue.toISOString().slice(0, -8);
    }

    if (paymentDeadlineValue < invoiceDateValue || paymentDeadlineValue < dueDateValue) {
        paymentDeadlineInput.value = dueDateValue.toISOString().slice(0, -8);
    }
}

const invoiceDateInput = document.getElementById('invoice_date');
const deliveryDateInput = document.getElementById('delivery_date');
const dueDateInput = document.getElementById('due_date');
const paymentDeadlineInput = document.getElementById('payment_deadline');

invoiceDateInput.addEventListener('input', validateDates);
deliveryDateInput.addEventListener('input', validateDates);
dueDateInput.addEventListener('input', validateDates);
paymentDeadlineInput.addEventListener('input', validateDates);

window.onload = function () {
    let tabs = document.querySelectorAll("#tabs .nav-item");
    numberOfTabs = tabs.length;

    for (let i = 0; i < tabs.length; i++) {
        tabs[i].querySelector(".nav-link").addEventListener("click", function (event) {
            event.preventDefault();
            let tabIndex = parseInt(this.parentElement.id.replace("tabHeader_", ""), 10);
            goToTabByIndex(tabIndex);
        });
    }

    goToTabByIndex(1);
};

function activateNavLink(tabIndex) {
    let navLink = document.getElementById("tabHeader_" + tabIndex).querySelector(".nav-link");
    navLink.classList.add("active");
    navLink.setAttribute("aria-selected", "true");
}

function deactivateNavLinks() {
    let navLinks = document.querySelectorAll(".nav-link");
    navLinks.forEach(function (navLink) {
        navLink.classList.remove("active");
        navLink.setAttribute("aria-selected", "false");
    });
}

function displayTab(tabIndex) {
    deactivateNavLinks();
    activateNavLink(tabIndex);
    document.getElementById("tabpage_" + tabIndex).style.display = "block";
}

function hideTab(tabIndex) {
    document.getElementById("tabpage_" + tabIndex).style.display = "none";
}

function goToTabByDelta(deltaIndex) {
    let newIndex = activeTabIndex + deltaIndex;

    if (newIndex < 1) {
        newIndex = numberOfTabs;
    } else if (newIndex > numberOfTabs) {
        newIndex = 1;
    }

    goToTabByIndex(newIndex);
}

function goToTabByIndex(newActiveTabIndex) {
    hideTab(activeTabIndex);
    displayTab(newActiveTabIndex);
    activeTabIndex = newActiveTabIndex;

    const tabContainer = document.getElementById("tabs");
    const targetTab = tabContainer.children[newActiveTabIndex - 1].querySelector(".nav-link");

    if (targetTab) {
        targetTab.scrollIntoView({behavior: "auto", block: "nearest"});

        // Update the active tab based on the target tab.
        const activeTab = tabContainer.querySelector(".nav-link.active");
        activeTab.classList.remove("active");
        targetTab.classList.add("active");

        // Check if the new tab is the first or last tab
        if (newActiveTabIndex === 1) {
            document.getElementById("back-button").setAttribute("hidden", "");
            document.getElementById("next-button").removeAttribute("hidden");
            document.getElementById("save-button").setAttribute("hidden", "");
        } else if (newActiveTabIndex === numberOfTabs) {
            document.getElementById("back-button").removeAttribute("hidden");
            document.getElementById("next-button").setAttribute("hidden", "");
            document.getElementById("save-button").removeAttribute("hidden");
        } else {
            document.getElementById("back-button").removeAttribute("hidden");
            document.getElementById("next-button").removeAttribute("hidden");
            document.getElementById("save-button").setAttribute("hidden", "");
        }
    }
}

function addInvoiceItem() {
    const template = document.querySelector('.invoice-item').outerHTML;
    const newIndex = invoiceItemIndex++;
    const newTemplate = template.replace(/\[0]/g, `[${newIndex}]`);
    const container = document.createElement('div');
    container.innerHTML = newTemplate;
    document.getElementById('invoice-items').appendChild(container.firstChild);
}

function removeInvoiceItem(button) {
    let invoiceItemRow = button.closest('.invoice-item');
    if (document.querySelectorAll('.invoice-item').length > 1) {
        invoiceItemRow.remove();
    }
}

function validateForm() {
    const form = document.getElementById('create-invoice-form');
    if (form.checkValidity()) {
        form.submit();
    } else {
        const formControls = form.elements;
        for (let i = 0; i < formControls.length; i++) {
            if (formControls[i].nodeName === 'INPUT' && !formControls[i].checkValidity()) {
                alert(`Field: ${formControls[i].name} is invalid`);
                break;
            }
        }
    }
}

