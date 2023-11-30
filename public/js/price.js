window.addEventListener('DOMContentLoaded', () => {
    let priceExpirationDate = new Date();
    priceExpirationDate.setMonth(priceExpirationDate.getMonth() + 6);
    priceExpirationDate.setMinutes(priceExpirationDate.getMinutes() - priceExpirationDate.getTimezoneOffset());

    let tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    tomorrow.setMinutes(tomorrow.getMinutes() - tomorrow.getTimezoneOffset());

    let todayDate = new Date();
    todayDate.setDate(todayDate.getDate());
    todayDate.setMinutes(todayDate.getMinutes() - todayDate.getTimezoneOffset());

    if (document.getElementById('price_expiration_date').value === null ||
        document.getElementById('price_expiration_date').value === "") {
        document.getElementById('price_expiration_date').value = priceExpirationDate.toISOString().slice(0, -8);
        document.getElementById('price_expiration_date').min = tomorrow.toISOString().slice(0, -8);
    } else {
        document.getElementById('price_expiration_date').min =
            document.getElementById('price_expiration_date').value;
    }

});

let PriceModule = {
    validateDates: function () {
        const priceExpirationDateInput = document.getElementById('price_expiration_date');
        const priceExpirationDateValue = new Date(priceExpirationDateInput.value);

        const currentDate = new Date();
        currentDate.setMinutes(currentDate.getMinutes() - currentDate.getTimezoneOffset());

        if (priceExpirationDateValue < currentDate) {
            priceExpirationDateInput.value = currentDate.toISOString().slice(0, -8);
            priceExpirationDateInput.min = currentDate.toISOString().slice(0, -8);
        }
    },
};

document.getElementById('price_expiration_date').addEventListener('input', PriceModule.validateDates);
