<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-3 col-lg-3">
            <div class="card card-navy card-outline" style="min-height:600px">
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Tìm kiếm thông tin sinh viên</div>
                    <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                        <div class="col-md-12 col-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                            <label for="id_place_user" class="col-sm-3 col-form-label" style="padding-bottom: 0px">Lớp:</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" onchange="timkiem_lop()" id="xuathang_alllop" style="width: 100%;">
                                        </select>
                                    </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-12 col-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="xuathang_mssv" class="col-sm-4 col-form-label" style="padding-bottom: 0px">MSSV:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id='xuathang_mssv' style="height:28px;">
                                </div>
                            </div>
                        </div> --}}
                        <!--  -->
                        {{-- <div class="col-md-12 col-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="xuathang_cccd" class="col-sm-4 col-form-label" style="padding-bottom: 0px">CCCD:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id='xuathang_cccd' style="height:28px;">
                                </div>
                            </div>
                        </div> --}}
                        <!--  -->
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-9 col-lg-9">
            <div class="card card-navy card-outline" style="min-height:600px">
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Danh sách sinh viên</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" id="xuathang_dssv">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="modal_xuathang">
    <div style="vertical-align:middle;background-color: rgba(0,0,0,0.5);height: 100%;">
        <div class="row">
            <div class="col-md-2 col-12">
            </div>
            <div class="col-md-8 col-12">
            <div class="card card-navy card-outline" style="width:auto; height:auto; padding: 2px; background-color:#fff; margin-top: 10%;">
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                        <div class="row">
                            <div class="col-md-11 col-lg-11 col-11">
                                <span class="">Phát đồng phục</span>
                            </div>
                            <div class="col-md-1 col-lg-1 col-1">
                                <span class="float-right" style="margin-right: 10px"><i onclick="modal_close_xuathang()" id='modal_number_go_wish_start_end_close' class="fas fa-times"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                        <div class="tb_xuathang" id="tb_xuathang"></div>
                    </div>
                    {{--  --}}
                    <div class="col-md-12 col-12">
                        <div class="row">
                            <div class="col-md-3 col-6">
                                {{-- <button type="button"  onclick="banhang()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Xác nhận xuất</button> --}}
                            </div>
                            <div class="col-md-3 col-6">
                                {{-- <button type="button"  onclick="banhang()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Xác nhận xuất</button> --}}
                            </div>
                           <div class="col-md-3 col-6">
                                {{-- <button type="button"  onclick="banhang()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Xác nhận xuất</button> --}}
                            </div>
                            <div class="col-md-2 col-6">
                                <button type="button" id="bttbanhang" data-idsv="" id onclick="banhang()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Xác nhận xuất</button>
                            </div>
                        </div>
                    </div>
                    {{-- <div><button onclick="banhang()"></button></div> --}}
                </div>
            </div>
            <div class="col-md-2 col-12">
            </div>
        </div>
    </div>

</div>

<!--  -->


</html>




<script src="/template/admin/plugins/jquery/jquery.min.js"></script>
<script src="/template/admin/plugins/select2/js/select2.full.min.js"></script>
<script src="/template/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/template/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="/admin/js/dongphuc/xuathang/control.js"></script>
