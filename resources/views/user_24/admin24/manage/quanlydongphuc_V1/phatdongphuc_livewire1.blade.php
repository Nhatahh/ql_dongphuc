<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('user_24.admin24.include.header')
    <link rel="stylesheet" href="/admin/admin_24/plugins/summernote/summernote.min.css">
    @livewireStyles
</head>
<style>
        /* .edit_tabledata:focus{
            outline: none;
       }
        .edit_tabledata {
            background-color: inherit !important;
        }
        .edit_tabledata:hover {
            background-color: inherit !important;
        } */
        .card-header{
            font-weight: normal
        }



        .selected {
            background-color: #007bff;
            color: #fff;
        }
        th > select{
            width: 90%
        }

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
            padding: 0px; /* Khoảng cách bên trong header */
            display: flex;
            justify-content: space-between; /* Căn các phần tử theo hai bên */

        }

        .item-row1 .maphieu {
            margin-right: 5px; /* Khoảng cách phải giữa 'Mã phiếu' và 'NVQS2024121223' */
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
            width: 100%; /* Chiếm 90% chiều rộng của phần tử cha */
            margin: 3px 0px; /* Canh giữa */

        }

        .item-body {
            padding: 5pxpx; /* Khoảng cách bên trong body */
        }

        .thongtin {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: space-between; /* Canh giữa các phần tử con */
            width: 100%; /* Chiều rộng 100% */
            margin-bottom: 3px
        }

        .thongtin .left {
            flex: 1; /* Độ rộng tự động */
            text-align: left; /* Căn trái */
        }

        .thongtin .right {
            flex: 1; /* Độ rộng tự động */
            text-align: right; /*Căn phải*/
            margin-left: auto;
            padding-right: 5px;
            /* padding-left:50px */
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


        .checkbox-container {
            display: inline-block;
            vertical-align: middle;
            position: relative;
            cursor: pointer;
            font-size: 14px;
            line-height: 1.2;
            padding-left: 28px; /* khoảng cách giữa checkbox và label */
            margin-bottom: 0px; /* khoảng cách giữa các checkbox */
            margin-top: 10px;
        }

        .checkbox-container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .checkbox-container label {
            position: relative;
            padding-left: 25px; /* khoảng cách giữa checkbox và nội dung */
            height: 14px;
            margin:0;

        }

        .checkbox-container label:before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 14px;
            height: 14px;
            border: 2px solid #aaa; /* màu viền */
            background-color: #fff; /* màu nền */

        }

        label:not(.form-check-label):not(.custom-file-label) {
            font-weight: normal;
        }
        .checkbox-container input:checked ~ label:before {
            background-color: #2196F3; /* màu nền khi được chọn */
            border-color: #2196F3; /* màu viền khi được chọn */
        }

        /* .checkbox-container label:after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 8px;
            height: 8px;
            background-color: #fff;
            border-radius: 50%;
            opacity: 0;
        }

        .checkbox-container input:checked ~ label:after {
            opacity: 0;
        } */

        label {
    cursor: pointer;
}

.item-thisinh {
    border: 1px solid #ddd; /* Viền đơn màu xám nhạt */
    border-radius: 8px; /* Bo tròn các góc */
    padding: 15px; /* Khoảng cách giữa nội dung và viền */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Đổ bóng nhẹ */
    background-color: #fff; /* Màu nền */
margin-bottom: 8px; /* Khoảng cách dưới của mỗi item */
}

.select2-search {
    display: none !important;
  }

  .select2-container--default .select2-selection--multiple .select2-selection__choice{
    background-color: #007bff;
  }

  #scrollTopBtn {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 99;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    font-size: 18px;
    cursor: pointer;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s ease;
    opacity: 0;
    visibility: hidden;
}

#scrollTopBtn:hover {
    background-color: #0056b3;
}

/* CSS cho icon trong nút */
#scrollTopBtn i {
    pointer-events: none; /* Không cho phép sự kiện click cho icon */
    line-height: 40px; /* Căn giữa icon */
}
</style>
<body class="sidebar-mini sidebar-collapse">
<div class="wrapper">
    @include('user_24.admin24.include.preloader')
    @include('user_24.admin24.include.navbar')
    @include('user_24.admin24.include.sidebar')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                @include('user_24.admin24.include.contentheader')
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <div class="row">
                                    <!-- Kiếm theo cccd -->
                                    <div class="col-12">
                                        <div class="form-group" style="margin-bottom: 3px;margin-top: 10px">
                                            <label for="cccd_sv" class="col-12" style="padding-top: 5px;font-weight:bold">Căn cước công dân:</label>
                                            <div class="col-12">
                                                <input id="cccd_sv" style="height: 28px" type="text" class="form-control" >
                                            </div>
                                            <div class="col-12" style="margin-top: 3px">
                                                <div class="row">
                                                        <div class="col-6"></div>
                                                        <div class="col-6">
                                                            <div class="style_all_button">
                                                            <button style="height: 28px" type="button" time="" data-id="" id="phat_dongphuc" onclick="phatdongphuc_timkiem()" class="btn btn-block btn-primary btn-xs">
                                                                <i class="fa-solid fa-magnifying-glass"></i>&nbsp;&nbsp;Tìm kiếm
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" col-md-12 col-12" style="margin-top: 8px">
                                                <div class=" tt_sv row" style="margin-bottom: 3px" id="">
                                                    <label for="ten_sv" class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4" style="padding-bottom: 0px;font-weight:700">Tên SV:</label>
                                                    <div  data-id="'+res.noidung['id']+'" class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8" id="ten_sv"></div>
                                                </div>
                                                <div class=" tt_sv row" style="margin-bottom: 3px" id="">
                                                    <label for="ngay_sinh" class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4" style="padding-bottom: 0px;font-weight:700">Ngày sinh:</label>
                                                    <div  data-id="'+res.noidung['id']+'" class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8" id="ngay_sinh"></div>
                                                </div>
                                                <div class=" tt_sv row" style="margin-bottom: 3px" id="">
                                                    <label for="cccd" class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4" style="padding-bottom: 0px;font-weight:700">CCCD:</label>
                                                    <div  data-id="'+res.noidung['id']+'" class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8" id="cccd"></div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div> <!-- Gọi component Livewire "Qldptimkiemsp" -->
                            <div class="col-12 col-md-9 col-lg-9">
                                <!-- <fieldset class="card card-body"> -->
                                    <legend style="margin-bottom: 12px">Danh sách đồng phục</legend>
                                    @if($loai)
                                    <div class="item-0">
                                        <div class="item-body">
                                            <div class="row">
                                            @foreach ($loai as $row2)
                                                <div class="thongtin col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                                    <div class="left">
                                                        <select style="width: 120%;height:33px;border:1px solid #ced4da;border-radius:.25rem" class="form-control loaisanpham"  id_loai = '{{$row2->id}}' id="select_dot_phat_{{$row2->id}}" onchange="()" style="width: 100%;">
                                                            {{-- <option value="0">Chọn loại sản phẩm</option> --}}
                                                            @foreach ($sanpham as $row)
                                                                @if($row->id_loai == $row2->id)
                                                                    <option value="{{$row->id_sp_kho}}"> {{$row2->loai}}({{$row->ten_size}})</option>
                                                                @endif
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="right">
                                                        <input class="sl_ban" id = "soluong_ban_{{$row2->id}}" data-id="{{ $row->id_sp_kho }}" style="background-color: inherit; width: 70px; height: 33px; border:1px solid #ced4da">
                                                    </div>
                                                    <div style="margin-bottom:10px" class="item-bottom"></div>
                                                </div>
                                            @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                <!-- </fieldset> -->
                            </div>


                            <div class="col-12 col-md-11"></div>
                            <div class="col-12 col-md-1">
                                <div class="style_all_button">
                                    <div class="row">
                                        {{-- <div class="col-6"></div> --}}
                                        <div class="col-12">
                                            <button type="button" time="" data-id="" id="phat_dongphuc" onclick="phat_dongphuc()" class="btn btn-block btn-primary btn-xs">
                                                <i class="fa-solid fa-cart-shopping"></i>&nbsp;&nbsp;In hóa đơn
                                            </button>
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
@livewireScripts

</body>
<script src="/admin/admin24/js/quanlydongphuc/phatdongphuc.js"></script>

<script>
    function select_dot_phat(){
        $.ajax({
            type: "get",
            url: "/admin24/select_dot_phat",
            success: function(res) {
                $('#select_dot_phat').select2({data:res})
            }
        })
    }
</script>
</html>
