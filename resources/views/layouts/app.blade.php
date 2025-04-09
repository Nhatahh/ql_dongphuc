<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Quản lý đồng phục')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/styleMobile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/stylePC.css') }}">

    {{-- Bootstrap từ local --}}
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    
    @stack('styles') {{-- Cho phép trang con đẩy thêm CSS nếu cần --}}
</head>
<body>

    {{-- Nav --}}
    @include('layouts.navbar')

    {{-- Nội dung chính --}}
    <div class="main-content container mt-4">
        @yield('content')
    </div>

    {{-- Footer --}}
    @include('layouts.footer')

    {{-- JS --}}
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    @stack('scripts') {{-- Cho phép trang con đẩy thêm JS nếu cần --}}
</body>
</html>
