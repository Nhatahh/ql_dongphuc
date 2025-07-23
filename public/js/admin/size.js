$(document).ready(function () {
    $("#tableSize").DataTable({
        ajax: SizeDataUrl,
        columns: [
            { data: "stt", className: "text-center" },
            { data: "size_id", className: "text-center" },
            { data: "ten", className: "text-center" },
            {
                data: "size_id",
                className: "text-center",
                render: function (data) {
                    return `
                        <button class="btn btn-sm btn-warning me-1 btn-edit" data-size-id="${data}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button class="btn btn-sm btn-danger btn-delete" data-size-id="${data}">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;
                },
            },
        ],
    });

    // Thêm Size
    $(document).on("click", "#btnShowAddSize", function () {
        $("#formAddSize")[0].reset();
        $("#modalAddSize").modal("show");
    });

    $("#formAddSize").submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "/admin/size/add",
            type: "POST",
            data: {
                ten: $("#add_ten").val(),
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function () {
                $("#modalAddSize").modal("hide");
                $("#formAddSize")[0].reset();
                $("#tableSize").DataTable().ajax.reload(null, false);
                toastr.success("Thêm Size thành công!");
            },
            error: function (xhr) {
                toastr.error("Lỗi khi thêm: " + xhr.responseText);
            },
        });
    });

    // Sửa Size
    $(document).on("click", ".btn-edit", function () {
        const size_id = $(this).data("size-id");
        $.ajax({
            url: `/admin/size/${size_id}`,
            type: "GET",
            success: function (data) {
                $("#edit_size_id").val(data.size_id);
                $("#edit_ten").val(data.ten);
                $("#modalEditSize").modal("show");
            },
            error: function () {
                toastr.error("Không thể tải dữ liệu Size.");
            },
        });
    });

    $("#formEditSize").on("submit", function (e) {
        e.preventDefault();
        const size_id = $("#edit_size_id").val();
        const formData = {
            size_id: size_id,
            ten: $("#edit_ten").val(),
            _token: $('meta[name="csrf-token"]').attr("content"),
        };

        $.ajax({
            url: `/admin/size/${size_id}`,
            type: "PUT",
            data: formData,
            success: function (res) {
                $("#modalEditSize").modal("hide");
                $("#tableSize").DataTable().ajax.reload(null, false);
                toastr.success(res.message || "Cập nhật thành công!");
            },
            error: function () {
                toastr.error("Không thể cập nhật Size.");
            },
        });
    });

    // Xóa Size
    $("#tableSize").on("click", ".btn-delete", function () {
        const size_id = $(this).data("size-id");

        Swal.fire({
            title: "Bạn có chắc chắn?",
            text: "Size sẽ bị xóa và không thể khôi phục!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Xóa",
            cancelButtonText: "Hủy",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/size/${size_id}`,
                    type: "DELETE",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function () {
                        $("#tableSize").DataTable().ajax.reload(null, false);
                        toastr.success("Xóa Size thành công!");
                    },
                    error: function () {
                        toastr.error("Xóa Size thất bại!");
                    },
                });
            }
        });
    });
});
