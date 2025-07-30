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

        .rotated {
            transform: rotate(90deg); /* Hoặc bất kỳ góc quay nào bạn muốn */
        }

            #aaaa {
        position: absolute;
        transition: opacity 0.3s ease; /* Thêm transition cho hiệu ứng mờ mờ */
        }
        #aaaa.dragging {
        opacity: 0.7; /* Độ trong suốt của hình ảnh khi đang kéo */
        }

        .swiper-container {
    width: 100%;
    height: 100%;
}

.swiper-container {
    width: 100%;
    height: 100%;
}

.swiper-slide {
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
}

.image-container {
    position: relative;
    overflow: hidden;
    width: 100%;
    height: 100%;
}

img {
    max-width: none;
    max-height: none;
    cursor: pointer;
    transition: transform 0.3s;
    position: absolute;
}

.controls {
    position: absolute;
    top: 10px;
    left: 10px;
    display: flex;
    gap: 10px;
}

.controls i {
    cursor: pointer;
    font-size: 20px;
    background: rgba(255, 255, 255, 0.8);
    padding: 5px;
    border-radius: 5px;
    transition: background 0.3s;
}

.controls i:hover {
    background: rgba(255, 255, 255, 1);
}

</style>


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
                                                <div class="col-12"><span style="font-weight:bold">Danh sách hồ sơ</span>
                                                    <table class="table table-bordered" id="kiemtra_danhsachhoso">
                                                    </table>
                                                </div>
                                                <div class="col-12" style="border-bottom: 1px solid rgba(221,224,228,0.8)"></div>
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group" style="margin-bottom: 3px">
                                                        <label for="hoten" class="col-sm-12 col-form-label" style="padding-bottom: 0px; font-weight: bold;">Nguyện vọng:</label>
                                                        <div class="col-sm-12 card-body table-responsive p-0" style="height: 160px">
                                                            <table class="table table-hover table-bordered table-head-fixed table-striped  text-nowrap" id="id_nguyenvong">
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-12">
                                                    <div class="card-footer">
                                                        <div class="row">
                                                            <div class="col-2"></div>
                                                            <div class="col-10">
                                                                <div class="style_all_button">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <button type="button" id="khoahoso" onclick="" class="btn btn-block btn-secondary btn-xs"><i class="fa-solid fa-lock"></i>&nbsp;&nbsp;Khóa hồ sơ</button>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <button type="button" id="duyethoso" onclick="" class="btn btn-block btn-info btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;Duyệt hồ sơ</button>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <button type="button" id="" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-graduation-cap"></i>&nbsp;&nbsp;Trúng tuyển</button>
                                                                        </div>
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
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="custom-tabs-four-guimail-tab" data-toggle="pill" href="#custom-tabs-four-guimail" role="tab" aria-controls="custom-tabs-four-guimail" aria-selected="false">Gửi mail</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="custom-tabs-four-lichsu-tab" data-toggle="pill" href="#custom-tabs-four-lichsu" role="tab" aria-controls="custom-tabs-four-lichsu" aria-selected="false">Lịch sử</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="card-body" >
                                                    <div class="tab-content" id="custom-tabs-four-tabContent">
                                                        <div class="tab-pane fade active show" id="custom-tabs-four-thongtin" role="tabpanel" aria-labelledby="custom-tabs-four-thongtin-tab">
                                                            <div class="row">
                                                                <div class="col-md-12 col-12">
                                                                    <div class="form-group" style="margin-bottom: 3px">
                                                                        <label for="hoten" class="col-sm-12 col-form-label" style="padding-bottom: 0px; font-weight: normal;">Họ và tên:</label>
                                                                        <div class="col-sm-12">
                                                                            <input type="text" class="form-control thongtincanhan" table = "24_thongtincanhan" id="hoten" value="" style="height:28px">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <div class="form-group" style="margin-bottom: 3px">
                                                                        <label for="hoten" class="col-sm-12 col-form-label" style="padding-bottom: 0px; font-weight: normal;">Điện thoại:</label>
                                                                        <div class="col-sm-12">
                                                                            <input type="text" class="form-control thongtincanhan" table = "24_thongtincanhan" id="dienthoai" value="" style="height:28px">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <div class="form-group" style="margin-bottom: 3px">
                                                                        <label for="hoten" class="col-sm-12 col-form-label" style="padding-bottom: 0px; font-weight: normal;">ĐT phụ huynh:</label>
                                                                        <div class="col-sm-12">
                                                                            <input type="text" class="form-control thongtincanhan" table = "24_thongtincanhan" id="dienthoai_phu" value="" style="height:28px">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <div class="form-group" style="margin-bottom: 3px">
                                                                        <label for="hoten" class="col-sm-12 col-form-label" style="padding-bottom: 0px; font-weight: normal;">Ngày sinh:</label>
                                                                        <div class="col-sm-12">
                                                                            <input type="date" class="form-control thongtincanhan" table = "24_thongtincanhan" placeholder="01/01/2004" id="ngaysinh" value="" style="height:28px">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <div class="form-group" style="margin-bottom: 3px">
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
                                                                    <div class="form-group" style="margin-bottom: 3px">
                                                                        <label for="hoten" class="col-sm-12 col-form-label thongtincanhan" style="padding-bottom: 0px; font-weight: normal;">Nơi sinh Tỉnh:</label>
                                                                        <div class="col-sm-12">
                                                                            <select class="form-control thongtincanhan" table = "24_thongtincanhan" id="noisinh" onchange="" style="width:100%">

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 col-12">
                                                                    <div class="form-group" style="margin-bottom: 3px">
                                                                        <label for="hoten" class="col-sm-12 col-form-label" style="padding-bottom: 0px; font-weight: normal;">CMND/CCCD:</label>
                                                                        <div class="col-sm-12">
                                                                                <input type="text" class="form-control thongtincanhan" table = "24_thongtincanhan" id="cccd" value="" style="height:28px">
                                                                            <sup>
                                                                                <p class="float-right validate" id="v_hoten" style="display: none;"></p>
                                                                            </sup>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12 col-12">
                                                                    <div class="form-group" style="margin-bottom: 3px">
                                                                        <label for="hoten" class="col-sm-12 col-form-label" style="padding-bottom: 0px; font-weight: normal;">Email:</label>
                                                                        <div class="col-sm-12">
                                                                                <input disabled type="text" class="form-control" table = "account24s" id="email" value="" style="height:28px">
                                                                            <sup>
                                                                                <p class="float-right validate" id="v_hoten" style="display: none;"></p>
                                                                            </sup>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 col-12">
                                                                    <div class="form-group" style="margin-bottom: 3px">
                                                                        <label for="hoten" class="col-sm-12 col-form-label" style="padding-bottom: 0px; font-weight: normal;">Email 2:</label>
                                                                        <div class="col-sm-12">
                                                                            <input type="text" class="form-control thongtincanhan" table = "24_thongtincanhan" id="email_phu" value="" style="height:28px">

                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-12 col-12">
                                                                    <div class="form-group" style="margin-bottom: 3px">
                                                                        <label for="hoten" class="col-sm-12 col-form-label" style="padding-bottom: 0px; font-weight: normal;">Địa chỉ:</label>
                                                                        <div class="col-sm-12">
                                                                            <input type="text" class="form-control thongtincanhan" table = "24_thongtincanhan" id="diachi" value="" style="height:28px">
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
                                                        <div class="tab-pane fade" id="custom-tabs-four-guimail" role="tabpanel" aria-labelledby="custom-tabs-four-guimail-tab">
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
                                                                                    {{-- <div class="col-4">
                                                                                        <button type="button" id="khoahoso" onclick="" class="btn btn-block btn-secondary btn-xs"><i class="fa-solid fa-lock"></i>&nbsp;&nbsp;Khóa hồ sơ</button>
                                                                                    </div>
                                                                                    <div class="col-2">
                                                                                        <button type="button" id="duyethoso" onclick="" class="btn btn-block btn-info btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;Duyệt hồ sơ</button>
                                                                                    </div> --}}
                                                                                    <div class="col-12">
                                                                                        <button type="button" id="guimail_kiemtrahoso" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-graduation-cap"></i>&nbsp;&nbsp;Gửi mail</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="custom-tabs-four-lichsu" role="tabpanel" aria-labelledby="custom-tabs-four-lichsu-tab">aaaa

                                                            Lịch sử

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4" >
                                            <div class="swiper swiper-slider card card-body" style="height: 100%">
                                                {{-- <div class="swiper-container tracuuthisinh-loadimg">
                                                    <div class="swiper-wrapper" id ="tracuuthusinh-loadimage">

                                                    </div>
                                                    <!-- Add Pagination -->
                                                    <div class="swiper-pagination"></div>

                                                    <!-- Add Navigation -->
                                                    <div class="swiper-button-next"></div>
                                                    <div class="swiper-button-prev"></div>
                                                    <!-- Rotate Button -->

                                                </div>
                                                <button class="rotate-left-btn">↻</button>
                                                <button class="rotate-right-btn">↻</button>
 --}}

    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="image-container">
                    <img src="/img/CTUT_logo.png" alt="Image 1">
                    <div class="controls">
                        <i class="fas fa-search-plus zoom-in-button"></i>
                        <i class="fas fa-search-minus zoom-out-button"></i>
                        <i class="fas fa-sync-alt rotate-button"></i>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="image-container">
                    <img src="/img/CTUT_logo.png" alt="Image 2">
                    <div class="controls">
                        <i class="fas fa-search-plus zoom-in-button"></i>
                        <i class="fas fa-search-minus zoom-out-button"></i>
                        <i class="fas fa-sync-alt rotate-button"></i>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="image-container">
                    <img src="/img/CTUT_logo.png" alt="Image 3">
                    <div class="controls">
                        <i class="fas fa-search-plus zoom-in-button"></i>
                        <i class="fas fa-search-minus zoom-out-button"></i>
                        <i class="fas fa-sync-alt rotate-button"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="swiper-pagination"></div>

        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>



    {{-- <div class="image-container" id="imageContainer">
        <img src="/img/CTUT_logo.png" alt="Your Image" id="zoomedImage">
        <div class="zoom-controls">
            <button onclick="zoomIn()">+</button>
            <button onclick="zoomOut()">-</button>
        </div>
    </div> --}}
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
{{-- <script src="/admin/admin24/js/quanlyhoso/tracuuthisinh.js"></script> --}}
<!-- <script src="/swiper/swiper.js"></script> -->
<!-- <script src="/admin/admin24/js/quanlyhoso/tracuuthisinh2.js"></script>
<script src="/admin/admin24/js/quanlyhoso/tracuuthisinh3.js"></script>
<script src="/admin/admin24/js/quanlyhoso/tracuuthisinh4.js"></script> -->
<script src="/admin/admin24/js/plugins/summernote/summernote.min.js"></script>







<!-- JavaScript Swiper -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
// document.addEventListener('DOMContentLoaded', function () {
    // var imageStates = []; // Mảng lưu trữ trạng thái của mỗi ảnh (tỷ lệ zoom và góc quay)
    // var isDragging = false; // Biến kiểm tra xem người dùng có đang kéo ảnh hay không
    // var startX, startY; // Vị trí chuột khi bắt đầu kéo
    // var startLeft, startTop; // Vị trí ban đầu của ảnh khi bắt đầu kéo

    // var swiper = new Swiper('.swiper-container', {
    //     // Cấu hình Swiper
    //     slidesPerView: 1,
    //     spaceBetween: 30,
    //     pagination: {
    //         el: '.swiper-pagination',
    //         clickable: true,
    //     },
    //     navigation: {
    //         nextEl: '.swiper-button-next',
    //         prevEl: '.swiper-button-prev',
    //     },
    // });

    // // Lắng nghe sự kiện khi nút Zoom được click
    // document.querySelectorAll('.zoom-button').forEach(function(button, index) {
    //     button.addEventListener('click', function() {
    //         var slide = this.closest('.swiper-slide');
    //         var image = slide.querySelector('img');
    //         var state = imageStates[index] || { scale: 1, rotation: 0 };

    //         if (!slide.classList.contains('zoomed')) {
    //             state.scale = 1.5; // Thiết lập tỷ lệ zoom
    //             updateTransform(image, state);
    //             slide.classList.add('zoomed');
    //             image.addEventListener('mousedown', startDrag); // Bắt đầu lắng nghe sự kiện kéo khi phóng to
    //         } else {
    //             state.scale = 1; // Reset tỷ lệ zoom về 1 khi hủy zoom
    //             slide.classList.remove('zoomed');
    //             updateTransform(image, state);
    //             image.removeEventListener('mousedown', startDrag); // Hủy sự kiện kéo khi hủy zoom
    //         }

    //         imageStates[index] = state; // Lưu trạng thái mới của ảnh
    //     });
    // });

    // // Lắng nghe sự kiện khi nút Rotate được click
    // document.querySelectorAll('.rotate-button').forEach(function(button, index) {
    //     button.addEventListener('click', function() {
    //         var slide = this.closest('.swiper-slide');
    //         var image = slide.querySelector('img');
    //         var state = imageStates[index] || { scale: 1, rotation: 0 };

    //         state.rotation += 90; // Tăng góc xoay lên 90 độ mỗi lần click
    //         updateTransform(image, state);
    //         imageStates[index] = state; // Lưu trạng thái mới của ảnh
    //     });
    // });

    // // Hàm cập nhật thuộc tính transform của ảnh dựa trên trạng thái (tỷ lệ zoom và góc quay)
    // function updateTransform(image, state) {
    //     var scale = state.scale || 1;
    //     var rotation = state.rotation || 0;
    //     image.style.transform = 'scale(' + scale + ') rotate(' + rotation + 'deg)';
    // }




// });

// });
// var swiper = new Swiper('.swiper-container', {
//         // Cấu hình Swiper
//         slidesPerView: 1,
//         spaceBetween: 30,
//         pagination: {
//             el: '.swiper-pagination',
//             clickable: true,
//         },
//         navigation: {
//             nextEl: '.swiper-button-next',
//             prevEl: '.swiper-button-prev',
//         },
//     });
// document.addEventListener('DOMContentLoaded', function () {



//     var slides = document.querySelectorAll('.swiper-slide');
//     var imageStates = [];

//     slides.forEach(function(slide, index) {
//         var zoomedImage = slide.querySelector('img');
//         var state = { scale: 1, rotation: 0 };

//         slide.querySelector('.zoom-in-button').addEventListener('click', function() {
//             if (state.scale < 3) {
//                 state.scale += 0.1;
//                 updateTransform(zoomedImage, state);
//             }
//         });

//         slide.querySelector('.zoom-out-button').addEventListener('click', function() {
//             if (state.scale > 0.5) {
//                 state.scale -= 0.1;
//                 updateTransform(zoomedImage, state);
//             }
//         });

//         slide.querySelector('.rotate-button').addEventListener('click', function() {
//             state.rotation += 90;
//             updateTransform(zoomedImage, state);
//         });

//         imageStates.push(state);
//     });

//     function updateTransform(image, state) {
//         var scale = state.scale || 1;
//         var rotation = state.rotation || 0;
//         image.style.transform = 'scale(' + scale + ') rotate(' + rotation + 'deg)';
//     }

//     var isDragging = false; // Biến kiểm tra xem người dùng có đang kéo ảnh hay không
//     var lastX, lastY; // Vị trí chuột khi bắt đầu kéo

//     // Lấy danh sách tất cả các slide trong swiper container
//     var slides = document.querySelectorAll('.swiper-slide');

//     slides.forEach(function(slide, index) {
//         var zoomedImage = slide.querySelector('img');

//         zoomedImage.addEventListener('mousedown', function(event) {
//             isDragging = true;
//             lastX = event.clientX;
//             lastY = event.clientY;
//             zoomedImage.style.cursor = 'grabbing';
//         });

//         zoomedImage.addEventListener('mouseup', function(event) {
//             isDragging = false;
//             zoomedImage.style.cursor = 'grab';
//         });

//         zoomedImage.addEventListener('mousemove', function(event) {
//             if (isDragging) {
//                 var deltaX = event.clientX - lastX;
//                 var deltaY = event.clientY - lastY;

//                 var newX = zoomedImage.offsetLeft + deltaX;
//                 var newY = zoomedImage.offsetTop + deltaY;

//                 zoomedImage.style.left = newX + 'px';
//                 zoomedImage.style.top = newY + 'px';

//                 lastX = event.clientX;
//                 lastY = event.clientY;
//             }
//         });
//     });


// });



document.addEventListener('DOMContentLoaded', function () {
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 1,
        spaceBetween: 30,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    var isDragging = false;
    var lastX, lastY;
    var draggedImage = null;

    document.addEventListener('mousedown', function(event) {
        if (event.target.tagName === 'IMG') {
            isDragging = true;
            lastX = event.clientX;
            lastY = event.clientY;
            draggedImage = event.target;
            draggedImage.style.cursor = 'grabbing';
        }
    });

    document.addEventListener('mouseup', function(event) {
        isDragging = false;
        if (draggedImage) {
            draggedImage.style.cursor = 'grab';
            draggedImage = null;
        }
    });

    document.addEventListener('mousemove', function(event) {
        if (isDragging && draggedImage) {
            var deltaX = event.clientX - lastX;
            var deltaY = event.clientY - lastY;

            var newTransform = getComputedStyle(draggedImage).transform.replace(/[^0-9\-.,]/g, '').split(',');
            var currentX = parseInt(newTransform[4]);
            var currentY = parseInt(newTransform[5]);

            draggedImage.style.transform = 'translate(' + (currentX + deltaX) + 'px, ' + (currentY + deltaY) + 'px)';

            lastX = event.clientX;
            lastY = event.clientY;
        }
    });

})


</script>
