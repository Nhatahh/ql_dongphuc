<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('user_24.admin24.include.header')
    {{-- <link rel="stylesheet" href="/admin/admin24/js/plugins/summernote/summernote.min.css"> --}}
    <style>


        /* #summernote .note-editable {
            max-height: 300px;
            overflow-y: hidden;

        } */
        .note-resizebar {
        display: none; /* Ẩn thanh kéo */
        }

        .selected {
            background-color: #007bff;
            color: #fff;
        }

        th>select {
            width: 90%
        }
        /* div.dataTables_scrollHead table.dataTable{
            margin-bottom: -11px !important;
        } */
    </style>


</head>

<body class="sidebar-mini sidebar-collapse">
    <div class="wrapper">
        <!-- Preloader -->
        <!-- @include('user_24.admin24.include.preloader')  -->
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
            <section class="content">
                <div class="container-fluid">
                    @include('user_24.admin24.include.contentheader')
                    <div class="row">
                        <div class="col-md-12">
                            <div id="loadpage"></div>
                            <div class="modal" id="id_manhinh_tam"></div>
                            <div class="row">
                                <div class="col-12 col-md-5 col-lg-5 card " style="min-height:570px">
                                    <div>
                                        <div class="card-header" style="padding: 0;margin-left:10px;font-weight: bold;">
                                            Danh sách Mail
                                        </div>
                                        <div class="card-body" style="padding-bottom: 0px;padding-top: 3px;height: 400px;" id="list_model_mail">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-7 col-lg-7">
                                    <div class="card" style="min-height: 570px ">
                                        <div class="card-header" style="padding: 0;margin-left:10px;font-weight: bold;">Nội dung Mail</div>
                                        <div class="card-body" style="">
                                            <div class="row">
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group row" style="margin-bottom: 5px">
                                                        <label for="id_user_check" class="col-3 col-sm-2 col-form-label" style="padding-bottom: 0px">Tiêu đề:</label>
                                                        <div class="col-9 col-sm-10">
                                                            <input id="tieude_mail" type="text" class="form-control" style="height:28px;  ">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group row" style="margin-bottom: 5px">
                                                        <label for="id_user_check" class="col-3 col-sm-2 col-form-label" style="padding-bottom: 0px">Tên email:</label>
                                                        <div class="col-9 col-sm-10">
                                                            <input id="ten_mail" type="text" class="form-control" style="height:28px; ">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-12">
                                                    <textarea style="min-height: 450px;" id="summernote" name=""></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div style="margin-bottom: 10px" class="tool_mail">
                                            <div class="row">
                                                <div class="col-md-6 col-6"></div>
                                                <div class="col-md-2 col-2">
                                                    <button type="button" id="add_mail" id_mail="" onclick="modal_mail()" class="btn btn-block btn-primary btn-xs "><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Thêm
                                                    </button>
                                                </div>
                                                <div class="col-md-2 col-2">
                                                    <button type="button" id="update_mail" id_mail="" onclick="update_mail()" class="btn btn-block btn-primary btn-xs "><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Cập nhật
                                                    </button>
                                                </div>
                                                <div class="col-md-2 col-2">
                                                    <button style="background-color: #fff; color:#007bff;" type="button" id="refresh_mail" id_mail="" onclick="refresh_mail()" class="btn btn-block btn-primary btn-xs "><i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;&nbsp;Làm mới
                                                    </button>
                                                </div>
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


        <div style="" class="modal" id="themmail">
            <div style="vertical-align:middle;padding-top:3%;background-color: rgba(0,0,0,0.5);height: 100%;">
                <div class="row container_showtientrinh">
                    <div class="col-md-1 col-12">
                    </div>
                    <div class="col-md-10 col-12">
                        <div class="card ">
                            <div class="card-header" style="padding: 0;font-weight: bold;border:none;background-color:#fff">
                                <div class="row">
                                    <div style="" class="col-md-11 col-lg-11 col-11">
                                        {{-- <span class="">Thêm mail</span> --}}
                                    </div>
                                    <div class="col-md-1 col-lg-1 col-1">
                                        <span class="float-right" style="margin-right: 10px"><i onclick="close_modal_them_mail()" id='modal_number_go_wish_start_end_close' class="fas fa-times"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="" style="width:auto; height:600px; padding: 10px;background-color:#fff;">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row" style="margin-bottom: 5px">
                                            <label for="id_user_check" class="col-1 col-sm-1 col-form-label" style="padding-bottom: 0px">Tiêu đề:</label>
                                            <div class="col-11 col-sm-11">
                                                <input id="them_tieude_mail" type="text" class="form-control" style="height:28px;  ">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <label for="id_user_check" class="col-1 col-sm-1 col-form-label" style="padding-bottom: 0px">Tên email:</label>
                                            <div style="margin-bottom: 10px;" class="col-11 col-sm-11">
                                                <input id="them_ten_mail" type="text" class="form-control" style="height:28px;  ">
                                            </div>
                                        </div>
                                    </div>
                                    <div style="height:450px" class="col-12">
                                        <textarea style="height: 100%; resize: none;" id="them_summernote" name=""></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-10 col-10">
                                            <div class="form-group row" style="margin-bottom: 5px">
                                                <label for="id_user_check" class="col-1 col-sm-1 col-form-label" style="padding-bottom: 0px">Email:</label>
                                                <div class="col-11 col-sm-11">
                                                    <input id="mail_thu" type="text" class="form-control" style="height:28px;  ">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-1">
                                            <button type="button" id="gui_thu" id_mail="" onclick="gui_thu()" class="btn btn-block btn-primary btn-xs "><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Gửi thử</button>
                                        </div>
                                        <div class="col-md-1 col-1">
                                            <button type="button" id="add_mail" id_mail="" onclick="add_mail()" class="btn btn-block btn-primary btn-xs "><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Thêm</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-1 col-12">
                    </div>
                </div>
            </div>

        </div>






        @include('user_24.modalevent')
        @include('user_24.admin24.include.footer')
    </div>
</body>
<script src="/admin/admin24/js/nguoidungchucnang/chucnang.js"></script>
<script src="/admin/admin24/js/quanlymail/mail.js"></script>
<script src="/admin/admin24/js/main.js"></script>
<!-- summernote -->
{{-- <script src="/admin/admin24/js/plugins/summernote/summernote.min.js"></script> --}}

</html>
