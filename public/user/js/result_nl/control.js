$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


//Khởi đầu

if($(document).width() > 992){
    $('#right_nl').css('min-height','630px')
    $('#left_nl').css('min-height','630px')
}else{
    $('#right_nl').css('min-height','0x')
    $('#left_nl').css('min-height','0px')
}

$(window).resize(function(){
    if($(document).width()>992){
        $('#right_nl').css('min-height','630px')
        $('#left_nl').css('min-height','630px')
    }else{
        $('#right_nl').css('min-height','0x')
        $('#left_nl').css('min-height','0px')

    }
});




    $('#modal_result_nl').hide();

    //Load môn để thí sinh nhập vào
    loadSubjects()

    //Load Slider Học bạ
    loadImg_nl();

    $('#addResult_nl').on('click',function(e){
        e.preventDefault();
        $('#addResult_nl').attr('disabled','true');
        $('#modal_result_nl').show();
        if($("#info_result_nl").attr("id-check1") == 0 || $('#mark_nl').val() == 0){
            toastr.warning('Chưa nhập điểm hoặc chưa upload phiếu điểm đánh giá năng lực')
            $('#modal_result_nl').hide();
            $('#addResult_nl').removeAttr('disabled');
        }else{
            var check = $("#info_result_nl").attr("id-check1")+"x"+$('#mark_nl').val();
            if($("#info_result_nl").attr("id-check") == check){
                toastr.warning('Không có dữ liệu mới')
                $('#modal_result_nl').hide();
                $('#addResult_nl').removeAttr('disabled');
            }else{
                $.ajax({
                    url: "/result_nl/addResult_nl",
                    type:'post',
                    data: {
                    mark: $('#mark_nl').val(),
                    id_subject: $('#mark_nl').attr('id_subject'),
                    img:  $("#info_result_nl").attr("data"),
                    id_check: $("#info_result_nl").attr("id-check1"),
                    // data: $("#info_result_nl").attr("data")
                    },

                    success: function(res){
                        if(res == 'check_reg_false'){
                            toastr.warning('Bạn đã đăng ký xét tuyển, không chỉnh sửa điểm được')
                        }else{
                            if(res == 1){
                                toastr.success('Cập nhật điểm thành công')
                            }else{
                                toastr.warning("Cập nhật không thành công, có thể lỗi hệ thống, vui lòng liên hệ 02923.898.167")
                            }
                        }
                        loadSubjects()
                        loadImg_nl();
                        $('#modal_result_nl').hide();
                        $('#addResult_nl').removeAttr('disabled');
                    }
                })
            }

        }
    })

    $('#info_result_nl').on('click',function(){
        $('#open_img_result_nl').click();
    })


    $('#open_img_result_nl').on('change',function(){
        var a = Math.floor(Math.random() * (999999- 111111) ) + 111111
        var type = this.files[0].type
        if(type == 'image/png' || type == 'image/pjpeg' || type == 'image/jpeg' || type == 'image/jpg'){
            var reader = new FileReader();
            reader.onload = function (event) {
                src = event.target.result
                $("#info_result_nl").attr("data",src)
                $("#info_result_nl").css("color",'#007bff')
                $("#info_result_nl").attr("id-check1",a)
            }
            reader.readAsDataURL(this.files[0]);
        }else{
            toastr.warning('Vui lòng upload file ảnh')
        }
    })
});//Ready


//Load môn để thí sinh nhập vào
function loadSubjects(){
    $.ajax({
        type: "get",
        url: "/result_nl/loadSubjects",
        success: function (response) {
            $('#subjectnl').html(response.classnl)
            $('#info_result_nl').attr('id-check',response.id_check)
            $('#info_result_nl').attr('id-check1',response.id_check1)
            $('#info_result_nl').attr('data',response.data)
            if(response.data == 0){
                $('#info_result_nl').css('color','red')
            }else{
                $('#info_result_nl').css('color','#007bff')
            }
        }
    });
}


function loadImg_nl(){
    $.ajax({
        type: "get",
        url: "/result_nl/loadImg_nl",
        success: function (response) {
            $('#img_nl').attr('src',response)
        }
    });
}


