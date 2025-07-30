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
                        <div class="col-12 col-sm-3 col-lg-4">
                           <div class="card" style="height: 600px">
                                <div class="card-header">
                                    Thêm chức năng
                                </div>
                                <div class="card-body">



                                    <div class="form-group row">
                                        <label for="" class="col-3 col-form-label" style="">ID CN:</label>
                                        <div class="col-9">
                                            <input type="text"  class="form-control" id="" name = ""  style="height:28px; width:100%"  value="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-3 col-form-label" style="">Tên CN:</label>
                                        <div class="col-9">
                                            <input type="text"  class="form-control" id="" name = ""  style="height:28px; width:100%"  value="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-3 col-sm-4 col-form-label" style="">Ghi chú:</label>
                                        <div class="col-9 col-sm-8">
                                            <input type="text"  class="form-control" id="" name = ""  style="height:28px; width:100%"  value="">
                                        </div>
                                    </div>

                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="update_id_card_user_search" class="col-12 col-sm-4 col-md-3 col-lg-4 col-xl-4 col-form-label"style="padding-bottom: 0px ">Màn hình</label>
                                       <div class="col-12 col-sm-8 col-lg-8 col-md-9 col-xl-8">


                                            <select class="form-control" style="width: 100%;" id = "themchucnang_manhinh">
                                                <option>Chọn màn hình</option>
                                                <option>Quản lý chức năng</option>
                                                <option>Quản lý nhập học</option>
                                                <option>Quản lý xét tuyển</option>
                                            </select>

                                        </div>
                                    </div>















                                    <div class="row">

                                        <div class="col-6 col-sm-4">
                                        </div>
                                        <div class="col-6 col-sm-4">
                                        </div>
                                        <div class="col-6 col-sm-4">
                                            <button type="button" id="" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;Tìm kiếm</button>
                                        </div>


                                    </div>


                                </div>
                                <div class="card-footer">

                            </div>
                           </div>


                        </div>
                        <div class="col-12 col-sm-9 col-lg-8">
                            <div class="card" style="height: 600px">
                                <div class="card-body">
                                    <table class="table table-hover text-nowrap table-striped" id = "themchucnang_table">
                                        {{-- Tiêu đề --}}
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox">
                                                </th>
                                                <th>STT</th>
                                                <th>ID</th>
                                                <th>Tên</th>
                                                <th>Trạng thái</th>
                                                <th>Chức năng</th>
                                                <th>STT</th>
                                                <th>ID</th>
                                                <th>Tên</th>
                                                <th>Trạng thái</th>
                                                <th>Chức năng</th>
                                                <th>Chức năng</th>
                                            </tr>
                                        </thead>
                                        {{-- Nội dung --}}
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="checkbox">
                                                </td>
                                                <td>1</td>
                                                <td>Tu</td>
                                                <td>VVVV</td>
                                                <td>XXXXX</td>
                                                <td>ádfasfsd</td>
                                                <td>ádfasfsd</td>
                                                <td>ádfasfsd</td>
                                                <td>ádfasfsd</td>
                                                <td>ádfasfsd</td>
                                                <td>ádfasfsd</td>
                                                <td><i style="color: #0976d7" class="fa-solid fa-pen-nib"></i></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox">
                                                </td>
                                                <td>1</td>
                                                <td>Tu</td>
                                                <td>VVVV</td>
                                                <td>XXXXX</td>
                                                <td>ádfasfsd</td>
                                                <td>ádfasfsd</td>
                                                <td>ádfasfsd</td>
                                                <td>ádfasfsd</td>
                                                <td>ádfasfsd</td>
                                                <td>ádfasfsd</td>
                                                <td>ádfasfsd</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" style="height: 50px">
                                                </td>
                                                <td>1</td>
                                                <td>Tu</td>
                                                <td>VVVV</td>
                                                <td>XXXXX</td>
                                                <td>ádfasfsd</td>
                                                <td>ádfasfsd</td>
                                                <td>ádfasfsd</td>
                                                <td>ádfasfsd</td>
                                                <td>ádfasfsd</td>
                                                <td>ádfasfsd</td>
                                                <td>ádfasfsd</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" style="height: 19px">
                                                </td>
                                                <td>1</td>
                                                <td>Tu</td>
                                                <td>VVVV</td>
                                                <td>XXXXX</td>
                                                <td>ádfasfsd</td>
                                                <td>ádfasfsd</td>
                                                <td>ádfasfsd</td>
                                                <td>ádfasfsd</td>
                                                <td>ádfasfsd</td>
                                                <td>ádfasfsd</td>
                                                <td>ádfasfsd</td>
                                            </tr>

                                        </tbody>




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
                                <label for="" class="col-4 col-form-label" style="">Căn cước:</label>
                                <div class="col-8">
                                    <input type="text"  class="form-control" id="" name = ""  style="height:28px; width:100%"  value="">
                                </div>
                            </div>
                        </div>
                    </div> --}}























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

<script src="/admin/admin24/js/quanlynhaphoc/tracuusinhvien.js"></script>

<script>


$('#themchucnang_table').DataTable({
    columnDefs: [
        {
            targets: 0,
            className: 'dt-body-center'
        },
        {
            targets: 1,
            className: 'dt-body-left'
        },
        {
            targets: 2,
            className: 'dt-body-left'
        },
        {
            targets: 3,
            className: 'dt-body-center'
        },
        {
            targets: 4,
            className: 'dt-body-left'
        },
        {
            targets: 5,
            className: 'dt-body-left'
        },
        {
            targets: 6,
            className: 'dt-body-left'
        },
        // {
        //     targets: 7,
        //     className: 'dt-body-left'
        // },

    ],

    "language": {
        "emptyTable": "Không tìm thấy chức năng",
        "info": " _START_ / _END_ trên _TOTAL_ chức năng",
        "paginate": {
            "first": "Trang đầu",
            "last": "Trang cuối",
            "next": "Trang sau",
            "previous": "Trang trước"
        },
        "search": "Tìm kiếm:",
        "loadingRecords": "Đang tìm kiếm ... ",
        "lengthMenu": "Hiện thị _MENU_ chức năng",
        "infoEmpty": "",
    },
    "retrieve": true,
    "paging": true,
    "lengthChange": false,
    "searching": true,
    "ordering": false,
    "info": false,
    "autoWidth": true,
    "responsive": true,
    scrollY: 400,
});

$('#themchucnang_manhinh').select2();



</script>
