$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $("#addsize_tennsx").select2();
    $("#addsize_loai").select2();
    hienthisize();
    addsize_tennsx();
});
//
function addsize_tennsx() {
    $.ajax({
        type: "get",
        url: "size/addsize_tennsx",
        dataType: "json",
        success: function (res) {
            $("#addsize_tennsx").select2({
                data: res.addsize_nsx,
            });
            $("#addsize_loai").select2({
                data: res.addsize_loai,
            });
        },
    });
}

//
function themsize() {
    if ($("#tensize").val() == "") {
        toastr.warning("Tên size không được trống!");
    } else if ($("#addsize_tennsx").val() == 0) {
        toastr.warning("Tên nhà sản xuất không được trống!");
    }else if ($("#addsize_loai").val() == 0) {
        toastr.warning("Tên loại không được trống!");
    }
    else if ($("#addsize_thongso").val() == 0) {
        toastr.warning("Thông số không được trống!");
    }else {
        $.ajax({
            type: "post",
            url: "size/themsize",
            // dataType: 'json',
            data: {
                tensize: $("#tensize").val(),
                addsize_tennsx: $("#addsize_tennsx").val(),
                addsize_loai: $("#addsize_loai").val(),
                addsize_thongso: $("#addsize_thongso").val(),
            },
            success: function (res) {
                if (res == 1) {
                    hienthisize();
                    size_clear()
                    toastr.success("Thêm thành công");
                } else if(res==3) {
                    toastr.warning("Cập nhật không thành công,size đã tồn tại");
                }else  toastr.warning("Cập nhật không thành công,liên hệ admin");
            },
        });
    }
}
//
function modal_close_size() {
    $("#modal_sua_size").hide();
    $("#sua_size_nsx").empty();
    $("#sua_size_nsx").empty();
}
//

function xoasize(id) {
    $.ajax({
        type: "post",
        url: "size/xoasize/" + id,
        success: function (res) {
            if (res == 1) {
                hienthisize();
                return toastr.success("Xóa thành công");
            } else {
                // $('#info_login').html('<span style = "color: red">Mật khẩu hoặc email không đúng</span>')
                return toastr.warning("Xóa không thành công!!Tồn tại loại nhận size này");
                // toastr.warning('aaaaaaaaaaaaaaaaaaaaa');
            }
        },
    });
}
//


function modal_sua_size(id) {
    $("#sua_size_loai").empty();
    $("#sua_size_nsx").empty();
    $("#modal_sua_size").show();
    $("#btnCapNhat").attr("data-id", id);
    $.ajax({
        type: "get",
        url: "/admin/size/sua_size/" + id,
        dataType: "json",
        success: function (res) {
            $("#sua_size_loai").select2({
                data: res.loai,
            });
            $("#sua_size_nsx").select2({
                data: res.nsx,
            });
            $("#sua_size_thongso").val(res.info[0].thongso);
            $("#sua_size_ten").val(res.info[0].namesize);
        },
    });
}



// function modal_sua_size(id) {
//     // alert(1111111)
//     setTimeout(() => {
//         modal_sua_size1(id)
//     }, 200);
// }



// đóng size
function close_update_size(){
    modal_close_size();
}
// làm mới size
function clear_size(){
    $("#sua_size_loai").empty();
    $("#sua_size_nsx").empty();
    $("#sua_size_thongso").empty();
    var id=$("#btnCapNhat").attr("data-id");
    modal_sua_size(id);
}
//
function update_size(){
    var id = $("#btnCapNhat").data("id");
    var sua_size_ten = $("#sua_size_ten").val();
    var sua_size_loai = $("#sua_size_loai").val();
    var sua_size_nsx = $("#sua_size_nsx").val();
    var sua_size_thongso = $("#sua_size_thongso").val();
    $.ajax({
        type: "post",
        url: "size/update_size/" + id,
        data: {
            id: id,
            sua_size_ten: sua_size_ten,
            sua_size_loai: sua_size_loai,
            sua_size_nsx: sua_size_nsx,
            sua_size_thongso: sua_size_thongso,
        },
        success: function (res) {
            if(res == 1){
                hienthisize();
                $("#modal_sua_size").hide();
                return toastr.success("Cập nhật thành công");
            }
            else if(res == 0){
                return toastr.warning("Cập nhật không thành công");
            }
        },
    });
}
//

function hienthisize() {
    $("#hienthi_size").empty();
    $("#hienthi_size").append(
        '<table class="table-bordered table-hover table-striped" id="allsize"></table>'
    );
    var table = $("#allsize").DataTable({
        ajax: {
            type: "get",
            url: "/admin/size/hienthi_size",
        },
        // dom: 'frtip',
        columns: [
            { title: "ID", data: "idsz" },

            { title: "Size", data: "namesize" },
            { title: "Nhà sản xuất", data: "nsx_name" },
            { title: "Loại", data: "loai_name" },
            { title: "Thông số", data: "thongso" },
            {
                title: "Chức năng",
                data: "idsz",
                render: function (data) {
                    var html =
                        '<i style ="color: #0000FF;" class="fa-regular fa-pen-to-square"  onclick = "modal_sua_size(' +
                        data +
                        ')">&nbsp&nbsp</i><i style ="color: red;" class="fa-regular fa-trash-can"onclick = xoasize(' +
                        data +
                        ")></i>";

                    return html;
                },
            },
        ],

        columnDefs: [
            {
                targets: 4,
                className: "text-center",
            },
        ],

        scrollY: 450,
        language: {
            emptyTable: "Không có sản phẩm",
            info: " _START_ / _END_ trên _TOTAL_ sản phẩm",
            paginate: {
                first: "Trang đầu",
                last: "Trang cuối",
                next: "Trang sau",
                previous: "Trang trước",
            },
            search: "Tìm kiếm:",
            loadingRecords: "Đang tìm kiếm ... ",
            lengthMenu: "Hiện thị _MENU_ sản phẩm",
            infoEmpty: "",
        },
        retrieve: true,
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: true,
        responsive: true,
        select: true,
    });
}

function size_clear(){
    $("#addsize_tennsx").empty();
    $("#addsize_loai").empty();
    addsize_tennsx();
    $("#tensize").val('');
    $("#addsize_thongso").val('')
}

function change_nsx(){
    var id = $('#addsize_tennsx').val();
    $.ajax({
        type: "get",
        url: "size/change_nsx/" + id,
        success: function (res) {
            $("#addsize_loai").empty()
            $("#addsize_loai").select2({
                data: res
            });
            // alert(res)
        }
    })
}

function change_edit_nsx(){
    var id = $('#sua_size_nsx').val();
    $.ajax({
        type: "get",
        url: "size/change_nsx/" + id,
        success: function (res) {
            $("#sua_size_loai").empty()
            $("#sua_size_loai").select2({
                data: res
            });
        }
    })
}
