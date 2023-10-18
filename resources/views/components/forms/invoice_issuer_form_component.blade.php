<!-- Issuer Company Information (Read-Only) -->
<div class="text-center">
    <h4 class="m-3">Invoice Issuer Data</h4>
</div>
<hr/>

<div class="row">
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="issuer_name" class="form-label">Issuer Company Name:</label>
            <input type="text" class="form-control" id="issuer_name"
                   value="{{ $issuer['name'] }}" placeholder="Issuer company name" required readonly>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="issuer_website_url" class="form-label">Issuer Website URL:</label>
            <input type="text" class="form-control" id="issuer_website_url"
                   value="{{ $issuer['url'] }}" placeholder="Issuer website URL (optional)" readonly>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="issuer_bank_account"> Issuer Bank account: </label>
            <select class="form-select mt-2" id="issuer_bank_account" name="issuer_bank_account">
                @foreach ($bank_accounts as $bank_account)
                    <option value="{{ $bank_account['id'] }}">
                        {{$bank_account['name']}} - {{$bank_account['iban']}}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="issuer_tax_code" class="form-label">Issuer Tax Code:</label>
            <input type="text" class="form-control" id="issuer_tax_code"
                   value="{{ $issuer['tax_code'] }}" placeholder="Issuer tax code" required readonly>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="issuer_registration_id" class="form-label">Issuer Registration ID:</label>
            <input type="text" class="form-control" id="issuer_registration_id"
                   value="{{ $issuer['reg_id'] }}" placeholder="Issuer registration id (optional)" readonly>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="issuer_vat_id" class="form-label">Issuer VAT ID:</label>
            <input type="text" class="form-control" id="issuer_vat_id"
                   value="{{ $issuer['vat_id'] }}" placeholder="Issuer VAT id (optional)" readonly>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-2">
        <div class="form-outline mb-4">
            <label for="issuer_country" class="form-label">Issuer Country:</label>
            <input type="text" class="form-control" id="issuer_country"
                   value="{{ $issuer['country'] }}" placeholder="Issuer country" required readonly>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-outline mb-4">
            <label for="issuer_place" class="form-label">Issuer Place:</label>
            <input type="text" class="form-control" id="issuer_place"
                   value="{{ $issuer['place'] }}" placeholder="Issuer place" required readonly>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-outline mb-4">
            <label for="issuer_postal_code" class="form-label">Issuer Postal Code:</label>
            <input type="text" class="form-control" id="issuer_postal_code"
                   value="{{ $issuer['postal_code'] }}" placeholder="Issuer postal code" required readonly>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="issuer_address" class="form-label">Issuer Address:</label>
            <input type="text" class="form-control" id="issuer_address"
                   value="{{ $issuer['address'] }}" placeholder="Issuer address" required readonly>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="issuer_phone_num" class="form-label">Issuer Phone Number:</label>
            <input type="text" class="form-control" id="issuer_phone_num"
                   value="{{ $issuer['phone_num'] }}" placeholder="Issuer phone number (optional)" readonly>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="issuer_fax" class="form-label">Issuer Fax:</label>
            <input type="text" class="form-control" id="issuer_fax"
                   value="{{ $issuer['fax'] }}" placeholder="Issuer fax (optional)" readonly>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="issuer_email" class="form-label">Issuer Email:</label>
            <input type="email" class="form-control" id="issuer_email"
                   value="{{ $issuer['email'] }}" placeholder="Issuer email (optional)" readonly>
        </div>
    </div>
</div>
