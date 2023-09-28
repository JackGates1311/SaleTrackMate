<div class="list-group scrollable-list">
    @foreach($invoices as $invoice)
        <a href="{{route('invoices', ['company' => request()->query('company'), 'invoice' => $invoice['id']])}}"
           class="list-group-item list-group-item-action">
            {{ $invoice['invoice_num'] }}
        </a>
    @endforeach
</div>
