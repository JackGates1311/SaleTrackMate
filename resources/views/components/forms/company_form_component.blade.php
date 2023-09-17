<div class="row">
    <div class="col-lg-4 col-sm-12 mb-3">
        <label for="name" class="form-label">Company Name:</label>
        <input type="text" class="form-control" id="name" name="name"
               value="{{ $selected_company ? $selected_company['name'] : '' }}"
               {{ session('company_edit') || session('company_create') ? '' : 'readonly'}}
               placeholder="Company name" required>
    </div>
    <div class="col-lg-4 col-sm-6 mb-3">
        <label for="company_id" class="form-label">Company ID:</label>
        <input type="text" class="form-control" id="company_id" name="company_id"
               value="{{ $selected_company ? $selected_company['company_id'] : '' }}"
               {{ session('company_edit') || session('company_create') ? '' : 'readonly'}}
               placeholder="Company id" required>
    </div>
    <div class="col-lg-4 col-sm-6 mb-3">
        <label for="category" class="form-label">Category:</label>
        <input type="text" class="form-control" id="category" name="category"
               value="{{ $selected_company ? $selected_company['category'] : '' }}"
               {{ session('company_edit') || session('company_create') ? '' : 'readonly'}}
               placeholder="Company category" required>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-sm-4 mb-3">
        <label for="reg_id" class="form-label">Registration ID:</label>
        <input type="text" class="form-control" id="reg_id" name="reg_id"
               value="{{ $selected_company ? $selected_company['reg_id'] : '' }}"
               {{ session('company_edit') || session('company_create') ? '' : 'readonly'}}
               placeholder="Company reg. id (optional)">
    </div>
    <div class="col-lg-4 col-sm-4 mb-3">
        <label for="tax_code" class="form-label">Tax Code:</label>
        <input type="text" class="form-control" id="tax_code" name="tax_code"
               value="{{ $selected_company ? $selected_company['tax_code'] : '' }}"
               {{ session('company_edit') || session('company_create') ? '' : 'readonly'}}
               placeholder="Company tax code" required>
    </div>
    <div class="col-lg-4 col-sm-4 mb-3">
        <label for="vat_id" class="form-label">VAT ID:</label>
        <input type="text" class="form-control" id="vat_id" name="vat_id"
               value="{{ $selected_company ? $selected_company['vat_id'] : '' }}"
               {{ session('company_edit') || session('company_create') ? '' : 'readonly'}}
               placeholder="Company vat id (optional)">
    </div>
</div>

<div class="row">
    <div class="col-lg-2 col-sm-3 mb-3">
        @if(session('company_create'))
            @component('components.country_dropdown_component',
                ['selected_country' => null])
            @endcomponent
        @elseif(session('company_edit'))
            @component('components.country_dropdown_component',
                ['selected_country' => $selected_company['country']])
            @endcomponent
        @else
            <label for="country" class="form-label">Country:</label>
            <input type="text" class="form-control" id="country" name="country"
                   value="{{ $selected_company ? $selected_company['country'] : '' }}"
                   {{ session('company_edit') || session('company_create') ? '' : 'readonly'}}
                   placeholder="Company country" required>
        @endif
    </div>
    <div class="col-lg-2 col-sm-4 mb-3">
        <label for="postal_code" class="form-label">Postal Code:</label>
        <input type="text" class="form-control" id="postal_code" name="postal_code"
               value="{{ $selected_company ? $selected_company['postal_code'] : '' }}"
               {{ session('company_edit') || session('company_create') ? '' : 'readonly'}}
               placeholder="Company postal code" required>
    </div>
    <div class="col-lg-4 col-sm-5 mb-3">
        <label for="place" class="form-label">Place:</label>
        <input type="text" class="form-control" id="place" name="place"
               value="{{ $selected_company ? $selected_company['place'] : '' }}"
               {{ session('company_edit') || session('company_create') ? '' : 'readonly'}}
               placeholder="Company place" required>
    </div>
    <div class="col-lg-4 col-sm-12 mb-3">
        <label for="address" class="form-label">Address:</label>
        <input type="text" class="form-control" id="address" name="address"
               value="{{ $selected_company ? $selected_company['address'] : '' }}"
               {{ session('company_edit') || session('company_create') ? '' : 'readonly'}}
               placeholder="Company address" required>
    </div>
</div>
<div class="row">
    <div class="col-lg-4 col-sm-12 mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" class="form-control" id="email" name="email"
               value="{{ $selected_company ? $selected_company['email'] : ''}}"
               {{ session('company_edit') || session('company_create') ? '' : 'readonly'}}
               placeholder="Company email (optional)">
    </div>
    <div class="col-lg-4 col-sm-6 mb-3">
        <label for="phone_num" class="form-label">Phone Number:</label>
        <input type="text" class="form-control" id="phone_num" name="phone_num"
               value="{{ $selected_company ? $selected_company['phone_num'] : '' }}"
               {{ session('company_edit') || session('company_create') ? '' : 'readonly'}}
               placeholder="Company phone number (optional)">
    </div>
    <div class="col-lg-4 col-sm-6 mb-3">
        <label for="fax" class="form-label">Fax:</label>
        <input type="text" class="form-control" id="fax" name="fax"
               value="{{ $selected_company ? $selected_company['fax'] : '' }}"
               {{ session('company_edit') || session('company_create') ? '' : 'readonly'}}
               placeholder="Company fax (optional)">
    </div>
</div>
<div class="row">
    <div class="col-lg-6 mb-3">
        <label for="url" class="form-label">Website URL:</label>
        <input type="text" class="form-control" id="url" name="url"
               value="{{ $selected_company ? $selected_company['url'] : '' }}"
               {{ session('company_edit') || session('company_create') ? '' : 'readonly'}}
               placeholder="Company website (optional)">
    </div>
    <div class="col-lg-6 mb-3">
        <label for="logo_url" class="form-label">Logo URL:</label>
        <input type="text" class="form-control" id="logo_url" name="logo_url"
               value="{{ $selected_company ?  $selected_company['logo_url'] : '' }}"
               {{ session('company_edit') || session('company_create') ? '' : 'readonly'}}
               placeholder="Company logo (optional)">
    </div>
</div>
