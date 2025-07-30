$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    danhmuc_hoso(0);
});


//load dot tuyen sinh
loaddottuyensinh()
//dottuyensinh
$('#dottuyensinh').select2()
// loaddanhmuc()

//noisinh
$('#id_tinh_noisinh').select2()
$('#id_huyen_noisinh').select2()
$('#id_xa_noisinh').select2()
//quequan
$('#id_tinh_quequan').select2()
$('#id_huyen_quequan').select2()
$('#id_xa_quequan').select2()
//ttru
$('#id_tinh_ttru').select2()
$('#id_huyen_ttru').select2()
$('#id_xa_ttru').select2()

//noicapcccd
$('#noicapcccd').select2()
//dantoc
$('#id_dantoc').select2()

//quoctich
$('#id_quoctich').select2()
//tongiao
$('#id_tongiao').select2()
//khuyettat
$('#khuyettat').select2()

function loaddottuyensinh() {
    $.ajax({
        type: "get",
        url: "hosonhaphoc/loaddottuyensinh",
        //load data tỉnh
        success: function (data) {
            $('#dottuyensinh').select2({
                data: data.batch
            })

        }
    });
}

function loadtinh() {
    $.ajax({
        type: "get",
        url: "hosonhaphoc/loadtinh",
        //load data tỉnh
        success: function (data) {
            $('#capnnhatdiachi_noisinh').select2({
                data: data
            })

        }
    });
}


// Hàm load select2 huyện
function loadhuyen(id_tinh,id_cap2,id_cap3) {
    // thay thế vị trí
    $('#'+id_cap2).empty()
    $('#'+id_cap3).empty()
    $.ajax({
        type: "get",
        url: "hosonhaphoc/loadhuyen/" + id_tinh,
        // load data huyện
        success: function (res) {
            $('#'+id_cap2).select2({
                data: res
            })
        }
    });
}
// Hàm load select2 xã
function loadxa(id_huyen,id_cap3) {
    // thay thế vị trí
    $('#'+id_cap3).empty()
    $.ajax({
        type: "get",
        url: "hosonhaphoc/loadxa/" + id_huyen,

        // load data xã
        success: function (res) {
            $('#'+id_cap3).select2({
                data: res
            })
        }
    });
}
// Hàm load select2 tỉnh
function loadtinh2() {
    $.ajax({
        type: "get",
        url: "hosonhaphoc/loadtinh2",
        //load data tỉnh
        success: function (data) {
            $('#id_tinh_ttru').select2({
                data: data
            })
        }
    });
}
// Hàm load select2 huyện
function loadhuyen2() {
    // thay thế vị trí
    $('#id_huyen_ttru').empty()
    $('#id_xa_ttru').empty()

    // lấy id tỉnh
    var tinh2 = $('#id_tinh_ttru').val();
    $.ajax({
        type: "get",
        url: "hosonhaphoc/loadhuyen2/" + tinh2,

        // load data huyện
        success: function (res) {
            $('#id_huyen_ttru').select2({
                data: res
            })

        }
    });
}
// Hàm load select2 xã
function loadxa2() {
    // thay thế vị trí
    $('#id_xa_ttru').empty()

    // lấy id huyện
    var huyen2 = $('#id_huyen_ttru').val();
    $.ajax({
        type: "get",
        url: "hosonhaphoc/loadxa/" + huyen2,

        // load data xã
        success: function (res) {
            $('#id_xa_ttru').select2({
                data: res
            })


        }
    });
}
//quequan
// Hàm load select3 tỉnh
function loadtinh3() {
    $.ajax({
        type: "get",
        url: "hosonhaphoc/loadtinh3",
        //load data tỉnh
        success: function (data) {
            $('#id_tinh_quequan').select2({
                data: data
            })
        }
    });
}
// Hàm load select3 huyện
function loadhuyen3() {
    // thay thế vị trí
    $('#id_huyen_quequan').empty()
    $('#id_xa_quequan').empty()

    // lấy id tỉnh
    var tinh3 = $('#id_tinh_quequan').val();
    $.ajax({
        type: "get",
        url: "hosonhaphoc/loadhuyen3/" + tinh3,

        // load data huyện
        success: function (res) {
            $('#id_huyen_quequan').select2({
                data: res
            })

        }
    });
}
// Hàm load select3 xã
function loadxa3() {
    // thay thế vị trí
    $('#id_xa_quequan').empty()

    // lấy id huyện
    var huyen3 = $('#id_huyen_quequan').val();
    $.ajax({
        type: "get",
        url: "hosonhaphoc/loadxa/" + huyen3,

        // load data xã
        success: function (res) {
            $('#id_xa_quequan').select2({
                data: res
            })

        }
    });
}

function loadtoanbothongtin(){
    var mssv = $('#search_mssv').val();
    var cccd = $('#cccd').val();
    loadttcn_qlsv(mssv,cccd)
    danhmuc_hoso(mssv,cccd)
}
//Load thong tin cá nhân
function loadttcn_qlsv(mssv,cccd)
{
    $.ajax({
        type: "post",
        url: "hosonhaphoc/loadttcn_qlsv",
        data: {
            cccd: cccd,
            // dottuyensinh: dottuyensinh,
            mssv: mssv
        },
        success: function (res) {
            switch (res['trangthai']) {
                case 'up_2':
                    hsnh_resetformthongtincannhan()
                    toastr.warning('CCCD không khớp với MSSV');
                    break;
                case 'up_3':
                    toastr.warning('Vui lòng nhập CCCD hoặc MSSV');
                    hsnh_resetformthongtincannhan()
                    break;
                case 1:
                    var res = res['data']
                    $('#hoten').val(res.hoten);
                    $('#hoten').attr('id_taikhoan', res.id_taikhoan);
                    $('#cccd_sv').val(res.cccd);
                    $('#dienthoai').val(res.dienthoai);
                    $('#ngaysinh').val(res.ngaysinh);
                    $('#giaykhaisinh').val(res.giaykhaisinh);
                    if(res.gioitinh == 0) {
                        $('#gioitinh').prop('checked',true);
                    }else{
                        $('#gioitinh').prop('checked',false);
                    }

                    $('#id_dantoc').select2({ data: res.dantoc });
                    $('#id_quoctich').select2({ data: res.quoctich });
                    $('#id_tongiao').select2({ data: res.tongiao });
                    $('#ngaycapcccd').val(res.ngaycapcccd);
                    $('#noicapcccd').select2({ data: res.noicapcccd });
                    $('#ngayvaodang').val(res.ngayvaodang);
                    $('#ngayvaodoan').val(res.ngayvaodoan);
                    $('#id_tinh_noisinh').select2({ data: res.noisinh_tinh });
                    $('#id_huyen_noisinh').select2({ data: res.noisinh_huyen });
                    $('#id_xa_noisinh').select2({ data: res.noisinh_xa });
                    $('#id_tinh_quequan').select2({ data: res.quequan_tinh });
                    $('#id_huyen_quequan').select2({ data: res.quequan_huyen });
                    $('#id_xa_quequan').select2({ data: res.quequan_xa });
                    $('#id_tinh_ttru').select2({ data: res.ttru_tinh });
                    $('#id_huyen_ttru').select2({ data: res.ttru_huyen });
                    $('#id_xa_ttru').select2({ data: res.ttru_xa });
                    $('#duoi_xa_quequan').val(res.duoi_xa_quequan);
                    $('#duoi_xa_ttru').val(res.duoi_xa_ttru);
                    $('#hotencha').val(res.hotencha);
                    $('#hotenme').val(res.hotenme);
                    $('#nguoidodau').val(res.nguoidodau);
                    $('#dienthoaicha').val(res.dienthoaicha);
                    $('#dienthoaime').val(res.dienthoaime);
                    $('#dienthoainguoidodau').val(res.dienthoainguoidodau);
                    $('#nghenghiepcha').val(res.nghenghiepcha);
                    $('#nghenghiepme').val(res.nghenghiepme);
                    $('#nghenghiepnguoidodau').val(res.nghenghiepnguoidodau);
                    $('#khuyettat').select2({ data: res.khuyettat });
                    $('#bhyt').val(res.bhyt);
                    $('#diachi').val(res.diachi);
                    $('#ghichu').val(res.ghichu);
                    // if(res.mssv == null){
                    //     $('#mssv').attr('disabled',false);
                    // }else{
                    //     $('#mssv').attr('disabled','true');
                    // }
                    $('#mssv').val(res.mssv);
                    let html_lichsu = "";
                    res.lichsu.forEach(function(item){
                        if(item.id_nhansu == 0){
                                html_lichsu += '<div class="direct-chat-msg">'
                                    html_lichsu += '<div class="direct-chat-infos clearfix">'
                                        html_lichsu += '<span class="direct-chat-name float-left">'+item.tenthisinh+'</span>'
                                        html_lichsu += '<span class="direct-chat-timestamp float-right">'+item.create_at+'</span>'
                                    html_lichsu += '</div>'
                                    html_lichsu += '<img class="direct-chat-img" src="'+item.img_gg+'" alt="message user image">'
                                    html_lichsu += '<div style="background-color: #fff" class="direct-chat-text">'
                                        html_lichsu += item.noidung
                                    html_lichsu += '</div>'
                                html_lichsu += '</div>'
                        }else{
                                html_lichsu += '<div class="direct-chat-msg right">'
                                    html_lichsu += '<div class="direct-chat-infos clearfix">'
                                        html_lichsu += '<span class="direct-chat-name float-right">'+item.name+'</span>'
                                        html_lichsu += '<span class="direct-chat-timestamp float-left">'+item.create_at+'</span>'
                                    html_lichsu +='</div>'
                                    html_lichsu +='<img class="direct-chat-img" src="/img/CTUT_logo.png" alt="message user image">'
                                    html_lichsu +='<div class="direct-chat-text">'
                                        html_lichsu += item.noidung
                                    html_lichsu +='</div>'
                                html_lichsu +='</div>'
                        }
                    });
                    $('#lichsu').html(html_lichsu)
                    slider()
                    break;
                default:
                    thongbao(res['trangthai'])
                    hsnh_resetformthongtincannhan()
                    break;
            }
        }

        // $('#dottuyensinh').select2({data:res.batch});
    });
}

function hsnh_resetformthongtincannhan(){
    $('#hoten').removeAttr('id_taikhoan');
    $('#hoten').val('');
    $('#cccd_sv').val('');
    $('#dienthoai').val('');
    $('#ngaysinh').val('');
    $('#giaykhaisinh').val('');
    $('#gioitinh').prop('checked', 0);
    $('#id_dantoc').empty();
    $('#id_quoctich').empty();
    $('#id_tongiao').empty();
    $('#ngaycapcccd').val('');
    $('#noicapcccd').empty();
    $('#ngayvaodoan').val('');
    $('#ngayvaodang').val('');
    $('#id_tinh_noisinh').empty();
    $('#id_huyen_noisinh').empty();
    $('#id_xa_noisinh').empty();
    $('#id_tinh_quequan').empty();
    $('#id_huyen_quequan').empty();
    $('#id_xa_quequan').empty();
    $('#id_tinh_ttru').empty();
    $('#id_huyen_ttru').empty();
    $('#id_xa_ttru').empty();
    $('#duoi_xa_quequan').val('');
    $('#duoi_xa_ttru').val('');
    $('#hotencha').val('');
    $('#hotenme').val('');
    $('#nguoidodau').val('');
    $('#dienthoaicha').val('');
    $('#dienthoaime').val('');
    $('#dienthoainguoidodau').val('');
    $('#nghenghiepcha').val('');
    $('#nghenghiepme').val('');
    $('#nghenghiepnguoidodau').val('');
    $('#khuyettat').empty();
    $('#bhyt').val('');
    $('#diachilienlac').val('');
    $('#mssv').val('');
    $('#slider').html('<div class="swiper-slide" style="position: relative; height: 580px;">' +
        '<div class="swiper-zoom-container" style="height: 580px;">' +
            '<img src="/img/test.png">' +
        '</div>' +
    '</div>');
    $('#lichsu').html('');
}

//danh muc
function danhmuc_hoso(mssv,cccd)//Co ho so
{
    $.ajax({
        type: 'post',
        url: 'hosonhaphoc/danhmuchoso',
        data: {
            mssv: mssv,
            cccd: cccd,
        },
        success: function (res) {
            var result = ''
            for (let i = 0; i < res['danhmuc'].length; i++) {
                if(res['danhmuc'][i]['id_hoso'] == null){
                    checked = ''
                }else{
                    checked = 'checked'
                }
                result += '<div class="col-12">'
                    result +=   '<input type="checkbox" '+checked+' id = "danhmuchoso_'+res['id_taikhoan']+'_'+res['danhmuc'][i]['danhmuc_hoso_id']+'" class="nhanhoso" onchange="nhanhoso('+res['id_taikhoan']+','+res['danhmuc'][i]['danhmuc_hoso_id']+','+res['danhmuc'][i]['id_check']+')"  style="height:13px" >'
                    result +=   '&nbsp;&nbsp;&nbsp;<label for="danhmuchoso_'+res['id_taikhoan']+'_'+res['danhmuc'][i]['danhmuc_hoso_id']+'"  style="padding-bottom: 0px; margin-bottom:0.3rem"><span style="font-weight:normal">' + res['danhmuc'][i]['danhmuc_hoso_ten'] + '</span></label>'
                result += '</div>'
            }
            $('#hsnh_danhmuchoso').html(result);
        }
    });
}

function nhanhoso(id_taikhoan,danhmuc_hoso_id,id_check){
    $('.nhanhoso').attr('disabled',true)
    $('#modal_event').show()
    setTimeout(() => {
        if(id_taikhoan == 0){
            toastr.warning('Vui lòng nhập thông tin tìm kiếm sinh viên')
            $('#danhmuchoso_'+id_taikhoan+'_'+danhmuc_hoso_id).prop('checked',false)
            $('#modal_event').hide()
        }else{
            // var id_check = 0;
            // $('#danhmuchoso_'+id_taikhoan+'_'+danhmuc_hoso_id).prop('checked') == true ? id_check = 1 : id_check = 0
            $.ajax({
                type: 'post',
                url: 'hosonhaphoc/nhanhoso',
                data: {
                    id_taikhoan: id_taikhoan,
                    danhmuc_hoso_id: danhmuc_hoso_id,
                    id_check: id_check
                },
                success: function (res) {
                    loadtoanbothongtin()
                    thongbao(res)
                    $('#modal_event').hide()
                }
            });
        }
        // $('#modal_event').hide()
    }, 800);
}

$('.capnhatttcn').on('change', function () {
    var id_taikhoan = $('#hoten').attr('id_taikhoan')
    var table = $(this).attr('table')
    var id = $(this).attr('id')
    if(id == 'gioitinh'){
        if ($('#gioitinh').prop('checked')==true) {
            var val = 0;
        } else {
            var val = 1;
        }
    }else{
        var val = $(this).val()
    }
    $.ajax({
        type: "post",
        url: "hosonhaphoc/capnhatthongtincannhan",
        data: {
            id_taikhoan: id_taikhoan,
            val: val,
            table: table,
            id: id
        },
        success: function (res) {
            if (res.maloi == 'vali_1') {
                toastr.warning(res.data['original']['val'][0])
            } else {
                thongbao(res)
                loadtoanbothongtin();
            }

        }
    })

})

$('.capnnhatdiachi_tinh').on('change', function () {
    var id_cap2 = $(this).attr('id_cap2')
    var id_cap3 = $(this).attr('id_cap3')
    var val = $(this).val();
    var id_data = $(this).attr('id_data')
    var id_thongtin = $(this).attr('id_thongtin')
    var id_taikhoan = $('#hoten').attr('id_taikhoan')
    $.ajax({
        type: "post",
        url: "hosonhaphoc/capnhatdiachi_tinh",
        data: {
            id_taikhoan: id_taikhoan,
            val: val,
            id_thongtin: id_thongtin,
            id_data: id_data,
            id_cap2: id_cap2,
            id_cap3: id_cap3,
        },
        success: function (res) {
            if (res.maloi == 'vali_1') {
                toastr.warning(res.data['original']['val'][0])
            } else {
                thongbao(res)
                loadhuyen(val,id_cap2,id_cap3)
            }
        }
    })
})


$('.capnnhatdiachi_huyen').on('change', function () {
    var id_cap3 = $(this).attr('id_cap3')
    var val = $(this).val();
    var id_data = $(this).attr('id_data')
    var id_thongtin = $(this).attr('id_thongtin')
    var id_taikhoan = $('#hoten').attr('id_taikhoan')
    $.ajax({
        type: "post",
        url: "hosonhaphoc/capnhatdiachi_huyen",
        data: {
            id_taikhoan: id_taikhoan,
            val: val,
            id_thongtin: id_thongtin,
            id_data: id_data,
            id_cap3: id_cap3,
        },
        success: function (res) {
            if (res.maloi == 'vali_1') {
                toastr.warning(res.data['original']['val'][0])
            } else {
                thongbao(res)
                loadxa(val,id_cap3)
            }
        }
    })
})

$('.capnhatdiachi_xa').on('change', function () {
    var val = $(this).val();
    var id_data = $(this).attr('id_data')
    var id_thongtin = $(this).attr('id_thongtin')
    var id_taikhoan = $('#hoten').attr('id_taikhoan')
    $.ajax({
        type: "post",
        url: "hosonhaphoc/capnhatdiachi_xa",
        data: {
            id_taikhoan: id_taikhoan,
            val: val,
            id_thongtin: id_thongtin,
            id_data: id_data,
        },
        success: function (res) {
            if (res.maloi == 'vali_1') {
                toastr.warning(res.data['original']['val'][0])
            } else {
                thongbao(res)
                loadxa(val,id_cap3)
            }
        }
    })
})

function slider() {
    var id_taikhoan = $('#hoten').attr('id_taikhoan')
    $.ajax({
        type: 'post',
        url: 'hosonhaphoc/slider',
        data: {
            id_taikhoan: id_taikhoan
        },
        success: function (res) {
            var result = '';
            res.forEach(function (item) {
                result += '<div class="swiper-slide" style="position: relative; height: 580px;">' +
                    '<div class="swiper-zoom-container" style="height: 580px;">' +
                    '<i onclick = "if (confirm(\'Bạn có chắc chắn muốn xóa hình này?\')) { xoahinhhhsnh(' + id_taikhoan + ',' + item.id + '); }" style="color: #f40f02; position: absolute; top: 6px; left: 90%; z-index: 10; font-size: 24px;" class="fa-regular fa-circle-xmark"></i>'+
                    '<img src="' + item.path_img + '">' +
                    '</div>' +
                    '</div>';
            });
            $('#slider').html(result);
        }

    });
}

function xoahinhhhsnh(id_taikhoan,id){
    $('#modal_event').show()
    setTimeout(() => {
        if(id_taikhoan == 0){
            toastr.warning('Vui lòng nhập thông tin tìm kiếm sinh viên')
        }else{
            $.ajax({
                type: 'post',
                url: 'hosonhaphoc/xoahinhhhsnh',
                data: {
                    id_taikhoan: id_taikhoan,
                    id: id
                },
                success: function (res) {
                    loadtoanbothongtin()
                    thongbao(res)
                    $('#modal_event').hide()
                }
            });
        }
        $('#modal_event').hide()
    }, 800);
}


function text_mssv() {
    var mssv = $('#text_mssv').val();
    var id_taikhoan = $('#hoten').attr('id_taikhoan');
    $.ajax({
        type: 'post',
        url: 'hosonhaphoc/nhapmssv',
        data: {
            mssv: mssv,
            id_taikhoan: id_taikhoan
        },
        success: function (res) {
            if (res.status === 'exists') {
                toastr.warning('Đã tồn tại MSSV');
            } else if (res.status === 'success') {
                toastr.success('Lưu thành công');
                $('#text_mssv').attr('disabled','true');
            } else {
                toastr.error('Đã có lỗi xảy ra');
            }
        },
        error: function () {
            toastr.error('Hệ thống đang lỗi!');
        }
    });
}

