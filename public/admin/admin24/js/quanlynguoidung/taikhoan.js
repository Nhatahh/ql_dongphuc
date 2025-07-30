$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});
const check = laythongtincheckquyen(1);
check.then(function(api) {
    var table = $("#list_accounts").DataTable({
        ajax: "/admin24/danhsachtaikhoan/" + api[0],
        // type: "get",
        // dom: 'frtip',
        columns: [
            {
                title: "STT",
                data: "so_thu_tu"
            },
            { title: "Email", data: "email" },
            { title: "Tên", data: "name" },
            {
                title: "Trạng thái",
                data: "status",
                render: function (data, type, row) {
                    let trangthai = ""
                    return data == 1 ? trangthai = '<small class="badge badge-primary">Hoạt động</small>' : trangthai = '<small class="badge badge-warning">Ngừng sử dụng</small>'
                }
            },
            {
                title: "Chức năng",
                data: 'id',
                render: function (data, type, row) {
                    var icon_sua = '<i id="btt_chucnang_edit" class="fa-regular fa-pen-to-square" onclick = "edit_accounts(' + row.sua.id_nguoidung + ',' + row.sua.id_chucnang + ',' + row.sua.active + ')">&nbsp&nbsp</i>';
                    var icon_phanquyen = '<i style ="color: blue;" id="btt_chucnang_role" class="fa-solid fa-gears" onclick = "loadUser_Menus_Roles(' + row.phanquyen.id_nguoidung + ',' + row.phanquyen.id_chucnang + ',' + row.phanquyen.active + ')">&nbsp&nbsp</i>';
                    if (row.status == 1) {
                        var icon_xoa = '<i style ="color: red;" id="btt_chucnang_dlt" class="fa-regular fa-solid fa-user-xmark" onclick = "delete_accounts(' + row.xoa.id_nguoidung + ',' + row.xoa.id_chucnang + ',' + row.xoa.active + ','+row.status+')">&nbsp&nbsp</i>';
                    } else {
                        var icon_xoa = '<i style ="color: #007bff;" id="btt_chucnang_dlt" class="fa-solid fa-user-check" onclick = "delete_accounts(' + row.xoa.id_nguoidung + ',' + row.xoa.id_chucnang + ',' + row.xoa.active + ','+row.status+')">&nbsp&nbsp</i>';
                    }
                    return html = icon_sua + icon_phanquyen + icon_xoa
                },
            },
        ],
        columnDefs: [{
            targets: [3, 4],
            className: "text-center",
        },],
        scrollY: 450,
        language: {
            emptyTable: "Không có tài khoản người dùng",
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
        paging: false,
        lengthChange: true,
        searching: true,
        ordering: false,
        info: true,
        autoWidth: true,
        responsive: true,
        select: true,
    });
    return table;
});

// function test(){
//     $.ajax({
//         type: "get",
//         url: "/admin24/danhsachtaikhoan/" + check[0],
//         dataType: "json",
//         success: function (res) {
//            alert(res)
//         },
//     });
// }
// var table = $("#list_accounts").DataTable({
//     ajax: "/admin24/danhsachtaikhoan/" + check[0],
//     // type: "get",
//     // dom: 'frtip',
//     columns: [
//         {
//             title: "STT",
//             data: "so_thu_tu"
//         },
//         { title: "Email", data: "email" },
//         { title: "Tên", data: "name" },
//         {
//             title: "Trạng thái",
//             data: "status",
//             render: function (data, type, row) {
//                 let trangthai = ""
//                 return data == 1 ? trangthai = '<small class="badge badge-primary">Hoạt động</small>' : trangthai = '<small class="badge badge-warning">Ngừng sử dụng</small>'
//             }
//         },
//         {
//             title: "Chức năng",
//             data: 'id',
//             render: function (data, type, row) {
//                 var icon_sua = '<i id="btt_chucnang_edit" class="fa-regular fa-pen-to-square" onclick = "edit_accounts(' + row.sua.id_nguoidung + ',' + row.sua.id_chucnang + ',' + row.sua.active + ')">&nbsp&nbsp</i>';
//                 var icon_phanquyen = '<i style ="color: blue;" id="btt_chucnang_role" class="fa-solid fa-gears" onclick = "loadUser_Menus_Roles(' + row.phanquyen.id_nguoidung + ',' + row.phanquyen.id_chucnang + ',' + row.phanquyen.active + ')">&nbsp&nbsp</i>';
//                 if (row.status == 1) {
//                     var icon_xoa = '<i style ="color: red;" id="btt_chucnang_dlt" class="fa-regular fa-solid fa-user-xmark" onclick = "delete_accounts(' + row.xoa.id_nguoidung + ',' + row.xoa.id_chucnang + ',' + row.xoa.active + ','+row.status+')">&nbsp&nbsp</i>';
//                 } else {
//                     var icon_xoa = '<i style ="color: #007bff;" id="btt_chucnang_dlt" class="fa-solid fa-user-check" onclick = "delete_accounts(' + row.xoa.id_nguoidung + ',' + row.xoa.id_chucnang + ',' + row.xoa.active + ','+row.status+')">&nbsp&nbsp</i>';
//                 }
//                 return html = icon_sua + icon_phanquyen + icon_xoa
//             },
//         },
//     ],
//     columnDefs: [{
//         targets: [3, 4],
//         className: "text-center",
//     },],
//     scrollY: 450,
//     language: {
//         emptyTable: "Không có tài khoản người dùng",
//         info: " _START_ / _END_ trên _TOTAL_",
//         paginate: {
//             first: "Trang đầu",
//             last: "Trang cuối",
//             next: "Trang sau",
//             previous: "Trang trước",
//         },
//         search: "Tìm kiếm:",
//         loadingRecords: "Đang tìm kiếm ... ",
//         lengthMenu: "Hiện thị _MENU_",
//         infoEmpty: "",
//     },
//     retrieve: true,
//     paging: false,
//     lengthChange: true,
//     searching: true,
//     ordering: false,
//     info: true,
//     autoWidth: true,
//     responsive: true,
//     select: true,
// });

//Edit Tài khoản
async function edit_accounts(id_nguoidung, id_chucnang, active) {
    // const time = await lay_time(id_chucnang);
    const check = await laythongtincheckquyen(id_chucnang);

    // if (active == 1) {
        $.ajax({
            type: "get",
            url: "/admin24/edit_accounts",
            dataType: "json",
            data: {
                id_nguoidung: id_nguoidung,
                id_manhinh: check[0],
                id_chucnang: id_chucnang,
                active: active,
                time: check[1],
            },
            success: function (res) {
                if (res.active == 1) {
                    $("#modal_accounts").show();
                    var accounts_Data = res.result[0];
                    $("#Update_button").attr("id_nguoidung", id_nguoidung);
                    $('#Update_button').attr("id_chucnang", id_chucnang)
                    $('#Update_button').attr("active", active)
                    $("#update_accounts_name").val(accounts_Data.name);
                    $("#update_accounts_email").val(accounts_Data.email);
                    $("#Refresh_update_button").attr("id_nguoidung", id_nguoidung);
                } else {
                    thongbao('rol_2')
                }
            },
        });
    // } else {
    //     thongbao('rol_2')
    // }
    table.ajax.reload();
}

//Update Tài khoản
async function update_accounts() {
    var id_chucnang = 2;
    const check = await laythongtincheckquyen(id_chucnang);
    var active = $('#Update_button').attr("active")
    // if (active == 0) {
    //     thongbao('rol_2')
    // } else {
        var id_nguoidung = $("#Update_button").attr("id_nguoidung");
        var id_chucnang = $('#Update_button').attr("id_chucnang")
        var update_accounts_name = $("#update_accounts_name").val();
        var update_accounts_email = $("#update_accounts_email").val();
        $.ajax({
            type: "post",
            url: "/admin24/update_accounts",
            data: {
                id_nguoidung: id_nguoidung,
                id_manhinh: check[0],
                id_chucnang: id_chucnang,
                active: active,
                update_accounts_name: update_accounts_name,
                update_accounts_email: update_accounts_email,
                time: check[1],
            },
            success: function (res) {
                if (res.loaithongbao == "thongbao") {
                    thongbao(res.thongbao)
                    // table.ajax.reload();
                    $('#list_accounts').DataTable().ajax.reload();

                } else {
                    var keys = Object.keys(res.thongbao['original'])
                    var dom_validate = document.getElementsByClassName('validate_taikhoan')
                    validate(res.thongbao, keys, dom_validate)
                }
            },
        });
    // }
}

//Tải lại form
function modal_refresh_accounts() {
    var id_nguoidung = $("#Update_button").attr("id_nguoidung");
    var id_chucnang = $('#Update_button').attr("id_chucnang")
    var active = $('#Update_button').attr("active")
    $("#error_update_accounts_name").text("");
    $("#error_name_accounts_name").text("");
    edit_accounts(id_nguoidung, id_chucnang, active)
}

//Hủy và tắt popup Cập nhật tài khoản
function modal_close_accounts() {
    $("#error_update_accounts_email").text("");
    $("#error_name_accounts_email").text("");
    $("#modal_accounts").hide();
}

function modal_cancel_accounts() {
    $("#error_update_accounts_email").text("");
    $("#error_name_accounts_email").text("");
    $("#modal_accounts").hide();
}

//Thoát form cập nhật
function modal_close_phan_quyen_user() {
    $("#error_update_accounts_name").text("");
    $("#error_name_accounts_name").text("");
    $("#modal_phan_quyen").hide();
}

async function loadUser_Menus_Roles(id_nguoidung, pq_chucnang, active) {
    if (active == 1) {
        $("#remove_loadUser_Menus_Roles").empty();
        const check = await laythongtincheckquyen(pq_chucnang);
        $.ajax({
            type: "get",
            url: "/admin24/loadUser_Menus_Roles",
            data: {
                id_nguoidung: id_nguoidung,
                id_manhinh: check[0],
                id_chucnang: pq_chucnang,
                active: active,
                time: check[1]
            },
            success: function (data) {
                if (data.active == 'rol_1') {
                    $("#modal_phan_quyen").show();
                    var html = "";
                    html += '<table class="table table-bordered table-hover table-striped" style = "width: 100%;" id = "loadUser_Menus_Roles">';
                    html += "<thead>";
                    html += "<tr>";
                    html += "<th>Tên chức năng</th>";
                    for (let i = 0; i < data.head.length; i++) {
                        html += "<th>" + data.head[i]["danhmuc_chucnang_ten"] + "</th>";
                    }
                    html += "</tr>";
                    html += "</thead>";
                    html += "<tbody>";
                    if (data.body.length > 0) {
                        for (let j = 0; j < data.body.length; j++) {
                            var name = data.body[j]["name"]; parent_id = data.body[j]["parent_id"]; id_user = data.id_user
                            html += "<tr>";
                            html += "<td>" + name + "</td>";
                            for (let i = 0; i < data.head.length; i++) {
                                var checked = ""; disabled = ""; display = "inline-block"; trangthai = 0;
                                var id_chucnang = data.head[i]['danhmuc_chucnang_id']; head_chucnang = data.head[i]['id']; manhinh = data.body[j]['IDMN']; body_chucnang = data.body[j][id_chucnang]
                                var dom_id = 'phanquyen_nd' + id_user + "_mh" + manhinh + "_cn" + head_chucnang
                                var parent_id_res = 0;
                                body_chucnang > 0 ? checked = "checked" : checked = "";
                                (parent_id == 0 && manhinh != 1) ? disabled = "disabled" : disabled = "";
                                parent_id == 0 && head_chucnang > 1 ? display = "none" : display = "inline-block"
                                parent_id == 0 ? parent_id_res = manhinh : parent_id_res = parent_id;
                                var class_manhinh = 0;
                                head_chucnang > 1 ? class_manhinh = manhinh : class_manhinh = 0;
                                html += "<td  style = 'text-align:center'><input id_manhinh = '" + manhinh + "' id_nguoidung = '" + id_user + "'  id_chucnang = '" + head_chucnang + "'  class = 'parent_id_res" + parent_id_res + " parent_id" + parent_id + " id_manhinh" + class_manhinh + "' id = " + dom_id + " onclick = 'capnhatquyen(" + id_user + "," + manhinh + "," + head_chucnang + "," + pq_chucnang + "," + parent_id + "," + active + ")' type = 'checkbox' " + checked + " " + disabled + " style = 'height: 20px; display:" + display + "')></td>";
                            }
                            html += "</tr>";
                        }
                    }
                    html += "</tbody>";
                    html += "</table>";
                    $("#remove_loadUser_Menus_Roles").html(html);
                    $("#loadUser_Menus_Roles").DataTable({
                        scrollY: 400,
                        paging: false,
                        lengthChange: false,
                        searching: true,
                        ordering: false,
                        info: false,
                        autoWidth: true,
                        responsive: false,
                        retrieve: false,
                    });
                } else {
                    return thongbao(data.active)
                }
            },
        });
    } else {
        thongbao('rol_2')
    }
}

//Đếm tất cả quyền của paren_id bổ sung cho Chức năng cập nhật quyền
function check_class(check_class_id) {
    var dem = 0;
    for (let i = 0; i < check_class_id.length; i++) {
        if ($(check_class_id[i]).prop("checked") == true) {
            dem++
        }
    }
    if (dem > 0) {
        return 1; //Thêm menu cha
    } else {
        return 0; // Xóa menu cha
    }
}

//Cập nhật quyền
async function capnhatquyen(id_nguoidung, manhinh, head_chucnang, pq_chucnang, parent, active) {
    $('#modal_event').show('fast')
    const checkpq_manhinh = await kiemtraquyenmanhinh(manhinh, head_chucnang);
    // const time = await lay_time(pq_chucnang);
    const check_new = await laythongtincheckquyen(pq_chucnang);


    let parent_id_res = document.getElementsByClassName('parent_id_res'+parent)
    var pq_manhinh = localStorage.getItem('id_manhinh');
    var parent_id = document.getElementsByClassName('parent_id' + parent)
    var id_manhinh = document.getElementsByClassName('id_manhinh' + manhinh)
    var check_parent_id = check_class(parent_id);
    var check_id_manhinh = check_class(id_manhinh);
    var check = $('#phanquyen_nd' + id_nguoidung + "_mh" + manhinh + "_cn" + head_chucnang).prop('checked')
    var check_xem = $('#phanquyen_nd' + id_nguoidung + "_mh" + manhinh + "_cn1").prop('checked')
    var arr_quyen = [];
    if (check == 1) { //Thêm Quyền
        if (checkpq_manhinh == 1) {
            arr_quyen.push(
                {
                    'id_nguoidung': id_nguoidung,
                    'id_manhinh': parent,
                    'id_chucnang': 1
                }
            )
            if (check_id_manhinh == 1 && check_xem == false) {
                arr_quyen.push(
                    {
                        'id_nguoidung': id_nguoidung,
                        'id_manhinh': manhinh,
                        'id_chucnang': 1
                    }
                )
            }
            for (let i = 0; i < parent_id.length; i++) {
                if ($(parent_id[i]).prop('checked') == true) {
                    arr_quyen.push(
                        {
                            'id_nguoidung': id_nguoidung,
                            'id_manhinh': $(parent_id[i]).attr('id_manhinh'),
                            'id_chucnang': $(parent_id[i]).attr('id_chucnang')
                        }
                    )
                }
            }
            $.ajax({
                type: "post",
                url: "/admin24/capnhatquyen",
                data: {
                    data: arr_quyen,
                    parent_id: parent,
                    time: check_new[1],
                    pq_manhinh: check_new[0],
                    pq_chucnang: pq_chucnang,
                    active: 1,
                    // pq_manhinh: pq_manhinh,
                    // pq_chucnang: check_new[0],
                    id_nguoidung: id_nguoidung,
                    // active: active,
                    // time: check_new[1]
                },
                success: function (data) {
                    thongbao(data.thongbao)
                    for (let j = 0; j < parent_id_res.length; j++) {
                        for (let i = 0; i < data.data.length; i++) {
                            let id_nguoidung = data.data[i]['id_nguoidung']
                            let id_manhinh = data.data[i]['id_manhinh']
                            let id_chucnang = data.data[i]['id_chucnang']
                            if(id_nguoidung == $(parent_id_res[j]).attr('id_nguoidung') && id_manhinh == $(parent_id_res[j]).attr('id_manhinh') && id_chucnang == $(parent_id_res[j]).attr('id_chucnang')){
                                $(parent_id_res[j]).prop('checked',true)
                                break;
                            }else{
                                $(parent_id_res[j]).prop('checked',false)
                            }
                        }
                    }
                    $('#modal_event').hide()
                }
            });
        } else {
            thongbao('rol_3')
            $('#phanquyen_nd' + id_nguoidung + "_mh" + manhinh + "_cn" + head_chucnang).prop('checked', false)
            $('#modal_event').hide()
        }
    } else {//Xóa quyền
        if (check_xem == false) {
            var dem_parent = 0;
            for (let i = 0; i < parent_id.length; i++) {
                if ($(parent_id[i]).prop("checked") == true) {
                    dem_parent++
                }
            }

            var dem_manhinh = 0;
            for (let i = 0; i < id_manhinh.length; i++) {
                if ($(id_manhinh[i]).prop("checked") == true) {
                    dem_manhinh++
                }
            }
            if (dem_manhinh == dem_parent) {
                arr_quyen.push(
                    {
                        'id_nguoidung': 0,
                        'id_manhinh': 0,
                        'id_chucnang': 0,
                    }
                )
            } else {
                arr_quyen.push(
                    {
                        'id_nguoidung': id_nguoidung,
                        'id_manhinh': parent,
                        'id_chucnang': 1
                    }
                )
                for (let i = 0; i < parent_id.length; i++) {
                    if ($(parent_id[i]).prop('checked') == true && $(parent_id[i]).attr('id_manhinh') != manhinh) {
                        arr_quyen.push(
                            {
                                'id_nguoidung': id_nguoidung,
                                'id_manhinh': $(parent_id[i]).attr('id_manhinh'),
                                'id_chucnang': $(parent_id[i]).attr('id_chucnang')
                            }
                        )
                    }
                }
            }
        } else {
            arr_quyen.push(
                {
                    'id_nguoidung': id_nguoidung,
                    'id_manhinh': parent,
                    'id_chucnang': 1
                }
            )
            for (let i = 0; i < parent_id.length; i++) {
                if ($(parent_id[i]).prop('checked') == true) {
                    arr_quyen.push(
                        {
                            'id_nguoidung': id_nguoidung,
                            'id_manhinh': $(parent_id[i]).attr('id_manhinh'),
                            'id_chucnang': $(parent_id[i]).attr('id_chucnang')
                        }
                    )
                }
            }
        }
        $.ajax({
            type: "post",
            url: "/admin24/capnhatquyen",
            data: {
                data: arr_quyen,
                parent_id: parent,
                //Check quyền
                time: check_new[1],
                pq_manhinh: check_new[0],
                pq_chucnang: pq_chucnang,
                active: 1,
                // pq_manhinh: pq_manhinh,
                // pq_chucnang: pq_chucnang,
                id_nguoidung: id_nguoidung,
                // active: active,
            },
            success: function (data) {
                thongbao(data.thongbao)
                for (let j = 0; j < parent_id_res.length; j++) {
                    for (let i = 0; i < data.data.length; i++) {
                        let id_nguoidung = data.data[i]['id_nguoidung']
                        let id_manhinh = data.data[i]['id_manhinh']
                        let id_chucnang = data.data[i]['id_chucnang']
                        if(id_nguoidung == $(parent_id_res[j]).attr('id_nguoidung') && id_manhinh == $(parent_id_res[j]).attr('id_manhinh') && id_chucnang == $(parent_id_res[j]).attr('id_chucnang')){
                            $(parent_id_res[j]).prop('checked',true)
                            break;
                        }else{
                            $(parent_id_res[j]).prop('checked',false)
                        }
                    }
                }
                $('#modal_event').hide()
                // loadUser_Menus_Roles(id_nguoidung, pq_chucnang, active)
            }
        });
    }

}

async function delete_accounts(id_nguoidung, id_chucnang, active , status) {
    let choice = status == 1 ? confirm("Người dùng sẽ không thể đăng nhập hệ thống! Đồng ý???") : confirm("Người dùng có thể truy cập hệ thống! Đồng ý???")
    if (choice == true) {
        const check = await laythongtincheckquyen(id_chucnang);
        $.ajax({
            type: "post",
            url: "/admin24/delete_accounts",
            data: {
                //id xóa người dùng
                id_nguoidung: id_nguoidung,
                //Kiểm tra quyền
                id_manhinh: check[0],
                id_chucnang: id_chucnang,
                active: active,
                time: check[1]
            },
            success: function (res) {
                thongbao(res)
                // table.ajax.reload();
                $('#list_accounts').DataTable().ajax.reload();
            },
        });
    }
}

//Thêm tài khoản
async function themtaikhoan() {
    $('.validate_themtaikhoan').text('')
    let id_chucnang = 3;
    // const time = await lay_time(id_chucnang);
    const check = await laythongtincheckquyen(id_chucnang);
    $.ajax({
        type: "post",
        url: "/admin24/themtaikhoan",
        data: {
            email: $("#account_email").val(),
            name: $("#account_name").val(),
            pass: $("#account_pass").val(),
            id_manhinh: check[0],
            id_chucnang: id_chucnang, //Quyền thêm
            time: check[1]
        },
        success: function (res) {
            if (res.loaithongbao == "thongbao") {
                // table.ajax.reload();
                $('#list_accounts').DataTable().ajax.reload();
                thongbao(res.thongbao)
            } else {
                var keys = Object.keys(res.thongbao['original'])
                var dom_validate = document.getElementsByClassName('validate_themtaikhoan')
                validate(res.thongbao, keys, dom_validate)
            }
        },
    });
}

function Clear_accounts() {
    $("#account_email").val("");
    $("#account_name").val("");
    $("#account_pass").val("");
    $("#error_pass").text("");
    $("#error_email").text("");
    $("#error_name").text("");
}
