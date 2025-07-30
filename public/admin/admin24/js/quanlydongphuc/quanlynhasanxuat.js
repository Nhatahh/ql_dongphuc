$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    danhsach_nhasanxuat()
});

function clear_form_nsx(){
    clear_input_error()
    $("#nhasanxuat_moi").val('')
    $("#diachi_moi").val('')
    $("#sdt_moi").val('')
    $("#mansx").val('')
}
// thêm nhà sản xuất
async function themnhasanxuat(event) {
    event.preventDefault();
    $('#modal_event').show();
    let id_chucnang = 3;
    const check = await laythongtincheckquyen(id_chucnang);
    $.ajax({
        type: "post",
        url: "themnhasanxuat",
        // dataType: 'json',
        data: {
            'nhasanxuat_moi': $("#nhasanxuat_moi").val(),
            'diachi_moi': $("#diachi_moi").val(),
            'sdt_moi': $("#sdt_moi").val(),
            'mansx': $("#mansx").val(),
            //Check quyền
            'time': check[1],
            'id_manhinh': check[0],
            'id_chucnang': id_chucnang,
            'active': 1,
        },
        success: function (res) {
            clear_input_error()
            if(['ins_0', 'ins_1', '-100', 'rol_2'].includes(res.trangthai) == true){
                thongbao(res.trangthai)
                clear_form_nsx()
            }else{
                input_error(res)
            }
            $("#danhsachnhasanxuat").DataTable().ajax.reload(null, false);
            setTimeout(() => {
                $('#modal_event').hide();
            }, 300);
        },
    });
}
// danh nhà sản xuất
function danhsach_nhasanxuat() {
    $("#danhsachnhasanxuat").empty();
    var table = $("#danhsachnhasanxuat").DataTable({
        ajax: {
            type: "get",
            url: "danhsach_nhasanxuat",
        },
        // dom: 'frtip',
        columns: [

            {
                targets: 0,
                name: 'stt',
                width: "5%",
                title: "STT",
                data: "stt",
                className: "text-center align-middle",
            },
            {
                targets: 0,
                name: 'mansx',
                width: "10%",
                title: "Mã NSX",
                data: "mansx",
                className: "text-center align-middle",
            },
            {
                name: "nhasanxuat",
                title: "Nhà sản xuất",
                data: "nhasanxuat",
                render: function(data, type, row){
                    return '<input onchange="Upd_Nhasanxuat(event,' + row.id + ')" id="nhasanxuat_' + row.id + '" class="edit_tabledata" value="' + data + '">';
                },
                className: "align-middle",

            },
            {
                name: "diachi",
                title: "Địa chỉ",
                data: "diachi",
                render: function(data, type, row){
                    return '<input onchange="Upd_Nhasanxuat(event,' + row.id + ')" id="diachi_' + row.id + '" class="edit_tabledata" value="' + data + '">';
                },
                className: "align-middle",

            },
            {
                name: "sdt",
                title: "SĐT",
                data: "sdt",
                render: function(data, type, row){
                    return '<input onchange="Upd_Nhasanxuat(event,' + row.id + ')" id="sdt_' + row.id + '" class="edit_tabledata" value="' + data + '">';
                },
                className: "align-middle",

            },
            {
                title: "Trạng thái",
                data: "trangthai",
                render: function (data) {
                    let trangthai = ""
                    return data == 1 ? trangthai = '<small class="badge badge-primary">Đang sử dụng</small>' : trangthai = '<small class="badge badge-warning">Ngừng sử dụng</small>'
                },
                className: "text-center align-middle",
            },
            {
                title: "Chức năng",
                className: "text-center",
                data: "id",
                render: function (data, type, row) {
                    if (type === 'display') {
                        if(row.trangthai == 1){
                            html1 ='<i style ="color: #007bff; padding-top:8px" class="fa-solid fa-unlock" trangthai = "'+row.trangthai+'" id = "trangthai_NSX_'+data+'" onclick = change_TrangthaiNSX(event,' +data +')></i> &nbsp&nbsp';
                        }else{
                            html1 ='<i style ="color: #ffc107; padding-top:8px" class="fa-solid fa-lock" trangthai = "'+row.trangthai+'" id = "trangthai_NSX_'+data+'" onclick = change_TrangthaiNSX(event,' +data +')></i> &nbsp&nbsp';
                        }
                        html ='<i style ="color: red; padding-top:8px"   class="fa-regular fa-trash-can" id = "dlt_loai'+data+'" onclick = dlt_Nhasaxuat(event,' +data +")></i>";
                    }
                    return data = html1 + html;
                },
            },
        ],

        columnDefs: [
            {
                targets: 2,
                className: "text-center",
            },
            {
                targets: 3,
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
        retrieve: false,
        paging: false,
        lengthChange: false,
        searching: true,
        ordering: false,
        info: true,
        autoWidth: true,
        responsive: true,
        select: true,
    });
}
async function Upd_Nhasanxuat(event,id){
    event.preventDefault()
    $('#model_event').show()
    let id_chucnang = 2;
    const check = await laythongtincheckquyen(id_chucnang);
    var upd_nhasanxuat = $('#nhasanxuat_'+id).val()
    var upd_diachi = $('#diachi_'+id).val()
    var upd_sdt = $('#sdt_'+id).val()
    $.ajax({
        type: 'POST',
        url:'Upd_Nhasanxuat',
        data:{
            'id': id,
            'upd_nhasanxuat':upd_nhasanxuat,
            'upd_diachi':upd_diachi,
            'upd_sdt':upd_sdt,
            //Check quyền
            'time': check[1],
            'id_manhinh': check[0],
            'id_chucnang': id_chucnang,
            'active': 1,
        },
        success: function(res){
            if(['upd_0', 'upd_1', '-100', 'rol_2', 'prod_0'].includes(res.trangthai) == true){
                thongbao(res.trangthai)
            }else{
                thongbao_error(res)
            }
            $("#danhsachnhasanxuat").DataTable().ajax.reload(null, false);
            setTimeout(() => {
                $('#modal_event').hide();
            }, 300);
        }
    })
}
async function change_TrangthaiNSX(event,id){
    event.preventDefault();
    $('#modal_event').show();
    let id_chucnang = 2;
    const check = await laythongtincheckquyen(id_chucnang);
    var trangthai = $('#trangthai_NSX_'+id).attr('trangthai')

    $.ajax({
        type: "POST",
        url: "change_TrangthaiNSX",
        data:{
            'id': id,
            'trangthai': trangthai,
            //Check quyền
            'time': check[1],
            'id_manhinh': check[0],
            'id_chucnang': id_chucnang,
            'active': 1,
        },
        success: function(res){
            if(['upd_1', 'upd_0', '-100','rol_2'].includes(res.trangthai) == true){
                thongbao(res.trangthai)
                $("#danhsachnhasanxuat").DataTable().ajax.reload(null, false);
                setTimeout(() => {
                    $('#modal_event').hide();
                }, 300);
            }
        }
    })

}
async function dlt_Nhasaxuat(event,id){
    event.preventDefault();
    $('#modal_event').show();
    let id_chucnang = 4;
    const check = await laythongtincheckquyen(id_chucnang);
    $.ajax({
        type: "POST",
        url: "dlt_Nhasaxuat/"+id,
        data: {
            //Check quyền
            'time': check[1],
            'id_manhinh': check[0],
            'id_chucnang': id_chucnang,
            'active': 1,
        },
        success: function(res){
            if(['del_1', 'del_0', 'prod_1','prod_0', '-100', 'rol_2'].includes(res) == true){
                thongbao(res)
                $("#danhsachnhasanxuat").DataTable().ajax.reload(null, false);
                setTimeout(() => {
                    $('#modal_event').hide();
                }, 300);
            }
        }
    })
}
