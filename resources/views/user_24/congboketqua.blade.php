<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CTUT | Lịch sử thao tác</title>
    @include('user_24.head')
    <style>
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
            padding: 10px; /* Khoảng cách bên trong header */
            display: flex;
            justify-content: space-between; /* Căn các phần tử theo hai bên */

        }

        .item-row1 .maphieu {
            margin-right: 10px; /* Khoảng cách phải giữa 'Mã phiếu' và 'NVQS2024121223' */
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
            width: 90%; /* Chiếm 90% chiều rộng của phần tử cha */
            margin: auto; /* Canh giữa */
        }

        .item-body {
            padding: 10px; /* Khoảng cách bên trong body */
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
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        @include('user_24.navbar')
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin-left:0px;background-color:#f4f6f9 ">
            <!-- Content Header (Page header) -->
            <div class="content-header" style="padding: 10px 0.5rem">
                <div class="row">
                    <div style="font-size: 0.95rem; color:#869099;" class="col-12 col-xl-8 col-md-12">
                    </div>
                    <div class="col-12 col-xl-4 col-md-12"></div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-xl-8 col-md-12">
                            {{-- <fieldset class="card card-body"> --}}
                                {{-- <legend>Trạng thái hồ sơ</legend> --}}
                                <div style="min-height: 600px;" class="card">
                                    @if (count($trungtuyen) > 0)
                                        @foreach ($trungtuyen as $row)
                                            @if($row->congbo == 1)
                                                <div class="item-hoso">
                                                    <div class="item-header">
                                                        <div class="item-row1">
                                                            <div class="maphieu">
                                                                <span>Đợt xét tuyển:</span>
                                                                <strong>Xét tuyển chung 2024</strong>
                                                            </div>
                                                        </div>
                                                        <div class="item-bottom">
                                                        </div>
                                                    </div>
                                                    <div class="item-body">
                                                        <div class = 'thongtin'>
                                                            <div class = "left">Trạng thái: </div>
                                                            <div style = "color:#11a2f3">Trúng tuyển chính thức</div>
                                                        </div>
                                                        <div class = 'thongtin'>
                                                            <div class = "left">Ngành: </div>
                                                            <div class = "right">{{$row->tenchuyennganh}} </div>
                                                        </div>
                                                        <div class = 'thongtin'>
                                                            <div class = "left">Điểm tổ hợp: </div>
                                                            <div class = "right">{{$row->diemtohop}} </div>
                                                        </div>
                                                        <div class = 'thongtin'>
                                                            <div class = "left">Điểm ưu tiên: </div>
                                                            <div class = "right">{{$row->diemuutien}} </div>
                                                        </div>
                                                        <div class = 'thongtin'>
                                                            <div class = "left">Điểm xét tuyển: </div>
                                                            <div class = "right">{{$row->diemxettuyen}} </div>
                                                        </div>
                                                        <div class = 'thongtin'>
                                                            <div class = "left">Cố vấn học tập:</div>
                                                            <div class = "right">{{$row->ten_cvht}}</div>
                                                        </div>
                                                        <div class = 'thongtin'>
                                                            <div class = "left">Điện thoại:</div>
                                                            <div class = "right">{{$row->dienthoai_cvht}}</div>
                                                        </div>
                                                        <div class = 'thongtin'>
                                                            <div class = "left">Điện thoại hỗ trợ:</div>
                                                            <div class = "right">02923898167 (Phòng đào tạo) </div>
                                                        </div>
                                                        <div class = 'thongtin'>
                                                            <div class = "left">Facebook:</div>
                                                            <div class = "right">https://www.facebook.com/CTUT.CT</div>
                                                        </div>
                                                        <div class = "" style="margin-bottom:3px">
                                                            <div class = "">CCCD/CMND: </div>
                                                            @if ($row->xacnhan == 1)
                                                                <div class = ""><input disabled type="text" class="form-control" id="xacnhannhaphoc_cccd{{$row->id}}" value="{{$name_user}}" style="height:28px;width:100%"></div>
                                                            @else
                                                                <div class = ""><input disabled type="text" class="form-control" id="xacnhannhaphoc_cccd{{$row->id}}" value="{{$name_user}}" style="height:28px;width:100%"></div>
                                                            @endif
                                                        </div>

                                                        <div class = 'thongtin'>


                                                            <div class="col-12">
                                                                <div class="style_all_button">
                                                                    <div class="row">
                                                                        <div class="col-10">
                                                                        </div>
                                                                        <div class="col-2">
                                                                            @if ($row->xacnhan == 1)
                                                                                <div class = "right"> <button disabled style="width:150px" onclick="xacnhannhaphoc({{$row->id}})" type="button" id="xacnhannhaphoc{{$row->id}}" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Xác nhận</button></div>
                                                                            @else
                                                                                <div class = "right"> <button  style="width:150px" onclick="xacnhannhaphoc({{$row->id}})" type="button" id="xacnhannhaphoc{{$row->id}}" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Xác nhận</button></div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="item-header">
                                                            <div class="item-row1">
                                                                <div class="maphieu">
                                                                    <strong>Hướng dẫn</strong>
                                                                </div>
                                                            </div>
                                                            <div class="item-bottom">
                                                            </div>
                                                        </div>
                                                        <div class="item-body">
                                                            <div class = 'thongtin'>
                                                                {{-- <p style="text-align:  justify">B1. Nhập <strong style="color:red">CCCD/CMND Tài khoản đăng ký xét tuyển trên </strong> của <strong style="color:red">Hệ thống của Bộ</strong>. Chọn xác nhận.</p> --}}
                                                                {{-- <p style="text-align:  justify">Thí sinh nhập thông tin sinh viên đầy đủ và chọn Xác nhận! <strong style="color:red">Nguyện vọng 1</strong> là ngành thí sinh Trúng tuyển (Mã trường: <strong style="color:red">KCC</strong>)</p> --}}
                                                                <p style="text-align:  justify">B1. Thí sinh nhập thông tin sinh viên phía dưới đầy đủ.
                                                                <p style="text-align:  justify">B2. Thí sinh chọn nút màu xanh trên góc phải để cập nhật hình ảnh Căn cước công dân, 04 trang học bạ, Giấy chứng nhận Tốt nghiệp tạm thời, Giáy chứng nhận kết quả thi THPT</p>
                                                                <p style="text-align:  justify">B3. Thí sinh chọn <strong style="color:red">Xác nhận</strong></p></p>


                                                                {{-- <p style="text-align:  justify">Lưu ý. Thí sinh không nhập CMND/CCCD xem như từ chối kết quả xét tuyển sớm tại Trường. Mọi chi tiết: Liên hệ Phòng Đào tạo - 02923898167</p> --}}
                                                            </div>
                                                            <div class="item-bottom">
                                                            </div>
                                                        </div>


                                                        <div class=" row" >
                                                            <div class="col-md-6 col-12 " style="margin-bottom:5px">
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <label for="ttsv_id_nation_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Dân tộc:</label>
                                                                    <div class="col-sm-8">
                                                                        <select class="form-control ttsv_info capnhatttcn" table ="" id="id_dantoc"   style="width: 100%;">

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-12 " style="margin-bottom:5px">
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <label for="ttsv_date_card" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Ngày cấp CCCD:</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="date" class="form-control ttsv_info capnhatttcn"  id="ngaycapcccd" name = "ttsv_date_card" style="height:28px"  value="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-12 " style="margin-bottom:5px">
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <label for="ttsv_id_place_card" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Nơi cấp CCCD:</label>

                                                                    <div class="col-sm-8">
                                                                        <select class="form-control ttsv_info capnhatttcn" table="24_hosonhaphoc" id="noicapcccd" name = "ttsv_id_place_card"  style="width: 100%;"> </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-12 " style="margin-bottom:5px">
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <label for="ttsv_sothebhyt" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Số thẻ BHYT:</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control ttsv_info capnhatttcn" table="24_bhyt" id="bhyt"  name = "ttsv_sothebhyt" style="height:28px"  value="">
                                                                        </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-12 " style="margin-bottom:5px">
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <label for="ttsv_doan_sv" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Ngày vào Đoàn:</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="date" class="form-control ttsv_info capnhatttcn" table="24_hosonhaphoc" id="ngayvaodoan" name = "ttsv_doan_sv" style="height: 28px; " value="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-12 " style="margin-bottom:5px">
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <label for="ttsv_dang_sv" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Ngày vào Đảng:</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="date" class="form-control ttsv_info capnhatttcn" table="24_hosonhaphoc" id="ngayvaodang" name = "ttsv_dang_sv" style="height:28px;"  value="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-12 " style="margin-bottom:5px">
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <label for="ttsv_id_religion" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Tôn giáo<sup style = 'color:red'>*</sup>:</label>

                                                                    <div class="col-sm-8">
                                                                        <select class="form-control ttsv_info capnhatttcn" table="24_hosonhaphoc" id="id_tongiao"  name = 'ttsv_id_religion' style="width: 100%;">
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="col-md-6 col-12 " style="margin-bottom:5px">
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <label for="ttsv_id_nationality" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Quốc tịch<sup style = 'color:red'>*</sup>:</label>
                                                                    <div class="col-sm-8">
                                                                        <select class="form-control ttsv_info capnhatttcn" table="24_hosonhaphoc" id="id_quoctich" name = 'ttsv_id_nationality' style="width: 100%; color:#3333;">
                                                                    </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6  col-12 " style="margin-bottom:5px">
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <label for="ttsv_address_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">ĐC liên lạc<sup style = 'color:red'>*</sup>:</label>
                                                                        <div class="col-sm-8">
                                                                        <input type="text" class="form-control ttsv_info capnhatttcn" table="24_hosonhaphoc" id="diachilienlac" name = "ttsv_address_user" style="height: 28px;" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="item-bottom" style="margin-bottom: 10px">
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-12 col-12" style="font-weight:600;text-align:center">Nơi sinh:
                                                            </div>
                                                            <div class="col-md-6 col-12 ">
                                                                <div class="form-group row" style="margin-bottom: 2px">
                                                                <label for="ttsv_id_place_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px"><span style="font-weight:normal">Tỉnh/TP</span><sup style = 'color:red'>*</sup>:</label>
                                                                    <div class="col-sm-8">
                                                                        <select class="form-control ttsv_info tinh_id_huyen_noisinh capnhatttcn" table="24_hosonhaphoc" id="id_tinh_noisinh" id_tinh="id_tinh_noisinh" onchange="loadhuyen()" name = "ttsv_id_place_user" style="width: 100%;"></select>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="col-md-6 col-12 ">
                                                                <div class="form-group row" style="margin-bottom: 2px">
                                                                    <label for="ttsv_noisinh_huyen" class="col-sm-4 col-form-label"  style="padding-bottom: 0px"><span style="font-weight:normal">Huyện/Quận:</span></label>
                                                                    <div class="col-sm-8">
                                                                        <select class="form-control ttsv_info huyen_id_xa_noisinh capnhatttcn" table="24_hosonhaphoc" id="id_huyen_noisinh" id_huyen="id_huyen_noisinh" onchange="loadxa()" name = "ttsv_noisinh_huyen" style="width: 100%;"></select>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="col-md-6 col-12 ">
                                                                <div class="form-group row" style="margin-bottom: 2px">
                                                                    <label for="ttsv_noisinh_xa" class="col-sm-4 col-form-label" style="padding-bottom: 0px"><span style="font-weight:normal">Xã/Phường:</span></label>
                                                                    <div class="col-sm-8">
                                                                        <select class="form-control ttsv_info capnnhatdiachi capnhatttcn" table="24_hosonhaphoc" id="id_xa_noisinh"  id_xa="id_xa_noisinh" name = "ttsv_noisinh_xa" style="width: 100%;"></select>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="col-md-6 col-12 ">
                                                                <div class="form-group row" style="margin-bottom: 2px">
                                                                    <label for="ttsv_noisinh_cccd" class="col-sm-4 col-form-label" style="padding-bottom: 0px "><span style="font-weight:normal">Nơi sinh theo GKS:</span></label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control ttsv_info capnhatttcn" table="24_hosonhaphoc" id="giaykhaisinh"  name = "ttsv_noisinh_cccd"  style="height:28px" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="item-bottom" style="margin-bottom: 10px">
                                                            </div>

                                                            <div class="col-md-12 col-12" style="text-align:center;font-weight:600">Hộ khẩu thường trú:
                                                            </div>
                                                            <div class="col-md-6 col-12 ">
                                                                <div class="form-group row" style="margin-bottom: 2px">
                                                                    <label for="ttsv_id_khttprovince_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px"><span style="font-weight:normal">Tỉnh/TP:</span></label>
                                                                    <div class="col-sm-8">
                                                                        <select class="form-control ttsv_info search_hktt_change tinh_id_huyen_ttru capnhatttcn" table="24_hosonhaphoc" name = "ttsv_id_khttprovince_user" onchange="loadhuyen2()" id="id_tinh_ttru"  id_tinh="id_tinh_ttru"  style="width: 100%;"></select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-12 ">
                                                            <div class="form-group row" style="margin-bottom: 2px">
                                                                <label for="ttsv_id_khttprovince2_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px"><span style="font-weight:normal">Quận/Huyện:</span></label>
                                                                    <div class="col-sm-8">
                                                                        <select class="form-control ttsv_info search_hktt_change huyen_id_xa_ttru capnhatttcn" table="24_hosonhaphoc" onchange="loadxa2()" id="id_huyen_ttru" id_huyen="id_huyen_ttru"  name = "ttsv_id_khttprovince2_user" style="width: 100%;"></select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-12 ">
                                                                <div class="form-group row" style="margin-bottom: 2px">
                                                                    <label for="ttsv_id_khttprovince3_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px"><span style="font-weight:normal">Xã/Phường:</span></label>
                                                                    <div class="col-sm-8">
                                                                        <select class="form-control ttsv_info search_hktt_change capnnhatdiachi capnhatttcn" table="24_hosonhaphoc"  id="id_xa_ttru" id_xa= "id_xa_ttru" name = "ttsv_id_khttprovince3_user" style="width: 100%;"></select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group row" style="margin-bottom: 2px">
                                                                    <label for="ttsv_dow_province3" class="col-sm-4 col-form-label"  style="padding-bottom: 0px "><span style="font-weight:normal">Dưới Xã/Phường:</span></label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control ttsv_info search_hktt_change capnhatttcn"  table = '24_hosonhaphoc'  name = "ttsv_dow_province3" id="duoi_xa_ttru" style="height:28px" value="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="item-bottom" style="margin-bottom: 10px">
                                                            </div>

                                                            <div class="col-md-12 col-12" style="text-align:center;font-weight:600">Địa chỉ quê quán:
                                                            </div>

                                                            <div class="col-md-6 col-12 ">
                                                                <div class="form-group row" style="margin-bottom: 2px">
                                                                    <label for="ttsv_quequan_tinh" class="col-sm-4 col-form-label" style="padding-bottom: 0px"><span style="font-weight:normal">Tỉnh/TP:</span><sup style = 'color:red'>*</sup>:</label>
                                                                    <div class="col-sm-8">
                                                                        <select class="form-control ttsv_info search_quequan_change tinh_id_huyen_quequan capnhatttcn" table="24_hosonhaphoc" id="id_tinh_quequan" id_tinh="id_tinh_quequan" onchange="loadhuyen3()" name = "ttsv_quequan_tinh"  style="width: 100%;"></select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-12 ">
                                                                <div class="form-group row" style="margin-bottom: 2px">
                                                                    <label for="ttsv_quequan_huyen" class="col-sm-4 col-form-label" style="padding-bottom: 0px"><span style="font-weight:normal">Quận/Huyện:</span><sup style = 'color:red'>*</sup>:</label>
                                                                    <div class="col-sm-8">
                                                                        <select class="form-control ttsv_info search_quequan_change huyen_id_xa_quequan capnhatttcn" table="24_hosonhaphoc" id="id_huyen_quequan" id_huyen="id_huyen_quequan"  onchange="loadxa3()"  name = "ttsv_quequan_huyen" style="width: 100%;"> </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group row" style="margin-bottom: 2px">
                                                                    <label for="ttsv_quequan_xa" class="col-sm-4 col-form-label" style="padding-bottom: 0px"><span style="font-weight:normal">Xã/Phường:</span><sup style = 'color:red'>*</sup>:</label>
                                                                    <div class="col-sm-8">
                                                                        <select class="form-control ttsv_info search_quequan_change  capnnhatdiachi capnhatttcn" table="24_hosonhaphoc" id="id_xa_quequan" id_xa="id_xa_quequan" name = "ttsv_quequan_xa" style="width: 100%;"></select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-12 ">
                                                                <div class="form-group row" style="margin-bottom: 2px">
                                                                    <label for="ttsv_down_quequan_xa" class="col-sm-4 col-form-label" style="padding-bottom: 0px "><span style="font-weight:normal">Dưới Xã/Phường:</span></label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control ttsv_info search_quequan_change capnhatttcn" table="24_hosonhaphoc"  name = "ttsv_down_quequan_xa"  id="duoi_xa_quequan" style="height:28px" value="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="item-bottom" style="margin-bottom: 10px">
                                                            </div>

                                                            <div class="col-md-12 col-12" style="text-align:center;font-weight:600">Thông tin cha:
                                                            </div>

                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group row" style="margin-bottom: 2px">
                                                                    <label for="ttsv_tencha_sv" class="col-sm-4 col-form-label" style="padding-bottom: 0px ; font-weight:normal ">Họ tên: </label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control ttsv_info search_cha capnhatttcn" table="24_hosonhaphoc" id="hotencha" style="height:28px" name = "ttsv_tencha_sv" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group row" style="margin-bottom: 2px">
                                                                    <label for="ttsv_dienthoaicha_sv" class="col-sm-4 col-form-label"   style="padding-bottom: 0px ; font-weight:normal ">Điện thoại: </label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control ttsv_info search_cha capnhatttcn" table="24_hosonhaphoc" id="dienthoaicha" name = "ttsv_dienthoaicha_sv" style="height:28px" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group row " style="margin-bottom: 2px">
                                                                    <label for="ttsv_nghenghiepcha_sv" class="col-sm-4 col-form-label"  style="padding-bottom: 0px ; font-weight:normal ">Nghề nghiệp: </label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control ttsv_info search_cha capnhatttcn" table="24_hosonhaphoc" id="nghenghiepcha"  name = "ttsv_nghenghiepcha_sv"  style="height:28px" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="item-bottom" style="margin-bottom: 10px">
                                                            </div>

                                                            <div class="col-md-12 col-12" style="text-align:center;font-weight:600">Thông tin Mẹ:
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group row " style="margin-bottom: 2px">
                                                                    <label for="ttsv_tenme_sv" class="col-sm-4 col-form-label" style="padding-bottom: 0px ; font-weight:normal ">Họ tên:</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control ttsv_info search_me capnhatttcn" table="24_hosonhaphoc"id="hotenme" style="height:28px" name = "ttsv_tenme_sv" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group row " style="margin-bottom: 2px">
                                                                    <label for="ttsv_dienthoaime_sv" class="col-sm-4 col-form-label"   style="padding-bottom: 0px ; font-weight:normal ">Điện thoại: </label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control ttsv_info search_me capnhatttcn" table="24_hosonhaphoc" id="dienthoaime" name = "ttsv_dienthoaime_sv" style="height:28px" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group row " style="margin-bottom: 2px">
                                                                    <label for="ttsv_nghenghiepme_sv" class="col-sm-4 col-form-label"  style="padding-bottom: 0px ; font-weight:normal ">Nghề nghiệp:</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control ttsv_info search_me capnhatttcn" table="24_hosonhaphoc" id="nghenghiepme"  name = "ttsv_nghenghiepme_sv"  style="height:28px" value="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="item-bottom" style="margin-bottom: 10px">
                                                            </div>

                                                            <div class="col-md-12 col-12" style="text-align:center;font-weight:600">Thông tin Người đỡ đầu:
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group row " style="margin-bottom: 2px">
                                                                    <label for="ttsv_tendodau_sv" class="col-sm-4 col-form-label" style="padding-bottom: 0px ; font-weight:normal ">Họ tên: </label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control ttsv_info search_dodau capnhatttcn" table="24_hosonhaphoc" id="nguoidodau" style="height:28px" name = "ttsv_dodau_sv" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group row " style="margin-bottom: 2px">
                                                                    <label for="ttsv_dienthoaidodau_sv" class="col-sm-4 col-form-label"   style="padding-bottom: 0px ; font-weight:normal ">Điện thoại: </label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control ttsv_info search_dodau capnhatttcn" table="24_hosonhaphoc" id="dienthoainguoidodau" name = "ttsv_dienthoaidodau_sv" style="height:28px" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group row " style="margin-bottom: 2px">
                                                                    <label for="ttsv_nghenghiepdodau_sv" class="col-sm-4 col-form-label"  style="padding-bottom: 0px ; font-weight:normal ">Nghề nghiệp:</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control ttsv_info search_dodau capnhatttcn" table="24_hosonhaphoc" id="nghenghiepnguoidodau"  name = "ttsv_nghenghiepdodau_sv"  style="height:28px" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="style_all_button">
                                                                <div class="row">
                                                                    <div class="col-10">
                                                                    </div>
                                                                    <div class="col-2">
                                                                        <button  style="width:150px" onclick="capnhatthongtincannhan({{$row->id}})" type="button" id="xacnhannhaphoc{{$row->id}}" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Lưu thông tin</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        {{-- <div class="item-hoso">
                                            <div class="item-body" >
                                                <div class="">Thí sinh <span style="color: red">không trúng tuyển </span> đại học chính quy tại Trường. Nếu thí sinh vẫn muốn xét tuyển vào các ngành đào tạo chính quy thì vui lòng truy cập cổng xét tuyển chung của Bộ Giáo dục và Đào tạo tại địa chỉ <a style="font-weight:bold;font-style:italic" href="https://thisinh.thitotnghiepthpt.edu.vn/">https://thisinh.thitotnghiepthpt.edu.vn/</a> (từ ngày 18/7 đến 17 giờ 00 ngày 30/7/2024) để đăng ký Nguyện vọng.</div>
                                                <div style="font-style:italic;margin-top:20px">Chi tiết liên hệ:</div>
                                                <div class="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Trang Facebook: Trường Đại học Kỹ thuật - Công nghệ Cần Thơ.</div>
                                                <div class="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Số điện thoại Phòng Đào tạo (Giờ hành chính): 02923.898.167 </div>
                                                <div class="">Xin chân thành cảm ơn!</div>
                                                <div class="item-bottom" style="margin-bottom:30px"></div>
                                                <div style="font-style:italic;font-weight:bold">Hiện tại, Nhà trường đang đào tạo hình thức vừa làm vừa học các ngành:</div>
                                                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.Khoa học máy tính (Chỉ tiêu: 15)</div>
                                                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. Công nghệ thực phẩm (Chỉ tiêu: 20)</div>
                                                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. Khoa học dữ liệu (Chỉ tiêu: 15) </div>
                                                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4. Tài chính - Ngân hàng (Chỉ tiêu: 24)</div>
                                                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5. Công nghệ thông tin (Chỉ tiêu: 30)</div>
                                                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;6. Kế toán (Chỉ tiêu: 24)</div>
                                                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;7. Logistics và quản lý chuỗi cung ứng (Chỉ tiêu: 35)</div>
                                                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;8. Quản trị kinh doanh (Chỉ tiêu: 30)</div>
                                                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;9. Công nghệ kỹ thuật điện, điện tử (Chỉ tiêu: 25)</div>
                                                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10. Luật (Chỉ tiêu: 22)</div>
                                                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;11. Ngôn ngữ Anh (Chỉ tiêu: 20)</div>
                                                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;12. Công nghệ kỹ thuật điều khiển và tự động hóa (Chỉ tiêu: 25)</div>
                                                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;13. Quản lý xây dựng (Chỉ tiêu: 15)</div>
                                                <div>Để biết thêm chi tiết các ngành theo hình thức vừa làm vừa học, thí sinh liên hệ Trung tâm Đào tạo - Bồi dưỡng - <strong style="color:#007bff">02923890060</strong> (hoặc Cô Nhung: <strong style="color:#007bff">0909237789</strong>, Thầy Khoa: <strong style="color:#007bff">0917273266</strong>)</div>
                                            </div>
                                        </div> --}}
                                    @endif
                                </div>
                            {{-- </fieldset> --}}
                        </div>
                        <div class="col-12 col-md-12 col-xl-4 content_right">
                            @include('user_24.content_right')
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @include('user_24.navbarfooter')
        @include('user_24.modalevent')
        @include('user_24.info_popup')
    </div>














    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    @include('user_24.footer')


    <script src="/template/admin/plugins/select2/js/select2.full.min.js"></script>
    <script src="/swiper/swiper.js"></script>
    <script src="/user_24/js/congboketqua.js"></script>
</body>

</html>
