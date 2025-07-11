<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('admin.taikhoan') }}">
            <i class="bi bi-house-fill"></i>
            Admin
        </a>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar p-0">
            <div class="list-group list-group-flush">
                <a href="{{ route('admin.taikhoan') }}" class="nav-link">
                    <i class="bi bi-person-fill sidebar-icon"></i>
                    Quản lý tài khoản
                </a>
                <a href="{{ route('admin.sanpham') }}" class="nav-link active">
                    <i class="bi bi-box-seam sidebar-icon"></i>
                    Quản lý sản phẩm
                </a>
                <a href="{{ route('admin.donhang') }}" class="nav-link">
                    <i class="bi bi-cart-fill sidebar-icon"></i>
                    Quản lý đơn hàng
                </a>
                <a href="{{ route('admin.danhmuc') }}" class="nav-link">
                    <i class="bi bi-folder-fill sidebar-icon"></i>
                    Quản lý danh mục
                </a>
                <a href="{{ route('admin.thongke') }}" class="nav-link">
                    <i class="bi bi-bar-chart-fill sidebar-icon"></i>
                    Thống kê
                </a>
                <a href="" class="nav-link">
                    <i class="bi bi-three-dots sidebar-icon"></i>
                    ...
                </a>
            </div>
        </div>
