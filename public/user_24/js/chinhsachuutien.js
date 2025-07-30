$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('.menu2').css('background-color','#2e3192')
    $('.menu2').find('i').css('color','#f4f6f9')
    $('.menu2').find('div').css('color','#f4f6f9')
    $('.menu2').find('strong').css('color','#f4f6f9')
    // $('#noisinh').select2();

    const swiper = new Swiper('.swiper-slide', {

        // zoom: true,

        zoom: {
            maxRatio: 3,
            minRatio: 1
          },

        // rotate: 'true',

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

    //   $('#upload_img').show('slow')
    $('*').keyup(function(e){
        if(e.keyCode=='27'){
            $('#upload_img').hide('slow')
            location.reload(true);
        }
    })
})


function luuthongtincanhan(id){
    $('.validate').hide();
    var thongtincanhan = document.getElementsByClassName('thongtincanhan')
    var data = []
    for(let i=0;i<thongtincanhan.length;i++){

        $(thongtincanhan[i]).removeClass('input_er')
        $("#v_"+$(thongtincanhan[i]).attr('id')).removeClass('error');
        $("#v_"+$(thongtincanhan[i]).attr('id')).text('');
        data[i] = [$(thongtincanhan[i]).attr('id'),$(thongtincanhan[i]).val()]
    }
    if($('#gioitinhnam').prop('checked') == true){
        var gioitinh = 0;
    }else{
        var gioitinh = 1;
    }
    data.push(['gioitinh',gioitinh])
    $.ajax({
        type: "post",
        url: "/thongtincanhan/luuthongtincanhan",
        data: {
            id:id,
            data: data
        },
        success: function (res) {
            if(res['maloi'] == "vali_1"){
                toastr.warning("Có lỗi nhập thông tin, vui lòng chú ý hướng dẫn màu đỏ!")
                var keys = Object.keys(res['data']['original'])
                for(let i = 0; i<keys.length; i++){
                    if($('#'+keys[i]).attr('type_custom') == "select_custom"){
                        $('#'+keys[i]).find('.select2-selection .select2-selection--single').addClass('input_er')
                    }else{
                        $('#'+keys[i]).addClass('input_er')
                    }
                    $('#v_'+keys[i]).show('slow')
                    $('#v_'+keys[i]).text(res['data']['original'][keys[i]][0])
                    $('#v_'+keys[i]).addClass('error')

                }
            }else{
                resutlinfo(res)
            }
        }
    });
}

function upload_img(){
    $('#upload_img').show('slow')
}


function upload_img_close(){
    $('#upload_img').hide('slow')
    location.reload(true);
}

function upload_anhdaidien(id){
    $('#upload_anhdaidien').click();
}

$('#upload_anhdaidien').on('change',function(e){
    $('#modal_event').show('fast');
    e.preventDefault();
    var id_user = $(this).attr('id-user')
    var type = this.files[0].type
    if(type == 'image/png' || type == 'image/pjpeg' || type == 'image/jpeg' || type == 'image/jpg'){
        var reader = new FileReader();
        reader.onload = function (event) {
            src = event.target.result
            $.ajax({
                url: "/thongtincanhan/upload_anhdaidien",
                type:'POST',
                data: {
                    src: src,
                    id_user: id_user,
                },
                success:function(res){
                    $('#upload_anhdaidien_1').attr('src',res.path)
                    $('#anhdaidien').attr('src',res.path)
                    resutlinfo(res.act)
                    if(res.act == "UpOrIns_1"){
                        $('#upload_img_icon_upload_anhdaidien_1').css('color','#007aff')
                        $('#upload_img_text_upload_anhdaidien_1').css('color','#007aff')
                    }else{
                        $('#upload_img_icon_upload_anhdaidien_1').css('color','rgb(242, 4, 4)')
                        $('#upload_img_text_upload_anhdaidien_1').css('color','#007aff')
                    }
                }
            })
        }
        reader.readAsDataURL(this.files[0]);
    }else{
        toastr.warning('Vui lòng upload file ảnh')
    }
    $('#modal_event').hide('slow');
    $(this).val('')
})

function upload_cccd(id){
    $('#upload_cccd').click();
}

$('#upload_cccd').on('change',function(e){
    $('#modal_event').show('slow');
    e.preventDefault();
    var id_user = $(this).attr('id-user')
    var type = this.files[0].type
    if(type == 'image/png' || type == 'image/pjpeg' || type == 'image/jpeg' || type == 'image/jpg'){
        var reader = new FileReader();
        reader.onload = function (event) {
            src = event.target.result
            $.ajax({
                url: "/thongtincanhan/upload_cccd",
                type:'POST',
                data: {
                    src: src,
                    id_user: id_user,
                },
                success:function(res){
                    $('#upload_cccd_2').attr('src',res.path)
                    resutlinfo(res.act)
                    if(res.act == "UpOrIns_1"){
                        $('#upload_img_icon_upload_cccd_2').css('color','#007aff')
                        $('#upload_img_text_upload_cccd_2').css('color','#007aff')
                    }else{
                        $('#upload_img_icon_upload_cccd_2').css('color','rgb(242, 4, 4)')
                        $('#upload_img_text_upload_cccd_2').css('color','#007aff')
                    }
                }
            })
        }
        reader.readAsDataURL(this.files[0]);
    }else{
        toastr.warning('Vui lòng upload file ảnh')
    }
    $('#modal_event').hide('slow');
    $(this).val('')
})


function upload_cccdsau(id){
    $('#upload_cccdsau').click();
}

$('#upload_cccdsau').on('change',function(e){
    $('#modal_event').show('fast');
    e.preventDefault();
    var id_user = $(this).attr('id-user')
    var type = this.files[0].type
    if(type == 'image/png' || type == 'image/pjpeg' || type == 'image/jpeg' || type == 'image/jpg'){
        var reader = new FileReader();
        reader.onload = function (event) {
            src = event.target.result
            $.ajax({
                url: "/thongtincanhan/upload_cccdsau",
                type:'POST',
                data: {
                    src: src,
                    id_user: id_user,
                },
                success:function(res){
                    $('#upload_cccdsau_3').attr('src',res.path)
                    resutlinfo(res.act)
                    if(res.act == "UpOrIns_1"){
                        $('#upload_img_icon_upload_cccdsau_3').css('color','#007aff')
                        $('#upload_img_text_upload_cccdsau_3').css('color','#007aff')
                    }else{
                        $('#upload_img_icon_upload_cccdsau_3').css('color','rgb(242, 4, 4)')
                        $('#upload_img_text_upload_cccdsau_3').css('color','#007aff')
                    }
                }
            })
        }
        reader.readAsDataURL(this.files[0]);
    }else{
        toastr.warning('Vui lòng upload file ảnh')
    }
    $('#modal_event').hide('slow');
    $(this).val('')
})

function upload_hbhocbalop10(id){
    $('#upload_hbhocbalop10').click();
}

$('#upload_hbhocbalop10').on('change',function(e){
    $('#modal_event').show('fast');
    e.preventDefault();
    var id_user = $(this).attr('id-user')
    var type = this.files[0].type
    if(type == 'image/png' || type == 'image/pjpeg' || type == 'image/jpeg' || type == 'image/jpg'){
        var reader = new FileReader();
        reader.onload = function (event) {
            src = event.target.result
            $.ajax({
                url: "/thongtincanhan/upload_hbhocbalop10",
                type:'POST',
                data: {
                    src: src,
                    id_user: id_user,
                },
                success:function(res){
                    $('#upload_hbhocbalop10_4').attr('src',res.path)
                    resutlinfo(res.act)
                    if(res.act == "UpOrIns_1"){
                        $('#upload_img_icon_upload_hbhocbalop10_4').css('color','#007aff')
                        $('#upload_img_text_upload_hbhocbalop10_4').css('color','#007aff')
                    }else{
                        $('#upload_img_icon_upload_hbhocbalop10_4').css('color','rgb(242, 4, 4)')
                        $('#upload_img_text_upload_hbhocbalop10_4').css('color','#007aff')
                    }
                }
            })
        }
        reader.readAsDataURL(this.files[0]);
    }else{
        toastr.warning('Vui lòng upload file ảnh')
    }
    $('#modal_event').hide('slow');
    $(this).val('')
})

function upload_hocbalop11(id){
    $('#upload_hocbalop11').click();
}

$('#upload_hocbalop11').on('change',function(e){
    $('#modal_event').show('fast');
    e.preventDefault();
    var id_user = $(this).attr('id-user')
    var type = this.files[0].type
    if(type == 'image/png' || type == 'image/pjpeg' || type == 'image/jpeg' || type == 'image/jpg'){
        var reader = new FileReader();
        reader.onload = function (event) {
            src = event.target.result
            $.ajax({
                url: "/thongtincanhan/upload_hocbalop11",
                type:'POST',
                data: {
                    src: src,
                    id_user: id_user,
                },
                success:function(res){
                    $('#upload_hocbalop11_5').attr('src',res.path)
                    resutlinfo(res.act)
                    if(res.act == "UpOrIns_1"){
                        $('#upload_img_icon_upload_hocbalop11_5').css('color','#007aff')
                        $('#upload_img_text_upload_hocbalop11_5').css('color','#007aff')
                    }else{
                        $('#upload_img_icon_upload_hocbalop11_5').css('color','rgb(242, 4, 4)')
                        $('#upload_img_icon_upload_hocbalop11_5').css('color','#007aff')
                    }
                }
            })
        }
        reader.readAsDataURL(this.files[0]);
    }else{
        toastr.warning('Vui lòng upload file ảnh')
    }
    $('#modal_event').hide('slow');
    $(this).val('')
})


function upload_hbhocbalop12(id){
    $('#upload_hbhocbalop12').click();
}

$('#upload_hbhocbalop12').on('change',function(e){
    $('#modal_event').show('fast');
    e.preventDefault();
    var id_user = $(this).attr('id-user')
    var type = this.files[0].type
    if(type == 'image/png' || type == 'image/pjpeg' || type == 'image/jpeg' || type == 'image/jpg'){
        var reader = new FileReader();
        reader.onload = function (event) {
            src = event.target.result
            $.ajax({
                url: "/thongtincanhan/upload_hbhocbalop12",
                type:'POST',
                data: {
                    src: src,
                    id_user: id_user,
                },
                success:function(res){
                    $('#upload_hbhocbalop12_6').attr('src',res.path)
                    resutlinfo(res.act)
                    if(res.act == "UpOrIns_1"){
                        $('#upload_img_icon_upload_hbhocbalop12_6').css('color','#007aff')
                        $('#upload_img_text_upload_hbhocbalop12_6').css('color','#007aff')
                    }else{
                        $('#upload_img_icon_upload_hbhocbalop12_6').css('color','rgb(242, 4, 4)')
                        $('#upload_img_text_upload_hbhocbalop12_6').css('color','#007aff')
                    }
                }
            })
        }
        reader.readAsDataURL(this.files[0]);
    }else{
        toastr.warning('Vui lòng upload file ảnh')
    }
    $('#modal_event').hide('slow');
    $(this).val('')
})

function upload_uutien1(id){
    $('#upload_uutien1').click();
}

$('#upload_uutien1').on('change',function(e){
    $('#modal_event').show('fast');
    e.preventDefault();
    var id_user = $(this).attr('id-user')
    var type = this.files[0].type
    if(type == 'image/png' || type == 'image/pjpeg' || type == 'image/jpeg' || type == 'image/jpg'){
        var reader = new FileReader();
        reader.onload = function (event) {
            src = event.target.result
            $.ajax({
                url: "/thongtincanhan/upload_uutien1",
                type:'POST',
                data: {
                    src: src,
                    id_user: id_user,
                },
                success:function(res){
                    $('#upload_uutien1_7').attr('src',res.path)
                    resutlinfo(res.act)
                    if(res.act == "UpOrIns_1"){
                        $('#upload_img_icon_upload_uutien1_7').css('color','#007aff')
                        $('#upload_img_text_upload_uutien1_7').css('color','#007aff')
                    }else{
                        $('#upload_img_icon_upload_uutien1_7').css('color','rgb(242, 4, 4)')
                        $('#upload_img_text_upload_uutien1_7').css('color','#007aff')
                    }
                }
            })
        }
        reader.readAsDataURL(this.files[0]);
    }else{
        toastr.warning('Vui lòng upload file ảnh')
    }
    $('#modal_event').hide('slow');
    $(this).val('')
})

function upload_uutien2(id){
    $('#upload_uutien2').click();
}

$('#upload_uutien2').on('change',function(e){
    $('#modal_event').show('fast');
    e.preventDefault();
    var id_user = $(this).attr('id-user')
    var type = this.files[0].type
    if(type == 'image/png' || type == 'image/pjpeg' || type == 'image/jpeg' || type == 'image/jpg'){
        var reader = new FileReader();
        reader.onload = function (event) {
            src = event.target.result
            $.ajax({
                url: "/thongtincanhan/upload_uutien2",
                type:'POST',
                data: {
                    src: src,
                    id_user: id_user,
                },
                success:function(res){
                    $('#upload_uutien2_8').attr('src',res.path)
                    resutlinfo(res.act)
                    if(res.act == "UpOrIns_1"){
                        $('#upload_img_icon_upload_uutien2_8').css('color','#007aff')
                        $('#upload_img_text_upload_uutien2_8').css('color','#007aff')
                    }else{
                        $('#upload_img_icon_upload_uutien2_8').css('color','rgb(242, 4, 4)')
                        $('#upload_img_text_upload_uutien2_8').css('color','#007aff')
                    }
                }
            })
        }
        reader.readAsDataURL(this.files[0]);
    }else{
        toastr.warning('Vui lòng upload file ảnh')
    }
    $('#modal_event').hide('slow');
    $(this).val('')
})


function upload_bangtotnghiep(id){
    $('#upload_bangtotnghiep').click();
}

$('#upload_bangtotnghiep').on('change',function(e){
    $('#modal_event').show('fast');
    e.preventDefault();
    var id_user = $(this).attr('id-user')
    var type = this.files[0].type
    if(type == 'image/png' || type == 'image/pjpeg' || type == 'image/jpeg' || type == 'image/jpg'){
        var reader = new FileReader();
        reader.onload = function (event) {
            src = event.target.result
            $.ajax({
                url: "/thongtincanhan/upload_bangtotnghiep",
                type:'POST',
                data: {
                    src: src,
                    id_user: id_user,
                },
                success:function(res){
                    $('#upload_bangtotnghiep_9').attr('src',res.path)
                    resutlinfo(res.act)
                    if(res.act == "UpOrIns_1"){
                        $('#upload_img_icon_upload_bangtotnghiep_9').css('color','#007aff')
                        $('#upload_img_text_upload_bangtotnghiep_9').css('color','#007aff')
                    }else{
                        $('#upload_img_icon_upload_bangtotnghiep_9').css('color','rgb(242, 4, 4)')
                        $('#upload_img_text_upload_bangtotnghiep_9').css('color','#007aff')
                    }
                }
            })
        }
        reader.readAsDataURL(this.files[0]);
    }else{
        toastr.warning('Vui lòng upload file ảnh')
    }
    $('#modal_event').hide('slow');
    $(this).val('')
})









