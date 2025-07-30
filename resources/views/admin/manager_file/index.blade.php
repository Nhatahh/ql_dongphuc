
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card card-navy card-outline" style="min-height: 600px">
                <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Danh sách thí sinh</div>
                <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="manager_file_batch" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Đợt TS:</label>
                                <div class="col-sm-8">
                                    <select class="form-control"  id="manager_file_batch" style="width: 100%;">

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="manager_file_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Người thu:</label>
                                <div class="col-sm-8">
                                    <select class="form-control"  id="manager_file_user" style="width: 100%;">

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="startday_manager_file" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Từ ngày:</label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control" id="startday_manager_file" style="height:28px">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="endday_manager_file" class="col-sm-4 col-form-label" style="padding-bottom: 0px">đến ngày:</label>
                                <div class="col-sm-8">
                                <input type="date" class="form-control" id="endday_manager_file" style="height:28px">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9 col-12"> </div>

                        <div class="col-md-3 col-12">
                            <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                            <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <button type="button"  id = "manager_file_search" class="btn btn-block btn-primary btn-xs"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Tìm kiếm</button>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <button type="button" id = "manager_file_excel" onclick="manager_file_excel()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-list"></i>&nbsp;&nbsp;&nbsp;Danh sách</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-12" style="border: 2px solid  #dee2e6; min-height:530px;margin:3px">
                            <div class="card-body" id = "manager_file_list_remove">
                                {{-- <table class="table table-hover text-nowrap"  id = "load_list_reg"> --}}
                                    {{-- Hiện thị Users--}}
                                {{-- </table> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class = "modal" id="manager_file_modal">
    <div  style="vertical-align: middle;text-align:center; background-color: rgba(0,0,0,0.5);height: 100%;">
        <div  style = "position: absolute; right: 0; left: 0; top: 0; bottom: 0; margin: auto; witdh:40px;height:40px;">&nbsp;&nbsp;
            <img src = "https://xettuyentest.ctuet.edu.vn/img/Loading.gif" width="40px" height="auto">
            {{-- <img src = "https://congmotcua.ctuet.edu.vn/img/Loading.gif" width="40px" height="auto"> --}}
            {{-- <span style="color:white"><strong id = "loadding_go_virtual_mess"></strong></span> --}}
        </div>
    </div>
</div>

</html>



<script src="/admin/js/manager_file/control.js"></script>
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


