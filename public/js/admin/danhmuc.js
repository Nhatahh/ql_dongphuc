$(document).ready(function () {
    $("#tableDanhMuc").DataTable({
        ajax: DanhMucDataUrl,
        columns: [
            { data: "stt", className: "text-center" },
            { data: "dm_id", className: "text-center" },
            { data: "ten", className: "text-center" },
            {
                data: "dm_id",
                className: "text-center",
                render: function (data) {
                    return `
                        <button class="btn btn-sm btn-warning me-1 btn-edit" data-dm-id="${data}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button class="btn btn-sm btn-danger btn-delete" data-dm-id="${data}">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;
                },
            },
        ],
    });

    // Thêm danh mục
    $(document).on("click", "#btnShowAddDanhMuc", function () {
        $("#formAddDanhMuc")[0].reset();
        $("#modalAddDanhMuc").modal("show");
    });

    $("#formAddDanhMuc").submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "/admin/danhmuc/add",
            type: "POST",
            data: {
                ten: $("#add_ten").val(),
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function () {
                $("#modalAddDanhMuc").modal("hide");
                $("#formAddDanhMuc")[0].reset();
                $("#tableDanhMuc").DataTable().ajax.reload(null, false);
                toastr.success("Thêm danh mục thành công!");
            },
            error: function (xhr) {
                toastr.error("Lỗi khi thêm: " + xhr.responseText);
            },
        });
    });

    // Sửa danh mục
    $(document).on("click", ".btn-edit", function () {
        const dm_id = $(this).data("dm-id");
        $.ajax({
            url: `/admin/danhmuc/${dm_id}`,
            type: "GET",
            success: function (data) {
                $("#edit_dm_id").val(data.dm_id);
                $("#edit_ten").val(data.ten);
                $("#modalEditDanhMuc").modal("show");
            },
            error: function () {
                toastr.error("Không thể tải dữ liệu danh mục.");
            },
        });
    });

    $("#formEditDanhMuc").on("submit", function (e) {
        e.preventDefault();
        const dm_id = $("#edit_dm_id").val();
        const formData = {
            dm_id: dm_id,
            ten: $("#edit_ten").val(),
            _token: $('meta[name="csrf-token"]').attr("content"),
        };

        $.ajax({
            url: `/admin/danhmuc/${dm_id}`,
            type: "PUT",
            data: formData,
            success: function (res) {
                $("#modalEditDanhMuc").modal("hide");
                $("#tableDanhMuc").DataTable().ajax.reload(null, false);
                toastr.success(res.message || "Cập nhật thành công!");
            },
            error: function () {
                toastr.error("Không thể cập nhật danh mục.");
            },
        });
    });

    // Xóa danh mục
    $("#tableDanhMuc").on("click", ".btn-delete", function () {
        const dm_id = $(this).data("dm-id");

        Swal.fire({
            title: "Bạn có chắc chắn?",
            text: "Danh mục sẽ bị xóa và không thể khôi phục!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Xóa",
            cancelButtonText: "Hủy",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/danhmuc/${dm_id}`,
                    type: "DELETE",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function () {
                        $("#tableDanhMuc").DataTable().ajax.reload(null, false);
                        toastr.success("Xóa danh mục thành công!");
                    },
                    error: function () {
                        toastr.error("Xóa danh mục thất bại!");
                    },
                });
            }
        });
    });
});
