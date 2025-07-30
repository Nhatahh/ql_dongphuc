$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    load_index()
    $(window).resize(function() {
        equalizeHeight();
    });
});
async function load_dau(){
    return new Promise (function(resolve, reject){
        $("#qlsp_ds_nhasanxuat").select2()
        $("#qlsp_ds_loai").select2()
        $("#qlsp_ds_size").select2()
        load_dssanpham()
        qlsp_loadds()
        $('#qlspdssanpham_filter').hide();
        resolve(true)
    })
}
async function load_index(){
    await open_preloader();//Mở Preloader (main.js)
    await load_dau();
    await equalizeHeight(); //Cân bằng 2 block trái và phải (main.js)
    await close_preloader(); //Tắt Preloader (main.js)
}
// Load seclect box
function qlsp_loadds(){
    $.ajax({
        type: "get",
        url: "qlsp_loadds",
        dataType: "json",
        success: function (res) {
            $("#qlsp_ds_nhasanxuat").select2({data: res.ds_nhasanxuat});
            $("#qlsp_ds_loai").select2({data: res.ds_loai});
            $("#qlsp_ds_size").select2({data: res.ds_size});
        },
    });
}
// Load tabledata sản phẩm\
function load_dssanpham(){
    var table = $("#qlspdssanpham").DataTable({
        ajax: "load_dssanpham",
        columns: [
            {
                targets: 0,
                name: 'stt',
                width: "2%",
                title: "STT",
                data: "stt",
                className: "text-center align-middle",
            },
            {
                name: "loai",
                title: "<div class = 'title_datatables'>Loại sản phẩm</div><div class = 'div_datatables'><input id='qlspdssanpham_loai' onkeyup = search_datatables('qlspdssanpham_loai') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "loai",
                render: function (data, type, row) {
                    let html = '<span style = "display:none">'+data+'</span>'
                    html += '<select id = "slb_loai_'+row.id+'"  style = "width:100%;border:none;background-color: inherit;" onchange = "update_Sanpham(event,'+row.id+')">'
                    if (type === 'display') {
                        row.loaiSanpham.forEach(item => {
                            if(row.idloai == item.id){
                                html += '<option value = "'+item.id+'" selected = true>'+item.loaisanpham+'</option>'
                            }else{
                                html += '<option value = "'+item.id+'">'+item.loaisanpham+'</option>'
                            }
                        });
                         html += '</select>'
                    }
                    return html;
                },
                className: "align-middle",
            },
            {
                name: "nhasanxuat",
                title: "<div class = 'title_datatables'>Nhà sản xuất</div><div class = 'div_datatables'><input id='qlspdssanpham_nhasanxuat' onkeyup = search_datatables('qlspdssanpham_nhasanxuat') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "nhasanxuat",
                render: function (data, type, row) {
                    let html = '<span style = "display:none">'+data+'</span>'
                    html += '<select id = "slb_nhasanxuat_'+row.id+'" style = "width:100%;border:none;background-color: inherit;" onchange = "update_Sanpham(event,'+row.id+')">'
                    if (type === 'display') {
                        row.All_Nhasanxuat.forEach(item => {
                            if(row.id_nhasanxuat == item.id){
                                html += '<option value = "'+item.id+'" selected = true>'+item.nhasanxuat+'</option>'
                            }else{
                                html += '<option value = "'+item.id+'">'+item.nhasanxuat+'</option>'
                            }
                        });
                         html += '</select>'
                    }
                    return html;
                },
                className: "align-middle",
            },
            {
                name: "size",
                title: "<div class = 'title_datatables'>Size</div><div class = 'div_datatables'><input id='qlspdssanpham_size' onkeyup = search_datatables('qlspdssanpham_size') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "size",
                render: function (data, type, row) {
                    let html = '<span style = "display:none">'+data+'</span>'
                    html += '<select id="slb_size_' + row.id + '" style="width:100%;border:none;background-color: inherit;" onchange="update_Sanpham(event,' + row.id + ')">';
                    if (type === 'display') {
                        row.All_Size.forEach(item => {
                            if(row.id_size == item.id){
                                html += '<option value = "'+item.id+'" selected = true>'+item.size+'</option>'
                            }else{
                                html += '<option value = "'+item.id+'">'+item.size+'</option>'
                            }
                        });
                         html += '</select>'
                    }
                    return html;
                },
                className: "align-middle",
            },
            {
                name: "thongso",
                title: "<div class = 'title_datatables'>Thông số</div><div class = 'div_datatables'><input id='qlspdssanpham_thongso' onkeyup = search_datatables('qlspdssanpham_thongso') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "thongso",
                render: function(data, type, row){
                    let html = '<span style = "display:none">'+data+'</span>'
                    html += '<input id="txt_thongso_'+row.id+'" class = "edit_tabledata textarea_upd" value="'+data+'"  onchange = "update_Sanpham(event,'+row.id+')">'
                    return html
                },
                className: "align-middle",
            },
            {
                targets: 3,
                name: "trangthai",
                title: "<div class ='title_datatables'>Trạng thái</div><div class = 'div_datatables'> <select style = 'width:100%' class = 'select_datatables' id='qlspdssanpham_trangthai' onchange = search_datatables('qlspdssanpham_trangthai')><option  value =''></option><option value ='1'>Đang sử dụng</option><option value ='0'>Ngưng sử dụng</option></select></div>",
                data: "trangthai",
                className: "text-center align-middle",
                width: "10%",
                render: function (data, type, row) {
                    let trangthai = ""
                    return data == 1 ? trangthai = '<span class = "search_tmp">'+data+'</span><small class="badge badge-primary">Đang sử dụng</small>' : trangthai = '<span class = "search_tmp">'+data+'</span><small class="badge badge-warning">Ngưng sử dụng</small>'
                }
            },
            {
                title: "Chức năng",
                className: "text-center",
                data: "id",
                render: function (data, type, row) {
                    if (type === 'display') {
                        if(row.trangthai == 1){
                            html1 ='<i style ="color: #007bff; padding-top:8px" class="fa-solid fa-unlock" trangthai = "'+row.trangthai+'" id = "trangthai_SP_'+data+'" onclick = change_TrangthaiSP(event,' +data +')></i> &nbsp&nbsp';
                        }else{
                            html1 ='<i style ="color: #ffc107; padding-top:8px" class="fa-solid fa-lock" trangthai = "'+row.trangthai+'" id = "trangthai_SP_'+data+'" onclick = change_TrangthaiSP(event,' +data +')></i> &nbsp&nbsp';
                        }
                        html ='<i style ="color: red; padding-top:8px"   class="fa-regular fa-trash-can" id = "dlt_SP'+data+'" onclick = dlt_SP(event,' +data +")></i>";
                    }
                    return data = html1 + html;
                },
            },
        ],
        columnDefs: [
            // { targets: [0, 3, 4, 5, 6], className: "text-center" },
            // { targets: [1, 2], },
            // { targets: [0], searchable: true },
        ],
        scrollY: 450,
        language: {
            emptyTable: "Không tìm thấy sản phẩm",
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
        paging: true,
        lengthChange: false,
        searching: true,
        ordering: false,
        info: true,
        autoWidth: true,
        responsive: true,
        select: true,
    });
    return table
}
// Thêm sản phẩm
async function btt_themsanpham(event){
    event.preventDefault();
    $('#modal_event').show();
    let id_chucnang = 3;
    const check = await laythongtincheckquyen(id_chucnang);
    let id_nhasanxuat =  $("#qlsp_ds_nhasanxuat").val()
    let id_loai =  $("#qlsp_ds_loai").val()
    let id_size =   $("#qlsp_ds_size").val()
    let qlsp_thongso =  $("#qlsp_thongso").val()
    let elements = document.getElementsByClassName('error_validate');
    let error_validate = Array.from(elements).map(function(element) {
        return element.id;
    });
    $.ajax({
        type: "post",
        url: "themsanpham",
        data:{
            'id_nhasanxuat':id_nhasanxuat,
            'id_loai':id_loai,
            'id_size':id_size,
            'thongso':qlsp_thongso,
            //Check quyền
            'time': check[1],
            'id_manhinh': check[0],
            'id_chucnang': id_chucnang,
            'active': 1,
        },
        success: function (res) {
            if(['ins_1', 'newproduct_0', '-100','rol_2'].includes(res.trangthai) == true){
                for(let i = 0; i < error_validate.length; i++){
                    $('#'+error_validate[i]).text('')
                }
                $("#qlspdssanpham").DataTable().ajax.reload(null, false);
                thongbao(res.trangthai)
                $("#qlsp_thongso").val('')
                $("#qlsp_ds_nhasanxuat").val(0).trigger('change');
                $("#qlsp_ds_loai").val(0).trigger('change');
                $("#qlsp_ds_size").val(0).trigger('change');
            }else{
                validate_span_error(res, error_validate)
            }
            setTimeout(() => {
                $('#modal_event').hide();
            }, 300);
        },
    });
}
function clear_nhapsanpham(){
    let elements = document.getElementsByClassName('error_validate');
    let error_validate = Array.from(elements).map(function(element) {
        return element.id;
    });
    for(let i = 0; i < error_validate.length; i++){
        $('#'+error_validate[i]).text('')
    }
    $("#qlsp_thongso").val('')
    $("#qlsp_ds_nhasanxuat").val(0).trigger('change');
    $("#qlsp_ds_loai").val(0).trigger('change');
    $("#qlsp_ds_size").val(0).trigger('change');
}
async function change_TrangthaiSP(event,id){
    event.preventDefault();
    $('#modal_event').show();
    let id_chucnang = 2;
    const check = await laythongtincheckquyen(id_chucnang);
    var trangthai = $('#trangthai_SP_'+id).attr('trangthai')
    $.ajax({
        type: "POST",
        url: "change_TrangthaiSP",
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
                $("#qlspdssanpham").DataTable().ajax.reload(null, false);
                setTimeout(() => {
                    $('#modal_event').hide();
                }, 300);
            }
        }
    })
}
async function update_Sanpham(event,id){
    event.preventDefault();
    $('#modal_event').show();
    let id_chucnang = 2;
    const check = await laythongtincheckquyen(id_chucnang);
    var idloai_upd = $('#slb_loai_'+id).val()
    var idsize_upd = $('#slb_size_'+id).val()
    var idnhasanxuat_upd = $('#slb_nhasanxuat_'+id).val()
    var thongso_upd = $('#txt_thongso_'+id).val()
    $.ajax({
        type:"POST",
        url: "update_Sanpham",
        data:{
            'id': id,
            'idloai_upd': idloai_upd,
            'idsize_upd': idsize_upd,
            'idnhasanxuat_upd': idnhasanxuat_upd,
            'thongso_upd': thongso_upd,
            //Check quyền
            'time': check[1],
            'id_manhinh': check[0],
            'id_chucnang': id_chucnang,
            'active': 1,
        },
        success: function(res){
            if(['upd_1', 'upd_0', 'prod_2','prod_0', '-100','rol_2'].includes(res.trangthai) == true){
                thongbao(res.trangthai)
            }else{
                thongbao_error(res)
            }
            $("#qlspdssanpham").DataTable().ajax.reload(null, false);
            setTimeout(() => {
                $('#modal_event').hide();
            }, 300);
        }
    })
}
async function dlt_SP(event,id){
    event.preventDefault();
    $('#modal_event').show();
    let id_chucnang = 4;
    const check = await laythongtincheckquyen(id_chucnang);
    $.ajax({
        type: "POST",
        url: "dlt_SP/"+id,
        data: {
            //Check quyền
            'time': check[1],
            'id_manhinh': check[0],
            'id_chucnang': id_chucnang,
            'active': 1,
        },
        success: function(res){
            if(['del_1', 'del_0', 'prod_1','prod_0', '-100'].includes(res) == true){
                thongbao(res)
                $("#qlspdssanpham").DataTable().ajax.reload(null, false);
                setTimeout(() => {
                    $('#modal_event').hide();
                }, 300);
            }
        }
    })
}
