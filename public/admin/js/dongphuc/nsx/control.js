$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#nsx_tennsx").select2();
    nsx_danhsachnsx();
});

function nsx_tennsx() {
    $.ajax({
        type: "get",
        url: "admin/nsx/nsx_tennsx",
        dataType: "json",
        success: function (res) {
            $("#nsx_tennsx").select2({
                data: res,
            });
        },
    });
}

function nsx_clear(){
    $("#nsx_ten").val('')
    $("#nsx_diachi").val('')
    $("#nsx_chucoso").val('')
    $("#nsx_dienthoai").val('')
    $("#nsx_email").val('')
}
function nsx_them() {
    if ($("#nsx_ten").val() == "") {
        toastr.warning("Tên nhà sản xuất không được trống!");
    } else if ($("#nsx_dienthoai").val() == "") {
        toastr.warning("Số điện thoại nhà sản xuất không được trống!");
    } else if ($("#nsx_chucoso").val() == "") {
        toastr.warning("Tên chủ cơ sở không được trống!");
    } else if ($("#nsx_diachi").val() == "") {
        toastr.warning("Địa chỉ nhà sản xuất không được trống!");
    } else if ($("#nsx_email").val() == "") {
        toastr.warning("Email nhà sản xuất không được trống!");
    } else {
        $.ajax({
            type: "post",
            url: "/admin/nsx/nsx_them",
            data: {
                ten: $("#nsx_ten").val(),
                diachi: $("#nsx_diachi").val(),
                chucoso: $("#nsx_chucoso").val(),
                dienthoai: $("#nsx_dienthoai").val(),
                email: $("#nsx_email").val(),
            },
            success: function (res) {
                if (res == 1) {
                    nsx_danhsachnsx();
                    nsx_clear();
                    toastr.success("Thêm thành công");
                } else {
                    toastr.warning("Cập nhật không thành công, liên hệ admin");
                }
            },
        });
    }
}

function delete_nsx(id) {
    $.ajax({
        type: "post",
        url: "/admin/nsx/delete_nsx/" + id,
        success: function (res) {
            if (res == 1) {
                nsx_danhsachnsx();
                return toastr.success("Xóa thành công");
            } else {
                return toastr.warning("Tồn tại size hoặc loại do nhà sản xuất này cung cấp");
            }
        },
    });
}

function edit_nsx(id) {
    $("#modal_editnsx").show();
    $("#btnCapNhat").attr("data-id", id);
    $.ajax({
        type: "get",
        url: "/admin/nsx/edit_nsx/" + id,
        dataType: "json",
        success: function (res) {
            var nsxData = res[0];
            $("#editnsx_ten").val(nsxData.name);
            $("#editnsx_diachi").val(nsxData.diachi);
            $("#editnsx_chucoso").val(nsxData.chucoso);
            $("#editnsx_dienthoai").val(nsxData.dienthoai);
            $("#editnsx_email").val(nsxData.email);
        },
    });
}


function capnhatnsx() {
    var id = $("#btnCapNhat").data("id");
    var editnsx_ten = $("#editnsx_ten").val();
    var editnsx_diachi = $("#editnsx_diachi").val();
    var editnsx_chucoso = $("#editnsx_chucoso").val();
    var editnsx_dienthoai = $("#editnsx_dienthoai").val();
    var editnsx_email = $("#editnsx_email").val();
    $.ajax({
        type: "post",
        url: "nsx/capnhatnsx/" + id,
        data: {
            id: id,
            editnsx_ten: editnsx_ten,
            editnsx_diachi: editnsx_diachi,
            editnsx_chucoso: editnsx_chucoso,
            editnsx_dienthoai: editnsx_dienthoai,
            editnsx_email: editnsx_email,
        },
        success: function (res) {
            if(res == 1){
                nsx_danhsachnsx();
                $("#modal_editnsx").hide();
                return toastr.success("Cập nhật thành công");
            }
            else if(res == 0){
                return toastr.success("Cập nhật không thành công");
            }
        },
    });
}

function modal_close_nsx() {
    $("#modal_editnsx").hide();
}

function modal_huy_nsx() {
    $("#modal_editnsx").hide();
}

//
function modal_lammoi_nsx() {
    var id = $("#btnCapNhat").data("id");
    edit_nsx(id);
}
//

function nsx_danhsachnsx() {
    $("#nsx_danhsachnsx").empty();
    $("#nsx_danhsachnsx").append(
        '<table class="table table-bordered table-hover table-striped dataTable no-footer dtr-inline" id="danhsachnsx"></table>'
    );
    var table = $("#danhsachnsx").DataTable({
        ajax: {
            type: "get",
            url: "nsx/danhsachnsx",
        },

        // dom: 'frtip',
        columns: [
            { title: "Tên nhà sản xuất", data: "name" },
            { title: "Địa chỉ", data: "diachi" },
            { title: "Chủ cơ sở", data: "chucoso" },
            { title: "Điện thoại", data: "dienthoai" },
            { title: "Email", data: "email" },
            {
                title: "Chức năng",
                data: "id",
                render: function (data) {
                    var html =
                        '<i style ="color: #0000FF;" class="fa-regular fa-pen-to-square" onclick = "edit_nsx(' +
                        data +
                        ')">&nbsp&nbsp</i><i style ="color: red;" class="fa-regular fa-trash-can" onclick = delete_nsx(' +
                        data +
                        ")></i>";
                    return html;
                },
            },
        ],
        'columnDefs': [
            {
                "targets": 3,
                "className": "text-center",
            },
            {
                "targets": 5,
                "className": "text-center",
            },],
        scrollY: 450,
        language: {
            emptyTable: "Không có sản phẩm",
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
    });
}
