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
                        <div class="col-12 col-md-12 col-lg-12" >
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-header" style="font-weight:normal">
                                    <div class="row">
                                        <div class="col-1">
                                            <button type="button" id="tcsv_timkiem" onclick="tcsv_timkiem()" class="load-index btn btn-block btn-primary btn-xs"><i class="fa-solid fa-search"></i>&nbsp;&nbsp;Tìm kiếm</button>
                                        </div>
                                        <div class="col-1">
                                            <button type="button" id="tcsv_lammoi" onclick="tcsv_lammoi()" class="load-index btn btn-block btn-default  btn-xs"><i class="fa-solid fa-arrow-rotate-left"></i>&nbsp;&nbsp;Làm mới</button>
                                        </div>
                                        <div class="col-1">
                                            <button type="button" id="tcsv_excel" onclick="tcsv_dp_excel()" class="load-index btn btn-block btn-primary btn-xs"><i class="fa-regular fa-file-excel"></i></i>&nbsp;&nbsp;Excel</button>
                                        </div>
                                        <!-- <div class="col-1">
                                            <button type="button" id="tcsv_lammoi" onclick="tcsv_lammoi()" class="load-index btn btn-block btn-primary btn-xs"><i class="fa-regular fa-file-pdf"></i>&nbsp;&nbsp;Xuất PDF</button>
                                        </div> -->



                                        <div class="col-1">
                                            <button type="button" id="tcsv_excel" onclick="Upload_ttsv()" class="load-index btn btn-block btn-primary btn-xs"><i class="fa-regular fa-file-excel"></i></i>&nbsp;&nbsp;Upload</button>
                                        </div>
                                        <div>
                                            <form style="display:none" id="submit_Upload_ttsv_open">
                                                <input type="file" name="upload_ttsv_open" id="upload_ttsv_open"/>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" >
                                    <div class="row">
                                        <div class="col-12 col-md-4 col-lg-3 p-0 block-left load-index" >
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="update_id_card_user_search" class="col-12 col-form-label" style="padding-bottom: 0px ">Khóa học:</label>
                                                        <div class="col-12">
                                                            <select  val-def = "0" class="tcsv form-control" id="tcsv_khoahoc" name = 'update_id_batch_search' style="width: 100%;"></select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="update_id_card_user_search" class="col-12 col-form-label" style="padding-bottom: 0px ">Khoa:</label>
                                                        <div class="col-12">
                                                            <select  val-def = "0" class="tcsv form-control ttsv_info" id="tcsv_khoa" name = 'update_id_batch_search' style="width: 100%;"></select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="update_id_card_user_search" class="col-12 col-form-label" style="padding-bottom: 0px ">Ngành:</label>
                                                        <div class="col-12">
                                                            <select  val-def = "0" class="tcsv form-control ttsv_info" id="tcsv_nganh" name = 'update_id_batch_search' style="width: 100%;"></select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="update_id_card_user_search" class="col-12 col-form-label" style="padding-bottom: 0px ">Ch/Ngành:</label>
                                                        <div class="col-12">
                                                            <select  val-def = "0" class="tcsv form-control ttsv_info" id="tcsv_chuyennganh" name = 'update_id_batch_search' style="width: 100%;"></select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="update_id_card_user_search" class="col-12 col-form-label" style="padding-bottom: 0px ">Lớp:</label>
                                                    <div class="col-12">
                                                            <select  val-def = "0" class="tcsv form-control ttsv_info" id="tcsv_lop" name = 'update_id_batch_search' style="width: 100%;"></select>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="col-12" >
                                                    <div class="form-group">
                                                        <label for="update_id_card_user_search" class="col-12 col-form-label" style="padding-bottom: 0px ">Họ tên:</label>
                                                    <div class="col-12">
                                                        <input type="text"  val-def = ""  class="tcsv form-control ttsv_info" id="tcsv_hoten" name = "update_id_card_user_search" style="height:28px; width:100%" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="update_id_card_user_search" class="col-12 col-form-label" style="padding-bottom: 0px ">MSSV:</label>
                                                        <div class="col-12">
                                                            <input type="text" val-def = "" class="tcsv form-control ttsv_info" id="tcsv_mssv" name = "update_id_card_user_search" style="height:28px; width:100%"  value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="update_id_card_user_search" class="col-12 col-form-label" style="padding-bottom: 0px ">Căn cước:</label>
                                                        <div class="col-12">
                                                            <input type="text"  val-def = "" class="tcsv form-control ttsv_info" id="tcsv_cccd" name = "update_id_card_user_search"  style="height:28px; width:100%"  value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-8 col-lg-9" >
                                            <div class="card block-right">
                                                <div class="card-header p-0">Danh sách sinh viên</div>
                                                    <div class="card-body p-1 load-index" id= "tcsv_body_ds" style="overflow: hidden">
                                                        <table id = "tcsv_load_danhsach" class="table table-hover table-striped table-bordered"></table>
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
                <!--  -->
                <div class="row" style="display:none">
                    
                        <div class="col-1">
                            <select  val-def = "0" class="tcsv  ttsv_info" id="tcsv_dantoc" name = 'update_id_batch_search' style="width: 100%;height:0px"></select>
                        </div>

                   
                        <div class="col-1">
                            <select   val-def = "0" class="tcsv form-control ttsv_info" id="tcsv_tongiao" name = 'update_id_batch_search' style="width: 100%;height:0px"></select>
                        </div>

                    
                        <div class="col-12">
                            <select  val-def = "-1" class="tcsv ttsv_info" id="tcsv_gioitinh" name = 'update_id_batch_search' style="width: 100%;height:0px">

                            </select>
                        </div>

                        <div class="col-1">
                            <select  val-def = "0" class="tcsv  ttsv_info" id="tcsv_noisinh" name = 'update_id_batch_search' style="width: 100%;height:1px"></select>
                        </div>

                    
                        <div class="col-1" >
                            <select  val-def = "0" class="tcsv  ttsv_info" id="tcsv_hktt" name = 'update_id_batch_search' style="width: 100%;height:1px"></select>
                        </div>

                    <div class="col-1">

                                <select  val-def = "0" class="tcsv ttsv_info" id="tcsv_quequan" name = 'update_id_batch_search' style="width: 100%;height:0px"></select>

                    </div>
                    <div class="col-1">
                        <select  val-def = "-1" class="tcsv form-control ttsv_info" id="tcsv_hoatdong" name = 'update_id_batch_search' style="width: 100%;height:0px">
                        </select>
                    </div>
                </div>
                <!--  -->
                <div class = "modal" id="modal_event_tcsv">
                    <div style="position: relative; text-align:center; background-color: rgba(0,0,0,0.7);height: 100%;">
                        <i
                            class="fa-solid fa-xmark"
                            onclick = "modal_event_tcsv_close()"
                            style="
                                position: absolute;
                                top: 10px;
                                right: 10px;
                                font-size: 24px;
                                color: white;
                                cursor: pointer;
                                z-index: 1000; "
                        >
                        </i>
                        <div class="swiper swiper-slider1">
                            <div class="swiper-wrapper" id = 'tcsv_slider'>

                            </div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-scrollbar"></div>
                        </div>
                        {{-- <img class= "img-fluid" style="height:100%" id ='tcsv_load_img' src = ''> --}}
                    </div>
                </div>
                @include('user_24.admin24.include.preloader')
            </section>
        </di>
        @include('user_24.admin24.include.footer')
    </div>
    @include('user_24.modalevent')
</body>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script src="/admin/admin24/js/quanlynhaphoc/tracuusinhvien.js"></script>
<script src="/swiper/swiper.js"></script>
<script>
    const swiper = new Swiper('.swiper-slider1', {
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



