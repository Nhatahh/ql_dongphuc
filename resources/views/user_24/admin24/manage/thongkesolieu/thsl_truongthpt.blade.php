<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('user_24.admin24.include.header')



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
                        <div class="col-2">
                            <div class="card card-primary card-outline card-outline-tabs block-left">
                                <div class="card-header p-1" >Điều kiện tìm kiếm
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="thsl_namtuyensinh" class="col-12 col-form-label" style="padding-bottom: 0px ">Năm TS:</label>
                                        <div class="col-12">
                                            <select  val-def = "0" class="search form-control thsl_search" id="thsl_namtuyensinh" name = 'thsl_namtuyensinh' style="width: 100%;">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="thsl_namtotnghiep" class="col-12 col-form-label" style="padding-bottom: 0px ">Năm tốt nghiệp:</label>
                                        <div class="col-12">
                                            <select  val-def = "0" class="search form-control thsl_search" id="thsl_namtotnghiep" name = 'thsl_namtotnghiep' style="width: 100%;"></select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="thsl_tinh" class="col-12 col-form-label" style="padding-bottom: 0px ">Tỉnh:</label>
                                        <div class="col-12">
                                            <select  val-def = "0" onchange="thsl_change_tinh()" class="search form-control thsl_search" id="thsl_tinh" name = 'thsl_tinh' style="width: 100%;"></select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="thsl_truongthpt" class="col-12 col-form-label" style="padding-bottom: 0px ">Trường THPT:
                                            &nbsp;<sup><i id = "thsl_truongthpt_toado" id_truong = "" style="color:#ffc107" onclick="" class="fa-solid fa-location-dot"></i></sup>
                                        </label>
                                        <div class="col-12">
                                            <select  val-def = "0" class="search form-control thsl_search" id="thsl_truongthpt" name = 'thsl_truongthpt' style="width: 100%;"></select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="thsl_topnhaphoc" class="col-12 col-form-label" style="padding-bottom: 0px ">Top nhập học:</label>
                                        <div class="col-12">
                                            <input type="number"  class="search form-control thsl_search" id="thsl_topnhaphoc" name = "thsl_topnhaphoc" style="height:28px; width:100%" value="10">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="thsl_soluong" class="col-12 col-form-label" style="padding-bottom: 0px ">Nhập học:</label>
                                        <div class="col-12">
                                            <input type="number"  class="search form-control thsl_search" id="thsl_soluong" name = "thsl_soluong" style="height:28px; width:100%" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="card card-primary card-outline card-outline-tabs block-right">
                                <div class="card-header p-1" style="text-align:center">
                                    Phân bố Số lượng theo Trường THPT&nbsp;&nbsp;<i class="fa-regular fa-file-excel" onclick="thsl_truong_excel()" ></i>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12" style="border: 1px solid rgba(0,0,0,.125);height: 250px; margin-top:3px" id="thsl_tinh_bieudo_bar_empty">

                                        </div>
                                        <div style="margin-top: 10px" class="col-12" id="map">

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


<script src="/admin/admin24/js/thongkesolieu/thsl_truongthpt.js"></script>
<script src="https://unpkg.com/ol@latest/dist/ol.js"></script>



</html>



