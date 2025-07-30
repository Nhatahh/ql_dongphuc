$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    var emailValue = localStorage.getItem('email')
    var passValue = localStorage.getItem('password')
    if(emailValue !== null && passValue !== null){
        $('#email_admin').val(emailValue)
        $('#password_admin').val(passValue)
    }else{
        $('#email_admin').val('')
        $('#password_admin').val('')
    }
});
function login(){
    var remember_Check = $('#remember_account').prop('checked') ? 1 : 0;
    $.ajax({
        type: "get",
        url: "/dangnhap_admin",
        data: {
           email : $('#email_admin').val(),
           password : $('#password_admin').val(),
           remember_Check: remember_Check
        },
        success: function (res) {
            document.querySelectorAll('.validate_loginadmin').forEach(element => {
                element.innerText = ''; // Đặt văn bản của mỗi phần tử thành chuỗi rỗng
            });
            $('#error_login').text('')
            switch (res.trangthai) {
                case 1:
                    // window.location.href = "https://xettuyentest.ctuet.edu.vn/admin24/main";
                    window.location.href = "/admin24/main";
                    if(res.remember == 1){
                        localStorage.clear()
                        localStorage.setItem('email', res.email);
                        localStorage.setItem('password', res.password);
                    }
                  break;
                case 0:
                    $('#error_login').text('Đăng nhập không thành công vui kiểm tra lại thông tin')
                  break;
                default:
                    var keys = Object.keys(res)
                    keys.forEach(element => {
                        $('#error_'+element).text(res[element])
                    });
              }
        }
    });
}
