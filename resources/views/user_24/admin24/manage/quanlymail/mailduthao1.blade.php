<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @livewireStyles
    @include('user_24.admin24.include.header')
    {{-- <link rel="stylesheet" href="/admin/admin_24/plugins/summernote/summernote.min.css"> --}}
    <style>
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

        {{-- @include('user_24.admin24.include.sidebar') --}}
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
                                <div class="col-12 col-md-12 col-lg-12">
                                    @livewire('click-counter')
                                </div>22222222222222
                                <span id = "result"></span>
                                <div class="col-12 col-md-6 col-lg-5">
                                    <div class="card" style="height: 36rem">
                                        <div class="card-header" style="padding: 5 0;font-weight: bold;">
                                            <button id='test'></button>





                                            {{-- @livewireScripts --}}



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
                                                    {{--  --}}


                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body" style="padding: 5 0; height:520px;">
                                            <div class="row">
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group row" style="margin-bottom: 15px">
                                                        <label for="id_user_check" class="col-sm-2 col-form-label" style="padding-bottom: 0px">Tiêu đề:</label>
                                                        <div class="col-9 col-sm-10">
                                                            <input id ="tieude_maumail" type="text" class="form-control"
                                                                id='settings_name' style="height:28px;  ">
                                                        </div>
                                                        <!-- <div class="col-sm-3"></div> -->
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group row" style="margin-bottom: 15px">
                                                        <label for="id_user_check" class="col-sm-2 col-form-label" style="padding-bottom: 0px">Nội dung:</label>
                                                        <div class="col-9 col-sm-10">

                                                        </div>
                                                        <!-- <div class="col-sm-3"></div> -->
                                                    </div>
                                                </div>
                                                <div style="height:400px " class="card direct-chat-messages col-md-12 col-12">
                                                    <div id = "nd_maumail" style="height: 90px; resize: none;" id="summernote" name="content"></div>
                                                </div>
                                            </div>

                                        </div>
                                        {{-- <div id = "nd_maumail">

                                        </div> --}}
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-7">
                                    <div class="card" style="height:36rem">
                                        <div class="card-header"
                                            style="padding: 5 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                                            <div class="row">
                                                <div class="col-md-4 col-12">
                                                    <select disabled id="find_dot" class="form-control" id="thongtin_taikhoan"
                                                        style="width: 100%;">
                                                        <option>Chọn đợt tuyển sinh</option>
                                                        <option>Chưa có đợt</option>
                                                        <option>Xét tuyển sớm 2024</option>
                                                    </select>
                                                </div>
                                                {{-- <div class="col-md-5 col-12">
                                                    <select class="form-control" id="trangthai_taikhoan" style="width: 100%;">
                                                    </select>
                                                </div> --}}
                                                <div class="col-md-2 col-4">
                                                    <button type="button" id="" onclick="guimail()"
                                                        class="btn btn-block btn-primary btn-xs"><i class="fa-regular fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Lưu
                                                    </button>
                                                </div>
                                                <div class="col-md-2 col-4">
                                                    <button style="color:#fff" class="btn btn-block btn-info btn-xs" type="button" id="" onclick="guimail()">
                                                        <i class="fa-regular fa-paper-plane"></i>&nbsp;&nbsp;&nbsp;Gửi
                                                    </button>
                                                </div>
                                                <div class="col-md-2 col-4">
                                                    <button style="color:#fff" class="btn btn-block btn-secondary btn-xs" type="button" id="" onclick="guimail()">
                                                        <i class="fa-solid fa-file-excel"></i>&nbsp;&nbsp;&nbsp;Xuất danh sách
                                                    </button>
                                                </div>
                                                <div class="col-md-2 col-4">
                                                    <button style="color:#fff" class="btn btn-block btn-secondary btn-xs" type="button" id="" onclick="xemtientrinh()">
                                                        <i class="fa-solid fa-file-excel"></i>&nbsp;&nbsp;&nbsp;Xem tiến trình
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">


                                            <table id = "table_tientrinhguimail"></table>
                                            {{-- <div style="padding-top: 5px;" class="col-12 col-md-12 col-lg-12">
                                                <div style=" padding: 0 20px;" class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input style="height: 13px" name_tt=TTCN tt=1 class="radio_tt" type="radio"
                                                                    name="radio_ttcn">
                                                                <label class="form-check-label">TTCN <i style="color:rgb(10 85 140)" class="fas fa-check"></i></label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input style="height: 13px" name_tt=TTCN tt=0 class="radio_tt" type="radio"
                                                                    name="radio_ttcn" checked="">
                                                                <label class="form-check-label">TTCN <i style="color:red" class="fas fa-times"></i></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input style="height: 13px" name_tt=NV tt=1 class="radio_tt" type="radio"
                                                                    name="radio_nv">
                                                                <label class="form-check-label">Nguyện vọng <i style="color:rgb(10 85 140)" class="fas fa-check"></i></label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input style="height: 13px" name_tt=NV tt=0 class="radio_tt" type="radio"
                                                                    name="radio_nv" checked="">
                                                                <label class="form-check-label">Nguyện vọng <i style="color:red" class="fas fa-times"></i></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input style="height: 13px" name_tt=KQTT tt=1  class="radio_tt" type="radio"
                                                                    name="radio_kqtt">
                                                                <label class="form-check-label">KQTT <i style="color:rgb(10 85 140)" class="fas fa-check"></i></label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input style="height: 13px" name_tt=KQTT tt=0 class="radio_tt" type="radio"
                                                                    name="radio_kqtt" checked="">
                                                                <label class="form-check-label">KQTT <i style="color:red" class="fas fa-times"></i></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input style="height: 13px" name_tt=KĐK tt=1 class="radio_tt" type="radio"
                                                                    name="radio_kdk">
                                                                <label class="form-check-label">KĐK <i style="color:rgb(10 85 140)" class="fas fa-check"></i></label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input style="height: 13px" name_tt=KĐK tt=0 class="radio_tt" type="radio"
                                                                    name="radio_kdk" checked="">
                                                                <label class="form-check-label">KĐK <i style="color:red" class="fas fa-times"></i></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}

                                            <div class="col-12 col-md-12 col-lg-12">
                                                <div class="col-12 col-md-12 col-lg-12 card-body"
                                                    style="padding-bottom: 0px;padding-top: 3px;height:480px"
                                                    id="tt_mail_sinhvien">
                                                    <table class="table table-bordered table-hover table-striped dataTable no-footer dtr-inline" id="list_mail_sv"></table>
                                                    {{-- <table style="padding: 10px" id="example" class="table table-hover  dataTable table-striped no-footer dtr-inline">
                                                        <tfoot>
                                                            <tr>
                                                                <th>Email</th>
                                                                <th>Đợt</th>
                                                                <th>TTCN</th>
                                                                <th>NV</th>
                                                                <th>KQTT</th>
                                                                <th>KĐK</th>
                                                                <th style="padding: 0; text-align: center;"><input type="checkbox"></th>
                                                            </tr>
                                                        </tfoot>
                                                        <thead>
                                                            <tr>
                                                                <th style="padding: 0; text-align: center;"><input type="checkbox"></th>
                                                                <th style="padding: 0; text-align: center;">Email</th>
                                                                <th style="padding: 0; text-align: center;">Đợt</th>
                                                                <th style="padding: 0; text-align: center;">TTCN</th>
                                                                <th style="padding: 0; text-align: center;">NV</th>
                                                                <th style="padding: 0; text-align: center;">KQTT</th>
                                                                <th style="padding: 0; text-align: center;">KĐK</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                                <tr>
                                                                    <td style="padding: 0; text-align: center;"><input type="checkbox"></td>
                                                                    <td>{{$item->email}}</td>
                                                                    <td style="text-align: center">
                                                                        @if ($item->dot == 0)
                                                                            <i style="color:rgb(10 85 140)" class="fas fa-check"></i>
                                                                        @else
                                                                            <i style="color:rgb(10 85 140)" class="fas fa-check"></i>
                                                                        @endif
                                                                    </td>
                                                                    <td style="text-align: center">{{$item->thongtincanhan}}</td>
                                                                    <td style="text-align: center">{{$item->nguyenvong}}</td>
                                                                    <td style="text-align: center">{{$item->kqthanhtoan}}</td>
                                                                    <td style="text-align: center">{{$item->khoadangky}}</td>
                                                                </tr>
                                                            @endforeach

                                                        </tbody>

                                                    </table> --}}
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
        @include('user_24.admin24.include.footer')
        @livewireScripts
    </div>
</body>


<script src="/admin/admin24/js/quanlymail/mailduthao.js"></script>


</html>
