@extends('layouts.app')

@section('title', 'Cửa Hàng')

@section('content')
<div class="body container">
    <!-- Body content here... -->
    <div class="product-list">
        <div class="row">
            @foreach($sanphams as $sp)
                <div class="col-6 col-md-3 mt-4">
                    <div class="product-item card h-100">
                        <img src="{{ asset('images/' . $sp->image_url) }}" class="card-img-top" alt="{{ $sp->tensp }}">
                        <div class="card-body d-flex flex-column">
                            <div class="text-center fs-2 fw-bold gia" style="color: red;">
                                {{ number_format($sp->gia, 0, ',', '.') }} VND
                            </div>
                            <a href="{{ route('uniforms.show_detail', ['sp_id' => $sp->sp_id]) }}" class="card-title fs-2 tensp" style="color: black; text-decoration: none;">
                                {{ $sp->tensp }}
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
@endsection
