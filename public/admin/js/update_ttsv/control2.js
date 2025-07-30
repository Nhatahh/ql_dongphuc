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

    $(document).keydown(function(event) {
        if (event.keyCode == 27) {
          $('#update_ttsv_img').hide();
        }
    });

    $('#id_batch_temp').hide();
    $('#cmnd_temp').hide()

    $('#update_id_batch_search').select2();
    $('#ttsv_sex_user').select2();
    $('#ttsv_id_nation_user').select2();
    $('#ttsv_id_religion').select2();
    $('#ttsv_id_nationality').select2();
    $('#ttsv_id_place_card').select2();

    $('#ttsv_id_place_user').select2();
    $('#ttsv_noisinh_huyen').select2();
    $('#ttsv_noisinh_xa').select2();

    $('#ttsv_id_khttprovince_user').select2();
    $('#ttsv_id_khttprovince2_user').select2();
    $('#ttsv_id_khttprovince3_user').select2();

    $('#ttsv_quequan_tinh').select2();
    $('#ttsv_quequan_huyen').select2();
    $('#ttsv_quequan_xa').select2();
    $('#ttsv_id_khuyettat').select2();
    
    $('#update_ttsv_search').on('click',function(){
        var cmnd = $('#update_id_card_user_search').val();
        var batch = $('#update_id_batch_search').val();
        if(cmnd == "" || batch == 0){
            toastr.warning("Chọn đợt tuyển sinh và CMND/CCCD")
        }else{
            $('#id_batch_temp').val(batch);
            $('#cmnd_temp').val(cmnd);
    
            ttsv_load_list_file(batch,cmnd)
            update_ttsv_load(batch,cmnd)
        }
    })

   
 
    // $('#ttsv_submit').on('submit',function(){
    //     alert(1111111111)
    // });
    update_ttsv_load_batch()
    $('#ttsv_submit').on('submit',function(event){
        event.preventDefault();       
        var cmnd = $('#update_id_card_user_search').val();
        var batch = $('#update_id_batch_search').val();
        if(cmnd == "" || batch == 0){
            toastr.warning("Chọn đợt tuyển sinh và CMND/CCCD")
        }else{
            if($('#id_batch_temp').val() == '' || $('#cmnd_temp').val()==''){
                toastr.warning("Chưa chọn tìm kiếm thí sinh")
            }else{
                $('#loadding_ttsv').show()
                $.ajax({
                    url: "/admin/update_ttsv/ttsv_submit",
                    type:"POST",
                    data: new FormData(this),
                    contentType:false,
                    processData:false,
                    success:function(data){
                        $('#loadding_ttsv').hide()
                        switch (data) {
                            case '0':
                                toastr.warning("Hệ thống bị lỗi, vui lòng liên hệ admin")
                                break;
                            case '1':
                                toastr.success("Cập nhật thành công!")
                                update_ttsv_load(batch,cmnd)
                                break;
                            case '2':
                                toastr.success("Không tồn tại thí sinh!")
                                break;
                            case '3':
                                toastr.success("Hệ thống bị lỗi, 1 thí sinh nhiều tài khoản trong 1 đợt tuyển sinh!")
                                break;
                            case '4':
                                toastr.success("Dữ liệu đã lưu trước! Không có dữ liệu mới!")
                                break;
                            default:
                                break;
                        }                        
                    }
                })
            }
        }
    })


    $('#ttsv_file_clear').on('click',function(){
        var cmnd = $('#update_id_card_user_search').val();
        var batch = $('#update_id_batch_search').val();
    
        var cmnd1 = $('#cmnd_temp').val();
        var batch2 = $('#id_batch_temp').val();
        if(cmnd==cmnd1 && batch == batch2){
            ttsv_load_list_file(batch,cmnd)
        }else{
            $('#update_id_card_user_search').val('')
            $('#update_id_batch_search').val('')
            $('#cmnd_temp').val('')
            $('#cmnd_temp').val();
        }
    })


    $('#ttsv_file_save').on('click',function(){
        var cmnd = $('#update_id_card_user_search').val();
        var batch = $('#update_id_batch_search').val();
    
        var cmnd1 = $('#cmnd_temp').val();
        var batch2 = $('#id_batch_temp').val();
        if(cmnd==cmnd1 && batch == batch2){
            var file_hs_ts = document.getElementsByClassName('file_hs_ts')
            var checked_new = []
            var j = 0;
            for(let i = 0;i < file_hs_ts.length; i++){
                if($(file_hs_ts[i]).prop('checked') == true){
                    var a = 1
                } else {
                    var a = 0
                }
        
                if(a == $(file_hs_ts[i]).attr('old_data')){
                    j++
                    var id_new = 0;
                }else{
                    var id_new = 1;
                }
                checked_new[i] = [$(file_hs_ts[i]).attr('id'),a,id_new]
            }
            if(file_hs_ts.length == j){
                toastr.warning('Không có dữ liệu mới')      
            }else{
                if(file_hs_ts.length < j){
                    toastr.warning('Hệ thống có thể bị lỗi, nhấn Crlt F5 hoặc liên hệ admin')
                }else{
                    $('#loadding_ttsv').show()
                    $('#ttsv_file_save').attr('disabled','true')
                    $.ajax({
                        type: "post",
                        url: "/admin/update_ttsv/ttsv_file_save",
                        data:{
                            data: checked_new,
                            batch:batch,
                            cmnd:cmnd,
                        },
                        success: function (res) {
                            $('#ttsv_file_save').removeAttr('disabled')
                            $('#loadding_ttsv').hide()
                            ttsv_load_list_file(batch,cmnd)
                            switch (res) {
                                case '1':
                                    toastr.success('Thu hồ sơ tuyển sinh thành công')
                                    break;
                                case '2':
                                    toastr.warning('Đợt tuyển sinh chưa mở')
                                    break;
                                default:
                                    toastr.warning('Thu hồ sơ thất bại')
                                    break;
                            }
        
                        }
                    });
                }
            }
        }else{
            toastr.warning("Chưa chọn tìm kiếm cho hồ sơ này")
        }
    })
    

    $('#ttsv_id_khttprovince_user').on('change',function(){
        pronvince('l_province2','name_province2',$(this).val(),'id_province','ttsv_id_khttprovince2_user','Chọn Huyện/Quận')
        $('#ttsv_id_khttprovince3_user').html('<option value = "0">Chọn Xã/Phường</option>')
    });

    $('#ttsv_id_khttprovince2_user').on('change',function(){
        pronvince('l_province3','name_province3',$(this).val(),'id_province2','ttsv_id_khttprovince3_user','Chọn Xã/Phường')
    });

    $('#ttsv_id_place_user').on('change',function(){
        pronvince('l_province2','name_province2',$(this).val(),'id_province','ttsv_noisinh_huyen','Chọn Huyện/Quận')
        $('#ttsv_noisinh_xa').html('<option value = "0">Chọn Xã/Phường</option>')
    });

    $('#ttsv_noisinh_huyen').on('change',function(){
        pronvince('l_province3','name_province3',$(this).val(),'id_province2','ttsv_noisinh_xa','Chọn Xã/Phường')
    });


    $('#ttsv_quequan_tinh').on('change',function(){
        pronvince('l_province2','name_province2',$(this).val(),'id_province','ttsv_quequan_huyen','Chọn Huyện/Quận')
        $('#ttsv_quequan_xa').html('<option value = "0">Chọn Xã/Phường</option>')
    });

    $('#ttsv_quequan_huyen').on('change',function(){
        pronvince('l_province3','name_province3',$(this).val(),'id_province2','ttsv_quequan_xa','Chọn Xã/Phường')
    });

})

function update_ttsv_load_batch(){
    $.ajax({
        url: "/admin/update_ttsv/update_ttsv_load_batch",
        type:"get",
        success:function(data){
            $('#update_id_batch_search').html('').select2({data});
        }
    });
}


function update_ttsv_slide(){
    var cmnd = $('#update_id_card_user_search').val();
    var batch = $('#update_id_batch_search').val();
    $.ajax({
        url: "/admin/update_ttsv/update_ttsv_slide/"+batch+'/'+cmnd,
        type:"get",
        success:function(data){
            $('#update_ttsv_slide').html(data);
        }
    });
}


function update_ttsv_img_search(){
    var cmnd = $('#update_id_card_user_search').val();
    var batch = $('#update_id_batch_search').val();
    if(cmnd == "" || batch == 0){
        toastr.warning("Chọn đợt tuyển sinh và CMND/CCCD")
    }else{
        $('#update_ttsv_img').show()
        setTimeout(() => {
            update_ttsv_slide();
        }, 100);   
    }
}



function update_ttsv_load(batch,cmnd){
    $.ajax({
        url: "/admin/update_ttsv/update_ttsv_load/"+batch+'/'+cmnd,
        type:"get",
        // dataType: 'json',
        success:function(data){
            $('#ttsv_name_user').val(data.info[0].name_user)
            $('#ttsv_birth_user').val(data.info[0].birth_user)
            $('#ttsv_id_card_user').val(data.info[0].id_card_user)
            $('#ttsv_date_card').val(data.info[0].date_card)
            $('#ttsv_doan_sv').val(data.info[0].doan_sv)
            $('#ttsv_dang_sv').val(data.info[0].dang_sv)
            $('#ttsv_phone_users').val(data.info[0].phone_users)
            $('#ttsv_id_card_users').val(data.info[0].id_card_users)
            if(data.info[0].sex_user == 1){
                var html = "<option value = '0'>Nam</option><option value = '1' selected>Nữ</option>"            
            }else{
                var html = "<option value = '0' selected>Nam</option><option value = '1' >Nữ</option>"         
            }
            $('#ttsv_sex_user').html(html)
            $('#ttsv_id_nation_user').html('').select2({
                data: data.nation
            });
            $('#ttsv_id_religion').html('').select2({
                data: data.religion
            });
            $('#ttsv_id_nationality').html('').select2({
                data: data.nationality
            });
            $('#ttsv_id_place_card').html('').select2({
                data: data.province_place_card
            });
            
            $('#ttsv_id_place_user').html('').select2({
                data: data.province_noisinh_tinh
            });
            $('#ttsv_noisinh_huyen').html('').select2({
                data: data.province_noisinh_huyen
            });
            $('#ttsv_noisinh_xa').html('').select2({
                data: data.province_noisinh_xa
            });
            $('#ttsv_noisinh_cccd').val(data.info[0].noisinh_cccd)

            $('#ttsv_id_khttprovince_user').html('').select2({
                data: data.province_httttinh
            });
            $('#ttsv_id_khttprovince2_user').html('').select2({
                data: data.province_httthuyen
            });
            $('#ttsv_id_khttprovince3_user').html('').select2({
                data: data.province_htttxa
            });
            $('#ttsv_dow_province3').val(data.info[0].down_province3)

            $('#ttsv_quequan_tinh').html('').select2({
                data: data.province_quequan_tinh
            });
            $('#ttsv_quequan_huyen').html('').select2({
                data: data.province_quequan_huyen
            });
            $('#ttsv_quequan_xa').html('').select2({
                data: data.province_quequan_xa
            });
            $('#ttsv_down_quequan_xa').val(data.info[0].dow_quequan_xa)


            
            $('#ttsv_tencha_sv').val(data.info[0].tencha_sv)
            $('#ttsv_dienthoaicha_sv').val(data.info[0].dienthoaicha_sv)
            $('#ttsv_nghenghiepcha_sv').val(data.info[0].nghenghiepcha_sv)
            $('#ttsv_tenme_sv').val(data.info[0].tenme_sv)
            $('#ttsv_dienthoaime_sv').val(data.info[0].dienthoaime_sv)
            $('#ttsv_nghenghiepme_sv').val(data.info[0].nghenghiepme_sv)

            $('#ttsv_dodau_sv').val(data.info[0].dodau_sv)
            $('#ttsv_dienthoaidodau_sv').val(data.info[0].dienthoaidodau_sv)
            $('#ttsv_nghenghiepdodau_sv').val(data.info[0].nghenghiepdodau_sv)

            $('#ttsv_sothebhyt').val(data.info[0].sothebhyt)
            $('#ttsv_address_user').val(data.info[0].address_user)
            $('#ttsv_id_khuyettat').html('').select2({
                data: data.khuyettat
            });
        
        }
    });
}

function ttsv_save(){
    $('#ttsv_submit').submit();
}

function ttsv_load_list_file(batch,cmnd){   
    $.ajax({
        type: "get",
        url: "/admin/update_ttsv/ttsv_load_list_file/"+batch+"/"+cmnd,
        success: function (res) {
            if(res == 0){
                var html = "<span style = 'color:blue'>Chưa có đợt tuyển sinh</span>"
            }else{
                var html = ""
                for(let i = 0; i < res.length; i++){
                    if(res[i].checked == 1){
                        var checked = "checked"
                        var old_data = 1
                    }else{
                        var checked = ""
                        var old_data = 0
                    }
                    html += '<div class="col-12 col-md-4 col-lg-4" >'
                        html += '<div class="custom-control">'
                            html += '<input style = "height: 13px" '+checked+' class="file_hs_ts file_hs_ts'+res[i].id+'" type="checkbox" old_data = '+old_data+' id-data = "'+res[i].id+'" id="'+res[i].id+'" value="">'
                            html += '<label style = "font-weight:normal" for="'+res[i].id+'" class="" >&nbsp;&nbsp;'+res[i].name_file+'</label>'
                        html += '</div>'
                    html += '</div>'
                }
            }
            $('#ttsv_load_list_file').html(html)
            // $('#check_user_load_list_file').html(html)


        }
    });
}



function pronvince(name_table,col_table,value,col_table_value,id_select,value0){
    $('#'+id_select).html('')
    $.ajax({
        type: "post",
        url: "/admin/update_ttsv/change_selectbox",
        dataType: 'json',
        data:{
            name_table:name_table,
            col_table:col_table,
            value:value,
            col_table_value:col_table_value,
            value0: value0
        },
        success: function(data){
            $('#'+id_select).html('').select2({
                data:  data,
            })
        }
    })
}