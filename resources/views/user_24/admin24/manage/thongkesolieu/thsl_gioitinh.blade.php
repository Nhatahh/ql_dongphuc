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
                                                <label for="thsl_namtuyensinh" class="col-12 col-form-label" style="padding-bottom: 0px ">Năm TS:</label>
                                                <div class="col-12">
                                                    <select  val-def = "0" class="search form-control thsl_search" id="thsl_namtuyensinh" name = 'thsl_namtuyensinh' style="width: 100%;">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="thsl_namtotnghiep" class="col-12 col-form-label" style="padding-bottom: 0px ">Năm tốt nghiệp:</label>
                                                <div class="col-12">
                                                    <select  val-def = "0" class="search form-control thsl_search" id="thsl_namtotnghiep" name = 'thsl_namtotnghiep' style="width: 100%;"></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="thsl_tinh" class="col-12 col-form-label" style="padding-bottom: 0px ">Tỉnh:</label>
                                                <div class="col-12">
                                                    <select  val-def = "0" onchange="thsl_change_tinh()" class="search form-control thsl_search" id="thsl_tinh" name = 'thsl_tinh' style="width: 100%;"></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="thsl_truongthpt" class="col-12 col-form-label" style="padding-bottom: 0px ">Trường THPT:</label>
                                                <div class="col-12">
                                                    <select  val-def = "0" class="search form-control thsl_search" id="thsl_truongthpt" name = 'thsl_truongthpt' style="width: 100%;"></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-9" >
                            <div class="card card-primary card-outline card-outline-tabs block-right">
                                <div class="card-body p-2" style="text-align:center">
                                    <div class="col-12" style="border: 1px solid rgba(0,0,0,.125);height: 300px;" id="thsl_bieudo_bar_load_empty">
                                    </div>
                                    <div style = "font-weight:bold">Phân bố Giới tính theo Đăng ký - Trúng tuyển - Nhập học&nbsp;&nbsp;<i class="fa-regular fa-file-excel"  onclick="thsl_excel()"></i></button></div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body p-2">
                                    <div class="row p-1" style="overflow-x: auto;">
                                        <div class="col-12" style="height: 230px; display: flex; border: 1px solid rgba(0,0,0,.125);" id = "load_bieudo_pie">

                                        </div>
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

<script src="/admin/admin24/js/thongkesolieu/thsl_gioitinh.js"></script>

</html>



