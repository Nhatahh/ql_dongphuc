<div class="col-12 col-md-4 col-lg-4" style="padding: 0;display:flex;font-weight: bold;">Quản lý đợt </div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-3 col-lg-3">
            <div class="card card-navy card-outline" style="min-height:600px">
                <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Thêm đợt</div>
                <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="id_user_check" class="col-sm-3 col-form-label" style="padding-bottom: 0px">Đợt:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id='dot_ten' style="height:28px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="id_user_check" class="col-sm-3 col-form-label" style="padding-bottom: 0px">Ngày:</label>
                                <div class="col-sm-9">
                                <input type="date" class="form-control" id="dot_ngay" name="dot_ngay" style="height:28px;" value="{{ old('ngaynhap', now()->format('Y-m-d')) }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                            <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                <div class="row">
                                    <div class="col-md-6 col-6">
                                        <button type="button" id="" onclick="dot_clear()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Clear</button>
                                    </div>
                                    <div class="col-md-6 col-6">
                                        <button type="button" id="" onclick="dot_them()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;&nbsp;Thêm</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ccol-12 col-md-8 col-lg-8">
            <div class="card card-navy card-outline" style="min-height:600px">
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Danh sách đợt</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" id="hiendot">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="model_editdot">
    <div style="vertical-align:middle;background-color: rgba(0,0,0,0.5);height: 100%;">
        <div class="row">
            <div class="col-md-4 col-12">
            </div>
            <div class="col-md-4 col-12">
                <div class="card card-navy card-outline" style="width:auto; height:auto; padding: 2px; background-color:#fff; margin-top: 20%;">
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                        <div class="row">
                            <div class="col-md-11 col-lg-11 col-11">
                                <span class="">Kệ</span>
                            </div>
                            <div class="col-md-1 col-lg-1 col-1">
                                <span class="float-right" style="margin-right: 10px"><i onclick="model_close_dot()"  class="fas fa-times"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                        <form id="editForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="name" class="col-sm-2 col-form-label" style="padding-bottom: 0px">Tên đợt:</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="e_name" id='e_name' value="{{old('e_name')}}" class="validate form-control" style="height:28px">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-12 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="link" class="col-sm-2 col-form-label" style="padding-bottom: 0px">Ngày đợt:</label>
                                        <div class="col-sm-10">
                                            <input type="date" name="e_link" id='e_link' value="{{old('e_link')}}" class="form-control validate" style="height:28px">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                                    <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                        <div class="row">
                                            <div class="col-md-4 col-4" style="margin-bottom:3px">
                                                <button type="button" id='editMenu' onclick="submit_dot()" data-id=""  class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Cập nhật</button>
                                            </div>
                                            <div class="col-md-4 col-4" style="margin-bottom:3px">
                                                <button type="button" id='clearEditMenu' onclick="clear_dot()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                            </div>
                                            <div class="col-md-4 col-4" style="margin-bottom:3px">
                                                <button type="button" id='destroyEditMenu'onclick="model_close_dot()" class="btn btn-block btn-primary btn-xs"><i class="fa-regular fa-circle-xmark"></i>&nbsp;&nbsp;&nbsp;Hủy</button>
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


<div class="modal" id="modal_loadding_check_user">
    <div style="text-align:center; background-color: rgba(0,0,0,0);height: 100%;">
        <div class="loader"></div>
    </div>
</div>

</html>


<script src="/admin/js/dongphuc/dot/control.js"></script>
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

