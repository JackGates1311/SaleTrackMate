@php use App\Enums\InvoiceStatus; @endphp
<div class="card-header w-100">
    <div class="d-inline-flex justify-content-between w-100">
        <strong class="p-1">Invoice #{{ $invoice['invoice_num'] }}</strong>
        <div class="d-inline-flex gap-2">
            <button class="btn btn-sm btn-primary">Export Invoice</button>
            <button class="btn btn-sm btn-primary">Close Invoice</button>
        </div>
    </div>
</div>
<div class="card-body">
    <div id="invoiceAccordion">
        <div class="accordion">
            <!-- Invoice Overview -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="issuerHeading">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#invoiceOverviewCollapse" aria-expanded="false"
                            aria-controls="invoiceOverviewCollapse">
                        Invoice Overview
                    </button>
                </h2>
                <div id="invoiceOverviewCollapse" class="accordion-collapse collapse show"
                     aria-labelledby="invoiceOverviewHeading">
                    <div class="accordion-body">
                        <div class="d-inline-flex justify-content-between w-100">
                            <p><strong>Invoice Number:</strong> {{ $invoice['invoice_num'] }}</p>
                            <div>
                                <div class="d-inline-flex gap-2">
                                    @if($invoice['status'] == InvoiceStatus::SENT->value)
                                        <span class="badge badge-small rounded-pill bg-success">
                                {{ ucwords(strtolower($invoice['status'])) }}</span>
                                    @elseif($invoice['status'] == InvoiceStatus::STAGING->value)
                                        <span class="badge badge-small rounded-pill bg-warning">
                                {{ ucwords(strtolower($invoice['status'])) }}</span>
                                    @else
                                        <span class="badge badge-small rounded-pill bg-danger">
                                {{ ucwords(strtolower($invoice['status'])) }}</span>
                                    @endif
                                    @if("0" == 1)
                                        <span class="badge badge-small rounded-pill bg-primary">Closed</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <p><strong>Recipient:</strong> {{ $invoice['recipient']['name'] }}
                            ({{ $invoice['recipient']['place'] }})</p>
                        <p><strong>Issuer Bank Account:</strong> {{$invoice['issuer']['iban']}}
                            ({{$invoice['issuer']['bank_name']}})</p>
                        <p><strong>Invoice Date:</strong> {{ $invoice['invoice_date'] }}</p>
                        <p><strong>Invoice Type:</strong> {{ucwords(strtolower($invoice['type']))}}</p>
                        <p><strong>Due Date:</strong> {{ date('y-m-d - h:i A', strtotime($invoice['due_date'])) }}</p>
                        <p><strong>Payment Method:</strong>
                            {{ ucwords(strtolower(str_replace('_', ' ', $invoice['payment_method']))) }} (Local
                            Currency)</p>
                        <p><strong>Total Price:</strong> {{ $invoice['total_price'] }} </p>
                    </div>
                </div>
            </div>

            <!-- Issuer Information -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="issuerHeading">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#issuerCollapse" aria-expanded="false" aria-controls="issuerCollapse">
                        Issuer Information
                    </button>
                </h2>
                <div id="issuerCollapse" class="accordion-collapse collapse" aria-labelledby="issuerHeading">
                    <div class="accordion-body">
                        <div class="d-inline-flex justify-content-between w-100 gap-3">
                            <div>
                                <p><strong>Name:</strong> {{ $invoice['issuer']['name'] ?? '' }}</p>
                                <p><strong>Company ID:</strong> {{ $invoice['issuer']['company_id'] ?? '' }}</p>
                                <p><strong>Tax Code:</strong> {{ $invoice['issuer']['tax_code'] ?? '' }}</p>
                                <p><strong>Registration ID:</strong> {{ $invoice['issuer']['reg_id'] ?? '' }}</p>
                                <p><strong>VAT ID:</strong> {{ $invoice['issuer']['vat_id'] ?? '' }}</p>
                                <p><strong>Country:</strong> {{ $invoice['issuer']['country'] ?? '' }}</p>
                                <p><strong>Place:</strong> {{ $invoice['issuer']['place'] ?? '' }}</p>
                                <p><strong>Postal Code:</strong> {{ $invoice['issuer']['postal_code'] ?? '' }}</p>
                                <p><strong>Address:</strong> {{ $invoice['issuer']['address'] ?? '' }}</p>
                                <p><strong>Bank Name:</strong>
                                    {{ $invoice['issuer']['bank_name'] ?? '' }}
                                </p>
                                <p><strong>IBAN:</strong>
                                    {{ $invoice['issuer']['iban'] ?? '' }}
                                </p>
                                <p><strong>Phone Number:</strong> {{ $invoice['issuer']['phone_num'] ?? '' }}</p>
                                <p><strong>Fax:</strong> {{ $invoice['issuer']['fax'] ?? '' }}</p>
                                <p><strong>Email:</strong> {{ $invoice['issuer']['email'] ?? '' }}</p>
                                <p><strong>Website:</strong> <a
                                        href="{{ $invoice['issuer']['url'] ?? '' }}">{{ $invoice['issuer']['url'] ?? '' }}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recipient Information -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="recipientHeading">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#recipientCollapse" aria-expanded="true" aria-controls="recipientCollapse">
                        Recipient Information
                    </button>
                </h2>
                <div id="recipientCollapse" class="accordion-collapse collapse" aria-labelledby="recipientHeading">
                    <div class="accordion-body">
                        <p><strong>Name:</strong> {{ $invoice['recipient']['name'] ?? '' }}</p>
                        <p><strong>Tax Code:</strong> {{ $invoice['recipient']['tax_code'] ?? '' }}</p>
                        <p><strong>Registration ID:</strong> {{ $invoice['recipient']['reg_id'] ?? '' }}</p>
                        <p><strong>VAT ID:</strong> {{ $invoice['recipient']['vat_id'] ?? '' }}</p>
                        <p><strong>Place:</strong> {{ $invoice['recipient']['place'] ?? '' }}</p>
                        <p><strong>Postal Code:</strong> {{ $invoice['recipient']['postal_code'] ?? '' }}</p>
                        <p><strong>Address:</strong> {{ $invoice['recipient']['address'] ?? '' }}</p>
                        <p><strong>Bank Name:</strong>
                            {{ $invoice['recipient']['bank_name'] ?? '' }}
                        </p>
                        <p><strong>IBAN:</strong>
                            {{ $invoice['recipient']['iban'] ?? '' }}
                        </p>
                        <p><strong>Phone Number:</strong> {{ $invoice['recipient']['phone_num'] ?? '' }}</p>
                        <p><strong>Fax:</strong> {{ $invoice['recipient']['fax'] ?? '' }}</p>
                        <p><strong>Email:</strong> {{ $invoice['recipient']['email'] ?? '' }}</p>
                    </div>
                </div>
            </div>
            <!-- Invoice Details -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="invoiceDetailsHeading">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#invoiceDetailsCollapse" aria-expanded="false"
                            aria-controls="invoiceDetailsCollapse">
                        Invoice Details
                    </button>
                </h2>
                <div id="invoiceDetailsCollapse" class="accordion-collapse collapse"
                     aria-labelledby="invoiceDetailsHeading">
                    <div class="accordion-body">
                        <p><strong>Invoice Number:</strong> {{ $invoice['invoice_num'] }}</p>
                        <p><strong>Invoice Date:</strong> {{ $invoice['invoice_date'] }}</p>
                        <p><strong>Invoice Location:</strong> {{ $invoice['invoice_location'] }}</p>
                        <p><strong>Due Date:</strong> {{ date('y-m-d - h:i A', strtotime($invoice['due_date'])) }}</p>
                        <p><strong>Due Location:</strong> {{ $invoice['due_location'] }}</p>
                        <p><strong>Delivery
                                Date:</strong> {{ date('y-m-d - h:i A', strtotime($invoice['delivery_date'])) }}</p>
                        <p><strong>Delivery Location:</strong> {{ $invoice['delivery_location'] }}</p>
                        <p><strong>Payment Method:</strong>
                            {{ ucwords(strtolower(str_replace('_', ' ', $invoice['payment_method']))) }} (Local
                            Currency)</p>
                        <p><strong>Payment
                                Deadline:</strong> {{ date('y-m-d - h:i A', strtotime($invoice['payment_deadline'])) }}
                        </p>
                        <p><strong>Fiscal Receipt Number:</strong> {{ $invoice['fiscal_receipt_num'] }}</p>
                        <p><strong>Total Base Amount:</strong> {{ $invoice['total_base_amount'] }}</p>
                        <p><strong>Total Price:</strong> {{ $invoice['total_price'] }}</p>
                        <p><strong>Total VAT:</strong> {{ $invoice['total_vat'] }}</p>
                        <p><strong>Total Rebate:</strong> {{ $invoice['total_rebate'] }}</p>
                        <p><strong>Invoice Status:</strong> {{ ucwords(strtolower($invoice['status'])) }}</p>
                        <p><strong>Invoice Type:</strong> {{ ucwords(strtolower($invoice['type'])) }}</p>
                    </div>
                </div>
            </div>

            <!-- Invoice Items -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="invoiceItemsHeading">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#invoiceItemsCollapse" aria-expanded="false"
                            aria-controls="invoiceItemsCollapse">
                        Invoice Items
                    </button>
                </h2>
                <div id="invoiceItemsCollapse" class="accordion-collapse collapse"
                     aria-labelledby="invoiceItemsHeading">
                    <div class="accordion-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th class="text-nowrap text-center table-header-cell">Item</th>
                                    <th class="text-nowrap text-center table-header-cell">Description</th>
                                    <th class="text-nowrap text-center table-header-cell">Unit</th>
                                    <th class="text-nowrap text-center table-header-cell">Unit Price</th>
                                    <th class="text-nowrap text-center table-header-cell">Quantity</th>
                                    <th class="text-nowrap text-center table-header-cell">Base Amount</th>
                                    <th class="text-nowrap text-center table-header-cell">Rebate</th>
                                    <th class="text-nowrap text-center table-header-cell">VAT Price</th>
                                    <th class="text-nowrap text-center table-header-cell">VAT Percentage</th>
                                    <th class="text-nowrap text-center table-header-cell">Total Price</th>
                                    <th class="text-nowrap text-center table-header-cell">Image URL</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($invoice['invoice_items'] as $item)
                                    <tr>
                                        <td class="text-nowrap text-center">{{ $item['name'] }}</td>
                                        <td class="text-nowrap text-center">{{ $item['name'] }}</td>
                                        <td class="text-nowrap text-center">{{ $item['unit'] }}</td>
                                        <td class="text-nowrap text-center">{{ $item['unit_price'] }}</td>
                                        <td class="text-nowrap text-center">{{ $item['quantity'] }}</td>
                                        <td class="text-nowrap text-center">{{ $item['base_amount'] }}</td>
                                        <td class="text-nowrap text-center">{{ $item['rebate'] }}</td>
                                        <td class="text-nowrap text-center">{{ $item['vat_price'] }}</td>
                                        <td class="text-nowrap text-center">{{ $item['vat_percentage'] }}</td>
                                        <td class="text-nowrap text-center">{{ $item['total_price'] }}</td>
                                        <td class="text-nowrap text-center">{{ $item['image_url'] }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
