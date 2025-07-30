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
                                    <div class="col-12 col-md-6 col-xl-6" style="padding-left: 0px">
                                        <fieldset class="card card-body">
                                            <legend>Nguyện vọng đã đăng ký</legend>
                                            <div class="row">
                                                @foreach ($nguyenvong as $val)
                                                    <div class="col-12 col-md-12 line_nganhdangky" style="margin-bottom:10px; ">
                                                        <span style="font-weight: bold;">{{$val->thutu}}. {{$val->name_major}}</span>
                                                        @if($val->chuyennganh == 1)
                                                            <div class="text-sm"><b>Chuyên ngành {{$val->tenchuyennganh}}</b></div>
                                                        @endif
                                                        <div class="chucvu text-sm"><b>Nguyện vọng {{$val->thutu}}</b></div>
                                                        <span class="explore-price-box small">Phương thức: 200</span>
                                                        <span class="explore-price-box small">Tổ hợp: {{$val->id_group}}</span>
                                                        <span class="explore-price-box small">Điểm xét tuyển: {{$val->diemxettuyen}}</span>
                                                    </div>
                                                @endforeach
                                                    <div class="col-6 col-md-8" style="margin-bottom:10px">
                                                    </div>
                                                    <div class="col-6 col-md-4" style="margin-bottom:10px">
                                                        <button type="button" id = "" onclick="thanhtoanlephi({{Auth::guard('loginbygoogles')->id()}})" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-cash-register"></i>&nbsp;&nbsp;Thanh toán</button>
                                                    </div>
                                            </div>
                                        </fieldset>
                                    </div>


                                    <div class="col-12 col-md-6 col-xl-6">

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

    </div>


    @include('user_24.footer')


    <script src="/template/admin/plugins/select2/js/select2.full.min.js"></script>
    <script src="/swiper/swiper.js"></script>
    <script src="/user_24/js/thanhtoanlephi.js"></script>

</body>

</html>
