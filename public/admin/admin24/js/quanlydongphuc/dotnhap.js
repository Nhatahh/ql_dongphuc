$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    load_dsdotnhap()
    $('#dsdotnhap_filter').hide();

});
function adjustView() {
    var btt_Themdot = document.getElementsByClassName('btt_Themdot');
    if (window.innerWidth <= 575) {
        btt_Themdot[0].classList.add('padding_btt_Themdot');
    } else {
        btt_Themdot[0].classList.remove('padding_btt_Themdot');
    }
}

// Gọi hàm adjustView khi tải trang và khi thay đổi kích thước màn hình
document.addEventListener('DOMContentLoaded', adjustView);
window.addEventListener('resize', adjustView);
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
                width: "5%",
            },
            {
                name: "dot",
                title: "<div class = 'title_datatables'>Tên đợt</div><div class = 'div_datatables'><input id='dsdotnhap_dot' onkeyup = search_datatables('dsdotnhap_dot') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "dot",
                render: function(data, type, row, meta) {
                    if (type === 'display') {
                        return '<input style = "border: none; width:100%" type="text" class=" edit_tabledata" id = "tenDot_'+row.id+'" onchange = "capnhat_Dot('+row.id+')" value="' + data + '" />';
                    }
                    return data;
                }
            },
            {
                name: "ngaytao",
                title: "<div class = 'title_datatables'>Tên đợt</div><div class = 'div_datatables'><input id='dsdotnhap_ngaytao' onkeyup = search_datatables('dsdotnhap_ngaytao') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "ngaytao",

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
                width: "10%",
                render: function (data, type, row) {
                    if (row.trangthai == 1) {
                        var icon_xoa = '<i style ="color: #007bff;" id="trangthai_'+data+'" trangthai = '+row.trangthai+' class="fa-solid fa-unlock" onclick = "change_trangthai('+data+')">&nbsp&nbsp</i>';
                    } else {
                        var icon_xoa = '<i style ="color: red;" id="trangthai_'+data+'" trangthai = '+row.trangthai+' class="fa-solid fa-lock" onclick = "change_trangthai('+data+')">&nbsp&nbsp</i>';
                    }
                    return icon_xoa
                },
            },
        ],
        columnDefs: [
            // { targets: [0, 3, 4, 5, 6], className: "text-center" },
            // { targets: [1, 2], },
            // { targets: [0], searchable: true },
        ],
        scrollY: 450,
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
async function themDot(){
    let id_chucnang = 3;
    const check = await laythongtincheckquyen(id_chucnang);
    var ten_dot = $("#ten_dot_moi").val()
    $.ajax({
        type: "post",
        url: "themDot",
        data:{
            ten_dot : ten_dot,
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
        },
    });
}

async function capnhat_Dot(id){
    let id_chucnang = 3;
    const check = await laythongtincheckquyen(id_chucnang);
    var tenDot = $('#tenDot_'+id).val()
    $.ajax({
        type: "post",
        url: "capnhat_Dot",
        data: {
            id:id,
            tenDot:tenDot,
            time: check[1],
            id_manhinh: check[0],
            id_chucnang: id_chucnang,
            active: 1,
        },
        success:function (res) {
            if([ 'upd_1','upd_0','dotnhap_0','rol_2'].includes(res.trangthai) == true){
                thongbao(res.trangthai)
            }else{
                thongbao_error(res)
            }
            $("#dsdotnhap").DataTable().ajax.reload(null, false);
        },
    });
}

function change_trangthai(id){
    var trangthai = $('#trangthai_'+id).attr('trangthai')
    $.ajax({
        type: "post",
        url: "change_trangthai",
        data:{
            trangthai : trangthai,
            id : id,
        },
        success: function (res) {
            if([ 'upd_1','upd_0'].includes(res.trangthai) == true){
                thongbao(res.trangthai)
            }else{
                thongbao_error(res)
            }
            $("#dsdotnhap").DataTable().ajax.reload(null, false);
        },
    });
}




