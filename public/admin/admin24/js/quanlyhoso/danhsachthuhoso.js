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
    thuhoso_loadtieude()
})

async function load_index(){
    await open_preloader();//Mở Preloader (main.js)

    await equalizeHeight(); //Cân bằng 2 block trái và phải (main.js)
    await close_preloader(); //Tắt Preloader (main.js)
}

function thuhoso_loadtieude() {
    $.ajax({
        url: 'thuhoso_load_tb',
        method: 'GET',
        // dataType: 'json',
        success: function (data) {

            // Lấy tất cả các keys từ object đầu tiên để làm header
            var columns = Object.keys(data[0]).map(function(key) {
                return { data: key, title: key };
            });

            // Khởi tạo DataTable với columns tự động lấy từ dữ liệu
            $('#thuhoso_load_danhsach').DataTable({
                data: data,
                columns: columns,

            });
        },
        error: function (xhr, status, error) {
            console.error('Error loading data:', error);
        }
    });
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
// function tcsv_loadtimkiem_trong(){
//     return new Promise (function(resolve, reject){
//         var tcsv = document.getElementsByClassName('tcsv')
//         for (let i = 0; i < tcsv.length; i++) {
//             if($(tcsv[i]).is('input')){
//                 $(tcsv[i]).val('')
//             }else{
//                 $(tcsv[i]).empty();
//                 $(tcsv[i]).select2()
//             }
//         }
//         resolve(true)
//     })
// }
// function tcsv_laygiatribandau(){
//     return new Promise (function(resolve, reject){
//         let data = {};
//         var tcsv = document.getElementsByClassName('tcsv')
//         for (let i = 0; i < tcsv.length; i++) {
//             var id = $(tcsv[i]).attr('id')
//             data[id] = $(tcsv[i]).attr('val-def');
//         }
//         resolve(data);
//     })
// }
// function tcsv_thongtintimkiem(){
//     return new Promise (function(resolve, reject){
//         let data = {};
//         var tcsv = document.getElementsByClassName('tcsv')
//         for (let i = 0; i < tcsv.length; i++) {
//             var id = $(tcsv[i]).attr('id')
//             data[id] = $(tcsv[i]).val();
//         }
//         resolve(data);
//     })
// }
// function tcsv_isEqual(originalData,searchData){
//     if(searchData == 0 || JSON.stringify(originalData) === JSON.stringify(searchData) ){
//         originalData['trangthai'] = 0;
//         return originalData;
//     }else{
//         searchData['trangthai'] = 1;
//         return searchData;
//     }
// }
// function tcsv_reg(){
//     let reg = /[!@#$%^&*(),.?":{}|<>]+/
//     let hoten = "",cccd = "",mssv = ""
//     reg.test($('#tcsv_hoten').val()) == false ? hoten = $('#tcsv_hoten').val() : hoten = "false_not";
//     reg.test($('#tcsv_cccd').val()) == false ? cccd = $('#tcsv_cccd').val() : cccd = 'false_not';
//     reg.test($('#tcsv_mssv').val()) == false ? mssv = $('#tcsv_mssv').val() : mssv = 'false_not';
//     if( hoten == 'false_not' || cccd == 'false_not' || mssv == 'false_not'){
//         return 0;
//     }
//     return 1;
// }
// async function tcsv_timkiem(){
//     try{
//         var originalData = await tcsv_laygiatribandau();
//         var searchData = await tcsv_thongtintimkiem();
//         var isEqual =  tcsv_isEqual(originalData,searchData)
//         if(isEqual['trangthai'] == 0){
//             toastr.warning('Vui lòng chọn một giá trị để tìm kiếm!!!');
//             var isEqual =  tcsv_isEqual(originalData,0)
//             tcsv_load_danhsach(searchData).ajax.url('tcsv_timkiem/'+JSON.stringify(isEqual)).load();
//         }else{
//             if( tcsv_reg() == 0){
//                 toastr.warning('Họ tên, CCCD, MSSV chứa ký tự đặc biệt');
//             }else{
//                 tcsv_load_danhsach(isEqual).ajax.url('tcsv_timkiem/'+JSON.stringify(isEqual)).load();
//             }
//         }
//     }catch(e){
//         thongbao('err_0')
//     }
// }
// function tcsv_load_danhsach(searchData) {
//     var containerHeight = $('.block-left').height();
//     var table = $('#tcsv_load_danhsach').DataTable({
//         processing: true,
//         // deferRender: true,
//         ajax: {
//             type: 'get',
//             url: 'tcsv_timkiem/'+searchData,
//         },
//         columns: [
//             {
//                 name: "data",
//                 className: 'text-center',
//                 title: "",
//                 data: "id_taikhoan" ,
//                 render: function(data,type,row){
//                     return '<i onclick = "tcsv_load_modal_img('+data+')" style = "color:blue" class="fa-solid fa-file-image"></i>'
//                 }
//             },
//             {
//                 name: "stt",
//                 className: 'text-center',
//                 title: "STT",
//                 data: null ,
//                 render: function (data, type, row, meta) {
//                     return meta.row + meta.settings._iDisplayStart + 1; // Tính STT dựa trên trang hiện tại
//                 },
//             },

//             {
//                 title: "ID",
//                 data: 'id_taikhoan',
//                 visible: false
//             },
//             {
//                 title: "MSSV",
//                 data: 'mssv'
//             },
//             {
//                 title: "Họ tên",
//                 data: 'hoten'
//             },
//             {
//                 title: "Ngày sinh",
//                 data: 'ngaysinh'
//             },
//             {
//                 title: "Giới tính",
//                 data: 'gioitinh',
//                 render: function(data,type,row){
//                     if(data == 1){
//                         return "Nữ";
//                     }
//                     return "Nam";
//                 }
//             },
//             {
//                 title: "Điện thoại",
//                 data: 'dienthoai'
//             },
//             {
//                 title: "Ngành",
//                 data: 'nganh'
//             },
//             // {
//             //     title: "Chuyên ngành",
//             //     data: 'tenchuyennganh'
//             // },
//             // {
//             //     title: "Mã lớp",
//             //     data: 'malop'
//             // },
//             {
//                 title: "Tên Lớp",
//                 data: 'tenlop'
//             },
//             {
//                 title: "Trạng thái",
//                 data: 'hoatdong',
//                 className: 'text-center',
//                 render: function(data,type,row){
//                     if(data == 0){
//                         return '<small class="badge badge-primary"><i class="fa-solid fa-user-check"></i>Đã nhập học</small>'
//                     }
//                     return '<small class="badge badge-danger"><i class="fa-solid fa-user-slash"></i>Rút hồ sơ</small>'
//                 }
//             },
//         ],

//         "language": {
//             "emptyTable": "Không tìm thấy sinh viên",
//             "info": " _TOTAL_ sinh viên",
//             "paginate": {
//                 "first": "Trang đầu",
//                 "last": "Trang cuối",
//                 "next": "Trang sau",
//                 "previous": "Trang trước"
//             },
//             "search": "Tìm kiếm:",
//             "loadingRecords": "Đang tìm kiếm ... ",
//             "lengthMenu": "Hiện thị _MENU_ SV",
//             "infoEmpty": "",
//         },
//         "retrieve": true,
//         "paging": false,
//         "lengthChange": false,
//         "searching": true,
//         "ordering": false,
//         "info": true,
//         "autoWidth": true,
//         "responsive": false,
//         // "dom": '<"top d-flex justify-content-between"i f>rt<"bottom"lp><"clear">',
//         scrollY: containerHeight - 10,
//     });
//     return table;
// }
// async function tcsv_lammoi(){
//     await tcsv_loadtimkiem_trong()
//     await tcsv_loadtimkiem();
//     var data = JSON.stringify(tcsv_isEqual(await tcsv_laygiatribandau(),0))
//     tcsv_load_danhsach(data).ajax.url('tcsv_timkiem/'+data).load();
// }
// function modal_event_tcsv(){
//     $('#modal_event_tcsv').show('slow');
// }
// async function tcsv_load_modal_img(id){
//     let checkload = await tcsv_load_img(id);
//     if(checkload == true){
//         modal_event_tcsv();
//     }else{
//         thongbao('err_0')
//     }
// }
// function tcsv_load_img(id){
//     return new Promise(function(resolve,reject){
//         $.ajax({
//             url: "/admin24/tcsv_load_img/"+id+"/0",
//             type:"get",
//             success:function(data){
//                 var html = ""
//                 for (let i = 0; i < data.length; i++) {
//                     html += '<div class="swiper-slide">'
//                     html +=     '<div class="swiper-zoom-container">'
//                     html +=         '<img class="img-slide-config" src="'+data[i].path_img+'">'
//                     html +=     '</div>'
//                     html += '</div>'
//                 }
//                 $('#tcsv_slider').html(html)
//                 resolve(true)
//             }
//         });
//     });
// }
// function modal_event_tcsv_close(){
//     $('#modal_event_tcsv').hide('slow');
// }
// async function tcsv_excel(){
//     var originalData = await tcsv_laygiatribandau();
//     var searchData = await tcsv_thongtintimkiem();
//     var isEqual =  tcsv_isEqual(originalData,searchData);
//     if( tcsv_reg() == 0){
//         toastr.warning('Họ tên, CCCD, MSSV chứa ký tự đặc biệt');
//     }else{
//         if(isEqual['trangthai'] == 1){
//             var search = JSON.stringify(isEqual);
//             var row = tcsv_load_danhsach(search).rows().count();
//             if( row > 0){
//                 window.location.href = "/admin24/tcsv_excel/"+search;
//             }else{
//                 toastr.warning('Hãy đảm bảo tìm kiếm SV xuất Excel');
//             }
//         }else{
//             toastr.warning('Vui lòng chọn một giá trị để tìm kiếm!!!');
//         }
//     }

// }
