$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    hosolephi().ajax.url("/admin24/loadhosolephi/-1").load();
    $('#thanhtoan_namtuyensinh').select2();
});

function hosolephi(){
    var val = $('#thanhtoan_namtuyensinh').val()
    var table =  $('#danhsachthanhtoan').DataTable({
        ajax: {
            type:'get',
            url: '/admin24/loadhosolephi/'+val,
            dataSrc: 'data'
        },
        columns: [
            { title: "Mã hóa đơn",
                data: 'order_id'
            },
            {   title: "Họ và tên",
                data: 'customer_name' },
            { title: "Email",
            data: 'customer_email' },
            { title: "Điện thoại",  data: 'customer_phone' },
            { title: "Tài khoản",  data: 'AccNo' },
            { title: "Ngân hàng",  data: 'BankShortName' },
            { title: "Thời gian",  data: 'completed_at' },
            { title: "Tổng tiền",  data: 'total_amount' },
        ],
        columnDefs: [
            {
                targets: 0,
                className: 'dt-body-left'
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
            {
                targets: 7,
                className: 'dt-body-left'
            },

        ],

        "language": {
            "emptyTable": "Không tìm thấy hóa đơn",
            "info": " _START_ / _END_ trên _TOTAL_ hóa đơn",
            "paginate": {
                "first":      "Trang đầu",
                "last":       "Trang cuối",
                "next":       "Trang sau",
                "previous":   "Trang trước"
            },
            "search":         "Tìm kiếm:",
            "loadingRecords": "Đang tìm kiếm ... ",
            "lengthMenu":     "Hiện thị _MENU_ hóa đơn",
            "infoEmpty":      "",
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

function loadhosolephi(){
    var val = $('#thanhtoan_namtuyensinh').val()
    $.ajax({
        type:'get',
        url: '/admin24/thongkelephitheotrangthai/'+val,
        success:function(res){
            hosolephi().ajax.url("/admin24/loadhosolephi/"+val).load();
            $('#tonghoadon').text(res[0].tonghoadon);
            $('#tongthisinh').text(res[0].tongthisinh);
            $('#tongtien').text(res[0].tongthu);
        }
    })

}


function exceldanhsachtructuyen(){
    var val = $('#thanhtoan_namtuyensinh').val()
    window.location.href = '/admin24/exceldanhsachtructuyen/'+val
}

