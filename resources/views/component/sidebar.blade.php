<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.blade.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Passport Admin</div>
    </a>

    <!-- Heading -->
    <div class="sidebar-heading">
        菜单
    </div>

    <!-- Nav Item - Tables -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('/users') }}">
            <i class="fas fa-user fa-table"></i>
            <span>用户</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('/apps') }}">
            <i class="fas fa-list fa-table"></i>
            <span>应用</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
