<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('user_24.admin24.include.header')

    <style>
        .selected {
            background-color: #ccc; /* Màu nền cho dòng được chọn */
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
                        <div class="col-12 col-md-12 col-lg-8" style="min-height: 600px;">
                            <div class="card block-left" style="min-height: 600px;">
                                <div class="card-header">
                                    <div class="col-6">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Năm đăng ký:</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="gxn_tiepnhan_sldot" onchange="" style="width: 100%;"></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6"></div>
                                </div>
                                <div class="card-body">    
                                    <table id ="gxn_danhsachdangky" class="table table-hover"></table>
                                </div>   
                                <div class="card-footer">
                                    <div class="row" style="margin-bottom: 10px">
                                        <div class="col-md-6"></div>
                                        <div class="col-12 col-md-6">
                                            <div class="row">
                                                <div class="col-6"><button type="button" time="" id="thongke" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa fa-pie-chart" aria-hidden="true"></i>&nbsp;&nbsp;Thống kê</button></div>
                                                <div class="col-6"><button type="button" time="" id="btt_excel_danhmuc" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-user-check"></i>&nbsp;&nbsp;Excel</button> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-4">
                            <div class="card block-right" style="min-height: 600px;">
                                <div class="card-header">
                                </div>
                                <div class="card-body">
                                    <div id="pdfViewerContainer" style="width: 100%; height: 500px;">
                                        <iframe id="pdfViewer" style="width: 100%; height: 100%;" frameborder="0"></iframe>
                                    </div>
                                    
                                    
                                </div>
                                <div class="card-footer">
                                    <div class="row" style="margin-bottom: 10px">
                                        <div class="col-12 d-flex justify-content-between">
                                                <div class="col-6">
                                                    <button type="button" id="btn-approve" class="btn btn-block btn-primary btn-xs">
                                                        <i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;&nbsp;Duyệt
                                                    </button>
                                                </div>
                                                <div class="col-6">
                                                    <button type="button" id="btn-reject" class="btn btn-block btn-primary btn-xs">
                                                        <i class="fa fa-times-circle"></i>&nbsp;&nbsp;Không duyệt
                                                    </button>
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
        @include('user_24.admin24.include.footer')
    </div>
</body>
</html>
<script src="/admin/admin24/js/quanlynguoidung/taikhoan.js"></script>
<script src="/admin/admin24/js/quanlygiayxacnhan/gxn_tiepnhan.js"></script>
<script>
    // equalizeHeight();
</script>


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





