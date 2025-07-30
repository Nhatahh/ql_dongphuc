$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    ds_manhinh();
    manhinhgoc();
    layid_mhqltk();
});
// lấy id màn hình
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
        success: function(res) {
            $('#id_manhinh_tam').text(res['IDMN'])
        },
    })
}

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
function ds_manhinh() {
    $("#ds_manhinh").empty();
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
                    html += "<td>" + data[i]["stt"] + "</td>";
                    html += "<td>" + data[i]["name"] + "</td>";
                    html += "<td>" + data[i]["link"] + "</td>";
                    html += "<td style =' text-align: center;'><i style ='color: #0000FF;'  id='btt_menus_edit' data-id='" + data[i]["IDMN"] + "'  class='fa-regular fa-pen-to-square' onclick = 'edit_manhinh(" + data[i]["IDMN"] + ")'>&nbsp&nbsp</i>";
                    html += "<i style ='color: blue;'  id='btt_chucnang_role' id_edit='6' data-id='" + data[i]["IDMN"] + "' class='fa-solid fa-gear' onclick = 'data_tables_menus(" + data[i]["IDMN"] + ")'>&nbsp&nbsp</i>";
                    html += "<i style ='color: red;'  id='btt_manhinh_dlt' id_edit='4' data-id='3' class='fa-regular fa-trash-can' onclick = 'dlt_manhinh(" + data[i]["IDMN"] + ")'>&nbsp&nbsp</i></td>";
                    html += "<tr>";
                }

            }
            html += "</tbody>";
            html += "</table>";
            $("#ds_manhinh").html(html);
            $("#danhsach_manhinh").DataTable({
                scrollY: "200px",
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: false,
                info: false,
                autoWidth: true,
                responsive: true,
            });
            // }
        },
    });
}
//edit màn hình
function edit_manhinh(id) {
    var id_manhinh = $('#id_manhinh_tam').text();
    var id_chucnang = $("#btt_menus_edit").attr("data-id");
    $.ajax({
        type: "get",
        url: "/admin24/edit_manhinh/" + id,
        dataType: "json",
        data:{
            id_manhinh:id_manhinh,
            id_chucnang:id_chucnang
        },
        success: function(res) {
            if (res == -1) {
                return toastr.warning("Không có quyền truy cập chức năng này");
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
    $("#error_update_tenmanhinh").text("");
    $("#error_update_icon").text("");
    $("#error_update_link").text("");
    $("#error_update_stt").text("");

    $("#update_manhinhgoc").empty();
    $("#modal_manhinh").hide();
}
// Update màn hình

function update_manhinh() {
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
        },
        success: function(res) {
            $("#error_update_tenmanhinh").text("");
            $("#error_update_icon").text("");
            $("#error_update_link").text("");
            $("#error_update_stt").text("");
            if (res == 1) {
                // list_accounts();
                $("#modal_manhinh").hide();
                ds_manhinh();
                $.ajax({
                    type: "get",
                    url: "/sidebar",
                    success: function(res) {
                        $("#loadsidebar").empty();
                        $("#loadsidebar").html(res);
                    },
                });
                return toastr.success("Cập nhật thành công");
            } else if (res == 4) {
                return toastr.warning(
                    "Cập nhật không thành công,liên hệ admin"
                );
            } else if (res == 3) {
                return toastr.warning(
                    "Tên màn hình bị trùng"
                );
            } else if (res == -2) {
                return toastr.warning(
                    "Chưa có thay đổi"
                );
            } else {
                if (res.update_tenmanhinh) {
                    $("#error_update_tenmanhinh").text(res.update_tenmanhinh[0]);
                }
                if (res.update_link) {
                    $("#error_update_link").text(res.update_link[0]);
                }
                if (res.update_icon) {
                    $("#error_update_icon").text(res.update_icon[0]);
                }
                if (res.update_stt) {
                    $("#error_update_stt").text(res.update_stt[0]);
                }
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
function Add_new_Menu() {
    $("#error_link").text("");
    $("#error_icon").text("");
    $("#error_stt").text("");
    $("#error_manhinh").text("");

    var id_manhinh = $('#id_manhinh_tam').text();
    var id_chucnang = $('#btt_submit_menu').attr('btt_id_add');
    $.ajax({
        type: "post",
        url: "/admin24/Add_new_Menu",
        data: {
            menus_manhinh: $("#menus_manhinh").val(),
            menus_parent: $("#manhinhgoc").val(),
            menus_link: $("#menus_link").val(),
            menus_icon: $("#menus_icon").val(),
            menus_stt: $("#menus_stt").val(),
            id_manhinh: id_manhinh,
            id_chucnang: id_chucnang,
        },
        success: function(res) {
            if (res == 1) {
                ds_manhinh();
                $.ajax({
                    type: "get",
                    url: "/sidebar",
                    success: function(res) {
                        $("#loadsidebar").empty();
                        $("#loadsidebar").html(res);
                    },
                });
                toastr.success("Thêm thành công");
                $("#menus_manhinh").val(""),
                    $("#menus_link").val(""),
                    $("#menus_icon").val(""),
                    $("#menus_stt").val("")
            } else if (res == 0) {
                toastr.warning("Cập nhật không thành công, liên hệ admin");
            } else if (res == -2) {
                toastr.warning("Không có quyền truy cập chức năng");
            }
            if (res.menus_manhinh) {
                $("#error_manhinh").text(res.menus_manhinh[0]);
            }
            if (res.menus_link) {
                $("#error_link").text(res.menus_link[0]);
            }
            if (res.menus_icon) {
                $("#error_icon").text(res.menus_icon[0]);
            }
            if (res.menus_stt) {
                $("#error_stt").text(res.menus_stt[0]);
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
function dlt_manhinh(idmn) {
    var id_manhinh = $('#id_manhinh_tam').text();
    var id_chucnang = $('#btt_manhinh_dlt').attr('id_edit');
    $.ajax({
        type: "post",
        url: "/admin24/dlt_manhinh/" + idmn,
        data:{
            id_manhinh: id_manhinh,
            id_chucnang: id_chucnang
        },
        success: function(res) {
            if (res == 1) {
                ds_manhinh();
                // $.ajax({
                //     type: "get",
                //     url: "/sidebar",
                //     success: function(res) {
                //         $("#loadsidebar").empty();
                //         $("#loadsidebar").html(res);
                //     },
                // });
                return toastr.success("Xóa màn hình thành công");
            }else if(res == -2){
                return toastr.warning("Không có quyền truy cập chức năng");
            }else if (res == 2) {
                return toastr.warning("Không có quyền truy cập chức năng");
            } else if (res == 4) {
                return toastr.warning("Không thể xóa màn hình này!!Liên hệ admin");
            } else if (res == 3) {
                return toastr.warning("Màn hình có chứa màn hình khác!!")
            } else if (res == 5) {
                return toastr.warning("Không thể xóa màn hình hiện tại!!!");
            } else if (res == 6) {
                return toastr.warning("Màn hình đang được sử dụng!!!Hãy xóa quyền truy cập của người dùng trước");
            } else {
                return toastr.warning("Có lỗi xảy ra!!!Liên hệ admin");
            }
        },
    });
}

function modal_close_chucnangmanhinh() {
    $("#modal_phan_chucnang_manhinh").hide();
}

function data_tables_menus(idmn) {
    $("#remove_Menus").empty();
    var id_manhinh = $("#btt_manhinh_dlt").attr("data-id");
    $.ajax({
        type: "get",
        url: "/admin24/data_tables_menus/" + idmn,
        data: {
            id_manhinh: id_manhinh,
        },
        success: function(data) {
            if (data == 2) {
                return toastr.warning("Không có quyền truy cập chức năng");
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

function Update_chucnang_manhinh(id_user, id_manhinh, id_chucnang) {
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
        },
        success: function(res) {
            if (res == 1) {
                data_tables_menus(id_manhinh)
                return toastr.warning("Lỗi hệ thống!!!Liên hệ admin")
            } else if (res == 0) {
                data_tables_menus(id_manhinh)
                return toastr.success("Thay đổi thành công");
            } else {
                data_tables_menus(id_manhinh)
                return toastr.warning("Có lỗi xảy ra!!!Liên hệ admin")
            }
        },
    });
}
