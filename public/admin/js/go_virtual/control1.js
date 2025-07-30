$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#go_virtual_batch').select2();
    $('#go_virtual_batch_ts').select2(
        // data: [
        //     {  id: 1 , text : "Lưu nguyện vọng" },
        // ]
    );
    // $('.go_setup_method2').hide()




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

    $('#import_go_virtual_batch_ip_list_id_batch_ts').hide();
    $('#import_go_virtual_batch_ip_list_id_batch').hide();
    $('#import_go_virtual_batch_ip_list_nhom').hide();

    $('#go_virtual_batch_ip_list_bo_id_batch_ts').hide();
    $('#go_virtual_batch_ip_list_bo_id_batch').hide();
    $('#import_go_virtual_batch_ip_list_bo').hide();

    go_virtual_batch_ts();

    $('#go_virtual_batch_ts').on('change',function(){
        var  id = $(this).val()
        $('#import_go_virtual_batch_ip_list_id_batch_ts').attr('value',id);
        $('#go_virtual_batch_ip_list_bo_id_batch_ts').attr('value',id);
        $.ajax({
            type: "get",
            url: 'go_virtual/go_virtual_batch/'+id,
            success: function (res) {
                $('#go_virtual_batch').html('').select2({
                    data: res.batch
                });
            }
        })
    })

    $('#go_virtual_batch').on('change',function(){
        $('#go_virtual_search').attr('onclick','go_virtual_load('+$('#go_virtual_batch_ts').val()+','+$('#go_virtual_batch').val()+')')
        var  id = $(this).val()
        $('#import_go_virtual_batch_ip_list_id_batch').attr('value',id);
        $('#go_virtual_batch_ip_list_bo_id_batch').attr('value',id);
    })

    $('#go_number_wish').on('change',function(){
        if($('#go_batch').val() == 0 || $('#go_batch').val() == ''){
            toastr.warning('Chọn đợt xét tuyển')
            $('#go_number_wish').val('')
        }else{
            if($(this).val() == 0 || $(this).val() == ""){
                toastr.warning('Chọn thứ tự nguyện vọng xét tuyển')
            }else{
                $.ajax({
                    type: "get",
                    url: 'go/go_number_wish/'+$(this).val()+'/'+$('#go_batch').val(),
                    success: function (res) {
                        if(res == 1){
                            toastr.success('Cài đặt nguyện vọng thành công')
                            load_go($('#go_batch').val(),$('#go_active').val());
                        }else{
                            toastr.warning('Cài đặt nguyện vọng thất bại')
                        }
                    }
                })
            }
        }
    })

    $('#import_go_virtual_batch_ip_list_nhom').change(function(){
        $('#submit_go_virtual_batch_ip_list_nhom').submit();
    });


    $('#submit_go_virtual_batch_ip_list_nhom').on('submit', function(event){
        event.preventDefault();
        $('#loadding_go_virtual_mess').text('Đang upload dữ liệu ..., Có thể mất vài phút!!!')
        $('#go_virtual_batch_ip_list_nhom').attr('disabled','true')
        $('#loadding_go_virtual').show();
        if($('#import_go_virtual_batch_ip_list_nhom').val() != ''){
            $.ajax({
                url: "go_virtual/submit_go_virtual_batch_ip_list_nhom",
                type:"POST",
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data){
                    $('#go_virtual_batch_ip_list_nhom').removeAttr('disabled')
                    $('#loadding_go_virtual').hide();
                    $('#import_go_virtual_batch_ip_list_nhom').val('')
                    switch (data) {
                        case '1':
                            toastr.success("Import danh sách thành thông")
                            break;
                        case '2':
                            toastr.warning("Đợt xét tuyển chung chưa được mở")
                            break;
                        case '3':
                            toastr.warning("Đợt lọc ảo chưa được thực hiện")
                            break;
                        default:
                            toastr.warning("Import danh sách thất bại")
                            break;
                    }
                }
            });
        }
    });

    $('#import_go_virtual_batch_ip_list_bo').change(function(){
        $('#submit_go_virtual_batch_ip_list_bo').submit();
    });

    $('#submit_go_virtual_batch_ip_list_bo').on('submit', function(event){
        event.preventDefault();
        $('#loadding_go_virtual_mess').text('Đang upload dữ liệu ..., Có thể mất vài phút!!!')
        $('#go_virtual_batch_ip_list_bo').attr('disabled','true')
        $('#loadding_go_virtual').show();
        if($('#import_go_virtual_batch_ip_list_bo').val() != ''){
            $.ajax({
                url: "go_virtual/submit_go_virtual_batch_ip_list_bo",
                type:"POST",
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data){
                    $('#go_virtual_batch_ip_list_bo').removeAttr('disabled')
                    $('#loadding_go_virtual').hide();
                    $('#import_go_virtual_batch_ip_list_bo').val('')
                    switch (data) {
                        case '1':
                            toastr.success("Import danh sách thành thông")
                            break;
                        case '2':
                            toastr.warning("Đợt xét tuyển chung chưa được mở")
                            break;
                        case '3':
                            toastr.warning("Đợt lọc ảo chưa được thực hiện")
                            break;
                        default:
                            toastr.warning("Import danh sách thất bại")
                            break;
                    }
                }
            });
        }
    });


})

$(document).keydown(function(event) {
    if (event.keyCode == 27) {
      $('#loadding_go_virtual_show').hide();
    }
});

function go_virtual_batch_ts(){
    $.ajax({
        type: "get",
        url: "go_virtual/go_virtual_batch_ts",
        success: function (res) {
            $('#go_virtual_batch_ts').html('').select2({
                data: res.batch
            });
        }
    });
}

function go_virtual_load(id_batch_ts,id_batch){
    go_virtual_load_check_block();
    if($('#go_virtual_batch').val() == 0 || $('#go_virtual_batch_ts').val() == 0 ){
        toastr.warning("Chọn đợt lọc ảo!")
        $('#go_virtual_load').html('')
    }else{
        $.ajax({
            type: "get",
            url: 'go_virtual/go_virtual_load/'+id_batch_ts+'/'+id_batch,
            // dataType: 'json',
            success: function (r) {
                var html = "";
                for (let i = 0; i<r.length; i++){
                    if(i%2 == 1){
                        var active ="row_odd"
                    }else{
                        var active ="row_even"
                    }
                    html += "<tr>";
                    html += '<td style = "text-align: center">'+r[i].id+'</td>';
                    html += "<td class = 'go_virtual_show_major' id ='go_virtual_show_major'"+r[i].id+" ondblclick = 'go_virtual_show_major("+r[i].id+")'>"+r[i].name_major+"</td>";
                    html += '<td class = "min_major_1" style = "text-align: center">'+r[i].min_major+'</td>';
                    html += '<td class = "reg_all" style = "text-align: center">'+r[i].reg_all+'</td>';
                    html += '<td class = "reg_pas" style = "text-align: center">'+r[i].reg_pas+'</td>';
                    if(r[i].reg_all == 0 || r[i].reg_pas == 0){
                        var tl_ct = "";
                    }else{
                        var tl_ct = Math.round(r[i].reg_pas/r[i].min_major* 10000)/100
                    }
                    html += '<td style = "text-align: center">'+tl_ct+'</td>';
                    html += '<td class = "reg_pas_nv1" style = "text-align: center">'+r[i].reg_pas_nv1+'</td>';
                    html += '<td class = "reg_pas_nv2" style = "text-align: center">'+r[i].reg_pas_nv2+'</td>';
                    html += '<td class = "reg_pas_nv3" style = "text-align: center">'+r[i].reg_pas_nv3+'</td>';

                    //Học bạ
                    html += '<td class = "min_major_hb min_major" style = "text-align: center">'+r[i].min_major_hb+'</td>';
                    html += '<td class = "reg_tts" style = "text-align: center">'+r[i].reg_tts+'</td>';
                    html += '<td class = "reg_tts_pas" style = "text-align: center">'+r[i].reg_tts_pas+'</td>';
                    if(r[i].min_major_hb == 0 || r[i].reg_tts_pas == 0){
                        var tl_hb_tts = "";
                    }else{
                        var tl_hb_tts = Math.round(r[i].reg_tts_pas/r[i].min_major_hb* 10000)/100
                    }
                    html += '<td style = "text-align: center">'+tl_hb_tts+'</td>';
                    html += '<td class = "reg_hb_dkm" style = "text-align: center">'+r[i].reg_hb_dkm+'</td>';
                    html += '<td class = "reg_hb_dkm_mark mark_basic" style = "text-align: center" id-data = "'+r[i].id_major_hb+'" contenteditable="true">'+r[i].reg_hb_dkm_mark+'</td>';//Điểm chuẩn
                    html += '<td class = "reg_hb_dkm_pas" style = "text-align: center">'+r[i].reg_hb_dkm_pas+'</td>';
                    if(r[i].min_major_hb == 0 || r[i].reg_hb_dkm_pas == 0){
                        var tl_hb_dkm = 0;
                    }else{
                        var tl_hb_dkm = Math.round(r[i].reg_hb_dkm_pas/r[i].min_major_hb* 10000)/100
                    }
                    html += '<td style = "text-align: center">'+tl_hb_dkm+'</td>';
                    html += '<td class = "reg_hb_pas" style = "text-align: center">'+r[i].reg_hb_pas+'</td>';

                    if(r[i].min_major_hb == 0 || r[i].reg_hb_pas == 0){
                        var tl_hb = 0;
                    }else{
                        var tl_hb = Math.round(r[i].reg_hb_pas/r[i].min_major_hb* 10000)/100
                    }
                    html += '<td style = "text-align: center">'+tl_hb+'</td>';

                    //Trung học phổ thông
                    html += '<td class = "min_major_thpt" style = "text-align: center">'+r[i].min_major_thpt+'</td>';
                    html += '<td class = "reg_thpt" style = "text-align: center">'+r[i].reg_thpt+'</td>';
                    html += '<td class = "reg_thpt_mark mark_basic" style = "text-align: center" id-data = "'+r[i].id_major_thpt+'" contenteditable="true">'+r[i].reg_thpt_mark+'</td>';//Điểm chuẩn
                    html += '<td class = "reg_thpt_pas" style = "text-align: center">'+r[i].reg_thpt_pas+'</td>';
                    if(r[i].min_major_thpt == 0 || r[i].reg_thpt_pas == 0){
                        var tl_thpt = 0;
                    }else{
                        var tl_thpt = Math.round(r[i].reg_thpt_pas/r[i].min_major_thpt* 10000)/100
                    }
                    html += '<td style = "text-align: center">'+tl_thpt+'</td>';

                    //Đánh giá năng lực
                    html += '<td class = "min_major_nl" style = "text-align: center">'+r[i].min_major_nl+'</td>';
                    html += '<td class = "reg_tts_nl" style = "text-align: center">'+r[i].reg_tts_nl+'</td>';
                    html += '<td class = "reg_tts_nl_pas" style = "text-align: center">'+r[i].reg_tts_nl_pas+'</td>';
                    if(r[i].min_major_nl == 0 || r[i].reg_tts_nl_pas == 0){
                        var tl_nl_tts = "";
                    }else{
                        var tl_nl_tts = Math.round(r[i].reg_tts_nl_pas/r[i].min_major_nl* 10000)/100
                    }
                    html += '<td style = "text-align: center">'+tl_nl_tts+'</td>';
                    html += '<td class = "reg_nl_dkm" style = "text-align: center">'+r[i].reg_nl_dkm+'</td>';
                    html += '<td class = "reg_nl_dkm_mark mark_basic" style = "text-align: center"  id-data = "'+r[i].id_major_nl+'" contenteditable="true">'+r[i].reg_nl_dkm_mark+'</td>';//Điểm chuẩn
                    html += '<td class = "reg_nl_dkm_pas" style = "text-align: center">'+r[i].reg_nl_dkm_pas+'</td>';
                    if(r[i].min_major_nl == 0 || r[i].reg_nl_dkm_pas == 0){
                        var tl_nl_dkm = 0;
                    }else{
                        var tl_nl_dkm = Math.round(r[i].reg_nl_dkm_pas/r[i].min_major_nl* 10000)/100
                    }
                    html += '<td style = "text-align: center">'+tl_nl_dkm+'</td>';
                    html += '<td class = "reg_nl_pas" style = "text-align: center">'+r[i].reg_nl_pas+'</td>';
                    if(r[i].min_major_nl == 0 || r[i].reg_nl_pas == 0){
                        var tl_nl = 0;
                    }else{
                        var tl_nl = Math.round(r[i].reg_nl_pas/r[i].min_major_nl* 10000)/100
                    }
                    html += '<td style = "text-align: center">'+tl_nl+'</td>';

                    html += "</tr>";
                }
                html += "<tr>";
                    // html += '<td style = "text-align: center"></td>';
                    html += '<td colspan = "2" style = "text-align: center">Tổng</td>';
                    html += '<td class = "min_major_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td class = "reg_all_sum" style = "text-align: right;font-weight: bold"></td>';

                    html += '<td class = "reg_pas_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "tl_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td class = "reg_pas_nv1_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td class = "reg_pas_nv2_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td class = "reg_pas_nv3_sum" style = "text-align: right;font-weight: bold"></td>';
                    //Học bạ
                    html += '<td  class = "min_major_hb_sum"  style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "reg_tts_sum"  style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "reg_tts_pas_sum"  style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "tl_hb_tts_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "reg_hb_dkm_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "reg_hb_dkm_mark_sum" style = "text-align: right;font-weight: bold"></td>';//Điểm chuẩn học bạ
                    html += '<td  class = "reg_hb_dkm_pas_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "tl_hb_dkm_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "reg_hb_pas_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "tl_hb_sum" style = "text-align: right;font-weight: bold"></td>';

                    //Trung học phổ thông
                    html += '<td  class = "min_major_thpt_sum"  style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "reg_thpt_sum"  style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "reg_thpt_mark_sum"  style = "text-align: right;font-weight: bold"></td>';//Điểm chuẩn
                    html += '<td  class = "reg_thpt_pas_sum"  style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "tl_thpt_sum" style = "text-align: right;font-weight: bold"></td>';

                    //Đánh giá năng lực
                    html += '<td  class = "min_major_nl_sum"  style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "reg_tts_nl_sum"  style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "reg_tts_nl_pas_sum"  style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "tl_nl_tts_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "reg_nl_dkm_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "reg_nl_dkm_mark_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "reg_nl_dkm_pas_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "tl_nl_dkm_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "reg_nl_pas_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "tl_nl_sum" style = "text-align: right;font-weight: bold"></td>';
                html += "</tr>";

                $('#go_virtual_load').html(html)
                setTimeout(() => {

                    var min_major = document.getElementsByClassName('min_major_1')
                    $('.min_major_sum').text(sumArray(min_major))
                    var reg_all = document.getElementsByClassName('reg_all')
                    $('.reg_all_sum').text(sumArray(reg_all))
                    var reg_pas = document.getElementsByClassName('reg_pas')
                    $('.reg_pas_sum').text(sumArray(reg_pas))

                    if(sumArray(min_major) == 0 || sumArray(reg_pas) ==0){
                        var tl_sum = "";
                    }else{
                        var tl_sum = Math.round(sumArray(reg_pas)/sumArray(min_major)*10000)/100
                    }
                    $('.tl_sum').text(tl_sum)
                                        var reg_pas_nv1 = document.getElementsByClassName('reg_pas_nv1')
                    $('.reg_pas_nv1_sum').text(sumArray(reg_pas_nv1))
                    var reg_pas_nv2 = document.getElementsByClassName('reg_pas_nv2')
                    $('.reg_pas_nv2_sum').text(sumArray(reg_pas_nv2))
                    var reg_pas_nv3 = document.getElementsByClassName('reg_pas_nv3')
                    $('.reg_pas_nv3_sum').text(sumArray(reg_pas_nv3))

                    //Học bạ
                    var min_major_hb = document.getElementsByClassName('min_major_hb')
                    $('.min_major_hb_sum').text(sumArray(min_major_hb))
                    var reg_tts = document.getElementsByClassName('reg_tts')
                    $('.reg_tts_sum').text(sumArray(reg_tts))
                    var reg_tts_pas = document.getElementsByClassName('reg_tts_pas')
                    $('.reg_tts_pas_sum').text(sumArray(reg_tts_pas))

                    if(sumArray(min_major_hb) == 0 || sumArray(reg_tts_pas) ==0){
                        var tl_hb_tts_sum = "";
                    }else{
                        var tl_hb_tts_sum = Math.round(sumArray(reg_tts_pas)/sumArray(min_major_hb)*10000)/100
                    }
                    $('.tl_hb_tts_sum').text(tl_hb_tts_sum)
                    var reg_hb_dkm = document.getElementsByClassName('reg_hb_dkm')
                    $('.reg_hb_dkm_sum').text(sumArray(reg_hb_dkm))
                    var reg_hb_dkm_pas = document.getElementsByClassName('reg_hb_dkm_pas')
                    $('.reg_hb_dkm_pas_sum').text(sumArray(reg_hb_dkm_pas))
                    if(sumArray(min_major_hb) == 0 || sumArray(reg_hb_dkm_pas) == 0){
                        var tl_hb_dkm_sum = '';
                    }else{
                        var tl_hb_dkm_sum = Math.round(sumArray(reg_hb_dkm_pas)/sumArray(min_major_hb)*10000)/100
                    }
                    $('.reg_hb_dkm_pas_sum').text(tl_hb_dkm_sum)

                    var reg_hb_pas = document.getElementsByClassName('reg_hb_pas')
                    $('.reg_hb_pas_sum').text(sumArray(reg_hb_pas))
                    if(sumArray(min_major_hb) == 0 || sumArray(reg_hb_pas) ==0){
                        var tl_hb= '';
                    }else{
                        var tl_hb = Math.round(sumArray(reg_hb_pas)/sumArray(min_major_hb)*10000)/100
                    }
                    $('.tl_hb_sum').text(tl_hb)

                    //Trung học phổ thông
                    var min_major_thpt = document.getElementsByClassName('min_major_thpt')
                    $('.min_major_thpt_sum').text(sumArray(min_major_thpt))
                    var reg_thpt = document.getElementsByClassName('reg_thpt')
                    $('.reg_thpt_sum').text(sumArray(reg_thpt))
                    var reg_thpt_mark = document.getElementsByClassName('reg_thpt_mark')
                    $('.reg_thpt_mark_sum').text(sumArray(reg_thpt_mark))
                    var reg_thpt_pas = document.getElementsByClassName('reg_thpt_pas')
                    $('.reg_thpt_pas_sum').text(sumArray(reg_thpt_pas))
                    if(sumArray(min_major_thpt) == 0 || sumArray(reg_thpt_pas) ==0){
                        var tl_thpt = '';
                    }else{
                        var tl_thpt = Math.round(sumArray(reg_thpt_pas)/sumArray(min_major_thpt)*10000)/100
                    }
                    $('.tl_thpt_sum').text(tl_thpt)

                    //Đánh giá năng lực
                    var min_major_nl = document.getElementsByClassName('min_major_nl')
                    $('.min_major_nl_sum').text(sumArray(min_major_nl))
                    var reg_tts_nl = document.getElementsByClassName('reg_tts_nl')
                    $('.reg_tts_nl_sum').text(sumArray(reg_tts_nl))
                    var reg_tts_nl_pas = document.getElementsByClassName('reg_tts_nl_pas')
                    $('.reg_tts_nl_pas_sum').text(sumArray(reg_tts_nl_pas))
                    if(sumArray(min_major_nl) == 0 || sumArray(reg_tts_nl_pas) == 0){
                        var tl_nl_tts= "";
                    }else{
                        var tl_nl_tts = Math.round(sumArray(reg_tts_nl_pas)/sumArray(min_major_nl)*10000)/100
                    }
                    $('.tl_nl_tts_sum').text(tl_nl_tts)
                    var reg_nl_dkm = document.getElementsByClassName('reg_nl_dkm')
                    $('.reg_nl_dkm_sum').text(sumArray(reg_nl_dkm))

                    // var reg_nl_dkm_mark = document.getElementsByClassName('reg_nl_dkm_mark')
                    // $('.reg_nl_dkm_mark_sum').text(sumArray(reg_nl_dkm_mark))

                    var reg_nl_dkm_pas = document.getElementsByClassName('reg_nl_dkm_pas')
                    $('.reg_nl_dkm_pas_sum').text(sumArray(reg_nl_dkm_pas))
                    if(sumArray(min_major_nl) == 0 || sumArray(reg_nl_dkm_pas) == 0){
                        var tl_nl_dkm = '';
                    }else{
                        var tl_nl_dkm = Math.round(sumArray(reg_nl_dkm_pas)/sumArray(min_major_nl)*10000)/100
                    }
                    $('.tl_nl_dkm_sum').text(tl_nl_dkm)
                    var reg_nl_pas = document.getElementsByClassName('reg_nl_pas')
                    $('.reg_nl_pas_sum').text(sumArray(reg_nl_pas))
                    if(sumArray(min_major_nl) == 0 || sumArray(reg_nl_pas) ==0){
                        var tl_nl= '';
                    }else{
                        var tl_nl = Math.round(sumArray(reg_nl_pas)/sumArray(min_major_nl)*10000)/100
                    }
                    $('.tl_nl_sum').text(tl_nl)

                    // load_go_block(id_batch);
                }, 0);
            }
        });
    }

}

function sumArray(arr){
    let sum = 0;
        for(let i = 0; i<arr.length; i++){
            sum = Number($(arr[i]).text().trim()) + sum;
        }
    return sum;
}

function go_virtual_batch_pass(){
    var id_batch_ts = $('#go_virtual_batch_ts').val()
    var id_batch = $('#go_virtual_batch').val()
    if(id_batch_ts == 0 || id_batch == 0 ){
        toastr.warning("Chọn đợt lọc ảo!")
    }else{
        $('#loadding_go_virtual_mess').text('Hệ thống đang lọc ảo ..., Có thể mất vài phút!!!')
        $('#go_virtual_batch').attr('disabled','true')
        $('#loadding_go_virtual').show();
        var mark_basic = document.getElementsByClassName('mark_basic')
        var mark = [];
        for(let i = 0; i < mark_basic.length ; i++){
            mark[i] = [$(mark_basic[i]).attr('id-data'),$(mark_basic[i]).text(),id_batch_ts,id_batch]
        }
        if(mark.length >0 ){
            $.ajax({
                type: "post",
                url: 'go_virtual/go_virtual_batch_pass',
                data:{
                    data:mark,
                },
                success: function (res) {
                    $('#go_virtual_batch').removeAttr('disabled')
                    $('#loadding_go_virtual').hide();
                    go_virtual_load(id_batch_ts,id_batch)
                    switch (res) {
                        case '1':
                            toastr.success("Lọc ảo thành công!")
                            break;
                        case '0':
                            toastr.warning("Lọc ảo thất bại")
                            break;
                        case '2':
                            toastr.warning("Đợt xét tuyển chung chưa được mở")
                            break;
                        case '3':
                            toastr.warning("Có lỗi xảy ra, vui lòng load trang và thử lại")
                            break;
                        case '4':
                            toastr.warning("Đợt lọc ảo đã khóa")
                            break;
                        default:
                            break;
                    }

                }
            })
        }else{
            toastr.warning("Vui lòng tìm kiếm đợt tuyển sinh")
        }
    }
}

function go_virtual_batch_clear(){
    var id_batch_ts = $('#go_virtual_batch_ts').val()
    var id_batch = $('#go_virtual_batch').val()
    go_virtual_load(id_batch_ts,id_batch)
}

function go_virtual_batch_sta(type){
    var id_batch_ts = $('#go_virtual_batch_ts').val()
    var id = $('#go_virtual_batch').val()
    var data = document.getElementById('go_virtual_ex');
    var excelFile = XLSX.utils.table_to_book(data, {sheet: "sheet1"});
    XLSX.write(excelFile, { bookType: type, bookSST: true, type: 'base64' });
    XLSX.writeFile(excelFile, 'ThongKetQuaLocAo_Đot'+id_batch_ts+'_ĐotLaoAo'+id+'.'+ type);
}

function ex_list_student(){
    // window.location.href = "https://xettuyentest.ctuet.edu.vn/admin/go/ex_list_student"
    window.location.href = "https://congmotcua.ctuet.edu.vn/admin/go/ex_list_student"
}

function go_virtual_batch_list(){
    var id_batch_ts = $('#go_virtual_batch_ts').val()
    var id_batch = $('#go_virtual_batch').val()
    if(id_batch_ts == 0 || id_batch == 0){
        toastr.warning("Chọn đợt lọc ảo")
    }else{
        // window.location.href = "https://xettuyentest.ctuet.edu.vn/admin/go_virtual/go_virtual_batch_list_dowload/"+id_batch_ts+'/'+id_batch
        window.location.href = "https://congmotcua.ctuet.edu.vn/admin/go_virtual/go_virtual_batch_list_dowload/"+id_batch_ts+'/'+id_batch

    }
}

function go_virtual_batch_block(){
    var id_batch_ts = $('#go_virtual_batch_ts').val()
    var id = $('#go_virtual_batch').val()
    $.ajax({
        type: "post",
        url: 'go_virtual/go_virtual_batch_block',
        data:{
            id_batch_ts : id_batch_ts,
            id : id,
        },
        success:function(res){
            if(res == 1){
                toastr.success("Đã khóa đợt lọc ảo")
                $('#go_virtual_batch_block').attr('disabled','true')
            }else{
                toastr.warning("Khóa thất bại")
                $('#go_virtual_batch_block').removeAttr('disabled')
            }
        }
    })

}

function go_virtual_batch_list_bo(){
    var id_batch_ts = $('#go_virtual_batch_ts').val()
    var id_batch = $('#go_virtual_batch').val()
    if(id_batch_ts == 0 || id_batch == 0){
        toastr.warning("Chọn đợt lọc ảo")
    }else{
        $.ajax({
            type: "post",
            url: 'go_virtual/go_virtual_batch_list_bo',
            data:{
                id_batch_ts : id_batch_ts,
                id_batch : id_batch,
            },
            success: function (res) {
                if(res == 1){
                    // window.location.href = "https://xettuyentest.ctuet.edu.vn/admin/go_virtual/go_virtual_batch_list_bo_dowload/"+id_batch_ts+'/'+id_batch
                    window.location.href = "https://congmotcua.ctuet.edu.vn/admin/go_virtual/go_virtual_batch_list_bo_dowload/"+id_batch_ts+'/'+id_batch
                }else{
                    toastr.warning("Chưa khóa đợt lọc ảo")
                }
            }
        })
    }
}

function go_virtual_load_check_block(){
    var id_batch_ts = $('#go_virtual_batch_ts').val()
    var id = $('#go_virtual_batch').val()
    $.ajax({
        type: "post",
        url: 'go_virtual/go_virtual_load_check_block',
        data:{
            id_batch_ts : id_batch_ts,
            id : id,
        },
        success: function (res) {
            if(res == 1){
                $('#go_virtual_batch_block').attr('disabled','true')
            }else{
                $('#go_virtual_batch_block').removeAttr('disabled')
            }
        }
    })
}

function go_virtual_batch_ip_list_nhom(){
    if( $('#import_go_virtual_batch_ip_list_id_batch_ts').val() == '' || $('#import_go_virtual_batch_ip_list_id_batch').val() == ''){
        toastr.warning("Chọn đợt tuyển sinh")
    }else{
        $('#import_go_virtual_batch_ip_list_nhom').click()
    }
}

function go_virtual_batch_ip_list_bo(){
    if( $('#go_virtual_batch_ip_list_bo_id_batch_ts').val() == '' || $('#go_virtual_batch_ip_list_bo_id_batch').val() == ''){
        toastr.warning("Chọn đợt tuyển sinh")
    }else{
        $('#import_go_virtual_batch_ip_list_bo').click()
    }
}






function go_virtual_show_major(id){
    go_virtual_chart_major(id);
    $('#loadding_go_virtual_show').show();
}

function go_virtual_chart_major(id){
    var id_batch_ts = $('#go_virtual_batch_ts').val()
    var id_batch = $('#go_virtual_batch').val()
    $('#go_virtual_chart_major').empty();
    // $('#go_virtual_chart_major').append('<canvas id="add_go_virtual_chart_major" style="min-height: 450px; height: 450px; max-height: 450px; max-width: 100%;"></canvas>');
    $('#go_virtual_chart_major').append('<canvas id="add_go_virtual_chart_major" style="position: absolute; right: 0; left: 0; top: 0; bottom: 0; margin: auto; min-height: 450px; height: 450px; max-height: 450px; max-width: 100%;"></canvas>');
    // style = "position: absolute; right: 0; left: 0; top: 0; bottom: 0; margin: auto; witdh:40px;height:40px;"
    setTimeout(() => {
        $.ajax({
            type: "get",
            url: 'go_virtual/add_go_virtual_chart_major/'+id+'/'+id_batch_ts+'/'+id_batch,
            success: function (res) {
                switch (res) {
                    case '2':
                        $('#go_virtual_chart_major').html('<span style="color:white"><strong>Chưa có dữ liệu của đợt lọc ảo trước ...</strong></span>');
                        break;
                    default:
                        var major = [], pass_tr = [], pass_nhom = [], pass_bo= []
                        for(let i = 0;i<res.length;i++){
                            major[i] = res[i]['id_batch']
                            pass_tr[i] = res[i]['pass_tr']
                            pass_nhom[i] = res[i]['pass_nhom']
                            pass_bo[i] = res[i]['pass_bo']
                        }
                        var ctx = document.getElementById('add_go_virtual_chart_major').getContext('2d');
                        var myChart = new Chart(ctx, {
                            data: {
                                labels: major,
                                datasets: [
                                    {
                                        label: 'Trúng tuyển Trường',
                                        data: pass_tr,
                                        backgroundColor: [
                                            'rgba(0, 0, 255,0.7)',
                                        ],
                                        borderColor: [
                                            'rgba(0, 0, 255,0.7)',
                                        ],
                                        borderWidth: 1,
                                        type: 'bar',
                                        stack: 'Stack 0',
                                        datalabels:{
                                            anchor: 'center',
                                            align: 'left',
                                            color: 'white',
                                            font: {
                                                weight: 'bold',
                                                size: '13pt'
                                            }
                                        },
                                    },

                                    {
                                        label: 'Trúng tuyển Nhóm',
                                        data: pass_nhom,
                                        backgroundColor: [
                                            'rgba(128, 0, 128,0.7)',
                                        ],
                                        borderColor: [
                                            'rgba(128, 0, 128,0.7)',
                                        ],
                                        borderWidth: 1,
                                        type: 'bar',
                                        stack: 'Stack 1',
                                        datalabels:{
                                            anchor: 'center',
                                            align: 'left',
                                            color: 'white',
                                            font: {
                                                weight: 'bold',
                                                size: '13pt'
                                            }
                                        },
                                    },
                                    {
                                        label: 'Trúng tuyển Bộ',
                                        data: pass_bo,
                                        backgroundColor: [
                                            'rgba(0, 128, 0,0.7)',
                                        ],
                                        borderColor: [
                                            'rgba(0, 128, 0,0.7)',
                                        ],
                                        borderWidth: 1,
                                        type: 'bar',
                                        stack: 'Stack 2',
                                        datalabels:{
                                            anchor: 'center',
                                            align: 'left',
                                            color: 'white',
                                            font: {
                                                weight: 'bold',
                                                size: '13pt'
                                            }
                                        },
                                    },
                                ]

                            },
                            options: {
                                legend: {
                                    labels: {
                                        fontColor: "white",
                                        fontSize: 18
                                    }
                                },
                                responsive              : true,
                                maintainAspectRatio     : false,
                                datasetFill             : false,
                                scales: {
                                    x: {
                                        stacked: true,
                                    },
                                    y: {
                                      stacked: true,

                                    }
                                }
                            },
                            plugins: [ChartDataLabels],
                        });
                        break;
                }

            }
        });
    },1);



}



