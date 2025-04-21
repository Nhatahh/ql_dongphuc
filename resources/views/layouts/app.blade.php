<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Quản lý đồng phục')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/styleMobile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/stylePC.css') }}">

    <!-- Bootstrap từ local -->
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    @stack('styles') {{-- Cho phép trang con đẩy thêm CSS nếu cần --}}
</head>
<body>

    {{-- Nav --}}
    @include('layouts.navbar')

    {{-- Nội dung chính --}}
    @yield('content')


    {{-- Footer --}}
    @include('layouts.footer')

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- JS --}}
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>


    @stack('scripts') {{-- Cho phép trang con đẩy thêm JS nếu cần --}}

    <script>
        window.addEventListener('DOMContentLoaded', function () {
            const navbar = document.querySelector('.layouts_navbar');
            const body = document.querySelector('.body');
            if (navbar && body) {
                const navbarHeight = navbar.offsetHeight;
                body.style.marginTop = navbarHeight + 'px';
            }
        });
    </script>
</body>
</html>
