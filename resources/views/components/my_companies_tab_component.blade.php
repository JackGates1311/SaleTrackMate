<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-center mt-2">
                @if(session('company_edit'))
                    <h4>Edit Company</h4>
                @elseif(session('company_create'))
                    <h4>Create Company</h4>
                @else
                    <h4>My Companies</h4>
                @endif
            </div>
            <div class="card-body">
                @php
                    /**
                        * @var array $companies
                    */
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
                    @if(isset($companies) && count($companies) > 0)
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
                                    <a href="{{ session('company_edit') ?
                                    route('companies', ['company' => $selected_company['id']]) :
                                    route('company_edit', ['company' => $selected_company['id']]) }}"
                                       class="btn btn-primary mb-3 mb-lg-0 me-lg-2"
                                        {{ session('company_edit') ? 'hidden' : ''}}>
                                        Edit Company
                                    </a>
                                    <a href="{{ route('create_company_view', ['company' => 'default']) }}"
                                       class="btn btn-primary" {{ session('company_edit') ? 'hidden' : ''}}>
                                        Add New Company
                                    </a>
                                </div>
                            </div>

                            @if($errors->has('message'))
                                <div class="alert alert-danger mt-3">
                                    {{$errors->first('message')}}
                                </div>
                            @endif

                            @if (Session::has('message'))
                                <div class="alert alert-success mt-3">
                                    {{session('message')}}
                                </div>
                            @endif
                            <hr/>
                        </form>
                    @endif
                </div>

                <form accept-charset="UTF-8"
                      action="{{ $selected_company ?
                                    route('company_edit_save', ['company' => $selected_company['id']]) :
                                    route('create_company')}}"
                      method="POST">
                    @csrf <!-- {{ csrf_field() }} -->
                    <div class="row">
                        <div class="col-lg-4 col-sm-12 mb-3">
                            <label for="name" class="form-label">Company Name:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="{{ $selected_company ? $selected_company['name'] : '' }}"
                                   {{ session('company_edit') || session('company_create') ? '' : 'readonly'}} required>
                        </div>
                        <div class="col-lg-4 col-sm-6 mb-3">
                            <label for="company_id" class="form-label">Company ID:</label>
                            <input type="text" class="form-control" id="company_id" name="company_id"
                                   value="{{ $selected_company ? $selected_company['company_id'] : '' }}"
                                   {{ session('company_edit') || session('company_create') ? '' : 'readonly'}} required>
                        </div>
                        <div class="col-lg-4 col-sm-6 mb-3">
                            <label for="category" class="form-label">Category:</label>
                            <input type="text" class="form-control" id="category" name="category"
                                   value="{{ $selected_company ? $selected_company['category'] : '' }}"
                                   {{ session('company_edit') || session('company_create') ? '' : 'readonly'}} required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-sm-4 mb-3">
                            <label for="reg_id" class="form-label">Registration ID:</label>
                            <input type="text" class="form-control" id="reg_id" name="reg_id"
                                   value="{{ $selected_company ? $selected_company['reg_id'] : '' }}"
                                   {{ session('company_edit') || session('company_create') ? '' : 'readonly'}} required>
                        </div>
                        <div class="col-lg-4 col-sm-4 mb-3">
                            <label for="tax_code" class="form-label">Tax Code:</label>
                            <input type="text" class="form-control" id="tax_code" name="tax_code"
                                   value="{{ $selected_company ? $selected_company['tax_code'] : '' }}"
                                   {{ session('company_edit') || session('company_create') ? '' : 'readonly'}} required>
                        </div>
                        <div class="col-lg-4 col-sm-4 mb-3">
                            <label for="vat_id" class="form-label">VAT ID:</label>
                            <input type="text" class="form-control" id="vat_id" name="vat_id"
                                   value="{{ $selected_company ? $selected_company['vat_id'] : '' }}"
                                   {{ session('company_edit') || session('company_create') ? '' : 'readonly'}} required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2 col-sm-3 mb-3">
                            <label for="country" class="form-label">Country:</label>
                            <input type="text" class="form-control" id="country" name="country"
                                   value="{{ $selected_company ? $selected_company['country'] : '' }}"
                                   {{ session('company_edit') || session('company_create') ? '' : 'readonly'}} required>
                        </div>
                        <div class="col-lg-2 col-sm-4 mb-3">
                            <label for="postal_code" class="form-label">Postal Code:</label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code"
                                   value="{{ $selected_company ? $selected_company['postal_code'] : '' }}"
                                   {{ session('company_edit') || session('company_create') ? '' : 'readonly'}} required>
                        </div>
                        <div class="col-lg-4 col-sm-5 mb-3">
                            <label for="place" class="form-label">Place:</label>
                            <input type="text" class="form-control" id="place" name="place"
                                   value="{{ $selected_company ? $selected_company['place'] : '' }}"
                                   {{ session('company_edit') || session('company_create') ? '' : 'readonly'}} required>
                        </div>
                        <div class="col-lg-4 col-sm-12 mb-3">
                            <label for="address" class="form-label">Address:</label>
                            <input type="text" class="form-control" id="address" name="address"
                                   value="{{ $selected_company ? $selected_company['address'] : '' }}"
                                   {{ session('company_edit') || session('company_create') ? '' : 'readonly'}} required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-sm-12 mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   value="{{ $selected_company ? $selected_company['email'] : ''}}"
                                   {{ session('company_edit') || session('company_create') ? '' : 'readonly'}} required>
                        </div>
                        <div class="col-lg-4 col-sm-6 mb-3">
                            <label for="phone_num" class="form-label">Phone Number:</label>
                            <input type="text" class="form-control" id="phone_num" name="phone_num"
                                   value="{{ $selected_company ? $selected_company['phone_num'] : '' }}"
                                   {{ session('company_edit') || session('company_create') ? '' : 'readonly'}} required>
                        </div>
                        <div class="col-lg-4 col-sm-6 mb-3">
                            <label for="fax" class="form-label">Fax:</label>
                            <input type="text" class="form-control" id="fax" name="fax"
                                   value="{{ $selected_company ? $selected_company['fax'] : '' }}"
                                   {{ session('company_edit') || session('company_create') ? '' : 'readonly'}} required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="url" class="form-label">Website URL:</label>
                            <input type="text" class="form-control" id="url" name="url"
                                   value="{{ $selected_company ? $selected_company['url'] : '' }}"
                                   {{ session('company_edit') || session('company_create') ? '' : 'readonly'}} required>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="logo_url" class="form-label">Logo URL:</label>
                            <input type="text" class="form-control" id="logo_url" name="logo_url"
                                   value="{{ $selected_company ?  $selected_company['logo_url'] : '' }}"
                                   {{ session('company_edit') || session('company_create') ? '' : 'readonly'}} required>
                        </div>
                    </div>
                    <hr/>
                    @if(session('company_create'))

                        <div id="bank-accounts">
                            <!-- Bank Account Template -->
                            <div class="bank-account">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-12 mb-3">
                                        <label for="bank_identifier" class="form-label">Bank
                                            Identifier:</label>
                                        <input type="text" class="form-control" name="bank_accounts[0][bank_identifier]"
                                               id="bank_identifier" required>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <label for="bank_name" class="form-label">Bank Name:</label>
                                        <input id="bank_name" type="text" class="form-control"
                                               name="bank_accounts[0][name]"
                                               required>
                                    </div>
                                    <div class="col-lg-3 mb-3">
                                        <label for="iban" class="form-label">IBAN:</label>
                                        <input type="text" class="form-control" id="iban" name="bank_accounts[0][iban]"
                                               required>
                                    </div>
                                    <div class="col-lg-1 mb-3 d-flex justify-content-end align-items-end">
                                        <button class="form-control btn-form-control mt-1" type="button"
                                                onclick="removeBankAccount(this)">
                                            <img src="{{ asset('images/res/delete.png') }}" alt="delete" width="21"
                                                 height="21">
                                            <span class="visually-hidden">Remove</span>
                                        </button>
                                    </div>
                                </div>
                                <hr/>
                            </div>
                        </div>
                    @endif

                    @if(session('company_edit') || session('company_create'))
                        <div class="row">
                            <div class="{{session('company_edit') ? 'col-lg-6' : 'col-lg-4'}}">
                                @if(session('company_edit'))
                                    <a href="{{route('companies', ['company' => $selected_company['id']])}}"
                                       type="button" class="btn btn-outline-secondary mt-2 w-100"
                                       data-bs-dismiss="modal">Cancel</a>
                                @endif
                                @if(session('company_create'))
                                    <a href="{{route('companies', ['company' => 'default'])}}"
                                       type="button" class="btn btn-outline-secondary mt-2 w-100"
                                       data-bs-dismiss="modal">Cancel</a>
                                @endif

                            </div>
                            @if(session('company_create'))
                                <div class="col-lg-4">
                                    <a type="button" class="btn btn-primary mt-2 w-100" id="add-bank-account"
                                       onclick="addBankAccount()">
                                        Add Bank Account
                                    </a>
                                </div>
                            @endif
                            <div class="{{session('company_edit') ? 'col-lg-6' : 'col-lg-4'}}">
                                <button type="submit" class="btn btn-primary mt-2 w-100">
                                    {{$selected_company ? 'Save Changes' : 'Create Company'}}
                                </button>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

<script>
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
</script>

