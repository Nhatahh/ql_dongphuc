$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $("#productsTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: sanphamDataUrl,
        columns: [
            { data: "sp_id", className: "text-center" },
            {
                data: "image_url",
                render: function (data) {
                    return `<img src="/images/${data}" alt="Ảnh" width="60" height="60" style="object-fit: cover;">`;
                },
                className: "text-center",
            },
            { data: "tensp", className: "text-center" },
            { data: "mota", className: "text-center" },
            { data: "gia", className: "text-center" },
            { data: "danhmuc", className: "text-center" },
            { data: "nhasanxuat", className: "text-center" },
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
                className: "text-center",
            },
        ],
    });
});

// Hiển thị modal thêm sản phẩm
$("#btnShowAddSP").click(function () {
    $("#addSanphamForm")[0].reset();
    $("#addModal").modal("show");
});

// Form thêm sản phẩm
$("#addSanphamForm").on("submit", function (e) {
    e.preventDefault();
    let formData = new FormData(this);

    // Thêm CSRF token
    formData.append("_token", $('meta[name="csrf-token"]').attr("content"));

    // Xóa lỗi cũ
    $(".invalid-feedback").text("");
    $(".form-control").removeClass("is-invalid");

    $.ajax({
        url: "/admin/sanpham/add",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function () {
            $("#addModal").modal("hide");
            $("#productsTable").DataTable().ajax.reload(null, false);
            toastr.success("Đã thêm sản phẩm!");
        },
        error: function (xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                for (let key in errors) {
                    let input = $("#" + key);
                    input.addClass("is-invalid");
                    $("#error-" + key).text(errors[key][0]);
                }
                toastr.error("Vui lòng điền đầy đủ thông tin sản phẩm.");
            } else {
                toastr.error("Đã có lỗi xảy ra. Vui lòng thử lại sau.");
            }
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
                    $("#productsTable").DataTable().ajax.reload(null, false);
                    toastr.success("Xóa thành công!");
                },
                error: function () {
                    toastr.error("Xóa thất bại!");
                },
            });
        }
    });
});

// Load danh mục và nhà sản xuất vào select2 modal sửa
function loadDanhMucAndNSXEdit(selectedDmId, selectedNsxId) {
    $.ajax({
        url: "/admin/danhmuc-nsx",
        method: "GET",
        success: function (response) {
            // Xử lý danh mục
            let $dmSelect = $("#edit_dm_id");
            $dmSelect.empty();
            response.danhmucs.forEach((dm) => {
                $dmSelect.append(
                    new Option(
                        dm.ten,
                        dm.dm_id,
                        false,
                        dm.dm_id === selectedDmId
                    )
                );
            });

            // Xử lý nhà sản xuất
            let $nsxSelect = $("#edit_nsx_id");
            $nsxSelect.empty();
            response.nsxs.forEach((nsx) => {
                $nsxSelect.append(
                    new Option(
                        nsx.ten,
                        nsx.nsx_id,
                        false,
                        nsx.nsx_id === selectedNsxId
                    )
                );
            });

            // Trigger lại Select2
            $dmSelect.val(selectedDmId).trigger("change");
            $nsxSelect.val(selectedNsxId).trigger("change");
        },
        error: function () {
            alert("Không thể load danh mục hoặc nhà sản xuất.");
        },
    });
}

// Mở modal sửa và load dữ liệu sản phẩm
$("#productsTable").on("click", ".btn-edit", function () {
    let sp_id = $(this).data("sp-id");

    $.ajax({
        url: `/admin/sanpham/${sp_id}/edit`,
        method: "GET",
        success: function (data) {
            // Đổ dữ liệu vào form
            $("#edit_sp_id").val(data.sp_id);
            $("#edit_tensp").val(data.tensp);
            $("#edit_mota").val(data.mota);
            $("#edit_gia").val(data.gia);
            $("#current_image").attr("src", `/images/${data.image_url}`);
            $("#image_old").val(data.image_url);

            // Load danh mục + NSX vào select2 và chọn giá trị tương ứng
            loadDanhMucAndNSXEdit(data.dm_id, data.nsx_id);

            $("#editModal").modal("show");
        },
        error: function (xhr) {
            console.log(xhr.responseText); // debug thêm nếu cần
        },
    });
});
// Cập nhật sản phẩm
$("#editSanphamForm").on("submit", function (e) {
    e.preventDefault();

    let formData = new FormData(this);
    let sp_id = $("#edit_sp_id").val();

    // Clear old errors
    $("#editSanphamForm .invalid-feedback").text("");
    $("#editSanphamForm .form-control").removeClass("is-invalid");

    $.ajax({
        url: `/admin/sanpham/${sp_id}/update`,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            toastr.success("Cập nhật sản phẩm thành công");
            $("#editModal").modal("hide");
            $("#editSanphamForm")[0].reset();
            $("#productsTable").DataTable().ajax.reload(null, false);
        },
        error: function (xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function (field, messages) {
                    $(`#editSanphamForm [name="${field}"]`).addClass(
                        "is-invalid"
                    );
                    $(`#editSanphamForm #error-${field}`).text(messages[0]);
                });
            } else {
                toastr.error("Đã xảy ra lỗi khi cập nhật.");
            }
        },
    });
});
