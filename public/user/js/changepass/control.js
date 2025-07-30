$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
})

function UserChangePass(id){
    $('#v_user_passwordreset_old').text(''),
    $('#v_user_passwordreset').text(''),
    $('#v_user_passwordreset_confirm').text(''),
    $.ajax({
        type: "get",
        url: "/updatepassword",
        data: {
            id: $('#id_user').attr('id-data'),
            user_passwordreset_old: $('#user_passwordreset_old').val(),
            user_passwordreset: $('#user_passwordreset').val(),
            user_passwordreset_confirm: $('#user_passwordreset_confirm').val(),
        },
        // dataType: "dataType",
        success: function (data) {
            if(data == 1){
                $('#v_user_passwordreset_old').text(''),
                $('#v_user_passwordreset').text(''),
                $('#v_user_passwordreset_confirm').text(''),
                toastr.success('Cập nhật thành công mật khẩu! Hệ thống sẽ đăng xuất!');
                setTimeout(() => {
                    logout();
                  }, 2000);
            }else{
                if(data == 0){
                    $('#v_user_passwordreset').text(''),
                    $('#v_user_passwordreset_confirm').text(''),
                    $('#v_user_passwordreset_old').text('Mật khẩu cũ không khớp')
                }else{
                    var dem = 0;
                    var dom = document.getElementsByClassName("validate_changepass");
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

function logout(){
    window.location.href = '/login';
    $.ajax({
        type: "post",
        url: "/logout",
        success: function (data) {

        }
    })
}
