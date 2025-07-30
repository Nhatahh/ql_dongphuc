<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('user_24.admin24.include.header')

    <style>
        .btt_lammoi{
            border-color: #007bff;
            color: #007bff;
       }
       .text_error{
            color: red;
            font-size: 0.8rem;
       }
       #qlsp_thongso{
        resize: vertical;  /* Cho phép thay đổi kích thước cả chiều rộng và chiều cao */
        max-height: 400px; /* Chiều cao tối đa */
        min-height: 200px; /* Chiều cao tối đa */
       }
       .textarea_upd{
        resize: none;
       }
       .edit_tabledata:focus{
            outline: none;
       }
       /* Đặt màu nền của ô input giống với hàng */
        .edit_tabledata {
            background-color: inherit !important;
            border:none;
            width: 100%;
            height: 23px;
        }

        /* Đảm bảo hiệu ứng hover của ô input giống với hàng */
        .edit_tabledata:hover {
            background-color: inherit !important;
        }


    </style>
</head>

<body class="sidebar-mini sidebar-collapse">

    <div class="wrapper">
        <!-- Preloader -->
        {{-- <!-- @include('user_24.admin_24.preloader')  --> --}}
        <!-- /.preloader -->

        <!-- Navbar -->
        @include('user_24.admin24.include.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->

        @include('user_24.admin24.include.sidebar')
        <!-- /.sidebar -->
        {{-- @yield('sidebar1') --}}

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 1302.12px;">
            @include('user_24.admin24.include.contentheader')
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div style="min-height: 590px">
                                <div class="row">
                                    <div class="col-12 col-md-3 col-lg-3">
                                        <div class = "card">
                                            <div class="card-header p-1" style="font-weight: bold;">Thêm Nhà sản xuất</div>
                                            <div class="card-body p-1"  style="min-height: 590px">
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group row col-md-12 col-12" style="margin-bottom: 3px">
                                                        <label for="nhasanxuat_moi" class="col-sm-3 col-form-label" style="padding-bottom: 0px">NSX:</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="nhasanxuat_moi" name="nhasanxuat_moi" style="height:28px;">
                                                            <span class="text_error error_validate" id = 'error_nhasanxuat_moi'></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row col-md-12 col-12" style="margin-bottom: 3px">
                                                        <label for="diachi_moi" class="col-sm-3 col-form-label" style="padding-bottom: 0px">Địa chỉ:</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="diachi_moi" name="diachi_moi" style="height:28px;">
                                                            <span class="text_error error_validate" id = 'error_diachi_moi'></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row col-md-12 col-12" style="margin-bottom: 3px">
                                                        <label for="sdt_moi" class="col-sm-3 col-form-label" style="padding-bottom: 0px">SĐT:</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="sdt_moi" name="sdt_moi" style="height:28px;">
                                                            <span class="text_error error_validate" id = 'error_sdt_moi'></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-12">
                                                    {{-- <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div> --}}
                                                    <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                                        <div class="row">
                                                            <div class="col-md-6 col-6">
                                                                <button type="button" id="" onclick="clear_nhasanxuat_moi()" class="btn btn-block btn-xs btt_lammoi"><i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                                            </div>
                                                            <div class="col-md-6 col-6">
                                                                <button type="button" id="" onclick="themnhasanxuat(event)" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Thêm</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!--  -->
                                    <div class="col-12 col-md-9 col-lg-9 card">
                                        <div class="card-body p-3" style="padding-bottom: 0px;padding-top: 3px" id="ds_nhasanxuat">
                                            <table class="table table-bordered table-hover table-striped dataTable no-footer dtr-inline" id="danhsachnhasanxuat"></table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @include('user_24.modalevent')
        @include('user_24.admin24.include.footer')
    </div>
</body>
<script src="/admin/admin24/js/quanlydongphuc/quanlynhasanxuat.js"></script>
</html>


