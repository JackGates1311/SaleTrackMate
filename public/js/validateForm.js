function validateForm(formId) {
    let form = document.getElementById(formId);
    if (form.checkValidity()) {
        form.submit();
    } else {
        let formControls = form.elements;
        for (let i = 0; i < formControls.length; i++) {
            if ((formControls[i].nodeName === 'INPUT' || formControls[i].nodeName === 'SELECT') &&
                formControls[i].name && !formControls[i].checkValidity()) {
                alert(`Field ${formControls[i].name} is invalid`);
                break;
            }
        }
    }
}
