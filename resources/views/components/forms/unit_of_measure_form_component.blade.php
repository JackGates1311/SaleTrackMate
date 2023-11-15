<div class="unit-of-measure">
    <div class="row">
        <div class="col-xl-2 col-md-12 col-sm-12 mb-3">
            <label for="abbreviation" class="form-label">Abbreviation:</label>
            <input type="text" maxlength="8" class="form-control" name="abbreviation" id="abbreviation"
                   placeholder="Abbreviation" value="{{$unit_of_measure['abbreviation'] ?? old('abbreviation')}}"
                   required {{$mode == 'manage' ? 'readonly' : ''}}>
        </div>
        <div class="col-xl-3 col-md-12 col-sm-12 mb-3">
            <label for="full_name" class="form-label">Full Name:</label>
            <input type="text" maxlength="64" class="form-control" name="full_name" id="full_name"
                   placeholder="Full name" value="{{$unit_of_measure['full_name'] ?? old('full_name')}}"
                   required {{$mode == 'manage' ? 'readonly' : ''}}>
        </div>
        <div class="{{$mode == "manage" ? 'col-xl-5' : 'col-xl-7'}} col-md-12 col-sm-12 mb-3">
            <label for="description" class="form-label">Description:</label>
            <input type="text" class="form-control" name="description" id="description"
                   placeholder="Description" value="{{$unit_of_measure['description'] ?? old('description')}}"
                   required {{$mode == 'manage' ? 'readonly' : ''}}>
        </div>
        @if($mode == "manage")
            <div class="col-xl-1 mb-xl-3 d-flex justify-content-center align-items-end">
                <a class="form-control btn-form-control mt-1 text-center"
                   href="{{route('unit_of_measure_edit', [
                    'unit_of_measure' => $unit_of_measure['id'], 'company' => request()->query('company')])}}">
                    <img src="{{ asset('images/res/edit.png') }}" alt="edit"
                         width="21"
                         height="21">
                    <span class="visually-hidden">Edit</span>
                </a>
            </div>
            <div class="col-xl-1 mb-xl-3 mt-sm-3 d-flex justify-content-end align-items-end">
                <form class="w-100" method="POST" action="{{route('unit_of_measure_delete', [
                    'company' => request()->query('company'), 'unit_of_measure' => $unit_of_measure['id']])}}">
                    @csrf <!-- {{ csrf_field() }} -->
                    <button type="submit" class="form-control btn-form-control mt-1 text-center w-100">
                        <img src="{{ asset('images/res/delete.png') }}" alt="delete" width="21"
                             height="21">
                        <span class="visually-hidden">Remove</span>
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
