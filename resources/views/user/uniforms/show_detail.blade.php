@extends('layouts.app')

@section('title', 'Chi Tiết Sản Phẩm')

@section('content')
    <!-- Body -->
      <div class="body show-detail container p-3 bg-white">
        <!-- Product-Detail -->
        <div class="product-detail row mt-4">
            <!-- Product-img -->
            <div class="product-img col-12 col-md-6">
                <div class="row">
                    <img id="mainImage" 
                        src="{{ asset('images/' . $ct_sp->image_url) }}" 
                        alt="Ảnh sản phẩm" 
                        class="product-img__main img-fluid zoomable" 
                        style="cursor: zoom-in;" 
                        data-bs-toggle="modal" 
                        data-bs-target="#imageModal">                
                </div>
                <!-- Modal hiển thị ảnh lớn -->
                <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content bg-transparent border-0">
                            <div class="modal-body text-center p-0">
                                <img id="modalImage" src="{{ asset('images/' . $ct_sp->image_url) }}" 
                                    class="img-fluid" style="max-height: 90vh; object-fit: contain;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-img__extra row mt-3 flex-nowrap overflow-auto">
                    <img src="{{ asset('images/' . $ct_sp->image_url) }}" alt="" class="product-img__extra-item img-fluid col-3 thumbnail" style="cursor:pointer">
                    <img src="{{ asset('images/product1.jpg') }}" alt="" class="product-img__extra-item img-fluid col-3 thumbnail" style="cursor:pointer">
                    <img src="{{ asset('images/product2.jpg') }}" alt="" class="product-img__extra-item img-fluid col-3 thumbnail" style="cursor:pointer">
                    <img src="{{ asset('images/product3.jpg') }}" alt="" class="product-img__extra-item img-fluid col-3 thumbnail" style="cursor:pointer">
                </div>
            </div>
            <!-- Product Infomation -->
            <div class="col-12 col-md-6">
                <div class="product-info col-12 ps-md-5 mt-md-0 d-flex flex-column mt-4">
                    <div class="fs-1 mb-3"><strong>{{ $ct_sp->tensp }}</strong></div>
                    <div class="d-flex flex-column">
                        <p>Loại: <span class="product-info__cate">{{ $ct_sp->ten_danhmuc }}</span></p>
                        <p>Nhà sản xuất: <span class="product-info__nsx">{{ $ct_sp->ten_nsx }}</span></p>
                        <div class="d-flex w-50 justify-content-between">
                            <!-- <p>Tồn kho: <span class="product-info__stock" >{{ $ct_sp->tonkho }}</span></p> -->
                            <small class="text-muted"
                                id="tonkho_{{ $ct_sp->sp_id }}"
                                data-tonkho="{{ $ct_sp->tonkho }}">
                                {{ $ct_sp->tonkho }} sản phẩm còn lại
                            </small>
                            <small class="text-muted">Đã bán: {{ $soLuongDaBan  }}</small>
                        </div>
                    </div>
                    <span class="product-info__price fw-bold" style="color: red;">{{ number_format($ct_sp->gia, 0, ',', '.') }} ₫</span>
                    <div class="gap-3 d-flex justify-content-center mt-3">
                        <div class="input-group quantity-group" style="max-width: 100px;">
                            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="changeQuantity(this, -1)">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number"
                                class="form-control text-center form-control-sm quantity-input"
                                value="1" min="1"
                                data-sp-id="{{ $ct_sp->sp_id }}" id="soluong_{{ $ct_sp->sp_id }}">
                            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="changeQuantity(this, 1)">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <!-- select 2 size -->
                        <select id="sizeSelect2" class="form-select sizeSelect2" style="max-width: 200px;" data-sp-id="{{ $ct_sp->sp_id }}">
                            <option value="">--- Chọn size ---</option>
                        </select>            
                    </div>
                    <div class="gap-3 d-flex justify-content-center mt-3">
                        <button class="btn btn-danger fs-4 w-50" data-sp-id="{{ $ct_sp->sp_id }}" data-url=""><i class="bi bi-bag-check-fill"></i> Mua ngay</button>
                        <button class="btn btn-primary btn-addSP fs-4 w-50" data-sp-id="{{ $ct_sp->sp_id }}" data-url="{{ route('addSP') }}" data-cart-url="{{ route('orders.cart') }}"><i class="fa-solid fa-cart-plus"></i> Thêm giỏ hàng</button>
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

            <!-- Đánh giá sản phẩm -->
            <div class="product-rating col-12 mt-4">
                <h3><i class="fa-solid fa-star text-warning me-2"></i>Đánh giá sản phẩm</h3>
                @if ($danhgias->isEmpty())
                    <div class="text-center w-100 py-5">
                        <i class="fa-solid fa-star fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Chưa có đánh giá cho sản phẩm này.</h5>
                    </div>
                @else
                    @foreach ($danhgias as $dg)
                        <div class="product-rating__content mt-4 p-3 border rounded">
                            <div class="d-flex align-items-center mb-2"> 
                                <img src="{{ $dg->avt_url ? asset('images/avt/' . $dg->avt_url) : asset('images/default-avatar.png') }}"
                                    alt="avatar"
                                    class="rounded-circle me-3"
                                    style="width: 40px; height: 40px; object-fit: cover;">
                                
                                <div>
                                    <strong>{{ $dg->user_name ?? 'Khách hàng' }}</strong>
                                    <div class="text-warning">
                                        @for ($i = 0; $i < $dg->rating; $i++)
                                            <i class="fa-solid fa-star"></i>
                                        @endfor
                                        @for ($i = $dg->rating; $i < 5; $i++)
                                            <i class="fa-regular fa-star"></i>
                                        @endfor
                                    </div>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($dg->created_at)->diffForHumans() }}</small>
                                </div>
                            </div>

                            <p class="mt-2 fs-5 text-dark">{{ $dg->binhluan }}</p>

                            {{-- Hình ảnh đánh giá --}}
                            @if($dg->anh_url)
                                <div class="d-flex gap-2 mt-3">
                                    <img src="{{ asset('images/danhgia/' . $dg->anh_url) }}"
                                        alt="hình đánh giá"
                                        style="width: 80px; height: auto;"
                                        class="rounded">
                                </div>
                            @endif
                        </div>
                    @endforeach
                    <!-- PHÂN TRANG -->
                    <div class="mt-3">
                        {{ $danhgias->links() }}
                    </div>
                @endif
            </div>

            <!-- Gợi ý sản phẩm -->
            <div class="product-list">
                <div class="suggest mt-4 d-flex justify-content-between">
                    <span class="fw-bold fst-italic fs-4">Gợi ý cho bạn</span>
                </div>
                <div class="row">
                    @foreach($sanphams as $sp)
                        <div class="col-6 col-md-3 mt-4 d-flex">
                            <a href="{{ route('uniforms.show_detail', $sp->sp_id) }}" class="text-decoration-none text-dark w-100">
                                <div class="card h-100 d-flex flex-column shadow-sm border-0 position-relative hover-shadow" style="transition: transform 0.3s ease;">
                                    {{-- Hình ảnh sản phẩm --}}
                                    <img src="{{ asset('images/' . $sp->image_url) }}" class="card-img-top" alt="{{ $sp->tensp }}"
                                        style="height: 220px; object-fit: cover; border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem;">

                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title text-truncate" title="{{ $sp->tensp }}">{{ $sp->tensp }}</h5>

                                        <p class="card-text" style="
                                            flex-grow: 1;
                                            overflow: hidden;
                                            display: -webkit-box;
                                            -webkit-line-clamp: 2;
                                            -webkit-box-orient: vertical;">
                                            {{ $sp->mota }}
                                        </p>

                                        <div class="d-flex justify-content-between align-items-center mt-auto">
                                            <p class="fs-5 fw-bold text-danger mb-0">
                                                {{ number_format($sp->gia, 0, ',', '.') }} ₫
                                            </p>
                                            <p class="fs-6 mb-0">Đã bán: {{ $sp->so_luong_da_ban ?? 0 }}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/users/changeImage.js') }}"></script>
@endpush