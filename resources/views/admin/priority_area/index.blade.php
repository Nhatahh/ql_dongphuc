
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-3 col-lg-3">
            <div>
                <div class="card card-navy card-outline" style=" min-height: 630px">
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Thêm Khu vực ưu tiên</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                        <div class="row">
                            <div class="col-md-12  col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="id_priority_area" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Mã KV:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="id_priority_area" id="name_priority_area" class="font_fix form-control menus " id="name" style="height:28px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="name_priority_area" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Tên KV:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="name_priority_area" id="name_priority_area" class="font_fix form-control menus " id="name" style="height:28px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12  col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="mark_priority_area" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Điểm:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="mark_priority_area" id="mark_priority_area" class="form-control menus" style="height:28px">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12  col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="mark_priority_area" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Thứ tự:</label>
                                    <div class="col-sm-8">
                                        <input type="number" name="num_priority_area" id="num_priority_area" class="form-control menus" style="height:28px">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12  col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="note_priority_area" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Ghi chú:</label>
                                    <div class="col-sm-8">
                                        <textarea rows="2" type="text" id="note_priority_area" name="note_priority_area" class="form-control menus"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                                <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <button type="button" onclick="fresh_priority_area()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <button type="button" id="add_fresh_priority_area" onclick="add_fresh_priority_area()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Thêm</button>
                                        </div>
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
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Danh sách khu vực</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" id = "remove_list_priority_area" >

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class = "modal" id="loadding_priority_area">
    <div  style="vertical-align: middle;text-align:center; background-color: rgba(0,0,0,0.5);height: 100%;">
        <div  style = "position: absolute; right: 0; left: 0; top: 0; bottom: 0; margin: auto; witdh:40px;height:40px;">&nbsp;&nbsp;
            <img src = "https://xettuyentest.ctuet.edu.vn/img/Loading.gif" width="40px" height="auto" >
            {{-- <span style="color:white"><strong>Đang import dữ liệu ..., Có thể mất vài phút!!!</strong></span> --}}
        </div>
    </div>
</div>


</html>

<script src="/admin/js/priority_area/control.js"></script>
<script src="/template/admin/plugins/jquery/jquery.min.js"></script>
<script src="/template/admin/plugins/select2/js/select2.full.min.js"></script>

{{-- <script src="/swiper/swiper.js"></script> --}}
<script src="/template/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/template/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>

{{-- <script src="/template/admin/plugins/dropzone/min/dropzone.min.js"></script> --}}

{{-- <script src="/template/admin/plugins/jszip/jszip.min.js"></script> --}}
{{-- <script src="/template/admin/plugins/pdfmake/pdfmake.min.js"></script>
<script src="/template/admin/plugins/pdfmake/vfs_fonts.js"></script> --}}
{{-- <script src="/template/admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script> --}}

{{-- <script src="/croppie/croppie.js"></script> --}}

