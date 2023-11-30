<div class="price-discount-form" id="price-discount" {{isset($hidden) && $hidden ? 'hidden' : ''}}>
    <div class="row">
        <div class="col-lg-{{!$editable ? '2' : '4'}} mb-4">
            <div class="form-outline">
                <label for="discount_percentage" class="form-label">Discount
                    Percentage:</label>
                <input type="{{!$editable ? 'text' : 'number'}}" class="form-control"
                       id="discount_percentage" step="1" min="0" max="100"
                       @if (!$hidden)
                           name="price_discount[percentage]"
                       @endif
                       placeholder="Discount percentage"
                       value="{{ isset($price_discount) ? $price_discount['percentage'] :
                        old('price_discount.percentage') }}" {{!$editable ? 'readonly' : ''}}
                    {{$hidden ? '' : 'required'}}>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="form-outline">
                <label for="discount_from_date" class="form-label">Discount
                    From Date:</label>
                <input type="datetime-local" class="form-control"
                       id="discount_from_date"
                       @if (!$hidden)
                           name="price_discount[from_date]"
                       @endif
                       value="{{ isset($price_discount) ? $price_discount['from_date'] :
                        old('price_discount.from_date') }}" {{!$editable ? 'readonly' : ''}}
                    {{$hidden ? '' : 'required'}}>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="form-outline">
                <label for="discount_due_date" class="form-label">Discount
                    Due Date:</label>
                <input type="datetime-local" class="form-control"
                       id="discount_due_date"
                       @if (!$hidden)
                           name="price_discount[due_date]"
                       @endif
                       value="{{ isset($price_discount) ? $price_discount['due_date'] :
                        old('price_discount.due_date') }}" {{!$editable ? 'readonly' : ''}}
                    {{$hidden ? '' : 'required'}}>
            </div>
        </div>
        @if(!$editable)
            <div class="col-lg-1 mb-lg-2 d-flex justify-content-center align-items-end">
                <a class="form-control btn-form-control mt-lg-1 mb-3 text-center"
                   href="{{route('price_discount_edit', ['price_discount' => $price_discount['id'],
                    'company' => request()->query('company'),
                        'good_or_service' => request()->query('good_or_service')])}}">
                    <img src="{{ asset('images/res/edit.png') }}" alt="edit"
                         width="21"
                         height="21">
                    <span class="visually-hidden">Edit</span>
                </a>
            </div>
            <div class="col-lg-1 mb-lg-2 d-flex justify-content-end align-items-end">
                <form class="w-100" method="POST" action="{{route('price_discount_delete', [
                        'price_discount' => $price_discount['id'], 'company' => request()->query('company'),
                        'good_or_service' => request()->query('good_or_service')])}}">
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
    </div>
</div>
