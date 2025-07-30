
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-3 col-lg-3">
            <div class="card card-navy card-outline" style="min-height: 600px;">
                <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Nhập hàng</div>
                <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                    <div class="col-md-12 col-12">
                        <div class="form-group row" style="margin-bottom: 3px">
                            <label for="id_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Ngày nhập:</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="fsp_ngay" name="fnsp_ngay" style="height:28px;" value="{{ old('ngaynhap', now()->format('Y-m-d')) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-12">
                        <div class="form-group row" style="margin-bottom: 3px">
                            <label for="l_listallnsx" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Nhà SX:</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="l_listallnsx" onchange="truyentt()" style="width: 100%;">


                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-12">
                        <div class="form-group row" style="margin-bottom: 3px">
                            <label for="l_listallsp" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Loại SP:</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="l_listallsp" onchange="truyenttloai()" style="width: 100%;">


                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-12">
                        <div class="form-group row" style="margin-bottom: 3px">
                            <label for="l_listallsize" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Size:</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="l_listallsize" style="width: 100%;">


                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-12">
                        <div class="form-group row" style="margin-bottom: 3px">
                            <label for="l_listallke" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Đợt nhập:</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="l_listalldot" style="width: 100%;">


                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-12">
                        <div class="form-group row" style="margin-bottom: 3px">
                            <label for="id_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px">SL nhập:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="sl_spn" id="sl_spn" style="height:28px;">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-12">
                        <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                        <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                            <div class="row">
                                <div class="col-md-6 col-6">
                                    <button type="button" id="" onclick="bttclearsp()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;&nbsp;Clear</button>
                                </div>
                                <div class="col-md-6 col-6">
                                    <button type="button" id="" onclick="bttnhapsp()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Nhập hàng</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <!--  -->
        <div class="ccol-12 col-md-9 col-lg-9">
            <div class="card card-navy card-outline" style="min-height: 600px ;">
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Danh sách sản phẩm nhập</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" id="l_listspn">




                    </div>
                </div>
            </div>
            <!--  -->
            <!--  -->
        </div>
        <!--  -->

        <!-- <div class="ccol-12 col-md-12 col-lg-12">
            <div class="card card-navy card-outline" id='right_check'>
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Danh sách nhập hàng</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" id="">
                    </div>
                </div>
            </div>

        </div> -->
    </div>
</div>


<div class="modal" id="modal_loadding_check_user">
    <div style="text-align:center; background-color: rgba(0,0,0,0);height: 100%;">
        <div class="loader"></div>
    </div>
</div>
<!--  -->
<div class="modal" id="modal_editnhapsp">
    <div style="vertical-align:middle;background-color: rgba(0,0,0,0.5);height: 100%;">
        <div class="row">
            <div class="col-md-4 col-12">
            </div>
            <div class="col-md-4 col-12">
                <div class="card card-navy card-outline" style="width:auto; height:auto; padding: 2px; background-color:#fff; margin-top: 20%;">
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                        <div class="row">
                            <div class="col-md-11 col-lg-11 col-11">
                                <span class="">Cập nhật sản phẩm</span>
                            </div>
                            <div class="col-md-1 col-lg-1 col-1">
                                <span class="float-right" style="margin-right: 10px"><i onclick="modal_close_nhapsp()" id='modal_number_go_wish_start_end_close' class="fas fa-times"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                        <form id="editnsx">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="name" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Ngày nhập:</label>
                                        <div class="col-sm-8">
                                            <input type="date" name="editnhapsp_ngay" id='editnhapsp_ngay' value="" class="validate form-control" style="height:28px">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="e_icon" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Nhà sản xuất:</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" onchange="truyentt_edit()" id="editnhap_nsx" style="width: 100%;">
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="link" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Loại:</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" onchange="truyenttloai_edit()" id="editnhap_loai" style="width: 100%;">
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-12 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="e_content" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Size:</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="editnhap_size" style="width: 100%;">
                                            </select>
                                        </div>
                                    </div>
                                </div>



                                <div class="col-md-12 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="e_icon" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Số lượng:</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="editnhap_sl" id='editnhap_sl' value="" class="form-control validate" style="height:28px">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-12 col-12">
                                    <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                                    <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                        <div class="row">
                                            <div class="col-md-4 col-4">

                                                <button type="button" onclick="capnhatnhapsp()" id="btnCapNhat" data-id="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Cập nhật</button>
                                            </div>
                                            <div class="col-md-4 col-4">
                                                <button type="button" onclick="modal_lammoi_nhapsp()" id='clearEditMenu' class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                            </div>
                                            <div class="col-md-4 col-4">
                                                <button type="button" id='destroyEditMenu' onclick="modal_huy_nhapsp()" class="btn btn-block btn-primary btn-xs"><i class="fa-regular fa-circle-xmark"></i>&nbsp;&nbsp;&nbsp;Hủy</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12">
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

<script src="/admin/js/dongphuc/nhapsp/control.js"></script>
