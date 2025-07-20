$(document).ready(function () {
    if ($.fn.DataTable.isDataTable("#donhangTable")) {
        $("#donhangTable").DataTable().destroy();
    }

    $("#donhangTable").DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        ajax: donhangDataUrl,
        columns: [
            { data: "hd_id" },
            { data: "username" },
            { data: "sanpham" },
            { data: "soluong" },
            { data: "tongtien" },
            { data: "trangthai" },
            { data: "created_at" },
            { data: "action", orderable: false, searchable: false },
        ],
    });

    // Xử lý nút "Xem chi tiết"
    $("#donhangTable").on("click", ".view-details", function () {
        const hd_id = $(this).data("id");
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
            $("#tongTienFooter").text(Number(tongTien).toLocaleString() + "đ");

            // Hiển thị modal
            $("#modalChiTietHD").modal("show");
        });
    });
});
