$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var validate_cha = document.getElementsByClassName('validate')
    for(let j = 0; j<validate_cha.length; j++){
        $(validate_cha[j]).hide()
        $(validate_cha[j]).find('p').text('')
    }


    $('#search_sex_user').select2();
    $('#search_noisinh_tinh').select2();
    $('#search_noisinh_huyen').select2();
    $('#search_noisinh_xa').select2();
    $('#search_dantoc').select2();
    $('#search_tongiao').select2();
    $('#search_quoctich').select2();
    $('#search_noicapcmnd').select2();
    $('#search_hktttinh').select2();
    $('#search_hktthuyen').select2();
    $('#search_hkttxa').select2();
    $('#search_noisinhhuyen').select2();
    $('#search_noisinhtinh').select2();
    $('#search_noisinhxa').select2();
    $('#search_khuyettat').select2();
    $('#search_chinhsach').select2();
    $('#search_quequan_tinh').select2();
    $('#search_quequan_huyen').select2();
    $('#search_quequan_xa').select2();

    $('#search_noisinh_tinh').on('change',function(){
        pronvince('l_province2','name_province2',$(this).val(),'id_province','search_noisinh_huyen','Chọn Quận/Huyện')
        $('#search_noisinh_xa').html('<option value = "0">Chọn Xã/Phường</option>')

    });

    $('#search_upload_cmnd_submit').hide();
    $('#search_upload_cmnd2_submit').hide();
    $('#search_upload_kqthi_submit').hide();
    $('#search_upload_tn_submit').hide();
    $('#search_upload_9_submit').hide();
    $('#search_upload_10_submit').hide();
    $('#search_upload_11_submit').hide();
    $('#search_upload_12_submit').hide();
    $('#search_upload_gks_submit').hide();
    $('#search_upload_btn_submit').hide();

    $('#search_noisinh_huyen').on('change',function(){
        pronvince('l_province3','name_province3',$(this).val(),'id_province2','search_noisinh_xa','Chọn Xã/Phường')
    });

    $('#search_hktttinh').on('change',function(){
        pronvince('l_province2','name_province2',$(this).val(),'id_province','search_hktthuyen','Chọn Huyện/Quận')
        $('#search_hkttxa').html('<option value = "0">Chọn Xã/Phường</option>')
    });
    $('#search_hktthuyen').on('change',function(){
        pronvince('l_province3','name_province3',$(this).val(),'id_province2','search_hkttxa','Chọn Xã/Phường')
    });

    $('#search_quequan_tinh').on('change',function(){
        pronvince('l_province2','name_province2',$(this).val(),'id_province','search_quequan_huyen','Chọn Huyện/Quận')
        $('#search_quequan_xa').html('<option value = "0">Chọn Xã/Phường</option>')
    });
    $('#search_quequan_huyen').on('change',function(){
        pronvince('l_province3','name_province3',$(this).val(),'id_province2','search_quequan_xa','Chọn Xã/Phường')
    });

    $('.search_hktt_change').on('change',function(){
        var tinh = $('#search_hktttinh option:selected').text()
        var huyen = $('#search_hktthuyen option:selected').text()
        var xa = $('#search_hkttxa option:selected').text()
        var duoixa = $('#search_down_province3').val()
        var  hktt_cccd = duoixa+', '+ xa+', '+ huyen+', '+ tinh
        $('#hktt_cccd').text(hktt_cccd)
    });

    $('.search_quequan_change').on('change',function(){
        var qtinh = $('#search_quequan_tinh option:selected').text()
        var qhuyen = $('#search_quequan_huyen option:selected').text()
        var qxa = $('#search_quequan_xa option:selected').text()
        var qduoixa = $('#search_down_quequan_xa').val()
        var  quequan_cccd = qduoixa+', '+ qxa+', '+ qhuyen+', '+ qtinh
        $('#quequan_cccd').text(quequan_cccd)
    });


    $('#search_submit').on('submit',function(event){
        event.preventDefault();
        var validate_cha = document.getElementsByClassName('validate')
        for(let j = 0; j<validate_cha.length; j++){
            $(validate_cha[j]).hide()
            $(validate_cha[j]).find('p').text('')
        }
        var cha = document.getElementsByClassName('search_cha')
        var demcha = 0
        for(let j = 0; j<cha.length; j++){
            if($(cha[j]).val() != ""){
                demcha++;
            }
        }
        var me = document.getElementsByClassName('search_me')
        var demme = 0
        for(let k = 0; k<me.length; k++){
            if($(me[k]).val() != ""){
                demme++;
            }
        }
        var dodau = document.getElementsByClassName('search_dodau')
        var demdodau = 0
        for(let j = 0; j<dodau.length; j++){
            if($(dodau[j]).val() != ""){
                demdodau++;
            }
        }

        if(demcha == 3 || demme ==3 || demdodau == 3){
            $('#loadding_search').show()
            $.ajax({
                url: "/tracuuketqua/search_submit",
                type:"POST",
                data: new FormData(this),
                contentType:false,
                processData:false,
                success:function(data){
                    $('#loadding_search').hide()
                    switch (data) {
                        case '0':
                            toastr.success("Có lỗi xảy ra, vui lòng xem lại thông tin hoặc liên hệ 02923.898.167")
                            break;
                        case '1':
                            toastr.success("Lưu thông tin thành công")
                            break;
                        case '2':
                            toastr.warning("Thông tin đã lưu, không có dữ liệu mới")
                            break;
                        case '3':
                            toastr.warning("Có lỗi xảy ra, vui lòng load lại trang hoặc liên hệ 02923.898.167")
                            break;
                        case '4':
                            toastr.warning("Thí sinh chưa trúng tuyển trong đợt xét tuyển này!Thắc mắc liên hệ 02923.898.167")
                            break;
                        case '5':
                            toastr.warning("Thông tin sinh viên đã được kiểm tra và xác nhận, Thí sinh không thay đổi được")
                            break;
                        default:
                            var validate_cha = document.getElementsByClassName('validate')
                            var keys = Object.keys(data)
                            for(let i = 0; i<keys.length; i++){
                                for(let j = 0; j<validate_cha.length; j++){
                                    if('v_'+keys[i] == $(validate_cha[j]).find('p').attr('id')){
                                        $(validate_cha[j]).show()
                                        $(validate_cha[j]).find('p').text(data[keys[i]])
                                        break;
                                    }else{
                                        continue;
                                    }
                                }
                            }
                            break;
                    }
                }
            });
        }else{
            toastr.warning("Phải điền thông tin Cha hoặc Mẹ hoặc Người đở đầu")
        }
    })

    $('#search_upload_cmnd').on('change',function(){
        $('#search_upload_cmnd_submit').submit();
    });
    $('#search_upload_cmnd_submit').on('submit',function(event){
        var validate_cha = document.getElementsByClassName('validate')
        for(let j = 0; j<validate_cha.length; j++){
            $(validate_cha[j]).hide()
            $(validate_cha[j]).find('p').text('')
        }
        event.preventDefault();
        $.ajax({
            url: "/tracuuketqua/search_upload_cmnd_submit",
            type:"POST",
            data: new FormData(this),
            contentType:false,
            processData:false,
            success:function(data){
                switch (data) {
                    case '0':
                        toastr.success("Upload thất bại, vui lòng lòng thử lại hoặc liên hệ 029023898167")
                        break;
                    case '1':
                        toastr.success("Upload thành công")
                        break;
                    case '2':
                        toastr.warning("Thí sinh chưa trúng tuyển")
                        break;
                    default:
                        var validate_cha = document.getElementsByClassName('validate')
                        var keys = Object.keys(data)
                        for(let i = 0; i<keys.length; i++){
                            for(let j = 0; j<validate_cha.length; j++){
                                if('v_'+keys[i] == $(validate_cha[j]).find('p').attr('id')){
                                    $(validate_cha[j]).show()
                                    $(validate_cha[j]).find('p').text(data[keys[i]])
                                    break;
                                }else{
                                    continue;
                                }
                            }
                        }
                        break;
                }
                load_swiper_search()
            }
        });
    });

    $('#search_upload_cmnd2').on('change',function(){
        $('#search_upload_cmnd2_submit').submit();
    });
    $('#search_upload_cmnd2_submit').on('submit',function(event){
        var validate_cha = document.getElementsByClassName('validate')
        for(let j = 0; j<validate_cha.length; j++){
            $(validate_cha[j]).hide()
            $(validate_cha[j]).find('p').text('')
        }
        $('#loadding_search').show()
        event.preventDefault();
        $.ajax({
            url: "/tracuuketqua/search_upload_cmnd2_submit",
            type:"POST",
            data: new FormData(this),
            contentType:false,
            processData:false,
            success:function(data){
                $('#loadding_search').hide()
                switch (data) {
                    case '0':
                        toastr.warning("Upload thất bại, vui lòng load lại hoặc liên hệ 02923898167")
                        break;
                    case '1':
                        toastr.success("Upload thành công")
                        break;
                    case '2':
                        toastr.warning("Thí sinh chưa trúng tuyển")
                        break;
                    default:
                        var validate_cha = document.getElementsByClassName('validate')
                        var keys = Object.keys(data)
                        for(let i = 0; i<keys.length; i++){
                            for(let j = 0; j<validate_cha.length; j++){
                                if('v_'+keys[i] == $(validate_cha[j]).find('p').attr('id')){
                                    $(validate_cha[j]).show()
                                    $(validate_cha[j]).find('p').text(data[keys[i]])
                                    break;
                                }else{
                                    continue;
                                }
                            }
                        }
                        break;
                }
                load_swiper_search()
            }
        });
    });


    $('#search_upload_kqthi').on('change',function(){
        $('#search_upload_kqthi_submit').submit();
    });
    $('#search_upload_kqthi_submit').on('submit',function(event){
        $('#loadding_search').show()
        var validate_cha = document.getElementsByClassName('validate')
        for(let j = 0; j<validate_cha.length; j++){
            $(validate_cha[j]).hide()
            $(validate_cha[j]).find('p').text('')
        }
        event.preventDefault();
        $.ajax({
            url: "/tracuuketqua/search_upload_kqthi_submit",
            type:"POST",
            data: new FormData(this),
            contentType:false,
            processData:false,
            success:function(data){
                $('#loadding_search').hide()
                switch (data) {
                    case '0':
                        toastr.warning("Upload thất bại, vui lòng load lại hoặc liên hệ 02923898167")
                        break;
                    case '1':
                        toastr.success("Upload thành công")
                        break;
                    case '2':
                        toastr.warning("Thí sinh chưa trúng tuyển")
                        break;
                    default:
                        var validate_cha = document.getElementsByClassName('validate')
                        var keys = Object.keys(data)
                        for(let i = 0; i<keys.length; i++){
                            for(let j = 0; j<validate_cha.length; j++){
                                if('v_'+keys[i] == $(validate_cha[j]).find('p').attr('id')){
                                    $(validate_cha[j]).show()
                                    $(validate_cha[j]).find('p').text(data[keys[i]])
                                    break;
                                }else{
                                    continue;
                                }
                            }
                        }
                        break;
                }
                load_swiper_search()
            }
        });
    });


    $('#search_upload_tn').on('change',function(){
        $('#search_upload_tn_submit').submit();
    });
    $('#search_upload_tn_submit').on('submit',function(event){
        var validate_cha = document.getElementsByClassName('validate')
        for(let j = 0; j<validate_cha.length; j++){
            $(validate_cha[j]).hide()
            $(validate_cha[j]).find('p').text('')
        }
        $('#loadding_search').show()
        event.preventDefault();
        $.ajax({
            url: "/tracuuketqua/search_upload_tn_submit",
            type:"POST",
            data: new FormData(this),
            contentType:false,
            processData:false,
            success:function(data){
                $('#loadding_search').hide()
                switch (data) {
                    case '0':
                        toastr.warning("Upload thất bại, vui lòng load lại hoặc liên hệ 02923898167")
                        break;
                    case '1':
                        toastr.success("Upload thành công")
                        break;
                    case '2':
                        toastr.warning("Thí sinh chưa trúng tuyển")
                        break;
                    default:
                        var validate_cha = document.getElementsByClassName('validate')
                        var keys = Object.keys(data)
                        for(let i = 0; i<keys.length; i++){
                            for(let j = 0; j<validate_cha.length; j++){
                                if('v_'+keys[i] == $(validate_cha[j]).find('p').attr('id')){
                                    $(validate_cha[j]).show()
                                    $(validate_cha[j]).find('p').text(data[keys[i]])
                                    break;
                                }else{
                                    continue;
                                }
                            }
                        }
                        break;
                }
                load_swiper_search()
            }
        });
    });

    $('#search_upload_10').on('change',function(){
        $('#search_upload_10_submit').submit();
    });
    $('#search_upload_10_submit').on('submit',function(event){
        var validate_cha = document.getElementsByClassName('validate')
        for(let j = 0; j<validate_cha.length; j++){
            $(validate_cha[j]).hide()
            $(validate_cha[j]).find('p').text('')
        }
        $('#loadding_search').show()
        event.preventDefault();
        $.ajax({
            url: "/tracuuketqua/search_upload_10_submit",
            type:"POST",
            data: new FormData(this),
            contentType:false,
            processData:false,
            success:function(data){
                $('#loadding_search').hide()
                switch (data) {
                    case '0':
                        toastr.warning("Upload thất bại, vui lòng load lại hoặc liên hệ 02923898167")
                        break;
                    case '1':
                        toastr.success("Upload thành công")
                        break;
                    case '2':
                        toastr.warning("Thí sinh chưa trúng tuyển")
                        break;
                    default:
                        var validate_cha = document.getElementsByClassName('validate')
                        var keys = Object.keys(data)
                        for(let i = 0; i<keys.length; i++){
                            for(let j = 0; j<validate_cha.length; j++){
                                if('v_'+keys[i] == $(validate_cha[j]).find('p').attr('id')){
                                    $(validate_cha[j]).show()
                                    $(validate_cha[j]).find('p').text(data[keys[i]])
                                    break;
                                }else{
                                    continue;
                                }
                            }
                        }
                        break;
                }
                load_swiper_search()
            }
        });
    });

    $('#search_upload_9').on('change',function(){
        $('#search_upload_9_submit').submit();
    });
    $('#search_upload_9_submit').on('submit',function(event){
        var validate_cha = document.getElementsByClassName('validate')
        for(let j = 0; j<validate_cha.length; j++){
            $(validate_cha[j]).hide()
            $(validate_cha[j]).find('p').text('')
        }
        $('#loadding_search').show()
        event.preventDefault();
        $.ajax({
            url: "/tracuuketqua/search_upload_9_submit",
            type:"POST",
            data: new FormData(this),
            contentType:false,
            processData:false,
            success:function(data){
                $('#loadding_search').hide()
                switch (data) {
                    case '0':
                        toastr.warning("Upload thất bại, vui lòng load lại hoặc liên hệ 02923898167")
                        break;
                    case '1':
                        toastr.success("Upload thành công")
                        break;
                    case '2':
                        toastr.warning("Thí sinh chưa trúng tuyển")
                        break;
                    default:
                        var validate_cha = document.getElementsByClassName('validate')
                        var keys = Object.keys(data)
                        for(let i = 0; i<keys.length; i++){
                            for(let j = 0; j<validate_cha.length; j++){
                                if('v_'+keys[i] == $(validate_cha[j]).find('p').attr('id')){
                                    $(validate_cha[j]).show()
                                    $(validate_cha[j]).find('p').text(data[keys[i]])
                                    break;
                                }else{
                                    continue;
                                }
                            }
                        }
                        break;
                }
                load_swiper_search()
            }
        });
    });

    $('#search_upload_11').on('change',function(){
        $('#search_upload_11_submit').submit();
    });

    $('#search_upload_11_submit').on('submit',function(event){
        var validate_cha = document.getElementsByClassName('validate')
        for(let j = 0; j<validate_cha.length; j++){
            $(validate_cha[j]).hide()
            $(validate_cha[j]).find('p').text('')
        }
        $('#loadding_search').show()
        event.preventDefault();
        $.ajax({
            url: "/tracuuketqua/search_upload_11_submit",
            type:"POST",
            data: new FormData(this),
            contentType:false,
            processData:false,
            success:function(data){
                $('#loadding_search').hide()
                switch (data) {
                    case '0':
                        toastr.warning("Upload thất bại, vui lòng load lại hoặc liên hệ 02923898167")
                        break;
                    case '1':
                        toastr.success("Upload thành công")
                        break;
                    case '2':
                        toastr.warning("Thí sinh chưa trúng tuyển")
                        break;
                    default:
                        var validate_cha = document.getElementsByClassName('validate')
                        var keys = Object.keys(data)
                        for(let i = 0; i<keys.length; i++){
                            for(let j = 0; j<validate_cha.length; j++){
                                if('v_'+keys[i] == $(validate_cha[j]).find('p').attr('id')){
                                    $(validate_cha[j]).show()
                                    $(validate_cha[j]).find('p').text(data[keys[i]])
                                    break;
                                }else{
                                    continue;
                                }
                            }
                        }
                        break;
                }
                load_swiper_search()
            }
        });
    });

    $('#search_upload_12').on('change',function(){
        $('#search_upload_12_submit').submit();
    });
    $('#search_upload_12_submit').on('submit',function(event){
        var validate_cha = document.getElementsByClassName('validate')
        for(let j = 0; j<validate_cha.length; j++){
            $(validate_cha[j]).hide()
            $(validate_cha[j]).find('p').text('')
        }
        $('#loadding_search').show()
        event.preventDefault();
        $.ajax({
            url: "/tracuuketqua/search_upload_12_submit",
            type:"POST",
            data: new FormData(this),
            contentType:false,
            processData:false,
            success:function(data){
                $('#loadding_search').hide()
                switch (data) {
                    case '0':
                        toastr.warning("Upload thất bại, vui lòng load lại hoặc liên hệ 02923898167")
                        break;
                    case '1':
                        toastr.success("Upload thành công")
                        break;
                    case '2':
                        toastr.warning("Thí sinh chưa trúng tuyển")
                        break;
                    default:
                        var validate_cha = document.getElementsByClassName('validate')
                        var keys = Object.keys(data)
                        for(let i = 0; i<keys.length; i++){
                            for(let j = 0; j<validate_cha.length; j++){
                                if('v_'+keys[i] == $(validate_cha[j]).find('p').attr('id')){
                                    $(validate_cha[j]).show()
                                    $(validate_cha[j]).find('p').text(data[keys[i]])
                                    break;
                                }else{
                                    continue;
                                }
                            }
                        }
                        break;
                }
                load_swiper_search()
            }
        });
    });

    $('#search_upload_gks').on('change',function(){
        $('#search_upload_gks_submit').submit();
    });
    $('#search_upload_gks_submit').on('submit',function(event){
        var validate_cha = document.getElementsByClassName('validate')
        for(let j = 0; j<validate_cha.length; j++){
            $(validate_cha[j]).hide()
            $(validate_cha[j]).find('p').text('')
        }
        $('#loadding_search').show()
        event.preventDefault();
        $.ajax({
            url: "/tracuuketqua/search_upload_gks_submit",
            type:"POST",
            data: new FormData(this),
            contentType:false,
            processData:false,
            success:function(data){
                $('#loadding_search').hide()
                switch (data) {
                    case '0':
                        toastr.warning("Upload thất bại, vui lòng load lại hoặc liên hệ 02923898167")
                        break;
                    case '1':
                        toastr.success("Upload thành công")
                        break;
                    case '2':
                        toastr.warning("Thí sinh chưa trúng tuyển")
                        break;
                    default:
                        var validate_cha = document.getElementsByClassName('validate')
                        var keys = Object.keys(data)
                        for(let i = 0; i<keys.length; i++){
                            for(let j = 0; j<validate_cha.length; j++){
                                if('v_'+keys[i] == $(validate_cha[j]).find('p').attr('id')){
                                    $(validate_cha[j]).show()
                                    $(validate_cha[j]).find('p').text(data[keys[i]])
                                    break;
                                }else{
                                    continue;
                                }
                            }
                        }
                        break;
                }
                load_swiper_search()
            }
        });
    });

    $('#search_upload_btn').on('change',function(){
        $('#search_upload_btn_submit').submit();
    });

    $('#search_upload_btn_submit').on('submit',function(event){
        $('#loadding_search').show()
        event.preventDefault();
        $.ajax({
            url: "/tracuuketqua/search_upload_btn_submit",
            type:"POST",
            data: new FormData(this),
            contentType:false,
            processData:false,
            success:function(data){
                $('#loadding_search').hide()
                switch (data) {
                    case '0':
                        toastr.warning("Upload thất bại, vui lòng load lại hoặc liên hệ 02923898167")
                        break;
                    case '1':
                        toastr.success("Upload thành công")
                        break;
                    case '2':
                        toastr.warning("Thí sinh chưa trúng tuyển")
                        break;
                    default:
                        var validate_cha = document.getElementsByClassName('validate')
                        var keys = Object.keys(data)
                        for(let i = 0; i<keys.length; i++){
                            for(let j = 0; j<validate_cha.length; j++){
                                if('v_'+keys[i] == $(validate_cha[j]).find('p').attr('id')){
                                    $(validate_cha[j]).show()
                                    $(validate_cha[j]).find('p').text(data[keys[i]])
                                    break;
                                }else{
                                    continue;
                                }
                            }
                        }
                        break;
                }
                load_swiper_search()
            }
        });
    });

     $('#batch_login').select2({
        height: '36px'
     });
    load_swiper_search()
    batch_login();

})

function batch_login(){
    $.ajax({
        url: "/tracuuketqua/batch_login",
        type:'get',
        dataType: 'json',
        success:function(data){
            // $('#year_check').html('').select2({
            //     data: data.year,
            // });
            $('#batch_login').html('').select2({
                data: data.batch
            });
        }
    })
}


function load_swiper_search(){
    $.ajax({
        url: "/tracuuketqua/load_swiper_search",
        type:"POST",
        success:function(data){
            $('#swiper_search').html(data);
        }
    });
}

function searchlogin(){
    $('#v_cmnd_login').text('');
    $('#v_batch_login').text('');
    $('#info_login').text('');
    $.ajax({
        type: "post",
        url: "/tracuuketqua/login",
        data:{
            cmnd_login: $('#cmnd_login').val(),
            batch_login: $('#batch_login').val(),
        },
        success: function (data) {
            switch (data) {
                case '1':
                    window.location.href = "https://congmotcua.ctuet.edu.vn/tracuuketqua/main";
                    // window.location.href = "https://xettuyentest.ctuet.edu.vn/tracuuketqua/main";
                    break;
                case '2':
                    $('#info_login').text('Hiện tại chưa có kết quả xét tuyển');
                    break;
                case '0':
                    $('#info_login').text('Nhập CMND/TCC đăng ký xét tuyển trên Cổng của Bộ GD&ĐT');
                    break;
                default:
                    var dem = 0;
                    var dom = document.getElementsByClassName("validate_login");
                    var keys = Object.keys(data)
                    for(let i=0;i<dom.length;i++){
                        for(let j=0;j<keys.length;j++){
                            if($(dom[i]).attr('name') == keys[j])
                            {
                                $('#v_'+keys[j]).text(data[keys[j]])
                                dem++;
                                // alert(keys[j])
                            }
                        }
                    if(dem == 0){
                        $('#v_'+$(dom[i]).attr('name')).text("")
                    }
                    dem = 0;
                    }
                    break;
            }
        }
    })
}

function search_check(id) {
    $('#loadding_search').show()
    var text = $('#search_check').attr('onclick')
    var id1 = text.split('(')[1].split(')')[0]
    if(id1 == id){
        var a = confirm("Bạn đồng ý xác nhận nhập học tại Trường")
        if(a == true){
            $.ajax({
                type: "post",
                url: "/tracuuketqua/search_check",
                data:{
                    id_check: id,
                },
                success: function (data) {
                    $('#loadding_search').hide()
                    switch (data) {
                        case '1':
                            toastr.success('Thí sinh đã xác nhận nhập học thành công');
                            $('#search_check').attr('value',"Đã xác nhận")
                            break;
                        case '2':
                            toastr.warning('Thí sinh đã xác nhận nhập học');
                            break;
                        case '3':
                            toastr.warning('Thao tác không thành công, vui lòng liên hệ Phòng Đào tạo, 02923898167');
                            break;
                        case '4':
                            toastr.warning('Đợt xác nhận đã khóa');
                            break;
                        case '6':
                            toastr.warning('Thí sinh chưa trúng tuyển');
                        break;
                        case '7':
                            toastr.warning('Thí sinh chưa lưu thông tin nhập học');
                        break;
                        default:
                            toastr.warning('Chưa đến đợt xác nhận nhập học');
                            break;
                    }
                }
            })
        }
    }
    // else{
    //     toastr.warning("Có lỗi xảy ra")
    // }
}

function pronvince(name_table,col_table,value,col_table_value,id_select,value0){
    $('#'+id_select).html('')
    $.ajax({
        type: "post",
        url: "/tracuuketqua/pronvince",
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

function search_save1(){

    $('#search_submit').submit();
}

function op_search_form_upload_cmnd(){
    $('#search_upload_cmnd').click();
}

function op_search_form_upload_cmnd2(){
    $('#search_upload_cmnd2').click();
}
function op_search_form_upload_kqthi(){
    $('#search_upload_kqthi').click();
}

function op_search_form_upload_tn(){
    $('#search_upload_tn').click();
}
function op_search_form_upload_9(){
    $('#search_upload_9').click();
}
function op_search_form_upload_10(){
    $('#search_upload_10').click();
}

function op_search_form_upload_11(){
    $('#search_upload_11').click();
}

function op_search_form_upload_12(){
    $('#search_upload_12').click();
}

function op_search_form_upload_gks(){
    $('#search_upload_gks').click();
}

function op_search_form_upload_btn(){
    $('#search_upload_btn').click();
}

function search_bosung(id){
    $('#loadding_search').show()
    if($('#dt_bosung').val() == ""){
        toastr.warning("Vui lòng nhập số điện thoại!")
    }else{
        $.ajax({
            url: "/tracuuketqua/search_bosung",
            type:"post",
            data:{
                dt_bosung: $('#dt_bosung').val()
            },
            success:function(data){
                $('#loadding_search').hide()
                if(data == 1){
                    toastr.success("Thí sinh vui lòng chờ đăng ký đợt bổ sung!")
                }else{
                    if(data == 2){
                        toastr.warning("Thí sinh đã điền thông tin, vui lòng chờ đợt bổ sung!")
                    }else{
                        if(data == 0){
                            toastr.warning("Lưu thông tin thất bại, vui lòng liên hệ 02923898167!")
                        }else{
                            toastr.warning("Điện thoại bao gồm 10 chữ số")
                        }
                    }
                }
            }
        })
    }

}
