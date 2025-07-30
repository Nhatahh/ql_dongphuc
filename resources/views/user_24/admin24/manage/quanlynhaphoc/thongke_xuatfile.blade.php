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

                        <!-- tìm kiếm -->
                        <div class="col-12 col-md-3 col-lg-3">
                            <!-- <span class=""  style="margin-left:10px"><strong>Tìm kiếm thí sinh </strong></span> -->
                            <div class="card" style="height:600px">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group" style="margin-bottom: 3px">
                                                <label for="update_id_card_user_search" class="col-12 col-form-label" style="padding-bottom: 0px ">Năm học:</label>
                                                <div class="col-12 ">
                                                    {{-- <input type="text"  class="form-control ttsv_info" id="cccd" name = "update_id_card_user_search" style="height:28px; width:100%"  value=""> --}}
                                                    <select class="form-control ttsv_info major" id="nam" name = 'update_id_batch_search' style="width: 100%;"></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group" style="margin-bottom: 3px">
                                                <label for="update_id_card_user_search" class="col-12 col-form-label" style="padding-bottom: 0px ">Khoa:</label>
                                                <div class="col-12">
                                                    {{-- <input type="text"  class="form-control ttsv_info" id="cccd" name = "update_id_card_user_search" style="height:28px; width:100%"  value=""> --}}
                                                    <select class="form-control ttsv_info major" id="khoa" onchange="loadlop()" name = 'update_id_batch_search' style="width: 100%;"></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group" style="margin-bottom: 3px">
                                                <label for="update_id_card_user_search" class="col-2 col-form-label" style="padding-bottom: 0px ">Lớp:</label>
                                                <div class="col-12">
                                                    {{-- <input type="text"  class="form-control ttsv_info" id="cccd" name = "update_id_card_user_search" style="height:28px; width:100%"  value=""> --}}
                                                    <select class="form-control ttsv_info major" id="lop" name = 'update_id_batch_search' style="width: 100%;"></select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-1 col-12">
                                        </div>
                                        <div class="col-md-11 col-12">
                                            <div class="card-body p-1">
                                                <div class="row">
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-6">
                                                        <!-- <button id=""  id-data = "" class="btn btn-block btn-primary btn-xs " onclick="update_ttsv_img_search()"><i class="fa fa-file"></i>&nbsp;&nbsp;&nbsp;</button> -->
                                                    </div>
                                                    <div class="col-12 col-md-8 col-lg-8 col-xl-6">
                                                        <button id="update_ttsv_search"  id-data = "" class="btn btn-block btn-primary btn-xs " onclick="search()"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Tìm kiếm</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class=" " style="border:1px solid rgba(0,0,0,.125);margin-bottom:5px"> </div>
                                        </div>




                                    </div>
                                </div>
                            </div>

                        </div> <!-- Thẻ đóng Tìm kiếm -->

                        <div class="col-12 col-md-9 col-lg-9" >
                            <div class="card card-primary card-outline card-outline-tabs" style="height:600px">
                                <div class="card-body" >
                                        <div class="tab-content" id="custom-tabs-two-tabContent">
                                                <table id = "table_thongke_xuatfile" class="table table-hover text-nowrap table-striped table_thongtinsv">
                                                    {{-- <thead>
                                                        <th>aaa</th>
                                                        <th><input type="checkbox" name="" id="" style="height:19px"></th>
                                                        <th>STT</th>
                                                        <th>MSSV</th>
                                                        <th>CCCD</th>
                                                        <th>Họ và tên</th>
                                                        <th>Ngày sinh</th>
                                                        <th>Giới tính</th>
                                                        <th>Địa chỉ</th>

                                                    </thead>
                                                    <tbody id = "danhsachsinhvien"> --}}
                                                        {{-- <tr>
                                                            <td>gfg</td>
                                                            <td><input type="checkbox" name="" id="check" style="height:19px"></td>
                                                            <td>' + (index + 1) + '</td>
                                                            <td>' + item.mssv + '</td>
                                                            <td>' + item.cccd + '</td>
                                                            <td> + item.hoten + '</td>
                                                            <td>' + item.ngaysinh + '</td>
                                                            <td>' + gioitinh + '</td>
                                                            <td>' + item.diachi + '</td>
                                                          </tr> --}}
                                                    {{-- </tbody>
                                                    <tfoot></tfoot> --}}
                                                </table>



                                    </div>

                                </div>
                                <div class="card-footer">
                                <div class="col-md-12 col-12" style="margin-bottom: 5px">
                                        <div class="row">
                                            <div class="col-9">
                                            </div>
                                            <div class="col-3">
                                                <div class="style_all_button">
                                                    <div class="row">
                                                        <!-- <div class="col-4">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <button type="button" id="themdotxettuyen_popup" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;Thêm đợt</button>
                                                                </div>
                                                                <div class="col-4">
                                                                    <button type="button" id="laydulieutheodot" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;Lấy dữ liệu</button>
                                                                </div>
                                                                <div class="col-4">
                                                                    <button type="button" id="luudanhsachtrungtuyentam" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;Lưu KQ</button>
                                                                </div>
                                                            </div>
                                                        </div> -->

                                                        <div class="col-12">
                                                            <div class="row">
                                                                <div class="col-6"></div>
                                                                <div class="col-6">
                                                                    <button type="button" id="excel_hsnh_thongke_xuatfile"  class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-file-excel"></i>&nbsp;&nbsp;Excel</button>
                                                                </div>
                                                                {{-- <div class="col-6">
                                                                    <button type="button" id="pdf_hsnh_thongtinsinhvien" onclick = pdf_hsnh_thongtinsinhvien(12) class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-print"></i>&nbsp;&nbsp;In</button>
                                                                </div> --}}
                                                                <!-- <div class="col-4">
                                                                    <button type="button" id="phodiemtheodotts" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;Exports</button>
                                                                </div> -->
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
                </div><!-- Class container-fluid -->
            </section>
        </div>
        @include('user_24.admin24.include.footer')
    </div>
</body>
<script>

    const swiper = new Swiper('.swiper', {
    zoom: true,
    zoom: {
        maxRatio: 3,
        minRatio: 1
      },
    rotate: 'true',
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },

    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },

    slidesPerView: 1,
    spaceBetween: 10,
    // freeMode: true
    });


</script>
</html>

<!-- <script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/5.0.1/js/dataTables.fixedColumns.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/5.0.1/js/fixedColumns.dataTables.js"></script> -->
<script>

    $('#abc').select2();

    function loadthongtincanhan(){

        var id_taikhoan = $('#loadthongtincanhan').val()
        $.ajax({
            url: "hosonhaphoc/loadttcn/"+id_taikhoan,
            type:'get',

            success:function(res){
                if(res.length > 0){
                    $('#hoten').val(res[0].text)
                }else{
                    $('#hoten').val('')
                }

            }
        })
    }

    // $('#table_thongtinsv').Datatables();



</script>

<script src="/admin/admin24/js/quanlynhaphoc/thongke_xuatfile.js"></script>
