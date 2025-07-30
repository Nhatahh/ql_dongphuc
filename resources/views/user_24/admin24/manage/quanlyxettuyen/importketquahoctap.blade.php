<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('user_24.admin24.include.header')
    <link rel="stylesheet" href="/admin/admin_24/plugins/summernote/summernote.min.css">
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
    </style>
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
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-12 col-md-3 col-lg-3">
                                    <div class="card" style="height: 605px">
                                        <div class="card-body" style="padding-bottom: 0px;padding-top: 3px;height:455px" id="">
                                            {{-- <div class="item-thisinh"> --}}
                                                <div class="item-body" style="margin-top: 10px">
                                                    <div class = 'thongtin'>
                                                        <div class = "left">Import Kết quả học tập:</div>
                                                        <div>
                                                            <form style="display:none" id="submit_ketquahoctap">
                                                                <input type="file" name="ketquahoctap" id="ketquahoctap"/>
                                                            </form>
                                                        </div>
                                                        <i onclick="open_ketquahoctap()" class="fa-solid fa-file-excel"></i>&nbsp;&nbsp;
                                                        <i onclick="import_ketquahoctap()" class="fa fa-upload"></i>&nbsp;&nbsp;
                                                    </div>
                                                    <div class="item-bottom"></div>

                                                </div>

                                            {{-- </div> --}}
                                        </div>
                                    </div>

                                </div>
                                <div class="col-12 col-md-9 col-lg-9">
                                    <div class="card" style="height: 605px">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-md-4 col-12" style="margin-bottom: 5px">
                                                    <div class="form-group row" >
                                                        <label for="import_dotts" class="col-sm-2 col-md-3 col-form-label" style="padding-bottom: 0px;font-weight:bold">Đợt TS:</label>
                                                        <div class="col-sm-10 col-md-9">
                                                            <select class="form-control " id="import_dotts"  style="width:100%;" >
                                                                <option value="0">Chọn đợt tuyển sinh</option>
                                                                <option value="1">Xét tuyển sớm 2024</option>
                                                                <option value="2">Xét tuyển chung 2024</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-12" style="margin-bottom: 5px">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="import_start_id" class="col-sm-5 col-form-label" style="padding-bottom: 0px;font-weight:bold">Từ ID:</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control" id="import_start_id" style="height:28px;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-12" style="margin-bottom: 5px">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="import_end_id" class="col-sm-5 col-form-label" style="padding-bottom: 0px;font-weight:bold">Đến ID:</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control" id="import_end_id" style="height:28px;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12" style="margin-bottom: 5px">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="button"  style="width:100%" onclick="export_ketquahoctap()" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-regular fa-file-excel"></i>&nbsp;&nbsp;Xuất DS</button>
                                                        </div>
                                                        <div class="col-6">
                                                            <button type="button"  style="width:100%" onclick="search_ketquahoctap()" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa fa-search"></i>&nbsp;&nbsp;Tìm kiếm</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-body" style="padding-bottom: 0px;padding-top: 10px;height:455px" id="remove_import_loadketquahoctap">
                                            {{-- <table class="table table-bordered table-hover table-striped dataTable no-footer dtr-inline" id="import_loadketquahoctap"></table> --}}
                                        </div>
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

</body>

<script src="/admin/admin24/js/quanlyxettuyen/importketquahoctap.js"></script>

<!-- summernote -->
{{-- <script src="/admin/admin_24/plugins/summernote/summernote.min.js"></script> --}}

</html>
