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
                                            <div class="form-group " style="margin-bottom: 3px">
                                                <label for="update_id_card_user_search" class="col-sm-12 col-lg-12 col-xl-12 col-md-12 col-form-label" style="padding-bottom: 0px ">Lớp:</label>
                                                <div class="col-sm-12  col-lg-12 col-xl-12 col-md-12 ">
                                                    <select class="form-control ttsv_info" id="major_bhyt" name = 'update_id_batch_search' style="width: 100%;"></select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-12">
                                            <div class="form-group " style="margin-bottom: 3px">
                                                <label for="update_id_card_user_search" class="col-sm-12 col-lg-12 col-xl-12 col-md-12 col-form-label" style="padding-bottom: 0px ">Mã số sinh viên</label>
                                                <div class="col-sm-12  col-lg-12 col-xl-12 col-md-12">
                                                <input type="text"  class="form-control ttsv_info" id="mssv_bhyt" name = "update_id_card_user_search" style="height:28px; width:100%"  value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group " style="margin-bottom: 3px">
                                                <label for="update_id_card_user_search" class="col-sm-12 col-lg-12 col-xl-12 col-md-12 col-form-label" style="padding-bottom: 0px ">Căn cước công dân</label>
                                                <div class="col-sm-12  col-lg-12 col-xl-12 col-md-12">
                                                <input type="text"  class="form-control ttsv_info" id="cccd_bhyt" name = "update_id_card_user_search" style="height:28px; width:100%"  value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group " style="margin-bottom: 3px">
                                                <label for="update_id_card_user_search" class="col-sm-12 col-lg-12 col-xl-12 col-md-12 col-form-label" style="padding-bottom: 0px ">Số thẻ BHYT</label>
                                                <div class="col-sm-12  col-lg-12 col-xl-12 col-md-12">
                                                <input type="text"  class="form-control ttsv_info" id="sothe_bhyt" name = "update_id_card_user_search" style="height:28px; width:100%"  value="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-1 col-12">
                                        </div>
                                        <div class="col-md-11 col-12">
                                            <div class="card-body ">
                                                <div class="row">
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-6">
                                                        <!-- <button id=""  id-data = "" class="btn btn-block btn-primary btn-xs " onclick="update_ttsv_img_search()"><i class="fa fa-file"></i>&nbsp;&nbsp;&nbsp;</button> -->
                                                    </div>
                                                    <div class="col-12 col-md-8 col-lg-8 col-xl-6">
                                                    <button id="update_ttsv_search_bhyt"  id-data = "" class="btn btn-block btn-primary btn-xs " onclick="search_bhyt()"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Tìm kiếm</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12 ">
                                            <div class=" " style="border:1px solid rgba(0,0,0,.125);margin-bottom:5px; margin-top:7px"> </div>
                                        </div>
                                        <div class="col-12 p-1">
                                            <div class="row">
                                                <div class="col-12 col-md-7 col-lg-7 col-xl-9 col-sm-9">
                                                    <label for="" class=" col-form-label" style="padding-bottom: 0px ">Tải lên Ds BHYT:</label>

                                                    <form id="importForm" >
                                                        <input type="file" name="fileInput" id="fileInput" style="display: none;">
                                                    </form>
                                                </div>
                                                <div class="col-12 col-md-5 col-lg-5 col-xl-3 col-sm-3 d-flex justify-content-between align-items-center">


                                                        <i id="selectFileBtn" class="fas fa-folder-open" style="cursor: pointer"></i>

                                                        <i class="fa-solid fa-upload" id="import_bhyt" style="cursor: pointer"></i>

                                                        <i class="fa-solid fa-arrows-rotate" id="cancelFileBtn" style="cursor: pointer"></i>

                                                </div>
                                                <div id="fileNameContainer" >
                                                    <div id="selectedFileName" ></div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div> <!-- Thẻ đóng Tìm kiếm -->

                        <div class="col-12 col-md-9 col-lg-9" >
                            <div class="card card-primary card-outline card-outline-tabs" style="height:600px">
                                <div class="card-body" >
                                    <div class="tab-content" id="custom-tabs-two-tabContent">
                                        <table id = "table_thongtinsv_bhyt" class="table table-hover text-nowrap table-striped ">
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="col-md-12 col-12" style="margin-bottom: 5px">
                                        <div class="row">
                                            <div class="col-7">
                                            </div>
                                            <div class="col-5">
                                                <div class="style_all_button">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <!-- <button type="button" id="import_bhyt"  class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-pen-to-square"></i>&nbsp;&nbsp; Cập nhật thông tin </button> -->
                                                                </div>
                                                                <div class="col-3">
                                                                    {{-- <button type="button" id="lichsu_bhyt" onclick="lichsu_bhyt()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-clock-rotate-left"></i>&nbsp;&nbsp; Lịch sử </button> --}}
                                                                </div>
                                                                <div class="col-3">
                                                                    <button type="button" id="excel_hsnh_thongtinsinhvien_bhyt" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-file-excel"></i>&nbsp;&nbsp;Excel</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- Class container-fluid -->
                <div class = "modal" id="modal_event_bhyt">
                    <div style="text-align:center; background-color: rgba(0,0,0,0.7);height: 100%;">
                        <div class="fa-solid fa-xmark"
                            style="position: absolute;
                            top: 10px;
                            right: 10px;
                            cursor: pointer;
                            font-size: 18px;
                            color: red;
                            background-color: #fff;
                            border-radius: 50%;
                            width: 40px;
                            height: 40px;
                            display: flex;
                            align-items: center;
                            justify-content: center;">
                        </div>
                        <img class= "img-fluid" style="height:100%" id ='img_bhyt_load' src = ''>
                    </div>
                </div>

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

<script src="/admin/admin24/js/quanlynhaphoc/bhyt.js"></script>
