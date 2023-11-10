<div class="modal fade" id="unitOfMeasureModal" tabindex="-1" aria-labelledby="unitOfMeasureModal"
     aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-center" data-bs-dismiss="modal">
                <h5 class="modal-title w-100" id="unitOfMeasureModalLabel">
                    Add new Unit of Measure</h5>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('create_unit_of_measure', ['company' =>
                    request()->query('company')])}}">
                    @csrf <!-- {{ csrf_field() }} -->
                    @component('components.forms.unit_of_measure_form_component', ['mode' => 'create'])
                    @endcomponent
                    <div class="row">
                        <div class="col-lg-6">
                            <button type="button" class="btn btn-outline-secondary mt-2 w-100"
                                    data-bs-dismiss="modal">
                                Cancel
                            </button>
                        </div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-primary mt-2 w-100">Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
