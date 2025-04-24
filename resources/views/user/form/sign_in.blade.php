<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styleForm.css') }}">
    <style>

    </style>
</head>
<body>
    <div class="body-form">
        <div class="sign_in-modal">
            <a href="{{ route('home.index') }}"><i class="fa-solid fa-chevron-left"></i></a>
            <form action="" method="">
                <h2><b>ĐĂNG NHẬP</b></h2>
                <div class="userName form-group">
                    <input class="form-control" type="text" placeholder="Nhập email hoặc số điện thoại">
                </div>
                <div class="password form-group">
                    <input class="form-control" type="password" placeholder="Mật khẩu">
                </div>
                <button class="signinBtn">Đăng nhập</button> 
                <span>Quên mật khẩu?</span>
                <a href="#" class="signupLink">Đăng ký</a>
            </form>
        </div>
    </div>
</body>
</html>