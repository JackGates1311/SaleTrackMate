<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Create Invoice - SaleTrackMate</title>
    @component('components.header_component')
    @endcomponent
</head>
<body>
@component('components.navbar_component', ['companies' => []])
@endcomponent
<div class="h-100 pt-5 d-flex flex-column">
    <div class="container mt-lg-4 mt-2 h-100">
        <div class="d-flex align-items-center justify-content-center" style="height: 50vh;">
            <div class="alert alert-danger" role="alert">
                <h3 class="alert-danger">Permission Denied Error</h3>
                <p>
                    Sorry, you do not have the required permissions to access this admin page. Please ensure you have
                    the necessary privileges or contact your administrator for assistance.
                </p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
