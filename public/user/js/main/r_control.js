
$(document).ready(function(){
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    loadsidebar()
    loadUser()
    loaduser_Img()
    $('#loadpageuser').load('/instruct')
    $('#user_level1').text('Hướng dẫn - Thông báo')
    $('#user_level2').text('Hướng dẫn đăng ký')
})


function loadsidebar(){
    $.ajax({
        type: "get",
        url: "/sidebar",
        success: function (res) {
            $('#user_sidebar').html(res)
        }
    });
}


function userLogout(){
    $.ajax({
        type: "post",
        url: "/logout",
    });
}

function userChangePass_load(){
    $('#user_level2').text($('#doimatkhau').text())
    $('#user_level1').text('Tài khoản')
    $('#titleMenu').text('1111111111111111111111')
    $('#loadpageuser').load('/changepass');
}


$('.fa-bars').on('click',function(){
    $('.main-sidebar').show('fast');
})



function loadpage(id){
    load(id)
    titleMenu(id)
    var  x = screen.width;
    if(x < 988){
        $('.main-sidebar').hide('fast');
    }else{
        $('.main-sidebar').show('fast');
    }
}

function load(id){
    $.ajax({
        type: "post",
        url: "/loadpage/"+id,
        success: function (res) {
            $('#loadpageuser').load(res[0].link)
        }
    });
}

function titleMenu(id){
    $.ajax({
        type: "post",
        url: "/loadpage/"+id,
        success: function (resid) {
            var name = resid[0].name;
            $.ajax({
                type: "post",
                url: "/loadpage/"+resid[0].parent_id,
                success: function (res_parent) {
                    $('#user_level1').text(res_parent[0].name)
                    $('#user_level2').text(name)
                }
            });
        }
    });
}


function loadUser(){
    $.ajax({
        type: "post",
        url: "/admin/navar",
        success: function (res) {
            $('#nameUser').text(res.email)
        }
    });
}

function loaduser_Img(){
    $.ajax({
        type: "get",
        url: "/loaduser_Img",
        dataType: 'json',
        success: function (response) {
            $('#loaduser_Img').attr('src',response[0].link_img_user)
        }
    });
}
