<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CTUT-Tuyển sinh| Lịch sử thao tác</title>
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
            <div class="content-header" style="padding: 0px">
                <div class="row">
                    <div style="font-size: 0.95rem; color:#869099;" class="col-12 col-xl-8 col-md-12">
                        <marquee direction="left" behavior="" scrollamount="15">
                           Chức năng được phát triển bởi sinh viên: Minh Quân, Dũng Son, Đỗ Phi
                        </marquee>
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
                            <fieldset class="card card-body">
                                <legend>Trạng thái hồ sơ</legend>

                                <div style="min-height: 20px;" class="direct-chat-messages">
                                    @if (count($history)> 0)
                                        @foreach ($history as $ls)
                                            @if ($ls->id_nhansu == 0)
                                                <div class="direct-chat-msg">
                                                    <div class="direct-chat-infos clearfix">
                                                        <span
                                                            class="direct-chat-name float-left">{{ $name_user->hoten }}</span>
                                                        <span
                                                            class="direct-chat-timestamp float-right">{{ $ls->create_at }}</span>
                                                    </div>

                                                    <img class="direct-chat-img" src="{{ $avatar}}"
                                                        alt="message user image">

                                                    <div style="background-color: #fff" class="direct-chat-text">
                                                        {{ $ls->noidung }}
                                                    </div>

                                                </div>
                                                @else
                                                <div class="direct-chat-msg right">
                                                    <div class="direct-chat-infos clearfix">
                                                        <span
                                                            class="direct-chat-name float-right">{{ $ls->ten_nhansu }}</span>
                                                        <span
                                                            class="direct-chat-timestamp float-left">{{ $ls->create_at }}</span>
                                                    </div>
                                                    <img class="direct-chat-img" src="img/CTUT_logo.jpg"
                                                        alt="message user image">

                                                    <div class="direct-chat-text">
                                                        {{ $ls->noidung }}
                                                    </div>

                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <div></div>
                                    @endif

                                </div>


                            </fieldset>
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
    </div>














    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    @include('user_24.footer')


    <script src="/template/admin/plugins/select2/js/select2.full.min.js"></script>
    <script src="/swiper/swiper.js"></script>
    <script src="/user_24/js/lichsuthaotac.js"></script>
</body>

</html>
