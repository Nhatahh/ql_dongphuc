$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    load_dsdotnhap()
    $('#dsdotnhap_filter').hide();
    load_dssanpham_dot().ajax.url('qldot_load_dssanpham_dot/-1').load()
    $("#loadsanphamdotnhapQLDN_filter").hide()


});

function adjustView() {
    var ql_dotnhap_Mobile = document.getElementsByClassName('ql_dotnhap_mobile');
    var ql_dotnhap_Desktop = document.getElementsByClassName('ql_dotnhap_desktop');
    if (window.innerWidth <= 1000) {
        for (var i = 0; i < ql_dotnhap_Mobile.length; i++) {
            ql_dotnhap_Mobile[i].style.display = 'block';
        }
        for (var i = 0; i < ql_dotnhap_Desktop.length; i++) {
            ql_dotnhap_Desktop[i].style.display = 'none';
        }
    } else {
        for (var i = 0; i < ql_dotnhap_Desktop.length; i++) {
            ql_dotnhap_Desktop[i].style.display = 'block';
        }
        for (var i = 0; i < ql_dotnhap_Mobile.length; i++) {
            ql_dotnhap_Mobile[i].style.display = 'none';
        }
    }
}
document.addEventListener('DOMContentLoaded', adjustView);
window.addEventListener('resize', adjustView);
function hienthi() {
    if (window.innerWidth <= 1000) {
        return 1;
    } else {
        return 0;
    }
}

function load_dssanpham_dot() {
    let id_dotnhap = $('#dot_nhap').val()
    var table = $("#loadsanphamdotnhapQLDN").DataTable({
        ajax: "qldot_load_dssanpham_dot/" + id_dotnhap,
        columns: [
            {
                targets: 0,
                name: 'stt',
                width: "1%",
                title: "<div style = 'padding-bottom: 15px;'>STT</div>",
                data: "stt",
                className: "text-center align-middle",

            },
            {
                targets: 1,
                name: "loai",
                title: "<div class = 'title_datatables'>Loại sản phẩm</div><div class = 'div_datatables'><input id='loadsanphamdotnhapQLDN_loai' onkeyup = search_datatables('loadsanphamdotnhapQLDN_loai') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "loai",
                className: "align-middle",
            },
            {
                targets: 2,
                name: "nhasanxuat",
                title: "<div class = 'title_datatables'>Nhà sản xuất</div><div class = 'div_datatables'><input id='loadsanphamdotnhapQLDN_nhasanxuat' onkeyup = search_datatables('loadsanphamdotnhapQLDN_nhasanxuat') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "nhasanxuat",
                className: " align-middle",
            },

            {
                targets: 3,
                name: "size",
                title: "<div class = 'title_datatables'>Size</div><div class = 'div_datatables'><input id='loadsanphamdotnhapQLDN_size' onkeyup = search_datatables('loadsanphamdotnhapQLDN_size') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "size",
                className: "text-center align-middle",
            },
            // {
            //     targets: 4,
            //     width: "20%",
            //     name: "thongso",
            //     title: "<div class = 'title_datatables'>Thông số</div><div class = 'div_datatables'><input id='loadsanphamdotnhapQLDN_thongso' onkeyup = search_datatables('loadsanphamdotnhapQLDN_thongso') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
            //     data: "thongso",
            //     className: " align-middle",
            // },
            {
                targets: 5,
                title: "<div style = 'padding-bottom: 15px;'>Số lượng</div>",
                data: "id",
                width: "10%",
                render: function(data, type, row, meta) {
                    if (type === 'display') {
                        return '<input style = "border: none;background-color: inherit" type="text" onchange= "change_soluong(event,'+row.id+')" id ="soluongsanphamnhap_'+row.id+'" value="'+row.soluong+'" />';
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
        scrollY: 430,
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
        info: true,
        autoWidth: true,
        responsive: true,
        select: true,
    });
    return table
}
function change_dot(event,id_dot){
    event.preventDefault();
    load_dssanpham_dot().ajax.url('qldot_load_dssanpham_dot/'+id_dot).load()
    $('#soluongnhap').attr('id_dot',id_dot)
    Livewire.emit('data_iddotnhap',id_dot);

    // Xóa màu nền của tất cả các hàng trước khi tô màu hàng mới
    $("#dsdotnhap tbody tr").css("background-color", "");

    // Tìm hàng tương ứng với `rowId` và thay đổi màu nền
    var row = $("#dsdotnhap").DataTable().row(function(idx, data, node) {
        return data.id === id_dot;  // So sánh với `rowId` để tìm hàng
    }).node();

    // Đổi màu nền cho hàng đã tìm thấy
    $(row).css("background-color", "#B0E2FF");  // Thay đổi màu nền theo ý muốn

}
async function change_soluong(event, id_sanpham){
    event.preventDefault();
    $('#modal_event').show();
    let id_chucnang = 2;
    const check = await laythongtincheckquyen(id_chucnang);
    if(hienthi() == 1){
        var id_dot = $('#soluongnhap').attr('id_dot')
        var soluong = $('#soluongsanphamnhap_mobile_'+id_sanpham).val()
    }else{
        var id_dot = $('#soluongnhap').attr('id_dot')
        var soluong = $('#soluongsanphamnhap_'+id_sanpham).val()
    }
    let id_dot_int = parseInt(id_dot, 10);
    $.ajax({
        type: "post",
        url: "change_soluong",
        data:{
            id_sanpham : id_sanpham,
            id_dot : id_dot_int,
            soluong : soluong,
            //Check quyền
            time: check[1],
            id_manhinh: check[0],
            id_chucnang: id_chucnang,
            active: 1,
        },
        success: function (res) {
            if([ 'upd_1','upd_0','dotnhap_0','rol_2','DaNhap_0','DaNhap_1'].includes(res.trangthai) == true){
                thongbao(res.trangthai)
            }else{
                thongbao_error(res)
            }
            load_dssanpham_dot().ajax.url('qldot_load_dssanpham_dot/'+id_dot).load()
            Livewire.emit('updateData')
            setTimeout(() => {
                $('#modal_event').hide();
                // $('#tenDot_'+id).prop('disabled', false);
            }, 300);
        },
    });
}


// quản lý đợt
function adjustView1() {
    var btt_Themdot = document.getElementsByClassName('btt_Themdot');
    if (window.innerWidth <= 575) {
        btt_Themdot[0].classList.add('padding_btt_Themdot');
    } else {
        btt_Themdot[0].classList.remove('padding_btt_Themdot');
    }
}

// Gọi hàm adjustView khi tải trang và khi thay đổi kích thước màn hình
document.addEventListener('DOMContentLoaded', adjustView1);
window.addEventListener('resize', adjustView1);
function ds_dotnhap(){
    $.ajax({
        type: "get",
        url: "ds_dotnhap",
        dataType: "json",
        success: function (res) {
            $("#dot_nhap").select2({data: res.load_sanpham_dotnhap});
        },
    });
}
function load_dsdotnhap() {
    var table = $("#dsdotnhap").DataTable({
        ajax: "load_dsdotnhap",
        columns: [
            {
                targets: 0,
                name: 'stt',
                width: "1%",
                title: "<div style = 'padding-bottom: 15px;'>STT</div>",
                data: "stt",
                className: "text-center align-middle",
            },
            {
                name: "dotnhap",
                title: "<div class = 'title_datatables'>Tên đợt</div><div class = 'div_datatables'><input id='dsdotnhap_dotnhap' onkeyup = search_datatables('dsdotnhap_dotnhap') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "dotnhap",
                render: function(data, type, row, meta) {
                    if (type === 'display') {
                        return '<input style = "border: none; width:100%" type="text" class=" edit_tabledata" id = "tenDot_'+row.id+'" onchange = "capnhat_Dot(event,'+row.id+')" value="' + data + '" />';
                    }
                    return data;
                }
            },

                {
                    name: "ngaytao",
                    title: "<div class = 'title_datatables'>Ngày tạo</div><div class = 'div_datatables'><input id='dsdotnhap_ngaytao' onkeyup = search_datatables('dsdotnhap_ngaytao') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                    data: "ngaytao",
                    render: function(data, type, row, meta) {
                        if (type === 'display') {
                            return '<input style = "border: none; width:100%" type="text" class=" edit_tabledata" id = "tenDot_'+row.id+'" onchange = "capnhat_Dot('+row.id+')" value="' + data + '" />';
                        }
                        return data;
                    }
                },

            {
                targets: 3,
                name: "trangthai",
                title: "<div class ='title_datatables'>Trạng thái</div><div class = 'div_datatables'> <select style = 'width:100%' class = 'select_datatables' id='dsdotnhap_trangthai' onchange = search_datatables('dsdotnhap_trangthai')><option  value =''></option><option value ='1'>Đang mở</option><option value ='0'>Đã khóa</option></select></div>",
                data: "trangthai",
                className: "text-center align-middle",
                width: "10%",
                render: function (data, type, row) {
                    let trangthai = ""
                    return data == 1 ? trangthai = '<span class = "search_tmp">'+data+'</span><small class="badge badge-primary">Đang mở</small>' : trangthai = '<span class = "search_tmp">'+data+'</span><small class="badge badge-warning">Đã đóng</small>'
                }
            },
            {
                targets: 4,
                title: "Chức năng",
                data: 'id',
                className: "text-center align-middle",
                width: "20%",
                render: function (data, type, row) {
                    if (row.trangthai == 1) {
                        var icon_xoa = '<i style ="color: #007bff;" id="trangthai_'+data+'" trangthai = '+row.trangthai+' class="fa-solid fa-unlock" onclick = "change_trangthai(event,'+data+')">&nbsp&nbsp</i>';
                        var icon_xoa1 = '<i style ="color:#17a2b8;" id = "dot_nhap_'+data+'" class="fa-solid fa-square-pen" onclick = "change_dot(event,'+data+')">&nbsp&nbsp</i>';

                    } else {
                        var icon_xoa = '<i style ="color: red;" id="trangthai_'+data+'" trangthai = '+row.trangthai+' class="fa-solid fa-lock" onclick = "change_trangthai(event,'+data+')">&nbsp&nbsp</i>';
                        var icon_xoa1 = '<i style ="color: #17a2b8;" id = "dot_nhap_'+data+'" class="fa-solid fa-square-pen" onclick = "change_dot(event,'+data+')">&nbsp&nbsp</i>';
                    }
                    return $r = icon_xoa + icon_xoa1
                },
            },
        ],
        columnDefs: [
            // { targets: [0, 3, 4, 5, 6], className: "text-center" },
            // { targets: [1, 2], },
            // { targets: [0], searchable: true },
        ],
        scrollY: 430,
        language: {
            emptyTable: "Không tìm thấy đợt nhập",
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
        paging: false,
        lengthChange: true,
        searching: true,
        ordering: false,
        info: false,
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
// thêm đợt mới
async function themDot(event){
    event.preventDefault();
    $('#modal_event').show();
    let id_chucnang = 3;
    const check = await laythongtincheckquyen(id_chucnang);
    var ten_dot = $("#ten_dot_moi").val()
    $('#btt_them_Dot').prop('disabled', true);
    $.ajax({
        type: "post",
        url: "themDot",
        data:{
            ten_dot : ten_dot,
            //Check quyền
            time: check[1],
            id_manhinh: check[0],
            id_chucnang: id_chucnang,
            active: 1,
        },
        success: function (res) {
            if([ 'ins_1','ins_0','rol_2'].includes(res.trangthai) == true){
                thongbao(res.trangthai)
                $("#ten_dot_moi").val('')
            }else{
                thongbao_error(res)
            }
            $("#dsdotnhap").DataTable().ajax.reload(null, false);
            setTimeout(() => {
                $('#modal_event').hide();
                $('#btt_them_Dot').prop('disabled', false);
            }, 300);


        },
    });
}

async function capnhat_Dot(event,id){
    event.preventDefault();
    $('#modal_event').show();
    let id_chucnang = 2;
    const check = await laythongtincheckquyen(id_chucnang);
    var tenDot = $('#tenDot_'+id).val()
    $('#tenDot_'+id).prop('disabled', true);
    $.ajax({
        type: "post",
        url: "capnhat_Dot",
        data: {
            id:id,
            tenDot:tenDot,
              //Check quyền
            time: check[1],
            id_manhinh: check[0],
            id_chucnang: id_chucnang,
            active: 1,
        },
        success:function (res) {
            if([ 'upd_1','upd_0','dotnhap_0','rol_2'].includes(res.trangthai) == true){
                thongbao(res.trangthai

                )
            }else{
                thongbao_error(res)
            }
            $("#dsdotnhap").DataTable().ajax.reload(null, false);
            setTimeout(() => {
                $('#modal_event').hide();
                $('#tenDot_'+id).prop('disabled', false);
            }, 300);
        },
    });
}

async function change_trangthai(event,id){
    event.preventDefault();
    $('#modal_event').show()
    let id_chucnang = 2;
    const check = await laythongtincheckquyen(id_chucnang);
    var trangthai = $('#trangthai_'+id).attr('trangthai')
    $.ajax({
        type: "post",
        url: "change_trangthai",
        data:{
            trangthai : trangthai,
            id : id,
            //Check quyền
            time: check[1],
            id_manhinh: check[0],
            id_chucnang: id_chucnang,
            active: 1,
        },
        success: function (res) {
            if([ 'upd_1','upd_0','rol_2'].includes(res.trangthai) == true){
                thongbao(res.trangthai)
            }else{
                thongbao_error(res)
            }
            $("#dsdotnhap").DataTable().ajax.reload(null, false);
            setTimeout(() => {
                $('#modal_event').hide();
            }, 300);
        },
    });
}


