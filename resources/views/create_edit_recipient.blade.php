<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{isset($recipient) ? 'Edit' : 'Add New'}} Recipient - SaleTrackMate</title>
    @component('components.header_component')
    @endcomponent
</head>
<body>
@component('components.navbar_component', ['companies' => []])
@endcomponent
<div class="min-vh-100 pt-5 d-flex flex-column gradient-form">
    <div class="container mt-lg-4 mt-2 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-12">
                <div class="card rounded-3 text-black border-0">
                    <div class="row g-0">
                        <div class="col-lg-12">
                            <div class="card-body p-3">
                                <div class="text-center">
                                    <h4 class="mt-1 mb-3 pb-1">
                                        @if(isset($recipient))
                                            Edit Recipient
                                        @else
                                            Add New Recipient
                                        @endif
                                    </h4>
                                </div>
                                <hr/>
                                @if(isset($recipient))
                                    <form accept-charset="UTF-8" action="{{ route('recipient_edit_save',
                                        ['company' => request()->query('company')]) }}" method="POST">@else
                                            <form accept-charset="UTF-8" action="{{ route('create_recipient',
                                        ['company_id' => request()->query('company')]) }}" method="POST">@endif
                                                @csrf <!-- {{ csrf_field() }} -->
                                                @if(isset($recipient))
                                                    <input type="hidden" name="recipient_id"
                                                           value="{{ $recipient['id'] }}">
                                                @endif
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-outline mb-4">
                                                            <label for="recipient_name" class="form-label">Recipient
                                                                Company
                                                                Name:</label>
                                                            <input type="text" class="form-control" id="recipient_name"
                                                                   name="name"
                                                                   placeholder="Recipient company name"
                                                                   value="{{isset($recipient) ? $recipient['name'] : old('name')}}"
                                                                   required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-outline mb-4">
                                                            <label for="recipient_tax_code" class="form-label">Recipient
                                                                Tax
                                                                Code:</label>
                                                            <input type="text" class="form-control"
                                                                   id="recipient_tax_code"
                                                                   name="tax_code"
                                                                   placeholder="Recipient tax code"
                                                                   value="{{isset($recipient) ? $recipient['tax_code'] :
                                                       old('tax_code')}}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-outline mb-4">
                                                            <label for="recipient_reg_id" class="form-label">Recipient
                                                                Registration
                                                                ID:</label>
                                                            <input type="text" class="form-control"
                                                                   id="recipient_reg_id"
                                                                   name="reg_id"
                                                                   placeholder="Recipient registration id (optional)"
                                                                   value="{{isset($recipient) ? $recipient['reg_id'] :
                                                       old('reg_id')}}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="form-outline mb-4">
                                                            <label for="recipient_vat_id" class="form-label">Recipient
                                                                VAT
                                                                ID:</label>
                                                            <input type="text" class="form-control"
                                                                   id="recipient_vat_id"
                                                                   name="vat_id"
                                                                   placeholder="Recipient VAT id"
                                                                   value="{{isset($recipient) ? $recipient['vat_id'] :
                                                       old('vat_id')}}"
                                                                   required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-outline mb-4">
                                                            @component('components.country_dropdown_component',
                                                                ['selected_country' =>
                                                                isset($recipient) ? $recipient['country'] : old('country')])
                                                            @endcomponent
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-outline mb-4">
                                                            <label for="recipient_place" class="form-label">Recipient
                                                                Place:</label>
                                                            <input type="text" class="form-control" id="recipient_place"
                                                                   name="place"
                                                                   value="{{isset($recipient) ? $recipient['place'] :
                                                       old('place')}}" placeholder="Recipient place"
                                                                   required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-outline mb-4">
                                                            <label for="recipient_postal_code" class="form-label">Recipient
                                                                Postal
                                                                Code:</label>
                                                            <input type="text" class="form-control"
                                                                   id="recipient_postal_code"
                                                                   name="postal_code"
                                                                   value="{{isset($recipient) ? $recipient['postal_code'] :
                                                       old('postal_code')}}" placeholder="Recipient postal code"
                                                                   required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-outline mb-4">
                                                            <label for="recipient_address" class="form-label">Recipient
                                                                Address:</label>
                                                            <input type="text" class="form-control"
                                                                   id="recipient_address"
                                                                   name="address"
                                                                   value="{{isset($recipient) ? $recipient['address'] :
                                                       old('address')}}" placeholder="Recipient address" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-outline mb-4">
                                                            <label for="recipient_email" class="form-label">Recipient
                                                                Email:</label>
                                                            <input type="email" class="form-control"
                                                                   id="recipient_email"
                                                                   name="email" value="{{isset($recipient) ? $recipient['email'] :
                                                       old('email')}}" placeholder="Recipient email (optional)">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-outline mb-4">
                                                            <label for="recipient_phone_num" class="form-label">Recipient
                                                                Phone
                                                                Number:</label>
                                                            <input type="text" class="form-control"
                                                                   id="recipient_phone_num"
                                                                   name="phone_num"
                                                                   value="{{isset($recipient) ? $recipient['phone_num'] :
                                                       old('phone_num')}}"
                                                                   placeholder="Recipient phone number (optional)">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-outline mb-4">
                                                            <label for="recipient_fax" class="form-label">Recipient
                                                                Fax:</label>
                                                            <input type="text" class="form-control" id="recipient_fax"
                                                                   name="fax"
                                                                   value="{{isset($recipient) ? $recipient['fax'] :old('fax')}}"
                                                                   placeholder="Recipient fax (optional)">
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr/>
                                                @if(!isset($recipient))
                                                    <div id="bank-accounts">
                                                        @component('components.forms.bank_accounts_form_component', ['bank_account' => [],
                                                            'mode' => 'recipient_create'])
                                                        @endcomponent
                                                    </div>
                                                @endif

                                                @if ($errors->has('message'))
                                                    <div class="alert alert-danger mb-4 text-center">
                                                        {{$errors->first('message')}}</div>
                                                @endif
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <a href="{{route('recipients', ['company' => request()->query('company')])}}"
                                                           type="button" class="btn btn-outline-secondary w-100"
                                                           data-bs-dismiss="modal">Cancel</a>
                                                    </div>
                                                    @if(isset($recipient))
                                                        <div class="col-lg-4">
                                                            <a href="{{route('bank_accounts', [
                                                    'recipient' => request()->query('recipient'),
                                                    'company' => request()->query('company')
                                                    ])}}" class="btn btn-primary w-100">
                                                                Manage Bank Accounts
                                                            </a>
                                                        </div>
                                                    @else
                                                        <div class="col-lg-4">
                                                            <a type="button" class="btn btn-primary w-100"
                                                               id="add-bank-account"
                                                               onclick="addBankAccount()">
                                                                Add Bank Account
                                                            </a>
                                                        </div>
                                                    @endif
                                                    <div class="col-lg-4">
                                                        <button
                                                            class="btn btn-primary btn-block fa-lg gradient-custom-2 w-100"
                                                            type="submit"> {{isset($recipient) ? 'Save' : 'Create'}}
                                                        </button>
                                                    </div>
                                                </div>
                                                @if(true)
                                            </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/bankAccounts.js') }}"></script>
</body>
</html>
