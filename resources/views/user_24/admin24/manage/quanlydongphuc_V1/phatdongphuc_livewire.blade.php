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
/* Bảng con */


/* .pdphd_mobile{
    display: none;
}
.pdphd_pc{
    display: block;
} */

/* quantity */
.button_dangkynganh{
    background: 0 0;
    border: 0;
    box-shadow: 0;
    outline: 0 !important;
    color: rgb(46, 49, 146);
    font-weight: bold ;
    /* font-weight: bold; */
}
.suQW3X{
    background: transparent;
    border:1px solid rgba(0,0,0,.09);
    border-radius:2px;
    color: rgba(0,0,0,.8);
    cursor: pointer;
    /* display:flex; */
    justify-content: center;
    letter-spacing: 0;
    outline: none;
    transition: background-color .1s cubic-bezier(.4,0,.6,1);
    width: 32px;
}
.u00pLG{
    -webkit-appearance: none;
    border-left: 0;
    border-right: 0;
    border-radius: 0;
    box-sizing: border-box;
    cursor: text;
    text-align: center;
    width: 40px;


}

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
                <div class="">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-5">
                            <fieldset style="height:590px"  class="card card-body">
                                <!--  -->
                                <div class="col-12 col-sm-12 col-md-12">
                                    <div class="row">
                                        <!-- Kiếm theo cccd -->
                                        <div class="col-12 col-md-12">
                                            <div class="form-group row" style="margin-bottom: 3px;">
                                                <label for="cccd_sv" class="col-12 col-sm-2 col-md-3" style="padding-top: 10px;font-weight:bold">CCCD:</label>
                                                <div style="padding-top: 10px" class="col-12 col-sm-6 col-md-9">
                                                    <input id="cccd_sv" style="height: 28px" type="text" class="form-control" >
                                                </div>
                                                <div style="padding-top: 10px" class="col-6 col-sm-1 col-md-6"></div>
                                                <div style="padding-top: 10px" class="col-6 col-sm-3 col-md-6">
                                                    <button style="height: 28px" type="button" time="" data-id="" id="phat_dongphuc" onclick="phatdongphuc_timkiem()" class="btn btn-block btn-primary btn-xs">
                                                        <i class="fa-solid fa-magnifying-glass"></i>&nbsp;&nbsp;Tìm kiếm
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12  col-md-12">
                                            <div style="height: 40px;padding-top:10px;padding-bottom:20px" class="tt_sv " style="margin-bottom: 3px" id="">
                                            <div style="font-weight: bold; background: linear-gradient(45deg, #007bff, #00c6ff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; transition: transform 0.3s ease;" data-id="'+res.noidung['id']+'" id="ten_sv"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12  col-12">
                                            <div class=" " style="border-bottom:1px solid rgba(0,0,0,.125);margin-bottom:30px;"> </div>
                                        </div>
                                    </div>
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        @if($loai)
                                        <div class="item-0">
                                            <div class="item-body">
                                                <div class="row">
                                                @foreach ($loai as $row2)
                                                    <div class="thongtin col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 row">
                                                        <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-6 col-xxl-6">
                                                        <div class="left">
                                                            <select style="" class="form-control loaisanpham slect_dongphuc"  id_loai = '{{$row2->id}}' id="select_dot_phat_{{$row2->id}}" onchange="()"    >
                                                                {{-- <option value="0">Chọn loại sản phẩm</option> --}}
                                                                @foreach ($sanpham as $row)
                                                                    @if($row->id_loai == $row2->id)
                                                                        <option value="{{$row->id_sp_kho}}"> {{$row2->loai}}({{$row->ten_size}})</option>
                                                                    @endif
                                                                    @endforeach
                                                            </select>
                                                        </div>
                                                        </div>
                                                        <div class="col-6 col-sm-6 col-md-8 col-lg-8 col-xl-6 col-xxl-6">
                                                            <div class=" right">
                                                                <div class="_9m0o30 shopee-input-quantity">
                                                                    <button style="width:30px"  class="suQW3X decrease"> - </button>
                                                                    <input style="width:40px" value="0" class="suQW3X u00pLG nguyenvong sl_ban" id="soluong_ban_{{ $row2->id }}" data-id="{{ $row->id_sp_kho }}" type="text">
                                                                    <button style="width:30px" class="suQW3X increase">+</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div style="margin-bottom:10px" class="item-bottom"></div>
                                                    </div>
                                                    <!--  -->
                                                @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-1"></div>
                                    <div class="col-12 col-sm-8 col-md-11">
                                        <div class="row">
                                            <div class="col-6 col-sm-6 col-md-4 col-lg-6 col-xl-6"></div>
                                            <div style="padding-bottom:10px;padding-right:10px" class="col-3 col-sm-3 col-md-4 col-lg-3 col-xl-3 style_all_button">
                                                <button style="height: 28px;" type="button" time="" data-id="" id="phat_dongphuc" onclick="phat_dongphuc(0)" class="btn btn-block btn-primary btn-xs">
                                                <i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;Lưu
                                                </button>
                                            </div> 
                                            <div style="padding-bottom:10px;padding-right:10px" class="col-3 col-sm-3 col-md-4 col-lg-3 col-xl-3 style_all_button">
                                                <button style="height: 28px;" type="button" time="" data-id="" id="phat_dongphuc" onclick="phat_dongphuc(1)" class="btn btn-block btn-primary btn-xs">
                                                    <i class="fa-regular fa-file-excel"></i>&nbsp;&nbsp;In HD
                                                </button>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <!--  -->
                        
                        <div class="col-12 col-sm-12 col-md-7">
                            <div class="pdphd_pc">
                                <fieldset style="height:590px" class="card card-body">
                                    <table class="table-bordered table-striped dataTable no-footer dtr-inline" id = "ds_hoadon_sv">
                                    </table>
                                </fieldset>
                            </div>
                            <!--  -->
                            <div class="pdphd_mobile">
                                @livewire('qldpphatdongphuc_hoadon')  
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
<script src="/admin/admin24/js/quanlydongphuc/quanlyhoadon.js"></script>

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
