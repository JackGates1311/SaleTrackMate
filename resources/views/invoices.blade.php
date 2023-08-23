<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Invoice Management - SaleTrackMate</title>
    @component('components.header_component')
    @endcomponent
</head>
<body>
@component('components.navbar_component')
@endcomponent

<div class="container mt-3">
    <div class="row">
        <div class="col-lg-4">
            <form class="invoice-search-form mb-4" action="#" method="GET">
                <label for="search"></label>
                <div class="input-group">
                    <input type="text" id="search" name="search" class="form-control" placeholder="Search for invoices">
                    <button type="submit" class="btn btn-primary">
                        <img src="{{ asset('images/res/search.png') }}" alt="arrow_forward" width="24" height="24">
                    </button>
                </div>
            </form>
            <a href="#" class="btn btn-primary btn-block gradient-custom-2 w-100 mb-3">Create New Invoice</a>
            <!-- Invoices List -->
            <h5 class="p-1">Invoices:</h5>
            <div class="list-group mt-4 scrollable-list">
                @php
                    $invoices = [
                        ['id' => 1, 'invoice_number' => 'INV2021001', 'total_amount' => 100.00],
                        ['id' => 2, 'invoice_number' => 'INV2021002', 'total_amount' => 150.00],
                        ['id' => 3, 'invoice_number' => 'INV2021003', 'total_amount' => 200.00],
                                                ['id' => 1, 'invoice_number' => 'INV2021001', 'total_amount' => 100.00],
                        ['id' => 2, 'invoice_number' => 'INV2021002', 'total_amount' => 150.00],
                        ['id' => 3, 'invoice_number' => 'INV2021003', 'total_amount' => 200.00],
                                                ['id' => 1, 'invoice_number' => 'INV2021001', 'total_amount' => 100.00],
                        ['id' => 2, 'invoice_number' => 'INV2021002', 'total_amount' => 150.00],
                        ['id' => 3, 'invoice_number' => 'INV2021003', 'total_amount' => 200.00],
                                                ['id' => 1, 'invoice_number' => 'INV2021001', 'total_amount' => 100.00],
                        ['id' => 2, 'invoice_number' => 'INV2021002', 'total_amount' => 150.00],
                        ['id' => 3, 'invoice_number' => 'INV2021003', 'total_amount' => 200.00],
                                                ['id' => 1, 'invoice_number' => 'INV2021001', 'total_amount' => 100.00],
                        ['id' => 2, 'invoice_number' => 'INV2021002', 'total_amount' => 150.00],
                        ['id' => 3, 'invoice_number' => 'INV2021003', 'total_amount' => 200.00],
                    ];
                @endphp
                @foreach($invoices as $invoice)
                    <a href="{{ route('login', $invoice['id']) }}" class="list-group-item list-group-item-action">
                        Invoice #{{ $invoice['id'] }}
                    </a>
                @endforeach
            </div>
        </div>
        <div class="col-lg-8 mt-3">
            @php
                $invoice = [
'invoice_number' => 'INV123456',
'recipient' => 'John Doe',
'recipient_email' => 'john@example.com',
'recipient_address' => '123 Main St, Cityville, Country',
'items' => [
[
    'item_name' => 'Product A',
    'item_description' => 'Description for Product A',
    'quantity' => 2,
    'unit_price' => 50.00,
    'total' => 100.00,
],
[
    'item_name' => 'Product B',
    'item_description' => 'Description for Product B',
    'quantity' => 3,
    'unit_price' => 30.00,
    'total' => 90.00,
],
],
'total_amount' => 190.00,
];

            @endphp
            <div class="card">
                <div class="card-header">
                    Invoice Details - Invoice #{{ $invoice['invoice_number'] }}
                </div>
                <div class="card-body">
                    <div class="d-inline-flex w-100 justify-content-between">
                        <h5 class="card-title">Recipient Information</h5>
                        <button class="btn btn-primary mb-3">Export Invoice</button>
                    </div>

                    <p><strong>Recipient:</strong> {{ $invoice['recipient'] }}</p>
                    <p><strong>Email:</strong> {{ $invoice['recipient_email'] }}</p>
                    <p><strong>Address:</strong> {{ $invoice['recipient_address'] }}</p>

                    <h5 class="card-title mt-4">Invoice Items</h5>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Item</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoice['items'] as $item)
                            <tr>
                                <td>{{ $item['item_name'] }}</td>
                                <td>{{ $item['item_description'] }}</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>{{ $item['unit_price'] }}</td>
                                <td>{{ $item['total'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="text-end mt-4">
                        <p><strong>Total Amount:</strong> {{ $invoice['total_amount'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>


