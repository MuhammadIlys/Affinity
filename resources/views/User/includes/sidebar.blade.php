<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="{{ route('user.index') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('referrer.users') }}">
                <i class="bi bi-person"></i>
                <span>Referred Users</span>
            </a>
        </li>

        {{-- <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('payout.index') }}">
                <i class="bi bi-person"></i>
                <span>Payout History</span>
            </a>
        </li> --}}

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#payouts" data-bs-toggle="collapse" href="#"
                aria-expanded="false">
                <i class="bi bi-gear"></i><span>Payout History</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="payouts" class="nav-content collapse" data-bs-parent="#sidebar-nav" style="">
                <li>
                    <a href="{{ route('payout.pending') }}">
                        <i class="bi bi-circle"></i><span>Pending Payout</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('payout.completed') }}">
                        <i class="bi bi-circle"></i><span>Completed Payout</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('payout.rejected') }}">
                        <i class="bi bi-circle"></i><span>Rejected Payout</span>
                    </a>
                </li>
            </ul>
        </li>

        @if (Auth::check())
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('logout') }}">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Logout</span>
                </a>
            </li>
        @endif
    </ul>

</aside><!-- End Sidebar-->
