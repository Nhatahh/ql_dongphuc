<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Quản lý đồng phục')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap từ local --}}
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    
    @stack('styles') {{-- Cho phép trang con đẩy thêm CSS nếu cần --}}
</head>
<body>

    {{-- Thanh điều hướng --}}
    @include('layouts.navbar')

    {{-- Nội dung chính --}}
    <div class="container mt-4">
        @yield('content')
    </div>

    {{-- JS --}}
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    @stack('scripts') {{-- Cho phép trang con đẩy thêm JS nếu cần --}}
</body>
</html>
