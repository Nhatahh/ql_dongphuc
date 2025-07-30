$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // select_dot_phat()
    // $("#select_dot_phat_1").select2();
    $("#ds_dongphuc_filter").hide()

    // var cccdValue = $('#cccd').text();
    // console.log(cccdValue); // Hiển thị giá trị CCCD trong console
});

//Danh sách đồng phục
var ds_dongphuc = $("#ds_dongphuc").DataTable({
    //render input
    drawCallback: function(settings) {
        var api = this.api();
        api.rows().every(function() {
            var row = this.node();
            var bgColor = $(row).css('background-color');

            $(row).find('input.edit_tabledata').each(function() {
                $(this).css('background-color', '');  // Xóa bỏ màu nền hiện tại
                $(this).css('background-color', bgColor);
            });
        });
    },
    ajax: {
        type: "GET",
        url: "/admin24/ds_dongphuc",
    },
    columns: [
        {
            title: "<div style='text-align: center;'>Nhà sản xuất</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_nsx' onkeyup='search_nsx()' class='form-control' style='width:90%;height:22px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
            data: "nsx",
            className: 'remove_click',
        },
        {
            title: "<div style='text-align: center;'>Loại</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_loai' onkeyup='search_loai()' class='form-control' style='width:90%;height:22px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
            data: "loai",
            className: 'remove_click text-left',
        },
        {
            title: "<div style='text-align: center;'>Size</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_size' onkeyup='search_size()' class='form-control' style='width:90%;height:22px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
            data: "size",
            className: 'remove_click text-left',
        },
        {
            title: "<div style='text-align: center;'>Số lượng tồn</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_slton' onkeyup='search_slton()' class='form-control' style='width:90%;height:22px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
            data: "slton",
            className: 'remove_click text-left',
        },
        {
            title: "<div style='text-align: center;'>Đợt nhập</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_dotnhap' onkeyup='search_dotnhap()' class='form-control' style='width:90%;height:22px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
            data: "dotnhap",
            className: 'remove_click text-left',
        },
        {
            title: "<div style='text-align: center;'>Số lượng bán</div>",
            // title: "<div class='title_datatables'>Số lượng bán</div><div class='div_datatables'><input id='loadsanphamdotnhap_loai' onkeyup='search_datatables(\"loadsanphamdotnhap_loai\")' class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
            data: "id",
            className: 'timkiem_thisinh text-center remove_click',
            render: function(data ) {
                return '<input  style = "border: none;height: 28px;width:100%" type="text" class=" edit_tabledata sl_ban" data-id='+data+' />';
                // return '<input style="height: 28px;width:100%" type="text" class="sl_ban" data-id='+data+' id="">';
            }
        }
    ],
    language: {
        emptyTable: "Không tìm thấy hồ sơ",
        info: " _START_ / _END_ trên _TOTAL_ hóa đơn",
        paginate: {
            first: "Trang đầu",
            last: "Trang cuối",
            next: "Trang sau",
            previous: "Trang trước"
        },
        search: "Tìm kiếm:",
        loadingRecords: "Đang tìm kiếm ... ",
        lengthMenu: "Hiện thị _MENU_ hóa đơn",
        infoEmpty: "",
    },
    retrieve: true,
    paging: false,
    lengthChange: false,
    searching: true,
    ordering: false,
    info: false,
    autoWidth: true,
    responsive: false,
    scrollY: 360,
});
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
                if(res.trangthai==1){
                    $('#ngay_sinh').html(res.noidung['ngaysinh'])
                    $('#ten_sv').html(res.noidung['hoten'])
                    $('#cccd').html(res.noidung['cccd'])

                }else if(res.trangthai==2){
                    $('#mssv').empty()
                    toastr.warning("Không tìm thấy thông tin sinh viên")
                    reset_formphatdongphuc();
                }else{
                    var data = Object.values(res.noidung['original'])
                    toastr.warning(data[0]);
                }
                $('#modal_event').hide();
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

async function phat_dongphuc(){
    const check = await laythongtincheckquyen(11);
    var cccd = $('#cccd_sv').val();
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
                if (res.trangthai == 1) {
                    $('#phat_dongphuc').val(' ');
                    $('#cccd_sv').val('');
                    $('.sl_ban').val('');
                    reset_formphatdongphuc();
                    thongbao(res.noidung);
                    setTimeout(() => {
                        $('#modal_event').hide();
                        var pri = confirm("Có muốn in hóa đơn ?!")
                        if (pri == true){
                            window.open("in_hoadon/"+res.mahoadon, "_blank");
                        }
                    }, 1000);
                } else {
                    if (res.kieudulieu == 'json') {
                        var data = Object.values(res.noidung['original'])
                        toastr.warning(data[0]);
                        $('#modal_event').hide();
                    } else {
                        thongbao(res.noidung);
                        $('#modal_event').hide();
                    }
                }
            }
        })
    }else{
        toastr.warning('Chưa tìm kiếm sinh viên')
    }
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

function reset_formphatdongphuc(){
    $('#ten_sv').text('');
    $('#cccd').text('');
    $('#ngay_sinh').text('');
}
