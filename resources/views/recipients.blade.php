<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Recipients - SaleTrackMate</title>
    @component('components.header_component')
    @endcomponent
</head>
<body>
@component('components.navbar_component')
@endcomponent
<section class="min-vh-100 gradient-form d-flex">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-12">
                <div class="card rounded-3 text-black border-0">
                    <div class="row g-0">
                        <div class="col-lg-12">
                            <div class="card-body p-3">
                                <div class="text-center">
                                    <h4 class="mt-1 mb-3 pb-1">Recipients</h4>
                                </div>
                                <hr/>
                                @if(isset($companies) && count($companies) > 0)
                                    @component('components.forms.select_company_form_component', [
                                        'companies' => $companies, 'selected_company' => $selected_company,
                                        'entity' => 'recipients'])
                                    @endcomponent
                                @endif
                                <hr/>
                                @if (Session::has('message'))
                                    <div
                                        class="alert alert-success text-center {{session('company_create') ? 'mt-1' : 'mt-3'}}">
                                        {{session('message')}}
                                    </div>
                                    <hr/>
                                @endif
                                @if($errors->has('message'))
                                    <div class="alert alert-danger text-center">
                                        {{$errors->first('message')}}
                                    </div>
                                    <hr/>
                                @endif
                                <div class="table-responsive pt-2">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th class="text-nowrap text-center table-header-cell">Company Name</th>
                                            <th class="text-nowrap text-center table-header-cell">Identification
                                                Information
                                            </th>
                                            <th class="text-nowrap text-center table-header-cell">Address</th>
                                            <th class="text-nowrap text-center table-header-cell">Contact Info</th>
                                            <th class="text-nowrap text-center table-header-cell">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($recipients['recipients']) && count($recipients['recipients']) > 0)
                                            @foreach($recipients['recipients'] as $i=>$recipient)
                                                <tr>
                                                    <td class="text-nowrap text-center text-middle">
                                                        {{ $recipient['name'] }}</td>
                                                    <td class="text-nowrap text-center text-middle">
                                                        Tax Code: {{ $recipient['tax_code'] }} <br>
                                                        Reg. ID: {{ $recipient['reg_id'] ?? '-' }} <br>
                                                        VAT ID: {{ $recipient['vat_id'] }}
                                                    </td>
                                                    <td class="text-center text-middle">
                                                        {{ $recipient['address'] }}, <br>
                                                        {{ $recipient['postal_code'] }}, {{ $recipient['place'] }},
                                                        {{ $recipient['country'] }}
                                                    </td>
                                                    <td class="text-nowrap text-center text-middle">
                                                        Phone: {{$recipient['phone_num'] ?? '-'}}
                                                        <br>
                                                        Fax: {{ $recipient['fax'] ?? '-'}} <br>
                                                        Email: {{ $recipient['email'] ?? '-'}}
                                                    </td>
                                                    <td class="text-nowrap text-center text-middle">
                                                        <div class="d-flex gap-3">
                                                            <a class="form-control btn-form-control text-center
                                                        cursor-pointer"
                                                               data-bs-toggle="modal"
                                                               data-bs-target="#bankAccountsModal{{$i}}">
                                                                <img src="{{ asset('images/res/credit_card.png') }}"
                                                                     alt="bank accounts"
                                                                     width="16"
                                                                     height="16"
                                                                     title="Show Bank Accounts">
                                                                <span class="visually-hidden">Bank Accounts</span>
                                                            </a>
                                                            <a class="form-control btn-form-control text-center
                                                        cursor-pointer"
                                                               href="{{route('recipient_edit',
                                                                ['recipient' => $recipient['id'],
                                                                'company' => request()->query('company')])}}">
                                                                <img src="{{ asset('images/res/edit.png') }}" alt="edit"
                                                                     width="16"
                                                                     height="16"
                                                                     title="Edit recipient">
                                                                <span class="visually-hidden">Edit</span>
                                                            </a>
                                                            <form class="w-100" method="POST"
                                                                  action="{{route('recipient_delete',
                                                                ['recipient' => $recipient['id'],
                                                                'company' => request()->query('company')])}}">
                                                                @csrf <!-- {{ csrf_field() }} -->
                                                                <button type="submit"
                                                                        class="form-control btn-form-control text-center
                                                                     cursor-pointer w-100">
                                                                    <img src="{{ asset('images/res/delete.png') }}"
                                                                         alt="delete" width="16"
                                                                         height="16" title="Delete Recipient">
                                                                    <span class="visually-hidden">Remove</span>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if(isset($recipient->bankAccounts) &&
                                                    count($recipient->bankAccounts) > 0)
                                                    @component('components.bank_accounts_modal_component',
                                                    ['bank_accounts' => $recipient->bankAccounts, 'read_only' => true,
                                                        'index' => $i])
                                                    @endcomponent
                                                @endif
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
