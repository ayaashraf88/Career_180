<div x-data="headerApp()">

    <header class="container-fluid bg-light shadow-sm py-3">
        <div class="row align-items-center">
            <div class="col-3  d-lg-none ">
                <button
                    class="btn btn-outline-primary"
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <div class="col-9 col-lg-2 text-center text-lg-start mb-3 mb-lg-0">
                <a href="{{route('dashboard')}}" class="text-decoration-none text-reset">
                    <h1 class="h3 m-0">Career 180</h1>
                </a>

            </div>
            <div class="col-12 col-lg-10">
                @php

                $isAuthenticated = Auth::check() || Auth::guard('student')->check();
                $currentUser = Auth::user() ?? Auth::guard('student')->user();
                @endphp

                <ul
                    class="nav justify-content-lg-end flex-column flex-lg-row gap-3 text-center d-none d-lg-flex"
                    :class="{ 'd-flex': mobileMenuOpen, 'flex-column': mobileMenuOpen,'justify-content-center': mobileMenuOpen, 'd-none': !mobileMenuOpen }">
                    @if($isAuthenticated)
                    <li class="nav-item">
                        @livewire('navbar-course-search')
                    </li>

                    <li class="nav-item">
                        <a href="{{route('student.logs')}}" class="nav-link text-reset">
                            <i class="fas fa-home me-1"></i> logs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('student.courses')}}" class="nav-link text-reset">
                            <i class="fas fa-book-open me-1"></i> My Courses
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('student.profile')}}" class="nav-link text-reset">
                            <i class="fa-solid fa-user me-1"></i> Profile
                        </a>
                    </li>
                    <li class="nav-item mt-1">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-reset p-0 m-0" style="display: inline;">
                                <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
                            </button>
                        </form>
                    </li>
                    @else
                    <li class="nav-item">
                        <a href="{{route('login')}}" class="nav-link text-reset">
                            <i class="fa-solid fa-user me-1"></i> login
                        </a>
                    </li>
                </ul>


                @endif

            </div>
        </div>
    </header>
</div>

<script>
    function headerApp() {
        return {
            mobileMenuOpen: false,
            open: false,


            toggle() {
                console.log('toggle clicked');
                this.open = !this.open;
            },

            get totalPrice() {
                return this.cartItems.reduce((sum, item) => sum + item.price * item.quantity, 0);
            },

            removeFromCart(index) {
                this.cartItems.splice(index, 1);
            },

            goToCheckout() {
                alert('Redirect to checkout page');
                // window.location.href = '/cart';
            }
        }
    }
</script>