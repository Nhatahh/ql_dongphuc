$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#parent_id").select2();
    $("#e_parent_id").select2();
    fresh()

    $('#clearEditMenu').on('click', function(){
        loadRowMenu($(this).attr('data-id'))
    })

    $('#destroyEditMenu').on('click', function(){
        $("#formactive").hide('fast');
        $("#editForm").trigger("reset");
        fresh()
        loadsidebar()
    })


    $('#editMenu').on('click', function(){
        $.ajax({
        type: "post",
        url: '/admin/menus/edit',
        data:{
            name: $('#e_name').val(),
            content: $('#e_content').val(),
            parent_id: $('#e_parent_id').val(),
            link: $('#e_link').val(),
            icon: $('#e_icon').val(),
            active: $('#e_active').prop('checked'),
            number: $('#e_number').val(),
            id: $(this).attr('data-id')
        }
    })
    .done(function(data){
        if(data == 1){
            toastr.success('Cập nhật thành công');
            $("#editForm").trigger("reset");
            loadComboxMenu()
        }else{
            if(data == 0){
                toastr.error('Cập nhật thất bại');
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

})

function reload_all(){
    $('#formactive').hide();
    fresh();
    loadsidebar();
    $("#editForm").trigger("reset");
}

$(document).keydown(function(event) {
    if (event.keyCode == 27) {
        reload_all();
    }
});

function modal_close_menu(){
    reload_all();
}
function fresh(){
    loadMenuAjax()
    loadComboxMenu(-1,'parent_id')
    $('.menus').val('')
    // loadsidebar()
}


function addMenu(){
    $.ajax({
        type: "post",
        url: '/admin/menus/add',
        // dataType:"json",
        data:{
            name: $('#name').val(),
            content: $('#content').val(),
            parent_id: $('#parent_id').val(),
            link: $('#link').val(),
            active: $('#active').prop('checked'),
            fa_icon:  $('#fa_icon').val(),
            number: $('#number').val(),
        }
    })
    .done(function(data){
        if(data == 1){
            toastr.success('Thêm thành công');
            fresh()
            loadsidebar()
        }else{
            if(data == 0){
                toastr.warning('Thất bại, có lỗi hệ thống! Vui lòng liên hệ admin');
            }else{
                var keys = Object.keys(data)
                var html = "";
                for(let i = 0;i<keys.length;i++){
                    html += data[keys[i]]+", "
                }
                var html = html.slice( 0, -2 ) ;
                toastr.error(html);
            }
        }
    })
}

function freshMenu(){
    fresh();
    loadsidebar()
}

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
    $("#remove_loadMenu").empty()
    $("#remove_loadMenu").append('<table class="table table-bordered table-hover table-striped" style = "width: 100%" id = "loadMenu">')
    var table =  $('#loadMenu').DataTable({
    ajax: "/admin/menus/loadMenu",
    columns: [
        // {title: "STT",               data: 'stt'},
        {
            title: "Tên chức năng",
            data: 'name',
        },
        {title: "Đường dẫn",        data: 'link'},
        {title: "Mô tả chức năng",  data: 'content'},
        // {title: "Thứ tự",           data: 'number'},
        {
            title: "Tình trạng",
            data: 'active',
            render: function(data){
                var checked = ""
                data == 1 ? checked = '<small class="badge badge-primary">Đang sử dụng</small>' :checked =  '<small class="badge badge-warning">Ngưng sử dụng</small>';
                return  checked;
            },
        },
        {
            title: "Thao tác",
            data: 'id',
            render: function(data){
                $html = "";
                $html = $html +'<div style ="text-align: center;width:100%">'
                    $html = $html + '<a class="clickdestroy" onclick = loadRowMenu('+data+')>'
                        $html = $html + '<i class="fa-solid fa-user-pen"></i>'
                    $html = $html + '</a>&nbsp;&nbsp;'
                    $html = $html + '<a class="clickdestroy" onclick = removemenu('+data+')>'
                        $html = $html + '<i style="color:red" class="fa-regular fa-trash-can"></i>'
                    $html = $html + '</a>'
                $html = $html + '</div>'
                return $html;
            },
        },
    ],

    scrollY: 480,
    "language": {
        "emptyTable": "Không tìm thấy chức năng",
        "info": " _START_ / _END_ trên _TOTAL_ chức năng",
        "paginate": {
            "first":      "Trang đầu",
            "last":       "Trang cuối",
            "next":       "Trang sau",
            "previous":   "Trang trước"
        },
        "search":         "Tìm kiếm:",
        "loadingRecords": "Đang tìm kiếm ... ",
        "lengthMenu":     "Hiện thị _MENU_ chức năng",
        "infoEmpty":      "",
        },
    'columnDefs': [
        {
            "targets": 0,
            "className": "text-left",
        },
        {
            "targets": 3,
            "className": "text-center",
        },
        {
            "targets": 4,
            "className": "text-center",
        },
        // {
        //     "targets": 5,
        //     "className": "text-center",
        // }
    ],
    // "fixedColumns": true,
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

function loadRowMenu(id){
    $("#formactive").show();
    $.ajax({
        type: "post",
        url: "menus/load/"+id,
        success: function (res) {
            if(res){
                $("#e_name").val(res[0].name)
                $("#e_link").val(res[0].link)
                $("#e_number").val(res[0].number)
                $("#e_icon").val(res[0].icon)
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

function removemenu(id){
    if(confirm("Bạn có chắc chắn xóa chức năng")){
        $.ajax({
            type: "post",
            url: "menus/destroy/"+id,
            success: function (res) {
                switch (res) {
                    case '1':
                        toastr.success('Xóa thành công');
                        break;
                    case '2':
                        toastr.warning('Không được xóa danh mục có các danh mục con!');
                        break;
                    case '3':
                        toastr.warning('Không có chức năng');
                        break;
                    default:
                        toastr.error('Thất bại, có lỗi hệ thống! Vui lòng liên hệ admin');
                        break;
                }
                fresh();
                loadsidebar()
            }
        });
    }
}
