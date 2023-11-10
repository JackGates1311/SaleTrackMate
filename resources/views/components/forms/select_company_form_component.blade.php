<form method="GET" action="{{route('select_company')}}">
    <input type="hidden" name="entity" value="{{ $entity }}">
    <label class="mb-2" for="companySelect">Company:</label>
    <div class="d-flex flex-column flex-lg-row">
        <div
            class="d-flex flex-column flex-lg-row justify-content-start justify-content-lg-start w-100 w-lg-50">
            <select class="form-select mb-3 mb-lg-0 me-lg-2 w-sm-100 w-100" id="companySelect"
                    name="company"
                    onchange="this.form.submit()" {{session('company_edit') ? 'disabled' : ''}}>
                @foreach ($companies as $company)
                    <option value="{{ $company['id'] }}"
                        {{ $selected_company && $selected_company['id'] === $company['id'] ? 'selected' : '' }}>
                        {{ $company['name'] }}
                    </option>
                @endforeach
            </select>
        </div>

        @if($entity == 'companies')
            <div
                class="d-flex flex-column flex-lg-row justify-content-end justify-content-lg-end w-100 w-lg-50">
                <a data-bs-toggle="modal" data-bs-target="#bankAccountsModal"
                   class="btn btn-primary mb-3 mb-lg-0 me-lg-2" {{ session('company_edit') ? 'hidden' : ''}}>
                    Show Bank Accounts
                </a>
                <a href="{{route('bank_accounts', ['company' => $selected_company['id']])}}"
                   class="btn btn-primary mb-3 mb-lg-0 me-lg-2" {{ session('company_edit') ? '' : 'hidden'}}>
                    Manage Bank Accounts
                </a>
                <a href="{{ session('company_edit') ?
                                    route('companies', ['company' => $selected_company['id']]) :
                                    route('company_edit', ['company' => $selected_company['id']]) }}"
                   class="btn btn-primary mb-3 mb-lg-0 me-lg-2"
                    {{ session('company_edit') ? 'hidden' : ''}}>
                    Edit Company
                </a>
                <a href="{{ route('create_company_view', ['company' => request()->query('company')]) }}"
                   class="btn btn-primary" {{ session('company_edit') ? 'hidden' : ''}}>
                    Add New Company
                </a>
            </div>
        @elseif ($entity == 'recipients')
            <div
                class="d-flex flex-column flex-lg-row justify-content-end justify-content-lg-end w-100 w-lg-50"></div>
            <div
                class="d-flex flex-column flex-lg-row justify-content-end justify-content-lg-end w-100 w-lg-50"></div>
            <div
                class="d-flex flex-column flex-lg-row justify-content-end justify-content-lg-end w-100 w-lg-50">
                <a href=" {{route('create_recipient_view', ['company' => request()->query('company')])}} "
                   class="btn btn-primary mb-3 mb-lg-0 me-lg-2">
                    Add New Recipient
                </a>
            </div>
        @else
            <div
                class="d-flex flex-column flex-lg-row justify-content-end justify-content-lg-end w-100 w-lg-50">
            </div>
            <div
                class="d-flex flex-column flex-lg-row justify-content-end justify-content-lg-end w-100 w-lg-50">
            </div>
            <div
                class="d-flex flex-column flex-lg-row justify-content-end justify-content-lg-end w-100 w-lg-50">
                <a href="{{route('create_goods_and_services_view', ['company' => request()->query('company')])}}"
                   class="btn btn-primary mb-3 mb-lg-0 me-lg-2 w-100">
                    Add New Good Or Service
                </a>
            </div>
        @endif
    </div>
</form>
