$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
//Khởi đầu
// $('.select_wish').select2()

    load_wish()
    //LOAD GỢI Ý ĐIỂM TỔ HỢP
    // loadsuggest_group()

    //Load Nguyện vọng


    //Lưu nguyện vọng
    $('#save_wish').on('click',function(){
       save_wish()
    })

    //Thêm nguyện vọng
    $('#add_wish').on('click',function(){
        add_wish()
     })

     $('#add_wish2').on('click',function(){
        add_wish()
     })



    //  Chage Phương thức
    $(document).on('change','.method_wish',function(){
        change_method($(this).val(),$(this).attr('id-data'))
     })

     //Change Ngành
    $(document).on('change','.major_wish',function(){
        change_major($(this).val(),$(this).attr('id-data'))
     })

     //Change tổ hợp
     $(document).on('change','.group_wish',function(){
        var id_method = ($('#load_wish').find('#method_wish'+$(this).attr('id-data')).val())
        change_group($(this).val(),$(this).attr('id-data'),id_method)
     })


     //Đăng ký xét tuyển
    $('#reg_wish').on('click',function(){
        var add_wish = document.getElementsByClassName('save_wish');
        // alert(add_wish)
        if(add_wish.length >0){
            data = []
            for(i=0;i<add_wish.length;i++){
                data[i] = [$(add_wish[i]).attr('id'),$(add_wish[i]).attr('id_year'),$(add_wish[i]).attr('id_batch'),$(add_wish[i]).find('.number_wish').val(),$(add_wish[i]).find('.method_wish').val(),$(add_wish[i]).find('.major_wish').val(),$(add_wish[i]).find('.group_wish').val(),$(add_wish[i]).find('.mark_wish').val()]
            }
            $.ajax({
                type: "post",
                url: "/registerwish/check_khop",
                data:
                {data: data},
                success: function (response) {
                    if(response == 1){
                        var choice = confirm("Nếu bạn đăng ký xét tuyển thì không được thay đổi nguyện vong trong đợt xét tuyển này! Bạn chắc chắn!!!");
                        if(choice == true){
                            $('#modal_loadding_wish').show('')
                            $.ajax({
                                type: "post",
                                url: "/registerwish/reg_wish",
                                success: function (response) {
                                    $('#modal_loadding_wish').hide('')
                                    if(response == 'check_false_info'){
                                        toastr.warning("Bạn chưa lưu thông tin cá nhân, vui lòng trở lại nhập thông tin cá nhân tại màn hình Hồ sơ xét tuyển -> Thông tin cá nhân")
                                    }else{
                                        if(response == 'check_false'){
                                            $('#info_reg_wish').text('')
                                            toastr.warning("Thí sinh đã đăng ký xét tuyển trong đợt này! Vui lòng chờ đợt sau!")
                                        }else{
                                            if(response == 1){
                                                 $('#info_reg_wish').text('Hệ thống đã gửi mail xác nhận thứ tự nguyện vọng thí sinh đã đăng ký, vui lòng check mail để kiểm tra nguyện vọng đang ký chính xác')
                                                toastr.success("Đăng ký xét tuyển thành công! Vào màn hình Thanh toán lệ phí để được hướng dẫn bước tiếp theo")
                                            }else{
                                                toastr.danger("Đăng ký thất bại, vui lòng đăng ký lại hoặc liên hệ về Phòng Đào tạo. Hotline: 02923898167!")
                                            }
                                        }
                                    }
                                    load_wish()
                                }
                            });
                        }
                    }else{
                        toastr.warning("Bạn chưa lưu nguyện vọng. Hãy kiểm tra và lưu nguyện vọng")
                    }
                }
            })
        }else{
            toastr.warning("Bạn chưa đăng ký nguyện vọng")
        }
    })





})//EM REadk

//Check Đăng ký nguyện vọng
// function check_reg(){
// $.ajax({
//     type: "post",
//         url: "/registerwish/check_reg",
//         success: function (response) {
//             a = response
//         }

//     });
// return a;
// }




function del_wish(id,id_data){
    $.ajax({
        type: "post",
        url: "/registerwish/check_reg",
        success: function (response1) {
            if(response1 == 1){
                toastr.warning("Thí sinh đã đăng ký xét tuyển, nên không được thay đổi nguyện vọng xét tuyển")
                load_wish()
            }else{
                if(id == 0){
                    $('#remove_wish'+id_data).remove()
                }else{
                    $('#remove_wish'+id_data).remove()
                    $.ajax({
                        type: "post",
                        url: "/registerwish/check_expenses/"+id,
                        success: function (response2) {
                            if(response2 == 1){
                                toastr.warning("Nguyện vọng đã được đóng phí, không được xóa, hãy chọn bằng cách đổi chọn lại phương thức, ngành xét tuyển")
                                load_wish()
                            }else{
                                $.ajax({
                                    type: "get",
                                    url: "/registerwish/del_wish/"+id,
                                    success: function (response) {
                                        if(response == 1){
                                            toastr.success('Đã xóa nguyện vọng, Thí sinh sắp xếp thứ tự nguyện vọng, lưu, và đăng ký xét tuyển lại')
                                        }else{
                                            toastr.success('Xóa không thành công')
                                        }
                                    load_wish()
                                    }
                                })
                            }
                        }
                    })
                }
            }
        }
        });
}

//Load nguyện vọng
function load_wish(){
    $.ajax({
        type: "get",
        url: "/registerwish/load_wish",
        success: function (response) {
            if(response.check_reg == 1){
                $('#edit_wish_sc').removeAttr("disabled")
                $('#reg_wish').attr("disabled",'true')
            }else{
                $('#edit_wish_sc').attr("disabled",'true')
                $('#reg_wish').removeAttr("disabled")

            }
            $('#load_wish').html(response.html);
            // $('#load_wish').
            response.datas.forEach(data => {
                $('#method_wish'+data.number).select2({
                    data: data.method
                })
                $('#major_wish'+data.number).select2({
                    data: data.major
                })

                $('#group_wish'+data.number).select2({
                    data: data.group
                })
           });
           setTimeout(() => {
                $.ajax({
                    type: "get",
                    url: "/registerwish/block_user",
                    success: function (res) {
                        if(res == 1){
                            $('#save_wish').attr('disabled','true')
                            $('#reg_wish').attr('disabled','true')
                            $('#edit_wish_sc').attr('disabled','true')
                        }
                    }
                })
           }, 0);

        }
    });
}

//Load gợi ý điểm
// function loadsuggest_group(){
//     $.ajax({
//         type: "get",
//         url: "/registerwish/loadsuggest_group",
//         success: function (response) {
//             $('#suggest_group_1').html(response.methodhb1)
//             $('#suggest_group_2').html(response.methodhb2)
//             $('#priority').html(response.priority)
//             $('#suggest_group_3').html(response.methodnl)

//             // $('.v_group_mark_methodhb1').hide();
//         }
//     });
// }

//Lưu nguyện vọng
function save_wish(){
    var add_wish = document.getElementsByClassName('save_wish')
    if(add_wish.length >0){
        $.ajax({
            type: "post",
            url: "/registerwish/check_reg",
            success: function (response1) {
                if(response1 == 1){
                    toastr.warning("Thí sinh đã đăng ký xét tuyển, nên không được thay đổi nguyện vọng xét tuyển")
                    load_wish()
                }else{
                    $('.number_wish').removeClass('warning_result')
                    $('.method_wish').removeClass('warning_result')
                    $('.group_wish').removeClass('warning_result')
                    $('.major_wish').removeClass('warning_result')
                    $('.mark_group_wish').removeClass('warning_result')
                    $('.min_wish').removeClass('warning_result')
                    $('.select2-selection').css('border-color', '')
                    var number_wish = document.getElementsByClassName('number_wish')
                    var method_wish = document.getElementsByClassName('method_wish')
                    var group_wish = document.getElementsByClassName('group_wish')
                    var major_wish = document.getElementsByClassName('major_wish')
                    var mark_group_wish = document.getElementsByClassName('mark_group_wish')

                    var fail = [];
                    var index = 0;

                    var dem1 = 0;
                    for(let j=0; j<number_wish.length;j++) {
                        if($(number_wish[j]).val() == 0 || $(number_wish[j]).val() == "" ){
                        dem1 ++
                        $(number_wish[j]).addClass('warning_result')
                        }
                    }
                    if(dem1 > 0){
                        fail[index] = 'Thứ tự nguyện vọng không được trống hoặc bằng 0! ';
                        index++;
                    }

                    dem1 = 0
                    for(let j=0; j<method_wish.length;j++) {
                        if($(method_wish[j]).val() == 0){
                            $(method_wish[j]).next().find('.select2-selection').css('border-color', 'red');
                            dem1 ++
                        }
                    }
                    if(dem1 > 0){
                        fail[index] = 'Bạn chưa chọn Phương thức xét tuyển! ';
                        index++;
                    }


                    dem1 = 0
                    for(let j=0; j<major_wish.length;j++) {
                        if($(major_wish[j]).val() == 0){
                            $(major_wish[j]).next().find('.select2-selection').css('border-color', 'red');
                            dem1 ++
                        }
                    }

                    if(dem1 > 0){
                        fail[index] = 'Bạn chưa chọn Ngành xét tuyển! ';
                        index++;
                    }

                    dem1 = 0
                    for(let j=0; j<group_wish.length;j++) {
                        if($(group_wish[j]).val() == 0){
                            $(group_wish[j]).next().find('.select2-selection').css('border-color', 'red');
                            dem1 ++
                        }
                    }

                    if(dem1 > 0){
                        fail[index] = 'Bạn chưa chọn Tổ hợp xét tuyển! ';
                        index++;
                    }

                    var news =""
                    if(fail.length >0){
                        for(let i = 0;i<fail.length; i++){
                        news += fail[i]
                        }
                        toastr.warning(news)
                    }else{
                        var check_double = 0;
                        var dem2 = 0;
                        for(let j=0; j<major_wish.length;j++) {
                            for(let i=0; i<major_wish.length;i++) {
                                if($(major_wish[j]).val() == $(major_wish[i]).val() && i != j){
                                    dem2 ++
                                    $(major_wish[j]).next().find('.select2-selection').css('border-color', 'red');
                                    $(major_wish[i]).next().find('.select2-selection').css('border-color', 'red');
                                    $(major_wish[j]).attr('id-data');$(major_wish[i]).attr('id-data')
                                    $('#method_wish'+$(major_wish[j]).attr('id-data')).next().find('.select2-selection').css('border-color', 'red');
                                    $('#method_wish'+$(major_wish[i]).attr('id-data')).next().find('.select2-selection').css('border-color', 'red');
                                }
                            }
                            if( dem2> 0){
                                check_double = 1
                                break;
                            }else{
                                check_double = 0
                            }
                        }
                        if(check_double > 0){
                            toastr.warning( 'Nguyện vọng bị trùng (Trùng phương thức và ngành xét tuyển)! ');
                        }else{
                            var dem = 0; check_number =0;
                            for(let i = 1;i<1+number_wish.length;i++){
                                for(let j=0; j<number_wish.length;j++) {
                                    if(Number($(number_wish[j]).val()) == i ){
                                        dem ++
                                    }
                                }
                                if( dem == 1){
                                    check_number = 1
                                }else{
                                    check_number = 0
                                    break;
                                }
                                dem = 0
                            }
                            var dem1 = 0;
                            for(let j=0; j<mark_group_wish.length;j++) {
                                if($(mark_group_wish[j]).val() < $('#min_wish'+$(mark_group_wish[j]).attr('id-data')).val()){
                                    dem1 ++
                                    $(mark_group_wish[j]).addClass('warning_result')
                                    $('#min_wish'+$(mark_group_wish[j]).attr('id-data')).addClass('warning_result')
                                    break;
                                }
                            }
                            if(dem1 == 1){
                                toastr.warning('Tồn tại ngành có điểm tổ hợp bé hơn ngưỡng nhận hồ sơ xét tuyển')
                            }else{
                                if(check_number == 0){
                                    $('.number_wish').addClass('warning_result')
                                    toastr.warning("Vui lòng sắp xếp thứ tự nguyện vọng theo thứ tự ưu tiên tăng dần, bắt đầu từ 1")
                                }else{
                                    if(add_wish.length >0){
                                        data = []
                                        for(i=0;i<add_wish.length;i++){
                                            data[i] = [$(add_wish[i]).attr('id'),$(add_wish[i]).attr('id_year'),$(add_wish[i]).attr('id_batch'),$(add_wish[i]).find('.number_wish').val(),$(add_wish[i]).find('.method_wish').val(),$(add_wish[i]).find('.major_wish').val(),$(add_wish[i]).find('.group_wish').val(),$(add_wish[i]).find('.mark_wish').val(),$(add_wish[i]).find('.area_mark_check').val(),$(add_wish[i]).find('.mark_group_wish').val()]
                                        }
                                        $.ajax({
                                            type: "post",
                                            url: "/registerwish/save_wish",
                                            data:
                                            {data: data},
                                            success: function (response) {
                                                if(response == "check_false"){
                                                    toastr.warning("Tồn tại ngành có điểm xét tuyển bé hơn ngưỡng đầu vào (18 điểm)")
                                                }else{
                                                    if(response >0){
                                                        toastr.success("Cập nhật nguyện vọng thành công")
                                                    }else(
                                                        toastr.warning("Không có dữ liệu mới")
                                                    )
                                                }
                                                load_wish()
                                            }
                                        });
                                    }else{
                                        toastr.warning("Chưa có nguyện vọng, bạn hãy đăng ký nguyện vọng")
                                    }
                                }
                            }
                        }
                    }
                }


            }
        })
    }else{
        toastr.warning("Thí sinh chưa đăng ký nguyện vọng")
    }

}
//Thêm nguyện vọng
function add_wish(){
    $.ajax({
        type: "post",
        url: "/registerwish/check_reg",
        success: function (response1) {
            if(response1 == 1){
            toastr.warning("Thí sinh đã đăng ký xét tuyển, nên không được thay đổi nguyện vọng xét tuyển")
            load_wish()
            }else{
            var number = document.getElementsByClassName('save_wish').length
                $.ajax({
                    type: "post",
                    url: "/registerwish/add_wish/"+number,
                    success: function (response) {
                        if(response == 'number_wish_false'){
                            toastr.warning("Số nguyện vọng vượt quy định của đợt xét tuyển")
                        }else{
                            $('#load_wish').append(response.html);
                            response.datas.forEach(data => {
                                $('#method_wish'+data.number).select2({
                                    data: data.method
                                })
                                $('#major_wish'+data.number).select2({
                                    data: data.major
                                })
                                $('#group_wish'+data.number).select2({
                                    data: data.group
                                })
                        });
                        }
                    }
                });
            }
        }
    })
}

// Xóa nguyện vọng

//Chage Phương thức
function change_method(id_method,dom){
    $.ajax({
        type: "post",
        url: "/registerwish/change_method",
        data:
            {
                id_method: id_method,
                dom: dom,
            },
        success: function (data) {
            $('#major_wish'+data.dom).html('').select2({
                data: data.data
            })
            $('#group_wish'+data.dom).html('').select2({
            })
            $('#min_wish'+data.dom).val('')
            $('#mark_group_wish'+data.dom).val('')
            $('#prio_wish'+data.dom).val('')
        }
    });
}

function change_major(id_major,dom){
    $.ajax({
        type: "post",
        url: "/registerwish/change_major",
        data:
            {
                id_major: id_major,
                dom: dom,
            },
        success: function (data) {
            $('#group_wish'+data.dom).html('').select2({
                data: data.data
            })
            $('#min_wish'+data.dom).val(data.min_mark)
            $('#mark_wish'+data.dom).val('')
            $('#mark_group_wish'+data.dom).val('')
            $('#prio_wish'+data.dom).val('')
        }
    });
}

function change_group(id_group,dom,id_method){
    $.ajax({
        type: "post",
        url: "/registerwish/change_group",
        data:
            {
                id_group: id_group,
                id_method: id_method,
                dom: dom,
            },
        success: function (data) {
            $('#mark_wish'+data.dom).val(data.data)
            $('#mark_group_wish'+data.dom).val(data.mark_group)
            $('#prio_wish'+data.dom).val(data.mark_prio)
        }
    });
}


function edit_wish_sc(){

    $.ajax({
        type: "post",
        url: "/registerwish/edit_wish_sc",
        success: function (data) {
            if(data == 0){
                $('#edit_wish_sc').attr("disabled",'true')
                $('#reg_wish').removeAttr("disabled")
                toastr.success("Đã yêu cầu thành công, thí sinh vui lòng cập nhật trong vòng 24h")
            }else{
                toastr.warning("Cập nhật thất bại, vui lòng tải lại trang")
                load_wish();
            }
        }
    });
}
