@extends('layouts.app')

@section('title', 'Chi Tiết Sản Phẩm')

@section('content')
    <!-- Body -->
    <div class="body show_detail container p-3 bg-white">
        <!-- Search -->
        <div class="nav-searchShowDetail row d-flex align-items-center">
            <div class="col-1 text-center py-3">
                <a href="{{ route('uniforms.store') }} class=" text-decoration-none"><i class="back-icon fa-solid fa-chevron-left p-3 d-block"></i></a>
            </div>
            <div class="col-8">
                <div class="search input-group">
                    <input type="text" class="form-control w-50" placeholder="Nhập từ khóa...">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
            </div>
            <div class="col-3 d-flex justify-content-end">
                <a class="btn p-3" href="{{ route('orders.cart') }}><div class="cart col-6"><i class="fa-solid fa-cart-shopping"></i></div></a>
                <a class="btn p-3" href="{{ route('user.profile') }}><div class="profile col-6"><i class="fa-solid fa-user"></i></div></a>
            </div>
        </div>

        <!-- Product-Detail -->
        <div class="product-detail row mt-4">
            <!-- Product-img -->
            <div class="product-img col-12 col-md-6">
                <div class="row">
                    <img src="{{ asset('images/product1.jpg') }}" alt="" class="product-img__main img-fluid">
                </div>
                <div class="product-img__extra row mt-3 flex-nowrap overflow-auto">
                    <img src="{{ asset('images/product1.jpg') }}" alt="" class="product-img__extra-item img-fluid col-3">
                    <img src="{{ asset('images/product2.jpg') }}" alt="" class="product-img__extra-item img-fluid col-3">
                    <img src="{{ asset('images/product3.jpg') }}" alt="" class="product-img__extra-item img-fluid col-3">
                    <img src="{{ asset('images/product1.jpg') }}" alt="" class="product-img__extra-item img-fluid col-3">
                    <img src="{{ asset('images/product2.jpg') }}" alt="" class="product-img__extra-item img-fluid col-3">
                    <img src="{{ asset('images/product3.jpg') }}" alt="" class="product-img__extra-item img-fluid col-3">
                    <img src="{{ asset('images/product1.jpg') }}" alt="" class="product-img__extra-item img-fluid col-3">
                </div>
            </div>
            <!-- Product Infomation -->
            <div class="col-12 col-md-6">
                <div class="product-info col-12 ps-md-5 mt-md-0 d-flex flex-column mt-4">
                    <h1>Đồng phục sinh viên</h1>
                    <div class="d-flex">
                        <label>Loại: <span class="product-info__cate fw-bold">Áo sơ mi</span></label>
                        <label>Tồn kho: <span class="product-info__stock">98</span></label>
                    </div>

                    <span class="product-info__price fw-bold">69,999đ</span>

                    <div class="d-flex justify-content-between align-content-center">
                        <select class="product-info__size form-select mt-2 w-25">
                            <option selected>Size</option>
                            <option value="">S</option>
                            <option value="">M</option>
                            <option value="">L</option>
                            <option value="">XL</option>
                        </select> 
                        <a href="{{ route('orders.cart') }} class="action-item addCart addCartPC btn rounded d-flex"><span class="d-block mt-1"><i class="fa-solid fa-cart-plus me-2"></i>Thêm giỏ hàng</span></a>
                    </div>

                    <div class="d-flex justify-content-between align-content-center mt-md-3">
                        <div class="product-quantity input-group mb-3 mt-4 mb-md-0 mt-md-0 w-25">
                            <button class="btn btn-outline-secondary" type="button" onclick="">−</button>
                            <input type="number" class="form-control text-center" id="product-quantity" value="1" min="1" max="100">
                            <button class="btn btn-outline-secondary" type="button" onclick="">+</button>
                        </div>
                        <a href="{{ route('orders.payment') }} class="action-item buyNow buyNowPC btn btn-danger rounded d-flex"><span class="d-block mt-1">Mua ngay</span></a>
                    </div>
                </div>
                <!-- Description -->
                <div class="product-desc col-12 mt-4 mt-md-5 px-md-5 py-md-2">
                    <h2>Mô tả sản phẩm</h2>
                    <div class="mt-3" id="desc">
                        <div class="card card-body" style="font-size: 1.4rem;">
                            <p> Tên sản phẩm: Áo đồng phục trường CTUET</p>
                            <p>🏫 Dành cho: Học sinh/Sinh viên CTUET</p>
                            <h4>✅ Chất liệu:</h4>
                            <p>Được làm từ vải cotton 65/45 thoáng mát, thấm hút mồ hôi tốt.
                                Vải co giãn nhẹ, giữ form lâu dài, không nhăn, không phai màu.
                            </p>
                            <h4>✅ Thiết kế:</h4>
                            <p>Kiểu dáng trẻ trung, năng động, phù hợp cho học sinh/sinh viên.
                                Cổ áo: Có thể là cổ trụ (áo polo) hoặc cổ tròn (áo thun).
                                Logo trường được in/thêu trên ngực trái, tạo sự tự hào và nhận diện.
                                Màu sắc: Màu chủ đạo theo thiết kế của trường (thường là trắng, xanh, xám, hoặc đỏ).
                            </p>
                            <h4>✅ Size & Độ vừa vặn:</h4>
                            
                            Có nhiều size từ S → XXL, phù hợp cho từng vóc dáng học sinh/sinh viên.
                            Form áo: Thoải mái, dễ vận động trong các hoạt động thể chất & học tập.
                            <h4>✅ Công dụng:</h4>
                            
                            Mặc hàng ngày đến trường theo quy định.
                            Dễ phối đồ với quần jean, kaki, hoặc chân váy.
                            Thích hợp cho các hoạt động ngoại khóa, sự kiện trường học.
                            <h4>✅ Hướng dẫn bảo quản:</h4>
                            
                            Giặt với nước lạnh, tránh dùng chất tẩy mạnh.
                            Phơi nơi râm mát, tránh ánh nắng trực tiếp để giữ màu áo bền lâu.
                            Ủi ở nhiệt độ thấp nếu cần.
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        showDetailAction()
    </script>
@endsection