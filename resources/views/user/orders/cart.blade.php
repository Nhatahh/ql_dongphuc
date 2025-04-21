@extends('layouts.app')

@section('title', 'Giỏ Hàng')

@section('content')
    <div class="body container">
            <!-- Giỏ hàng -->
            <div class="cart-list" style="max-height: 75vh;">
                <div class="row mt-5 g-0">
                    @foreach ($cartItems as $item)
                        <div class="cart-item border rounded p-2 mb-3 d-flex align-items-center">
                            <input type="checkbox" class="cart-item__checkbox form-check-input ms-2 me-4">
                            <img src="{{ asset('images/' . $item->image_url) }}" class="cart-item__img img-fluid rounded me-3">
                            <div class="cart-item__content flex-grow-1">
                                <p class="mb-1 fw-bold">{{ $item->tensp }}</p>
                                <p class="text-danger fw-bold mb-1">{{ number_format($item->gia, 0, ',', '.') }}đ</p>
                                <div class="input-group product-quantity align-items-center float-start">
                                    <button class="btn btn-outline-secondary" type="button" onclick="changeQuantity(this, -1)">-</button>
                                    <input type="number" class="form-control text-center form-control-sm quantity-input"
                                        value="{{ $item->soluong }}" min="1" data-kho-id="{{ $item->kho_id }}" id="soluong_{{ $item->kho_id }}">
                                    <button class="btn btn-outline-secondary" type="button" onclick="changeQuantity(this, 1)">+</button>
                                    <span class="ms-2 text-danger err_soluong" id="err_soluong_{{ $item->kho_id }}"></span>
                                    
                                </div>
                                <button class="btn btn-success ms-2 btn-update-quantity" data-kho-id="{{ $item->kho_id }}">Cập nhật</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
    </div>
@endsection
