$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    hosolephi().ajax.url("/admin24/loadhosolephi/-1").load();
    $('#thanhtoan_namtuyensinh').select2();
});


function hosolephi() {
    var val = $('#thanhtoan_namtuyensinh').val()
    var table = $('#danhsachthanhtoan').DataTable({
        ajax: {
            type: 'get',
            url: '/admin24/loadhosolephi/' + val,
            // dataSrc: 'data'
        },
        columns: [
            {
                title: "<div style = 'text-align: center;margin-bottom: 15px;'>STT</div></div>",
                data: 'stt'
            },
            {
                title: "<div style = 'text-align: center;'>Mã HĐ</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_order' onkeyup = 'search_order()' class='form-control' style='width:90%;height:28px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
                data: 'id_order'
            },
            {
                title: "<div style = 'text-align: center;'>Họ và tên</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_ten' onkeyup = 'search_ten()' class='form-control' style='width:90%;height:28px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
                data: 'hoten'
            },
            {
                title: "<div style = 'text-align: center;'>Email</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_email' onkeyup = 'search_email()' class='form-control' style='width:90%;height:28px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
                data: 'email'
            },
            {
                title: "<div style = 'text-align: center;'>Điện thoại</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_phone' onkeyup = 'search_phone()' class='form-control' style='width:90%;height:28px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
                data: 'dienthoai'
            },
            // {
            //     title: "<div  style = 'text-align: center;'>Tài khoản</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input  readonly class='form-control' style='background-color:inherit;width:90%;height:28px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
            //     data: 'AccNo'
            // },
            // {
            //     title: "<div  style = 'text-align: center;'>Ngân hàng</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input  readonly class='form-control' style='background-color:inherit;width:90%;height:28px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
            //     data: 'BankShortName'
            // },
            {
                title: "<div style = 'text-align: center;'>Ngày thanh toán</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_time' onkeyup = 'search_time()' class='form-control' style='width:90%;height:28px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
                data: 'ngaythanhtoan'
            },
            {
                title: "<div  style = 'text-align: center;'>Số tiền</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input  readonly class='form-control' style='background-color:inherit;width:90%;height:28px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
                data: 'total_amount'
            },
            {
                title: "<div>Hình thức</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'> <select style='height:28px; border:none;color:#8a8c8f;' id='search_hinhthuc' onchange = 'search_hinhthuc()'><option  value =''></option><option value ='1'>Chuyển khoản</option><option value ='2'>Tiền mặt</option><option value ='3'>BaoKim</option></select></div>",
                data: 'hinhthuc',
                render: function (data, type, row) {
                    switch (data) {
                        case 1:
                            hinhthuc = "1-Chuyển khoản"
                            break;
                        case 2:
                            hinhthuc = "2-Tiền mặt"
                            break;
                        case 3:
                            hinhthuc = "3-BaoKim"
                            break;
                        default:
                            hinhthuc = "4-Không XĐ"
                            break;
                    }
                    return hinhthuc
                }
            },
        ],

        columnDefs: [
            {
                targets: 0,
                className: 'dt-body-center'
            },
            {
                targets: 1,
                className: 'dt-body-left'
            },
            {
                targets: 2,
                className: 'dt-body-left'
            },
            {
                targets: 4,
                className: 'dt-body-left'
            },
            {
                targets: 5,
                className: 'dt-body-left'
            },
            {
                targets: 6,
                className: 'dt-body-left'
            },
            // {
            //     targets: 7,
            //     className: 'dt-body-left'
            // },

        ],

        "language": {
            "emptyTable": "Không tìm thấy hóa đơn",
            "info": " _START_ / _END_ trên _TOTAL_ hóa đơn",
            "paginate": {
                "first": "Trang đầu",
                "last": "Trang cuối",
                "next": "Trang sau",
                "previous": "Trang trước"
            },
            "search": "Tìm kiếm:",
            "loadingRecords": "Đang tìm kiếm ... ",
            "lengthMenu": "Hiện thị _MENU_ hóa đơn",
            "infoEmpty": "",
        },
        "retrieve": true,
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        scrollY: 380,
    });
    return table;
}

function search_order() {
    var value = $('#search_order').val()
    hosolephi().column(1).search(value).draw();
}

function search_ten() {
    var value = $('#search_ten').val()
    hosolephi().column(2).search(value).draw();
}

function search_email() {
    var value = $('#search_email').val()
    hosolephi().column(3).search(value).draw();
}

function search_phone() {
    var value = $('#search_phone').val()
    hosolephi().column(4).search(value).draw();
}

function search_time() {
    var value = $('#search_time').val()
    hosolephi().column(5).search(value).draw();
}

function search_hinhthuc() {
    var value = $('#search_hinhthuc').val()
    hosolephi().column(7).search(value).draw();
}

function loadhosolephi() {
    var val = $('#thanhtoan_namtuyensinh').val()
    $.ajax({
        type: 'get',
        url: '/admin24/thongkelephitheotrangthai/' + val,
        success: function (res) {
            hosolephi().ajax.url("/admin24/loadhosolephi/" + val).load();
            $('#tonghoadon').text(res[0].tonghoadon);
            $('#tongthisinh').text(res[0].tongthisinh);
            $('#tongtien').text(res[0].tongthu);
        }
    })

}


function exceldanhsachtructuyen() {
    var val = $('#thanhtoan_namtuyensinh').val()
    window.location.href = '/admin24/exceldanhsachtructuyen/' + val
}

function testmail() {

    $.ajax({
        type: 'get',
        url: '/admin24/testmail',
        success: function (res) {
            alert(res)
        }
    })
}

