<!-- Invoice Data Form -->
<div class="text-center">
    <h4 class="m-3">Invoice Data</h4>
</div>
<hr/>

<div class="row">
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="invoice_num" class="form-label">Invoice Number:</label>
            <input type="text" class="form-control" id="invoice_num" name="invoice_num">
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="invoice_date" class="form-label">Invoice Date:</label>
            <input type="date" class="form-control" id="invoice_date" name="invoice_date">
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="invoice_location" class="form-label">Invoice Location:</label>
            <input type="text" class="form-control" id="invoice_location" name="invoice_location"
                   value="{{$issuer['address'] . ', ' . $issuer['place'] ?? ''}}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="due_date" class="form-label">Due Date:</label>
            <input type="datetime-local" class="form-control" id="due_date" name="due_date">
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="due_location" class="form-label">Due Location:</label>
            <input type="text" class="form-control" id="due_location" name="due_location"
                   value="{{$issuer['address'] . ', ' . $issuer['place'] ?? ''}}">
        </div>
    </div>
    <div class=" col-lg-4">
        <div class="form-outline mb-4">
            <label for="delivery_date" class="form-label">Delivery Date:</label>
            <input type="datetime-local" class="form-control" id="delivery_date" name="delivery_date">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="delivery_location" class="form-label">Delivery Location:</label>
            <input type="text" class="form-control" id="delivery_location" name="delivery_location"
                   value="{{$issuer['address'] . ', ' . $issuer['place'] ?? ''}}">
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="payment_method" class="form-label">Payment Method:</label>
            <select class="form-select" id="payment_method" name="payment_method">
                <option value="ADVANCE_PAYMENT">Advance Payment</option>
                <option value="BANK_TRANSFER">Bank Transfer</option>
                <option value="CASH_PAYMENT">Cash Payment</option>
            </select>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="payment_deadline" class="form-label">Payment Deadline:</label>
            <input type="datetime-local" class="form-control" id="payment_deadline" name="payment_deadline">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-3">
        <div class="form-outline mb-4">
            <label for="fiscal_receipt_num" class="form-label">Fiscal Receipt Number:</label>
            <input type="text" class="form-control" id="fiscal_receipt_num" name="fiscal_receipt_num">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-outline mb-4">
            <label for="fiscal_year" class="form-label">Fiscal Year:</label>
            <select class="form-select" id="fiscal_year" name="fiscal_year">
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <!-- Add more fiscal year options as needed -->
            </select>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-outline mb-4">
            <label for="type" class="form-label">Invoice Type:</label>
            <select class="form-select" id="type" name="type">
                <option value="Invoice">Invoice</option>
                <option value="Proforma">Proforma</option>
            </select>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-outline mb-4">
            <label for="status" class="form-label">Invoice Status:</label>
            <select class="form-select" id="status" name="status">
                <option value="STAGING">Staging</option>
                <option value="SENT">Sent</option>
            </select>
        </div>
    </div>
</div>
