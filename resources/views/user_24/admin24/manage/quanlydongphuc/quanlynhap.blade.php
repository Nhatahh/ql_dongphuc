<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('user_24.admin24.include.header')
    <!-- <link rel="stylesheet" href="/admin/admin_24/plugins/summernote/summernote.min.css"> -->
    <style>

        .card-header{
            font-weight: normal
        }



        .selected {
            background-color: #007bff;
            color: #fff;
        }
        th > select{
            width: 90%
        }


        .item-hoso {
            border: 1px solid #ccc; /* Viền nổi */
            border-radius: 8px; /* Bo góc */
            overflow: hidden; /* Đảm bảo các nội dung bên trong không bị tràn ra ngoài */
            box-shadow: 0 8px 8px rgba(0, 0, 0, 0.1); /* Đổ bóng nhẹ */
            width: 100%;
            margin-bottom: 20px; /* Khoảng cách dưới giữa các item */
            font-family: 'Open Sans', sans-serif;
            font-weight: 400;
            background-color: #ffffff; /* Màu nền header */
        }

        .item-header{
            display: flex;
            flex-direction:column;
        }

        .item-row1 {
            padding: 0px; /* Khoảng cách bên trong header */
            display: flex;
            justify-content: space-between; /* Căn các phần tử theo hai bên */

        }

        .item-row1 .maphieu {
            margin-right: 5px; /* Khoảng cách phải giữa 'Mã phiếu' và 'NVQS2024121223' */
        }

        .item-row1 .xemchitiet {
            color: #11a2f3; /* Màu chữ cho đường link */
            text-decoration: none; /* Loại bỏ gạch chân mặc định của link */
            margin: 0 10px 0 0;
        }

        .item-row2  {
            padding: 0 0 0 10px;
        }

        .item-bottom{
            border-bottom: 1px dashed black; /* Border bottom dạng gạch chấm */
            width: 100%; /* Chiếm 90% chiều rộng của phần tử cha */
            margin: 3px 0px; /* Canh giữa */

        }

        .item-body {
            padding: 5pxpx; /* Khoảng cách bên trong body */
        }

        .thongtin {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: space-between; /* Canh giữa các phần tử con */
            width: 100%; /* Chiều rộng 100% */
        }

        .thongtin .left {
            flex: 1; /* Độ rộng tự động */
            text-align: left; /* Căn trái */
        }

        .thongtin .right {
            flex: 1; /* Độ rộng tự động */
            text-align: right; /* Căn phải */
            margin-left: auto;
        }

        .title-hoso {
            display: flex;
            justify-content: space-between; /* Canh các phần tử con ở hai bên */
            align-items: center; /* Căn các phần tử con theo chiều dọc */
            padding: 0px; /* Khoảng cách bên trong */
        }

        .title-hoso .loaihoso {
            font-size: 15px; /* Cỡ chữ */
            font-weight: 400; /* Đậm */
            color:#11a2f3;
        }

        .title-hoso .xacnhan-hoso {
            background-color: #11a2f3; /* Màu nền */
            color: white; /* Màu chữ */
            border: none; /* Không có viền */
            padding: 4px 4px; /* Khoảng cách bên trong */
            border-radius: 4px; /* Bo góc */
            cursor: pointer; /* Con trỏ chuột khi hover */
            transition: background-color 0.3s ease, color 0.3s ease; /* Hiệu ứng hover */
        }

        .title-hoso .xacnhan-hoso:hover {
            background-color: #0b8ab8; /* Màu nền hover */
        }


        .checkbox-container {
            display: inline-block;
            vertical-align: middle;
            position: relative;
            cursor: pointer;
            font-size: 14px;
            line-height: 1.2;
            padding-left: 28px; /* khoảng cách giữa checkbox và label */
            margin-bottom: 0px; /* khoảng cách giữa các checkbox */
            margin-top: 10px;
        }

        .checkbox-container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .checkbox-container label {
            position: relative;
            padding-left: 25px; /* khoảng cách giữa checkbox và nội dung */
            height: 14px;
            margin:0;

        }

        .checkbox-container label:before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 14px;
            height: 14px;
            border: 2px solid #aaa; /* màu viền */
            background-color: #fff; /* màu nền */

        }

        label:not(.form-check-label):not(.custom-file-label) {
            font-weight: normal;
        }
        .checkbox-container input:checked ~ label:before {
            background-color: #2196F3; /* màu nền khi được chọn */
            border-color: #2196F3; /* màu viền khi được chọn */
        }

        /* .checkbox-container label:after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 8px;
            height: 8px;
            background-color: #fff;
            border-radius: 50%;
            opacity: 0;
        }

        .checkbox-container input:checked ~ label:after {
            opacity: 0;
        } */

        label {
            cursor: pointer;
        }

        .item-thisinh {
            border: 1px solid #ddd; /* Viền đơn màu xám nhạt */
            border-radius: 8px; /* Bo tròn các góc */
            padding: 15px; /* Khoảng cách giữa nội dung và viền */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Đổ bóng nhẹ */
            background-color: #fff; /* Màu nền */
        margin-bottom: 8px; /* Khoảng cách dưới của mỗi item */
        }

        .select2-search {
            display: none !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice{
            background-color: #007bff;
        }

        #scrollTopBtn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 99;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 18px;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease;
            opacity: 0;
            visibility: hidden;
        }

        #scrollTopBtn:hover {
            background-color: #0056b3;
        }

        /* CSS cho icon trong nút */
        #scrollTopBtn i {
            pointer-events: none; /* Không cho phép sự kiện click cho icon */
            line-height: 40px; /* Căn giữa icon */
        }
        .btt_lammoi{
            border-color: #007bff;
            color: #007bff;
       }
       .text_error{
            color: red;
            font-size: 0.8rem;
       }
       .edit_tabledata:focus{
            outline: none;
       }
       /* Đặt màu nền của ô input giống với hàng */
        .edit_tabledata {
            background-color: inherit !important;
        }

        /* Đảm bảo hiệu ứng hover của ô input giống với hàng */
        .edit_tabledata:hover {
            background-color: inherit !important;
        }

        .nhap_mobile{
            display: none;
        }
        .nhap_pc{
            display: none;
        }
        .modal-fullscreen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
        }

    </style>

@livewireStyles
</head>

<body class="sidebar-mini sidebar-collapse">
    <div class="wrapper">

        {{-- @include('user_24.admin24.include.preloader') --}}
        @include('user_24.admin24.include.navbar')
        @include('user_24.admin24.include.sidebar')
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    @include('user_24.admin24.include.contentheader')
                    <div class="row">

                        <div class="ccol-12 col-md-12 col-lg-12 nhap_mobile">
                            @livewire('quanlynhap')
                        </div>
                        <div class="ccol-12 col-md-12 col-lg-12 nhap_pc">
                            <div class="card" style="min-height: 550px ;">
                                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group row" style="margin-bottom: 3px">
                                                <label for="load_sanpham_dotnhap" class=" col-lg-1 col-sm-5 col-12 col-form-label" style="padding-bottom: 0px">Đợt nhập:</label>
                                                <div class=" col-lg-2 col-sm-4 col-6">
                                                    <select class="form-control" id="qlnhap_iddot" onchange="reload_dssanpham_dot()" style="width: 100%;"></select>
                                                </div>
                                                <div class="col-lg-1 col-sm-3 col-6">
                                                    <button type="button" id="" onclick="btt_show_model_nhapdongphuc()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-circle-plus"></i>&nbsp;&nbsp;&nbsp;Nhập ĐP</button>
                                                </div>
                                                <div class="col-lg-1 col-sm-3 col-6">
                                                    <button type="button" id="" onclick="bieudo_thongke_nhap()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-chart-simple"></i>&nbsp;&nbsp;&nbsp;Biểu đồ</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" id="dssanpham_dot">
                                        <table class="table table-bordered table-hover table-striped dataTable no-footer dtr-inline" id="loadSanphamQLN"></table>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button  onclick="scrollToTop()" id="scrollTopBtn" title="Trở về đầu trang"><i  class="fas fa-arrow-up"></i></button>
            </section>
        </div>
        @include('user_24.modalevent')
        @include('user_24.admin24.include.footer')
    </div>
    @livewireScripts

    <!-- Modal nhập đồng phục -->
    <div class="modal" id="modal_nhapdongphuc1">
        <div id = "container_modal_Nhap" style="vertical-align:middle;background-color: rgba(0,0,0,0.5);height: 100%; ">
            <div class="row">
                <div class="col-md-12 col-12">
                    <div id = "container-modalNhap"  class="card card-navy card-outline" style="width:85%; height:auto; padding: 2px; background-color:#fff; margin-top: 5%;margin-left: 7%;">
                        <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                            <div class="row">
                                <div class="col-md-11 col-lg-11 col-11">
                                    <span class="">Nhập đồng phục</span>
                                </div>
                                <div class="col-md-1 col-lg-1 col-1">
                                    <span class="float-right" style="margin-right: 10px"><i onclick="btt_hide_model_nhapdongphuc()" id='modal_number_go_wish_start_end_close' class="fas fa-times"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="" style="padding-bottom: 0px;padding-top: 3px">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12 nhap_mobile direct-chat-messages direct-chat-infos clearfix" style = "height: 98vh;">
                                            
                                        @livewire('qldp-nhap')

                                </div>

                                <div class="ccol-12 col-md-12 col-lg-12 nhap_pc">
                                    <div class="" style="padding: 3px 10px 0px 10px;" id="dssanpham_dot">
                                        <table class="table table-bordered table-hover table-striped dataTable no-footer dtr-inline" id="loadsanphamdotnhap"></table>
                                    </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>









    <!-- Modal thống kê -->
    <div class="modal" id="modal_bieudo_thongke_nhap" style="display: none; align-items: center; justify-content: center; min-height: 100vh; position: fixed;">
        <div style="display: flex; justify-content: center; align-items: center; width: 100%; height: 100%;">
            <div class="card card-navy card-outline" style="position: relative; width: 110%; max-width: 1200px; height: 80%; margin: auto; background-color: #fff; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; background-color: transparent; color: #000;">
                    <div class="row" style="width: 100%;">
                        <div class="col-md-11 col-lg-11 col-11">
                            <span><i class="fa-solid fa-chart-pie"></i> Biểu đồ thống kê</span>
                        </div>
                        <div class="col-md-1 col-lg-1 col-1">
                            <span class="float-right" style="margin-right: 10px;">
                                <i onclick="close_bieudo_thongke()" id='modal_number_go_wish_start_end_close' class="fas fa-times" style="cursor: pointer;"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding-bottom: 30px; height: calc(100% - 60px);min-width:100%;">
                    <canvas id="dongphuc_dot-chart-canvas" style="display: block;" class="chartjs-render-monitor"></canvas>
                    <div class="row">
                        <div class="col-md-8 col-lg-8 col-10 col-xl-8"></div>
                        <div style="padding-bottom:0px;padding-right:9px;"  class="col-md-2 col-lg-2 col-6 col-xl-2">
                            <button type="button" id="" onclick="btt_xuatexcel_ql_sanphamnhap()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Xuất DS</button>
                        </div>
                        <div style="padding-bottom:0px;padding-right:9px;"  class="col-md-2 col-lg-2 col-6 col-xl-2">
                            <button type="button" id="" onclick="btt_xuatexcel_sanphamnhap()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Xuất TK</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @include('user_24.admin24.include.Scan_QR')
</body>
<!-- summernote -->
{{-- <script src="/admin/admin_24/plugins/summernote/summernote.min.js"></script> --}}
<script src="/admin/admin24/js/quanlydongphuc/quanlynhap.js"></script>
</html>

