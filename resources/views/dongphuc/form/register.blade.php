<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Đăng ký</title>
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
        <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h2>ĐĂNG KÝ TÀI KHOẢN!</h2>

            {{-- Hiển thị lỗi --}}
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
            @endif

            {{-- Tên tài khoản --}}
            <div class="form-group mb-3">
            <label>Tên tài khoản</label>
            <input type="text" name="username" class="form-control input-animate @error('username') is-invalid @enderror"
                    placeholder="Nhập tên tài khoản" value="{{ old('username') }}">
            @error('username')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            </div>

            {{-- Họ tên --}}
            <div class="form-group mb-3">
            <label>Họ tên</label>
            <input type="text" name="hoten" class="form-control input-animate @error('hoten') is-invalid @enderror"
                    placeholder="Nhập họ tên" value="{{ old('hoten') }}">
            @error('hoten')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            </div>

            {{-- Email --}}
            <div class="form-group mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control input-animate @error('email') is-invalid @enderror"
                    placeholder="Nhập email" value="{{ old('email') }}">
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            </div>

            {{-- Số điện thoại --}}
            <div class="form-group mb-3">
            <label>Số điện thoại</label>
            <input type="text" name="sdt" class="form-control input-animate @error('sdt') is-invalid @enderror"
                    placeholder="Nhập số điện thoại" value="{{ old('sdt') }}">
            @error('sdt')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            </div>

            {{-- Địa chỉ --}}
            <div class="form-group mb-3">
            <label>Địa chỉ</label>
            <input type="text" name="diachi" class="form-control input-animate @error('diachi') is-invalid @enderror"
                    placeholder="Nhập địa chỉ" value="{{ old('diachi') }}">
            @error('diachi')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            </div>

            {{-- Ảnh đại diện (File) --}}
            <div class="form-group mb-3">
                <label>Ảnh đại diện</label>
                <input type="file" name="avt_file" accept="image/*"
                    class="form-control input-animate @error('avt_file') is-invalid @enderror">
                @error('avt_file')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- MSSV --}}
            <div class="form-group mb-3">
            <label>MSSV</label>
            <input type="text" name="mssv" class="form-control input-animate @error('mssv') is-invalid @enderror"
                    placeholder="Nhập MSSV" value="{{ old('mssv') }}">
            @error('mssv')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            </div>

            {{-- Mật khẩu --}}
            <div class="form-group mb-3">
            <label>Mật khẩu</label>
            <input type="password" name="password" class="form-control input-animate @error('password') is-invalid @enderror"
                    placeholder="Nhập mật khẩu">
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            </div>

            {{-- Nhập lại mật khẩu --}}
            <div class="form-group mb-3">
            <label>Nhập lại mật khẩu</label>
            <input type="password" name="password_confirmation" class="form-control input-animate"
                    placeholder="Nhập lại mật khẩu">
            </div>

            <button type="submit" class="signinBtn">Đăng ký</button>

            <div class="form-footer mt-3">
            <a href="{{ route('login') }}" class="signupLink">Đã có tài khoản? Đăng nhập</a>
            </div>
        </form>
    </div>
  </div>

</body>
</html>
