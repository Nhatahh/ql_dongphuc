<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- DataTables -->
<link rel="stylesheet" href="/admin/admin_24/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/admin/admin_24/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="/admin/admin_24/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<script src="/admin/admin_24/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/admin/admin_24/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/admin/admin_24/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/admin/admin_24/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/admin/admin_24/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/admin/admin_24/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="/admin/admin_24/plugins/jszip/jszip.min.js"></script>
<script src="/admin/admin_24/plugins/pdfmake/pdfmake.min.js"></script>
<script src="/admin/admin_24/plugins/pdfmake/vfs_fonts.js"></script>
<script src="/admin/admin_24/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/admin/admin_24/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/admin/admin_24/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });


</script>

    @include('user_24.admin24.include.header')
    <link rel="stylesheet" href="/admin/admin_24/plugins/summernote/summernote.min.css">
    <style>


        /* div.dataTables_scrollHead table.dataTable{
            margin-bottom: -11px !important;
        } */

        .table td, .table th {
            text-align: center;
            vertical-align: middle;
        }

        .info{
            margin-bottom: 10px
        }
        .dangky{
            padding-top: 8px;
            border-top: 1px solid rgba(0, 0, 0, .125)
        }


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
                                        <div class="card card-navy card-outline" style="min-height:600px">
                                            <div>
                                                <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Thêm đợt xét tuyển</div>
                                                <div class="card-body" style="padding-top: 3px; padding-bottom:0px">


                                                    <div class="col-md-12 col-12 validate_themtaikhoan " id="error_email" style="font-size: 13px; color : red;text-align: right;"></div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group row" style="margin-bottom: 3px">
                                                            <label for="id_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Mã đợt:</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id='iddotxt' style="height:28px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12 validate_themtaikhoan " id="error_email" style="font-size: 13px; color : red;text-align: right;"></div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group row" style="margin-bottom: 3px">
                                                            <label for="id_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Tên đợt:</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id='tendotxettuyen' style="height:28px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group row" style="margin-bottom: 3px">
                                                            <label for="id_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Đợt TS:</label>
                                                            <div class="col-sm-8">
                                                                <!-- <input type="text" class="form-control" id='iddotts' style="height:28px;"> -->
                                                                <select class="form-control" id="iddotts" style="width: 100%;"> </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12 validate_themtaikhoan" id="error_name" style="font-size: 13px; color : red;text-align: right;"></div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group row" style="margin-bottom: 3px">
                                                            <label for="id_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Mã quy trình:</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id='id_quytrinhcongbo' style="height:28px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12 validate_themtaikhoan " id="error_email" style="font-size: 13px; color : red;text-align: right;"></div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group row" style="margin-bottom: 3px">
                                                            <label for="nsx_chucoso" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Ghi chú:</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id='ghichu_quytrinh' style="height:28px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12 validate_themtaikhoan" id="error_pass" style="font-size: 13px; color : red;text-align: right;"></div>
                                                    <!-- <div class="col-md-12 col-12">
                                                        <div class="form-group row" style="margin-bottom: 3px">
                                                            <label for="nsx_chucoso" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Khóa đợt:</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id='khoadot' style="height:28px;">
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <div class="col-md-12 col-12 validate_themtaikhoan" id="error_pass" style="font-size: 13px; color : red;text-align: right;"></div>
                                                </div>
                                            </div>
                                            <div class="card-header" style="padding: 0;margin-left: 10px;"></div>
                                            <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                                <div class="row">
                                                    <div class="col-md-6 col-6">
                                                        <button style="background-color: #fff; color:#007bff;" type="button" id="" onclick="refresh_dotxettuyen()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                                    </div>
                                                    <div class="col-md-6 col-6">
                                                        <button type="button" id="btt_submit_account" btt_id_add="3" data-id="" onclick="them_dotxettuyen()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Thêm</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-9 col-lg-9">
                                        <div class="card card-navy" style="min-height:600px">
                                            <div>
                                                <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Danh sách đợt xét tuyển</div>
                                                <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" id="list_accounts_tmp">
                                                        <table id="bang_ds_dotxettuyen" class="table table-bordered table-striped">



                                                        </table>

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
        {{-- @include('user_24.admin_24.footer') --}}

    </div>


    <div class="modal" id="modal_sua_dxt">
        <div style="vertical-align:middle;background-color: rgba(0,0,0,0.5);height: 100%;">
            <div class="row">
                <div class="col-md-2 col-12">
                </div>
                <div class="col-md-8 col-12">
                    <div class="card card-navy card-outline" style="width:70%; height:auto; padding: 2px; background-color:#fff; margin-top: 20%;margin-left: 20%;">
                        <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                            <div class="row">
                                <div class="col-md-11 col-lg-11 col-11">
                                    <span class="">Cập nhật đợt xét tuyển</span>
                                </div>
                                <div class="col-md-1 col-lg-1 col-1">
                                    <span class="float-right" style="margin-right: 10px"><i onclick="close_modal_sua_dxt()" id='modal_number_go_wish_start_end_close' class="fas fa-times"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                            <form id="">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="name" class="col-sm-2 col-form-label" style="padding-bottom: 0px">ID đợt tuyển sinh:</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id='edit_iddotts' style="width: 100%;"></select>
                                                <!-- <input type="text" name="update_accounts_name" id='edit_iddotts' value="" class="validate form-control" style="height:28px"> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="name" class="col-sm-2 col-form-label" style="padding-bottom: 0px">Id đợt xét tuyển:</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="update_accounts_name" id='edit_iddotxt' value="" class="validate form-control" style="height:28px">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="name" class="col-sm-2 col-form-label" style="padding-bottom: 0px">Tên đợt xét tuyển:</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="update_accounts_name" id='edit_tendotxettuyen' value="" class="validate form-control" style="height:28px">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="name" class="col-sm-2 col-form-label" style="padding-bottom: 0px">Id quy trình công bố:</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="update_accounts_name" id='edit_id_quytrinhcongbo' value="" class="validate form-control" style="height:28px">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12 validate_taikhoan" id="error_update_accounts_name" style="font-size: 13px; color : red;text-align: right;"></div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="link" class="col-sm-2 col-form-label" style="padding-bottom: 0px">Ghi chú quy trình:</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="update_accounts_email" id='edit_ghichu_quytrinh' value="" class="form-control validate" style="height:28px">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Checkbox Trạng thái và Khóa đợt nằm ngang nhau -->
                                    <!-- <div class="col-md-12 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px; align-items: center;">
                                            <label class="col-sm-2 col-form-label" style="padding-bottom: 0px;">Trạng thái:</label>
                                            <div class="col-sm-10">
                                                <input id="edit_trangthai" type="checkbox" style="height: 28px; vertical-align: middle;">
                                            </div>
                                        </div>
                                    </div> -->

                                    <div class="col-md-12 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px; align-items: center;">
                                            <label class="col-sm-2 col-form-label" style="padding-bottom: 0px;">Khóa đợt:</label>
                                            <div class="col-sm-10">
                                                <input id="edit_khoadot" type="checkbox" style="height: 28px; vertical-align: middle;">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-12 col-12 validate_taikhoan" id="error_update_accounts_email" style="font-size: 13px; color : red;text-align: right;"></div>
                                    <div class="col-md-12 col-12">
                                        <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                                        <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                </div>
                                                <div class="col-md-2 col-6">
                                                    <button type="button"  id="update_dotxettuyen_button" data-id="" onclick="update_dotxettuyen()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Cập nhật</button>
                                                </div>
                                                <div class="col-md-2 col-6">
                                                    <button style="background-color: #fff; color:#007bff" type="button" onclick="refresh_modal_sua_dxt()" id='Refresh_update_button' data-id="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                                </div>
                                                <div class="col-md-2 col-6">
                                                    <button style="background-color: #fff; color:#007bff" type="button" id='destroyEditMenu' onclick="close_modal_sua_dxt()" class="btn btn-block btn-primary btn-xs"><i class="fa-regular fa-circle-xmark"></i>&nbsp;&nbsp;&nbsp;Hủy</button>
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

    @include('user_24.modalevent')
</body>
<script src="/admin/admin24/js/dottuyensinh/dotxettuyen.js"></script>
</html>
