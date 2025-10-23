<footer class="bg-light text-dark py-4 mt-5 border-top">
    <div class="container">
        <div class="row">
            <!-- Brand / Logo -->
            <div class="col-md-4 mb-3 mb-md-0">
                <h5 class="fw-bold">Career 180</h5>
                <p class="text-muted small">
                    Empowering learners and professionals through accessible education.
                </p>
            </div>

            <!-- Quick Links -->
            <div class="col-md-4 mb-3 mb-md-0">
                <h6 class="text-uppercase fw-semibold">Quick Links</h6>
                @php
                    $isAuthenticated = Auth::check() || Auth::guard('student')->check();
                @endphp
                @if($isAuthenticated)
                <ul class="list-unstyled">
                    <li><a href="#" class="text-decoration-none text-muted">Dashboard</a></li>
                    <li><a href="#" class="text-decoration-none text-muted">My Courses</a></li>
                    <li><a href="#" class="text-decoration-none text-muted">Profile</a></li>
                    <li><a href="#" class="text-decoration-none text-muted">Logout</a></li>
                </ul>
                @endif
                @guest
                <!-- Guest nav items -->
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                    @endif
                </ul>
                @endguest

            </div>


            <!-- Contact Info -->
            <div class="col-md-4">
                <h6 class="text-uppercase fw-semibold">Contact</h6>
                <p class="mb-1 small">
                    <i class="fas fa-envelope me-2"></i> support@career180.com
                </p>
                <p class="mb-0 small">
                    <i class="fas fa-phone me-2"></i> +1 (123) 456-7890
                </p>
            </div>
        </div>

        <hr class="my-4">

        <div class="text-center small text-muted">
            © <span x-data="{ year: new Date().getFullYear() }" x-text="year"></span> Career 180. All rights reserved.
        </div>
    </div>
</footer>