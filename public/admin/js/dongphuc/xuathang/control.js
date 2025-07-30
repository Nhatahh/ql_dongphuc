$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    xh_lop();
    $("#xuathang_alllop").select2();
    //    $('.banhang_size').select2()
    // $("#xuathang_alllop").select2();
});
//
function xh_lop() {
    $.ajax({
        type: "get",
        url: "xuathang/xuathang_lop",
        dataType: "json",
        success: function (res) {
            $("#xuathang_alllop").select2({
                data: res,
            });
        },
    });
}
//
function show_xuathang(id) {
    $("#bttbanhang").attr("data-idsv", id);
    $("#modal_xuathang").show();
    //
    $("#tb_xuathang").empty();
    $("#tb_xuathang").append(
        '<table class="table table-bordered table-hover table-striped" id="list_xuathang"></table>'
    );
    var table = $("#list_xuathang").DataTable({
        ajax: {
            type: "get",
            url: "xuathang/show_xuathang",
        },
        // dom: 'frtip',
        columns: [
            {
                title: "Loại",
                data: "name",
            },
            {
                title: "Nhà sản xuất",
                data: "name1",
            },
            // { title: "Size", data: "ten_size" },
            // { title: "Kệ", data: "ten_ke" },
            {
                title: "Size",
                data: "size",
                render: function (data) {
                    var html =
                        '<select id="size' +
                        data.id_loai +
                        '" id_loai = "' +
                        data.id_loai +
                        '" id_nsx = "' +
                        data.id_nsx +
                        '"   onchange = "change_size(' +
                        data.id_loai +
                        "," +
                        data.id_nsx +
                        ')"  style = "width:100%;height:100%;background-color:inherit;border:none" class = "banhang_size">';
                    html += "<option value = '0' >Chọn size</option>";
                    for (let i = 0; i < data.size.length; i++) {
                        html +=
                            "<option value = " +
                            data.size[i].idsz +
                            " >" +
                            data.size[i].namesize +
                            "</option>";
                    }
                    html += "</select>";
                    return html;
                },
            },

            {
                title: "Số lượng",
                data: "size",
                render: function (data) {
                    return (
                        '<span id = "banhang_size' +
                        data.id_loai +
                        "x" +
                        data.id_nsx +
                        '"></span>'
                    );
                },
            },
            {
                title: "Số lượng phát",
                data: "id_loai",
                render: function (data) {
                    var inputHtml =
                        '<input id-data = "' +
                        data +
                        '" class = "banhang" style = "width:100%;height:100%;background-color:inherit;border:none" type="number" id="input_soluong">';
                    return inputHtml;
                },
            },
            // {
            //     title: "Chức năng",
            //     data: "ten_loai",
            //     render: function () {
            //         var html =
            //             '<i style ="color: #0000FF;" class="fa-regular fa-pen-to-square"  onclick = "show_xuathang()">&nbsp&nbsp</i>';
            //         return html;
            //     },
            // },
        ],

        // columnDefs: [
        //     {
        //         targets: 4,
        //         className: "text-center",
        //     },
        // ],

        // scrollY: 400,
        language: {
            emptyTable: "Không có sản phẩm",
            info: " _START_ / _END_ trên _TOTAL_ sản phẩm",
            paginate: {
                first: "Trang đầu",
                last: "Trang cuối",
                next: "Trang sau",
                previous: "Trang trước",
            },
            search: "Tìm kiếm:",
            loadingRecords: "Đang tìm kiếm ... ",
            lengthMenu: "Hiện thị _MENU_ sản phẩm",
            infoEmpty: "",
        },
        retrieve: true,
        paging: false,
        lengthChange: false,
        searching: false,
        ordering: false,
        info: false,
        autoWidth: true,
        responsive: true,
        select: false,
    });
}
//
function btt_xuathang() {
    var id = $("#btnCapNhat").data("id");
    var editproduct_loai = $("#editproduct_loai").val();
    var editproduct_nsx = $("#editproduct_nsx").val();
    //trạng thái
    var editproduct_trangthai = $("#editproduct_trangthai").is(":checked");

    if (editproduct_trangthai) {
        // Checkbox is checked.
        editproduct_trangthai = 1;
    } else {
        // Checkbox is not checked.
        editproduct_trangthai = 0;
    }
    //
    $.ajax({
        type: "post",
        url: "loadsp/capnhatloai/" + id,
        data: {
            id: id,
            editproduct_loai: editproduct_loai,
            editproduct_nsx: editproduct_nsx,
            editproduct_trangthai: editproduct_trangthai,
        },
        success: function (res) {
            if (res == 1) {
                show_product();
                dongsualoai();
                $("#modal_editnsx").hide();
                return toastr.success("Cập nhật thành công");
            } else if (res == 0) {
                return toastr.success("Cập nhật không thành công");
            }
        },
    });
}
// đóng xuất hàng
function modal_close_xuathang() {
    $("#modal_xuathang").hide();
}

//
function timkiem_lop() {
    $("#xuathang_dssv").empty();
    $("#xuathang_dssv").append(
        '<table class="table table-bordered table-hover table-striped dataTable no-footer dtr-inline" id="danhsachsinhvien"></table>'
    );
    var xuathang_alllop = $("#xuathang_alllop").val();
    var table = $("#danhsachsinhvien").DataTable({
        ajax: {
            type: "get",
            url: "xuathang/xuathang_alllop",
            data: {
                xuathang_alllop: xuathang_alllop,
            },
        },

        // dom: 'frtip',

        columns: [
            { title: "MSSV", data: "mssv" },
            { title: "CCCD", data: "cccd" },
            { title: "Họ và Tên", data: "ho_ten" },
            { title: "Lớp", data: "lop" },
            {
                title: "Chức năng",
                data: "id",
                render: function (data) {
                    var html =
                        '<i style ="color: #0000FF;" class="fa-regular fa-brands fa-shopify"  onclick = "show_xuathang(' +
                        data +
                        ')"></i>';

                    return html;
                },
            },
        ],

        columnDefs: [
            {
                targets: 4,
                className: "text-center",
            },
        ],

        scrollY: 400,
        language: {
            emptyTable: "Không có sinh viên",
            info: " _START_ / _END_ trên _TOTAL_",
            paginate: {
                first: "Trang đầu",
                last: "Trang cuối",
                next: "Trang sau",
                previous: "Trang trước",
            },
            search: "Tìm kiếm:",
            loadingRecords: "Đang tìm kiếm ... ",
            lengthMenu: "_MENU_",
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
    });
}

function change_size(id_nsx, id_loai) {
    var id_size = $("#banhang_size" + id_nsx + "x" + id_loai).val();
    $.ajax({
        type: "get",
        url: "xuathang/change_size/" + id_nsx + "/" + id_loai,
        success: function (res) {
            $("#banhang_size" + id_nsx + "x" + id_loai).text(res);
        },
    });
}

function banhang(){
    var button = document.getElementById('bttbanhang');
    var idsv = button.getAttribute('data-idsv');
    var banhang = document.getElementsByClassName('banhang')
    var list_banhang = [];
    var i = 0;
    for(let i = 0; i<banhang.length; i++){
        if($(banhang[i]).val() != ""){
            var id = $(banhang[i]).attr('id-data')
            if($(banhang[i]).val() > 0){
                if($('#size'+id).val() != 0){
                    list_banhang.push([$('[id=size' + id + ']').attr('id_loai'), $('[id=size' + id + ']').attr('id_nsx'), $('#size' + id).val(), $(banhang[i]).val()]);
                }
            }
        }
    }
    if(list_banhang.length <= 0){
        toastr.warning('Chọn size hoặc số lượng phát')
    }else{
        $.ajax({
            type: "post",
            url: "xuathang/banhang",
            data: {
                list_banhang:list_banhang,
                idsv:idsv
            },
            success: function (res) {
                if (res.active == 1) {
                    toastr.success("Xuất thành công");
                    var pri = confirm("Có muốn in hóa đơn ?!")
                    $("#modal_xuathang").hide();
                    if (pri == true){
                        window.open("http://congmotcua.ctuet.edu.vn/admin/hoadon/printhd/"+res.id_hd, "_blank");
                    }
                } else if (res.active == 0) {
                    toastr.warning("Xuất không thành công");
                } else if (res.active == 2) {
                    toastr.warning("Không đủ hàng để bán!!!???");
                }
            },
        });
    }
}

