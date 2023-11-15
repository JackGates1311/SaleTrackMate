@php use Carbon\Carbon; @endphp
<div class="tax-category-rate">
    <div class="row">
        @if($mode == 'tax_rate_create')
            <div class="col-xl-4 col-md-12 col-sm-12 mb-3">
                <label for="tax_category_id" class="form-label">Tax Category:</label>
                <select class="form-select mb-3 mb-lg-0 me-lg-2 w-sm-100 w-100" id="tax_category_id"
                        name="tax_category_id">
                    @foreach ($tax_categories as $tax_category)
                        <option
                            value="{{ $tax_category['id'] }}"
                            {{ old('tax_category_id') == $tax_category['id'] ? 'selected' : '' }}>
                            {{ $tax_category['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif
        @if($mode == 'tax_category_create' || $mode == 'tax_category_edit')
            <div class="{{$mode == 'tax_category_edit' ? 'col-xl-12' : 'col-xl-4'}} col-md-12 col-sm-12 mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" maxlength="32" class="form-control" name="name" id="name"
                       placeholder="Name" value="{{$tax_category['name'] ?? old('name')}}"
                       required>
            </div>
        @endif
        @if($mode == 'tax_category_create' || $mode == 'tax_rate_create')
            <div class="col-xl-4 col-md-12 col-sm-12 mb-3">
                <label for="tax_rate[percentage_value]" class="form-label">Percentage:</label>
                <input type="number" class="form-control" name="tax_rate[percentage_value]"
                       id="tax_rate[percentage_value]" placeholder="Percentage" min="0" max="100" step="1"
                       value="{{$tax_rate['percentage_value'] ?? old('tax_rate.percentage_value')}}"
                       required>
            </div>
            <div class="col-xl-4 col-md-12 col-sm-12 mb-3">
                <label for="tax_rate[from_date]" class="form-label">From Date:</label>
                <input type="date" class="form-control" id="tax_rate[from_date]" name="tax_rate[from_date]"
                       value="{{old('tax_rate.from_date', Carbon::now()->addMonth()->firstOfMonth()->format('Y-m-d'))}}"
                       min="{{ Carbon::now()->addDay()->format('Y-m-d') }}" {{$mode == 'tax_category_create' ? '' :
                        'required'}}>
            </div>
        @endif
    </div>
</div>
