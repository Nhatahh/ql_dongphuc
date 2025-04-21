@extends('layouts.app')

@section('title', 'Chi Tiết Sản Phẩm')

@section('content')
    <!-- Body -->
    <div class="body show_detail container p-3 bg-white">
        <!-- Search -->
        <div class="nav-searchShowDetail row d-flex align-items-center">
            <div class="col-1 text-center py-3">
                <a href="{{ route('uniforms.store') }}" class=" text-decoration-none"><i class="back-icon fa-solid fa-chevron-left p-3 d-block"></i></a>
            </div>
            <div class="col-8">
                <div class="search input-group">
                    <input type="text" class="form-control w-50" placeholder="Nhập từ khóa...">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
            </div>
            <div class="col-3 d-flex justify-content-end">
                <a class="btn p-3" href="{{ route('orders.cart') }}"><div class="cart col-6"><i class="fa-solid fa-cart-shopping"></i></div></a>
                <a class="btn p-3" href="{{ route('user.profile') }}"><div class="profile col-6"><i class="fa-solid fa-user"></i></div></a>
            </div>
        </div>

        <!-- Product-Detail -->
        <div class="product-detail row mt-4">
            <!-- Product-img -->
            <div class="product-img col-12 col-md-6">
                <div class="row">
                    <img src="{{ asset('images/' . $ct_Spham->image_url) }}" alt="" class="product-img__main img-fluid">
                </div>
                <div class="product-img__extra row mt-3 flex-nowrap overflow-auto">
                    <img src="{{ asset('images/' . $ct_Spham->image_url) }}" alt="" class="product-img__extra-item img-fluid col-3">
                    <img src="{{ asset('images/' . $ct_Spham->image_url) }}" alt="" class="product-img__extra-item img-fluid col-3">
                    <img src="{{ asset('images/' . $ct_Spham->image_url) }}" alt="" class="product-img__extra-item img-fluid col-3">
                    <img src="{{ asset('images/' . $ct_Spham->image_url) }}" alt="" class="product-img__extra-item img-fluid col-3">
                    <img src="{{ asset('images/' . $ct_Spham->image_url) }}" alt="" class="product-img__extra-item img-fluid col-3">
                    <img src="{{ asset('images/' . $ct_Spham->image_url) }}" alt="" class="product-img__extra-item img-fluid col-3">
                </div>
            </div>
            <!-- Product Infomation -->
            <div class="col-12 col-md-6">
                <div class="product-info fs-1 col-12 ps-md-5 mt-md-0 d-flex flex-column mt-4">
                    <h1 class="fw-bold">{{ $ct_Spham->tensp }}</h1>
                    <div class="d-flex flex-wrap gap-3 mt-2">
                        <label>Loại: <span class="product-info__cate fw-bold">
                            {{ $ct_Spham->loaiSanPham->ten ?? 'Không rõ' }}
                        </span></label>
                        <label>Tồn kho: <span class="product-info__stock">{{ $ct_Spham->tonkho }}</span></label>
                    </div>

                    <span class="product-info__price fw-bolder fs-2 mt-3" style="color: red;">
                        {{ number_format($ct_Spham->gia, 0, ',', '.') }} VND
                    </span>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <select class="product-info__size form-select w-25 fw-bolder" id="size">
                            @foreach($sizes as $size)
                                <option value="{{ $size->size_id }}">{{ $size->ten }}</option>
                            @endforeach
                        </select>

                        <a href="{{ route('orders.cart') }}" class="action-item addCart btn btn-outline-primary rounded d-flex align-items-center">
                            <i class="fa-solid fa-cart-plus me-2"></i> Thêm giỏ hàng
                        </a>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="product-quantity input-group w-25">
                            <button class="btn btn-outline-secondary" type="button" onclick="changeQuantity(-1)">−</button>
                            <input type="number" class="form-control text-center" id="product-quantity" value="1" min="1" max="100">
                            <button class="btn btn-outline-secondary" type="button" onclick="changeQuantity(1)">+</button>
                        </div>

                        <a href="{{ route('orders.payment') }}" class="action-item buyNow btn btn-danger rounded d-flex align-items-center">
                            <i class="fa-solid fa-credit-card me-2"></i> Mua ngay
                        </a>
                    </div>
                </div>

                <!-- Description -->
                <div class="product-desc col-12 mt-5 px-md-5 py-md-2">
                    <h2>Mô tả sản phẩm</h2>
                    <div class="mt-3" id="desc">
                        <div class="card card-body" style="font-size: 1.4rem;">
                            {{ $ct_Spham->mota }}
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
                        <p>Nội dung đánh giá: 
                            @foreach ($danhgias as $danhgias)
                                <p>{{ $danhgias->binhluan }}</p>
                            @endforeach
                        </p>

                        <div class="user-rate d-flex align-items-center">
                            <img src="{{ asset('images/product2.jpg') }}" alt="" class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: contain;">
                            <div class="row">
                                <span><b>Tên khách hàng: {{ $ct_Spham->username }}</b></span>
                                <span>Ngày đánh giá: {{ $ct_Spham->created_at}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        showDetailAction()
    </script>
@endsection