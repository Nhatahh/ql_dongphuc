<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('user_24.admin24.include.header')
    <link rel="stylesheet" href="/admin/admin_24/plugins/summernote/summernote.min.css">
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
                <div class="card" style="">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Năm TS:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="phancong_namtuyensinh" onchange="namtuyensinh_phancong()" style="width: 100%;">
                                            <option value = "-1">Chọn năm tuyển sinh</option>
                                            <option value = "1">Năm 2024</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Trạng thái:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="hoso_trangthai" onchange="()" style="width: 100%;">
                                            <option value = "-1">Chọn trạng thái</option>
                                            <option value = "1">Đăng ký mới</option>
                                            <option value = "1">Đã kiểm tra</option>
                                            <option value = "1">Đang cập nhật</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Cán bộ:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="hoso_canbo" onchange="()" style="width: 100%;">
                                        </select>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                                <div class="row">
                                    {{-- <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                        <button type="button" id="" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-magnifying-glass"></i>&nbsp;&nbsp;Tìm kiếm</button>
                                    </div> --}}
                                    <div class="col-6 col-sm-6 col-md-4 col-lg-2 col-xl-4">
                                        <button type="button" id="" onclick="" class="btn btn-block btn-primary btn-xs lammoi"><i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;Làm mới</button>
                                    </div>
                                    <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                        <button type="button" id="" onclick="phancong_exel()" class="btn btn-block bg-gradient-secondary btn-xs"><i class="fa-regular fa-file-excel"></i>&nbsp;&nbsp;Danh sách</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2">
                            </div>
                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                {{-- <div class="col-sm-12"> --}}
                                    <div class="input-group  input-group-sm">
                                        <div class="input-group-prepend">
                                                <input type="radio" trangthai = "1" id="phancongkiemtra" name="radio1" style="margin-top: 2px">
                                            <div class="" style="padding-top: 7px;">
                                                <span class="">&nbsp;&nbsp;&nbsp; Phân công kiểm tra</span>
                                            </div>
                                        </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <div class="input-group-prepend">
                                            <input type="radio" trangthai = "2" id="phancongduyet" name="radio1" style="margin-top: 2px">
                                            <div class="" style="padding-top: 7px;">
                                                <span class="">&nbsp;&nbsp;&nbsp; Phân công duyệt</span>
                                            </div>
                                            </div>
                                    </div>
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <fieldset class="card card-body block-left" >
                                    <legend>Danh sách thí sinh</legend>
                                        <table class="table-bordered table-striped dataTable no-footer dtr-inline" id = "hosodanhsach">
                                        </table>
                                </fieldset>
                            </div>
                            <div class="col-12 col-md-4 ">
                                <fieldset class="card card-body block-right">
                                    <legend>Danh sách cán bộ</legend>
                                    <table class="table-bordered table-striped dataTable no-footer dtr-inline" id = "ds_canbo">
                                    </table>
                                </fieldset>
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
                                            <button type="button" time = "" id="phancong" onclick="phancong()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-user-check"></i>&nbsp;&nbsp;Phân công</button>
                                        </div>
                                        <div class="col-6">
                                            <button type="button" time = "" id="phancong_canboduyet" onclick="phancong_canboduyet()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-user-check"></i>&nbsp;&nbsp;Duyệt</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('user_24.modalevent')
    </div>
    @include('user_24.admin24.include.footer')
</div>
</body>
<script src="/admin/admin24/js/quanlyhoso/phanconghoso.js"></script>
</html>
