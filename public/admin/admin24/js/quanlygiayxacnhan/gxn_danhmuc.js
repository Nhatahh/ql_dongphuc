$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    dm_gxn_load_bandau();
});

function dm_gxn_load_bandau() {
    $.ajax({
        url: "/admin24/dm_gxn_load_bandau",
        type: "get",
        success: function (res) {
            $("#donViInput").select2({
                data: res,
            });
            $("#ghiChuInput").val("");
            $("#err_ghiChuInput").text("");
            $("#tenLoaiGiayInput").val("");
            $("#err_tenLoaiGiayInput").text("");
        },
    });
}
// Reset Form thêm
function btn_resetForm() {
    $(".err_del").text("");
    dm_gxn_load_bandau();
    $("#donViInput").val(0).trigger("change");
}
// Reset Form modal cập nhật
$("#Form_Modal").on("click", "#btn_resetModal", function () {
    var id = $("#btn_updateModal").attr("data-id");
    btn_edit(id);
});

//Bảng danh mục giấy xác nhận
var table = $("#gxn_danhsachgiay").DataTable({
    ajax: {
        type: "get",
        url: "/admin24/gxn_danhsachgiay",
        // dataSrc: 'data'
    },
    columns: [
        {
            // Cột STT
            title: "STT",
            data: null,
        },
        {
            title: "id",
            data: "id",
            visible: false,
        },
        {
            title: "Tên loại giấy",
            data: "danhmuc_gxn_tenloai",
        },
        {
            title: "Đơn vị",
            data: "ten",
        },
        {
            title: "Ngày thêm",
            data: "create_at",
        },
        {
            title: "Ngày cập nhật",
            data: "update_at",
        },
        {
            title: "Ghi chú",
            data: "ghichu",
        },
        {
            title: "Thao tác",
            data: null,
            render: function (data, type, row) {
                return `
                    <button id="btn-edit"  class="btn btn-edit" style="padding: 0">
                        <i style="color: #0000FF;" class="fa-regular fa-pen-to-square" onclick="btn_edit('${row.id}')"></i>
                    </button>
                    <button id="btn-removeSingle" data-id="${row.id}" class="btn removeSingle" style="padding: 0">
                        <i style="color: red;" class="fa-regular fa-trash-can" onclick=""></i> 
                    </button>`;
            },
        },
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
    ],
    language: {
        emptyTable: "Không tìm thấy giấy xác nhận.",
        info: " _START_ / _END_ trên _TOTAL_ trang",
        paginate: {
            first: "NExt",
            last: "NExt",
            next: "Trang sau",
            previous: "Trang trước",
        },
        search: "Search:",
        loadingRecords: "Đang tìm kiếm ... ",
        lengthMenu: "Hiện thị _MENU_ dòng",
        infoEmpty: "",
    },
    retrieve: true,
    paging: true,
    lengthChange: true,
    searching: true,
    ordering: false,
    info: true,
    autoWidth: true,
    responsive: true,
    scrollY: 380,
    order: [[1, "asc"]], // Sắp xếp theo cột Tên
    rowCallback: function (row, data, index) {
        // Thiết lập STT cho mỗi hàng
        var pageInfo = this.api().page.info();
        var page = pageInfo.page; // Trang hiện tại
        var length = pageInfo.length; // Số hàng mỗi trang
        var stt = page * length + index + 1; // Tính STT
        $("td:eq(0)", row).html(stt); // Gán STT vào cột đầu tiên
    },
});

//Thêm giấy xác nhận
$("#btn_addForm").on("click", function () {
    $("#modal_event").show();

    $(".err_del").text("");

    setTimeout(() => {
        var formData = {
            tenLoaiGiayInput: $("#tenLoaiGiayInput").val(),
            donViInput: $("#donViInput").val(),
            ghiChuInput: $("#ghiChuInput").val(),
        };
        $.ajax({
            url: "/admin24/gxn_add",
            type: "POST",
            data: formData,
            success: function (response) {
                $("#modal_event").hide();
                switch (response) {
                    case "1":
                        toastr.success("Thêm giấy xác nhận thành công!");
                        table.ajax.reload();
                        btn_resetForm();
                        break;
                    case "0":
                        toastr.error("Thêm giấy xác nhận thất bại!");
                        break;
                    case "-1":
                        toastr.error(
                            "Hệ thống bị lỗi, vui lòng tải lại trang hoặc liên hệ quản trị viên!"
                        );
                        break;
                    default:
                        const keys = Object.keys(response);
                        for (let i = 0; i < keys.length; i++) {
                            $("#err_" + keys[i]).text(response[keys[i]]);
                        }
                        break;
                }
            },
        });
    }, 1000);
    // }
});

//Cập nhật giấy xác nhận
// Hiển thị Modal cập nhật
function btn_edit(id) {
    $(".err_del").text("");
    $.ajax({
        url: "/admin24/dm_gxn_load_modal/" + id,
        type: "get",
        success: function (res) {
            switch (res.trangthai) {
                case 1:
                    $("#gxn_update_modal").modal("show");
                    $("#donViInput_modal").select2({
                        data: res.donvi,
                    });
                    $("#donViInput_modal")
                        .val(res.data.donvi_id)
                        .trigger("change");
                    $("#tenLoaiGiayInput_modal").val(
                        res.data.danhmuc_gxn_tenloai
                    );
                    $("#ghiChuInput_modal").val(res.data.ghichu);
                    $("#btn_updateModal").attr("data-id", res.data.id);
                    $("#btn_resetModal").attr("data-id", res.data.id);
                    break;
                case 0:
                    toastr.error(
                        "Hệ thống bị lỗi, vui lòng tải lại trang hoặc liên hệ quản trị viên!"
                    );
                    break;
                default:
                    toastr.error(
                        "Hệ thống bị lỗi, vui lòng liên hệ quản trị viên!"
                    );
                    break;
            }
        },
    });
}
// Cập nhật giấy xác nhận
$("#btn_updateModal").on("click", function () {
    $("#modal_event").show();

    $(".err_del").text("");

    setTimeout(() => {
        var idGiayInput_modal = $("#btn_updateModal").attr("data-id");
        var tenLoaiGiayInput_modal = $("#tenLoaiGiayInput_modal").val();
        var donViInput_modal = $("#donViInput_modal").val();
        var ghiChuInput_modal = $("#ghiChuInput_modal").val();
        $.ajax({
            url: "/admin24/gxn_update",
            type: "POST",
            data: {
                idGiayInput_modal: idGiayInput_modal,
                tenLoaiGiayInput_modal: tenLoaiGiayInput_modal,
                donViInput_modal: donViInput_modal,
                ghiChuInput_modal: ghiChuInput_modal,
            },
            success: function (response) {
                $("#modal_event").hide();
                switch (response) {
                    case "1":
                        toastr.success("Cập nhật giấy xác nhận thành công!");
                        table.ajax.reload();
                        $("#gxn_update_modal").modal("hide");
                        break;
                    case "0":
                        toastr.warning("Dữ liệu đã tồn tại trên hệ thống!");
                        break;
                    case "-1":
                        toastr.error(
                            "Hệ thống bị lỗi, vui lòng tải lại trang hoặc liên hệ quản trị viên!"
                        );
                        break;
                    default:
                        const keys = Object.keys(response);
                        for (let i = 0; i < keys.length; i++) {
                            $("#err_" + keys[i]).text(response[keys[i]]);
                        }
                        break;
                }
            },
        });
    }, 1000);
});

// Xóa giấy xác nhận
$("#gxn_danhsachgiay").on("click", "#btn-removeSingle", function () {
    var id = $(this).data("id");
    console.log(id);
    Swal.fire({
        title: "Xác nhận xóa?",
        text: "Bạn có chắc chắn muốn xóa mục này không?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Đồng ý",
        cancelButtonText: "Hủy",
    }).then((result) => {
        if (result.isConfirmed) {
            $("#modal_event").show();
            setTimeout(() => {
                $.ajax({
                    url: "/admin24/gxn_delete/" + id,
                    type: "DELETE",
                    success: function (response) {
                        $("#modal_event").hide();
                        switch (response) {
                            case "1":
                                toastr.success("Xóa giấy xác nhận thành công!");
                                table.ajax.reload();
                                break;
                            case "0":
                                toastr.warning("Xóa giấy xác nhận thất bại!");
                                break;
                            default:
                                toastr.error(
                                    "Hệ thống bị lỗi, vui lòng tải lại trang hoặc liên hệ quản trị viên!"
                                );
                                break;
                        }
                    },
                });
            }, 1000);
        }
    });
});
