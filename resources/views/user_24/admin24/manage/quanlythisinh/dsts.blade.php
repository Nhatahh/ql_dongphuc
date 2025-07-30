<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('user_24.admin24.include.header')
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/2.1.2/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/5.0.1/css/fixedColumns.dataTables.css"> -->
    <style>
        .card-footer{
            background-color: #fff;
        }
        th, td {
            white-space: nowrap;

        }

        .text-center{
            text-align: center;

        }

        .border-right{
            border-right:1px solid rgba(0, 0, 0, 0.15)
        }


        table.dataTable > tbody > tr > th, table.dataTable > tbody > tr > td {
            padding: 0px 4px;
        }
        table.dataTable > thead > tr > th, table.dataTable > thead > tr > td{
            padding: 0px 4px;
        }

        table.dataTable>thead>tr>th:not(.sorting_disabled), table.dataTable>thead>tr>td:not(.sorting_disabled){
            padding:0px 4px;
        }

        div.dataTables_wrapper {
            /* width: 400px; */
            margin: 0 auto;
        }


        /* .equal-height {
            display: flex;
        }

        .equal-height .card {
            flex: 1;
        }
 */





    </style>
</head>

<body class="sidebar-mini sidebar-collapse">

    <div class="wrapper">
        <!-- Preloader -->

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
                        <div class="col-3" >
                            <div class="card card-primary card-outline card-outline-tabs block-left">
                                <div class="card-header p-1">
                                    Điều kiện tìm kiếm
                                </div>
                                <div class="card-body p-1" >
                                    <div class="row">
                                        {{-- <div class="col-12 col-md-4 col-lg-3 p-0 block-left load-index" > --}}
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="dsts_namtuyensinh" class="col-12 col-form-label" style="padding-bottom: 0px ">Năm TS:</label>
                                                <div class="col-12">
                                                    <select  val-def = "0" class="search form-control" id="dsts_namtuyensinh" name = 'dsts_namtuyensinh' style="width: 100%;">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="dsts_dottuyensinh" class="col-12 col-form-label" style="padding-bottom: 0px ">Đợt TS:</label>
                                                <div class="col-12">
                                                    <select  val-def = "0" class="search form-control" id="dsts_dottuyensinh" name = 'dsts_dottuyensinh' style="width: 100%;">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="dsts_namtotnghiep" class="col-12 col-form-label" style="padding-bottom: 0px ">Năm tốt nghiệp:</label>
                                                <div class="col-12">
                                                    <select  val-def = "0" class="search form-control" id="dsts_namtotnghiep" name = 'dsts_namtotnghiep' style="width: 100%;"></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="dsts_tinh" class="col-12 col-form-label" style="padding-bottom: 0px ">Tỉnh:</label>
                                                <div class="col-12">
                                                    <select  val-def = "0" onchange="dsts_change_tinh()" class="search form-control" id="dsts_tinh" name = 'dsts_tinh' style="width: 100%;"></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="dsts_truongthpt" class="col-12 col-form-label" style="padding-bottom: 0px ">Trường THPT:</label>
                                                <div class="col-12">
                                                    <select  val-def = "0" class="search form-control" id="dsts_truongthpt" name = 'dsts_truongthpt' style="width: 100%;"></select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="dsts_gioitinh" class="col-12 col-form-label" style="padding-bottom: 0px ">Giới tính:</label>
                                                <div class="col-12">
                                                    <select  val-def = "0" class="search form-control" id="dsts_gioitinh" name = 'dsts_gioitinh' style="width: 100%;"></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="dsts_ngaydangky1" class="col-12 col-form-label" style="padding-bottom: 0px ">Đăng ký từ:</label>
                                                <div class="col-12">
                                                    <input type="date"  val-def = "" class="search form-control ttsv_info" id="dsts_ngaydangky1" name = "dsts_ngaydangky1"  style="height:28px; width:100%"  value="">
                                                </div>
                                            </div>
                                            <span style="font-size: x-small;color:red;position: absolute;top: 40px; right: 20px;" class="float-right" id="error_dsts_ngaydangky1"></span>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="dsts_ngaydangky2" class="col-12 col-form-label" style="padding-bottom: 0px ">Đến ngày:</label>
                                                <div class="col-12">
                                                    <input type="date"  val-def = "" class="search form-control ttsv_info" id="dsts_ngaydangky2" name = "dsts_ngaydangky2"  style="height:28px; width:100%"  value="">
                                                </div>
                                            </div>
                                            <span style="font-size: x-small;color:red;position: absolute;top: 40px; right: 20px;" class="float-right" id="error_dsts_ngaydangky2"></span>
                                        </div>
                                        {{-- <div class="col-12">
                                            <div class="form-group" style="position: relative;">
                                                <label for="dsts_idts" class="col-12 col-form-label" style="padding-bottom: 0px ">ID thí sinh:</label>
                                                <div class="col-12">
                                                    <input type="text" val-def = "" class="search form-control ttsv_info" id="dsts_idts" name = "dsts_idts" style="height:28px; width:100%"  value="">
                                                </div>
                                            </div>
                                            <span style="font-size: x-small;color:red;position: absolute;top: 40px; right: 20px;" class="float-right" id="error_dsts_idts"></span>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="dsts_cccd" class="col-12 col-form-label" style="padding-bottom: 0px ">Căn cước công dân:</label>
                                                <div class="col-12">
                                                    <input type="text"  val-def = "" class="search form-control ttsv_info" id="dsts_cccd" name = "dsts_cccd"  style="height:28px; width:100%"  value="">
                                                </div>
                                            </div>
                                            <span style="font-size: x-small;color:red;position: absolute;top: 40px; right: 20px;" class="float-right" id="error_dsts_cccd"></span>
                                        </div> --}}
                                        {{-- </div> --}}
                                    </div>
                                </div>
                                <div class="card-footer">
                                        <div class="row">
                                            <div class="col-12" style = "border-top:1px solid rgba(0,0,0,.125);margin: 5px;">
                                            </div>
                                            <div class="col-6">
                                                <button type="button" id="dsts_lammoi" onclick="dsts_lammoi()" class="load-index btn btn-block btn-default  btn-xs"><i class="fa-solid fa-arrow-rotate-left"></i>&nbsp;&nbsp;Làm mới</button>
                                            </div>
                                            <div class="col-6">
                                                <button type="button" id="dsts_timkiem" onclick="dsts_timkiem()" class="load-index btn btn-block btn-primary btn-xs"><i class="fa-solid fa-search"></i>&nbsp;&nbsp;Tìm kiếm</button>
                                            </div>
                                        </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-9" >
                            <div class="card card-primary card-outline card-outline-tabs block-right" style="min-height:550px">
                                <div class="card-header p-1">
                                    <div class="row">
                                        Danh sách thí sinh
                                    </div>
                                </div>
                                <div class="card-body p-2">
                                    <div class="row">
                                        <div class="col-12 load-index">
                                            <table id = "dsts_loadds" class="table table-hover table-striped table-bordered">
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-1">
                                        </div>
                                        <div class="col-11">
                                            <div class="style_all_button">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="row">
                                                            <div class="col-4">
                                                                {{-- <button type="button" id="themdotxettuyen_popup" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;Thêm đợt</button> --}}
                                                            </div>
                                                            <div class="col-4">
                                                                {{-- <button type="button" id="laydulieutheodot" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;Thêm đợt</button> --}}
                                                            </div>
                                                            <div class="col-4">
                                                                {{-- <button type="button" id="laydulieutheodot" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-chart-area"></i>&nbsp;&nbsp;Thống kê</button> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="row">
                                                            <div class="col-4">
                                                                {{-- <button type="button" id="trungtuyenchinhthucdotts" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;Lưu KQ</button> --}}

                                                                {{-- <button type="button" id="danhsach_thisinh_locao" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-regular fa-file-excel"></i>&nbsp;&nbsp;Danh sách</button> --}}
                                                            </div>
                                                            <div class="col-4">
                                                                {{-- <button type="button" id="xuatdanhsachlocao" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-regular fa-file-excel"></i>&nbsp;&nbsp;DS Lọc ảo</button> --}}
                                                            </div>
                                                            <div class="col-4">
                                                                {{-- <button type="button" id="thongkeketqualocao" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-chart-area"></i>&nbsp;&nbsp;Thống kê</button> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="row">
                                                            <div class="col-4">
                                                                {{-- <button disabled type="button" id="importketquanhom" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-users-viewfinder"></i>&nbsp;&nbsp;KQ Nhóm</button> --}}
                                                            </div>

                                                            <div class="col-4">
                                                                {{-- <button disabled type="button" id="importketquabo" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-users-viewfinder"></i>&nbsp;&nbsp;KQ Bộ</button> --}}
                                                            </div>

                                                            <div class="col-4">
                                                                <button type="button" id="dsts_excel" onclick="dsts_excel()" class="btn btn-block btn-primary btn-xs"><i class="fa-regular fa-file-excel"></i>&nbsp;&nbsp;Danh sách</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="col-3"></div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('user_24.admin24.include.preloader')
            </section>
        </div>
        @include('user_24.admin24.include.footer')
    </div>
    @include('user_24.modalevent')
</body>

<script src="/admin/admin24/js/quanlythisinh/dsts.js"></script>


</html>



