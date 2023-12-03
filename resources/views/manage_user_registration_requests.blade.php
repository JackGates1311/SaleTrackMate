<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>User Registration Requests - SaleTrackMate</title>
    @component('components.header_component')
    @endcomponent
</head>
<body>
@component('components.navbar_component')
@endcomponent
<section class="min-vh-100 gradient-form d-flex">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-12">
                <div class="card rounded-3 text-black border-0">
                    <div class="row g-0">
                        <div class="col-lg-12">
                            <div class="card-body p-3">
                                <div class="text-center">
                                    <h4 class="mt-1 mb-3 pb-1">User Registration Requests</h4>
                                </div>
                                <hr/>
                                @if (Session::has('message'))
                                    <div
                                        class="alert alert-success text-center">
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
                                            <th class="text-center">Username</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Contact Information</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($user_registration_requests as $user_registration_request)
                                            <tr>
                                                <td class="text-center text-middle">
                                                    {{ $user_registration_request['username']}}</td>
                                                <td class="text-center text-middle">
                                                    {{ $user_registration_request['email'] }}</td>
                                                <td class="text-center text-middle">
                                                    {{ $user_registration_request['first_name'] }}
                                                    {{ $user_registration_request['middle_name'] ?? '' }}
                                                    {{ $user_registration_request['last_name'] }}
                                                    <br>
                                                    Country: {{ $user_registration_request['country'] }}
                                                </td>
                                                <td class="text-center text-middle">
                                                    {{ $user_registration_request['address'] }}, <br>
                                                    {{ $user_registration_request['postal_code'] }},
                                                    {{ $user_registration_request['city'] }}
                                                </td>
                                                <td class="text-center text-middle">
                                                    Phone: {{ $user_registration_request['phone'] }} <br>
                                                    Fax: {{ $user_registration_request['fax'] }}
                                                </td>
                                                <td class="text-nowrap text-center text-middle">
                                                    <div class="d-flex gap-3">
                                                        <form class="w-100 mt-1" method="POST"
                                                              action="{{route('user_registration_update',
                                                                ['user_registration_request' =>
                                                                $user_registration_request['id'],
                                                                'company' => request()->query('company'),
                                                                'approved' => false])}}">
                                                            @csrf <!-- {{ csrf_field() }} -->
                                                            <button type="submit"
                                                                    class="form-control btn-form-control text-center
                                                                     cursor-pointer w-100">
                                                                <img src="{{ asset('images/res/close.png') }}"
                                                                     alt="delete" width="16"
                                                                     height="16"
                                                                     title="Reject User Registration Request">
                                                                <span class="visually-hidden">Reject</span>
                                                            </button>
                                                        </form>
                                                        <form class="w-100 mt-1" method="POST"
                                                              action="{{route('user_registration_update',
                                                                ['user_registration_request' =>
                                                                $user_registration_request['id'],
                                                                'company' => request()->query('company'),
                                                                'approved' => true])}}">
                                                            @csrf <!-- {{ csrf_field() }} -->
                                                            <button type="submit"
                                                                    class="form-control btn-form-control text-center
                                                                     cursor-pointer w-100">
                                                                <img src="{{ asset('images/res/done.png') }}"
                                                                     alt="delete" width="16"
                                                                     height="16"
                                                                     title="Approve User Registration Request">
                                                                <span class="visually-hidden">Approve</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
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
</section>
</body>
</html>
