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

{{$bank}}

                    <input type="text" id = "tutu"  value="">

                    <button id="them">Luu</button>





                    <h1 id = "aaa"></h1>
                    <img id = "hinhanh" src="">







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
    <script src="/user_24/js/test.js"></script>
    <script>

    </script>
</body>

</html>
