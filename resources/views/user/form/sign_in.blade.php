<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Đăng nhập</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

  <a href="{{ route('home.index') }}" class="back-link">
    <i class="fa-solid fa-chevron-left"></i> Trang chủ
  </a>

  <div class="container-login">
    <div class="login-image">
      <img src="{{ asset('images/logo3.jpg') }}" alt="logo">
    </div>
    <div class="login-form">
      <form action="" method="">
      <h2>Xin chào, hãy tham gia cùng chúng tôi nhé!</h2>

      <div class="form-group mb-3">
        <label>Email hoặc số điện thoại</label>
        <input class="form-control input-animate" type="text" placeholder="Nhập email hoặc SĐT" required>
      </div>

      <div class="form-group mb-3">
        <label>Mật khẩu</label>
        <input class="form-control input-animate" type="password" placeholder="Nhập mật khẩu" required>
      </div>

      <div class="form-check mb-3">
        <input type="checkbox" class="form-check-input" id="rememberMe">
        <label class="form-check-label" for="rememberMe">Ghi nhớ đăng nhập</label>
      </div>

      <button type="submit" class="signinBtn">Đăng nhập</button>

      <div class="google-login mb-3">
        <a href="{{ route('login.google') }}" class="google-btn">
          <i class="fa-brands fa-google"></i> Đăng nhập với Google
        </a>
      </div>

      <div class="form-footer">
        <a href="#">Quên mật khẩu?</a> |
        <a href="#" class="signupLink">Đăng ký tài khoản</a>
      </div>

      </form>
    </div>
  </div>

</body>
</html>
