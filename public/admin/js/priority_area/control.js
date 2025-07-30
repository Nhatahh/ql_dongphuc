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
    list_priority_area()
})

function list_priority_area(){
    $('#remove_list_priority_area').empty();
    $('#remove_list_priority_area').append('<table class="table table-hover text-nowrap"  id = "list_priority_area"></table>');
    var table = $('#list_priority_area').DataTable( {
        ajax: {
            type: "get",
            url: 'priority_area/list_priority_area',
        },
        // dom: 'frtip',
        columns: [
            {
                title: "ID",
                data: 'id',
            },
            {
                title: "Mã khu vực",
                data: 'id_priority_area',
            },
            {
                title: "Tên khu vực",
                data: 'name_priority_area',
            },
            {
                title: "Điểm ưu tiên chuẩn",
                data: 'mark_priority',
            },
            {
                title: "Thứ tự",
                data: 'num_priority_area',
            },
            {
                title: "Ghi chú",
                data: 'note_priority_area',
            },
        ],
        scrollY: 450,
        "language": {
            "emptyTable": "Không có khu vực",
            "info": " _START_ / _END_ trên _TOTAL_ khu vực",
            "paginate": {
                "first":      "Trang đầu",
                "last":       "Trang cuối",
                "next":       "Trang sau",
                "previous":   "Trang trước"
            },
            "search":         "Tìm kiếm:",
            "loadingRecords": "Đang tìm kiếm ... ",
            "lengthMenu":     "Hiện thị _MENU_ khu vực",
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
            ],
        "retrieve": true,
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        "select": false,
    })
}

