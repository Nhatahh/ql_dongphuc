$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    load_dssanpham_quanlynhap().ajax.url('load_sanpham_quanlynhap/0').load()
    load_dssanpham_dot().ajax.url('load_dssanpham_dot/-1').load()
    $('#loadsanphamdotnhap_filter').hide();
    $('#loadSanphamQLN_filter').hide();
    $("#qlnhap_iddot").select2()
    ds_dotnhap()

});

function adjustView() {
    var nhapMobile = document.getElementsByClassName('nhap_mobile');
    var nhapPc = document.getElementsByClassName('nhap_pc');
    if (window.innerWidth <= 1000) {
        for (var i = 0; i < nhapMobile.length; i++) {
            nhapMobile[i].style.display = 'block';
        }
        for (var i = 0; i < nhapPc.length; i++) {
            nhapPc[i].style.display = 'none';
        }
    } else {
        for (var i = 0; i < nhapPc.length; i++) {
            nhapPc[i].style.display = 'block';
        }
        for (var i = 0; i < nhapMobile.length; i++) {
            nhapMobile[i].style.display = 'none';
        }
    }
    $("#modal_nhapdongphuc").hide()
}
document.addEventListener('DOMContentLoaded', adjustView);
window.addEventListener('resize', adjustView);
function hienthi() {
    var nhapMobile = document.getElementsByClassName('nhap_mobile');
    var nhapPc = document.getElementsByClassName('nhap_pc');
    if (window.innerWidth <= 1000) {
        return 1;
    } else {
        return 0;
    }
}

function ds_dotnhap(){
    $.ajax({
        type: "get",
        url: "ds_dotnhap",
        dataType: "json",
        success: function (res) {
            $("#qlnhap_iddot").select2({data: res.load_sanpham_dotnhap});
        },
    });
}
// Tabledata danh sách sản phẩm nhập theo đợt
function load_dssanpham_quanlynhap() {
    let today = new Date();
    let year = today.getFullYear();
    let month = (today.getMonth() + 1).toString().padStart(2, '0'); // Tháng bắt đầu từ 0 nên cần +1
    let day = today.getDate().toString().padStart(2, '0');
    let ngayhientai = `${year}-${month}-${day}`;

    let id_dotnhap = $('#qlnhap_iddot').val()
    var table = $("#loadSanphamQLN").DataTable({
        ajax: "load_sanpham_quanlynhap/" + id_dotnhap,
        columns: [
            {
                targets: 0,
                name: 'stt',
                width: "1%",
                title: "STT",
                data: "stt",
                className: "text-center align-middle",
            },
            {
                name: "masp",
                title: "<div class = 'title_datatables'>Mã SP</div><div class = 'div_datatables'><input id='loadSanphamQLN_masp' onkeyup = search_datatables('loadSanphamQLN_masp') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "masp",
                render: function(data, type, row, meta) {
                    if (type === 'display') {
                        return '<input disabled style = "border: none;" type="text" class=" edit_tabledata" value="' + data + '" />';
                    }
                    return data;
                }
            },
            {
                name: "loai",
                title: "<div class = 'title_datatables'>Loại sản phẩm</div><div class = 'div_datatables'><input id='loadSanphamQLN_loai' onkeyup = search_datatables('loadSanphamQLN_loai') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "loai",
                render: function(data, type, row, meta) {
                    if (type === 'display') {
                        return '<input disabled style = "border: none;" type="text" class=" edit_tabledata" value="' + data + '" />';
                    }
                    return data;
                }
            },
            {
                name: "nhasanxuat",
                title: "<div class = 'title_datatables'>Nhà sản xuất</div><div class = 'div_datatables'><input id='loadSanphamQLN_nhasanxuat' onkeyup = search_datatables('loadSanphamQLN_nhasanxuat') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "nhasanxuat",
                render: function(data, type, row, meta) {
                    if (type === 'display') {
                        return '<input disabled style = "border: none;" type="text" class=" edit_tabledata" value="' + data + '" />';
                    }
                    return data;
                }
            },
            {
                name: "size",
                title: "<div class = 'title_datatables'>Size</div><div class = 'div_datatables'><input id='loadSanphamQLN_size' onkeyup = search_datatables('loadSanphamQLN_size') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "size",
                render: function(data, type, row, meta) {
                    if (type === 'display') {
                        return '<input disabled style = "border: none;" type="text" class=" edit_tabledata" value="' + data + '" />';
                    }
                    return data;
                }
            },
            {
                name: "soluongnhap",
                title: "<div class = 'title_datatables'>Số lượng nhập</div><div class = 'div_datatables'><input id='loadSanphamQLN_soluongnhap' onkeyup = search_datatables('loadSanphamQLN_soluongnhap') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "soluongnhap",
                render: function(data, type, row, meta) {
                    if (type === 'display') {
                        return '<input id_kiemtra = "'+row.id+'" id_dot_sanpham = "'+row.id_dot_sanpham+'" id_sanpham = "'+row.id_sanpham+'" soluongnhap_old = "'+data+'" id_dot = "'+row.id_dotnhap+'" style = "border: none;" type="text" class=" edit_tabledata" onchange= "capnhat_soluongnhap(event,'+row.id+')" id ="soluongnhap_desktop_'+row.id+'" value="' + data + '" />';
                    }
                    return data;
                }
            },
            {
                name: "ngaynhap",
                title: "<div class = 'title_datatables'>Ngày nhập</div><div class = 'div_datatables'><input id='loadSanphamQLN_ngaynhap' onkeyup = search_datatables('loadSanphamQLN_ngaynhap') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "ngaynhap",
                render: function(data, type, row, meta) {
                    if (type === 'display') {
                        if(data === null){
                            return '<input id_nhaphang = "'+row.id+'" id_dotnhap = "'+row.id_dotnhap+'" style = "width:90%; border:none" type="date" class=" edit_tabledata" id ="ngaynhap_'+row.id+'" value="'+ngayhientai+'" />';
                        }else{
                            return '<input disabled id_nhaphang = "'+row.id+'" id_dotnhap = "'+row.id_dotnhap+'" style = "width:90%; border:none" type="date" class=" edit_tabledata" onchange= "capnhat_ngaynhap('+row.id+')" id ="ngaynhap_'+row.id+'" value="' + data + '" />';
                        }
                    }
                    return data;
                }
            },
            {
                name: "dienthoai",
                title: "<div class = 'title_datatables'>Người nhập</div><div class = 'div_datatables'><input id='loadsanphamdotnhap_ngaynhap' onkeyup = search_datatables('loadsanphamdotnhap_ngaynhap') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "dienthoai",
                render: function(data, type, row, meta) {
                    if (type === 'display') {
                        if(data === null){
                            return '<input id_nhaphang = "'+row.id+'" id_dotnhap = "'+row.id_dotnhap+'" style = "width:90%; border:none" type="date" class=" edit_tabledata" id ="ngaynhap_'+row.id+'" value="'+ngayhientai+'" />';
                        }else{
                            return '<input disabled id_nhaphang = "'+row.id+'" id_dotnhap = "'+row.id_dotnhap+'" style = "width:90%; border:none" type="text" class=" edit_tabledata" onchange= "capnhat_ngaynhap('+row.id+')" id ="ngaynhap_'+row.id+'" value="' + data + '" />';
                        }
                    }
                    return data;
                }
            },
            {
                title: "<div style = 'padding-bottom: 15px;'>Chức năng</div>",
                className: "text-center",
                data: "id",
                render: function (data, type, row) {
                    if (type === 'display') {
                        return  html ='<i style ="color: red; padding-top:8px"  id_kiemtra = "'+row.id+'" id_dot_sanpham = "'+row.id_dot_sanpham+'" id_sanpham ="'+row.id_sanpham+'" id_dotnhap = "'+row.id_dotnhap+'" soluong ="'+row.soluongnhap+'" class="fa-regular fa-trash-can" id = "deltesanpham_'+data+'" onclick = delete_sanphamnhap(event,' +data +")></i>";
                    }
                    return data;
                },
            },
        ],
        columnDefs: [
            // { targets: [0, 3, 4, 5, 6], className: "text-center" },
            // { targets: [1, 2], },
            // { targets: [0], searchable: true },
        ],
        scrollY: 350,
        language: {
            emptyTable: "Không tìm thấy sản phẩm",
            info: " _START_ / _END_ trên _TOTAL_",
            paginate: {
                first: "Trang đầu",
                last: "Trang cuối",
                next: "Trang sau",
                previous: "Trang trước",
            },
            search: "Tìm kiếm:",
            loadingRecords: "Đang tìm kiếm ... ",
            lengthMenu: "Hiện thị _MENU_",
            infoEmpty: "",
        },
        retrieve: true,
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: false,
        info: true,
        autoWidth: true,
        responsive: true,
        select: true,
        drawCallback: function(settings) {
            var api = this.api();
            api.rows().every(function() {
                var row = this.node();
                var bgColor = $(row).css('background-color');

                $(row).find('input.edit_tabledata').each(function() {
                    $(this).css('background-color', '');  // Xóa bỏ màu nền hiện tại
                    $(this).css('background-color', bgColor);
                });

            });
        }
    });
    return table
}
//
function reload_dssanpham_dot() {
    let id_dotnhap = $('#qlnhap_iddot').val()
    load_dssanpham_quanlynhap().ajax.url('load_sanpham_quanlynhap/'+id_dotnhap).load()
}
// Cập nhật số lượng nhập của sản phẩm theo đợt
async function capnhat_soluongnhap(event, id){
    event.preventDefault();
    $('#modal_event').show()
    let id_chucnang = 2;
    const check = await laythongtincheckquyen(id_chucnang);
    if (window.innerWidth <= 1000) {
        var hienthi = 'mobile'
    } else {
        var hienthi = 'desktop'
    }
    let id_kiemtra = $('#soluongnhap_'+hienthi+'_'+id).attr('id_kiemtra')
    let id_dot_sanpham = $('#soluongnhap_'+hienthi+'_'+id).attr('id_dot_sanpham')
    let id_sanpham = $('#soluongnhap_'+hienthi+'_'+id).attr('id_sanpham')
    let soluongnhap_cu = $('#soluongnhap_'+hienthi+'_'+id).attr('soluongnhap_old')
    let id_dot = $('#soluongnhap_'+hienthi+'_'+id).attr('id_dot')
    let soluong_moi = $('#soluongnhap_'+hienthi+'_'+id).val()

    $.ajax({
        type: "post",
        url: "capnhat_soluongnhap",
        data:{
            id_kiemtra:id_kiemtra,
            id_dot_sanpham:id_dot_sanpham,
            id_sanpham:id_sanpham,
            soluongnhap_cu:soluongnhap_cu,
            id_dot:id_dot,
            soluong_moi:soluong_moi,
            //Check quyền
            time: check[1],
            id_manhinh: check[0],
            id_chucnang: id_chucnang,
            active: 1,
        },
        success: function (res) {
            if(['ins_0', 'ins_1', '-100','dot_0','ins_-1','rol_2','checksl_0'].includes(res.trangthai) == true){
                thongbao(res.trangthai)
            }else{
                thongbao_error(res)
                $('#soluongnhap_'+id).val(soluongnhap_cu)
            }
            // load_dssanpham_quanlynhap().ajax.url('load_sanpham_quanlynhap/'+id_dot).load()

            $("#loadSanphamQLN").DataTable().ajax.reload(null, false);

            Livewire.emit('updateData')
            setTimeout(() => {
                $('#modal_event').hide();
            }, 300);
        },
    });

}
// Xóa sản phẩm theo đợt
async function delete_sanphamnhap(event, id){
    event.preventDefault();
    $('#modal_event').show()
    let id_chucnang = 4;
    const check = await laythongtincheckquyen(id_chucnang);
    let id_dot = $('#deltesanpham_'+id).attr('id_dotnhap')
    let id_dot_sanpham = $('#deltesanpham_'+id).attr('id_dot_sanpham')
    let id_sanpham = $('#deltesanpham_'+id).attr('id_sanpham')
    let soluong_xoa = $('#deltesanpham_'+id).attr('soluong')
    let id_kiemtra = id
    $.ajax({
        type: "post",
        url: "delete_sanphamnhap",
        data:{
            id_dot:id_dot,
            id_sanpham:id_sanpham,
            soluong_xoa:soluong_xoa,
            id_kiemtra:id_kiemtra,
            id_dot_sanpham:id_dot_sanpham,
            //Check quyền
            time: check[1],
            id_manhinh: check[0],
            id_chucnang: id_chucnang,
            active: 1,
        },
        success: function (res) {
            if(['dot_0', 'del_1', 'del_0', '-100','rol_2'].includes(res.trangthai) == true){
                thongbao(res.trangthai)
            }else{
                thongbao_error(res)
            }
            // load_dssanpham_quanlynhap().ajax.url('load_sanpham_quanlynhap/'+id_dot).load()
            $("#loadSanphamQLN").DataTable().ajax.reload(null, false);
            Livewire.emit('updateData')
            setTimeout(() => {
                $('#modal_event').hide();
            }, 300);
        },
    });
}

function btt_show_model_nhapdongphuc(){
    if(hienthi() == 1){
        if($('#id_dotnhap').val() > 0){
            $('#container_modal_Nhap').css('padding-top', '100px');
            $("#modal_nhapdongphuc1").show('slow')
            Livewire.emit('data_iddotnhap',$('#id_dotnhap').val());
        }else{
            toastr.warning('Vui lòng chọn đợt!');
        }
        $('#container-modalNhap').removeAttr('style')
        // $('#container_modal_Nhap').css({ 'padding-top': '53px',});
        $('#container-modalNhap').addClass('modal-fullscreen');
    }else{
        if($('#qlnhap_iddot').val() > 0){
            $('#container-modalNhap').css({
                'width': '85%',
                'height': 'auto',
                'padding': '2px',
                'background-color': '#fff',
                'margin-top': '5%',
                'margin-left': '7%'
            });
            $('#container-modalNhap').removeClass('modal-fullscreen');
            $("#modal_nhapdongphuc1").show('slow')
            setTimeout(() => {
                reload_dssanpham_dot_modal()
            }, 500);

        }else{
            toastr.warning('Vui lòng chọn đợt!');
        }
    }

}
function btt_hide_model_nhapdongphuc(){
    $("#modal_nhapdongphuc1").hide('slow')
}

function load_dssanpham_dot() {
    let today = new Date();
    let year = today.getFullYear();
    let month = (today.getMonth() + 1).toString().padStart(2, '0');
    let day = today.getDate().toString().padStart(2, '0');
    let ngayhientai = `${year}-${month}-${day}`;

    let id_dotnhap = $('#load_sanpham_dotnhap').val()
    var table = $("#loadsanphamdotnhap").DataTable({
        ajax: "load_dssanpham_dot/" + id_dotnhap,
        columns: [
            {
                targets: 0,
                name: 'stt',
                width: "1%",
                title: "STT",
                data: "stt",
                className: "text-center align-middle",
            },
            {
                name: "loai",
                title: "<div class = 'title_datatables'>Loại sản phẩm</div><div class = 'div_datatables'><input id='loadsanphamdotnhap_loai' onkeyup = search_datatables('loadsanphamdotnhap_loai') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "loai",
                render: function(data, type, row, meta) {
                    if (type === 'display') {
                        return '<input disabled style = "border: none;" type="text" class=" edit_tabledata" value="' + data + '" />';
                    }
                    return data;
                }
            },
            {
                name: "nhasanxuat",
                title: "<div class = 'title_datatables'>Nhà sản xuất</div><div class = 'div_datatables'><input id='loadsanphamdotnhap_nhasanxuat' onkeyup = search_datatables('loadsanphamdotnhap_nhasanxuat') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "nhasanxuat",
                render: function(data, type, row, meta) {
                    if (type === 'display') {
                        return '<input disabled style = "border: none;" type="text" class=" edit_tabledata" value="' + data + '" />';
                    }
                    return data;
                }
            },
            {
                name: "size",
                title: "<div class = 'title_datatables'>Size</div><div class = 'div_datatables'><input id='loadsanphamdotnhap_size' onkeyup = search_datatables('loadsanphamdotnhap_size') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "size",
                render: function(data, type, row, meta) {
                    if (type === 'display') {
                        return '<input disabled style = "border: none;" type="text" class=" edit_tabledata" value="' + data + '" />';
                    }
                    return data;
                }
            },

            {
                name: "soluongyeucau",
                title: "<div class = 'title_datatables'>Số lượng yêu cầu</div><div class = 'div_datatables'><input id='loadsanphamdotnhap_soluongnhap' onkeyup = search_datatables('loadsanphamdotnhap_soluongnhap') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "soluongyeucau",
                render: function(data, type, row, meta) {
                    if (type === 'display') {
                        return '<input disabled id_nhaphang = "'+row.id+'" id_sanpham = "'+row.id_sanpham+'" soluongnhap_old = "'+data+'" id_dot = "'+row.id_dotnhap+'" style = "border: none;" type="text" class=" edit_tabledata" id ="soluongdanhap_'+row.id+'" value="'+data+'" />';
                    }
                    return data;
                }
            },

            {
                name: "soluongnhap",
                title: "<div class = 'title_datatables'>Số lượng đã nhập</div><div class = 'div_datatables'><input id='loadsanphamdotnhap_soluongnhap' onkeyup = search_datatables('loadsanphamdotnhap_soluongnhap') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "soluongnhap",
                render: function(data, type, row, meta) {
                    if (type === 'display') {
                        return '<input disabled id_nhaphang = "'+row.id+'" id_sanpham = "'+row.id_sanpham+'" soluongnhap_old = "'+data+'" id_dot = "'+row.id_dotnhap+'" style = "border: none;" type="text" class=" edit_tabledata" id ="soluongdanhap_'+row.id+'" value="'+data+'" />';
                    }
                    return data;
                }
            },

            {

                title: "<div style = 'padding-bottom: 15px;'>Số lượng nhập</div>",
                data: "id",
                render: function(data, type, row, meta) {
                    if (type === 'display') {
                        return '<input id_nhaphang = "'+row.id+'" id_sanpham = "'+row.id_sanpham+'" id_dot = "'+row.id_dotnhap+'" style = "border: none;" type="text" class=" edit_tabledata" onchange= "change_nhapsanpham(event,'+row.id+')" id ="soluongnhap_'+row.id+'" value="0" />';
                    }
                    return data;
                }
            },
        ],
        columnDefs: [
            // { targets: [0, 3, 4, 5, 6], className: "text-center" },
            // { targets: [1, 2], },
            // { targets: [0], searchable: true },
        ],
        scrollY: 350,
        language: {
            emptyTable: "Không tìm thấy sản phẩm",
            info: " _START_ / _END_ trên _TOTAL_",
            paginate: {
                first: "Trang đầu",
                last: "Trang cuối",
                next: "Trang sau",
                previous: "Trang trước",
            },
            search: "Tìm kiếm:",
            loadingRecords: "Đang tìm kiếm ... ",
            lengthMenu: "Hiện thị _MENU_",
            infoEmpty: "",
        },
        retrieve: true,
        paging: true,
        lengthChange: false,
        searching: true,
        ordering: false,
        info: false,
        autoWidth: true,
        responsive: true,
        select: false,
        drawCallback: function(settings) {
            var api = this.api();
            api.rows().every(function() {
                var row = this.node();
                var bgColor = $(row).css('background-color');

                $(row).find('input.edit_tabledata').each(function() {
                    $(this).css('background-color', '');  // Xóa bỏ màu nền hiện tại
                    $(this).css('background-color', bgColor);
                });

            });
        }
    });
    return table
}
function reload_dssanpham_dot_modal() {
    let id_dotnhap = $('#qlnhap_iddot').val()
    load_dssanpham_dot().ajax.url('load_dssanpham_dot/'+id_dotnhap).load()
}
// nhập sản phẩm
async function change_nhapsanpham(event, id){
    event.preventDefault();
    $('#modal_event').show()
    let id_chucnang = 3;
    const check = await laythongtincheckquyen(id_chucnang);
    let id_nhaphang = $('#soluongnhap_'+id).attr('id_nhaphang')
    let id_dot = $('#soluongnhap_'+id).attr('id_dot')
    let soluong_moi = $('#soluongnhap_'+id).val()
    let id_sanpham = $('#soluongnhap_'+id).attr('id_sanpham')
    $.ajax({
        type: "post",
        url: "change_nhapsanpham",
        data:{
            id_nhaphang:id_nhaphang,
            id_dot:id_dot,
            soluong_moi:soluong_moi,
            id_sanpham:id_sanpham,
            //Check quyền
            time: check[1],
            id_manhinh: check[0],
            id_chucnang: id_chucnang,
            active: 1,
        },
        success: function (res) {
            if([ 'ins_1','ins_0', '-100','dot_0','ins_-1',"rol_2",'checksl_0'].includes(res.trangthai) == true){
                thongbao(res.trangthai)

            }else{
                thongbao_error(res)
            }
            $('#soluongnhap_'+id).val('0')
            Livewire.emit('updateData')
            load_dssanpham_dot().ajax.url('load_dssanpham_dot/'+id_dot).load()
            load_dssanpham_quanlynhap().ajax.url('load_sanpham_quanlynhap/'+id_dot).load()
            setTimeout(() => {
                $('#modal_event').hide();
            }, 300);
        },
    });
}
// xuất excel danh sách
function btt_xuatexcel_ql_sanphamnhap(){
    if (window.innerWidth <= 1000) {
        var id_dotnhap = $('#id_dotnhap').val()
    } else {
        var id_dotnhap = $('#qlnhap_iddot').val()
    }
    $.ajax({
        type: "get",
        url: "btt_xuatexcel_ql_sanphamnhap",
        data:{
            'id_dotnhap':id_dotnhap,
        },
        success: function (res) {
            if(['excel_1','-100'].includes(res.trangthai) == true){
                window.location.href = '/admin24/xuatexcel_ql_sanphamnhap/' + id_dotnhap
            }else{
                thongbao_error(res)
            }

        },
    });

}
function btt_xuatexcel_ql_sanphamnhap_mobile(){
    let id_dotnhap = $('#id_dotnhap').val()

    // $.ajax({
    //     type: "get",
    //     url: "btt_xuatexcel_ql_sanphamnhap",
    //     data:{
    //         'id_dotnhap':id_dotnhap,
    //     },
    //     success: function (res) {
    //         if(['excel_1','-100'].includes(res.trangthai) == true){
    //             window.location.href = '/admin24/xuatexcel_ql_sanphamnhap/' + id_dotnhap
    //         }else{
    //             thongbao_error(res)
    //         }

    //     },
    // });
}

// xuất excel thống kê
function btt_xuatexcel_sanphamnhap(){
    if (window.innerWidth <= 1000) {
        var id_dotnhap = $('#id_dotnhap').val()
    } else {
        var id_dotnhap = $('#qlnhap_iddot').val()
    }
    $.ajax({
        type: "get",
        url: "btt_xuatexcel_sanphamnhap",
        data:{
            'id_dotnhap':id_dotnhap,
        },
        success: function (res) {
            if(['excel_1','-100'].includes(res.trangthai) == true){
                window.location.href = '/admin24/xuatexcel_sanphamnhap/' + id_dotnhap
            }else{
                thongbao_error(res)
            }

        },
    });

}


// Biểu đồ thống kê nhap
function bieudo_thongke_nhap() {
    var id_dotnhap = hienthi() == 1 ? $('#id_dotnhap').val() : $('#qlnhap_iddot').val();

    $.ajax({
        url: "bieudo_thongke_nhap",
        type: 'get',
        data: {
            id_dotnhap: id_dotnhap,
        },
        success: function (res) {
            $("#modal_bieudo_thongke_nhap").show('slow');

            if (window.myChart) {
                window.myChart.destroy();
            }

            var loaiNsxLabels = [];
            var sizeData = {};
            var data = res;

            data.forEach(item => {
                var label = `${item.loai} - ${item.nsx}`;
                if (!loaiNsxLabels.includes(label)) {
                    loaiNsxLabels.push(label);
                }
                if (!sizeData[label]) {
                    sizeData[label] = {};
                }
                if (!sizeData[label][item.size]) {
                    sizeData[label][item.size] = { value: 0, color: item.color };
                }
                sizeData[label][item.size].value += parseInt(item.tong_sl_nhap, 10);
            });

            var datasets = [];
            var uniqueSizes = [...new Set(data.map(item => item.size))];

            uniqueSizes.forEach(size => {
                var dataForSize = loaiNsxLabels.map(label => sizeData[label] && sizeData[label][size] ? sizeData[label][size].value : 0);
                var colorForSize = data.find(item => item.size === size)?.color || "#CCCCCC";
                var hasData = dataForSize.some(value => value > 0);

                if (hasData) {
                    datasets.push({
                        label: size,
                        data: dataForSize,
                        backgroundColor: colorForSize,
                    });
                }
            });

            var ctx = document.getElementById('dongphuc_dot-chart-canvas').getContext('2d');
            window.myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: loaiNsxLabels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: 'black',
                                font: { size: 14 }
                            }
                        },
                        datalabels: {
                            color: 'black',
                            display: true,
                            anchor: 'end',
                            align: 'top',
                            formatter: value => value > 0 ? value : ''
                        }
                    },
                    scales: {
                        x: {
                            stacked: false,
                            title: { display: true, text: 'Loại sản phẩm - Nhà sản xuất' }
                        },
                        y: {
                            stacked: false,
                            title: { display: true, text: 'Tổng SL' }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        }
    });
}

function close_bieudo_thongke(){
    $("#modal_bieudo_thongke_nhap").hide();
}


