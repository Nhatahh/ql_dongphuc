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

    $('#import_go_wish').hide();

    // $('#go_data_year').select2();
    // //Load năm tuyển sinh
    // load_go_year()
    load_go_wish();

    //Hiện thị tên file HB
    $('#import_go_wish').change(function(){
        var data = $('#import_go_wish').val().split('fakepath');
        $('#name_go_wish1').text(data[1])
        if( $('#name_go_wish1').text() != ""){
            $('#open_go_wish').css("color","rgb(0, 123, 255)")
        }else{
            $('#open_go_wish').css("color","red")
        }
   });
   //Sumit file HB
   $('#submit_go_wish').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url: "go_wish/import_go_wish",
            type:"POST",
            data: new FormData(this),
            contentType:false,
            processData:false,
            success:function(data){
                $('#loadding_go_wish').hide();
                if(data == 1){
                    toastr.success("Import danh sách thành thông")
                    $('#import_go_wish').val('');
                    $('#name_go_wish1').text('')
                    load_go_wish();
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

   $('#cal_go_wish').on('click',function(){
        var start = $('#cal_go_wish_start').val();
        var end = $('#cal_go_wish_end').val();
        if(start == '' || end == ''){
            toastr.warning('VUi lòng nhập ID của thí sinh')
        }else{
            cal_go_wish(start,end)
        }
   })

   $('#number_go_wish').on('click',function(){
        var start = $('#number_go_wish_start').val();
        var end = $('#number_go_wish_end').val();
        if(start == '' || end == ''){
            toastr.warning('VUi lòng nhập ID của thí sinh')
        }else{
            number_go_wish(start,end)
        }
    })

})


function open_go_wish(){
    $('#import_go_wish').click()
}


function upload_go_wish(){
    if($('#name_go_wish1').text() == ""){
        toastr.warning("Chọn file excel import")
    }else{
        $('#submit_go_wish').submit();
        $('#loadding_go_wish').show();
    }
}

//Mở file HB

function download_go_wish(){
    window.location.href = "https://congmotcua.ctuet.edu.vn/admin/go_wish/download_go_wish"
    // window.location.href = "https://xettuyentest.ctuet.edu.vn/admin/go_wish/download_go_wish"
}

function load_go_wish(){
    $('#remove_load_go_wish').empty();
    $('#remove_load_go_wish').append('<table class="table table-hover text-nowrap"  id = "load_go_wish"></table>');
    var table = $('#load_go_wish').DataTable( {
        ajax: {
            type: "get",
            url: 'go_wish/load_go_wish',
        },

        // dom: 'frtip',
        columns: [
            {
                title: "ID",
                data: 'id_user',
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
                title: "PT",
                data: 'id_method',
            },

            {
                title: "Mã ngành",
                data: 'id_major',
            },
            {
                title: "Tên ngành",
                data: 'name_major',
            },
            {
                title: "TTNV",
                data: 'number_bo',
            },
            {
                title: "NV_Tr",
                data: 'number',
            },
            {
                title: "TH",
                data: 'id_group',
            },
            {
                title: "Điểm TH",
                data: 'group_mark',
            },
            {
                title: "Điểm UT",
                data: 'priority_mark',
            },
            {
                title: "Tổng điểm",
                data: 'mark',
            },
            {
                title: "TT Sớm",
                data: 'tts1',
            },
        ],
        scrollY: 450,
        "language": {
            "emptyTable": "Không có nguyện vọng",
            "info": " _START_ / _END_ trên _TOTAL_ nguyện vọng",
            "paginate": {
                "first":      "Trang đầu",
                "last":       "Trang cuối",
                "next":       "Trang sau",
                "previous":   "Trang trước"
            },
            "search":         "Tìm kiếm:",
            "loadingRecords": "Đang tìm kiếm ... ",
            "lengthMenu":     "Hiện thị _MENU_ nguyện vọng",
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


function go_wish_tts(){
    $('#loadding_go_wish').show();
    $('#go_wish_tts').attr('disabled','true');
    $.ajax({
        url: "go_wish/go_wish_tts",
        type:"POST",
        contentType:false,
        processData:false,
        success:function(data){
            $('#loadding_go_wish').hide();
            $('#go_wish_tts').removeAttr('disabled');
            if(data == 1){
                toastr.success("Cập nhập danh sách trúng tuyển sớm thành công")
                load_go_wish();
            }else{
                if(data == 2){
                    toastr.warning("Đợt xét tuyển chung chưa được mở")
                }else{
                    toastr.warning("Cập nhập danh sách trúng tuyển sớm thất bại")
                }
            }

        }
    });
}


function cal_go_wish_start_end(){
    $('#modal_cal_go_wish_start_end').show('slow');
}

function modal_cal_go_wish_start_end_close(){
    $('#modal_cal_go_wish_start_end').hide('slow');
}

function number_go_wish_start_end(){
    $('#modal_number_go_wish_start_end').show('slow');
}

function modal_number_go_wish_start_end_close(){
    $('#modal_number_go_wish_start_end').hide('slow');
}

function cal_go_wish(start,end){
    $('#loadding_go_wish').show();
    $('#cal_go_wish').attr('disabled','true');
    $.ajax({
        url: "go_wish/cal_go_wish",
        type:"POST",
        data:{
            start: start,
            end: end,
        },
        // contentType:false,
        // processData:false,
        success:function(data){
            $('#loadding_go_wish').hide();
            $('#cal_go_wish').removeAttr('disabled');
            switch(String(data)) {
                case '1':
                    toastr.success("Tính điểm thành công")
                    load_go_wish();
                    break;
                case '2':
                    toastr.warning("Không có nguyện vọng để tính điểm")
                    break;
                case '3':
                    toastr.warning("Đợt xét tuyển chưa đợt mở")
                    break;
                default:
                    toastr.warning("Tính điểm thất bại")
                    break;
            }
        }
    });
}


function number_go_wish(start,end){
    $('#loadding_go_wish').show();
    $('#number_go_wish').attr('disabled','true');
    $.ajax({
        url: "go_wish/number_go_wish",
        type:"POST",
        data:{
            start: start,
            end: end,
        },
        // contentType:false,
        // processData:false,
        success:function(data){
            $('#loadding_go_wish').hide();
            $('#number_go_wish').removeAttr('disabled');
            switch(String(data)) {
                case '1':
                    toastr.success("Sắp xếp nguyện vọng thành công")
                    load_go_wish();
                    break;
                case '2':
                    toastr.warning("Không có nguyện vọng để sắp xếp")
                    break;
                case '3':
                    toastr.warning("Đợt xét tuyển chưa đợt mở")
                    break;
                default:
                    toastr.warning("Sắp xếp nguyện vọng thất bại")
                    break;
            }
        }
    });
}
