<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Edit Tax Category - SaleTrackMate</title>
    @component('components.header_component')
    @endcomponent
</head>
<body>
@component('components.navbar_component', ['companies' => []])
@endcomponent
<div class="min-vh-100 pt-5 d-flex flex-column gradient-form">
    <div class="container mt-lg-4 mt-2 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header text-center mt-2">
                            <h4>Edit Tax Rate</h4>
                        </div>
                        <div class="card-body">
                            @if($errors->has('message'))
                                <div class="alert alert-danger text-center">
                                    {{$errors->first('message')}}
                                </div>
                                <hr/>
                            @endif
                            <form method="POST" action="{{route('tax_rate_edit_save', [
                                'tax_rate' => request()->query('tax_rate'),
                                'company' => request()->query('company')])}}">
                                @csrf <!-- {{ csrf_field() }} -->
                                @component('components.forms.tax_category_and_rate_form_component',
                                    ['mode' => 'tax_rate_edit', 'tax_categories' => $tax_categories ?? [],
                                    'tax_category' => $tax_category ?? [], 'tax_rate' => $tax_rate])
                                @endcomponent
                                <hr/>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <a href="{{route('tax_categories', ['company' =>
                                            request()->query('company')])}}" class="btn btn-outline-secondary mt-2
                                            w-100"> Back to Manage Tax Categories</a>
                                    </div>
                                    <div class="col-lg-6">
                                        <button type="submit" class="btn btn-primary mt-2 w-100">Save Changes
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
