$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#donhangTable").DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        ajax: donhangDataUrl,
        columns: [
            { data: "hd_id", className: "text-center" },
            { data: "username", className: "text-center" },
            { data: "tongtien", className: "text-center" },
            { data: "pttt", className: "text-center" },
            { data: "trangthai", className: "text-center" },
            { data: "created_at", className: "text-center" },
            {
                data: "hd_id",
                className: "text-center",
                render: function (data) {
                    return `
                        <button class="btn btn-sm btn-warning me-1 btn-edit" data-hd-id="${data}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button class="btn btn-sm btn-success btn-view-details" data-hd-id="${data}">
                            <i class="bi bi-search"></i>
                        </button>
                    `;
                },
                className: "text-center",
            },
        ],
    });
});

// Cập nhật trạng thái
$("#donhangTable").on("change", ".trangthai-select", function () {
    const tt_id = $(this).val();
    const hd_id = $(this).data("id");

    $.ajax({
        url: `/admin/donhang/update-trangthai/${hd_id}`,
        type: "POST",
        data: {
            tt_id: tt_id,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (res) {
            $("#donhangTable").DataTable().ajax.reload(null, false);
            Swal.fire("Thành công", res.message, "success");
        },
        error: function () {
            Swal.fire("Lỗi", "Không thể cập nhật trạng thái.", "error");
        },
    });
});

// Xử lý nút "Xem chi tiết"
$("#donhangTable").on("click", ".btn-view-details", function () {
    const hd_id = $(this).data("hd-id");
    $.get(`${donhangChiTietUrl}/${hd_id}`, function (data) {
        const tbody = $("#tableChiTietHD tbody");
        tbody.empty();
        let tongTien = 0;

        data.forEach(function (item) {
            const thanhTien = item.gia * item.soluong;
            tongTien += thanhTien;

            const row = `
                <tr>
                    <td><img src="/images/${
                        item.sanpham?.image_url ?? "default.png"
                    }" alt="SP" width="60" height="60" class="rounded shadow-sm"></td>
                    <td>${item.sanpham?.tensp ?? "Không rõ"}</td>
                    <td>${item.size?.ten ?? "Không rõ"}</td>
                    <td>${item.soluong}</td>
                    <td>${Number(item.gia).toLocaleString()}đ</td>
                    <td>${Number(thanhTien).toLocaleString()}đ</td>
                </tr>`;
            tbody.append(row);
        });

        // Cập nhật tổng tiền footer
        $("#tongTienFooter").text(Number(tongTien).toLocaleString() + "VND");

        // Hiển thị modal
        $("#modalChiTietHD").modal("show");
    });
});
