<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">



    @include('user_24.admin24.include.header')
    {{-- <link rel="stylesheet" href="/admin/admin_24/plugins/summernote/summernote.min.css"> --}}


    <link rel="stylesheet" href="/admin/admin24/plugins/datatables2.1.2/dataTables.dataTables.css">
    <link rel="stylesheet" href="/admin/admin24/plugins/datatables2.1.2/fixedColumns.dataTables.css">

    <style>
        .card-header{
            font-weight: normal
        }
        .selected {
            background-color: #007bff;

            color: #fff;
        }
        th > select{
            width: 90%
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
            width: 400px;
            margin: 0 auto;
        }
    </style>

</head>

<body class="sidebar-mini sidebar-collapse">
    <div class="wrapper">
        {{-- @include('user_24.admin24.include.preloader') --}}
        @include('user_24.admin24.include.navbar')
        @include('user_24.admin24.include.sidebar')
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    @include('user_24.admin24.include.contentheader')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="card" style="height: 605px">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-md-3 col-12" style="margin-bottom: 5px">
                                                    <div class="form-group row" >
                                                        <label for="" class="col-sm-2 col-md-3 col-form-label" style="padding-bottom: 0px">Đợt TS:</label>
                                                        <div class="col-sm-10 col-md-9">
                                                            <select class="form-control " id="thxt_dotts"  style="width:100%;" >
                                                                <option value="-1">Chọn đợt tuyển sinh</option>
                                                                <option value="1">Xét tuyển sớm 2024</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-12" style="margin-bottom: 5px">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            {{-- <div class="style_all_button"> --}}
                                                                <div class="row">
                                                                    <div class="col-3">
                                                                        <button type="button" id="xuatexcelthongketrungtuyentheodotts" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;Excel</button>
                                                                    </div>
                                                                    <div class="col-3">
                                                                        <button type="button" id="phodiemtheodotts" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;Phổ điểm</button>
                                                                    </div>
                                                                    <div class="col-3">
                                                                        <button type="button" id="duyethoso" onclick="" class="btn btn-block btn-secondary btn-xs"><i class="fa-solid fa-chart-simple"></i>&nbsp;&nbsp;Khóa đợt TS</button>
                                                                    </div>
                                                                    <div class="col-3">
                                                                        <button type="button" id="xuatdanhsachtrungtuyenchinhthuc" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;DS trúng tuyển</button>
                                                                    </div>

                                                                </div>
                                                            {{-- </div> --}}
                                                        </div>
                                                        {{-- <div class="col-3"></div> --}}
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                        <div class="card-body" style="padding-bottom: 0px;padding-top: 3px;height:455px" id="">
                                            <div class="row">
                                                <div class="col-7">
                                                    <table class="table table-bordered table-hover table-striped dataTable no-footer dtr-inline" id="thxt_thongketrungtuyentheodotts"></table>
                                                </div>
                                                <div class="col-5">
                                                    <table class="table table-bordered table-hover table-striped dataTable no-footer dtr-inline" id="thxt_danhsachtrungtuyentheodotts"></table>
                                                </div>
                                            </div>

                                        </div>

                                        {{-- <div class="card-footer">
                                            <div class="col-md-12 col-12" style="margin-bottom: 5px">
                                                <div class="row">
                                                    <div class="col-8">
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="style_all_button">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <button type="button" id="duyetdanhsachxetuyentuyentheodot" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;Excel</button>
                                                                </div>
                                                                <div class="col-4">
                                                                    <button type="button" id="duyetdanhsachxetuyentuyentheodot" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;PDF</button>
                                                                </div>
                                                                <div class="col-4">
                                                                    <button type="button" id="duyethoso" onclick="" class="btn btn-block btn-secondary btn-xs"><i class="fa-solid fa-chart-simple"></i>&nbsp;&nbsp;Khóa đợt TS</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>


                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="card" style="min-height: 605px">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-md-3 col-12" style="margin-bottom: 5px">
                                                    <div class="form-group row" >
                                                        <label for="" class="col-sm-2 col-md-3 col-form-label" style="padding-bottom: 0px">Đợt TS:</label>
                                                        <div class="col-sm-10 col-md-9">
                                                            <select disabled class="form-control " id="thxt_dotts_xettuyen"  style="width:100%;" >
                                                                <option value="-1">Chọn đợt tuyển sinh</option>
                                                                <option value="1">Xét tuyển sớm 2024</option>
                                                                <option selected = "selected" value="2">Xét tuyển chung 2024</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-md-3 col-12" style="margin-bottom: 5px">
                                                    <div class="form-group row" >
                                                        <label for="" class="col-sm-2 col-md-3 col-form-label" style="padding-bottom: 0px">Đợt XT:</label>
                                                        <div class="col-sm-10 col-md-9">
                                                            <select class="form-control" id="thxt_dotxt"  style="width:100%;" >
                                                                <option value="-1">Chọn đợt xét tuyển</option>
                                                                <option value="1">Xét tuyển sớm 2024 - Đợt 1</option>
                                                                <option value="2">Xét tuyển sớm 2024 - Đợt 2</option>
                                                                <option value="3">Xét tuyển sớm 2024 - Đợt 3</option>
                                                                <option value="4">Xét tuyển sớm 2024 - Đợt 4</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                                <div class="col-md-3 col-12" style="margin-bottom: 5px">
                                                    <div class="form-group row" >
                                                        <label for="" class="col-sm-2 col-md-3 col-form-label" style="padding-bottom: 0px">Ng Vọng:</label>
                                                        <div class="col-sm-10 col-md-9">
                                                            <select disabled class="form-control" id="thxt_nguyenvong"  style="width:100%;" >
                                                                <option value="-1">Chọn Nguyện vọng</option>
                                                                <option value="1">Nguyện vọng 1</option>
                                                                <option value="2">Nguyện vọng 2</option>
                                                                <option value="3">Nguyện vọng 3</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12" style="margin-bottom: 5px">
                                                    <div class="form-group row" >
                                                        <label for="" class="col-sm-2 col-md-3 col-form-label" style="padding-bottom: 0px">Cách xét:</label>
                                                        <div class="col-sm-10 col-md-9">
                                                            <select disabled class="form-control" id="thxt_cachxet"  style="width:100%;" >
                                                                <option value="1">Ưu tiên Nguyện vọng -> Điểm</option>
                                                                <option value="2" selected = 'selected'>Ưu tiên Điểm -> Nguyện vọng</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-12" style="margin-bottom: 5px">
                                                    <div class="row">
                                                        <div class="col-1">
                                                        </div>
                                                        <div class="col-11">
                                                            <div class="style_all_button">
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <button type="button" id="themdotxettuyen_popup" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;Thêm đợt</button>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <button type="button" id="laydulieutheodot" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;Lấy dữ liệu</button>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <button type="button" id="luudanhsachtrungtuyentam" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;Lưu KQ</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <button type="button" id="trungtuyenchinhthucdotts" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;Trúng tuyển</button>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <button type="button" id="congboketquatheodotxt1" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;Khóa đợt</button>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <button type="button" id="congboketquatheodotxt" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;Công bố</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <button type="button" id="phodiemtheodotts" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;Gửi mail</button>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <button type="button" id="dieutraketquatheodotxt" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;Điều tra</button>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <button type="button" id="phodiemtheodotts" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;Exports</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-3"></div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body" style="padding-bottom: 0px;padding-top: 3px;min-height:455px" id="">
                                            <div class="row">
                                                <div class="col-12" id = "thxt_thongketheodotxettuyen_remove">
                                                    {{-- <table class="stripe row-border order-column" style="width:100%"  id="thxt_thongketheodotxettuyen"></table> --}}


                                                </div>
                                                {{-- <div class="col-7">
                                                    <table class="table table-bordered table-hover table-striped dataTable no-footer dtr-inline" id="thxt_danhsachtrungtuyenchinhthuc"></table>
                                                </div> --}}
                                            </div>

                                        </div>

                                        {{-- <div class="card-footer">
                                            <div class="col-md-12 col-12" style="margin-bottom: 5px">
                                                <div class="row">
                                                    <div class="col-8">
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="style_all_button">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <button type="button" id="duyetdanhsachxetuyentuyentheodot" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;Excel</button>
                                                                </div>
                                                                <div class="col-4">
                                                                    <button type="button" id="duyetdanhsachxetuyentuyentheodot" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;PDF</button>
                                                                </div>
                                                                <div class="col-4">
                                                                    <button type="button" id="duyethoso" onclick="" class="btn btn-block btn-secondary btn-xs"><i class="fa-solid fa-chart-simple"></i>&nbsp;&nbsp;Khóa đợt TS</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>



    </div>

        @include('user_24.modalevent')
        @include('user_24.admin24.include.footer')
    </div>

    <div class = "modal" id="modal_phodiem">
        <div style="background-color: rgba(250, 247, 247, 1);height: 100%;">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3 col-12" style="margin-bottom: 5px">
                            <div class="form-group row" >
                                <label for="" class="col-sm-4 col-md-4 col-form-label" style="padding-bottom: 0px">Nguyện vọng:</label>
                                <div class="col-sm-8 col-md-8">
                                    <select class="form-control " id="thxt_phodiem_nguyenvong"  style="width:100%;" >
                                        <option value="0">Tất cả nguyện vọng</option>
                                        <option value="1">Nguyện vọng 1</option>
                                        <option value="2">Nguyện vọng 2</option>
                                        <option value="3">Nguyện vọng 3</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-12" style="margin-bottom: 5px">
                            <div class="form-group row" >
                                <label for="" class="col-sm-12 col-md-3 col-form-label" style="padding-bottom: 0px">Ngành/Chuyên ngành:</label>
                                <div class="col-sm-12 col-md-8">
                                    <select class="form-control " id="thxt_phodiem_nganh"  style="width:100%;" >

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-12">
                            <div class="form-group row" style="margin-bottom: 1px">
                                <label for="thxt_phodiem_khoangdiem" class="col-sm-6 col-form-label" style="padding-bottom: 0px;">Khoảng điểm:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="thxt_phodiem_khoangdiem" value="0.5" style="height:28px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" id = "tam_phodiem-chart-canvas">
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="modal_dotxettuyen">
        <div style="vertical-align:middle;background-color: rgba(0,0,0,0.5);height: 100%;">
            <div class="row">
                <div class="col-md-3 col-12">
                </div>
                <div class="col-md-6 col-12">
                    <div class="card" style="width:70%; height:auto; padding: 2px; background-color:#fff; margin-top: 20%;margin-left: 20%;">
                        <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                            <div class="row">
                                <div class="col-md-11 col-lg-11 col-11">
                                    <span class="">Thêm đợt xét tuyển</span>
                                </div>
                                <div class="col-md-1 col-lg-1 col-1">
                                    <span class="float-right" style="margin-right: 10px"><i onclick="modal_close_accounts()" id='modal_number_go_wish_start_end_close' class="fas fa-times"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="name" class="col-sm-3 col-form-label" style="padding-bottom: 0px">Đợt xét tuyển:</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="" id='thxt_dotxettuyen_themdot' value="" class="form-control" style="height:28px">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12" style="margin-bottom: 5px">
                                    <div class="row">
                                        <div class="col-8">
                                        </div>
                                        <div class="col-4">
                                            <div class="style_all_button">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <button type="button" id="themdotxettuyen" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-compass-drafting"></i>&nbsp;&nbsp;Thêm đợt</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12">

                </div>
            </div>
        </div>
    </div>



</body>


<!-- summernote -->
{{-- <script src="/admin/admin_24/plugins/summernote/summernote.min.js"></script> --}}



</html>



<script src="/admin/admin24/js/quanlyxettuyen/thuchienxettuyen.js"></script>
<script src="/admin/admin24/plugins/datatables2.1.2/dataTables.js"></script>
<script src="/admin/admin24/plugins/datatables2.1.2/fixedColumns.dataTables.js"></script>
<script src="/admin/admin24/plugins/datatables2.1.2/dataTables.fixedColumns.js"></script>



<script>
    $("#example").DataTable({
        fixedColumns: true,
        paging: false,
        scrollCollapse: true,
        scrollX: true,
        scrollY: 300
    });
</script>
