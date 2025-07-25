$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    // Tabl User
    $("#usersTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: "admin/users/data",
        columns: [
            { data: "user_id", className: "text-center" },
            { data: "username", className: "text-center" },
            { data: "mssv", className: "text-center" },
            { data: "email", className: "text-center" },
            { data: "sdt", className: "text-center" },
            { data: "hoten", className: "text-center" },
            { data: "diachi", className: "text-center" },
            { data: "trangthai", className: "text-center" },
            {
                data: "user_id",
                className: "text-center",
                render: function (data) {
                    return `
                        <button class="btn btn-sm btn-warning me-1 btn-edit" data-user-id="${data}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button class="btn btn-sm btn-danger btn-delete" data-user-id="${data}">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;
                },
                className: "text-center",
            },
        ],
    });
    // Tabl Admin
    $("#adminsTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: "admin/admins/data",
        columns: [
            { data: "admin_id" },
            { data: "username" },
            { data: "created_at" },
            { data: "trangthai" },
            {
                data: "admin_id",
                className: "text-center",
                render: function (data) {
                    return `
                        <button class="btn btn-sm btn-warning me-1 btn-edit" data-admin-id="${data}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button class="btn btn-sm btn-danger btn-delete" data-admin-id="${data}">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;
                },
                className: "text-center",
            },
        ],
    });
});

// Xóa Admin
$("#adminsTable").on("click", ".btn-delete", function () {
    const admin_id = $(this).data("admin-id");

    Swal.fire({
        title: "Bạn chắc chắn muốn xóa?",
        text: "Sản phẩm sẽ bị xóa vĩnh viễn!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Xóa",
        cancelButtonText: "Hủy",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/admin-del/${admin_id}`,
                method: "DELETE",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function () {
                    $("#adminsTable").DataTable().ajax.reload(null, false);
                    toastr.success("Xóa thành công!");
                },
                error: function () {
                    toastr.error("Xóa thất bại!");
                },
            });
        }
    });
});
// Xóa User
$("#usersTable").on("click", ".btn-delete", function () {
    const user_id = $(this).data("user-id");

    Swal.fire({
        title: "Bạn chắc chắn muốn xóa?",
        text: "Sản phẩm sẽ bị xóa vĩnh viễn!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Xóa",
        cancelButtonText: "Hủy",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/user-del/${user_id}`,
                method: "DELETE",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function () {
                    $("#usersTable").DataTable().ajax.reload(null, false);
                    toastr.success("Xóa thành công!");
                },
                error: function () {
                    toastr.error("Xóa thất bại!");
                },
            });
        }
    });
});

// Show Modal Add Admin
$("#btnShowAddAdmin").on("click", function () {
    $("#addAdminForm")[0].reset();
    $("#addAdminModal").modal("show");
});
// Add Admin
$("#addAdminForm").on("submit", function (e) {
    e.preventDefault();
    let formData = new FormData(this);

    // Thêm CSRF token
    formData.append("_token", $('meta[name="csrf-token"]').attr("content"));

    // Xóa lỗi cũ
    $(".invalid-feedback").text("");
    $(".form-control").removeClass("is-invalid");

    $.ajax({
        url: "/admin/admin-add",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function () {
            $("#addAdminModal").modal("hide");
            $("#adminsTable").DataTable().ajax.reload(null, false);
            toastr.success("Đã thêm Admin!");
        },
        error: function (xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                for (let key in errors) {
                    let input = $("#" + key);
                    input.addClass("is-invalid");
                    $("#error-" + key).text(errors[key][0]);
                }
                toastr.error("Vui lòng kiểm tra lại thông tin.");
            } else {
                toastr.error("Đã xảy ra lỗi khi thêm tài khoản!");
            }
        },
    });
});
