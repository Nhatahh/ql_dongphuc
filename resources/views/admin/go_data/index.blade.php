
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-4 col-lg-4">
            <div class="card card-navy card-outline" id = 'left_check'>
                {{-- <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Chọn năm tuyển sinh</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                        <div class="col-md-12 col-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="id_place_user" class="col-sm-3 col-form-label" style="padding-bottom: 0px">Năm TS:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="go_data_year" style="width: 100%;">

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
                </div> --}}

                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Import danh sách tài khoản từ Bộ</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                        <div class="row">
                            <div class="ccol-12 col-md-12 col-lg-12">

                                <table class="table table-bordered table-hover">
                                    <tbody>
                                        <tr>
                                            <td>
                                               Tài khoản thí sinh: &nbsp;&nbsp;<i class="fa fa-paperclip" id = "open_go_data_list" onclick="open_go_data_list()" style="color: red" aria-hidden="true"></i> &nbsp;&nbsp;<span id = "name_go_data_list"></span>
                                            </td>
                                            <td>
                                                <form id="submit_go_data_list">
                                                    <input type="file" name="import_go_data_list" id="import_go_data_list"/>
                                                </form>
                                            <i onclick="upload_go_data_list()" class="fa fa-upload"></i>&nbsp;&nbsp;
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Thông tin thí sinh: &nbsp;&nbsp;<i class="fa fa-paperclip" id = "open_go_info_list" onclick="open_go_info_list()" style="color: red" aria-hidden="true"></i> &nbsp;&nbsp;<span id = "name_go_info_list"></span>
                                            </td>
                                            <td>
                                                <form id="submit_go_info_list">
                                                    <input type="file" name="import_go_info_list" id="import_go_info_list"/>
                                                </form>
                                                <i onclick="upload_go_info_list()" class="fa fa-upload"></i>&nbsp;&nbsp;
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Đối tượng ưu tiên: &nbsp;&nbsp;<i class="fa fa-paperclip" id="open_go_policy_list" onclick="open_go_policy_list()" style="color: red" aria-hidden="true"></i> &nbsp;&nbsp;<span id = "name_go_policy_list"></span>
                                            </td>
                                            <td>
                                                <form id="submit_go_policy_list">
                                                    <input type="file" name="import_go_policy_list" id="import_go_policy_list"/>
                                                </form>
                                                <i onclick="upload_go_policy_list()" class="fa fa-upload"></i>&nbsp;&nbsp;
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="ccol-12 col-md-8 col-lg-8">
                            </div>
                            <div class="ccol-12 col-md-4 col-lg-4">
                                <button type="button" onclick="download_go_data_list()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-download"></i>&nbsp;&nbsp;&nbsp;Tải danh sách</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="ccol-12 col-md-8 col-lg-8">
            <div class="card card-navy card-outline" id = 'right_check' >
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Danh sách thí sinh</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" id = "remove_load_go_data_acc" >

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class = "modal" id="loadding_go_data">
    <div  style="vertical-align: middle;text-align:center; background-color: rgba(0,0,0,0.5);height: 100%;">
        <div  style = "position: absolute; right: 0; left: 0; top: 0; bottom: 0; margin: auto; witdh:40px;height:40px;">&nbsp;&nbsp;
            <img src = "https://xettuyentest.ctuet.edu.vn/img/Loading.gif" width="40px" height="auto" >
            <span style="color:white"><strong>Đang import dữ liệu ..., Có thể mất vài phút!!!</strong></span>
        </div>
    </div>
</div>


</html>

<script src="/admin/js/go_data/control.js"></script>
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

