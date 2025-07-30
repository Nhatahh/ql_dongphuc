$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    show_product();
    nsx_tennsx();
});
//
function nsx_tennsx() {
    $.ajax({
        type: "get",
        url: "nsx/nsx_tennsx",
        dataType: "json",
        success: function (res) {
            $("#addsp_tennsx").select2({
                data: res,
            });
        },
    });
}


function add_product() {
    if ($("#tensp").val() == "") {
        toastr.warning("Tên loại không được trống!");
    } else if ($("#addsp_tennsx").val() == 0) {
        toastr.warning("Tên nhà sản xuất không được trống!");
    } else {
        $.ajax({
            type: "post",
            url: "/admin/qlsp/add_product",
            // dataType: 'json',
            data: {
                tensp: $("#tensp").val(),
                addsp_tennsx: $("#addsp_tennsx").val(),
            },
            success: function (res) {
                if (res == 1) {
                    show_product();
                    toastr.success("Thêm thành công");
                }else if(res == 0){
                    toastr.warning("Tên sản phẩm của nhà sản xuất đã tồn tại!");

                }
                else {
                    toastr.warning("Thêm không thành công, liên hệ admin");
                }
            },
        });
    }
}


function delete_product(id) {
    $.ajax({
        type: "post",
        url: "/admin/qlsp/delete_product/" + id,
        success: function (res) {
            if (res == 1) {
                show_product();
                return toastr.success("Xóa thành công");
            } else {
                // $('#info_login').html('<span style = "color: red">Mật khẩu hoặc email không đúng</span>')
                return toastr.warning("Xóa không thành công!!Tồn tại loại trong hóa đơn nhập");
                // toastr.warning('aaaaaaaaaaaaaaaaaaaaa');
            }
        },
    });
}
//Get data ke
function edit_product(id) {
    $("#btnCapNhat").attr("data-id", id);
    $("#modal_edit_product").show();
    $("#editMenu").attr("data-id", id);
    $.ajax({
        type: "get",
        url: "/admin/qlsp/edit_product/" + id,
        dataType: "json",
        success: function (res) {
            $("#editproduct_nsx").select2({
                data: res.nsx,
            });
            // $("#e_link").val(editproduct_nsx);
            $("#editproduct_loai").val(res.info[0].name);
            $("#editproduct_trangthai").prop(
                "checked",
                res.info[0].trangthai == 1
            );
        },
    });
}

function capnhatloai() {
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
        url: "/admin/qlsp/capnhatloai/" + id,
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
//
function dongsualoai() {
    $("#modal_edit_product").hide();
    $("#editproduct_nsx").empty();
}
function huysualoai() {
    $("#modal_edit_product").hide();
    $("#editproduct_nsx").empty();
}

//
function clearEditMenuloai() {
    $("#editproduct_nsx").empty();
    var id = $("#btnCapNhat").data("id");
    edit_product(id);
}

function show_product() {
    $("#show_product").empty();
    $("#show_product").append(
        '<table class="table table-bordered table-hover table-striped dataTable no-footer dtr-inline" id="list_product"></table>'
    );
    var table = $("#list_product").DataTable({
        ajax: {
            type: "get",
            url: "/admin/qlsp/show_product",
        },
        // dom: 'frtip',
        columns: [
            { title: "Loại", data: "loai" },
            { title: "Nhà sản xuất", data: "nsx" },
            {
                title: "Trạng thái",
                data: "trangthai",
                render: function (data) {
                    var checkbox = data === 1 ? 'Hiện' : 'Ẩn';
                    return checkbox;
                },
            },
            {
                title: "Chức năng",
                data: "id_loai",
                render: function (data) {
                    var html =
                        '<i style ="color: #0000FF;" class="fa-regular fa-pen-to-square"  onclick = "edit_product(' +
                        data +
                        ')">&nbsp&nbsp</i><i style ="color: red;" class="fa-regular fa-trash-can"onclick = delete_product(' +
                        data +
                        ")></i>";

                    return html;
                },
            },
        ],

        columnDefs: [
            {
                targets: 2,
                className: "text-center",
            },
        ],
        scrollY: 450,
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
        retrieve: false,
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
