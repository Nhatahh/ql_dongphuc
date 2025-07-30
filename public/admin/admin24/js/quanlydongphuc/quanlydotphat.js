$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#ds_dotphat_filter").hide()
    $("#ds_dongphuc_phat_filter").hide()

});
//Danh sách đợt phát
var ds_dotphat = $("#ds_dotphat").DataTable({
    //render input
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
    },
    ajax: {
        type: "GET",
        url: "/admin24/ds_dotphat",
    },
    columns: [

        {
            title: "STT",
            data: "stt",
            width:"10%",
            className: 'remove_click',
        },
        {
            title: "<div style='text-align: center;'>Tên Đợt</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_ten' onkeyup='search_ten()' class='form-control' style='width:90%;height:22px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
            data: "dot",
            className: 'remove_click text-left',
            render: function(data, type, row) {
                let kieu = "dot";
                return '<span style="display:none">' + data + '</span>' +
                       '<input kieu="' + kieu + '" onchange="change_dot(' + row.id + ', this.value, \'' + kieu + '\')" ' +
                       'style="border: none; height:100%; width:100%" type="text" ' +
                       'class="edit_tabledata" value="' + data + '"/>';
            }
        },
        {
            title: "<div style='text-align: center;'>Ngày tạo</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input type='date' id='search_ngay' onchange='search_ngay()' class='form-control' style='width:90%;height:22px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
            data: "formatted_create_at",
            className: 'remove_click text-left',
            render: function(data, type, row) {
                let kieu = "create_at";
                // Đảm bảo giá trị ngày được hiển thị đúng định dạng yyyy-mm-dd
                return '<span kieu="' + kieu + '" style = "display:none">' + data + '</span><input onchange="change_dot(' + row.id + ', this.value,  \'' + kieu + '\')" style="border: none; height:100%; width:100%" type="date" id="edit_ten" class="edit_tabledata" value="' + data + '" />';
            }
        },
        {
            title: "<div>Trạng thái</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'> <select style='height:22px; border:none;color:#8a8c8f;' id='search_trangthai' onchange = 'search_trangthai()'><option  value =''></option><option value ='0'>Đang Mở</option><option value ='1'>Đã khóa</option></select></div>",
            data: "trangthai",
            className: 'remove_click text-center',
            render: function(data,type,row){
                var html ="";
                switch (data) {
                    case 0:
                        html =  '<span style = "display:none">0</span><small class="badge badge-success"><i class="fa-solid fa-lock-open"></i>&nbsp;&nbsp;</i>Đang mở</small>'
                        break;
                    case 1:
                        html = '<span style = "display:none">1</span><small class="badge badge-danger"><i class="fa-solid fa-lock"></i>&nbsp;&nbsp;</i>Đã khóa</small>'
                        break;
                    default:
                        break;
                }
                return html;
            }
        },
        {
            title: "Thao tác",
            data: "id",
            width:"10%",
            className: 'timkiem_thisinh text-center remove_click',
            render: function(data, type, row) {
                var html ="";
                if (row.trangthai==1) {
                    html = '<i id="btn_changetrangthai_' + data + '"  onclick="change_trangthai_dotphat(' + data + ', ' + row.trangthai + ')" style="color: #007bff;" class="fa-solid fa-lock-open"></i>';
                }else{
                    html = '<i id="btn_changetrangthai_' + data + '"  onclick="change_trangthai_dotphat(' + data + ', ' + row.trangthai + ')" style ="color: red;" class="fa-solid fa-lock"></i>&nbsp;&nbsp;</i>'
                }
                return html;
            }
        }
    ],
    language: {
        emptyTable: "Không tìm thấy đợt phát",
        info: " _START_ / _END_ trên _TOTAL_ hóa đơn",
        paginate: {
            first: "Trang đầu",
            last: "Trang cuối",
            next: "Trang sau",
            previous: "Trang trước"
        },
        search: "Tìm kiếm:",
        loadingRecords: "Đang tìm kiếm ... ",
        lengthMenu: "Hiện thị _MENU_ hóa đơn",
        infoEmpty: "",
    },
    retrieve: true,
    paging: false,
    lengthChange: false,
    searching: true,
    ordering: false,
    info: false,
    autoWidth: true,
    responsive: false,
    scrollY: 360,
});
//Search for column đợt phát
function search_ten() {
    var value = $('#search_ten').val();
    ds_dotphat.column(1).search(value).draw();
}
function search_ngay() {
    var value = $('#search_ngay').val();
    ds_dotphat.column(2).search(value).draw();
}
function search_trangthai() {
    var value = $('#search_trangthai').val()
    ds_dotphat.column(3).search(value).draw();
}
//Thêm đợt mới
async function them_dot(){
    const check = await laythongtincheckquyen(3);
    $('#modal_event').show();

    var name=$('#name').val();
    $.ajax({
        type: 'post',
        url: '/admin24/them_dot',
        data: {
            name : name,
            time: check[1],
            id_manhinh: check[0],
            id_chucnang: 3,
            active: 1,
        },
        success: function(res) {
            $('#modal_event').hide();
            if(res.status==1){
                $('#name').val('');
                thongbao(res.noidung)
                ds_dotphat.ajax.reload();
            }else{
                if(res.kieudulieu=='json'){
                    var keys = Object.keys(res['noidung']['original'])
                    for(let i = 0; i<keys.length; i++){
                        toastr.warning(res['noidung']['original'][keys[i]][0]);
                    }
                }else{
                    thongbao(res.noidung)
                }
            }
        }
    });
}
// trạng thái
async function change_trangthai_dotphat(id,trangthai){
    const check = await laythongtincheckquyen(2);
    $('#btn_changetrangthai_' + id).attr('disabled', true);
    $('#modal_event').show();
    $.ajax({
        type: 'post',
        url: `/admin24/change_trangthai_dotphat/${id}/${trangthai}`,
        data: {
            time: check[1],
            id_manhinh: check[0],
            id_chucnang: 2,
            active: 1,
        },
        success: function(res) {
            $('#modal_event').hide();
            $('#btn_changetrangthai_' + id).attr('disabled', false);
            if(res.status==1){
                thongbao(res.noidung)
                ds_dotphat.ajax.reload();
            }else{
                if(res.kieudulieu=='json'){
                    var keys = Object.keys(res['noidung']['original'])
                    for(let i = 0; i<keys.length; i++){
                        toastr.warning(res['noidung']['original'][keys[i]][0]);
                    }
                }else{
                    thongbao(res.noidung)
                }
            }
        }
    });
}
//sửa đợt
async function change_dot(id,value,trangthai){
    const check = await laythongtincheckquyen(2);
    $('#modal_event').show();
    $.ajax({
        type: 'post',
        url: `/admin24/change_dot`,
        data: {
            id:id,
            value:value,
            trangthai:trangthai,
            time: check[1],
            id_manhinh: check[0],
            id_chucnang: 2,
            active: 1,
        },
        success: function(res) {
            $('#modal_event').hide();
            if(res.status==1){
                thongbao(res.noidung)
                ds_dotphat.ajax.reload();
            }else{
                if(res.kieudulieu=='json'){
                    toastr.warning(res.noidung)
                }else{
                    thongbao(res.noidung)
                }
            }
        }
    });
}
//Danh sách đồng phục phát
var ds_dongphuc_phat = $("#ds_dongphuc_phat").DataTable({
    //render input
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
    },
    ajax: {
        type: "GET",
        url: "/admin24/ds_dongphuc",
    },
    columns: [

        {
            title: "<div style='text-align: center;'>Nhà sản xuất</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_nsx' onkeyup='search_nsx()' class='form-control' style='width:90%;height:22px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
            data: "nsx",
            className: 'remove_click',
        },
        {
            title: "<div style='text-align: center;'>Loại</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_loai' onkeyup='search_loai()' class='form-control' style='width:90%;height:22px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
            data: "loai",
            className: 'remove_click text-left',
        },
        {
            title: "<div style='text-align: center;'>Size</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_size' onkeyup='search_size()' class='form-control' style='width:90%;height:22px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
            data: "size",
            className: 'remove_click text-left',
        },
        {
            title: "<div style='text-align: center;'>Đợt nhập</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_dotnhap' onkeyup='search_dotnhap()' class='form-control' style='width:90%;height:22px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
            data: "dotnhap",
            className: 'remove_click text-left',
        },
        {
            title: "<div style='text-align: center;'>Trạng thái</div>",
            data: "id",
            className: 'timkiem_thisinh text-center remove_click',
            render: function(data,type,row ) {
                var html=""
                if(row.trangthai==0){
                    html+= '<input checked class="check_trangthai"  onclick=change_trangthai_kho("'+data+'","'+row.trangthai+'") style="height:13px" id_kho="'+data+'" type="checkbox">'
                }else{
                    html+= '<input class="check_trangthai"  onclick=change_trangthai_kho("'+data+'","'+row.trangthai+'") style="height:13px" id_kho="'+data+'" type="checkbox">'
                }
                return html;
            }
        }
    ],
    language: {
        emptyTable: "Không tìm thấy đồng phục",
        info: " _START_ / _END_ trên _TOTAL_ hóa đơn",
        paginate: {
            first: "Trang đầu",
            last: "Trang cuối",
            next: "Trang sau",
            previous: "Trang trước"
        },
        search: "Tìm kiếm:",
        loadingRecords: "Đang tìm kiếm ... ",
        lengthMenu: "Hiện thị _MENU_ hóa đơn",
        infoEmpty: "",
    },
    retrieve: true,
    paging: false,
    lengthChange: false,
    searching: true,
    ordering: false,
    info: false,
    autoWidth: true,
    responsive: false,
    scrollY: 360,
});
//Search for column
function search_nsx() {
    var value = $('#search_nsx').val()
    ds_dongphuc_phat.column(0).search(value).draw();
}
function search_loai() {
    var value = $('#search_loai').val()
    ds_dongphuc_phat.column(1).search(value).draw();
}
function search_size() {
    var value = $('#search_size').val()
    ds_dongphuc_phat.column(2).search(value).draw();
}
function search_dotnhap() {
    ds_dongphuc_phat.column(3).search($('#search_dotnhap').val()).draw();
}
// trạng thái
async function change_stt(id,value){
    const check = await laythongtincheckquyen(2);
    $('#modal_event').show();
    $.ajax({
        type: 'post',
        url: `/admin24/change_stt`,
        data: {
            id:id,
            value:value,
            time: check[1],
            id_manhinh: check[0],
            id_chucnang: 2,
            active: 1,
        },
        success: function(res) {
            $('#modal_event').hide();
            if(res.status==1){
                thongbao(res.noidung)
                ds_dongphuc_phat.ajax.reload();
            }else{
                if(res.kieudulieu=='json'){
                    toastr.warning(res.noidung)
                }else{
                    thongbao(res.noidung)
                }
            }
        }
    });
}
//Đổi trạng thái
async function change_trangthai_kho(id,trangthai){
    var pri=""
    if(trangthai==0){
        pri = confirm("Sản phẩm sẽ ngưng hoạt động ?!")
    }else{
        pri = confirm("Sản phẩm sẽ được hoạt động lại ?!")
    }
    if (pri == true){
        $('#modal_event').show();
        const check = await laythongtincheckquyen(3);
        $.ajax({
            type: 'post',
            url: '/admin24/change_trangthai_kho',
            data: {
                time: check[1],
                id_manhinh: check[0],
                id_chucnang: 3,
                active: 1,
                id: id,
                trangthai: trangthai,
            },
            success: function(res) {

                $('#modal_event').hide();
                // search_kho()
                ds_dongphuc_phat.ajax.reload();
                if(res.status==1){
                    thongbao(res.noidung);
                    // reloadDsKho();
                }else if(res.status == 2){
                    toastr.warning(res.noidung)
                }
                else{
                    thongbao(res.noidung);
                    // reloadDsKho();
                }
            }
        });
    }else{
        ds_dongphuc_phat.ajax.reload(null, false);

    }
}
