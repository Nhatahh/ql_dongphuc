<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('user_24.admin24.include.header')
</head>

<body class="sidebar-mini sidebar-collapse">
    <div class="wrapper">
        <!-- Preloader -->
        {{-- <!-- @include('user_24.admin_24.preloader')  --> --}}
        <!-- /.preloader -->

        <!-- Navbar -->
        @include('user_24.admin24.include.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->

        @include('user_24.admin24.include.sidebar')
        <!-- /.sidebar -->
        {{-- @yield('sidebar1') --}}

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 1302.12px;">
            @include('user_24.admin24.include.contentheader')
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card" style="min-height: 590px">
                                {{-- Tìm kiếm --}}
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
                                            <div class="form-group row" style="margin-bottom: 3px">
                                                <label for="thanhtoan_namtuyensinh" class="col-sm-4 col-form-label"
                                                    style="padding-bottom: 0px">Đợt tuyển sinh:</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" id="thanhtoan_namtuyensinh" onchange="loadhosolephi()"
                                                        style="width: 100%;">
                                                        <option value = "-1">Chọn đợt tuyển sinh</option>
                                                        <option value = "1">Xét tuyển sớm ĐHCQ 2024</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-6 col-md-4 col-lg-2 col-xl-2">
                                            <button onclick="exceldanhsachtructuyen()" style="height: 28px;width:100px"
                                                class="btn btn-block bg-gradient-secondary btn-xs"><i
                                                    class="notika-icon notika-next"></i>&nbsp;&nbsp;Excel</button>
                                        </div>
                                        {{-- <div class="col-6 col-sm-6 col-md-4 col-lg-2 col-xl-2">
                                            <button onclick="testmail()" style="height: 28px;width:100px"
                                                class="btn btn-block bg-gradient-secondary btn-xs"><i
                                                    class="notika-icon notika-next"></i>&nbsp;&nbsp;Mail</button>
                                        </div> --}}
                                    </div>
                                </div>
                                {{-- Table --}}
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">

                                            <table id = "danhsachthanhtoan" style="width:100%"
                                                class="table table-bordered table-striped">

                                            </table>

                                        </div>
                                    </div>
                                </div>
                                {{-- Thống kê --}}
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-3 col-sm-12 col-xs-12">
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                                            <b>Hóa đơn: <span id = "tonghoadon"></span></b>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                                            <b>Thí sinh: <span id = "tongthisinh"></span></b>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                                            <b>Tổng thu: <span id = "tongtien"></span></b>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @include('user_24.admin24.include.footer')
    </div>
</body>

</html>
<script src="/admin/admin24/js/hosotructuyen.js"></script>
