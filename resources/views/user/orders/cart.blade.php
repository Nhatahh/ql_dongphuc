@extends('layouts.app')

@section('title', 'Giỏ Hàng')

@section('content')
    <!-- Body -->
    <div class="body p-3 mt-2 bg-white">
        <div class="container">
            <!-- Search -->
            <div class="nav-search row d-flex align-items-center">
                <div class="col-1 text-center">
                    <a href="{{ route('uniforms.store') }} class=" text-decoration-none"><i class="back-icon fa-solid fa-chevron-left p-3 d-block"></i></a>
                </div>
                <div class="col-9">
                    <div class="search input-group">
                        <input type="text" class="form-control w-50" placeholder="Nhập từ khóa...">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                </div>
                <div class="col-2 d-flex justify-content-end">
                    <a class="btn p-3" href="{{ route('user.profile') }}><div class="profile"><i class="fa-solid fa-user"></i></div></a>
                </div>
            </div>

            <div class="cart-list" style="max-height: 75vh;">
                <div class="row mt-5 g-0">
                    <div class="cart-item border rounded p-2 mb-3 d-flex align-items-center">
                        <input type="checkbox" class="cart-item__checkbox form-check-input ms-2 me-4">
                        <img src="{{ asset('images/product3.jpg') }}" class="cart-item__img img-fluid rounded me-3">
                        <div class="cart-item__content flex-grow-1">
                            <p class="mb-1 fw-bold">Đồng phục sinh viên</p>
                            <p class="text-danger fw-bold mb-1">69,999đ</p>
                            <div class="input-group product-quantity">
                                <button class="btn btn-outline-secondary btn-sm" type="button" onclick="changeQuantity(this, -1)">-</button>
                                <input type="number" class="form-control text-center form-control-sm" value="1" min="1">
                                <button class="btn btn-outline-secondary btn-sm" type="button" onclick="changeQuantity(this, 1)">+</button>
                            </div>                   
                        </div>
                    </div>
                </div>        
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="{{ asset('js/main.js') }}"></script>
@endsection