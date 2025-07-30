$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
//Khởi đầu

    //Class add Trường
$('.add_school').hover(function(){
    $(this).css('color','#343a40');
    },function(){
    $(this).css('color','#17a2b8');
});


$('#Priority_policy').select2();
$('#id_khttprovince_user').select2();
$('#id_khttprovince_user2').select2();
$('#id_khttprovince_user3').select2();
$('#id_place_user').select2();
$('#nation_user').select2();
$('.province').select2();
$('.province2').select2();
$('.province3').select2();

$('#graduation_year_user_img').hide()
$('.modal').hide()
$('#open_userImg').hide()
$('#my_camera').hide()

$('#graduation_year_user').on('change',function () {
    var today = new Date();
    if($(this).val() < today.getFullYear()){
        $('#graduation_year_user_attr').show()
        $('#graduation_year_user_attr').addClass('info_attr')
    }else{
        $('#graduation_year_user_attr').hide()
        $('#graduation_year_user_attr').removeClass('info_attr')

    }
 })
                                // Bộ điều khiển

// Hộ khẩu thường trú
province();
province2()
province3()

// Hộ khẩu thường trú Tỉnh change
$('.province').on('change',function(){
    $.ajax({
        type: "post",
        url: "/info/change_province",
        data: {
            id: $(this).val()
        },
        dataType: 'json',
        success: function (response) {
            $('.province2').html('').select2({
                data: response
            });
            $('.province3').html('').select2()
        }
    });
});

//Hộ khẩu thường trú Huyện change
$('.province2').on('change',function(){
    $.ajax({
        type: "post",
        url: "/info/change_province2",
        data: {
            id: $(this).val()
        },
        dataType: 'json',
        success: function (response) {
            $('.province3').html('').select2({
                data: response
            });
        }
    });
});

// Dân tộc
nationUser()

//Dân tộc
placeUser()

//Thông tin đăng ký
loadRegister()

//Thông tin cơ bản
loadInfoUser()

//Tạo copre
image_crop = $('#resizer-demo').croppie({
    enableExif: true,
    viewport: {
        width:350,
        height:350,
        type:'circle' //circle
    },
    boundary:{
        width:370,
        height:370
    }
});

$('#attr_userImage').on('click',function(){
    $('#open_userImg').click()
})
//Open ảnh đại diện
$('#open_userImg').on('change',function(){
    var type = this.files[0].type
    if(type == 'image/png' || type == 'image/pjpeg' || type == 'image/jpeg'){
        var reader = new FileReader();
        reader.onload = function (event) {
            image_crop.croppie('bind', {
            url: event.target.result
            })
        }
        reader.readAsDataURL(this.files[0]);
        $('#modal2').show('slow');
    }else{
        toastr.warning("Vui lòng chọn file ảnh")
    }
})


$('#crop').click(function(event){
    image_crop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
    }).then(function(data){
        $('#userImg').attr('src',data)
        $('#modal2').hide('slow');
    })
})




$.ajax({
    type: "get",
    url: "/info/check_reg",
    // caches: false,
    success: function (response) {
        if(response == 1){
            $('#graduation_year_user').attr('disabled','disabled')
        }

    }
})


//Lưu thông tin cá nhân
$('#add_infoUser').on('click',function(){
    $('#add_infoUser').attr('disabled','true')
    $('#modal_loadding_info').show()
    if($('#id_card_users_attr').attr('data') == 0){
        toastr.warning('Vui lòng upload ảnh mặt trước chứng minh nhân dân')
        $('#add_infoUser').removeAttr('disabled')
        $('#modal_loadding_info').hide()
    }else{
        if($('#graduation_year_user').val() < 2023 && $('#graduation_year_user_attr').attr('data') == 0){
            toastr.warning('Vui lòng upload hình ảnh bằng tốt nghiệp THPT')
            $('#add_infoUser').removeAttr('disabled')
            $('#modal_loadding_info').hide()
        }else{
            if($('#userImg').attr('src') == "/storage/profile/start.png"){
                toastr.warning('Vui lòng cập nhật hình đại diện')
                $('#add_infoUser').removeAttr('disabled')
                $('#modal_loadding_info').hide()
            }else{
                var checkedradio = $('input[name="radio1"]:radio:checked').attr('id');
                if(checkedradio == 'female_user'){
                    var sex_user = 1
                }else{
                    var sex_user = 0
                }
                var info_attr = document.getElementsByClassName('info_attr')
                var data = []
                for(let i = 0;i<info_attr.length;i++){
                    data[i] = [$(info_attr[i]).attr('type_img'),$(info_attr[i]).attr('id-data'),$(info_attr[i]).attr('data')]
                }
                $.ajax({
                    type: "post",
                    url: "/info/add_infoUser",
                    data:{
                        userImg: $('#userImg').attr('src'),
                        name_user: $('#name_user').val(),
                        birth_user: $('#birth_user').val(),
                        id_place_user: $('#id_place_user').val(),
                        emailsc_user: $('#emailsc_user').val(),
                        nation_user: $('#nation_user').val(),
                        phonesc_user: $('#phonesc_user').val(),
                        id_khttprovince_user: $('#id_khttprovince_user').val(),
                        id_khttprovince2_user: $('#id_khttprovince_user2').val(),
                        id_khttprovince3_user: $('#id_khttprovince_user3').val(),
                        sex_user: sex_user,
                        address_user: $('#address_user').val(),
                        graduation_year_user: $('#graduation_year_user').val(),
                        data: data,
                    },
                    // caches: false,
                    success: function (response) {
                        if(response == 1 ){
                            setTimeout(() => {
                                $('#add_infoUser').removeAttr('disabled')
                                $('#modal_loadding_info').hide()
                            }, 0);
                            toastr.success("Cập nhật thành công")
                            nationUser()
                            placeUser()
                            loadRegister()
                            loadInfoUser()
                            $.ajax({
                                type: "get",
                                url: "/loaduser_Img",
                                // dataType: 'json',
                                success: function (response) {
                                    $('#loaduser_Img').attr('src',response[0].link_img_user)
                                }
                            });
                        }else{
                            var keys = Object.keys(response)
                            toastr.warning(response[keys[0]])
                            $('#add_infoUser').removeAttr('disabled')
                            $('#modal_loadding_info').hide()
                        }
                    }
                });
            }
        }
    }

})

//Load Trường lớp 10, 11, 12
province_shool_10()
province_shool_11()
province_shool_12()

//Thêm Trường lớp 10, 11, 12
$('#add_school_10').click(function(){

    var length = 1+ document.getElementsByClassName('province_school10').length
    var soft_del = 1000 + length
    var html = '<div class="card-body" style="padding-top: 0px;padding-bottom: 0px" id="'+soft_del+'">'
    html += '<div class="row">'
        html +='<div class="col-md-3 col-12">'
            html +='<div class="form-group row" style="margin-bottom: 3px">'
                html +='<label for="inputEmail3" class="col-sm-4 col-form-label" style="padding-bottom: 0px "><i class="fa fa-trash  delArea" onclick = "del_area_2(0,'+soft_del+')" style="color: red" id_area = "0" id_del="'+soft_del+'"></i>&nbsp;&nbsp;Tỉnh/TP:</label>'
                html +='<div class="col-sm-8" >'
                    html +='<select  class="province_school province_school10 province_school_10_'+length+' province_school_new" id = "province_school_10_'+length+'" style="width: 100%;">'

                    html +='</select>'
                    html +='</div>'
                html +='</div>'
            html +='</div>'
        html +='<div class="col-md-6 col-12">'
        html +='<div class="form-group row" style="margin-bottom: 3px">'
            html +='<label for="inputEmail3" class="col-sm-3 col-form-label" style="padding-bottom: 0px ">Trường THPT:<sup id = "v_province_school_10_'+length+'s" style="padding: 0;color:#17a2b8"></sup></label>'
            html += '<div class="col-sm-9">'
                html += '<select class="school school_new province_school_10_'+length+'s" id_area = "0" id-data = "10" id = "province_school_10_'+length+'s"  style="width: 100%;">'
                html += '</select>'
            html += '</div>'
            html += '</div>'
        html += '</div>'
        html += '<div class="col-md-3 col-12">'
            html += '<div class="form-group row" style="margin-bottom: 3px">'
                html += '<label for="inputEmail3" class="col-sm-7 col-form-label" style="padding-bottom: 0px">Thời gian học (tháng):</label>'
                html += '<div class="col-sm-5">'
                        html += ' <input type="text" class="form-control time time_10" id = "province_school_10_'+length+'stime" style="height:30px" value = "">'
                    html += '</div>'
                html += '</div>'
            html += '</div>'
        html += '</div>'
    html += ' </div>';

    $('#school_10').append(html);
    $('.province_school_10_'+length).select2();
    $('.province_school_10_'+length+'s').select2();
    $.ajax({
        type: "get",
        url: "/info/province_shool",
        dataType: 'json',
        success: function (response) {
            $('.province_school_10_'+length).html('').select2({
                data: response
            });
        }
    });
});

$('#add_school_11').click(function(){
    var length = 1+ document.getElementsByClassName('province_school11').length
    var soft_del = 1000+length;
    var html = '<div class="card-body" style="padding-top: 0px;padding-bottom: 0px" id="'+soft_del+'">'
    html += '<div class="row">'
        html +='<div class="col-md-3 col-12">'
            html +='<div class="form-group row" style="margin-bottom: 3px">'
                html +='<label for="inputEmail3" class="col-sm-4 col-form-label" style="padding-bottom: 0px "><i class="fa fa-trash delArea" onclick = "del_area_2(0,'+soft_del+')" style="color: red" id_area = "0" id_del="'+soft_del+'"></i>&nbsp;&nbsp;Tỉnh/TP:</label>'
                html +='<div class="col-sm-8" >'
                    html +='<select  class="province_school province_school11 province_school_11_'+length+' province_school_new" id = "province_school_11_'+length+'" style="width: 100%;">'

                    html +='</select>'
                    html +='</div>'
                html +='</div>'
            html +='</div>'
        html +='<div class="col-md-6 col-12">'
        html +='<div class="form-group row" style="margin-bottom: 3px">'
            html +='<label for="inputEmail3" class="col-sm-3 col-form-label" style="padding-bottom: 0px ">Trường THPT:<sup id = "v_province_school_11_'+length+'s" style="padding: 0;color:#17a2b8"></sup></label>'
            html += '<div class="col-sm-9">'
                html += '<select class="school school_new province_school_11_'+length+'s" id_area = "0" id-data = "11" id = "province_school_11_'+length+'s"  style="width: 100%;">'
                html += '</select>'
            html += '</div>'
            html += '</div>'
        html += '</div>'
        html += '<div class="col-md-3 col-12">'
            html += '<div class="form-group row" style="margin-bottom: 3px">'
                html += '<label for="inputEmail3" class="col-sm-7 col-form-label" style="padding-bottom: 0px">Thời gian học (tháng):</label>'
                html += '<div class="col-sm-5">'
                        html += ' <input type="text" class="form-control time time_11" id = "province_school_11_'+length+'stime" style="height:30px" value = "">'
                    html += '</div>'
                html += '</div>'
            html += '</div>'
        html += '</div>'
    html += ' </div>';

    $('#school_11').append(html);
    $('.province_school_11_'+length).select2();
    $('.province_school_11_'+length+'s').select2();
    $.ajax({
        type: "get",
        url: "/info/province_shool",
        dataType: 'json',
        success: function (response) {
            $('.province_school_11_'+length).html('').select2({
                data: response
            });
        }
    });
});

$('#add_school_12').click(function(){
    var length = 1+ document.getElementsByClassName('province_school12').length
    var soft_del = 1000+length
    var html = '<div class="card-body" style="padding-top: 0px;padding-bottom: 0px" id="'+soft_del+'">'
    html += '<div class="row">'
        html +='<div class="col-md-3 col-12">'
            html +='<div class="form-group row" style="margin-bottom: 3px">'
                html +='<label for="inputEmail3" class="col-sm-4 col-form-label" style="padding-bottom: 0px "><i class="fa fa-trash delArea" onclick = "del_area_2(0,'+soft_del+')" style="color: red" id_area = "0" id_del="'+soft_del+'"></i>&nbsp;&nbsp;Tỉnh/TP:</label>'
                html +='<div class="col-sm-8" >'
                    html +='<select  class="province_school province_school12 province_school_12_'+length+' province_school_new" id = "province_school_12_'+length+'" style="width: 100%;">'

                    html +='</select>'
                    html +='</div>'
                html +='</div>'
            html +='</div>'
        html +='<div class="col-md-6 col-12">'
        html +='<div class="form-group row" style="margin-bottom: 3px">'
            html +='<label for="inputEmail3" class="col-sm-3 col-form-label" style="padding-bottom: 0px ">Trường THPT:<sup id = "v_province_school_12_'+length+'s" style="padding: 0;color:#17a2b8"></sup></label>'
            html += '<div class="col-sm-9">'
                html += '<select class="school school_new province_school_12_'+length+'s" id_area = "0" id-data = "12" id = "province_school_12_'+length+'s"  style="width: 100%;">'
                html += '</select>'
            html += '</div>'
            html += '</div>'
        html += '</div>'
        html += '<div class="col-md-3 col-12">'
            html += '<div class="form-group row" style="margin-bottom: 3px">'
                html += '<label for="inputEmail3" class="col-sm-7 col-form-label" style="padding-bottom: 0px">Thời gian học (tháng):</label>'
                html += '<div class="col-sm-5">'
                        html += ' <input type="text" class="form-control time time_12" id = "province_school_12_'+length+'stime" style="height:30px" value = "">'
                    html += '</div>'
                html += '</div>'
            html += '</div>'
        html += '</div>'
    html += ' </div>';

    $('#school_12').append(html);
    $('.province_school_12_'+length).select2();
    $('.province_school_12_'+length+'s').select2();
    $.ajax({
        type: "get",
        url: "/info/province_shool",
        dataType: 'json',
        success: function (response) {
            $('.province_school_12_'+length).html('').select2({
                data: response
            });
        }
    });
});


//Change Tỉnh thay đổi Trường
$(document).on('change','.province_school',function(){
    var id_dom = $(this).attr('id')+'s'
    $.ajax({
        type: "get",
        url: "/info/province_shools/"+$(this).val(),
        dataType: 'json',
        success: function (response) {
            var schools = document.getElementsByClassName('school')
            for(var i =0; i<schools.length;i++){
                if(id_dom ==  $(schools[i]).attr('id')){
                    $(schools[i]).html('').select2({
                        data:  response,
                    })
                }
            }
        }
    });
})

//Change Trường thay đổi khu vực
$(document).on('change','.school',function(){
    loadarea($(this).val(),$(this).attr('id'))
    $('#priority_area').text('')
});

//Them trường và Tính khu vực ưu tiên
$('#addArea').on('click',function(){
    $.ajax({
        type: "get",
        url: "/info/check_reg",
        // caches: false,
        success: function (response) {
            if(response == 0){
                var provinces = document.getElementsByClassName('province_school')
                var schools = document.getElementsByClassName('school')
                var times = document.getElementsByClassName('time')
                var time_10 = document.getElementsByClassName('time_10')
                var time_11 = document.getElementsByClassName('time_11')
                var time_12 = document.getElementsByClassName('time_12')


                if(time_10.length >9 || time_10.length >9 || time_10.length >9){
                    var maxschools = 1;
                }

                var time_schoool = 0;

                if(time_10.length >0 && time_11.length >0 && time_12.length >0){
                    var sum = 0;
                    for(let i = 0;i<time_10.length;i++){
                        sum = sum + Number($(time_10[i]).val())
                    }
                    if(sum != 9){
                        time_schoool++
                    }

                    var sum = 0;
                    for(let i = 0;i<time_11.length;i++){
                        sum = sum + Number($(time_11[i]).val())
                    }
                    if(sum != 9){
                        time_schoool++
                    }

                    var sum = 0;
                    for(let i = 0;i<time_12.length;i++){
                        sum = sum + Number($(time_12[i]).val())
                    }
                    if(sum != 9){
                        time_schoool++
                    }
                }else{
                    time_schoool = -1
                }

                var dempro = 0
                for(let i = 0;i<provinces.length;i++){
                    if($(provinces[i]).val() == 0){
                        dempro++;
                    }
                }
                var demsch = 0;
                for(let i = 0;i<schools.length;i++){
                    if($(schools[i]).val() == 0){
                        demsch++;
                    }
                }
                var maxtime = 0;
                var demtime = 0;
                var sumtime = 0;
                var reg =0;
                var myRe = /^[+]?((\d+(\.\d*)?)|(\.\d+))$/;
                for(let i = 0;i<times.length;i++){
                    if(Number($(times[i]).val()) > 9){
                        maxtime++;
                    }
                    if($(times[i]).val() == 0){
                        demtime++;
                    }
                    if(myRe.test($(times[i]).val()) == false){
                        reg++;
                    }
                    sumtime =sumtime + Number($(times[i]).val())
                }
                if(reg>0){
                        toastr.warning("Thời gian tính theo tháng (nhập số)")
                }else{
                    if(time_schoool == -1){
                        toastr.warning("Chọn đủ 3 năm trung học phổ thông")
                    }else{
                        if(time_schoool >0){
                            toastr.warning("Thời gian học trong một lớp bằng 9 tháng")
                        }else{
                            if(sumtime !=  27){
                                toastr.warning("Tổng thời gian học phải bằng 27 tháng")
                            }else{
                                if(maxschools == 1){
                                    toastr.warning("Bạn học mỗi tháng 1 trường hay sao ạ!!!!!!")
                                }else{
                                    if( dempro == 0 && demsch == 0 && demtime == 0){
                                        var data = [];
                                        for (let i=0; i<provinces.length;i++){
                                            for (let j=0; j<schools.length;j++){
                                                for (let k=0; k<times.length;k++){
                                                    if($(provinces[i]).attr('id')+'stime' == $(schools[j]).attr('id')+'time' && $(schools[j]).attr('id')+'time' == $(times[k]).attr('id')){
                                                        data[i] = [
                                                            $(provinces[i]).val(),$(schools[j]).val(),$(times[k]).val(),$(schools[j]).attr('id-data'),$(schools[j]).attr('id_area')
                                                            ]
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                        data = {
                                            'data': data,
                                            'graduation_year_user': $('#graduation_year_user').val(),
                                        }
                                        $.ajax({
                                            type: "post",
                                            url: "/info/addArea",
                                            data: data,
                                            // dataType: 'json',
                                            success: function (response) {
                                                if(response == 'check_info_false'){
                                                    toastr.warning("Bạn chưa lưu thông tin cá nhân")
                                                }else{
                                                    if(response == 1000){
                                                        toastr.warning('Thí sinh phải học 3 lớp 10, 11, 12')
                                                    }else{
                                                        if(response > 0){
                                                            toastr.success('Cập nhật thành công')
                                                        }else{
                                                            toastr.warning('Không có dữ liệu mới')
                                                        }
                                                    }
                                                    province_shool_10()
                                                    province_shool_11()
                                                    province_shool_12()
                                                    loadPriority_area()
                                                }
                                            }
                                        });
                                    }else{
                                        toastr.warning('Bạn chưa chọn Trường THPT hoặc chưa chọn thời gian học tại trường THPT')
                                    }
                                }
                            }
                        }
                    }
                }

            }else{
                toastr.warning("Bạn dá đăng ký xét tuyển, không thay đổi được Trường THPT")
                loadPriority_area()
                province_shool_10()
                province_shool_11()
                province_shool_12()
            }
        }
    })
})


//Load Khu vực ưu tiên để tính điểm xét tuyển
loadPriority_area()

// Xóa Trường




// $(document).on('click','.delArea',function(){
//     var id = $(this).attr('id_area')
//     var id_del = $(this).attr('id_del')
//     $.ajax({
//         type: "get",
//         url: "/info/check_reg",
//         // caches: false,
//         success: function (response) {
//             if(response == 1){
//                 toastr.warning("Bạn đã đăng ký nguyện vọng nên không thay đổi được Trường THPT")
//                 province_shool_10();
//                 province_shool_11();
//                 province_shool_12();
//             }else{
//                 alert(id)
//                 if(id == 0){
//                     $('#'+id_del).remove();
//                 }else{
//                     $.ajax({
//                         type: "post",
//                         url: "/info/delArea/"+id,
//                         success: function (response) {
//                             if(response == 1){
//                                 province_shool_10();
//                                 province_shool_11();
//                                 province_shool_12();
//                                 toastr.success("Xóa thành công");
//                             }
//                         }
//                     });
//                 }
//             }
//         }
//     })
// })

//Load Chính sách ưu tiên
loadPriority_Policy()



//Change Chính sách thay đổi Chi chú
$('#Priority_policy').on('change',function(){
    if($(this).val() == 0){
        $('#load_list_policy').text('')
    }
    $.ajax({
        type: "get",
        url: "info/changePriority_Policy/"+$(this).val(),
        dataType: 'json',
        success: function (response) {
            // if(response.check_reg == 1){
            //     toastr.warning("Thí sinh đã đăng ký nguyện vọng")
            //     loadPriority_Policy()
            //     loadnote_Priority_Policy()
            // }else{
                // if(response.act == 1){
                    // toastr.warning('Hình ảnh của đối tượng ưu tiên cũ đã xóa, vui lòng upload hình mới')
                    $('#note_Priority_policy').val(response.policys)
                    $('#load_list_policy').html(response.html)
                // }else{
                //     toastr.warning('Hệ thống bị lỗi, vui lòng liên hệ 02923.898.167')
                //     loadPriority_Policy()
                //     loadnote_Priority_Policy()
                // }
            // }

        }
    });

})



//Add Đối tượng chính sách ưu tiên
$('#addPriority_policy').on('click',function(){
    $('#addPriority_policy').attr('disabled','true')
    var policy_attr = document.getElementsByClassName('policy_attr')
    if(policy_attr.length >0){
        var j = 0, k = 0;
        for (let i = 0; i<policy_attr.length ; i++){
            if($(policy_attr[i]).attr('data-old') == $(policy_attr[i]).attr('data')){
                j++;
            }

            if($(policy_attr[i]).attr('data') == 0){
                k++;
            }
        }
        if(k > 0 ){
            toastr.warning('Chưa upload minh chứng')
            $('#addPriority_policy').removeAttr('disabled')
        }else{
            if(j == policy_attr.length){
                toastr.warning('Bạn đã lưu rồi, không cần lưu nữa')
                $('#addPriority_policy').removeAttr('disabled')
            }else{
               var h = 0;
            }
        }
    }else{
        var h = 0;
    }
    if(h == 0 || $('#Priority_policy').val() == 0){
        $.ajax({
            type: "get",
            url: "/info/check_reg",
            success: function (response) {
                if(response == 1){
                    toastr.warning("Bạn dá đăng ký xét tuyển, không thay đổi được Đối tượng ưu tiên")
                    loadPriority_Policy()
                    loadnote_Priority_Policy()
                }else{
                    $.ajax({
                        type: "post",
                        url: "info/addPriority_policy",
                        data: {
                            id: $('#Priority_policy').val()
                        },
                        success: function (response) {
                            loadPriority_Policy()
                            if(response == 2){
                                toastr.warning("Bạn đã đăng ký xét tuyển, vui lòng chọn yêu cầu chỉnh sửa để cập nhật lại")
                            }else{
                                if(response == 1){
                                    toastr.success("Lưu thành công")
                                    add_img();
                                }else{
                                    toastr.warning("Cập nhật thất bại")
                                }
                            }
                            $('#addPriority_policy').removeAttr('disabled')
                        }
                    });
                }
            }
        })
    }



})

//Load hướng dẫn chính sách ưu tiên
loadnote_Priority_Policy()

$('#crop_close').on('click',function(){
    $('.modal').hide('fast')
})





})//Ready

function del_area_2(id,id_del){
    $.ajax({
        type: "get",
        url: "/info/check_reg",
        // caches: false,
        success: function (response) {
            if(response == 1){
                toastr.warning("Bạn đã đăng ký nguyện vọng nên không thay đổi được Trường THPT")
                province_shool_10();
                province_shool_11();
                province_shool_12();
            }else{
                if(id == 0){
                    $('#'+id_del).remove();
                }else{
                    $.ajax({
                        type: "post",
                        url: "/info/delArea/"+id,
                        success: function (response) {
                            if(response == 1){
                                province_shool_10();
                                province_shool_11();
                                province_shool_12();
                                toastr.success("Xóa thành công");
                            }
                        }
                    });
                }
            }
        }
    })
}



function id_card_users_img(id,type){
    $('#open_img_policy').val('');
    $('#open_img_policy').attr('id-data',id)
    $('#open_img_policy').attr('type_img',type)
    $('#open_img_policy').click()
}

function graduation_year_user_img(id,type){
    $('#open_img_policy').val('');
    $('#open_img_policy').attr('id-data',id)
    $('#open_img_policy').attr('type_img',type)
    $('#open_img_policy').click()
}

//Hộ khẩu thường trú Tỉnh
function province(){
    $.ajax({
        type: "post",
        url: "/info/province",
        dataType: 'json',
        success: function (response) {
            $('.province').select2({
                 data:  response,
            });
        }
    });
}

//Hộ khẩu thường trú Huyện
function province2(){
    $.ajax({
        type: "get",
        url: "/info/province2",
        dataType: 'json',
        success: function (response) {
            $('.province2').html('').select2({
                 data:  response,
            });
        }
    });
}

//Hộ khẩu thường trú Xã
function province3(){
    $.ajax({
        type: "get",
        url: "/info/province3/",
        dataType: 'json',
        success: function (response) {
            $('.province3').html('').select2({
                 data:  response,
            });
        }
    });
}

//Dân tộc
function nationUser(){
    $.ajax({
        type: "get",
        url: "/info/nationUser",
        dataType: "json",
        success: function (response) {
            $('#nation_user').html('').select2({
                data: response
            })
        }
    });
}

//Noi sinh
function placeUser(){
    $.ajax({
        type: "get",
        url: "/info/placeUser",
        dataType: "json",
        success: function (response) {
            $('#id_place_user').html('').select2({
                data: response
            })
        }
    });
}

//Thông tin đăng ký
function loadRegister(){
    $.ajax({
        type: "get",
        url: "/info/loadRegister",
        dataType: 'json',
        success: function (response) {
            $('#id_card_users').val(response[0].id_card_users)
            $('#phone_users').val(response[0].phone_users)
            $('#email_users').val(response[0].email_users)
        }
    });
}

//Thông tin cơ bản
function loadInfoUser(){
    $.ajax({
        type: "get",
        url: "/info/loadInfoUser",
        dataType: 'json',
        success: function (response) {
            if(response.info.length > 0){
                $('#name_user').val(response.info[0].name_user)
                $('#birth_user').val(response.info[0].birth_user)
                $('#id_place_user').val(response.info[0].id_place_user)
                $('#userImg').attr('src',response.info[0].link_img_user)
                if(response.info[0].sex_user == 1){
                    $('#female_user').attr('checked','checked')
                }else{
                    $('#male_user').attr('checked','checked')
                }
                $('#emailsc_user').val(response.info[0].emailsc_user)
                $('#phonesc_user').val(response.info[0].phonesc_user)
                $('#address_user').val(response.info[0].address_user)
                $('#graduation_year_user').val(response.info[0].graduation_year_user)
                var today = new Date();
                if(response.info[0].graduation_year_user < today.getFullYear()){
                    $('#graduation_year_user_attr').show()
                    if(response.data_old > 0){
                        $('#graduation_year_user_attr').attr('data_old',response.data_old_year)
                        $('#graduation_year_user_attr').attr('data',response.data_old_year)
                        $('#graduation_year_user_attr').css('color','#007bff')
                    }
                }else{
                    $('#graduation_year_user_attr').hide()
                }

                if(response.data_old > 0){
                    $('#id_card_users_attr').attr('data_old',response.data_old)
                    $('#id_card_users_attr').attr('data',response.data_old)
                    $('#id_card_users_attr').css('color','#007bff')
                }
            }else{
                $('#birth_user').val('2005-01-01')
            }
        }
    });
}

//Mở upload ảnh
function open_userImg(){
    $('#open_userImg').click()
}

                                        // Khu vực ưu tiên

//Load Trường lớp 10
function province_shool_10(){
    $.ajax({
        type: "get",
        url: "/info/province_shool_10/",
        success: function (response) {
            $('#school_10').html(response.html)
            response.datas.forEach(element => {
                $('.'+element.id_dom_school).html('').select2({
                    data:   element.data_school
                })
                $('.'+element.id_dom_province).html('').select2({
                    data:   element.data_province
                })
                $('#'+element.id_time).attr('value',element.time)
            });
        }
    });
}

//Load Trường lớp 11
function province_shool_11(){
    $.ajax({
        type: "get",
        url: "/info/province_shool_11/",
        success: function (response) {
            $('#school_11').html(response.html)
            response.datas.forEach(element => {
                $('.'+element.id_dom_school).html('').select2({
                    data:   element.data_school
                })
                $('.'+element.id_dom_province).html('').select2({
                    data:   element.data_province
                })
                $('#'+element.id_time).attr('value',element.time)
            });
        }
    });
}

//Load Trường lớp 12
function province_shool_12(){
    $.ajax({
        type: "get",
        url: "/info/province_shool_12/",
        success: function (response) {
            $('#school_12').html(response.html)
            response.datas.forEach(element => {
                $('.'+element.id_dom_school).html('').select2({
                    data:   element.data_school
                })
                $('.'+element.id_dom_province).html('').select2({
                    data:   element.data_province
                })
                $('#'+element.id_time).attr('value',element.time)
            });
        }
    });
}

//Load Khu vực ưu tiên theo Trường
function loadarea(id,id_show){
    $.ajax({
        type: "post",
        url: "info/area/"+id,
        dataType: 'json',
        success: function (response) {
            $('#v_'+id_show).text(response[0].id_priority_area)
        }
    });
}

//Load khu vực ưu tiên để tính điểm xét tuyển
function loadPriority_area(){
    $.ajax({
        type: "get",
        url: "info/Priority_area/",
        // dataType: 'json',
        success: function (response) {
            $('#priority_area').text(response)
        }
    });
}

// Load đối tượng chính sách
function loadPriority_Policy(){
    $.ajax({
        type: "get",
        url: "info/Priority_Policy",
        dataType: 'json',
        success: function (response) {
            $('#Priority_policy').html('').select2({
                data: response.policys
            })
            $('#load_list_policy').html(response.html)
        }
    });
}

function loadnote_Priority_Policy(){
    $.ajax({
        type: "get",
        url: "info/loadnote_Priority_Policy/",
        dataType: 'json',
        success: function (response) {
            $('#note_Priority_policy').val(response[0].note_policy_user)
        }
    });
}




//Open Ảnh policy
function policy(id,type){
    $('#open_img_policy').val('');
    $.ajax({
        type: "get",
        url: "/info/check_reg",
        // caches: false,
        success: function (response) {
            if(response == 1){
                toastr.warning("Bạn dá đăng ký xét tuyển, không thay đổi được Đối tượng ưu tiên")
                loadPriority_Policy()
                loadnote_Priority_Policy()
            }else{
                $('#open_img_policy').click()
                $('#open_img_policy').attr('id-data',id)
                $('#open_img_policy').attr('type_img',type)
                // $("#policy_attr").attr("data",src)
                // $("#img_hb"+id_class).css("color",'#007bff')
                // $("#img_hb"+id_class).attr("idcheck_hb1_"+id_class,a)
            }
        }
    })
}

$('#open_img_policy').on('change',function(){
    // e.preventDefault();
    var id = $(this).attr('id-data')
    var type_img = $(this).attr('type_img')
    var type1 = this.files[0].type
    if(type1 == 'image/png' || type1 == 'image/pjpeg' || type1 == 'image/jpeg'){
        var reader = new FileReader();
        reader.onload = function (event) {
            src = event.target.result
            var attr = document.getElementsByClassName('attr')
            for(let i = 0; i<attr.length; i++){
                if($(attr[i]).attr('id-data') == id && type_img == $(attr[i]).attr('type_img')){
                    $(attr[i]).attr("data",src)
                    $(attr[i]).css("color",'#007bff')
                    break;
                }
            }
        }
        reader.readAsDataURL(this.files[0]);
        // $('#modal_policy').show('slow');
    }else{
        toastr.warning("Vui lòng chọn file ảnh")
    }
})


function add_img(policy_attr){
    var policy_attr = document.getElementsByClassName('policy_attr')
    var data = []
    for(let i = 0;i<policy_attr.length;i++){
        data[i] = [$(policy_attr[i]).attr('type_img'),$(policy_attr[i]).attr('id-data'),$(policy_attr[i]).attr('data')]
    }
    $.ajax({
        url: "/info/crop_policy",
        type:'POST',
        data: {
           data : data
        },
        success:function(data){
            loadPriority_Policy();
        }
    })

}



