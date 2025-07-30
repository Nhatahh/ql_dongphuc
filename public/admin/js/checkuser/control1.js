
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    alert(111111111111)
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

    $('#year_check').select2();
    $('#batch_check').select2();
    $('#school_check').select2();
    $('#province_check').select2();
    $('#active_check').select2();



    //Load Search
    load_search()

    //Change Year
    $('#year_check').on('change',function(){
        var id = $(this).val();
        $.ajax({
            url: "/admin/checkuser/changeyear/"+id,
            type:'get',
            dataType: 'json',
            success:function(data){
                $('#batch_check').html('').select2({
                    data: data
                });
            }
        })
    })


    //Change Tỉnh
    $('#province_check').on('change',function(){
        var id = $(this).val();
        if(id == 0){
            $('#school_check').html('').select2();
        }else{
            $.ajax({
                url: "/admin/checkuser/changeprovince/"+id,
                type:'get',
                dataType: 'json',
                success:function(data){
                    $('#school_check').html('').select2({
                        data: data
                    });
                }
            })
        }
    })


    //Tìm kiếm
    $('#search_check').on('click',function(){
        result()
    });


    $('#clear_check').on('click',function(){
        $('#remove_load_list_reg').empty();
        $('#remove_load_list_reg').append('<table class="table table-hover text-nowrap"  id = "load_list_reg"></table>');
        load_search()
    })

    $('#close_check').on('click',function(){
        result();
        $('#modal_check').hide('slow')
    })

});
//Load thông tin tìm kiếm


//Kết quả tìm kiếm

function result(){
    $('#remove_load_list_reg').empty();
    $('#remove_load_list_reg').append('<table class="table table-hover text-nowrap"  id = "load_list_reg"></table>');
    var year = $('#year_check').val();
    var batch = $('#batch_check').val();
    var active = $('#active_check').val();
    var province = $('#province_check').val();
    var school = $('#school_check').val();
    var id_card = $('#id_card_check').val();
    var phone = $('#phone_check').val();
    var id_user = $('#id_user_check').val();

    if(year == 0){
        toastr.warning("Chọn năm tuyển sinh")
    }else{
        if(active == 0){
            toastr.warning("Chọn trạng thái hồ sơ thí sinh")
        }else{
            var data;
            switch (Number(active)) {
                case 1:
                    data = [year,batch,active,province,school,id_card,phone,id_user]
                    break;
                case 2:
                    data = [year,batch,active,province,school,id_card,phone,id_user]
                    break;
                case 3:
                    data = [year,batch,active,province,school,id_card,phone,id_user]
                    var table = $('#load_list_reg').DataTable( {
                        ajax: {
                            type: "get",
                            url: 'checkuser/load_list_reg',
                            data:
                            {
                                data: data
                            },
                        },
                        columns: [
                            {title: "ID",               data: 'id'},
                            {title: "Họ và tên",        data: 'name_user'},
                            {title: "Ngày sinh",        data: 'birth_user'},
                            {title: "Điện thoại",       data: 'phone_users'},
                            {title: "Email",            data: 'email_users'},
                            {title: "CMND/TCC",         data: 'id_card_users'},
                            {title: "Năm TS",           data: 'course'},
                            {title: "Đợt tuyển sinh",   data: 'name_batch'},
                            {title: "Tỉnh",             data: 'name_province'},
                            // {title: "Trường",       data: 'name_school'},
                            {
                                title: "",
                                data: 'id',
                                render: function(data){
                                    return '<i onclick = "view_check('+data+')" style = "color:#007bff" class="fas fa-pencil-alt"></i>'
                                }
                            },


                        ],

                        "language": {
                            "emptyTable": "Không tìm thấy thí sinh",
                            "info": " _START_ / _END_ trên _TOTAL_ thí sinh",
                            "paginate": {
                                "first":      "Trang đầu",
                                "last":       "Trang cuối",
                                "next":       "Trang sau",
                                "previous":   "Trang trước"
                            },
                            "search":         "Tìm kiếm:",
                            "loadingRecords": "Đang tìm kiếm ... ",
                            "lengthMenu":     "Hiện thị _MENU_ thí sinh",
                            "infoEmpty":      "",
                          },
                        "retrieve": true,
                        "paging": true,
                        "lengthChange": true,
                        "searching": true,
                        "ordering": false,
                        "info": true,
                        "autoWidth": true,
                        "responsive": true,
                    })
                    // table.ajax.reload();
                    break;
            }
        }
    }
}
//Load tìm kiếm
function load_search(){
    $.ajax({
        url: "/admin/checkuser/load_search",
        type:'get',
        dataType: 'json',
        success:function(data){
            $('#year_check').html('').select2({
                data: data.year,
            });
            $('#batch_check').html('').select2({
                data: data.batch
            });
            $('#province_check').html('').select2({
                data: data.province
            });
            $('#school_check').html('').select2({
                data: data.school
            });
        }

    })
}



function view_check(id){
    $('#modal_check').show('slow');
}



function load_list_reg(){
    var data = [1,2]
    $('#load_list_reg').DataTable({
    ajax:    '/admin/checkuser/load_list_reg',
    dataSrc:  data,
    columns: [
        {title: "ID",               data: 'id'},
        {title: "Họ và tên",        data: 'name_user'},
        {title: "Ngày sinh",        data: 'birth_user'},
        {title: "Điện thoại",       data: 'phone_users'},
        {title: "Email",            data: 'email_users'},
        {title: "CMND/TCC",         data: 'id_card_users'},
        {title: "Năm tuyển sinh",       data: 'course'},
        {title: "Đợt tuyển sinh",       data: 'name_batch'},

    ],
    "retrieve": true,
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": false,
    "info": true,
    "autoWidth": true,
    "responsive": true,
    });
    // table.ajax.reload()
  }



