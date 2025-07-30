<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$title}}</title>
    @include('admin.head')
</head>
<body class="sidebar-mini">
    <div class="wrapper">

        <!-- Preloader -->
        {{-- @include('admin.preloader') --}}
        <!-- /.preloader -->

        <!-- Navbar -->
         @include('admin.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->

        @include('admin.sidebar')
        <!-- /.sidebar -->
        {{-- @yield('sidebar1') --}}

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 1302.12px;">
            <section class="content">
                <div class="container-fluid">
                    @include('admin.contentheader')
                    <div class="row">
                        <div class="col-md-12">
                            <div id="loadpage"></div>





                        </div>
                    </div>
                </div>
            </section>
        </div>
         @include('admin.footer')

    </div>

</body>



</html>
