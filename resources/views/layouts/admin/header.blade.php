<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('admin.index') }}">
            <i class="bi bi-house-fill"></i>
            Admin
        </a>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar p-0 d-flex flex-column">
            <!-- Menu -->
            <div class="list-group list-group-flush">
                <a href="{{ route('admin.index') }}" class="nav-link">
                    <i class="bi bi-person-fill sidebar-icon"></i>
                    Quản lý tài khoản
                </a>
                <a href="{{ route('admin.donhang') }}" class="nav-link">
                    <i class="bi bi-box-seam sidebar-icon"></i>
                    Quản lý đơn hàng
                </a>
                <a href="{{ route('admin.sanpham') }}" class="nav-link active">
                    <i class="bi bi-box-seam sidebar-icon"></i>
                    Quản lý sản phẩm
                </a>
                <a href="{{ route('admin.kho') }}" class="nav-link active">
                    <i class="bi bi-box-seam sidebar-icon"></i>
                    Quản lý kho
                </a>
                <div class="accordion" id="accordionSidebar">
                    <div class="accordion-item border-0 bg-transparent">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed nav-link bg-transparent text-start w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDanhMuc" aria-expanded="false" aria-controls="collapseDanhMuc">
                                <i class="bi bi-folder-fill sidebar-icon me-2"></i>
                                Quản lý danh mục
                            </button>
                        </h2>
                        <div id="collapseDanhMuc" class="accordion-collapse collapse" data-bs-parent="#accordionSidebar">
                            <div class="accordion-body p-0">
                                <a href="{{ route('admin.danhmuc') }}" class="nav-link ps-5">Loại sản phẩm</a>
                                <a href="{{ route('admin.NSX') }}" class="nav-link ps-5">Nhà sản xuất</a>
                                <a href="{{ route('admin.size') }}" class="nav-link ps-5">Size</a>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('admin.thongke.index') }}" class="nav-link">
                    <i class="bi bi-bar-chart-fill sidebar-icon"></i>
                    Thống kê
                </a>
                <a href="" class="nav-link">
                    <i class="bi bi-three-dots sidebar-icon"></i>
                    ...
                </a>
            </div>

            <!-- Nút Logout -->
            <div class="mt-auto p-3 border-top">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="bi bi-box-arrow-right me-1"></i> Đăng xuất
                    </button>
                </form>
            </div>
        </div>
