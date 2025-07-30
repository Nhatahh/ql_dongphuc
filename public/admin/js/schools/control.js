$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    load_province_schools()

})

function load_province_schools(){
    var tableData =  $('#load_province_shools').DataTable({
    ajax: "/admin/schools/load_province_shools",
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
        },
        {
            title: "Tên Tỉnh",
            data: 'name_province',
            render: function(data){
                var data = data.split("xxx")
                return "<span class = 'select reset_name_province' id = 'change_load_province_schools"+data[1]+"' style = 'width: 100%; height: 100%; border: none; background-color: inherit' onclick = change_load_province_schools("+data[1]+")>"+data[0]+"</span>"
            },
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
                return  '<input class = "reset_active"  type="checkbox"  style = "height:14px" '+checked +'>'

                // data == 1 ? checked = '<small class="badge badge-primary">Đang sử dụng</small>' :checked =  '<small class="badge badge-warning">Ngưng sử dụng</small>';
                // return  checked;
            },
        },
    ],
    "dom": 'pfrtil',
    scrollY: 480,
    "select": {
        'style': 'os',
        'blurable': true
    },
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
            "className": "left-center",
        },
        {
            "targets": 1,
            "className": "text-center",
            'visible': false,
            // 'searchable': false
        },

        {
            "targets": 2,
            "className": "text-center",
        },
        {
            "targets": 3,
            "className": "text-center",
        },
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


function load_chools(id){
    var tableData =  $('#load_shools').DataTable({
    ajax: "/admin/schools/load_shools/"+id,
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
            title: "Mã Trường",
            data: 'id_school',
        },
        {
            title: "Tên Trường THPT",
            data: 'name_school',
            render: function(data){
                var data = data.split("xxx")
                if(data[1] == 0 && data[0] == 0){
                    return "<input id = 'edit_name_school"+data[2]+"' style = 'width: 100%; height: 100%; border: none; background-color: inherit'>"
                }else{
                    return "<input class = 'select reset_name_province' id = 'edit_name_school"+data[2]+"' style = 'width: 100%; height: 100%; border: none; background-color: inherit' onclick = edit_school("+data[2]+") value = '"+data[0]+"'>"
                }
            },
        },
        {
            title: "Khu vực",
            data: 'priority_area',
            render: function(data){
                if(data.id == 0){
                    var html = "<select id = 'edit_area_school"+data.id+"' style = 'width: 100%; height: 100%; border: none; background-color: inherit'>"
                    for (let i = 0; i < data.option.length; i++) {
                        html += "<option "+data.option[i].selected+" value = '"+data.option[i].id+"'>"+data.option[i].id_priority_area+"</option>"
                    }
                }else{
                    var html = "<select id = 'edit_area_school"+data.id+"' onchange = 'edit_area_school("+data.id+","+data.id_province+")' style = 'width: 100%; height: 100%; border: none; background-color: inherit'>"
                    for (let i = 0; i < data.option.length; i++) {
                        html += "<option "+data.option[i].selected+" value = '"+data.option[i].id+"'>"+data.option[i].id_priority_area+"</option>"
                    }
                }
                return html;
            }
        },

        {
            title: "Trạng thái",
            data: 'active_school',
            render: function(data){
                var data = data.split("xxx")
                var checked = ""
                if(data[0] == 1){
                    checked = 'checked';
                }else{
                    checked = "";
                }
                return  '<input type="checkbox"  style = "height:14px" '+checked +' onclick="return false">'
            }
        },
        {
            title: "Ghi chú",
            data: 'note_school',
            render: function(data){
                var data = data.split("xxx")
                if(data[1] == 0 && data[0] == 0){
                    return "<input id = 'edit_note_school"+data[1]+"' onclick = edit_note_school("+data[1]+") style = 'width: 100%; height: 100%; border: none; background-color: inherit' value = '"+data[0]+"'>"
                }else{
                    return "<input class = 'select reset_name_province' id = 'edit_note_school"+data[1]+"' style = 'width: 100%; height: 100%; border: none; background-color: inherit' onclick = edit_school("+data[1]+") value = '"+data[0]+"'>"
                }
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
    "select": {
        'style': 'os',
        'blurable': true
    },
    "language": {
        "emptyTable": "Không tìm thấy Trường",
        "info": " _START_ / _END_ trên _TOTAL_ Trường",
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
            // 'searchable': false
        },

        {
            "targets": 2,
            "className": "text-center",
        },
        {
            "targets": 3,
            "className": "text-left",
        },
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


function change_load_province_schools(id){
    $('.select').parent().parent().css('background-color','')
    $('#change_load_province_schools'+id).parent().parent().css('background-color','#f4fc9c')
    load_chools().ajax.url("/admin/schools/load_shools/"+id).load();
}


// function load_province_schools(id){
//     var tableData2 =  $('#list_province2').DataTable({
//     ajax: "/admin/province/list_province2"+id,
//     columns: [
//         {title: "#",            data: 'stt'},
//         {
//             title: "ID",
//             data: 'id'
//         },
//         {
//             title: "Mã Quận/Huyện",
//             data: 'id_province2',
//             render: function(data){
//                 var data = data.split("xxx")
//                 if(data[1] == 0){
//                     return '<input id = "id_province2_save" style = "width: 100%; height: 100%; border: none; background-color: inherit;text-align:center">'
//                 }else{
//                     return "<input readonly class = 'select2 reset_id_province' onchange = change_id_province2("+data[1]+","+data[2]+") id = 'edit_id_province2"+data[1]+"' style = 'width: 100%; height: 100%; border: none; background-color: inherit;text-align:center' value = '"+data[0]+"' old = '"+data[0]+"'>"
//                 }
//             }
//         },
//         {
//             title: "Tên Huyện/Quận",
//             data: 'name_province2',
//             render: function(data){
//                 var data = data.split("xxx")
//                 if(data[1] == 0){
//                     return '<input id = "name_province2_save" style = "width: 100%; height: 100%; border: none; background-color: inherit">'
//                 }else{
//                     return "<input readonly   class = 'reset_name_province' onchange = 'change_name_province2("+data[1]+","+data[2]+")' id = 'edit_name_province2"+data[1]+"' style = 'width: 100%; height: 100%; border: none; background-color: inherit' onclick = 'load_province3("+data[1]+")'  value = '"+data[0]+"'>"
//                 }
//             }
//         },
//         {
//             title: "Hiện thị",
//             data: 'active_province2',
//             render: function(data){
//                 var data = data.split("xxx")
//                 var checked = ""
//                 if(data[0] == 1){
//                     checked = 'checked';
//                 }else{
//                     checked = "";
//                 }
//                 return  '<input class = "reset_active" onchange = change_active_province2('+data[1]+','+data[2]+') id = "edit_active_province2'+data[1]+'" type="checkbox"  style = "height:14px" '+checked +' onclick="return false">'
//             },
//         },
//         {
//             title: "Thao tác",
//             data: 'end',
//             render: function(data){
//                 var data = data.split("_")
//                 $html = "";
//                 if(data[0] == 0){
//                     $html = $html +'<div style ="text-align: center;width:100%;">'
//                         $html = $html + '<a onclick = "edit_province2('+data[1]+','+data[2]+')">'
//                             $html = $html + '<i id = "edit_province2'+data[1]+'" style="color:#007bff" class="fa-solid fa-user-pen"></i>&nbsp;&nbsp;'
//                         $html = $html + '</a>'
//                         $html = $html + '<a onclick = "remove_province2('+data[1]+','+data[2]+')">'
//                             $html = $html + '<i style="color:red" class="fa-regular fa-trash-can"></i>'
//                         $html = $html + '</a>'
//                     $html = $html + '</div>'
//                 }else{
//                     $html = $html +'<div style ="text-align: center;width:100%">'
//                         $html = $html + '<a onclick = "province2_save('+data[1]+')">'
//                             $html = $html + '<i style="color:red" class="fa fa-floppy-disk"></i>&nbsp;&nbsp;'
//                         $html = $html + '</a>'
//                         $html = $html + '<a onclick = "province2_fresh()">'
//                             $html = $html + '<i style="color:#007bff" class="fa-solid fa-rotate"></i>'
//                         $html = $html + '</a>'
//                     $html = $html + '</div>'
//                 }
//                 return $html;
//             },
//         },

//     ],
//     "dom": 'pfrtil',
//     scrollY: 480,
//     "language": {
//         "emptyTable": "Không tìm thấy Quận/Huyện",
//         "info": " _START_ / _END_ trên _TOTAL_Quận/Huyện",
//         "paginate": {
//             "first":      "Trang đầu",
//             "last":       "Trang cuối",
//             "next":       "Trang sau",
//             "previous":   "Trang trước"
//         },
//         "search":         "Tìm kiếm:",
//         "loadingRecords": "Đang tìm kiếm ... ",
//         "lengthMenu":     "Hiện thị _MENU_",
//         "infoEmpty":      "",
//         },
//     'columnDefs': [
//         {
//             "targets": 0,
//             "className": "text-center",

//         },
//         {
//             "targets": 1,
//             "className": "text-center",
//             'visible': false,
//             'searchable': false
//         },
//         {
//             "targets": 2,
//             "className": "text-center",

//         },
//         {
//             "targets": 4,
//             "className": "text-center",
//         },
//     ],
//     // "fixedColumns": true,
//     "autoWidth": false,
//     "retrieve": true,
//     "paging": false,
//     "lengthChange": false,
//     "searching": true,
//     "ordering": false,
//     "info": false,
//     "autoWidth": false,
//     "responsive": true,
//     });
//     return tableData2;
//     // tableData.ajax.reload()
// }














