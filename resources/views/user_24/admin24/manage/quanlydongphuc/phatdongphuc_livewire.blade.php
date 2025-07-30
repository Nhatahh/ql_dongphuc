<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('user_24.admin24.include.header')
    <link rel="stylesheet" href="/admin/admin_24/plugins/summernote/summernote.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/QuaggaJS/0.12.1/quagga.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    @livewireStyles

</head>
<style>
/* Camera */
    #videoContainer {
            position: relative;
            width: 100%;
            height: 100%;
        }
        video {
            width: 100%; /* Đảm bảo video chiếm đầy modal */
            height: auto; /* Giữ tỷ lệ khung hình */
            border: 1px solid black; /* Thêm viền để dễ nhìn */
        }
        /* Modal styles */
        .modal {
            display: none; /* Ẩn modal mặc định */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            text-align: center;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Camera preview styles */
        #scanner-container {
            width: 100%;
            height: 300px;
        }



/* Bảng con */


/* .pdphd_mobile{
    display: none;
}
.pdphd_pc{
    display: block;
} */

/* quantity */
.scroll-container::-webkit-scrollbar {
    display: none; /* Chrome, Safari, Opera */
}
.no-scroll {
    overflow: hidden;
    height: 100vh; /* Đảm bảo trang không thể cuộn */
}
/* CSS cho hiệu ứng hiện modal mượt mà */
.modal {
    opacity: 0;
    transform: scale(0.9);
    transition: opacity 0.5s ease, transform 0.5s ease;
}

.modal.show {
    opacity: 1;
    transform: scale(1);
}

/* CSS cho hiệu ứng cuộn mượt mà */
body.no-scroll {
    overflow: hidden;
}
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
    z-index: 50;
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

/* Áp dụng chỉ cho select_size_phat_sp với class custom-select-size */
.custom-select-size + .select2-container .select2-selection--single {
    border-radius: 0;
    border: none;
    border-bottom: 1px solid rgba(0, 0, 0, 0.5);
}

.custom-select-size + .select2-container .select2-selection--single .select2-selection__arrow {
    top: 50%; /* Đặt mũi tên giữa */
    transform: translateY(-50%);
    overflow: hidden;
}

.custom-select-size + .select2-container .select2-selection--single .select2-selection__rendered,
.custom-select-size + .select2-container--default .select2-selection--single .select2-selection__placeholder {
    color: rgba(0, 0, 0, 0.5); /* Màu sắc cho rendered và placeholder */
}

.custom-select-size + .select2-container .select2-results::-webkit-scrollbar {
    width: 8px; /* Chiều rộng thanh cuộn */
}

.custom-select-size + .select2-container .select2-results__options {
    padding: 0; /* Loại bỏ padding và margin */
    margin: 0;
}


#cart-icon {
    position: fixed; /* Cố định vị trí */
    bottom: 20px; /* Cách cạnh dưới 20px */
    right: 20px; /* Cách cạnh phải 20px */
    background-color: #33CCFF; /* Màu nền */
    color: white; /* Màu chữ */
    padding: 10px; /* Khoảng đệm */
    border-radius: 55%; /* Làm tròn để tạo thành bóng */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); /* Hiệu ứng bóng */
    z-index: 50; /* Đảm bảo nằm trên các thành phần khác */
    cursor: pointer; /* Hiệu ứng con trỏ */
    font-size: 25px; /* Kích thước icon */
}

#cart-count {
    position: absolute; /* Để số lượng hiện tại 1 góc */
    top: -5px;
    right: -5px;
    background-color: red; /* Màu nền cho số */
    color: white; /* Màu chữ */
    padding: 5px;
    border-radius: 50%; /* Làm tròn */
    font-size: 12px; /* Kích thước chữ */
}

#tt_sinhvien{

}
#danhmuc_sp{

}
#giohang{
    /* opacity: 0; */
    /* transform: translateY(-50px); */
    bottom: 20px;
    z-index: 50;
    /* transition: opacity 0.3s ease, transform 0.3s ease; Thêm hiệu ứng chuyển động */
}
/* Trạng thái khi modal mở */
#giohang.modal-open {
    /* opacity: 1; */
    /* transform: translateY(0); */

}
.content-wrapper {
  min-height: 600px !important;
}

</style>
<body class="sidebar-mini sidebar-collapse">
<div class="wrapper pc">
    @include('user_24.admin24.include.navbar')
    @include('user_24.admin24.include.sidebar')
    <div style="min-height:500px" class="content-wrapper" >
        <section class="content">
            <div class="container-fluid">
                @include('user_24.admin24.include.contentheader')
                <div class="row">
                    <!-- Tìm kiếm thông tin sinh viên -->
                    <div id="tt_sinhvien" class="col-12 col-sm-12 col-md-12">
                        <div class="card card-body">
                            <div class="row">
                                <div style="width:100%;margin-bottom: 3px;padding-top: 10px;" class="col-8 col-sm-12 col-md-2">
                                    <select class="select_dotphat" style="width:100%;" name="size" id="select_dotphat">
                                    @foreach ($dot_phat as $dot)
                                        <option value="{{ $dot->id }}">{{ $dot->text }}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="col-4 col-sm-4 col-md-1">
                                    <div class="form-group row" style="margin-bottom: 3px;">
                                        <label for="" class="col-12 col-sm-12 col-md-1" style="padding-top: 10px;display:none;font-weight:bold">CCCD</label>
                                        <div style="padding-top: 10px" class="col-12 col-sm-12 col-md-11">
                                            <button style="height: 28px;" type="button" time="" data-id="" id="startScan"  class="btn btn-block btn-primary btn-xs">
                                            <i class="fa-solid fa-qrcode"></i>&nbsp;&nbsp;QR
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Kiếm theo cccd -->
                                <div class="col-12 col-sm-12 col-md-3">
                                    <div class="form-group row" style="margin-bottom: 3px;">
                                        <!-- <label for="cccd_sv" class="col-12 col-sm-12 col-md-2" style="padding-top: 10px;display:none; font-weight:bold">CCCD:</label> -->
                                        <div style="padding-top: 10px" class="col-12 col-sm-12 col-md-12">
                                            <input id="cccd_sv" style="height: 28px" type="text" placeholder="Căn cước công dân sinh viên" class="form-control" >
                                        </div>
                                    </div>
                                </div>
                                 <!-- Kiếm theo cccd -->
                                <div class="col-12 col-sm-12 col-md-3">
                                    <div class="form-group row" style="margin-bottom: 3px;">
                                        <div style="padding-top: 10px;" class="col-12 col-sm-12 col-md-12">
                                            <div style="position: relative;">
                                                <input id="mssv_dp" style="height: 28px; padding-right: 30px;" type="text" placeholder="Mã số sinh viên" class="form-control">
                                                <i class="fa-solid fa-arrow-up-from-bracket" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: #666;" onclick="Upload_ttsv()"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <form style="display:none" id="submit_Upload_ttsv_open">
                                        <input type="file" name="upload_ttsv_open" id="upload_ttsv_open"/>
                                    </form>
                                </div>
                                {{-- <button onclick="import_upload_ttsv()">OK</button> --}}
                                <!-- <div class="col-1 col-sm-1 col-md-1"></div> -->
                            </div>
                        </div>
                    </div>
                    <!-- Danh mục sản phẩm -->
                    <div id="danhmuc_sp" class="col-12 col-sm-12 col-md-9" style="margin-top: 5px; margin-bottom: 10px; height: 350px;">
                        <div id="danhmuc_sp_container" class="scroll-container row" style="min-height: 100px; max-height: 350px; overflow-y: auto;">
                        @if($loai->isEmpty())
                            <div style="font-weight:bold;color:red;margin-left:33%;margin-right:20%;marign-top:30%">Hiện chưa có sản phẩm nào được mở bán !!!</div>
                        @else
                            @foreach ($loai as $val1)
                                <div class="col-6 col-sm-6 col-md-3" style="margin-top: 5px;">
                                    <div class="card card-body thongtin_sanpham_loai_nsx">
                                        <div class="row">
                                            <div class="col-12">
                                            @if(!empty($val1->anhsanpham))
                                                <img src="{{ $val1->anhsanpham }}" alt="Ảnh sản phẩm" style="width: 100%; height: 145px; object-fit: contain;">
                                            @else

                                                <img src="{{ asset('img/CTUT_logo.jpg') }}" alt="Ảnh sản phẩm" style="width: 100%; height: 145px; object-fit: contain;">
                                            @endif
                                            </div>
                                            <label for="" id="ten_loai_{{ $val1->id }}" class="col-12" style="padding-top: 10px; font-weight: light; margin-left: 10px;">
                                                {{ $val1->loai }}
                                            </label>
                                            <div class="col-12" style="margin-bottom: 5px;">
                                                <div class="form-group row">
                                                    <div class="col-8 col-sm-6 col-md-12">
                                                        <select class="select_size_phat_sp custom-select-size" id_loai="{{ $val1->id }}" name="loai_{{ $val1->id }}" id="select_size_{{ $val1->id }}" style="width: 100%;">
                                                            <option value="0">Size</option>
                                                            @foreach ($size as $val)
                                                                @if($val1->id == $val->id_loai)
                                                                    <option value="{{ $val->id_sanpham }}">{{ $val->size }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-1 col-sm-12 col-md-12" style="padding-top: 10px; text-align: right;">
                                                        <i onclick="cart_Database({{ $val1->id }})" class="fa-solid fa-cart-plus" style="background: linear-gradient(45deg, #007bff, #00c6ff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; transition: transform 0.3s ease; cursor: pointer;"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        </div>
                    </div>
                    <!-- Giỏ hàng  -->
                    <div id="giohangContainer" style="margin-top: 10px;margin-bottom: 10px" class ="col-12 col-sm-12 col-md-3">
                        <div id="giohang" class="card-header" style="padding: 0;margin-left: 5px;margin-right: 5px;margin-top: 10px;width:95%;transition: opacity 0.5s ease;opacity: 1;">
                            <fieldset class="card card-body row">
                                <legend>Giỏ hàng <span style="font-weight: bold; background: linear-gradient(45deg, #007bff, #00c6ff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; transition: transform 0.3s ease;" id_taikhoan="" class="col-8 col-sm-8 col-md-8" id="ten_sv"></span></legend>
                                <div class="col-md-12 col-lg-12 col-12 row scroll-container" style="height: auto;overflow-y: 100px;padding-right: 3px;" id="carts_pc">
                                    <div ><span  style="font-weight:light;text-align:center"  class="">Chưa có sản phẩm</span></div>
                                </div>
                                <div  style="" class="row">
                                    <div class="col-8 col-sm-8 col-md-8"></div>
                                    <div class="col-4 col-sm-4 col-md-4">
                                        <div id="group_phatdongphuc" class="form-group row" style="margin-bottom: 3px;display:none;">
                                            <div style="padding-top: 10px" class="col-12 col-sm-12 col-md-12">
                                                <button style="height: 28px;" type="button" time="" data-id="" id="phat_dongphuc" onclick="phat_dong_phuc()" class="btn btn-block btn-primary btn-xs">
                                                    <i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;Lưu
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <!-- <div id="giohang" style="margin-top: 10px;margin-bottom: 10px" class="col-12 col-sm-12 col-md-3">
                        <div class="card-header" style="padding: 0;margin-left: 5px;margin-right: 5px;margin-top: 20px;">
                            <fieldset class="card card-body row">
                                <legend>Giỏ hàng <span style="font-weight: bold; background: linear-gradient(45deg, #007bff, #00c6ff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; transition: transform 0.3s ease;" id_taikhoan="" class="col-8 col-sm-8 col-md-8" id="ten_sv"></span></legend>
                                <div class="col-md-12 col-lg-12 col-12 row scroll-container" style="height: auto;overflow-y: 100px;padding-right: 3px;" id="carts_pc">
                                    <div ><span  style="font-weight:light;text-align:center"  class="">Chưa có sản phẩm</span></div>
                                </div>
                                <div  style="" class="row">
                                    <div class="col-8 col-sm-8 col-md-8"></div>
                                    <div class="col-4 col-sm-4 col-md-4">
                                        <div id="group_phatdongphuc" class="form-group row" style="margin-bottom: 3px;display:none;">
                                            <div style="padding-top: 10px" class="col-12 col-sm-12 col-md-12">
                                                <button style="height: 28px;" type="button" time="" data-id="" id="phat_dongphuc" onclick="phat_dong_phuc()" class="btn btn-block btn-primary btn-xs">
                                                    <i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;Lưu
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div> -->
                </div>
            </div>
        </section>
        @include('user_24.modalevent')
        <!-- @include('user_24.admin24.include.preloader') -->
    </div>

    <div id="footer">
           @include('user_24.admin24.include.footer')
    </div>
    <div style="position: fixed;overflow: hidden;transition: opacity 0.5s ease;opacity: 1;" class="modal" id="scannerModal">
        <div style="vertical-align:middle;background-color: rgba(0,0,0,0.5);height: 120%;">
            <div class="row">
                <div class="col-md-2 col-12">
                </div>
                <div class="col-md-8 col-12">
                <div class="col-md-12 col-12">
                    <div id="" class="card card-navy card-outline" style="width:70%; height:auto; padding: 2px; background-color:#fff; margin-top: 20%;margin-left: 15%;">
                            <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                                <div class="row">
                                    <div class="col-md-11 col-lg-11 col-11">
                                        <span class="">Quét QR</span>
                                    </div>
                                    <div class="col-md-1 col-lg-1 col-1">
                                        <span class="float-right" style="margin-right: 10px"><i id='closeModal' class="fas fa-times"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                                <div id="videoContainer" style="display: flex; justify-content: center; align-items: center; height: 100%; z-index: 1;">
                                    <video id="videoElement" style="width: 110%; height: 100%;" autoplay playsinline></video>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div id="tmp"class="col-md-12 col-12"></div>
                <div class="col-md-2 col-12">
                </div>
            </div>
        </div>
    </div>
</div>


@livewireScripts
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script src="/admin/admin24/js/quanlydongphuc/phatdongphuc.js"></script>

<!-- <script src="/admin/admin24/js/quanlydongphuc/quanlyhoadon.js"></script> -->
<!-- <script src="/admin/admin24/plugins/jsQr/jsQR.js"></script> -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/QuaggaJS/0.12.1/quagga.min.js"></script>
<script src="https://unpkg.com/@ericblade/quagga2@1.2.6/dist/quagga.min.js"></script> --}}
<script src="/template/jsqr/dist/jsQR.js"></script>
<!-- Gọi Quagga từ thư mục public/template -->
<script src="/template/quagga.min.js"></script>
<script>














        $(document).ready(function() {
            // Khởi tạo Select2
            $('.select_size_phat_sp').select2({
                minimumResultsForSearch: Infinity // Tắt ô tìm kiếm nếu không cần
            });
            $('.select_dotphat').select2({
                minimumResultsForSearch: Infinity // Tắt ô tìm kiếm nếu không cần
            });


        });
    </script>
</html>
