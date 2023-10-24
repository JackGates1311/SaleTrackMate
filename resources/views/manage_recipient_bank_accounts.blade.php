<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Recipient Bank Accounts - SaleTrackMate</title>
    @component('components.header_component')
    @endcomponent
</head>
<body>
@component('components.navbar_component', ['companies' => []])
@endcomponent
<div class="min-vh-100 pt-5 d-flex flex-column gradient-form">
    <div class="container mt-lg-4 mt-2 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            @if(isset($bank_accounts) && count($bank_accounts) > 0)
                @component('components.manage_bank_accounts_component',
                    ['bank_accounts' => $bank_accounts, 'editable' => session('edit_bank_account'),
                    'entity' => 'recipient'])
                @endcomponent
            @endif
        </div>
    </div>
</div>
</body>
</html>
