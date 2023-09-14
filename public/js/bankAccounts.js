let bankAccountIndex = 1;

function addBankAccount() {
    const template = document.querySelector('.bank-account').outerHTML;
    const newIndex = bankAccountIndex++;
    const newTemplate = template.replace(/\[0]/g, `[${newIndex}]`);
    const container = document.createElement('div');
    container.innerHTML = newTemplate;
    document.getElementById('bank-accounts').appendChild(container.firstChild);
}

function removeBankAccount(button) {
    let bankAccountRow = button.closest('.bank-account');
    if (document.querySelectorAll('.bank-account').length > 1) {
        bankAccountRow.remove();
    }
}
