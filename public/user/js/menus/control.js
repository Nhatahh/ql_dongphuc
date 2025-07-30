$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#formactive").hide();
    loadMenuAjax()
    loadComboxMenu(-1,'parent_id')
    alert("Đã xong")
})


function loadComboxMenu(value,pos){
    $.ajax({
        type: "post",
        url: "/admin/menus/loadComboxMenu",
    })
    .done(function(res){
        var selected = "";
        var html = '<option value="0">Chức năng gốc</option>';
        for (let index = 0; index < res.length; index++) {
            res[index].id == value ?  selected = "selected='selected'" : selected = ""
            html += '<option '+selected+' value = "'+res[index].id+'">'+res[index].name+'</option>';
        }
        $("#"+pos).html(html);
    })
}

function loadMenuAjax(){
    var table =  $('#loadMenu').DataTable({
    ajax: "/admin/menus/loadMenu",
    columns: [
        {title: "ID",               data: 'id'},
        {title: "Tên chức năng",    data: 'name'},
        {title: "Đường dẫn",        data: 'link'},
        {title: "Chức năng chính",  data: 'content'},
        {title: "Thứ tự",           data: 'number'},
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
                    $html = $html + '<a class="clickdestroy" onclick = loadRowMenu('+data+')>'
                        $html = $html + '<i class="fa fa-edit"></i>'
                    $html = $html + '</a>'
                    $html = $html + '<a class="clickdestroy" onclick = removemenu('+data+')>'
                        $html = $html + '<i class="fa fa-trash"></i>'
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

$('#addMenu').on('click', function(){
    $.ajax({
    type: "post",
    url: '/admin/menus',
    // dataType:"json",
    data:{
        name: $('#name').val(),
        content: $('#content').val(),
        parent_id: $('#parent_id').val(),
        link: $('#link').val(),
        active: $('#active').prop('checked'),
        number: $('#number').val(),
    }
})
.done(function(data){
    if(data == 1){
        toastr.success('Thêm thành công');
        $('#collapsed').addClass('collapsed-card');
        $('#display').css('display', 'none');
        $('#fas').removeClass('fa-minus');
        $('#fas').addClass('fa-plus');
        $("#addForm").trigger("reset");
        loadMenuAjax()
        loadComboxMenu(-1,'parent_id')
        loadsidebar()
    }else{
        if(data == 0){
                toastr.error('Thêm chức năng thất bại');
        }else{
            var dem = 0;
            var dom = document.getElementsByClassName("validate");
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
})
});


function loadRowMenu(id){
    $("#formactive").show('fast');
    $.ajax({
        type: "post",
        url: "menus/load/"+id,
        success: function (res) {
            if(res){
                $("#e_name").val(res[0].name)
                $("#e_link").val(res[0].link)
                $("#e_number").val(res[0].number)
                $("#e_content").val(res[0].content)
                $("#editMenu").attr('data-id',res[0].id)
                $("#clearEditMenu").attr('data-id',res[0].id)
                if(res[0].active == 1){
                    $("#e_active").prop('checked',true)
                }else{
                    $("#e_active").prop('checked',false)
                }
                loadComboxMenu(res[0].parent_id,'e_parent_id')
            }
            else
            {
                $("#editForm").trigger("reset");
                toastr.error("Hiện tại không tải được dữ liệu, vui lòng liên hệ admin")
            }
        }
    });
}

    $('#clearEditMenu').on('click', function(){
        loadRowMenu($(this).attr('data-id'))
    })

    $('#destroyEditMenu').on('click', function(){
        $("#formactive").hide('fast');
        $("#editForm").trigger("reset");
    })

    $('#editMenu').on('click', function(){
        $.ajax({
        type: "post",
        url: '/admin/menus/edit',
        // dataType:"json",
        data:{
            name: $('#e_name').val(),
            content: $('#e_content').val(),
            parent_id: $('#e_parent_id').val(),
            link: $('#e_link').val(),
            active: $('#e_active').prop('checked'),
            number: $('#e_number').val(),
            id: $(this).attr('data-id')
        }
    })
    .done(function(data){
        if(data == 1){
            toastr.success('Cập nhật thành công');
            loadMenuAjax()
            loadsidebar()
            $("#formactive").hide('fast');
            $("#editForm").trigger("reset");
        }else{
            if(data == 0){
                toastr.error('Cập nhật thất bại');
                $("#formactive").hide('fast');
                loadMenuAjax()
                loadsidebar()
            }else{
                var dem = 0;
                var dom = document.getElementsByClassName("validate");
                var keys = Object.keys(data)
                for(let i=0;i<dom.length;i++){
                    for(let j=0;j<keys.length;j++){
                        if($(dom[i]).attr('name') == "e_"+keys[j])
                        {
                            $('#v_e_'+keys[j]).text(data[keys[j]])
                            dem++;
                        }
                    }
                    if(dem == 0){
                        $('#v_e_'+$(dom[i]).attr('name')).text("")
                    }
                    dem = 0;
                }
            }
        }
    })
    });

    function removemenu(id){
        if(confirm("Bạn có chắc chắn xóa chức năng")){
            $.ajax({
                type: "post",
                url: "menus/destroy/"+id,
                success: function (res) {
                if(res == true){
                    toastr.success('Xóa thành công');
                    loadMenuAjax()
                    loadsidebar()
                    $("#formactive").hide('fast');
                    $("#editForm").trigger("reset");
                }else{
                    toastr.error('Không được xóa danh mục có các danh mục con!');
                }
            }
        });
    }
}
