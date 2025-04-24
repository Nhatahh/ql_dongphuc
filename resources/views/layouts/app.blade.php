<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Quản lý đồng phục')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap từ local -->
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">


    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/styleMobile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/stylePC.css') }}">



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
