<!-- Recipient Company Information -->
<div class="text-center">
    <h4 class="m-3">Invoice Recipient Data</h4>
</div>
<hr/>
<div class="d-flex w-100 justify-content-end align-content-end gap-2" role="group">
    <a type="button" class="btn btn-primary" id="select-recipient" onclick="clearRecipientFields()">
        Clear
    </a>
    <a type="button" class="btn btn-primary" id="select-recipient" data-bs-toggle="modal"
       data-bs-target="#selectRecipientModal">
        Select Recipient
    </a>
</div>
<hr/>
<div class="row">
    <div class="col-lg-3">
        <div class="form-outline mb-4">
            <label for="recipient_name" class="form-label">Recipient Company Name:</label>
            <input type="text" class="form-control" id="recipient_name" name="recipient[name]"
                   placeholder="Recipient company name" value="{{old('recipient.name')}}" required>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-outline mb-4">
            <label for="recipient_tax_code" class="form-label">Recipient Tax Code:</label>
            <input type="text" class="form-control" id="recipient_tax_code" name="recipient[tax_code]"
                   placeholder="Recipient tax code" value="{{old('recipient.tax_code')}}" required>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-outline mb-4">
            <label for="recipient_reg_id" class="form-label">Recipient Registration ID:</label>
            <input type="text" class="form-control" id="recipient_reg_id" name="recipient[reg_id]"
                   placeholder="Recipient registration id (optional)" value="{{old('recipient.reg_id')}}">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-outline mb-4">
            <label for="recipient_vat_id" class="form-label">Recipient VAT ID:</label>
            <input type="text" class="form-control" id="recipient_vat_id" name="recipient[vat_id]"
                   placeholder="Recipient VAT id" value="{{old('recipient.vat_id')}}" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-3">
        <div class="form-outline mb-4">
            <label for="recipient_bank_name" class="form-label">Recipient Bank Name:</label>
            <input type="text" class="form-control" id="recipient_bank_name" name="recipient[bank_name]"
                   placeholder="Recipient bank name (optional)" value="{{old('recipient.bank_name')}}">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-outline mb-4">
            <label for="recipient_bank_iban" class="form-label">Recipient Bank IBAN:</label>
            <input type="text" class="form-control" id="recipient_bank_iban" name="recipient[bank_iban]"
                   placeholder="Recipient bank IBAN (optional)" value="{{old('recipient.bank_iban')}}">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-outline mb-4">
            <label for="recipient_phone_num" class="form-label">Recipient Phone Number:</label>
            <input type="text" class="form-control" id="recipient_phone_num" name="recipient[phone_num]"
                   value="{{old('recipient.phone_num')}}" placeholder="Recipient phone number (optional)">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-outline mb-4">
            <label for="recipient_fax" class="form-label">Recipient Fax:</label>
            <input type="text" class="form-control" id="recipient_fax" name="recipient[fax]"
                   value="{{old('recipient.fax')}}" placeholder="Recipient fax (optional)">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-3">
        <div class="form-outline mb-4">
            @component('components.country_dropdown_component',
                ['selected_country' => old('recipient.country') != "" ? old('recipient.country') : 'AF',
                'entity' => 'recipient[]'])
            @endcomponent
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-outline mb-4">
            <label for="recipient_place" class="form-label">Recipient Place:</label>
            <input type="text" class="form-control" id="recipient_place" name="recipient[place]"
                   value="{{old('recipient.place')}}" placeholder="Recipient place" required>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-outline mb-4">
            <label for="recipient_postal_code" class="form-label">Recipient Postal Code:</label>
            <input type="text" class="form-control" id="recipient_postal_code" name="recipient[postal_code]"
                   value="{{old('recipient.postal_code')}}" placeholder="Recipient postal code" required>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-outline mb-4">
            <label for="recipient_address" class="form-label">Recipient Address:</label>
            <input type="text" class="form-control" id="recipient_address" name="recipient[address]"
                   value="{{old('recipient.address')}}" placeholder="Recipient address" required>
        </div>
    </div>
</div>
@component('components.select_recipient_modal_component', ['recipient_list' => $recipient_list])
@endcomponent
