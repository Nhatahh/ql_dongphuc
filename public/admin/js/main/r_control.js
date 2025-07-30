
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
    loadsidebar()
    loadUser()
})

function loadsidebar(){
    $.ajax({
        type: "get",
        url: "/admin/menus/sidebar",
        success: function (res) {
            $('#sidebar').html(res)
        }
    });
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
        url: "/admin/menus/loadpage/"+id,
        success: function (res) {
            $('#loadpage').load(res[0].link)
        }
    });
}

function titleMenu(id){
    $.ajax({
        type: "post",
        url: "/admin/menus/loadpage/"+id,
        success: function (resid) {
            var name = resid[0].name;
            $.ajax({
                type: "post",
                url: "/admin/menus/loadpage/"+resid[0].parent_id,
                success: function (res_parent) {
                    $('#level1').text(res_parent[0].name)
                    $('#level2').text(name)
                    $('#titleMenu').text(name)
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

function userChangePass_load_admin(){
    $('#level2').text($('#doimatkhau_admin').text())
    $('#level1').text('Tài khoản')
    // $('#titleMenu').text('1111111111111111111111')
    $('#loadpage').load('/admin/changepass_admin');
}


function userLogout_admin(){
    $.ajax({
        type: "post",
        url: "/admin/logout_admin",
    });
}

