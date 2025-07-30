$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    if($(document).width() > 992){
        $('#right_check_user').css('min-height','760px')
        $('#left_check_user').css('min-height','760px')
    }else{
        $('#right_check_user').css('min-height','0x')
        $('#left_check_user').css('min-height','0px')
    }

    $(window).resize(function(){
        if($(document).width()>992){
            $('#right_check_user').css('min-height','760px')
            $('#left_check_user').css('min-height','760px')
        }else{
            $('#right_check_user').css('min-height','0x')
            $('#left_check_user').css('min-height','0px')
        }
    });


    if($(document).width() > 992){
        $('#right_check').css('min-height','630px')
        $('#left_check').css('min-height','630px')
    }else{
        $('#right_check').css('min-height','0x')
        $('#left_check').css('min-height','0px')
    }

    $(window).resize(function(){
        if($(document).width()>992){
            $('#right_check').css('min-height','630px')
            $('#left_check').css('min-height','630px')
        }else{
            $('#right_check').css('min-height','0x')
            $('#left_check').css('min-height','0px')
        }
    });

    $('#id_card_reset_save').on('click',function(){
        cmnd = $('#id_card_reset').val()
        if(cmnd == '' || cmnd == 0){
            toastr.warning("Nhập chứng minh nhân dân")
        }else{
            $.ajax({
                type: "post",
                url: 'adduser/id_card_reset_save',
                data:{
                    id_card_users: cmnd,
                },
                success: function (data) {
                    switch (data) {
                        case '0':
                            var text = '<a style = "color: blue">Reset thất bại</a>'
                            break;
                        case '1':
                            var text = '<a style = "color: blue">Đã mở hệ thống tra cứu cho thí sinh</a>'
                            break;
                        case '2':
                            var text = '<a style = "color: blue">Có nhiều xét tuyển đang mở, Kiểm tra lại!!!!</a>'
                            break;
                        case '3':
                            var text = '<a style = "color: blue">Không có đợt đang mở</a>'
                            break;
                        case '4':
                            var text = '<a style = "color: blue">Hệ thống đã gửi thông tin đăng nhập cho thí sinh qua email '+$('#email_add').val()+'</a>'
                            break;

                        default:
                            break;
                    }

                    alert(data)
                }
            })
        }
    })

})


function add(){
    $('#modal_loadding_add').show();
    $('#add_user').attr('disabled','true');
    $.ajax({
        type: "post",
        url: 'adduser/add',
        data:{
            id_card_add: $('#id_card_add').val(),
            phone_add: $('#phone_add').val(),
            email_add: $('#email_add').val(),
        },
        success: function (data) {
            var values = Object.values(data)
            if(data == 1){
                var text = '<a style = "color: blue">Hệ thống đã gửi thông tin đăng nhập cho thí sinh qua email '+$('#email_add').val()+'</a>'
                $('#info_add').html(text)
                $('#modal_loadding_add').hide();
                $('#add_user').removeAttr('disabled');
            }else{
                if(data == 0){
                    toastr.warning("Hệ thống bị lỗi, vui lòng load lại hoặc nhấn Crtl F5")
                    $('#modal_loadding_add').hide();
                    $('#add_user').removeAttr('disabled');
                }else{
                    var text = '<a style = "color: blue">'+values[0]+'</a>'
                    $('#info_add').html(text)
                    $('#modal_loadding_add').hide();
                    $('#add_user').removeAttr('disabled');
                }
            }
        }
    })
}

$('#clear_add').on('click',function(){
    $('#id_card_add').val('')
    $('#phone_add').val('')
    $('#email_add').val('')
    $('#info_add').html('')
})

