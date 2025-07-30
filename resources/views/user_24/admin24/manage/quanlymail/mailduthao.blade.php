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
        @include('user_24.admin24.include.preloader')
        @include('user_24.admin24.include.navbar')
        @include('user_24.admin24.include.sidebar')
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    @include('user_24.admin24.include.contentheader')
                    <div class="row">
                        <div class="col-md-12">
                            {{-- <div id="loadpage"></div>                          --}}
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-5">
                                    <div class="card" style="height: 605px">
                                        <div class="card-header" style="padding: 5 0;font-weight: bold;">
                                            <div class="row">
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="id_user_check" class="col-sm-2 col-form-label" style="padding-bottom: 0px">Mail mẫu:</label>
                                                        <div class="col-sm-10">
                                                            <select onchange="tim_maumail()" id="chonmail" class="form-control" id="thongtin_taikhoan" style="width: 100%;">
                                                                <option value="0">Chọn mẫu mail</option>
                                                                @foreach($mail as $row)
                                                                    <option value="{{$row->id}}"> {{$row->ten_mail}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body" style="padding: 5 0; height:520px;">
                                            <div class="row">
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group row" style="margin-bottom: 15px">
                                                        <label for="id_user_check" class="col-sm-2 col-form-label" style="padding-bottom: 0px">Tiêu đề:</label>
                                                        <div class="col-9 col-sm-10">
                                                            <input style="background-color: #fff; height: 28px" disabled id ="tieude_maumail" type="text" class="form-control"
                                                                id='settings_name' style="height:28px;  ">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group row" style="margin-bottom: 15px">
                                                        <label for="id_user_check" class="col-sm-2 col-form-label" style="padding-bottom: 0px">Nội dung:</label>
                                                        <div class="col-9 col-sm-10">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="height:395px " class="card direct-chat-messages col-md-12 col-12">
                                                    <div id = "nd_maumail" style="height: 90px; resize: none;" id="summernote" name="content"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-7">
                                    <div class="card" style="height: 605px">
                                        <div class="card-header" style="padding: 5 0;margin-left: 10px;margin-top: 3px;">
                                            <div class="row">
                                                <div class="col-md-4 col-12">
                                                    <div class="row">
                                                        <div class="col-md-12 col-12" style="margin-bottom: 5px">
                                                            <div class="form-group row" >
                                                                <label for="" class="col-sm-2 col-md-3 col-form-label" style="padding-bottom: 0px">Đợt TS:</label>
                                                                <div class="col-sm-10 col-md-9">
                                                                    <select class="form-control mail_dieukien " id="find_dot"  style="width:100%;" >
                                                                        <option value="0">Chọn đợt tuyển sinh</option>
                                                                        <option value="1">Xét tuyển sớm 2024</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="row">
                                                        <div class="col-md-12 col-12" style="margin-bottom: 5px">
                                                            <div class="form-group row" >
                                                                <label for="" class="col-sm-12 col-md-4 col-form-label" style="padding-bottom: 0px">Đợt mail:</label>
                                                                <div class="col-sm-12 col-md-8">
                                                                    <select class="form-control mail_dieukien " id="find_dotmail"  style="width:100%;" >
                                                                        <option value="0">Chọn đợt gửi mail</option>
                                                                        <option value="1">2024_Thông báo DK xét tuyển</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-4">
                                                    <button type="button" id="themds_guimail" onclick="themds_guimail(6)" id_mail="" id_nguoigui = "{{Auth::guard('loginadmin')->user()->id}}"
                                                        class="btn btn-block btn-primary btn-xs"><i class="fa-regular fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Thêm vào DS
                                                    </button>
                                                </div>
                                                <div class="col-md-2 col-4">
                                                    <button style="color:#fff" id="btt_xemtientrinh"class="btn btn-block btn-info btn-xs" type="button" id="" onclick="xemtientrinh()">
                                                        <i class="fa-regular fa-paper-plane"></i>&nbsp;&nbsp;&nbsp;Xem tiến trình
                                                    </button>
                                                </div>
                                                <div class="col-md-3 col-12" style="margin-bottom: 5px">
                                                    <div class="form-group" >
                                                        <label for="" class="col-form-label" style="padding-bottom: 0px">Đăng ký xét tuyển</label>
                                                        <div class="">
                                                            <div class="form-check"  >
                                                                <input type="radio" name = "mail_dangkyxettuyen" style="height: 13px" class="form-check-input  mail_dieukien" id="checked_dangkyxettuyen">
                                                                <label class="form-check-label"  for="exampleCheck1">Đã Đăng ký</label>
                                                            </div>

                                                            <div class="form-check" >
                                                                <input type="radio" name = "mail_dangkyxettuyen"  style="height: 13px" class="form-check-input  mail_dieukien" id="nochecked_dangkyxettuyen">
                                                                <label class="form-check-label" for="exampleCheck1">Chưa đăng ký</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12" style="margin-bottom: 5px">
                                                    <div class="form-group" >
                                                        <label for="" class="col-form-label" style="padding-bottom: 0px">Lệ phí xét tuyển</label>
                                                        <div class="">
                                                            <div class="form-check"  >
                                                                <input type="checkbox" style="height: 13px" class="form-check-input mail_dieukien" checked id="checked_lephixettuyen">
                                                                <label class="form-check-label"  for="exampleCheck1">Đã thanh toán</label>
                                                            </div>

                                                            <div class="form-check" >
                                                                <input type="checkbox" style="height: 13px" class="form-check-input mail_dieukien" checked id="nochecked_lephixettuyen">
                                                                <label class="form-check-label"  for="exampleCheck1">Chưa thanh toán</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12" style="margin-bottom: 5px">
                                                    <div class="form-group" >
                                                        <label for="" class="col-form-label" style="padding-bottom: 0px">Trúng tuyển</label>
                                                        <div class="">
                                                            <div class="form-check"  >
                                                                <input type="checkbox" style="height: 13px" disabled checked class="form-check-input" id="">
                                                                <label class="form-check-label"  for="">Đạt</label>
                                                            </div>

                                                            <div class="form-check" >
                                                                <input type="checkbox" style="height: 13px" disabled  checked class="form-check-input" id="">
                                                                <label class="form-check-label"  for="">Chưa đạt</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12" style="margin-bottom: 5px">
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div id="thanhtientrinh" class="float-right container_Loader_tientrinh">
                                                        <span style="color: #8a8c8f">Không có tiến trình</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            <div class="card-body" style="padding-bottom: 0px;padding-top: 3px;height:455px" id="tt_mail_sinhvien">
                                                <table class="table table-bordered table-hover table-striped dataTable no-footer dtr-inline" id="listmailsv"></table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @include('user_24.admin24.include.footer')
    </div>
    <div style=" font-family: Consolas, monospace; font-style: italic" class="modal" id="model_tientrinh">
        <div style="vertical-align:middle;background-color: rgba(0,0,0);height: 100%;">
            <div class="row container_showtientrinh" style="height: 100%;">
                <div class="col-md-12 col-12">
                    <div class="card card-navy card-outline" style="width:auto; height:90%; padding: 2px; margin: 0;background-color:#000; color:#fff">
                        <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                            <div class="row">
                                <div style="text-align: center" class="col-md-11 col-lg-11 col-11">
                                    <span class="">Tiến trình gửi mail</span>
                                </div>
                                <div class="col-md-1 col-lg-1 col-1">
                                    <span class="float-right" style="margin-right: 10px"><i onclick="close_model_tientrinh()" id='modal_number_go_wish_start_end_close' class="fas fa-times"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="card-body card direct-chat-messages"   style="height:100%; padding-bottom: 0px;padding-top: 3px; background-color:#000; color:#fff">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="col-12 col-md-12 col-lg-12 card-body"
                                        style="padding-bottom: 0px;padding-top: 3px;height:480px" id="tientrinh_container">
                                        <table style="width: 100%; background-color:#000; color:#fff; border:none" class="table  " id="tb_tientrinh">

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-10"></div>
                                <div class="col-2">
                                    <div class="style_all_button">
                                        <div class="row">
                                            <div class="col-6">
                                                <button  style="color: white;border:1px solid white" type="button" id="btt_guimail" onclick="guimai12(6)" id_mail="" id_nguoigui = "{{Auth::guard('loginbygoogles')->id()}}"
                                                    class="btn btn-block btn-xs"><i class="fa-regular fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Gửi mail
                                                </button>
                                            </div>
                                            <div class="col-6">
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
    <div class = "modal" id="modal_event_guimail">
        <div style="text-align:center; background-color: rgba(0,0,0,0.4);height: 100%;">
            <span class="loader1" style="margin-top: 200px;color:white">

            </span>
        </div>
    </div>

</body>
<script src="/admin/admin24/js/quanlymail/mailduthao.js"></script>

<!-- summernote -->
{{-- <script src="/admin/admin_24/plugins/summernote/summernote.min.js"></script> --}}

</html>
