<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @if($editable && (!isset($price_discounts)))
        <title>Add new Price Discount - SaleTrackMate</title>
    @elseif($editable && (isset($price_discounts) && count($price_discounts) > 0))
        <title>Edit Price Discount - SaleTrackMate</title>
    @else
        <title>Price Discounts - SaleTrackMate</title>
    @endif
    @component('components.header_component')
    @endcomponent
</head>
<body>
@component('components.navbar_component', ['companies' => []])
@endcomponent
<div class="min-vh-100 gradient-form d-flex">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12">
                <div class="card rounded-3 text-black border-0">
                    <div class="row g-0">
                        <div class="col-lg-12">
                            <div class="card-body p-3">
                                <div class="text-center">
                                    <h4 class="mt-1 mb-3 pb-1">
                                        @if($editable && (!isset($price_discounts)))
                                            Add new Price Discount
                                        @elseif($editable && (isset($price_discounts) && count($price_discounts) > 0))
                                            Edit Price Discount
                                        @else
                                            Price Discounts
                                        @endif
                                    </h4>
                                </div>
                                <hr/>
                                @if (Session::has('message'))
                                    <div
                                        class="alert alert-success text-center mt-3">
                                        {{session('message')}}
                                    </div>
                                    <hr/>
                                @endif
                                @if($errors->has('message'))
                                    <div class="alert alert-danger text-center">
                                        {{$errors->first('message')}}
                                    </div>
                                    <hr/>
                                @endif
                                @if($editable)
                                    <form method="POST" action="{{route(isset($price_discounts) ?
                                        'price_discount_edit' : 'create_price_discount', [
                                            'company' => request()->query('company'),
                                            'good_or_service' => request()->query('good_or_service'),
                                            'price_discount_id' => isset($price_discounts) ? $price_discounts[0]['id']
                                            : null])}}">
                                        @endif
                                        @csrf <!-- {{ csrf_field() }} -->
                                        <div id="price-discounts">
                                            @if(isset($price_discounts) && count($price_discounts) > 0)
                                                @foreach($price_discounts as $price_discount)
                                                    <div id="price-discount">
                                                        @component('components.forms.price_discount_form_component',
                                                        ['price_discount' => $price_discount, 'editable' => $editable,
                                                        'hidden' => false])
                                                        @endcomponent
                                                    </div>
                                                @endforeach
                                            @else
                                                @if(!$editable)
                                                    <div
                                                        class="d-flex-row p-4 justify-content-center align-items-center">
                                                        <h5 class="text-center">This good or service doesn't have any
                                                            price discounts yet</h5>
                                                        <p class="small text-center p-3">To create price discount on
                                                            this good or service, click on button <b><i>Add New Price
                                                                    Discount</i></b></p>
                                                    </div>
                                                @else
                                                    <div class="row">
                                                        @component('components.forms.price_discount_form_component',
                                                        ['editable' => $editable,'hidden' => false])
                                                        @endcomponent
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="row">
                                            @if($editable)
                                                <div class="col-lg-6">
                                                    <a href="{{ route('price_discounts', [
                                                        'company' => request()->query('company'),
                                                        'good_or_service' => request()->query('good_or_service')
                                                        ]) }}" class="btn btn-outline-secondary mt-2 w-100"> Back to
                                                        Price Discounts</a>
                                                </div>
                                                <div class="col-lg-6">
                                                    <button
                                                        class="btn btn-primary btn-block fa-lg gradient-custom-2 w-100 mt-2"
                                                        type="submit"> {{isset($price_discount) ? 'Save' : 'Create'}}
                                                    </button>
                                                </div>
                                            @else
                                                <div class="col-lg-6">
                                                    <a href="{{ route('goods_and_services', ['company' => request()->query(
                                                            'company')]) }}"
                                                       class="btn btn-outline-secondary mt-2 w-100">
                                                        Back to Goods and Services</a>
                                                </div>
                                                <div class="col-lg-6">
                                                    <a href="{{ route('create_price_discount', [
                                                            'company' => request()->query('company'),
                                                            'good_or_service' => request()->query('good_or_service')])
                                                            }}" class="btn btn-primary mt-2 w-100">Add New Price
                                                        Discount</a>
                                                </div>
                                            @endif
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
@if($editable)
    <script src="{{ asset('js/priceDiscount.js') }}"></script>
@endif
</html>
