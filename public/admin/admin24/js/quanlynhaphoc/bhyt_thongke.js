$('#nam_bhyt_thongke').select2()
$('#khoa_bhyt_thongke').select2()
$('#lop_bhyt_thongke').select2()

loadlop_bhyt()
loadkhoa_bhyt()
loadnam_bhyt()

function loadlop_bhyt(){
    $.ajax({
        type: "get",
        url: "loadlop_bhyt/",
        success: function (res) {
            $('#lop_bhyt_thongke').select2({data: res.lop})

        }
    });
}

function loadnam_bhyt(){
    $.ajax({
        type: "get",
        url: "loadnam_bhyt/",
        success: function (res) {
            $('#nam_bhyt_thongke').select2({data: res.nam})
        }
    });

}

function loadkhoa_bhyt(){
    $.ajax({
        type: "get",
        url: "loadkhoa_bhyt/",
        success: function (res) {
            $('#khoa_bhyt_thongke').select2({data: res.khoa})
        }
    });

}

bhyt_thongke(0,0,0).ajax.url("loadthongtin_bhyt_thongke/0/0/0").load();

function search_bhyt_thongke() {
    var lop = $('#lop_bhyt_thongke').val();
    var nam = $('#nam_bhyt_thongke').val();
    var khoa = $('#khoa_bhyt_thongke').val();
    bhyt_thongke(lop,nam,khoa).ajax.url("loadthongtin_bhyt_thongke/"+lop+"/"+nam+"/"+khoa).load();
}

$('#khoa_bhyt_thongke').on('change',function(){
    var id = $(this).val();
    $.ajax({
        type:'get',
        url: "onchange/"+id,
        success: function (res) {
            $('#lop_bhyt_thongke').empty()
            $('#lop_bhyt_thongke').select2({data: res.lop})

        }
    })
})

function bhyt_thongke(lop,nam,khoa)
{
    if ($.fn.DataTable.isDataTable("#table_thongtinsv_bhyt_thongke")) {
        // Xóa DataTable hiện tại và cấu trúc lại bảng
        $("#table_thongtinsv_bhyt_thongke").DataTable().destroy();
        $("#table_thongtinsv_bhyt_thongke").empty();
    }
    var bhyt_thongke = $("#table_thongtinsv_bhyt_thongke").DataTable({
        ajax: {
            url: "loadthongtin_bhyt_thongke/" + lop + nam + khoa,
            dataSrc: 'data'
        },
        columns: [
            {
                title: "Số thứ tự",
                data: "stt",
                className: 'text-center'
             },

            {
                title: "Lớp",
                data: "tenlop",
                className: 'text-center'
             },
             {
                title: "Sỉ số",
                data: "Sỉ số",
                className: 'text-center'
             },
             {
                title: "Có BHYT",
                data: "Có BHYT",
                className: 'text-center'
             },
            {
                title: "Chưa có BHYT",
                data: "Chưa có BHYT",
                className: 'text-center'
             },
             {
                title: "Năm nhập học",
                data: "namnhaphoc",
                className: 'text-center'
             },

        ],
        scrollY: 430,
        scrollX: true,
        language: {
            emptyTable: "Không tìm thấy dữ liệu",
            info: "_START_ / _END_ trên _TOTAL_",
            paginate: {
                first: "Trang đầu",
                last: "Trang cuối",
                next: "Trang sau",
                previous: "Trang trước"
            },
            search: "Tìm kiếm:",
            loadingRecords: "Đang tải dữ liệu...",
            lengthMenu: "Hiển thị _MENU_ bản ghi",
            infoEmpty: "Không có dữ liệu"
        },
        retrieve: true,
        paging: false,
        lengthChange: false,
        searching: true,
        ordering: false,
        info: true,
        autoWidth: false,
        responsive: false,
    });
    return bhyt_thongke;
}

$("#excel_hsnh_thongtinsinhvien_bhyt_thongke").on('click', function () {
    var lop = $('#lop_bhyt_thongke').val();
    var nam = $('#nam_bhyt_thongke').val();
    var khoa = $('#khoa_bhyt_thongke').val();
    window.location.href = "/admin24/excel_hsnh_thongtinsinhvien_bhyt_thongke/"+lop+"/"+nam+"/"+khoa;
});




