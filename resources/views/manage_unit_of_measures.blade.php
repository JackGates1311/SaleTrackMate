<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Unit of Measures - SaleTrackMate</title>
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
                                    <h4 class="mt-1 mb-3 pb-1">Unit of Measures</h4>
                                </div>
                                <hr/>
                                <div class="d-flex flex-column flex-lg-row">
                                    <div
                                        class="d-flex flex-column flex-lg-row justify-content-end
                                        justify-content-lg-end w-100 w-lg-50">
                                        <a class="btn btn-primary mb-lg-0 me-lg-2" data-bs-toggle="modal"
                                           data-bs-target="#unitOfMeasureModal">
                                            Add New Unit Of Measure
                                        </a>
                                    </div>
                                </div>
                                <hr/>
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
                                @if(isset($unit_of_measures) && count($unit_of_measures) > 0)
                                    <div id="unit-of-measures">
                                        @foreach($unit_of_measures as $unit_of_measure)
                                            @component('components.forms.unit_of_measure_form_component',
                                            ['mode' => 'manage', 'unit_of_measure' => $unit_of_measure])
                                            @endcomponent
                                            @if(!$loop->last)
                                                <hr/>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <div
                                        class="d-flex-row p-4 justify-content-center align-items-center">
                                        <h5 class="text-center">It looks like you haven't created any unit of measure
                                            yet</h5>
                                        <p class="small text-center p-3">To create your first unit of measure, click
                                            on button <b><i>Add New Unit Of Measure</i></b></p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@component('components.unit_of_measures_modal_component')
@endcomponent
</body>
</html>
