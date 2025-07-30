
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card card-navy card-outline" id = "block_left" style = "min-height: 600px;">
                <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Điểm thi tốt nghiệp THPT &nbsp;&nbsp;&nbsp;(Đính kèm giấy chứng nhận kết quả thi THPT quốc gia &nbsp;<i class="fa fa-paperclip image_thpt" id_class = "TN" type ="3" id= 'image_thpt' aria-hidden="true" style="color: #007bff"></i>)
                </div>
                {{-- <input type='file' id='open_file_10' name ='open_file_10' style = "display: none"> --}}
                <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                    <div class="row" id = 'subjects_thpt'>

                    </div>
                </div>
                <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-12 col-md-10">
                        </div>
                        <div class="col-12 col-md-2">
                            {{-- <button type="button"  id = "addResult" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp; Lưu</button> --}}
                            <button type="button" id = "addResult_thpt" onclick="addResult_thpt()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp; Lưu</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card card-navy card-outline"  id = "block_right" style = "min-height: 600px" >

                <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Hướng dẫn đăng ký:
                </div>
                <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                    <p style = "height: fix-content;color: #007bff" >&nbsp;&nbsp;&nbsp;- Thí sinh nhập chính xác điểm số trên giấy chứng nhận kết quả thi vào hệ thống (Lưu ý: Nhập điểm dấu thập phân là dấu chấm)</p>
                    <p style = "height: fix-content;color: #007bff" >&nbsp;&nbsp;&nbsp;- Môn thí sinh không thi thì điền 0.</p>
                    <p style = "height: fix-content;color: #007bff" >&nbsp;&nbsp;&nbsp;- Tải giấy xác nhận kết quả thi, bằng cách click vào biểu tượng <i class="fa fa-paperclip" style = "color: red" aria-hidden="true"></i>.&nbsp;Thí sinh lưu ý chụp rõ cả trang học bạ, sao cho thấy rõ Họ tên, lớp, chữ ký của giáo viên</p>
                    <p style = "height: fix-content;color: #007bff" >&nbsp;&nbsp;&nbsp;- Lưu điểm.</p>
                </div>
                <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Minh chứng giấy kết quả thi (thí sinh kiểm tra kỹ điểm số trước khi lưu)
                </div>
                <div style="margin-top: 10px; margin-left: 10px" id ="remove_slider_thpt">
                    {{-- <ul class = "slider_thpt" id ="slider_thpt"><li><img class = "" src="/images/hocba/17639/result_5_1_tnrpqInFtfUStoEmwSAFgrqCvveaWE_17639.png" title="GCN Tốt nghiệp THPT"></li></ul> --}}
                </div>
            </div>
        </div>
    </div>
</div>
    {{-- Modal Resize Ảnh học bạ lớp 10--}}

    {{-- <div class = "modal" id="modal_result">
        <div style="text-align:center; background-color: rgba(0,0,0,.4);height: 100%;">
            <div id="resizer-result" style="margin-bottom: 0px;">
                <i class="fas fa-check" id = "crop_result" style = "font-size: 15pt; color: #0d0e0f;"></i>&nbsp;&nbsp;&nbsp;
                <i class="fas fa-times" id = "crop_result_close" style = "font-size: 15pt; color: #007bff;"></i>
            </div>
        </div>
    </div> --}}
    <input type='file' id='open_img_result_thpt' name ='open_img_result_thpt' style = "display: none">

    <div class = "modal" id="modal_loadding_hb">
        <div style="text-align:center; background-color: rgba(0,0,0,0);height: 100%;">
            <div class="loader"></div>
        </div>
    </div>
</html>

<script src="/user/js/result_thpt/control.js"></script>
<script src="/template/admin/plugins/jquery/jquery.min.js"></script>
{{-- <script src="/template/admin/plugins/select2/js/select2.full.min.js"></script> --}}
<script src="/bxslider/dist/jquery.bxslider.min.js"></script>

<script src="/croppie/croppie.js"></script>


<script>


// Webcam.set({
//         width: 490,
//         height: 350,
//         image_format: 'jpeg',
//         jpeg_quality: 90
//     });

//     Webcam.attach( '#my_camera' );

//     function take_snapshot() {
//         Webcam.snap( function(data_uri) {
//             $(".image-tag").val(data_uri);
//             document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
//         } );
//     }

</script>
