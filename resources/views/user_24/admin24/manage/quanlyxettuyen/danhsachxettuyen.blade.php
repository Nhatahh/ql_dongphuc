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

        #tb_tientrinh{
            border: none
        }
        #tb_tientrinh td{
            border: none
        }
        .note-editable {
            max-height: 280px;
            overflow-y: auto;
            /* Tự động hiển thị thanh cuộn nếu nội dung vượt quá chiều cao tối đa */
        }

        .selected {
            background-color: #007bff;
            color: #fff;
        }
        th > select{
            width: 90%
        }

        /* loader_tientrinh tiến trình */
        .container_Loader_tientrinh{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .loader_tientrinh {
        position: relative;
        width: 1rem;
        height: 1rem;
        border-radius: 10px;
        }

        .loader_tientrinh div {
        width: 8%;
        height: 24%;
        background: rgb(173, 173, 173);
        position: absolute;
        left: 50%;
        top: 30%;
        opacity: 0;
        border-radius: 50px;
        box-shadow: 0 0 3px rgba(34, 34, 34, 0.2);
        animation: fade458 1s linear infinite;
        }

        @keyframes fade458 {
        from {
            opacity: 1;
        }

        to {
            opacity: 0.25;
        }
        }

        .loader_tientrinh .bar1 {
        transform: rotate(0deg) translate(0, -130%);
        animation-delay: 0s;
        }

        .loader_tientrinh .bar2 {
        transform: rotate(30deg) translate(0, -130%);
        animation-delay: -1.1s;
        }

        .loader_tientrinh .bar3 {
        transform: rotate(60deg) translate(0, -130%);
        animation-delay: -1s;
        }

        .loader_tientrinh .bar4 {
        transform: rotate(90deg) translate(0, -130%);
        animation-delay: -0.9s;
        }

        .loader_tientrinh .bar5 {
        transform: rotate(120deg) translate(0, -130%);
        animation-delay: -0.8s;
        }

        .loader_tientrinh .bar6 {
        transform: rotate(150deg) translate(0, -130%);
        animation-delay: -0.7s;
        }

        .loader_tientrinh .bar7 {
        transform: rotate(180deg) translate(0, -130%);
        animation-delay: -0.6s;
        }

        .loader_tientrinh .bar8 {
        transform: rotate(210deg) translate(0, -130%);
        animation-delay: -0.5s;
        }

        .loader_tientrinh .bar9 {
        transform: rotate(240deg) translate(0, -130%);
        animation-delay: -0.4s;
        }

        .loader_tientrinh .bar10 {
        transform: rotate(270deg) translate(0, -130%);
        animation-delay: -0.3s;
        }

        .loader_tientrinh .bar11 {
        transform: rotate(300deg) translate(0, -130%);
        animation-delay: -0.2s;
        }

        .loader_tientrinh .bar12 {
        transform: rotate(330deg) translate(0, -130%);
        animation-delay: -0.1s;
        }
        /* Loader chờ */
        .loader_cho {
            width: 100%;
            /* bottom: 0; */
            margin-top:13px;
            height: 0.2rem;
            -webkit-mask: radial-gradient(circle closest-side, #fff 50%, #fff0) left/1% 100%;
            background: linear-gradient(#fff 0 0) left/0% 100% no-repeat #000; /* Thay đổi màu linear gradient từ #0000 sang #fff và ngược lại */
            animation: l17 2s infinite steps(50);
        }

        @keyframes l17 {
            100% { background-size: 100% 70%; }
        }

        /* Loader xong */
        .loader_xong {
            width: 100%;
            /* bottom: 0; */
            margin-top:13px;
            height: 0.2rem;
            -webkit-mask: radial-gradient(circle closest-side, #fff 50%, #fff0) left/1% 100%;
            background: linear-gradient(#fff 0 0) left/0% 100% no-repeat #000; /* Thay đổi màu linear gradient từ #0000 sang #fff và ngược lại */
            animation: none; /* Tắt animation */
            background-size: 100% 70%; /* Định kích thước của gradient */
        }


        /* div.dataTables_scrollHead table.dataTable{
            margin-bottom: -11px !important;
        } */
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
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="card" style="height: 605px">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-md-3 col-12" style="margin-bottom: 5px">
                                                    <div class="form-group row" >
                                                        <label for="" class="col-sm-2 col-md-3 col-form-label" style="padding-bottom: 0px">Đợt TS:</label>
                                                        <div class="col-sm-10 col-md-9">
                                                            <select class="form-control " id="dsxt_dot"  style="width:100%;" >
                                                                <option value="-1">Chọn đợt tuyển sinh</option>
                                                                <option value="1">Xét tuyển sớm 2024</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12" style="margin-bottom: 5px">
                                                    <div class="form-group row" >
                                                        <label for="" class="col-sm-2 col-md-3 col-form-label" style="padding-bottom: 0px">Trạng thái</label>
                                                        <div class="col-sm-10 col-md-9">
                                                            <select class="form-control" id="dsxt_luu"  style="width:100%;" >
                                                                <option value="-1">Chọn trạng thái</option>
                                                                <option value="0">Lưu nguyện vọng</option>
                                                                <option value="1">Đăng ký mới</option>
                                                                <option value="2">Mở Cập nhật</option>
                                                                <option value="3">Đăng ký lại</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-md-3 col-12" style="margin-bottom: 5px">
                                                    <div class="form-group row" >
                                                        <label for="" class="col-sm-2 col-md-3 col-form-label" style="padding-bottom: 0px">Đăng ký:</label>
                                                        <div class="col-sm-10 col-md-9">
                                                            <select class="form-control" id="dsxt_dangky"  style="width:100%;" >
                                                                <option value="0">Chọn trạng thái</option>
                                                                <option value="1">Đã đăng ký</option>
                                                                <option value="1">Chưa đăng ký</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                                <div class="col-md-3 col-12" style="margin-bottom: 5px">
                                                    <div class="form-group row" >
                                                        <label for="" class="col-sm-2 col-md-3 col-form-label" style="padding-bottom: 0px">Khóa HS:</label>
                                                        <div class="col-sm-10 col-md-9">
                                                            <select class="form-control" id="dsxt_khoa"  style="width:100%;" >
                                                                <option value="-1">Chọn trạng thái</option>
                                                                <option value="1">Đã khóa</option>
                                                                <option value="0">Chưa khóa</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12" style="margin-bottom: 5px">
                                                    <div class="form-group row" >
                                                        <label for="" class="col-sm-2 col-md-3 col-form-label" style="padding-bottom: 0px">Duyệt HS:</label>
                                                        <div class="col-sm-10 col-md-9">
                                                            <select class="form-control" id="dsxt_duyet"  style="width:100%;" >
                                                                <option value="-1">Chọn trạng thái</option>
                                                                <option value="1">Đã duyệt</option>
                                                                <option value="0">Chưa duyệt</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12" style="margin-bottom: 5px">
                                                    <div class="form-group row" >
                                                        <label for="" class="col-sm-2 col-md-3 col-form-label" style="padding-bottom: 0px">Ng Vọng:</label>
                                                        <div class="col-sm-10 col-md-9">
                                                            <select class="form-control" id="dsxt_nguyenvong"  style="width:100%;" >
                                                                <option value="-1">Chọn Nguyện vọng</option>
                                                                <option value="1">Nguyện vọng 1</option>
                                                                <option value="2">Nguyện vọng 2</option>
                                                                <option value="3">Nguyện vọng 3</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-9 col-12" style="margin-bottom: 5px">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="style_all_button">
                                                                <div class="row">
                                                                    <div class="col-2">
                                                                        <button type="button" id="timdanhsachxetuyentuyentheodot" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-magnifying-glass"></i>&nbsp;&nbsp;Tìm kiếm</button>
                                                                    </div>
                                                                    <div class="col-2">
                                                                        <button type="button" id="duyetdanhsachxetuyentuyentheodot" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;Duyệt NV</button>
                                                                    </div>
                                                                    <div class="col-2">
                                                                        <button type="button" id="duyethoso" onclick="" class="btn btn-block btn-secondary btn-xs"><i class="fa-solid fa-chart-simple"></i>&nbsp;&nbsp;Thống kê</button>
                                                                    </div>
                                                                    <div class="col-2">
                                                                        <button type="button" id="xuatexceldanhsachxettuyen" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-regular fa-file-excel"></i>&nbsp;&nbsp;Excel</button>
                                                                    </div>
                                                                    <div class="col-2">
                                                                        <button type="button" id="" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-regular fa-file-pdf"></i></i>&nbsp;&nbsp;PDF</button>
                                                                    </div>
                                                                    <div class="col-2">
                                                                        <button type="button" id="resetsachxetuyentuyentheodot" style="background-color: #fff; color:#007bff;" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-arrows-rotate"></i>&nbsp;&nbsp;Reset</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-3"></div> --}}
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                        <div class="card-body" style="padding-bottom: 0px;padding-top: 3px;height:455px" id="">
                                            <table class="table table-bordered table-hover table-striped dataTable no-footer dtr-inline" id="listnguyenvong"></table>
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

<script src="/admin/admin24/js/quanlyxettuyen/danhsachxettuyen.js"></script>

<!-- summernote -->
{{-- <script src="/admin/admin_24/plugins/summernote/summernote.min.js"></script> --}}

</html>
