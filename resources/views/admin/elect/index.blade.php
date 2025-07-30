
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-3 col-lg-3">
            <div class="card card-navy card-outline" id = 'left_check'>
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Tìm kiếm thí sinh</div>
                    <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="elect_batch" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Đợt TS:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="elect_batch" style="width: 100%;">

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="elect_major" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Ngành TS:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="elect_major" style="width: 100%;">

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="elect_id_card" class="col-sm-4 col-form-label" style="padding-bottom: 0px" >CMND/TCC:</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control" id='elect_id_card' style="height:28px">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="elect_id" class="col-sm-4 col-form-label" style="padding-bottom: 0px" >ID:</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control" id='elect_id' style="height:28px">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                                <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            {{-- <button type="button" id = "excel_investigate" onclick="excel_investigate()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-list"></i>&nbsp;&nbsp;&nbsp;Danh sách</button> --}}
                                            {{-- <button type="button"  id = "clear_check" class="btn btn-block btn-primary btn-xs"><i class="fa fa-broom"></i>&nbsp;&nbsp;&nbsp;Làm mới</button> --}}
                                        </div>
                                        {{-- <div class="col-md-6 col-12">
                                            <button type="button"  id = "nvqs_search" class="btn btn-block btn-primary btn-xs"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Tìm kiếm</button>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Chọn người ký</div>
                    <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="elect_sig" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Người ký:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id = "elect_sig" style="width: 100%;">
                                            <option value="0">Chọn người ký</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="ccol-12 col-md-9 col-lg-9">
            <div class="card card-navy card-outline" id = 'right_check' >
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Danh sách thí sinh

                            {{-- <div class="form-group row  float-right" style="margin-bottom: 3px">
                                <label for="nvqs_investigate" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Ngành TS:</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="nvqs_investigate" style="width: 100%;">

                                    </select>
                                </div>
                            </div> --}}

                        <button style = "width: 100px;margin: 1px 2px" type="button"  id = "investigate_excel" class="btn btn-block btn-primary btn-xs float-right"><i class="fa fa-table"></i>&nbsp;&nbsp;&nbsp;In danh sách</button>
                        <button style = "width: 100px;margin: 1px 2px" type="button" onclick="elect_print()" id = "elect_print" class="btn btn-block btn-primary btn-xs float-right"><i class="fa fa-table"></i>&nbsp;&nbsp;&nbsp;In GBTT</button>
                    </div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" id = "remove_list_elect">
                        {{-- <table class="table table-hover text-nowrap"  id = "load_list_reg"> --}}
                            {{-- Hiện thị Users--}}
                        {{-- </table> --}}

                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card card-navy card-outline">
                <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Thống kê xác nhận nhập học
                    <button style = "width: 100px;margin: 1px 2px" type="button"  id = "investigate_excel" class="btn btn-block btn-primary btn-xs float-right"><i class="fa fa-table"></i>&nbsp;&nbsp;&nbsp;Xuất excel</button>
                </div>
                <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12" id="investigate_chart">

                        </div>
                        <div class="col-12 col-md-12 col-lg-12" id="investigate_table">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    {{-- Modal Resize Ảnh học bạ lớp 10--}}


    <div class = "modal" id="modal_loadding_check_user">
        <div style="text-align:center; background-color: rgba(0,0,0,0);height: 100%;">
            <div class="loader"></div>
        </div>
    </div>

</html>



<script src="/admin/js/elect/control.js"></script>
<script src="/template/admin/plugins/jquery/jquery.min.js"></script>
<script src="/template/admin/plugins/select2/js/select2.full.min.js"></script>
<script src="/chart/chart.js"></script>
<script src="/chart/config.js"></script>
<script src="/exceljs/control.js"></script>
<script src="/template/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/template/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
