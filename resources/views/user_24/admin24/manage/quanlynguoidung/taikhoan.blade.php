<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('user_24.admin24.include.header')
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
        <div class="content-wrapper" style="min-height: 1302.12px;">
            <section class="content">
                <div class="container-fluid">
                    @include('user_24.admin24.include.contentheader')
                    <div class="row">
                        <div class="col-md-12">
                            <div id="loadpage">
                                <div class="modal" id="id_manhinh_tam"></div>
                                <!--  -->
                                <div class="row">
                                    <div class="col-12 col-md-3 col-lg-3">
                                        <div class="card" style="min-height:600px">
                                            <div>
                                                <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Thêm tài khoản</div>
                                                <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group row" style="margin-bottom: 3px">
                                                            <label for="id_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Email:</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id='account_email' style="height:28px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12 validate_themtaikhoan " id="error_email" style="font-size: 13px; color : red;text-align: right;"></div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group row" style="margin-bottom: 3px">
                                                            <label for="id_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Tên:</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id='account_name' style="height:28px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12 validate_themtaikhoan" id="error_name" style="font-size: 13px; color : red;text-align: right;"></div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group row" style="margin-bottom: 3px">
                                                            <label for="nsx_chucoso" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Mật khẩu:</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id='account_pass' style="height:28px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12 validate_themtaikhoan" id="error_pass" style="font-size: 13px; color : red;text-align: right;"></div>
                                                </div>
                                            </div>
                                            <div class="card-header" style="padding: 0;margin-left: 10px;"></div>
                                            <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                                <div class="row">
                                                    <div class="col-md-6 col-6">
                                                        <button style="background-color: #fff; color:#007bff;" type="button" id="" onclick="Clear_accounts()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                                    </div>
                                                    <div class="col-md-6 col-6">
                                                        <button type="button" id="btt_submit_account" btt_id_add="3" data-id="" onclick="themtaikhoan()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Thêm</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-9 col-lg-9">
                                        <div class="card card-navy" style="min-height:600px">
                                            <div>
                                                <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Danh sách tài khoản</div>
                                                <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" id="list_accounts_tmp">
                                                    <table class="table table-bordered table-hover table-striped dataTable no-footer dtr-inline" id="list_accounts"></table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--  -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @include('user_24.admin24.include.footer')
    </div>
    <div class="modal" id="modal_phan_quyen">
        <div style="vertical-align:middle;background-color: rgba(0,0,0,0.5);height: 100%;">
            <div class="row">
                <div class="col-md-1 col-12"></div>
                <div class="col-md-10 col-12">
                    <div class="card" style="width:90%; height:90%; padding: 2px; background-color:#fff; margin-top: 7%;margin-left: 7%;">
                        <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                            <div class="row">
                                <div class="col-md-11 col-lg-11 col-11">
                                    <span class="">Phân quyền cho người dùng </span>
                                </div>
                                <div class="col-md-1 col-lg-1 col-1">
                                    <span class="float-right" style="margin-right: 10px"><i onclick="modal_close_phan_quyen_user()" id='modal_number_go_wish_start_end_close' class="fas fa-times"></i></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-12">
                                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" id="remove_loadUser_Menus_Roles">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 col-12"></div>
            </div>
        </div>
    </div>
    <div class="modal" id="modal_accounts">
        <div style="vertical-align:middle;background-color: rgba(0,0,0,0.5);height: 100%;">
            <div class="row">
                <div class="col-md-2 col-12">
                </div>
                <div class="col-md-8 col-12">
                    <div class="card card-navy card-outline" style="width:70%; height:auto; padding: 2px; background-color:#fff; margin-top: 20%;margin-left: 20%;">
                        <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                            <div class="row">
                                <div class="col-md-11 col-lg-11 col-11">
                                    <span class="">Cập nhật tài khoản</span>
                                </div>
                                <div class="col-md-1 col-lg-1 col-1">
                                    <span class="float-right" style="margin-right: 10px"><i onclick="modal_close_accounts()" id='modal_number_go_wish_start_end_close' class="fas fa-times"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                            <form id="">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="name" class="col-sm-2 col-form-label" style="padding-bottom: 0px">Tên:</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="update_accounts_name" id='update_accounts_name' value="" class="validate form-control" style="height:28px">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12 validate_taikhoan" id="error_update_accounts_name" style="font-size: 13px; color : red;text-align: right;"></div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="link" class="col-sm-2 col-form-label" style="padding-bottom: 0px">Email:</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="update_accounts_email" id='update_accounts_email' value="" class="form-control validate" style="height:28px">
                                            </div>
                                        </div>
                                    </div>
                                    <!--  -->
                                    <!--  -->
                                    <div class="col-md-12 col-12 validate_taikhoan" id="error_update_accounts_email" style="font-size: 13px; color : red;text-align: right;"></div>
                                    <div class="col-md-12 col-12">
                                        <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                                        <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                </div>
                                                <div class="col-md-2 col-6">
                                                    <button type="button" onclick="update_accounts()" id="Update_button" data-id="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Cập nhật</button>
                                                </div>
                                                <div class="col-md-2 col-6">
                                                    <button style="background-color: #fff; color:#007bff" type="button" onclick="modal_refresh_accounts()" id='Refresh_update_button' data-id="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                                </div>
                                                <div class="col-md-2 col-6">
                                                    <button style="background-color: #fff; color:#007bff" type="button" id='destroyEditMenu' onclick="modal_cancel_accounts()" class="btn btn-block btn-primary btn-xs"><i class="fa-regular fa-circle-xmark"></i>&nbsp;&nbsp;&nbsp;Hủy</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-12">

                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script src="/admin/admin24/js/quanlynguoidung/taikhoan.js"></script>











<script src="/template/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/template/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/jszip/jszip.min.js"></script>
<script src="/template/admin/plugins/pdfmake/pdfmake.min.js"></script>
<script src="/template/admin/plugins/pdfmake/vfs_fonts.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>





