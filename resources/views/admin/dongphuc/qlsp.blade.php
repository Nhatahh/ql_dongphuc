<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-4 col-lg-4">
            <div class="card card-navy card-outline" style="min-height:600px">
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Thêm loại:</div>
                    <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                        <div class="col-md-12 col-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="id_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Loại:</label>
                                <div class="col-sm-8">
                                    <input type="text" name="tensp" class="form-control" id='tensp' style="height:28px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                            <label for="id_place_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Nhà sản xuất</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="addsp_tennsx" style="width: 100%;">
                                        </select>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-6">
                            <button type="button" id="" onclick="add_product()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Thêm</button>
                        </div><br>

                    </div>
                </div>
            </div>
        </div>

        <div class="ccol-12 col-md-8 col-lg-8">
            <div class="card card-navy card-outline" style="min-height:600px">
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Danh sách loại</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" id="show_product"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="modal_loadding_check_user">
    <div style="text-align:center; background-color: rgba(0,0,0,0);height: 100%;">
        <div class="loader"></div>
    </div>
</div>


{{-- Sửa loại --}}
<div class="modal" id="modal_edit_product">
    <div style="vertical-align:middle;background-color: rgba(0,0,0,0.5);height: 100%;">
        <div class="row">
            <div class="col-md-2 col-12">
            </div>
            <div class="col-md-8 col-12">
                <div class="card card-navy card-outline" style="width:auto; height:auto; padding: 2px; background-color:#fff; margin-top: 20%;">
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                        <div class="row">
                            <div class="col-md-11 col-lg-11 col-11">
                                <span class="">Cập nhật sản phẩm nhập</span>
                            </div>
                            <div class="col-md-1 col-lg-1 col-1">
                                <span class="float-right" style="margin-right: 10px"><i onclick="dongsualoai()" id='modal_number_go_wish_start_end_close' class="fas fa-times"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                        <form id="editnsx">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="name" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Loại</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="editproduct_loai" id='editproduct_loai' value="" class="validate form-control" style="height:28px">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="e_icon" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Nhà sản xuất:</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="editproduct_nsx" style="width: 100%;">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- checkbox ưu tiên -->
                                <div class="col-md-6 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="name" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Loại</label>
                                        <div class="col-sm-8">
                                            <input type="checkbox" name="editproduct_trangthai" id="editproduct_trangthai" > Trạng thái
                                        </div>
                                    </div>
                                </div>
                                <!--  -->
                                <div class="col-md-12 col-12">
                                    <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                                    <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                        <div class="row">
                                            <div class="col-md-4 col-4">

                                                <button type="button" onclick="capnhatloai()" id="btnCapNhat" data-id="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Cập nhật</button>
                                            </div>
                                            <div class="col-md-4 col-4">
                                                <button type="button" onclick="clearEditMenuloai()" id='' class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                            </div>
                                            <div class="col-md-4 col-4">
                                                <button type="button" id='destroyEditMenu' onclick="huysualoai()" class="btn btn-block btn-primary btn-xs"><i class="fa-regular fa-circle-xmark"></i>&nbsp;&nbsp;&nbsp;Hủy</button>
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





</html>




<script src="nxs/control.js"></script>
<script src="/template/admin/plugins/jquery/jquery.min.js"></script>
<script src="/template/admin/plugins/select2/js/select2.full.min.js"></script>

<script src="/template/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/template/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="/admin/js/dongphuc/qlloai/control.js"></script>
