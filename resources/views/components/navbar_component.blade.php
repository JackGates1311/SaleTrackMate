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
            <ul class="navbar-nav ml-auto">
                @if (session()->get('user_data') != '' && session()->get('user_data') != null)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('invoices') ? 'active' : '' }}" href="{{ route('invoices') }}">Invoice Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="justify-content-end nav-link {{ request()->is('logout') ? 'active' : '' }}" href="{{ route('logout') }}">Log Out</a>
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
        </div>
    </div>
</nav>
