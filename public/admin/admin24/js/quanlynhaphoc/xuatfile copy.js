$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    //
    loadmajor()
    loadloaigiay()
    $('#major').select2()
    table_thongtinsv(0,0,0).ajax.url("loadthongtin/-1/0/0").load();
});
function search() {
    var major = $('#major').val();
    var cccd = $('#cccd').val();
    var mssv = $('#mssv').val();
    major == 0 ? major = -1 :  major = $('#major').val();
    cccd == 0 ? cccd = 0 :  cccd = $('#cccd').val();
    mssv == 0 ? mssv = 0 :  mssv = $('#mssv').val();
    table_thongtinsv(major,cccd,mssv).ajax.url("loadthongtin/"+major+"/"+cccd+"/"+mssv).load();
}


function table_thongtinsv(major, cccd, mssv) {
    var table_thongtinsv = $("#table_thongtinsv").DataTable({
        processing: true,
        // serverSide: true,
        deferRender: true,
        ajax: "giayxacnhan/loadthongtin/" + major + "/" + cccd + "/" + mssv,
        columns: [
            {
                title: '<input type="checkbox" id="hsnh_checkall" onclick="hsnh_checkall()" style="height:19px">',
                className: 'text-center',
                data: "mssv",
                render: function(data, type, row) {
                    return '<input type="checkbox" class="hsnh_checkbox" id_gioitinh = "'+row.gioitinh+'" id_taikhoan="' + row.id_taikhoan + '" style="height:19px">';
                }
            },
            {
                name: "stt",
                className: 'text-center',
                title: "STT",
                data: "stt",
            },
            {
                name: "mssv",
                className: 'text-center',
                title: "MSSV",
                data: "mssv",
            },
            {
                name: "hoten",
                className: 'text-center',
                title: "Họ và tên",
                data: "hoten",
            },
            {
                name: "cccd",
                className: 'text-center',
                title: "CCCD/CMND",
                data: "cccd",
            },
            {
                name: "dienthoai",
                className: 'text-center',
                title: "Điện thoại",
                data: "dienthoai",
            },

            {
                name: "ngaysinh",
                className: 'text-center',
                title: "Ngày sinh",
                data: "ngaysinh",
            },
            {
                name: "gioitinh",
                title: "Giới tính",
                className: 'text-center',
                data: "gioitinh",
                render: function(data){
                    if (data == 1){
                        return "Nữ";
                    }else{
                        return "Nam"
                    }
                }

            },
            {
                name: "duoi_xa_ttru",
                className: 'text-center',
                title: "Địa chỉ thường trú",
                data: "duoi_xa_ttru",
                render: function (data, type, row) {
                    return `${row.duoi_xa_ttru || ''}, ${row.name_province3}, ${row.name_province2}, ${row.name_province}`.replace(/^,/, '');
                }
            },
        ],
        scrollY: 430,
        language: {
            emptyTable: "Không tìm thấy sinh viên",
            info: " _START_ / _END_ trên _TOTAL_",
            paginate: {
                first: "Trang đầu",
                last: "Trang cuối",
                next: "Trang sau",
                previous: "Trang trước",
            },
            search: "Tìm kiếm:",
            loadingRecords: " ... ",
            lengthMenu: "Hiện thị _MENU_",
            infoEmpty: "",
        },
        retrieve: true,
        paging: false,
        lengthChange: false,
        searching: true,
        ordering: false,
        info: true,
        autoWidth: false,
        responsive: false,
        select: true,
    });

    // Xử lý sự kiện click trên hàng
    $('#table_thongtinsv tbody').on('click', 'tr', function(e) {
        // Chỉ xử lý sự kiện nếu click không phải vào checkbox
        if (!$(e.target).is('.hsnh_checkbox')) {
            var $checkbox = $(this).find('.hsnh_checkbox');
            if ($checkbox.length) {
                // Chuyển đổi trạng thái của checkbox
                $checkbox.prop('checked', !$checkbox.prop('checked'));
            }
        }
    });

    // Xử lý sự kiện click trên checkbox
    $('#table_thongtinsv tbody').on('click', '.hsnh_checkbox', function(e) {
        // Ngăn sự kiện click truyền lên hàng
        e.stopPropagation();
    });

    return table_thongtinsv;
}
$("#excel_hsnh_thongtinsinhvien").on('click',function(){
    var major = $('#major').val();
    var cccd = $('#cccd').val();
    var mssv = $('#mssv').val();
    major == 0 ? major = 0 :  major = $('#major').val();
    cccd == 0 ? cccd = 0 :  cccd = $('#cccd').val();
    mssv == 0 ? mssv = 0 :  mssv = $('#mssv').val();
    var hsnh_checkbox = document.getElementsByClassName('hsnh_checkbox');
    var id_sinhvien = []
    for(let i = 0;i<hsnh_checkbox.length; i++){
        if($(hsnh_checkbox[i]).prop('checked') == true){
            id_sinhvien.push($(hsnh_checkbox[i]).attr('id_taikhoan'));
        }
    }
    if(id_sinhvien.length > 0){
        window.location.href = "/admin24/excel_hsnh_thongtinsinhvien/"+major+"/"+cccd+"/"+mssv+"/"+id_sinhvien;
    }else{

        toastr.warning('Chọn ít nhất 1 sinh viên')
    }
})

function pdf_hsnh_thongtinsinhvien() {
    //lấy id nếu in lại phiếu cũ
    if ($.fn.DataTable.isDataTable('#table_thongtinsv')) {
        var table_thongtinsv = $("#table_thongtinsv").DataTable();

        // Lấy dữ liệu của tất cả các hàng đã chọn
        var selectedRows = table_thongtinsv.rows({ selected: true }).data();
        var maphieu
        selectedRows.each(function(value, index) {
            maphieu = value.mp
        });
    }

    if(maphieu){
        window.open("/admin24/hosonhaphoc/inlai_maphieu/"  + maphieu, "_blank");
    }else{
        var hsnh_checkbox = document.getElementsByClassName('hsnh_checkbox');
        var loaigiay = $('.loaigiay:checked').attr('id_loai');

        var id_sinhvien = [];
        for(let i = 0; i < hsnh_checkbox.length; i++) {
            if(loaigiay == 1){
                if($(hsnh_checkbox[i]).attr('id_gioitinh') == 0  && $(hsnh_checkbox[i]).prop('checked') === true){
                    id_sinhvien.push($(hsnh_checkbox[i]).attr('id_taikhoan'));
                }
            }else{
                if($(hsnh_checkbox[i]).prop('checked') === true) {
                    id_sinhvien.push($(hsnh_checkbox[i]).attr('id_taikhoan'));
                }
            }

        }
        if(id_sinhvien.length < 1) {
            toastr.warning("Không có SV hoặc đã chọn SV nữ khi in giấy NVQS.");
            return;
        } else if(!loaigiay) {
            toastr.warning("Vui lòng chọn loại giấy.");
            return;
        } else {
            $('#confirmModal').modal('show');
            // Handle confirmation button click
            $('#confirmPrintBtn').off('click').on('click', function() {
                var id_admin_sig = $('.admin_sig:checked').attr('id_admin_sig');
                if(id_sinhvien.length > 150){
                    toastr.warning("Không được in quá 150 giấy xác nhận");
                }else{
                    if(!id_admin_sig) {
                        toastr.warning("Vui lòng chọn cán bộ.");
                    } else {
                        let code = btoa(id_sinhvien.join(',') + "/" + loaigiay + "/" + id_admin_sig);
                        $('#confirmModal').modal('hide');
                        // window.open("/admin24/giayxacnhan/pdf_hsnh_thongtinsinhvien/" + id_sinhvien.join(',') + "/" + loaigiay + "/" + id_admin_sig, "_blank");
                        window.open("/admin24/pdf_hsnh_thongtinsinhvien/"+ code , "_blank");
                    }
                }
            });
        }
    }

}
function hsnh_checkall(){
    // var hsnh_checkbox = document.getElementsByClassName('hsnh_checkbox');
    if($('#hsnh_checkall').prop('checked') == true){
        $('.hsnh_checkbox').prop('checked',true)
    }else{
        $('.hsnh_checkbox').prop('checked',false)
    }

}
function loadmajor(){
    $.ajax({
        type: "get",
        url: "loadmajor",
        // load data huyện
        success: function (res) {
            $('#major').select2({data: res.major})

        }
    });
}
function loadloaigiay(){
    $.ajax({
        type: "get",
        url: "loadloaigiay",
        success: function (res) {
            var result = '';
            res.forEach(function(item){
                result += '<div class="col-sm-2 col-2 d-flex justify-content-center align-items-center">'+
                            '<input type="radio" class="form-control ttsv_info loaigiay" id="loaigiay_' + item.danhmuc_gxn_id + '" id_loai="' + item.danhmuc_gxn_id + '" name="ttsv_name_user" style="height:14px"  >'+
                        '</div>'+
                        '<label for="loaigiay_' + item.danhmuc_gxn_id + '" class="col-sm-10 col-10 col-form-label d-flex align-items-center" style="padding-bottom: 0px "><span style="font-weight:normal">'+item.danhmuc_gxn_tenloai+'</span></label>';
            });
            $('#loaigiay').html(result);
        }
    });
}

