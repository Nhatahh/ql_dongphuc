$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    alert('Chưa xong! Còn hiệu chỉnh chức năng thêm, sửa, xóa phương thức')
    MethodsAjax().ajax.reload()

})

// function SchoolsAjax(id){
//     $.ajax({
//         type: "get",
//         url: "/admin/schools/loadSchools/"+id,

//         success: function (response) {
//             alert(response)
//         }
//     });
// }


function MethodsAjax(){
    var table =  $('#loadMethods').DataTable({
        ajax: "/admin/methods/loadMethods",
        columns: [
            {title: "ID",     data: 'id'},
            {title: "Mã phương thức",     data: 'id_method'},
            {title: "Tên phương thức",     data: 'name_method'},
            {
                title: "Trạng thái",
                data: 'active_method',
                render: function(data){
                    var $html = "";
                    if(data == 0){
                        return  $html = $html + '<span class="badge bg-danger">Ngưng sử dụng</span>'
                    }else{
                        return  $html = $html + '<span class="badge bg-primary">Đang sử dụng</span>'
                    }
                },
            },
            {title: "Ghi chú",     data: 'note_method'},
        ],
        columnDefs: [
            { targets: [0,1,3],
                className: 'dt-body-center',
            },
            { targets: [0],
                width: "10%"
            },
            { targets: [1],
                width: "10%"
            },
            { targets: [2],
                width: "30%"
            },
            { targets: [3],
                width: "15%"
            },
            { targets: [4],
                width: "35%"
            },
        ],
        "retrieve": true,
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": false,
        "autoWidth": true,
        "responsive": true,
        'select': true,
        });
    return table;
}















