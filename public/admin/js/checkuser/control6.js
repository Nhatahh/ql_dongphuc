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

    // const a = [1,2,3 ];
    // localStorage.setItem('data',a);

    // if (typeof(Storage) !== "undefined") {
    //     toastr.warning("Trình duyệt có hộ trợ chức năng cả hệ thống")
    // } else {
    //     toastr.warning("Trình duyêt không hỗ trợ một số chức năng của hệ thống. Vui lòng cập nhật Trình duyệt mới nhát")
    // }

    // $('#faceback_content').summernote()
    $('#img_check').hide();
    // $('#modal_check').hide();
    $('#year_check').select2();
    $('#batch_check').select2();
    $('#school_check').select2();
    $('#province_check').select2();
    $('#active_check').select2();
    $('#plicy_check').select2();
    $('#id_place_user_check').select2();
    $('#nation_user_check').select2();
    $('#id_khttprovince_user_check').select2();
    $('#id_khttprovince_user2_check').select2();
    $('#id_khttprovince_user3_check').select2();



    const swiper = new Swiper('.swiper', {

        // zoom: true,

        zoom: {
            maxRatio: 3,
            minRatio: 1
          },

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

    //Điểm
    $('#method_mark_check').select2();

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

    //Change Tỉnh - Trường
    $(document).on('change','.province_check',function(){
        change_province_school($(this).val(),$(this).attr('id-data'))
    })

    //Change Trường - Khu vực
    $(document).on('change','.school_check',function(){
        change_school_area($(this).val(),$(this).attr('id-data'))
    })

    //Thêm Trường THPT
    $('#add_school_check').on('click',function(){
        add_school_check()
    })

    //Click Trường --> Slect
    $(document).on('click','.select_ed',function(){
        $('.select_ed').removeClass('select_background')
        $(this).addClass('select_background')
        $('#clear_school_check').attr('id-data', $(this).attr('id-data'))
    })


    //Xoa Trường
    $('#clear_school_check').on('click',function(){
        $(this).attr('disabled','true');
        $('.select_ed'+$(this).attr('id-data')).remove();
        $(this).removeAttr('disabled');
    })

    //Reset thông tin
    $('#reset_school_check').on('click',function(){
        load_list_school($('#id_user_check1').attr('id-data'))
    })

    //Save Trường THPT
    $('#save_school_check').on('click',function(){
        save_list_school($('#id_user_check1').attr('id-data'))
    })



                        //ĐỐI TƯỢNG ƯU TIÊN
    //Change Đối tượng thay đổi THông tin
    $('#plicy_check').on('change',function(){
        change_policy_check($(this).val(),$('#id_user_check1').attr('id-data'))
    })

    //Lưu Đối tượng ưu tiên
    $('#save_policy_check').on('click',function(){
        setTimeout(() => {
            $(this).attr('disabled','true');
        }, 0);

        setTimeout(() => {
            save_policy_check($('#plicy_check').val(),$('#id_user_check1').attr('id-data'))
        }, 100);
    })

     //Reset Đối tượng ưu tiên
     $('#reset_policy_check').on('click',function(){
        load_policy_check($('#id_user_check1').attr('id-data'))
    })

                        //THÔNG TIN CÁ NHÂN
    //Change HKTT Tỉnh
    $('#id_khttprovince_user_check').on('change',function(){
        var id = $(this).val()
        $.ajax({
            type: "post",
            url: "checkuser/change_hktt_province_check/"+id,
            success: function (res) {
                $(id_khttprovince_user2_check).html('').select2({
                    data: res
                })
                $(id_khttprovince_user3_check).html('').select2()
            }
        });

    })

    //Change HKTT Huyện
    $('#id_khttprovince_user2_check').on('change',function(){
        var id = $(this).val()
        $.ajax({
            type: "post",
            url: "checkuser/change_hktt_province2_check/"+id,
            success: function (res) {
                $(id_khttprovince_user3_check).html('').select2({
                    data: res
                })
            }
        });

    })

    //Lưu thông tin cá nhân
    $('#add_info_check').on('click',function(){
        $('#add_info_check').attr('disabled','true')
        if($('#male_user_check').prop('checked') == true){
            var sex = 0;
        }else{
            var sex = 1;
        }
        var check_old_sex = sex+"0";
        if($('#male_user_check').attr('old-data') == check_old_sex && $('#name_user_check').val() == $('#name_user_check').attr('old-data') && $('#birth_user_check').val() == $('#birth_user_check').attr('old-data') && $('#id_place_user_check').val() == $('#id_place_user_check').attr('old-data') && $('#nation_user_check').val() == $('#nation_user_check').attr('old-data') && $('#emailsc_user_check').val() == $('#emailsc_user_check').attr('old-data') && $('#phonesc_user_check').val() == $('#phonesc_user_check').attr('old-data')&& $('#address_user_check').val() == $('#address_user_check').attr('old-data') && $('#id_khttprovince_user_check').val() == $('#id_khttprovince_user_check').attr('old-data') && $('#id_khttprovince_user2_check').val() == $('#id_khttprovince_user2_check').attr('old-data') && $('#id_khttprovince_user3_check').val() == $('#id_khttprovince_user3_check').attr('old-data') && $('#graduation_year_user_check').val() == $('#graduation_year_user_check').attr('old-data')){
            toastr.warning("Không có dữ liệu mới")
            $('#add_info_check').removeAttr('disabled')
        }else{
            $.ajax({
                type: "post",
                url: "checkuser/add_info_check",
                data:
                {
                    id_user: $('#id_user_check1').attr('id-data'),
                    name_user: $('#name_user_check').val(),
                    birth_user: $('#birth_user_check').val(),
                    id_place_user: $('#id_place_user_check').val(),
                    id_nation_user: $('#nation_user_check').val(),
                    sex_user: sex,
                    emailsc_user: $('#emailsc_user_check').val(),
                    phonesc_user: $('#phonesc_user_check').val(),
                    address_user: $('#address_user_check').val(),
                    id_khttprovince_user: $('#id_khttprovince_user_check').val(),
                    id_khttprovince2_user: $('#id_khttprovince_user2_check').val(),
                    id_khttprovince3_user: $('#id_khttprovince_user3_check').val(),
                    graduation_year_user: $('#graduation_year_user_check').val(),
                },
                // dataType: 'json',
                success: function (res) {
                    load_wish_check($('#id_user_check1').attr('id-data'))
                    $('#add_info_check').removeAttr('disabled')
                    if(res == 1){
                        load_list_info($('#id_user_check1').attr('id-data'))
                        toastr.success("Cập nhật thành công")
                    }else{
                        if(res == 3){
                            load_list_info($('#id_user_check1').attr('id-data'))
                            toastr.warning("Hồ sơ đã được khóa, vui lòng mở khóa")
                        }else{
                            toastr.warning("Cập nhật bị lỗi, xem lại dữ liệu nhập vào hoặc liên hệ admin")
                        }
                    }
                }
            });
        }
    })


                        //NGUYỆN VỌNG
    //Change Phương thức



});

//Kết quả tìm kiếm
function result(){
    $('#remove_load_list_reg').empty();
    $('#remove_load_list_reg').append('<table class="table table-hover text-nowrap"  id = "load_list_reg"></table>');
    var year = $('#year_check').val();
    var batch = $('#batch_check').val();
    var active = $('#active_check').val();
    // var province = $('#province_check').val();
    // var school = $('#school_check').val();
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
                    // data = [year,batch,active,province,school,id_card,phone,id_user]
                    break;
                case 2:
                    // data = [year,batch,active,province,school,id_card,phone,id_user]
                    break;
                case 3:
                    data = [year,batch,active,id_card,phone,id_user]
                    // data = [year,batch,active,province,school,id_card,phone,id_user]
                    var table = $('#load_list_reg').DataTable({
                        ajax: {
                            type: "get",
                            url: 'checkuser/load_list_reg',
                            data:
                            {
                                data: data
                            },
                        },
                        scrollY: 450,
                        columns: [
                            {title: "ID",               data: 'id'},
                            {title: "Họ và tên",        data: 'name_user'},
                            // {title: "Ngày sinh",        data: 'birth_user'},
                            {title: "Điện thoại",       data: 'phone_users'},
                            {title: "Email",            data: 'email_users'},
                            {title: "CMND/TCC",         data: 'id_card_users'},
                            // {title: "Năm TS",           data: 'course'},
                            {title: "Đợt tuyển sinh",   data: 'name_batch'},
                            // {title: "Tỉnh",             data: 'name_province'},
                            // {title: "Trường",       data: 'name_school'},

                            {
                                title: "Kiểm tra",
                                data: 'check_user',
                                render: function(data){
                                    if(data == 1){
                                        return '<small class="badge badge-warning"><i class="fa fa-unlock"></i>&nbsp;Chưa khóa</small>'
                                    }else{
                                        if(data == 2){
                                            return '<small class="badge badge-success"><i class="fa fa-undo"></i>&nbsp;Phản hồi</small>'
                                        }else{
                                            if(data == 3){
                                                return '<small class="badge badge-primary"><i class="fa fa-lock"></i>&nbsp;Đã khóa</small>'
                                            }else{
                                                if(data == 4){
                                                    return '<small class="badge badge-secondary"><i class="fa fa-registered"></i>&nbsp;Đã đăng ký lại</small>'
                                                }else{
                                                    if(data == 5){
                                                        return '<small class="badge badge-info"><i class="fa fa-bell"></i>&nbsp;Yêu cầu chỉnh sửa</small>'
                                                    }else{
                                                        return '<small class="badge badge-warning"><i class="fa fa-unlock"></i>&nbsp;Chưa khóa</small>'
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            },


                            {
                                title: "Kiểm Duyệt",
                                data: 'pass',
                                render: function(data){
                                    if(data == 1){
                                        return '<span><small class="badge badge-primary"><i class="fa fa-check"></i>&nbsp;Đã duyệt</small></span>'
                                    }else{
                                        return '<span><small class="badge badge-warning"><i class="fa fa-times"></i>&nbsp;Chưa duyệt</small></span>'
                                    }
                                }
                            },

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

function load_view(id){
    load_list_info(id)
    load_list_school(id)
    // loadslider_info_check(id)
    load_policy_check(id)
    method_mark_check(id);
    load_mark_check(id)
    loadslider_mark_check(id)
    load_wish_check(id)
    history(id)
    load_area_check(id)
}

function view_check(id){
    $('#faceback_content').val() == "";
    $('#id_user_check1').text(id);
    $('#id_user_check1').attr('id-data',id);
    $('#modal_check').show('slow');
    setTimeout(() => {
        load_view(id)
    }, 200);

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

//Change Tỉnh_Trường
function change_province_school(id_province,id){
    $.ajax({
        type: "get",
        url: 'checkuser/change_province_school/'+id_province,
        success: function (res) {
            var html ="";
                for(let i = 0;i<res.length;i++)
                {
                    html +=  '<option  '+res[i].selected+' value = "'+res[i].id+'">'+res[i].name_school+'</option>'
                }
            $('.school_check'+id).html(html)
            $('.time_area_check'+id).val('')
            // $('#area_check').text("")
        }
    });
}


//Change Trường_Khu vực
function change_school_area(id_school,id){
    $.ajax({
        type: "get",
        url: 'checkuser/change_school_area/'+id_school,
        success: function (res) {
            $('.time_area_check'+id).val(res[0].id_priority_area)
            // $('#area_check').text("")
        }
    });
}

//Thêm Trường
function add_school_check(){
    var schools = document.getElementsByClassName('province_check')
    if(schools.length >27){
        toastr.warning("Khổng thể mỗi tháng học 1 trường")
    }else{
        $.ajax({
            type: "get",
            url: 'checkuser/load_province',
            success: function (res){
                var school_new = document.getElementsByClassName('school_new')
                if(school_new.length > 0){
                    var num = -school_new.length -1
                }else{
                    var num = -1
                }
                var province ="";
                province +=  '<select style = "width:100%" class = "province_check province_check_null" id-data = "'+num+'">'
                for(let i = 0;i<res.length;i++)
                {
                    province +=  '<option '+res[i].selected+' value = "'+res[i].id+'">'+res[i].name_province+'</option>'
                }
                province +='</select>'
                var html = '<tr class="school_new select_ed select_ed'+num+'" id-data = "'+num+'" id_school_check = "0">';
                    html += '<td><input  id-data = "'+num+'" style = "width:100%;border:none;height: 28px;text-align:center;background-color:inherit" id= "class_check" class = "class_check" id-data = "'+num+'" value ="0"></td>'
                    html += '<td>'+province+'</td>';
                    html += '<td><select style = "width:100%;" class = "school_check_null school_check school_check'+num+'" id-data = "'+num+'"><option>Chọn Trường THPT</option></select></td>'
                    html += '<td><input class = "time_area_check time_area_check_null time_area_check_sum'+num+'" style = "width:100%;border:none;height: 28px;text-align:center;background-color:inherit" id-data = "'+num+'" value ="0"></td>'
                    html += '<td><input class = "time_area_check'+num+'" id-data = "'+num+'" disabled style = "width:100%;border:none;height: 28px;text-align:center;background-color:inherit" value =""></td>'
                html += "</tr>";
                $('#load_list_school').append(html)
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

}

//Save Trường THPT
function save_list_school(){
    //Check lớp
    var _class = document.getElementsByClassName('class_check');
    var class_check = "";
    var reg = /^\d+$/;
    for(let i = 0; i <_class.length ;i++){
        if(reg.test($(_class[0]).val()) == true){
            if($(_class[i]).val()< 10 ||  $(_class[i]).val() > 12){
                class_check = false;
            }else{
                class_check = true;
            }
        }else{
            class_check = false;
        }
    }
    var a = []
    for(let i = 0; i <_class.length ;i++){
        a[i] = $(_class[i]).val();
    }
    var full_class = [...new Set(a)];
    if(full_class.length == 3){
        class_full_check = true;
    }else{
        class_full_check = false;
    }

    var sum10 = 0;
    var sum11 = 0;
    var sum12 = 0;
    for(let j = 0; j <_class.length ;j++){
        if($(_class[j]).val() == 10){
            sum10 = sum10 + Number($('.time_area_check_sum'+$(_class[j]).attr('id-data')).val())
        }
        if($(_class[j]).val() == 11){
            sum11 = sum11 + Number($('.time_area_check_sum'+$(_class[j]).attr('id-data')).val())
        }
        if($(_class[j]).val()== 12){
            sum12 = sum12 + Number($('.time_area_check_sum'+$(_class[j]).attr('id-data')).val())
        }
    }
    if(sum10 == 9 && sum11 == 9 && sum11 == 9){
        class_time_check = true;
    }else{
        class_time_check = false;
    }

    var province_check_null = document.getElementsByClassName('province_check_null');
    var province_check = "";
    for(let i = 0; i < province_check_null.length ;i++){
        if(Number($(province_check_null[i]).val()) == 0){
            province_check = false;
        }else{
            province_check = true;
        }
    }


    var school_check_null = document.getElementsByClassName('school_check_null');
    var school_check = "";
    for(let i = 0; i < school_check_null.length ;i++){
        if(Number($(school_check_null[i]).val()) == 0){
            school_check = false;
        }else{
            school_check = true;
        }
    }


    var time_area_check_null = document.getElementsByClassName('time_area_check_null');
    var time_area_check = "";
    for(let i = 0; i < time_area_check_null.length ;i++){
        if(reg.test($(time_area_check_null[i]).val()) == true){
            if(Number($(time_area_check_null[i]).val()) > 0){
                time_area_check = true;
            }else{
                time_area_check = false;
            }
        }else{
            time_area_check = false;
        }
    }

    if(class_check == false){
        toastr.warning("Nhập Lớp không đúng")
    }else{
        if(province_check ==  false){
            toastr.warning("Nhập Tỉnh/Thành phố")
        }else{
            if(school_check == false){
                toastr.warning("Nhập Trường THPT")
            }else{
                if(time_area_check == false){
                    toastr.warning("Thời gian chưa đúng định dạng")
                }else{
                    if(class_full_check == false){
                        toastr.warning("Điền đầy đủ lớp 10, 11, 12")
                    }else{
                        if(class_time_check == false){
                            toastr.warning("Tổng thời gian học của mỗi năm phải bằng 9")
                        }else{
                            $('#save_school_check').attr('disabled','true');
                            var select_ed = document.getElementsByClassName('select_ed')
                            var data = []
                            var id_school_check = 0;
                            for(let i = 0; i< select_ed.length; i++){
                                data[i] = [$(select_ed[i]).find('#class_check').val(),$(select_ed[i]).find('.province_check').val(),$(select_ed[i]).find('.school_check').val(),$(select_ed[i]).find('.time_area_check').val(),$('#id_user_check1').attr('id-data'),$(select_ed[i]).attr('id-data'),]
                                if($(select_ed[i]).attr('id_school_check') == $(select_ed[i]).find('#class_check').val()+"_"+$(select_ed[i]).find('.province_check').val()+"_"+$(select_ed[i]).find('.school_check').val()+"_"+$(select_ed[i]).find('.time_area_check').val()+"_"+$('#id_user_check1').attr('id-data')){
                                    id_school_check++
                                }
                            }
                            if(id_school_check == data.length){
                                toastr.warning("Không có dữ liệu mới")
                                $('#save_school_check').removeAttr('disabled')
                            }else{
                                $.ajax({
                                    type: "post",
                                    url: "checkuser/save_list_school",
                                    data:
                                    {
                                        data: data
                                    },
                                    success: function (res) {
                                        $('#save_school_check').removeAttr('disabled')
                                        if(res == 'true'){
                                            toastr.success("Cập nhật thành công")
                                            load_list_school($('#id_user_check1').attr('id-data'))
                                            load_area_check($('#id_user_check1').attr('id-data'))
                                            load_wish_check($('#id_user_check1').attr('id-data'))
                                            load_list_info($('#id_user_check1').attr('id-data'))
                                            load_wish_check( $('#id_user_check1').attr('id-data'))
                                        }else{
                                            if(res == 3){
                                                toastr.warning("Hồ sơ đã được khóa, Vui lòng mở khóa")
                                            }else{
                                                toastr.warning("Có thể dữ liệu nhập vào không đúng yêu cầu. Kiểm tra lại lần nữa! Hoặc liên hệ admin")
                                            }

                                        }
                                    }
                                });
                            }
                        }
                    }
                }
            }
        }
    }
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


                    //ĐỐI TƯỢNG ƯU TIÊN
//Load đối tượng ưu tiên
function load_policy_check(id){
    $.ajax({
        type: "get",
        url: "checkuser/load_policy_check/"+id,
        success: function (res){
            $('#plicy_check').html('').select2({
                data: res.policy
            })
            $('#info_plicy_check').text(res.note_policy)
            $('#file_plicy_check').html(res.list_policy)
        }
    });
}

//Change Đối tượng ưu tiên
function change_policy_check(id,id_user){
    if(id == 0){
        $('#info_plicy_check').text('')
        $('#file_plicy_check').text('')
    }else{
        $.ajax({
            type: "post",
            url: "checkuser/change_policy_check",
            data: {
                id: id,
                id_user: id_user,
            },
            success: function (res){
                $('#info_plicy_check').text(res.note_policy)
                $('#file_plicy_check').html(res.file_policy)
            }
        });
    }
}

//Chon file
function file_policy_check(id){
    var a = Math.floor(Math.random() * (999999- 111111) ) + 111111
    $("#img_check").click()
    $("#img_check").on('change',function(){
        var type = this.files[0].type
        if(type == 'image/png' || type == 'image/pjpeg' || type == 'image/jpeg'){
            var reader = new FileReader();
            reader.onload = function (event) {
                src = event.target.result
                $(".img_check"+id).attr("data",src)
                $(".img_check"+id).css("color",'#007bff')
                $(".img_check"+id).attr("id_check_1",a)
            }
            reader.readAsDataURL(this.files[0]);
        }else{
            toastr.warning("Vui lòng chọn file ảnh")
        }
    })
}

//Lưu đối tượng ưu tiên
function save_policy_check(id,id_user){
    img_check = document.getElementsByClassName('img_check')
    if(id == 0){
        $.ajax({
            type: "post",
            url: "checkuser/save_policy_check",
            data: {
                id: id,
                id_user: id_user,
            },
            success: function (res){
                alert(res)
                if(res == true){
                    toastr.success("Cập nhật thành công")
                }else{
                    if(res == 3){
                        toastr.warning("Hồ sơ đã được khóa, vui lòng mở khóa")
                    }else{
                        toastr.warning("Cập nhật thất bại, liên hệ admin")
                    }
                }
                load_policy_check(id_user)
                $("#save_policy_check").removeAttr('disabled');
                loadslider_mark_check(id_user)
                load_wish_check(id_user)
            }
        })
    }else{
        if(img_check.length > 0){
            var dem = 0;
            for(let i = 0; i<img_check.length;i++){
                if($(img_check[i]).attr('id_check') == $(img_check[i]).attr('id_check_1')){
                    dem++;
                }
            }
            var data = [];
            var check = 0;
            for(let i = 0; i<img_check.length;i++){
                if($(img_check[i]).attr('id_check_1') != 0){
                    data[i] = [$(img_check[i]).attr('data'),$(img_check[i]).attr('id-data'),$(img_check[i]).attr('id_check_1')]
                    check++;
                }
            }
            if(check != img_check.length){
                toastr.warning("Chưa upload minh chứng")
                $("#save_policy_check").removeAttr('disabled');
            }else{
                if(dem == img_check.length ){
                    toastr.warning("Không có dữ liệu mới")
                    $("#save_policy_check").removeAttr('disabled');
                }else{
                    $.ajax({
                        type: "post",
                        url: "checkuser/save_policy_check",
                        data: {
                            id: id,
                            id_user: id_user,
                            data: data,
                        },
                        success: function (res){
                            if(res == 1){
                                    toastr.success("Cập nhật thành công")
                            }else{
                                if(res == 3){
                                    toastr.warning("Hồ sơ đã được khóa, vui lòng mở khóa")
                                }else{
                                    if(res == 0){
                                        toastr.warning("Không có dữ liệu mới")
                                    }else{
                                        toastr.warning("Cập nhật thất bại, liên hệ admin")
                                    }
                                }
                            }
                            $("#save_policy_check").removeAttr('disabled');
                            load_policy_check(id_user)
                            loadslider_mark_check(id_user)
                            load_wish_check(id_user)
                        }
                    });
                }

            }
        }else{
            toastr.warning("Vui lòng chọn đối tượng ưu tiên")
        }
    }

}


                //THÔNG TIN CÁ NHÂN

//Load Thông tin cá nhân
function load_list_info(id){
    $.ajax({
        type: "get",
        url: 'checkuser/load_list_info/'+id,
        dataType: "json",
        success: function (res) {
            $('#name_user_check1').text(res.info[0].name_user)
            $('#emailsc_user_check1').text(res.info[0].email_users)
            $('#phonesc_user_check1').text(res.info[0].phone_users)
            $('#id_card_users_check1').text(res.info[0].id_card_users)


            $('#userimg_check').attr('src',res.info[0].link_img_user)

            $('#name_user_check').val(res.info[0].name_user)
            $('#name_user_check').attr('old-data',res.info[0].name_user)


            $('#birth_user_check').val(res.info[0].birth_user)
            $('#birth_user_check').attr('old-data',res.info[0].birth_user)

            $('#emailsc_user_check').val(res.info[0].emailsc_user)
            $('#emailsc_user_check').attr('old-data',res.info[0].emailsc_user)


            $('#phonesc_user_check').val(res.info[0].phonesc_user)
            $('#phonesc_user_check').attr('old-data',res.info[0].phonesc_user)


            $('#graduation_year_user_check').val(res.info[0].graduation_year_user)
            $('#graduation_year_user_check').attr('old-data',res.info[0].graduation_year_user)


            $('#address_user_check').val(res.info[0].address_user)
            $('#address_user_check').attr('old-data',res.info[0].address_user)

            if(res.info[0].sex_user == 1){
                $('#female_user_check').prop('checked','true')
                $('#female_user_check').attr('old-data',"10")
                $('#male_user_check').attr('old-data',"10")
            }else{
                $('#male_user_check').prop('checked','true')
                $('#male_user_check').attr('old-data',"00")
                $('#female_user_check').attr('old-data',"00")
            }

            $('#id_place_user_check').html('').select2({
                data: res.birth_provine
            });

            res.birth_provine.forEach(e => {
                if(e.selected == true)
                $('#id_place_user_check').attr('old-data',e.id)
            });

            $('#nation_user_check').html('').select2({
                data: res.nation
            });

            res.nation.forEach(e => {
                if(e.selected == true)
                $('#nation_user_check').attr('old-data',e.id)
            });


            $('#id_khttprovince_user_check').html('').select2({
                data: res.province
            });

            res.province.forEach(e => {
                if(e.selected == true)
                $('#id_khttprovince_user_check').attr('old-data',e.id)
            });

            $('#id_khttprovince_user2_check').html('').select2({
                data: res.province2
            });

            res.province2.forEach(e => {
                if(e.selected == true)
                $('#id_khttprovince_user2_check').attr('old-data',e.id)
            });

            $('#id_khttprovince_user3_check').html('').select2({
                data: res.province3
            });
            res.province3.forEach(e => {
                if(e.selected == true)
                $('#id_khttprovince_user3_check').attr('old-data',e.id)
            });

            $('#area_check').text(res.info[0].name_priority_area)
            $('#id_card_users_check').val(res.info[0].id_card_users)
            $('#email_users_check').val(res.info[0].email_users)
            $('#phone_users_check').val(res.info[0].phone_users)
            load_policy_check(id);
        }
    });
}

                //ĐIỂM THÍ SINH
//Load phương thức xét tuyển
function method_mark_check(){
    $.ajax({
        type: "get",
        url: "checkuser/method_mark_check/",
        success: function (res) {
            $('#method_mark_check').html('').select2(
                {
                    data: res.method
                }
            );
        }
    });
}

//Load điểm theo phương thức xét tuyển
function load_mark_check(id){
    $.ajax({
        type: "get",
        url: "checkuser/load_mark_check/"+id,
        // dataType: "dataType",
        success: function (res) {
            var mark =[]
            if(res.active_hb == 1){
                for(let i = 0; i<res.subject.length; i++){
                    for(let j =0; j<res.mark_10hk1.length;j++){
                        if(res.subject[i].id == res.mark_10hk1[j].id_subject){
                            var diem_10hk1= res.mark_10hk1[j].mark_result
                            var id_10hk1 = res.mark_10hk1[j].id
                        }
                    }
                    for(let j =0; j<res.mark_10hk1.length;j++){
                        if(res.subject[i].id == res.mark_10hk2[j].id_subject){
                            var diem_10hk2 = res.mark_10hk2[j].mark_result
                            var id_10hk2 = res.mark_10hk2[j].id
                        }
                    }
                    for(let j =0; j<res.mark_10hkcn.length;j++){
                        if(res.subject[i].id == res.mark_10hkcn[j].id_subject){
                            var diem_10hkcn = res.mark_10hkcn[j].mark_result
                            var id_10hkcn = res.mark_10hkcn[j].id
                        }
                    }
                    for(let j =0; j<res.mark_11hk1.length;j++){
                        if(res.subject[i].id == res.mark_11hk1[j].id_subject){
                            var diem_11hk1= res.mark_11hk1[j].mark_result
                            var id_11hk1 = res.mark_11hk1[j].id
                        }
                    }
                    for(let j =0; j<res.mark_11hk1.length;j++){
                        if(res.subject[i].id == res.mark_11hk2[j].id_subject){
                            var diem_11hk2 = res.mark_11hk2[j].mark_result
                            var id_11hk2 = res.mark_11hk2[j].id
                        }
                    }
                    for(let j =0; j<res.mark_11hkcn.length;j++){
                        if(res.subject[i].id == res.mark_11hkcn[j].id_subject){
                            var diem_11hkcn = res.mark_11hkcn[j].mark_result
                            var id_11hkcn   = res.mark_11hkcn[j].id
                        }
                    }

                    for(let j =0; j<res.mark_12hk1.length;j++){
                        if(res.subject[i].id == res.mark_12hk1[j].id_subject){
                            var diem_12hk1= res.mark_12hk1[j].mark_result
                            var id_12hk1  = res.mark_12hk1[j].id
                        }
                    }
                    for(let j =0; j<res.mark_12hk1.length;j++){
                        if(res.subject[i].id == res.mark_12hk2[j].id_subject){
                            var diem_12hk2 = res.mark_12hk2[j].mark_result
                            var id_12hk2  = res.mark_12hk2[j].id
                        }
                    }
                    for(let j =0; j<res.mark_12hkcn.length;j++){
                        if(res.subject[i].id == res.mark_12hkcn[j].id_subject){
                            var diem_12hkcn = res.mark_12hkcn[j].mark_result
                            var id_12hkcn  = res.mark_12hkcn[j].id
                        }
                    }
                    mark[i] = [res.subject[i].name_subject,diem_10hk1,id_10hk1,diem_10hk2,id_10hk2,diem_10hkcn,id_10hkcn,diem_11hk1,id_11hk1,diem_11hk2,id_11hk2,diem_11hkcn,id_11hkcn,diem_12hk1,id_12hk1,diem_12hk2,id_12hk2,diem_12hkcn,id_12hkcn]
                }
            }else{
                for(let i = 0; i<res.subject.length; i++){
                    mark[i] = [res.subject[i].name_subject,"",0,"",0,"",0,"",0,"",0,"",0,"",0,"",0,"",0]
                }
            }

            if(res.active_nl == 1){
                var mark_nl = res.mark_nl[0].mark_result
                var id_nl = res.mark_nl[0].id
            }else{
                var mark_nl = ""
                var id_nl = "0"
            }
            var html = '<div class="row">'
                html += '<div class="col-12 col-md-12">'
                    html += '<div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Điểm học bạ THPT</div>'
                    html += '<div class="card-body" style="padding-top: 5px;padding-bottom: 5px">'
                        html += '<table class="table table-hover text-nowrap" style = "width:100%">'
                            html +="<thead>"
                                html +="<tr>"
                                    html += "<th></th>"
                                    html += "<th colspan = '3'>Lớp 10</th>"
                                    html += "<th colspan = '3'>Lớp 11</th>"
                                    html += "<th colspan = '3'>Lớp 12</th>"
                                html +="</tr>"
                                html +="<tr>"
                                    html += "<th rowspan = '2'>Môn</th>"
                                    html += "<th>HK1</th>"
                                    html += "<th>HK2</th>"
                                    html += "<th>CN</th>"
                                    html += "<th>HK1</th>"
                                    html += "<th>HK2</th>"
                                    html += "<th>CN</th>"
                                    html += "<th>HK1</th>"
                                    html += "<th>HK2</th>"
                                    html += "<th>CN</th>"
                                html +="</tr>"
                            html +="</thead>"
                            html +="<tbody>"
                                for(let i = 0; i<mark.length; i++){
                                    html +="<tr>"
                                        html +="<td>"+mark[i][0]+"</td>"
                                        html +="<td ><input style = 'width:100%;border:none;height: 28px;text-align:center;background-color:inherit' id='"+mark[i][2]+"' class= 'edit_mark"+mark[i][2]+"' onchange = 'edit_mark("+mark[i][2]+")' value = '"+mark[i][1]+"'></td>"
                                        html +="<td ><input style = 'width:100%;border:none;height: 28px;text-align:center;background-color:inherit' id='"+mark[i][4]+"' class= 'edit_mark"+mark[i][4]+"' onchange = 'edit_mark("+mark[i][4]+")' value = '"+mark[i][3]+"'></td>"
                                        html +="<td ><input style = 'width:100%;border:none;height: 28px;text-align:center;background-color:inherit' id='"+mark[i][6]+"' class= 'edit_mark"+mark[i][6]+"' onchange = 'edit_mark("+mark[i][6]+")' value = '"+mark[i][5]+"'></td>"
                                        html +="<td ><input style = 'width:100%;border:none;height: 28px;text-align:center;background-color:inherit' id='"+mark[i][8]+"' class= 'edit_mark"+mark[i][8]+"' onchange = 'edit_mark("+mark[i][8]+")' value = '"+mark[i][7]+"'></td>"
                                        html +="<td ><input style = 'width:100%;border:none;height: 28px;text-align:center;background-color:inherit' id='"+mark[i][10]+"' class= 'edit_mark"+mark[i][10]+"' onchange = 'edit_mark("+mark[i][10]+")' value = '"+mark[i][9]+"'></td>"
                                        html +="<td ><input style = 'width:100%;border:none;height: 28px;text-align:center;background-color:inherit' id='"+mark[i][12]+"' class= 'edit_mark"+mark[i][12]+"' onchange = 'edit_mark("+mark[i][12]+")' value = '"+mark[i][11]+"'></td>"
                                        html +="<td ><input style = 'width:100%;border:none;height: 28px;text-align:center;background-color:inherit' id='"+mark[i][14]+"' class= 'edit_mark"+mark[i][14]+"' onchange = 'edit_mark("+mark[i][14]+")' value = '"+mark[i][13]+"'></td>"
                                        html +="<td ><input style = 'width:100%;border:none;height: 28px;text-align:center;background-color:inherit' id='"+mark[i][16]+"' class= 'edit_mark"+mark[i][16]+"' onchange = 'edit_mark("+mark[i][16]+")' value = '"+mark[i][15]+"'></td>"
                                        html +="<td ><input style = 'width:100%;border:none;height: 28px;text-align:center;background-color:inherit' id='"+mark[i][18]+"' class= 'edit_mark"+mark[i][18]+"' onchange = 'edit_mark("+mark[i][18]+")' value = '"+mark[i][17]+"'></td>"
                                    html +="</tr>"
                                }
                            html +="</tbody>"
                        html +="</table>"
                    html += '</div>'
                html += '</div>'
                html += '<div class="col-12 col-md-12">'
                    html += '<div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Điểm Đánh giá năng lực</div>'
                    html += '<div class="card-body" style="padding-top: 5px;padding-bottom: 5px">'
                        html += '<table>'
                            html +="<tr>"
                                html +="<td>"+res.subject_nl+"</td>"
                                html +="<td colspan ='9' ><input style = 'width:100%;border:none;height: 28px;text-align:center;background-color:inherit' id='"+id_nl+"' class= 'edit_mark"+id_nl+"' onchange = 'edit_mark("+id_nl+")' value = '"+mark_nl+"'></td>"
                            html +="</tr>"
                        html += '</table>'
                    html += '</div>'
                html += '</div>'
                html += '<div class="col-12 col-md-12">'
                    html += '<div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Điểm thi Tốt nghiệp THPT</div>'
                    html += '<div class="card-body" style="padding-top: 5px;padding-bottom: 5px">'


                    html += '</div>'
                html += '</div>'
            html += '</div>'
            $('#mark_check').html(html)
        }
    });
}

// Load minh chứng điểm
function loadslider_mark_check(id){
    $.ajax({
        type: "get",
        url: "checkuser/loadslider_mark_check",
        data:
        {
            data: id
        },
        success: function (res) {
            $('.swiper-wrapper').html(res)
        }
    });
}

//Cập nhật điểm
function edit_mark(id){
    var myRe = /^[+-]?((\d+(\.\d*)?)|(\.\d+))$/;
    var diem = $('.edit_mark'+id).val()
    if(myRe.test(diem) == false){
        toastr.warning('Nhập điểm đúng đúng định dạng thập phân là dấu chấm ".", điểm phải từ 0 đến 10')
    }else{
        $.ajax({
            type: "post",
            url: "checkuser/edit_mark_check",
            data: {
                mark: diem,
                id: id,
                id_student: $('#id_user_check1').attr('id-data')
            },
            success: function (res) {
                load_wish_check($('#id_user_check1').attr('id-data'))
                load_mark_check($('#id_user_check1').attr('id-data'));
                if(res == 1){
                    toastr.success("Cập nhật thành công");
                }else{
                    if(res == 3){
                        toastr.warning("Hồ sơ đã được khóa, vui lòng mở khóa")
                    }else{
                        toastr.warning("Cập nhập thất bại")
                    }
                }
            }
        });
    }
}

                //NGUYỆN VONG
//Load nguyện vọng
function load_wish_check(id){
     $.ajax({
        type: "get",
        url: "checkuser/load_wish_check/"+id,
        success: function (res) {
            if(res.fail == 1){
                var html = "<p style = 'color:red'>"+res.info+'</p>'
            }else{
                var html = '<div class = "row">'
                    html += '<div class="col-12 col-md-12">'
                        html += '<table class="table table-hover text-nowrap" style = "width:100%">'
                            html +="<thead>"
                                html +="<tr>"
                                    html += "<th >Thứ tự</th>"
                                    html += "<th >Phương thức</th>"
                                    html += "<th >Nguyện vọng</th>"
                                    html += "<th >Ngưỡng</th>"
                                    html += "<th >Tổ hợp</th>"
                                    html += "<th >Điểm tổ hợp</th>"
                                    html += "<th >Ưu tiên</th>"
                                    html += "<th >Điểm xét tuyển</th>"
                                html +="</tr>"
                            html +="</thead>"
                            html +="<tbody>"
                                for(let i = 0; i<res.info.length; i++){
                                    html +='<tr id-data = "'+res.info[i].id+'" class = "check_old" id-check ="'+res.info[i].id+'x'+res.info[i].number+'x'+res.info[i].id_method_id+'x'+res.info[i].id_major+'x'+res.info[i].id_group+'x'+res.info[i].group_mark+'x'+res.info[i].priority_mark+'x'+res.info[i].mark+'">'
                                        html +='<td><input style = "width:100%;border:none;height: 28px;text-align:center;background-color:inherit" class = "number_mark_check" id = "number_mark_check'+res.info[i].id+'" id-data = "'+res.info[i].id+'" value = "'+res.info[i].number+'"></td>'
                                        html +=  '<td><select style = "width:100%" id = "sl_method_wish_check'+res.info[i].id+'" onchange = "change_method_wish_check('+res.info[i].id+')" class = "sl_method_wish_check" id-data = "'+res.info[i].id+'">'
                                        for(let j = 0;j<res.info[i].sl_method.length;j++)
                                        {
                                            html +=  '<option value = "'+res.info[i].sl_method[j].id+'"'+res.info[i].sl_method[j].selected+'>'+res.info[i].sl_method[j].text+'</option>'
                                        }
                                        html +='</select></td>'
                                        html +=  '<td><select style = "width:100%" class = "sl_major_wish_check" onchange = "change_major_wish_check('+res.info[i].id+')" id = "sl_major_wish_check'+res.info[i].id+'" id-data = "'+res.info[i].id+'">'
                                        for(let j = 0;j<res.info[i].sl_major.length;j++)
                                        {
                                            html +=  '<option value = "'+res.info[i].sl_major[j].id+'"'+res.info[i].sl_major[j].selected+'>'+res.info[i].sl_major[j].text+'</option>'
                                        }
                                        html +='</select></td>'
                                        html +='<td ><input style = "width:100%;border:none;height: 28px;text-align:center;background-color:inherit" class = "min_mark_check" id = "min_mark_check'+res.info[i].id+'" id-data = "'+res.info[i].id+'" value = "'+res.info[i].min_mark+'" disabled></td>'
                                        html +=  '<td><select style = "width:100%" class = "sl_group_wish_check" onchange = "change_group_wish_check('+res.info[i].id+')" id = "sl_group_wish_check'+res.info[i].id+'" id-data = "'+res.info[i].id+'">'
                                        for(let j = 0;j<res.info[i].sl_group.length;j++)
                                        {
                                            html +=  '<option value = "'+res.info[i].sl_group[j].id+'"'+res.info[i].sl_group[j].selected+'>'+res.info[i].sl_group[j].text+'</option>'
                                        }
                                        html +='</select></td>'
                                        html +='<td ><input style = "width:100%;border:none;height: 28px;text-align:center;background-color:inherit" class = "group_mark_check" id = "group_mark_check'+res.info[i].id+'" id-data = "'+res.info[i].id+'" value = "'+res.info[i].group_mark+'" disabled></td>'
                                        html +='<td ><input style = "width:100%;border:none;height: 28px;text-align:center;background-color:inherit" class = "area_mark_check" id = "area_mark_check'+res.info[i].id+'" id-data = "'+res.info[i].id+'" value = "'+res.info[i].priority_mark+'" disabled></td>'
                                        html +='<td ><input style = "width:100%;border:none;height: 28px;text-align:center;background-color:inherit" class = "total_mark_check" id = "total_mark_check'+res.info[i].id+'" id-data = "'+res.info[i].id+'" value = "'+res.info[i].mark+'" disabled></td>'
                                    html +="</tr>"
                                }
                            html +="</tbody>"
                        html +="</table>"
                    html += '</div>'

                    // html += '<div class="col-12 col-md-2">'
                    // html += '</div>'

                    html += '<div class="col-12 col-md-2">'
                        html +='<button type="button" id="" class="btn btn-block btn-primary btn-xs" disabled><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;Xóa</button>'
                    html += '</div>'

                    if(res.check_block == 1){
                        var disabled = 'disabled'
                    }else{
                        var disabled = ''
                    }
                    html += '<div class="col-12 col-md-2">'
                        html +='<button type="button" id="clear_wish_check" class="btn btn-block btn-primary btn-xs" '+disabled+' onclick = "clear_wish_check()"><i class="fa fa-broom" ></i>&nbsp;&nbsp;&nbsp;Reset</button>'
                    html += '</div>'

                    html += '<div class="col-12 col-md-2">'
                        html +='<button type="button" id="" class="btn btn-block btn-primary btn-xs" disabled><i class="fa fa-plus" ></i>&nbsp;&nbsp;&nbsp;Thêm</button>'
                    html += '</div>'


                    html += '<div class="col-12 col-md-2">'
                        html +='<button type="button" id="save_wish_check" class="btn btn-block btn-primary btn-xs" '+disabled+' onclick = "save_wish_check()" ><i class="fa fa-save" ></i>&nbsp;&nbsp;&nbsp;Lưu</button>'
                    html += '</div>'

                    html += '<div class="col-12 col-md-2">'
                        html +='<button type="button" id="calculator_check" class="btn btn-block btn-primary btn-xs" '+disabled+' onclick = "calculator_check()" ><i class="fa fa-calculator" ></i>&nbsp;&nbsp;&nbsp;Tính lại điểm</button>'
                    html += '</div>'

                    if(res.check_block == 1){
                        var active_block = "Mở khóa"
                    }else{
                        var active_block = "Khóa hồ sơ"
                    }
                    html += '<div class="col-12 col-md-2">'
                        html +='<button type="button" id="block_wish_check" class="btn btn-block btn-primary btn-xs" onclick = "block_wish_check('+id+','+res.user_block+')" ><i class="fa fa-key" ></i>&nbsp;&nbsp;&nbsp;'+active_block+'</button>'
                    html += '</div>'


                html += '</div>'
            }
            $('#wish_check').html(html)
            setTimeout(() => {
                $('.sl_method_wish_check').select2();
                $('.sl_method_wish_check').next().find('.select2-selection').css('border', 'none')
                $('.sl_method_wish_check').next().find('.select2-selection').css('background-color', 'inherit')

                $('.sl_major_wish_check').select2();
                $('.sl_major_wish_check').next().find('.select2-selection').css('border', 'none')
                $('.sl_major_wish_check').next().find('.select2-selection').css('background-color', 'inherit')

                $('.sl_group_wish_check').select2();
                $('.sl_group_wish_check').next().find('.select2-selection').css('border', 'none')
                $('.sl_group_wish_check').next().find('.select2-selection').css('background-color', 'inherit')
            }, 0);
        }
    });
}

//Change phương thức
function change_method_wish_check(id){
    var value = $('#sl_method_wish_check'+id).val()
    $.ajax({
        type: "get",
        url: "checkuser/change_method_wish_check/"+value,
        success: function (res) {
            var html =  '<select style = "width:100%" class = "sl_major_wish_check" id = "sl_major_wish_check'+id+'" id-data = "'+id+'">'
            for(let j = 0;j<res.majors.length;j++){
                if(res.majors[j].selected == 'selected'){
                    var selected = 'selected'
                }else{
                    var selected = ''
                }
                html +=  '<option selected = "'+selected+'" value = "'+res.majors[j].id+'">'+res.majors[j].text+'</option>'
            }
            html +='</select>'
            $('#sl_major_wish_check'+id).html(html)

            var html_group =  '<select style = "width:100%" class = "sl_group_wish_check" id = "sl_group_wish_check'+id+'" id-data = "'+id+'">'
            html_group +=  '<option value = "'+res.groups.id+'">'+res.groups.text+'</option>'
            html_group +='</select>'
            $('#sl_group_wish_check'+id).html(html_group)
            $('#min_mark_check'+id).attr('value',"")
            $('#group_mark_check'+id).attr('value',"")
            $('#area_mark_check'+id).attr('value',"")
            $('#total_mark_check'+id).attr('value',"")
        }
    });
}

//Change Ngành
function change_major_wish_check(id){
    var value = $('#sl_major_wish_check'+id).val()
    if(value == 0){
        var html =  '<select style = "width:100%" class = "sl_group_wish_check" id = "sl_group_wish_check'+id+'" id-data = "'+id+'">'
        html +=  '<option selected = "selected" value = "0">Chọn tổ hợp</option>'
        html +='</select>'
        $('#sl_group_wish_check'+id).html(html)
        $('#min_mark_check'+id).attr('value',"")
        $('#group_mark_check'+id).attr('value',"")
        $('#area_mark_check'+id).attr('value',"")
        $('#total_mark_check'+id).attr('value',"")
    }else{
        $.ajax({
            type: "get",
            url: "checkuser/change_major_wish_check/"+value,
            success: function (res) {
                var html =  '<select style = "width:100%" class = "sl_group_wish_check" id = "sl_group_wish_check'+id+'" id-data = "'+id+'">'
                for(let j = 0;j<res.groups.length;j++){
                    if(res.groups[j].selected == 'selected'){
                        var selected = 'selected'
                    }else{
                        var selected = ''
                    }
                    html +=  '<option selected = "'+selected+'" value = "'+res.groups[j].id+'">'+res.groups[j].text+'</option>'
                }
                html +='</select>'
                $('#sl_group_wish_check'+id).html(html)
                $('#min_mark_check'+id).attr('value',res.min_mark)
                $('#group_mark_check'+id).attr('value',"")
                $('#area_mark_check'+id).attr('value',"")
                $('#total_mark_check'+id).attr('value',"")
                }
            });
        }
    }

//Change Tổ hợp
function change_group_wish_check(id){
    var value = $('#sl_group_wish_check'+id).val()
    if(value == 0){
        $('#group_mark_check'+id).attr('value',"")
        $('#area_mark_check'+id).attr('value',"")
        $('#total_mark_check'+id).attr('value',"")
    }else{
        $.ajax({
            type: "post",
            url: "checkuser/change_group_wish_check",
            data:{
                value: value,
                id_method: $('#sl_method_wish_check'+id).val(),
                id_user:   $('#id_user_check1').attr('id-data'),
            },
            success: function (res) {
                $('#group_mark_check'+id).attr('value',res.group_mark)
                $('#area_mark_check'+id).attr('value',res.priotity_mark)
                $('#total_mark_check'+id).attr('value',res.total_mark)
            }
        });
    }
}

//Save ngueyeenmj vọng
function save_wish_check(){
    var number_mark_check = document.getElementsByClassName('number_mark_check')
    var fail = 0;
    var arr_check = []

    var arr_lientuc = []
    var arr_number = [];
    var dem_number_mark_check = 0;
    for(let i = 0;i<number_mark_check.length; i++){
        arr_lientuc[i] = i+1;
        arr_number[i] = Number($(number_mark_check[i]).val())
        if($(number_mark_check[i]).val() == 0 || $(number_mark_check[i]).val()== ''){
            dem_number_mark_check ++;
            break;
        }
    }


    if(dem_number_mark_check >0){
        arr_check[fail] = 'Nguyện vọng không được trống; ' ;
        fail++;
    }else{
        if(JSON.stringify(arr_number.sort(function(a, b){return a - b})) === JSON.stringify(arr_lientuc)){
           let khongbietlamgi = 0;
        }else{
            arr_check[fail] = 'Nguyện vọng phải liên tiếp và bắt đầu tư 1' ;
            fail++;
        }
    }

    var major = [];
    var sl_major_wish_check = document.getElementsByClassName('sl_major_wish_check')
    var dem_sl_major_wish_check = 0;
    for(let i = 0;i<sl_major_wish_check.length; i++){
        let id = $(sl_major_wish_check[i]).attr('id-data')
        major[i] = [$(sl_major_wish_check[i]).val(),$('#sl_method_wish_check'+id).val()]
        if($(sl_major_wish_check[i]).val() == 0){
            dem_sl_major_wish_check ++;
            break;
        }
    }

    if(dem_sl_major_wish_check >0){
        arr_check[fail] = 'Chưa chọn nguyện vọng xét tuyển; ' ;
        fail++;
    }else{
        var check_double = 0;
        for(let i = 0; i<(major.length)/2;i++){
            for(let j = i+1;j<major.length;j++){
                if(JSON.stringify(major[i]) === JSON.stringify(major[j])){
                    check_double ++;
                    break;
                }
            }
        }
    }

    if(check_double >0){
        arr_check[fail] = 'Nguyện vọng bị trùng; ' ;
        fail++;
    }

    var min_mark_check = document.getElementsByClassName('min_mark_check')
    var dem_min_mark_check = 0;
    for(let i = 0;i<min_mark_check.length; i++){
        if($(min_mark_check[i]).val() == ''){
            dem_min_mark_check ++;
            break;
        }
    }

    if(dem_min_mark_check >0){
        arr_check[fail] = 'Có lỗi load ngưỡng đầu vào; ' ;
        fail++;
    }

    var sl_group_wish_check = document.getElementsByClassName('sl_group_wish_check')
    var dem_sl_group_wish_check = 0;
    for(let i = 0;i<sl_group_wish_check.length; i++){
        if($(sl_group_wish_check[i]).val() == 0){
            dem_sl_group_wish_check ++;
            break;
        }
    }

    if(dem_sl_group_wish_check >0){
        arr_check[fail] = 'Chọn tổ hợp xét tuyển; ' ;
        fail++;
    }

    var group_mark_check = document.getElementsByClassName('group_mark_check')
    var dem_group_mark_check = 0;
    for(let i = 0;i<group_mark_check.length; i++){
        if($(group_mark_check[i]).val() == 0 || $(group_mark_check[i]).val() == ''){
            dem_group_mark_check ++;
            break;
        }
    }

    if(dem_group_mark_check >0){
        arr_check[fail] = 'Lỗi tính điểm tổ hợp; ' ;
        fail++;
    }

    var area_mark_check = document.getElementsByClassName('area_mark_check')
    var dem_area_mark_check = 0;
    for(let i = 0;i<area_mark_check.length; i++){
        if($(area_mark_check[i]).val() == ''){
            dem_area_mark_check ++;
            break;
        }
    }

    if(dem_area_mark_check >0){
        arr_check[fail] = 'Lỗi tính điểm ưu tiên; ' ;
        fail++;
    }

 var total_mark_check = document.getElementsByClassName('total_mark_check')
    var dem_total_mark_check = 0;
    for(let i = 0;i<total_mark_check.length; i++){
        if($(total_mark_check[i]).val() == '' || $(total_mark_check[i]).val() == 0){
            dem_total_mark_check ++;
            break;
        }
    }

    if(dem_total_mark_check >0){
        arr_check[fail] = 'Lỗi tính điểm xét tuyển; ' ;
        fail++;
    }

    if(fail == 0){
        setTimeout(() => {
            $('#save_wish_check').attr('disabled','true');
        }, 0);

        setTimeout(() => {
            var wish_check = document.getElementsByClassName('check_old')
            var dem = 0;
            var data=[];
            for(let i = 0; i<wish_check.length; i++){
                var id_user =  $('#id_user_check1').attr('id-data');
                var id = $(wish_check[i]).attr('id-data')
                var number = $('#number_mark_check'+id).val();
                var method = $('#sl_method_wish_check'+id).val();
                var major = $('#sl_major_wish_check'+id).val();
                var group = $('#sl_group_wish_check'+id).val();
                var group_mark = $('#group_mark_check'+id).val();
                var area_mark = $('#area_mark_check'+id).val();
                var total_mark = $('#total_mark_check'+id).val();
                var check_new = id+'x'+number+'x'+method+'x'+major+'x'+group+'x'+group_mark+'x'+area_mark+'x'+total_mark
                if($(wish_check[i]).attr('id-check') ==  check_new){
                    dem++;
                }
                data[i] = [id_user,id,number,method,major,group,group_mark,area_mark,total_mark,check_new]
            }
            if(dem == wish_check.length){
                toastr.warning("Không có dữ liệu mới")
                $('#save_wish_check').removeAttr('disabled');
            }else{
                $.ajax({
                    type: "post",
                    url: "checkuser/save_wish_check",
                    data: {
                        data: data
                    },
                    success: function (res) {
                        if(res == 1){
                            toastr.success("Cập nhật thành công")
                        }else{
                            toastr.warning("Hệ thống bị lỗi, vui lòng thử lại hoặc liên hệ admin")
                        }
                        load_wish_check(id_user)
                        $('#save_wish_check').removeAttr('disabled');
                    }
                });
            }
        }, 1);
    }else{
        toastr.warning(arr_check[0])
    }


}

//Clear cập nhật
function clear_wish_check(){
    load_wish_check( $('#id_user_check1').attr('id-data'))
}


function block_wish_check(id,active_block){
    $.ajax({
        type: "post",
        url: "checkuser/block_wish_check/"+id+'/'+active_block,
        success: function (res) {
            if(res == 1){
                toastr.success("Đã mở khóa hồ sơ")
            }else{
                if(res == 0){
                    toastr.success("Đã khóa hồ sơ")
                }else{
                    if(res == 3){
                        toastr.warning("Hồ sơ đã được duyệt, Vui lòng Hủy duyệt")
                    }else{
                        toastr.warning("Có lỗi hệ thống, vui lòng nhấn Ctrl F5")
                    }
                }
            }
            load_wish_check(id)
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

function faceback_check_user(){
    $('#faceback_check_user').attr('disabled','true')
    $('#modal_loadding_check_user').show();
    if( $('#faceback_content').val() == ""){
        toastr.warning("Nhập nội dung mail cần gửi cho thí sinh")
        $('#faceback_check_user').removeAttr('disabled')
        $('#modal_loadding_check_user').hide();
    }else{
        $.ajax({
            url: "checkuser/faceback_check_user",
            type:'post',
            data:{
                id_student: $('#id_user_check1').attr('id-data'),
                content: $('#faceback_content').val()
            },
            success:function(data){
                $('#faceback_check_user').removeAttr('disabled')
                $('#modal_loadding_check_user').hide();
                if(data == 1){
                    toastr.success("Đã gửi thành công")
                }else{
                    if(data == 3){
                        toastr.warning("Hồ sơ đã khóa,vui lòng mở khóa")
                    }else{
                        toastr.warning("Gửi không thành công, vui lòng nhấn Ctrl F5")
                    }
                }
            }
        })
    }
}

function calculator_check(){

    $('#modal_loadding_check_user').show();
    $('#calculator_check').attr('disabled','true');
    $.ajax({
        type: "post",
        url: "checkuser/calculator_check",
        data:{
            id_student:  $('#id_user_check1').attr('id-data'),
        },
        success: function (res) {
            if(res == 1){
                toastr.success("Tính lại điểm thành công")
            }else{
                if(res == 2){
                    toastr.warning("Hồ sơ đã khóa, vui lòng mở khóa")
                }else{
                    toastr.success("Tính lại điểm thất bại, Vui lòng nhấn Ctrl F5")
                }
            }
            $('#calculator_check').removeAttr('disabled');
            $('#modal_loadding_check_user').hide();
            load_wish_check($('#id_user_check1').attr('id-data'))
        }
    });
}
