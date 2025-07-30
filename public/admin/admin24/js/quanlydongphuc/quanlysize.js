$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    danhsach_size()
    $('#danhsachsize_filter').hide()
});
// thêm loại
async function themsize(event) {
    event.preventDefault();
    $('#modal_event').show();
    let id_chucnang = 3;
    const check = await laythongtincheckquyen(id_chucnang);
    $.ajax({
        type: "post",
        url: "themsize",
        // dataType: 'json',
        data: {
            'sizemoi': $("#sizemoi").val(),
            'masize': $("#masize").val(),
            //Check quyền
            'time': check[1],
            'id_manhinh': check[0],
            'id_chucnang': id_chucnang,
            'active': 1,
        },
        success: function (res) {
            if(['ins_0', 'ins_1', '-100', 'rol_2'].includes(res.trangthai) == true){
                thongbao(res.trangthai)
                clear_input_error()
                clear_input_values()
            }else{
                // thongbao_error(res)
                input_error(res)
            }
            $("#danhsachsize").DataTable().ajax.reload(null, false);
            setTimeout(() => {
                $('#modal_event').hide();
            }, 300);
        },
    });
}
function clear_form_size(){
    clear_input_error()
    clear_input_values()
}
function danhsach_size() {
    $("#danhsachsize").empty();
    var table = $("#danhsachsize").DataTable({
        ajax: {
            type: "get",
            url: "danhsachsize",
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
                targets: 1,
                name: 'masize',
                width: "10%",
                title: "Mã size",
                data: "masize",
                className: "text-center align-middle",
            },
            {
                name: "size",
                title: "Size",
                data: "size",
                render: function(data, type, row){
                    return '<input onchange="Upd_Size(event,' + row.id + ')" id="size_' + row.id + '" class="edit_tabledata" value="' + data + '">';
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
            },
            {
                title: "Chức năng",
                className: "text-center",
                data: "id",
                render: function (data, type, row) {
                    if (type === 'display') {
                        if(row.trangthai == 1){
                            html1 ='<i style ="color: #007bff; padding-top:8px" class="fa-solid fa-unlock" trangthai = "'+row.trangthai+'" id = "trangthai_size_'+data+'" onclick = change_TrangthaiSize(event,' +data +')></i> &nbsp&nbsp';
                        }else{
                            html1 ='<i style ="color: #ffc107; padding-top:8px" class="fa-solid fa-lock" trangthai = "'+row.trangthai+'" id = "trangthai_size_'+data+'" onclick = change_TrangthaiSize(event,' +data +')></i> &nbsp&nbsp';
                        }
                        html ='<i style ="color: red; padding-top:8px"   class="fa-regular fa-trash-can" id = "dlt_size'+data+'" onclick = dlt_Size(event,' +data +")></i>";
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
        paging: true,
        lengthChange: false,
        searching: true,
        ordering: false,
        info: true,
        autoWidth: true,
        responsive: true,
        select: true,
    });
}
async function Upd_Size(event,id){
    event.preventDefault()
    $('#model_event').show()
    let id_chucnang = 2;
    const check = await laythongtincheckquyen(id_chucnang);
    var upd_size = $('#size_'+id).val()
    $.ajax({
        type: 'POST',
        url:'Upd_Size',
        data:{
            'id': id,
            'upd_size':upd_size,
            //Check quyền
            'time': check[1],
            'id_manhinh': check[0],
            'id_chucnang': id_chucnang,
            'active': 1,
        },
        success: function(res){
            if(['upd_0', 'upd_1', '-100', 'rol_2', 'prod_0'].includes(res.trangthai) == true){
                thongbao(res.trangthai)
            }else if(res.trangthai = 'validate'){
                thongbao_error(res)
            }else{
                toastr.warning('Lỗi hệ thống');
            }
            $("#danhsachsize").DataTable().ajax.reload(null, false);
            setTimeout(() => {
                $('#modal_event').hide();
            }, 300);
        }
    })
}
async function change_TrangthaiSize(event,id){
    event.preventDefault();
    $('#modal_event').show();
    let id_chucnang = 2;
    const check = await laythongtincheckquyen(id_chucnang);
    var trangthai = $('#trangthai_size_'+id).attr('trangthai')
    $.ajax({
        type: "POST",
        url: "change_TrangthaiSize",
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
                $("#danhsachsize").DataTable().ajax.reload(null, false);
                setTimeout(() => {
                    $('#modal_event').hide();
                }, 300);
            }
        }
    })
}
async function dlt_Size(event,id){
    event.preventDefault();
    $('#modal_event').show();
    let id_chucnang = 4;
    const check = await laythongtincheckquyen(id_chucnang);
    $.ajax({
        type: "POST",
        url: "dlt_Size/"+id,
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
                $("#danhsachsize").DataTable().ajax.reload(null, false);
                setTimeout(() => {
                    $('#modal_event').hide();
                }, 300);
            }
        }
    })
}
