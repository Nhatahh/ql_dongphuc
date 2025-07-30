$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $('#hinhthucthanhtoan').select2()
    ds_hoadon().ajax.url("/admin24/ds_hoadon/-10").load();

});


// Table hóa đơn
function ds_hoadon(id) {
    var table_hoadon = $("#tb_hoadon").DataTable({
        ajax: {
            type: "get",
            url: "/admin24/ds_hoadon/" + id,
        },
        // dom: 'frtip',
        columns: [
            { title: "ID", data: "id" },
            { title: "Mã Hóa đơn", data: "mahoadon" },
            { title: "Họ tên", data: "hoten" },
            { title: "Lệ phí", data: "sotien" },
            { title: "Người thu", data: "nguoithu" },
            {
                title: "Hình thức",
                data: "hinhthuc",
                render: function (data) {
                    let trangthai = "";
                    switch (data) {
                        case 1:
                            trangthai = 'Chuyển khoản';
                            break;
                        case 2:
                            trangthai = 'Tiền mặt';
                            break
                        case 3:
                            trangthai = 'BaoKim';
                            break
                        default:
                            trangthai = '';
                            break
                    }
                    return trangthai
                },
            },
            { title: "Ngày thu", data: "ngaythu" },
            {
                title: "Chức năng",
                // width: "5%",
                data: "id",
                render: function (data, type, row) {
                    var html = '<i style ="color: red;" class="fa-regular fa-trash-can" onclick = "delete_hoadon(' + row.id + ', 4)"></i>'
                    return html;
                },
            }
            // {
            //     title: "Chức năng",
            //     width: "20%",
            //     data: "id",
            //     render: function(data) {
            //         var html =
            //             '<i style ="color: #0000FF;"  id="btt_setting_edit" id_edit="2" data-id="' +
            //             data +
            //             '" class="fa-regular fa-pen-to-square"  onclick = "edit_setting(' +
            //             data +
            //             ')">&nbsp&nbsp</i><i style ="color: red;" class="fa-regular fa-trash-can"  id="btt_chucnang_dlt" data-id="' +
            //             id_manhinh +
            //             '" id_delete="4" onclick = delete_chucnang(' +
            //             data +
            //             ")></i>";
            //         return html;
            //     },
            // },
        ],
        columnDefs: [{
            targets: 7,
            className: "text-center",
        },],
        scrollY: 300,
        language: {
            emptyTable: "Không có hóa đơn",
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
        lengthChange: false,
        searching: false,
        ordering: false,
        info: false,
        autoWidth: false,
        responsive: true,
        select: true,
    });
    return table_hoadon
}

function re_ttsinhvien() {
    $('#hoten').val('')
    $('#ngaysinh').val('')
    $('#cccd').val('')
    $('#email').val('')
    $('#dienthoai').val('')
    $('#diachi').val('')
    ds_hoadon().ajax.url("/admin24/ds_hoadon/-1").load();
}

$("#id_taikhoandong").on("change", function () {
    let id_taikhoandong = this.value
    if (id_taikhoandong == "") {
        re_ttsinhvien()
    } else {
        $.ajax({
            type: "get",
            url: "/admin24/ttsv_donglephi/" + id_taikhoandong,
            success: function (res) {
                if (res) {
                    $('#hoten').val(res.hoten)
                    $('#ngaysinh').val(res.ngaysinh)
                    $('#cccd').val(res.cccd)
                    $('#email').val(res.email)
                    $('#dienthoai').val(res.dienthoai)
                    $('#diachi').val(res.diachi)
                    ds_hoadon().ajax.url("/admin24/ds_hoadon/" + id_taikhoandong).load();
                    // ds_hoadon(id_taikhoandong)
                } else {
                    re_ttsinhvien()
                }
            },
        });
    }
});

async function thanhtoan(id_chucnang) {
    $('#modal_event').show();
    const check = await laythongtincheckquyen(id_chucnang);
    setTimeout(() => {
          var id_tk = $('#id_taikhoandong').val();
        var email = $('#email').val();
        var hoten = $('#hoten').val();
        var sotien = $('#sotien').val();
        var hinhthucthanhtoan = $('#hinhthucthanhtoan').val();
        $.ajax({
            type: "post",
            url: "/admin24/thanhtoan",
            data: {
                id_tk: id_tk,
                email: email,
                hoten: hoten,
                sotien: sotien,
                hinhthucthanhtoan: hinhthucthanhtoan,
                //Check quyền
                time: check[1],
                id_manhinh: check[0],
                id_chucnang: id_chucnang,
                active: 1,
            },
            success: function (res) {
                $('#modal_event').hide();
                if(res.trangthai == 'validate'){
                    var noidung = Object.values(res.noidung['original'])
                    toastr.warning(noidung[0])
                }else{
                    thongbao(res.trangthai)
                    ds_hoadon().ajax.url("/admin24/ds_hoadon/" + id_tk).load();
                }
            },
        });
    }, 2000);
}

async function delete_hoadon(id, id_chucnang) {
    var result = confirm("Bạn có chắc chắn xóa?");
    if (result) {
        const check = await laythongtincheckquyen(id_chucnang);
        // const time = await lay_time(id_chucnang);
        $.ajax({
            type: "post",
            url: "/admin24/delete_hoadon/" + id,
            data:{
                //Check quyền
                time: check[1],
                id_manhinh: check[0],
                id_chucnang: id_chucnang,
                active: 1,
            },
            success: function (res) {
                let id_taikhoandong = $('#id_taikhoandong').val()
                ds_hoadon().ajax.url("/admin24/ds_hoadon/" + id_taikhoandong).load();
                thongbao(res)
            },
        });
    }else{
        ds_hoadon().ajax.url("/admin24/ds_hoadon/" + id_taikhoandong).load();
    }

}
