<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Goods and Services - SaleTrackMate</title>
    @component('components.header_component')
    @endcomponent
</head>
<body>
@component('components.navbar_component')
@endcomponent
<section class="min-vh-100 gradient-form d-flex">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-12">
                <div class="card rounded-3 text-black border-0">
                    <div class="row g-0">
                        <div class="col-lg-12">
                            <div class="card-body p-3">
                                <div class="text-center">
                                    <h4 class="mt-1 mb-3 pb-1">Goods and Services</h4>
                                </div>
                                <hr/>
                                @if(isset($companies) && count($companies) > 0)
                                    @component('components.forms.select_company_form_component', [
                                        'companies' => $companies, 'selected_company' => $selected_company,
                                        'entity' => 'goods_and_services'])
                                    @endcomponent
                                @endif
                                <hr/>
                                @if (Session::has('message'))
                                    <div
                                        class="alert alert-success text-center {{session('company_create') ? 'mt-1' : 'mt-3'}}">
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
                                <div class="table-responsive pt-2">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-nowrap text-center table-header-cell align-middle"></th>
                                            <th class="text-nowrap text-center table-header-cell align-middle">
                                                Serial Number
                                            </th>
                                            <th class="text-nowrap text-center table-header-cell align-middle">Name</th>
                                            <th class="text-nowrap text-center table-header-cell align-middle">
                                                Description
                                            </th>
                                            <th class="text-nowrap text-center table-header-cell align-middle">Type</th>
                                            <th class="text-nowrap text-center table-header-cell align-middle">
                                                Warranty length
                                            </th>
                                            <th class="text-nowrap text-center table-header-cell align-middle">
                                                Actual Price
                                            </th>
                                            <th class="text-nowrap text-center table-header-cell align-middle">Image
                                            </th>
                                            <th class="text-nowrap text-center table-header-cell align-middle">Actions
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($goods_or_services as $i=>$good_or_service)
                                            <tr>
                                                <td class="text-nowrap text-center text-middle">
                                                    {{ $loop->index + 1 }}</td>
                                                <td class="text-nowrap text-center text-middle">{{
                                                    $good_or_service['serial_num'] }}</td>
                                                <td class="text-nowrap text-center text-middle">{{
                                                    $good_or_service['name'] }}</td>
                                                <td class="text-center text-middle">{{
                                                    $good_or_service['description'] }}</td>
                                                <td class="text-nowrap text-center text-middle">{{
                                                    $good_or_service['type'] }}</td>
                                                <td class="text-nowrap text-center text-middle">{{
                                                    $good_or_service['warranty_len'] }} (months)
                                                </td>
                                                <td class="text-nowrap text-center text-middle">{{
                                                    $good_or_service['actual_price']['amount'] }} <br>
                                                    @if($good_or_service['actual_price']['all_prices_expired'])
                                                        <div class="text-danger">
                                                            Price is expired
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="text-nowrap text-center text-middle">
                                                    <img src="{{ $good_or_service['image_url'] }}" alt="-"
                                                         class="img-table">
                                                </td>
                                                <td class="text-nowrap text-center text-middle">
                                                    <div class="d-flex gap-3">
                                                        <a class="form-control btn-form-control text-center
                                                        cursor-pointer" data-bs-toggle="modal"
                                                           data-bs-target="#goodOrServiceDetailsModal{{$i}}">
                                                            <img src="{{ asset('images/res/info.png') }}"
                                                                 alt="bank accounts"
                                                                 width="16"
                                                                 height="16"
                                                                 title="Show Good or Service details">
                                                            <span class="visually-hidden">Good or Service details</span>
                                                        </a>
                                                        <a class="form-control btn-form-control text-center
                                                        cursor-pointer" href="{{route('good_or_service_prices', [
                                                            'company' => request()->query('company'),
                                                            'good_or_service' => $good_or_service['id']])}}">
                                                            <img src="{{ asset('images/res/monetization.png') }}"
                                                                 alt="bank accounts"
                                                                 width="16"
                                                                 height="16"
                                                                 title="Good or Service Prices">
                                                            <span class="visually-hidden">Good or Service Prices</span>
                                                        </a>
                                                        <a class="form-control btn-form-control text-center
                                                        cursor-pointer" href="{{route('good_or_service_price_discounts',
                                                            ['company' => request()->query('company'),
                                                            'good_or_service' => $good_or_service['id']])}}">
                                                            <img src="{{ asset('images/res/payments.png') }}"
                                                                 alt="bank accounts"
                                                                 width="16"
                                                                 height="16"
                                                                 title="Good or Service Price Discounts">
                                                            <span class="visually-hidden">Good or Service Price
                                                                Discounts</span>
                                                        </a>
                                                        <a class="form-control btn-form-control text-center
                                                        cursor-pointer"
                                                           href="{{route('good_or_service_edit',
                                                                ['good_or_service' => $good_or_service['id'],
                                                                'company' => request()->query('company')])}}">
                                                            <img src="{{ asset('images/res/edit.png') }}" alt="edit"
                                                                 width="16"
                                                                 height="16"
                                                                 title="Edit recipient">
                                                            <span class="visually-hidden">Edit</span>
                                                        </a>
                                                        <form class="w-100" method="POST"
                                                              action="{{route('recipient_delete',
                                                                ['recipient' => null,
                                                                'company' => request()->query('company')])}}">
                                                            @csrf <!-- {{ csrf_field() }} -->
                                                            <button type="submit"
                                                                    class="form-control btn-form-control text-center
                                                                     cursor-pointer w-100">
                                                                <img src="{{ asset('images/res/delete.png') }}"
                                                                     alt="delete" width="16"
                                                                     height="16" title="Delete Recipient">
                                                                <span class="visually-hidden">Remove</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(isset($good_or_service->toArray()['good_or_service_details']))
                                                @component('components.good_or_service_details_modal_component',
                                                ['good_or_service_details' =>
                                                $good_or_service->toArray()['good_or_service_details'],
                                                    'price' => $good_or_service->toArray()['prices'][0],
                                                    'tax_category' => $good_or_service->toArray()['tax_category'],
                                                    'unit_of_measure' => $good_or_service->toArray()['unit_of_measure'],
                                                    'mode' => 'read',
                                                    'index' => $i])
                                                @endcomponent
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
