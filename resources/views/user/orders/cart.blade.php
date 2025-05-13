@extends('layouts.app')

@section('title', 'Giỏ Hàng')

@section('content')
    <!-- Body -->
    <div class="body p-3 mt-2 bg-white">
        <div class="container">
            <!-- Search -->
            <div class="nav-search row d-flex align-items-center">
                <div class="col-1 text-center">
                    <a href="{{ route('uniforms.store') }}" class=" text-decoration-none"><i class="back-icon fa-solid fa-chevron-left p-3 d-block"></i></a>
                </div>
                <div class="col-9">
                    <div class="search input-group">
                        <input type="text" class="form-control w-50" placeholder="Nhập từ khóa...">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                </div>
                <div class="col-2 d-flex justify-content-end">
                    <a class="btn p-3" href="profile.html"><div class="profile"><i class="fa-solid fa-user"></i></div></a>
                </div>
            </div>
            <!-- Giỏ hàng -->
            <div class="cart-list" style="max-height: 75vh;">
                <div class="row mt-5 g-0">
                    @foreach ($cartItems as $item)
                        <div class="cart-item border rounded p-2 mb-3 d-flex align-items-center">
                            <input type="checkbox" class="cart-item__checkbox form-check-input ms-2 me-4">
                            <img src="{{ asset('images/' . $item->image_url) }}" class="cart-item__img img-fluid rounded me-3">
                            <div class="cart-item__content flex-grow-1">
                                <a href="{{ route('uniforms.show_detail', $item->sp_id) }}" style="text-decoration: none; color: black;"><p class="mb-1 fw-bold fs-2">{{ $item->tensp }}</p></a>
                                <p class="fw-bold" style="color: red;">{{ number_format($item->gia, 0, ',', '.') }}đ</p>
                                <div class="input-group product-quantity align-items-center float-start">
                                    <button class="btn btn-outline-secondary" type="button" onclick="changeQuantity(this, -1)">-</button>
                                    <input type="number" class="form-control text-center form-control-sm quantity-input"
                                        value="{{ $item->soluong }}" min="1" data-kho-id="{{ $item->kho_id }}" id="soluong_{{ $item->kho_id }}">
                                    <button class="btn btn-outline-secondary" type="button" onclick="changeQuantity(this, 1)">+</button>
                                    <span class="ms-2 text-danger err_soluong" id="err_soluong_{{ $item->kho_id }}"></span>
                                    
                                </div>
                                <button class="btn btn-success ms-2 btn-update-quantity" data-kho-id="{{ $item->gh_id }}">Cập nhật</button>
                                <button class="btn btn-danger ms-2 btn-update-quantity" data-kho-id="{{ $item->gh_id }}">Xóa</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection