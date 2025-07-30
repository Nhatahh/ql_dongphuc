$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    alert('Chưa xong! Còn hiệu chỉnh chức năng thêm Tỉnh, Trường, Đổi trạng thái')
    SubjectsAjax().ajax.reload()
    GroupsAjax().ajax.reload()





    // $('#loadProvince tbody').on('click','tr', function(){
    //     var id = ProvinceAjax().row( this ).data().id;
    //     SchoolsAjax().ajax.url("/admin/schools/loadSchools/"+id).load();

    // // })
    // testAjax()
})

// function testAjax(){
//     $.ajax({
//         type: "get",
//         url: "/admin/group_sb/loadGroups",

//         success: function (response) {
//             alert(response)
//         }
//     });
// }



function GroupsAjax(){
    var table =  $('#loadGroups').DataTable({
        ajax: "/admin/group_sb/loadGroups",
        columns: [
            {title: "ID",     data: 'id'},
            {title: "Mã",     data: 'id_group'},
            {title: "Tên",    data: 'name_group'},
            {
                title: "Môn xét tuyển",
                data: 'subjects_group',
                render: function(data){
                    var html = '';
                    if(data == 0){
                        return  html += '<p style = "margin: 0; color: red">Chưa có môn xét tuyển</p>';
                    }else{
                        return data;
                    }
                }
            },


            {
                title: "Trạng thái",
                data: 'active_group',
                render: function(data){
                    var $html = "", ac = '';
                    if(data == 0){
                        return  $html = $html + '<span class="badge bg-danger">Ngưng sử dụng</span>'
                    }else{
                        return  $html = $html + '<span class="badge bg-primary">Đang sử dụng</span>'
                    }
                },
            },
            {title: "Thứ tự",    data: 'num_group'},
            {title: "Ghi chú",    data: 'note_group'},
        ],

        columnDefs: [
            { targets: [0], //ID
                width: '5%'
            },
            { targets: [1], //Mã TH
                width: '5%'
            },
            { targets: [2], //Tên tổ hợp
                width: '25%'
            },
            { targets: [3], // Môn xét tuyển
                width: '25%'
            },
            { targets: [4], //Trạng thái
                width: '13%',
                className: 'dt-body-center'
            },
            { targets: [5], //Thứ tự
                width: '7%',
                className: 'dt-body-center'
            },
            { targets: [6], //Ghi chú
                width: '20%'
            },
        ],

        "retrieve": true,
        "paging": true,
        "pageLength": 10,
        "lengthChange": false,
        "searching": true,
        "ordering": false,
        "info": false,
        "autoWidth": true,
        "responsive": true,
        'select': true
        });
    return table;
}

function SubjectsAjax(){
    var table =  $('#loadSubjects').DataTable({
        ajax: "/admin/group_sb/loadSubjects",
        columns: [
            {title: "ID",     data: 'id'},
            {title: "Mã Môn",     data: 'id_subject'},
            {title: "Tên Môn",    data: 'name_subject'},
            {
                title: "Trạng thái",
                data: 'active_subject',
                render: function(data){
                    var $html = "", ac = '';
                    if(data == 0){
                        return  $html = $html + '<span class="badge bg-danger">Ngưng sử dụng</span>'
                    }else{
                        return  $html = $html + '<span class="badge bg-primary">Đang sử dụng</span>'
                    }
                },
            },
            {title: "Thứ tự",    data: 'num_subject'},
            {title: "Ghi chú",    data: 'note_subject'},
        ],



        columnDefs: [
            { targets: [0],
                width: '7%'
            },
            { targets: [1],
                width: '12%'
            },
            { targets: [2],
                width: '26%'
            },
            { targets: [3],
                width: '15%',
                className: 'dt-body-center'
            },
            { targets: [4],
                width: '10%',
                className: 'dt-body-center'
            },
            { targets: [5],
                width: '30%'
            },
        ],
        "retrieve": true,
        "paging": true,
        "pageLength": 10,
        "lengthChange": false,
        "searching": true,
        "ordering": false,
        "info": false,
        "autoWidth": true,
        "responsive": true,
        'select': true
        });
    return table;
}


// function SchoolsAjax(id){
//     var table =  $('#loadSchools').DataTable({
//         ajax: "/admin/schools/loadSchools/"+id,
//         columns: [
//             {title: "ID",
//             data: 'id',

//         },
//             {title: "Mã Trường",     data: 'id_school'},
//             {title: "Tên Trường",    data: 'name_school'},
//             {title: "Khu vực",    data: 'priority_area_school'},
//             {title: "Điện thoại",    data: 'phone_rector_school'},
//             {
//                 title: "Trạng thái",
//                 data: 'active_school',
//                 render: function(data){
//                     var $html = "", ac = '';
//                     if(data == 0){
//                         return  $html = $html + '<span class="badge bg-danger">Ngưng sử dụng</span>'
//                     }else{
//                         return  $html = $html + '<span class="badge bg-primary">Đang sử dụng</span>'
//                     }
//                 },
//             },
//         ],
//         columnDefs: [
//             { targets: [1,3,4,5],
//                 className: 'dt-body-center'
//             },
//         ],
//         "retrieve": true,
//         "paging": false,
//         "lengthChange": true,
//         "searching": true,
//         "ordering": false,
//         "info": false,
//         "autoWidth": true,
//         "responsive": true,
//         'select': true,
//         'scrollY': '55vh',
//         'scrollCollapse': true,
//         });
//     return table;
// }














