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

        .checkbox_chucnang{

            margin-left:0px;
            padding-bottom:3px;
        }
        .khoangcach_chucnang{
            height:15px;
            width:10%;
        }
       .dorong_box{
        height: 340px;
        width: 100%;
        overflow-y: scroll;
        overflow-x: hidden;
        margin-bottom: 13px;
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

                {{-- Code ở đây --}}

                    <div class="row">
                        <div class="col-12 col-sm-3 col-lg-3">
                             <div class="card" style="min-height:540px">
                                <div>
                                    <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Danh mục phân quyền</div>
                                    <div class="card-body" style="height:300px;">
                                        <div class="form-group">
                                        <label for="update_id_card_user_search" class="col-12 col-sm-4 col-md-3 col-lg-4 col-xl-4 col-form-label"style="padding-bottom: 0px ">Màn hình</label>
                                            <div class="col-12">
                                                <select class="form-control" style="width: 100%;" id = "themchucnang_manhinh" onchange="themchucnang_manhinh()">
                                                    <!-- <option>Chọn màn hình</option>
                                                    <option value = 0>Quản lý chức năng</option>
                                                    <option>Quản lý nhập học</option>
                                                    <option>Quản lý xét tuyển</option>
                                                    <option>Quản lý lịch học</option>
                                                    <option>Quản lý lịch thi</option>
                                                    <option>Quản lý thông tin</option>
                                                    <option>Quản lý đăng ký</option>
                                                    <option>Quản lý học phần</option>
                                                    <option>Quản lý đồng phục</option> -->
                                                 </select>
                                            </div>
                                        </div>
                                        <div class="box dorong_box" style="margin-top: 35px;" id = "ip_chucnang_danhsachchucnang">
                                        <!-- <div class="row checkbox_chucnang">
                                            <input type="checkbox"  class="form-control khoangcach_chucnang">&nbsp;&nbsp;Thêm
                                        </div>
                                        <div class="row checkbox_chucnang">
                                            <input type="checkbox"  class="form-control khoangcach_chucnang">&nbsp;&nbsp;Chỉnh sửa
                                        </div>
                                        <div class="row checkbox_chucnang">
                                            <input type="checkbox"  class="form-control khoangcach_chucnang">&nbsp;&nbsp;Truy cập
                                        <div class="row checkbox_chucnang">
                                            <input type="checkbox"  class="form-control khoangcach_chucnang">&nbsp;&nbsp;Nâng cấp
                                        </div> -->
                                        </div>
                                        <!-- <div class="card-header" style="padding:2px;margin-left: 10px;"></div>
                                        <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                            <div class="row">
                                                <div class="col-md-6 col-6"></div>
                                                <div class="col-md-6 col-6">
                                                    <button type="button" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-user-pen"></i>&nbsp;&nbsp;&nbsp;Cấp quyền</button>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-12 col-sm-9 col-lg-9">
                            <div class="card" style="height: 540px">
                                <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                                    Thông tin hiển thị chức năng
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered text-nowrap table-striped" id = "importchucnang_table" >
                                        {{-- Tiêu đề --}}
                                        <!-- <thead>
                                            <tr>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 25px;">STT</th>
                                                <th style="width: 200px;">Màn hình</th>
                                                <th style="width: 180px;">Chức năng</th>
                                                <th style="width: 50px;">Số lần dùng</th>
                                                <th style="width: 200px;">Ghi chú</th>
                                                <th style="width: 130px;">Trạng thái</th>
                                                <th style="width: 80px;">Delete</th>

                                            </tr>
                                        </thead> -->
                                        {{-- Nội dung --}}
                                        <!-- <tbody>
                                             <tr>
                                                <td style="text-align: center;">1</td>
                                                <td>&nbsp;&nbsp;Quản lý học phần</td>
                                                <td>&nbsp;&nbsp;Thêm</td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-center">
                                                    <small class="badge badge-primary">Hoạt động</small>
                                                </td>
                                                <td class="text-center"><i class="fa-solid fa-trash-can" style="color: #f20707;"></i>
                                                </td>
                                             </tr>
                                            <tr>
                                               <td style="text-align: center;">2</td>
                                                <td>&nbsp;&nbsp;Quản lý xét tuyển</td>
                                                <td>&nbsp;&nbsp;Cập nhật</td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-center">
                                                    <small class="badge badge-primary">Hoạt động</small>
                                                </td>
                                                <td class="text-center"><i class="fa-solid fa-trash-can" style="color: #f20707;"></i>
                                                </td>
                                            </tr>
                                        </tbody>-->
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- Class container-fluid -->
            </section>
        </div>
        @include('user_24.admin24.include.footer')
    </div>
</body>

</html>

<!-- <script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/5.0.1/js/dataTables.fixedColumns.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/5.0.1/js/fixedColumns.dataTables.js"></script> -->

<script src="/admin/admin24/js/quanlychucnang/importchucnang.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
