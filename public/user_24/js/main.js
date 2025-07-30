$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.validate').hide();

    $('*').keyup(function(e){
        if(e.keyCode=='27'){
            $('#upload_img').hide('slow')
            location.reload(true);
        }
    })

    $('*').keyup(function(e){
        if(e.keyCode=='27'){
            $('#videohuongdan').hide('slow')
            // location.reload(true);
        }
    })
})




const swiper1 = new Swiper('.swiper-slider', {

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


const swiper2 = new Swiper('.swiper-modal', {

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

function resutlinfo(res){
    switch (res) {
        case 'hinhanh':
            toastr.warning('Vui lòng cập nhật hình ảnh tại mục quản lý hình ảnh!')
            break;
        case 'thongtincannhan':
            toastr.warning('Chưa nhập thông tin cá nhân!')
            break;
        case 'khoadangky_ttcn':
            toastr.warning('Thí sinh đã đăng ký xét tuyển, không thay đổi được thông tin đã đăng ký!')
            break;
        case '-99':
            toastr.warning('Tài khoản không được phân quyền')
            break;
        case '-100':
            toastr.error('Hệ thống bị lỗi, vui lòng liên hệ admin')
            break;
        case 'UpOrIns_1':
            toastr.success('Cập nhật thông tin thành công')
            break;
        case 'UpOrIns_0':
            toastr.warning("Không có thông tin mới!!!")
            break;
        case 'UpOrIns_cccd':
            toastr.warning("CMMD/CCCD đã đăng ký tài khoản")
            break;
        case 'edit_0':
            toastr.warning('Cập nhật thất bại!!!')
            break;
        case 'edit_1':
            toastr.success("Cập nhật thành công!!!")
            break;
        case 'del_0':
            toastr.error('Xóa thất bại!!!')
            break;
        case 'del_1':
            toastr.success("Xóa thành công!!!")
            break;
        case 'up_1':
            toastr.success("Cập nhật thành công!!!")
            break;
        case 'dangky_chua':
            toastr.warning("Thí sinh chưa đăng ký xét tuyển!!!")
            break;
        case 'mocapnhat':
            toastr.warning("Hệ thống xử lý yêu cầu thí sinh trước 17h!")
            break;
        case 'capnhatitnv':
            toastr.warning('Thí sinh không được cập nhật ít nguyện vọng hơn số nguyện vọng đã thanh toán lệ phi')
            break;
        case 'chuamodot':
            toastr.warning("Hệ thống chưa có đợt tuyển sinh mới!")
            break;
        case 'dathanhtoan':
            toastr.warning("Thí sinh đã thanh toán nhiều hơn, không cần thanh toán nữa")
            break;
        case 'xetuyen_1':
            toastr.warning("Các nguyện vọng của thí sinh đang được xét tuyển")
            break;
        case 'khoadot_1':
            toastr.warning("Hệ thống đã khóa!!!")
            break;
        default:
            toastr.warning("Có lỗi nhập thông tin, vui lòng chú ý hướng dẫn màu đỏ!")
        break;


    }
}

function upload_img(){
    $('#upload_img').show('slow')
}


function upload_img_close(){
    $('#upload_img').hide('slow')
    location.reload(true);
}


function upload_cccd(id){
    $('#upload_cccd').click();
}

$('#upload_cccd').on('change',function(e){
    $('#modal_event').show();
    e.preventDefault();
    var id_user = $(this).attr('id-user')
    var type = this.files[0].type
    if(type == 'image/png' || type == 'image/pjpeg' || type == 'image/jpeg' || type == 'image/jpg'){
        var reader = new FileReader();
        reader.onload = function (event) {
            src = event.target.result
            $('#upload_cccd_2').attr('src',src)
            $.ajax({
                url: "/thongtincanhan/upload_cccd",
                type:'POST',
                data: {
                    src: src,
                    id_user: id_user,
                },
                success:function(res){
                    if(res.act == "UpOrIns_1"){
                        $('#upload_img_icon_upload_cccd_2').css('color','#007aff')
                        $('#upload_img_text_upload_cccd_2').css('color','#007aff')
                        resutlinfo(res.act)
                    }else{
                        $('#upload_img_icon_upload_cccd_2').css('color','rgb(242, 4, 4)')
                        $('#upload_img_text_upload_cccd_2').css('color','#007aff')
                        resutlinfo(res)
                    }
                    $('#modal_event').hide();
                }
            })
        }
        reader.readAsDataURL(this.files[0]);
    }else{
        toastr.warning('Vui lòng upload file ảnh')
        $('#modal_event').hide();
    }
    $(this).val('')
})

function upload_cccdsau(id){
    $('#upload_cccdsau').click();
}

$('#upload_cccdsau').on('change',function(e){
    $('#modal_event').show();
    e.preventDefault();
    var id_user = $(this).attr('id-user')
    var type = this.files[0].type
    if(type == 'image/png' || type == 'image/pjpeg' || type == 'image/jpeg' || type == 'image/jpg'){
        var reader = new FileReader();
        reader.onload = function (event) {
            src = event.target.result
            $('#upload_cccdsau_3').attr('src',src)
            $.ajax({
                url: "/thongtincanhan/upload_cccdsau",
                type:'POST',
                data: {
                    src: src,
                    id_user: id_user,
                },
                success:function(res){
                    if(res.act == "UpOrIns_1"){
                        resutlinfo(res.act)
                        $('#upload_img_icon_upload_cccdsau_3').css('color','#007aff')
                        $('#upload_img_text_upload_cccdsau_3').css('color','#007aff')
                    }else{
                        $('#upload_img_icon_upload_cccdsau_3').css('color','rgb(242, 4, 4)')
                        $('#upload_img_text_upload_cccdsau_3').css('color','#007aff')
                        resutlinfo(res)
                    }
                    $('#modal_event').hide();
                }
            })
        }
        reader.readAsDataURL(this.files[0]);
    }else{
        toastr.warning('Vui lòng upload file ảnh')
        $('#modal_event').hide();
    }
    $(this).val('')
})

function upload_hbhocbalop10(id){
    $('#upload_hbhocbalop10').click();
}

$('#upload_hbhocbalop10').on('change',function(e){
    $('#modal_event').show();
    e.preventDefault();
    var id_user = $(this).attr('id-user')
    var type = this.files[0].type
    if(type == 'image/png' || type == 'image/pjpeg' || type == 'image/jpeg' || type == 'image/jpg'){
        var reader = new FileReader();
        reader.onload = function (event) {
            src = event.target.result
            $('#upload_hbhocbalop10_4').attr('src',src)
            $.ajax({
                url: "/thongtincanhan/upload_hbhocbalop10",
                type:'POST',
                data: {
                    src: src,
                    id_user: id_user,
                },
                success:function(res){
                    if(res.act == "UpOrIns_1"){
                        resutlinfo(res.act)
                        $('#upload_img_icon_upload_hbhocbalop10_4').css('color','#007aff')
                        $('#upload_img_text_upload_hbhocbalop10_4').css('color','#007aff')
                    }else{
                        $('#upload_img_icon_upload_hbhocbalop10_4').css('color','rgb(242, 4, 4)')
                        $('#upload_img_text_upload_hbhocbalop10_4').css('color','#007aff')
                        resutlinfo(res)
                    }
                    $('#modal_event').hide();
                }
            })
        }
        reader.readAsDataURL(this.files[0]);
    }else{
        toastr.warning('Vui lòng upload file ảnh')
        $('#modal_event').hide();
    }
    $(this).val('')
})

function upload_hocbathongtin(id){
    $('#upload_hocbathongtin').click();
}

$('#upload_hocbathongtin').on('change',function(e){
    $('#modal_event').show();
    e.preventDefault();
    var id_user = $(this).attr('id-user')
    var type = this.files[0].type
    if(type == 'image/png' || type == 'image/pjpeg' || type == 'image/jpeg' || type == 'image/jpg'){
        var reader = new FileReader();
        reader.onload = function (event) {
            src = event.target.result
            $('#upload_hocbathongtin_10').attr('src',src)
            $.ajax({
                url: "/thongtincanhan/upload_hocbathongtin",
                type:'POST',
                data: {
                    src: src,
                    id_user: id_user,
                },
                success:function(res){
                    if(res.act == "UpOrIns_1"){
                        resutlinfo(res.act)
                        $('#upload_img_icon_upload_hocbathongtin_10').css('color','#007aff')
                        $('#upload_img_text_upload_hocbathongtin_10').css('color','#007aff')
                    }else{
                        $('#upload_img_icon_upload_hocbathongtin_10').css('color','rgb(242, 4, 4)')
                        $('#upload_img_text_upload_hocbathongtin_10').css('color','#007aff')
                        resutlinfo(res)
                    }
                    $('#modal_event').hide();
                }
            })
        }
        reader.readAsDataURL(this.files[0]);
    }else{
        toastr.warning('Vui lòng upload file ảnh')
        $('#modal_event').hide();
    }
    $(this).val('')
})

function upload_hocbalop11(id){
    $('#upload_hocbalop11').click();
}

$('#upload_hocbalop11').on('change',function(e){
    $('#modal_event').show();
    e.preventDefault();
    var id_user = $(this).attr('id-user')
    var type = this.files[0].type
    if(type == 'image/png' || type == 'image/pjpeg' || type == 'image/jpeg' || type == 'image/jpg'){
        var reader = new FileReader();
        reader.onload = function (event) {
            src = event.target.result
            $('#upload_hocbalop11_5').attr('src',src)
            $.ajax({
                url: "/thongtincanhan/upload_hocbalop11",
                type:'POST',
                data: {
                    src: src,
                    id_user: id_user,
                },
                success:function(res){
                    if(res.act == "UpOrIns_1"){
                        resutlinfo(res.act)
                        $('#upload_img_icon_upload_hocbalop11_5').css('color','#007aff')
                        $('#upload_img_text_upload_hocbalop11_5').css('color','#007aff')
                    }else{
                        $('#upload_img_icon_upload_hocbalop11_5').css('color','rgb(242, 4, 4)')
                        $('#upload_img_icon_upload_hocbalop11_5').css('color','#007aff')
                        resutlinfo(res)
                    }
                    $('#modal_event').hide();
                }
            })
        }
        reader.readAsDataURL(this.files[0]);
    }else{
        toastr.warning('Vui lòng upload file ảnh')
        $('#modal_event').hide();
    }
    $(this).val('')
})

function upload_hbhocbalop12(id){
    $('#upload_hbhocbalop12').click();
}

$('#upload_hbhocbalop12').on('change',function(e){
    $('#modal_event').show();
    e.preventDefault();
    var id_user = $(this).attr('id-user')
    var type = this.files[0].type
    if(type == 'image/png' || type == 'image/pjpeg' || type == 'image/jpeg' || type == 'image/jpg'){
        var reader = new FileReader();
        reader.onload = function (event) {
            src = event.target.result
            $('#upload_hbhocbalop12_6').attr('src',src)
            $.ajax({
                url: "/thongtincanhan/upload_hbhocbalop12",
                type:'POST',
                data: {
                    src: src,
                    id_user: id_user,
                },
                success:function(res){
                    if(res.act == "UpOrIns_1"){
                        resutlinfo(res.act)
                        $('#upload_img_icon_upload_hbhocbalop12_6').css('color','#007aff')
                        $('#upload_img_text_upload_hbhocbalop12_6').css('color','#007aff')
                    }else{
                        $('#upload_img_icon_upload_hbhocbalop12_6').css('color','rgb(242, 4, 4)')
                        $('#upload_img_text_upload_hbhocbalop12_6').css('color','#007aff')
                        esutlinfo(res)
                    }
                    $('#modal_event').hide('slow');
                }
            })
        }
        reader.readAsDataURL(this.files[0]);
    }else{
        toastr.warning('Vui lòng upload file ảnh')
        $('#modal_event').hide('slow');
    }
    $(this).val('')
})

function upload_uutien1(id){
    $('#upload_uutien1').click();
}

$('#upload_uutien1').on('change',function(e){
    $('#modal_event').show();
    e.preventDefault();
    var id_user = $(this).attr('id-user')
    var type = this.files[0].type
    if(type == 'image/png' || type == 'image/pjpeg' || type == 'image/jpeg' || type == 'image/jpg'){
        var reader = new FileReader();
        reader.onload = function (event) {
            src = event.target.result
            $('#upload_uutien1_7').attr('src',src)
            $.ajax({
                url: "/thongtincanhan/upload_uutien1",
                type:'POST',
                data: {
                    src: src,
                    id_user: id_user,
                },
                success:function(res){
                    if(res.act == "UpOrIns_1"){
                        $('#upload_img_icon_upload_uutien1_7').css('color','#007aff')
                        $('#upload_img_text_upload_uutien1_7').css('color','#007aff')
                        resutlinfo(res.act)
                    }else{
                        $('#upload_img_icon_upload_uutien1_7').css('color','rgb(242, 4, 4)')
                        $('#upload_img_text_upload_uutien1_7').css('color','#007aff')
                        resutlinfo(res)
                    }
                    $('#modal_event').hide();
                }
            })
        }
        reader.readAsDataURL(this.files[0]);
    }else{
        toastr.warning('Vui lòng upload file ảnh')
        $('#modal_event').hide();
    }
    $(this).val('')
})

function upload_uutien2(id){
    $('#upload_uutien2').click();
}

$('#upload_uutien2').on('change',function(e){
    $('#modal_event').show();
    e.preventDefault();
    var id_user = $(this).attr('id-user')
    var type = this.files[0].type
    if(type == 'image/png' || type == 'image/pjpeg' || type == 'image/jpeg' || type == 'image/jpg'){
        var reader = new FileReader();
        reader.onload = function (event) {
            src = event.target.result
            $('#upload_uutien2_8').attr('src',src)
            $.ajax({
                url: "/thongtincanhan/upload_uutien2",
                type:'POST',
                data: {
                    src: src,
                    id_user: id_user,
                },
                success:function(res){
                    if(res.act == "UpOrIns_1"){
                        resutlinfo(res.act)
                        $('#upload_img_icon_upload_uutien2_8').css('color','#007aff')
                        $('#upload_img_text_upload_uutien2_8').css('color','#007aff')
                    }else{
                        $('#upload_img_icon_upload_uutien2_8').css('color','rgb(242, 4, 4)')
                        $('#upload_img_text_upload_uutien2_8').css('color','#007aff')
                        resutlinfo(res)
                    }
                    $('#modal_event').hide();
                }
            })
        }
        reader.readAsDataURL(this.files[0]);
    }else{
        toastr.warning('Vui lòng upload file ảnh')
        $('#modal_event').hide();
    }
    $(this).val('')
})

function upload_bangtotnghiep(id){
    $('#upload_bangtotnghiep').click();
}

$('#upload_bangtotnghiep').on('change',function(e){
    $('#modal_event').show();
    e.preventDefault();
    var id_user = $(this).attr('id-user')
    var type = this.files[0].type
    if(type == 'image/png' || type == 'image/pjpeg' || type == 'image/jpeg' || type == 'image/jpg'){
        var reader = new FileReader();
        reader.onload = function (event) {
            src = event.target.result
            $('#upload_bangtotnghiep_9').attr('src',src)
            $.ajax({
                url: "/thongtincanhan/upload_bangtotnghiep",
                type:'POST',
                data: {
                    src: src,
                    id_user: id_user,
                },
                success:function(res){
                    if(res.act == "UpOrIns_1"){
                        resutlinfo(res.act)
                        $('#upload_img_icon_upload_bangtotnghiep_9').css('color','#007aff')
                        $('#upload_img_text_upload_bangtotnghiep_9').css('color','#007aff')
                    }else{
                        $('#upload_img_icon_upload_bangtotnghiep_9').css('color','rgb(242, 4, 4)')
                        $('#upload_img_text_upload_bangtotnghiep_9').css('color','#007aff')
                        resutlinfo(res)
                    }
                    $('#modal_event').hide();
                }
            })
        }
        reader.readAsDataURL(this.files[0]);
    }else{
        toastr.warning('Vui lòng upload file ảnh')
        $('#modal_event').hide();
    }
    $(this).val('')
})

function upload_gxnkqthi(id){
    $('#upload_gxnkqthi').click();
}


$('#upload_gxnkqthi').on('change',function(e){
    $('#modal_event').show();
    e.preventDefault();
    var id_user = $(this).attr('id-user')
    var type = this.files[0].type
    if(type == 'image/png' || type == 'image/pjpeg' || type == 'image/jpeg' || type == 'image/jpg'){
        var reader = new FileReader();
        reader.onload = function (event) {
            src = event.target.result
            $('#upload_gxnkqthi_11').attr('src',src)
            $.ajax({
                url: "/thongtincanhan/upload_gxnkqthi",
                type:'POST',
                data: {
                    src: src,
                    id_user: id_user,
                },
                success:function(res){
                    if(res.act == "UpOrIns_1"){
                        resutlinfo(res.act)
                        $('#upload_img_icon_upload_gxnkqthi').css('color','#007aff')
                        $('#upload_img_text_upload_gxnkqthi').css('color','#007aff')
                    }else{
                        $('#upload_img_icon_upload_gxnkqthi').css('color','rgb(242, 4, 4)')
                        $('#upload_img_text_upload_gxnkqthi').css('color','#007aff')
                        resutlinfo(res)
                    }
                    $('#modal_event').hide();
                }
            })
        }
        reader.readAsDataURL(this.files[0]);
    }else{
        toastr.warning('Vui lòng upload file ảnh')
        $('#modal_event').hide();
    }
    $(this).val('')
})

function upload_gxntntamthoi(id){
    $('#upload_gxntntamthoi').click();
}
$('#upload_gxntntamthoi').on('change',function(e){
    $('#modal_event').show();
    e.preventDefault();
    var id_user = $(this).attr('id-user')
    var type = this.files[0].type
    if(type == 'image/png' || type == 'image/pjpeg' || type == 'image/jpeg' || type == 'image/jpg'){
        var reader = new FileReader();
        reader.onload = function (event) {
            src = event.target.result
            $('#upload_gxntntamthoi_12').attr('src',src)
            $.ajax({
                url: "/thongtincanhan/upload_gxntntamthoi",
                type:'POST',
                data: {
                    src: src,
                    id_user: id_user,
                },
                success:function(res){
                    if(res.act == "UpOrIns_1"){
                        resutlinfo(res.act)
                        $('#upload_img_icon_upload_gxntntamthoi').css('color','#007aff')
                        $('#upload_img_text_upload_gxntntamthoi').css('color','#007aff')
                    }else{
                        $('#upload_img_icon_upload_gxntntamthoi').css('color','rgb(242, 4, 4)')
                        $('#upload_img_text_upload_gxntntamthoi').css('color','#007aff')
                        resutlinfo(res)
                    }
                    $('#modal_event').hide();
                }
            })
        }
        reader.readAsDataURL(this.files[0]);
    }else{
        toastr.warning('Vui lòng upload file ảnh')
        $('#modal_event').hide();
    }
    $(this).val('')
})

function upload_bhyt(id){
    $('#upload_bhyt').click();
}
$('#upload_bhyt').on('change',function(e){
    $('#modal_event').show();
    e.preventDefault();
    var id_user = $(this).attr('id-user')
    var type = this.files[0].type
    if(type == 'image/png' || type == 'image/pjpeg' || type == 'image/jpeg' || type == 'image/jpg'){
        var reader = new FileReader();
        reader.onload = function (event) {
            src = event.target.result
            $('#upload_bhyt_13').attr('src',src)
            $.ajax({
                url: "/thongtincanhan/upload_bhyt",
                type:'POST',
                data: {
                    src: src,
                    id_user: id_user,
                },
                success:function(res){
                    if(res.act == "UpOrIns_1"){
                        resutlinfo(res.act)
                        $('#upload_img_icon_upload_bhyt').css('color','#007aff')
                        $('#upload_img_text_upload_bhyt').css('color','#007aff')
                    }else{
                        $('#upload_img_icon_upload_bhyt').css('color','rgb(242, 4, 4)')
                        $('#upload_img_text_upload_bhyt').css('color','#007aff')
                        resutlinfo(res)
                    }
                    $('#modal_event').hide();
                }
            })
        }
        reader.readAsDataURL(this.files[0]);
    }else{
        toastr.warning('Vui lòng upload file ảnh')
        $('#modal_event').hide();
    }
    $(this).val('')
})



















function dangxuat(){
    $.ajax({
        type: "post",
        url: "/logout",
        success:function(){
            window.location="/";
        }
    });
}
function videohuongdan(){
    $('#videohuongdan').show()
    $('#youtube_player').attr('src','https://www.youtube.com/embed/o_GcFm8Gd-Y?si=W49jAe6u67Gs8bKU')
}

function videohuongdan_close(){
    $('#youtube_player').attr('src','')
    $('#videohuongdan').hide('slow')
}




