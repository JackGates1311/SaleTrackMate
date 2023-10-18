<!-- Recipient Company Information -->
<div class="text-center">
    <h4 class="m-3">Invoice Recipient Data</h4>
</div>
<hr/>
<!-- component('components.forms.select_recipient_form_component', ['recipients' => $recipients])
endcomponent !-->
<div class="row">
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="recipient_name" class="form-label">Recipient Company Name:</label>
            <input type="text" class="form-control" id="recipient_name" name="recipient[name]"
                   placeholder="Recipient company name" value="" required>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="recipient_bank_name" class="form-label">Recipient Bank Name:</label>
            <input type="text" class="form-control" id="recipient_bank_name" name="recipient[bank_name]"
                   placeholder="Recipient bank name (optional)" value="">
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="recipient_bank_iban" class="form-label">Recipient Bank IBAN:</label>
            <input type="text" class="form-control" id="recipient_bank_iban" name="recipient[bank_iban]"
                   placeholder="Recipient bank IBAN (optional)" value="">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="recipient_tax_code" class="form-label">Recipient Tax Code:</label>
            <input type="text" class="form-control" id="recipient_tax_code" name="recipient[tax_code]"
                   placeholder="Recipient tax code" value="" required>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="recipient_reg_id" class="form-label">Recipient Registration ID:</label>
            <input type="text" class="form-control" id="recipient_reg_id" name="recipient[reg_id]"
                   placeholder="Recipient registration id (optional)" value="">
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="recipient_vat_id" class="form-label">Recipient VAT ID:</label>
            <input type="text" class="form-control" id="recipient_vat_id" name="recipient[vat_id]"
                   placeholder="Recipient VAT id" value="" required>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-3">
        <div class="form-outline mb-4">
            <label for="recipient_country" class="form-label">Recipient Country:</label>
            @component('components.country_dropdown_component',
                ['selected_country' => null, 'entity' => 'recipient[]'])
            @endcomponent
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-outline mb-4">
            <label for="recipient_place" class="form-label">Recipient Place:</label>
            <input type="text" class="form-control" id="recipient_place" name="recipient[place]"
                   value="" placeholder="Recipient place" required>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-outline mb-4">
            <label for="recipient_postal_code" class="form-label">Recipient Postal Code:</label>
            <input type="text" class="form-control" id="recipient_postal_code" name="recipient[postal_code]"
                   value="" placeholder="Recipient postal code" required>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-outline mb-4">
            <label for="recipient_address" class="form-label">Recipient Address:</label>
            <input type="text" class="form-control" id="recipient_address" name="recipient[address]"
                   value="" placeholder="Recipient address" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="form-outline mb-4">
            <label for="recipient_phone_num" class="form-label">Recipient Phone Number:</label>
            <input type="text" class="form-control" id="recipient_phone_num" name="recipient[phone_num]"
                   value="" placeholder="Recipient phone number (optional)">
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-outline mb-4">
            <label for="recipient_fax" class="form-label">Recipient Fax:</label>
            <input type="text" class="form-control" id="recipient_fax" name="recipient[fax]"
                   value="" placeholder="Recipient fax (optional)">
        </div>
    </div>
</div>
