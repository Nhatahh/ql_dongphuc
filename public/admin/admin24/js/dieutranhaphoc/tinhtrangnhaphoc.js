$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#ttnh_dotts").select2();
    $.ajax({
        type: 'get',
        url: '/admin24/loadchuyennganh',
        success: function(res) {
            $("#ttnh_chuyennganh").select2({
                data: res
            });
        }

    })
    var dotts = $("#ttnh_dotts").val();
    var chuyennganh = 0
    tinhtrangnhaphoc(dotts,0,chuyennganh)
});

//Danh sách đồng phục

function tinhtrangnhaphoc(dotts,chuyennganh){
    var myDataTable = $("#ttnh_danhsach").DataTable({
        processing: true,
        // serverSide: true,
        deferRender: true,
        ajax: "/admin24/ttnh_danhsach/"+dotts+'/0/'+chuyennganh,
        columns: [
            {
                title: "STT",
                className: 'text-center',
                data: "sothutu",
            },
            {
                name: "id",
                className: 'text-center',
                title: "ID",
                data: "id",
            },
            {
                name: "hoten",
                title: "Họ và tên",
                data: "hoten",
            },
            {
                name: "cccd",
                title: "CCCD/CMND",
                data: "cccd",
            },
            {
                name: "tenchuyennganh",
                title: "Ngành",
                data: "tenchuyennganh",
            },
            {
                name: "dienthoai",
                title: "Diện thoại",
                data: "dienthoai",
            },
            {
                name: "daxem",
                title: "Xem",
                data: "daxem",
                render: function(data){
                    if(data == 1) {
                        return "X"
                    }else{
                        return ""
                    }
                }
            },
            {
                name: "xacnhan",
                title: "XN Cổng Trường",
                data: "xacnhan",
                render: function(data){
                    if(data == 1) {
                        return "X"
                    }else{
                        return ""
                    }
                }
            },
            {
                name: "xacnhanbo",
                title: "XN Cổng Bộ",
                data: "xacnhanbo",
            },
            {
                name: "mssv",
                title: "Nhập học",
                data: "mssv",
            },
            {
                name: "trangthaidieutra",
                title: "Điều tra",
                data: "trangthaidieutra",
                render: function(data){
                    switch (data) {
                        case 1:
                            return "Xác nhận";
                            break;
                        case 2:
                            return  "Không xác nhận";
                            break;
                        case 3:
                            return "Phân vân";
                            break;
                        case 4:
                            return "Không liên lạc được";
                            break;
                        case 5:
                            return "Chuyển ngành";
                            break;
                        default:
                            return "";
                            break;
                    }
                }
            },
            {
                name: "ghichu_xnnh",
                title: "Ghi chú",
                data: "ghichu_xnnh",
            },
        ],
        columnDefs: [
            {
                targets: [0,1,3,5,7,8],
                // orderable: false
                className: "text-center"
            },
        ],
        scrollY: 370,
        language: {
            emptyTable: "Không tìm thấy thí sinh",
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
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: true,
        responsive: true,
        select: true,
    });
    return myDataTable;
}

$("#ttnh_timkiem").on('click',function(){
    var dotts = $('#ttnh_dotts').val()
    var chuyennganh = $("#ttnh_chuyennganh").val()
    tinhtrangnhaphoc(dotts,0,chuyennganh).ajax.url('/admin24/ttnh_danhsach/'+dotts+'/0/'+chuyennganh).load();
})

$("#ttnh_xuatdanhsach").on('click',function(){
    var dotts = $("#ttnh_dotts").val();
    var chuyennganh = $("#ttnh_chuyennganh").val();
    var rowCount =  tinhtrangnhaphoc(dotts,chuyennganh).rows().count();
    if(rowCount > 0){
        window.location.href = 'xuatdanhsachtrungtuyenchinhthuc/'+dotts+'/0/'+chuyennganh;
    }else{
        thongbao('table_0')
    }
})

$("#ttnh_thongke").on('click',function(){
    var dotts = $('#ttnh_dotts').val()
    window.location.href = 'xuatexcelthongketrungtuyentheodotts/'+dotts;
})
