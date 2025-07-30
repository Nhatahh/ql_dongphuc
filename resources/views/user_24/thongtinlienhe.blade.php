<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CTUT | Thông tin liên hệ</title>

    @include('user_24.head')

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
                    {{-- <div class="card card-body thongtinlienhecontainer"> --}}
                        <div class="row">
                            <div class="col-12 col-xl-6 col-md-6">
                                <div class="row">
                                    <div class="col-12 col-xl-12 col-md-12">
                                        <fieldset style="min-height: 600px; padding-bottom: 10px;"
                                            class="card card-body">
                                            <legend>Hỗ trợ thí sinh đăng ký</legend>
                                            <div class="row">
                                                @if (empty($ttnhansu))
                                                    <span>Hiện tại chưa có hỗ trợ</span>
                                                @else
                                                    @foreach ($ttnhansu as $thongtin)
                                                        <div class="col-12 col-xl-6 col-md-6">
                                                            <div class="row">
                                                                <div class="col-12 col-md-3 text-center">
                                                                    <div style="margin: 0.5rem auto" class="user-panel">
                                                                        <div style="padding-left: 0;" class="image">
                                                                            <img style="width: 3.5rem;"src="{{ $thongtin->img }}"
                                                                                class="img-circle elevation-0"
                                                                                alt="User Image">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-9 thongtinlienhe">
                                                                    @if ($thongtin->gioitinh == 0)
                                                                        <span style="font-weight: bold;">Thầy
                                                                            {{ $thongtin->ten }}</span>
                                                                    @else
                                                                        <span style="font-weight: bold;">Cô
                                                                            {{ $thongtin->ten }}</span>
                                                                    @endif
                                                                    <div class="chucvu text-sm"><b>Zalo: {{ $thongtin->sdt }}
                                                                        </b> </div>
                                                                    <span
                                                                        class="explore-price-box small">{{ $thongtin->email }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-xl-6 col-md-6 ">
                                <fieldset class="card card-body thongtinlienheright" style="min-height: 600px">
                                    <legend>Đội ngũ phát triển</legend>
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <!-- slider -->
                                            <div class="row images-slider">
                                                @if(empty($doinguphattrien))
                                                    <div></div>
                                                @else
                                                    @foreach($doinguphattrien as $ttdoi5)
                                                        <div class="col-12 col-xl-6 col-md-6">
                                                            <div class="row">
                                                                <div class="col-12 col-md-12 text-center">
                                                                    <div style="margin: 0.5rem auto" class="user-panel ">
                                                                        <div style="padding-left: 0;" class="image ">
                                                                            <img style="width: 5rem;height:5rem;" src="{{$ttdoi5->img}}" class="img-imgdoinguhotro elevation-0" alt="User Image">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-12 doinguhotro">
                                                                    <span style="font-weight: bold;">{{$ttdoi5->hoten}}</span>
                                                                    <div class="chucvu text-sm"><b>{{$ttdoi5->lop}}</b> </div>
                                                                    <span class="explore-price-box small">{{$ttdoi5->email}}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <!-- end slider -->
                                        </div>
                                        <div class="col-12 col-md-12" style="margin-top:50px;text-align:center;display: flex; justify-content: center;">
                                                <img style="width:100px;height:100px;vertical-align: middle;" src="img/CTUT_logo.png" alt="">
                                        </div>
                                        <div style="margin-top:15px;" class="col-12 col-md-12">
                                            <div class="row">
                                                <div  class="col-12 col-md-12 col-xl-7">
                                                    <div>
                                                        <div style="font-size:1rem; font-weight:bold">Trường Đại học Kỹ thuật - Công nghệ Cần Thơ</div>
                                                        <div><i style="color:  rgb(102, 6, 6); font-size:20px; " class="fa-solid fa-location-dot"></i>&nbsp;&nbsp;256, Nguyễn Văn Cừ, P. An Hòa, Q. Ninh Kiều, TP. Cần Thơ</div>
                                                        <div><i style="color:  rgb(102, 6, 6); font-size:20px; " class="fa-brands fa-facebook"></i>&nbsp;&nbsp;https://www.facebook.com/CTUT.CT</div>
                                                        <div><i style="color:  rgb(102, 6, 6); font-size:20px; " class="fa-solid fa-envelope-circle-check"></i>&nbsp;&nbsp;tuvantuyensinh@ctuet.edu.vn</div>
                                                        <div><i style="color:  rgb(102, 6, 6); font-size:20px; " class="fa-solid fa-phone-volume"></i>&nbsp;&nbsp; 02923898167</div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-12 col-xl-5" style="margin-top: 10px;">
                                                    <iframe class="img-fluid" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3928.6384937437037!2d105.76524067479426!3d10.046660190061154!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0880f08006ffb%3A0x9a745510330faf4e!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBL4bu5IHRodeG6rXQgLSBDw7RuZyBuZ2jhu4cgQ-G6p24gVGjGoQ!5e0!3m2!1svi!2s!4v1711333304006!5m2!1svi!2s">
                                                    </iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    {{-- </div> --}}
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
    <script src="/user_24/js/thongtinlienhe.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    {{--  --}}

</body>

</html>
