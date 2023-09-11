<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-center mt-2">
                <h4>{{session('company_edit') ? 'Edit Company Data' : 'My Companies'}}</h4>
            </div>
            <div class="card-body">
                @php
                    /**
                        * @var array $companies
                    */

                    session(['company_edit' => false]);
                    $selected_company_id = request('company');
                    if(isset($companies) && count($companies) > 0) {
                        $selected_company = $companies[0];

                    } else {
                        $selected_company = null;
                    }

                    foreach ($companies as $company) {
                        if ($company['id'] === $selected_company_id) {
                            $selected_company = $company;
                            break;
                        }
                    }
                @endphp
                <div class="form-group pb-2">
                    <form method="GET">
                        <label class="mb-2" for="companySelect">Company:</label>
                        <div class="d-flex flex-column flex-lg-row justify-content-between w-100">
                            <select class="form-select mb-3 mb-lg-0 me-lg-2" id="companySelect"
                                    name="company" onchange="this.form.submit()">
                                @foreach ($companies as $company)
                                    <option value="{{ $company['id'] }}"
                                        {{ $selected_company_id === $company['id'] ? 'selected' : '' }}>
                                        {{ $company['name'] }}
                                    </option>
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
                    </form>
                </div>

                @if ($selected_company)
                    <form method="POST" action="#">
                        @csrf

                        <div class="row">
                            <div class="col-lg-4 col-sm-12 mb-3">
                                <label for="name" class="form-label">Company Name:</label>
                                <input type="text" class="form-control" id="name" name="name"
                                       value="{{ $selected_company['name'] }}" {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                            <div class="col-lg-4 col-sm-6 mb-3">
                                <label for="company_id" class="form-label">Company ID:</label>
                                <input type="text" class="form-control" id="company_id" name="company_id"
                                       value="{{ $selected_company['company_id'] }}"
                                    {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                            <div class="col-lg-4 col-sm-6 mb-3">
                                <label for="category" class="form-label">Category:</label>
                                <input type="text" class="form-control" id="category" name="category"
                                       value="{{ $selected_company['category'] }}" {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-sm-4 mb-3">
                                <label for="reg_id" class="form-label">Registration ID:</label>
                                <input type="text" class="form-control" id="reg_id" name="reg_id"
                                       value="{{ $selected_company['reg_id'] }}" {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                            <div class="col-lg-4 col-sm-4 mb-3">
                                <label for="tax_code" class="form-label">Tax Code:</label>
                                <input type="text" class="form-control" id="tax_code" name="tax_code"
                                       value="{{ $selected_company['tax_code'] }}" {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                            <div class="col-lg-4 col-sm-4 mb-3">
                                <label for="vat_id" class="form-label">VAT ID:</label>
                                <input type="text" class="form-control" id="vat_id" name="vat_id"
                                       value="{{ $selected_company['vat_id'] }}" {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-2 col-sm-3 mb-3">
                                <label for="country" class="form-label">Country:</label>
                                <input type="text" class="form-control" id="country" name="country"
                                       value="{{ $selected_company['country'] }}" {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                            <div class="col-lg-2 col-sm-4 mb-3">
                                <label for="postal_code" class="form-label">Postal Code:</label>
                                <input type="text" class="form-control" id="postal_code" name="postal_code"
                                       value="{{ $selected_company['postal_code'] }}"
                                    {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                            <div class="col-lg-4 col-sm-5 mb-3">
                                <label for="place" class="form-label">Place:</label>
                                <input type="text" class="form-control" id="place" name="place"
                                       value="{{ $selected_company['place'] }}" {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                            <div class="col-lg-4 col-sm-12 mb-3">
                                <label for="address" class="form-label">Address:</label>
                                <input type="text" class="form-control" id="address" name="address"
                                       value="{{ $selected_company['address'] }}" {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-sm-12 mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       value="{{ $selected_company['email'] }}" {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                            <div class="col-lg-4 col-sm-6 mb-3">
                                <label for="phone_num" class="form-label">Phone Number:</label>
                                <input type="text" class="form-control" id="phone_num" name="phone_num"
                                       value="{{ $selected_company['phone_num'] }}" {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                            <div class="col-lg-4 col-sm-6 mb-3">
                                <label for="fax" class="form-label">Fax:</label>
                                <input type="text" class="form-control" id="fax" name="fax"
                                       value="{{ $selected_company['fax'] }}" {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label for="url" class="form-label">Website URL:</label>
                                <input type="text" class="form-control" id="url" name="url"
                                       value="{{ $selected_company['url'] }}" {{ session('company_edit') ? '' : 'readonly'}}>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="logo_url" class="form-label">Logo URL:</label>
                                <input type="text" class="form-control" id="logo_url" name="logo_url"
                                       value="{{ $selected_company['logo_url'] }}" {{ session('company_edit') ? '' : 'readonly'}}>
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
