$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});

function Userlogin(){
    $('#v_email_login').text('');
    $('#v_phone_login').text('');
    $('#v_cmnd_login').text('');
    $('#v_password_login').text('');
    $('#info_login').text('');
    $.ajax({
        type: "post",
        url: "/login/store",
        data:{
            // email_login: $('#email_login').val(),
            // phone_login: $('#phone_login').val(),
            cmnd_login: $('#cmnd_login').val(),
            ngaysinh: $('#ngaysinh').val(),

        },
        success: function (data) {
            if(data == 1){
                window.location.href = "/thongtincanhan";
                // window.location.href = "https://xettuyentest.ctuet.edu.vn/thongtincanhan";
            }else{
                if(data == 2){
                    $('#info_login').text('Hiện tại, chưa có đợt xét tuyển');
                }else{
                    if(data == 0){
                        $('#info_login').text('Thông tin đăng nhập không khớp với dữ liệu từ Bộ GD&ĐT');
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

















// function login() {
//     var email = $("#email_login").val();
//     var pass = $("#password_login").val();
//     $("#thongbaomk").empty();
//     $("#thongbaoemail").empty();
//     $.ajax({
//         type: "post",
//         url: "dangnhap",
//         data: {
//             email: email,
//             pass: pass,
//         },
//         success: function (res) {
//             if (res == 1) {
//                 window.location.href = "http://congmotcua.ctuet.edu.vn:8080/";
//             } else {
//                 toastr.warning("Đăng nhập không thành công");

//                 //
//                 if (res.pass) {
//                     $("#thongbaomk").text(res.pass[0]);
//                     if (res.email) {
//                         $("#thongbaoemail").text(res.email[0]);
//                     }
//                 } else if (res.email) {
//                     $("#thongbaoemail").text(res.email[0]);
//                     if (res.pass) {
//                         $("#thongbaomk").text(res.pass[0]);
//                     }
//                 } else {
//                     $("#thongbaomk").text(res.pass[0]);
//                     $("#thongbaoemail").text(res.email[0]);
//                 }
//             }
//         },
//     });
// }

// function loginbygoogle() {
//     $.ajax({
//         type: "get",
//         url: "auth/google",
//         success: function (res) {},
//     });
// }
