$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });


    $("#l_listallsize").select2();
    $("#l_listallsp").select2();
    $("#l_listallke").select2();
    $("#l_listallnsx").select2();
    $("#l_listalldot").select2();
    l_listsp();
    l_listspn();

});
//


function truyentt() {
    var nsp_nsx = $("#l_listallnsx").val();
    $("#l_listallsp").empty();
    $.ajax({
        type: "get",
        url: "/admin/nsp/truyentt/"+nsp_nsx,
        success: function (res) {
            $("#l_listallsp").select2({
                data: res,
            });
            truyenttloai();
        },
    });
}

//
function truyenttloai() {
    var nsp_nsx = $("#l_listallnsx").val();
    var nsp_loai = $("#l_listallsp").val();
    $("#l_listallsize").empty();
    $.ajax({
        type: "get",
        url: "nsp/truyenttloai",
        data: {
            nsp_nsx: nsp_nsx,
            nsp_loai: nsp_loai,
        },
        success: function (res) {
            $("#l_listallsize").select2({
                data: res,
            });
        },
    });
}

//Load thông tin để nhập
function l_listsp() {
    $.ajax({
        type: "get",
        url: "nsp/l_listsp",
        dataType: "json",
        success: function (res) {
            $("#l_listallnsx").select2({
                data: res.listallnsx,
            });
            $("#l_listalldot").select2({
                data: res.listalldot,
            });
        },
    });
}


function edit_nhapsp(id) {
    $("#modal_editnhapsp").show();
    $("#btnCapNhat").attr("data-id", id);
    $("#btnCapNhat").attr("data-id", id);
    // edit_ttnhap();
    // $("#editnhap_size").select2();
    // $("#editnhap_loai").select2();
    // $("#editnhap_nsx").select2();
    // $("#editnhap_ke").select2();

    $.ajax({
        type: "get",
        url: "nsp/edit_nhapsp/" + id,
        dataType: "json",
        success: function (res) {
            // $("#editnhap_loai").val(res.info[0].loai_name);
            // $("#editnhap_size").val(res.info[0].diachi);
            // $("#editnhap_nsx").val(res.info[0].nsx_name);
            $("#editnhap_loai").select2({
                data: res.loai,
            });
            $("#editnhap_size").select2({
                data: res.size,
            });
            $("#editnhap_nsx").select2({
                data: res.nsx,
            });
            $("#editnhap_sl").val(res.info[0].soluong);
            $("#editnhapsp_ngay").val(res.info[0].ngaynhap);
            // $("#editnhapsp_ngay").val(res.info[0].ngaynhap);
        },
    });
}

function capnhatnhapsp() {
    var id = $("#btnCapNhat").data("id");
    var editnhapsp_ngay = $("#editnhapsp_ngay").val();
    var editnhap_loai = $("#editnhap_loai").val();
    var editnhap_size = $("#editnhap_size").val();
    var editnhap_nsx = $("#editnhap_nsx").val();
    // var editnhap_ke = $("#editnhap_ke").val();
    var editnhap_sl = $("#editnhap_sl").val();
    $.ajax({
        type: "post",
        url: "nsp/capnhatnhapsp/" + id,
        data: {
            id: id,
            editnhapsp_ngay: editnhapsp_ngay,
            editnhap_loai: editnhap_loai,
            editnhap_size: editnhap_size,
            editnhap_nsx: editnhap_nsx,
            // editnhap_ke: editnhap_ke,
            editnhap_sl: editnhap_sl,
        },
        success: function (res) {
            if (res == 1) {
                l_listspn();
                $("#modal_editnhapsp").hide();
                return toastr.success("Cập nhật thành công");
            } else if (res == 0) {
                return toastr.success("Cập nhật không thành công");
            }
        },
    });
}
//

function bttnhapsp() {
    if ($("#l_listallnsx").val() == 0) {
        toastr.warning("Tên nhà sản xuất không được trống!");
    } else if ($("#l_listallsp").val() == 0) {
        toastr.warning("Loại không được trống!");
    } else if ($("#l_listallsize").val() == 0) {
        toastr.warning("Size không được trống!");
    } else if ($("#sl_spn").val() == "") {
        toastr.warning("Số lượng không được trống!");
    } else if ($("#l_listalldot").val() == "") {
        toastr.warning("Đợt nhập không được trống!");
    } else {
        $.ajax({
            type: "post",
            url: "nsp/nsp_them",
            data: {
                ngaynhap: $("#fsp_ngay").val(),
                nsx: $("#l_listallnsx").val(),
                sp: $("#l_listallsp").val(),
                size: $("#l_listallsize").val(),
                sln: $("#sl_spn").val(),
                dot: $("#l_listalldot").val(),
            },
            success: function (res) {
                if (res == 1) {
                    toastr.success("Thêm thành công");
                    bttclearsp()
                    l_listspn();
                } else {
                    toastr.warning("Thêm không thành công, liên hệ admin");
                }
            },
        });
    }
    // alert('dlkfjadlk')
    // alert($('#nsx_ten').val())
}
//
function modal_lammoi_nhapsp() {
    $("#editnhap_loai").empty();
    $("#editnhap_size").empty();
    $("#editnhap_ke").empty();
    $("#editnhap_nsx").empty();
    var id = $("#btnCapNhat").data("id");
    edit_nhapsp(id);
}
//
function modal_close_nhapsp() {
    $("#modal_editnhapsp").hide();
    $("#editnhap_loai").empty();
    $("#editnhap_size").empty();
    $("#editnhap_ke").empty();
    $("#editnhap_nsx").empty();
}
function modal_huy_nhapsp() {
    $("#modal_editnhapsp").hide();
    $("#editnhap_size").empty();
    $("#editnhap_ke").empty();
    $("#editnhap_nsx").empty();
    $("#editnhap_loai").empty();
}
//
function delete_nhapsp(id) {
    $.ajax({
        type: "post",
        url: "nsp/delete_nhapsp/" + id,
        success: function (res) {
            if (res == 1) {
                l_listspn();
                return toastr.success("Xóa thành công");
            } else {
                // $('#info_login').html('<span style = "color: red">Mật khẩu hoặc email không đúng</span>')
                return toastr.warning("Xóa không thành công");
                // toastr.warning('aaaaaaaaaaaaaaaaaaaaa');
            }
        },
    });
}

//Load danh sách sản phẩm

function l_listspn() {
    $("#l_listspn").empty();
    $("#l_listspn").append(
        '<table class="table table-bordered table-hover table-striped dataTable no-footer dtr-inline" id="danhsachsanpham"></table>'
    );
    var table = $("#danhsachsanpham").DataTable({
        ajax: {
            type: "get",
            url: "nsp/l_listspn",
        },

        // dom: 'frtip',
        columns: [
            { title: "Loại", data: "loai_name" },
            { title: "Size", data: "namesize" },
            { title: "Nhà sản xuất", data: "nsx_name" },
            { title: "Số lượng", data: "soluong" },
            { title: "Đợt", data: "dot" },
            { title: "Ngày nhập", data: "ngaynhap" },
            {
                title: "Chức năng",
                data: "idn",
                render: function (data) {
                    var html =
                        '<i style ="color: #0000FF;" class="fa-regular fa-pen-to-square"  onclick = "edit_nhapsp(' +
                        data +
                        ')">&nbsp&nbsp</i><i style ="color: red;" class="fa-regular fa-trash-can"onclick = delete_nhapsp(' +
                        data +
                        ")></i>";

                    return html;
                },
            },
        ],

        columnDefs: [
            {
                targets: 5,
                className: "text-center",
            },
            {
                targets: 6,
                className: "text-center",
            },
        ],

        scrollY: 450,
        language: {
            emptyTable: "Không có loại sản phẩm",
            info: " _START_ / _END_ trên _TOTAL_",
            paginate: {
                first: "Trang đầu",
                last: "Trang cuối",
                next: "Trang sau",
                previous: "Trang trước",
            },
            search: "Tìm kiếm:",
            loadingRecords: "Đang tìm kiếm ... ",
            lengthMenu: "_MENU_",
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
        select: true,
    });
}

function nsp_alltt(sl_spn) {
    var sl_spn = sl_spn;
    var fsp_ngay = $("#fsp_ngay").val();
    var l_listallsize = {};
    var l_listallsp = {};
    var l_listallnsx = {};
    var l_listallke = {};
    var sl = {};
    for (var i = 1; i <= sl_spn; i++) {
        l_listallsize["l_listallsize" + i] = $("#l_listallsize" + i).val();
        l_listallsp["l_listallsp" + i] = $("#l_listallsp" + i).val();
        l_listallnsx["l_listallnsx" + i] = $("#l_listallnsx" + i).val();
        l_listallke["l_listallke" + i] = $("#l_listallke" + i).val();
        sl["sl" + i] = $("#sl" + i).val();
    }
    $.ajax({
        type: "post",
        url: "/nsp/nsp_alltt",
        data: {
            sl_spn: sl_spn,
            l_listallsize: l_listallsize,
            l_listallsp: l_listallsp,
            l_listallnsx: l_listallnsx,
            l_listallke: l_listallke,
            sl: sl,
            fsp_ngay: fsp_ngay,
        },
        success: function (res) {
            if (res == 1) {
                toastr.success("Thành công");
            }else if (res == 6) {
                toastr.warning("Vui lòng chọn đủ size");
            } else if (res == 7) {
                toastr.warning("Vui lòng chọn đủ tên sản phẩm!");
            } else if (res == 8) {
                toastr.warning("Vui lòng chọn đủ tên nhà sản xuất!");
            } else if (res == 9) {
                toastr.warning("Vui lòng chọn đủ kệ!");
            } else {
                toastr.warning("Không thành công liên hệ admin!");
            }
        },
    });
}


function bttclearsp(){
    $("#l_listallsize").empty();
    $("#l_listallsp").empty();
    $("#l_listallnsx").empty();
    $("#sl_spn").val('');
    l_listsp()
}
//

function truyentt_edit() {
    var nsp_nsx = $("#editnhap_nsx").val();
    $("#editnhap_loai").empty();
    $.ajax({
        type: "get",
        url: "/admin/nsp/truyentt/"+nsp_nsx,
        success: function (res) {
            $("#editnhap_loai").select2({
                data: res,
            });
            truyenttloai_edit();
        },
    });
}

//
function truyenttloai_edit() {
    var nsp_nsx = $("#editnhap_nsx").val();
    var nsp_loai = $("#editnhap_loai").val();
    $("#editnhap_size").empty();
    $.ajax({
        type: "get",
        url: "nsp/truyenttloai",
        data: {
            nsp_nsx: nsp_nsx,
            nsp_loai: nsp_loai,
        },
        success: function (res) {
            $("#editnhap_size").select2({
                data: res,
            });
        },
    });
}
