$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    bang_ds_dottuyensinh();

    refresh_dottuyensinh();

    $('#update_dottuyensinh_button').attr('data-id',"");
    close_modal_sua_dts();

});



function bang_ds_dottuyensinh(){
    var ds_dottuyensinh = $("#bang_ds_dottuyensinh").DataTable({
        ajax: {
            type: "get",
            url: "/admin24/bang_ds_dottuyensinh",
        },
        columns: [
            { title: "STT", data: "stt" },
            { title: "Mã đợt", data: "madot" },
            { title: "Tên đợt", data: "tendot" },
            { title: "Trạng thái", data: "trangthai",
                render: function (data, type, row){
                    var cbtrangthai = ''
                    if (data == 1){
                        cbtrangthai = '<input type="checkbox" checked="" onclick="return false;" style="height:18px;background-color:inhert">';
                    } else{
                        cbtrangthai = '<input type="checkbox" onclick="return false;" style="height:18px;background-color:inhert">';
                    }
                    return cbtrangthai
                }
            },
            { title: "Khóa đợt", data: "khoadot",
                render: function (data, type, row){
                    var cbtrangthai = ''
                    if (data == 1){
                        cbtrangthai = '<input type="checkbox" checked="" onclick="return false;" style="height:18px;background-color:inhert">';
                    } else{
                        cbtrangthai = '<input type="checkbox" onclick="return false;" style="height:18px;background-color:inhert">';
                    }
                    return cbtrangthai
                }
             },
            {
                title: "Chức năng",
                data: 'id',
                render: function (data, type, row) {
                    var icon_sua = '<i id="" class="fa-regular fa-pen-to-square" onclick = "edit_load_dottuyensinh('+row.id+')" >&nbsp&nbsp</i>';

                    var icon_xoa = '<i style ="color: red;" id="" class="fa-regular fa-solid fa-user-xmark" onclick = "delete_dts('+row.id+')">&nbsp&nbsp</i>';

                    // var icon_sua = '<i id="btt_chucnang_edit" class="fa-regular fa-pen-to-square" onclick = "edit_accounts(' + row.sua.id_nguoidung + ',' + row.sua.id_chucnang + ',' + row.sua.active + ')">&nbsp&nbsp</i>';
                    // var icon_phanquyen = '<i style ="color: blue;" id="btt_chucnang_role" class="fa-solid fa-gears" onclick = "loadUser_Menus_Roles(' + row.phanquyen.id_nguoidung + ',' + row.phanquyen.id_chucnang + ',' + row.phanquyen.active + ')">&nbsp&nbsp</i>';
                    // if (row.status == 1) {
                    //     var icon_xoa = '<i style ="color: red;" id="btt_chucnang_dlt" class="fa-regular fa-solid fa-user-xmark" onclick = "delete_accounts(' + row.xoa.id_nguoidung + ',' + row.xoa.id_chucnang + ',' + row.xoa.active + ','+row.status+')">&nbsp&nbsp</i>';
                    // } else {
                    //     var icon_xoa = '<i style ="color: #007bff;" id="btt_chucnang_dlt" class="fa-solid fa-user-check" onclick = "delete_accounts(' + row.xoa.id_nguoidung + ',' + row.xoa.id_chucnang + ',' + row.xoa.active + ','+row.status+')">&nbsp&nbsp</i>';
                    // }
                    return html = icon_sua + icon_xoa
                },
            },

        ],
        columnDefs: [
            {
                targets: 0,
                className: "text-center",
            },
            {
                targets: 1,
                className: "text-center",
            },
        ],
        scrollY: 400,
        language: {
            emptyTable: "Không có đợt tuyển sinh",
            info: " _START_ / _END_ trên _TOTAL_ đợt",
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
    return ds_dottuyensinh;
}



function them_dottuyensinh() {
    let trangthaichecked = 0;
    if ($("#trangthai").is(":checked")) {
        trangthaichecked = 1;
    }

    $("#modal_event").show();

    $.ajax({
        type: 'post',
        url: '/admin24/them_dottuyensinh',
        data: {
            madot: $("#madot").val(),
            tendot: $("#tendot").val(),
            trangthai: trangthaichecked,
            khoadot: 0,
        },
        success: function (res) {
            if(res == 1){
                toastr.success('Đã thêm thành công!');
                bang_ds_dottuyensinh().ajax.url('/admin24/bang_ds_dottuyensinh').load();
            } else {
                toastr.error("Thêm thất bại");
                if(res == 0){
                    toastr.error('Hệ thống bị lỗi, vui lòng ngưng sử dụng');
                } else {
                    toastr.warning(res);
                }
            }

            $("#modal_event").hide();
        }
    });

    refresh_dottuyensinh()
}

// var dts_data_refresh = 0;

function edit_load_dottuyensinh(id){

    $.ajax({
        type: "get",
        url: "/admin24/edit_load_dottuyensinh",
        dataType: "json",
        data: {
            id: id,
        },
        success: function (res) {
                var dts_data = res[0];
                // dts_data_refresh = dts_data;
                // $("#modal_accounts").show();
                $("#edit_madot").val(dts_data.madot);
                $("#edit_tendot").val(dts_data.tendot);
                if (dts_data.trangthai == 1){
                    $("#edit_trangthai").prop("checked",true);
                } else {
                    $("#edit_trangthai").prop("checked",false);
                }
                if (dts_data.khoadot == 1){
                    $("#edit_khoadot").prop("checked",true);
                } else {
                    $("#edit_khoadot").prop("checked",false);
                }
                $('#update_dottuyensinh_button').attr('data-id',id);
        },
    });

    $("#modal_sua_dts").show();
}

function close_modal_sua_dts(){
    $("#modal_sua_dts").hide();
    $("#edit_madot").val("");
    $("#edit_tendot").val("");
    $("#edit_trangthai").prop("checked",false);
    $("#edit_khoadot").prop("checked",false);
    $('#update_dottuyensinh_button').attr('data-id',"");
    dts_data_refresh = 0;
}


function update_dottuyensinh(){
        var id = $('#update_dottuyensinh_button').attr('data-id');
        var madot = $("#edit_madot").val();
        var tendot = $("#edit_tendot").val();
        var trangthai = $('#edit_trangthai').prop('checked') == true ? trangthai = 1 : trangthai = 0;
        // alert(trangthai);
        var khoadot = $('#edit_khoadot').prop('checked') == true ? khoadot = 1 : khoadot = 0;
        // alert(id)
        // alert(trangthai)
        $("#modal_event").show();
        $.ajax({
            type: 'post',
            url: '/admin24/update_dottuyensinh',
            data: {
                id: id,
                madot: madot,
                tendot: tendot,
                trangthai: trangthai,
                khoadot: khoadot,
            },
            success: function (res) {
                bang_ds_dottuyensinh().ajax.url('/admin24/bang_ds_dottuyensinh').load()
                thongbao(res)
                $("#modal_event").hide();
            }
        })

    }


function refresh_modal_sua_dts(){
    var id = $('#update_dottuyensinh_button').attr('data-id');
    edit_load_dottuyensinh(id);
    // $("#edit_madot").val(dts_data_refresh.madot);
    // $("#edit_tendot").val(dts_data_refresh.tendot);
    // if (dts_data_refresh.trangthai == 1){
    //     $("#edit_trangthai").prop("checked",true);
    // } else {
    //     $("#edit_trangthai").prop("checked",false);
    // }
    // if (dts_data_refresh.khoadot == 1){
    //     $("#edit_khoadot").prop("checked",true);
    // } else{
    //     $("#edit_khoadot").prop("checked",false);
    // }
}

function refresh_dottuyensinh() {
    $("#madot").val("");
    $("#tendot").val("");
    $("#trangthai").prop("checked", true);
    // $("#modal_event").show();
    // $.ajax({
    //     type: "post",
    //     url: "/admin24/refresh_dottuyensinh",
    //     dataType: "json",
    //     success: function(res) {
    //         bang_ds_dottuyensinh().ajax.url('/admin24/bang_ds_dottuyensinh').load();
    //         if (res.status === 'success') {
    //             document.getElementById("madot").value = "";
    //             document.getElementById("tendot").value = "";



    //             toastr.success("Làm mới thành công!");
    //         } else {
    //             toastr.error(res.message || "Có lỗi xảy ra!");
    //         }
    //         $("#modal_event").hide();
    //     },
        // error: function() {
        //     toastr.error("Có lỗi xảy ra khi kiểm tra dữ liệu!");
        // }
    // });
}
// function refresh_modal_sua_dts() {

//     $("#edit_madot").val("");
//     $("#edit_tendot").val("");

// }







function delete_dts(id){
    let choice = confirm("Xóa đợt tuyển sinh mã đợt " + id + "! Đồng ý???");
    if (choice){
        $.ajax({
            type: "post",
            url: "/admin24/delete_dottuyensinh",
            dataType: "json",
            data: {
                id: id,
            },
            success: function (res) {
                bang_ds_dottuyensinh().ajax.url('/admin24/bang_ds_dottuyensinh').load()
                toastr.success('Xóa thành công');
            },
        });
    }
}
