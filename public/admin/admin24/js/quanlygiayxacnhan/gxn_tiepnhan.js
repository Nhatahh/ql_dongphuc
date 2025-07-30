$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    load_dulieubandau();
});

$("#gxn_tiepnhan_sldot").on("change", function () {
    var id_nam = $(this).val();
    table.ajax.url("/admin24/gxn_danhsachdangky/" + id_nam).load();

});

function load_dulieubandau() {
    $("#gxn_tiepnhan_sldot").empty();
    $.ajax({
        url: "/admin24/gxn_tiepnhan_test",
        type: "get",
        success: function (res) {
            if (res == "err_0") {
                thongbao(res);
                // toastr.error('Lỗi hệ thống, vui lòng dừng sử dụng')
            } else {
                $("#gxn_tiepnhan_sldot").select2({
                    data: res,
                });
            }

            $("#gxn_tiepnhan_test").val(res[0].text);
        },
    });
}


var table = $("#gxn_danhsachdangky").DataTable({
    ajax: {
        type: "get",
        url: "/admin24/gxn_danhsachdangky/0",
        // dataSrc: 'data'
    },
    columns: [
        {
            className: "dt-control",
            data: null,
            defaultContent: "",
            orderable: false,
        },
        {
            // Cột STT
            title: "STT",
            data: null,
            orderable: false,
        },
        { title: "ID tài khoản", data: "id_taikhoan" },
        { title: "MSSV", data: "mssv" },
        { title: "Họ tên", data: "hoten" },
        { title: "CCCD/CMND", data: "cccd" },
        { title: "Loại giấy", data: "loaigiay" },
        {
            title: "Trạng thái",
            data: "tiendoxyly",
            render: function (data) {
                if (data === 0) {
                    return "Chưa duyệt";
                } else if (data === 1) {
                    return "Đã duyệt";
                } else if (data === 2) {
                    return "Không được duyệt";
                }
                return "Không xác định";
            }
        },
        {
            title: "ID loại giấy", data:"id_loaigiay",visible: false,
        }

    ],
    columnDefs: [
        {
            targets: 0,
            className: "dt-body-center",
        },
        {
            targets: 1,
            className: "dt-body-center",
        },
        {
            targets: 2,
            className: "dt-body-center",
        },
        {
            targets: 3,
            className: "dt-body-center",
        },
        {
            targets: 4,
            className: "dt-body-center",
        },
        {
            targets: 5,
            className: "dt-body-center",
        },
        {
            targets: 6,
            className: "dt-body-center",
        },
        {
            targets: 7,
            className: "dt-body-center",
        },
        {
            targets: 8,
            className: "dt-body-center",
        },
    ],

    language: {
        emptyTable: "Không tìm thấy sinh viên",
        info: " _START_ / _END_ trên _TOTAL_ sinh viên",
        paginate: {
            first: "<",
            last: ">",
            next: "Next",
            previous: "Prev",
        },
        search: "Search:",
        loadingRecords: "Đang tìm kiếm ... ",
        lengthMenu: "Hiển thị _MENU_",
        infoEmpty: "",
    },
    retrieve: true,
    paging: true,
    lengthChange: true,
    searching: true,
    ordering: true,
    order: [],
    info: true,
    autoWidth: true,
    responsive: {
        details: false,
    },
    scrollY: 380,
    rowCallback: function (row, data, index) {
        // Thiết lập STT cho mỗi hàng
        var pageInfo = this.api().page.info();
        var page = pageInfo.page; // Trang hiện tại
        var length = pageInfo.length; // Số hàng mỗi trang
        var stt = page * length + index + 1; // Tính STT
        $("td:eq(1)", row).html(stt); // Gán STT vào cột đầu tiên
    },
});
//Cạp nhật giấy xác nhận
var selectedRow = null;

// Xử lý sự kiện click vào hàng để chọn
$("#gxn_danhsachdangky tbody").on("click", "tr", function () {
    if ($(this).hasClass("selected")) {
        $(this).removeClass("selected");
        selectedRow = null; // Hủy chọn dòng
    } else {
        table.$("tr.selected").removeClass("selected");
        $(this).addClass("selected");
        selectedRow = table.row(this).data(); // Lấy dữ liệu của dòng
    }
});
// Hàm xử lý cập nhật trạng thái
function updateStatus(newStatus) {
    var id_nam = $("#gxn_tiepnhan_sldot").val();
    console.log(id_nam);
    if (id_nam==0) {
        toastr.warning("Vui lòng chọn năm!");
        return;
    }
    if (!selectedRow) {
        toastr.error("Vui lòng chọn một dòng để cập nhật trạng thái!");
        return;
    }

    var idTaiKhoan = selectedRow.id_taikhoan;
    var IdLoaiGiay = selectedRow.id_loaigiay;
    var idtrangthai = selectedRow.tiendoxyly;
    if (newStatus === idtrangthai) {
        toastr.info("Trạng thái không thay đổi. Không có gì để cập nhật.");
        return;
    }
    // Gửi yêu cầu cập nhật trạng thái
    $.ajax({
        url: "/admin24/updateStatus",
        type: "POST",
        data: {
            idtaikhoan: idTaiKhoan,
            idloaigiay: IdLoaiGiay,
            newStatus: newStatus,
        },
        success: function (response) {
            if (response.success) {
                toastr.success("Cập nhật trạng thái thành công!");
                table.ajax.reload();
            } else {
                toastr.error("Lỗi: " + response.message);
            }
        },
        error: function () {
            toastr.error("Không thể cập nhật trạng thái. Vui lòng thử lại.");
        },
    });
    console.log(newStatus);
}
// Xử lý sự kiện nút "Cho phép" (1)
$("#btn-approve").on("click", function () {
    updateStatus(1);

    var data = table.row('.selected').data();
    var id_nam = $("#gxn_tiepnhan_sldot").val();// Lấy thông tin của dòng được chọn
    if (data && data.id_taikhoan && data.id_loaigiay && id_nam) {
        $.ajax({
            url: "/admin24/pdf_tiepnhan_save/" + data.id_taikhoan + "/" + data.id_loaigiay +  "/" + id_nam,
            method: 'get',
            success: function(response) {

                $("#pdfViewer").attr("src", response.pdf_url); // Hiển thị PDF mới
                $("#pdfViewerContainer").show(); // Hiển thị container chứa PDF
            }
        });
    }
});
// Xử lý sự kiện nút "Không cho phép" (2)
$("#btn-reject").on("click", function () {
    updateStatus(2);
    var data = table.row('.selected').data();
    var id_nam = $("#gxn_tiepnhan_sldot").val();// Lấy thông tin của dòng được chọn
    if (data && data.id_taikhoan && data.id_loaigiay && id_nam) {
        $.ajax({
            url: "/admin24/pdf_tiepnhan_save/" + data.id_taikhoan + "/" + data.id_loaigiay + "/" + id_nam,
            method: 'get',
            success: function(response) {

                $("#pdfViewer").attr("src", response.pdf_url); // Hiển thị PDF mới
                $("#pdfViewerContainer").show(); // Hiển thị container chứa PDF
            },
            error: function() {
                toastr.error("Có lỗi xảy ra, vui lòng thử lại.");
            }
        });
    }
});

// Hàm hỗ trợ format ngày tháng
function formatDate(dateString) {
    if (!dateString) return null;
    const date = new Date(dateString);
    return date.toLocaleDateString("vi-VN", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
    });
}


//xuất excel
$("#btt_excel_danhmuc").on("click", function () {
    var id_nam = $("#gxn_tiepnhan_sldot").val();

    if (id_nam==0) {
        toastr.warning("Vui lòng chọn năm đăng ký để xuất file!");
        return;
    }
    window.location.href = "/admin24/btt_excel_danhmuc/" + id_nam;
});

// Xử lý sự kiện click dt-control dtr-control
$("#gxn_danhsachdangky").on("click", "td.dt-control", function () {
    var tr = $(this).closest("tr");
    var row = table.row(tr);
    var $icon = $(this).find("i");

    if (row.child.isShown()) {
        // Đang mở thì đóng lại
        row.child.hide();
        tr.removeClass("shown");
        $icon.removeClass("fa-minus").addClass("fa-plus");
    } else {
        // Đang đóng thì mở ra
        if (row.data()) {
            row.child(formatDetails(row.data())).show();
            tr.addClass("shown");
            $icon.removeClass("fa-plus").addClass("fa-minus");
        }
    }
});

function formatDetails(rowData) {
    if (!rowData) return "Không có dữ liệu";

    const ngaysinhFormatted = rowData.ngaysinh
        ? formatDate(rowData.ngaysinh)
        : "N/A";
    const gioitinhFormatted = rowData.ten_gioitinh || "N/A"; // Lấy tên giới tính trực tiếp
    const ngaycapcccdFormatted = rowData.ngaycapcccd
        ? formatDate(rowData.ngaycapcccd)
        : "N/A";

    return `
        <div class="details-container p-4">
            <table class="table table-bordered table-striped">
                <tr>
                    <th width="35%">Ngày sinh:</th>
                    <td>${ngaysinhFormatted}</td>
                </tr>
                <tr>
                    <th>Giới tính:</th>
                    <td>${gioitinhFormatted}</td>
                </tr>
                <tr>
                    <th>Điện thoại:</th>
                    <td>${rowData.dienthoai || "N/A"}</td>
                </tr>
                <tr>
                    <th>Ngày cấp CCCD:</th>
                    <td>${ngaycapcccdFormatted}</td>
                </tr>
                <tr>
                    <th>Nơi cấp CCCD:</th>
                    <td>${rowData.noicapcccd || "N/A"}</td>
                </tr>
                <tr>
                    <th>Nơi sinh:</th>
                    <td>${rowData.tentinh || "N/A"}</td>
                </tr>
                <tr>
                    <th>Địa chỉ:</th>
                    <td>${rowData.diachi || "N/A"}</td>
                </tr>
                <tr>
                    <th>Tên chuyên ngành:</th>
                    <td>${rowData.tenchuyennganh || "N/A"}</td>
                </tr>
                <tr>
                    <th>Email phụ:</th>
                    <td>${rowData.email_phu || "N/A"}</td>
                </tr>
                <tr>
                    <th>Tên tỉnh:</th>
                    <td>${rowData.tentinh || "N/A"}</td>
                </tr>

                <!-- Thêm các trường khác nếu cần -->
                 <tr>
                    <th>Tên đơn vị:</th>
                    <td>${rowData.ten_donvi || "N/A"}</td>
                </tr>

            </table>
        </div>
    `;
}

//Hiển thị view pdf
$('#gxn_danhsachdangky tbody').on('click', 'tr', function (event) {
    if (!$(event.target).closest('td.dt-control').length) {
        var data = table.row(this).data();
        var id_nam = $("#gxn_tiepnhan_sldot").val();
        if (data && data.id_taikhoan && data.id_loaigiay && id_nam) {
            // Gọi endpoint trả về PDF
            var pdfUrl = "/admin24/pdf_tiepnhan/"+data.id_taikhoan+'/'+data.id_loaigiay+'/'+id_nam;

            // Nhúng URL PDF vào iframe
            $("#pdfViewer").attr("src", pdfUrl); // Gán URL vào iframe
            // $("#pdfViewerContainer").show();    // Hiển thị iframe
        }
    }
});


