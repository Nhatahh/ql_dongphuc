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

    $('#import_go_mark_hb').hide();
    $('#import_go_mark_thpt').hide();


    // $('#go_data_year').select2();
    // //Load năm tuyển sinh
    // load_go_year()
    load_go_mark();

    //Hiện thị tên file HB
    $('#import_go_mark_hb').change(function(){
        var data = $('#import_go_mark_hb').val().split('fakepath');
        $('#name_go_mark_hb').text(data[1])
        if( $('#name_go_mark_hb').text() != ""){
            $('#open_go_mark_hb').css("color","rgb(0, 123, 255)")
        }else{
            $('#open_go_mark_hb').css("color","red")
        }
   });
   //Sumit file HB
   $('#submit_go_mark_hb').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url: "go_mark/import_go_mark_hb",
            type:"POST",
            data: new FormData(this),
            contentType:false,
            processData:false,
            success:function(data){
                $('#loadding_go_mark').hide();
                if(data == 1){
                    toastr.success("Import danh sách thành thông")
                    $('#import_go_mark_hb').val('');
                    $('#name_go_mark_hb').text('')
                    load_go_mark();
                }else{
                    if(data == 2){
                        toastr.warning("Đợt xét tuyển chung chưa được mở")
                    }else{
                        toastr.warning("Import danh sách thất bại")
                    }
                }

            }
        });
   });


    //Hiện thị tên file THPT
    $('#import_go_mark_thpt').change(function(){
        var data = $('#import_go_mark_thpt').val().split('fakepath');
        $('#name_go_mark_thpt').text(data[1])
        if( $('#name_go_mark_thpt').text() != ""){
            $('#open_go_mark_thpt').css("color","rgb(0, 123, 255)")
        }else{
            $('#open_go_mark_thpt').css("color","red")
        }
    });
   //Sumit file THPT
    $('#submit_go_mark_thpt').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url: "go_mark/import_go_mark_thpt",
            type:"POST",
            data: new FormData(this),
            contentType:false,
            processData:false,
            success:function(data){
                $('#loadding_go_mark').hide();
                if(data == 1){
                    toastr.success("Import danh sách thành thông")
                    $('#import_go_mark_thpt').val('');
                    $('#name_go_mark_thpt').text('')
                    load_go_mark();
                }else{
                    if(data == 2){
                        toastr.warning("Đợt xét tuyển chung chưa được mở")
                    }else{
                        toastr.warning("Import danh sách thất bại")
                    }
                }

            }
        });
    });



})

//Mở file HB

function open_go_mark_thpt(){
    $('#import_go_mark_thpt').click()
}
function upload_go_mark_thpt(){
    if($('#name_go_mark_thpt').text() == ""){
        toastr.warning("Chọn file excel import")
    }else{
        $('#submit_go_mark_thpt').submit();
        $('#loadding_go_mark').show();
    }
}



function open_go_mark_hb(){
    $('#import_go_mark_hb').click()
}
function upload_go_mark_hb(){
    if($('#name_go_mark_hb').text() == ""){
        toastr.warning("Chọn file excel import")
    }else{
        $('#submit_go_mark_hb').submit();
        $('#loadding_go_mark').show();
    }
}


function download_go_mark(){
    window.location.href = "https://congmotcua.ctuet.edu.vn/admin/go_mark/download_go_mark"
    // window.location.href = "https://xettuyentest.ctuet.edu.vn/admin/go_mark/download_go_mark"
}

function load_go_mark(){
    $('#remove_load_go_mark').empty();
    $('#remove_load_go_mark').append('<table class="table table-hover text-nowrap"  id = "load_go_mark"></table>');
    var table = $('#load_go_mark').DataTable( {
        ajax: {
            type: "get",
            url: 'go_mark/load_go_mark',
        },

        // dom: 'frtip',
        columns: [
            {
                title: "ID",
                data: 'id',
            },
            {
                title: "CMND/CCCD",
                data: 'id_card_users',
            },
            {
                title: "Họ tên",
                data: 'name_user',
            },

            {
                title: "Lớp",
                data: 'id_class_result',
            },

            {
                title: "Học kì",
                data: 'id_semester_result',
            },
            {
                title: "Môn",
                data: 'name_subject',
            },
            {
                title: "Điểm",
                data: 'mark_result',
            },
            {
                title: "Phương thức",
                data: 'note_subject',
            },
            {
                title: "Năm TS",
                data: 'course',
            },
        ],
        scrollY: 450,
        "language": {
            "emptyTable": "Không có môn",
            "info": " _START_ / _END_ trên _TOTAL_ môn",
            "paginate": {
                "first":      "Trang đầu",
                "last":       "Trang cuối",
                "next":       "Trang sau",
                "previous":   "Trang trước"
            },
            "search":         "Tìm kiếm:",
            "loadingRecords": "Đang tìm kiếm ... ",
            "lengthMenu":     "Hiện thị _MENU_ môn",
            "infoEmpty":      "",
            },
        "retrieve": true,
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        "select": false,
    })
}
