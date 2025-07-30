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

    $('#import_go_data_list').hide();
    $('#import_go_info_list').hide();
    $('#import_go_policy_list').hide();

    // $('#loadding_go_data').show();


    $('#go_data_year').select2();
    //Load năm tuyển sinh
    load_go_year()
    load_go_data_acc();

    $('#import_go_data_list').change(function(){
        var data = $('#import_go_data_list').val().split('fakepath');
        $('#name_go_data_list').text(data[1])
        if( $('#name_go_data_list').text() != ""){
            $('#open_go_data_list').css("color","rgb(0, 123, 255)")
        }else{
            $('#open_go_data_list').css("color","red")
        }
   });
   $('#submit_go_data_list').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url: "go_data/import_go_data_list",
            type:"POST",
            data: new FormData(this),
            contentType:false,
            processData:false,
            success:function(data){
                $('#loadding_go_data').hide();

                if(data == 1){
                    toastr.success("Import danh sách thành thông")
                    $('#import_go_data_list').val('');
                    $('#name_go_data_list').text('')
                    load_go_data_acc();
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


   $('#import_go_info_list').change(function(){
        var data = $('#import_go_info_list').val().split('fakepath');
        $('#name_go_info_list').text(data[1])
        if( $('#name_go_info_list').text() != ""){
            $('#open_go_info_list').css("color","rgb(0, 123, 255)")
        }else{
            $('#open_go_info_list').css("color","red")
        }
    });
    $('#submit_go_info_list').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url: "go_data/import_go_info_list",
            type:"POST",
            data: new FormData(this),
            contentType:false,
            processData:false,
            success:function(data){
                $('#loadding_go_data').hide();
                if(data == 1){
                    toastr.success("Import danh sách thành thông")
                    $('#import_go_info_list').val('');
                    $('#name_go_info_list').text('')
                    load_go_data_acc();
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

    $('#import_go_policy_list').change(function(){
        var data = $('#import_go_policy_list').val().split('fakepath');
        $('#name_go_policy_list').text(data[1])
        if( $('#name_go_policy_list').text() != ""){
            $('#open_go_policy_list').css("color","rgb(0, 123, 255)")
        }else{
            $('#open_go_policy_list').css("color","red")
        }
    });
    $('#submit_go_policy_list').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url: "go_data/import_go_policy_list",
            type:"POST",
            data: new FormData(this),
            contentType:false,
            processData:false,
            success:function(data){
                $('#loadding_go_data').hide();
                if(data == 1){
                    toastr.success("Import danh sách thành thông")
                    $('#import_go_policy_list').val('');
                    $('#name_go_policy_list').text('')
                    load_go_data_acc();
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

function load_go_year(){
    $.ajax({
        url: "go_data/load_go_year",
        type:'get',
        // dataType: 'json',
        success:function(data){
            $('#go_data_year').html('').select2({
                data: data.year,
            });
        }
    })
}


function open_go_data_list(){
    $('#import_go_data_list').click()
}

function upload_go_data_list(){
    if($('#name_go_data_list').text() == ""){
        toastr.warning("Chọn file excel import")
    }else{
        $('#submit_go_data_list').submit();
        $('#loadding_go_data').show();
    }
}

function download_go_data_list(){
    window.location.href = "https://congmotcua.ctuet.edu.vn/admin/go_data/download_go_data_list"
    // window.location.href = "https://xettuyentest.ctuet.edu.vn/admin/go_data/download_go_data_list"
}


function open_go_info_list(){
    $('#import_go_info_list').click()
}
function upload_go_info_list(){
    if($('#name_go_info_list').text() == ""){
        toastr.warning("Chọn file excel import")
    }else{
        $('#loadding_go_data').show();
        $('#submit_go_info_list').submit();
    }
}

function open_go_policy_list(){
    $('#import_go_policy_list').click()
}
function upload_go_policy_list(){
    if($('#name_go_policy_list').text() == ""){
        toastr.warning("Chọn file excel import")
    }else{
        $('#loadding_go_data').show();
        $('#submit_go_policy_list').submit();
    }
}

function load_go_data_acc(){
    $('#remove_load_go_data_acc').empty();
    $('#remove_load_go_data_acc').append('<table class="table table-hover text-nowrap"  id = "load_go_data_acc"></table>');
    var table = $('#load_go_data_acc').DataTable( {
        ajax: {
            type: "get",
            url: 'go_data/load_go_data_acc',
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
                title: "Ngày sinh",
                data: 'birth_user',
            },
            {
                title: "Điện thoại",
                data: 'phone_users',
            },

            {
                title: "Email",
                data: 'email_users',
            },

            {
                title: "Đối tượng",
                data: 'name_policy_user',
            },

            {
                title: "Khu vực",
                data: 'id_priority_area',
            },

            // {
            //     title: "Năm TS",
            //     data: 'course',
            // },
        ],
        scrollY: 450,
        "language": {
            "emptyTable": "Không có tài khoản",
            "info": " _START_ / _END_ trên _TOTAL_ tài khoản",
            "paginate": {
                "first":      "Trang đầu",
                "last":       "Trang cuối",
                "next":       "Trang sau",
                "previous":   "Trang trước"
            },
            "search":         "Tìm kiếm:",
            "loadingRecords": "Đang tìm kiếm ... ",
            "lengthMenu":     "Hiện thị _MENU_ tài khoản",
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

