<nav class="navbar navbar-expand-lg navbar-light navbar-light-gray">
    <div class="container">
        <a class="navbar-brand" href="/">SaleTrackMate</a>
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
                        <a class="nav-link {{ request()->is('invoices') ? 'active' : '' }}" href="{{ route('invoices') }}">Invoices</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('recipients') ? 'active' : '' }}" href="#">Recipients</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('login') ? 'active' : '' }}" href="{{ route('login') }}">Log In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('register') ? 'active' : '' }}" href="{{ route('register') }}">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ route('about') }}">About Us</a>
                    </li>
                @endif
            </ul>
            <div class="navbar-nav d-flex">
                @if(session()->get('user_data') != '' && session()->get('user_data') != null)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            First Company
                        </a>
                        <ul class="dropdown-menu text-center" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Account
                        </a>
                        <ul class="dropdown-menu text-center" aria-labelledby="navbarDropdownMenuLink">
                            <li>
                                <a class="dropdown-item {{ request()->is('account') ? 'active' : '' }}" href="{{ route('account') }}">
                                    Settings
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request()->is('logout') ? 'active' : '' }}" href="{{ route('logout') }}">Log Out</a>
                            </li>
                        </ul>
                    </li>
                @endif
            </div>
        </div>
    </div>
</nav>
