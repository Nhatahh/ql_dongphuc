$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
})

function UserChangePass_admin(){
    $('#v_passwordreset_old_admin').text(''),
    $('#v_passwordreset_admin').text(''),
    $('#v_passwordreset_confirm_admin').text(''),
    $.ajax({
        type: "post",
        url: "/admin/updatepassword_admin",
        data: {
            id: $('#id_user_admin').attr('id-data'),
            user_passwordreset_old_admin: $('#user_passwordreset_old_admin').val(),
            user_passwordreset_admin: $('#user_passwordreset_admin').val(),
            user_passwordreset_confirm_admin: $('#user_passwordreset_confirm_admin').val(),
        },
        // dataType: "dataType",
        success: function (data) {
            if(data == 1){
                $('#v_passwordreset_old_admin').text(''),
                $('#v_passwordreset_admin').text(''),
                $('#v_passwordreset_confirm_admin').text(''),
                toastr.success('Cập nhật thành công mật khẩu! Hệ thống sẽ đăng xuất!');
                setTimeout(() => {
                    logout();
                  }, 2000);
            }else{
                if(data == 0){
                    $('#v_user_passwordreset_admin').text(''),
                    $('#v_user_passwordreset_confirm_admin').text(''),
                    $('#v_user_passwordreset_old_admin').text('Mật khẩu cũ không khớp')
                }else{
                    var dem = 0;
                    var dom = document.getElementsByClassName("validate_changepass_admin");
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
    window.location.href = '/admin/users/login';
    $.ajax({
        type: "post",
        url: "/admin/logout_admin",
        success: function (data) {

        }
    })
}
