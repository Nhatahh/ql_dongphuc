$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(window).resize(function() {
        equalizeHeight();
    });
    load_index();
})

async function load_index(){
    await open_preloader();//Mở Preloader (main.js)
    await tcsv_loadtimkiem_trong()
    await tcsv_loadtimkiem();
    var data = JSON.stringify(tcsv_isEqual(await tcsv_laygiatribandau(),0))
    tcsv_load_danhsach(data).ajax.url('tcsv_timkiem/'+data).load();
    await equalizeHeight(); //Cân bằng 2 block trái và phải (main.js)
    await close_preloader(); //Tắt Preloader (main.js)
}
function tcsv_loadtimkiem(){
    return new Promise (function(resolve, reject){
        $.ajax({
            type: "get",
            url: "tcsv_loadtimkiem",
            success: function (res) {
                $('#tcsv_khoahoc').select2({
                    data: res.tcsv_khoahoc
                })
                $('#tcsv_nganh').select2({
                    data: res.tcsv_nganh
                })
                $('#tcsv_khoa').select2({
                    data: res.tcsv_khoa
                })
                $('#tcsv_chuyennganh').select2({
                    data: res.tcsv_chuyennganh
                })
                $('#tcsv_lop').select2({
                    data: res.tcsv_lop
                })
                $('#tcsv_dantoc').select2({
                    data: res.tcsv_dantoc
                })
                $('#tcsv_tongiao').select2({
                    data: res.tcsv_tongiao
                })
                $('#tcsv_noisinh').select2({
                    data: res.tcsv_noisinh
                })
                $('#tcsv_hktt').select2({
                    data: res.tcsv_hktt
                })
                $('#tcsv_quequan').select2({
                    data: res.tcsv_quequan
                })
                $('#tcsv_gioitinh').select2({
                    data: res.tcsv_gioitinh
                })
                $('#tcsv_hoatdong').select2({
                    data: res.tcsv_hoatdong
                })
                resolve(true)
            }
        });
    })

}
function tcsv_loadtimkiem_trong(){
    return new Promise (function(resolve, reject){
        var tcsv = document.getElementsByClassName('tcsv')
        for (let i = 0; i < tcsv.length; i++) {
            if($(tcsv[i]).is('input')){
                $(tcsv[i]).val('')
            }else{
                $(tcsv[i]).empty();
                $(tcsv[i]).select2()
            }
        }
        resolve(true)
    })
}
function tcsv_laygiatribandau(){
    return new Promise (function(resolve, reject){
        let data = {};
        var tcsv = document.getElementsByClassName('tcsv')
        for (let i = 0; i < tcsv.length; i++) {
            var id = $(tcsv[i]).attr('id')
            data[id] = $(tcsv[i]).attr('val-def');
        }
        resolve(data);
    })
}
function tcsv_thongtintimkiem(){
    return new Promise (function(resolve, reject){
        let data = {};
        var tcsv = document.getElementsByClassName('tcsv')
        for (let i = 0; i < tcsv.length; i++) {
            var id = $(tcsv[i]).attr('id')
            data[id] = $(tcsv[i]).val();
        }
        resolve(data);
    })
}
function tcsv_isEqual(originalData,searchData){
    if(searchData == 0 || JSON.stringify(originalData) === JSON.stringify(searchData) ){
        originalData['trangthai'] = 0;
        return originalData;
    }else{
        searchData['trangthai'] = 1;
        return searchData;
    }
}
function tcsv_reg(){
    let reg = /[!@#$%^&*(),.?":{}|<>]+/
    let hoten = "",cccd = "",mssv = ""
    reg.test($('#tcsv_hoten').val()) == false ? hoten = $('#tcsv_hoten').val() : hoten = "false_not";
    reg.test($('#tcsv_cccd').val()) == false ? cccd = $('#tcsv_cccd').val() : cccd = 'false_not';
    reg.test($('#tcsv_mssv').val()) == false ? mssv = $('#tcsv_mssv').val() : mssv = 'false_not';
    if( hoten == 'false_not' || cccd == 'false_not' || mssv == 'false_not'){
        return 0;
    }
    return 1;
}


async function tcsv_timkiem(){
    try{
        var originalData = await tcsv_laygiatribandau();
        var searchData = await tcsv_thongtintimkiem();
        var isEqual =  tcsv_isEqual(originalData,searchData)
        if(isEqual['trangthai'] == 0){
            toastr.warning('Vui lòng chọn một giá trị để tìm kiếm!!!');
            var isEqual =  tcsv_isEqual(originalData,0)
            tcsv_load_danhsach(searchData).ajax.url('tcsv_timkiem/'+JSON.stringify(isEqual)).load();
        }else{
            if( tcsv_reg() == 0){
                toastr.warning('Họ tên, CCCD, MSSV chứa ký tự đặc biệt');
            }else{
                tcsv_load_danhsach(isEqual).ajax.url('tcsv_timkiem/'+JSON.stringify(isEqual)).load();
            }
        }
    }catch(e){
        thongbao('err_0')
    }
}
function tcsv_load_danhsach(searchData) {
    var containerHeight = $('.block-left').height();
    var table = $('#tcsv_load_danhsach').DataTable({
        processing: true,
        // deferRender: true,
        ajax: {
            type: 'get',
            url: 'tcsv_timkiem/'+searchData,
        },
        columns: [
            {
                name: "data",
                className: 'text-center',
                title: "",
                data: "id_taikhoan" ,
                render: function(data,type,row){
                    return '<i onclick = "tcsv_load_modal_img('+data+')" style = "color:blue" class="fa-solid fa-file-image"></i>'
                }
            },
            {
                name: "stt",
                className: 'text-center',
                title: "STT",
                data: null ,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1; // Tính STT dựa trên trang hiện tại
                },
            },

            {
                title: "ID",
                data: 'id_taikhoan',
                visible: false
            },
            {
                title: "MSSV",
                data: 'mssv'
            },
            {
                title: "Họ tên",
                data: 'hoten'
            },
            {
                title: "Ngày sinh",
                data: 'ngaysinh'
            },
            {
                title: "Giới tính",
                data: 'gioitinh',
                render: function(data,type,row){
                    if(data == 1){
                        return "Nữ";
                    }
                    return "Nam";
                }
            },
            {
                title: "Điện thoại",
                data: 'dienthoai'
            },
            {
                title: "Ngành",
                data: 'nganh'
            },
            // {
            //     title: "Chuyên ngành",
            //     data: 'tenchuyennganh'
            // },
            // {
            //     title: "Mã lớp",
            //     data: 'malop'
            // },
            {
                title: "Tên Lớp",
                data: 'tenlop'
            },
            {
                title: "Trạng thái",
                data: 'hoatdong',
                className: 'text-center',
                render: function(data,type,row){
                    if(data == 0){
                        return '<small class="badge badge-primary"><i class="fa-solid fa-user-check"></i>Đã nhập học</small>'
                    }
                    return '<small class="badge badge-danger"><i class="fa-solid fa-user-slash"></i>Rút hồ sơ</small>'
                }
            },

        ],

        "language": {
            "emptyTable": "Không tìm thấy sinh viên",
            "info": " _TOTAL_ sinh viên",
            "paginate": {
                "first": "Trang đầu",
                "last": "Trang cuối",
                "next": "Trang sau",
                "previous": "Trang trước"
            },
            "search": "Tìm kiếm:",
            "loadingRecords": "Đang tìm kiếm ... ",
            "lengthMenu": "Hiện thị _MENU_ SV",
            "infoEmpty": "",
        },
        "retrieve": true,
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": true,
        "responsive": false,
        // "dom": '<"top d-flex justify-content-between"i f>rt<"bottom"lp><"clear">',
        scrollY: containerHeight - 90,
    });
    return table;
}
async function tcsv_lammoi(){
    await tcsv_loadtimkiem_trong()
    await tcsv_loadtimkiem();
    var data = JSON.stringify(tcsv_isEqual(await tcsv_laygiatribandau(),0))
    tcsv_load_danhsach(data).ajax.url('tcsv_timkiem/'+data).load();
}
function modal_event_tcsv(){
    $('#modal_event_tcsv').show('slow');
}
async function tcsv_load_modal_img(id){
    let checkload = await tcsv_load_img(id);
    if(checkload == true){
        modal_event_tcsv();
    }else{
        thongbao('err_0')
    }
}
function tcsv_load_img(id){
    return new Promise(function(resolve,reject){
        $.ajax({
            url: "/admin24/tcsv_load_img/"+id+"/0",
            type:"get",
            success:function(data){
                var html = ""
                for (let i = 0; i < data.length; i++) {
                    html += '<div class="swiper-slide">'
                    html +=     '<div class="swiper-zoom-container">'
                    html +=         '<img class="img-slide-config" src="'+data[i].path_img+'">'
                    html +=     '</div>'
                    html += '</div>'
                }
                $('#tcsv_slider').html(html)
                resolve(true)
            }
        });
    });
}
function modal_event_tcsv_close(){
    $('#modal_event_tcsv').hide('slow');
}
async function tcsv_excel(){
    var originalData = await tcsv_laygiatribandau();
    var searchData = await tcsv_thongtintimkiem();
    var isEqual =  tcsv_isEqual(originalData,searchData);
    if( tcsv_reg() == 0){
        toastr.warning('Họ tên, CCCD, MSSV chứa ký tự đặc biệt');
    }else{
        if(isEqual['trangthai'] == 1){
            var search = JSON.stringify(isEqual);
            var row = tcsv_load_danhsach(search).rows().count();
            if( row > 0){
                window.location.href = "/admin24/tcsv_excel/"+search;
            }else{
                toastr.warning('Hãy đảm bảo tìm kiếm SV xuất Excel');
            }
        }else{
            toastr.warning('Vui lòng chọn một giá trị để tìm kiếm!!!');
        }
    }

}

// upload thông tin sinh viên
function Upload_ttsv(){
    $('#upload_ttsv_open').click();
}

$('#upload_ttsv_open').on('change', function(){
    $('#submit_Upload_ttsv_open').submit();
})

// function import_upload_ttsv(){
//     $('#submit_Upload_ttsv_open').submit();
// }

$('#submit_Upload_ttsv_open').on('submit', function(e){
    e.preventDefault();
    $('#modal_event').show();
    $.ajax({
        url: "/admin24/upload_ttsv",
        type:"POST",
        data: new FormData(this),
        contentType:false,
        processData:false,
        success:function(data){
            if(data == 'imp_0'){
                thongbao(data)
                $('#modal_event').hide();
            }else{
                thongbao(data.trangthai)
                var wb = XLSX.utils.book_new();
                var header = ['EMAIL', 'CCCD', 'HỌ TÊN', 'NGÀY SINH', 'GIỚI TÍNH', 'SĐT', 'MSSV', 'MÃ LỚP', 'GHI CHÚ'];
                var tdata = [header];
                data.rows.forEach((row, index) => {
                    if (index > 0) {
                        var rowData = [];
                        row.forEach(function (col) {
                            rowData.push(col)
                        });
                        tdata.push(rowData);
                    }
                });

                // Tạo sheet từ dữ liệu
                var ws = XLSX.utils.aoa_to_sheet(tdata);

                // Tự động điều chỉnh chiều rộng cột
                var colWidths = [];
                for (var i = 0; i < header.length; i++) {
                    var maxLength = header[i].length; // Độ dài tối đa của tiêu đề
                    data.rows.forEach(row => {
                        if (row[i] && row[i].toString().length > maxLength) {
                            maxLength = row[i].toString().length;
                        }
                    });
                    colWidths.push(maxLength + 2); // Thêm khoảng cách thêm cho cột
                }
                ws['!cols'] = colWidths.map(width => ({ wch: width }));

                // Tô màu hàng tiêu đề
                var headerCells = header.map((col, i) => XLSX.utils.encode_cell({r: 0, c: i})); // Tạo tham chiếu ô hàng tiêu đề

                headerCells.forEach(cellRef => {
                    var cell = ws[cellRef];
                    if (cell) {
                        // Kiểu dữ liệu cho ô
                        cell.s = cell.s || {};  // Đảm bảo ô có thuộc tính 's'
                        cell.s.fill = cell.s.fill || {};  // Đảm bảo thuộc tính fill tồn tại
                        cell.s.fill.fgColor = { rgb: "FFFF00" }; // Màu nền vàng
                        cell.s.font = cell.s.font || {}; // Đảm bảo thuộc tính font tồn tại
                        cell.s.font.bold = true; // Làm đậm chữ
                    }
                });

                // Thêm sheet vào workbook
                XLSX.utils.book_append_sheet(wb, ws, "Thongke");

                // // Thêm sheet thứ hai
                // var ws1 = XLSX.utils.aoa_to_sheet(tdata);
                // XLSX.utils.book_append_sheet(wb, ws1, "Thongke1");

                // Lưu file Excel
                const now = new Date();
                const timestamp = now.getTime();
                XLSX.writeFile(wb, "KQ"+timestamp+".xlsx");

            
                $('#modal_event').hide();
            }
            $('#upload_ttsv_open').val('')
        }
    });
})
//xuất excel
async function tcsv_dp_excel(){
    var originalData = await tcsv_laygiatribandau();
    var searchData = await tcsv_thongtintimkiem();
    var isEqual =  tcsv_isEqual(originalData,searchData);
    if( tcsv_reg() == 0){
        toastr.warning('Họ tên, CCCD, MSSV chứa ký tự đặc biệt');
    }else{
        if(isEqual['trangthai'] == 1){
            var search = JSON.stringify(isEqual);
            var row = tcsv_load_danhsach(search).rows().count();
            if( row > 0){
                window.location.href = "/admin24/tcsv_dp_excel/"+search;
            }else{
                toastr.warning('Hãy đảm bảo tìm kiếm SV xuất Excel');
            }
        }else{
            toastr.warning('Vui lòng chọn một giá trị để tìm kiếm!!!');
        }
    }

}