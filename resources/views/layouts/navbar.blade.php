<!-- <header class="header">
    <a href="{{ route('home.index') }}">
        <img src="{{ asset('images/logo3.jpg') }}" alt="aa" class="logo">
    </a>
    <div class="name-header">
        <p>TRƯỜNG ĐẠI HỌC</p>
        <p>KỸ THUẬT - CÔNG NGHỆ CẦN THƠ</p>
        <p>MÃ TRƯỜNG: KCC</p>
    </div>        
    <div class="nav-header">
        <div class="nav-pc d-flex justify-content-around icon-link-hover">
            <a href="{{ route('uniforms.store') }}" class="nav-item"><i class="fas fa-shopping-bag"></i><span>Cửa hàng</span></a>
            <a href="#" class="nav-item"><i class="fa-solid fa-comment"></i><span>Chat</span></a>
            <a href="{{ route('home.index') }}" class="nav-item"><i class="fas fa-home"></i><span>Trang chủ</span></a>
            <a href="{{ route('orders.cart') }}" class="nav-item"><i class="fa-solid fa-cart-shopping"></i><span>Giỏ hàng</span></a>
            <a href="{{ route('user.profile') }}" class="nav-item"><i class="fas fa-user"></i><span>Hồ sơ</span></a>
        </div>
    </div>
</header> -->

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <div class="navbar-nav row w-100">
        <div class="col-1 fs-1">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </div>
        <div class="col-11 nav-search p-3 row justify-content-center">
            <div class="position-relative w-75">
                <input id="searchInput" class="form-control" placeholder="Tìm kiếm sản phẩm...">
                <div id="searchResults" class="dropdown-menu w-100 shadow" style="max-height: 400px; overflow-y: auto;"></div>
            </div>
        </div>
    </div>
    <!-- Right navbar links -->
    
</nav>

<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('/') }}" class="brand-link">
        <img src="{{ asset('images/logo3.jpg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">CTUT</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">MENU</a>
            </div>
        </div> -->

        <!-- SidebarSearch Form -->
        <div class="form-inline position-relative">
            <div class="input-group" data-widget="sidebar-search">
                <input id="sidebar-search-input" class="form-control form-control-sidebar" type="search" placeholder="Tìm sản phẩm..." aria-label="Search" autocomplete="off">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>

            <!-- Kết quả tìm kiếm -->
            <div id="sidebar-search-result" class="position-absolute w-100 bg-white shadow rounded mt-3" style="z-index: 9999; display: none;"></div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('uniforms.store') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Cửa hàng</p>
                    </a>
                    <!-- <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../../index.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard v1</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../../index2.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard v2</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../../index3.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard v3</p>
                            </a>
                        </li>
                    </ul> -->
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Chat</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('home.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>Trang chủ</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('orders.cart') }}" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>Giỏ hàng</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.profile') }}" class="nav-link">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>Hồ sơ</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
