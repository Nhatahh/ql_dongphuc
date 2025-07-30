$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $("#tonkhoTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: khoDataUrl,
        columns: [
            { data: "sp_id", className: "text-center" },
            {
                data: "image_url",
                render: function (data) {
                    return `<img src="/images/${data}" width="60" height="60" style="object-fit: cover;">`;
                },
                className: "text-center",
            },
            { data: "tensp", className: "text-center" },
            { data: "sizeS", className: "text-center" },
            { data: "sizeM", className: "text-center" },
            { data: "sizeL", className: "text-center" },
            { data: "sizeXL", className: "text-center" },
            {
                data: "action",
                orderable: false,
                searchable: false,
                className: "text-center",
            },
        ],
    });
});

$(document).on("change", ".stock-input", function () {
    const input = $(this);
    const sp_id = input.data("sp-id");
    const size = input.data("size");
    const value = input.val();

    $.ajax({
        url: "/admin/kho/update-stock",
        method: "POST",
        data: {
            sp_id: sp_id,
            size: size,
            value: value,
        },
        success: function (response) {
            toastr.success(response.message);
        },
        error: function (xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                for (let field in errors) {
                    toastr.error(errors[field][0]);
                }
            } else {
                toastr.error("Có lỗi xảy ra.");
            }
        },
    });
});
