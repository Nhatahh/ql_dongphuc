

$('#major_bhyt').select2()
loadlop_bhyt()

$(document).on('keydown click', function(event) {
    if (event.type === 'keydown' && event.key === "Escape") {
        $('#modal_event').hide('fast');
    }
    if (event.type === 'click' && !$(event.target).closest('#img_bhyt_load, .fa-circle-xmark').length) {
        $('#modal_event').hide('fast');
    }
});

$('.rounded-circle').on('click', function() {
    $('#modal_event_bhyt').hide('fast');
});
table_thongtinsv_bhyt(0,-1,-1,-1).ajax.url("loadthongtin_bhyt/-1/254514dfdf41214mkli/254514dfdf41214mkli/254514dfdf41214mkli").load();

function loadlop_bhyt(){
    $.ajax({
        type: "get",
        url: "loadlop_bhyt/",
        success: function (res) {
            $('#major_bhyt').select2({data: res.lop})

        }
    });
}

function search_bhyt() {
    var major = $('#major_bhyt').val();
    var cccd = $('#cccd_bhyt').val();
    var mssv = $('#mssv_bhyt').val();
    var bhyt = $('#sothe_bhyt').val();
    var major1 = 0,
    cccd1 = 0,
    mssv1 = 0,
    bhyt1 = 0
    major == 0 ? major1 = -1 :  major1 = major;
    cccd == '' ? cccd1 = '254514dfdf41214mkli' :  cccd1 = cccd;
    mssv == '' ? mssv1 = '254514dfdf41214mkli' :  mssv1 = mssv;
    bhyt == '' ? bhyt1 = '254514dfdf41214mkli' :  bhyt1 = bhyt;
    table_thongtinsv_bhyt().ajax.url("/admin24/loadthongtin_bhyt/"+major1+"/"+cccd1+"/"+mssv1+"/"+bhyt1).load();
}

function table_thongtinsv_bhyt(major,cccd,mssv,bhyt){
    if ($.fn.DataTable.isDataTable("#table_thongtinsv_bhyt")) {
        $("#table_thongtinsv_bhyt").DataTable().destroy();
        $("#table_thongtinsv_bhyt").empty();
    }
    var table_thongtinsv_bhyt =  $("#table_thongtinsv_bhyt").DataTable({
        ajax: "/admin24/loadthongtin_bhyt/"+major+"/"+cccd+"/"+mssv+"/"+bhyt,
        columns: [
            {
                title: '<input type="checkbox" id="hsnh_checkall_bhyt" onclick="hsnh_checkall()" style="height:19px">',
                className: 'text-center',
                data: null,
                render: function(data, type, row) {
                    return '<input type="checkbox" class="hsnh_checkbox_bhyt" id_taikhoan=' + row.id_taikhoan + ' style="height:19px">';
                }
            },
            {
                name: "bhyt",
                className: 'text-center',
                title: "",
                data: "bhyt" ,
                render: function(data,type,row){
                    return '<i onclick = "open_img('+row.id_taikhoan+')" style = "color:blue" class="fa-solid fa-file-image"></i>'
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
                render: function(data, type, row) {
                    if(row.trangthai == 1){
                        return  '<span style = "color:red">'+data+'</span>'
                    }else{
                        return '<span>'+data+'</span>'
                    }
                }

            },
            {
                name: "hoten",
                title: "Họ và tên",
                data: "hoten",
                render: function(data, type, row) {
                    if(row.trangthai == 1){
                        return  '<span style = "color:red">'+data+'</span>'
                    }else{
                        return '<span>'+data+'</span>'
                    }
                }
            },
            {
                name: "cccd",
                className: 'text-center',
                title: "CCCD/CMND",
                data: "cccd"
            },
            {
                name: "dienthoai",
                className: 'text-center',
                title: "Điện thoại",
                data: "dienthoai"
            },
            {
                name: "lop",
                title: "Lớp",
                data: "lop"
            },
            {
                name: "ngaysinh", className: 'text-center',
                title: "Ngày sinh",
                data: "ngaysinh"
            },
            // {
            //     name: "gioitinh",
            //     title: "Giới tính",
            //     className: 'text-center',
            //     data: "gioitinh",
            //     render:
            //     function(data) {
            //         return data == 1 ? "Nữ" : "Nam";
            //     }
            // },

            {
                name: "bhyt",
                className: 'text-center',
                title: "Số thẻ BHYT",
                data: "bhyt",
                render: function(data, type, row) {
                    return `<input style = "background-color: inherit; width: 100%; margin-top:-1px; height: fit-content; border:none" onchange = "capnhat_bhyt(${row.id_taikhoan})" id = "sobhyt${row.id_taikhoan}" data-id="${row.id_taikhoan}" data-column="bhyt" value = "${data || ''}">`;
                }
            },
            {
                name: "name_province",
                className: 'text-center',
                title: "Hộ khẩu thường trú",
                data: "name_province",
                render: function (data, type, row) {
                    return `${row.duoi_xa_ttru || ''}, ${row.name_province3}, ${row.name_province2}, ${row.name_province}`.replace(/^,/, '');
                }
            },
            {
                name: "trangthai",
                className: 'text-center',
                title: "Trạng thái",
                data: "trangthai",
                render: function (data, type, row) {
                    if(data == 0){
                        return  '<small class="badge badge-primary"><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;&nbsp;Đang học</small>'
                    }else{
                        return '<small class="badge badge-danger"><i class="fa-regular fa-circle-xmark"></i>&nbsp;&nbsp;Tạm ngưng</small>'
                    }

                }
            },
            {
                name: "ghichu",
                className: 'text-center',
                title: "Ghi chú",
                data: "ghichu",
                render: function (data, type, row) {
                    if(data == 0 || data == null){
                        return ''
                    }else{
                        return data
                    }

                }
            },
















        ],
        scrollY: 450,
        scrollX:true,
        language: {
            emptyTable: "Không tìm thấy sinh viên",
            info: " _START_ / _END_ trên _TOTAL_",
            paginate: {
                first: "Trang đầu",last: "Trang cuối",
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
    })
    return table_thongtinsv_bhyt;
}

function hsnh_checkall(){
    if($('#hsnh_checkall_bhyt').prop('checked') == true){
        $('.hsnh_checkbox_bhyt').prop('checked',true)
    }else{
        $('.hsnh_checkbox_bhyt').prop('checked',false)
    }

}

$('#table_thongtinsv_bhyt tbody').on('click', 'tr', function(e) {
    if (!$(e.target).is('.hsnh_checkbox_bhyt')) {
        var checkbox = $(this).find('input.hsnh_checkbox_bhyt');
        if (checkbox.prop('checked')) {
            checkbox.prop('checked', false);
            $(this).removeClass('selected');
        } else {
            checkbox.prop('checked', true);
            $(this).addClass('selected');
        }
    }
});

$("#excel_hsnh_thongtinsinhvien_bhyt").on('click', function () {
    if($('#major_bhyt').val() > 0){
        var hsnh_checkbox = document.getElementsByClassName('hsnh_checkbox_bhyt');
        var id_sinhvien = []
        for(let i = 0;i<hsnh_checkbox.length; i++){
            if($(hsnh_checkbox[i]).prop('checked') == true){
                id_sinhvien.push($(hsnh_checkbox[i]).attr('id_taikhoan'));
            }
        }
        if (id_sinhvien.length==0){
            toastr.warning('Vui lòng chọn sinh viên')
        } else{
            window.location.href = "/admin24/excel_hsnh_thongtinsinhvien_bhyt/" +id_sinhvien.join(',');
        }
    }else{
        toastr.warning('Vui lòng chọn Lớp danh nghĩa')
    }

});

$('#import_bhyt').on('click', function() {
    $('#importForm').submit();
});

$('#importForm').on('submit', function(e) {
    e.preventDefault();
    var filePath = $('#fileInput').val();
    if(filePath==''){
        toastr.warning('Vui lòng chọn file')
    }else{
        var allowedExtensions = /(\.xlsx|\.xls)$/i;
        if (!allowedExtensions.exec(filePath)) {
            toastr.warning("File không đúng định dạng!");
        } else {
            $.ajax({
                url: "/admin24/import_bhyt",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data == 1) {
                        toastr.success("Tải lên thành công");
                        table_thongtinsv_bhyt(0, 0, 0, 0).ajax.url("loadthongtin_bhyt/0/254514dfdf41214mkli/254514dfdf41214mkli/254514dfdf41214mkli").load();
                    } else {
                        toastr.error("Hệ thống bị lỗi");
                    }
                },
                // error: function() {
                //     toastr.error("Có lỗi xảy ra trong quá trình import");
                // }
            });
        }
    }
});

//img
function open_img(id){
    $.ajax({
        url: "/admin24/img_bhyt/"+id,
        type:"get",
        success:function(data){
            $('#modal_event_bhyt').show('slow');
            $('#img_bhyt_load').attr('src', data);
        }
    });
}
document.getElementById('selectFileBtn').addEventListener('click', function() {
    document.getElementById('fileInput').click();
});
  document.getElementById('cancelFileBtn').addEventListener('click', function() {
    var fileInput = document.getElementById('fileInput');
    var selectedFileName = document.getElementById('selectedFileName');

    fileInput.value = '';

    selectedFileName.innerHTML = '';

});
document.getElementById('fileInput').addEventListener('change', function() {
    var fileInput = document.getElementById('fileInput');
    var fileNameContainer = document.getElementById('selectedFileName');
    if (fileInput.files.length > 0) {
        fileNameContainer.innerHTML = '' + fileInput.files[0].name;
    } else {
        fileNameContainer.innerHTML = '';
    }
});


function capnhat_bhyt(id_taikhoan){
    var value = $('#sobhyt'+id_taikhoan).val()
    $('#modal_event').show();
    $.ajax({
        url: "/admin24/capnhat_bhyt",
        type:"post",
        data: {
            id_taikhoan: id_taikhoan,
            value: value,
        },
        success:function(res){
            $('#modal_event').hide();
            $('#sobhyt'+id_taikhoan).val(res.noidung)
            thongbao(res.trangthai)
        }
    });
}
