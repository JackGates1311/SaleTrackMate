<div class="price-discount-form" id="price-discount" {{isset($hidden) && $hidden ? 'hidden' : ''}}>
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="form-outline">
                <label for="discount_percentage" class="form-label">Discount
                    Percentage:</label>
                <input type="number" class="form-control"
                       id="discount_percentage" step="1" min="0" max="100"
                       @if (!$hidden)
                           name="price_discount[percentage]"
                       @endif
                       placeholder="Discount percentage (optional)"
                       value="{{ isset($good_or_service) ? $good_or_service['price_discount']['percentage'] :
                        old('price_discount.percentage') }}">
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
                       value="{{ isset($good_or_service) ? $good_or_service['price_discount']['from_date'] :
                        old('price_discount.from_date') }}">
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
                       value="{{ isset($good_or_service) ? $good_or_service['price_discount']['due_date'] :
                        old('price_discount.due_date') }}">
            </div>
        </div>
    </div>
</div>
