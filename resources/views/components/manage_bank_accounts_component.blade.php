<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-center mt-2">
                <h4>Manage Bank Accounts</h4>
            </div>
            <div class="card-body">
                <form accept-charset="UTF-8"
                      action="#"
                      method="POST">
                    @csrf <!-- {{ csrf_field() }} -->
                    <div id="bank-accounts">
                        @foreach($bank_accounts as $index=>$bank_account)
                            @component('components.bank_accounts_form_component', ['bank_account' => $bank_account,
                                'editable' => true])
                            @endcomponent
                            <hr/>
                        @endforeach
                    </div>
                    <div class="row">
                        <div>
                            <a href="{{route('company_edit', ['company', request()->query('company')])}}"
                               class="btn btn-primary">Back to Edit Company</a>
                            <a href="{{route('company_edit', ['company', request()->query('company')])}}"
                               class="btn btn-primary">Add New Bank Account</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
