@extends('layouts.app')

@section('title', 'Giỏ Hàng')

@section('content')
<div class="body p-3 mt-2 bg-white">
    <div id="loading" class="loader" style="display:none;">
        <div class="spinner"></div>
    </div>
    <div class="container">
        <!-- Search -->
        <div class="nav-search row d-flex align-items-center">
            <div class="col-1 text-center py-3">
                <a href="{{ route('uniforms.store') }}" class="text-decoration-none">
                    <i class="back-icon fa-solid fa-chevron-left p-3 d-block"></i>
                </a>
            </div>
            <div class="col-11 d-flex justify-content-center">
                <div class="position-relative w-75">
                    <input id="searchGioHang" class="form-control" placeholder="Tìm kiếm sản phẩm trong giỏ hàng...">
                </div>
            </div>
        </div>

        <!-- Giỏ hàng -->
        <div class="cart-list mt-4" style="max-height: 75vh;">
            <div class="row g-0">
                @if ($cartItems->isEmpty())
                    <div class="text-center w-100 py-5">
                        <i class="fa fa-shopping-cart fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Không có sản phẩm nào trong giỏ hàng.</h5>
                    </div>
                @else
                @foreach ($cartItems as $item)
                        <div class="col-12 mb-3 cart-item-wrapper">
                            <div class="row cart-item border rounded p-2 align-items-center gx-2" data-name="{{ $item->tensp }}">
                                <!-- Checkbox -->
                                <div class="col-1 d-flex justify-content-center align-items-center">
                                    <input type="checkbox" class="form-check-input" style="border: 1px solid black;">
                                </div>
                                <!-- Hình ảnh -->
                                <div class="col-2 d-flex justify-content-center align-items-center">
                                    <a href="{{ route('uniforms.show_detail', $item->sp_id) }}" class="text-decoration-none text-dark">
                                        <img src="{{ asset('images/' . $item->image_url) }}" class="img-fluid rounded w-100" style="max-width: 100px;">
                                    </a>
                                </div>
                                <!-- Tên và giá -->
                                <div class="col-3 d-flex justify-content-center align-items-center">
                                    <div>
                                        <a href="{{ route('uniforms.show_detail', $item->sp_id) }}" class="text-decoration-none text-dark">
                                            <h2 class="fw-bold mb-1">{{ $item->tensp }}</h2>
                                        </a>
                                        <h3 class="fw-bold text-danger mb-0">{{ number_format($item->gia, 0, ',', '.') }} VND</h3>
                                    </div>
                                </div>
                                <!-- Số lượng -->
                                <div class="col-3 gap-3 d-flex flex-column justify-content-center align-items-center">
                                    <div class="input-group quantity-group" style="max-width: 100px;">
                                        <button class="btn btn-outline-secondary btn-sm" type="button" onclick="changeQuantity(this, -1)">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number"
                                            class="form-control text-center form-control-sm quantity-input"
                                            value="{{ $item->soluong }}" min="1"
                                            data-gh-id="{{ $item->gh_id }}" id="soluong_{{ $item->gh_id }}"
                                            data-current-quantity="{{ $item->soluong }}">
                                        <button class="btn btn-outline-secondary btn-sm" type="button" onclick="changeQuantity(this, 1)">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    <!-- select 2 size -->
                                    <select class="form-select getsizeSelect2" data-gh-id="{{ $item->gh_id }}" data-current-size="{{ $item->size_id ?? '' }}">
                                        <option value="">--- Chọn size ---</option>
                                    </select>
                                </div>
                                <!-- Nút thao tác -->
                                <div class="col-3 d-flex justify-content-center align-items-center gap-2 flex-column flex-md-row">
                                    <button class="btn btn-success btn-update-quantity" data-gh-id="{{ $item->gh_id }}" data-user-id="{{ $item->user_id }}" data-url="{{ route('cart.updateQuantity') }}">Cập nhật</button>
                                    <button class="btn btn-danger btn-delete-item" data-gh-id="{{ $item->gh_id }}" data-url="{{ route('cart.delete') }}">Xóa</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <!-- Thông báo không tìm thấy sản phẩm -->
            <div id="noResultsMessage" class="text-center py-5" style="display: none;">
                <i class="fa fa-search fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Không tìm thấy sản phẩm trong giỏ hàng.</h5>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("searchGioHang");
        const noResultsMessage = document.getElementById("noResultsMessage");
        const items = document.querySelectorAll(".cart-item");

        searchInput.addEventListener("input", function () {
            const query = removeVietnameseTones(this.value.trim()).toLowerCase();
            let found = false;

            items.forEach((item) => {
                const name = removeVietnameseTones(item.getAttribute("data-name") || '').toLowerCase();
                const wrapper = item.closest(".cart-item-wrapper");

                if (name.includes(query)) {
                    wrapper.style.display = "";
                    found = true;
                } else {
                    wrapper.style.display = "none";
                }
            });

            // Hiển thị hoặc ẩn thông báo không có sản phẩm
            if (!found) {
                noResultsMessage.style.display = "block";
            } else {
                noResultsMessage.style.display = "none";
            }
        });
    });
</script>
@endpush



