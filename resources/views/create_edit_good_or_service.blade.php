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
                                @if($errors->has('message'))
                                    <div class="alert alert-danger text-center">
                                        {{$errors->first('message')}}
                                    </div>
                                    <hr/>
                                @endif
                                @if(isset($good_or_service))
                                    <form accept-charset="UTF-8" action="{{ route('good_or_service_edit_save',
                                        ['company' => request()->query('company'), 'good_or_service' =>
                                            $good_or_service['id']]) }}" method="POST"
                                          onsubmit="return validateForm('create-edit-good-or-service-form');"
                                          id="create-edit-good-or-service-form">
                                        @else
                                            <form accept-charset="UTF-8" action="{{ route('create_good_or_service',
                                                  ['company' => request()->query('company')]) }}" method="POST"
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
                                                    <div class="col-lg-2 mb-4">
                                                        <!-- Warranty Length -->
                                                        <div class="form-outline">
                                                            <label for="warranty_len" class="form-label">Warranty
                                                                (months):</label>
                                                            <input type="number" class="form-control" id="warranty_len"
                                                                   name="warranty_len" placeholder="Warranty length"
                                                                   min="0" max="100" step="1"
                                                                   value="{{ isset($good_or_service) ?
                                                                    $good_or_service['warranty_len'] ?? '0' :
                                                                    old('warranty_len') ?? '0' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 mb-4">
                                                        <!-- Unit of measure (required)-->
                                                        <div class="form-outline">
                                                            <label for="unit_of_measure_id" class="form-label">
                                                                Unit of measure:
                                                            </label>
                                                            <select type="text" class="form-select"
                                                                    id="unit_of_measure_id" name="unit_of_measure_id"
                                                                    required>
                                                                <option
                                                                    value="" {{ old('unit_of_measure_id') == '' ?
                                                                    'selected' : '' }}>
                                                                    Select unit of measure
                                                                </option>
                                                                @foreach($unit_of_measures as $unit_of_measure)
                                                                    <option value="{{ $unit_of_measure['id'] }}"
                                                                        {{ old('unit_of_measure_id',
                                                                    $good_or_service['unit_of_measure']['id'] ?? '') ==
                                                                    $unit_of_measure['id'] ? 'selected' : '' }}>
                                                                        {{ $unit_of_measure['full_name'] . ' (' .
                                                                    $unit_of_measure['abbreviation'] . ')' }}
                                                                    </option>
                                                                @endforeach
                                                                <option
                                                                    value="other" {{ old('unit_of_measure_id',
                                                                    $good_or_service['unit_of_measure']['id'] ?? '') ==
                                                                    null && isset($good_or_service) ? 'selected' : ''
                                                                    }}>Other
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 mb-4">
                                                        <!-- Type (Required) -->
                                                        <div class="form-outline">
                                                            <label for="type" class="form-label">Type:</label>
                                                            <select class="form-select" id="type" name="type">
                                                                <option value="GOOD" {{ old('type',
                                                                    $good_or_service['type'] ?? '') == 'GOOD' ?
                                                                    'selected' : '' }}>Good
                                                                </option>
                                                                <option value="SERVICE" {{ old('type',
                                                                    $good_or_service['type'] ?? '') == 'SERVICE' ?
                                                                    'selected' : '' }}>Service
                                                                </option>
                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    @if(!isset($good_or_service))
                                                        @component('components.forms.price_form_component',
                                                                    ['editable' => true, 'small' => true])
                                                        @endcomponent
                                                    @endif
                                                    <div class="col-lg-{{isset($good_or_service) ? '4' : '2'}} mb-4">
                                                        <!-- Tax Category (Optional) -->
                                                        <div class="form-outline">
                                                            <label for="tax_category_id" class="form-label">
                                                                Tax Category:
                                                            </label>
                                                            <select type="text" class="form-select" id="tax_category_id"
                                                                    name="tax_category_id" required>
                                                                <option
                                                                    value="" {{ old('tax_category_id',
                                                                    $good_or_service['tax_category']['id'] ?? '') == ''
                                                                    ? 'selected' : '' }}>
                                                                    Select tax category
                                                                </option>
                                                                @foreach($tax_categories as $tax_category)
                                                                    @if(array_key_exists('actual_percentage_value',
                                                                    $tax_category))
                                                                        <option value="{{ $tax_category['id'] }}"
                                                                            {{ old('tax_category_id',
                                                                    $good_or_service['tax_category']['id'] ?? '') ==
                                                                    $tax_category['id'] ? 'selected' : '' }}>
                                                                            {{ $tax_category['name'] }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                                <option
                                                                    value="other" {{ old('tax_category_id',
                                                                    $good_or_service['tax_category']['id'] ?? '') ==
                                                                    null && isset($good_or_service) ? 'selected' : '' }}>
                                                                    Other
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-{{isset($good_or_service) ? '8' : '4'}} mb-4">
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
                                                @component('components.forms.good_or_service_details_form_component',
                                                                    ['mode' => 'edit', 'good_or_service_details' =>
                                                                    $good_or_service['good_or_service_details'] ?? null,
                                                                    'good_or_service_image_url' =>
                                                                    $good_or_service['image_url'] ?? null])
                                                @endcomponent
                                                @component('components.forms.price_discount_form_component',
                                                            ['hidden' => true])
                                                @endcomponent
                                                <hr/>
                                                <div class="row">
                                                    <div class="col-lg-{{isset($good_or_service) ? '6' : '4'}} mb-3">
                                                        <a href="{{route('goods_and_services',
                                                                ['company' => request()->query('company')])}}"
                                                           type="button" class="btn btn-outline-secondary w-100"
                                                           data-bs-dismiss="modal">Cancel</a>
                                                    </div>
                                                    @if(!isset($good_or_service))
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
                                                    @endif
                                                    <div class="col-lg-{{isset($good_or_service) ? '6' : '4'}} mb-3">
                                                        <button
                                                            class="btn btn-primary btn-block fa-lg gradient-custom-2 w-100"
                                                            type="button"
                                                            onclick="validateForm('create-edit-good-or-service-form')">
                                                            {{isset($good_or_service) ? 'Save' : 'Create'}}
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
<script src="{{ asset('js/price.js') }}"></script>
<script src="{{ asset('js/priceDiscount.js') }}"></script>
</html>
