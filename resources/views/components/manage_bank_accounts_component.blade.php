<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-center mt-2">
                <h4>{{$editable ? 'Edit Bank Account' : 'Manage Bank Accounts'}}</h4>
            </div>
            <div class="card-body">
                @if($errors->has('message'))
                    <div class="alert alert-danger text-center">
                        {{$errors->first('message')}}
                    </div>
                    <hr/>
                @endif
                @if (Session::has('message'))
                    <div class="alert alert-success text-center">
                        {{session('message')}}
                    </div>
                    <hr/>
                @endif
                @if($editable)
                    @if($entity == 'company')
                        <form method="POST" action="{{route('bank_account_edit_save', ['bank_account' =>
                        request()->query('bank_account')])}}">@endif
                            @if($entity == 'recipient')
                                <form method="POST" action="{{route('bank_account_edit_save', [
                                'bank_account' => request()->query('bank_account'),
                                'recipient' => request()->query('recipient'),
                                'company' => request()->query('company')])}}">@endif
                                    @csrf <!-- {{ csrf_field() }} -->
                                    @endif
                                    <div id="bank-accounts">
                                        @foreach($bank_accounts as $index=>$bank_account)
                                            @component('components.forms.bank_accounts_form_component', ['bank_account' => $bank_account,
                                                'mode' => $editable ? 'edit' : 'manage'])
                                            @endcomponent
                                            <hr/>
                                        @endforeach
                                    </div>
                                    @if($editable)
                                        <div class="row">
                                            <div class="col-lg-6">
                                                @if($entity == 'company')
                                                    <a href="{{route('bank_accounts',
                                            ['company' => $bank_accounts[0]['company_id']])}}"
                                                       class="btn btn-outline-secondary mt-2 w-100"> Back to Manage Bank
                                                        Accounts</a>
                                                @endif
                                                @if($entity == 'recipient')
                                                    <a href="{{route('bank_accounts',
                                            ['recipient' => $bank_accounts[0]['recipient_id'],
                                             'company' => request()->query('company')])}}"
                                                       class="btn btn-outline-secondary mt-2 w-100"> Back to Manage Bank
                                                        Accounts</a>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <button type="submit" class="btn btn-primary mt-2 w-100">Save Changes
                                                </button>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row">
                                            <div class="col-lg-6">
                                                @if($entity == 'company')
                                                    <a href="{{route('company_edit', ['company' => request()->query('company')])}}"
                                                       class="btn btn-outline-secondary mt-2 w-100">Back to Edit
                                                        Company</a>
                                                @endif
                                                @if($entity == 'recipient')
                                                    <a href="{{route('recipient_edit', ['company' => request()->query('company'),
                                            'recipient' => request()->query('recipient')])}}"
                                                       class="btn btn-outline-secondary mt-2 w-100">Back to Edit
                                                        Recipient</a>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <a data-bs-toggle="modal" data-bs-target="#bankAccountsModal"
                                                   class="btn btn-primary mt-2 w-100">Add New Bank Account</a>
                                            </div>
                                        </div>
                                    @endif
                                    @if($editable)
                                </form>
                    @endif
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/bankAccounts.js') }}"></script>

@if(session('manage_bank_accounts'))
    @component('components.bank_accounts_modal_component',
                                    ['bank_accounts' => $selected_company['bank_accounts'] ?? [], 'read_only' => false,
                                    'entity' => $entity])
    @endcomponent
@endif

