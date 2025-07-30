
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-4 col-lg-4">
            <div class="card card-navy card-outline" id = 'left_check'>
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Import điểm thi sinh</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                        <div class="row">
                            <div class="ccol-12 col-md-12 col-lg-12">

                                <table class="table table-bordered table-hover">
                                    <tbody>
                                        <tr>
                                            <td>
                                                Điểm học bạ: &nbsp;&nbsp;<i class="fa fa-paperclip img_check img_check7" id = "open_go_mark_hb" onclick="open_go_mark_hb()" style="color: red" aria-hidden="true"></i> &nbsp;&nbsp;<span id = "name_go_mark_hb"></span>
                                            </td>
                                            <td>
                                                <form id="submit_go_mark_hb">
                                                    <input type="file" name="import_go_mark_hb" id="import_go_mark_hb"/>
                                                </form>
                                            <i onclick="upload_go_mark_hb()" class="fa fa-upload"></i>&nbsp;&nbsp;
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Điểm THPT: &nbsp;&nbsp;<i class="fa fa-paperclip" id = "open_go_mark_thpt" onclick="open_go_mark_thpt()" style="color: red" aria-hidden="true"></i> &nbsp;&nbsp;<span id = "name_go_mark_thpt"></span>
                                            </td>
                                            <td>
                                                <form id="submit_go_mark_thpt">
                                                    <input type="file" name="import_go_mark_thpt" id="import_go_mark_thpt"/>
                                            </form>
                                            <i onclick="upload_go_mark_thpt()" class="fa fa-upload"></i>&nbsp;&nbsp;
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="ccol-12 col-md-8 col-lg-8">
                            </div>
                            <div class="ccol-12 col-md-4 col-lg-4">
                                <button type="button" onclick="download_go_mark()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-download"></i>&nbsp;&nbsp;&nbsp;Tải danh sách</button>
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
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" id = "remove_load_go_mark" >
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class = "modal" id="loadding_go_mark">
    <div  style="vertical-align: middle;text-align:center; background-color: rgba(0,0,0,0.5);height: 100%;">
        <div  style = "position: absolute; right: 0; left: 0; top: 0; bottom: 0; margin: auto; witdh:40px;height:40px;">&nbsp;&nbsp;
            <img src = "https://xettuyentest.ctuet.edu.vn/img/Loading.gif" width="40px" height="auto" >
            <span style="color:white"><strong>Đang import dữ liệu ..., Có thể mất vài phút!!!</strong></span>
        </div>
    </div>
</div>


</html>

<script src="/admin/js/go_mark/control.js"></script>
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

