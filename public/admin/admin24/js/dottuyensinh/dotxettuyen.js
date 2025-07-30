$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



    bang_ds_dotxettuyen();

    load_selectbox_dotxettuyen();

    refresh_dotxettuyen();

});



function bang_ds_dotxettuyen(){
    var ds_dotxettuyen = $("#bang_ds_dotxettuyen").DataTable({
        ajax: {
            type: "get",
            url: "/admin24/bang_ds_dotxettuyen",
        },
        columns: [
            // { title: "STT", data: "stt" },
            { title: "STT", data: "stt" },
            { title: "Đợt tuyển sinh", data: "tendot" },
            { title: "ID đxt", data: "iddotxt" },
            { title: "Tên đợt", data: "tendotxettuyen" },
            { title: "ID QT", data: "id_quytrinhcongbo" },
            { title: "Ghi chú", data: "ghichu_quytrinh" },
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
                    var icon_sua = '<i id="" class="fa-regular fa-pen-to-square" onclick = "edit_load_dotxettuyen('+row.id+')" >&nbsp&nbsp</i>';
                    tendot = "'" + row['tendotxettuyen'] + "'";
                    var icon_xoa = '<i style ="color: red;" id="" class="fa-regular fa-solid fa-user-xmark" onclick = "delete_dxt('+row.id+','+ tendot + ')">&nbsp&nbsp</i>';

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
            emptyTable: "Không có đợt xét tuyển",
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
    return ds_dotxettuyen;
}


function load_selectbox_dotxettuyen(){
    $.ajax({
        type: "get",
        url: "/admin24/load_selectbox_dotxettuyen",
        dataType: "json",
        success: function(res) {
            $("#iddotts").select2({
                data: res,
            });
        },
    });

    // document.getElementById("iddotts").selectedIndex = 2;
}

function them_dotxettuyen(){
    $("#modal_event").show();
    // $("#dkg_dangky").prop("disabled", true)
    $("#modal_event").show();
    $.ajax({
        type: 'post',
        url: '/admin24/them_dotxettuyen',
        data: {
            iddotts: $("#iddotts").val(),
            iddotxt: $("#iddotxt").val(),
            tendotxettuyen: $("#tendotxettuyen").val(),
            id_quytrinhcongbo: $("#id_quytrinhcongbo").val(),
            ghichu_quytrinh: $("#ghichu_quytrinh").val(),
            khoadot: 0,
        },
        success: function (res) {
            if(res == 1){
                toastr.success('Đã thêm thành công! abc'); //Xu ly ngoai le
                bang_ds_dotxettuyen().ajax.url('/admin24/bang_ds_dotxettuyen').load();
            }else{
                toastr.error("Thêm thất bại");
                if(res == 0){
                    toastr.error('Hệ thống bị lỗi, vui lòng ngưng sử dụng');
                }else{
                    toastr.warning(res);
                }
            }
            // $("#dkg_dangky").prop("disabled", false)
            $("#modal_event").hide();
        }
    });

    refresh_dotxettuyen();

}

function edit_load_dotxettuyen(id){

    $.ajax({
        type: "get",
        url: "/admin24/edit_load_dotxettuyen",
        dataType: "json",
        data: {
            id: id,
        },
        success: function (res) {
                console.log(res);
                var dxt_data = res.edit_load_dotxettuyen[0];
                $("#edit_iddotts").select2({
                    data: res.selectbox_dottuyensinh,
                });;
                $("#edit_iddotts").val(dxt_data.iddotts);
                $("#edit_iddotts").trigger('change');
                $("#edit_iddotxt").val(dxt_data.iddotxt);
                $("#edit_tendotxettuyen").val(dxt_data.tendotxettuyen);
                $("#edit_id_quytrinhcongbo").val(dxt_data.id_quytrinhcongbo);
                $("#edit_ghichu_quytrinh").val(dxt_data.ghichu_quytrinh);
                if (dxt_data.khoadot == 1){
                    $("#edit_khoadot").prop("checked",true);
                }
                $('#update_dotxettuyen_button').attr('data-id',id);
        },
    });

    $("#modal_sua_dxt").show();
}

function close_modal_sua_dxt(){
    $("#modal_sua_dxt").hide();
    $("#edit_iddotts").val("");
    $("#edit_iddotxt").val("");
    $("#edit_tendotxettuyen").val("");
    $("#edit_id_quytrinhcongbo").val("");
    $("#edit_ghichu_quytrinh").val("");
    $("#edit_khoadot").prop("checked",false);
    $('#update_dotxettuyen_button').attr('data-id',"");
    dxt_data_refresh = 0;
}


function update_dotxettuyen(){
    $("#modal_event").show();

    var id = $('#update_dotxettuyen_button').attr('data-id');
    var iddotts = $("#edit_iddotts").val();
    var iddotxt = $("#edit_iddotxt").val();
    var tendotxettuyen = $("#edit_tendotxettuyen").val();
    var id_quytrinhcongbo = $("#edit_id_quytrinhcongbo").val();
    var ghichu_quytrinh = $("#edit_ghichu_quytrinh").val();
    var khoadot = $('#edit_khoadot').prop('checked') == true ? khoadot = 1 : khoadot = 0;

    $.ajax({
        type: 'post',
        url: '/admin24/update_dotxettuyen',
        data: {
            id: id,
            iddotts: iddotts,
            iddotxt: iddotxt,
            tendotxettuyen: tendotxettuyen,
            id_quytrinhcongbo: id_quytrinhcongbo,
            ghichu_quytrinh: ghichu_quytrinh,
            khoadot: khoadot,
        },
        success: function (res) {
            bang_ds_dotxettuyen().ajax.url('/admin24/bang_ds_dotxettuyen').load()
            thongbao(res)
            $("#modal_event").hide();
        }
    })


}


function refresh_modal_sua_dxt(){
    var id = $('#update_dotxettuyen_button').attr('data-id');
    edit_load_dotxettuyen(id);
}

function refresh_dotxettuyen() {
    $("#iddotts").val("0");
    $("#iddotts").trigger('change');
    $("#iddotxt").val("");
    $("#tendotxettuyen").val("");
    $("#id_quytrinhcongbo").val("");
    $("#ghichu_quytrinh").val("");
}


function delete_dxt(id, tendot){
    let choice = confirm("Xóa \"" + tendot + "\"! Đồng ý???");
    if (choice){
        $.ajax({
            type: "post",
            url: "/admin24/delete_dotxettuyen",
            dataType: "json",
            data: {
                id: id,
            },
            success: function (res) {
                bang_ds_dotxettuyen().ajax.url('/admin24/bang_ds_dotxettuyen').load()
                toastr.success('Xóa thành công');
            },
        });
    }
}
