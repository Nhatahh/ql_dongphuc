$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // select_dot_phat()
    $(".slect_dongphuc").select2();
    $("#ds_dongphuc_filter").hide()
    change_sl_ban()
    window.addEventListener('resize', adjustView1);
    adjustView1()


    ds_hoadon_dp(0).ajax.url('/admin24/ds_hoadon_sv/0').load();



});





// //Danh sách đồng phục
// var ds_dongphuc = $("#ds_dongphuc").DataTable({
//     //render input
//     drawCallback: function(settings) {
//         var api = this.api();
//         api.rows().every(function() {
//             var row = this.node();
//             var bgColor = $(row).css('background-color');

//             $(row).find('input.edit_tabledata').each(function() {
//                 $(this).css('background-color', '');  // Xóa bỏ màu nền hiện tại
//                 $(this).css('background-color', bgColor);
//             });
//         });
//     },
//     ajax: {
//         type: "GET",
//         url: "/admin24/ds_dongphuc",
//     },
//     columns: [

//         {
//             title: "<div style='text-align: center;'>Nhà sản xuất</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_nsx' onkeyup='search_nsx()' class='form-control' style='width:90%;height:22px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
//             data: "nsx",
//             className: 'remove_click',
//         },
//         {
//             title: "<div style='text-align: center;'>Loại</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_loai' onkeyup='search_loai()' class='form-control' style='width:90%;height:22px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
//             data: "loai",
//             className: 'remove_click text-left',
//         },
//         {
//             title: "<div style='text-align: center;'>Size</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_size' onkeyup='search_size()' class='form-control' style='width:90%;height:22px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
//             data: "size",
//             className: 'remove_click text-left',
//         },
//         {
//             title: "<div style='text-align: center;'>Số lượng tồn</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_slton' onkeyup='search_slton()' class='form-control' style='width:90%;height:22px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
//             data: "slton",
//             className: 'remove_click text-left',
//         },
//         {
//             title: "<div style='text-align: center;'>Đợt nhập</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_dotnhap' onkeyup='search_dotnhap()' class='form-control' style='width:90%;height:22px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
//             data: "dotnhap",
//             className: 'remove_click text-left',
//         },
//         {
//             title: "<div style='text-align: center;'>Số lượng bán</div>",
//             // title: "<div class='title_datatables'>Số lượng bán</div><div class='div_datatables'><input id='loadsanphamdotnhap_loai' onkeyup='search_datatables(\"loadsanphamdotnhap_loai\")' class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
//             data: "id",
//             className: 'timkiem_thisinh text-center remove_click',
//             render: function(data ) {
//                 return '<input  style = "border: none;height: 28px;width:100%" type="text" class=" edit_tabledata sl_ban" data-id='+data+' />';
//                 // return '<input style="height: 28px;width:100%" type="text" class="sl_ban" data-id='+data+' id="">';
//             }
//         }
//     ],
//     language: {
//         emptyTable: "Không tìm thấy hồ sơ",
//         info: " _START_ / _END_ trên _TOTAL_ hóa đơn",
//         paginate: {
//             first: "Trang đầu",
//             last: "Trang cuối",
//             next: "Trang sau",
//             previous: "Trang trước"
//         },
//         search: "Tìm kiếm:",
//         loadingRecords: "Đang tìm kiếm ... ",
//         lengthMenu: "Hiện thị _MENU_ hóa đơn",
//         infoEmpty: "",
//     },
//     retrieve: true,
//     paging: false,
//     lengthChange: false,
//     searching: true,
//     ordering: false,
//     info: false,
//     autoWidth: true,
//     responsive: false,
//     scrollY: 360,
// });
//Search for column
function search_nsx() {
    var value = $('#search_nsx').val()
    ds_dongphuc.column(0).search(value).draw();
}
function search_loai() {
    var value = $('#search_loai').val()
    ds_dongphuc.column(1).search(value).draw();
}
function search_size() {
    var value = $('#search_size').val()
    ds_dongphuc.column(2).search(value).draw();
}
function search_slton() {
    ds_dongphuc.column(3).search(value = $('#search_slton').val()).draw();
}
function search_dotnhap() {
    ds_dongphuc.column(4).search(value = $('#search_dotnhap').val()).draw();
}
//Danh sách đồng phục
// Khởi tạo DataTable
function ds_hoadon_dp(id){
    var ds_hoadon_sv = $("#ds_hoadon_sv").DataTable({
        ajax: {
            type: "GET",
            url: "/admin24/ds_hoadon_sv/"+id,
        },
        columns: [
            {
                className: 'dt-control',
                orderable: false,
                data: null,
                defaultContent: ''
            },
            {
                title: "Mã hóa đơn",
                data: "mahoadon",
                className: 'remove_click',
            },
            {
                title: "Người phát",
                data: "hoten_nguoiphat",
                className: 'remove_click text-left',
            },
            {
                title: "Ngày phát",
                data: "ngaytao",
                className: 'remove_click text-left',
            },
            {
                title: "Đợt phát",
                data: "dot_phat",
                className: 'remove_click text-left',
            },
            {
                title: "Thao tác",
                data: "mahoadon",
                width:"10%",
                className: 'timkiem_thisinh text-center remove_click',
                render: function(data, type, row) {
                    var html = "";
                    html += '<i style ="color:rgb(23, 2, 250);" data-id="' + data + '" class="fa-solid fa-file-pdf" onclick="in_hoadon(' + data + ')">&nbsp&nbsp</i>';
                    html += '<i style ="color: #f40f02;" data-id="' + data + '" class="fa-regular fa-trash-can" onclick="xoa_hoadon(' + data + ')">&nbsp&nbsp</i>';
                    return html;
                }
            }
        ],
        language: {
            emptyTable: "Không tìm thấy hóa đơn",
            info: " _START_ / _END_ trên _TOTAL_ hóa đơn",
            paginate: {
                first: "Trang đầu",
                last: "Trang cuối",
                next: "Trang sau",
                previous: "Trang trước"
            },
            search: "Tìm kiếm:",
            loadingRecords: "Đang tìm kiếm ... 111111111",
            lengthMenu: "Hiện thị _MENU_ hóa đơn",
            infoEmpty: "",
        },
        retrieve: true,
        paging: false,
        lengthChange: false,
        searching: true,
        ordering: false,
        info: false,
        autoWidth: false,
        responsive: true,
        scrollY: 360,
    });
    return ds_hoadon_sv;
}

// Hàm định dạng cho bảng con
function format(data) {

        // var html = '<div style = "margin-top:20px;"><table style="width:100%;">';
        // html += '<thead><tr><th class="dt-control">STT</th><th>Loại</th><th>Size</th><th>Nhà sản xuất</th><th>Số lượng phát</th></tr></thead>';
        // html += '<tbody>';
        // data.chitietsp.forEach(function(product) {
        //     html += '<tr>';
        //     html += '<td>' + product.stt + '</td>';
        //     html += '<td>' + product.loai + '</td>';
        //     html += '<td>' + product.size + '</td>';
        //     html += '<td>' + product.nsx + '</td>';
        //     html += '<td>' + product.sl_phat + '</td>';
        //     html += '</tr>';
        // });
        // html += '</tbody></table></div>';


        var html = '<div class = "row">';
            html +=      '<div class = "col-1"></div>';
            html +=      '<div class = "col-2" style = "text-align:center">STT</div>';
            html +=      '<div class = "col-2" style = "text-align:center">Sản xuất</div>';
            html +=      '<div class = "col-2" style = "text-align:center">Loại</div>';
            html +=      '<div class = "col-2" style = "text-align:center">Size</div>';
            html +=      '<div class = "col-2" style = "text-align:center">Số lượng</div>';
            html +=      '<div class = "col-1"></div>';

            data.chitietsp.forEach(function(product) {
                html +=      '<div class = "col-1"></div>';
                html +=      '<div class = "col-2" style = "text-align:center">' + product.stt + '</div>';
                html +=      '<div class = "col-2" style = "text-align:center">' + product.nsx + '</div>';
                html +=      '<div class = "col-2" style = "text-align:center">' + product.loai + '</div>';
                html +=      '<div class = "col-2" style = "text-align:center">' + product.size + '</div>';
                html +=      '<div class = "col-2" style = "text-align:center">' + product.sl_phat + '</div>';
                html +=      '<div class = "col-1"></div>';
            });

            html += '</div>';
        return html;

}


// Xử lý sự kiện khi nhấp vào cột điều khiển
$("#ds_hoadon_sv").on('click', 'td.dt-control', function() {
    let tr = $(this).closest('tr');
    let row = ds_hoadon_dp().row(tr);
    if (row.child.isShown()) {
        // Nếu hàng con đã mở - đóng nó
        row.child.hide();
    } else {
        // Mở hàng con
        row.child(format(row.data())).show();
    }
});

//Tìm kiếm sinh viên
function phatdongphuc_timkiem() {
        $('#modal_event').show();
        let cccd_sv=$('#cccd_sv').val()
        $.ajax({
            type: 'get',
            url: '/admin24/phatdongphuc_timkiem',
            data: {
                cccd_sv : cccd_sv
            },
            success: function(res) {
                $('#modal_event').hide();
                if(res.trangthai==1){
                    var html = res.noidung['hoten'] + " (" +res.noidung['cccd'] + ")";
                    ds_hoadon_dp().ajax.url('/admin24/ds_hoadon_sv/'+res.noidung.id_taikhoan).load();
                    $('#ten_sv').html(html);
                    Livewire.emit('get_cccdsv',cccd_sv);
                }else if(res.trangthai==2){
                    toastr.warning("Không tìm thấy thông tin sinh viên")
                    $('#ten_sv').html('');
                    ds_hoadon_dp(0).ajax.url('/admin24/ds_hoadon_sv/0').load();
                }else{
                    var data = Object.values(res.noidung['original'])
                    toastr.warning(data[0]);
                }
            }
        })
}


//Hàm thông báo chưa nhập thông tin sinh viên
function kiem_tra_tt_sv(){
    let cccd_sv=$('#cccd_sv').val()
    $.ajax({
        type: "get",
        url: "/admin24/kiem_tra_tt_sv",
        data: {
            cccd_sv:cccd_sv,
        },
        success: function(res) {
            if(res.trangthai!=1 && res.kieudulieu=="json"){
                var data = Object.values(res.noidung['original'])
                toastr.warning(data[0]);
                return 0;
            }else{
                return 1;
            }
        }
    });
}

async function phat_dongphuc(kieu){
    const check = await laythongtincheckquyen(11);
    var cccd = $('#cccd_sv').val();
    var email = $('#email_sv').text();
    var result = {};
    var loaisanpham = document.getElementsByClassName('loaisanpham')
    for (let i = 0; i < loaisanpham.length; i++) {
        var id_loai = $(loaisanpham[i]).attr('id_loai')
        var idsp =  $(loaisanpham[i]).val()
        var value = $('#soluong_ban_'+id_loai).val();
        if (value > 0 && value != null && !isNaN(value)) {
            result[idsp] = value;
        }
    }
    if($('#ten_sv').text() != ''){
        $('#modal_event').show();
        $.ajax({
            type: "post",
            url: "/admin24/phat_dongphuc",
            data: {
                result: result,
                cccd: cccd,
                time: check[1],
                id_manhinh: check[0],
                id_chucnang: 11,
                active: 1,
            },
            success: function(res) {
                $('#modal_event').hide();
                if (res.trangthai == 1) {
                    if(kieu==1){
                        var pri = confirm("Có muốn in hóa đơn ?!")
                        if (pri == true){
                            // location.reload()
                            window.open("https://congmotcua.ctuet.edu.vn/admin24/in_hoadon/"+res.mahoadon, "_blank");
                        }

                    }else{
                        thongbao(res.noidung);
                        $('.sl_ban').val(0);
                        phatdongphuc_timkiem()
                        // $('.sl_ban').val(0)
                    }
                } else {
                    if (res.kieudulieu == 'json') {
                        var data = Object.values(res.noidung['original'])
                        toastr.warning(data[0]);
                    } else {
                        thongbao(res.noidung);
                    }
                }
                // if (res.trangthai == 1) {
                //     var pri = confirm("Đã phát đồng phục thanh công!!!Có muốn gửi hóa đơn đến email "+email,"!?")
                //     if (pri == true){
                //         guimail_hd(res.idsv)
                //         thongbao(res.noidung);
                //     }
                // } else {
                //     if (res.kieudulieu == 'json') {
                //         var data = Object.values(res.noidung['original'])
                //         toastr.warning(data[0]);
                //     } else {
                //         thongbao(res.noidung);
                //     }
                // }
            }
        })
    }else{
        toastr.warning('Chưa tìm kiếm sinh viên')
    }
}
//Gửi hóa đơn đến mail
function guimail_hd(id_sv){
    $.ajax({
        type: "POST",
        url: "/admin24/guimail_hd/"+id_sv,
        success: function(res) {
            thongbao(res)

        }
    });

}
//Lấy lại sl tồn
function lay_soluong_ton() {
    $.ajax({
        type: "GET",
        url: "/admin24/lay_soluong_ton",
        success: function(res) {
            // Giả sử bạn đã có nơi để hiển thị số lượng tồn kho, bạn có thể cập nhật chúng tại đây
            res.sanpham.forEach(item => {
                $('#ton_kho_' + item.id_sp_kho).text(item.sl);
            });
        }
    });
}
//
function change_sl_ban(){
    $('.decrease').click(function() {
        let input = $(this).siblings('input');
        let value = parseInt(input.val());

        // Giảm giá trị nếu lớn hơn 1
        if (value >= 1) {
            input.val(value - 1);
        }
    });

    // Khi nhấn nút tăng
    $('.increase').click(function() {
        let input = $(this).siblings('input');
        let value = parseInt(input.val());

        // Tăng giá trị
        input.val(value + 1);
    });

    // Đảm bảo ô input chỉ nhận số
    $('.nguyenvong').on('input', function() {
        let value = $(this).val().replace(/\D/g, ''); // Loại bỏ các ký tự không phải số
        $(this).val(value);
    });
}
//Reponsive
function adjustView1() {

    var nhapMobile = document.getElementsByClassName('pdphd_mobile');
    var nhapPc = document.getElementsByClassName('pdphd_pc');
    // phatdongphuc_timkiem()
    if (window.innerWidth <= 567) {
        for (var i = 0; i < nhapMobile.length; i++) {
            nhapMobile[i].style.display = 'block';
        }
        for (var i = 0; i < nhapPc.length; i++) {
            nhapPc[i].style.display = 'none';
        }
    } else {
        for (var i = 0; i < nhapPc.length; i++) {
            nhapPc[i].style.display = 'block';
        }
        for (var i = 0; i < nhapMobile.length; i++) {
            nhapMobile[i].style.display = 'none';
        }
    }
}


