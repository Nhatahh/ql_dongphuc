
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-4 col-lg-4">
            <div class="card card-navy card-outline" id = 'left_check'>
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Tìm kiếm thí sinh</div>
                    <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="elect_year" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Năm TS:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="elect_year" style="width: 100%;">

                                        </select>
                                    </div>
                                </div>
                            </div>
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
                                    <label for="elect_method" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Phương thức:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="elect_method" style="width: 100%;">

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
                                    <label for="elect_hktt" class="col-sm-4 col-form-label" style="padding-bottom: 0px">KHTT Tỉnh:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="elect_hktt" style="width: 100%;">

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
                    <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Điều kiện lấy phương thức</div>
                    <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                        <div class="row">
                            <div class="col-md-12 col-12">

                                <div class="input-group-prepend" style="margin-top: -7px">
                                    <input  class="type_top" type="radio" id = 'type_top1' id-data = "1" checked  name="type_top" style="margin-top: 2px">
                                    <div class="" style="padding-top: 7px;">
                                        <span class="" for = "type_top1" >&nbsp; Theo danh sách trúng tuyển</span>
                                    </div>
                                </div>

                                <div class="input-group-prepend" style="margin-top: 0px">
                                    <input class="type_top" type="radio" id = 'type_top2' onclick="type_top2()"  id-data = "2" name="type_top" style="margin-top: 2px">
                                    <div class="" style="padding-top: 7px;">
                                        <span class=""  for = "type_top2">&nbsp; Tính lại điểm theo từng phương thức</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="ccol-12 col-md-8 col-lg-8">
            <div class="card card-navy card-outline" id = 'right_check' >
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Danh sách thí sinh
                        <button style = "width: 100px;margin: 1px 2px" type="button"  id="elect_exp" class="btn btn-block btn-primary btn-xs float-right"><i class="fa-solid fa-marker"></i>&nbsp;&nbsp;&nbsp;DS Điểm</button>
                        <button style = "width: 100px;margin: 1px 2px" type="button"  id="elect_ttsv" class="btn btn-block btn-primary btn-xs float-right"><i class="fa-solid fa-circle-info"></i>&nbsp;&nbsp;&nbsp;DS TTSV</button>
                        <button style = "width: 100px;margin: 1px 2px" type="button"  id="elect_e" class="btn btn-block btn-primary btn-xs float-right"><i class="fa-solid fa-location-dot"></i>&nbsp;&nbsp;&nbsp;DS TT-QQ</button>




                        {{-- <button style = "width: 100px;margin: 1px 2px" type="button" onclick="elect_print()" id = "elect_print" class="btn btn-block btn-primary btn-xs float-right"><i class="fa fa-table"></i>&nbsp;&nbsp;&nbsp;In GBTT</button> --}}
                    </div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" id = "remove_list_elect">
                        {{-- <table class="table table-hover text-nowrap"  id = "load_list_reg"> --}}
                            {{-- Hiện thị Users--}}
                        {{-- </table> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    {{-- Modal Resize Ảnh học bạ lớp 10--}}


    <div class = "modal" id="modal_loadding_elect">
        <div  style="vertical-align: middle;text-align:center; background-color: rgba(0,0,0,0.5);height: 100%;">
            <div  style = "position: absolute; right: 0; left: 0; top: 0; bottom: 0; margin: auto; witdh:40px;height:40px; z-index:2">&nbsp;&nbsp;
                <img src = "https://congmotcua.ctuet.edu.vn/img/CTUT_logo.png" style="width:40px; height:auto">
                {{-- <span style="color:white"><strong id = "loadding_go_virtual_mess"></strong></span> --}}
            </div>
            <div  style = "position: absolute; right: 0; left: 0; top: 0; bottom: 0; margin: auto; witdh:100px; height:100px;z-index:1">&nbsp;&nbsp;
                <img src = "https://congmotcua.ctuet.edu.vn/img/Loading.gif"  style="width:100px; height:auto">
                {{-- <span style="color:white"><strong id = "loadding_go_virtual_mess"></strong></span> --}}
            </div>
        </div>
        {{-- <div style="text-align:center; background-color: rgba(0,0,0,0);height: 100%;">
            <div class="loader"></div>
        </div> --}}
    </div>

</html>



<script src="/admin/js/admission/control.js"></script>
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
