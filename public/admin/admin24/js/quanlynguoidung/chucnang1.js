$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    ds_chucnang();
    layid_mhqltk();
});

function layid_mhqltk() {
    // Lấy đường dẫn hiện tại
    var currentURL = window.location.href;

    // Tách chuỗi thành mảng các phần tử dựa trên dấu /
    var parts = currentURL.split('/');

    // Lấy phần tử cuối cùng (trước dấu / cuối cùng)
    var link = parts[parts.length - 1];
    $.ajax({
        type: "get",
        url: "/admin24/layid_mhqltk/",
        data: {
            link: link,
        },
        success: function (res) {
            $('#id_manhinh_tam').text(res['IDMN'])
        },
    })
}


function ds_chucnang() {
    $("#ds_chucnang").empty();
    $("#ds_chucnang").append(
        '<table class="table table-bordered table-hover table-striped dataTable no-footer dtr-inline" id="list_settings"></table>'
    );
    var id_manhinh = $("#btt_submit_account").attr("data-id");
    var table = $("#list_settings").DataTable({
        ajax: {
            type: "get",
            url: "/admin24/quanlychucnang/ds_chucnang",
        },
        // dom: 'frtip',
        columns: [
            { title: "ID", data: "id", width: "5%" },
            { title: "Tên", data: "danhmuc_chucnang_ten", width: "20%" },
            { title: "Link", data: "danhmuc_chucnang_id", width: "20%" },
            { title: "Ghi chú", data: "danhmuc_chucnang_ghichu", width: "35%" },
            {
                title: "Chức năng",
                width: "20%",
                data: "id",
                render: function (data) {
                    var html =
                        '<i style ="color: #0000FF;"  id="btt_setting_edit" id_edit="2" data-id="' + data + '" class="fa-regular fa-pen-to-square"  onclick = "edit_setting(' + data + ')">&nbsp&nbsp</i><i style ="color: red;" class="fa-regular fa-trash-can"  id="btt_chucnang_dlt" data-id="' + id_manhinh + '" id_delete="4" onclick = delete_chucnang(' + data + ",4)></i>";
                    return html;
                },
            },
        ],
        columnDefs: [{
            targets: 4,
            className: "text-center",
        },],
        scrollY: 450,
        language: {
            emptyTable: "There are no accounts to display",
            info: " _START_ / _END_ trên _TOTAL_",
            paginate: {
                first: "Trang đầu",
                last: "Trang cuối",
                next: "Trang sau",
                previous: "Trang trước",
            },
            search: "Tìm kiếm:",
            loadingRecords: "Đang tìm kiếm ... ",
            lengthMenu: "Hiện thị _MENU_",
            infoEmpty: "",
        },
        retrieve: true,
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: false,
        info: true,
        autoWidth: false,
        responsive: true,
        select: true,
    });
}


function Add_new_settings() {
    $("#error_settings_note").text("");
    $("#error_settings_link").text("");
    $("#error_settings_name").text("");
    $.ajax({
        type: "post",
        url: "/admin24/quanlychucnang/add_new_settings",
        data: {
            settings_name: $("#settings_name").val(),
            settings_link: $("#settings_link").val(),
            settings_note: $("#settings_note").val(),
        },
        success: function (res) {
            if (res == 1) {
                ds_chucnang();
                toastr.success("Thêm thành công");
                $("#error_settings_note").text("");
                $("#error_settings_link").text("");
                $("#error_settings_name").text("");
                $("#settings_name").val("");
                $("#settings_link").val("");
                $("#settings_note").val("");
            } else if (res == 0) {
                toastr.warning("Cập nhật không thành công, liên hệ admin");
            } else if (res == 2) {
                toastr.warning("Không có quyền truy cập chức năng");
            }
            if (res.settings_note) {
                $("#error_settings_note").text(res.settings_note[0]);
            } else {
                $("#error_settings_note").text("");
            }
            if (res.settings_link) {
                $("#error_settings_link").text(res.settings_link[0]);
            } else {
                $("#error_settings_link").text("");
            }
            if (res.settings_name) {
                $("#error_settings_name").text(res.settings_name[0]);
            } else {
                // return toastr.warning("Lỗi!!Liên hệ admin");
                $("#error_settings_name").text("");
            }
        },
    });
}

function edit_setting(id) {
    var id_manhinh = $('#id_manhinh_tam').text();
    var id_chucnang = $('#btt_setting_edit').attr('id_edit');
    $.ajax({
        type: "get",
        url: "/admin24/quanlychucnang/edit_setting/" + id,
        data: {
            id_manhinh: id_manhinh,
            id_chucnang: id_chucnang,
        },
        success: function (res) {
            if (res == -2) {
                toastr.warning("Không có quyền truy cập chức năng");
            } else {
                $("#modal_setting").show();
                $("#update_tenchucnang").val(res[0].danhmuc_chucnang_ten);
                $("#update_chucnang_link").val(res[0].danhmuc_chucnang_id);
                $("#update_ghichu").val(res[0].danhmuc_chucnang_ghichu);
                $("#btt_update_chucnang").attr("data-id", id);
                $("#Refresh_update_button").attr("data-id", id);
            }
        },
    });
}
function modal_cancel_setting() {
    $("#error_update_tenchucnang").text("");
    $("#error_update_chucnang_link").text("");
    $("#error_update_ghichu").text("");

    // $("#update_manhinhgoc").empty();
    $("#modal_setting").hide();
}

// update chucnang
function update_chucnang() {
    var id = $("#btt_update_chucnang").attr("data-id");
    var update_tenchucnang = $("#update_tenchucnang").val();
    var update_chucnang_link = $("#update_chucnang_link").val();
    var update_ghichu = $("#update_ghichu").val();
    $.ajax({
        type: "post",
        url: "/admin24/chucnang/update_chucnang",
        data: {
            id: id,
            update_tenchucnang: update_tenchucnang,
            update_chucnang_link: update_chucnang_link,
            update_ghichu: update_ghichu,
        },
        success: function (res) {

            switch (res) {
                case '1':
                    $("#update_tenchucnang").val("");
                    $("#update_chucnang_link").val("");
                    $("#update_ghichu").val("");
                    $("#error_update_tenchucnang").text("");
                    $("#error_update_chucnang_link").text("");
                    $("#error_update_ghichu").text("");
                    $("#modal_setting").hide();
                    ds_chucnang()
                    toastr.success("Cập nhật thành công.");
                    break;
                case '0':
                    toastr.warning("Không có cập nhật mới.");
                    break;
                case '-1':
                    toastr.error("Hệ thống bị sập");
                    break;
                case '-2':
                    toastr.warning("Tên chức năng hoặc link chức năng trùng với chức khác");
                    break;
                default:
                    if (res.update_tenchucnang) {
                        $("#error_update_tenchucnang").text(res.update_tenchucnang[0]);
                    }
                    if (res.update_chucnang_link) {
                        $("#error_update_chucnang_link").text(res.update_chucnang_link[0]);
                    }
                    if (res.update_ghichu) {
                        $("#error_update_ghichu").text(res.update_ghichu[0]);
                    }
                    break;
            }
        },
    });
}

//
function Clear_settings() {
    $("#error_settings_note").text("");
    $("#error_settings_link").text("");
    $("#error_settings_name").text("");
    $("#settings_name").val("");
    $("#settings_link").val("");
    $("#settings_note").val("");
}
function modal_refresh_setting() {
    var id = $('#Refresh_update_button').attr('data-id')
    // alert(id)
    edit_setting(id);
    $("#error_update_tenchucnang").text("");
    $("#error_update_chucnang_link").text("");
    $("#error_update_ghichu").text("");
}
// delete
function delete_chucnang(idmn) {
    var id_manhinh = $('#id_manhinh_tam').text();
    var id_chucnang = $('#btt_setting_edit').attr('id_edit');
    if (confirm("Bạn có chắc chắn xóa quyền của chức năng") == true) {
        $.ajax({
            type: "post",
            url: "/admin24/chucnang/delete_chucnang/" + idmn,
            data: {
                id_manhinh: id_manhinh,
                id_chucnang: id_chucnang,
            },
            success: function (res) {
                if (res == 1) {
                    ds_chucnang();
                    return toastr.success("Xóa màn hình thành công");
                } else if (res == 2) {
                    return toastr.warning("Không có quyền truy cập chức năng");
                } else if (res == 3) {
                    return toastr.warning("Chức năng đang được sử dụng");
                } else {
                    return toastr.warning("Có lỗi xảy ra!!!Liên hệ admin");
                }
            },
        });
    }
}
