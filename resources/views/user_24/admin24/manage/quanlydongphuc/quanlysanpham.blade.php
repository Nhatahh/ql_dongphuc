<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    @include('user_24.admin24.include.header')

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
        .btt_lammoi{
            border-color: #007bff;
            color: #007bff;
       }
       .text_error_input{
            /* color: red;
            font-size: 0.8rem; */
            position: absolute;
            bottom: 0px;
            right: 11px;
            font-size: 8px;
            color: red;
       }
       .text_error_select{
            position: absolute;
            right: 11px;
            font-size: 8px;
            color: red;

       }
       #thongso, #qlsp_ghichu{
        resize: none;  /* Cho phép thay đổi kích thước cả chiều rộng và chiều cao */

       }
       .textarea_upd{
        resize: none;
       }
       .edit_tabledata:focus{
            outline: none;
       }
       /* Đặt màu nền của ô input giống với hàng */
        .edit_tabledata {
            background-color: inherit !important;
            border:none;
            width: 100%;
            height: 23px;
        }

        /* Đảm bảo hiệu ứng hover của ô input giống với hàng */
        .edit_tabledata:hover {
            background-color: inherit !important;
        }
        .ql_sanpham_desktop{
            display: none;
        }
        .ql_sanpham_mobile{
            display: none;
        }
        .select2-custom-border .select2-selection {
            border: none !important; /* Bỏ viền cũ */
        }
        .tyle_model_QR{
            width:100%;
            display: flex;
            justify-content:center;
            align-items: center;
            text-align: center;
        }

        #avatarPreview {
            width: 100%;  /* Chiếm toàn bộ chiều rộng của modal */
            height: 100%; /* Chiếm toàn bộ chiều cao của modal */
            object-fit: contain; /* Đảm bảo ảnh không bị cắt mất khi lấp đầy */
        }

        .img_sanpham{
            width: 150px;
            height: 200px;
            vertical-align: middle;
            margin-bottom: 5px;
            object-fit: contain;
            background-color: #f0f0f0;
            filter: drop-shadow(0 0 5px Silver);
        }

        .img_QRcode_down{
            width: 300px;
            height: 300px;
            vertical-align: middle;
            margin-bottom: 5px;
        }

        .container_modal_QRcodeDown{
            width: 100%;
            height: 300px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin-bottom: 5px;
        }
        .modal_QRcodeDown{
            display: none;
            flex: 2;
            width: 100%;
            height: auto;
            max-width: 600px;
            max-height: 500px;
        }
        .input_capnhat_Anhsp{
            display: inline-block;
            height: 28px;
            border-radius: 5px;
            padding-left: 10px;
            line-height: 28px;
            width: 70%;
            padding-right: 10px;
            color:#007bff;
            cursor: pointer;
            border: 1px solid #007bff
        }


    </style>
    @livewireStyles

</head>

<body class="sidebar-mini sidebar-collapse">

    <div class="wrapper">
        <!-- Preloader -->
        {{-- @include('user_24.admin24.include.preloader') --}}
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
                        <div class="col-12">
                            <div >
                                <div class="row">
                                    <div class="col-12 col-md-3 col-lg-3 ">
                                        <div class="card block-left">
                                            <div class="card-header p-1" style="padding: 0;margin-left: 10px;font-weight: bold;">Thêm Sản phẩm</div>
                                            <div class="card-body p-3 ">
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group row " style="margin-bottom: 12px">
                                                            <label for="id_loai" class="col-sm-4 col-form-label" style="padding-bottom: 0px; padding-bottom: 0px;font-weight: bold;">Loại SP:</label>
                                                            <div class="col-sm-8 load-index">
                                                                <select class="form-control " id="id_loai" style="width: 100%;">
                                                                </select>
                                                                <span class="text_error_select error_select error_validate_select" id = 'error-id_loai'></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group row" style="margin-bottom: 12px">
                                                            <label for="id_nhasanxuat" class="col-sm-4 col-form-label" style="padding-bottom: 0px; padding-bottom: 0px;font-weight: bold;">Nhà SX:</label>
                                                            <div class="col-sm-8 load-index">
                                                                <select class="form-control" id="id_nhasanxuat" style="width: 100%;">
                                                                </select>
                                                                <span class="text_error_select error_select error_validate_select" id = 'error-id_nhasanxuat'></span>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group row" style="margin-bottom: 12px">
                                                            <label for="id_size" class="col-sm-4 col-form-label" style="padding-bottom: 0px; padding-bottom: 0px;font-weight: bold;">Size:</label>
                                                            <div class="col-sm-8 load-index">
                                                                <select class="form-control" id="id_size" style="width: 100%;">


                                                                </select>
                                                                <span class="text_error_select error_select error_validate_select" id = 'error-id_size'></span>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <div class = 'col-md-12 col-12'>
                                                        <div class="form-group row" style="margin-bottom: 12px">
                                                            <label for="file_anhsp_input" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight: bold;">Hình ảnh:</label>
                                                            <div class="custom-file col-sm-8">
                                                                <input type="file" class="custom-file-input"  accept="image/*" id="file_anhsp_input">
                                                                <label class="custom-file-label" id = "file_anhsp" for="file_anhsp_input" style = " height: 28px;margin-left: 7px; border-radius: 5px;">Choose file</label>
                                                                <span class="text_error_input error_validate" id="error-file_anhsp"></span>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group row" style="margin-bottom: 12px">
                                                            <label for="thongso" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight: bold;">Thông số</label>
                                                            <div class="col-sm-8 load-index">
                                                                <textarea rows = "5" class="form-control" name="thongso" id="thongso"></textarea>
                                                                <span class="text_error_input error_validate" id = 'error-thongso'></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group row" style="margin-bottom: 12px">
                                                            <label for="qlsp_ghichu" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight: bold;">Ghi chú</label>
                                                            <div class="col-sm-8 load-index">
                                                                <textarea rows = "5" class="form-control" name="qlsp_ghichu" id="qlsp_ghichu"></textarea>
                                                                <span class="text_error_input error_validate" id = 'error_ghichu'></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 col-12">
                                                        <div class="card-body" style="padding-top: 8px; padding-bottom:0px">
                                                            <div class="row">
                                                                <div class="col-md-6 col-6">
                                                                    <button type="button" id="" onclick="clear_nhapsanpham()" class="btn btn-block btn-xs btt_lammoi load-index"><i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                                                </div>
                                                                <div class="col-md-6 col-6">
                                                                    <button type="button" id="" onclick="btt_themsanpham(event)" class="btn btn-block btn-primary btn-xs load-index"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Thêm</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--  -->
                                    <div class="col-12 col-md-9 col-lg-9 ql_sanpham_desktop">
                                        <div class="card p-4 block-right">
                                            <div class="card-body load-index" id="dssanpham_dot">
                                                <table class="table table-bordered table-hover table-striped dataTable no-footer dtr-inline" id="qlspdssanpham"></table>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="ccol-12 col-md-12 col-lg-12 ql_sanpham_mobile">
                                        @livewire('quanlysanpham')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @include('user_24.modalevent')
        @include('user_24.admin24.include.footer')
    </div>
    @livewireScripts



  <!-- Modal edit sản phẩm mobile -->
    <div class="modal" style="z-index: 10;" id="modal_edit_sanpham">
        <div id = "container_modal_Nhap" style="vertical-align:middle;background-color: rgba(0,0,0,0.5);height: 100%; ">
            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="card card-navy card-outline" style="width:85%; height:auto; padding: 2px; background-color:#fff; margin-top: 5%;margin-left: 7%;">
                        <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                            <div class="row">
                                <div class="col-md-11 col-lg-11 col-11">
                                    <span class="">Sửa sản phẩm</span>
                                </div>
                                <div class="col-md-1 col-lg-1 col-1">
                                    <span class="float-right" style="margin-right: 10px"><i onclick="btt_hide_modal_edit_sanpham()" id='modal_number_go_wish_start_end_close' class="fas fa-times"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="row p-1" id = "form_edit_sanpham">


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <!-- Modal down qr -->
    <div class="modal" id="modal_down_qrcode">
        <div id = "container_down_qrcode" style="vertical-align:middle;background-color: rgba(0,0,0,0.5);height: 100%; ">
            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="card card-navy card-outline" style="width:85%; height:auto; padding: 2px; background-color:#fff; margin-top: 5%;margin-left: 7%;">
                        <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                            <div class="row">
                                <div class="col-md-11 col-lg-11 col-11">
                                    <span> Tải Qrcode</span>
                                </div>
                                <div class="col-md-1 col-lg-1 col-1">
                                    <span class="float-right" style="margin-right: 10px"><i onclick="btt_hide_modal_down_qrcode()" id='modal_number_go_wish_start_end_close' class="fas fa-times"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="row p-1 tyle_model_QR"  id = "imgQR_modal">



                        </div>

                        <div class="row" id = "container_btn_downQR">
                            <div class="col-md-1 col-6"></div>
                            <div class="col-md-2 col-12" style="margin-bottom: 10px">
                                    <button type="button" style="color:#007bff" id="downQR" class=" btt_lammoi btn btn-block btn-xs load-index"><i class="fa-solid fa-download"></i>&nbsp;&nbsp;&nbsp;Tải ảnh</button>
                            </div>
                            <div class="col-md-2 col-6"  style="margin-bottom: 10px" >
                                <button type="button" id="printQR" class="btn btn-block btn-primary btn-xs load-index"><i class="fa-solid fa-print"></i>&nbsp;&nbsp;&nbsp;In Qrcode</button>
                            </div>
                            <div class="col-md-1 col-6"  style="margin-bottom: 10px">
                                <!-- <div class="form-group row col-md-12 col-12" style="margin-bottom: 3px"> -->
                                    <!-- <label for="loaimoi" class="col-sm-3 col-form-label" style="padding-bottom: 0px">Tên loại:</label> -->
                                    <!-- <div class="col-sm-12"> -->
                                        <input type="number" class="form-control" placeholder="SL in" id="copies_QR" id_qr = "" name="" style="height:28px;">
                                    <!-- </div> -->
                                <!-- </div> -->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Cắt ảnh -->
    <div class="modal" id="modal_Cropper">
        <div id="container_down_qrcode" style="vertical-align:middle;background-color: rgba(0,0,0,0.5); height: 100%;">
            <div class="row justify-content-center">
                <div class="col-md-8 col-12">
                    <div class="card card-navy card-outline" style="width:60%;margin-left: 20%; padding: 2px; background-color:#fff; margin-top: 5%;">
                        <div class="card-header" style="padding: 0; margin: 10px; font-weight: bold;">
                            <div class="row">
                                <div class="col-md-11 col-lg-11 col-11">
                                    <span>Ảnh sản phẩm</span>
                                </div>
                                <div class="col-md-1 col-lg-1 col-1">
                                    <span class="float-right" style="margin-right: 10px">
                                        <i onclick="btt_hide_modal_Cropper()" id="modal_number_go_wish_start_end_close" class="fas fa-times"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="right container_modal_QRcodeDown" >
                            <img class = 'modal_QRcodeDown' id="avatarPreview"/>
                        </div>

                        <div class="row justify-content-center" id="container_btn_downQR">
                            <div class="col-md-3 col-8">
                                <button isset = '' id_sanpham = '' type="button" style="color:#007bff" id="cropButton" class="btn btn-block btn-xs btt_lammoi load-index">
                                    <i class="fa-solid fa-download"></i>&nbsp;&nbsp;&nbsp;Xác nhận
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>








</body>
<script type="text/javascript" src="https://unpkg.com/qr-code-styling@1.5.0/lib/qr-code-styling.js"></script>
<script src="/admin/admin24/js/quanlydongphuc/quanlysanpham.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<!-- <script src="path/to/quanlysanpham.js"></script> -->
</html>


