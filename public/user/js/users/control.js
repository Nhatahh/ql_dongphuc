$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // alert("Chưa xong");
    $("#formactiveUser").hide();
    $("#formactiveRoles_User").hide();

    loadUsersAjax()
    // loadUser_Menus_Roles(1)
    // loadComboxMenu(-1,'parent_id')
})


// function loadComboxMenu(value,pos){
//     $.ajax({
//         type: "post",
//         url: "/admin/menus/loadComboxMenu",
//     })
//     .done(function(res){
//         var selected = "";
//         var html = '<option value="0">Chức năng gốc</option>';
//         for (let index = 0; index < res.length; index++) {
//             res[index].id == value ?  selected = "selected='selected'" : selected = ""
//             html += '<option '+selected+' value = "'+res[index].id+'">'+res[index].name+'</option>';
//         }
//         $("#"+pos).html(html);
//     })
// }

function loadUsersAjax(){
    var table =  $('#loadUsers').DataTable({
    ajax: "/admin/users/loadUsers",
    columns: [
        {title: "ID",               data: 'id'},
        {title: "Tên người dùng",    data: 'name'},
        {title: "Email",        data: 'email'},
        {title: "Điện thoại",  data: 'phone'},
        {title: "Thứ tự",           data: 'num'},
        {
            title: "Hiện thị",
            data: 'active',
            render: function(data){
                var $html = ""; checked = "";
                data == 1 ? checked = "checked":checked = "";
                return  $html = $html + '<div style = "text-align: center;"><input type="checkbox" '+checked+' disabled = "disabled"></div>'
            },
        },
        {
            title: "Thao tác",
            data: 'id',
            render: function(data){
                $html = "";
                $html = $html +'<div style ="text-align: center;width:100%">'
                    $html = $html + '<a onclick = loadRowUser('+data+')>'
                        $html = $html + '<i class="fa fa-edit"></i>'
                    $html = $html + '</a>'
                    $html = $html + '<a onclick = removeUser('+data+')>'
                        $html = $html + '<i class="fa fa-trash"></i>'
                    $html = $html + '</a>'
                     $html = $html + '<a onclick = roleUser('+data+')>'
                        $html = $html + '<i class="fa fa-key"></i>'
                    $html = $html + '</a>'
                $html = $html + '</div>'
                return $html;
            },
        },
    ],
    "retrieve": true,
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": false,
    "info": true,
    "autoWidth": true,
    "responsive": true,
    });
    table.ajax.reload()
}

$('#addUser').on('click', function(){
    $.ajax({
    type: "post",
    url: '/admin/users',
    // dataType:"json",
    data:{
        name: $('#name_user').val(),
        email: $('#email_user').val(),
        phone: $('#phone_user').val(),
        num: $('#num_user').val(),
        active: $('#active_user').prop('checked'),
    }
})
.done(function(data){
    if(data == 1){
        toastr.success('Thêm thành công');
        $('#collapsed_user').addClass('collapsed-card');
        $('#display_user').css('display', 'none');
        $('#fas_user').removeClass('fa-minus');
        $('#fas_user').addClass('fa-plus');
        $("#addFormUser").trigger("reset");
        $(".error").text("");
        loadUsersAjax()
    }else{
        if(data == 0){
                toastr.error('Thêm người dùng thắt bại');
        }else{
            var dem = 0;
            var dom = document.getElementsByClassName("validate_user");
            var keys = Object.keys(data)
            for(let i=0;i<dom.length;i++){
                for(let j=0;j<keys.length;j++){
                    if($(dom[i]).attr('name') == keys[j]+"_user")
                    {
                        $('#v_'+keys[j]+"_user").text(data[keys[j]])
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
})
});



$('#fas_user').on('click',function(){
    $("#addFormUser").trigger("reset");
    $(".error").text("")
})


function loadRowUser(id){
    $("#User_Roles").text("");
    $("#formactiveRoles_User").hide('fast');
    $("#formactiveUser").show('fast');
    $.ajax({
        type: "post",
        url: "users/load/"+id,
        success: function (res) {
            if(res){
                $("#e_name_user").val(res[0].name)
                $("#e_email_user").val(res[0].email)
                $("#e_num_user").val(res[0].num)
                $("#e_phone_user").val(res[0].phone)
                // $("#e_password_user").val(res[0].password)
                $("#editUser").attr('data-id',res[0].id)
                $("#clearEditUser").attr('data-id',res[0].id)
                $("#destroyEditUser").attr('data-id',res[0].id)

                if(res[0].active == 1){
                    $("#e_active_user").prop('checked',true)
                }else{
                    $("#e_active_user").prop('checked',false)
                }
            }
            else
            {
                $("#editFormUser").trigger("reset");
                toastr.error("Hiện tại không tải được dữ liệu, vui lòng liên hệ admin")
            }
        }
    });
}

    $('#clearEditUser').on('click', function(){
        loadRowUser($(this).attr('data-id'))
        $(".error").text("")
    })

    $('#destroyEditUser').on('click', function(){
        $("#formactiveUser").hide('fast');
        $("#editFormUser").trigger("reset");
    })

    $('#editUser').on('click', function(){

        $.ajax({
        type: "post",
        url: '/admin/users/edit',
        // dataType:"json",
        data:{
            name: $('#e_name_user').val(),
            email: $('#e_email_user').val(),
            phone: $('#e_phone_user').val(),
            num: $('#e_num_user').val(),
            active: $('#e_active_user').prop('checked'),
            password: $('#e_password_user').val(),
            id: $(this).attr('data-id')
        }
    })
    .done(function(data){
        if(data == 1){
            toastr.success('Cập nhật thành công');
            loadUsersAjax()
            $("#formactiveUser").hide('fast');
            $("#editFormUser").trigger("reset");
            $("#editFormRoles_User").trigger("reset");
            $("#User_Roles").text("");
            $("#formactiveRoles_User").hide('fast');
            $(".error").text("");
        }else{
            if(data == 0){
                toastr.error('Cập nhật thất bại');
                $("#formactiveUser").hide('fast');
                loadUsersAjax()

            }else{
                var dem = 0;
                var dom = document.getElementsByClassName("validate_user");
                var keys = Object.keys(data)
                for(let i=0;i<dom.length;i++){
                    for(let j=0;j<keys.length;j++){
                        if($(dom[i]).attr('name') == "e_"+keys[j]+"_user")
                        {
                            $('#v_e_'+keys[j]+"_user").text(data[keys[j]])
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
    })
    });


    function removeUser(id){
        if(confirm("Bạn có chắc chắn xóa chức năng")){
            $.ajax({
                type: "post",
                url: "users/destroy/"+id,
                success: function (res) {
                if(res == true){
                    toastr.success('Xóa thành công');
                    loadUsersAjax()
                    $("#formactiveUser").hide('fast');
                    // $("#editFormUser").trigger("reset");
                }else{
                    toastr.error('Xóa thất bại, vui lòng kiểm tra dữ liệu');
                }
            }
        });
    }
}

function  roleUser(id){
    $("#editFormUser").trigger("reset");
    $("#formactiveUser").hide('fast');
    $.ajax({
        type: "post",
        url: "users/loadNameUser/"+id,
        success: function (res) {
            $('#User_Roles').text("Chức năng cho: "+res[0].name)
            $("#formactiveRoles_User").show('fast');
            loadUser_Menus_Roles(id)
        }
    })
}


function loadUser_Menus_Roles(id){
    var link = "users/loadUser_Menus_Roles/"+id
    var table =  $('#loadUser_Menus_Roles').DataTable({
    ajax: link,
    columns: [
        {title: "ID",               data: 'id'},
        {title: "Tên chức năng",    data: 'name'},
        {
            title: "Trạng thái",
            data: 'trangthai',
            render: function(data){
                var trangthai = data.split("_");
                var checked = "";
                var html = "";
                if(trangthai[0] == 1){
                    checked = 'checked';
                }else{
                    checked = "";
                }
                trangthai[1] == 0 ? disabled = 'disabled' : disabled = '';
                var idmenu = Number(trangthai[2])
                var idrole = Number(trangthai[3])
                var iduser= Number(trangthai[4])
                var parent= Number(trangthai[5])
                // return  data.split("_")[0];
                // var disabled;
                // data.substr(2) == "0" ? disabled = 'disabled = "disabled"' :disabled = '';
                //  v ar$html = "";
                // var $html = ""; checked = "";
                // data == 1 ? checked = "checked": checked = "";
                return  html = html + '<div style = "text-align: center;"><input type="checkbox"  id ="role'+idmenu+'"class = "checkrole" onclick = roles('+idmenu+','+idrole+','+iduser+','+parent+') '+checked +' '+disabled+'></div>'
            },
        },
    ],
    "retrieve": true,
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": false,
    "info": true,
    "autoWidth": true,
    "responsive": true,
    });
    table.ajax.url(link).load();
}



function roles(idmenu,idrole,iduser,parent){
    var check = 0;
    $('#role'+idmenu).prop('checked') == false ? check = 0 : check = 1;
    $.ajax({
        type: "post",
        url: "users/updateRole/"+idmenu+'/'+idrole+'/'+iduser+'/'+check+'/'+parent,
        success: function (res) {
            alert(res)
            if(res == 1){
                toastr.success("Cập nhật chức năng người dùng thành công")
            }
            loadUser_Menus_Roles(iduser)
        }
    })
}


$('#fas_user_role').on('click',function () {
    $("#formactiveRoles_User").hide('fast');
 })


