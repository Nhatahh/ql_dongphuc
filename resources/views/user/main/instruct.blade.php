
<div class="container-fluid">
    <div class="row">

        <div class="col-12 col-md-12 col-lg-4">
            <div class="card card-navy card-outline" id = 'right_instruct' >
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Trạng thái hồ sơ: &nbsp; </div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                        <span>Trạng thái đăng ký:&nbsp;</span><span id = "reg_instruct" style="color:#007bff" ></span><br>
                        <span>Trạng thái duyệt hồ sơ:&nbsp;</span><span id = "check_instruct" style="color: #007bff" ></span><br>
                        <span>Trạng thái lệ phí: </span> <br>
                        &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<span>Đã hoàn tất lệ phí: &nbsp; </span><span id = "price_instruct" style="color: #007bff"></span><br>
                        &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<span>Số nguyện vọng thanh toán:&nbsp;</span> <span style="color: #007bff" id = "wish_instruct"></span><br>
                        &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<span>Tiền dư: &nbsp;</span> <span style="color: #007bff" id = "price2_instruct"></span><br>
                        <div class="row">
                            <div class="col-12 col-md-5 col-lg-5">
                                <span>Kết quả xét tuyển: &nbsp;</span>
                            </div>
                            <div class="col-12 col-md-7 col-lg-7">
                                <button type="button" onclick="go_seen()" style="margin: bottom: 2px;" class="btn btn-block btn-primary btn-xs"><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp; Click xem kết quả</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-12 col-lg-8">
            <div class="card card-navy card-outline" id = 'left_instruct'>
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 5px;font-weight: bold;">Hướng dẫn đăng ký xét tuyển  </div>
                    <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                        <div id = 'instruct' style="">
                            <i style="color:#007bff;">Nếu thí sinh sử dụng điện thoại đi động vui lòng click &nbsp;</i><i class="fas fa-bars"></i><i style="color:#007bff;"> &nbsp; ở góc trái, phía trên để mở hiện danh sách các menu hệ thống</i><br>
                            Thí sinh thực hiện đăng ký nguyện vọng theo các bước sau:<br>

                            <strong>Bước 1.</strong> Khai báo thông tin cá nhân ở menu <span style ="color: blue">Hồ sơ xét tuyển -> Thông tin cá nhân.</span><br>

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Thí sinh khai báo chính xác thông tin cá nhân, trường THPT, đối tượng ưu tiên (nếu có).<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Thí sinh đang học 12 thì nhập Năm TN (Năm tốt nghiệp THPT) là 2023 .<br>

                            <strong>Bước 2.</strong> Nhập điểm để hệ thống tự động tính điểm xét tuyển.<br>

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>a.</strong> Nhập điểm học bạ đối với thí sinh đăng ký phương thức HB1, HB2 ở menu <span style ="color: blue">Hồ sơ xét tuyển -> Học bạ THPT</span><br>

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>b.</strong> Nhập điểm thi đánh giá năng lực đối với thí sinh đăng ký phương thức 402 ở menu <span style ="color: blue">Hồ sơ xét tuyển ->Điểm thi ĐGNL</span><br>

                            <strong>Bước 3.</strong> Đăng ký nguyện vọng ở menu  <span style ="color: blue"> Đăng ký xét tuyển -> Nguyện vọng xét tuyển</span><br>

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Hệ thống tự động tính điểm xét tuyển dựa vào điểm do thí sinh nhập vào ở bước 2 và thông tin cá nhân ở bước 1.<br>

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Thí sinh dựa vào điểm tham khảo để đăng ký các nguyện vọng phù hợp.<br>

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Thí sinh chọn Lưu để lưu dữ liệu nguyện vọng. Trong thời gian này, thí sinh vẫn có thể điều chỉnh nguyện vọng.<br>

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Sau khi cân nhắc thật kỹ thí sinh chọn Đăng ký để chính thức Đăng ký nguyện vọng xét tuyển. Sau khi đăng ký hệ thống sẽ không cho phép chỉnh sửa.<br>

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Sau khi đăng ký, thí sinh đăng nhập mail để kiểm tra xem hệ thống có xác nhận đúng nguyện vọng đã đăng ký. Nếu sai thì phản hồi về Phòng Đào tạo, hotline: <span style ="color: blue">02923898167</span><br>

                            <strong>Bước 4.</strong>      Chọn nguyện vọng để thanh toán lệ phí ở menu <span style ="color: blue"> Đăng ký xét tuyển ->Thanh toán lệ phí</span><br>

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Thí sinh đã đăng ký xét tuyển có thể chọn 1 hoặc nhiều nguyện vọng để thanh toán lệ phí. (Khuyến khích nên chọn thanh toán hết các nguyện vọng đã đăng ký).<br>

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Thí sinh chuyển khoản về vào tài khoản của Trường theo đúng thông tin hướng dẫn ở màn hình <span style ="color: blue">Thanh toán lệ phí</span>.<br>

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Cấu trúc thông tin chuyển khoản: <strong style ="color: blue">(Số điện thoại thi sinh) (ID hồ sơ)</strong> <br>

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Sau khi chuyển khoản về Trường lệ phí xét tuyển (20.000 đồng/01 nguyện vọng), thí sinh upload ảnh chuyển khoản lên hệ thống để Trường có thể thu được khi thí sinh chuyển khoản sai thông tin.<br>

                            <strong style="color:#007bff">Lưu ý: </strong> <br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong style="color:#007bff">1. Thí sinh phải tải các hình ảnh minh chứng liên quan bằng cách click vào dấu <i class="fa fa-paperclip" style = "color: #007bff"aria-hidden="true"></i>.<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. Thí sinh không gửi hồ sơ xét tuyển về Trường. Thí sinh phải đảm bảo thông tin trên Cổng đăng ký xét tuyển chính xác. Nhà trường sẽ hậu kiểm khi có kết quả xét sơ tuyển.</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
    {{-- Modal Resize Ảnh học bạ lớp 10--}}

    {{-- <div class = "modal" id="modal1">
        <div style="text-align:center; background-color: rgba(0,0,0,.4);height: 100%;">
            <div id="resizer-file_ex" style="margin-bottom: 0px;">
                <i class="fas fa-check" id = "crop_ex" style = "font-size: 15pt; color: #007bff;"></i>&nbsp;&nbsp;&nbsp;
                <i class="fas fa-times" id = "crop_close_ex" style = "font-size: 15pt; color: #007bff;"></i>
            </div>
        </div>
    </div> --}}


</html>

<script src="/user/js/instruct/control.js"></script>
<script src="/template/admin/plugins/jquery/jquery.min.js"></script>


<script src="/croppie/croppie.js"></script>





