
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-8">
            <div class="card card-navy card-outline" id = 'left_ex'>
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Thu lệ phí thí sinh</div>
                    <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                        <div class="row">
                            <div class="col-md-2">
                                <img class="profile-user-img img-fluid img-circle" src = '' alt="Ảnh cá nhân"  id="userimg_check_ex">
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-4" style="margin-bottom: 7px">ID thí sinh: <input style="height: 20px;width: 50%" type="text" name = "text" id = 'id_expenses_ad'></div>
                                    <div class="col-md-4" style="margin-bottom: 7px">Họ và tên: <span id="name_user_ex"></span></div>
                                    <div class="col-md-4" style="margin-bottom: 7px">Ngày sinh: <span id="birth_user_ex"> </span></div>
                                    <div class="col-md-4" style="margin-bottom: 7px">CMND/TCC: <span id="id_user_ex"> </span> </div>
                                    <div class="col-md-4" style="margin-bottom: 7px">Điện thoại: <span id="phone_user_ex"> </span></div>
                                    <div class="col-md-4" style="margin-bottom: 7px">Điện thoại PH: <span id="phonesc_user_ex"> </span></div>
                                    <div class="col-md-4" style="margin-bottom: 7px">Email: <span id="email_user_ex"> </span></div>
                                    <div class="col-md-4" style="margin-bottom: 7px">Tổng lệ phí: <span style = "color:#007bff" id="price_ex"> </span></div>
                                    <div class="col-md-4" style="margin-bottom: 7px">Tiền thừa: <span style = "color:#007bff" id = "price2_ex"> </span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 5px" >
                    <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Danh sách nguyện vọng</div>
                    <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                        <div class="row">
                            <div class="col-12 col-md-10"></div>
                            <div class="col-12 col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="form_check" style="margin-top:-5px">
                                    <label class="form-check-label">Tiền mặt</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div id="remove_ex_wish">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-12 col-md-7"></div>
                        <div class="col-12 col-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend" style="height: 24px">
                                    <span class="input-group-text" style="background-color: inherit;border:none">Số tiền</span>
                                </div>
                                <input type="text" class="form-control"  id = "total_price" style="height: 24px">
                            </div>
                        </div>
                        <div class="col-12 col-md-2">
                            <button type="button" style="width: 90%" id = "save_ex_ad" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp; Thu lệ phí</button>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 5px" >
                    <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Mail phản hồi</div>
                    <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                        <div class="row" style="margin-top: 3px">
                            <div class="col-12 col-md-12">
                                <textarea class="form-control" id = "content_user_ex" rows="6" style = "font-size: 0.9rem; background-color:inherit"  placeholder="Nhập nội dung gửi mail cho thí sinh"></textarea>
                            </div>
                            <div class="col-12 col-md-10">
                            </div>
                            <div class="col-12 col-md-2">
                                <button type="button" style="width: 90%;margin-top: 3px" id = "faceback_ex_ad" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp; Gửi</button>
                            </div>

                            <div class="col-12 col-md-12" >
                                <div><a style="color:red">Cấu trúc email được gửi đi như sau:</a>
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nhà trường đã nhận được lệ phí của thí sinh  <strong>Tên thí sinh (ID:   ). </strong> Tuy nhiên, <strong style="color:red">(Nội dung gửi mail cho thí sinh)</strong></p>
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mọi thắc mắc về lệ phí xét tuyển vui lòng liên hệ Zalo: 0823 891 457</p>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12 col-md-4">
            <div class="card card-navy card-outline" id = 'right_ex' >
                <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Hỉnh ảnh chuyển khoản hoặc phiếu thu: &nbsp;&nbsp;&nbsp;</div>
                <input type='file' id='open_img_expenses' name ='open_img_expenses' style = "display: none">

                <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                    <img id='view_img_expenses_ad' class="img-fluid" style="margin-bottom: 10px">
                </div>
            </div>
        </div>

    </div>
</div>


<div class = "modal" id="modal_loadding_ex">
    <div style="text-align:center; background-color: rgba(0,0,0,0);height: 100%;">
        <div class="loader"></div>
    </div>
</div>



</html>

<script src="/admin/js/expenses/control.js"></script>
<script src="/template/admin/plugins/jquery/jquery.min.js"></script>
{{-- <script src="/template/admin/plugins/select2/js/select2.full.min.js"></script> --}}
{{-- <script src="/bxslider/dist/jquery.bxslider.min.js"></script> --}}



<script src="/template/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/template/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/jszip/jszip.min.js"></script>
{{-- <script src="/template/admin/plugins/pdfmake/pdfmake.min.js"></script> --}}
<script src="/template/admin/plugins/pdfmake/vfs_fonts.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
{{-- <script src="/template/admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script> --}}

