<div class="col-lg-{{isset($price) && !$editable ? '5' : ($small ? '3' : '6')}} mb-4">
    <!-- Price Amount (Required) -->
    <div class="form-outline">
        <label for="price_amount"
               class="form-label">Price:</label>
        <input type="{{!$editable ? 'text' : 'number'}}" class="form-control"
               id="price_amount"
               name="price[amount]" step="0.01"
               placeholder="Price"
               value="{{isset($price) ? $price['amount'] : old('price.amount') ?? '' }}"
               required {{!$editable ? 'readonly' : ''}}>
    </div>
</div>
<div class="col-lg-{{isset($price) && !$editable ? '5' : ($small ? '3' : '6')}} mb-4">
    <!-- Price Expiration Date (Required) -->
    <div class="form-outline">
        <label for="price_expiration_date" class="form-label">Price
            Expiration Date:</label>
        <input type="datetime-local" class="form-control"
               id="price_expiration_date"
               name="price[expiration_date]"
               value="{{isset($price) ? $price['expiration_date'] : old('price.expiration_date') ?? '' }}"
               required {{!$editable ? 'readonly' : ''}}>
    </div>
</div>
@if(!$editable)
    <div class="col-lg-1 mb-lg-2 d-flex justify-content-center align-items-end">
        <a class="form-control btn-form-control mt-lg-1 mb-3 text-center"
           href="{{route('price_edit', ['price' => $price['id'],
                    'company' => request()->query('company'),
                        'good_or_service' => request()->query('good_or_service')])}}">
            <img src="{{ asset('images/res/edit.png') }}" alt="edit"
                 width="21"
                 height="21">
            <span class="visually-hidden">Edit</span>
        </a>
    </div>
    <div class="col-lg-1 mb-lg-2 d-flex justify-content-end align-items-end">
        <form class="w-100" method="POST" action="{{route('price_delete', [
                        'price' => $price['id'], 'company' => request()->query('company')])}}">
            @csrf <!-- {{ csrf_field() }} -->
            <button type="submit" class="form-control btn-form-control mt-lg-1 mb-3 text-center w-100">
                <img src="{{ asset('images/res/delete.png') }}" alt="delete" width="21"
                     height="21">
                <span class="visually-hidden">Remove</span>
            </button>
        </form>
    </div>
    <hr/>
@endif
