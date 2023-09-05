<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-center mt-2">
                <h4>{{session('company_edit') ? 'Edit Company Data' : 'My Companies'}}</h4>
            </div>
            <div class="card-body">
                @php
                    session(['company_edit' => false]);
                    $selectedCompany = (object)[
                            'id' => 1,
                            'name' => 'Company A',
                            'tax_code' => '123456789',
                            'reg_id' => 'REG123',
                            'vat_id' => 'VAT456',
                            // Add other attributes here
                        ];

$companies = [
    (object)[
        'company_id' => 'ABC123',
        'tax_code' => '1234567890',
        'reg_id' => 'REG123',
        'vat_id' => 'VAT123',
        'name' => 'Company A',
        'category' => 'Technology',
        'country' => 'United States',
        'place' => 'New York',
        'postal_code' => '10001',
        'address' => '123 Main St, Apt 4B',
        'phone_num' => '(555) 555-1234',
        'fax' => '123-456-7890',
        'email' => 'companya@example.com',
        'url' => 'https://www.companya.com',
        'logo_url' => 'https://www.companya.com/logo.png',
    ],
    (object)[
        'company_id' => 'XYZ456',
        'tax_code' => '9876543210',
        'reg_id' => 'REG456',
        'vat_id' => 'VAT456',
        'name' => 'Company B',
        'category' => 'Finance',
        'country' => 'Canada',
        'place' => 'Toronto',
        'postal_code' => 'M5V 2L6',
        'address' => '456 Oak Street, Suite 200',
        'phone_num' => '(416) 555-7890',
        'fax' => '416-123-4567',
        'email' => 'companyb@example.com',
        'url' => 'https://www.companyb.ca',
        'logo_url' => 'https://www.companyb.ca/logo.png',
    ],
    // Add more company data as needed
];
                @endphp
                <div class="form-group pb-2">
                    <label class="mb-2" for="companySelect">Company:</label>
                    <div class="d-flex flex-column flex-lg-row justify-content-between w-100">
                        <select class="form-select mb-3 mb-lg-0 me-lg-2 w-100 w-lg-50" id="companySelect"
                                onchange="">
                            @foreach ($companies as $company)
                                <option value="{{ $company->company_id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                        <div
                            class="d-flex flex-column flex-lg-row justify-content-end justify-content-lg-end w-100 w-lg-50">
                            <a href="{{ session('company_edit') ? route('account') : route('invoices') }}"
                               class="btn btn-primary mb-3 mb-lg-0 me-lg-2" {{ session('company_edit') ? 'hidden' : ''}}>
                                Edit Company Data
                            </a>
                            <a href="{{ session('company_edit') ? route('account') : route('invoices') }}"
                               class="btn btn-primary">
                                Add New Company
                            </a>
                        </div>
                    </div>
                    <hr/>
                </div>

                @if ($selectedCompany)
                    <form method="POST" action="#">
                        @csrf

                        <div class="row">
                            <div class="col-lg-4 col-sm-12 mb-3">
                                <label for="name" class="form-label">Company Name:</label>
                                <input type="text" class="form-control" id="name" name="name"
                                       value="{{ $company->name }}" {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                            <div class="col-lg-4 col-sm-6 mb-3">
                                <label for="company_id" class="form-label">Company ID:</label>
                                <input type="text" class="form-control" id="company_id" name="company_id"
                                       value="{{ $company->company_id }}"
                                    {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                            <div class="col-lg-4 col-sm-6 mb-3">
                                <label for="category" class="form-label">Category:</label>
                                <input type="text" class="form-control" id="category" name="category"
                                       value="{{ $company->category }}" {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-sm-4 mb-3">
                                <label for="reg_id" class="form-label">Registration ID:</label>
                                <input type="text" class="form-control" id="reg_id" name="reg_id"
                                       value="{{ $company->reg_id }}" {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                            <div class="col-lg-4 col-sm-4 mb-3">
                                <label for="tax_code" class="form-label">Tax Code:</label>
                                <input type="text" class="form-control" id="tax_code" name="tax_code"
                                       value="{{ $company->tax_code }}" {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                            <div class="col-lg-4 col-sm-4 mb-3">
                                <label for="vat_id" class="form-label">VAT ID:</label>
                                <input type="text" class="form-control" id="vat_id" name="vat_id"
                                       value="{{ $company->vat_id }}" {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-2 col-sm-3 mb-3">
                                <label for="country" class="form-label">Country:</label>
                                <input type="text" class="form-control" id="country" name="country"
                                       value="{{ $company->country }}" {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                            <div class="col-lg-2 col-sm-4 mb-3">
                                <label for="postal_code" class="form-label">Postal Code:</label>
                                <input type="text" class="form-control" id="postal_code" name="postal_code"
                                       value="{{ $company->postal_code }}"
                                    {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                            <div class="col-lg-4 col-sm-5 mb-3">
                                <label for="place" class="form-label">Place:</label>
                                <input type="text" class="form-control" id="place" name="place"
                                       value="{{ $company->place }}" {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                            <div class="col-lg-4 col-sm-12 mb-3">
                                <label for="address" class="form-label">Address:</label>
                                <input type="text" class="form-control" id="address" name="address"
                                       value="{{ $company->address }}" {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-sm-12 mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       value="{{ $company->email }}" {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                            <div class="col-lg-4 col-sm-6 mb-3">
                                <label for="phone_num" class="form-label">Phone Number:</label>
                                <input type="text" class="form-control" id="phone_num" name="phone_num"
                                       value="{{ $company->phone_num }}" {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                            <div class="col-lg-4 col-sm-6 mb-3">
                                <label for="fax" class="form-label">Fax:</label>
                                <input type="text" class="form-control" id="fax" name="fax"
                                       value="{{ $company->fax }}" {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label for="url" class="form-label">Website URL:</label>
                                <input type="text" class="form-control" id="url" name="url"
                                       value="{{ $company->url }}" {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="logo_url" class="form-label">Logo URL:</label>
                                <input type="text" class="form-control" id="logo_url" name="logo_url"
                                       value="{{ $company->logo_url }}" {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                        </div>

                        @if(session('company_edit'))
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" class="btn btn-outline-secondary mt-2 w-100"
                                            data-bs-dismiss="modal">
                                        Cancel
                                    </button>
                                </div>
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary mt-2 w-100">Save Changes
                                    </button>
                                </div>
                            </div>
                        @endif

                    </form>

                @endif
            </div>
        </div>

    </div>
</div>
<script>
    function changeCompany(companyId) {
        window.location.href = '/companies/' + companyId;
    }
</script>
