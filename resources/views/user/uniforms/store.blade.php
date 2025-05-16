@extends('layouts.app')

@section('title', 'Cửa Hàng')

@section('content')
<!-- Body content here... -->
<div class="body container p-3">
    <div class="nav-search row d-flex align-items-center justify-content-around bg-white p-3">
        <div class="position-relative w-75">
            <input id="searchInput" class="form-control" placeholder="Tìm kiếm sản phẩm...">
            <div id="searchResults" class="dropdown-menu w-100 shadow" style="max-height: 400px; overflow-y: auto;"></div>
        </div>
    </div>
    <!-- List Menu -->
    <ul class="menu-list row mt-3 gap-1 justify-content-around">
        <li class="menu-item btn col-2">Mới nhất</li>
        <li class="menu-item btn col-2">Phổ biến</li>
        <li class="menu-item btn col-2">Bán chạy</li>
        <li class="menu-item btn filter col-2" data-bs-toggle="collapse" data-bs-target="#filter-modal">Lọc</li>
        <!-- Modal filter -->
        <div id="filter-modal" class="collapse border border-dark border-1 bg-white text-center p-3 mt-3">
            <div class="d-flex justify-content-center gap-2 mb-2">
                <!-- select 2 danh muc -->
                <select id="danhmucSelect2" class="form-select">
                    <option value="">--- Chọn danh mục ---</option>
                </select> 
                <!-- select 2 size -->
                <select id="sizeSelect2" class="form-select">
                    <option value="">--- Chọn size ---</option>
                </select> 
                <!-- select giá -->
                <select id="giaSelect" class="form-select" style="max-width: 200px;">
                    <option selected>--- Chọn giá ---</option>
                    <option value="">Giảm dần</option>
                    <option value="">Tăng dần</option>
                </select>
            </div>
            <button class="btn btn-danger" data-url="">Lọc</button>
        </div>
    </ul>
    <div class="product-list">
        <div class="row">
            @foreach($sanphams as $sp)
                <div class="col-6 col-md-3 mt-4">
                    <a href="{{ route('uniforms.show_detail', $sp->sp_id) }}" class="text-decoration-none text-dark">
                        <div class="card">
                            <img src="{{ asset('images/' . $sp->image_url) }}" class="card-img-top" alt="{{ $sp->tensp }}">
                            <div class="card-body">
                                <div class="text-center fs-2 fw-bold gia" style="color: red;">
                                    {{ number_format($sp->gia, 0, ',', '.') }} VND
                                </div>
                                <h5 class="card-title">{{ $sp->tensp }}</h5>
                                <p class="card-text">{{ $sp->mota }}</p>
                                <div class="text-center">
                                <a href="#" class="order text-white btn btn-primary card-link mt-3"><i class="fa-solid fa-gift me-1"></i> Đặt hàng</a>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        const navLinks = document.querySelectorAll('.nav-footer .nav-item')
        navLinks.forEach((item, i) => {
            item.onclick = () => {
                localStorage.setItem('navLink', i)
            }
        })
        document.addEventListener("DOMContentLoaded", function () {
        const activeId = localStorage.getItem("activeLink");
        if (activeId) {
        document.querySelector(`.nav-footer .nav-item[data-id="${activeId}"]`)?.classList.add("active");
        }
    });
    </script>
@endsection