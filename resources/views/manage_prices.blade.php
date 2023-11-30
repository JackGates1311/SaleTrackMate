<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @if($editable && (!isset($prices)))
        <title>Add new Price - SaleTrackMate</title>
    @elseif($editable && (isset($prices) && count($prices) > 0))
        <title>Edit Price - SaleTrackMate</title>
    @else
        <title>Prices - SaleTrackMate</title>
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
                                        @if($editable && (!isset($prices)))
                                            Add new Price
                                        @elseif($editable && (isset($prices) && count($prices) > 0))
                                            Edit Price
                                        @else
                                            Prices
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
                                    <form method="POST" action="{{route(isset($prices) ? 'price_edit' : 'create_price', [
                                            'company' => request()->query('company'),
                                            'good_or_service' => request()->query('good_or_service'),
                                            'price_id' => isset($prices) ? $prices[0]['id'] : null])}}">
                                        @endif
                                        @csrf <!-- {{ csrf_field() }} -->
                                        <div id="prices">
                                            @if(isset($prices) && count($prices) > 0)
                                                @foreach($prices as $price)
                                                    <div id="price">
                                                        <div class="row">
                                                            @component('components.forms.price_form_component', ['price' =>
                                                                $price, 'editable' => $editable, 'small' => false])
                                                            @endcomponent
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="row">
                                                    @component('components.forms.price_form_component', [
                                                                        'editable' => $editable, 'small' => false])
                                                    @endcomponent
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            @if($editable)
                                                <div class="col-lg-6">
                                                    <a href="{{ route('prices', [
                                                        'company' => request()->query('company'),
                                                        'good_or_service' => request()->query('good_or_service')
                                                        ]) }}" class="btn btn-outline-secondary mt-2 w-100"> Back to
                                                        Prices</a>
                                                </div>
                                                <div class="col-lg-6">
                                                    <button
                                                        class="btn btn-primary btn-block fa-lg gradient-custom-2 w-100 mt-2"
                                                        type="submit"> {{isset($price) ? 'Save' : 'Create'}}
                                                    </button>
                                                </div>
                                            @else
                                                <div class="col-lg-6">
                                                    <a href="{{ route('goods_and_services', ['company' => request()->query('company')]) }}"
                                                       class="btn btn-outline-secondary mt-2 w-100"> Back to Goods and
                                                        Services</a>
                                                </div>
                                                <div class="col-lg-6">
                                                    <a href="{{ route('create_price', [
                                                            'company' => request()->query('company'),
                                                            'good_or_service' => request()->query('good_or_service')])
                                                            }}" class="btn btn-primary mt-2 w-100">Add New Price</a>
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
    <script src="{{ asset('js/price.js') }}"></script>
@endif
</html>
