<div class="invoice-item">
    <div class="row mx-1">
        <div class="col-xl-2 col-md-12 col-sm-12 mb-3">
            <label for="invoice_item_name" class="form-label">
                Name:
            </label>
            <input type="text" class="form-control" name="invoice_items[0][name]" id="invoice_item_name"
                   placeholder="Name" value="" required>
        </div>
        <div class="col-xl-1 col-md-12 col-sm-12 mb-3">
            <label for="invoice_item_unit" class="form-label">
                Unit:
            </label>
            <input type="text" class="form-control" name="invoice_items[0][unit]" id="invoice_item_unit"
                   placeholder="Unit" value="" required>
        </div>
        <div class="col-xl-2 col-md-12 col-sm-12 mb-3">
            <label for="invoice_item_unit_price" class="form-label">
                Unit price:
            </label>
            <input type="number" class="form-control" name="invoice_items[0][unit_price]" step="0.01"
                   id="invoice_item_unit_price" placeholder="Unit price" value="0" required>
        </div>
        <div class="col-xl-1 col-md-12 col-sm-12 mb-3">
            <label for="invoice_item_quantity" class="form-label">
                Quantity:
            </label>
            <input type="number" class="form-control" name="invoice_items[0][quantity]" step="0.01"
                   id="invoice_item_quantity" placeholder="Qt." value="1" required>
        </div>
        <div class="col-xl-2 col-md-12 col-sm-12 mb-3">
            <label for="invoice_item_rebate" class="form-label">
                Rebate (%):
            </label>
            <input type="number" class="form-control" name="invoice_items[0][rebate]"
                   id="invoice_item_rebate" placeholder="Rebate (%)" value="0">
        </div>
        <div class="col-xl-1 col-md-12 col-sm-12 mb-3">
            <label for="invoice_item_vat" class="form-label">
                VAT (%):
            </label>
            <input type="number" class="form-control" name="invoice_items[0][vat_percentage]" id="invoice_item_vat"
                   placeholder="VAT" value="0" required>
        </div>
        <div class="col-xl-2 col-md-12 col-sm-12 mb-3">
            <label for="invoice_item_image_url" class="form-label">
                Image URL:
            </label>
            <input type="text" class="form-control" name="invoice_items[0][image_url]" pattern="https?://.+"
                   id="invoice_item_image_url" placeholder="Image URL" value="">
        </div>
        <div class="col-xl-1 mb-3 d-flex justify-content-end align-items-end">
            <button class="form-control btn-form-control mt-1 me-xl-3" type="button"
                    onclick="removeInvoiceItem(this)">
                <img src="{{ asset('images/res/delete.png') }}" alt="delete" width="21"
                     height="21">
                <span class="visually-hidden">Remove</span>
            </button>
        </div>
    </div>
    <hr/>
</div>
