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
        // load_dssanpham()
        table.ajax.url("load_dssanpham").load();
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
function adjustView() {
    var ql_sanpham_Mobile = document.getElementsByClassName('ql_sanpham_mobile');
    var ql_sanpham_Desktop = document.getElementsByClassName('ql_sanpham_desktop');
    if (window.innerWidth <= 1000) {
        for (var i = 0; i < ql_sanpham_Mobile.length; i++) {
            ql_sanpham_Mobile[i].style.display = 'block';
        }
        for (var i = 0; i < ql_sanpham_Desktop.length; i++) {
            ql_sanpham_Desktop[i].style.display = 'none';
        }
    } else {
        for (var i = 0; i < ql_sanpham_Desktop.length; i++) {
            ql_sanpham_Desktop[i].style.display = 'block';
        }
        for (var i = 0; i < ql_sanpham_Mobile.length; i++) {
            ql_sanpham_Mobile[i].style.display = 'none';
        }
    }
}
document.addEventListener('DOMContentLoaded', adjustView);
window.addEventListener('resize', adjustView);
// Load seclect box
function qlsp_loadds(){
    $.ajax({
        type: "get",
        url: "qlsp_loadds",
        dataType: "json",
        success: function (res) {
            $("#id_nhasanxuat").select2({
                data: res.ds_nhasanxuat,
                templateResult: formatState,
                templateSelection: formatStateSelection
            });
            $("#id_loai").select2({
                data: res.ds_loai,
                templateResult: formatState,
                templateSelection: formatStateSelection
            });
            $("#id_size").select2({
                data: res.ds_size,
                templateResult: formatState,
                templateSelection: formatStateSelection
            });
        },
    });
}
function formatState(state) {
    if (!state.id) {
        return state.text;
    }
    var $state = $('<span>' + state.text + '</span>');
    return $state;
}

function formatStateSelection(state) {
    if (!state.text) {
        return state.text;
    }
    return state.text;
}





// Load tabledata sản phẩm\
// function load_dssanpham(){
    var table = $("#qlspdssanpham").DataTable({
        ajax: "load_dssanpham",
        columns: [
            {
                targets: 0,
                className: 'dt-control remove_click',
                orderable: false,
                data: null,
                defaultContent: ''
            },
            {
                targets: 1,
                name: 'stt',
                width: "2%",
                title: "STT",
                data: "stt",
                className: "text-center align-middle",
            },
            {
                targets: 2,
                name: "masp",
                width: "15%",
                title: "<div class = 'title_datatables'>Mã SP</div><div class = 'div_datatables'><input id='qlspdssanpham_masp' onkeyup = search_datatables('qlspdssanpham_masp') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "masp",
                render: function(data, type, row){
                    let html = '<span style = "display:none">'+data+'</span>'
                    html += '<input disabled id="txt_masp_'+row.id+'_desktop" class = "edit_tabledata textarea_upd" value="'+data+'">'
                    return html
                },
                className: "align-middle",
            },
            {
                targets: 3,
                name: "loai",
                title: "<div class = 'title_datatables'>Loại sản phẩm</div><div class = 'div_datatables'><input id='qlspdssanpham_loai' onkeyup = search_datatables('qlspdssanpham_loai') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "loai",
                render: function (data, type, row) {
                    let html = '<span style = "display:none">'+data+'</span>'
                    html += '<select id = "slb_loai_'+row.id+'_desktop"  style = "width:100%;border:none;background-color: inherit;" onchange = "update_Sanpham(event,'+row.id+')">'
                    if (type === 'display') {
                        row.loaiSanpham.forEach(item => {
                            if(row.idloai == item.id){
                                html += '<option value = "'+item.id+'" code = "'+item.code+'"  selected = true>'+item.loaisanpham+'</option>'
                            }else{
                                html += '<option value = "'+item.id+'" code = "'+item.code+'">'+item.loaisanpham+'</option>'
                            }
                        });
                         html += '</select>'
                    }
                    return html;
                },
                className: "align-middle",
            },
            {
                targets: 4,
                name: "nhasanxuat",
                title: "<div class = 'title_datatables'>Nhà sản xuất</div><div class = 'div_datatables'><input id='qlspdssanpham_nhasanxuat' onkeyup = search_datatables('qlspdssanpham_nhasanxuat') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "nhasanxuat",
                render: function (data, type, row) {
                    let html = '<span style = "display:none">'+data+'</span>'
                    html += '<select id = "slb_nhasanxuat_'+row.id+'_desktop" style = "width:100%;border:none;background-color: inherit;" onchange = "update_Sanpham(event,'+row.id+')">'
                    if (type === 'display') {
                        row.All_Nhasanxuat.forEach(item => {
                            if(row.id_nhasanxuat == item.id){
                                html += '<option value = "'+item.id+'" code = "'+item.code+'" selected = true>'+item.nhasanxuat+'</option>'
                            }else{
                                html += '<option value = "'+item.id+'" code = "'+item.code+'">'+item.nhasanxuat+'</option>'
                            }
                        });
                         html += '</select>'
                    }
                    return html;
                },
                className: "align-middle",
            },
            {
                targets: 5,
                name: "size",
                title: "<div class = 'title_datatables'>Size</div><div class = 'div_datatables'><input id='qlspdssanpham_size' onkeyup = search_datatables('qlspdssanpham_size') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "size",
                render: function (data, type, row) {
                    let html = '<span style = "display:none">'+data+'</span>'
                    html += '<select id="slb_size_' + row.id + '_desktop" style="width:100%;border:none;background-color: inherit;" onchange="update_Sanpham(event,' + row.id + ')">';
                    if (type === 'display') {
                        row.All_Size.forEach(item => {
                            if(row.id_size == item.id){
                                html += '<option value = "'+item.id+'" code = "'+item.code+'" selected = true>'+item.size+'</option>'
                            }else{
                                html += '<option value = "'+item.id+'" code = "'+item.code+'">'+item.size+'</option>'
                            }
                        });
                         html += '</select>'
                    }
                    return html;
                },
                className: "align-middle",
            },
            // {
            //     name: "thongso",
            //     title: "<div class = 'title_datatables'>Thông số</div><div class = 'div_datatables'><input id='qlspdssanpham_thongso' onkeyup = search_datatables('qlspdssanpham_thongso') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
            //     data: "thongso",
            //     render: function(data, type, row){
            //         let html = '<span style = "display:none">'+data+'</span>'
            //         html += '<input id="txt_thongso_'+row.id+'" class = "edit_tabledata textarea_upd" value="'+data+'"  onchange = "update_Sanpham(event,'+row.id+')">'
            //         return html
            //     },
            //     className: "align-middle",
            // },
            {
                targets: 6,
                name: "trangthai",
                width: "10%",
                title: "<div class ='title_datatables'>Trạng thái</div><div class = 'div_datatables'> <select style = 'width:100%' class = 'select_datatables' id='qlspdssanpham_trangthai' onchange = search_datatables('qlspdssanpham_trangthai')><option  value =''></option><option value ='1'>Đang sử dụng</option><option value ='0'>Ngưng sử dụng</option></select></div>",
                data: "trangthai",
                className: "text-center align-middle",
                render: function (data, type, row) {
                    let trangthai = ""
                    return data == 1 ? trangthai = '<span class = "search_tmp">'+data+'</span><small class="badge badge-primary">Đang sử dụng</small>' : trangthai = '<span class = "search_tmp">'+data+'</span><small class="badge badge-warning">Ngưng sử dụng</small>'
                }
            },
            // {
            //     targets: 3,
            //     name: "qrcode",
            //     title: "QRCODE",
            //     data: "qrcode",
            //     className: "text-center align-middle",
            //     width: "10%",
            //     render: function (data, type, row) {
            //         let html = "";
            //         // Sử dụng data trực tiếp để tạo chuỗi base64 cho ảnh
            //         html = "<img src='data:image/png;base64," + data + "' alt='QR Code' style='width: 100%; height: auto;' />"; // Thêm style nếu cần thiết
            //         return html;
            //     }
            // },
            {
                targets: 6,
                title: "Chức năng",
                className: "text-center align-middle",
                width: "10%",
                data: "id",
                render: function (data, type, row) {
                    if (type === 'display') {
                        if(row.trangthai == 1){
                            html1 ='<i style ="color: #007bff; padding-top:8px" class="fa-solid fa-unlock" trangthai = "'+row.trangthai+'" id = "trangthai_SP_'+data+'_desktop" onclick = change_TrangthaiSP(event,' +data +')></i> &nbsp&nbsp';
                        }else{
                            html1 ='<i style ="color: #ffc107; padding-top:8px" class="fa-solid fa-lock" trangthai = "'+row.trangthai+'" id = "trangthai_SP_'+data+'_desktop" onclick = change_TrangthaiSP(event,' +data +')></i> &nbsp&nbsp';
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
        scrollY: 400,
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
        autoWidth: false,
        responsive: true,
        select: true,
    });
    // return table
// }
function format(d) {
    return (
        '<div class = "card card-body" style = "margin: 0rem 0.4rem  0.4rem 0.4rem">' +
            '<div class = "row">' +

                '<div style="text-align:center;" class="col-3 col-md-3">' +
                    '<span>' +
                        "<img class = 'img_sanpham' id = 'img_sanpham"+d.id+"' src='" + (d.anhsanpham ? d.anhsanpham : 'https://placehold.co/150x200?text=%E1%BA%A2nh%20s%E1%BA%A3n%20ph%E1%BA%A9m\n(150x200)') + "' alt='Ảnh sản phẩm'  />" +
                    '</span><br>' +
                    '<div class = "" style ="width: 100%; text-align: -webkit-center;">' +
                        // '<button style="width: 150px;" type="button" id="" onclick="update_anhsanpham(event,'+d.id+')" class="btn btn-block btn-xs btt_lammoi load-index">' +
                        //     '<div class="load-index-children"></div>' +
                        //     '<i class="fa-solid fa-upload"></i>&nbsp;&nbsp;&nbsp;Cập nhật' +
                        // '</button>' +
                        // '<label style = "height: 28px" for="file_anhsp_update_desktop'+d.id+'" class="custom-file-label">Cập nhật</label>'+
                        // '<input type="file" onchange = "crop_imgsp_update(event,'+d.id+')" class = "custom-file-input file_anhsp_update" id="file_anhsp_update_desktop'+d.id+'" accept="image/*" style = "height: 28px">'+

                            // '<input type="file" class="custom-file-input" accept="image/*" id="file_anhsp_update_desktop'+d.id+'"  onchange = "crop_imgsp_update(event,'+d.id+')">'+
                            // '<label class="custom-file-label" id="" for="file_anhsp_update_desktop'+d.id+'" style="display: inline-block; height: 28px; margin-left: 7px; border-radius: 5px; text-align: left; padding-left: 10px;">Cận nhật</label>'+
                            '<input type="file" class="" accept="image/*" id="file_anhsp_update_desktop'+d.id+'" onchange="crop_imgsp_update(event,'+d.id+')" style="display: none;">'+
                            '<label class="input_capnhat_Anhsp" for="file_anhsp_update_desktop'+d.id+'"> Cập nhật</label>'+

                    '</div>' +
                '</div>'+
                '<div class = "col-9 col-md-6">' +
                    // '<strong>Mã SP:</strong>&nbsp;&nbsp;' +'<span>' +d.masp+ '</span><br>' +
                    '<strong>Thông số:</strong>&nbsp;&nbsp;' +'<span><input id = "txt_thongso_'+d.id+'_desktop" onchange= "update_Sanpham_etc(event,'+d.id+')" class = "edit_tabledata" style = "width:80%" value =" '+d.thongso+ '"></span><br>' +
                    '<strong>Ghi chú:</strong>&nbsp;&nbsp;' +'<span><input id = "txt_ghichu_'+d.id+'_desktop" onchange= "update_Sanpham_etc(event,'+d.id+')" class = "edit_tabledata" style = "width:80%" value = "'+d.ghichu+ '"></span><br>' +
                    '<strong>Người tạo:</strong>&nbsp;&nbsp;' +'<span>' +d.dienthoai+ '</span><br>' +
                    '<strong>Ngày tạo:</strong>&nbsp;&nbsp;' +'<span>' +d.create_at+ '</span><br>' +
                '</div>'+
               '<div style="text-align:center;" class="col-3 col-md-3">' +

                    '<span>' +
                        "<img id='img_Qrcode_" + d.id + "' src='data:image/png;base64," + d.qrcode + "' alt='QR Code' style='width: 200px; height: 200px; vertical-align: middle; margin-bottom: 5px;' />" +
                    '</span><br>' +
                    '<div style="flex-grow: 1;"></div>' +
                    '<div style="display: flex; justify-content: center;">' +
                        '<button style="width: 95%; text-align:center;" type="button" id="" onclick="modal_Down_Qrcode(event,' + d.id + ')" class="btn btn-block btn-primary btn-xs load-index">' +
                            '<div class="load-index-children"></div>' +
                            '<i class="fa-solid fa-print"></i>&nbsp;&nbsp;&nbsp;Tải QR' +
                        '</button>' +
                    '</div>' +
                '</div>' +
                // '<div style="text-align: right; position: relative; min-height: 20px;" class="col-3 col-md-3">' +

                // '</div>'+
            '</div>'+
        '</div>'
    );
}
var crop_anhsp_update = ''
$('#qlspdssanpham tbody').on('click', 'td.dt-control', function(e) {
    let tr = e.target.closest('tr');
    let row = table.row(tr);
    if (row.child.isShown()) {
        row.child.hide();
    }
    else {
        row.child(format(row.data())).show();
    }
});
// chuyển ảnh từ input thành chuỗi base64
function getBase64(file) {
    return new Promise((resolve, reject) => {
        let reader = new FileReader();
        reader.onloadend = () => resolve(reader.result);
        reader.onerror = error => reject(error);
        reader.readAsDataURL(file);
    });
}
// $('#file_anhsp_input').on('change', function() {
//     // Lấy tên file đã chọn
//     var fileName = $(this).prop('files')[0].name;
//     // Cập nhật tên file trong nhãn
//     $('#file_anhsp').text(fileName);
// });
function reload_livewire(){
    return new Promise (function(resolve, reject){
        Livewire.emit('reloadComponent')
        Livewire.on('componentReloaded', function() {
            resolve(true);
        });
    })
}
// Thêm sản phẩm
async function btt_themsanpham(event){
    event.preventDefault();
    $('#modal_event').show();
    let id_chucnang = 3;
    const check = await laythongtincheckquyen(id_chucnang);
    var selectedDataNSX = $('#id_nhasanxuat').select2('data')[0];
    var selectedDataLoai = $('#id_loai').select2('data')[0];
    var selectedDataSize = $('#id_size').select2('data')[0];

    let id_nhasanxuat =  selectedDataNSX.id
    let id_loai =  selectedDataLoai.id
    let id_size =  selectedDataSize.id

    let ma_nhasanxuat = selectedDataNSX.code
    let ma_loai = selectedDataLoai.code
    let ma_size = selectedDataSize.code

    // let file_anhsp = $('#file_anhsp_input').prop('files')[0];
    // let base64Image = '';
    // Kiểm tra loại tệp
    // if (file_anhsp && !file_anhsp.type.startsWith('image/')) {
    //     $('#file_anhsp_input').val(''); // Xóa tệp nếu không phải là ảnh
    //     $('#modal_event').hide();
    //     return toastr.warning('Vui lòng chọn tệp hình ảnh (jpg, jpeg, png, gif, ...)')
    // }
    // if (file_anhsp) {
    //     base64Image = await getBase64(file_anhsp); // Chờ lấy chuỗi base64
    // }
    let qlsp_thongso =  $("#thongso").val()
    // let qlsp_masp =  $("#ma_sp").val()
    let qlsp_ghichu =  $("#qlsp_ghichu").val()
    let elements = document.getElementsByClassName('error_validate');
    // let error_validate = Array.from(elements).map(function(element) {
    //     return element.id;
    // });

    $.ajax({
        type: "post",
        url: "themsanpham",
        data:{
            'id_nhasanxuat':id_nhasanxuat,
            'id_loai':id_loai,
            'id_size':id_size,

            'ma_nhasanxuat':ma_nhasanxuat,
            'ma_loai':ma_loai,
            'ma_size':ma_size,

            'file_anhsp':base64Image_crop,


            'thongso':qlsp_thongso,
            // 'ma_sp':qlsp_masp,
            'ghichu':qlsp_ghichu,
            //Check quyền
            'time': check[1],
            'id_manhinh': check[0],
            'id_chucnang': id_chucnang,
            'active': 1,
        },
        success:async function (res) {
            if(['ins_1','rol_2'].includes(res.trangthai) == true){
                // $("#qlspdssanpham").DataTable().ajax.reload(null, false);
                await reload_datatable()
                await reload_livewire()
                clear_nhapsanpham()
                thongbao(res.trangthai)
                // Livewire.emit('reloadComponent')
                setTimeout(() => {
                    $('#modal_event').hide();
                }, 300);
            }else if (['ins_0', '-100','rol_2',"newproduct_0"].includes(res.trangthai) == true){
               thongbao(res.trangthai)
               clear_input_error()
               setTimeout(() => {
                $('#modal_event').hide();
            }, 300);
            }
            else{
                await input_error(res)
                // await select_error(res,[0,1,2])
                setTimeout(() => {
                    $('#modal_event').hide();
                }, 300);
            }

        },
    });
}
function clear_nhapsanpham(){
    clear_input_values()
    clear_input_error()
    $('#file_anhsp').text('')
    $('#file_anhsp_input').prop('value', "");
    base64Image_crop = ''

}
async function change_TrangthaiSP(event,id){
    event.preventDefault();
    $('#modal_event').show();
    let id_chucnang = 2;
    let screen = ''
    const check = await laythongtincheckquyen(id_chucnang);
    if (window.innerWidth <= 1000) {
        screen = '_mobile'
        var trangthai = $('#trangthai_SP_'+id+screen).val() == 1 ? 0 : 1
    } else {
        screen = '_desktop'
        var trangthai = $('#trangthai_SP_'+id+screen).attr('trangthai')
    }

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
        success: async function(res){
            if(['upd_1', 'upd_0', '-100','rol_2'].includes(res.trangthai) == true){
                await reload_datatable()
                await reload_livewire()
                // $("#qlspdssanpham").DataTable().ajax.reload(null, false);
                // Livewire.emit('reloadComponent')
                thongbao(res.trangthai)
                setTimeout(() => {
                    $('#modal_event').hide();
                }, 300);
            }
        }
    })

}
function reload_datatable(){
    return new Promise(function(resolve, reject){
        $("#qlspdssanpham").DataTable().ajax.reload(function(){
            resolve(true); // Chỉ trả về true sau khi reload xong
        }, false);
    });
}
async function update_Sanpham(event,id){
    event.preventDefault();
    $('#modal_event').show();
    let id_chucnang = 2;
    let screen = ''
    const check = await laythongtincheckquyen(id_chucnang);
    if (window.innerWidth <= 1000) {
        screen = '_mobile'
    } else {
        screen = '_desktop'
    }
    var idloai_upd = $('#slb_loai_'+id+screen).val()
    var idsize_upd = $('#slb_size_'+id+screen).val()
    var idnhasanxuat_upd = $('#slb_nhasanxuat_'+id+screen).val()

    var ma_loai_up = $('#slb_loai_'+id+screen).find(':selected').attr('code')
    var ma_size_up = $('#slb_size_'+id+screen).find(':selected').attr('code')
    var ma_nhasanxuat_up = $('#slb_nhasanxuat_'+id+screen).find(':selected').attr('code')
    $.ajax({
        type:"POST",
        url: "update_Sanpham",
        data:{
            'id': id,
            'idloai_upd': idloai_upd,
            'idsize_upd': idsize_upd,
            'idnhasanxuat_upd': idnhasanxuat_upd,

            'ma_loai_up': ma_loai_up,
            'ma_size_up': ma_size_up,
            'ma_nhasanxuat_up': ma_nhasanxuat_up,


            // 'masp_upd': masp_upd,
            //Check quyền
            'time': check[1],
            'id_manhinh': check[0],
            'id_chucnang': id_chucnang,
            'active': 1,
        },
        success: async function(res){
            await reload_datatable()
            if(['upd_1', 'upd_0', 'prod_2','prod_0', '-100','rol_2'].includes(res.trangthai) == true){
                // Livewire.emit('reloadComponent')
                await reload_livewire()
                thongbao(res.trangthai)

            }else{
                thongbao_error(res)
            }
            // $("#qlspdssanpham").DataTable().ajax.reload(null, false);
            setTimeout(() => {
                $('#modal_event').hide();
            }, 300);
        }
    })
}

async function update_Sanpham_etc(event,id){
    event.preventDefault()
    $('#modal_event').show()
    let id_chucnang = 2
    let screen = ''
    const check = await laythongtincheckquyen(id_chucnang)
    if (window.innerWidth <= 1000) {
        screen = '_mobile'
    } else {
        screen = '_desktop'
    }
    var thongso_upd = $('#txt_thongso_' + id + screen).val()
    var ghichu_upd = $('#txt_ghichu_'+id + screen).val()
    $.ajax({
        type:"POST",
        url: "update_Sanpham_etc",
        data:{
            'id': id,
            'ghichu_upd': ghichu_upd,
            'thongso_upd': thongso_upd,
            //Check quyền
            'time': check[1],
            'id_manhinh': check[0],
            'id_chucnang': id_chucnang,
            'active': 1,
        },
        success: async function(res){
            await reload_datatable()
            if(['upd_1', 'upd_0', 'prod_2','prod_0', '-100','rol_2'].includes(res.trangthai) == true){
                // Livewire.emit('reloadComponent')
                await reload_livewire()
                thongbao(res.trangthai)
            }else{
                thongbao_error(res)
            }
            // $("#qlspdssanpham").DataTable().ajax.reload(null, false);
            setTimeout(() => {
                $('#modal_event').hide();
            }, 300);
        }
    })
}
// async function update_anhsanpham(event,id){
//     event.preventDefault()
//     let id_chucnang = 2
//     const check = await laythongtincheckquyen(id_chucnang)
//     let screen = ''
//     if (window.innerWidth <= 1000) {
//         screen = '_mobile'
//     } else {
//         screen = '_desktop'
//     }
//     $('#file_anhsp_update'+screen+id).click();

//     $('#file_anhsp_update'+screen+id).off('change').on('change',async function() {
//         let id_input = 'file_anhsp_update'+screen+id
//         const Crop_anh = await Crop_Anhsanpham(id_input)
//         $('#cropButton').attr('isset', 2)
//         $('#cropButton').attr('id_sanpham', id)
//     });
// }

async function crop_imgsp_update(evnet, id){
    if (window.innerWidth <= 1000) {
        screen = '_mobile'
    } else {
        screen = '_desktop'
    }
    let id_input = 'file_anhsp_update'+screen+id
    const Crop_anh = await Crop_Anhsanpham(id_input)
    $('#cropButton').attr('isset', 2)
    $('#cropButton').attr('id_sanpham', id)
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
        success: async function(res){
            if(['del_1', 'del_0', 'prod_1','prod_0', '-100', 'rol_2'].includes(res) == true){
                // Livewire.emit('reloadComponent')
                await reload_datatable()
                await reload_livewire()
                thongbao(res)
                // $("#qlspdssanpham").DataTable().ajax.reload(null, false);
                setTimeout(() => {
                    $('#modal_event').hide();
                }, 300);
            }
        }
    })
}


async function show_modal_edit_sanpham(event, id){
    $('#modal_edit_sanpham').show('slow')
    event.preventDefault();
    // $('#modal_event').show();
    let id_chucnang = 2;
    const check = await laythongtincheckquyen(id_chucnang);
    $.ajax({
        type: "GET",
        url: "btn_edit_sanpham",
        data:{
            'id': id,
            //Check quyền
            'time': check[1],
            'id_manhinh': check[0],
            'id_chucnang': id_chucnang,
            'active': 1,
        },
        success: function(res){
                let htmlString = `
                <div class="col-md-12 col-12">

                    <div class="col-md-12 col-12">
                        <div class="form-group row" style="margin-bottom: 12px">
                            <label for="trangthai_SP_`+res[0].id+`_mobile" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight: bold;">Trạng thái:</label>
                            <div class="col-sm-8 load-index">
                                <select class="form-control" trangthai = "`+res[0].trangthai+`" onchange = change_TrangthaiSP(event,`+res[0].id+`) id="trangthai_SP_`+res[0].id+`_mobile" style="width: 100%;">`
                                    if (res[0].trangthai == 1) {
                                        htmlString += `<option value="1" selected="true">Đang sử dụng</option>`;
                                        htmlString += `<option value="0">Ngưng sử dụng</option>`;
                                    } else {
                                        htmlString += `<option value="1" >Đang sử dụng</option>`;
                                        htmlString += `<option value="0" selected="true">Ngưng sử dụng</option>`;
                                    }
                    htmlString += `
                                </select>
                                <span class="text_error_select error_validate" id='error_slb_nsx_`+res[0].id+`_mobile'></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="form-group row" style="margin-bottom: 12px">
                            <label for="slb_loai_`+res[0].id+`_mobile" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight: bold;">Loại SP:</label>
                            <div class="col-sm-8 load-index">
                                <select class="form-control" onchange = "update_Sanpham(event,`+res[0].id+`)" id="slb_loai_`+res[0].id+`_mobile" style="width: 100%;">`;

                                    res[0].loaiSanpham.forEach(item => {
                                        if (res[0].id_loai == item.id) {
                                            htmlString += `<option value="`+item.id+`" code = "`+item.code+`" selected="true">`+item.loaisanpham+`</option>`;
                                        } else {
                                            htmlString += `<option value="`+item.id+`" code = "`+item.code+`">`+item.loaisanpham+`</option>`;
                                        }
                                    });
                    htmlString += `
                                </select>
                                <span class="text_error_select error_validate" id='error_slb_loai_`+res.id+`_mobile'></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="form-group row" style="margin-bottom: 12px">
                            <label for="slb_nhasanxuat_`+res[0].id+`_mobile" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight: bold;">Nhà SX:</label>
                            <div class="col-sm-8 load-index">
                                <select class="form-control" onchange = "update_Sanpham(event,`+res[0].id+`)" id="slb_nhasanxuat_`+res[0].id+`_mobile" style="width: 100%;">`
                                    res[0].All_Nhasanxuat.forEach(item => {
                                        if (res[0].id_nhasanxuat == item.id) {
                                            htmlString += `<option value="`+item.id+`" code = "`+item.code+`" selected="true">`+item.nhasanxuat+`</option>`;
                                        } else {
                                            htmlString += `<option value="`+item.id+`" code = "`+item.code+`">`+item.nhasanxuat+`</option>`;
                                        }
                                    });

                    htmlString += `
                                </select>
                                <span class="text_error_select error_validate" id='error_slb_nhasanxuat_`+res[0].id+`_mobile'></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="form-group row" style="margin-bottom: 12px">
                            <label for="slb_size_`+res[0].id+`_mobile" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight: bold;">Size:</label>
                            <div class="col-sm-8 load-index">
                                <select class="form-control" onchange = "update_Sanpham(event,`+res[0].id+`)" id="slb_size_`+res[0].id+`_mobile" style="width: 100%;">`
                                    res[0].All_Size.forEach(item => {
                                        if (res[0].id_size == item.id) {
                                            htmlString += `<option value="`+item.id+`" code = "`+item.code+`" selected="true">`+item.size+`</option>`;
                                        } else {
                                            htmlString += `<option value="`+item.id+`" code = "`+item.code+`">`+item.size+`</option>`;
                                        }
                                    });
                    htmlString += `
                                </select>
                                <span class="text_error_select error_validate" id='error_id_size'></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="form-group row" style="margin-bottom: 12px">
                            <label for="" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight: bold;">Thông số:</label>
                            <div class="col-sm-8 load-index">
                                <textarea rows="5" class="form-control" name="" onchange= "update_Sanpham_etc(event,`+res[0].id+`)" id="txt_thongso_`+res[0].id+`_mobile">`+res[0].thongso+`</textarea>
                                <span class="text_error_input error_validate" id='error_thongso'></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="form-group row" style="margin-bottom: 12px">
                            <label for="" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight: bold;">Ghi chú:</label>
                            <div class="col-sm-8 load-index">
                                <textarea rows="5" class="form-control" name="" onchange= "update_Sanpham_etc(event,`+res[0].id+`)" id="txt_ghichu_`+res[0].id+`_mobile">`+res[0].ghichu+`</textarea>
                                <span class="text_error_input error_validate" id='error_ghichu'></span>
                            </div>
                        </div>
                    </div>
            </div>`;

                $('#form_edit_sanpham').html(htmlString);
        }
    })

}
function btt_hide_modal_edit_sanpham(){
    $('#modal_edit_sanpham').hide('slow')

}

function Down_Qrcode(event, id_sanpham) {
    // Lấy tên sản phẩm và QR code
    var name = $('#Masp_modal' + id_sanpham).text();
    var src = $('#img_Qrcode_modal' + id_sanpham).attr('src');

    // Định dạng thời gian
    var currentDate = new Date();
    var formattedDate = currentDate.getFullYear() +
        ('0' + (currentDate.getMonth() + 1)).slice(-2) +
        ('0' + currentDate.getDate()).slice(-2) +
        '_' +
        ('0' + currentDate.getHours()).slice(-2) +
        ('0' + currentDate.getMinutes()).slice(-2) +
        ('0' + currentDate.getSeconds()).slice(-2);

    // Tạo tên file với thời gian
    var fileName = name + '_' + formattedDate + '.png';

    // Tạo canvas
    var canvas = document.createElement('canvas');
    var context = canvas.getContext('2d');

    // Kích thước canvas, bao gồm nền trắng bao quanh
    canvas.width = 340; // Độ rộng bao gồm padding
    canvas.height = 400; // Độ cao bao gồm QR code, mã sản phẩm và padding

    // Vẽ nền trắng bao quanh
    context.fillStyle = 'white';
    context.fillRect(0, 0, canvas.width, canvas.height);

    // Tạo một đối tượng ảnh để tải QR code
    var qrImage = new Image();
    qrImage.src = src;

    qrImage.onload = function() {
        // Vẽ QR code với padding
        context.drawImage(qrImage, 20, 20, 300, 300); // Căn giữa với padding 20px

        // Thêm mã sản phẩm dưới QR code
        context.font = '20px Arial';
        context.fillStyle = 'black';
        context.textAlign = 'center';
        context.fillText(name, canvas.width / 2, 370);

        // Chuyển canvas thành ảnh và tải xuống
        const link = document.createElement('a');
        link.href = canvas.toDataURL('image/png');
        link.download = fileName;
        link.click();
    };
}
function print_QRCode(id_sanpham) {
    if($('#copies_QR').attr('id_QR') == id_sanpham){
        let copies = $('#copies_QR').val()
        if(copies > 0){
            printVariableSizeQRCode(id_sanpham ,copies)
        }else{
            return  toastr.warning('Vui lòng nhập số lượng cần in!')
        }
    }else{
        return toastr.error('Lỗi hệ thông, vui lòng liên hệ admin!')
    }

}
function printVariableSizeQRCode(id_sanpham, copies) {
    var name = $('#Masp_modal' + id_sanpham).text();
    var src = $('#img_Qrcode_modal' + id_sanpham).attr('src');
    var canvas = document.createElement('canvas');
    var context = canvas.getContext('2d');
    canvas.width = 400;
    canvas.height = 450; // Tăng chiều cao để có thêm khoảng trống cho văn bản bên dưới
    context.fillStyle = 'white';
    context.fillRect(0, 0, canvas.width, canvas.height);

    var qrImage = new Image();
    qrImage.src = src;
    qrImage.onload = function() {
        context.drawImage(qrImage, 50, 20, 300, 300); // Căn chỉnh QR code ở giữa và chừa khoảng trống dưới
        context.font = '20px Arial';
        context.fillStyle = 'black';
        context.textAlign = 'center';
        context.fillText(name, canvas.width / 2, 380); // Đặt văn bản bên dưới QR code ở vị trí phù hợp

        var qrCodeDataURL = canvas.toDataURL('image/png');

        var columns;
        var qrSize;

        if (copies <= 3) {
            columns = copies;
            qrSize = 400;
        } else if (copies <= 10) {
            columns = 3;
            qrSize = 180;
        } else {
            columns = 5;
            qrSize = Math.min(150, 600 / columns);
        }

        var rows = Math.ceil(copies / columns);

        var printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Print QR Codes</title>
                    <style>
                        @page { size: A4; margin: 10mm; }
                        body {
                            display: grid;
                            grid-template-columns: repeat(${columns}, auto);
                            gap: 10px;
                            justify-content: center;
                            align-items: start;
                            padding: 10px;
                            font-family: Arial, sans-serif;
                        }
                        .qr-container {
                            width: ${qrSize}px;
                            height: ${qrSize + 50}px;
                            text-align: center;
                        }
                        .qr-container img {
                            width: ${qrSize}px;
                            height: ${qrSize}px;
                        }
                    </style>
                </head>
                <body>
        `);

        for (let i = 0; i < copies; i++) {
            printWindow.document.write(`
                <div class="qr-container">
                    <img src="${qrCodeDataURL}" />
                </div>
            `);
        }

        printWindow.document.write(`
                </body>
            </html>
        `);

        printWindow.document.close();
        printWindow.onload = function() {
            printWindow.print();
            printWindow.close();
        };
    };
}
function modal_Down_Qrcode(event, id_sanpham){
    if (window.innerWidth > 1000) {
        $('#container_btn_downQR').addClass('tyle_model_QR');
    }
    $('#modal_down_qrcode').show('slow')
    $.ajax({
        type: "GET",
        url: "data_QRcode/"+id_sanpham,
        data: {
          'id':id_sanpham
        },
        success: function(res){
            var stringHtml = `<div class="right" id = "imgQR_modal">
                                <img class = 'img_QRcode_down' id = "img_Qrcode_modal`+id_sanpham+`" src='data:image/png;base64,`+res.qrcode+`'
                                alt='QR Code' />
                                <div id = "Masp_modal`+res.id+`" style = "font-weight:bold"> Mã SP: `+res.masp+` </div>
                            </div>`
            $('#imgQR_modal').html(stringHtml)
            $('#downQR').attr('onclick', "Down_Qrcode(event,"+res.id+")");
            $('#printQR').attr('onclick', "print_QRCode("+res.id+")");
            $('#copies_QR').attr('id_qr', res.id)

        }
    })
}
function btt_hide_modal_down_qrcode(){
    $('#modal_down_qrcode').hide('slow')
}
function Crop_Anhsanpham(inpit_id) {
    return new Promise(function(resolve, reject) {
        const fileInput = $('#' + inpit_id);
        const file = fileInput.prop('files')[0];

        if (!file) {
            return reject('No file selected');
        }

        $('#modal_event').show();
        $('#modal_Cropper').show('slow');

        const reader = new FileReader();
        reader.onload = function(event) {
            $('#avatarPreview').attr('src', event.target.result).show();

            // Xóa cropper cũ nếu có
            if (cropper) {
                cropper.destroy();
            }

            cropper = new Cropper(document.getElementById('avatarPreview'), {
                // aspectRatio: 3 / 4, // Căn chỉnh tỉ lệ
                viewMode: 1,
                dragMode: 'move', // Cho phép di chuyển hình ảnh
                // cropBoxMovable: false, // Không cho phép di chuyển khung cắt
                // cropBoxResizable: false, // Không cho phép thay đổi kích thước khung cắt
                ready: function() {
                    // Thiết lập kích thước cố định cho khung cắt
                    const cropBoxData = cropper.getCropBoxData();
                    cropper.setCropBoxData({
                        left: cropBoxData.left,
                        top: cropBoxData.top,
                        width: 150,
                        height: 200
                    });
                }
            });

            resolve(true); // Chỉ resolve sau khi cropper đã được khởi tạo
        };

        reader.onerror = function() {
            reject('Failed to read the file');
        };

        reader.readAsDataURL(file);
    });
}

let cropper;
$('#file_anhsp_input').on('change', function(e) {
    Crop_Anhsanpham('file_anhsp_input')
    $('#modal_event').show()
});

var base64Image_crop;
$('#cropButton').on('click', async function() {
    if (cropper) {
        const croppedCanvas = cropper.getCroppedCanvas();
        base64Image_crop = croppedCanvas.toDataURL('image/jpeg', 0.8);
        if($('#cropButton').attr('isset') == 2){
            if (window.innerWidth <= 1000) {
                screen = '_mobile'
            } else {
                screen = '_desktop'
            }
            id = $('#cropButton').attr('id_sanpham')
            let id_chucnang = 2
            const check = await laythongtincheckquyen(id_chucnang)
            $.ajax({
                type:"POST",
                url: "update_Anhsanpham",
                data:{
                    'id': id,
                    'file_anhsp': base64Image_crop,
                    //Check quyền
                    'time': check[1],
                    'id_manhinh': check[0],
                    'id_chucnang': id_chucnang,
                    'active': 1,
                },
                success: async function(res){
                    $('#modal_Cropper').hide('slow');
                    await reload_datatable()
                    if(['upd_1', 'upd_0', 'prod_2','prod_0', '-100','rol_2'].includes(res.trangthai) == true){
                        await reload_livewire()
                        thongbao(res.trangthai)
                        $('#modal_event').hide('slow');
                        // Livewire.emit('reloadComponent')
                    }else{
                        thongbao_error(res)
                        $('#modal_event').hide('slow');
                    }
                    $('.file_anhsp_update').val('')
                    $('#cropButton').attr('isset', '')
                    $('#cropButton').attr('id_sanpham', '')
                    $('#file_anhsp_update'+screen+id).prop('value', "");
                    base64Image_crop = ''
                }
            })
        }else{
            // Lấy tên file đã chọn
            var fileName = $('#file_anhsp_input').prop('files')[0].name;
            // Cập nhật tên file trong nhãn
            $('#file_anhsp').text(fileName);
            // $('#modal_event').hide();
            btt_hide_modal_Cropper()
        }
    }
});

function btt_hide_modal_Cropper(){
    $('#modal_Cropper').hide('slow');
    $('#modal_event').hide('slow');
    $('.file_anhsp_update').val('')
}


