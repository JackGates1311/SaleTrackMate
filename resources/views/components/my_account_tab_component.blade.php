<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header text-center mt-2">
                <h4>{{session('account_edit') ? 'Edit My Account' : 'My Account'}}</h4>
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 mb-3">
                            <label for="first_name" class="form-label">First Name:</label>
                            <input type="text" class="form-control" id="first_name"
                                   value="{{session()->get('user_data')['first_name']}}"
                                {{ session('account_edit') ? '' : 'readonly'}}>
                        </div>
                        <div class="col-lg-3 col-sm-6 mb-3">
                            <label for="middle_name" class="form-label">Middle Name:</label>
                            <input type="text" class="form-control" id="middle_name"
                                   value="{{session()->get('user_data')['middle_name']}}"
                                {{ session('account_edit') ? '' : 'readonly'}}>
                        </div>
                        <div class="col-lg-3 col-sm-6 mb-3">
                            <label for="last_name" class="form-label">Last Name:</label>
                            <input type="text" class="form-control" id="last_name"
                                   value="{{session()->get('user_data')['last_name']}}"
                                {{ session('account_edit') ? '' : 'readonly'}}>
                        </div>
                        <div class="col-lg-3 col-sm-6 mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" class="form-control" id="username"
                                   value="{{session()->get('user_data')['username']}}"
                                {{ session('account_edit') ? '' : 'readonly'}}>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-sm-12 mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email"
                                   value="{{session()->get('user_data')['email']}}"
                                {{ session('account_edit') ? '' : 'readonly'}}>
                        </div>
                        <div class="col-lg-4 col-sm-6 mb-3">
                            <label for="phone" class="form-label">Phone:</label>
                            <input type="tel" class="form-control" id="phone"
                                   value="{{session()->get('user_data')['phone']}}"
                                {{ session('account_edit') ? '' : 'readonly'}}>
                        </div>
                        <div class="col-lg-4 col-sm-6 mb-3">
                            <label for="fax" class="form-label">Fax:</label>
                            <input type="text" class="form-control" id="fax"
                                   value="{{session()->get('user_data')['fax']}}"
                                {{ session('account_edit') ? '' : 'readonly'}}>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-3 mb-3">
                            <label for="country" class="form-label">Country:</label>
                            <input type="text" class="form-control" id="country"
                                   value="{{session()->get('user_data')['country']}}"
                                {{ session('account_edit') ? '' : 'readonly'}}>
                        </div>
                        <div class="col-lg-2 col-sm-4 mb-3">
                            <label for="postal_code" class="form-label">Postal Code:</label>
                            <input type="text" class="form-control" id="postal_code"
                                   value="{{session()->get('user_data')['postal_code']}}"
                                {{ session('account_edit') ? '' : 'readonly'}}>
                        </div>
                        <div class="col-lg-4 col-sm-5 mb-3">
                            <label for="city" class="form-label">City:</label>
                            <input type="text" class="form-control" id="city"
                                   value="{{session()->get('user_data')['city']}}"
                                {{ session('account_edit') ? '' : 'readonly'}}>
                        </div>
                        <div class="col-lg-4 col-sm-12 mb-3">
                            <label for="address" class="form-label">Address:</label>
                            <input class="form-control" id="address" value="{{session()->get('user_data')['address']}}"
                                {{ session('account_edit') ? '' : 'readonly'}}>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-lg-6">
                        <button class="btn btn-primary mt-3 w-100" data-bs-toggle="modal"
                                data-bs-target="#changePasswordModal" hidden>
                            Change Password
                        </button>
                    </div>
                    <div class="col-lg-6">
                        <a href="{{ session('account_edit') ? route('account') : route('account_edit') }}"
                           class="btn btn-primary mt-3 w-100" hidden>
                            {{session('account_edit') ? 'Save Changes' : 'Edit My Account'}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@component('components.change_password_modal_component')
@endcomponent
