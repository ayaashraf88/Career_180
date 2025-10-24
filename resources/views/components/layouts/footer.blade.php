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
            
                <ul class="list-unstyled">
                    <li><a href="{{ route('/') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                    <li><a href="{{ route('student.courses') }}" class="text-decoration-none text-muted">My Courses</a></li>
                    <li><a href="{{ route('student.profile') }}" class="text-decoration-none text-muted">Profile</a></li>
                    <li class="nav-item mt-1">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-muted p-0 m-0" style="display: inline;">
                                 Logout
                            </button>
                        </form>
                    </li>
                </ul>
               
              

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