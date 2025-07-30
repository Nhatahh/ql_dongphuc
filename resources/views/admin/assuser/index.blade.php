
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-3 col-lg-3">
            <div class="card card-navy card-outline" id = 'left_check'>
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Cài đặt phân công</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="input-group-prepend" style="margin-top: 0px">
                                    <input class="active_ass" type="radio" id = 'active1_ass' id-data = "1" name="radio1_check" style="margin-top: 2px">
                                    <div class="" style="padding-top: 7px;">
                                        <span class="" >&nbsp; Tự động phân công</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="input-group-prepend" style="margin-top: -7px">
                                    <input  class="active_ass" type="radio" id = 'active2_ass' id-data = "2"  name="radio1_check" style="margin-top: 2px">
                                    <div class="" style="padding-top: 7px;">
                                        <span class="" >&nbsp; Chọn thí sinh phân công</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-12">
                                <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                                <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <button type="button" onclick="auto_ass()" id = "auto_ass" class="btn btn-block btn-primary btn-xs"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Phân công</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Danh sách nhân viên</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" id = "remove_load_list_assuser">

                    </div>
                </div>
            </div>
        </div>


        <div class="ccol-12 col-md-9 col-lg-9">
            <div class="card card-navy card-outline" id = 'right_check' >
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Điều kiện tìm kiếm</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                        <div class = "row">

                            <div class="col-md-4 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="year_check_ass" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Năm TS:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="year_check_ass" style="width: 100%;">

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="batch_check_ass" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Đợt TS:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="batch_check_ass" style="width: 100%;">

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="batch_check_ass" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Nhân viên:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="user_check_ass" style="width: 100%;">

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="year_check_ass" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Phân công:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="active_check_ass" style="width: 100%;">

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="year_check_ass" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Kiểm tra:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="block_check_ass" style="width: 100%;">

                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-4 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="year_check_ass" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Duyệt:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="pass_check_ass" style="width: 100%;">

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="id_card_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px" >Ngày PC:</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" id='day_ess' style="height:28px">
                                    </div>
                                </div>
                            </div>



                            <div class="col-md-4 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="id_card_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px" >Ngày ĐK:</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" id='day_reg_ess' style="height:28px">
                                    </div>
                                </div>
                            </div>




                            <div class="col-md-4 col-12">
                                <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                                <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <button type="button"  id = "clear_check_ass" class="btn btn-block btn-primary btn-xs"><i class="fa fa-broom"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <button type="button"  id = "search_check_ass" class="btn btn-block btn-primary btn-xs"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Tìm kiếm</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 10px;font-weight: bold;">Danh sách thí sinh
                    </div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" id = "remove_load_list_assstudent">
                        {{-- <input style = "background:inherit,heigt:inherit; width:inherit"> --}}
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-12"></div>
                        <div class="col-md-2 col-12"></div>
                        <div class="col-md-6 col-12">
                            <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                            <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <button  type="button"  class="btn btn-block btn-primary btn-xs"><i class="fa fa-list"></i>&nbsp;&nbsp;&nbsp;Xem thống kê</button>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <button  type="button"  class="btn btn-block btn-primary btn-xs"><i class="fa fa-table"></i>&nbsp;&nbsp;&nbsp;Xuất Excel</button>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <button  type="button"  onclick="ass_pass()" id = "ass_pass" class="btn btn-block btn-primary btn-xs"><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp;Duyệt</button>
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
<div class = "modal" id="loadding_ass">
    <div style="text-align:center; background-color: rgba(0,0,0,0);height: 100%;">
        <div class="loader"></div>
    </div>
</div>

</html>

<script src="/admin/js/assuser/control.js"></script>
<script src="/template/admin/plugins/jquery/jquery.min.js"></script>
<script src="/template/admin/plugins/select2/js/select2.full.min.js"></script>

<script src="/swiper/swiper.js"></script>
<script src="/template/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/template/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>



{{-- <script src="/template/admin/plugins/jszip/jszip.min.js"></script> --}}
{{-- <script src="/template/admin/plugins/pdfmake/pdfmake.min.js"></script>
<script src="/template/admin/plugins/pdfmake/vfs_fonts.js"></script> --}}
{{-- <script src="/template/admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script> --}}

{{-- <script src="/croppie/croppie.js"></script> --}}

