<div class="bank-account">
    <div class="row">
        <div class="{{$mode == "manage" ? 'col-xl-3' : 'col-xl-4'}} col-md-12 col-sm-12 mb-3">
            <label for="bank_identifier" class="form-label">Bank
                Identifier:</label>
            <input type="text" class="form-control" name="bank_accounts[0][bank_identifier]"
                   id="bank_identifier" placeholder="Company bank identifier"
                   value="{{($mode == "create" || $mode == "company_create" || $mode == "recipient_create") ?
                    old('bank_identifier') : $bank_account['bank_identifier']}}"
                   required {{($mode == "edit" || $mode == "create" || $mode == "company_create" ||
                    $mode == "recipient_create")  ? '' : 'readonly'}}>
        </div>
        <div
            class="{{($mode == "manage" || $mode == "company_create" || $mode == "recipient_create") ?
                    'col-xl-3' : 'col-xl-4'}} col-md-12 col-sm-12 mb-3">
            <label for="bank_name" class="form-label">Bank Name:</label>
            <input id="bank_name" type="text" class="form-control"
                   name="bank_accounts[0][name]" placeholder="Company bank name"
                   value="{{($mode == "create" || $mode == "company_create" || $mode == "recipient_create") ?
                    old('bank_name') :  $bank_account['name']}}"
                   required {{($mode == "edit" || $mode == "create" || $mode == "company_create" ||
                    $mode == "recipient_create") ? '' : 'readonly'}}>
        </div>
        <div class="col-xl-4 col-md-12 col-sm-12 mb-3">
            <label for="iban" class="form-label">IBAN:</label>
            <input type="text" class="form-control" id="iban" name="bank_accounts[0][iban]"
                   placeholder="Company bank iban"
                   value="{{($mode == "create" || $mode == "company_create" || $mode == "recipient_create") ?
                    old('bank_account') : $bank_account['iban']}}"
                   required {{($mode == "edit" || $mode == "create" || $mode == "company_create"
                    || $mode == "recipient_create") ? '' : 'readonly'}}>
        </div>
        @if($mode == "company_create" || $mode == "recipient_create")
            <div class="col-xl-1 mb-3 d-flex justify-content-end align-items-end">
                <button class="form-control btn-form-control mt-1" type="button"
                        onclick="removeBankAccount(this)">
                    <img src="{{ asset('images/res/delete.png') }}" alt="delete" width="21"
                         height="21">
                    <span class="visually-hidden">Remove</span>
                </button>
            </div>
        @endif
        @if($mode == "manage")
            <div class="col-xl-1 mb-xl-3 d-flex justify-content-center align-items-end">
                <a class="form-control btn-form-control mt-1 text-center"
                   href="{{route('bank_account_edit', ['bank_account' => $bank_account['id'],
                    'company' => request()->query('company'), 'recipient' => request()->query('recipient')])}}">
                    <img src="{{ asset('images/res/edit.png') }}" alt="edit"
                         width="21"
                         height="21">
                    <span class="visually-hidden">Edit</span>
                </a>
            </div>
            <div class="col-xl-1 mb-xl-3 mt-sm-3 d-flex justify-content-end align-items-end">
                <form class="w-100" method="POST" action="{{route('bank_account_delete', [
                        'bank_account' => $bank_account['id'], 'company' => request()->query('company'),
                        'recipient' => request()->query('recipient')])}}">
                    @csrf <!-- {{ csrf_field() }} -->
                    <button type="submit" class="form-control btn-form-control mt-1 text-center w-100">
                        <img src="{{ asset('images/res/delete.png') }}" alt="delete" width="21"
                             height="21">
                        <span class="visually-hidden">Remove</span>
                    </button>
                </form>
            </div>
        @endif
    </div>
    @if($mode == "company_create" || $mode == "recipient_create")
        <hr/>
    @endif
</div>
