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

    //LOAD DANH SACH NHAN VIEN

    // $('#search_ass').on('click',function(e){
    //     e.preventDefault();
    //     load_search_ass()
    //    // table.ajax.reload();
    // })

    $('#clear_ass').on('click',function(e){
        $('#name_ass').val('')
        $('#email_ass').val('')
    })

    load_search_ass()
})

    //Load tìm kiếm
    function load_search_ass(){
        $('#remove_load_list_ass').empty();
        $('#remove_load_list_ass').append('<table class="table table-hover text-nowrap"  id = "load_list_ass"></table>');
        var table = $('#load_list_ass').DataTable( {
            ajax: {
                type: "get",
                url: 'assignment/load_list_ass',
                data:
                {
                    name: $('#name_ass').val(),
                    email: $('#email_ass').val(),
                },
            },
            columns: [
                {title: "ID",               data: 'id'},
                {title: "Họ và tên",        data: 'name'},
                {title: "Điện thoại",       data: 'phone'},
                {title: "Email",            data: 'email'},
                {
                    title: "Trạng thái",
                    data: 'active',
                    render: function(data){
                        // return '<i onclick = "view_check('+data+')" style = "color:#007bff" class="fas fa-check"></i>'
                        var data = data.split('-')
                        if(data[1] == 1){
                            return '<small class="badge badge-primary user_ac_ass'+data[0]+'"><i class="far fa-clock"></i> Đã phân công</small>'
                        }else{
                            return '<small class="badge badge-warning user_ac_ass'+data[0]+'"><i class="far fa-clock"></i> Chưa phân công</small>'
                        }
                    }
                },

                {
                    title: "",
                    data: 'active',
                    render: function(data){
                        // return '<i onclick = "view_check('+data+')" style = "color:#007bff" class="fas fa-check"></i>'
                        var data = data.split('-')
                        if(data[1] == 0){
                            var style = 'red'
                        }else{
                            var style = '#007bff'
                        }
                        return '<i onclick = "user_ass('+data[0]+','+data[1]+')" style = "color: '+style+'" class="fas fa-check user_ass'+data[0]+'"></i>'
                    }
                },
                {
                    title: "",
                    data: 'active',
                    render: function(data){
                        // return '<i onclick = "view_check('+data+')" style = "color:#007bff" class="fas fa-check"></i>'
                        var data = data.split('-')
                        if(data[1] == 0){
                            var style = 'red'
                        }else{
                            var style = '#007bff'
                        }
                        return ''
                    }
                },
            ],

            "language": {
                "emptyTable": "Không tìm thấy nhân viên",
                "info": " _START_ / _END_ trên _TOTAL_ nhân viên",
                "paginate": {
                    "first":      "Trang đầu",
                    "last":       "Trang cuối",
                    "next":       "Trang sau",
                    "previous":   "Trang trước"
                },
                "search":         "Tìm kiếm:",
                "loadingRecords": "Đang tìm kiếm ... ",
                "lengthMenu":     "Hiện thị _MENU_ nhân viên",
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

    //Phân công nhân viên kiểm tra hồ sơ
    function user_ass(id,active){
        $('.user_ass'+id).hide();
        $.ajax({
            type: "post",
            url: 'assignment/add_user_ass',
            data: {

                id:id,
                active: active,

            },
        }).done(function(res){
            if(res == 1){
                $.ajax({
                    type: "get",
                    url: 'assignment/load_user_ass/'+id,
                    success: function (res) {
                        toastr.success("Đã cập nhật")
                        $('.user_ass'+id).attr('onclick','user_ass('+id+','+res+')')
                        setTimeout(() => {
                            $('.user_ass'+id).show();
                            if(res == 1){
                                $('.user_ac_ass'+id).removeClass('badge-warning')
                                $('.user_ac_ass'+id).addClass('badge-primary');
                                $('.user_ac_ass'+id).html('<i class="far fa-clock"></i> Đã phân công');
                                $('.user_ass'+id).css('color','#007bff')
                            }else{
                                $('.user_ass'+id).css('color','red')
                                $('.user_ac_ass'+id).addClass('badge-warning')
                                $('.user_ac_ass'+id).removeClass('badge-primary');
                                $('.user_ac_ass'+id).html('<i class="far fa-clock"></i> Chưa phân công');
                            }
                        }, 50);
                    }
                });
            }else{
                if(res == 2){
                    $('.user_ass'+id).show();
                    toastr.warning("Nhân viên đã được phân công kiểm tra hồ sơ thí sinh, không hủy được")
                }else{
                    toastr.warning("Có lỗi, vui lòng load lại, hoặc nhấn Ctrl F5")
                    $('.user_ass'+id).show();
                }

            }

            // load_search_ass();


        })
    }
