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
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="" class="col-sm-2 col-md-3 col-form-label" style="padding-bottom: 0px">Năm TS:</label>
                                    <div class="col-sm-10 col-md-9">
                                        <select class="form-control" id="phancongduyet_namtuyensinh" onchange="namtuyensinh_phancongduyet()" style="width: 100%;">
                                            <option value = "-1">Chọn năm tuyển sinh</option>
                                            <option value = "1">Năm 2024</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
                                <div class="row">
                                    <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                       <button type="button" time = "" id="phancong_canboduyet" onclick="phancong_canboduyet()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-user-check"></i>&nbsp;&nbsp;Phân công</button>
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <button type="button" id="" onclick="lammoi_phancongduyet()" class="btn btn-block btn-primary btn-xs lammoi"><i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;Làm mới</button>
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <button type="button" id="" onclick="phancong_exel()" class="btn btn-block bg-gradient-secondary btn-xs"><i class="fa-regular fa-file-excel"></i>&nbsp;&nbsp;Danh sách</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <fieldset class="card card-body block-left" >
                                    <legend style="margin-bottom: -12px">Danh sách thí sinh</legend>
                                        <table class="table-bordered table-striped dataTable no-footer dtr-inline" id = "hosodanhsachduyet">
                                        </table>
                                </fieldset>
                            </div>
                            <div class="col-12 col-md-4 ">
                                <fieldset class="card card-body block-right">
                                    <legend style="margin-bottom: -12px">Danh sách cán bộ</legend>
                                    <table class="table-bordered table-striped dataTable no-footer dtr-inline" id = "ds_canbo_duyet">
                                    </table>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-11"></div>
                            <div class="col-1">
                                <div class="style_all_button">
                                    <div class="row">
                                        {{-- <div class="col-6">
                                            <button type="button" time = "" id="phancong" onclick="phancong()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-user-check"></i>&nbsp;&nbsp;Phân công</button>
                                        </div> --}}
                                        {{-- <div class="col-12">
                                            <button type="button" time = "" id="phancong_canboduyet" onclick="phancong_canboduyet()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-user-check"></i>&nbsp;&nbsp;Phân công</button>
                                        </div> --}}
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
<script src="/admin/admin24/js/quanlyhoso/phancongduyethoso.js"></script>
</html>
