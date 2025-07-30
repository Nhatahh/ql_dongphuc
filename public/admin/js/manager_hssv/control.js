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



    // $('#investigate_table').hide()

    // $('#year_check').select2();
    $('#file_hssv_batch').select2();
    $('#file_hssv_user').select2();



    $('#major_investigate').select2();
    $('#check_investigate_seen').select2();
    $('#check_investigate_onl').select2();
    $('#check_investigate_off').select2();
    $('#check_investigate_go').select2();

    load_search()

    //Tìm kiếm
    $('#file_hssv_search').on('click',function(){
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


    $('#investigate_excel').on('click',function(){
        var type = "xlsx"
        var id_batch = $('#batch_investigate').val()
        var data = document.getElementById('investigate_table');
        var excelFile = XLSX.utils.table_to_book(data, {sheet: "sheet1"});
        XLSX.write(excelFile, { bookType: type, bookSST: true, type: 'base64' });
        XLSX.writeFile(excelFile, 'ThongKetXacNhanNhapHoc'+id_batch+'.'+ type);
    })

});


//Load tìm kiếm
function load_search(){
    $.ajax({
        url: "/admin/file_hssv/load_search",
        type:'get',
        dataType: 'json',
        success:function(data){
            $('#file_hssv_batch').html('').select2({
                data: data.batch
            });
            $('#file_hssv_user').html('').select2({
                data: data.user
            });
        }
    })
}

function file_hssv_excel(){
    var batch = $('#file_hssv_batch').val();
    var end = $('#endday_file_hssv').val();
    var start = $('#startday_file_hssv').val()
    var user = $('#file_hssv_user').val()
    start == '' ? start = 0:start = start;
    end == '' ? end = 0:end = end;
    window.location.href = "https://congmotcua.ctuet.edu.vn/admin/file_hssv/file_hssv_excel"+'/'+batch+'/'+start+'/'+end+'/'+user
    // window.location.href = "https://xettuyentest.ctuet.edu.vn/admin/file_hssv/file_hssv_excel"+'/'+batch+'/'+start+'/'+end+'/'+user
}

//Kết quả tìm kiếm
function result(){
    $('#file_hssv_modal').show()
    $('#file_hssv_list_remove').empty();
    var batch = $('#file_hssv_batch').val();
    var end = $('#endday_file_hssv').val();
    var start = $('#startday_file_hssv').val()
    var user = $('#file_hssv_user').val()
    start == '' ? start = 0:start = start;
    end == '' ? end = 0:end = end;
    if(batch == 0){
        toastr.warning("Chọn đợt tuyển sinh")
    }else{
        $.ajax({
            url: "/admin/file_hssv/file_hssv_list/"+batch+"/"+start+"/"+end+"/"+user,
            type:'get',
            dataType: 'json',
            success:function(data){
                $('#file_hssv_modal').hide()
                if(data == -1){
                    toastr.warning("Chọn ngày bắt đầu và ngày kết thúc")
                }else{
                    if(data.length == 0){
                        toastr.warning("Không có thí sinh")
                    }else{
                        var id_check = 0;
                        var keys = Object.keys(data[0])
                        var html = '<table class="table table-bordered table-hover table-striped" style = "width: 100%;font-size:13px" id = "file_hssv_list">'
                        html += '<thead><tr>'
                            html +='<th>#</th>'
                            for(let i = 0; i<keys.length;i++){
                                html +='<th>'+keys[i]+'</th>'
                            }
                            html +='<th>Khóa</th>'
                        html += '</tr></thead>'
                        html += '<tbody>'

                        for(let i = 0; i<data.length;i++){
                            html +='<tr>'
                                html +='<td>'+(i+1)+'</td>'
                                for(let j = 0; j<keys.length;j++){
                                    html +='<td>'+data[i][keys[j]]+'</td>'
                                }
                                if(id_check == 1 ){
                                    html +='<td><i style = "color:#007bff" class="fa-solid fa-user-check"></i></td>'
                                }else{
                                    html +='<td><i style = "color:red" class="fa-solid fa-user-check"></i></td>'
                                }
                            html +='</tr>'
                        }
                        html += '</tbody>'
                        html += '</table>'
                        $('#file_hssv_list_remove').append(html);
                        $('#file_hssv_list').DataTable({
                            scrollY: 380,
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


            }
        })
    }
}


