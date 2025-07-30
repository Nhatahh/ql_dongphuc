
$(document).ready(function(){
    $.ajax({
        type: "get",
        url: "/admin/clear_cache",
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('#sign_in').on('click',function(){
        $('#v_email').text('')
        $('#v_password').text(),
        $('#v_info_login_admin').text('')
        $.ajax({
            type: "post",
            url: "/admin/users/login/store",
            data: {
               email : $('#email').val(),
               password : $('#password').val(),
            },
            success: function (data) {
                if(data == 1){
                    window.location.href = "https://congmotcua.ctuet.edu.vn/admin/main";
                    //  window.location.href = "https://xettuyentest.ctuet.edu.vn/admin/main";
                }else{
                    if(data == 0){
                        $('#info_login_admin').text('Thông tin đăng nhập không khớp với tài khoản đã đăng ký');
                    }else{
                        var dem = 0;
                        var dom = document.getElementsByClassName("validate_login_admin");
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
    })

})



