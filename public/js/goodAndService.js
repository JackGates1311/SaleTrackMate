function validateDates() {
    PriceModule.validateDates();
    PriceDiscountModule.validateDates();
}

document.getElementById('price_expiration_date').addEventListener('input', validateDates);
document.getElementById('discount_from_date').addEventListener('input', validateDates);
document.getElementById('discount_due_date').addEventListener('input', validateDates);

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
