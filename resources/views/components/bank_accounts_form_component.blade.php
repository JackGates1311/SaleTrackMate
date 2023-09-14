<div class="bank-account">
    <div class="row">
        <div class="{{$editable ? 'col-xl-3' : 'col-xl-4'}} col-md-12 col-sm-12 mb-3">
            <label for="bank_identifier" class="form-label">Bank
                Identifier:</label>
            <input type="text" class="form-control" name="bank_accounts[0][bank_identifier]"
                   id="bank_identifier" placeholder="Company bank identifier"
                   value="{{$bank_account['bank_identifier']}}"
                   required readonly>
        </div>
        <div class="{{$editable ? 'col-xl-3' : 'col-xl-4'}} col-md-12 col-sm-12 mb-3">
            <label for="bank_name" class="form-label">Bank Name:</label>
            <input id="bank_name" type="text" class="form-control"
                   name="bank_accounts[0][name]" placeholder="Company bank name"
                   value="{{$bank_account['name']}}" required readonly>
        </div>
        <div class="col-xl-4 col-md-12 col-sm-12 mb-3">
            <label for="iban" class="form-label">IBAN:</label>
            <input type="text" class="form-control" id="iban" name="bank_accounts[0][iban]"
                   placeholder="Company bank iban" value="{{$bank_account['iban']}}"
                   required readonly>
        </div>
        @if($editable)
            <div class="col-xl-1 mb-xl-3 d-flex justify-content-end align-items-end">
                <button class="form-control btn-form-control mt-1" type="button"
                        href="{{route('bank_account_edit')}}">
                    <img src="{{ asset('images/res/edit.png') }}" alt="delete" width="21"
                         height="21">
                    <span class="visually-hidden">Edit</span>
                </button>
            </div>
            <div class="col-xl-1 mb-xl-3 mt-sm-3 d-flex justify-content-end align-items-end">
                <button class="form-control btn-form-control mt-1" type="button"
                        onclick="removeBankAccount(this)">
                    <img src="{{ asset('images/res/delete.png') }}" alt="delete" width="21"
                         height="21">
                    <span class="visually-hidden">Remove</span>
                </button>
            </div>
        @endif
    </div>
</div>

@if($editable)
    <script src="{{ asset('js/bankAccounts.js') }}"></script>
@endif
