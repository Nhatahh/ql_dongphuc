@extends('layouts.app')

@section('title', 'Trang Cá Nhân')

@section('content')
    <!-- Body -->
    <div class="body container mt-2 bg-white">    
        <div class="body-bar row d-flex align-items-center">
            <div class="col-1 text-center py-3">
                <a href="{{ route('uniforms.store') }} class=" text-decoration-none"><i class="back-icon fa-solid fa-chevron-left p-3 d-block"></i></a>
            </div>
            <div class="col-8 d-flex justify-content-center" style="font-size: 1.4rem; translate: 10%;">
                Trang cá nhân
            </div>
            <div class="col-3 d-flex justify-content-end">
                <a class="btn p-3" href="{{ route('orders.cart') }}><div class="cart col-6"><i class="fa-regular fa-bell"></i></div></a>
                <a class="btn p-3" href="{{ route('user.profile') }}><div class="profile col-6"><i class="fa-solid fa-user"></i></div></a>
            </div>
        </div>


        <div class="user-info d-flex flex-column align-items-center">
            <img class="img-fluid mb-2 mt-4" src="../assets/img/slider2.jpg" alt="">
            <h3>{{ $user->username }}</h3>
            <p>{{ $user->sdt }}</p>
            <p>{{ $user->email }}</p>
        </div>

        <div class="profile-active d-flex justify-content-center mt-5 text-center">
            <div class="d-flex flex-column align-items-center">
                <i class="icon-active fa-solid fa-box-open"></i>
                <span>Đơn hàng</span>
            </div>
            <div class="d-flex flex-column align-items-center">
                <i class="icon-active fa-solid fa-clock-rotate-left"></i>
                <span>Lịch sử mua</span>
            </div>
            <div class="d-flex flex-column align-items-center">
                <i class="icon-active fa-regular fa-star"></i>
                <span>Đánh giá</span>
            </div>
            <div class="d-flex flex-column align-items-center">
                <i class="icon-active fa-solid fa-box-open"></i>
                <span>Chưa biết</span>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="{{ asset('js/main.js') }}"></script>
@endsection