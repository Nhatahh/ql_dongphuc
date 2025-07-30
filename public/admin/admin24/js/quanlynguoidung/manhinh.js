$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    ds_manhinh();
    manhinhgoc();

});
// lấy id màn hình


// Màn hình gốc
function manhinhgoc() {
    $.ajax({
        type: "get",
        url: "/admin24/manhinhgoc",
        dataType: "json",
        success: function(res) {
            $("#manhinhgoc").select2({
                data: res,
            });
        },
    });
}
// danh sach mà hình
async function ds_manhinh() {
    const  check = await laythongtincheckquyen(1);
    var id_manhinh= check[0]
    console.log(id_manhinh)
    $("#ds_manhinh").empty()
    $.ajax({
        type: "get",
        url: "/admin24/ds_manhinh",
        success: function(data) {
            var html = "";
            html +=
                '<table class="table table-bordered table-hover table-striped" style = "width: 100%" id = "danhsach_manhinh">';
            html += "<thead>";
            html += "<tr>";
            html += '<th>STT</th>'
            html += '<th>Tên màn hình</th>'
            html += '<th>Đường dẫn</th>'
            html += '<th>Thao tác</th>'
            html += "</tr>";
            html += "</thead>";
            html += "<tbody>";
            if (data.length > 0) {
                for (let i = 0; i < data.length; i++) {
                    html += "</tr>";
                    html += "<td>" + data[i]['stt'] + "</td>";
                    html += "<td>" + data[i]["name"] + "</td>";
                    html += "<td>" + data[i]["link"] + "</td>";
                    html += "<td style =' text-align: center;'><i style ='color: #0000FF;'  id='btt_menus_edit' data-id='" + data[i]["IDMN"] + "'  class='fa-regular fa-pen-to-square' onclick = 'edit_manhinh(" + data[i]["IDMN"] + ")'>&nbsp&nbsp</i>";
                    html += "<i style ='color: blue;'  id='btt_chucnang_role' id_edit='6' data-id='" + data[i]["IDMN"] + "' class='fa-solid fa-gear' onclick = 'data_tables_menus(" + data[i]["IDMN"] + ")'>&nbsp&nbsp</i>";
                    if(data[i]["IDMN"]!=id_manhinh){
                        html += "<i style ='color: red;'  id='btt_manhinh_dlt' id_edit='4' data-id='3' class='fa-regular fa-trash-can' onclick = 'dlt_manhinh(" + data[i]["IDMN"] + ")'>&nbsp&nbsp</i></td>";
                    }else{
                        html += "<i style ='color: #fff;'  id='btt_manhinh_dlt' id_edit='4' data-id='3' class='fa-regular fa-trash-can' >&nbsp&nbsp</i></td>";
                    }
                    html += "<tr>";
                }
            }
            html += "</tbody>";
            html += "</table>";
            $("#ds_manhinh").html(html);
            var aaaa=$("#aaaa").DataTable({
                    scrollY: "200px",
                    paging: true,
                    lengthChange: true,
                    searching: true,
                    ordering: false,
                    info: false,
                    autoWidth: true,
                    responsive: true,
                });
            return aaaa
        },
    });

}
//edit màn hình
async function edit_manhinh(id) {
    const check = await laythongtincheckquyen(2);
    $.ajax({
        type: "get",
        url: "/admin24/edit_manhinh/" + id,
        data:{
            id_manhinh: check[0],
            id_chucnang: 2,
            active: 1,
            time: check[1],
        },
        success: function(res) {
            if (res == 'rol_2') {
               thongbao(res)
            } else {
                $("#modal_manhinh").show();
                $("#update_tenmanhinh").val(res.manhinh[0].name);
                $("#update_link").val(res.manhinh[0].link);
                $("#update_icon").val(res.manhinh[0].icon);
                $("#update_stt").val(res.manhinh[0].stt);
                $("#update_manhinhgoc").select2({
                    data: res.menus,
                });
                $("#Update_button_manhinh").attr("data-id", id);
            }
        },
    });
}

function modal_cancel_manhinh() {
//    aaaa.ajax.reload();
    // table.ajax.reload();
    ds_manhinh()
    $("#error_update_tenmanhinh").text("");
    $("#error_update_icon").text("");
    $("#error_update_link").text("");
    $("#error_update_stt").text("");

    $("#update_manhinhgoc").empty();
    $("#modal_manhinh").hide();
}
// Update màn hình

async function update_manhinh() {
    const check = await laythongtincheckquyen(2);
    var id = $("#Update_button_manhinh").attr("data-id");
    var update_tenmanhinh = $("#update_tenmanhinh").val();
    var update_manhinhgoc = $("#update_manhinhgoc").val();
    var update_icon = $("#update_icon").val();
    var update_link = $("#update_link").val();
    var update_stt = $("#update_stt").val();
    $.ajax({
        type: "post",
        url: "/admin24/update_manhinh",
        data: {
            id: id,
            update_tenmanhinh: update_tenmanhinh,
            update_manhinhgoc: update_manhinhgoc,
            update_icon: update_icon,
            update_link: update_link,
            update_stt: update_stt,
            //lấy thông tin check quyền
            id_manhinh: check[0],
            id_chucnang: 2,
            active: 1,
            time: check[1],
        },
        success: function(res) {
            if (res.loaithongbao == "thongbao") {
                $("#error_update_tenmanhinh").text("");
                $("#error_update_icon").text("");
                $("#error_update_link").text("");
                $("#error_update_stt").text("");
                thongbao(res.thongbao)

            }else if(res.loaithongbao=='unique'){
                return toastr.warning('Màn hình đã tồn tại')
            }
             else {

                var keys = Object.keys(res.thongbao['original'])
                var dom_validate = document.getElementsByClassName('validate_update_manhinh')
                validate(res.thongbao, keys, dom_validate)
            }
        },
    });
}

function modal_refresh_menus() {
    var id = $("#Update_button_manhinh").attr("data-id");
    $("#update_tenmanhinh").val("");
    $("#update_link").val("");
    $("#update_icon").val("");
    $("#update_stt").val("");
    $("#update_manhinhgoc").empty();
    edit_manhinh(id)

    $("#error_update_tenmanhinh").text("");
    $("#error_update_link").text("");
    $("#error_update_icon").text("");
    $("#error_update_stt").text("");
}
//add màn hình
async function Add_new_Menu() {
    $('.validate_themtaikhoan').text('')

    let id_chucnang = 3;
    // const time = await lay_time(id_chucnang);
    const check = await laythongtincheckquyen(id_chucnang);
    console.log(check[0])
    $.ajax({
        type: "post",
        url: "/admin24/Add_new_Menu",
        data: {
            menus_manhinh: $("#menus_manhinh").val(),
            menus_parent: $("#manhinhgoc").val(),
            menus_link: $("#menus_link").val(),
            menus_icon: $("#menus_icon").val(),
            menus_stt: $("#menus_stt").val(),
            id_manhinh: check[0],
            id_chucnang: id_chucnang, //Quyền thêm
            time: check[1]
        },
        success: function(res) {
            if (res.loaithongbao == "thongbao") {
                // table.ajax.reload();
                // $('#ds_manhinh').DataTable().ajax.reload();
                ds_manhinh();
                manhinhgoc();
                thongbao(res.thongbao)
                $("#menus_manhinh").val(""),
                $("#menus_link").val(""),
                $("#menus_icon").val(""),
                $("#menus_stt").val("")
            } else {
                var keys = Object.keys(res.thongbao['original'])
                var dom_validate = document.getElementsByClassName('validate_them_manhinh')
                validate(res.thongbao, keys, dom_validate)
            }
        },
    });
}

function Clear_menu() {
    $("#manhinhgoc").empty()
    manhinhgoc()
    $("#menus_manhinh").val("");
    $("#menus_link").val("");
    $("#menus_icon").val("");
    $("#menus_stt").val("");

    $("#error_link").text("");
    $("#error_icon").text("");
    $("#error_stt").text("");
    $("#error_manhinh").text("");
}
//xóa màn hình
// Xóa màn hình
async function dlt_manhinh(idmn) {
    var id_chucnang = $('#btt_manhinh_dlt').attr('id_edit');
    const check = await laythongtincheckquyen(id_chucnang);
    $.ajax({
        type: "post",
        url: "/admin24/dlt_manhinh/" + idmn,
        data:{
            id_manhinh: check[0],
            id_chucnang: id_chucnang,
            time: check[1]
        },
        success: function(res) {
            if (res.loaithongbao == 'thongbao') {
                ds_manhinh();
               thongbao(res.thongbao)
               manhinhgoc();
            }else{
                if (res.thongbao == 4) {
                    return toastr.warning("Màn hình có chứa màn hình khác!!")
                } else if (res.thongbao == 3) {
                    return toastr.warning("Không thể xóa màn hình hiện tại!!!");
                } else if (res.thongbao == 5) {
                    return toastr.warning("Màn hình đang được sử dụng!!!Hãy xóa quyền truy cập của người dùng trước");
                }
            }
        },
    });
}

function modal_close_chucnangmanhinh() {
    $("#modal_phan_chucnang_manhinh").hide();
}

async function data_tables_menus(idmn) {
    const check = await laythongtincheckquyen(5);
    console.log(check[0])
    $("#remove_Menus").empty();
    $.ajax({
        type: "get",
        url: "/admin24/data_tables_menus/" + idmn,
        data: {
            id_manhinh_checkquyen: check[0],
            id_chucnang: 5, //phân quyền
            time: check[1]
        },
        success: function(data) {
            if (data == 'rol_2') {
               thongbao(data)
            } else {
                $("#modal_phan_chucnang_manhinh").show();
                var html = "";
                html +=
                    '<table class="table table-bordered table-hover table-striped" style = "width: 100%" id = "Load_menus">';
                html += "<thead>";
                html += "<tr>";
                // html += '<th>ID</th>'
                html += "<th>Tên chức năng</th>";
                for (let i = 0; i < data.head.length; i++) {
                    html +=
                        "<th>" + data.head[i]["danhmuc_chucnang_ten"] + "</th>";
                }
                html += "</tr>";
                html += "</thead>";
                html += "<tbody>";
                if (data.body.length > 0) {
                    for (let j = 0; j < data.body.length; j++) {
                        html += "<tr>";
                        html += "<td>" + data.body[j]["name"] + "</td>";
                        for (let i = 0; i < data.head.length; i++) {
                            if (data.body[j]["parent_id"] == 0) {
                                if (data.body[j][data.head[i]["danhmuc_chucnang_id"]] == undefined || data.body[j][data.head[i]["danhmuc_chucnang_id"]] == 0) {
                                    data.body[j][data.head[i]["danhmuc_chucnang_id"]] == 0;
                                    var checked = "";
                                    hasrole = 0;
                                } else {
                                    var checked = "checked";
                                    hasrole = 1;
                                }
                                html += "<td  style = 'text-align:center'><input hasrole = '" + hasrole + "' id_chucnang = '" + data.head[i]["id"] + "' class = 'checkquyen" + data.body[j]["IDMN"] + "' id='phanmanhinhchucnang" + data.id_user + "_" + data.body[j]["IDMN"] + "_" + data.head[i]["id"] + "' type = 'checkbox' id_user = " + data.id_user + " style = 'height: 20px;' " + checked + " onclick = Update_chucnang_manhinh(" + data.id_user + "," + data.body[j]["IDMN"] + "," + data.head[i]["id"] + ")></td>";

                            } else {
                                if (data.body[j][data.head[i]["danhmuc_chucnang_id"]] == undefined || data.body[j][data.head[i]["danhmuc_chucnang_id"]] == 0) {
                                    data.body[j][data.head[i]["danhmuc_chucnang_id"]] == 0;
                                    var checked = "";
                                    hasrole = 0;
                                } else {
                                    var checked = "checked";
                                    hasrole = 1;
                                }
                                html += "<td  style = 'text-align:center'><input hasrole = '" + hasrole + "' id_chucnang = '" + data.head[i]["id"] + "' class = 'checkquyen" + data.body[j]["IDMN"] + "' id='phanmanhinhchucnang" + data.id_user + "_" + data.body[j]["IDMN"] + "_" + data.head[i]["id"] + "' type = 'checkbox' id_user = " + data.id_user + " style = 'height: 20px;' " + checked + " onclick = Update_chucnang_manhinh(" + data.id_user + "," + data.body[j]["IDMN"] + "," + data.head[i]["id"] + ")></td>";
                            }
                        }
                        html += "</tr>";
                    }
                }
                html += "</tbody>";
                html += "</table>";
                $("#remove_Menus").html(html);
                $("#Load_menus").DataTable({
                    scrollY: "200px",
                    paging: false,
                    lengthChange: false,
                    searching: false,
                    ordering: false,
                    info: false,
                    autoWidth: true,
                    responsive: true,
                });
            }
        },
    });
}

async function Update_chucnang_manhinh(id_user, id_manhinh, id_chucnang) {
    const check = await laythongtincheckquyen(5);
    var quyen1 = document.getElementsByClassName("checkquyen" + id_manhinh);
    var list_quyen = [];
    var list_quyen_hienthi = [];
    var list_hasrole = [];

    for (let i = 0; i < quyen1.length; i++) {
        list_hasrole[i] = $(quyen1[i]).attr("hasrole");
        if ($(quyen1[i]).prop("checked") == true) {
            list_quyen[i] = $(quyen1[i]).attr("id_chucnang");
            list_quyen_hienthi[i] = $(quyen1[i]).attr("id_chucnang");
        } else {
            list_quyen[i] = 0;
            list_quyen_hienthi[i] = $(quyen1[i]).attr("id_chucnang");
        }
    }
    $.ajax({
        type: "post",
        url: "/admin24/Update_chucnang_manhinh",
        data: {
            id_user: id_user, //id người dùng
            id_manhinh: id_manhinh, //id màn hình
            id_chucnang: id_chucnang,
            quyen: list_quyen, //danh sách quyền nếu không có quyền thì truyền qua bằng 0 còn có thì lấy id nó
            hasrole: list_hasrole, //hasrole giá trị 0-1
            //tt check quyền
            id_manhinh_checkquyen: check[0],
            id_chucnang: 5, //phân quyền
            time: check[1]
        },
        success: function(res) {
           thongbao(res)
           data_tables_menus(id_manhinh)
        },
    });
}
