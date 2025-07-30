$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadprovince()
    loadprovince2().ajax.url("/admin/province/list_province2/0").load();
    loadprovince3().ajax.url("/admin/province/list_province3/0").load();
})


function loadprovince(){
    var tableData =  $('#list_province').DataTable({
    ajax: "/admin/province/list_province",
    columns: [
        {
            title: "#",
            data: 'stt'
        },
        {
            title: "ID",
            data: 'id'
        },
        {
            title: "Mã Tỉnh",
            data: 'id_province',
            render: function(data){
                var data = data.split("xxx")
                if(data[1] == 0){
                    return '<input id = "id_province_save" style = "width: 100%; height: 100%; border: none; background-color: inherit;text-align:center">'
                }else{
                    return "<input readonly class = 'reset_id_province' onchange = change_id_province("+data[1]+") id = 'edit_id_province"+data[1]+"' style = 'width: 100%; height: 100%; border: none; background-color: inherit;text-align:center' value = '"+data[0]+"' old = '"+data[0]+"'>"
                }
            }
        },
        {
            title: "Tên Tỉnh",
            data: 'name_province',
            render: function(data){
                var data = data.split("xxx")
                if(data[1] == 0){
                    return '<input id = "name_province_save" style = "width: 100%; height: 100%; border: none; background-color: inherit">'
                }else{
                    return "<input readonly class = 'select reset_name_province' onchange = 'change_name_province("+data[1]+")' id = 'edit_name_province"+data[1]+"' style = 'width: 100%; height: 100%; border: none; background-color: inherit' onclick = load_province2("+data[1]+") value = '"+data[0]+"'>"
                }
            }
        },
        {
            title: "Trạng thái",
            data: 'active_province',
            render: function(data){
                var data = data.split("xxx")
                var checked = ""
                if(data[0] == 1){
                    checked = 'checked';
                }else{
                    checked = "";
                }
                return  '<input class = "reset_active" onchange = change_active_province('+data[1]+') id = "edit_active_province'+data[1]+'" type="checkbox"  style = "height:14px" '+checked +' onclick="return false">'

                // data == 1 ? checked = '<small class="badge badge-primary">Đang sử dụng</small>' :checked =  '<small class="badge badge-warning">Ngưng sử dụng</small>';
                // return  checked;
            },
        },
        {
            title: "Thao tác",
            data: 'end',
            render: function(data){
                var data = data.split("_")
                $html = "";
                if(data[0] == 0){
                    $html = $html +'<div style ="text-align: center;width:100%;">'
                        $html = $html + '<a onclick = "edit_province('+data[1]+')">'
                            $html = $html + '<i id = "edit_province'+data[1]+'" style="color:#007bff" class="fa-solid fa-user-pen reset_edit_province"></i>&nbsp;&nbsp;'
                        $html = $html + '</a>'
                        $html = $html + '<a onclick = "remove_province('+data[1]+')">'
                            $html = $html + '<i style="color:red" class="fa-regular fa-trash-can"></i>'
                        $html = $html + '</a>'
                    $html = $html + '</div>'
                }else{
                    $html = $html +'<div style ="text-align: center;width:100%">'
                        $html = $html + '<a onclick = "province_save()">'
                            $html = $html + '<i style="color:red" class="fa fa-floppy-disk"></i>&nbsp;&nbsp;'
                        $html = $html + '</a>'
                        $html = $html + '<a onclick = "province_fresh()">'
                            $html = $html + '<i style="color:#007bff" class="fa-solid fa-rotate"></i>'
                        $html = $html + '</a>'
                    $html = $html + '</div>'
                }
                return $html;
            },
        },
    ],
    "dom": 'pfrtil',
    scrollY: 480,
    "language": {
        "emptyTable": "Không tìm thấy Tỉnh/Thành phố",
        "info": " _START_ / _END_ trên _TOTAL_ Tỉnh/Thành phố",
        "paginate": {
            "first":      "Trang đầu",
            "last":       "Trang cuối",
            "next":       "Trang sau",
            "previous":   "Trang trước"
        },
        "search":         "Tìm kiếm:",
        "loadingRecords": "Đang tìm kiếm ... ",
        "lengthMenu":     "Hiện thị _MENU_",
        "infoEmpty":      "",
        },
    'columnDefs': [
        {
            "targets": 0,
            "className": "text-center",
        },
        {
            "targets": 1,
            "className": "text-center",
            'visible': false,
            'searchable': false
        },

        {
            "targets": 2,
            "className": "text-center",
        },
        // {
        //     "targets": 3,
        //     "className": "text-center",
        // },
        {
            "targets": 4,
            "className": "text-center",
        },
    ],
    // "fixedColumns": true,
    "retrieve": true,
    "paging": false,
    "lengthChange": false,
    "searching": true,
    "ordering": false,
    "info": false,
    "autoWidth": false,
    "responsive": true,
    });
    return tableData;
    // tableData.ajax.reload()
}

function loadprovince2(id){
    var tableData2 =  $('#list_province2').DataTable({
    ajax: "/admin/province/list_province2"+id,
    columns: [
        {title: "#",            data: 'stt'},
        {
            title: "ID",
            data: 'id'
        },
        {
            title: "Mã Quận/Huyện",
            data: 'id_province2',
            render: function(data){
                var data = data.split("xxx")
                if(data[1] == 0){
                    return '<input id = "id_province2_save" style = "width: 100%; height: 100%; border: none; background-color: inherit;text-align:center">'
                }else{
                    return "<input readonly class = 'select2 reset_id_province' onchange = change_id_province2("+data[1]+","+data[2]+") id = 'edit_id_province2"+data[1]+"' style = 'width: 100%; height: 100%; border: none; background-color: inherit;text-align:center' value = '"+data[0]+"' old = '"+data[0]+"'>"
                }
            }
        },
        {
            title: "Tên Huyện/Quận",
            data: 'name_province2',
            render: function(data){
                var data = data.split("xxx")
                if(data[1] == 0){
                    return '<input id = "name_province2_save" style = "width: 100%; height: 100%; border: none; background-color: inherit">'
                }else{
                    return "<input readonly   class = 'reset_name_province' onchange = 'change_name_province2("+data[1]+","+data[2]+")' id = 'edit_name_province2"+data[1]+"' style = 'width: 100%; height: 100%; border: none; background-color: inherit' onclick = 'load_province3("+data[1]+")'  value = '"+data[0]+"'>"
                }
            }
        },
        {
            title: "Hiện thị",
            data: 'active_province2',
            render: function(data){
                var data = data.split("xxx")
                var checked = ""
                if(data[0] == 1){
                    checked = 'checked';
                }else{
                    checked = "";
                }
                return  '<input class = "reset_active" onchange = change_active_province2('+data[1]+','+data[2]+') id = "edit_active_province2'+data[1]+'" type="checkbox"  style = "height:14px" '+checked +' onclick="return false">'
            },
        },
        {
            title: "Thao tác",
            data: 'end',
            render: function(data){
                var data = data.split("_")
                $html = "";
                if(data[0] == 0){
                    $html = $html +'<div style ="text-align: center;width:100%;">'
                        $html = $html + '<a onclick = "edit_province2('+data[1]+','+data[2]+')">'
                            $html = $html + '<i id = "edit_province2'+data[1]+'" style="color:#007bff" class="fa-solid fa-user-pen"></i>&nbsp;&nbsp;'
                        $html = $html + '</a>'
                        $html = $html + '<a onclick = "remove_province2('+data[1]+','+data[2]+')">'
                            $html = $html + '<i style="color:red" class="fa-regular fa-trash-can"></i>'
                        $html = $html + '</a>'
                    $html = $html + '</div>'
                }else{
                    $html = $html +'<div style ="text-align: center;width:100%">'
                        $html = $html + '<a onclick = "province2_save('+data[1]+')">'
                            $html = $html + '<i style="color:red" class="fa fa-floppy-disk"></i>&nbsp;&nbsp;'
                        $html = $html + '</a>'
                        $html = $html + '<a onclick = "province2_fresh()">'
                            $html = $html + '<i style="color:#007bff" class="fa-solid fa-rotate"></i>'
                        $html = $html + '</a>'
                    $html = $html + '</div>'
                }
                return $html;
            },
        },

    ],
    "dom": 'pfrtil',
    scrollY: 480,
    "language": {
        "emptyTable": "Không tìm thấy Quận/Huyện",
        "info": " _START_ / _END_ trên _TOTAL_Quận/Huyện",
        "paginate": {
            "first":      "Trang đầu",
            "last":       "Trang cuối",
            "next":       "Trang sau",
            "previous":   "Trang trước"
        },
        "search":         "Tìm kiếm:",
        "loadingRecords": "Đang tìm kiếm ... ",
        "lengthMenu":     "Hiện thị _MENU_",
        "infoEmpty":      "",
        },
    'columnDefs': [
        {
            "targets": 0,
            "className": "text-center",

        },
        {
            "targets": 1,
            "className": "text-center",
            'visible': false,
            'searchable': false
        },
        {
            "targets": 2,
            "className": "text-center",

        },
        {
            "targets": 4,
            "className": "text-center",
        },
    ],
    // "fixedColumns": true,
    "autoWidth": false,
    "retrieve": true,
    "paging": false,
    "lengthChange": false,
    "searching": true,
    "ordering": false,
    "info": false,
    "autoWidth": false,
    "responsive": true,
    });
    return tableData2;
    // tableData.ajax.reload()
}
function loadprovince3(id){
    var tableData3 =  $('#list_province3').DataTable({
    ajax: "/admin/province/list_province3/"+id,
    columns: [
        {title: "#",            data: 'stt'},
        {
            title: "ID",
            data: 'id'
        },
        {
            title: "Mã Xã/Phường",
            data: 'id_province3',
            render: function(data){
                var data = data.split("xxx")
                if(data[1] == 0){
                    return '<input id = "id_province3_save" style = "width: 100%; height: 100%; border: none; background-color: inherit;text-align:center">'
                }else{
                    return "<input readonly class = 'select3 reset_id_province' onchange = change_id_province3("+data[1]+","+data[2]+") id = 'edit_id_province3"+data[1]+"' style = 'width: 100%; height: 100%; border: none; background-color: inherit;text-align:center' value = '"+data[0]+"' old = '"+data[0]+"'>"
                }
            }

        },
        {
            title: "Tên Xã/Phường",
            data: 'name_province3',
            render: function(data){
                var data = data.split("xxx")
                if(data[1] == 0){
                    return '<input id = "name_province3_save" style = "width: 100%; height: 100%; border: none; background-color: inherit">'
                }else{
                    return "<input readonly class = 'reset_name_province' onchange = 'change_name_province3("+data[1]+","+data[2]+")' id = 'edit_name_province3"+data[1]+"' style = 'width: 100%; height: 100%; border: none; background-color: inherit' value = '"+data[0]+"' old = '"+data[0]+"'>"
                }
            }
        },
        {
            title: "Hiện thị",
            data: 'active_province3',
            render: function(data){
                var data = data.split("xxx")
                var checked = ""
                if(data[0] == 1){
                    checked = 'checked';
                }else{
                    checked = "";
                }
                return  '<input class = "reset_active" onchange = change_active_province3('+data[1]+','+data[2]+') id = "edit_active_province3'+data[1]+'" type="checkbox"  style = "height:14px" '+checked +' onclick="return false">'
            },
        },
        {
            title: "Thao tác",
            data: 'end',
            render: function(data){
                var data = data.split("_")
                $html = "";
                if(data[0] == 0){
                    $html = $html +'<div style ="text-align: center;width:100%;">'
                        $html = $html + '<a onclick = "edit_province3('+data[1]+','+data[2]+')">'
                            $html = $html + '<i id = "edit_province3'+data[1]+'" style="color:#007bff" class="fa-solid fa-user-pen"></i>&nbsp;&nbsp;'
                        $html = $html + '</a>'
                        $html = $html + '<a onclick = "remove_province3('+data[1]+','+data[2]+')">'
                            $html = $html + '<i style="color:red" class="fa-regular fa-trash-can"></i>'
                        $html = $html + '</a>'
                    $html = $html + '</div>'
                }else{
                    $html = $html +'<div style ="text-align: center;width:100%">'
                        $html = $html + '<a onclick = "province3_save('+data[1]+')">'
                            $html = $html + '<i style="color:red" class="fa fa-floppy-disk"></i>&nbsp;&nbsp;'
                        $html = $html + '</a>'
                        $html = $html + '<a onclick = "province3_fresh()">'
                            $html = $html + '<i style="color:#007bff" class="fa-solid fa-rotate"></i>'
                        $html = $html + '</a>'
                    $html = $html + '</div>'
                }
                return $html;
            },
        },
    ],
    "dom": 'pfrtil',
    scrollY: 480,
    "language": {
        "emptyTable": "Không tìm thấy Phường/Xã",
        "info": " _START_ / _END_ trên _TOTAL_ Phường/Xã",
        "paginate": {
            "first":      "Trang đầu",
            "last":       "Trang cuối",
            "next":       "Trang sau",
            "previous":   "Trang trước"
        },
        "search":         "Tìm kiếm:",
        "loadingRecords": "Đang tìm kiếm ... ",
        "lengthMenu":     "Hiện thị _MENU_",
        "infoEmpty":      "",
        },
    'columnDefs': [
        {
            "targets": 0,
            "className": "text-center",
        },
        {
            "targets": 1,
            "className": "text-center",
            'visible': false,
            'searchable': false
        },
        {
            "targets": 2,
            "className": "text-center",
        },
        // {
        //     "targets": 3,
        //     "className": "text-center",
        // },
        {
            "targets": 4,
            "className": "text-center",
        },
    ],
    // "fixedColumns": true,
    "retrieve": true,
    "paging": false,
    "lengthChange": false,
    "searching": true,
    "ordering": false,
    "info": false,
    "autoWidth": false,
    "responsive": true,
    });
    return tableData3;
    // tableData.ajax.reload()
}

function load_province2(id){
    $('.select').parent().parent().css('background-color','')
    $('#edit_name_province'+id).parent().parent().css('background-color','#f4fc9c')
    loadprovince3().ajax.url("/admin/province/list_province3/0").load();
    loadprovince2().ajax.url("/admin/province/list_province2/"+id).load();
}
function load_province3(id){
    $('.select2').parent().parent().css('background-color','')
    $('#edit_name_province2'+id).parent().parent().css('background-color','#f4fc9c')
    loadprovince3().ajax.url("/admin/province/list_province3/"+id).load();

}

function remove_province(id){
    if (confirm("Chắc chắn xóa Tỉnh/Thành Phô!") == true) {
        $.ajax({
            type: "post",
            url: '/admin/province/remove_province',
            // dataType:"json",
            data:{
                id: id,
            },
            success: function (data) {
                switch (data) {
                    case '0':
                        toastr.error('Thất bại, có lỗi hệ thống! Vui lòng liên hệ admin');
                        break;
                    case '1':
                        loadprovince().ajax.reload();
                        loadprovince3().ajax.url("/admin/province/list_province3/0").load();
                        loadprovince2().ajax.url("/admin/province/list_province2/0").load();
                        toastr.warning("Xóa Tỉnh/Thành phố thành công")
                        break;
                    case '2':
                        toastr.warning('Tỉnh đã có Huyện! Không xóa được!');
                        break;
                    default:
                        break;
                }
            }
        })
    }
}
function remove_province2(id,id_province){
    if (confirm("Chắc chắn xóa Quận/Huyện") == true) {
        $.ajax({
            type: "post",
            url: '/admin/province/remove_province2',
            // dataType:"json",
            data:{
                id: id,
            },
            success: function (data) {
                switch (data) {
                    case '0':
                        toastr.error('Thất bại, có lỗi hệ thống! Vui lòng liên hệ admin');
                        break;
                    case '1':
                        loadprovince2().ajax.url("/admin/province/list_province2/"+id_province).load();
                        loadprovince3().ajax.url("/admin/province/list_province3/"+id).load();
                        toastr.warning("Xóa Quận/Huyện thành công")
                        break;
                    case '2':
                        toastr.warning('Tỉnh đã có Xã/Phường thực thuộc! Không xóa được!');
                        break;
                    default:
                        break;
                }
            }
        })
    }
}
function remove_province3(id,id_province2){
    if (confirm("Chắc chắn xóa Xã/Phường") == true) {
        $.ajax({
            type: "post",
            url: '/admin/province/remove_province3',
            // dataType:"json",
            data:{
                id: id,
            },
            success: function (data) {
                switch (data) {
                    case '0':
                        toastr.error('Thất bại, có lỗi hệ thống! Vui lòng liên hệ admin');
                        break;
                    case '1':
                        // loadprovince2().ajax.url("/admin/province/list_province2/"+id_province).load();
                        loadprovince3().ajax.url("/admin/province/list_province3/"+id_province2).load();
                        toastr.warning("Xóa Quận/Huyện thành công")
                        break;
                    case '2':
                        toastr.warning('Tỉnh đã có Xã/Phường thực thuộc! Không xóa được!');
                        break;
                    default:
                        break;
                }
            }
        })
    }
}

function edit_province(id){
    $('.select').parent().parent().css('background-color','')
    $('#edit_name_province'+id).parent().parent().css('background-color','#f4fc9c')
    $('#edit_active_province'+id).attr("onclick", "return true");
    $('#edit_province'+id).css("color", '#fd7e14');
    $('#edit_id_province'+id).attr("readonly", false);
    $('#edit_name_province'+id).attr("readonly", false);
}
function edit_province2(id){
    $('.select2').parent().parent().css('background-color','')
    $('#edit_name_province2'+id).parent().parent().css('background-color','#f4fc9c')
    $('#edit_active_province2'+id).attr("onclick", "return true");
    $('#edit_province2'+id).css("color", '#fd7e14');
    $('#edit_id_province2'+id).attr("readonly", false);
    $('#edit_name_province2'+id).attr("readonly", false);
}
function edit_province3(id){
    $('.select3').parent().parent().css('background-color','')
    $('#edit_name_province3'+id).parent().parent().css('background-color','#f4fc9c')
    $('#edit_active_province3'+id).attr("onclick", "return true");
    $('#edit_province3'+id).css("color", '#fd7e14');
    $('#edit_id_province3'+id).attr("readonly", false);
    $('#edit_name_province3'+id).attr("readonly", false);
}


function change_name_province(id){
    var name_province = $('#edit_name_province'+id).val();
    if(name_province == ""){
        toastr.warning("Tên Tỉnh/Thành phố không được Trống")
    }else{
        $.ajax({
            type: "post",
            url: '/admin/province/change_name_province',
            // dataType:"json",
            data:{
                id: id,
                name_province: name_province
            },
            success: function (data) {
                if(data == 1){
                    toastr.success('Cập nhật Tỉnh/Thành phố thành công');
                    $('#edit_name_province'+id).attr("readonly", true);
                    loadprovince().ajax.reload();
                    loadprovince2().ajax.url("/admin/province/list_province2/0").load();
                    loadprovince3().ajax.url("/admin/province/list_province3/0").load();
                }else{
                    if(data == 0){
                        toastr.error('Thất bại, có lỗi hệ thống! Vui lòng liên hệ admin');
                    }else{
                        var keys = Object.keys(data)
                        toastr.error(data[keys[0]]);
                    }
                }
            }
        })
    }
}
function change_name_province2(id,id_province){
    var name_province2 = $('#edit_name_province2'+id).val();
    if(name_province2 == ""){
        toastr.warning("Tên Tỉnh/Thành phố không được Trống")
    }else{
        $.ajax({
            type: "post",
            url: '/admin/province/change_name_province2',
            // dataType:"json",
            data:{
                id: id,
                name_province2: name_province2
            },
            success: function (data) {
                if(data == 1){
                    toastr.success('Cập nhật Tỉnh/Thành phố thành công');
                    $('#edit_name_province2'+id).attr("readonly", true);
                    // loadprovince().ajax.reload();
                    loadprovince2().ajax.url("/admin/province/list_province2/"+id_province).load();
                    loadprovince3().ajax.url("/admin/province/list_province3/0").load();
                }else{
                    if(data == 0){
                        toastr.error('Thất bại, có lỗi hệ thống! Vui lòng liên hệ admin');
                    }else{
                        var keys = Object.keys(data)
                        toastr.error(data[keys[0]]);
                    }
                }
            }
        })
    }
}
function change_name_province3(id,id_province2){
    var name_province3 = $('#edit_name_province3'+id).val();
    if(name_province3 == ""){
        toastr.warning("Tên Xã/Phường không được Trống")
    }else{
        $.ajax({
            type: "post",
            url: '/admin/province/change_name_province3',
            // dataType:"json",
            data:{
                id: id,
                name_province3: name_province3
            },
            success: function (data) {
                if(data == 1){
                    toastr.success('Cập nhật Xã/Phường thành công');
                    $('#edit_name_province3'+id).attr("readonly", true);
                    loadprovince3().ajax.url("/admin/province/list_province3/"+id_province2).load();
                }else{
                    if(data == 0){
                        toastr.error('Thất bại, có lỗi hệ thống! Vui lòng liên hệ admin');
                    }else{
                        var keys = Object.keys(data)
                        toastr.error(data[keys[0]]);
                    }
                }
            }
        })
    }
}

function change_id_province(id){
    var id_province = $('#edit_id_province'+id).val();
    if(id_province != $('#edit_id_province'+id).attr('old')){
        $.ajax({
            type: "post",
            url: '/admin/province/change_id_province',
            // dataType:"json",
            data:{
                id: id,
                id_province: id_province,
            },
            success: function (data) {
                switch (data) {
                    case '0':
                        toastr.error('Thất bại, có lỗi hệ thống! Vui lòng liên hệ admin');
                        break;
                    case '1':
                        toastr.success('Cập nhật Mã Tỉnh/Thành phố thành công');
                        $('#edit_id_province'+id).attr("readonly", true);
                        loadprovince().ajax.reload();
                        loadprovince2().ajax.url("/admin/province/list_province2/0").load();
                        loadprovince3().ajax.url("/admin/province/list_province3/0").load();
                        break;
                    case '2':
                        toastr.warning('Trùng Mã Quận/Huyện');
                        break;
                    default:
                        var keys = Object.keys(data)
                        toastr.error(data[keys[0]]);
                        break;
                }
            }
        })
    }
}
function change_id_province2(id,id_province){
    var id_province2 = $('#edit_id_province2'+id).val();
    if(id_province == ""){
        toastr.warning("Mã Quận/Huyện không được Trống")
    }else{
        if(id_province2 != $('#edit_id_province2'+id).attr('old')){
            $.ajax({
                type: "post",
                url: '/admin/province/change_id_province2',
                // dataType:"json",
                data:{
                    id: id,
                    id_province2: id_province2,
                    id_province: id_province,
                },
                success: function (data) {
                    switch (data) {
                        case '0':
                            toastr.error('Thất bại, có lỗi hệ thống! Vui lòng liên hệ admin');
                            break;
                        case '1':
                            toastr.success('Cập nhật Quận/Huyện thành công');
                            $('#edit_id_province3'+id).attr("readonly", true);
                            loadprovince2().ajax.url("/admin/province/list_province2/"+id_province).load();
                            loadprovince3().ajax.url("/admin/province/list_province0/").load();
                            break;
                        case '2':
                            toastr.warning('Trùng Mã Quận/Huyện');
                            break;
                        default:
                            var keys = Object.keys(data)
                            toastr.error(data[keys[0]]);
                            break;
                    }
                }
            })
        }
    }
}
function change_id_province3(id,id_province2){
    var id_province3 = $('#edit_id_province3'+id).val();
    if(id_province2 == ""){
        toastr.warning("Mã Xã/Phường phố không được Trống")
    }else{
        if(id_province3 != $('#edit_id_province3'+id).attr('old')){
            $.ajax({
                type: "post",
                url: '/admin/province/change_id_province3',
                // dataType:"json",
                data:{
                    id: id,
                    id_province3: id_province3,
                    id_province2: id_province2,
                },
                success: function (data) {
                    switch (data) {
                        case '0':
                            toastr.error('Thất bại, có lỗi hệ thống! Vui lòng liên hệ admin');
                            break;
                        case '1':
                            toastr.success('Cập nhật Mã Xã/Phường thành công');
                            $('#edit_id_province3'+id).attr("readonly", true);
                            loadprovince3().ajax.url("/admin/province/list_province3/"+id_province2).load();
                            break;
                        case '2':
                            toastr.warning('Trùng Mã Xã/Phường');
                            break;
                        default:
                            var keys = Object.keys(data)
                            toastr.error(data[keys[0]]);
                            break;
                    }
                }
            })
        }
    }
}

function change_active_province(id){
    var active_province = $('#edit_active_province'+id).prop('checked');
    $.ajax({
        type: "post",
        url: '/admin/province/change_active_province',
        data:{
            id: id,
            active_province: active_province
        },
        success: function (data) {
            if(data == 1){
                toastr.success('Cập nhật Trạng Tỉnh/Thành phố thành công');
                $('#edit_active_province'+id).attr("onclick", "return false");
                loadprovince().ajax.reload();
                loadprovince2().ajax.url("/admin/province/list_province2/0").load();
                loadprovince3().ajax.url("/admin/province/list_province3/0").load();
            }else{
                if(data == 0){
                    toastr.error('Thất bại, có lỗi hệ thống! Vui lòng liên hệ admin');
                }else{
                    var keys = Object.keys(data)
                    toastr.error(data[keys[0]]);
                }
            }
        }
    })

}
function change_active_province2(id,id_provice){
    var active_province2 = $('#edit_active_province2'+id).prop('checked');
    $.ajax({
        type: "post",
        url: '/admin/province/change_active_province2',
        data:{
            id: id,
            active_province2: active_province2
        },
        success: function (data) {
            if(data == 1){
                toastr.success('Cập nhật Trạng Tỉnh/Thành phố thành công');
                $('#edit_active_province2'+id).attr("onclick", "return false");
                loadprovince2().ajax.url("/admin/province/list_province2/"+id_provice).load();
                loadprovince3().ajax.url("/admin/province/list_province3/0").load();
            }else{
                if(data == 0){
                    toastr.error('Thất bại, có lỗi hệ thống! Vui lòng liên hệ admin');
                }else{
                    var keys = Object.keys(data)
                    toastr.error(data[keys[0]]);
                }
            }
        }
    })
}
function change_active_province3(id,id_provice2){
    var active_province3 = $('#edit_active_province3'+id).prop('checked');
    $.ajax({
        type: "post",
        url: '/admin/province/change_active_province3',
        data:{
            id: id,
            active_province3: active_province3
        },
        success: function (data) {
            if(data == 1){
                toastr.success('Cập nhật Xã/Phường thành công');
                $('#edit_active_province3'+id).attr("onclick", "return false");
                loadprovince3().ajax.url("/admin/province/list_province3/0"+id_provice2).load();
            }else{
                if(data == 0){
                    toastr.error('Thất bại, có lỗi hệ thống! Vui lòng liên hệ admin');
                }else{
                    var keys = Object.keys(data)
                    toastr.error(data[keys[0]]);
                }
            }
        }
    })
}

function province_save(){
    var id_province = $('#id_province_save').val();
    var name_province = $('#name_province_save').val();
    if(id_province == '' || name_province == ""){
        toastr.warning("Điền mã Tỉnh và Tên Tỉnh/Thành phố")
    }else{
        $.ajax({
            type: "post",
            url: '/admin/province/province_save',
            // dataType:"json",
            data:{
                id_province: id_province,
                name_province: name_province,
            },
            success: function (data) {
                if(data == 1){
                    toastr.success('Thêm Tỉnh thành Công');
                    loadprovince().ajax.reload();
                    loadprovince2().ajax.url("/admin/province/list_province2/0").load();
                    loadprovince3().ajax.url("/admin/province/list_province3/0").load();
                }else{
                    if(data == 0){
                        toastr.error('Thất bại, có lỗi hệ thống! Vui lòng liên hệ admin');
                    }else{
                        var keys = Object.keys(data)
                        var html = "";
                        for(let i = 0;i<keys.length;i++){
                            html += data[keys[i]]+", "
                        }
                        var html = html.slice( 0, -2 ) ;
                        toastr.warning(html);
                    }
                }
            }
        })
    }
}
function province2_save(id){
    var id_province2 = $('#id_province2_save').val();
    var name_province2 = $('#name_province2_save').val();
    var id_province = id;
    if(id_province == 0){
        toastr.warning('Chưa Chọn Tỉnh/Thành phố');
    }else{
        if(id_province2 == '' || name_province2 == ""){
            toastr.warning("Điền mã Tỉnh và Tên Tỉnh/Thành phố")
        }else{
            $.ajax({
                type: "post",
                url: '/admin/province/province2_save',
                // dataType:"json",
                data:{
                    id_province2: id_province2,
                    name_province2: name_province2,
                    id_province: id_province,
                },
                success: function (data) {
                    if(data == 1){
                        toastr.success('Thêm Quận/Huyện thành công');
                        loadprovince2().ajax.url("/admin/province/list_province2/0"+id_province).load();
                        loadprovince3().ajax.url("/admin/province/list_province3/0").load();
                    }else{
                        if(data == 0){
                            toastr.error('Thất bại, có lỗi hệ thống! Vui lòng liên hệ admin');
                        }else{
                            if(data == 2){
                                toastr.warning('Trùng Mã Huyện/Quận');
                            }else{
                                var keys = Object.keys(data)
                                var html = "";
                                for(let i = 0;i<keys.length;i++){
                                    html += data[keys[i]]+", "
                                }
                                var html = html.slice( 0, -2 ) ;
                                toastr.warning(html);
                            }
                        }
                    }
                }
            })
        }
    }

}
function province3_save(id){
    var id_province3 = $('#id_province3_save').val();
    var name_province3 = $('#name_province3_save').val();
    var id_province2 = id;
    if(id_province2 == 0){
        toastr.warning('Chưa Chọn Quận/Huyện');
    }else{
        if(id_province3 == '' || name_province3 == ""){
            toastr.warning("Xã/Phường không được trống")
        }else{
            $.ajax({
                type: "post",
                url: '/admin/province/province3_save',
                // dataType:"json",
                data:{
                    id_province3: id_province3,
                    name_province3: name_province3,
                    id_province2: id_province2,
                },
                success: function (data) {
                    alert(data)
                    if(data == 1){
                        toastr.success('Thêm Xã/Phường thành công');
                        loadprovince3().ajax.url("/admin/province/list_province3/"+id_province2).load();
                    }else{
                        if(data == 0){
                            toastr.error('Thất bại, có lỗi hệ thống! Vui lòng liên hệ admin');
                        }else{
                            if(data == 2){
                                toastr.warning('Trùng Mã Huyện/Quận');
                            }else{
                                var keys = Object.keys(data)
                                var html = "";
                                for(let i = 0;i<keys.length;i++){
                                    html += data[keys[i]]+", "
                                }
                                var html = html.slice( 0, -2 ) ;
                                toastr.warning(html);
                            }
                        }
                    }
                }
            })
        }
    }

}

function province_fresh(){
    $('#id_province_save').val('');
    $('#name_province_save').val('');
}
function province2_fresh(){
    $('#id_province2_save').val('');
    $('#name_province2_save').val('');
}
function province3_fresh(){
    $('#id_province3_save').val('');
    $('#name_province3_save').val('');
}
















