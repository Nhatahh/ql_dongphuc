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
        }

        /* Đảm bảo hiệu ứng hover của ô input giống với hàng */
        .edit_tabledata:hover {
            background-color: inherit !important;
        }
        .text_error_input{
            /* color: red;
            font-size: 0.8rem; */
            position: absolute; 
            /* bottom: 0px;  */
            right: 11px; 
            font-size: 8px; 
            color: red;
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
                            <div class="" style="min-height: 590px">
                                <div class="row">
                                    <div class="col-12 col-md-3 col-lg-3">
                                        <div class="card" style="min-height: 590px">
                                            <div class="card-header p-0" style="padding: 0;margin-left: 10px;font-weight: bold;">Thêm Size</div>
                                            <div class="card-body" style="padding: 10px 0 0 0;">
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group row col-md-12 col-12" style="margin-bottom: 12px">
                                                            <label for="sizemoi" class="col-sm-3 col-form-label" style="padding-bottom: 0px">Size mới:</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" id="sizemoi" name="sizemoi" style="height:28px;">
                                                                <span class="text_error_input error_validate" id = 'error-sizemoi'></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row col-md-12 col-12" style="margin-bottom: 12px">
                                                            <label for="masize" class="col-sm-3 col-form-label" style="padding-bottom: 0px">Mã size:</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" id="masize" name="masize" style="height:28px;">
                                                                <span class="text_error_input error_validate" id = 'error-masize'></span>
                                                            </div>
                                                        
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                                            <div class="row">
                                                                <div class="col-md-6 col-6">
                                                                    <button type="button" id="" onclick="clear_form_size()" class="btn btn-block btn-xs btt_lammoi"><i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                                                </div>
                                                                <div class="col-md-6 col-6">
                                                                    <button type="button" id="" onclick="themsize(event)" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Thêm</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--  -->
                                    <div class="ccol-12 col-md-9 col-lg-9 card p-3">
                                        <div class="" style="padding-bottom: 0px;padding-top: 3px" id="ds_size">
                                            <table class="table table-bordered table-hover table-striped dataTable no-footer dtr-inline" id="danhsachsize"></table>
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
<script src="/admin/admin24/js/quanlydongphuc/quanlysize.js"></script>
</html>


