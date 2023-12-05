function handleTimePeriodChange(url) {
    let select = document.getElementById('timePeriodSelect');
    let selectedValue = select.options[select.selectedIndex].value;
    url += '&period=' + selectedValue;
    window.location.href = url;
}

let numberOfInvoices = JSON.parse(document.getElementById('numberOfInvoicesData').getAttribute(
    'data-number-of-invoices'));

let averageTotalPriceAmount = JSON.parse(document.getElementById('averageTotalPriceAmountData').getAttribute(
    'data-total-price-amount'));

let theMostProfitableRecipientsLabels = JSON.parse(document.getElementById(
    'theMostProfitableRecipientsLabelsData').getAttribute('data-the-most-profitable-recipients-labels'));

let theMostProfitableRecipients = JSON.parse(document.getElementById(
    'theMostProfitableRecipientsData').getAttribute('data-the-most-profitable-recipients'));

let theMostLoyalRecipients = JSON.parse(document.getElementById(
    'theMostLoyalRecipientsData').getAttribute('data-the-most-loyal-recipients'));

let labelsData = [];

const urlParams = new URLSearchParams(window.location.search);

const periodParam = urlParams.get('period');

if (periodParam === 'yearly' || periodParam === undefined || periodParam === null) {
    labelsData = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October',
        'November', 'December'];
}

if (periodParam === 'monthly') {
    const daysInCurrentMonth = new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0).getDate();
    for (let i = 1; i <= daysInCurrentMonth; i++) {
        labelsData[i - 1] = i;
    }
}

if (periodParam === 'weekly') {
    labelsData = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
}

if (periodParam === 'daily') {
    labelsData = ['0'];
    for (let i = 1; i <= 23; i++) {
        labelsData.push(i.toString() + ' h');
    }
}

const numberOfInvoicesCtx = document.getElementById('numberOfInvoicesChart').getContext('2d');

new Chart(numberOfInvoicesCtx, {
    type: 'line',
    data: {
        labels: labelsData,
        datasets: [{
            label: 'Number of Invoices',
            data: numberOfInvoices,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 2
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

const averageTotalPriceAmountChartCtx = document.getElementById('averageTotalPriceAmountChart').getContext(
    '2d');

new Chart(averageTotalPriceAmountChartCtx, {
    type: 'line',
    data: {
        labels: labelsData,
        datasets: [{
            label: 'Average Invoices Amount',
            data: averageTotalPriceAmount,
            backgroundColor: 'rgba(192,75,75,0.2)',
            borderColor: 'rgb(192,75,75)',
            borderWidth: 2
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

const theMostProfitableRecipientsChartCtx =
    document.getElementById('theMostProfitableRecipientsChart').getContext('2d');

new Chart(theMostProfitableRecipientsChartCtx, {
    type: 'bar',
    data: {
        labels: Object.values(theMostProfitableRecipientsLabels),
        datasets: [{
            label: 'The most profitable recipients',
            data: theMostProfitableRecipients,
            backgroundColor: 'rgba(192,186,75,0.2)',
            borderColor: 'rgb(162,189,37)',
            borderWidth: 2
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

const theMostLoyalRecipientsChartCtx =
    document.getElementById('theMostLoyalRecipientsChart').getContext('2d');

new Chart(theMostLoyalRecipientsChartCtx, {
    type: 'bar',
    data: {
        labels: Object.values(theMostProfitableRecipientsLabels),
        datasets: [{
            label: 'The most loyal recipients',
            data: theMostLoyalRecipients,
            backgroundColor: 'rgba(192,120,75,0.2)',
            borderColor: 'rgb(192,120,75)',
            borderWidth: 2
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
