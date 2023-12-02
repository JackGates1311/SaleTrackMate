<div class="list-group scrollable-list">
    @foreach($invoices as $invoice)
        <a href="{{route('invoices', ['company' => request()->query('company'),
            'invoice' => $invoice['id'],
            'search' => request()->query('search'),
            'year' => request()->query('year')])}}"
           class="list-group-item list-group-item-action">
            {{ $invoice['invoice_num'] }}
        </a>
    @endforeach
</div>
