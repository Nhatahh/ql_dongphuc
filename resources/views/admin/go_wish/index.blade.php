
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-3 col-lg-3">
            <div class="card card-navy card-outline" id = 'left_check'>
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Import Nguyện vọng</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                        <div class="row">
                            <div class="ccol-12 col-md-12 col-lg-12">

                                <table class="table table-bordered table-hover">
                                    <tbody>
                                        <tr>
                                            <td>
                                                Nguyện vọng: &nbsp;&nbsp;<i class="fa fa-paperclip" id = "open_go_wish" onclick="open_go_wish()" style="color: red" aria-hidden="true"></i> &nbsp;&nbsp;<span id = "name_go_wish1"></span>
                                            </td>
                                            <td>
                                                <form id="submit_go_wish">
                                                    <input type="file" name="import_go_wish" id="import_go_wish"/>
                                                </form>
                                            <i onclick="upload_go_wish()" class="fa fa-upload"></i>&nbsp;&nbsp;
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="ccol-12 col-md-6 col-lg-6">
                            </div>
                            <div class="ccol-12 col-md-6 col-lg-6">
                                <button type="button" onclick="download_go_wish()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-download"></i>&nbsp;&nbsp;&nbsp;Tải danh sách</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="ccol-12 col-md-9 col-lg-9">
            <div class="card card-navy card-outline" id = 'right_check' >
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Danh sách nguyện vọng
                        <button style = "width: 100px;margin: 1px 2px" type="button"  onclick="number_go_wish_start_end()" id = "number_go_wish_start_end" class="btn btn-block btn-primary btn-xs float-right"><i class="fa fa-print"></i>&nbsp;&nbsp;&nbsp;Sắp xếp NV</button>
                        <button style = "width: 100px;margin: 1px 2px" type="button"  onclick="cal_go_wish_start_end()" id = "cal_go_wish_start_end" class="btn btn-block btn-primary btn-xs float-right"><i class="fa fa-table"></i>&nbsp;&nbsp;&nbsp;Tính điểm XT</button>
                        <button style = "width: 100px;margin: 1px 2px" type="button" onclick="go_wish_tts()"  id = "go_wish_tts" class="btn btn-block btn-primary btn-xs float-right"><i class="fa fa-print"></i>&nbsp;&nbsp;&nbsp;Chuyển TTS</button>
                    </div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" id = "remove_load_go_wish" >





                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class = "modal" id="loadding_go_wish">
    <div  style="vertical-align: middle;text-align:center; background-color: rgba(0,0,0,0.5);height: 100%;">
        <div  style = "position: absolute; right: 0; left: 0; top: 0; bottom: 0; margin: auto; witdh:40px;height:40px;">&nbsp;&nbsp;
            <img src = "https://xettuyentest.ctuet.edu.vn/img/Loading.gif" width="40px" height="auto" >
            <span style="color:white"><strong>Đang import dữ liệu ..., Có thể mất vài phút!!!</strong></span>
        </div>
    </div>
</div>

<div class = "modal" id="modal_cal_go_wish_start_end">
    <div style="vertical-align:middle;background-color: rgba(0,0,0,0.5);height: 100%;">
        <div class="row">
            <div class="col-md-4 col-12">
            </div>
            <div class="col-md-4 col-12">
                <div style="width:auto; height:auto;0 solid rgba(0,0,0,.125); padding: 2px;background-color:#fff; margin-top: 20%">
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                        <div class="row">
                            <div class="col-md-11 col-lg-11 col-1">
                                <span  class="">ID thí sinh</span>
                            </div>
                            <div class="col-md-1 col-lg-1 col-1">
                                <span  class="float-right" style="margin-right: 10px"><i onclick="modal_cal_go_wish_start_end_close()" id = 'modal_cal_go_wish_start_end_close' class="fas fa-times"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="cal_go_wish_start" class="col-sm-3 col-form-label" style="padding-bottom: 0px" >Từ:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control"  value="" id='cal_go_wish_start' style="height:28px">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="cal_go_wish_end" class="col-sm-3 col-form-label" style="padding-bottom: 0px" >Đến:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control"  value="" id='cal_go_wish_end' style="height:28px">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                            </div>
                            <div class="col-md-4 col-6">
                                {{-- <button type="button"  id = ""  onclick="()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-broom"></i>&nbsp;&nbsp;&nbsp;Làm mới</button> --}}
                            </div>
                            <div class="col-md-4 col-6">
                                <button type="button"  id = "cal_go_wish"  id-data = '' onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa fa-broom"></i>&nbsp;&nbsp;&nbsp;Tính điểm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class = "modal" id="modal_number_go_wish_start_end">
    <div style="vertical-align:middle;background-color: rgba(0,0,0,0.5);height: 100%;">
        <div class="row">
            <div class="col-md-4 col-12">
            </div>
            <div class="col-md-4 col-12">
                <div style="width:auto; height:auto;0 solid rgba(0,0,0,.125); padding: 2px;background-color:#fff; margin-top: 20%">
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                        <div class="row">
                            <div class="col-md-11 col-lg-11 col-1">
                                <span  class="">Chọn ID thí sinh</span>
                            </div>
                            <div class="col-md-1 col-lg-1 col-1">
                                <span  class="float-right" style="margin-right: 10px"><i onclick="modal_number_go_wish_start_end_close()" id = 'modal_number_go_wish_start_end_close' class="fas fa-times"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="number_go_wish_start" class="col-sm-3 col-form-label" style="padding-bottom: 0px" >Từ:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control"  value="" id='number_go_wish_start' style="height:28px">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="number_go_wish_end" class="col-sm-3 col-form-label" style="padding-bottom: 0px" >Đến:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control"  value="" id='number_go_wish_end' style="height:28px">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                            </div>
                            <div class="col-md-4 col-6">
                                {{-- <button type="button"  id = ""  onclick="()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-broom"></i>&nbsp;&nbsp;&nbsp;Làm mới</button> --}}
                            </div>
                            <div class="col-md-4 col-6">
                                <button type="button"  id = "number_go_wish"  id-data = '' onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa fa-broom"></i>&nbsp;&nbsp;&nbsp;Sắp xếp</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</html>

<script src="/admin/js/go_wish/control.js"></script>
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

