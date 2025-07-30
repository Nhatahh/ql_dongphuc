$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#modal_loadding_reg').hide()
    $.ajax({
        type: "post",
        url: "/register/active_batch",
        success: function (res) {

            switch (res.reg) {
                case 1:
                    $('#showinfo1').removeAttr('disabled')
                    $('#info_register').text('Hệ thống đang mở cho thí sinh đăng ký')
                    break;
                default:
                    $('#showinfo1').attr('disabled','true')
                    $('#info_register').text('Hệ thống đang khóa, thí sinh vui lòng xem thông báo tại tuyensinh.ctuet.edu.vn')
                    break;
            }
        }
     })
})


function showinfo(){
    $('#modal_loadding_reg').show()
    $('#showinfo1').attr('disabled','true')
    $.ajax({
        type: "post",
        url: "/register/store",
        data:{
            email_register: $('#email_register').val(),
            phone_register: $('#phone_register').val(),
            cmnd_register: $('#cmnd_register').val()
        },
        success: function (data) {
            $('#modal_loadding_reg').hide()
            $('#showinfo1').removeAttr('disabled')
            if(data == 1){
                $('#info_register').text('Thí sinh đã đăng ký thành công! Hệ thống đã gửi thông tin đăng nhập tại mail '+$('#email_register').val())
                $('#v_email_register').text('');
                $('#v_phone_register').text('');
                $('#v_cmnd_register').text('');
            }else{
                if(data == 2){
                    $('#info_register').text('Trong đợt xét tuyển này, đã tồn tại tài khoản CMND/TCC hoặc Email')
                    $('#v_email_register').text('');
                    $('#v_phone_register').text('');
                    $('#v_cmnd_register').text('');
                }else{
                    var dem = 0;
                    var dom = document.getElementsByClassName("validate_register");
                    var keys = Object.keys(data)
                    for(let i=0;i<dom.length;i++){
                        for(let j=0;j<keys.length;j++){
                            if($(dom[i]).attr('name') == keys[j])
                            {
                                $('#v_'+keys[j]).text(data[keys[j]])
                                dem++;
                            }
                        }
                        if(dem == 0){
                            $('#v_'+$(dom[i]).attr('name')).text("")
                        }
                        dem = 0;
                    }

                }

            }
        }
    });
}




function passwordreset(){
    $('#modal_loadding_pasreset').show('')
    $('#info_passwordreset').text('')
    $('#v_email_passwordreset').text('');
    $('#v_phone_passwordreset').text('');
    $('#v_cmnd_passwordreset').text('');


    // alert($('#email_passwordreset').val())
    // alert($('#cmnd_passwordreset').val())
    // alert($('#phone_passwordreset').val())
    $.ajax({
        type: "post",
        url: "/passwordreset/store",
        data:{
            email_passwordreset: $('#email_passwordreset').val(),
            phone_passwordreset: $('#phone_passwordreset').val(),
            cmnd_passwordreset: $('#cmnd_passwordreset').val()
        },
        success: function (data) {
            $('#modal_loadding_pasreset').hide()
            if(data == 'false'){
                $('#info_passwordreset').text('Hệ thống đang bảo trì, vui lòng liên hệ 02923.898.167');
            }else{
                if(data == 1){
                    $('#info_passwordreset').text('Thành công! Hệ thống đã gửi thông tin tại mail '+$('#email_passwordreset').val())
                    $('#v_email_passwordreset').text('');
                    $('#v_phone_passwordreset').text('');
                    $('#v_cmnd_passwordreset').text('');
                }else{
                    if(data == 0){
                        $('#info_passwordreset').text('Thông tin không khớp với tài khoản đã đăng ký! Vui lòng kiểm tra lại!');
                    }else{
                        var dem = 0;
                        var dom = document.getElementsByClassName("validate_passwordreset");
                        var keys = Object.keys(data)
                        for(let i=0;i<dom.length;i++){
                            for(let j=0;j<keys.length;j++){
                                if($(dom[i]).attr('name') == keys[j])
                                {
                                    $('#v_'+keys[j]).text(data[keys[j]])
                                    dem++;
                                }
                            }
                            if(dem == 0){
                                $('#v_'+$(dom[i]).attr('name')).text("")
                            }
                            dem = 0;
                        }
                    }
                }
            }
        }
    });
}


// function UserRegister(){
//     window.location.href = "/register";
// }

function Userlogin(){
    $('#v_email_login').text('');
    $('#v_phone_login').text('');
    $('#v_cmnd_login').text('');
    $('#v_password_login').text('');
    $('#info_login').text('');
    $.ajax({
        type: "post",
        url: "login/store",
        data:{
            email_login: $('#email_login').val(),
            phone_login: $('#phone_login').val(),
            cmnd_login: $('#cmnd_login').val(),
            password_login: $('#password_login').val()
        },
        success: function (data) {
            if(data == 1){
                window.location.href = "https://congmotcua.ctuet.edu.vn/";
                // window.location.href = "https://xettuyentest.ctuet.edu.vn/";
            }else{
                if(data == 2){
                    $('#info_login').text('Hiện tại, chưa có đợt xét tuyển');
                }else{
                    if(data == 0){
                        $('#info_login').text('Thông tin đăng nhập không khớp với tài khoản đã đăng ký');
                    }else{
                        var dem = 0;
                    var dom = document.getElementsByClassName("validate_login");
                    var keys = Object.keys(data)
                    for(let i=0;i<dom.length;i++){
                        for(let j=0;j<keys.length;j++){
                            if($(dom[i]).attr('name') == keys[j])
                            {
                                $('#v_'+keys[j]).text(data[keys[j]])
                                dem++;
                                // alert(keys[j])
                            }
                        }
                        if(dem == 0){
                            $('#v_'+$(dom[i]).attr('name')).text("")
                        }
                        dem = 0;
                        }
                    }
                }

            }
        }
    })
}

