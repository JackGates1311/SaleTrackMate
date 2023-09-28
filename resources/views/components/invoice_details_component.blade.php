<div class="card-header">
    Invoice Details - Invoice #{{ $invoice['invoice_num'] }}
</div>
<div class="card-body">
    <div id="invoiceAccordion">
        <div class="accordion">
            <!-- Recipient Information -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="recipientHeading">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#recipientCollapse" aria-expanded="true" aria-controls="recipientCollapse">
                        Recipient Information
                    </button>
                </h2>
                <div id="recipientCollapse" class="accordion-collapse collapse show" aria-labelledby="recipientHeading">
                    <div class="accordion-body">
                        <p><strong>Recipient:</strong> {{ $invoice['recipient']['name'] }}</p>
                        <p><strong>Email:</strong> {{ $invoice['recipient']['email'] }}</p>
                        <p><strong>Address:</strong> {{ $invoice['recipient']['address'] }}</p>
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
                        <ul>
                            <li><strong>Invoice ID:</strong> {{ $invoice['id'] }}</li>
                            <li><strong>Invoice Date:</strong> {{ $invoice['invoice_date'] }}</li>
                            <li><strong>Invoice Location:</strong> {{ $invoice['invoice_location'] }}</li>
                            <li><strong>Due Date:</strong> {{ $invoice['due_date'] }}</li>
                            <li><strong>Due Location:</strong> {{ $invoice['due_location'] }}</li>
                            <li><strong>Delivery Date:</strong> {{ $invoice['delivery_date'] }}</li>
                            <li><strong>Delivery Location:</strong> {{ $invoice['delivery_location'] }}</li>
                            <li><strong>Payment Method:</strong> {{ $invoice['payment_method'] }}</li>
                            <li><strong>Payment Deadline:</strong> {{ $invoice['payment_deadline'] }}</li>
                            <li><strong>Fiscal Receipt Number:</strong> {{ $invoice['fiscal_receipt_num'] }}</li>
                            <li><strong>Total Base Amount:</strong> {{ $invoice['total_base_amount'] }}</li>
                            <li><strong>Total Price:</strong> {{ $invoice['total_price'] }}</li>
                            <li><strong>Total VAT:</strong> {{ $invoice['total_vat'] }}</li>
                            <li><strong>Total Rebate:</strong> {{ $invoice['total_rebate'] }}</li>
                            <li><strong>Status:</strong> {{ $invoice['status'] }}</li>
                            <li><strong>Type:</strong> {{ $invoice['type'] }}</li>
                            <li><strong>Created At:</strong> {{ $invoice['created_at'] }}</li>
                            <li><strong>Updated At:</strong> {{ $invoice['updated_at'] }}</li>
                            <li><strong>Issuer Company ID:</strong> {{ $invoice['issuer_company_id'] }}</li>
                            <li><strong>Recipient Company ID:</strong> {{ $invoice['recipient_company_id'] }}</li>
                        </ul>
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
                        <ul>
                            <li><strong>Issuer Company ID:</strong> {{ $invoice['issuer']['company_id'] }}</li>
                            <li><strong>Tax Code:</strong> {{ $invoice['issuer']['tax_code'] }}</li>
                            <li><strong>Name:</strong> {{ $invoice['issuer']['name'] }}</li>
                            <li><strong>Category:</strong> {{ $invoice['issuer']['category'] }}</li>
                            <li><strong>Country:</strong> {{ $invoice['issuer']['country'] }}</li>
                            <li><strong>Place:</strong> {{ $invoice['issuer']['place'] }}</li>
                            <li><strong>Postal Code:</strong> {{ $invoice['issuer']['postal_code'] }}</li>
                            <li><strong>Address:</strong> {{ $invoice['issuer']['address'] }}</li>
                            <li><strong>Email:</strong> {{ $invoice['issuer']['email'] }}</li>
                            <li><strong>URL:</strong> {{ $invoice['issuer']['url'] }}</li>
                            <!-- You can add more issuer information here if needed -->
                        </ul>
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
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-nowrap text-center" style="min-width: 100px;">Item</th>
                                    <th class="text-nowrap text-center" style="min-width: 200px;">Description</th>
                                    <th class="text-nowrap text-center" style="min-width: 80px;">Unit</th>
                                    <th class="text-nowrap text-center" style="min-width: 100px;">Unit Price</th>
                                    <th class="text-nowrap text-center" style="min-width: 80px;">Quantity</th>
                                    <th class="text-nowrap text-center" style="min-width: 120px;">Base Amount</th>
                                    <th class="text-nowrap text-center" style="min-width: 80px;">Rebate</th>
                                    <th class="text-nowrap text-center" style="min-width: 120px;">VAT Price</th>
                                    <th class="text-nowrap text-center" style="min-width: 120px;">VAT Percentage</th>
                                    <th class="text-nowrap text-center" style="min-width: 120px;">Total Price</th>
                                    <th class="text-nowrap text-center" style="min-width: 150px;">Image URL</th>
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
