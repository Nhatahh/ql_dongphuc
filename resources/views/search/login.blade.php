
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('user.head')
    <title>{{ $title }}</title>

    <!-- Select2 -->
    <link rel="stylesheet" href="/template/admin/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/template/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <style>
        .select2-container--default .select2-selection--single {
            height: 36px
        }
    </style>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
    <div class="login-logo">
        {{-- <a href="#"><b>Đăng nhập</a> --}}
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
        <p class="login-box-msg"><strong>HỆ THỐNG TRA CỨU KẾT QUẢ XÉT TUYỂN</strong></p>

        <form action="" method="">
            {{-- <div class="col-12 col-md-12"> --}}
            <div class="form-group row" style="margin-bottom: 3px">
                {{-- <label for="batch_login" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Đợt TS:</label> --}}
                <div class="col-sm-12">
                    <select  name = 'batch_login' id="batch_login"  class="form-control validate_login" style="width: 100%; height: 36px">

                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <sup>
                    <p id = "v_batch_login" class="error"></p>
                </sup>
            </div>
            {{-- </div> --}}

            <div class="input-group mb-3">
                <input type="text" name = 'cmnd_login'  id = 'cmnd_login' class="form-control validate_login" placeholder="Chứng minh nhân dân/Thẻ căn cước">
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

            <div class="col-md-12">
                <p style="color: rgb(12, 12, 232)" id = 'info_login'></p>
            </div>
            <div class="col-sm-12">
                <div class="input-group mb-1">
                    <button style="height: 35px;" type="button"   onclick = "searchlogin()" class="btn btn-primary btn-block"><i class="fa fa-search">&nbsp;&nbsp;</i>Tra cứu kết quả</button>
                </div>
            </div>


            @csrf
        </form>
    </div>
</div>


<!-- /.login-box -->
</html>
<script src="/template/admin/plugins/jquery/jquery.min.js"></script>
<script src="/user/js/search/control.js"></script>
<script src="/template/admin/plugins/select2/js/select2.full.min.js"></script>
