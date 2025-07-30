$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    adjustView();
    window.addEventListener('resize', adjustView);
    $('#ds_hoadon_filter').hide()
});
//Danh sách đồng phục
var ds_hoadon = $("#ds_hoadon").DataTable({
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
        url: "/admin24/ds_hoadon_dongphuc",
    },
    columns: [
        {
            title: "<div style='text-align: center;'>Mã hóa đơn</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_mahoadon' onkeyup='search_mahoadon()' class='form-control' style='width:90%;height:22px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
            data: "mahoadon",
            className: 'remove_click',
        },
        {
            title: "<div style='text-align: center;'>Người phát</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_nguoiphat' onkeyup='search_nguoiphat()' class='form-control' style='width:90%;height:22px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
            data: "hoten_nguoiphat",
            className: 'remove_click text-left',
        },
        {
            title: "<div style='text-align: center;'>Người nhận</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_nhan' onkeyup='search_nhan()' class='form-control' style='width:90%;height:22px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
            data: "hoten_sv",
            className: 'remove_click text-left',
        },
        {
            title: "<div style='text-align: center;'>Thời gian</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_tg' onkeyup='search_tg()' class='form-control' style='width:90%;height:22px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
            data: "ngaytao",
            className: 'remove_click text-left',
        },
        {
            title: "<div style='text-align: center;'>Đợt phát</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_dotphat' onkeyup='search_dotphat()' class='form-control' style='width:90%;height:22px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
            data: "dot_phat",
            className: 'remove_click text-left',
        },
        // {
        //     title: "<div style='text-align: center;'>Trạng thái</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_trangthai' onkeyup='search_trangthai()' class='form-control' style='width:90%;height:22px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
        //     data: "trangthai",
        //     className: 'remove_click text-left',
        //     render: function(data, type, row) {
        //         var html=""
        //         if(data == 1){
        //             html+='<span>Đã xóa</span>'
        //         }else{
        //             html+='<span></span>'
        //         }
        //         return html;
        //     }
        // },
        {
            title: "Thao tác",
            data: "mahoadon",
            width:"10%",
            className: 'timkiem_thisinh text-center remove_click',
            render: function(data, type, row) {
                var html=""
                html+= '<i style ="color:rgb(23, 2, 250);" data-id="' +data +'" class="fa-solid fa-file-pdf"  onclick = "in_hoadon(' +data +')">&nbsp&nbsp</i>'
                html+='<i style ="color: #f40f02;"  data-id="' +data +'" class="fa-regular fa-trash-can"  onclick = "xoa_hoadon(' +data +')">&nbsp&nbsp</i>'
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
    autoWidth: false,
    responsive: true,
    scrollY: 360,
});
//Search for column
function search_mahoadon() {
    var value = $('#search_mahoadon').val()
    ds_hoadon.column(0).search(value).draw();
}
function search_nguoiphat() {
    var value = $('#search_nguoiphat').val()
    ds_hoadon.column(1).search(value).draw();
}
function search_nhan() {
    var value = $('#search_nhan').val()
    ds_hoadon.column(2).search(value).draw();
}
function search_tg() {
    ds_hoadon.column(3).search(value = $('#search_tg').val()).draw();
}
function search_dotphat() {
    ds_hoadon.column(4).search(value = $('#search_dotphat').val()).draw();
}
// function search_trangthai() {
//     ds_hoadon.column(5).search(value = $('#search_trangthai').val()).draw();
// }
//Button phát sản phẩm
function in_hoadon(mahoadon){
    window.open("in_hoadon/"+mahoadon, "_blank");
}
async function xoa_hoadon(mahoadon){
    var pri = confirm("Có muốn xóa hóa đơn ?!")
    if (pri == true){
        $('#modal_event').show();
        const check = await laythongtincheckquyen(4);
        $.ajax({
            type: 'post',
            url: '/admin24/xoa_hoadon/'+mahoadon,
            data: {
                time: check[1],
                id_manhinh: check[0],
                id_chucnang: 4,
                active: 1,
            },
            success: function(res) {
                $('#modal_event').hide();
                if(res.trangthai==1){
                    Livewire.emit('refreshComponent');
                    thongbao(res.noidung);
                    ds_hoadon.ajax.reload();
                }else{
                    thongbao(res.noidung);
                }
            }
        });
    }
}
function adjustView() {

    var nhapMobile = document.getElementsByClassName('qlhd_mobile');
    var nhapPc = document.getElementsByClassName('qlhd_pc');
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
