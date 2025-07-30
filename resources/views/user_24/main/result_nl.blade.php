
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card card-navy card-outline" id = 'left_nl' >
                <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Kết quả thi đánh giá năng lực &nbsp;&nbsp;&nbsp;(Đinh kèm giấy xác nhận kết quả thi của Đại học Quốc gia TP HCM &nbsp;<i class="fa fa-paperclip" id-check = "" id-check1 = "" data = "" id= 'info_result_nl' style = "color: #007bff"aria-hidden="true"></i>)
                </div>
                {{-- <input type='file' id='open_file_10' name ='open_file_10' style = "display: none"> --}}
                <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                    <div class="row">
                        <div class="col-12 col-md-10" id = 'subjectnl'>

                        </div>
                        <div class="col-12 col-md-2" style="vertical-align: middle;margin-bottom: 7px">
                            <button type="button"  id = "addResult_nl"  class="btn btn-block btn-primary btn-xs"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp; Lưu</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card card-navy card-outline"  id = 'right_nl' style="margin-bottom: 7px" >
                <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Hỉnh ảnh giấy xác nhận kết quả thi
                </div>
                <div style="margin-top: 10px; margin-left: 10px" >
                    <img id ="img_nl" class="img-fluid" >
                </div>
            </div>
        </div>
    </div>
</div>
    {{-- Modal Resize Ảnh học bạ lớp 10--}}

    <div class = "modal" id="modal_result_nl">
        <div style="text-align:center; background-color: rgba(0,0,0,0);height: 100%;">
            <div class="loader"></div>
        </div>
    </div>
    <input type='file' id='open_img_result_nl' name ='open_img_result_nl' style = "display:none">
</html>

<script src="/user/js/result_nl/control.js"></script>
<script src="/template/admin/plugins/jquery/jquery.min.js"></script>
{{-- <script src="/template/admin/plugins/select2/js/select2.full.min.js"></script>
<script src="/bxslider/dist/jquery.bxslider.min.js"></script> --}}

{{-- <script src="/croppie/croppie.js"></script> --}}


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
