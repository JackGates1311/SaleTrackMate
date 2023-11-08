window.addEventListener('DOMContentLoaded', () => {
    let priceExpirationDate = new Date();
    priceExpirationDate.setMonth(priceExpirationDate.getMonth() + 6);
    priceExpirationDate.setMinutes(priceExpirationDate.getMinutes() - priceExpirationDate.getTimezoneOffset());

    let todayDate = new Date();
    todayDate.setDate(todayDate.getDate());
    todayDate.setMinutes(todayDate.getMinutes() - todayDate.getTimezoneOffset());

    if (document.getElementById('price_expiration_date').value === null ||
        document.getElementById('price_expiration_date').value === "") {
        document.getElementById('price_expiration_date').value = priceExpirationDate.toISOString().slice(0, -8);
    }

    document.getElementById('price_expiration_date').min = todayDate.toISOString().slice(0, -8);

    if (document.getElementById('discount_from_date').value === null ||
        document.getElementById('discount_from_date').value === "") {
        document.getElementById('discount_from_date').value = todayDate.toISOString().slice(0, -8);
    }

    document.getElementById('discount_from_date').min = todayDate.toISOString().slice(0, -8);

    let priceDiscountDueDate = new Date();
    priceDiscountDueDate.setDate(priceDiscountDueDate.getDate() + 21);
    priceDiscountDueDate.setMinutes(priceDiscountDueDate.getMinutes() - priceDiscountDueDate.getTimezoneOffset());

    if (document.getElementById('discount_due_date').value === null ||
        document.getElementById('discount_due_date').value === "") {
        document.getElementById('discount_due_date').value = priceDiscountDueDate.toISOString().slice(0, -8);
    }

    document.getElementById('discount_due_date').min = todayDate.toISOString().slice(0, -8);
});

function validateDates() {
    const priceExpirationDateInput = document.getElementById('price_expiration_date');
    const discountFromDateInput = document.getElementById('discount_from_date');
    const discountDueDateInput = document.getElementById('discount_due_date');

    const priceExpirationDateValue = new Date(priceExpirationDateInput.value);
    const discountFromDateValue = new Date(discountFromDateInput.value);
    const discountDueDateValue = new Date(discountDueDateInput.value);

    const currentDate = new Date();
    currentDate.setMinutes(currentDate.getMinutes() - currentDate.getTimezoneOffset());

    if (priceExpirationDateValue < currentDate) {
        priceExpirationDateInput.value = currentDate.toISOString().slice(0, -8);
        priceExpirationDateInput.min = currentDate.toISOString().slice(0, -8);
    }

    if (discountFromDateInput) {
        if (discountFromDateValue < currentDate) {
            discountFromDateInput.value = currentDate.toISOString().slice(0, 16);
        }
    }

    if (discountDueDateInput) {
        if (discountDueDateValue < currentDate) {
            discountDueDateInput.value = currentDate.toISOString().slice(0, 16);
        }
        if (discountFromDateInput && discountFromDateValue > discountDueDateValue) {
            discountDueDateInput.value = discountFromDateInput.value;
        }
    }
}

const priceExpirationDate = document.getElementById('price_expiration_date');
const discountFromDate = document.getElementById('discount_from_date');
const discountDueDate = document.getElementById('discount_due_date');

priceExpirationDate.addEventListener('input', validateDates);
discountFromDate.addEventListener('input', validateDates);
discountDueDate.addEventListener('input', validateDates);

function showPriceDiscountFields() {
    const priceDiscountForm = document.getElementById('price-discount');

    priceDiscountForm.removeAttribute('hidden');

    const discountPercentageInput = document.getElementById('discount_percentage');
    const discountFromDateInput = document.getElementById('discount_from_date');
    const discountDueDateInput = document.getElementById('discount_due_date');

    discountPercentageInput.setAttribute('required', 'true');
    discountFromDateInput.setAttribute('required', 'true');
    discountDueDateInput.setAttribute('required', 'true');

    discountPercentageInput.setAttribute('name', 'price_discount[percentage]');
    discountFromDateInput.setAttribute('name', 'price_discount[from_date]');
    discountDueDateInput.setAttribute('name', 'price_discount[due_date]');

    const addPriceDiscountButton = document.getElementById('add-price-discount-button');
    addPriceDiscountButton.setAttribute('hidden', 'true');

    const removePriceDiscountButton = document.getElementById('remove-price-discount-button');
    removePriceDiscountButton.removeAttribute('hidden');
}

function removePriceDiscountFields() {
    const priceDiscountForm = document.getElementById('price-discount');

    priceDiscountForm.setAttribute('hidden', 'true');

    const discountPercentageInput = document.getElementById('discount_percentage');
    const discountFromDateInput = document.getElementById('discount_from_date');
    const discountDueDateInput = document.getElementById('discount_due_date');

    discountPercentageInput.removeAttribute('required');
    discountFromDateInput.removeAttribute('required');
    discountDueDateInput.removeAttribute('required');

    discountPercentageInput.removeAttribute('name');
    discountFromDateInput.removeAttribute('name');
    discountDueDateInput.removeAttribute('name');

    const addPriceDiscountButton = document.getElementById('add-price-discount-button');
    addPriceDiscountButton.removeAttribute('hidden');

    const removePriceDiscountButton = document.getElementById('remove-price-discount-button');
    removePriceDiscountButton.setAttribute('hidden', 'true');
}
