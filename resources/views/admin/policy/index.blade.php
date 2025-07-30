
<div class="container-fluid">

    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card card-navy card-outline" style="min-height: 250px">
                <div class="row">
                    <div class="col-12 col-md-8 col-lg-8">
                        <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Thêm loại hồ sơ</div>
                        <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="id_priority_area" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Mã HS:</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="id_priority_area" id="name_priority_area" class="font_fix form-control menus " id="name" style="height:28px;">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-8">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="name_priority_area" class="col-sm-2 col-form-label" style="padding-bottom: 0px">Tên HS:</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="name_priority_area" id="name_priority_area" class="font_fix form-control menus " id="name" style="height:28px;">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="note_priority_area" class="col-sm-2 col-form-label" style="padding-bottom: 0px">Ghi chú:</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="note_priority_area" name="note_priority_area" class="form-control menus" style="height:28px;">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                                    <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <button type="button" onclick="fresh_policy()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <button type="button" id="add_policy" onclick="add_policy()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Thêm</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Danh sách hồ sơ</div>
                            <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" id = "" >
                                <table class="table table-hover table-bordered table-striped text-nowrap"  id = "file_policy_attr">


                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Hồ sơ mẫu</div>
                        <div class="card-body" style="padding-bottom: 0px;padding-top: 3px;" id = "" >
                            {{-- <div class="row">
                                <div class="col-12 col-md-12 col-lg-12"> --}}
                                    <div class="swiper" id = "remove_load_file_policy">
                                        <!-- Additional required wrapper -->
                                        {{-- <div class="swiper-wrapper" id = "load_file_policy"> </div><div class="swiper-pagination"></div> --}}


                                        <!-- If we need pagination -->

                                        <!-- If we need navigation buttons -->
                                        {{-- <div class="swiper-button-prev"></div>
                                        <div class="swiper-button-next"></div> --}}
                                        <!-- If we need scrollbar -->
                                        {{-- <div class="swiper-scrollbar"></div> --}}
                                    </div>
                                </div>
                            {{-- </div>

                        </div> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-navy card-outline" style="min-height: 250px">
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Thêm Đối tượng ưu tiên</div>

                            <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                                <div class="row">
                                    <div class="col-md-12  col-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="id_priority_area" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Mã:</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="id_priority_area" id="name_priority_area" class="font_fix form-control menus " id="name" style="height:28px;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="name_priority_area" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Tên:</label>
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
                                                    <button type="button" onclick="fresh_policy()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <button type="button" id="add_policy" onclick="add_policy()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Thêm</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-9 col-lg-9">
                            <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Danh sách đối tượng ưu tiên</div>
                            <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" id = "remove_list_policy" >
                                <table class="table table-hover table-bordered table-striped text-nowrap"  id = "list_policy">


                                </table>
                            </div>
                        </div>
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


<div class = "modal" id = "modal_policy_file">
    <div style="vertical-align:middle;background-color: rgba(0,0,0,0.5);height: 100%;">
        <div class="row">
            <div class="col-md-3 col-12">
            </div>
            <div class="col-md-6 col-12">
                <div class="card card-navy card-outline" style="width:auto; height:auto;0 solid rgba(0,0,0,.125); padding: 2px;background-color:#fff; margin-top: 10%">
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                        <div class="row">
                            <div class="col-md-11 col-lg-11 col-11">
                                <span  class="" id = "">Cập nhật minh chứng đối tượng ưu tiên</span>
                            </div>
                            <div class="col-md-1 col-lg-1 col-1">
                                <span  class="float-right" style="margin-right: 10px"><i onclick="close_policy_file()" id = 'close_policy_file' class="fas fa-times"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                        <form id="">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div style="margin-top: 3px" id = "remove_edit_policy_file">
                                        {{-- <table class="table table-bordered table-hover" id = "loadUser_Menus_Roles" >

                                        </table> --}}
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-12">
            </div>
        </div>
    </div>
</div>


</html>

<script src="/admin/js/policy/control.js"></script>
<script src="/template/admin/plugins/jquery/jquery.min.js"></script>
<script src="/template/admin/plugins/select2/js/select2.full.min.js"></script>

<script src="/swiper/swiper.js"></script>
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

