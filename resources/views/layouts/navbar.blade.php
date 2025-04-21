<!-- Nav -->
<header class="header">
    <div class=" layouts_navbar">
        <a href="{{ route('home.index') }}">
            <img src="{{ asset('images/logo3.jpg') }}" alt="aa" class="logo" style="height: 70px;">
        </a>
        <div class="name-header">
            <p>TRƯỜNG ĐẠI HỌC</p>
            <p>KỸ THUẬT - CÔNG NGHỆ CẦN THƠ</p>
            <p>MÃ TRƯỜNG: KCC</p>
        </div>        
        <div class="nav-header">
            <div class="nav-pc d-flex justify-content-around icon-link-hover">
                <a href="{{ route('uniforms.store') }}" class="nav-item"><i class="fas fa-shopping-bag"></i><span>Cửa hàng</span></a>
                <a href="#" class="nav-item"><i class="fa-solid fa-comment"></i><span>Chat</span></a>
                <a href="{{ route('home.index') }}" class="nav-item"><i class="fas fa-home"></i><span>Trang chủ</span></a>
                <a href="{{ route('orders.cart') }}" class="nav-item"><i class="fa-solid fa-cart-shopping"></i><span>Giỏ hàng</span></a>
                <a href="{{ route('user.profile') }}" class="nav-item"><i class="fas fa-user"></i><span>Hồ sơ</span></a>
            </div>
        </div>
    </div>
</header>
