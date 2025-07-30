
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-8">
            <div class="card card-navy card-outline" id = 'left_ex'>
                <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 5px;font-weight: bold;">Danh sách nguyện vọng đã đăng ký</div>
                <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                    <div class="card-body table-responsive p-0">
                        <div style="color: #007bff" id = "check_reg_expenses"></div>
                        <table class="table table-hover text-nowrap"  id = "load_expenses_wish">
                            {{-- Hiện thị Users--}}
                        </table>
                    </div>
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-12 col-md-10">
                        </div>
                        <div class="col-12 col-md-2">
                            <button type="button"  id = "save_expenses" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp; Lưu thông tin</button>
                        </div>
                    </div>
                </div>
                <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Hướng dẫn chuyển khoản lệ phí xét tuyển: (20.000 đồng/01 nguyện vọng)</div>
                <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                    <div>
                        <strong>Các trường hợp cần gửi lệ phí xét tuyển.</strong>
                        <div><strong>Trường hợp 1.</strong> Nếu thí sinh đăng ký mới thì gửi lệ phí về trường theo hướng dẫn phía dưới.</div>
                        <div><strong>Trường hợp 2.</strong> Nếu thí sinh đã thanh toán lệ phí rồi và cập nhật lại nguyện vọng (không thêm nguyện vọng) thì <strong style="color: red">không thanh toán</strong> lệ thêm phí nữa.</div>
                        <div><strong>Trường hợp 3.</strong> Nếu thí sinh đã thanh toán lệ phí rồi, sau đó lại thêm nguyện vọng thì gửi thêm lệ phí của nguyện vọng mới (20000 đồng/nguyện vọng) về Trường.</div>
                    </div>
                    <div><strong style="color: red">Lưu ý quan trọng: Thí sinh phải cân nhắc chọn Nguyện vọng để đóng phí. Nếu thông tin đã lưu thì không thay đổi được. Khuyến khích thí sinh xác nhận đóng phí hết cho tất cả nguyện vọng</strong> </div>
                    <div><strong>Bước 1.</strong> Chọn nguyện vọng để thanh toán lệ phí xét tuyển ở phía trên. (Chỉ những nguyện vọng được đóng lệ phí xét tuyển mới được đưa vào danh sách xét tuyển)</div>
                    <div><strong>Bước 2.</strong>  Thanh toán lệ phí bằng hình thức chuyển khoản:</div>
                    <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Ngân hàng:</strong> Thương mại cổ phần Ngoại thương Việt Nam (Vietcombank) </div>
                    <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Tên tài khoản:</strong> Trường Đại học Kỹ thuật - Công nghệ Cần Thơ   </div>
                    <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Số tài khoản: </strong style = "color: #007bff"> 0111000315359  </div>
                    <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Số tiền chuyển khoản: </strong> <strong style = "color: #007bff" id = "price"></strong></div>
                    <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Thông tin chuyển khoản</strong>  (Ghi đúng như hướng dẫn màu xanh):<strong style = "color: #007bff" id = "info_price"></strong></div>
                    <div><strong>Bước 3.</strong>  Click <i class="fa fa-paperclip" id="img_expenses" style="color: #007bff" aria-hidden="true"></i> &nbsp; để Upload hình ảnh chuyển khoản (phiếu thu chuyển khoản, hoặc màn hình chuyển khoản tử Ipay)</div>
                    <div><strong>Bước 4.</strong> Sau 3 ngày, đăng nhập Cổng xét tuyển xem tình trạng lệ phí xét tuyển</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-4">
            <div class="card card-navy card-outline" id = 'right_ex' >
                <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Hỉnh ảnh chuyển khoản hoặc phiếu thu: &nbsp;&nbsp;&nbsp;</div>
                <input type='file' id='open_img_expenses' name ='open_img_expenses' style = "display: none">

                <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                    <img id='view_img_expenses' class="img-fluid" style="margin-bottom: 10px">

                </div>
            </div>
        </div>
    </div>
</div>
    {{-- Modal Resize Ảnh học bạ lớp 10--}}

    <div class = "modal" id="modal1">
        <div style="text-align:center; background-color: rgba(0,0,0,.4);height: 100%;">
            <div id="resizer-file_ex" style="margin-bottom: 0px;">
                <i class="fas fa-check" id = "crop_ex" style = "font-size: 15pt; color: #007bff;"></i>&nbsp;&nbsp;&nbsp;
                <i class="fas fa-times" id = "crop_close_ex" style = "font-size: 15pt; color: #007bff;"></i>
            </div>
        </div>
    </div>


</html>

<script src="/user/js/expenses/control.js"></script>
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
<script src="/template/admin/plugins/pdfmake/pdfmake.min.js"></script>
<script src="/template/admin/plugins/pdfmake/vfs_fonts.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script src="/croppie/croppie.js"></script>

