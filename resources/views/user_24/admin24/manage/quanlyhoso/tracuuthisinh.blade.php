<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('user_24.admin24.include.header')

    <style>

        .nav-link{
           padding: 0.5rem 0.4rem
        }
        input[type="checkbox"][disabled] {
            filter: hue-rotate(80deg);
        }
        .note-resizebar {
            display: none; /* Ẩn thanh kéo */
        }

        .rotate img {
            transform: rotate(90deg); /* Hoặc bất kỳ góc quay nào bạn muốn */
        }




        .swiper-zoom-container {
            position: relative;
            overflow: hidden;
        }

        .swiper-zoom-container img{
            transition: transform 0.3s ease-in-out;
        }

        /* Styles for the control buttons container */
        .controls {
            position: absolute;
            top: 10px;
            left: 10px;
            display: flex;
            gap: 10px;
            z-index: 10;
        }

        /* Styles for each control button */
        .controls i {
            font-size: 20px;
            color: #333;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 5px;
            border-radius: 50%;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .controls i:hover {
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
        }

        /* Additional styles to enhance the user experience */
        .controls i:active {
            transform: scale(0.9);
        }

        /* Add this if you want a subtle shadow for the buttons */
        .controls i {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* input[type="checkbox"] {
            accent-color: red;
        } */
    </style>
</head>

<body class="sidebar-mini sidebar-collapse">

    <div class="wrapper">
        <!-- Preloader -->
        {{-- <!-- @include('user_24.admin_24.preloader')  --> --}}
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
                            <div class="card" style="min-height: 590px">
                                {{-- Tìm kiếm --}}
                                <div class="card-header">
                                    <div class="row">
                                    </div>
                                </div>
                                {{-- Table --}}
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="row">
                                                <div class="col-12"><span style="font-weight:bold">Đợt tuyển sinh</span>
                                                    <select wire:model="iddotts" class=""  id="tcts_dotts" style="width: 100%;height:28px;border:1px solid #ced4da;border-radius:.25rem">
                                                        {{-- <option value="-1">Chọn đợt xét tuyển</option> --}}
                                                        <option value="0">Chọn đợt tuyển sinh</option>
                                                        <option value="2">Xét tuyển chung 2024 - Đợt 1 (23/08/2024)</option>
                                                        <option value="3">Xét tuyển chung 2024 - Bổ sung đợt 1(27/08/2024)</option>
                                                    {{-- <option value="1">Xét tuyển sớm 2024(01- 08/07/2024)</option> --}}
                                                </select>
                                                </div>
                                                <div class="col-12"><span style="font-weight:bold">Danh sách hồ sơ</span>
                                                    <table class="table table-bordered" id="kiemtra_danhsachhoso">
                                                    </table>
                                                </div>
                                                <div class="col-12" style="border-bottom: 1px solid rgba(221,224,228,0.8)"></div>
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group" style="margin-bottom: 3px">
                                                        <label for="hoten" class="col-sm-12 col-form-label" style="padding-bottom: 0px; font-weight: bold;">Nguyện vọng:</label>
                                                        <div class="col-sm-12 card-body table-responsive" style="height: 160px;padding:0px">
                                                            <table class="table table-hover table-bordered table-striped" id="id_nguyenvong">
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-12">
                                                    <div class="card-footer">
                                                        <div class="row">
                                                            {{-- <div class="col-2"></div> --}}
                                                            <div class="col-12">
                                                                <div class="style_all_button">
                                                                    <div class="row">
                                                                        <div class="col-3">
                                                                            {{-- <button type="button" id="huyhoso" onclick="" class="btn btn-block btn-danger btn-xs"><i class="fa-regular fa-circle-xmark"></i>&nbsp;&nbsp;Hủy hồ sơ</button> --}}
                                                                        </div>
                                                                        {{-- <div class="col-3"> --}}


                                                                            {{-- <button type="button" id="dangky_hoso" onclick="" class="btn btn-block btn-warning btn-xs"><i class="fa-regular fa-registered"></i>&nbsp;&nbsp;Đăng ký</button> --}}


                                                                        {{-- </div> --}}
                                                                        <div class="col-3">
                                                                            <button type="button" id="khoahoso" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-lock"></i>&nbsp;&nbsp;Khóa hồ sơ</button>
                                                                        </div>
                                                                        <div class="col-3">
                                                                            <button type="button" id="inphieurasoat" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-print"></i>&nbsp;&nbsp;In phiếu</button>
                                                                        </div>
                                                                        <div class="col-3">
                                                                            <button type="button" id="duyethoso" onclick="" class="btn btn-block btn-info btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;Duyệt hồ sơ</button>
                                                                        </div>
                                                                        {{-- <div class="col-4">
                                                                            <button type="button" id="" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-graduation-cap"></i>&nbsp;&nbsp;Trúng tuyển</button>
                                                                        </div> --}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4" >
                                            <div class="card card-primary card-outline card-outline-tabs" style="min-height: 570px">
                                                <div class="card-header p-0 border-bottom-0">
                                                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" id="custom-tabs-four-thongtin-tab" data-toggle="pill" href="#custom-tabs-four-thongtin" role="tab" aria-controls="custom-tabs-four-thongtin" aria-selected="true">Thông tin</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="custom-tabs-four-home-tab" data-toggle="pill" href="#truongthpt" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Trường</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Lớp 10</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Lớp 11</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Lớp 12</a>
                                                        </li>
                                                        {{-- <li class="nav-item">
                                                            <a class="nav-link" id="custom-tabs-four-guimail-tab" data-toggle="pill" href="#custom-tabs-four-guimail" role="tab" aria-controls="custom-tabs-four-guimail" aria-selected="false">Gửi mail</a>
                                                        </li> --}}
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="custom-tabs-four-thpt-tab" data-toggle="pill" href="#custom-tabs-four-thpt" role="tab" aria-controls="custom-tabs-four-thpt" aria-selected="false">THPT</a>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a class="nav-link" id="custom-tabs-four-danhmuc_hoso-tab" data-toggle="pill" href="#custom-tabs-four-danhmuc_hoso" role="tab" aria-controls="custom-tabs-four-danhmuc_hoso" aria-selected="false">Hồ sơ</a>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a class="nav-link" id="custom-tabs-four-lichsu-tab" data-toggle="pill" href="#custom-tabs-four-lichsu" role="tab" aria-controls="custom-tabs-four-lichsu" aria-selected="false">Lịch sử</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="card-body" >
                                                    <div class="tab-content" id="custom-tabs-four-tabContent">
                                                        <div class="tab-pane fade active show" id="custom-tabs-four-thongtin" role="tabpanel" aria-labelledby="custom-tabs-four-thongtin-tab">
                                                            <div class="row"  style="margin-bottom: 1px" >
                                                                <div class="col-md-12 col-12">
                                                                    <div class="form-group" style="margin-bottom: 1px">
                                                                        <label for="hoten" class="col-sm-12 col-form-label" style="padding-bottom: 0px; font-weight: normal;">Họ và tên:</label>
                                                                        <div class="col-sm-12">
                                                                            <input type="text" class="form-control thongtincanhan" table = "24_thongtincanhan" id="hoten" value="" style="height:28px">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <div class="form-group" style="margin-bottom: 1px">
                                                                        <label for="hoten" class="col-sm-12 col-form-label" style="padding-bottom: 0px; font-weight: normal;">Điện thoại:</label>
                                                                        <div class="col-sm-12">
                                                                            <input type="text" class="form-control thongtincanhan" table = "24_thongtincanhan" id="dienthoai" value="" style="height:28px">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <div class="form-group" style="margin-bottom: 1px">
                                                                        <label for="hoten" class="col-sm-12 col-form-label" style="padding-bottom: 0px; font-weight: normal;">ĐT phụ huynh:</label>
                                                                        <div class="col-sm-12">
                                                                            <input type="text" class="form-control thongtincanhan" table = "24_thongtincanhan" id="dienthoai_phu" value="" style="height:28px">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <div class="form-group" style="margin-bottom: 1px">
                                                                        <label for="hoten" class="col-sm-12 col-form-label" style="padding-bottom: 0px; font-weight: normal;">Ngày sinh:</label>
                                                                        <div class="col-sm-12">
                                                                            <input type="date" class="form-control thongtincanhan" table = "24_thongtincanhan" placeholder="01/01/2004" id="ngaysinh" value="" style="height:28px">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <div class="form-group" style="margin-bottom: 1px">
                                                                        <label for="hoten" class="col-sm-12 col-form-label thongtincanhan" style="padding-bottom: 0px; font-weight: normal;">Giới tính:</label>
                                                                        <div class="col-sm-12">
                                                                            <div class="input-group  input-group-sm">
                                                                                <div class="input-group-prepend">
                                                                                        <input class="thongtincanhan"  table = "24_thongtincanhan" type="radio" id="gioitinhnam" name="radio1" style="margin-top: 2px">
                                                                                    <div class="" style="padding-top: 7px;">
                                                                                        <span class="">&nbsp;&nbsp;&nbsp; Nam</span>
                                                                                    </div>
                                                                                </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                <div class="input-group-prepend">
                                                                                    <input class="thongtincanhan"  table = "24_thongtincanhan" type="radio" id="gioitinhnu" name="radio1" style="margin-top: 2px">
                                                                                    <div class="" style="padding-top: 7px;">
                                                                                        <span class="">&nbsp;&nbsp;&nbsp; Nữ</span>
                                                                                    </div>
                                                                                    </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 col-12">
                                                                    <div class="form-group" style="margin-bottom: 1px">
                                                                        <label for="hoten" class="col-sm-12 col-form-label thongtincanhan" style="padding-bottom: 0px; font-weight: normal;">Nơi sinh Tỉnh:</label>
                                                                        <div class="col-sm-12">
                                                                            <select class="form-control thongtincanhan" table = "24_thongtincanhan" id="noisinh" onchange="" style="width:100%">

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 col-12">
                                                                    <div class="form-group" style="margin-bottom: 1px">
                                                                        <label for="cccd"  class="col-sm-12 col-form-label" style="padding-bottom: 0px; font-weight: normal;">CMND/CCCD:</label>
                                                                        <div class="col-sm-12">
                                                                                <input type="text" disabled class="form-control thongtincanhan" table = "24_thongtincanhan" id="cccd" value="" style="height:28px">
                                                                            <sup>
                                                                                <p class="float-right validate" id="v_hoten" style="display: none;"></p>
                                                                            </sup>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12 col-12">
                                                                    <div class="form-group" style="margin-bottom: 1px">
                                                                        <label for="hoten" class="col-sm-12 col-form-label" style="padding-bottom: 0px; font-weight: normal;">Email:</label>
                                                                        <div class="col-sm-12">
                                                                                <input disabled type="text" class="form-control" table = "account24s" id="email" value="" style="height:28px">
                                                                            <sup>
                                                                                <p class="float-right validate" id="v_hoten" style="display: none;"></p>
                                                                            </sup>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- <div class="col-md-12 col-12">
                                                                    <div class="form-group" style="margin-bottom: 1px">
                                                                        <label for="hoten" class="col-sm-12 col-form-label" style="padding-bottom: 0px; font-weight: normal;">Email 2:</label>
                                                                        <div class="col-sm-12">
                                                                            <input type="text" class="form-control thongtincanhan" table = "24_thongtincanhan" id="email_phu" value="" style="height:28px">

                                                                        </div>
                                                                    </div>
                                                                </div> --}}


                                                                <div class="col-md-12 col-12">
                                                                    <div class="form-group" style="margin-bottom: 1px">
                                                                        <label for="" class="col-sm-12 col-form-label" style="padding-bottom: 0px; font-weight: normal;">Địa chỉ:</label>
                                                                        <div class="col-sm-12">
                                                                            <input type="text" class="form-control thongtincanhan" table = "24_thongtincanhan" id="diachi" value="" style="height:28px">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 col-12">
                                                                    <div class="form-group" style="margin-bottom: 1px">
                                                                        <label for="" class="col-sm-12 col-form-label" style="padding-bottom: 0px; font-weight: normal;">Ghi chú:</label>
                                                                        <div class="col-sm-12">
                                                                            <input type="text" class="form-control thongtincanhan" table = "24_kiemtrahoso" id="noidungghichu" value="" style="height:28px">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5 col-12">
                                                                    <div class="form-group" style="margin-bottom: 1px;display:flex">
                                                                        <label for="" class="col-sm-4 col-form-label" style="padding-bottom: 0px; font-weight: normal;">Lệ phí:</label>
                                                                        <div class="col-sm-7">
                                                                            <input type="text" disabled onclick="return false;" class="form-control" table = "" id="tonglephixettuyen" value="" style="height:28px;background-color:inherit;border:none;padding-bottom:0px">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                {{-- <div class="col-md-6 col-12" >
                                                                    <div class="form-group" style="margin-bottom: 1px;display:flex">
                                                                        <label class="col-sm-1 col-form-label"><input  class="thongtincanhan"  type="checkbox"  table = "24_kiemtrahoso" id="idghichu" value="" style="height:16px"></label> &nbsp; &nbsp;
                                                                        <div class="col-sm-11">
                                                                            <input disabled onclick="return false;" type="text" class="form-control" table = "" id="" value="Không đủ ĐKXT" style="height:28px;background-color:inherit;border:none;font-weight: normal;">
                                                                        </div>
                                                                    </div>
                                                                </div> --}}

                                                                <div class="col-md-7 col-12">
                                                                    <div class="form-group" style="margin-bottom: 1px;display:flex">
                                                                        <label for="" class="col-sm-5 col-form-label" style="padding-bottom: 0px; font-weight: normal;">Mã GBTT:</label>
                                                                        <div class="col-sm-7">
                                                                            <input type="text" disabled onclick="return false;" class="form-control" table = "" id="maphieu" value="" style="height:28px;background-color:inherit;border:none;padding-bottom:0px">
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="truongthpt">
                                                            <div style="margin-bottom: 10px; border-bottom: 1px solid rgba(221,224,228,0.8)">
                                                                <span style="font-weight: bold;">1. Lớp 10</span>

                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <span for="tinh-lop" class="col-sm-3 col-form-label"
                                                                        style="padding-bottom: 0px">Tỉnh:</span>
                                                                    <div class="col-sm-9">
                                                                        <select class="form-control capnhattinhlop" table ="24_truongthpt" id="tinh-lop10" id_lop='10' onchange="change_tinh10()"
                                                                            style="width: 100%;">

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <span for="truong-lop10" class="col-sm-3 col-form-label"
                                                                        style="padding-bottom: 0px;">Trường:</span>
                                                                    <div class="col-sm-9">
                                                                        <select class="form-control capnhattruonglop1" table ="24_truongthpt" id_lop='10' id_tinh="tinh-lop10" id="truong-lop10"  onchange=""
                                                                            style="width: 100%;">

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <span for="thanhtoan_namtuyensinh" class="col-sm-12 col-form-label"
                                                                        style="padding-bottom: 0px">Khu vực: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <span id="khuvuc-lop10"></span>
                                                                    </span>

                                                                </div>
                                                            </div>
                                                            <div style="margin-bottom: 10px; border-bottom: 1px solid rgba(221,224,228,0.8);">
                                                                <span style="font-weight: bold; ">2. Lớp 11</span>

                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <span for="tinh-lop10" class="col-sm-3 col-form-label"
                                                                        style="padding-bottom: 0px">Tỉnh:</span>
                                                                    <div class="col-sm-9">
                                                                        <select class="form-control capnhattinhlop" id="tinh-lop11" table ="24_truongthpt" id_lop='11' onchange="change_tinh11()"
                                                                            style="width: 100%;">

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <span for="truong-lop11" class="col-sm-3 col-form-label"
                                                                        style="padding-bottom: 0px">Trường:</span>
                                                                    <div class="col-sm-9">
                                                                        <select class="form-control capnhattruonglop1" table ="24_truongthpt" id_lop='11' id_tinh="tinh-lop11" id="truong-lop11" onchange=""
                                                                            style="width: 100%;">

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <span for="thanhtoan_namtuyensinh" class="col-sm-12 col-form-label"
                                                                        style="padding-bottom: 0px">Khu vực: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <span id="khuvuc-lop11"></span>

                                                                    </span>

                                                                    <div class="col-sm-12">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div style="border-bottom: 1px solid rgba(221,224,228,0.8)">
                                                                <span style="font-weight: bold;">3. Lớp 12</span>

                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <span for="tinh-lop12" class="col-sm-3 col-form-label"
                                                                        style="padding-bottom: 0px">Tỉnh:</span>
                                                                    <div class="col-sm-9">
                                                                        <select class="form-control capnhattinhlop" id="tinh-lop12" table ="24_truongthpt" id_lop='12'onchange="change_tinh12()"
                                                                            style="width: 100%;">

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <span for="thanhtoan_namtuyensinh" class="col-sm-3 col-form-label"
                                                                        style="padding-bottom: 0px">Trường:</span>
                                                                    <div class="col-sm-9">
                                                                        <select class="form-control capnhattruonglop1" table ="24_truongthpt" id_lop='12' id_tinh="tinh-lop12" id="truong-lop12" onchange=""
                                                                            style="width: 100%;">

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <span for="thanhtoan_namtuyensinh" class="col-sm-12 col-form-label"
                                                                        style="padding-bottom: 0px">Khu vực: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <span id="khuvuc-lop12"></span>
                                                                    </span>
                                                                    <div class="col-sm-12">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div style="margin-top: 10px;">
                                                                <span style="font-weight: bold;">4. Ưu tiên</span>


                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <span for="thanhtoan_namtuyensinh" class="col-sm-3 col-form-label" style="padding-bottom: 3px">Khu vực:</span>
                                                                    <div class="col-sm-3">
                                                                        <div class="form-group row" style="margin-bottom: 3px">
                                                                            <span for="thanhtoan_namtuyensinh" class="col-sm-12 col-form-label" style="padding-bottom: 3px" id="uutien-khuvuc"></span>
                                                                        </div>
                                                                    </div>
                                                                    <span for="thanhtoan_namtuyensinh" class="col-sm-3 col-form-label " style="padding-bottom: 3px">Năm TN:</span>
                                                                    <div class="col-sm-3">
                                                                        <input type="text" id="namtotnghiep" class="form-control "  value="" style="height:28px">
                                                                    </div>

                                                                    <span for="tinh-lop12" class="col-sm-3 col-form-label" style="padding-bottom: 3px">Đối tượng:</span>
                                                                    <div class="col-sm-9">
                                                                        <select class="form-control" id="uutien-doituong" onchange="capnhatdoituong()" style="width: 100%;"></select>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>
                                                        <div  class="tab-pane fade" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                                            <table class="table table-bordered " id ="diemlop10">
                                                            </table>
                                                        </div>
                                                        <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                                                            <table class="table table-bordered " id = "diemlop11">
                                                            </table>
                                                        </div>
                                                        <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                                                            <table class="table table-bordered " id = "diemlop12">
                                                            </table>
                                                        </div>

                                                        <div class="tab-pane fade" id="custom-tabs-four-thpt" role="tabpanel" aria-labelledby="custom-tabs-four-thpt-tab">

                                                            <table class="table table-bordered " id = "diemthpt">
                                                            </table>

                                                        </div>

                                                        <div class="tab-pane fade" id="custom-tabs-four-danhmuc_hoso" role="tabpanel" aria-labelledby="custom-tabs-four-danhmuc_hoso-tab">
                                                            <div class="row">
                                                                <div id="danhmuc_hoso_tracuutcts" class="col-12">

                                                                </div>
                                                            </div>
                                                        </div>


                                                        {{-- <div class="tab-pane fade" id="custom-tabs-four-guimail" role="tabpanel" aria-labelledby="custom-tabs-four-guimail-tab">
                                                            <div class="row">
                                                                <div class="col-md-12 col-12">
                                                                    <textarea style="min-height: 450px;" id="summernote_kiemtrahoso" name=""></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 col-12">
                                                                <div class="card-footer">
                                                                    <div class="row">
                                                                        <div class="col-6"></div>
                                                                        <div class="col-6">
                                                                            <div class="style_all_button">
                                                                                <div class="row">

                                                                                    <div class="col-12">
                                                                                        <button type="button" id="guimail_kiemtrahoso" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-graduation-cap"></i>&nbsp;&nbsp;Gửi mail</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                        <div class="tab-pane fade" id="custom-tabs-four-lichsu" role="tabpanel" aria-labelledby="custom-tabs-four-lichsu-tab">
                                                            <div style="min-height: 450px;" class="direct-chat-messages" id = "kiemtrahoso_lichsu">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4" >
                                            <div class="swiper tracuuthisinh-loadimg card card-body" style="height: 570px">
                                                <div class="swiper-wrapper" id="tracuuthusinh-loadimage" >

                                                </div>
                                                    <div class="swiper-pagination"></div>
                                                    <div class="swiper-button-prev"></div>
                                                    <div class="swiper-button-next"></div>
                                                    <div class="swiper-scrollbar"></div>
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
        @include('user_24.modalevent')
        @include('user_24.admin24.include.footer')
    </div>
</body>

</html>
<script src="/admin/admin24/js/quanlyhoso/tracuuthisinh.js"></script>
<!-- <script src="/swiper/swiper.js"></script> -->
<!-- <script src="/admin/admin24/js/quanlyhoso/tracuuthisinh2.js"></script>
<script src="/admin/admin24/js/quanlyhoso/tracuuthisinh3.js"></script>
<script src="/admin/admin24/js/quanlyhoso/tracuuthisinh4.js"></script> -->
<script src="/admin/admin24/js/plugins/summernote/summernote.min.js"></script>

