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
            { data: "action", orderable: false, searchable: false },
        ],
    });
});
