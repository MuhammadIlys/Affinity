<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('user.index') }}" class="logo d-flex align-items-center">
            {{-- <img src="{{ asset('assets/img/logo.png') }}" alt=""> --}}
            <span class="d-none d-lg-block text-uppercase">Affinity</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->



    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li><!-- End Search Icon-->

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex justify-content-start align-items-center pe-0" href="#"
                    data-bs-toggle="dropdown">
                    <img src="{{ Auth::check() && Auth::user()->image ? asset(Auth::user()->image) : asset('assets/img/placeholder.jpeg') }}"
                        alt="Profile" class="rounded-circle" id="UserProfile">
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
                </a>
                <!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6 class="text-start">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</h6>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    {{-- <li>
                    <a class="dropdown-item d-flex align-items-center" href="">
                        <i class="bi bi-person"></i>
                        <span>My Profile</span>
                    </a>
                    </li> --}}

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->
