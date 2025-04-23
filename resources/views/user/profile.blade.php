@extends('layouts.app')

@section('title', 'Trang Cá Nhân')

@section('content')
    <!-- Body -->
    <div class="body">    
        <div class="body-bar row d-flex align-items-center">
            <div class="col-1 text-center">
                <a href="#" class=" text-decoration-none"><i class="back-icon fa-solid fa-chevron-left p-3 d-block"></i></a>
            </div>
            <div class="col-10 fs-1 fw-bolder text-center">
                Trang cá nhân
            </div>
            <div class="col-1 text-center">
                <a class="btn" href="#"><div class="cart col-6"><i class="fa-regular fa-bell"></i></div></a>
            </div>
        </div>


        <div class="user-info d-flex flex-column align-items-center">
            <img class="img-fluid mb-2 mt-4" src="{{ asset('images/avt/' . $user->avt_images) }}" alt="avt">
            <p class="fs-2 fw-bold">{{ $user->hoten }}</p><br>
            <p class="fs-3">MSSV: {{ $user->mssv }}</p>
            <p class="fs-3">Tên tài khoản: {{ $user->username }}</p>
            <p class="fs-3">Số điện thoại: {{ $user->sdt }}</p>
            <p class="fs-3">Email: {{ $user->email }}</p>
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

@endsection