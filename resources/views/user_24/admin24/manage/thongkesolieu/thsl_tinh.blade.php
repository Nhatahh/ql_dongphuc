<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('user_24.admin24.include.header')
    {{-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" /> --}}
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/2.1.2/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/5.0.1/css/fixedColumns.dataTables.css"> -->
    <!-- Thêm MapLibre GL CSS -->
    {{-- <link href="https://unpkg.com/maplibre-gl@^4.7.1/dist/maplibre-gl.css" rel="stylesheet" /> --}}

    {{-- <link rel="stylesheet" href="https://unpkg.com/ol@latest/dist/ol.css" /> --}}

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <style>


        #map { width: 100%; height: 600px; }
        .chart-container { width: 50%; margin-top: 20px; }

        #thsl_tinh_map {
            height: 700px;
            width: 100%;
        }


/* Popup cơ bản */
        #thsl_truong_popup {
            display: none; /* Ban đầu ẩn popup */
            position: absolute;
            width: 350px;
            padding: 3px;
            background-color: #ffffff;
            border-radius: 10px; /* Bo góc */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1); /* Bóng đổ mềm mại */
            z-index: 9999; /* Đảm bảo popup luôn ở trên cùng */
            opacity: 0;
            transition: opacity 0.3s ease, transform 0.3s ease; /* Hiệu ứng mờ dần và chuyển động */
            transform: scale(0.95); /* Thu nhỏ khi popup xuất hiện */
        }

        /* Tiêu đề popup */
        #thsl_truong_popup h3 {
            font-size: 14px;
            color: #2c3e50;
            text-align: center;
            margin-bottom: 3px;
            font-weight: bold;
        }



        /* Các trường input và label */
        .input-container {
            margin: 3x 0;
            font-size: 14px;
        }

        .input-container label {
            display: block;
            font-size: 14px;
            color: #2c3e50;
            margin-bottom: 3px;
            font-weight: 600;
        }

        .input-container input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            background-color: #f9f9f9;
            transition: all 0.3s ease;
        }

        /* Hiệu ứng focus vào ô input */
        .input-container input:focus {
            border-color: #3498db;
            background-color: #ecf6ff;
            outline: none;
        }

        /* Nút Gửi thông tin */
        #submit-btn {
            width: 100%;
            padding: 3px;
            font-size: 14px;
            color: #fff;
            background-color: #3498db;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 3px;
            transition: all 0.3s ease;
        }

        #submit-btn:hover {
            background-color: #2980b9;
        }

        /* Nút đóng popup */
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 22px;
            color: #ccc;
            background: none;
            border: none;
            cursor: pointer;
        }

        .close-btn:hover {
            color: #2c3e50;
        }



        /* #popup {
            position: absolute;
            background-color: white;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            pointer-events: none;
            visibility: hidden;
        } */

        /* #popup-content {
            color: black;
        } */

        .card-footer{
            background-color: #fff;
        }
        th, td {
            white-space: nowrap;

        }

        .text-center{
            text-align: center;

        }

        .border-right{
            border-right:1px solid rgba(0, 0, 0, 0.15)
        }


        table.dataTable > tbody > tr > th, table.dataTable > tbody > tr > td {
            padding: 0px 4px;
        }
        table.dataTable > thead > tr > th, table.dataTable > thead > tr > td{
            padding: 0px 4px;
        }

        table.dataTable>thead>tr>th:not(.sorting_disabled), table.dataTable>thead>tr>td:not(.sorting_disabled){
            padding:0px 4px;
        }

        div.dataTables_wrapper {
            /* width: 400px; */
            margin: 0 auto;
        }


        /* .equal-height {
            display: flex;
        }

        .equal-height .card {
            flex: 1;
        }
 */





    </style>
</head>

<body class="sidebar-mini sidebar-collapse">

    <div class="wrapper">
        <!-- Preloader -->

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

                    <!-- Popup -->
                    <div id="thsl_truong_popup">
                        <button class="close-btn">&times;</button>
                        <h3 id = 'thsl_popup_tentruong'></h3>

                        <!-- Input cho Kinh độ -->
                        <div class="input-container">
                            <label for="thsl_longitude">Kinh độ</label>
                            <input type="text" id="thsl_longitude">
                        </div>

                        <!-- Input cho Vĩ độ -->
                        <div class="input-container">
                            <label for="thsl_latitude">Vĩ độ</label>
                            <input type="text" id="thsl_latitude">
                        </div>

                        <!-- Gửi thông tin -->
                        <button id="thsl_truong_popup_sumit">Lưu vị trí</button>
                    </div>
                    <div class="row">
                        <div class="col-9">
                            <div class="card card-primary card-outline card-outline-tabs block-left">
                                <div class="card-header p-1">Phân bố theo bản đồ địa lý</div>
                                <div class="card-body p-1">
                                    <div id="thsl_tinh_map" width= "500px">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="card card-primary card-outline card-outline-tabs block-right">
                                <div class="card-header p-1">
                                    Tỉ lệ phân bố theo Tỉnh/TP
                                </div>
                                <div class="card-body p-2" >
                                        <div class="row bieudo-pie p-2" style="" >
                                            <div class="col-12" style="text-align:center; border: 1px solid rgba(0,0,0,.125)">
                                                <div style = "font-weight:bold;margin-bottom:5px">Đăng ký xét tuyển</div>
                                                <div id = "thsl_tinh_bieudodangky_pie_load" style="height: 200px">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row bieudo-pie p-2" style="" >
                                            <div class="col-12" style="text-align:center; border: 1px solid rgba(0,0,0,.125)">
                                                <div style = "font-weight:bold;margin-bottom:10px">Trúng tuyển</div>
                                                <div id = "thsl_tinh_bieudotrungtuyen_pie_load" style="height: 200px">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row bieudo-pie p-2" style="" >
                                            <div class="col-12" style="text-align:center; border: 1px solid rgba(0,0,0,.125)">
                                                <div style = "font-weight:bold;margin-bottom:10px">Nhập học</div>
                                                <div id = "thsl_tinh_bieudo_pie_load" style="height: 200px">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-2">
                                                    <div class="form-group row">
                                                        <label for="thsl_tinh_namtuyensinh" class="col-12 col-form-label" style="padding-bottom: 0px ">Năm TS:</label>
                                                        <div class="col-12">
                                                            <select  val-def = "0" class="search form-control thsl_tinh_search" id="thsl_tinh_namtuyensinh" name = 'thsl_tinh_namtuyensinh' style="width: 100%;">
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group row">
                                                        <label for="thsl_tinh_dotts" class="col-12 col-form-label" style="padding-bottom: 0px ">Tỉnh:</label>
                                                        <div class="col-12">
                                                            <select  val-def = "0" class="search form-control thsl_tinh_search" id="thsl_tinh_dotts" name = 'thsl_tinh_dotts' style="width: 100%;"></select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group row">
                                                        <label for="thsl_tinh_namtotnghiep" class="col-12 col-form-label" style="padding-bottom: 0px ">Năm tốt nghiệp:</label>
                                                        <div class="col-12">
                                                            <select  val-def = "0" class="search form-control thsl_tinh_search" id="thsl_tinh_namtotnghiep" name = 'thsl_tinh_namtotnghiep' style="width: 100%;"></select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group row">
                                                        <label for="thsl_tinh_tinh" class="col-12 col-form-label" style="padding-bottom: 0px ">Tỉnh:</label>
                                                        <div class="col-12">
                                                            <select  val-def = "0" class="search form-control thsl_tinh_search" id="thsl_tinh_tinh" name = 'thsl_tinh_tinh' style="width: 100%;"></select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-1">
                                                    <div class="form-group row">
                                                        <label for="thsl_tinh_topnhaphoc" class="col-12 col-form-label" style="padding-bottom: 0px ">Top NH:</label>
                                                        <div class="col-12">
                                                            <input type="number"  class="search form-control thsl_tinh_search" id="thsl_tinh_topnhaphoc" name = "thsl_tinh_topnhaphoc" style="height:28px; width:100%" value="0">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-1">
                                                    <div class="form-group row">
                                                        <label for="thsl_tinh_soluong" class="col-12 col-form-label" style="padding-bottom: 0px ">Số lượng:</label>
                                                        <div class="col-12">
                                                            <input type="number"  class="search form-control thsl_tinh_search" id="thsl_tinh_soluong" name = "thsl_tinh_soluong" style="height:28px; width:100%" value="0">
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="col-2" style="position: relative;">
                                                    <div class="" style="position: absolute; bottom: 0;">
                                                        <div class="form-check">
                                                            <input  type="radio" class="form-check-input thsl_tinh_search" id="thsl_tinh_check_tile_sl" checked name = "thsl_tinh_check_tile" style="height:12px">
                                                            <label class="form-check-label" for="exampleCheck1">Theo số lượng</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="radio" class="form-check-input thsl_tinh_search" id="thsl_tinh_check_tile_tl"  name = "thsl_tinh_check_tile" style="height:12px">
                                                            <label class="form-check-label" for="exampleCheck1">Theo tỉ lệ</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12" style="border: 1px solid rgba(0,0,0,.125);height: 250px; margin-top:3px" id="thsl_tinh_bieudo_tinh_empty">
                                                </div>
                                            </div>
                                        </div>
                                        <div  class="col-12" style="text-align:center;margin-bottom:15px" >
                                            <div style = "font-weight:bold">Phân bố Đăng ký - Trúng tuyển - Nhập học theo Tỉnh/Thành phô&nbsp;&nbsp;<i class="fa-regular fa-file-excel"  onclick="thsl_tinh_excel()"></i></button></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('user_24.admin24.include.preloader')
            </section>
        </div>
        @include('user_24.admin24.include.footer')
    </div>
    @include('user_24.modalevent')
</body>
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="/admin/admin24/js/thongkesolieu/thsl_tinh.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/echarts@5.3.2/dist/echarts.min.js"></script>
<!-- Thêm dữ liệu bản đồ Việt Nam -->
<script src="https://cdn.jsdelivr.net/npm/echarts@5.3.2/dist/extension/bmap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/echarts@5.3.2/dist/extension/echarts-map.js"></script> --}}




{{-- <script src="https://unpkg.com/maplibre-gl@^4.7.1/dist/maplibre-gl.js"></script> --}}

<script src="https://unpkg.com/ol@latest/dist/ol.js"></script>



</html>



