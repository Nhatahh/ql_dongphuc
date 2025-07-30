$(document).ready(function () {
    $("#tableNhaSanXuat").DataTable({
        ajax: NSXDataUrl,
        columns: [
            { data: "stt", className: "text-center" },
            { data: "nsx_id", className: "text-center" },
            { data: "ten", className: "text-center" },
            {
                data: "nsx_id",
                className: "text-center",
                render: function (data) {
                    return `
                        <button class="btn btn-sm btn-warning me-1 btn-edit" data-nsx-id="${data}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button class="btn btn-sm btn-danger btn-delete" data-nsx-id="${data}">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;
                },
            },
        ],
    });

    // Thêm Nhà sản xuất
    $(document).on("click", "#btnShowAddNSX", function () {
        $("#formAddNSX")[0].reset();
        $("#modalAddNSX").modal("show");
    });

    $("#formAddNSX").submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "/admin/nhasanxuat/add",
            type: "POST",
            data: {
                ten: $("#add_ten").val(),
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function () {
                $("#modalAddNSX").modal("hide");
                $("#formAddNSX")[0].reset();
                $("#tableNhaSanXuat").DataTable().ajax.reload(null, false);
                toastr.success("Thêm Nhà sản xuất thành công!");
            },
            error: function (xhr) {
                toastr.error("Lỗi khi thêm: " + xhr.responseText);
            },
        });
    });

    // Sửa Nhà sản xuất
    $(document).on("click", ".btn-edit", function () {
        const nsx_id = $(this).data("nsx-id");
        $.ajax({
            url: `/admin/nhasanxuat/${nsx_id}`,
            type: "GET",
            success: function (data) {
                $("#edit_nsx_id").val(data.nsx_id);
                $("#edit_ten").val(data.ten);
                $("#modalEditNSX").modal("show");
            },
            error: function () {
                toastr.error("Không thể tải dữ liệu Nhà sản xuất.");
            },
        });
    });

    $("#formEditNSX").on("submit", function (e) {
        e.preventDefault();
        const nsx_id = $("#edit_nsx_id").val();
        const formData = {
            nsx_id: nsx_id,
            ten: $("#edit_ten").val(),
            _token: $('meta[name="csrf-token"]').attr("content"),
        };

        $.ajax({
            url: `/admin/nhasanxuat/${nsx_id}`,
            type: "PUT",
            data: formData,
            success: function (res) {
                $("#modalEditNSX").modal("hide");
                $("#tableNhaSanXuat").DataTable().ajax.reload(null, false);
                toastr.success(res.message || "Cập nhật thành công!");
            },
            error: function () {
                toastr.error("Không thể cập nhật Nhà sản xuất.");
            },
        });
    });

    // Xóa Nhà sản xuất
    $("#tableNhaSanXuat").on("click", ".btn-delete", function () {
        const nsx_id = $(this).data("nsx-id");

        Swal.fire({
            title: "Bạn có chắc chắn?",
            text: "Nhà sản xuất sẽ bị xóa và không thể khôi phục!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Xóa",
            cancelButtonText: "Hủy",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/nhasanxuat/${nsx_id}`,
                    type: "DELETE",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function () {
                        $("#tableNhaSanXuat")
                            .DataTable()
                            .ajax.reload(null, false);
                        toastr.success("Xóa nhà sản xuất thành công!");
                    },
                    error: function () {
                        toastr.error("Xóa nhà sản xuất thất bại!");
                    },
                });
            }
        });
    });
});
