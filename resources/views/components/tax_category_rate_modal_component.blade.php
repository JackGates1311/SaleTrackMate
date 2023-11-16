<div class="modal fade" id="{{$name}}" tabindex="-1" aria-labelledby="{{$name}}"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-center" data-bs-dismiss="modal">
                <h5 class="modal-title w-100" id="{{$name}}Label">
                    {{$mode == 'tax_category_rates_read' ? 'Tax Rates' : ''}}
                    {{$mode == 'tax_rate_create' ? 'Add new Tax Rate' : ''}}
                    {{$mode == 'tax_category_create' ? 'Add new Tax Category' : ''}}
                    {{$mode == 'tax_category_edit' ? 'Edit Tax Category' : ''}}
                </h5>
            </div>
            <div class="modal-body">
                @if($mode == 'tax_category_rates_read')
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="text-nowrap text-center table-header-cell">VAT value (%)</th>
                            <th class="text-nowrap text-center table-header-cell">From date</th>
                            <th class="text-nowrap text-center table-header-cell">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tax_rates as $tax_rate)
                            <tr>
                                <td class="text-nowrap text-center text-middle">
                                    {{ $tax_rate['percentage_value'] }}</td>
                                <td class="text-nowrap text-center text-middle">
                                    {{ Carbon\Carbon::parse($tax_rate['from_date'])->format('M d, Y') }}
                                </td>
                                <td class="text-nowrap text-center text-middle">
                                    <div class="d-flex gap-3">
                                        <a class="form-control btn-form-control text-center cursor-pointer"
                                           href="{{route('tax_rate_edit', [
                                            'tax_rate' => $tax_rate['id'],
                                            'company' => request()->query('company')
                                            ])}}">
                                            <img src="{{ asset('images/res/edit.png') }}" alt="edit"
                                                 width="16"
                                                 height="16"
                                                 title="Edit Tax Category">
                                            <span class="visually-hidden">Edit</span>
                                        </a>
                                        <form class="w-100" method="POST"
                                              action="{{route('tax_rate_delete', [
                                                            'company' => request()->query('company'),
                                                            'tax_rate' => $tax_rate['id']])}}">
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
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-lg-9"></div>
                        <div class="col-lg-3">
                            <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal">OK</button>
                        </div>
                    </div>
                @endif
                @if($mode == 'tax_rate_create' || $mode == 'tax_category_create' || $mode == 'tax_category_edit')
                    @if($mode == 'tax_rate_create')
                        <form method="POST" action="{{route('create_tax_rate', ['company' =>
                    request()->query('company')])}}">@elseif($mode == 'tax_category_create')
                                <form method="POST" action="{{route('create_tax_category', ['company' =>
                            request()->query('company')])}}">@else
                                        <form method="POST" action="{{route('tax_category_save', [
                                'tax_category_id' => $tax_category['id'],
                                'company' => request()->query('company')])}}">@endif
                                            @csrf <!-- {{ csrf_field() }} -->
                                            @component('components.forms.tax_category_and_rate_form_component',
                                                ['mode' => $mode, 'tax_categories' => $tax_categories ?? [],
                                                'tax_category' => $tax_category ?? []])
                                            @endcomponent
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <button type="button" class="btn btn-outline-secondary mt-2 w-100"
                                                            data-bs-dismiss="modal">
                                                        Cancel
                                                    </button>
                                                </div>
                                                <div class="col-lg-6">
                                                    <button type="submit" class="btn btn-primary mt-2 w-100">
                                                        {{$mode == 'tax_category_edit' ? 'Save' : 'Create'}}
                                                    </button>
                                                </div>
                                            </div>
                                            @if(true)
                                        </form>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
