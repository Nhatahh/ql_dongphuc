$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


//Khởi đầu

    //Load môn để thí sinh nhập vào
    loadSubjects()

    $('#image_thpt').on('click',function(){
        $('#open_img_result_thpt').val('');
        $('#open_img_result_thpt').click()
    })

    loadImgSlider()

    $('#open_img_result_thpt').on('change',function(e){
        e.preventDefault();
        $("#modal_loadding_hb").show();
        // var id_class = $(this).attr('id_class')
        // var type_img = $(this).attr('type_img')
        var a = Math.floor(Math.random() * (999999- 111111) ) + 111111
        var type = this.files[0].type
        if(type == 'image/png' || type == 'image/pjpeg' || type == 'image/jpeg' || type == 'image/jpg'){
            var reader = new FileReader();
            reader.onload = function (event) {
                src = event.target.result
                $("#img_thpt").attr("data",src)
                $("#img_thpt").css("color",'#007bff')
                // $("#img_hb"+id_class).attr("idcheck_hb1_"+id_class,a)
                $.ajax({
                    url: "/result_thpt/save_img_result_thpt",
                    type:'POST',
                    data: {
                        img: src,
                        // id: id_class,
                        // type: type_img,
                        id_check: a,
                    },
                    success:function(data){
                        $("#modal_loadding_hb").hide();
                        $('#remove_slider_thpt').html('')
                        loadImgSlider()
                    if(data == -1){
                        toastr.warning("Hệ thống bị lỗi, vui lòng thử lại hoặc liên hệ 02923898167")
                    }else{
                        if(data == 1){
                            toastr.success('Cập nhật thành công')
                        }else{
                            toastr.warning('Có lỗi xảy ra, vui lòng liên hệ hotline: 02923898167')
                        }
                    }
                    }
                })
            }
            reader.readAsDataURL(this.files[0]);
            // $('#modal_result').show('slow');
        }else{
            toastr.warning('Vui lòng upload file ảnh')
            $("#modal_loadding_hb").hide();
        }
    })

});//Ready


//Load môn để thí sinh nhập vào
function loadSubjects(){
    $.ajax({
        type: "get",
        url: "/result_thpt/loadSubjects",
        success: function (response) {
            $('#subjects_thpt').html(response.subjects_thpt)
            // var image_hb = document.getElementsByClassName('image_hb')
            // if(response.id_check_info == 0){
            //     for(let i = 0;i<image_hb.length; i++){
            //         $(image_hb[i]).attr('idcheck_hb_'+$(image_hb[i]).attr('id_class'),0)
            //         $(image_hb[i]).attr('idcheck_hb1_'+$(image_hb[i]).attr('id_class'),0)
            //         $(image_hb[i]).attr('id','img_hb'+$(image_hb[i]).attr('id_class'),0)
            //         $(image_hb[i]).css('color','red')
            //     }
            // }else{
            //     for(let i = 0;i<image_hb.length; i++){
            //         var dem = 0;
            //         for(let j = 0;j<response.id_check_info.length; j++){
            //             if($(image_hb[i]).attr('id_class') == response.id_check_info[j].id_img){
            //                 $(image_hb[i]).attr('idcheck_hb_'+response.id_check_info[j].id_check,response.id_check_info[j].id_check)
            //                 $(image_hb[i]).attr('idcheck_hb1_'+response.id_check_info[j].id_check,response.id_check_info[j].id_check)
            //                 $(image_hb[i]).attr('id','img_hb'+$(image_hb[i]).attr('id_class'),response.id_check_info[j].id_check)
            //                 $(image_hb[i]).css('color','#007bff')
            //                 break;
            //             }else{
            //                 dem ++;
            //             }
            //             if(dem == response.id_check_info.length){
            //                 $(image_hb[i]).attr('idcheck_hb_'+$(image_hb[i]).attr('id_class'),0)
            //                 $(image_hb[i]).attr('idcheck_hb1_'+$(image_hb[i]).attr('id_class'),0)
            //                 $(image_hb[i]).attr('id','img_hb'+$(image_hb[i]).attr('id_class'),0)
            //                 $(image_hb[i]).css('color','red')
            //             }
            //         }
            //     }
            // }

        }
    });
}


function loadImgSlider(){
    $.ajax({
        type: "get",
        url: "/result_thpt/loadslider_thpt",
        success: function (response) {
            $('#remove_slider_thpt').html(response.html)
            if(response.fail == 0){
                var config = {
                    // slideWidth: 200,
                    // minSlides: 3,
                    // maxSlides: 9,
                    // moveSlides: 4,
                    // slideMargin: 40,
                    controls: false,
                    pager: true,
                    auto: false,
                    clones: true,
                    pause: 80000,
                    randomStart: false,
                    captions: true,
                    preloadImages: 'all',
                    infiniteLoop: top,
                    onSlideAfter: function ($slideElement, oldIndex, newIndex) {
                        var imageelement = $slideElement.find('img');
                        imageelement.attr('src', imageelement.attr('imagesrc'));
                    },
                    onSliderLoad: function () {
                        $('.slider_thpt li img').css('display', 'block');
                    }
                };
                var sliders = new Array();
                $('.slider_thpt').each(function(i, slider) {
                    sliders[i] = $(slider).bxSlider(config);
                });
            }
        }
    });
}

function addResult_thpt(){
    // e.preventDefault();
    $('#addResult_thpt').attr('disabled','true')
    var result = document.getElementsByClassName('result_thpt')
    $('.result_thpt').removeClass('warning_result')
    var dem = 0;j=0;
    var warning = []
    var myRe = /^[+-]?((\d+(\.\d*)?)|(\.\d+))$/;
    for(let i = 0;i<result.length;i++){
        if($(result[i]).attr('id_class_result') == "TN"){
            if($(result[i]).val() == '' || myRe.test($(result[i]).val()) == false || Number($(result[i]).val())<0 || Number($(result[i]).val())>10 || $(result[i]).val().length >3){
                warning[j] = 'Điểm'+$(result[i]).attr('subject')+' chưa đúng định dạng. Điểm phải là số thập phân và làm tròn đền một chữ số thập phân, không có dấu cách phía trước hoặc sau'
                $(result[i]).addClass('warning_result');
                dem++
                j++
            }
        }
    }

    if(dem >0){
        for ( let i = 0; i<warning.length; i++){
            $('#addResult_thpt').removeAttr('disabled')
            toastr.warning(warning[i])
        }
    }else{
        $("#modal_loadding_hb").show();
        data=[];
        for(let i = 0; i<result.length; i++){
            data[i] = [$(result[i]).attr('id_subject'),$(result[i]).attr('id_class_result'),$(result[i]).attr('id_semester_result'),$(result[i]).val()]
        }
        $.ajax({
            type: "post",
            url: "/result_thpt/addResult_thpt",
            data: {
            data:  data,
            },
            success: function (response) {
                $("#modal_loadding_hb").hide();
                $('#addResult_thpt').removeAttr('disabled')
                if(response == -1){
                    toastr.warning("Hệ thống bị lỗi, vui lòng thử lại hoặc liên hệ 02923.898.167")
                }else{
                    if(response == 'check_false_error'){
                        toastr.warning("Hệ thống bị lỗi, vui lòng thử lại hoặc liên hệ 02923.898.167")
                    }else{
                        if(response == 'check_false'){
                            toastr.warning("Thí sinh chưa tải giấy chứng nhận kết quả thi")
                        }else{
                            if(response == 'check_reg_false'){
                                toastr.warning('Bạn đã đăng ký xét tuyển, không được chỉnh sửa điểm')
                            }else{
                                if(response == 0){
                                    toastr.warning("Không có dữ liệu mới")
                                }else{
                                    toastr.success("Cập nhật thành công")
                                }
                            }
                            loadSubjects()
                        }
                    }
                }
            }
        });
    }
}
