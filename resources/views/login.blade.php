<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Login - SaleTrackMate</title>
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
                        <div class="col-lg-6">
                            <div class="card-body p-md-5 mx-md-4">
                                <div class="text-center">
                                    <h4 class="mt-1 mb-5 pb-1">Log In to SaleTrackMate</h4>
                                </div>
                                <form accept-charset="UTF-8" method="POST" action="{{ route('login') }}">
                                    @csrf <!-- {{ csrf_field() }} -->
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="email">Email:</label>
                                        <input type="email" id="email" name="email"
                                               class="form-control"
                                               placeholder="Your email address"
                                               value="{{old('email')}}" required/>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="password">Password:</label>
                                        <input type="password" id="password" name="password"
                                               class="form-control"
                                               placeholder="Your password" minlength="8" required/>
                                    </div>

                                    @if ($errors->has('message'))
                                        <div class="alert alert-danger mb-4">
                                            {{ $errors->first('message') }}
                                        </div>
                                    @endif

                                    @if (Session::has('success'))
                                        <div class="alert alert-success mb-4">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    <div class="text-center pt-1 mb-4 pb-1">
                                        <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3 w-100"
                                                type="submit">Log In
                                        </button>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center mb-4 gap-3">
                                        <p class="small mb-0 me-2 text-center">Don't have an account?</p>
                                        <a href="{{ route('register') }}" class="btn btn-sm btn-outline-secondary w-50">Register
                                            now</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-center gradient-custom-2 gradient-form-black"
                             id="description-section">
                            <div class="text-white px-3 py-4 p-md-5 mx-md-4 description-text">
                                <h3 class="mb-4 text-center">Experience Enhanced Capabilities of Invoicing</h3>
                                <p class="small text-center mb-0">
                                    Embark on a journey of enhanced capabilities with SaleTrackMate's powerful software.
                                    Unleash the potential of efficient invoice creation, recipient management, fiscal
                                    year tracking, and more.
                                    Our feature-rich platform enables you to experience a range of functionalities that
                                    elevate your invoicing.
                                    Navigate through seamless processes, secure data encryption, and comprehensive goods
                                    and services management.
                                    Elevate your business experience with SaleTrackMate today.
                                </p>
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
