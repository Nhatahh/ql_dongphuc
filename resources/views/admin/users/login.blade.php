
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin.head')
    <title>{{ $title }}</title>
    <style>
        /* #background_image{
            height: 100%;
            background-size: cover;
        } */
        img{
            position: absolute;
        }
    </style>
</head>
<body class="login-page">
    <img src="\img\CTUT_logo.jpg" onclick="hide_logo()" alt="logo CTUT" id='logo' class="img-circle" style="opacity: .9;height:auto;width:150px;z-index: 1">
    <img  id ="background_image" onclick="hide_logo()" class="img-fluid" style="opacity: .6;background-size: cover;height:100%;z-index: 0" >
    <div class="login-box">
        <div id = 'login_theme' class="card" style="background: none;border:none">
            <div class="card-body login-card-body" style="background: none">
                <div class="input-group mb-3">
                    <input type="text" name = 'email'  id= 'email' class="form-control validate_login_admin" placeholder="Email"  style="background: none;color:white">
                    <div class="input-group-append">
                        <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <sup>
                        <p id = "v_email" style="color: white"></p>
                    </sup>
                </div>
                <div class="input-group mb-3">
                    <input type='password' id= 'password'   name = 'password' class="form-control validate_login_admin" placeholder="Password" style="background: none;color:white">
                    <div class="input-group-append">
                        <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <sup>
                        <p id = "v_password" style="color: white"></p>
                    </sup>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p style="color: white" id = 'info_login_admin'></p>
                    </div>
                    <div class="col-7">
                    </div>
                    <div class="col-5">
                        <button id='sign_in' style="background: none" class="btn btn-primary btn-block">Đăng nhập</button>
                    </div>
                </div>
        </div>
    </div>
</body>
</html>

<script src="/template/admin/plugins/jquery/jquery.min.js"></script>
<script src="/admin/js/login/control.js"></script>
<script>

$(document).ready(function(){
        $('.login-box').hide();
        $('#logo').show();
        var  i = Math.floor(Math.random() * 8);
        var image = "/images/locksreen/h"+(i+1)+".jpg"
        $('#background_image').attr('src',image)
})

function hide_logo(){
    $('#background_image').css('opacity','.9')
    $('.login-box').show('slow');
    $('#logo').hide();
}
</script>
