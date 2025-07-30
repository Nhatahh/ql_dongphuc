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
        resize: none;  /* Cho phép thay đổi kích thước cả chiều rộng và chiều cao */

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
        {{-- @include('user_24.admin24.include.preloader') --}}
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
                            <div class="">
                                <div class="row">
                                    <div class="col-12 col-md-3 col-lg-3 ">
                                        <div class="card block-left">
                                            <div class="card-header p-1" style="padding: 0;margin-left: 10px;font-weight: bold;">Thêm Sản phẩm</div>
                                            <div class="card-body p-3 ">
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group row " style="margin-bottom: 8px">
                                                            <label for="ds_loaisanpham" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Loại SP:</label>
                                                            <div class="col-sm-8 load-index">
                                                                <select class="form-control " id="qlsp_ds_loai" style="width: 100%;">
                                                                </select>
                                                                <span class="text_error error_validate" id = 'error_id_loai'></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group row" style="margin-bottom: 8px">
                                                            <label for="ds_nhasanxuat" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Nhà SX:</label>
                                                            <div class="col-sm-8 load-index">
                                                                <select class="form-control" id="qlsp_ds_nhasanxuat" style="width: 100%;">
                                                                </select>
                                                                <span class="text_error error_validate" id = 'error_id_nhasanxuat'></span>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group row" style="margin-bottom: 8px">
                                                            <label for="ds_size" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Size:</label>
                                                            <div class="col-sm-8 load-index">
                                                                <select class="form-control" id="qlsp_ds_size" style="width: 100%;">


                                                                </select>
                                                                <span class="text_error error_validate" id = 'error_id_size'></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group row" style="margin-bottom: 8px">
                                                            <label for="sl_sanphamnhap" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Thông số</label>
                                                            <div class="col-sm-8 load-index">
                                                                <textarea rows = "10" class="form-control" name="qlsp_thongso" id="qlsp_thongso"></textarea>
                                                                <span class="text_error error_validate" id = 'error_thongso'></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="card-body" style="padding-top: 8px; padding-bottom:0px">
                                                            <div class="row">
                                                                <div class="col-md-6 col-6">
                                                                    <button type="button" id="" onclick="clear_nhapsanpham()" class="btn btn-block btn-xs btt_lammoi load-index"><i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                                                </div>
                                                                <div class="col-md-6 col-6">
                                                                    <button type="button" id="" onclick="btt_themsanpham(event)" class="btn btn-block btn-primary btn-xs load-index"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Thêm</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <!--  -->
                                    <div class="col-12 col-md-9 col-lg-9">
                                        <div class="card p-4 block-right">
                                            <div class="card-body load-index" id="dssanpham_dot">
                                                <table class="table table-bordered table-hover table-striped dataTable no-footer dtr-inline" id="qlspdssanpham"></table>
                                            </div>
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
<script src="/admin/admin24/js/quanlydongphuc/quanlysanpham.js"></script>
</html>


