$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    danhsach_loai()
    $('#danhsachloai_filter').hide()
});
// thêm loại
async function themloai(event) {
    event.preventDefault();
    $('#modal_event').show();
    let id_chucnang = 3;
    const check = await laythongtincheckquyen(id_chucnang);
    $.ajax({
        type: "post",
        url: "themloai",
        // dataType: 'json',
        data: {
            'loaimoi': $("#loaimoi").val(),
            'maloai':$("#maloai").val(),
            //Check quyền
            'time': check[1],
            'id_manhinh': check[0],
            'id_chucnang': id_chucnang,
            'active': 1,
        },
        success: function (res) {
            if(['ins_0', 'ins_1', '-100', 'rol_2'].includes(res.trangthai) == true){
                thongbao(res.trangthai)
                clear_nhapsanpham()
            }else{
                input_error(res)
                // validate_span_error(res)
            }
            $("#danhsachloai").DataTable().ajax.reload(null, false);
            setTimeout(() => {
                $('#modal_event').hide();
            }, 300);
        },
    });
}
// danh sách loại
function danhsach_loai() {
    $("#danhsachloai").empty();
    var table = $("#danhsachloai").DataTable({
        ajax: {
            type: "get",
            url: "danhsachloai",
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
                name: 'maloai',
                width: "10%",
                title: "Mã loại",
                data: "maloai",
                className: "text-center align-middle",
            },
            {
                name: "loai",
                title: "Loại",
                data: "loai",
                render: function(data, type, row){
                    // return '<input onchange="Upd_Loai(event,' + row.id + ')" id="loai_' + row.id + '" class="edit_tabledata" value="' + data + '">';
                    return '<span id = "loai_'+row.id+'" class ="td_datatable" contenteditable="true" onfocus="change_contenteditable('+row.id+')">' + data + '</span>';
                },
                className: "align-middle p-1",

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
                            html1 ='<i style ="color: #007bff; padding-top:8px" class="fa-solid fa-unlock" trangthai = "'+row.trangthai+'" id = "trangthai_loai_'+data+'" onclick = change_TrangthaiLoai(event,' +data +')></i> &nbsp&nbsp';
                        }else{
                            html1 ='<i style ="color: #ffc107; padding-top:8px" class="fa-solid fa-lock" trangthai = "'+row.trangthai+'" id = "trangthai_loai_'+data+'" onclick = change_TrangthaiLoai(event,' +data +')></i> &nbsp&nbsp';
                        }
                        html ='<i style ="color: red; padding-top:8px"   class="fa-regular fa-trash-can" id = "dlt_loai'+data+'" onclick = dlt_Loai(event,' +data +")></i>";
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
function change_contenteditable(id){
    let arr_td = document.getElementsByClassName('td_datatable')
    // Duyệt qua tất cả các phần tử và xóa thuộc tính onblur
    for (let i = 0; i < arr_td.length; i++) {
        if($( arr_td[i]).attr('id') != 'loai_'+id){
            arr_td[i].removeAttribute('onblur');
        }else{
            arr_td[i].setAttribute('onblur', 'Upd_Loai(event, ' + id + ')');
        }
    }
}
async function Upd_Loai(event,id){
    event.preventDefault()
    let id_chucnang = 2;
    const check = await laythongtincheckquyen(id_chucnang);
    var upd_loai = $('#loai_'+id).text()
    $.ajax({
        type: 'POST',
        url:'Upd_Loai',
        data:{
            'id': id,
            'upd_loai':upd_loai,
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
            $("#danhsachloai").DataTable().ajax.reload(null, false);
        }
    })
}
async function change_TrangthaiLoai(event,id){
    event.preventDefault();
    $('#modal_event').show();
    let id_chucnang = 2;
    const check = await laythongtincheckquyen(id_chucnang);
    var trangthai = $('#trangthai_loai_'+id).attr('trangthai')

    $.ajax({
        type: "POST",
        url: "change_TrangthaiLoai",
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
                $("#danhsachloai").DataTable().ajax.reload(null, false);
                setTimeout(() => {
                    $('#modal_event').hide();
                }, 300);
            }
        }
    })

}
async function dlt_Loai(event,id){
    event.preventDefault();
    $('#modal_event').show();
    let id_chucnang = 4;
    const check = await laythongtincheckquyen(id_chucnang);
    $.ajax({
        type: "POST",
        url: "dlt_Loai/"+id,
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
                $("#danhsachloai").DataTable().ajax.reload(null, false);
                setTimeout(() => {
                    $('#modal_event').hide();
                }, 300);
            }
        }
    })
}
function clear_nhapsanpham(){
    clear_input_error()
    $("#loaimoi").val("")
    $("#maloai").val("")
}
