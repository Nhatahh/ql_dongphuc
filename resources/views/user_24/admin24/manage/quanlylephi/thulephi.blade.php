<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('user_24.admin24.include.header')
    <link rel="stylesheet" href="/admin/admin_24/plugins/summernote/summernote.min.css">
    <style>


        /* div.dataTables_scrollHead table.dataTable{
            margin-bottom: -11px !important;
        } */
    </style>

</head>

<body class="sidebar-mini sidebar-collapse">
    <div class="wrapper">
        <!-- Preloader -->
        <!-- @include('user_24.admin24.include.preloader')  -->
        <!-- /.preloader -->

        <!-- Navbar -->
        @include('user_24.admin24.include.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->

        @include('user_24.admin24.include.sidebar')
        <!-- /.sidebar -->
        {{-- @yield('sidebar1') --}}

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    @include('user_24.admin24.include.contentheader')
                    <div class="card" style="">
                        <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">
                            <div class="row"style =  "margin-top: 5px;">
                                <div class="col-md-2 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="id_taikhoandong" class="col-sm-2 col-form-label" style="padding-bottom: 0px">ID:</label>
                                        <div class="col-sm-10">
                                            <input  style="height: 28px" type="text" class="form-control" id="id_taikhoandong" style="height:28px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="sotien" class="col-sm-3 col-form-label" style="padding-bottom: 0px">Số tiền:</label>
                                        <div class="col-sm-9">
                                            <input  style="height: 28px" type="text" class="form-control " id="sotien" style="height:28px;">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="sotien" class="col-sm-3 col-form-label" style="padding-bottom: 0px">Hình thức:</label>
                                        <div class="col-sm-9">
                                            <select style="width: 100%; height: 28px" id="hinhthucthanhtoan">
                                                <option value="0">Chọn hình thức TT</option>
                                                <option selected value="1">Chuyển khoản</option>
                                                <option value="2">Tiền mặt</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-1 col-12">
                                    <button type="button" id="btt_thanhtoan" onclick="thanhtoan(3)"  class="btn btn-block btn-primary btn-xs"><i class="fa-regular fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Thanh toán</button>
                                </div>
                                <div class="col-md-1 col-12">
                                    <button type="button" id=""  class="btn btn-block btn-primary btn-xs"><i class="fa-regular fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp; Excel</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="padding: 5 0; height:520px;">

                        <div class="row">

                                {{--  --}}
                                <div  class="col-md-4 col-5">
                                    {{-- <fieldset class="card card-body"> --}}
                                        {{-- <legend style="font-size: 0.9rem">Thông tin sinh viên</legend> --}}
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group row" style="margin-bottom: 3px">
                                                            <label for="hoten" class="col-sm-3 col-form-label" style="padding-bottom: 0px;">Họ và tên:</label>
                                                            <div class="col-sm-9">
                                                                <input  disabled type="text" class="form-control" id="hoten" value="" style="height:28px;background-color: inherit;border:none">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group row" style="margin-bottom: 3px">
                                                            <label for="birth_user" class="col-sm-3 col-form-label" style="padding-bottom: 0px;">Ngày sinh:</label>
                                                            <div class="col-sm-9">
                                                                <input disabled type="text" class="form-control" placeholder="" id="ngaysinh" value="" style="height:30px;background-color: inherit;border:none">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group row" style="margin-bottom: 3px">
                                                            <label for="id_card_users" class="col-sm-3 col-form-label" style="padding-bottom: 0px;">CMND/CCCD:</label>
                                                            <div class="col-sm-9">
                                                                <input disabled type="text" class="form-control" id="cccd" value="" style="height:30px;background-color: inherit;border:none">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group row" style="margin-bottom: 3px">
                                                            <label for="email_users" class="col-sm-3 col-form-label" style="padding-bottom: 0px;">Email:</label>
                                                            <div class="col-sm-9">
                                                                <input disabled type="email" class="form-control" id="email" style="height:30px;background-color: inherit;border:none" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group row" style="margin-bottom: 3px">
                                                            <label for="phone_users" class="col-sm-3 col-form-label" style="padding-bottom: 0px;">Số điện thoại:</label>
                                                            <div class="col-sm-9">
                                                                <input disabled type="text" class="form-control" id="dienthoai" value="" style="height:30px;background-color: inherit;border:none">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group row" style="margin-bottom: 3px">
                                                            <label for="address_user" class="col-sm-3 col-form-label" style="padding-bottom: 0px;">Địa chỉ:</label>
                                                            <div class="col-sm-9">
                                                            <input disabled type="text" class="form-control" style="height:30px; background-color: inherit;border:none" id="diachi" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    {{-- </fieldset> --}}
                                </div>

                                <div class="col-md-8 col-12 ">
                                    <fieldset style="height: 450px" class="card card-body">
                                        {{-- <legend style="font-size: 0.9rem">Hóa đơn</legend> --}}
                                        <div class="row">
                                            <div class="col-12 col-md-12 col-lg-12">
                                                <div class="col-12 col-md-12 col-lg-12 card-body"
                                                    style="padding: 0px;padding-top: 3px;"
                                                    id="">
                                                    <div style="width: 100%;" id="ds_hoadon">
                                                        <table class="table table-bordered table-hover table-striped dataTable no-footer dtr-inline" id="tb_hoadon"></table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>




                            </div>
                        </div>
                    </div>
                </div>
            </section>
            @include('user_24.modalevent')
        </div>
        {{-- @include('user_24.admin_24.footer') --}}
        @include('user_24.admin24.include.footer')
    </div>




</body>
<script src="/admin/admin24/js/quanlylephi/thulephi.js"></script>

<!-- summernote -->
{{-- <script src="/admin/admin_24/plugins/summernote/summernote.min.js"></script> --}}

</html>
