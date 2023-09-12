<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Account Settings - SaleTrackMate</title>
    @component('components.header_component')
    @endcomponent
</head>
<body>
@component('components.navbar_component')
@endcomponent

<div class="vh-100 d-flex flex-column gradient-form">
    <div class="container mt-lg-4 mt-2">
        <ul class="nav nav-tabs" id="myTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link {{request()->has('company') ? '' : 'active'}}"
                   id="my-account-tab" data-bs-toggle="tab" role="tab" href="#profile"
                   aria-controls="profile" onclick="window.location.href = '{{ route('account') }}'"
                   aria-selected="true">My Account</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{!request()->has('company') ? '' : 'active'}}"
                   id="my-companies-tab" data-bs-toggle="tab" role="tab" aria-controls="settings"
                   aria-selected="false" href="#companies"
                   @if ($companies && count($companies) > 0)
                       onclick="window.location.href =
                    '{{ route('companies', ['company' => $companies[0]['id']]) }}'" @endif
                >My Companies</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabsContent">
            <div class="tab-pane fade {{request()->has('company') ? '' : 'show active'}}" id="profile"
                 role="tabpanel" aria-labelledby="my-account-tab">
                @component('components.my_account_tab_component')
                @endcomponent
            </div>
            <div class="tab-pane fade {{!request()->has('company') ? '' : 'show active'}}" id="companies"
                 role="tabpanel" aria-labelledby="my-companies-tab">
                @component('components.my_companies_tab_component', ['companies' => $companies])
                @endcomponent
            </div>
        </div>
    </div>
</div>
</body>
</html>
