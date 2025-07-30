<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>AdminLTE 3 | Dashboard</title>

  {{-- <link rel="stylesheet" href="/user/css/loading.css"> --}}
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/template/admin/plugins/fontawesome-free-6.4.2-web/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/template/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/template/admin/dist/css/adminlte.min.css">


    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="/template/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="/template/admin/plugins/jqvmap/jqvmap.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/template/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/template/admin/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="/template/admin/plugins/summernote/summernote-bs4.min.css">
    <!-- Ckeditor -->

        <!-- Select2 -->
        <link rel="stylesheet" href="/template/admin/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="/template/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <!-- Bootstrap4 Duallistbox -->
        <link rel="stylesheet" href="/template/admin/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">

        <!-- summernote -->
        <link rel="stylesheet" href="/template/admin/plugins/summernote/summernote-bs4.min.css">

        <!-- Toastr -->
        <link rel="stylesheet" href="/template/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
        <link rel="stylesheet" href="/template/admin/plugins/toastr/toastr.min.css">

        <!-- Ckeditor -->
        <!-- Datatable -->
        <link rel="stylesheet" href="/template/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="/template/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="/template/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
        <!-- Error -->
        <link rel="stylesheet" href="/user_24/css/style.css">
        <link rel="stylesheet" href="/croppie/croppie.css">

        {{-- Slider --}}
        {{-- <link rel="stylesheet" href="/bxslider/dist/jquery.bxslider.css"> --}}
        {{-- <link rel="stylesheet" href="/user_24/css/style.css">  --}}

  {{-- <style>
    @media only screen and (max-width: 992px) {
        .hide {
            display: none;
        }
    }

    @media only screen and (max-width: 768px) {
        .hide_menu {
            display: none;
        }
    }

    .hide_menu {
        margin-left:5px;
    }

    .menu{
        display:flex;
        justify-content: space-between;
    }

    .menu .menu1{
        width:20%;
    }

    .menu .menu2{
        width:19%;
    }

    .menu .menu3{
        width:19%;
    }
    .menu .menu4{
        width:19%;
    }

    .menu .menu5{
        width:19%;
    }

    .border_header {
        border-bottom: 4px solid;
        border-image-slice: 1;
        border-image-source: linear-gradient(to right bottom,  rgb(246, 0, 0), rgb(50, 1, 1));
        box-shadow:0px 0px 0.5rem rgb(41, 0, 0)
    }

    .border_footer {
        border-top: 2px solid;
        border-image-slice: 4;
        border-image-source: linear-gradient(to right bottom,  rgb(246, 0, 0), rgb(95, 3, 3));
    }

    .icon_menu{
        font-size: 1.4rem;
    }


   .media_text{
        color: blue;
        font-size:  small;
        font-weight: bold;
    }

    .icon_menu  .hide_menu{
        font-size: 1rem;
    }

    .navbar-expand .navbar-nav .nav-link {
        padding-right: 0.5rem;
        padding-left: 0.5rem;
        padding-bottom:0.1rem
    }

    .navbar-expand .navbar-nav .nav-item {
        text-align:center
    }
  </style> --}}
@include('user_24.head')

</head>


<body class="sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-closed sidebar-collapse">
    <div class="wrapper">

        @include('user_24.navbar')

        <div class="content-wrapper" >
            <div class="row">
                <div class="col-12 col-md-8">
                    <section class="content" style="margin: 0rem 0rem; ">
                        <div class="container-fluid">
                            <fieldset class="card card-body">
                                <legend>Upload hình ảnh</legend>
                                <div class="row">
                                    <div class="col-md-3 col-12">
                                        <div>Hình đại diện</div>
                                        <div>CMND/CCCD</div>
                                    </div>
                                    <div class="col-md-3 col-12"><strong>Học bạ/Bảng điểm:</strong>
                                        <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Trang thông tin cá nhân</div>
                                        <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Trang lớp 10 </div>
                                        <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Trang lớp 11 </div>
                                        <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Trang lớp 12 (hoặc HK1 lớp 12)</div>
                                    </div>
                                    <div class="col-md-3 col-12"><strong>Tốt nghiệp các năm trước:</strong>
                                        <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bằng tốt nghiệp</div>
                                    </div>
                                    <div class="col-md-3 col-12"><strong>Thí sinh trúng tuyển:</strong>
                                        <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Giấy khai sinh:</div>
                                        <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sơ yếu lý lịch:</div>
                                        <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GXN kết quả thi THPT QG:</div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset  class="card card-body">
                                <legend>Thông tin cơ bản</legend>
                                <div class="row">
                                    <div class="col-md-2" style="padding-top:3%">
                                        <div class="row">
                                            <div class="col-md-12" style="text-align:center">
                                                <img class="profile-user-img img-fluid img-square" src = "{{$user->img_gg}}" alt="Ảnh cá nhân"  id="userImg">
                                            </div>
                                            <div class="col-md-12" style="text-align:center">
                                                <span class="id_hsts">ID:</span><span class="id_hsts" id = "mahsxt">{{$mahsxt}}</span>
                                            </div>
                                        </div>

                                        {{-- <form id="form_userImg" enctype="multipart/form-data"> --}}

                                        {{-- </form> --}}
                                        {{-- <div style=" margin-right: 100px; margin-top: -16px;"><i class="fa fa-camera add_school"  style = "font-size: 12pt" id ='attr_userImage' aria-hidden="true"></i></div>
                                        <input type='file' id='open_userImg' name ='open_userImg' style = "display: none"> --}}
                                    </div>
                                    <div class="col-md-10">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="hoten" class="col-sm-4 col-form-label" style="padding-bottom: 0px; font-weight: normal;">Họ và tên:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control thongtincanhan" id="hoten" value = "{{$hoten}}" style="height:30px">
                                                        <sup>
                                                            <p class="float-right validate" id = "v_hoten"></p>
                                                        </sup>
                                                    </div>




                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="birth_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Ngày sinh:</label>
                                                    <div class="col-sm-8">
                                                        <input type="date" class="form-control thongtincanhan" placeholder="01/01/2004" id="ngaysinh" value = "{{$ngaysinh}}" style="height:30px">
                                                        <sup>
                                                            <p class="float-right validate" id = "v_ngaysinh"></p>
                                                        </sup>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">

                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="noisinh" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Nơi sinh Tỉnh:</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control thongtincanhan" type_custom = "select_custom" id="noisinh" style="width: 100%;height:28px">
                                                            <option value="0" >Chọn Tỉnh/Thành phố</option>
                                                            @foreach ( $noisinhs as $noisinh )
                                                                <option value="{{$noisinh->id}}" {{$noisinh->selected}}>{{$noisinh->text}}</option>
                                                            @endforeach


                                                        </select>
                                                        <sup>
                                                            <p class="float-right validate" id = "v_noisinh"></p>
                                                        </sup>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="id_card_users" class="col-sm-4 col-form-label"  style="padding-bottom: 0px">CMND/CCCD:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control thongtincanhan" id='cccd' id="cccd" value = "{{$cccd}}" style="height:30px">
                                                        <sup>
                                                            <p class="float-right validate" id = "v_cccd"></p>
                                                        </sup>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="email_users" class="col-sm-4 col-form-label"  style="padding-bottom: 0px"  >Email:</label>
                                                    <div class="col-sm-8">
                                                    <input type="email" class="form-control" id='email' style="height:30px" value="{{$user->email}}" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="email_phu" class="col-sm-4 col-form-label"  style="padding-bottom: 0px"  >Email 2:</label>
                                                    <div class="col-sm-8">
                                                    <input type="email" class="form-control thongtincanhan" id='email_phu' style="height:30px" value="{{$email_phu}}">
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-6 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="emailsc_user" class="col-sm-4 col-form-label"  style="padding-bottom: 0px"  >Email phụ:</label>
                                                    <div class="col-sm-8">
                                                    <input type="email" class="form-control" id='emailsc_user' style="height:30px">
                                                    </div>
                                                </div>
                                            </div> --}}

                                            <div class="col-md-6 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="phone_users" class="col-sm-4 col-form-label" style="padding-bottom: 0px" >Số điện thoại:</label>

                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control thongtincanhan" id='dienthoai' value = "{{$dienthoai}}" style="height:30px">
                                                        <sup>
                                                            <p class="float-right validate" id = "v_dienthoai"></p>
                                                        </sup>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="phonesc_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px" >Số ĐT phụ huynh:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control thongtincanhan" id='dienthoai_phu' value = "{{$dienthoai_phu}}" style="height:30px">
                                                        <sup>
                                                            <p class="float-right validate" id = "v_dienthoai_phu"></p>
                                                        </sup>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12" style="margin-bottom: -18px">
                                                <div class="form-group row" style="margin-bottom: 3px;">
                                                    <label for="sex_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Giới tính:</label>
                                                    <div class="col-sm-8">
                                                        <div class="input-group  input-group-sm mb-3">
                                                            <div class="input-group-prepend"></div>
                                                            <div class="input-group-prepend">
                                                                    @if ($gioitinh == 0)
                                                                        <input class="" type="radio" id = 'gioitinhnam' name="radio1"  style="margin-top: 2px">
                                                                    @else
                                                                        <input class="" type="radio" id = 'gioitinhnam' name="radio1" checked style="margin-top: 2px">
                                                                    @endif
                                                                <div class="" style="padding-top: 7px;">
                                                                    <span class="" >&nbsp;&nbsp;&nbsp; Nam</span>
                                                                </div>
                                                            </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <div class="input-group-prepend">
                                                                @if ($gioitinh == 0)
                                                                    <input class="" type="radio" id = 'gioitinhnu' name="radio1" checked  style="margin-top: 2px">
                                                                @else
                                                                    <input class="" type="radio" id = 'gioitinhnu' name="radio1"   style="margin-top: 2px">
                                                                @endif
                                                                <div class="" style="padding-top: 7px;">
                                                                    <span class="" >&nbsp;&nbsp;&nbsp; Nữ</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-6 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="nation_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px" >Dân tộc:</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="nation_user" style="width: 100%;height:28px">

                                                        </select>
                                                    </div>
                                                </div>
                                            </div> --}}
                                            {{-- <div class="col-md-6 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px;">
                                                    <label for="graduation_year_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Năm TN:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="graduation_year_user" style="height:30px">
                                                    </div>
                                                </div>
                                            </div> --}}
                                            <div class="col-md-12 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="address_user" class="col-sm-2 col-form-label" style="padding-bottom: 0px">Địa chỉ:</label>
                                                    <div class="col-sm-10">
                                                    <input type="text" class="form-control thongtincanhan"  style="height:30px" id="diachi" value="{{$diachi}}">
                                                    <sup>
                                                        <p class="float-right validate" id = "v_diachi"></p>
                                                    </sup>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-10 col-12">
                                            </div>
                                            <div class="col-md-2 col-12">
                                                {{-- <div class="col-sm-5"> --}}
                                                    <button type="button" id = "luuthongtincanhan" onclick="luuthongtincanhan({{Auth::guard('loginbygoogles')->id()}})" class="btn btn-block btn-primary btn-xs">Lưu</button>
                                                {{-- </div> --}}
                                                {{-- <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="inputEmail3" class="col-sm-4 col-form-label" style="padding-bottom: 0px"></label>

                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="card card-body">
                                <legend>Hộ khẩu thường trú</legend>
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="id_khttprovince_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Tỉnh/TP:</label>
                                            <div class="col-sm-8" >
                                                <select class="province form-control" id = "id_khttprovince_user" style="width: 100%;height:28px" data-select2-id="1" tabindex="-1" aria-hidden="true">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="id_khttprovince_user2" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Huyện/Quận:</label>
                                            <div class="col-sm-8">
                                                <select class="province2 form-control" id = "id_khttprovince_user2" style="width: 100%;height:28px" data-select2-id="1" tabindex="-1" aria-hidden="true">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="id_khttprovince_user3" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Xã/Phường:</label>
                                            <div class="col-sm-8">
                                                <select class="province3 form-control" id = "id_khttprovince_user3" style="width: 100%; height:28px" data-select2-id="1" tabindex="-1" aria-hidden="true">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-12">
                                    </div>
                                    <div class="col-md-10 col-12">
                                        <div class="row">
                                            <div class="col-md-10 col-12">
                                            </div>
                                            <div class="col-md-2 col-12">
                                                <button type="button" id = "add_infoUser" class="btn btn-block btn-primary btn-xs">Lưu</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <p>Text</p> --}}
                            </fieldset>


                        </div><!-- /.container-fluid -->
                    </section>
                </div>
                <div class="col-12 col-md-4" >
                    @include('user_24.content_right')
                </div>
            </div>
        </div>
        @include('user_24.footer')
    </div>


    <script src="/template/admin/plugins/jquery/jquery.min.js"></script>
    <script src="/template/admin/plugins/select2/js/select2.full.min.js"></script>
    <script src="/user_24/js/thongtincanhan.js"></script>
</body>
</html>
