$('#khoa').select2()
$('#lop').select2()
$('#nam').select2()
table_thongke_xuatfile(0,0,0).ajax.url("thongke_xuatfile/0/0/0").load();
loadkhoa()
// loadlop()
loadnam()
function search() {
    // var major = $('#major').val();
    var nam = $('#nam').val();
    // major == 0 ? major = 0 :  major = $('#major').val();
    var lop = $('#lop').val();
    var idkhoa = $('#khoa').val();
    table_thongke_xuatfile(nam,lop,idkhoa).ajax.url("thongke_xuatfile/"+nam+"/"+lop+"/"+idkhoa).load();
}



function table_thongke_xuatfile(nam,lop,idkhoa){
    if ($.fn.DataTable.isDataTable("#table_thongke_xuatfile")) {
        $("#table_thongke_xuatfile").DataTable().clear().destroy();
    }
    var table_thongtinsv =  $("#table_thongke_xuatfile").DataTable({
        // processing: true,
        // serverSide: true,
        // deferRender: true,
        ajax: "thongke_xuatfile/"+nam+"/"+lop+"/"+idkhoa ,
        columns: [
            {
                name: "stt",
                className: 'text-center',
                title: "STT",
                data: "stt",
            },
            {
                name: "tenlop",
                className: 'text-center',
                title: "Lớp",
                data: "tenlop",
            },
            {
                name: "khoa",
                className: 'text-center',
                title: "Khoa",
                data: "tenkhoa",
            },

            {
                name: "nvqs",
                className: 'text-center',
                title: "NVQS",
                data: "slnvqs",
            },
            {
                name: "vv",
                className: 'text-center',
                title: "Vay vốn",
                data: "slvv",
            }

        ],
        // columnDefs: [
        //     {
        //         targets: [0, 1, 2,3,4,5,6,7,8,9,10,11,12],
        //         orderable: false
        //         // className: "text-center"
        //     },
        // ],
        scrollY: 430,
        language: {
            emptyTable: "Không tìm thấy",
            info: " _START_ / _END_ trên _TOTAL_",
            paginate: {
                first: "Trang đầu",last: "Trang cuối",
                next: "Trang sau",
                previous: "Trang trước",
            },
            search: "Tìm kiếm:",
            loadingRecords: " ... ",
            lengthMenu: "Hiện thị _MENU_",
            infoEmpty: "",
        },
        retrieve: true,
        paging: false,
        lengthChange: false,
        searching: true,
        ordering: false,
        info: true,
        autoWidth: false,
        responsive: true,
        select: true,


    });
    $('#table_thongke_xuatfile tbody').on('click', 'tr', function () {
        var $checkbox = $(this).find('.hsnh_checkbox');
        if ($checkbox.length) {
            // Chuyển đổi trạng thái của checkbox
            $checkbox.prop('checked', !$checkbox.prop('checked'));
        }
    });
    return table_thongtinsv;
}


$("#excel_hsnh_thongke_xuatfile").on('click',function(){
    var nam = $('#nam').val();
    var lop = $('#lop').val();
    var idkhoa = $('#khoa').val();
    window.location.href = "/admin24/excel_hsnh_thongke_xuatfile/"+nam +"/"+lop+"/"+idkhoa;
})



function hsnh_checkall(){
    // var hsnh_checkbox = document.getElementsByClassName('hsnh_checkbox');
    if($('#hsnh_checkall').prop('checked') == true){
        $('.hsnh_checkbox').prop('checked',true)
    }else{
        $('.hsnh_checkbox').prop('checked',false)
    }

}

function loadkhoa(){
    $.ajax({
        type: "get",
        url: "loadkhoa/",
        // load data huyện
        success: function (res) {
            $('#khoa').select2({data: res.loadkhoa})
        }
    });
}

function loadlop(){
    var idkhoa = $('#khoa').val();
    $.ajax({
        type: "get",
        url: "loadlop/"+idkhoa,
        // load data huyện
        success: function (res) {
            $('#lop').empty()
            $('#lop').select2({data: res.loadlop})
        }
    });
}
//load khóa
function loadnam(){
    $.ajax({
        type: "get",
        url: "loadnam/",
        // load data huyện
        success: function (res) {
            $('#nam').select2({data: res.loadkhoas})
        }
    });
}
function loaigiay(){
    $.ajax({
        type: "get",
        url: "loaigiay/",
        success: function (res) {
            $('#loaigiay').select2({data: res.loaigiay})
        }
    });
}
