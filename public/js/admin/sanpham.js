$(document).ready(function () {
    $("#productsTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: sanphamDataUrl,
        columns: [
            { data: "sp_id" },
            {
                data: "image_url",
                render: function (data) {
                    return `<img src="/images/${data}" alt="Ảnh" width="60" height="60" style="object-fit: cover;">`;
                },
            },
            { data: "tensp" },
            { data: "mota" },
            { data: "gia" },
            { data: "danhmuc" },
            { data: "nhasanxuat" },
            {
                data: "sp_id",
                className: "text-center",
                render: function (data) {
                    return `
                        <button class="btn btn-sm btn-warning me-1 btn-edit" data-sp-id="${data}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button class="btn btn-sm btn-danger btn-delete" data-sp-id="${data}">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;
                },
            },
        ],
    });

    $("#edit_dm_id").select2({
        placeholder: "Chọn danh mục",
        ajax: {
            url: "/danhmuc/select2",
            dataType: "json",
            processResults: function (data) {
                return {
                    results: data.map((item) => ({
                        id: item.id,
                        text: item.ten,
                    })),
                };
            },
        },
    });

    $("#edit_nsx_id").select2({
        placeholder: "Chọn nhà sản xuất",
        ajax: {
            url: "/nhasanxuat/select2",
            dataType: "json",
            processResults: function (data) {
                return {
                    results: data.map((item) => ({
                        id: item.id,
                        text: item.ten,
                    })),
                };
            },
        },
    });

    // Khi nhấn nút sửa
    $(document).on("click", ".btn-edit", function () {
        const sp_id = $(this).data("sp-id");

        $.ajax({
            url: `sanpham/${sp_id}`,
            method: "GET",
            success: function (sp) {
                $("#edit_sp_id").val(sp.sp_id);
                $("#edit_tensp").val(sp.tensp);
                $("#edit_mota").val(sp.mota);
                $("#edit_gia").val(sp.gia);
                $("#current_image").attr("src", `/images/${sp.image_url}`);

                // Load Select2 và gán giá trị
                let newDM = new Option(
                    sp.danhmuc?.ten || "",
                    sp.dm_id,
                    true,
                    true
                );
                let newNSX = new Option(
                    sp.nhasanxuat?.ten || "",
                    sp.nsx_id,
                    true,
                    true
                );
                $("#edit_dm_id").val(newDM).trigger("change");
                $("#edit_nsx_id").val(newNSX).trigger("change");
                console.log("Đổ dữ liệu xong, mở modal");

                $("#editModal").modal("show");
            },
            error: function () {
                Swal.fire("Lỗi", "Không thể tải dữ liệu sản phẩm", "error");
            },
        });
    });

    $("#editSanphamForm").on("submit", function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        formData.append("_method", "PUT");
        const id = $("#edit_sp_id").val();

        $.ajax({
            url: `/sanpham/${id}`,
            method: "POST", // gửi POST kèm _method=PUT
            data: formData,
            processData: false,
            contentType: false,
            success: function () {
                $("#editModal").modal("hide");
                $("#productsTable").DataTable().ajax.reload(null, false);
                Swal.fire(
                    "Thành công",
                    "Cập nhật sản phẩm thành công",
                    "success"
                );
            },
            error: function () {
                Swal.fire("Lỗi", "Đã xảy ra lỗi khi cập nhật", "error");
            },
        });
    });

    // Xóa sản phẩm
    $("#productsTable").on("click", ".btn-delete", function () {
        const sp_id = $(this).data("sp-id");

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
                    url: `/sanpham/${sp_id}`,
                    method: "DELETE",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function () {
                        toastr.success("Xóa thành công!");
                        table.ajax.reload(null, false);
                    },
                    error: function () {
                        toastr.error("Xóa thất bại!");
                    },
                });
            }
        });
    });
});
