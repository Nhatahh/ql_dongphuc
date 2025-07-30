
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-4 col-lg-4">
            <div class="card card-navy card-outline" id = 'left_check'>
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Thêm đợt lọc ảo</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                        <div class="col-md-12 col-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="id_go_batch_bo" class="col-sm-3 col-form-label" style="padding-bottom: 0px" >Mã đợt:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id='id_go_batch_bo' style="height:28px">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="name_go_batch_bo" class="col-sm-3 col-form-label" style="padding-bottom: 0px" >Đợt lọc ảo:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id='name_go_batch_bo' style="height:28px">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="go_batch_bo_ts" class="col-sm-3 col-form-label" style="padding-bottom: 0px">Đợt TS:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="go_batch_bo_ts" style="width: 100%;">

                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12 col-12">
                        <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                        <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                </div>
                                <div class="col-md-4 col-12">
                                    <button type="button"  id = "clear_go_batch_bo"  onclick="clear_go_batch_bo()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-broom"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                </div>
                                <div class="col-md-4 col-12">
                                    <button type="button" id = "add_go_batch_bo" onclick="add_go_batch_bo()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Thêm đợt</button>
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
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Danh sách đợt lọc ảo</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" id = "remove_load_go_batch_bo">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class = "modal" id="loadding_go_batch">
    <div style="text-align:center; background-color: rgba(0,0,0,0);height: 100%;">
        <div class="loader"></div>
    </div>
</div>

<div class = "modal" id="edit_go_batch_modal">
    <div style="vertical-align:middle;background-color: rgba(0,0,0,0.5);height: 100%;">
        <div class="row">
            <div class="col-md-4 col-12">
            </div>
            <div class="col-md-4 col-12">
                <div style="width:auto; height:auto;0 solid rgba(0,0,0,.125); padding: 2px;background-color:#fff; margin-top: 20%">
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                        <div class="row">
                            <div class="col-md-11 col-lg-11 col-1">
                                <span  class="">Cập nhật đợt lọc ảo</span>
                            </div>
                            <div class="col-md-1 col-lg-1 col-1">
                                <span  class="float-right" style="margin-right: 10px"><i onclick="close_go_batch_edit()" id = 'close_go_batch_edit' class="fas fa-times"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="id_go_batch_bo_edit" class="col-sm-3 col-form-label" style="padding-bottom: 0px" >Mã đợt:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id_go_batch_bo_edit_old ="" value="" id='id_go_batch_bo_edit' style="height:28px">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="name_go_batch_bo_edit" class="col-sm-3 col-form-label" style="padding-bottom: 0px" >Đợt lọc ảo:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name_go_batch_bo_edit_old = ""  value="" id='name_go_batch_bo_edit' style="height:28px">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="go_batch_bo_ts" class="col-sm-3 col-form-label" style="padding-bottom: 0px">Đợt TS:</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="go_batch_bo_ts_edit" style="width: 100%;">

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                            </div>
                            <div class="col-md-4 col-6">
                                <button type="button"  id = "clear_go_batch_bo_edit"  onclick="clear_go_batch_bo_edit()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-broom"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                            </div>
                            <div class="col-md-4 col-6">
                                <button type="button"  id = "add_go_batch_bo_edit"  id-data = '' onclick="add_go_batch_bo_edit()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-broom"></i>&nbsp;&nbsp;&nbsp;Cập nhật</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</html>

<script src="/admin/js/go_batch_bo/control.js"></script>
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

