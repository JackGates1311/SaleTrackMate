<!-- Invoice Data Form -->
<div class="text-center">
    <h4 class="m-3">Invoice Data</h4>
</div>
<hr/>

<div class="row">
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="invoice_num" class="form-label">Invoice Number:</label>
            <input type="text" class="form-control" id="invoice_num" name="invoice_num"
                   placeholder="Invoice number"
                   value="{{old('invoice_num') == null ? $invoice_num : old('invoice_num')}}" required>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="invoice_date" class="form-label">Invoice Date:</label>
            <input type="date" class="form-control" id="invoice_date" name="invoice_date"
                   value="{{old('invoice_date')}}" required>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="invoice_location" class="form-label">Invoice Location:</label>
            <input type="text" class="form-control" id="invoice_location" name="invoice_location"
                   value="{{old('invoice_location') != "" ? old('invoice_location') :
                   $issuer['address'] . ', ' . $issuer['place'] ?? ''}}" placeholder="Invoice location" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="due_date" class="form-label">Due Date:</label>
            <input type="datetime-local" class="form-control" id="due_date" name="due_date"
                   value="{{old('due_date')}}" required>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="due_location" class="form-label">Due Location:</label>
            <input type="text" class="form-control" id="due_location" name="due_location"
                   value="{{old('due_location') != "" ? old('due_location') :
                   $issuer['address'] . ', ' . $issuer['place'] ?? ''}}" placeholder="Due location" required>
        </div>
    </div>
    <div class=" col-lg-4">
        <div class="form-outline mb-4">
            <label for="delivery_date" class="form-label">Delivery Date:</label>
            <input type="datetime-local" class="form-control" id="delivery_date" name="delivery_date"
                   value="{{old('delivery_date')}}" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="delivery_location" class="form-label">Delivery Location:</label>
            <input type="text" class="form-control" id="delivery_location" name="delivery_location"
                   value="{{old('delivery_location') != "" ? old('delivery_location') :
                   $issuer['address'] . ', ' . $issuer['place'] ?? ''}}" placeholder="Delivery location"
                   required>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="payment_method" class="form-label">Payment Method:</label>
            <select class="form-select" id="payment_method" name="payment_method">
                <option value="ADVANCE_PAYMENT"
                    {{old('payment_method')  == "ADVANCE_PAYMENT" ? 'selected' : ''}}>Advance Payment
                </option>
                <option value="BANK_TRANSFER"
                    {{old('payment_method')  == "BANK_TRANSFER" ? 'selected' : ''}}>Bank Transfer
                </option>
                <option value="CASH_PAYMENT"
                    {{old('payment_method')  == "CASH_PAYMENT" ? 'selected' : ''}}>Cash Payment
                </option>
            </select>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-outline mb-4">
            <label for="payment_deadline" class="form-label">Payment Deadline:</label>
            <input type="datetime-local" class="form-control" id="payment_deadline" name="payment_deadline"
                   value="{{old('payment_deadline')}}" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-3">
        <div class="form-outline mb-4">
            <label for="fiscal_receipt_num" class="form-label">Fiscal Receipt Number:</label>
            <input type="text" class="form-control" id="fiscal_receipt_num" name="fiscal_receipt_num"
                   placeholder="Fiscal receipt num" value="{{old('fiscal_receipt_num')}}" required>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-outline mb-4">
            <label for="fiscal_year" class="form-label">Fiscal Year:</label>
            <select class="form-select" id="fiscal_year" name="fiscal_year">
                <option value="2023">2023</option>
                <!-- Add more fiscal year options as needed -->
            </select>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-outline mb-4">
            <label for="type" class="form-label">Invoice Type:</label>
            <select class="form-select" id="type" name="type">
                <option value="INVOICE"
                    {{old('type')  == "INVOICE" ? 'selected' : ''}}>Invoice
                </option>
                <option value="PROFORMA"
                    {{old('type')  == "PROFORMA" ? 'selected' : ''}}>Proforma
                </option>
            </select>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-outline mb-4">
            <label for="status" class="form-label">Invoice Status:</label>
            <select class="form-select" id="status" name="status">
                <option value="STAGING"
                    {{old('status')  == "STAGING" ? 'selected' : ''}}>Staging
                </option>
                <option value="SENT"
                    {{old('status')  == "SENT" ? 'selected' : ''}}>Sent
                </option>
            </select>
        </div>
    </div>
</div>
