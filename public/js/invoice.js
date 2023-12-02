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

function addInvoiceItem(invoiceItem) {
    const template = document.querySelector('.invoice-item').outerHTML;
    const newIndex = invoiceItemIndex++;
    const newTemplate = template.replace(/\[0]/g, `[${newIndex}]`);
    const container = document.createElement('div');
    container.innerHTML = newTemplate;

    if (invoiceItem != null) {

        let nameField;
        let unitField;
        let unitPriceField;
        let rebateField;
        let vatPercentageField;
        let imageUrlField;

        let isZeroIndex = false;

        if (document.querySelector(`[name="invoice_items[0][name]"]`) !== null &&
            document.querySelector(`[name="invoice_items[0][name]"]`).value === '' &&
            document.querySelector(`[name="invoice_items[0][unit]"]`).value === '' &&
            document.querySelector(`[name="invoice_items[0][unit_price]"]`).value === '0.01' &&
            document.querySelector(`[name="invoice_items[0][quantity]"]`).value === '1' &&
            document.querySelector(`[name="invoice_items[0][rebate]"]`).value === '0' &&
            document.querySelector(`[name="invoice_items[0][vat_percentage]"]`).value === '0' &&
            document.querySelector(`[name="invoice_items[0][image_url]"]`).value === '') {

            isZeroIndex = true;

            nameField = document.querySelector(`[name="invoice_items[0][name]"]`);
            unitField = document.querySelector(`[name="invoice_items[0][unit]"]`);
            unitPriceField = document.querySelector(`[name="invoice_items[0][unit_price]"]`);
            rebateField = document.querySelector(`[name="invoice_items[0][rebate]"]`);
            vatPercentageField = document.querySelector(
                `[name="invoice_items[0][vat_percentage]"]`);
            imageUrlField = document.querySelector(`[name="invoice_items[0][image_url]"]`);

        } else {
            nameField = container.querySelector(`[name="invoice_items[${newIndex}][name]"]`);
            unitField = container.querySelector(`[name="invoice_items[${newIndex}][unit]"]`);
            unitPriceField = container.querySelector(`[name="invoice_items[${newIndex}][unit_price]"]`);
            rebateField = container.querySelector(`[name="invoice_items[${newIndex}][rebate]"]`);
            vatPercentageField = container.querySelector(
                `[name="invoice_items[${newIndex}][vat_percentage]"]`);
            imageUrlField = container.querySelector(`[name="invoice_items[${newIndex}][image_url]"]`);
        }

        if (nameField) {
            nameField.value = invoiceItem.name;
        }

        if (unitField) {
            if (invoiceItem.unit_of_measure !== null) {
                unitField.value = invoiceItem.unit_of_measure.abbreviation !== undefined ?
                    invoiceItem.unit_of_measure.abbreviation : '';
            }
        }

        if (unitPriceField) {
            unitPriceField.value = invoiceItem.actual_price.amount !== undefined ? invoiceItem.actual_price.amount : '';
        }

        if (rebateField) {
            if (invoiceItem.actual_price_discount !== null) {
                rebateField.value = invoiceItem.actual_price_discount.percentage !== undefined
                    ? invoiceItem.actual_price_discount.percentage : '';
            }
        }

        if (vatPercentageField) {
            if (invoiceItem.tax_category !== null && invoiceItem.tax_category.actual_tax_rate.percentage_value !== null) {
                vatPercentageField.value = invoiceItem.tax_category.actual_tax_rate.percentage_value !== undefined ?
                    parseFloat(invoiceItem.tax_category.actual_tax_rate.percentage_value).toString() : '';
            }
        }

        if (imageUrlField) {
            if (invoiceItem.image_url !== null) {
                imageUrlField.value = invoiceItem.image_url !== undefined ? invoiceItem.image_url : ''
            }
        }

        if (!isZeroIndex) {
            document.getElementById('invoice-items').appendChild(container.firstChild);
        }
    } else {
        document.getElementById('invoice-items').appendChild(container.firstChild);
    }
}

function removeInvoiceItem(button) {
    let invoiceItemRow = button.closest('.invoice-item');
    if (!invoiceItemRow.querySelector(`[name$="[name]"]`).name.includes('[0]')) {
        if (document.querySelectorAll('.invoice-item').length > 1) {
            invoiceItemRow.remove();
        } else {
            alert("Invoice must have at least one invoice item");
        }
    } else {
        alert("First row can't be removed");
    }
}

/**
 * Populates recipient form fields with the provided recipient data.
 *
 * @param {Object|null} recipient - The recipient data.
 * @param {string} recipient.name - The name.
 * @param {string} recipient.tax_code - The tax code.
 * @param {string} recipient.reg_id - The registration ID.
 * @param {string} recipient.vat_id - The VAT ID.
 * @param {string} recipient.bank_name - The bank name.
 * @param {string} recipient.bank_iban - The bank IBAN.
 * @param {string} recipient.phone_num - The phone number.
 * @param {string} recipient.fax - The fax.
 * @param {string} recipient.country - The country.
 * @param {string} recipient.place - The place.
 * @param {string} recipient.postal_code - The postal code.
 * @param {string} recipient.address - The address.
 */
function selectRecipient(recipient) {
    const selectedOption = document.getElementById('recipientSelect').options[
        document.getElementById('recipientSelect').selectedIndex];
    recipient = JSON.parse(selectedOption.getAttribute('data-recipient'));

    document.getElementById('recipient_name').value = recipient.name;
    document.getElementById('recipient_tax_code').value = recipient.tax_code;
    document.getElementById('recipient_reg_id').value = recipient.reg_id || '';
    document.getElementById('recipient_vat_id').value = recipient.vat_id;
    document.getElementById('recipient_bank_name').value = recipient.bank_name || '';
    document.getElementById('recipient_bank_iban').value = recipient.bank_iban || '';
    document.getElementById('recipient_phone_num').value = recipient.phone_num || '';
    document.getElementById('recipient_fax').value = recipient.fax || '';
    document.getElementById('country').value = recipient.country;
    document.getElementById('recipient_place').value = recipient.place;
    document.getElementById('recipient_postal_code').value = recipient.postal_code;
    document.getElementById('recipient_address').value = recipient.address;

    let modal = bootstrap.Modal.getInstance(document.getElementById('selectRecipientModal'));
    modal.hide();
}

function clearRecipientFields() {
    document.getElementById('recipient_name').value = '';
    document.getElementById('recipient_tax_code').value = '';
    document.getElementById('recipient_reg_id').value = '';
    document.getElementById('recipient_vat_id').value = '';
    document.getElementById('recipient_bank_name').value = '';
    document.getElementById('recipient_bank_iban').value = '';
    document.getElementById('recipient_phone_num').value = '';
    document.getElementById('recipient_fax').value = '';
    document.getElementById('country').value = 'AF';
    document.getElementById('recipient_place').value = '';
    document.getElementById('recipient_postal_code').value = '';
    document.getElementById('recipient_address').value = '';

    const recipientSelect = document.getElementById('recipientSelect');
    if (recipientSelect) {
        recipientSelect.selectedIndex = 0;
    }
}

/**
 * Populates recipient form fields with the provided recipient data.
 *
 * @param {Object|null} invoiceItem - The invoiceItem data.
 * @param {string} invoiceItem.name - The name.
 * @param {string} invoiceItem.actual_price_discount.percentage - The actual price discount percentage.
 * @param {string} invoiceItem.image_url - The image url.
 * @param {string} invoiceItem.actual_tax_rate - The actual tax rate.
 * @param {string|null} invoiceItem.unit_of_measure.abbreviation - The unit of measure.
 * @param {string} invoiceItem.actual_price - The actual price.
 * @param {string|null} invoiceItem.tax_category - The tax category.
 * @param {string} invoiceItem.actual_tax_rate.percentage_value - The actual tax rate percentage value.
 */
function selectInvoiceItem(invoiceItem) {
    const selectedOption = document.getElementById('invoiceItemSelect').options[
        document.getElementById('invoiceItemSelect').selectedIndex];
    invoiceItem = JSON.parse(selectedOption.getAttribute('data-invoice-item'));

    addInvoiceItem(invoiceItem);

    const invoiceItemSelect = document.getElementById('invoiceItemSelect');
    if (invoiceItemSelect) {
        invoiceItemSelect.selectedIndex = 0;
    }

    let modal = bootstrap.Modal.getInstance(document.getElementById('selectInvoiceItemModal'));
    modal.hide();
}
