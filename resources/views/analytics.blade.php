<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Analytics - SaleTrackMate</title>
    <script src="{{asset('chartJS/chart.js')}}"></script>
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
                                    <h4 class="mt-1 mb-3 pb-1">Analytics</h4>
                                </div>
                                <hr/>
                                @if(isset($companies) && count($companies) > 0)
                                    @component('components.forms.select_company_form_component', [
                                        'companies' => $companies, 'selected_company' => $selected_company,
                                        'entity' => 'analytics'])
                                    @endcomponent
                                    <hr/>
                                @endif
                                <div class="card rounded-3 text-black border-0">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <canvas id="numberOfInvoicesChart" height="100%"></canvas>
                                        </div>
                                        <div class="col-lg-6">
                                            <canvas id="averageTotalPriceAmountChart" height="100%"></canvas>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <canvas id="theMostProfitableRecipientsChart" height="125%"></canvas>
                                        </div>
                                        <div class="col-lg-6">
                                            <canvas id="theMostLoyalRecipientsChart" height="125%"></canvas>
                                        </div>
                                    </div>
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
<script id="numberOfInvoicesData" data-number-of-invoices="{{ json_encode($number_of_invoices) }}"></script>
<script id="averageTotalPriceAmountData" data-total-price-amount="{{ json_encode($average_total_price) }}"></script>
<script id="theMostProfitableRecipientsLabelsData"
        data-the-most-profitable-recipients-labels="{{ json_encode($the_most_profitable_recipients_labels) }}"></script>
<script id="theMostProfitableRecipientsData"
        data-the-most-profitable-recipients="{{ json_encode($the_most_profitable_recipients) }}"></script>
<script id="theMostLoyalRecipientsData"
        data-the-most-loyal-recipients="{{ json_encode($the_most_loyal_recipients) }}"></script>
<script src="{{ asset('js/analytics.js') }}"></script>
</html>
