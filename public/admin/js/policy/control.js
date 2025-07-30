$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    if($(document).width() > 992){
        $('#right_check_user').css('min-height','760px')
        $('#left_check_user').css('min-height','760px')
    }else{
        $('#right_check_user').css('min-height','0x')
        $('#left_check_user').css('min-height','0px')
    }

    $(window).resize(function(){
        if($(document).width()>992){
            $('#right_check_user').css('min-height','760px')
            $('#left_check_user').css('min-height','760px')
        }else{
            $('#right_check_user').css('min-height','0x')
            $('#left_check_user').css('min-height','0px')
        }
    });


    if($(document).width() > 992){
        $('#right_check').css('min-height','630px')
        $('#left_check').css('min-height','630px')
    }else{
        $('#right_check').css('min-height','0x')
        $('#left_check').css('min-height','0px')
    }

    $(window).resize(function(){
        if($(document).width()>992){
            $('#right_check').css('min-height','630px')
            $('#left_check').css('min-height','630px')
        }else{
            $('#right_check').css('min-height','0x')
            $('#left_check').css('min-height','0px')
        }
    });

    list_policy();
    file_policy_attr();






    // load_file_policy();
})

function list_policy(){
    var table_policy = $('#list_policy').DataTable( {
        ajax: {
            type: "get",
            url: 'policy/list_policy',
        },
        // dom: 'frtip',
        columns: [
            {
                title: "ID",
                data: 'id',
            },
            {
                title: "Mã đối tượng",
                data: 'id_policy_user',
            },
            {
                title: "Tên khu vực",
                data: 'name_policy',
                render: function(data){
                    var data = data.split("xxx")
                    return '<span onclick = "file_policy('+data[1]+')">'+data[0]+'</span>';
                }
            },
            {
                title: "Điểm ưu tiên chuẩn",
                data: 'mark_policy_user',
            },
            {
                title: "Thứ tự",
                data: 'num_policy',
            },
            {
                title: "Trạng thái",
                data: 'active_policy',
                render: function(data){
                    var html = ""
                    data == 1 ?  html = '<input type="checkbox" checked style = "height:14px" onclick = "return false"></input>' : html = '<input type="checkbox" style = "height:14px" onclick = "return false"></input></i>'
                    return html;
                }
            },
            {
                title: "Chức năng",
                data: 'id',
                render: function(data){
                    var html = '<i style ="color: #28a745" onclick = "file_policy('+data+')" class="fa-solid fa-file-shield"></i>'
                        html += '&nbsp;&nbsp;<i style ="color: #007bff"  class="fa-solid fa-user-pen"></i>'
                        html += '&nbsp;&nbsp;<i style ="color: red"  class="fa-solid fa-trash"></i>'
                    return html;
                }
            },
            {
                title: "Hồ sơ đính kèm",
                data: 'name_list',
            },
            {
                title: "Ghi chú",
                data: 'note_policy_user',
            },
        ],
        scrollY:150,
        "language": {
            "emptyTable": "Không có đối tượng",
            "info": " _START_ / _END_ trên _TOTAL_ đối tượng",
            "paginate": {
                "first":      "Trang đầu",
                "last":       "Trang cuối",
                "next":       "Trang sau",
                "previous":   "Trang trước"
            },
            "search":         "Tìm kiếm:",
            "loadingRecords": "Đang tìm kiếm ... ",
            "lengthMenu":     "Hiện thị _MENU_ đối tượng",
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
                    // 'visible': false,
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
                {
                    "targets": 5,
                    "className": "text-center",
                },
                {
                    "targets": 6,
                    "className": "text-center",
                },
            ],
        "retrieve": true,
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        "select": false,
    })
    return table_policy
}

function file_policy(id){
    $('#modal_policy_file').show();
    var link = "policy/file_policy/"+id
    $("#remove_edit_policy_file").empty()
    $("#remove_edit_policy_file").append('<table class="table table-bordered table-hover table-striped" style = "width: 100%" id = "edit_policy_file">')
    var table =  $('#edit_policy_file').DataTable({
    ajax: link,
    columns: [
        {title: "ID",    data: 'id'},
        {title: "Tên minh chứng",    data: 'name_list'},
        {
            title: "Trạng thái",
            data: 'active',
            render: function(data){
                var data = data.split("xxx")
                var checked = "";
                data[1] == 1 ? checked = "checked" : checked = ""
                return '<input onclick = "(edit_policy_file('+data[0]+')" type = "checkbox" '+checked+'></input>'
            }
        },
    ],
    scrollY: 300,
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
            "className": "text-left",
        },
        {
            "targets": 2,
            "className": "text-center",
        },
    ],
    // "fixedColumns": true,
    "retrieve": true,
    "paging": false,
    "lengthChange": true,
    "searching": true,
    "ordering": false,
    "info": false,
    "autoWidth": true,
    "responsive": false,
    });
    return table
    // table.ajax.url(link).load();
}

function file_policy_attr(){
    var file_policy_attr = $('#file_policy_attr').DataTable( {
        ajax: {
            type: "get",
            url: 'policy/file_policy_attr',
        },
        // dom: 'frtip',
        columns: [
            // {
            //     title: "ID",
            //     data: 'id',
            // },
            {
                title: "Mã hồ sơ",
                data: 'id_policy',
            },
            {
                title: "Tên hồ sơ",
                data: 'name_list',
                render: function(data){
                    var data = data.split("xxx")
                    return '<span onclick = "load_file_policy('+data[1]+')">'+data[0]+'</span>'
                }
            },

            {
                title: "Trạng thái",
                data: 'active',
                render: function(data){
                    var html = ""
                    data == 1 ?  html = '<input type="checkbox" checked style = "height:14px" onclick = "return false"></input>' : html = '<input type="checkbox" style = "height:14px" onclick = "return false"></input></i>'
                    return html;
                }
            },

            {
                title: "Chức năng",
                data: 'id',
                render: function(data){
                    var html = '&nbsp;&nbsp;<i style ="color: #007bff"  class="fa-solid fa-user-pen"></i>'
                    html += '&nbsp;&nbsp;<i style ="color: #28a745"  class="fa-solid fa-paperclip"></i>'
                    html += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i style ="color: red"  class="fa-solid fa-trash"></i>'
                    return html;
                }
            },

            {
                title: "Ghi chú",
                data: 'note_policy',
            },
        ],
        scrollY:190,
        "language": {
            "emptyTable": "Không có đối tượng",
            "info": " _START_ / _END_ trên _TOTAL_ đối tượng",
            "paginate": {
                "first":      "Trang đầu",
                "last":       "Trang cuối",
                "next":       "Trang sau",
                "previous":   "Trang trước"
            },
            "search":         "Tìm kiếm:",
            "loadingRecords": "Đang tìm kiếm ... ",
            "lengthMenu":     "Hiện thị _MENU_ đối tượng",
            "infoEmpty":      "",
            },
            'columnDefs': [
                {
                    "targets": 0,
                    "className": "text-center",
                },
                {
                    "targets": 1,
                    "className": "left-center",
                    // 'visible': false,
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
        "retrieve": true,
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        "select": false,
    })
    return file_policy_attr
}

function close_policy_file(){
    $('#modal_policy_file').hide();
}

async function load_file_policy(id) {
    await $('#remove_load_file_policy').empty();
    await $('#remove_load_file_policy').append('<div class="swiper-wrapper" id = "load_file_policy"> </div><div class="swiper-pagination"></div>');

    const swiper = new Swiper('.swiper', {
        // zoom: true,
        zoom: {
            maxRatio: 3,
            minRatio: 1
          },
        // rotate: 'true',
        // on: {
        // slideChangeTransitionEnd: function () {
        //     console.log('clicked!')
        //     this.zoom.in();
        //     }
        // },
        // Optional parameters
        slidesPerView: 1,
        // direction: 'vertical',
        // loop: true,

        // If we need pagination
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
        },

        // Navigation arrows
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },

        // And if we need scrollbar
        // scrollbar: {
        //   el: '.swiper-scrollbar',
        // },

        // slidesPerView: 1,
      });


      await $.ajax({
        type: "get",
        url: "policy/load_file_policy/"+id,
        success: function (res) {
            $('#load_file_policy').html(res)
        }
    });
}

// async function load_file_policy1(){
//     $('remove_load_file_policy').empty();
//     $('remove_load_file_policy').append('<div class="swiper-wrapper" id = "load_file_policy"> </div><div class="swiper-pagination"></div>');
// }

// async function load_file_policy2(id){
//
// }



function del_img_slide(id){
    alert("Xóa Ảnh")
}

function update_img_slide(id){
    alert("Upload Ảnh")
}
