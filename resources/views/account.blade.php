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
                <a class="nav-link active" id="my-account-tab" data-bs-toggle="tab" href="#profile" role="tab"
                   aria-controls="profile" aria-selected="true">
                    My Account</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="my-companies-tab" data-bs-toggle="tab" href="#settings" role="tab"
                   aria-controls="settings" aria-selected="false">
                    My Companies</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabsContent">
            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="my-account-tab">
                @component('components.my_account_tab_component')
                @endcomponent
            </div>
            <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="my-companies-tab">
                @component('components.my_companies_tab_component')
                @endcomponent
            </div>
        </div>
    </div>
</div>
</body>
</html>
