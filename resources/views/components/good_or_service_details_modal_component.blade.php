<div class="modal fade" id="goodOrServiceDetailsModal{{$index ?? ''}}" tabindex="-1"
     aria-labelledby="goodOrServiceDetailsModal{{$index ?? ''}}"
     aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-center" data-bs-dismiss="modal">
                <h5 class="modal-title w-100" id="goodOrServiceDetailsModalLabel">
                    Good or Service Details</h5>
            </div>
            <div class="modal-body">
                @component('components.forms.good_or_service_details_form_component',
                            ['mode' => $mode, 'good_or_service_details' =>
                             $good_or_service_details ?? null,
                             'good_or_service_image_url' => $good_or_service_image_url ?? null])
                @endcomponent
                <div class="row">
                    <div class="col-lg-4 mb-4">
                        <div class="form-outline">
                            <label for="price_expiration" class="form-label">Price Expiration:</label>
                            <input type="text" class="form-control" id="price_expiration"
                                   value="{{ $mode == 'read' && (is_null($price['expiration_date']) ||
                                    $price['expiration_date'] === '') ? 'Unknown' :
                                    Carbon\Carbon::parse($price['expiration_date'])->format('M d, Y')}}"
                                {{$mode == 'read' ? 'readonly' : ''}}>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4">
                        <div class="form-outline">
                            <label for="unit_of_measure" class="form-label">Unit of Measure:</label>
                            <input type="text" class="form-control" id="unit_of_measure"
                                   value="{{ $mode == 'read' && !isset($unit_of_measure) ? 'Unknown' :
                                    ($unit_of_measure['full_name'] . ' (' . $unit_of_measure['abbreviation'] . ')') }}"
                                {{$mode == 'read' ? 'readonly' : ''}}>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4">
                        <div class="form-outline">
                            <label for="tax_category_rate"
                                   class="form-label">Tax Category and Rate:</label>
                            <input type="text" class="form-control" id="tax_category_rate"
                                   value="{{ $mode == 'read' && !isset($tax_category) ? 'Unknown' :
                                    ($tax_category['name'] . ' (' . ($tax_category['actual_tax_rate']
                                    ['percentage_value'] + 0 ?? 'N/A') . ' %)') }}"
                                {{$mode == 'read' ? 'readonly' : ''}}>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary w-25" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
