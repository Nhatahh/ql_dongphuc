$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(window).resize(function() {
        equalizeHeight();
    });
    // equalizeHeight();
    // $('#dsts_namtuyensinh').select2()
    // $('#dsts_kvut').select2()
    // $('#dsts_dtut').select2()
    // $('#dsts_namtotnghiep').select2()
    // $('#dsts_trangthai').select2()






    dsts_load_index();
})

async function dsts_load_index(){
    await open_preloader(0);//Mở Preloader (main.js)
    await loadtimkiem_trong() //(main.js)
    await dsts_loadtimkiem();
    await dsts_timkiem_danhsach(0);

    // var data = JSON.stringify(tcsv_isEqual(await tcsv_laygiatribandau(),0))
    // tcsv_load_danhsach(data).ajax.url('tcsv_timkiem/'+data).load();

    await equalizeHeight(); //Cân bằng 2 block trái và phải (main.js)
    await close_preloader(0); //Tắt Preloader (main.js)
}

function dsts_loadtimkiem(){
    return new Promise (function(resolve, reject){
        $.ajax({
            type: "get",
            url: "dsts_loadtimkiem",
            success: function (res) {
                $('#dsts_namtuyensinh').select2({
                    data: res.dsts_namtuyensinh
                })
                $('#dsts_dottuyensinh').select2({
                    data: res.dsts_dottuyensinh
                })
                $('#dsts_namtotnghiep').select2({
                    data: res.dsts_namtotnghiep
                })
                $('#dsts_tinh').select2({
                    data: res.dsts_tinh
                })

                $('#dsts_truongthpt').empty()
                $('#dsts_truongthpt').select2()

                $('#dsts_dknv').select2({
                    data: res.dsts_dknv
                })
                $('#dsts_gioitinh').select2({
                    data: res.dsts_gioitinh
                })
                resolve(true)
            }
        });
    })
}

function dsts_change_tinh(){
    $('#dsts_truongthpt').empty()
    var tinh =  $('#dsts_tinh').val()
    if( tinh > 0){
        $.ajax({
            type: "get",
            url: "dsts_change_tinh/"+tinh,
            success: function (res) {
                $('#dsts_truongthpt').select2({
                    data: res.dsts_truongthpt
                })
            }
        });
    }else{
        $('#dsts_truongthpt').select2()
    }
}

async function dsts_lammoi(){
    await loadtimkiem_trong() //(main.js)
    await xacthuckytudacbiet('search')
    await dsts_loadtimkiem();
    await dsts_timkiem_danhsach(0);
}

async function dsts_timkiem(){
    await xacthuckytudacbiet('search')
    var ngaydangky1 = $('#dsts_ngaydangky1').val();
    var ngaydangky2 = $('#dsts_ngaydangky2').val();
    if(namts = $('#dsts_namtuyensinh').val() == 0){
        toastr.warning('Vui lòng chọn Năm tuyển sinh')
    }else{
        if((ngaydangky1 && ngaydangky2) || (!ngaydangky1 && !ngaydangky2) ){
            if(ngaydangky2 >= ngaydangky1 ){
                if(await xacthuckytudacbiet('search') == 1){
                    await xacthuckytudacbiet('search')
                }else{
                    var data = await dsts_timkiem_data()
                    await dsts_timkiem_danhsach(data)
                }
            }else{
                $("#error_dsts_ngaydangky1").text("Ngày bắt đầu lớn hơn ngày kết thúc")
                $("#error_dsts_ngaydangky2").text("Ngày bắt đầu lớn hơn ngày kết thúc")
            }
        }else{
            if(!ngaydangky1){
                $("#error_dsts_ngaydangky1").text("Ngày không được trống")
            }
            if(!ngaydangky2){
                $("#error_dsts_ngaydangky2").text("Ngày không được trống")
            }
        }
    }
}

function dsts_timkiem_data(){
    return new Promise(function(resolve,reject){
        var namts = $('#dsts_namtuyensinh').val();
        var dotts = $('#dsts_dottuyensinh').val();
        var namtn = $('#dsts_namtotnghiep').val();
        var tinh = $('#dsts_tinh').val();
        var truong = $('#dsts_truongthpt').val();
        var gioitinh = $('#dsts_gioitinh').val();
        if(truong == 0 || truong == undefined){
            truong = 0;
        }
        var ngaydangky1 = $('#dsts_ngaydangky1').val();
        var ngaydangky2 = $('#dsts_ngaydangky2').val();
        if(!ngaydangky1){
            ngaydangky1 = 0;
        }
        if(!ngaydangky2){
            ngaydangky2 = 0;
        }
        $.ajax({
            url: "dsts_loadds/"+namts+"/"+dotts+"/"+namtn+"/"+tinh+"/"+truong+"/"+ngaydangky1+"/"+ngaydangky2+"/"+gioitinh,
            type:"get",
            success:function(data){
                resolve(data)
            }
        });
    });
}

function dsts_timkiem_danhsach(data){
    return new Promise (function(resolve, reject){
        var containerHeight = $('.block-right').height();
        var table =  $('#dsts_loadds').DataTable({
            processing: true,
            data: data,
            columns: [
                {
                    name: "stt",
                    className: 'text-center',
                    title: "STT",
                    data: 'stt' ,
                },
                {
                    name: "id_taikhoan",
                    className: 'text-center',
                    title: "IDTS",
                    data: 'id_taikhoan' ,
                },
                {
                    name: "cccd",
                    className: 'text-center',
                    title: "CCCD",
                    data: 'cccd'  ,
                },

                {
                    name: "hoten",
                    className: 'text-left',
                    title: "Họ tên",
                    data: 'hoten'  ,
                },
                {
                    name: "ngaysinh",
                    className: 'text-center',
                    title: "Ngày sinh",
                    data: 'ngaysinh'  ,
                },
                {
                    name: "gioitinh",
                    className: 'text-center',
                    title: "Giới tính",
                    data: 'gioitinh'  ,
                    render: function(data, type, row){
                        if(data == 1){
                            return "Nữ"
                        }
                        return "Nam"
                    }
                },
                {
                    name: "name_province",
                    className: 'text-center',
                    title: "Tỉnh",
                    data: 'name_province'  ,
                },
                {
                    name: "name_school",
                    className: 'text-center',
                    title: "Trường THPT",
                    data: 'name_school'  ,
                },
                {
                    name: "namtotnghiep",
                    className: 'text-center',
                    title: "Năm TN",
                    data: 'namtotnghiep'  ,
                },

            ],
            language: {
                emptyTable: "Không tìm thấy thí sinh",
                info: "_TOTAL_ thí sinh",
                paginate: {
                    first: "Trang đầu",
                    last: "Trang cuối",
                    next: "Trang sau",
                    previous: "Trang trước"
                },
                search: "Tìm kiếm:",
                loadingRecords: "Đang tìm kiếm ... ",
                lengthMenu: "Hiện thị _MENU_ thí sinh",
                infoEmpty: "",
            },
            retrieve: true,
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: false,
            info: true,
            autoWidth: true,
            responsive: false,
            scrollY: containerHeight - 150,
        });
        if ($.fn.dataTable.isDataTable('#dsts_loadds')) {
            table.clear();
            table.rows.add(data); // Add new data
            table.draw(); // Redraw the table
        }
        resolve(table);
    });
}



function dsts_excel(){
    var namts = $('#dsts_namtuyensinh').val();
    var dotts = $('#dsts_dottuyensinh').val();
    var namtn = $('#dsts_namtotnghiep').val();
    var tinh = $('#dsts_tinh').val();
    var truong = $('#dsts_truongthpt').val();
    var gioitinh = $('#dsts_gioitinh').val();
    if(truong == 0 || truong == undefined){
        truong = 0;
    }
    var ngaydangky1 = $('#dsts_ngaydangky1').val();
    var ngaydangky2 = $('#dsts_ngaydangky2').val();
    if(!ngaydangky1){
        ngaydangky1 = 0;
    }
    if(!ngaydangky2){
        ngaydangky2 = 0;
    }
    window.open("dsts_excel/"+namts+"/"+dotts+"/"+namtn+"/"+tinh+"/"+truong+"/"+ngaydangky1+"/"+ngaydangky2+"/"+gioitinh, '_blank');
}































