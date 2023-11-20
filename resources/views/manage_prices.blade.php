<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{$editable ? 'Edit Price' : 'Prices'}} - SaleTrackMate</title>
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
                                        {{$editable ? 'Edit Price' : 'Prices'}}</h4>
                                </div>
                                <hr/>
                                @if(!$editable)
                                    <div class="d-flex flex-column flex-lg-row">
                                        <div
                                            class="d-flex flex-column flex-lg-row justify-content-end
                                        justify-content-lg-end w-100 w-lg-50">
                                            <a class="btn btn-primary mb-lg-0 me-lg-2" data-bs-toggle="modal"
                                               data-bs-target="#unitOfMeasureModal">
                                                Add New Price
                                            </a>
                                        </div>
                                    </div>
                                    <hr/>
                                @endif
                                @if (Session::has('message'))
                                    <div
                                        class="alert alert-success text-center {{session('company_create') ? 'mt-1' :
                                        'mt-3'}}">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
