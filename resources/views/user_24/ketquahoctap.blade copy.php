<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Dashboard</title>
    @include('user_24.head')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed">
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-8">
                    <nav class="navbar navbar-expand navbar-white navbar-light"  style="padding: 0rem 0rem;    border-bottom: 1px solid #dee2e6;">
                        @include('user_24.navbar')
                    </nav>
                    <!-- Main content -->
                    <section class="" style="margin: 0rem 0rem; ">
                        <div class="container-fluid">





                        </div>
                    </section>
                </div>


                {{-- Hinh anh ben phai --}}
                <div class="col-12 col-md-4" >
                    @include('user_24.content_right')
                </div>
            </div>
        </div>
    @include('user_24.footer')
    <script src="/user_24/js/ketquahoctap.js"></script>
</body>
</html>
