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
<div class="h-100 pt-5 d-flex flex-column gradient-form">
    <div class="container mt-lg-4 mt-2 h-100">
        <div id="tabContainer" class="tabContainer">
            <ul class="nav nav-tabs flex-nowrap" id="tabs"
                style="
                overflow-x: scroll !important;
                white-space: nowrap !important;
                overflow-y: hidden !important;">
                <li class="nav-item" id="tabHeader_1">
                    <a class="nav-link active" id="issuer-data-tab" href="#tabpage_1" role="tab"
                       aria-selected="true">Issuer Data</a>
                </li>
                @if(isset($issuer) && count($issuer) > 0)
                    <li class="nav-item" id="tabHeader_2">
                        <a class="nav-link" id="recipient-data-tab" href="#tabpage_2" role="tab"
                           aria-selected="false">Recipient Data</a>
                    </li>
                    <li class="nav-item" id="tabHeader_3">
                        <a class="nav-link" id="invoice-data-tab" href="#tabpage_3" role="tab"
                           aria-selected="false">Invoice Data</a>
                    </li>
                    <li class="nav-item" id="tabHeader_4">
                        <a class="nav-link" id="invoice-items-tab" href="#tabpage_4" role="tab"
                           aria-selected="false">Invoice Items</a>
                    </li>
                @endif
            </ul>
        </div>
        <form class="vh-100" accept-charset="UTF-8" action="#" method="POST">
            <div class="tab-content h-50" id="tabscontent">
                @csrf <!-- {{ csrf_field() }} -->
                <div class="tab-pane show active" id="tabpage_1" role="tabpanel">
                    @if(isset($issuer) && count($issuer) > 0)
                        @component('components.forms.invoice_issuer_form_component', ['issuer' => $issuer,
                                'bank_accounts' => $issuer['bank_accounts']])
                        @endcomponent
                    @else
                        <div class="d-flex align-items-center justify-content-center" style="height: 50vh;">
                            <div class="alert alert-danger" role="alert">
                                <h3 class="alert-danger">Internal Server Error</h3>
                                <p> Internal Server Error occurred while fetching issuer company data.
                                    Please try to refresh page and logout from system to resolve a problem.</p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="tab-pane" id="tabpage_2" role="tabpanel">
                    @component('components.forms.invoice_recipient_form_component', ['recipients' => $recipients])
                    @endcomponent
                </div>
                <div class="tab-pane" id="tabpage_3" role="tabpanel">
                    @component('components.forms.invoice_form_component', ['issuer' => $issuer])
                    @endcomponent
                </div>
                <div class="tab-pane" id="tabpage_4" role="tabpanel">
                    <h2>Page 4</h2>
                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the industry's standard dummy text ever since the 1500s.
                    </p>
                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the industry's standard dummy text ever since the 1500s.
                    </p>
                </div>
            </div>
            @if(isset($issuer) && count($issuer) > 0)
                <div class="d-flex w-100 justify-content-end align-content-end gap-2 card-header" role="group"
                     aria-label="Navigation Buttons">
                    <button type="button" class="btn btn-primary w-25" onclick="goToTabByDelta(-1)">Back</button>
                    <button type="button" class="btn btn-primary w-25" onclick="goToTabByDelta(1)">Next</button>
                </div>
            @endif
        </form>
    </div>
</div>
</body>

<script src="{{ asset('js/invoice.js') }}"></script>
</html>
