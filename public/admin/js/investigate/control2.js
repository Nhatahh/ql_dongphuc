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





    // $('#year_check').select2();
    $('#batch_investigate').select2();
    $('#major_investigate').select2();
    $('#check_investigate').select2();




    $('#batch_investigate').on('change',function(){
        $.ajax({
            url: "/admin/investigate/change_batch/"+$(this).val(),
            type:'get',
            dataType: 'json',
            success:function(data){
                $('#major_investigate').html('').select2({
                    data: data
                });
            }
        })
    });

    load_search()

    //Tìm kiếm
    $('#search_investigate').on('click',function(){
        result()
    });

    $('#clear_check').on('click',function(){
        $('#remove_load_list_reg').empty();
        $('#remove_load_list_reg').append('<table class="table table-hover text-nowrap"  id = "load_list_reg"></table>');
        load_search()
    })

    $('#close_check').on('click',function(){
        // result();
        $('#modal_check').hide('slow')
    })


});

function excel_investigate(){
    var batch = $('#batch_investigate').val();
    var major = $('#major_investigate').val();

    var name = $('#name_investigate').val();
    if(name == ''){name = 0}else{name=name}

    var id_card = $('#id_card_investigate').val();
    if(id_card == ''){id_card = 0}else{id_card=id_card}

    var phone = $('#phone_investigate').val();
    if(phone == ''){phone = 0}else{phone=phone}

    var id_user = $('#id_user_investigate').val();
    if(id_user == ''){id_user = 0}else{id_user=id_user}
    var check = $('#check_investigate').val();
    if(check == ''){check = 0}else{check=check}

    // window.location.href = "https://xettuyentest.ctuet.edu.vn/admin/investigate/excel_investigate"+'/'+batch+'/'+major+'/'+name+'/'+id_card+'/'+phone+'/'+id_user+'/'+check
    window.location.href = "https://congmotcua.ctuet.edu.vn/admin/investigate/excel_investigate"+'/'+batch+'/'+major+'/'+name+'/'+id_card+'/'+phone+'/'+id_user+'/'+check
}

//Kết quả tìm kiếm
function result(){
    $('#remove_list_investigate').empty();
    // $('#remove_list_investigate').append('<table class="table table-hover text-nowrap" style = "width: 100%" id = "list_investigate"></table>');
    $('#remove_list_investigate').append('<table class="table table-bordered table-hover" style = "width: 100%;font-size:13px" id = "list_investigate"></table>');


    var batch = $('#batch_investigate').val();
    var major = $('#major_investigate').val();
    var name = $('#name_investigate').val();
    var id_card = $('#id_card_investigate').val();
    var phone = $('#phone_investigate').val();
    var id_user = $('#id_user_investigate').val();
    var check = $('#check_investigate').val();

    if(batch == 0){
        toastr.warning("Chọn đợt tuyển sinh")
    }else{
        var data;

        data = [batch,major,name,id_card,phone,id_user,check]
        var table = $('#list_investigate').DataTable({
            ajax: {
                type: "get",
                url: 'investigate/list_investigate',
                data:
                {
                    data: data
                },
            },
            scrollY: 450,
            columns: [
                {title: "ID",               data: 'id_user'},
                {title: "Họ và tên",        data: 'name_user'},
                {title: "Điện thoại",       data: 'phone_users'},
                {title: "CMND/TCC",         data: 'id_card_users'},
                {title: "Email",            data: 'email_users'},

                {title: "Ngành trúng tuyển",            data: 'name_major'},
                // {title: "Đợt tuyển sinh",   data: 'name_batch'},

                {
                    title: "Xác nhận",
                    data: 'active',
                    render: function(data){
                        if(data == 1){
                            return '<span><small class="badge badge-primary"><i class="fa fa-check"></i>&nbsp;Đã xác nhận</small></span>'
                        }else{
                            return '<span><small class="badge badge-warning"><i class="fa fa-spinner"></i>&nbsp;Chưa xác nhận</small></span>'
                        }
                    }
                },
                {
                    title: "Ghi chú",
                    data: 'batch',
                    render: function(data){
                        if(data == 1){
                            return 'Đợt 1-2023'
                        }else{
                            if(data == 2){
                                return 'Đợt 2-2023'
                            }
                        }
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


    }

}
//Load tìm kiếm
function load_search(){
    $.ajax({
        url: "/admin/investigate/load_search",
        type:'get',
        dataType: 'json',
        success:function(data){
            // $('#year_check').html('').select2({
            //     data: data.year,
            // });
            $('#batch_investigate').html('').select2({
                data: data.batch
            });
        }
    })
}




function load_list_reg(){
    var data = [1,2]
    $('#load_list_reg').DataTable({
    ajax:    '/admin/checkuser/load_list_reg',
    dataSrc:  data,
    columns: [
        {title: "ID",               data: 'id'},
        {title: "Họ và tên",        data: 'name_user'},
        // {title: "Ngày sinh",        data: 'birth_user'},
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

function load_list_school(id){
    $.ajax({
        type: "get",
        url: 'checkuser/load_list_school/'+id,
        success: function (res) {
            if(res[0].fail == 0){
                var html = "";
                for(let i = 0; i<res.length ; i++){
                    html += '<tr class = "select_ed select_ed'+res[i].id_data+'" id-data = "'+res[i].id_data+'" id_school_check = "'+res[i].id_school_check+'">'
                        html +=  '<td><input id-data = "'+res[i].id_data+'" style = "width:100%;border:none;height: 28px;text-align:center;background-color:inherit" class = "class_check" id="class_check" value ="'+res[i].class+'"></td>'
                        html +=  '<td><select style = "width:100%" class = "province_check province_check_null" id-data = "'+res[i].id_data+'">'
                        for(let j = 0;j<res[i].provinces.length;j++)
                        {
                            html +=  '<option value = "'+res[i].provinces[j].id+'"'+res[i].provinces[j].selected+'>'+res[i].provinces[j].name_province+'</option>'
                        }
                        html +='</select></td>'

                        html +=  '<td><select style = "width:100%;background-color:inherit" class = "school_check_null school_check school_check'+res[i].id_data+'" id-data = "'+res[i].id_data+'" >'
                        for(let j = 0;j<res[i].school.length;j++)
                        {
                            html +=  '<option value = "'+res[i].school[j].id+'" '+res[i].school[j].selected+'>'+res[i].school[j].name_school+'</option>'
                        }
                        html +='</select></td>'
                        html +=  '<td><input class = "time_area_check time_area_check_null time_area_check_sum'+res[i].id_data+'" style = "width:100%;border:none;height: 28px;text-align:center;background-color:inherit" value ="'+res[i].time_area+'"></td>'
                        html +=  '<td><input class = "time_area_check'+res[i].id_data+'" disabled style = "width:100%;border:none;height: 28px;text-align:center;background-color:inherit" value ="'+res[i].id_priority_area+'"></td>'
                    html += '</tr>';
                }
            }else{
                var html = "<td style = 'color: #007bff ' colspan = '5'>Không tim thấy Trường của thí sinh</td>";
                $('#area_check').text('');
            }
            $('#load_list_school').html(html)

            setTimeout(() => {
                $('.province_check').select2();
                $('.province_check').next().find('.select2-selection').css('border', 'none')
                $('.province_check').next().find('.select2-selection').css('background-color', 'inherit')
                $('.school_check').select2();
                $('.school_check').next().find('.select2-selection').css('border', 'none')
                $('.school_check').next().find('.select2-selection').css('background-color', 'inherit')
            }, 0);
        }
    });
}




//Load Khu vực ưu tiên sau khi lưu Trường THPT
function load_area_check(id){
    $.ajax({
        type: "get",
        url: "checkuser/load_area_check/"+id,
        success: function (res) {
            $('#area_check').text(res)
        }
    });
}




function history(id){
    $('#remove_load_list_history').empty();
    $('#remove_load_list_history').append('<table class="table table-bordered table-hover"  id = "load_list_history"></table>');
    var table = $('#load_list_history').DataTable( {
        ajax: {
            type: "get",
            url: 'checkuser/load_list_history/'+id,
        },

        columnDefs: [
            { width: "3%", targets: 0 },
            { width: "15%", targets: 1 },
            { width: "20%", targets: 2 },
            { width: "47%", targets: 3 },
            { width: "15%", targets: 4 }
            ],
        // dom: 'frtip',
        columns: [
            {
                title: 'STT',
                data: 'stt',
            },
            {
                title: 'Nhân viên',
                data: 'name',
            },
            {
                title: "Chức năng",
                data: 'name_history',
            },

            {
                title: "Nội dung",
                data: 'content',
            },

            {
                title: "Thời gian",
                data: 'update_at',
            },
        ],

        scrollY: 530,
        "language": {
            "emptyTable": "Không có thao tác",
            "info": " _START_ / _END_ trên _TOTAL_ thao tác",
            "paginate": {
                "first":      "Trang đầu",
                "last":       "Trang cuối",
                "next":       "Trang sau",
                "previous":   "Trang trước"
            },
            "search":         "Tìm kiếm:",
            "loadingRecords": "Đang tìm kiếm ... ",
            "lengthMenu":     "Hiện thị _MENU_ thao tác",
            "infoEmpty":      "",
            },
        "retrieve": true,
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": true,
        "responsive": false,
        // "select": true,
    })
}

