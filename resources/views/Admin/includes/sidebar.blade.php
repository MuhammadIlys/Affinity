<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="{{ route('admin.index') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#referrers" data-bs-toggle="collapse" href="#"
                aria-expanded="false">
                <i class="bi bi-layout-text-window-reverse"></i><span>Referrers</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="referrers" class="nav-content collapse" data-bs-parent="#sidebar-nav" style="">
                <li>
                    <a href="{{ route('referrers.create') }}">
                        <i class="bi bi-circle"></i><span>New Referrer</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('referrers.index') }}">
                        <i class="bi bi-circle"></i><span>All Referrers</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#users" data-bs-toggle="collapse" href="#"
                aria-expanded="false">
                <i class="bi bi-layout-text-window-reverse"></i><span>Employees</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="users" class="nav-content collapse" data-bs-parent="#sidebar-nav" style="">
                <li>
                    <a href="{{ route('employees.create') }}">
                        <i class="bi bi-circle"></i><span>New Employee</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('employees.index') }}">
                        <i class="bi bi-circle"></i><span>All Employees</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#admins" data-bs-toggle="collapse" href="#"
                aria-expanded="false">
                <i class="bi bi-layout-text-window-reverse"></i><span>Admins</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="admins" class="nav-content collapse" data-bs-parent="#sidebar-nav" style="">
                <li>
                    <a href="{{ route('admins.create') }}">
                        <i class="bi bi-circle"></i><span>New Admin</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admins.index') }}">
                        <i class="bi bi-circle"></i><span>All Admins</span>
                    </a>
                </li>
            </ul>
        </li>


        
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#payouts" data-bs-toggle="collapse" href="#"
                aria-expanded="false">
                <i class="bi bi-gear"></i><span>Payout requests</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="payouts" class="nav-content collapse" data-bs-parent="#sidebar-nav" style="">
                <li>
                    <a href="{{ route('pending-payouts') }}">
                        <i class="bi bi-circle"></i><span>Pending payouts</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('approved-payouts') }}">
                        <i class="bi bi-circle"></i><span>Completed payouts</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('rejected-payouts') }}">
                        <i class="bi bi-circle"></i><span>Rejected payouts</span>
                    </a>
                </li>
            </ul>
        </li>
        
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#settings" data-bs-toggle="collapse" href="#"
                aria-expanded="false">
                <i class="bi bi-gear"></i><span>Settings</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="settings" class="nav-content collapse" data-bs-parent="#sidebar-nav" style="">
                <li>
                    <a href="{{ route('settings.edit',1) }}">
                        <i class="bi bi-circle"></i><span>Settings</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.profile') }}">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
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
