<nav class="main-header navbar navbar-expand navbar-white navbar-light text-sm">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('admin')}}" class="nav-link">Trang chủ</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="https://ctuet.edu.vn" class="nav-link">Liên hệ</a>
    </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <div class="user-panel mt-1 d-flex" style="margin-right: 10px">
            <div class="info">
                <a href="#" class="d-block" id = "nameUser"></a></a>
            </div>
        </div>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" style="padding:0px">
                <div class="user-panel" style="padding:2px">
                    <img  class="img-circle" alt="User Image" src = '/images/profile/start.png' >
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
            <div class="dropdown-divider"></div>
                <a id = 'doimatkhau_admin' onclick = "userChangePass_load_admin()" class="dropdown-item">
                    <i class="fas fa-key mr-2"></i>Đổi mật khẩu
                </a>
            <div class="dropdown-divider"></div>
                <a href="/admin/users/login" onclick = "userLogout_admin()" class="dropdown-item">
                    <i class="fa-solid fa-right-to-bracket mr-2"></i>Đăng xuất
                </a>
        </li>
    <!-- Messages Dropdown Menu -->

    </ul>
</nav>

