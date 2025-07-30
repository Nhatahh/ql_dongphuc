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
                        <div class="col-12 col-lg-3">
                            <form action="" id="gxn_danhmucForm">
                                <div class="card block-right" style="min-height: 600px;">
                                    <div class="card-header">
                                            Chi tiết giấy xác nhận
                                    </div>
                                    <div class="card-body">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group row">
                                                <label for="id_user_check" class="col-sm-12 col-form-label" style="padding-bottom: 0px">Tên loại giấy:</label>
                                                <div class="col-sm-12">
                                                    <input  type="text" class="form-control search" id="tenLoaiGiayInput" style="height:28px;">
                                                    <span class="err_del" id="err_tenLoaiGiayInput" style="position: absolute; top: 12px; right: 22px; color:red;font-size:x-small;font-weight:bold; background-color:#fff"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group row" style="margin-bottom: 3px">
                                                <label for="" class="col-sm-12 col-form-label" style="padding-bottom: 0px">Đơn vị:</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control" id="donViInput" onchange="" style="width: 100%;"></select>
                                                    <span  class="err_del" id="err_donViInput" style="position: absolute; top: 12px; right: 25px; color:red;font-size:x-small;font-weight:bold"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12 mt-2">
                                            <div class="form-group row" style="margin-bottom: 3px">
                                                <label for="id_user_check" class="col-sm-12 col-form-label" style="padding-bottom: 0px">Ghi chú:</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control search" id="ghiChuInput" style="height:28px;">
                                                    <span class="err_del" id="err_ghiChuInput" style="position: absolute; top: 12px; right: 22px; color:red;font-size:x-small;font-weight:bold; background-color:#fff"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6 col-6">
                                                <button type="button" id="btn-resetForm" onclick="btn_resetForm()" class="btn btn-block btn-primary btn-xs" style="background-color: #fff; color: #007bff"><i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                            </div>
                                            <div class="col-md-6 col-6">
                                                <button type="button" id="btn_addForm" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-upload"></i>&nbsp;&nbsp;&nbsp;Thêm</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer" style="padding-top: 3px; padding-bottom:0px">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-12 col-lg-9">
                            <div class="card block-left" style="min-height: 600px;">
                                <div class="card-header">
                                        Danh sách giấy xác nhận
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-hover table-striped" style="width: 100%" id="gxn_danhsachgiay">
                                    </table>
                                </div>
                                <!-- Modal -->
                                <div class="modal" id="gxn_update_modal">
                                    <div style="vertical-align:middle;background-color: rgba(0,0,0,0.5);height: 100%;">
                                        <div class="row">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Cập nhật thông tin giấy xác nhận</h5>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <!-- Modal Body -->
                                                    <div class="modal-body">
                                                        <form action="" id="Form_Modal">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="col-md-12 col-12">
                                                                        <div class="form-group row">
                                                                            <label for="tenLoaiGiayInput_modal" class="col-sm-12 col-form-label" style="padding-bottom: 0px">Tên loại giấy:</label>
                                                                            <div class="col-sm-12">
                                                                                <input  type="text" class="form-control search" id="tenLoaiGiayInput_modal" style="height:28px;">
                                                                                <span class="err_del" id="err_tenLoaiGiayInput_modal" style="position: absolute; top: 12px; right: 22px; color:red;font-size:x-small;font-weight:bold"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 col-12">
                                                                        <div class="form-group row" style="margin-bottom: 3px">
                                                                            <label for="donViInput_modal" class="col-sm-12 col-form-label" style="padding-bottom: 0px">Đơn vị:</label>
                                                                            <div class="col-sm-12">
                                                                                <select class="form-control" id="donViInput_modal" onchange="" style="width: 100%;"></select>
                                                                                <span class="err_del" id="err_donViInput_modal" style="position: absolute; top: 12px; right: 25px; color:red;font-size:x-small;font-weight:bold"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 col-12 mt-2">
                                                                        <div class="form-group row" style="margin-bottom: 3px">
                                                                            <label for="ghiChuInput_modal" class="col-sm-12 col-form-label" style="padding-bottom: 0px">Ghi chú:</label>
                                                                            <div class="col-sm-12">
                                                                                <input type="text" class="form-control search" id="ghiChuInput_modal" style="height:28px;">
                                                                                <span class="err_del" id="err_ghiChuInput_modal" style="position: absolute; top: 12px; right: 22px; color:red;font-size:x-small;font-weight:bold"></span>
                                                                            </div>
                                                                        </div>
                                                                        <span class="err_del" id="err_idGiayInput_modal" style="position: absolute; top: 12px; right: 22px; color:red;font-size:x-small;font-weight:bold"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="card-header mt-3" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                                                                <div class="card-body mb-3" style="padding-top: 3px; padding-bottom:0px">
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-6 col-6">
                                                                            <button type="button" id="btn_resetModal" onclick="btn_resetModal()" class="btn btn-block btn-primary btn-xs" style="background-color: #fff; color: #007bff"><i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                                                        </div>
                                                                        <div class="col-md-6 col-6">
                                                                            <button type="button" id="btn_updateModal" data-id="" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-upload"></i>&nbsp;&nbsp;&nbsp;Cập nhật</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
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
</html>
<script src="/admin/admin24/js/quanlynguoidung/taikhoan.js"></script>
<script src="/admin/admin24/js/quanlygiayxacnhan/gxn_danhmuc.js"></script>

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



