<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CTUT | Thanh toán lệ phí</title>

    @include('user_24.head')

</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        @include('user_24.navbar')
        <div class="content-wrapper" style="margin-left:0px;background-color:#f4f6f9 ">
            <div class="content-header" style="padding: 10px 0.5rem">
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-12 col-xl-8">
                            <div class="card card-body lephi_mobie">
                                <div class="row">
                                    <div class="col-12 col-md-12 col-xl-12" style="padding-left: 0px">
                                        <fieldset style="" class="card card-body">
                                            <legend>Hướng dẫn thanh toán lệ phí</legend>
                                            <div class="row">
                                                <div class="col-12 col-md-4 col-xl-4 col-12 col-md-12 line_nganhdangky" style="margin-top: 3px">
                                                    <span style="text-align: center;font-weight:bold;">Cách 1: Thanh toán bằng QRCode</span>
                                                    <div lass="chuc_vu text-md" ><i class="fa-regular fa-circle-check" style="color: #007bff;font-weight:bold"></i>&nbsp;&nbsp;Thời gian trả kết quả: <span style="font-weight:bold">Sau khi thanh toán</span></div>
                                                    <div lass="chuc_vu text-md" ><i class="fa-regular fa-circle-check" style="color: #007bff;font-weight:bold"></i>&nbsp;&nbsp;Hướng dẫn: <a style="font-weight:bold;" href="#" id = "moxemhuongdan">Xem tại đây</a></div>
                                                    <div lass="chuc_vu text-md" ><i class="fa-regular fa-circle-check" style="color: #007bff;font-weight:bold"></i>&nbsp;&nbsp;Xem kết quả tại màn hinh <span style="font-weight:bold;" href="">"Lịch sử"</span></div>
                                                </div>
                                                <div class="col-12 col-md-4 col-xl-4 col-12 col-md-12 line_nganhdangky" style="margin-top: 3px">
                                                    <span style="text-align: center;font-weight:bold;">Cách 2: Thanh toán qua Chuyển khoán</span>
                                                    <div lass="chuc_vu text-md" ><i class="fa-regular fa-circle-check" style="color: #007bff;font-weight:bold"></i>&nbsp;&nbsp;Thời gian trả kết quả: <span style="font-weight:bold">03 ngày làm việc</span></div>
                                                    <div lass="chuc_vu text-md" ><i class="fa-regular fa-circle-check" style="color: #007bff;font-weight:bold"></i>&nbsp;&nbsp;Thông chuyển khoản:</div>
                                                    <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Số tài khoản: <strong style="color: #007bff">0111000315359</strong></div>
                                                    <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ngân hàng: <strong style="color: #007bff">Vietcombank</strong></div>
                                                    <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Số tiền: <strong style="color: #007bff">{{ $tongtien - $dathanhtoan}}</strong></div>
                                                    <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nội dung: <strong style="color: #007bff">ID{{Auth::guard('loginbygoogles')->id()}}&nbsp;  @if (empty($dienthoai)) "" @else @if($dienthoai == 0) Chưa nhập số điện thoại @else {{ $dienthoai }} @endif @endif</strong></div>
                                                    <div lass="chuc_vu text-md" ><i class="fa-regular fa-circle-check" style="color: #007bff;font-weight:bold"></i>&nbsp;&nbsp;Xem kết quả tại màn hinh <span style="font-weight:bold;" href="">"Lịch sử"</span></div>
                                                </div>
                                                <div class="col-12 col-md-4 col-xl-4 col-12 col-md-12 line_nganhdangky" style="margin-top: 3px">
                                                    <span style="text-align: center;font-weight:bold;">Cách 3: Thanh toán bằng Tiền mặt</span>
                                                    <div lass="chuc_vu text-md" ><i class="fa-regular fa-circle-check" style="color: #007bff;font-weight:bold"></i>&nbsp;&nbsp;Tại:<span style="font-weight:bold">Phòng Tài chính - Kế toán</span></div>
                                                    <div lass="chuc_vu text-md" ><i class="fa-regular fa-circle-check" style="color: #007bff;font-weight:bold"></i>&nbsp;&nbsp;Địa chỉ: <span style="font-weight:bold;" href="">Địa chỉ: Số 256, Nguyễn Văn Cừ, P. An Hòa, Q. Ninh Kiều, TP Cần Thơ</span></div>
                                                    <div lass="chuc_vu text-md" ><i class="fa-regular fa-circle-check" style="color: #007bff;font-weight:bold"></i>&nbsp;&nbsp;Zalo: <span style="font-weight:bold;" href="">0823891457</span></div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-12 col-md-6 col-xl-6" style="padding-left: 0px">
                                        <fieldset style="min-height:400px" class="card card-body">
                                            <legend>Nguyện vọng đã đăng ký</legend>
                                            <div class="row">
                                                @if (empty($nguyenvong))
                                                    <div class="col-12 col-md-12" style="margin-bottom:10px; "></div>
                                                @else
                                                    @foreach ($nguyenvong as $val)
                                                        <div class="col-12 col-md-12 line_nganhdangky"
                                                            style="margin-bottom:10px; ">
                                                            <span style="font-weight: bold;">{{ $val->thutu }}.
                                                                {{ $val->name_major }}</span>
                                                            @if ($val->chuyennganh == 1)
                                                                <div class="text-sm"><b>Chuyên ngành
                                                                        {{ $val->tenchuyennganh }}</b></div>
                                                            @endif
                                                            <div class="chucvu text-sm"><b>Nguyện vọng
                                                                    {{ $val->thutu }}</b></div>
                                                            <span class="explore-price-box small">Phương thức:
                                                                200</span>
                                                            <span class="explore-price-box small">Tổ hợp:
                                                                {{ $val->id_group }}</span>
                                                            <span class="explore-price-box small">Điểm xét tuyển:
                                                                {{ $val->diemxettuyen }}</span>
                                                        </div>
                                                    @endforeach
                                                @endif
                                                <div class="col-6 col-md-8" style="margin-bottom:10px">
                                                    <div style="color:#007bff;font-weight:bolder"
                                                        class="explore-price-box small text-sm" id="sotienthanhtoan">
                                                        Tổng lệ phí: {{ $tongtien }}<br>
                                                        Đã thanh toán: {{ $dathanhtoan }}
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-4" style="margin-bottom:10px">
                                                    @if ($sotienthanhtoan == -1 || $sotienthanhtoan == -2 || $sotienthanhtoan == -3 || $tontai == 1)
                                                        <button type="button" disabled id = "layqrcode"
                                                            onclick="layqrcode({{ Auth::guard('loginbygoogles')->id() }})"
                                                            class="btn btn-block btn-primary btn-xs"><i
                                                                class="fa-solid fa-cash-register"></i>&nbsp;&nbsp;Thanh
                                                            toán QR</button>
                                                    @else
                                                        <button type="button" id = "layqrcode"
                                                            onclick="layqrcode({{ Auth::guard('loginbygoogles')->id() }})"
                                                            class="btn btn-block btn-primary btn-xs"><i
                                                                class="fa-solid fa-cash-register"></i>&nbsp;&nbsp;Thanh
                                                            toán QR</button>
                                                    @endif
                                                </div>
                                                {{-- <span style="color:red">Hiện tại, hệ thống đang chuẩn bị để phục vụ thanh toán lệ phí xét tuyển</span> --}}
                                            </div>
                                        </fieldset>
                                    </div>


                                    <div class="col-12 col-md-6 col-xl-6">
                                        <fieldset style="min-height:400px" class="card card-body">
                                            <legend>Quét QR để thanh toán</legend>
                                            <div style="display: flex; justify-content: center; align-items: center;">
                                                @if ($thanhtoan == 1)
                                                    <img id="qr_bank" style="width:15rem" src="/img/test.png">
                                                @else
                                                    <img id="qr_bank" style="width:15rem" src="{{ $qr }}">
                                                @endif
                                            </div>
                                            @if ($thanhtoan == 1)
                                                <div style="color:red;text-align:center;font-weight:bolder"
                                                    class="text-sm"></div>
                                                <div style="color:red;text-align:center;font-weight:bolder"
                                                    class="text-sm"></div>
                                            @else
                                                <div style="color:red;text-align:center;font-weight:bolder"
                                                    class="text-sm" id="thongbaolephi"></div>
                                                <div style="color:red;text-align:center;font-weight:bolder"
                                                    class="text-sm" id="laytgthuc"></div>
                                            @endif
                                        </fieldset>
                                    </div>
                                </div>

                            </div>
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
        <div class = "modal" id="huongdanthanhtoan" ><i class="fa-solid fa-xmark modal_close" id = "huongdanthanhtoan_img_close" onclick = "huongdanthanhtoan_img_close()" role="button"></i>
            <div  style="height:100%;display:flex;justify-content:center; background-color: rgba(0,0,0,0.5);" >
                <div class="direct-chat-messages" style="height:100%;margin-top:5px;">
                    <img src="/img/anhhuongdan.jpg">
                </div>
            </div>
        </div>
    </div>


    @include('user_24.footer')


    <script src="/template/admin/plugins/select2/js/select2.full.min.js"></script>
    <script src="/swiper/swiper.js"></script>
    <script src="/user_24/js/thanhtoanlephi.js"></script>

</body>



</html>


<script></script>
