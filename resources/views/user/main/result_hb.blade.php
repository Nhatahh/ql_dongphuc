
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-8" style = "max-width: fit-content">
            <div class="card card-navy card-outline" id = "block_left" style = "min-height: 883px;">
                <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Lớp 10 - Học kì 1 &nbsp;&nbsp;&nbsp;(Đính kèm trang thông tin học sinh trong học bạ &nbsp;<i class="fa fa-paperclip image_hb" id_class = "9" type ="2" id= '' aria-hidden="true"></i>; &nbsp;&nbsp;&nbsp;Học bạ lớp 10 &nbsp;<i class="fa fa-paperclip image_hb" id_class = "10" type ="2" id= '' aria-hidden="true"></i>)
                </div>
                {{-- <input type='file' id='open_file_10' name ='open_file_10' style = "display: none"> --}}
                <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                    <div class="row" id = 'subject10_1'>

                    </div>
                </div>
                <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Lớp 10 - Học kì 2
                </div>
                <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                    <div class="row" id = 'subject10_2'>

                    </div>
                </div>
                <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Lớp 10 - Cả năm
                </div>
                <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                    <div class="row" id = 'subject10_cn'>
                    </div>
                </div>
                <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Lớp 11 - Học kì 1&nbsp;&nbsp;&nbsp;(Đính kèm học bạ lớp 11 &nbsp;<i class="fa fa-paperclip image_hb" id_class = "11" type='2' id= '' aria-hidden="true"></i>)
                </div>
                {{-- <input type='file' id='open_file_11' name ='open_file_11' style = "display: none"> --}}
                <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                    <div class="row" id = 'subject11_1'>

                    </div>
                </div>
                <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Lớp 11 - Học kì 2
                </div>
                <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                    <div class="row" id = 'subject11_2'>

                    </div>
                </div>
                <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Lớp 11- Cả năm
                </div>
                <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                    <div class="row" id = 'subject11_cn'>

                    </div>
                </div>
                <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Lớp 12 - Học kì 1&nbsp;&nbsp;&nbsp;(Đính kèm học bạ lớp 12 &nbsp;<i class="fa fa-paperclip image_hb" id_class = "12" type='2'  id= ''  aria-hidden="true"></i>)
                </div>
                {{-- <input type='file' id='open_file_12' name ='open_file_12' style = "display: none"> --}}
                <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                    <div class="row" id = 'subject12_1'>

                    </div>
                </div>
                <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Lớp 12 - Học kì 2
                </div>
                <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                    <div class="row" id = 'subject12_2'>

                    </div>
                </div>
                <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Lớp 12- Cả năm
                </div>
                <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                    <div class="row" id = 'subject12_cn'>

                    </div>
                </div>
                <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-12 col-md-10">
                        </div>
                        <div class="col-12 col-md-2">
                            {{-- <button type="button"  id = "addResult" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp; Lưu</button> --}}
                            <button type="button" id = "addResult" onclick="addResult()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp; Lưu</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card card-navy card-outline"  id = "block_right" style = "min-height: 884px" >

                <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Hướng dẫn đăng ký:
                </div>
                <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                    <p style = "height: fix-content;color: #007bff" >&nbsp;&nbsp;&nbsp;- Thí sinh nhập chính xác điểm số trên học bạ vào hệ thống (Lưu ý: Nhập điểm dấu thập phân là dấu chấm)</p>
                    <p style = "height: fix-content;color: #007bff" >&nbsp;&nbsp;&nbsp;- Nếu thí sinh chưa có kết quả học tập hoc kì 2, lớp 12 thì nhập học kì 2 và cả năm là 0 điểm. Thí sinh có thể bổ sung sau khi có điểm học kì 2 lớp 12 nếu đợt xét tuyển đang mở</p>
                    <p style = "height: fix-content;color: #007bff" >&nbsp;&nbsp;&nbsp;- Tải ảnh học bạ, bằng cách click vào biểu tượng <i class="fa fa-paperclip" style = "color: red" aria-hidden="true"></i>.&nbsp;Thí sinh lưu ý chụp rõ cả trang học bạ, sao cho thấy rõ Họ tên, lớp, chữ ký của giáo viên</p>
                    <p style = "height: fix-content;color: #007bff" >&nbsp;&nbsp;&nbsp;- Lưu điểm học bạ.</p>
                </div>
                <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Minh chứng học bạ (thí sinh kiểm tra kỹ điểm số trước khi lưu)
                </div>
                <div style="margin-top: 10px; margin-left: 10px" id ="remove_slider_hb">
                </div>
            </div>



        </div>
    </div>
</div>
    {{-- Modal Resize Ảnh học bạ lớp 10--}}

    <div class = "modal" id="modal_result">
        <div style="text-align:center; background-color: rgba(0,0,0,.4);height: 100%;">
            <div id="resizer-result" style="margin-bottom: 0px;">
                <i class="fas fa-check" id = "crop_result" style = "font-size: 15pt; color: #007bff;"></i>&nbsp;&nbsp;&nbsp;
                <i class="fas fa-times" id = "crop_result_close" style = "font-size: 15pt; color: #007bff;"></i>
            </div>
        </div>
    </div>
    <input type='file' id='open_img_result' name ='open_img_result' style = "display: none">

    <div class = "modal" id="modal_loadding_hb">
        <div style="text-align:center; background-color: rgba(0,0,0,0);height: 100%;">
            <div class="loader"></div>
        </div>
    </div>
</html>

<script src="/user/js/result_hb/control.js"></script>
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
