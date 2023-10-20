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
                <div class="form-group pb-2">
                    @if(isset($companies) && count($companies) > 0)
                        @component('components.forms.select_company_form_component', ['companies' => $companies,
                            'selected_company' => $selected_company, 'entity' => 'companies'])
                        @endcomponent
                    @endif
                    @if($errors->has('message'))
                        <div class="alert alert-danger text-center {{session('company_create') ? 'mt-1' : 'mt-3'}}">
                            {{$errors->first('message')}}
                        </div>
                        <hr/>
                    @endif
                    @if (Session::has('message'))
                        <div class="alert alert-success text-center {{session('company_create') ? 'mt-1' : 'mt-3'}}">
                            {{session('message')}}
                        </div>
                        <hr/>
                    @endif
                </div>
                @if(!session('company_create') && !Session::has('message') && !$errors->has('message'))
                    <hr/>
                @endif
                <form accept-charset="UTF-8" action="{{ $selected_company ? route('company_edit_save',
                            ['company' => $selected_company['id']]) : route('create_company')}}" method="POST">
                    @csrf <!-- {{ csrf_field() }} -->
                    @component('components.forms.company_form_component', ['selected_company' => $selected_company])
                    @endcomponent
                    <hr/>
                    @if(session('company_create'))
                        <div id="bank-accounts">
                            @component('components.forms.bank_accounts_form_component', ['bank_account' => [],
                                'mode' => 'company_create'])
                            @endcomponent
                        </div>
                    @endif
                    @if(session('company_edit') || session('company_create'))
                        <div class="row">
                            <div class="{{session('company_edit') ? 'col-lg-6' : 'col-lg-4'}}">
                                <a href="{{route('companies', ['company' => request()->query('company')])}}"
                                   type="button" class="btn btn-outline-secondary mt-2 w-100"
                                   data-bs-dismiss="modal">Cancel</a>
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

@if(session('company_create'))
    <script src="{{ asset('js/bankAccounts.js') }}"></script>
@endif

@if(!session('company_create') && !session('company_edit') && request()->has('company'))
    @component('components.bank_accounts_modal_component',
                                ['bank_accounts' => $selected_company->toArray()['bank_accounts'] ??
                                    session('selected_company')->toArray()['bank_accounts'] ?? [], 'read_only' => true])
    @endcomponent
@endif
