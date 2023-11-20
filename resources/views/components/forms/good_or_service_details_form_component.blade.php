<div class="row">
    <div class="col-lg-{{$mode == 'edit' ? '3' : '5'}} mb-4">
        <!-- URL (Required for Goods) -->
        <div class="form-outline">
            <label for="url" class="form-label">Website URL:</label>
            <input type="text" class="form-control" id="url"
                   name="good_or_service_details[url]"
                   value="{{ $mode == 'read' && (is_null($good_or_service_details['url']) ||
                    $good_or_service_details['url'] === '') ? 'Unknown' : (isset($good_or_service_details) ?
                    $good_or_service_details['url'] : old('good_or_service_details.url')) }}"
                   placeholder="Website URL (optional)" {{$mode == 'read' ? 'readonly' : ''}}>
        </div>
    </div>
    @if($mode == 'edit')
        <div class="col-lg-3 mb-4">
            <!-- Image URL (Required) -->
            <div class="form-outline">
                <label for="image_url" class="form-label">Image URL:</label>
                <input type="text" class="form-control" id="image_url"
                       name="image_url" placeholder="Image URL (optional)"
                       value="{{ $good_or_service_image_url ?? old('good_or_service_details.image_url') }}">
            </div>
        </div>
    @endif
    <div class="col-lg-{{$mode == 'edit' ? '3' : '5'}} mb-4">
        <!-- Supplier (Required for Goods) -->
        <div class="form-outline">
            <label for="supplier" class="form-label">Supplier:</label>
            <input type="text" class="form-control" id="supplier"
                   name="good_or_service_details[supplier]"
                   placeholder="Supplier (optional)"
                   value="{{ $mode == 'read' && (is_null($good_or_service_details['supplier']) ||
                    $good_or_service_details['supplier'] === '') ? 'Unknown' : (isset($good_or_service_details) ?
                    $good_or_service_details['supplier'] : old('good_or_service_details.supplier')) }}"
                {{$mode == 'read' ? 'readonly' : ''}}>
        </div>
    </div>
    <div class="col-lg-{{$mode == 'edit' ? '3' : '2'}} mb-4">
        <!-- Country Origin (Required for Goods) -->
        <div class="form-outline">
            @if($mode == 'edit')
                @component('components.country_dropdown_component',
                    ['selected_country' => $good_or_service_details['country'] ??
                    old('good_or_service_details.country'),
                    'required' => false])
                @endcomponent
            @endif
            @if($mode == 'read')
                <label for="country" class="form-label">Country:</label>
                <input type="text" class="form-control" id="country"
                       name="good_or_service_details[country]"
                       placeholder="Country (optional)"
                       value="{{ (is_null($good_or_service_details['country']) ||
                    $good_or_service_details['country'] === '') ? 'Unknown' : $good_or_service_details['country'] }}"
                       readonly>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 mb-4">
        <!-- Category (Required for Goods) -->
        <div class="form-outline">
            <label for="category" class="form-label">Category:</label>
            <input type="text" class="form-control" id="category"
                   name="good_or_service_details[category]"
                   placeholder="Category (optional)"
                   value="{{ $mode == 'read' && (is_null($good_or_service_details['category']) ||
                    $good_or_service_details['category'] === '') ? 'Unknown' : (isset($good_or_service_details) ?
                    $good_or_service_details['category'] : old('good_or_service_details.category')) }}"
                {{$mode == 'read' ? 'readonly' : ''}}>
        </div>
    </div>
    <div class="col-lg-3 mb-4">
        <!-- Weight (Required for Goods) -->
        <div class="form-outline">
            <label for="weight" class="form-label">Weight (grams):</label>
            <input type="{{$mode == 'read' ? 'text' : 'number'}}" class="form-control" id="weight"
                   name="good_or_service_details[weight]" step="0.01"
                   min="0.01" placeholder="Weight in grams (optional)"
                   value="{{ $mode == 'read' && (is_null($good_or_service_details['weight']) ||
                    $good_or_service_details['weight'] === '') ? 'Unknown' : (isset($good_or_service_details) ?
                    $good_or_service_details['weight'] : old('good_or_service_details.weight'))}}"
                {{$mode == 'read' ? 'readonly' : ''}}>
        </div>
    </div>
    <div class="col-lg-3 mb-4">
        <!-- Color (Required for Goods) -->
        <div class="form-outline">
            <label for="color" class="form-label">Color:</label>
            <input type="text" class="form-control" id="color"
                   name="good_or_service_details[color]"
                   placeholder="Color (optional)"
                   value="{{ $mode == 'read' && (is_null($good_or_service_details['color']) ||
                    $good_or_service_details['color'] === '') ? 'Unknown' : (isset($good_or_service_details) ?
                    $good_or_service_details['color'] : old('good_or_service_details.color')) }}"
                {{$mode == 'read' ? 'readonly' : ''}}>
        </div>
    </div>
    <div class="col-lg-3 mb-4">
        <!-- Dimensions (Required for Goods) -->
        <div class="form-outline">
            <label for="dimensions"
                   class="form-label">Dimensions:</label>
            <input type="text" class="form-control" id="dimensions"
                   name="good_or_service_details[dimensions]"
                   placeholder="Dimensions (optional)"
                   value="{{ $mode == 'read' && (is_null($good_or_service_details['dimensions']) ||
                    $good_or_service_details['dimensions'] === '') ? 'Unknown' : (isset($good_or_service_details) ?
                    $good_or_service_details['dimensions'] : old('good_or_service_details.dimensions')) }}"
                {{$mode == 'read' ? 'readonly' : ''}}>
        </div>
    </div>
</div>
