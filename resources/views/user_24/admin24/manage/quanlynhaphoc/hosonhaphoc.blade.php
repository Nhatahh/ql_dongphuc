<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('user_24.admin24.include.header')
    <style>
        @media (max-width: 576px) {
            .col-margin-top {
                margin-top: 25px;
            }
        }

        .style_all_button{
            border-top: 1px solid rgba(0,0,0,.125);
            padding: 3px 0 0 0;
        }
        #lichsu {
            max-height: 500px; /* Adjust the maximum height as per your design */
            overflow-y: auto; /* Enables vertical scrollbar when content overflows */
            padding-right: 20px; /* Adds space for the scrollbar, adjust as needed */
        }
    </style>
</head>

<body class="sidebar-mini sidebar-collapse">
    <select>
        <option>sdasfsdfsdfsdfsdf</option>
        <option>ádfasfasdfsd</option>
    </select>
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
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="card" style="height:600px">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class= "col-md-12 col-12">
                                                <div class="form-group row">
                                                    <label for="update_id_card_user_search" class="col-sm-2 col-form-label" style="padding-bottom: 0px ">CCCD:</label>
                                                    <div class="col-sm-10">
                                                        <input type="text"  class="form-control ttsv_info" id="cccd" name = "update_id_card_user_search" style="height:28px">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class= "col-md-12 col-12" style="margin-top:8px">
                                                <div class="form-group row ">
                                                    <label for="update_id_card_user_search" class="col-sm-2 col-form-label" style="padding-bottom: 0px ">MSSV:</label>
                                                    <div class="col-sm-10">
                                                        <input type="text"  class="form-control ttsv_info" id="search_mssv" name = "update_id_card_user_search" style="height:28px">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12" style="margin-top:8px">
                                                <div class="">
                                                    <div class="row">
                                                        <div class="col-3">
                                                            {{-- <button type="button" id="huyhoso" onclick="" class="btn btn-block btn-danger btn-xs"><i class="fa-regular fa-circle-xmark"></i>&nbsp;&nbsp;Hủy hồ sơ</button> --}}
                                                        </div>
                                                        <div class="col-3">
                                                            {{-- <button type="button" id="dangky_hoso" onclick="" class="btn btn-block btn-warning btn-xs"><i class="fa-regular fa-registered"></i>&nbsp;&nbsp;Đăng ký</button> --}}
                                                        </div>
                                                        <div class="col-3">
                                                            {{-- <button id=""  id-data = "" class="btn btn-block btn-primary btn-xs " onclick="update_ttsv_img_search()"><i class="fa fa-file"></i>&nbsp;&nbsp;&nbsp;Xem file</button> --}}
                                                        </div>
                                                        <div class="col-3">
                                                            <button id="update_ttsv_search"  id-data = "" class="btn btn-block btn-primary btn-xs " onclick="loadtoanbothongtin()"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Tìm kiếm</button>
                                                        </div>
                                                        {{-- <div class="col-4">
                                                            <button type="button" id="" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-graduation-cap"></i>&nbsp;&nbsp;Trúng tuyển</button>
                                                        </div> --}}
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="col-12 col-md-12 col-lg-12 style_all_button" style="margin-top: 10px"></div>
                                        <!-- Thu hồ sơ thí sinh -->
                                        <div class="col-md-12 col-12" style="margin-top: 10px" id="hsnh_danhmuchoso">
                                            {{-- <span class=""  style="margin-left:10px;"><strong>Thu hồ sơ thí sinh</strong></span>       --}}



                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div> <!-- Thẻ đóng Tìm kiếm -->

                        <div class="col-12 col-md-4 col-lg-4" >
                            <div class="card card-primary card-outline card-outline-tabs" style="height:600px">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Thông tin cá nhân</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Địa chỉ</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-two-messages-tab" data-toggle="pill" href="#custom-tabs-two-messages" role="tab" aria-controls="custom-tabs-two-messages" aria-selected="false">Gia đình</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-two-ghichu-tab" data-toggle="pill" href="#custom-tabs-two-ghichu" role="tab" aria-controls="custom-tabs-two-ghichu" aria-selected="false">Ghi chú</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-two-settings-tab" data-toggle="pill" href="#custom-tabs-two-settings" role="tab" aria-controls="custom-tabs-two-settings" aria-selected="false">Lịch sử</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body" >
                                    <div class="tab-content" id="custom-tabs-two-tabContent">
                                        <div class="tab-pane fade show active" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
                                            <div class=" row" >
                                                <div class="col-md-12 col-12 " style="margin-bottom:5px">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="ttsv_name_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Họ và tên :</label>
                                                        <div class="col-sm-8" >
                                                            <input type="text" class="form-control ttsv_info " table = "24_thongtincanhan" id="hoten" name = "ttsv_name_user" style="height: 28px;"  value="" disabled >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-12 " style="margin-bottom:5px">
                                                    <div class="form-group row">
                                                        <label for="ttsv_name_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Ngày sinh :</label>

                                                        <div class="col-sm-8" >
                                                            <div class=" row" >
                                                                <div class="col-sm-8">
                                                                    <input type="date" class="form-control ttsv_info capnhatttcn" table = "24_thongtincanhan" id="ngaysinh" name = "ttsv_birth_user" style="height:28px" placeholder="dd/mm/yyyy" value="">
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-10 col-10 col-md-10 d-flex align-items-center">
                                                                            <input class="form-control ttsv_info capnhatttcn" type="checkbox" table = "24_thongtincanhan"  name="ttsv_id_gioitinh" id="gioitinh" style="height:14px;">
                                                                            <label for="gioitinh" class="col-form-label mb-0">Nam</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-12 " style="margin-bottom:5px">
                                                    <div class="form-group row " style="margin-bottom: 3px">
                                                        <label for="ttsv_id_khuyettat" class="col-sm-4 col-form-label" style="padding-bottom: 0px">MSSV: </label>
                                                        <div class="col-sm-8">
                                                            <input type="text"  class="form-control ttsv_info capnhatttcn" table = "24_mssv" id="mssv" name = "" style="height:28px"  value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-12 " style="margin-bottom:5px">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="ttsv_phone_users" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Điện thoại<sup style = 'color:red'>*</sup>:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control ttsv_info capnhatttcn" table = "24_thongtincanhan" id="dienthoai" name = ""  style="height:28px"  value="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-12 " style="margin-bottom:5px">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="ttsv_id_nation_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Dân tộc<sup style = 'color:red'>*</sup>:</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control ttsv_info capnhatttcn" table ="24_hosonhaphoc" id="id_dantoc"   style="width: 100%;">
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-12 " style="margin-bottom:5px">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="ttsv_id_card_users" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">CCCD<sup style = 'color:red'>*</sup>:</label>

                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control ttsv_info" id="cccd_sv" name = "ttsv_id_card_users" disabled style="height:28px"  value="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-12 " style="margin-bottom:5px">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="ttsv_date_card" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Ngày cấp<sup style = 'color:red'>*</sup>:</label>
                                                        <div class="col-sm-8">
                                                            <input type="date" class="form-control ttsv_info capnhatttcn" table="24_hosonhaphoc" id="ngaycapcccd" name = "ttsv_date_card" style="height:28px"  value="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-12 " style="margin-bottom:5px">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="ttsv_id_place_card" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Nơi cấp<sup style = 'color:red'>*</sup>:</label>

                                                        <div class="col-sm-8">
                                                            <select class="form-control ttsv_info capnhatttcn" table="24_hosonhaphoc" id="noicapcccd" name = "ttsv_id_place_card"  style="width: 100%;"> </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-12 " style="margin-bottom:5px">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="ttsv_sothebhyt" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Số thẻ BHYT:</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control ttsv_info capnhatttcn" table="24_hosonhaphoc" id="bhyt"  name = "ttsv_sothebhyt" style="height:28px"  value="">
                                                            </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-12 " style="margin-bottom:5px">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="ttsv_doan_sv" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Ngày vào Đoàn:</label>
                                                        <div class="col-sm-8">
                                                            <input type="date" class="form-control ttsv_info capnhatttcn" table="24_hosonhaphoc" id="ngayvaodoan" name = "ttsv_doan_sv" style="height: 28px; " value="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-12 " style="margin-bottom:5px">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="ttsv_dang_sv" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Ngày vào Đảng:</label>
                                                        <div class="col-sm-8">
                                                            <input type="date" class="form-control ttsv_info capnhatttcn" table="24_hosonhaphoc" id="ngayvaodang" name = "ttsv_dang_sv" style="height:28px;"  value="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-12 " style="margin-bottom:5px">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="ttsv_id_religion" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Tôn giáo<sup style = 'color:red'>*</sup>:</label>

                                                        <div class="col-sm-8">
                                                            <select class="form-control ttsv_info capnhatttcn" table="24_hosonhaphoc" id="id_tongiao"  name = 'ttsv_id_religion' style="width: 100%;">
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-md-12 col-12 " style="margin-bottom:5px">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="ttsv_id_nationality" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Quốc tịch<sup style = 'color:red'>*</sup>:</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control ttsv_info capnhatttcn" table="24_hosonhaphoc" id="id_quoctich" name = 'ttsv_id_nationality' style="width: 100%; color:#3333;">
                                                        </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12  col-12 " style="margin-bottom:5px">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="ttsv_address_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">ĐC liên lạc<sup style = 'color:red'>*</sup>:</label>
                                                            <div class="col-sm-8">
                                                            <input type="text" class="form-control ttsv_info capnhatttcn" table="24_thongtincanhan" id="diachi" name = "ttsv_address_user" style="height: 28px;" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
                                            <label for="">Nơi sinh :</label>

                                            <div class="col-md-12 col-12 "  style="margin-bottom:5px">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                <label for="ttsv_id_place_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:normal">Tỉnh/TP</span><sup style = 'color:red'>*</sup>:</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control ttsv_info capnnhatdiachi_tinh"  id_thongtin = 'Nơi sinh' id_cap2 = 'id_huyen_noisinh' id_cap3 = 'id_xa_noisinh' id_data ="id_tinh_noisinh" id= "id_tinh_noisinh" name = "ttsv_id_place_user" style="width: 100%;"></select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-12 col-12 "  style="margin-bottom:5px">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_noisinh_huyen" class="col-sm-4 col-form-label"  style="padding-bottom: 0px"><span style="font-weight:normal">Huyện/Quận:</span></label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control ttsv_info capnnhatdiachi_huyen" id_thongtin = 'Nơi sinh' id_cap3 = 'id_xa_noisinh'  id_data="id_huyen_noisinh" id="id_huyen_noisinh"  style="width: 100%;"></select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-12 col-12 "  style="margin-bottom:5px">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_noisinh_xa" class="col-sm-4 col-form-label" style="padding-bottom: 0px"><span style="font-weight:normal">Xã/Phường:</span></label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control ttsv_info capnhatdiachi_xa"  id_thongtin = 'Nơi sinh' id_data="id_xa_noisinh"  id="id_xa_noisinh" style="width: 100%;"></select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-12 "  style="margin-bottom:5px">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_noisinh_cccd" class="col-sm-4 col-form-label" style="padding-bottom: 0px "><span style="font-weight:normal">Giấy khai sinh</span><sup style = 'color:red'>*</sup>:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control ttsv_info capnhatttcn"  id="giaykhaisinh" name = "ttsv_noisinh_cccd"  table = '24_hosonhaphoc' style="height:28px" value="">
                                                    </div>
                                                </div>
                                            </div>

                                            <label for="">Thường trú :</label>
                                            <div class="col-md-12 col-12 "  style="margin-bottom:5px">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_id_khttprovince_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:normal">Tỉnh/TP:</span></label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control ttsv_info capnnhatdiachi_tinh"  id_thongtin = 'Thường Trú' id_cap2 = 'id_huyen_ttru' id_cap3 = 'id_xa_ttru' id_data ="id_tinh_ttru" id= "id_tinh_ttru" name = "" style="width: 100%;"></select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-12 "  style="margin-bottom:5px">
                                            <div class="form-group row" style="margin-bottom: 3px">
                                                <label for="ttsv_id_khttprovince2_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px"><span style="font-weight:normal">Quận/Huyện:</span></label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control ttsv_info capnnhatdiachi_huyen" id_thongtin = 'Thường Trú' id_cap3 = 'id_xa_ttru'  id_data="id_huyen_ttru" id="id_huyen_ttru"  style="width: 100%;"></select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-12 "  style="margin-bottom:5px">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_id_khttprovince3_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px"><span style="font-weight:normal">Xã/Phường:</span></label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control ttsv_info capnhatdiachi_xa"  id_thongtin = 'Thường Trú' id_data="id_xa_ttru"  id="id_xa_ttru" style="width: 100%;"></select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-12 "  style="margin-bottom:5px">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_dow_province3" class="col-sm-4 col-form-label"  style="padding-bottom: 0px "><span style="font-weight:normal">Dưới Xã/Phường:</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control ttsv_info search_hktt_change capnhatttcn"  table = '24_hosonhaphoc'  name = "ttsv_dow_province3" id="duoi_xa_ttru" style="height:28px" value="">
                                                    </div>
                                                </div>
                                            </div>

                                            <label for="">Quê quán :</label>
                                            <div class="col-md-12 col-12 "  style="margin-bottom:5px">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_quequan_tinh" class="col-sm-4 col-form-label" style="padding-bottom: 0px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:normal">Tỉnh/TP:</span><sup style = 'color:red'>*</sup>:</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control ttsv_info capnnhatdiachi_tinh"  id_thongtin = 'Quê Quán' id_cap2 = 'id_huyen_quequan' id_cap3 = 'id_xa_quequan' id_data ="id_tinh_quequan" id= "id_tinh_quequan" name = "" style="width: 100%;"></select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-12 "  style="margin-bottom:5px">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_quequan_huyen" class="col-sm-4 col-form-label" style="padding-bottom: 0px"><span style="font-weight:normal">Quận/Huyện:</span><sup style = 'color:red'>*</sup>:</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control ttsv_info capnnhatdiachi_huyen" id_thongtin = 'Quê Quán' id_cap3 = 'id_xa_quequan'  id_data="id_huyen_quequan" id="id_huyen_quequan"  style="width: 100%;"></select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-12 "  style="margin-bottom:5px">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_quequan_xa" class="col-sm-4 col-form-label" style="padding-bottom: 0px"><span style="font-weight:normal">Xã/Phường:</span><sup style = 'color:red'>*</sup>:</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control ttsv_info capnhatdiachi_xa"  id_thongtin = 'Quê quán' id_data="id_xa_quequan"  id="id_xa_quequan" style="width: 100%;"></select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-12 "  style="margin-bottom:5px">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_down_quequan_xa" class="col-sm-4 col-form-label" style="padding-bottom: 0px "><span style="font-weight:normal">Dưới Xã/Phường:</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control ttsv_info search_quequan_change capnhatttcn" table="24_hosonhaphoc"  name = "ttsv_down_quequan_xa"  id="duoi_xa_quequan" style="height:28px" value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade " id="custom-tabs-two-messages" role="tabpanel" aria-labelledby="custom-tabs-two-messages-tab">
                                            <label for="">Cha: </label>
                                            <div class="col-md-12 col-12 p-1 border-bottom mb-2 ">
                                                <div class="form-group row " style="margin-bottom: 3px">
                                                    <label for="ttsv_tencha_sv" class="col-sm-4 col-form-label" style="padding-bottom: 0px ; font-weight:normal ">Họ tên Cha: </label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control ttsv_info search_cha capnhatttcn" table="24_hosonhaphoc" id="hotencha" style="height:28px" name = "ttsv_tencha_sv" value="">
                                                    </div>
                                                </div>
                                                <div class="form-group row " style="margin-bottom: 3px">
                                                    <label for="ttsv_dienthoaicha_sv" class="col-sm-4 col-form-label"   style="padding-bottom: 0px ; font-weight:normal ">Điện thoại: </label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control ttsv_info search_cha capnhatttcn" table="24_hosonhaphoc" id="dienthoaicha" name = "ttsv_dienthoaicha_sv" style="height:28px" value="">
                                                    </div>
                                                </div>
                                                <div class="form-group row " style="margin-bottom: 3px">
                                                    <label for="ttsv_nghenghiepcha_sv" class="col-sm-4 col-form-label"  style="padding-bottom: 0px ; font-weight:normal ">Nghề nghiệp: </label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control ttsv_info search_cha capnhatttcn" table="24_hosonhaphoc" id="nghenghiepcha"  name = "ttsv_nghenghiepcha_sv"  style="height:28px" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <label for="">Mẹ: </label>
                                            <div class="col-md-12 col-12 border-bottom p-1 mb-2">
                                                <div class="form-group row " style="margin-bottom: 3px">
                                                    <label for="ttsv_tenme_sv" class="col-sm-4 col-form-label" style="padding-bottom: 0px ; font-weight:normal ">Họ tên Mẹ:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control ttsv_info search_me capnhatttcn" table="24_hosonhaphoc"id="hotenme" style="height:28px" name = "ttsv_tenme_sv" value="">
                                                    </div>
                                                </div>
                                                <div class="form-group row " style="margin-bottom: 3px">
                                                    <label for="ttsv_dienthoaime_sv" class="col-sm-4 col-form-label"   style="padding-bottom: 0px ; font-weight:normal ">Điện thoại: </label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control ttsv_info search_me capnhatttcn" table="24_hosonhaphoc" id="dienthoaime" name = "ttsv_dienthoaime_sv" style="height:28px" value="">
                                                    </div>
                                                </div>
                                                <div class="form-group row " style="margin-bottom: 3px">
                                                    <label for="ttsv_nghenghiepme_sv" class="col-sm-4 col-form-label"  style="padding-bottom: 0px ; font-weight:normal ">Nghề nghiệp:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control ttsv_info search_me capnhatttcn" table="24_hosonhaphoc" id="nghenghiepme"  name = "ttsv_nghenghiepme_sv"  style="height:28px" value="">
                                                    </div>
                                                </div>
                                            </div>

                                            <label for="">Người đỡ đầu: </label>
                                            <div class="col-md-12 col-12  p-1">
                                                <div class="form-group row " style="margin-bottom: 3px">
                                                    <label for="ttsv_tendodau_sv" class="col-sm-4 col-form-label" style="padding-bottom: 0px ; font-weight:normal ">Họ tên người đỡ đầu: </label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control ttsv_info search_dodau capnhatttcn" table="24_hosonhaphoc" id="nguoidodau" style="height:28px" name = "ttsv_dodau_sv" value="">
                                                        </div>
                                                </div>
                                                <div class="form-group row " style="margin-bottom: 3px">
                                                    <label for="ttsv_dienthoaidodau_sv" class="col-sm-4 col-form-label"   style="padding-bottom: 0px ; font-weight:normal ">Điện thoại: </label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control ttsv_info search_dodau capnhatttcn" table="24_hosonhaphoc" id="dienthoainguoidodau" name = "ttsv_dienthoaidodau_sv" style="height:28px" value="">
                                                        </div>
                                                    </div>
                                                <div class="form-group row " style="margin-bottom: 3px">
                                                    <label for="ttsv_nghenghiepdodau_sv" class="col-sm-4 col-form-label"  style="padding-bottom: 0px ; font-weight:normal ">Nghề nghiệp:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control ttsv_info search_dodau capnhatttcn" table="24_hosonhaphoc" id="nghenghiepnguoidodau"  name = "ttsv_nghenghiepdodau_sv"  style="height:28px" value="">
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="custom-tabs-two-ghichu" role="tabpanel" aria-labelledby="custom-tabs-two-ghichu-tab">
                                            <div class="col-md-12 col-12  ">
                                                <div class="form-group">
                                                    <textarea id = 'ghichu' table = '24_hosonhaphoc'  class="form-control capnhatttcn" rows="5" placeholder="Nội dung ghi chú ...."></textarea>

                                                </div>



                                            </div>
                                        </div>



                                        <div class="tab-pane fade" id="custom-tabs-two-settings" role="tabpanel" aria-labelledby="custom-tabs-two-settings-tab">
                                            <div class="col-md-12 col-12  ">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_name_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Lịch sử</label>
                                                    <div class="scrollable-container" id ="lichsu">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- load hình ảnh -->
                        <div class="col-12 col-md-4 col-lg-4 ">
                            <div class="img">
                                <div class=""> @include('user_24.admin24.manage.quanlynhaphoc.slider')</div>
                            </div>
                        </div><!-- Đóng load hình ảnh -->
                    </div>
                </div><!-- Class container-fluid -->
            </section>
        </div>
    </div>
    @include('user_24.modalevent')
</body>
@include('user_24.admin24.include.footer')
</html>
<script src="/admin/admin24/js/quanlynhaphoc/hosonhaphoc.js"></script>




