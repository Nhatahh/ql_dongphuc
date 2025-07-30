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
                        <div class="col-lg-2 col-4">
                            <div class="small-box bg-primary ">
                                <div class="inner">
                                    <h3>{{ $taikhoan }}</h3>
                                    <p>Accounts</p>
                                </div>
                                <div class="icon">
                                    <i class="fa-solid fa-users"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-2 col-4">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $chitieu }}</h3>
                                    <p>Chỉ tiêu</p>
                                </div>
                                <div class="icon">
                                    <i class="fa-solid fa-award"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-2 col-4">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $slnguyenvong }}/{{ $slthisinh }}</h3>
                                    <p>NV/ThS</p>
                                </div>
                                <div class="icon">
                                    <i class="fa-regular fa-registered"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-2 col-4">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $slkhoanguyenvong }}</h3>
                                    <p>Đăng ký</p>
                                </div>
                                <div class="icon">
                                    <i class="fa-solid fa-key"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-2 col-4">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3>{{ $nv1 }}/{{ $nv2 }}/{{ $nv3 }}</h3>
                                    <p>NV1/NV2/NV3</p>
                                </div>
                                <div class="icon">
                                    <i class="fa-solid fa-circle-info"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-2 col-4">
                            <div class="small-box bg-secondary">
                                <div class="inner">
                                    <h3>{{ $slthisinhlephi }}</h3>
                                    <p>Lệ phí</p>
                                </div>
                                <div class="icon">
                                    <i class="fa-solid fa-comments-dollar"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <section class="col-lg-10 connectedSortable ui-sortable">
                            <div class="card" style="position: relative; left: 0px; top: 0px; min-height:450px">
                                <div class="card-header ui-sortable-handle" style="cursor: move;">
                                    <h3 class="card-title">
                                        <i class="fas fa-chart-pie mr-1"></i>
                                        Biểu đồ thống kê
                                    </h3>
                                    <div class="card-tools">
                                        <ul class="nav nav-pills ml-auto">
                                            <li class="nav-item">
                                                <a class="nav-link active" href="#chitieu-chart" data-toggle="tab">Chỉ
                                                    tiêu</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#nguyenvong-chart" data-toggle="tab">Nguyện
                                                    vọng</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content p-0">
                                        <div class="chart tab-pane active" id="chitieu-chart"
                                            style="position: relative; height: 350px;">
                                            {{-- <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand">
                                                    <div class=""></div>
                                                </div>
                                                <div class="chartjs-size-monitor-shrink">
                                                    <div class=""></div>
                                                </div>
                                            </div> --}}
                                            <canvas id="chitieu-chart-canvas" height="350px"
                                                style="height: 350px; display: block;"
                                                class="chartjs-render-monitor"></canvas>
                                        </div>
                                        <div class="tab-pane" id="nguyenvong-chart"
                                            style="position: relative; height: 350px;">
                                            {{-- <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand">
                                                    <div class=""></div>
                                                </div>
                                                <div class="chartjs-size-monitor-shrink">
                                                    <div class=""></div>
                                                </div>
                                            </div> --}}
                                            <canvas id="nguyenvong-chart-canvas" height="350px"
                                                style="height: 350px; display: block;" class="chartjs-render-monitor"
                                                width="713"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section class="col-lg-2 connectedSortable ui-sortable">
                            <div class="card p-2" style="position: relative; left: 0px; top: 0px; min-height:450px">
                                <div class="info-box mb-3 bg-info">
                                    <span class="info-box-icon"><i class="fa-solid fa-users"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Accounts</span>
                                        <span class="info-box-number">{{$taikhoan}}</span>
                                    </div>
                                </div>
                                <div class="info-box mb-3 bg-info">
                                    <span class="info-box-icon"><i class="fa-solid fa-arrow-right-to-bracket"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">SignIn Count</span>
                                        <span class="info-box-number">{{$sldangnhap}}</span>
                                    </div>
                                </div>
                                <div class="info-box mb-3 bg-info">
                                    <span class="info-box-icon"><i class="fa-solid fa-reply-all"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">RPR</span>
                                        <span class="info-box-number">{{$tiledangnhaplai}}</span>
                                    </div>
                                </div>
                                <div class="info-box mb-3 bg-info">
                                    <span class="info-box-icon"><i class="fa-solid fa-arrow-pointer"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Click</span>
                                        <span class="info-box-number">{{$tongclick}}</span>
                                    </div>
                                </div>

                            </div>

                        </section>
                    </div>
                </div>
            </section>
        </div>
        @include('user_24.admin24.include.footer')

    </div>

</body>

</html>

<script src="/admin/admin24/js/home.js"></script>

