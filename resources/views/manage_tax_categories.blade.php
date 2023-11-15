<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{$editable ? 'Edit Tax Category' : 'Tax Categories'}} - SaleTrackMate</title>
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
                                        {{$editable ? 'Edit Tax Category' : 'Tax Categories'}}</h4>
                                </div>
                                <hr/>
                                <div class="d-flex flex-column flex-lg-row">
                                    <div
                                        class="d-flex flex-column flex-lg-row justify-content-end
                                        justify-content-lg-end w-100 w-lg-50">
                                        <a class="btn btn-primary mb-3 mb-lg-0 me-lg-2" data-bs-toggle="modal"
                                           data-bs-target="#taxRateModal">
                                            Add New Tax Rate To Existing Category
                                        </a>
                                        <a class="btn btn-primary mb-3 mb-lg-0 me-lg-2" data-bs-toggle="modal"
                                           data-bs-target="#taxCategoryModal">
                                            Add New Tax Category
                                        </a>
                                    </div>
                                </div>
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
                                            <th class="text-nowrap text-center table-header-cell">Name</th>
                                            <th class="text-nowrap text-center table-header-cell">Actual VAT value
                                                (%)
                                            </th>
                                            <th class="text-nowrap text-center table-header-cell">In use since</th>
                                            <th class="text-nowrap text-center table-header-cell">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($tax_categories['tax_categories'] as $i=>$tax_category)
                                            <tr>
                                                <td class="text-nowrap text-center text-middle">
                                                    {{ $tax_category['name'] }}</td>
                                                <td class="text-nowrap text-center text-middle">
                                                    @if(isset($tax_category['actual_percentage_value']))
                                                        {{$tax_category['actual_percentage_value']}}
                                                    @else
                                                        {{$tax_category['staged_percentage_value']}} <br>
                                                        (Not in usage yet)
                                                    @endif
                                                </td>
                                                <td class="text-center text-middle">
                                                    @if(isset($tax_category['actual_from_date']))
                                                        {{Carbon\Carbon::parse($tax_category['actual_from_date'])->
                                                            format('M d, Y')}}
                                                    @else
                                                        Usage starts from
                                                        {{Carbon\Carbon::parse($tax_category['staged_from_date'])->
                                                            format('M d, Y')}}
                                                    @endif
                                                </td>
                                                <td class="text-nowrap text-center text-middle">
                                                    <div class="d-flex gap-3">
                                                        <a class="form-control btn-form-control text-center
                                                        cursor-pointer" data-bs-toggle="modal" data-bs-target="
                                                           #taxCategoryRatesModal{{$tax_category['id']}}">
                                                            <img src="{{ asset('images/res/percent.png') }}"
                                                                 alt="vat_history"
                                                                 width="16"
                                                                 height="16"
                                                                 title="Tax Rate History">
                                                            <span class="visually-hidden">Tax Rate History</span>
                                                        </a>
                                                        <a class="form-control btn-form-control text-center
                                                        cursor-pointer" data-bs-toggle="modal" data-bs-target="
                                                           #taxCategoryEditModal{{$tax_category['id']}}">
                                                            <img src="{{ asset('images/res/edit.png') }}" alt="edit"
                                                                 width="16"
                                                                 height="16"
                                                                 title="Edit Tax Category">
                                                            <span class="visually-hidden">Edit</span>
                                                        </a>
                                                        <form class="w-100" method="POST"
                                                              action="{{route('tax_category_delete', [
                                                            'company' => request()->query('company'),
                                                            'tax_category' => $tax_category['id']
                                                            ])}}">
                                                            @csrf <!-- {{ csrf_field() }} -->
                                                            <button type="submit"
                                                                    class="form-control btn-form-control text-center
                                                                     cursor-pointer w-100">
                                                                <img src="{{ asset('images/res/delete.png') }}"
                                                                     alt="delete" width="16"
                                                                     height="16" title="Delete Tax Category">
                                                                <span class="visually-hidden">Remove</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    @component('components.tax_category_rate_modal_component',
                                                        ['name' => 'taxCategoryRatesModal' . $tax_category['id'],
                                                         'mode' => 'tax_category_rates_read',
                                                        'tax_rates' => $tax_category['tax_rates']])
                                                    @endcomponent
                                                </td>
                                            </tr>
                                            @component('components.tax_category_rate_modal_component',
                                                ['name' => 'taxCategoryEditModal' . $tax_category['id'],
                                                 'mode' => 'tax_category_edit',
                                                 'tax_category' => $tax_category])
                                            @endcomponent
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
</div>
@component('components.tax_category_rate_modal_component', ['name' => 'taxCategoryModal',
                                                            'mode' => 'tax_category_create', 'tax_categories' => []])
@endcomponent
@component('components.tax_category_rate_modal_component', ['name' => 'taxRateModal', 'mode' => 'tax_rate_create',
                                                            'tax_categories' => $tax_categories['tax_categories']])
@endcomponent

</body>
</html>
