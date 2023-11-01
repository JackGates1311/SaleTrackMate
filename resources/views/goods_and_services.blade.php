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
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th class="text-nowrap text-center table-header-cell">Serial Number</th>
                                            <th class="text-nowrap text-center table-header-cell">Name</th>
                                            <th class="text-nowrap text-center table-header-cell">Description</th>
                                            <th class="text-nowrap text-center table-header-cell">Type</th>
                                            <th class="text-nowrap text-center table-header-cell">Warranty length</th>
                                            <th class="text-nowrap text-center table-header-cell">Image</th>
                                            <th class="text-nowrap text-center table-header-cell">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
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
