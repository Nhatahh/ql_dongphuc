
<html>
    <head>
        <!-- Theme style -->
        <link rel="stylesheet" href="/template/admin/dist/css/adminlte.min.css">
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                width: 595px;
                margin: 0 auto;
            }

            @media print{
                body{
                    -webkit-print-color-adjust: exact;
                    font-size: 13pt;
                    font-family: 'Times New Roman', Times, serif
                }

                .quophieu {
                    padding-top: 0;
                    text-align: center;
                }

                .slogan {
                    padding-top: 0;
                    text-align: center;
                    font-size: 14pt;
                    font-weight: bold;
                }

                .truong {
                    padding-top: 0;
                    text-align: center;
                }

                .phong {
                    padding-top: 0;
                    text-align: center;
                    font-weight: bold;
                }

                .hr1{
                    height: 2px;
                    margin: auto;
                    width: 30%;
                }

                .hr2{
                    height: 2px;
                    margin: auto;
                    width:  48%;
                }

                .nguoithu{
                    font-weight: bold;
                    margin-bottom: 0;
                    text-align: center;
                }
                .nguoithu1{
                    height: 250px;
                }

                .time{
                    font-style: italic;
                    text-align: center;
                }

                .tieude{
                    margin-top: 30px;
                    text-align: center;
                    font-weight: bold;
                    font-size: 15pt;
                }

                .noidung{
                    margin-bottom: 15px;
                    text-align: center;
                    font-weight: bold;
                    font-size: 13pt;
                }

                .total{
                    font-weight: bold;
                }

                .footer{
                    margin-top: 20px;
                }
            }

            @page {
                size: a4;
                margin: 2cm;
            }


        </style>
    </head>
    <body>
    <div>
        <table style="width: 100%">
            <tbody>
                <tr>
                    <td style="width: 50%">
                        <div class="truong">TRƯỜNG ĐẠI HỌC</div>
                    </td>
                    <td style="width: 50%">
                        <div class="quophieu">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</div>
                    </td>
                </tr>

                <tr>
                    <td style="width: 50%">
                        <div class="truong">KỸ THUẬT - CÔNG NGHỆ CẦN THƠ</div>

                    </td>
                    <td style="width: 50%">
                        <div class="slogan">Dộc lập - Tự do - Hạnh Phúc</div>
                    </td>
                </tr>

                <tr>
                    <td style="width: 50%">
                        <div class="phong">PHÒNG TÀI CHÍNH - KẾ TOÁN</div>
                    </td>
                    <td style="width: 50%;" >
                        <hr class="hr2">
                     </td>
                </tr>

                <tr>
                    <td style="width: 50%;" >
                       <hr class="hr1">
                    </td>

                    <td style="width: 50%">

                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="tieude"> DANH SÁCH
    </div>
    <div class="noidung"> Thu lệ phí hồ sơ tuyển sinh năm {{$year}}
    </div>



    <div>
        <table class="table table-hover">
            <thead>
                <th>STT</th>
                <th>ID</th>
                <th>Họ và tên</th>
                <th>Ngày sinh</th>
                <th>Số tiền</th>
                <th>Ngày thu</th>
                <th>Hình thức</th>
                <th>Ghi chú</th>
            </thead>
            <tbody>
                @for ($i = 0; $i <count($data); $i++)
                <tr>
                    <td>{{$i + 1}}</td>
                    <td>{{$data[$i] ->id_user}}</td>
                    <td>{{$data[$i] ->name_user}}</td>
                    <td>{{$data[$i] ->birth_user}}</td>
                    <td>{{$data[$i] ->price}}</td>
                    <td>{{$data[$i] ->update_at}}</td>
                    <td>{{$data[$i] ->form_check1}}</td>
                    <td></td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>
    <div>
        <span class="total">Tổng cộng: {{$total}} đồng/{{$num}} thí sinh</span><br>
        <span class="total">  Bằng chữ: <span class="total" style="font-style: italic">{{$total_text}}</span> </span>



    </div>
        <table class = "footer" style="width: 100%">
            <tbody>
                <tr>
                    <td style="width: 50%">
                        <div></div>
                    </td>
                    <td style="width: 50%">
                        <div class="time">Ngày ... tháng ... năm {{$year}}</div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%">
                        <div class="nguoithu">Duyệt</div>
                    </td>
                    <td style="width: 50%">
                        <div class="nguoithu">Cán bộ thu</div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%">
                        <div></div>
                    </td>
                    <td class="nguoithu1" style="width: 50%">
                        <div class = "nguoithu">{{$user[0]->name}}</div>
                    </td>
                </tr>
            </tbody>
        </table>

    </body>
</html>


{{--
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-5 col-lg-4">
            <div class="card card-navy card-outline" id = 'left_check'>
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Tìm kiếm thí sinh</div>
                    <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="id_place_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Năm TS: <sup style="font-size:small;color:Red">*</sup></label>

                                    <div class="col-sm-8">
                                        <select class="form-control" id="year_ex_sta" style="width: 100%;">

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="id_place_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Hình thức:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="form_ex_sta" style="width: 100%;">
                                            <option value="0">Chọn hình thức</option>
                                            <option value="1">Chuyển khoản</option>
                                            <option value="2">Tiền mặt</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="id_place_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Người thu:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control"  id="user_ex_sta" style="width: 100%;">

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="id_card_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px" >Ngày thu:</label>
                                    <div class="col-sm-8">
                                    <input type="date" class="form-control" id='day_ex_sta' style="height:28px">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-12">
                                <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                                <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <button type="button"  id = "clear_ex_sta" class="btn btn-block btn-primary btn-xs"><i class="fa fa-broom"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <button type="button"  id = "search_ex_sta" class="btn btn-block btn-primary btn-xs"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Tìm kiếm</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px; margin-top: 10px;font-weight: bold;">Tra cứu thông tin thí sinh</div>
                    <div class="card-body" style="padding-top: 3px; padding-bottom:0px"  id = "remove_load_list_infor">


                    </div>
                </div>

            </div>
        </div>




        <div class="ccol-12 col-md-7 col-lg-8">
            <div class="card card-navy card-outline" id = 'right_check' >
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Danh sách thí sinh
                        <button style = "width: 100px;margin: 1px 2px" type="button"  id = "print_ex_sta" class="btn btn-block btn-primary btn-xs float-right"><i class="fa fa-print"></i>&nbsp;&nbsp;&nbsp;In</button>
                        <button style = "width: 100px;margin: 1px 2px" type="button"  id = "excel_ex_sta" class="btn btn-block btn-primary btn-xs float-right"><i class="fa fa-table"></i>&nbsp;&nbsp;&nbsp;Xuất excel</button>
                    </div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" id = "remove_load_list_ex">


                    </div>



                </div>
            </div>
        </div>
    </div>
</div>
<div class="excel_ex_sta" style="display:none">
    <div class="card-body " style="padding-bottom: 0px;padding-top: 3px" id = "remove_load_list_ex1">
    </div>
</div>



</html>

<script src="/admin/js/expenses_sta/control.js"></script>
<script src="/template/admin/plugins/jquery/jquery.min.js"></script>
<script src="/template/admin/plugins/select2/js/select2.full.min.js"></script>
{{-- <script src="/bxslider/dist/jquery.bxslider.min.js"></script> --}}


{{--
<script src="/template/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/template/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/jszip/jszip.min.js"></script>
<script src="/template/admin/plugins/pdfmake/pdfmake.min.js"></script>
<script src="/template/admin/plugins/pdfmake/vfs_fonts.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script src="/croppie/croppie.js"></script> --}}
{{-- }} --}}
