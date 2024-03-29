<nav class="navbar navbar-expand-lg navbar-light navbar-light-gray">
    <div class="container">
        <a class="navbar-brand"
           href="{{ route('invoices', ['company' => request()->query('company')]) }}">SaleTrackMate</a>
        <!-- Toggler button for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Collapsible navigation links -->
        <div class="collapse navbar-collapse text-center text-lg-left" id="navbarNav">
            <ul class="navbar-nav me-auto">
                @if (session()->get('user_data') != '' && session()->get('user_data') != null)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('invoices') ? 'active' : '' }}"
                           href="{{ route('invoices', ['company' => request()->query('company')]) }}">Invoices</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('recipients') ? 'active' : '' }}"
                           href="{{ route('recipients', ['company' => request()->query('company')]) }}">Recipients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('invoices/analytics') ? 'active' : '' }}"
                           href="{{ route('invoice_analytics', ['company' => request()->query('company'),
                                'period' => 'daily']) }}">
                            Analytics</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('goods_and_services') ? 'active' : '' }}"
                           href="{{ route('goods_and_services', ['company' => request()->query('company')]) }}">
                            Goods and Services</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('login') ? 'active' : '' }}" href="{{ route('login') }}">
                            Log In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('register') ? 'active' : '' }}"
                           href="{{ route('register') }}">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ route('about') }}">About
                            Us</a>
                    </li>
                @endif
            </ul>
            <div class="navbar-nav d-flex">
                @if(session()->get('user_data') != '' && session()->get('user_data') != null)
                    @if(isset($companies) && count($companies) > 0)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                @foreach($companies as $company)
                                    @if($company['id'] == request()->query('company'))
                                        {{$company['name']}}
                                    @endif
                                @endforeach
                            </a>
                            <ul class="dropdown-menu text-center" aria-labelledby="navbarDropdownMenuLink">
                                @foreach($companies as $company)
                                    <li><a class="dropdown-item" href="
                                    {{route('invoices', ['company' => $company['id']])}}">{{$company['name']}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                    @if(session()->get('user_data')['account_type'] == 'ADMINISTRATOR')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                Admin Actions
                            </a>
                            <ul class="dropdown-menu text-center" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="{{route('database_backup', ['company' =>
                                    request()->query('company')])}}">Backup Database</a></li>
                                <li><a href="#" class="dropdown-item" data-bs-toggle="modal"
                                       data-bs-target="#restoreDatabaseModal">Restore Database</a></li>
                                <li><a class="dropdown-item" href="{{route('user_registration_requests', ['company' =>
                                    request()->query('company')])}}">Manage User Registration Requests</a></li>
                                <li><a class="dropdown-item" href="{{route('tax_categories', ['company' =>
                                    request()->query('company')])}}">Manage Tax Categories</a></li>
                                <li><a class="dropdown-item" href="{{route('unit_of_measures', ['company' =>
                                    request()->query('company')])}}">Manage Unit of Measures</a></li>
                            </ul>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            Account
                        </a>
                        <ul class="dropdown-menu text-center" aria-labelledby="navbarDropdownMenuLink">
                            <li>
                                <a class="dropdown-item {{ request()->is('account') ? 'active' : '' }}"
                                   href="{{ route('account', ['user' => auth('web')->user(),
                                    'company' => request()->query('company') ?? 'default']) }}">
                                    Settings
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request()->is('logout') ? 'active' : '' }}"
                                   href="{{ route('logout') }}">Log Out</a>
                            </li>
                        </ul>
                    </li>
                @endif
            </div>
        </div>
    </div>
</nav>
@component('components.restore_database_modal_component')
@endcomponent
