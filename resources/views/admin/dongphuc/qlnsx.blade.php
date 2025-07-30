<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-3 col-lg-3" >
            <div class="card card-navy card-outline" style="min-height:600px" >
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Thêm Nhà sản xuất</div>
                    <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                        <div class="col-md-12 col-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="id_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Nhà SX:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id='nsx_ten' style="height:28px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="id_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Điện thoại:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id='nsx_dienthoai' style="height:28px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="nsx_chucoso" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Chủ cơ sở:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id='nsx_chucoso' style="height:28px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="nsx_diachi" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Địa chỉ:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id='nsx_diachi' style="height:28px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="nsx_email" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Email:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id='nsx_email' style="height:28px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                    <div class="row">
                        <div class="col-md-6 col-6">
                            <button type="button" id="" onclick="nsx_clear()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;&nbsp;Clear</button>
                        </div>
                        <div class="col-md-6 col-6">
                            <button type="button" id="" onclick="nsx_them()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Thêm</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-9 col-lg-9">
            <div class="card card-navy card-outline" style="min-height:600px">
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Danh sách nhà sản xuất</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" id="nsx_danhsachnsx">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="modal_editnsx">
    <div style="vertical-align:middle;background-color: rgba(0,0,0,0.5);height: 100%;">
        <div class="row">
            <div class="col-md-2 col-12">
            </div>
            <div class="col-md-8 col-12">
            <div class="card card-navy card-outline" style="width:auto; height:auto; padding: 2px; background-color:#fff; margin-top: 20%;">
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                        <div class="row">
                            <div class="col-md-11 col-lg-11 col-11">
                                <span class="">Cập nhật nhà sản xuất</span>
                            </div>
                            <div class="col-md-1 col-lg-1 col-1">
                                <span class="float-right" style="margin-right: 10px"><i onclick="modal_close_nsx()" id='modal_number_go_wish_start_end_close' class="fas fa-times"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                        <form id="editnsx">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="name" class="col-sm-2 col-form-label" style="padding-bottom: 0px">Tên nhà sản xuất:</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="editnsx_ten" id='editnsx_ten' value="" class="validate form-control" style="height:28px">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="link" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Địa chỉ:</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="editnsx_diachi" id='editnsx_diachi' value="" class="form-control validate" style="height:28px">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="e_content" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Chủ cơ sở:</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="editnsx_chucoso" id='editnsx_chucoso' value="" class="form-control validate" style="height:28px">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="e_icon" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Điện Thoại:</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="editnsx_dienthoai" id='editnsx_dienthoai' value="" class="form-control validate" style="height:28px">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="e_icon" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Email:</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="editnsx_email" id='editnsx_email' value="" class="form-control validate" style="height:28px">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-12 col-12">
                                    <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                                    <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                            </div>
                                            <div class="col-md-2 col-6">

                                                <button type="button" onclick="capnhatnsx()" id="btnCapNhat" data-id="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Cập nhật</button>
                                            </div>
                                            <div class="col-md-2 col-6">
                                                <button type="button" onclick="modal_lammoi_nsx()" id='clearEditMenu' class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                            </div>
                                            <div class="col-md-2 col-6">
                                                <button type="button" id='destroyEditMenu' onclick="modal_huy_nsx()" class="btn btn-block btn-primary btn-xs"><i class="fa-regular fa-circle-xmark"></i>&nbsp;&nbsp;&nbsp;Hủy</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-12">
            </div>
        </div>
    </div>

</div>

<!--  -->


</html>




<script src="/admin/js/dongphuc/nsx/control.js"></script>
<script src="/template/admin/plugins/jquery/jquery.min.js"></script>
<script src="/template/admin/plugins/select2/js/select2.full.min.js"></script>


<script src="/template/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/template/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>

<!-- Summernote -->



{{-- <script src="/template/admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script> --}}
