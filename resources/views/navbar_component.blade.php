<nav class="navbar navbar-expand-lg navbar-light navbar-light-gray">
    <div class="container">
        <a class="navbar-brand" href="#">SaleTrackMate</a>
        <!-- Toggler button for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Collapsible navigation links -->
        <div class="collapse navbar-collapse text-center text-lg-left" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Log In</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">About Us</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
