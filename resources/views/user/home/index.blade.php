@extends('layouts.app')

@section('title', 'Trang Chủ')

@section('content')
    <!-- Body -->
    <div class="body container">
        <div class="title text-center">
            <h5><strong>ĐỒNG PHỤC SINH VIÊN</strong></h5>
            <h4>HỆ THỐNG ĐẶT MUA ĐỒNG PHỤC NHANH CHÓNG VÀ TIỆN LỢI</h4>
        </div>
        <!-- Slider -->
        <div class="row mt-4">
            <div class="col-12">
                <div id="carouselExampleIndicators" class="carousel" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="slider-img carousel-inner">
                        <div class="carousel-item active">
                        <img src="{{ asset('images/slider1.jpg') }}" class="d-block w-100" alt="slider1">
                        </div>
                        <div class="carousel-item">
                        <img src="{{ asset('images/slider3.jpg') }}" class="d-block w-100" alt="slider3">
                        </div>
                        <div class="carousel-item">
                        <img src="{{ asset('images/slider2.jpg') }}" class="d-block w-100" alt="slider2">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <i class="fa-solid fa-circle-chevron-left fs-2 fw-bold text-white"></i>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <i class="fa-solid fa-circle-chevron-right fs-2 text-white"></i>
                    </button>
                    </div>
            </div>
        </div>
    
        <!-- Banner -->
        <div class="row mt-3">
            <div class="col-12">
                <img class="w-100" src="{{ asset('images/banner.jpg') }}" alt="dsfsdfsd">
            </div>
        </div>
    
        <div class="suggest mt-4 d-flex justify-content-between">
            <span>Gợi ý cho bạn</span>
            <span><a class="text-warning fst-italic fw-bold" href="{{ route('uniforms.store') }}">Xem thêm <i class="fa-solid fa-angles-right"></i></a></span>
        </div>
    
        <!-- Product -->
        <div class="product row mt-2">
            <div class="row d-flex flex-nowrap overflow-auto">
                @foreach($sanphams as $sp)
                    <div class="col-6 col-md-4">
                        <div class="card h-100">
                            <img src="{{ asset('images/' . $sp->image_url) }}" class="card-img-top" alt="{{ $sp->tensp }}">
                            <div class="card-body d-flex flex-column">
                                <div class="text-center fs-2 fw-bold gia" style="color: red;">
                                    {{ number_format($sp->gia, 0, ',', '.') }} VND
                                </div>
                                <a href="{{ route('uniforms.show_detail') }}" style="text-decoration: none;">
                                    <div class="card-title fs-2 tensp" style="color: black;">{{ $sp->tensp }}</div>
                                </a>
                                    <p class="card-text fs-3 mota">{{ $sp->mota }}</p>
                                <div class="text-center mt-auto">
                                    <hr>
                                    <a href="#" class="order text-white btn btn-primary card-link fs-4">
                                        <i class="fa-solid fa-gift me-1"></i> Đặt hàng
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>  
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="{{ asset('js/main.js') }}"></script>
@endsection
