<div class="modal fade" id="bankAccountsModal" tabindex="-1"
     aria-labelledby="bankAccountsModal"
     aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-center" data-bs-dismiss="modal">
                <h5 class="modal-title w-100" id="bankAccountModalLabel">
                    {{$read_only ? 'Bank Accounts' : 'Add new Bank Account'}}</h5>
            </div>
            <div class="modal-body">
                @if(!$read_only)
                    <form method="POST" action="{{route('create_bank_account', ['company' =>
                        request()->query('company')])}}">
                        @csrf <!-- {{ csrf_field() }} -->
                        @endif
                        <div id="bank-accounts">
                            @foreach($bank_accounts as $index=>$bank_account)
                                @component('components.bank_accounts_form_component', ['bank_account' => $bank_account,
                                    'mode' => 'read'])
                                @endcomponent
                                @if(!$loop->last)
                                    <hr/>
                                @endif
                            @endforeach
                            @if(!$read_only)
                                @component('components.bank_accounts_form_component', ['bank_account' => [],
                                    'mode' => 'create'])
                                @endcomponent
                            @endif
                        </div>
                        @if(!$read_only)
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" class="btn btn-outline-secondary mt-2 w-100"
                                            data-bs-dismiss="modal">
                                        Cancel
                                    </button>
                                </div>
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary mt-2 w-100">Save
                                    </button>
                                </div>
                            </div>
                    </form>
                @endif
            </div>
            @if($read_only)
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary w-25" data-bs-dismiss="modal">Close</button>
                </div>
            @endif
        </div>
    </div>
</div>
