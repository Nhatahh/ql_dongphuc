$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});


const check = laythongtincheckquyen(1);
check.then(function(api) {
    var table = $("#ds_chucnang").DataTable({
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
                        '<i style ="color: #0000FF;"  id="btt_setting_edit" id_edit="2" data-id="' + data + '" class="fa-regular fa-pen-to-square"  onclick = "edit_setting(' + data + ')">&nbsp&nbsp</i><i style ="color: red;" class="fa-regular fa-trash-can"  id="btt_chucnang_dlt" data-id="' + api[0] + '" id_delete="4" onclick = delete_chucnang(' + data + ",4)></i>";
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
    return table;
});

async function Add_new_settings() {
    $("#error_settings_note").text("");
    $("#error_settings_link").text("");
    $("#error_settings_name").text("");
    const check = await laythongtincheckquyen(3);
    $.ajax({
        type: "post",
        url: "/admin24/quanlychucnang/add_new_settings",
        data: {
            settings_name: $("#settings_name").val(),
            settings_link: $("#settings_link").val(),
            settings_note: $("#settings_note").val(),
            //lấy thông tin check quyền
            id_manhinh: check[0],
            id_chucnang: 3,
            active: 1,
            time: check[1],
        },
        success: function (res) {
            if (res.loaithongbao == "thongbao") {
                $("#settings_name").val("");
                $("#settings_link").val("");
                $("#settings_note").val("");
                $('#ds_chucnang').DataTable().ajax.reload();
                thongbao(res.thongbao)
            } else {
                var keys = Object.keys(res.thongbao['original'])
                var dom_validate = document.getElementsByClassName('validate_add_role')
                validate(res.thongbao, keys, dom_validate)
            }
        }
    });
}

async function edit_setting(id) {
    const check = await laythongtincheckquyen(2);
    $.ajax({
        type: "get",
        url: "/admin24/quanlychucnang/edit_setting/" + id,
        data: {
            id_chucnang: 2,
            //lấy thông tin người dùng
            id_manhinh: check[0],
            active: 1,
            time: check[1],
        },
        success: function (res) {
            if (res == 'rol_2') {
                thongbao(res)
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
    $('#ds_chucnang').DataTable().ajax.reload();
}
function modal_cancel_setting() {
    $("#error_update_tenchucnang").text("");
    $("#error_update_chucnang_link").text("");
    $("#error_update_ghichu").text("");

    // $("#update_manhinhgoc").empty();
    $("#modal_setting").hide();
}

// update chucnang
async function update_chucnang() {
    $("#error_update_tenchucnang").text("");
    $("#error_update_chucnang_link").text("");
    $("#error_update_ghichu").text("");

    var id =$("#btt_update_chucnang").attr("data-id");

    const check = await laythongtincheckquyen(2);
    var update_tenchucnang = $("#update_tenchucnang").val();
    var update_chucnang_link = $("#update_chucnang_link").val();
    var update_ghichu = $("#update_ghichu").val();
    $.ajax({
        type: "post",
        url: "/admin24/quanlychucnang/update_chucnang",
        data: {
            id:id,
            id_chucnang: 2,
            //lấy thông tin người dùng
            id_manhinh: check[0],
            active: 1,
            time: check[1],
            update_tenchucnang: update_tenchucnang,
            update_chucnang_link: update_chucnang_link,
            update_ghichu: update_ghichu,
        },
        success: function (res) {
            console.log(id)
            if (res.loaithongbao == "thongbao") {
                edit_setting(id)
                $("#update_tenchucnang").val("");
                $("#update_chucnang_link").val("");
                $("#update_ghichu").val("");
                thongbao(res.thongbao)
            } else if(res.loaithongbao=='validate') {
                edit_setting(id)
                var keys = Object.keys(res.thongbao['original'])
                var dom_validate = document.getElementsByClassName('validate_update_role')
                validate(res.thongbao, keys, dom_validate)
            }else{
                edit_setting(id)
                return toastr.warning('Tên chức năng đã tồn tại');
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
async function delete_chucnang(idmn) {
    const check = await laythongtincheckquyen(4);
    if (confirm("Bạn có chắc chắn xóa quyền của chức năng") == true) {
        $.ajax({
            type: "post",
            url: "/admin24/quanlychucnang/delete_chucnang/" + idmn,
            data: {
                //lấy thông tin người dùng
                id_chucnang: 2,
                id_manhinh: check[0],
                active: 1,
                time: check[1],
                id_manhinh: check[0],
                id_chucnang: 4,
            },
            success: function (res) {
                thongbao(res)
                $('#ds_chucnang').DataTable().ajax.reload();
            },
        });
    }
}
