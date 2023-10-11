<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Register - SaleTrackMate</title>
    @component('components.header_component')
    @endcomponent
</head>
<body>
@component('components.navbar_component')
@endcomponent
<section class="min-vh-100 gradient-form d-flex justify-content-center align-items-center">
    <div class="container pb-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black border-0">
                    <div class="row g-0">
                        <div class="col-lg-12">
                            <div class="card-body p-3">
                                <div class="text-center">
                                    <h4 class="mt-1 mb-3 pb-1">Register to SaleTrackMate</h4>
                                </div>
                                <hr/>
                                <form accept-charset="UTF-8" action="{{ route('register') }}" method="POST">
                                    @csrf <!-- {{ csrf_field() }} -->
                                    <div class="row">
                                        <div class="col-xl-4">
                                            <div class="form-outline mb-4">
                                                <label class="form-label" for="first_name">First Name:</label>
                                                <input type="text" id="first_name" name="first_name"
                                                       class="form-control" placeholder="Your first name"
                                                       value="{{old('first_name')}}" required/>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-outline mb-4">
                                                <label class="form-label" for="middle_name">Middle Name:</label>
                                                <input type="text" id="middle_name" name="middle_name"
                                                       class="form-control"
                                                       placeholder="Your middle name (optional)"
                                                       value="{{old('middle_name')}}"/>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-outline mb-4">
                                                <label class="form-label" for="last_name">Last Name:</label>
                                                <input type="text" id="last_name" name="last_name" class="form-control"
                                                       placeholder="Your last name" value="{{old('last_name')}}"
                                                       required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-outline mb-4">
                                                <label class="form-label" for="username">Username:</label>
                                                <input type="text" id="username" name="username" class="form-control"
                                                       placeholder="Your username" value="{{old('username')}}"
                                                       minlength="5" required/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-outline mb-4">
                                                <label class="form-label" for="email">Email:</label>
                                                <input type="email" id="email" name="email" class="form-control"
                                                       placeholder="Your email address" value="{{old('email')}}"
                                                       required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-outline mb-4">
                                                <label class="form-label" for="password">Password:</label>
                                                <input type="password" id="password" name="password"
                                                       class="form-control" placeholder="Your password"
                                                       value="{{old('password')}}" minlength="8" required/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-outline mb-4">
                                                <label class="form-label" for="password_repeat">Repeat Password:</label>
                                                <input type="password" id="password_repeat" name="passwordRepeat"
                                                       class="form-control" placeholder="Repeat your password"
                                                       value="{{old('password_repeat')}}" minlength="8" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-outline mb-4">
                                                @component('components.country_dropdown_component')
                                                @endcomponent
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-outline mb-4">
                                                <label class="form-label" for="city">City:</label>
                                                <input type="text" id="city" name="city" class="form-control"
                                                       placeholder="Your city" value="{{old('city')}}" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-outline mb-4">
                                                <label class="form-label" for="postal_code">Postal Code:</label>
                                                <input type="text" id="postal_code" name="postal_code"
                                                       class="form-control" placeholder="Your postal code"
                                                       value="{{old('postal_code')}}" required/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-outline mb-4">
                                                <label class="form-label" for="address">Address:</label>
                                                <input type="text" id="address" name="address" class="form-control"
                                                       placeholder="Your address" value="{{old('address')}}" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-outline mb-4">
                                                <label class="form-label" for="phone">Phone:</label>
                                                <input type="tel" id="phone" name="phone" class="form-control"
                                                       placeholder="Your phone number" value="{{old('phone')}}"
                                                       required/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-outline mb-4">
                                                <label class="form-label" for="fax">Fax:</label>
                                                <input type="tel" id="fax" name="fax" class="form-control"
                                                       placeholder="Your fax number (optional)"
                                                       value="{{old('fax')}}"/>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($errors->has('error'))
                                        <div class="alert alert-danger mb-4 text-center">
                                            {{$errors->first('error')}}</div>
                                    @endif
                                    <div class="text-center pt-1">
                                        <button class="btn btn-primary btn-block fa-lg gradient-custom-2 w-100"
                                                type="submit">Register
                                        </button>
                                    </div>
                                </form>
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
