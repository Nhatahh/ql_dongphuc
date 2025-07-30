<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('user_24.admin24.include.header')



    <style>

/* Định dạng bảng con */
table.table-bordered {
    border-collapse: collapse;
    margin-top: 10px;
}

table.table-bordered th,
table.table-bordered td {
    padding: 8px 12px;
    text-align: center;
}

table.table-sm th,
table.table-sm td {
    font-size: 14px;
}

/* Hiệu ứng cho dòng được mở rộng */
tr.shown td {
    background-color: #f9f9f9;
    font-weight: bold;
    border-top: 2px solid #ddd;
}

/* Các hiệu ứng mượt mà khi mở rộng bảng con */
tr.next-tr {
    display: none;
    animation: slide-down 0.3s ease-out;
}

@keyframes slide-down {
    from {
        max-height: 0;
    }
    to {
        max-height: 500px;
    }
}




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

                    <div class="row">
                        <div class="col-12" >
                            <div class="card">
                                <div class="card-header p-1">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group row" >
                                                <label for="" class="col-3 col-form-label" style="padding-bottom: 0px">Năm tuyển sinh:</label>
                                                <div class="col-9">
                                                    <select  class="form-control" id="thsl_trungtuyen_nhaphoc_namts"  style="width:100%;" >

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group row" >
                                                <label for="" class="col-3 col-form-label" style="padding-bottom: 0px">Đợt tuyển sinh:</label>
                                                <div class="col-9">
                                                    <select  class="form-control" id="thsl_trungtuyen_nhaphoc_dotts"  style="width:100%;" >

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="row">
                                                <div class="col-md-4 col-4">
                                                    <button style="background-color: #fff; color:#007bff;" type="button" id="thsl_trungtuyen_nhaphoc_clear" onclick="thsl_trungtuyen_nhaphoc_clear()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                                </div>
                                                <div class="col-md-4 col-4">
                                                    <button type="button" id="thsl_trungtuyen_nhaphoc_search" btt_id_add="3" data-id="" onclick="thsl_trungtuyen_nhaphoc_search()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-search"></i>&nbsp;&nbsp;&nbsp;Tìm kiếm</button>
                                                </div>
                                                <div class="col-md-4 col-4">
                                                    <button type="button" id = "thsl_trungtuyen_nhaphoc_xuat_ds_thongke" class="btn btn-block btn-primary btn-xs"><i class="fa-regular fa-file-excel" ></i>&nbsp;&nbsp;&nbsp;Danh sách</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" style="min-height: 550px">
                                    <div class="row">
                                        <div class="col-12 p-1">
                                            <table class="table table-bordered table-hover" id="thsl_trungtuyen_nhaphoc_thongke" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2">STT</th>
                                                        <th colspan="2">Ngành đào tạo</th>
                                                        <th colspan="4">Đăng ký</th>
                                                        <th colspan="6">Trúng tuyển</th>
                                                        <th colspan="7">Nhập học</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Ngành</th>
                                                        <th>CT</th>

                                                        <th>SL</th>
                                                        <th>Cạnh tranh</th>
                                                        <th>TTS</th>
                                                        <th>TTS/CT</th>

                                                        <th>SL</th>
                                                        <th>TL/ĐK</th>
                                                        <th>TL/CT</th>
                                                        <th>TTS</th>
                                                        <th>TLS/TT</th>
                                                        <th>TLS/CT</th>

                                                        <th>SL</th>
                                                        <th>TL/CT</th>
                                                        <th>TL/TT</th>
                                                        <th>TTS</th>
                                                        <th>TLS/TT</th>
                                                        <th>TLS/NH</th>
                                                        <th>#</th>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-12">
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-header p-1" >Bảng phân tích theo số lượng trúng tuyển - nhập học&nbsp;&nbsp;
                                    <i class="fa-regular fa-file-excel" id = "thsl_trungtuyen_nhaphoc_xuat_ds_thongke"></i>
                                </div>

                            </div>
                        </div> --}}
                    </div>
                </div>
                {{-- @include('user_24.admin24.include.preloader') --}}
            </section>
        </div>
        @include('user_24.admin24.include.footer')
    </div>
    @include('user_24.modalevent')
    <div class="modal" id="modal_danhsachnganh" style="padding: 10px;heihgt:100%;">
        <div id = "danhsach_height" class="card">
            <div class="card-header p-1" style="display: flex; align-items: center;">
                <span id = "modal_danhsachnganh_tennganh"></span>&nbsp;&nbsp;
                <i class="fa-regular fa-file-excel" id = "thsl_trungtuyen_nhaphoc_xuat_ds_nganh" onclick=""></i>
                <i class="fa-solid fa-xmark" id = 'modal_danhsachnganh_close'   style="margin-left: auto;" onclick="modal_danhsachnganh_close()"></i>
            </div>
            <div class="card-body">
                <div id="danhsach" style="padding: 10px;height: 100%">
                    <table class="table table-bordered table-hover" id="thsl_trungtuyen_nhaphoc_modal_danhsachnganh">
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script src="https://unpkg.com/ol@latest/dist/ol.js"></script>
<script src="/admin/admin24/js/thongkesolieu/thsl_trungtuyen_nhaphoc.js"></script>


</html>

<script>




</script>

