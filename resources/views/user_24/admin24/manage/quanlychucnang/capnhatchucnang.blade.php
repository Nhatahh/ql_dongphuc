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
                        <div class="col-12 col-sm-3 col-lg-3">
                            <div class="card" style="min-height:540px">
                                <div>
                                    <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Thêm chức năng</div>
                                    <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group row" style="margin-bottom: 3px">
                                                <label for="id_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px">ID CN:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="tcn_id_chucnang" style="height:28px;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12 validate_themchucnang " id="error_chucnang" style="font-size: 13px; color : red;text-align: right;"></div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group row" style="margin-bottom: 3px">
                                                <label for="id_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Tên CN:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="tcn_ten_chucnang" style="height:28px;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12 validate_themchucnang" id="error_ten_chucnang" style="font-size: 13px; color : red;text-align: right;"></div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group row" style="margin-bottom: 3px">
                                                <label for="nsx_chucoso" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Ghi chú:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="tcn_ghichu" style="height:28px;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12 validate_themchucnang" id="error_ghichu" style="font-size: 13px; color : red;text-align: right;"></div>
                                    </div>
                                </div>
                                <div class="card-header" style="padding: 0;margin-left: 10px;"></div>
                                <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                    <div class="row">
                                        <div class="col-md-6 col-6">
                                            <button style="background-color: #fff; color:#007bff;" type="button" id="tcn_reset" onclick="reset_chucnang()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-rotate" disabled></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                        </div>
                                        <div class="col-md-6 col-6">
                                            <button type="button" id="tcn_themchucnang" btt_id_add="3" data-id="" onclick="add_chucnang()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Thêm</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-9 col-lg-9">
                            <div class="card" style="height: 540px">
                                <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                                    Danh sách chức năng
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered text-nowrap table-striped" id = "themchucnang_table" >
                                        {{-- Tiêu đề --}}
                                         <!-- <thead>
                                            <tr>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 25px;">STT</th>
                                                <th>ID</th>
                                                <th>Tên chức năng </th>
                                                <th>Ngày tạo</th>
                                                <th style="width: 250px;">Ghi chú</th>
                                                <th style="width: 130px;">Trạng thái</th>
                                                <th style="width: 100px;">Chỉnh sửa</th>
                                            </tr>
                                        </thead>  -->
                                        {{-- Nội dung --}}
                                        <!-- <tbody>
                                            <tr>
                                                <td style="text-align: center;">1</td>
                                                <td>&nbsp;&nbsp;add</td>
                                                <td>&nbsp;&nbsp;Thêm</td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-center">
                                                    <small class="badge badge-primary">Hoạt động</small>
                                                </td>
                                                <td class="text-center"><i class="fa-regular fa-pen-to-square" style="color:#0976d7">&nbsp;&nbsp;</i>
                                                <i class="fa-solid fa-sliders">&nbsp;&nbsp;</i>
                                                <i class="fa-solid fa-ban" style="color: red" ></i>
                                                </td>
                                            </tr>
                                                <td style="text-align: center;">2</td>
                                                <td>&nbsp;&nbsp;delete</td>
                                                <td>&nbsp;&nbsp;Xóa</td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-center">
                                                    <small class="badge badge-primary">Hoạt động</small>
                                                </td>
                                                <td class="text-center"><i class="fa-regular fa-pen-to-square" style="color:#0976d7">&nbsp;&nbsp;</i>
                                                <i class="fa-solid fa-sliders">&nbsp;&nbsp;</i>
                                                <i class="fa-solid fa-ban" style="color: red" ></i>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;">3</td>
                                                <td>&nbsp;&nbsp;edit</td>
                                                <td>&nbsp;&nbsp;Sửa</td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-center">
                                                    <small class="badge badge-primary">Hoạt động</small>
                                                </td>
                                                <td class="text-center"><i class="fa-regular fa-pen-to-square" style="color:#0976d7">&nbsp;&nbsp;</i>
                                                <i class="fa-solid fa-sliders">&nbsp;&nbsp;</i>
                                                <i class="fa-solid fa-ban" style="color: red" ></i>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;">4</td>
                                                <td>&nbsp;&nbsp;update</td>
                                                <td>&nbsp;&nbsp;Cập nhật</td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-center">
                                                    <small class="badge badge-primary">Hoạt động</small>
                                                </td>
                                                <td class="text-center"><i class="fa-regular fa-pen-to-square" style="color:#0976d7">&nbsp;&nbsp;</i>
                                                <i class="fa-solid fa-sliders">&nbsp;&nbsp;</i>
                                                <i class="fa-solid fa-ban" style="color: red" ></i>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;">5</td>
                                                <td>&nbsp;&nbsp;view</td>
                                                <td>&nbsp;&nbsp;Xem</td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-center">
                                                    <small class="badge badge-primary">Hoạt động</small>
                                                </td>
                                                <td class="text-center"><i class="fa-regular fa-pen-to-square" style="color:#0976d7">&nbsp;&nbsp;</i>
                                                <i class="fa-solid fa-sliders">&nbsp;&nbsp;</i>
                                                <i class="fa-solid fa-ban" style="color: red" ></i>
                                                </td>
                                            </tr>
                                        </tbody> -->
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- Cụm input --}}
                    {{-- <label style="color: red;font-size:large">Họ tên:</label>
                    <input style="width:100%"  type="text" value="" > --}}
                    {{-- Cụm input dựng sẵn ATL ADmin--}}
                    {{-- <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                    </div> --}}
                    {{-- Cụm input dựng sẵn tùy biến--}}
                    {{-- <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label" style="height:28px">Căn cước:</label>
                                <div class="col-8">
                                    <input type="text"  class="form-control" id="" name = ""  style="height:28px; width:100%"  value="">
                                </div>
                            </div>
                        </div>
                    </div> --}}

                </div><!-- Class container-fluid -->
            </section>
        </div>
        @include('user_24.modalevent')
        @include('user_24.admin24.include.footer')

    </div>
</body>

</html>

<!-- <script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/5.0.1/js/dataTables.fixedColumns.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/5.0.1/js/fixedColumns.dataTables.js"></script> -->

<!-- <script src="/admin/admin24/js/quanlynhaphoc/tracuusinhvien.js"></script> -->

<script src="/admin/admin24/js/quanlychucnang/themchucnang.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



