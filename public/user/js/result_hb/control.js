$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


//Khởi đầu
    $('.modal').hide();
    $('#open_file_10').hide();
    $('#open_file_11').hide();
    $('#open_file_12').hide();

    //Load môn để thí sinh nhập vào
    loadSubjects()

    // //Mở file lớp 10
    // $('#file_10').on('click',function(){
    //     $('#open_img_result').val('');
    //     $('#crop_result').attr('type',$(this).attr('type'))
    //     $('#crop_result').attr('id_class',$(this).attr('id_class'))
    //     $('#open_img_result').click();
    // })

    // //Mở file lớp 11
    // $('#file_11').on('click',function(){
    //     $('#open_img_result').val('');
    //     $('#crop_result').attr('type',$(this).attr('type'))
    //     $('#crop_result').attr('id_class',$(this).attr('id_class'))
    //     $('#open_img_result').click();
    // })

    // //Mở file lớp 12
    // $('#file_12').on('click',function(){
    //     $('#open_img_result').val('');
    //     $('#crop_result').attr('type',$(this).attr('type'))
    //     $('#crop_result').attr('id_class',$(this).attr('id_class'))
    //     $('#open_img_result').click();
    // })

    // $('#info_result').on('click',function(){
    //     $('#open_img_result').val('');
    //     $('#crop_result').attr('type',$(this).attr('type'))
    //     $('#crop_result').attr('id_class',$(this).attr('id_class'))
    //     $('#open_img_result').click();
    // })

    $('.image_hb').on('click',function(e){
        var id_class = $(this).attr('id_class')
        $('#open_img_result').val('');
        $('#open_img_result').click();
        $('#open_img_result').attr('id_class',id_class)
        $('#open_img_result').attr('type_img',$(this).attr('type'))
        $('#open_img_result').attr('idcheck_hb_'+id_class,$(this).attr('idcheck_hb_'+id_class))


        // setTimeout(() => {

        // }, 100);
    })


    // $('#crop_result_close').on('click',function(){
    //     $('#open_img_result').val('');
    //     $('#modal_result').hide('slow');
    // })

    //Load Slider Học bạ
    loadImgSlider()




    // image_crop_result = $('#resizer-result').croppie({

    //     enableExif: true,
    //     viewport: {
    //         width:350,
    //         height:500,
    //         type:'square' //circle
    //     },
    //     boundary:{
    //         width:370,
    //         height:520
    //     }
    // });


    $('#open_img_result').on('change',function(e){
        e.preventDefault();
        $("#modal_loadding_hb").show();
        var id_class = $(this).attr('id_class')
        var type_img = $(this).attr('type_img')
        var a = Math.floor(Math.random() * (999999- 111111) ) + 111111
        var type = this.files[0].type
        if(type == 'image/png' || type == 'image/pjpeg' || type == 'image/jpeg' || type == 'image/jpg'){
            var reader = new FileReader();
            reader.onload = function (event) {
                src = event.target.result
                $("#img_hb"+id_class).attr("data",src)
                $("#img_hb"+id_class).css("color",'#007bff')
                $("#img_hb"+id_class).attr("idcheck_hb1_"+id_class,a)
                $.ajax({
                    url: "/result_hb/slider_hb",
                    type:'POST',
                    data: {
                        img: src,
                        id: id_class,
                        type: type_img,
                        id_check: a,
                    },
                    success:function(data){
                        $("#modal_loadding_hb").hide();
                        $('#remove_slider_hb').html('')
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
        }
    })

    // $("#crop_result").click(function(event){
    //     $("#modal_loadding_hb").show();
    //     $("#crop_result").hide('fast')
    //     var a = $(this).attr('id_class')
    //     var b = $(this).attr('type')
    //     // alert($(this).attr('type'))
    //     image_crop_result.croppie('result', {
    //         type: 'canvas',
    //         size: 'viewport',
    //         format: 'png',
    //         quality: 1,
    //     }).then(function(response){
    //         $.ajax({
    //         url: "/result_hb/slider_hb",
    //         type:'POST',
    //         data: {
    //             img: response,
    //             id: a,
    //             type: b,
    //         },
    //         success:function(data){
    //             $("#crop_result").show('fast')
    //             $("#modal_loadding_hb").hide();
    //             // alert(data)
    //             $('#modal_result').hide('slow');
    //             $('#remove_slider_hb').html('')
    //             loadImgSlider()
    //             if(data == -1){
    //                 toastr.warning("Hệ thống bị lỗi, vui lòng thử lại hoặc liên hệ 02923898167")
    //             }else{
    //                 if(data.ins == 1){
    //                     toastr.success('Cập nhật thành công')
    //                 }else{
    //                     toastr.warning('Có lỗi xảy ra, vui lòng liên hệ hotline: 02923898167')
    //                 }
    //             }
    //         }
    //         })
    //     });
    // })









});//Ready


//Load môn để thí sinh nhập vào
function loadSubjects(){
    $.ajax({
        type: "get",
        url: "/result_hb/loadSubjects",
        success: function (response) {
            $('#subject10_1').html(response.class10_1)
            $('#subject10_2').html(response.class10_2)
            $('#subject10_cn').html(response.class10_cn)
            $('#subject11_1').html(response.class11_1)
            $('#subject11_2').html(response.class11_2)
            $('#subject11_cn').html(response.class11_cn)
            $('#subject12_1').html(response.class12_1)
            $('#subject12_2').html(response.class12_2)
            $('#subject12_cn').html(response.class12_cn)
            var image_hb = document.getElementsByClassName('image_hb')
            if(response.id_check_info == 0){
                for(let i = 0;i<image_hb.length; i++){
                    $(image_hb[i]).attr('idcheck_hb_'+$(image_hb[i]).attr('id_class'),0)
                    $(image_hb[i]).attr('idcheck_hb1_'+$(image_hb[i]).attr('id_class'),0)
                    $(image_hb[i]).attr('id','img_hb'+$(image_hb[i]).attr('id_class'),0)
                    $(image_hb[i]).css('color','red')
                }
            }else{
                for(let i = 0;i<image_hb.length; i++){
                    var dem = 0;
                    for(let j = 0;j<response.id_check_info.length; j++){
                        if($(image_hb[i]).attr('id_class') == response.id_check_info[j].id_img){
                            $(image_hb[i]).attr('idcheck_hb_'+response.id_check_info[j].id_check,response.id_check_info[j].id_check)
                            $(image_hb[i]).attr('idcheck_hb1_'+response.id_check_info[j].id_check,response.id_check_info[j].id_check)
                            $(image_hb[i]).attr('id','img_hb'+$(image_hb[i]).attr('id_class'),response.id_check_info[j].id_check)
                            $(image_hb[i]).css('color','#007bff')
                            break;
                        }else{
                            dem ++;
                        }
                        if(dem == response.id_check_info.length){
                            $(image_hb[i]).attr('idcheck_hb_'+$(image_hb[i]).attr('id_class'),0)
                            $(image_hb[i]).attr('idcheck_hb1_'+$(image_hb[i]).attr('id_class'),0)
                            $(image_hb[i]).attr('id','img_hb'+$(image_hb[i]).attr('id_class'),0)
                            $(image_hb[i]).css('color','red')
                        }
                    }
                }
            }

        }
    });
}

function loadImgSlider(){
    $.ajax({
        type: "get",
        url: "/result_hb/loadslider_hb",
        success: function (response) {
            $('#remove_slider_hb').html(response.html)
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
                        $('.slider_hb li img').css('display', 'block');
                     }
                };
                var sliders = new Array();
                $('.slider_hb').each(function(i, slider) {
                    sliders[i] = $(slider).bxSlider(config);
                });
            }
        }
    });
}


function addResult(){
    // e.preventDefault();
    $('#addResult').attr('disabled','true')
    var result = document.getElementsByClassName('result')
    $('.result').removeClass('warning_result')
    var dem = 0;j=0;
    var warning = []
    var myRe = /^[+-]?((\d+(\.\d*)?)|(\.\d+))$/;
    for(let i = 0;i<result.length;i++){
        if(Number($(result[i]).attr('id_class_result')) == 10 || $(result[i]).attr('id_class_result') == '11' || ($(result[i]).attr('id_class_result') == '12' &&  $(result[i]).attr('id_semester_result') == '1')){
            if($(result[i]).val() == '' || myRe.test($(result[i]).val()) == false || Number($(result[i]).val())<0 || Number($(result[i]).val())>10 || $(result[i]).val().length >3){
                warning[j] = 'Điểm'+$(result[i]).attr('subject')+ ' - lớp ' + $(result[i]).attr('id_class_result')+' - học kì ' + $(result[i]).attr('id_semester_result')+' chưa đúng định dạng. Điểm phải là số thập phân và làm tròn đền một chữ số thập phân, không có dấu cách phía trước hoặc sau'
                $(result[i]).addClass('warning_result');
                dem++
                j++
            }
        }
        if($(result[i]).attr('id_class_result') == '12' &&  ($(result[i]).attr('id_semester_result') == '2' || $(result[i]).attr('id_semester_result') == 'CN')){
            if($(result[i]).val() == '' || myRe.test($(result[i]).val())==false || Number($(result[i]).val())<0 || Number($(result[i]).val())>10 || $(result[i]).val().length >3){
                warning[j] = 'Nếu chưa có điểm học kì 2 và cả năm lớp 12 thì nhập 0. Lưu ý: Dấu thập phân phải là dấu chấm, làm tròn một chữ số thập phân,không có dấu cách phía trước hoặc sau'
                $(result[i]).addClass('warning_result');
                dem++
                j++
            }
        }
    }

    if(dem >0){
        for ( let i = 0; i<warning.length; i++){
            $('#addResult').removeAttr('disabled')
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
            url: "/result_hb/addResult",
            data: {
            data:  data,
            },
            success: function (response) {
                $("#modal_loadding_hb").hide();
                $('#addResult').removeAttr('disabled')
                if(response == -1){
                    toastr.warning("Hệ thống bị lỗi, vui lòng thử lại hoặc liên hệ 02923.898.167")
                }else{
                    if(response == 'check_false_error'){
                        toastr.warning("Hệ thống bị lỗi, vui lòng thử lại hoặc liên hệ 02923.898.167")
                    }else{
                        if(response == 'check_false'){
                            toastr.warning("Thí sinh chưa tải trang thông tin học sinh và 3 trang điểm học tập lớp 10, 11, 12 trong học bạ")
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
