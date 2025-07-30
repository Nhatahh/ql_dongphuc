
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-4 col-lg-4">
            <div class="card card-navy card-outline" id = 'left_check'>
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Tạo tài khoản thí sinh</div>
                    <div class="card-body" style="padding-top: 3px; padding-bottom:0px">

                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="id_card_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px" >CMND/TCC:</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control" id='id_card_add' style="height:28px">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="phone_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px" >Điện thoại:</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control" id='phone_add' style="height:28px">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="id_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Email:</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control" id='email_add' style="height:28px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                                <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <button type="button"  id = "clear_add" class="btn btn-block btn-primary btn-xs"><i class="fa fa-broom"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <button type="button"  id = "add_user" onclick="add()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Tạo</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold; margin-top:10px">Reset tài khoản tra cứu</div>
                    <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                        <div class="col-12 col-md-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="batch_card_reset" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Đợt TS:</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="batch_card_reset" style="width: 100%;">

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="id_card_reset" class="col-sm-4 col-form-label" style="padding-bottom: 0px" >CMND/TCC:</label>
                                <div class="col-sm-8">
                                <input type="text" class="form-control" id='id_card_reset' style="height:28px">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-12">
                            <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                            <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <button type="button"  id = "id_card_reset_save" class="btn btn-block btn-primary btn-xs"><i class="fa fa-broom"></i>&nbsp;&nbsp;&nbsp;Reset</button>
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
                        <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Tình trạng tài khoản</div>
                        <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" id = "info_add">
                            {{-- <table class="table table-hover text-nowrap"  id = "load_list_reg"> --}}
                                {{-- Hiện thị Users--}}
                            {{-- </table> --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    {{-- Modal Resize Ảnh học bạ lớp 10--}}



    <div class = "modal" id="modal_loadding_add">
        <div style="text-align:center; background-color: rgba(0,0,0,0);height: 100%;">
            <div class="loader"></div>
        </div>
    </div>

</html>



{{-- <script src="/template/admin/plugins/summernote/summernote-bs4.min.js"></script> --}}
<script src="/admin/js/adduser/control.js"></script>
<script src="/template/admin/plugins/jquery/jquery.min.js"></script>
<script src="/template/admin/plugins/select2/js/select2.full.min.js"></script>
{{-- <script src="/bxslider/dist/jquery.bxslider.min.js"></script> --}}
{{-- <script src="/zoom/jquery.zoom.js"></script> --}}

{{-- <script src="/owlcarousel/dist/owl.carousel.js"></script> --}}
{{-- <script src="//code.jquery.com/jquery-latest.min.js"></script> --}}
{{-- <script src="/unslider/dist/js/unslider-min.js"></script> --}}

{{-- <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script> --}}
{{-- <script src="/swiper/swiper.js"></script> --}}
{{-- <script src="/template/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/template/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script> --}}
{{-- <script src="/template/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script> --}}

<!-- Summernote -->


{{-- <script src="/template/admin/plugins/jszip/jszip.min.js"></script> --}}
{{-- <script src="/template/admin/plugins/pdfmake/pdfmake.min.js"></script>
<script src="/template/admin/plugins/pdfmake/vfs_fonts.js"></script> --}}
{{-- <script src="/template/admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script> --}}

{{-- <script src="/croppie/croppie.js"></script> --}}

