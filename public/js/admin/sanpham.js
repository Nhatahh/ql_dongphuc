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

    // Khi nhấn nút sửa
    $(document).on("click", ".btn-edit", function () {
        const sp_id = $(this).data("sp-id");

        $.ajax({
            url: `/admin/sanpham/${sp_id}`,
            method: "GET",
            success: function (sp) {
                console.log("Dữ liệu trả về:", sp);
                $("#edit_sp_id").val(sp.sp_id);
                $("#edit_tensp").val(sp.tensp);
                $("#edit_mota").val(sp.mota);
                $("#edit_gia").val(sp.gia);
                $("#current_image").attr("src", `/images/${sp.image_url}`);

                // Load Select2 và gán giá trị
                // Danh mục
                let newDM = new Option(
                    sp.danhmuc?.ten || "",
                    sp.dm_id,
                    false,
                    false
                );
                $("#edit_dm_id").append(newDM).val(sp.dm_id).trigger("change");
                // Nhà sản xuất
                let newNSX = new Option(
                    sp.nhasanxuat?.ten || "",
                    sp.nsx_id,
                    false,
                    false
                );
                $("#edit_nsx_id")
                    .append(newNSX)
                    .val(sp.nsx_id)
                    .trigger("change");

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
        const sp_id = $("#edit_sp_id").val();

        $.ajax({
            url: `/admin/sanpham/${sp_id}`,
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
                    url: `/admin/sanpham/${sp_id}`,
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
