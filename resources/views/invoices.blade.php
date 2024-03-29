<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Invoices - SaleTrackMate</title>
    @component('components.header_component')
    @endcomponent
</head>
<body>
@component('components.navbar_component', ['companies' => $companies])
@endcomponent

<div class="vh-100 d-flex flex-column gradient-form">
    <div class="container mt-3 flex-grow-1">
        <div class="row bg-white">
            <div class="col-lg-4">
                <div class="search-form">
                    <form class="invoice-search-form mb-4" action="{{route('invoices_search', [
                        'company' => request()->query('company'),
                        'invoice' => request()->query('invoice'),
                        'year' => request()->query('year')])}}" method="POST">
                        @csrf <!-- {{ csrf_field() }} -->
                        <label for="search"></label>
                        <div class="input-group">
                            <input type="text" id="search" name="search" class="form-control"
                                   placeholder="Search for invoices" value="{{$search}}">
                            <button type="submit" class="btn btn-primary">
                                <img src="{{ asset('images/res/search.png') }}" alt="arrow_forward" width="24"
                                     height="24">
                            </button>
                        </div>
                    </form>
                    <a href="{{route('create_invoice', ['company' => request()->query('company')])}}"
                       class="btn btn-primary btn-block gradient-custom-2 w-100 mb-3">Create
                        New Invoice</a>
                    @if (Session::has('message'))
                        <div class="alert alert-success mb-2">
                            {{session('message')}}</div>
                    @endif
                    <hr/>
                </div>
                <div class="d-inline-flex justify-content-between w-100">
                    <h5 class="mx-2">Invoices:</h5>
                    <div>
                        <form action="{{route('invoices_year', [
                        'company' => request()->query('company'),
                        'invoice' => request()->query('invoice'),
                        'search' => request()->query('search')])}}" method="POST">
                            @csrf <!-- {{ csrf_field() }} -->
                            <label>
                                <select name="year" class="btn btn-secondary btn-dropdown btn-sm"
                                        onchange="this.form.submit()">
                                    @if(isset($fiscal_years) && count($fiscal_years) > 0)
                                        @foreach($fiscal_years as $fiscal_year)
                                            <option
                                                value="{{ $fiscal_year }}" {{$selected_fiscal_year == $fiscal_year ? 'selected' : ''}}>{{ $fiscal_year }}</option>
                                        @endforeach
                                    @else
                                        <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                                    @endif
                                </select>
                            </label>
                        </form>
                    </div>
                </div>
                <div class="invoices-list my-3">
                    @if(isset($invoices) && count($invoices) > 0)
                        @component('components.invoice_list_component', ['invoices' => $invoices])
                        @endcomponent
                    @else
                        <div id="invoices-not-found"
                             class="d-flex-row p-4 justify-content-center align-items-center border border-1
                             rounded-5">
                            @if(request()->has('search'))
                                <h5 class="text-center">No Invoices Found</h5>
                                <p class="small text-center p-3">
                                    It seems there are no invoices matching your search criteria for the selected
                                    company. If you haven't created any invoices yet, you can start by clicking on the
                                    <b><i>Create New Invoice</i></b> button.
                                </p>
                            @else
                                <h5 class="text-center">It looks like you haven't created any invoices yet for the
                                    selected
                                    company</h5>
                                <p class="small text-center p-3">To create your first invoice for selected company,
                                    click on button <b><i>Create New Invoice</i></b></p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-8 mt-3">
                <div class="card border border-left">
                    @if(isset($invoice) && count($invoice) > 0)
                        @component('components.invoice_details_component', ['invoice' => $invoice])
                        @endcomponent
                    @else
                        <div
                            class="d-flex-row p-4 justify-content-center align-items-center border border-1
                             rounded-5">
                            <h4 class="text-center p-3">Welcome to SaleTrackMate Invoice Management System</h4>
                            <p class="text-center p-2">
                                Thank you for using our invoice management system. With our platform, you can
                                efficiently manage and keep track of all your invoices in one place.
                            </p>
                            <p class="text-center p-2">
                                If you're looking to access <b><i>invoice details</i></b>, simply click on
                                <b><i>an invoice item</i></b> from the <b><i>list of invoices</i></b> on the left
                                side of the page to explore and manage your invoices. You'll find a wealth of
                                information about your invoices, such as due dates, payment status, goods or services,
                                prices and many more.
                            </p>
                            <p class="text-center p-2">
                                Our user-friendly interface makes it easy to navigate through your invoices and generate
                                reports to keep your financial records organized and
                                up-to-date.
                            </p>
                            <p class="text-center p-2">
                                If you have any questions, please don't hesitate to contact me via the email listed in
                                the <b><i>About</i></b> section of this page. I am here to help you make the most of our
                                invoice management system.
                                <br>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>


