<div class="modal fade" id="selectInvoiceItemModal" tabindex="-1" aria-labelledby="selectInvoiceItemModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-center" data-bs-dismiss="modal">
                <h5 class="modal-title w-100" id="changePasswordModalLabel">Select Good or Service</h5>
            </div>
            <div class="modal-body">
                @if(isset($goods_and_services) && count($goods_and_services) > 0)
                    <label for="invoiceItemSelect" class="form-label">Good or Service:</label>
                    <select
                        class="form-select mb-3 mb-lg-0 me-lg-2 w-sm-100 w-100" id="invoiceItemSelect"
                        name="invoice-item">
                        @foreach ($goods_and_services as $good_or_service)
                            <option value="{{ $good_or_service['id'] }}"
                                    data-invoice-item="{{ json_encode($good_or_service) }}">
                                {{ $good_or_service['name'] }}
                            </option>
                        @endforeach
                    </select>
                @else
                    <h5 class="text-center">It looks like you haven't saved a good or service yet</h5>
                    <p class="small text-center pt-3">To save your first good or service, on navigation bar click on
                        <b><i>Goods And Service</i></b> and then click on <b><i>Add New Good or Service</i></b></p>
                @endif
            </div>
            <div class="modal-footer">
                @if(isset($goods_and_services) && count($goods_and_services) > 0)
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="selectInvoiceItem(null)">
                        Select Good or Service
                    </button>
                @else
                    <button type="button" class="btn btn-primary w-25" data-bs-dismiss="modal">OK</button>
                @endif
            </div>
        </div>
    </div>
</div>
