<div class="modal fade" id="exportInvoiceModal" tabindex="-1" aria-labelledby="exportInvoiceModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-center" data-bs-dismiss="modal">
                <h5 class="modal-title w-100" id="exportInvoiceModalLabel">Export Invoice</h5>
            </div>
            <div class="modal-body">
                <div class="d-inline-flex w-100 mt-2 gap-3">
                    <a href="{{route('invoice_pdf_export', ['company' => request()->query('company'),
                        'invoice' => request()->query('invoice')])}}"
                       class="btn btn-primary btn-block gradient-custom-2 w-100 mb-2">Export As PDF</a>
                    <a href="{{route('invoice_xml_export', ['company' => request()->query('company'),
                        'invoice' => request()->query('invoice')])}}"
                       class="btn btn-primary btn-block gradient-custom-2 w-100 mb-2">Export As XML</a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary w-25" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
