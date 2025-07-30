$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(window).resize(function() {
        equalizeHeight();
    });
    hssv_loadindex();
})

function hssv_load_thanhtimkiem(){
    return new Promise (function(resolve, reject){
        $.ajax({
            type: 'get',
            url: 'hssv_load_thanhtimkiem', // URL để lấy dữ liệu
            dataType: 'json',
            success: function (data) {
                $('#hssv-khoahoc').empty();
                $('#hssv-khoahoc').select2({
                    data: data.hssv_khoahoc
                });
                $('#hssv-khoa').empty();
                $('#hssv-khoa').select2({
                    data: data.hssv_khoa
                });
                $('#hssv-nganh').empty();
                $('#hssv-nganh').select2({
                    data: data.hssv_nganh
                });
                $('#hssv-chuyennganh').empty();
                $('#hssv-chuyennganh').select2({
                    data: data.hssv_chuyennganh
                });
                $('#hssv-lop').empty();
                $('#hssv-lop').select2({
                    data: data.hssv_lop
                });
                $('#hssv-gioitinh').empty();
                $('#hssv-gioitinh').select2({
                    data: data.hssv_gioitinh
                });
                $('#hssv-hoatdong').empty();
                $('#hssv-hoatdong').select2({
                    data: data.hssv_hoatdong
                });
                $('#hssv-hoten').val();
                $('#hssv-cccd').val();
                $('#hssv-mssv').val();
                resolve(true)
            },
        })
    })
}
function empty_table(id_dom){
    return new Promise (function(resolve, reject){
        $('#'+id_dom+'_empty').empty();
        $('#'+id_dom+'_empty').append('<table id = "'+id_dom+'" class="table table-hover table-striped table-bordered"></table>');
        resolve(true);
    })
}

function create_table(data,id_dom){
    return new Promise (function(resolve, reject){
        var containerHeight = $('.block-right').height();
        var table =  $('#'+id_dom).DataTable({
            processing: true,
            data: data.data, // Dữ liệu sinh viên
            columns: data.columns, // Cột được lấy từ phản hồi
            language: {
                emptyTable: "Không tìm thấy sinh viên",
                info: "_TOTAL_ sinh viên",
                paginate: {
                    first: "Trang đầu",
                    last: "Trang cuối",
                    next: "Trang sau",
                    previous: "Trang trước"
                },
                search: "Tìm kiếm:",
                loadingRecords: "Đang tìm kiếm ... ",
                lengthMenu: "Hiện thị _MENU_ SV",
                infoEmpty: "",
            },
            retrieve: true,
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: true,
            responsive: false,
            scrollY: containerHeight - 150,
        });
        if ($.fn.dataTable.isDataTable('#' + id_dom)) {
            table.clear();
            table.rows.add(data.data); // Add new data
            table.draw(); // Redraw the table
        }
        resolve(table);
    });
}

async function hssv_loadindex(){
    await open_preloader(0);//Mở Preloader (main.js)
    await hssv_load_thanhtimkiem();
    await equalizeHeight();
    await close_preloader(0);//ĐóngPreloader (main.js)
}
//Load data
function table_data(searchData){
    return new Promise (function(resolve, reject){
        var uri = JSON.stringify(searchData)
        let encoded_uri = btoa(encodeURIComponent(uri));
        $.ajax({
            type: 'get',
            url: 'hssv_load_danhsachssv/'+encoded_uri, // URL để lấy dữ liệu
            dataType: 'json',
            success: function (res) {
                resolve(res)
            }
        })
    })
}
$('.hssv').on('change', async function(){
    var searchInfo = await table_thongtintimkiem('hssv')
    var searchData = await table_data(searchInfo)
    if($(this).attr('id') === 'hssv-khoahoc'){
        await empty_table('tcsv_load_danhsach')
    }
    if($('#hssv-khoahoc').val() > 0 || $(this).attr('id') === 'hssv-khoahoc'){
        await create_table(searchData,'tcsv_load_danhsach')
    }else{
        toastr.warning('Vui lòng chọn khóa học')
    }
})
async function hssv_excel_danhsach(){
    var searchInfo = await table_thongtintimkiem('hssv')
    let encoded_uri = btoa(encodeURIComponent(JSON.stringify(searchInfo)));
    window.location.href = '/admin24/hssv_excel_danhsach/'+encoded_uri
}

async function hssv_pdf_danhsach(){
    var searchInfo = await table_thongtintimkiem('hssv')
    let encoded_uri = btoa(encodeURIComponent(JSON.stringify(searchInfo)));

    var id_lop = $('#hssv-lop').val();
    var id_khoahoc = $('#hssv-khoahoc').val();
    if(id_khoahoc > 0){
        if(id_lop > 0){
            window.open('/admin24/hssv_pdf_danhsach/' + encoded_uri + '/' + id_lop, '_blank');
        }else{
            toastr.warning('Vui lòng chọn lớp sinh viên')
        }
    }else{
        toastr.warning('Vui lòng chọn khóa học')
    }
}

async function hssv_lammoi(){
    await hssv_load_thanhtimkiem();
    await empty_table('tcsv_load_danhsach')
}


