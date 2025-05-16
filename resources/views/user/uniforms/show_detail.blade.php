@extends('layouts.app')

@section('title', 'Chi Tiết Sản Phẩm')

@section('content')
    <!-- Body -->
      <div class="body show-detail container p-3 bg-white">
        <!-- Search -->
        <div class="nav-searchShowDetail row d-flex align-items-center bg-white" style="margin-top: 130px">
            <div class="col-1 text-center py-3">
                <a href="{{ route('uniforms.store') }}" class=" text-decoration-none"><i class="back-icon fa-solid fa-chevron-left p-3 d-block"></i></a>
            </div>
            <div class="col-11 d-flex justify-content-center">
                <div class="position-relative w-75">
                    <input id="searchInput" class="form-control" placeholder="Tìm kiếm sản phẩm...">
                    <div id="searchResults" class="dropdown-menu w-100 shadow" style="max-height: 400px; overflow-y: auto;"></div>
                </div>
            </div>
        </div>
        <!-- Product-Detail -->
        <div class="product-detail row mt-4">
            <!-- Product-img -->
            <div class="product-img col-12 col-md-6">
                <div class="row">
                    <img src="{{ asset('images/' . $ct_sp->image_url) }}" alt="" class="product-img__main img-fluid">
                </div>
                <div class="product-img__extra row mt-3 flex-nowrap overflow-auto">
                    <img src="{{ asset('images/' . $ct_sp->image_url) }}" alt="" class="product-img__extra-item img-fluid col-3">
                    <img src="{{ asset('images/product1.jpg') }}" alt="" class="product-img__extra-item img-fluid col-3">
                    <img src="{{ asset('images/product2.jpg') }}" alt="" class="product-img__extra-item img-fluid col-3">
                    <img src="{{ asset('images/product3.jpg') }}" alt="" class="product-img__extra-item img-fluid col-3">
                </div>
            </div>
            <!-- Product Infomation -->
            <div class="col-12 col-md-6">
                <div class="product-info col-12 ps-md-5 mt-md-0 d-flex flex-column mt-4">
                    <h1><strong>{{ $ct_sp->tensp }}</strong></h1>
                    <div class="d-flex">
                        <label>Loại: <span class="product-info__cate">{{ $ct_sp->ten_danhmuc }}</span></label>
                        <label>Tồn kho: <span class="product-info__stock">{{ $ct_sp->tonkho }}</span></label>
                    </div>
                    <span class="product-info__price fw-bold" style="color: red;">{{ number_format($ct_sp->gia, 0, ',', '.') }} VND</span>
                    <div class="gap-3 d-flex justify-content-evenly mt-3">
                        <div class="input-group quantity-group" style="max-width: 100px;">
                            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="changeQuantity(this, -1)">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number"
                                class="form-control text-center form-control-sm quantity-input"
                                value="1" min="1"
                                data-gh-id="" id="soluong_">
                            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="changeQuantity(this, 1)">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <!-- select 2 size -->
                        <select id="sizeSelect2" class="form-select w-75">
                            <option value="">--- Chọn size ---</option>
                        </select>                        
                    </div>
                    <div class="gap-3 d-flex mt-3">
                        <a href="{{ route('orders.payment') }}" class="action-item buyNow buyNowPC btn btn-danger rounded d-flex"><span class="d-block mt-1">Mua ngay</span></a>
                        <a href="{{ route('orders.cart') }}" class="action-item addCart addCartPC btn rounded d-flex">
                            <span class="d-block mt-1"><i class="fa-solid fa-cart-plus me-2"></i>Thêm giỏ hàng</span>
                        </a>
                    </div>
                </div>
                <!-- Description -->
                <div class="product-desc col-12 mt-4 mt-md-5 px-md-5 py-md-2">
                    <h2>Mô tả sản phẩm</h2>
                    <div class="mt-3" id="desc">
                        <div class="card card-body" style="font-size: 1.4rem;">
                            {{ $ct_sp->mota }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- Rating -->
            <div class="product-rating col-12 mt-4">
                <h1>Đánh giá sản phẩm</h1>
                <div class="product-rating__content mt-3">
                    <div class="stars">
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <div class="mt-3">
                        <h3>Tên: </h3>
                        <p>Nội dung đánh giá </p>

                        <div class="user-rate d-flex align-items-center">
                            <img src="{{ asset('images/product2.jpg') }}" alt="" class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: contain;">
                            <div class="row">
                                <span><b>Tên khách hàng</b></span>
                                <span>Ngày đánh giá</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        showDetailAction()
    </script>
@endpush