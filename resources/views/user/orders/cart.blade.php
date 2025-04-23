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
                            <a href="{{ route('uniforms.show_detail', ['sp_id' => $item->sp_id]) }}" class="card-title fs-2 tensp" style="color: black; text-decoration: none;">
                                {{ $item->tensp }}
                            </a>
                            <p class="text-danger fw-bold mb-1">{{ number_format($item->gia, 0, ',', '.') }}đ</p>
                            <div class="input-group product-quantity align-items-center float-start">
                                <button class="btn btn-outline-secondary" type="button" onclick="changeQuantity(this, -1)">-</button>
                                <input type="number" class="form-control text-center form-control-sm quantity-input"
                                    value="{{ $item->soluong }}" min="1" data-id="{{ $item->gh_id }}" id="soluong_{{ $item->gh_id }}">
                                <button class="btn btn-outline-secondary" type="button" onclick="changeQuantity(this, 1)">+</button>
                                <span class="ms-2 text-danger err_soluong" id="err_soluong_{{ $item->gh_id }}"></span>
                                
                            </div>
                            <button type="button" class="btn btn-primary ms-2 btn-update-quantity" data-id="{{ $item->gh_id }}">
                                <i class="fa-solid fa-upload"></i>&nbsp;&nbsp;&nbsp;Cập nhật
                            </button>
                            <span class="ms-2 text-danger err_soluong" id="err_soluong_{{ $item->gh_id }}"></span>
                            <button type="button" class="btn btn-danger ms-2 btn-delete" data-id="{{ $item->gh_id }}">
                                <i class="fa-regular fa-trash-can" onclick=""></i>&nbsp;&nbsp;&nbsp;Xóa
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
