
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$title}}</title>
    @include('user.head')
</head>
<body class="sidebar-mini">
    <div class="wrapper">

        <!-- Preloader -->
        {{-- @include('admin.preloader') --}}
        <!-- /.preloader -->

        <!-- Navbar -->
         @include('user.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->

        @include('user.sidebar')
        <!-- /.sidebar -->
        {{-- @yield('sidebar1') --}}

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 1302.12px;">
            <section class="content">
                <div class="container-fluid">
                    @include('user.contentheader')
                    <div class="row">
                        <div class="col-md-12">
                                <div id="loadpageuser"></div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
         @include('user.footer')

    </div>

</body>



</html>
