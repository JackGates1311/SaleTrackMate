<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{isset($good_or_service) ? 'Edit' : 'Add New'}} Good or Service - SaleTrackMate</title>
    @component('components.header_component')
    @endcomponent
</head>
<body>
@component('components.navbar_component', ['companies' => []])
@endcomponent
<div class="min-vh-100 pt-5 d-flex flex-column gradient-form">
    <div class="container mt-lg-4 mt-2 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-12">
                <div class="card rounded-3 text-black border-0">
                    <div class="row g-0">
                        <div class="col-lg-12">
                            <div class="card-body p-3">
                                <div class="text-center">
                                    <h4 class="mt-1 mb-3 pb-1">
                                        @if(isset($good_or_service))
                                            Edit Good or Service
                                        @else
                                            Add New Good or Service
                                        @endif
                                    </h4>
                                </div>
                                <hr/>
                                @if(isset($good_or_service))
                                    <form accept-charset="UTF-8" action="{{ route('recipient_edit_save',
                                        ['company' => request()->query('company')]) }}" method="POST"
                                          onsubmit="return validateForm('create-edit-good-or-service-form');"
                                          id="create-edit-good-or-service-form">
                                        @else
                                            <form accept-charset="UTF-8" action="{{ route('create_good_or_service',
                                                  ['company_id' => request()->query('company')]) }}" method="POST"
                                                  onsubmit="return validateForm('create-edit-good-or-service-form');"
                                                  id="create-edit-good-or-service-form">@endif
                                                @csrf <!-- {{ csrf_field() }} -->
                                                @if(isset($good_or_service))
                                                    <input type="hidden" name="good_or_service"
                                                           value="{{ $good_or_service['id'] }}">
                                                @endif
                                                <div class="row">
                                                    <div class="col-lg-2 mb-4">
                                                        <!-- Serial Number (Required) -->
                                                        <div class="form-outline">
                                                            <label for="serial_num" class="form-label">Serial
                                                                Number:</label>
                                                            <input type="text" class="form-control" id="serial_num"
                                                                   name="serial_num"
                                                                   placeholder="Serial number"
                                                                   value="{{ isset($good_or_service) ?
                                                                    $good_or_service['serial_num'] :
                                                                    old('serial_num') }}"
                                                                   required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 mb-4">
                                                        <!-- Name (Required) -->
                                                        <div class="form-outline">
                                                            <label for="name" class="form-label">Name:</label>
                                                            <input type="text" class="form-control" id="name"
                                                                   name="name" placeholder="Name"
                                                                   value="{{ isset($good_or_service) ? $good_or_service['name'] : old('name') }}"
                                                                   required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 mb-4">
                                                        <!-- Warranty Length (Optional) -->
                                                        <div class="form-outline">
                                                            <label for="warranty_len" class="form-label">Warranty
                                                                Length (months):</label>
                                                            <input type="number" class="form-control" id="warranty_len"
                                                                   name="warranty_len" placeholder="Warranty length"
                                                                   min="0" max="100" step="1"
                                                                   value="{{ isset($good_or_service) ?
                                                                    $good_or_service['warranty_len'] ?? '0' :
                                                                    old('warranty_len') ?? '0' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 mb-4">
                                                        <!-- Warranty Length (Optional) -->
                                                        <div class="form-outline">
                                                            <label for="unit_of_measure_id" class="form-label">
                                                                Unit of measure:
                                                            </label>
                                                            <select type="text" class="form-select"
                                                                    id="unit_of_measure_id"
                                                                    name="unit_of_measure_id">
                                                                <option value="">Select unit of measure</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 mb-4">
                                                        <!-- Type (Required) -->
                                                        <div class="form-outline">
                                                            <label for="type" class="form-label">Type:</label>
                                                            <select class="form-select" id="type" name="type">
                                                                <option value="GOOD"
                                                                    {{old('type')  == "GOOD" ? 'selected' : ''}}>
                                                                    Good
                                                                </option>
                                                                <option value="SERVICE"
                                                                    {{old('type')  == "SERVICE" ? 'selected' : ''}}>
                                                                    Service
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-3 mb-4">
                                                        <!-- Price Amount (Required) -->
                                                        <div class="form-outline">
                                                            <label for="price_amount" class="form-label">Price:</label>
                                                            <input type="number" class="form-control" id="price_amount"
                                                                   name="price[amount]" step="0.01"
                                                                   placeholder="Price"
                                                                   value="{{ isset($good_or_service) ?
                                                                $good_or_service['price']['amount'] ?? '' :
                                                                old('price.amount') ?? '' }}"
                                                                   required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 mb-4">
                                                        <!-- Price Expiration Date (Required) -->
                                                        <div class="form-outline">
                                                            <label for="price_expiration_date" class="form-label">Price
                                                                Expiration Date:</label>
                                                            <input type="datetime-local" class="form-control"
                                                                   id="price_expiration_date"
                                                                   name="price[expiration_date]"
                                                                   value="{{
                                                                    isset($good_or_service) ?
                                                                    $good_or_service['price']['expiration_date'] :
                                                                    old('price.expiration_date') }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 mb-4">
                                                        <!-- Tax Category (Optional) -->
                                                        <div class="form-outline">
                                                            <label for="tax_category_id" class="form-label">
                                                                Tax Category:
                                                            </label>
                                                            <select type="text" class="form-select"
                                                                    id="tax_category_id"
                                                                    name="tax_category_id">
                                                                <option value="">Select tax category</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 mb-4">
                                                        <!-- Description (Required) -->
                                                        <div class="form-outline">
                                                            <label for="description"
                                                                   class="form-label">Description:</label>
                                                            <input type="text" class="form-control" id="description"
                                                                   name="description"
                                                                   placeholder="Description"
                                                                   value="{{
                                                                    isset($good_or_service) ?
                                                                    $good_or_service['description'] :
                                                                    old('description') }}" required/>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-3 mb-4">
                                                        <!-- URL (Required for Goods) -->
                                                        <div class="form-outline">
                                                            <label for="url" class="form-label">Website URL:</label>
                                                            <input type="text" class="form-control" id="url"
                                                                   name="good_or_service_details[url]"
                                                                   value="{{ isset($good_or_service) ?
                                                                        $good_or_service['good_or_service_details']
                                                                        ['url'] : old('good_or_service_details.url') }}"
                                                                   placeholder="Website URL (optional)">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 mb-4">
                                                        <!-- Image URL (Required) -->
                                                        <div class="form-outline">
                                                            <label for="image_url" class="form-label">Image URL:</label>
                                                            <input type="text" class="form-control" id="image_url"
                                                                   name="image_url" placeholder="Image URL (optional)"
                                                                   value="{{ isset($good_or_service) ? $good_or_service['image_url'] : old('image_url') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 mb-4">
                                                        <!-- Supplier (Required for Goods) -->
                                                        <div class="form-outline">
                                                            <label for="supplier" class="form-label">Supplier:</label>
                                                            <input type="text" class="form-control" id="supplier"
                                                                   name="good_or_service_details[supplier]"
                                                                   placeholder="Supplier (optional)"
                                                                   value="{{ isset($good_or_service) ?
                                                                   $good_or_service['good_or_service_details']['supplier'] :
                                                                   old('good_or_service_details.supplier') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 mb-4">
                                                        <!-- Country Origin (Required for Goods) -->
                                                        <div class="form-outline">
                                                            @component('components.country_dropdown_component',
                                                                ['selected_country' =>
                                                                isset($good_or_service) ?
                                                                $good_or_service['country'] : old('country'),
                                                                'required' => false])
                                                            @endcomponent
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
                                                                   value="{{ isset($good_or_service) ? $good_or_service['good_or_service_details']['category'] :
                                                                old('good_or_service_details.category') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 mb-4">
                                                        <!-- Weight (Required for Goods) -->
                                                        <div class="form-outline">
                                                            <label for="weight" class="form-label">Weight:</label>
                                                            <input type="number" class="form-control" id="weight"
                                                                   name="good_or_service_details[weight]" step="0.01"
                                                                   min="0.01" placeholder="Weight (optional)"
                                                                   value="{{ isset($good_or_service) ?
                                                                $good_or_service['good_or_service_details']['weight']
                                                                : old('good_or_service_details.weight')}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 mb-4">
                                                        <!-- Color (Required for Goods) -->
                                                        <div class="form-outline">
                                                            <label for="color" class="form-label">Color:</label>
                                                            <input type="text" class="form-control" id="color"
                                                                   name="good_or_service_details[color]"
                                                                   placeholder="Color (optional)"
                                                                   value="{{ isset($good_or_service) ? $good_or_service['good_or_service_details']['color'] : old('good_or_service_details.color') }}">
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
                                                                   value="{{ isset($good_or_service) ?
                                                                $good_or_service['good_or_service_details']['dimensions']
                                                                : old('good_or_service_details.dimensions') }}">
                                                        </div>
                                                    </div>
                                                    @component('components.forms.price_discount_form_component',
                                                                ['hidden' => true])
                                                    @endcomponent
                                                </div>

                                                <hr/>
                                                <div class="row">
                                                    <div class="col-lg-4 mb-3">
                                                        <a href="{{route('goods_and_services',
                                                                ['company' => request()->query('company')])}}"
                                                           type="button" class="btn btn-outline-secondary w-100"
                                                           data-bs-dismiss="modal">Cancel</a>
                                                    </div>
                                                    <div class="col-lg-4 mb-3">
                                                        <a class="btn btn-primary btn-block fa-lg gradient-custom-2
                                                            w-100" onclick="showPriceDiscountFields()"
                                                           id="add-price-discount-button">
                                                            Add Price Discount
                                                        </a>
                                                        <a class="btn btn-primary btn-block fa-lg gradient-custom-2
                                                            w-100" onclick="removePriceDiscountFields()"
                                                           id="remove-price-discount-button" hidden>
                                                            Remove Price Discount
                                                        </a>
                                                    </div>
                                                    <div class="col-lg-4 mb-3">
                                                        <button
                                                            class="btn btn-primary btn-block fa-lg gradient-custom-2 w-100"
                                                            type="button"
                                                            onclick="validateForm('create-edit-good-or-service-form')">
                                                            {{isset($recipient) ? 'Save' : 'Create'}}
                                                        </button>
                                                    </div>
                                                </div>
                                                @if(true)
                                            </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="{{ asset('js/validateForm.js') }}"></script>
<script src="{{ asset('js/goodAndService.js') }}"></script>
</html>