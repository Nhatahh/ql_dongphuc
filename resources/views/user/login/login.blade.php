
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('user.head')
    <title>{{ $title }}</title>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
    <div class="login-logo">
        {{-- <a href="#"><b>Đăng nhập</a> --}}
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
        <p class="login-box-msg"><strong>HỆ THỐNG QUẢN LÝ XÉT TUYỂN</strong></p>

        <form action="" method="">
            {{-- @if ($errors->has('email_login'))
                <div class="input-group mb-3">
                    <sub style="color: red">
                        {{ $errors->first('email_login') }}
                    </sub>
                </div>
            @endif --}}

            <div class="input-group mb-3">
                <input type="text" name = 'email_login' id = 'email_login' class="form-control validate_login"  placeholder="Email">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <sup>
                    <p id = "v_email_login" class="error"></p>
                </sup>
            </div>



            <div class="input-group mb-3">
                <input type="text" name = 'phone_login' id = 'phone_login' class="form-control validate_login"  placeholder="Số điện thoại">
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-phone"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <sup>
                    <p id = "v_phone_login" class="error"></p>
                </sup>
            </div>

            <div class="input-group mb-3">
                <input type="text" name = 'cmnd_login'   id = 'cmnd_login' class="form-control validate_login" placeholder="Chứng minh nhân dân/Thẻ căn cước">
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-id-card"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <sup>
                    <p id = "v_cmnd_login" class="error"></p>
                </sup>
            </div>

            <div class="input-group mb-3">
                <input type="password" name = 'password_login'   id = 'password_login' class="form-control validate_login"  placeholder="Mật khẩu">
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-unlock-alt"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <sup>
                    <p id = "v_password_login" class="error"></p>
                </sup>
            </div>

            <div class="col-md-12">
                <p style="color: rgb(12, 12, 232)" id = 'info_login'></p>
            </div>

            <div class="input-group mb-3">
                <button type="button"   onclick = "Userlogin()" class="btn btn-primary btn-block"><i class="fa fa-user-circle"></i> Đăng nhập</button>
            </div>

            <p class="mb-0">
                <a href="/register" class="text-center" >Đăng ký tài khoản xét tuyển</a>
            </p>

            <p class="mb-0">
                <a href="/passwordreset" class="text-center" >Quên mật khẩu, thông tin tài khoản</a>
            </p>

            @csrf
        </form>
    </div>
</div>


<!-- /.login-box -->
</html>
<script src="/template/admin/plugins/jquery/jquery.min.js"></script>
<script src="/user/js/login/control.js"></script>

