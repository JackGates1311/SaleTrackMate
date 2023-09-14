<div class="modal fade" id="showBankAccountsModal" tabindex="-1"
     aria-labelledby="showBankAccountsModal"
     aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-center" data-bs-dismiss="modal">
                <h5 class="modal-title w-100" id="showBankAccountModalLabel">Bank Accounts</h5>
            </div>
            <div class="modal-body">
                <div id="bank-accounts">
                    @foreach($bank_accounts as $index=>$bank_account)
                        @component('components.bank_accounts_form_component', ['bank_account' => $bank_account,
                            'editable' => false])
                        @endcomponent
                        @if(!$loop->last)
                            <hr/>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary w-25" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
