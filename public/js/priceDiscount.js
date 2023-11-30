window.addEventListener('DOMContentLoaded', () => {
    let todayDate = new Date();
    todayDate.setDate(todayDate.getDate());
    todayDate.setMinutes(todayDate.getMinutes() - todayDate.getTimezoneOffset());

    if (document.getElementById('discount_from_date').value === null ||
        document.getElementById('discount_from_date').value === "") {
        document.getElementById('discount_from_date').value = todayDate.toISOString().slice(0, -8);
        document.getElementById('discount_from_date').min = todayDate.toISOString().slice(0, -8);
    } else {
        document.getElementById('discount_from_date').min =
            document.getElementById('discount_from_date').value;
    }


    let priceDiscountDueDate = new Date();
    priceDiscountDueDate.setDate(priceDiscountDueDate.getDate() + 21);
    priceDiscountDueDate.setMinutes(priceDiscountDueDate.getMinutes() - priceDiscountDueDate.getTimezoneOffset());

    if (document.getElementById('discount_due_date').value === null ||
        document.getElementById('discount_due_date').value === "") {
        document.getElementById('discount_due_date').value = priceDiscountDueDate.toISOString().slice(0, -8);
        document.getElementById('discount_due_date').min = todayDate.toISOString().slice(0, -8);
    } else {
        document.getElementById('discount_due_date').min =
            document.getElementById('discount_due_date').value;
    }

});

let PriceDiscountModule = {
    validateDates: function () {
        const discountFromDateInput = document.getElementById('discount_from_date');
        const discountDueDateInput = document.getElementById('discount_due_date');

        const discountFromDateValue = new Date(discountFromDateInput.value);
        const discountDueDateValue = new Date(discountDueDateInput.value);

        const currentDate = new Date();
        currentDate.setMinutes(currentDate.getMinutes() - currentDate.getTimezoneOffset());

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
    },
};

document.getElementById('discount_from_date').addEventListener('input',
    PriceDiscountModule.validateDates);
document.getElementById('discount_due_date').addEventListener('input',
    PriceDiscountModule.validateDates);
