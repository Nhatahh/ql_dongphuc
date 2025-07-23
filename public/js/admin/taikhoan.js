$(document).ready(function () {
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
