$(document).ready(function () {
    $("#thxt_nguyenvong").select2();
    $("#thxt_dotxt").select2();
    $("#thxt_dotts").select2();
    $("#thxt_phodiem_nguyenvong").select2();
    $("#thxt_phodiem_nganh").select2();
    $("#thxt_dotts_xettuyen").select2();
    $("#thxt_cachxet").select2();


    $(document).on('keyup', function(e) {
        // Kiểm tra nếu phím ESC được nhấn (keyCode 27)
        if (e.key === 'Escape' || e.key === 'Esc') {
            // Ẩn modal bằng hiệu ứng 'slow'
            $('#modal_phodiem').hide('slow');
        }
    });


    thongketheodotxettuyen();

    // laygiatritimkiem(0, function(result) {
    //     listnguyenvongDatatables().ajax.url("/admin24/danhsachnguyenvong/"+ result.noidung).load();;
    // });
    // laygiatritimkiem(0, function(result) {
    //     listthisinhtrungtuyenDatatables().ajax.url("/admin24/danhsachnguyenvong/"+ result.noidung).load();;
    // });

    // thongketrungtuyentheodotts(0).ajax.url("/admin24/thongketrungtuyentheodotts/0").load();
    // danhsachtrungtuyentheodotts(0).ajax.url("/admin24/danhsachtrungtuyentheodotts/0").load();
})
function danhsachtrungtuyentheodotts(iddot){
    var myDataTable = $("#thxt_danhsachtrungtuyentheodotts").DataTable({
        processing: true,
        // serverSide: true,
        deferRender: true,
        ajax: "/admin24/danhsachtrungtuyentheodotts/"+iddot,
        columns: [
            {
                title: "STT",
                className: 'text-center',
                data: "sothutu",
            },
            {
                name: "idts",
                className: 'text-center',
                title: "IDTS",
                data: "idts",
            },
            {
                name: "idnv",
                className: 'text-center',
                title: "IDNV",
                data: "idnv",
            },
            {
                name: "hoten",
                className: 'text-center',
                title: "Họ tên",
                data: "hoten",
            },
            {
                name: "nganhtrungtuyen",
                title: "Chuyên ngành/Ngành",
                data: "nganhtrungtuyen",
            },
            {
                name: "TTNV",
                className: 'text-center',
                title: "TTNV",
                data: "thutu",
            },

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
        ordering: false,
        info: true,
        autoWidth: true,
        responsive: true,
        select: true,
    });
    return myDataTable;
}

//Sử dụng Datatable lấy nội dung từ laygiatritimkiem;
function thongketrungtuyentheodotts(iddot){
    var myDataTable = $("#thxt_thongketrungtuyentheodotts").DataTable({
        processing: true,
        // serverSide: true,
        deferRender: true,
        ajax: "/admin24/thongketrungtuyentheodotts/"+iddot,
        columns: [
            {
                title: "STT",
                className: 'text-center',
                data: "sothutu",
            },
            {
                name: "tenchuyennganh",
                title: "Chuyên ngành/Ngành",
                data: "tenchuyennganh",
            },
            {
                name: "chitieu",
                className: 'text-center',
                title: "Chỉ tiêu",
                data: "chitieu",
            },
            {
                name: "soluongdangky",
                className: 'text-center',
                title: "Đăng ký",
                data: "soluongdangky",
            },
            {
                name: "soluongnv1",
                className: 'text-center',
                title: "NV1",
                data: "soluongnv1",
            },
            {
                name: "tilenv1",
                className: 'text-center',
                title: "TLNV1",
                data: "tilenv1",
            },
            {
                name: "soluongnv2",
                className: 'text-center',
                title: "NV2",
                data: "soluongnv2",
            },
            {
                name: "soluongnv3",
                className: 'text-center',
                title: "NV3",
                data: "soluongnv3",
            },

            {
                name: "soluongtrungtuyen",
                className: 'text-center',
                title: "TT",
                data: "soluongtrungtuyen",
            },
            {
                name: "tiletrungtuyen",
                className: 'text-center',
                title: "TLTT",
                data: "tiletrungtuyen",
            },
            {
                name: "diemchuan",
                className: 'text-center',
                title: "Điểm",
                data: "diemchuan",
            },

            {
                name: "soluongxacnhan",
                className: 'text-center',
                title: "Xác nhận",
                data: "soluongxacnhan",

            },
            {
                name: "tilexacnhan",
                className: 'text-center',
                title: "TLXN",
                data: "tilexacnhan",

            },



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
            emptyTable: "Không tìm thấy ngành/chuyên ngành",
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
        paging: false,
        lengthChange: false,
        searching: true,
        ordering: false,
        info: true,
        autoWidth: false,
        responsive: false,
        select: true,


    });

    return myDataTable;
}

$("#thxt_dotts").on('change',function(){
    var iddot = $(this).val();
    thongketrungtuyentheodotts(iddot).ajax.url("/admin24/thongketrungtuyentheodotts/"+iddot).load();
    var id_dom = "thxt_danhsachtrungtuyentheodotts"
    danhsachtrungtuyenchinhthuc(id_dom,iddot,0,0).ajax.url("/admin24/danhsachtrungtuyenchinhthuc/"+iddot+"/0/0").load();
    // danhsachtrungtuyentheodotts(iddot).ajax.url("/admin24/danhsachtrungtuyentheodotts/"+iddot).load();
})

$("#xuatexcelthongketrungtuyentheodotts").on('click',function(){
    var iddot = $("#thxt_dotts").val();
    var rowCount = thongketrungtuyentheodotts(iddot).rows().count();
    if(rowCount > 1){
        window.location.href = '/admin24/xuatexcelthongketrungtuyentheodotts/'+iddot;
    }else{
        thongbao('table_0')
    }
})

function load_phodiemtheodotts(iddot,idnguyenvong,khoangdiem,id_nganh){
    $('#tam_phodiem-chart-canvas').empty();
    $('#tam_phodiem-chart-canvas').append('<canvas id="phodiem-chart-canvas" height="100%"    style="height: 600px; display: block;" class="chartjs-render-monitor" width="713">');
    $.ajax({
        url: "/admin24/phodiemtheodotts/"+iddot+"/"+idnguyenvong+"/"+khoangdiem+"/"+id_nganh,
        type: 'get',
        success: function (res) {
            if (myChart) {
                myChart.destroy();
            }
            var Ojbres = JSON.parse(res);
            var labels = Ojbres.data.map(function (item) {
                return item.label;
            });
            var data = Ojbres.data.map(function (item) {
                return item.value;
            });

            var ctx = document.getElementById('phodiem-chart-canvas').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Khoảng điểm',
                        data: data,
                        backgroundColor: 'rgba(250, 247, 247, 1)',
                        borderColor: 'black',
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            labels: {
                                fontColor: "white",
                                fontSize: 18
                            }
                        },
                        datalabels: {  // Cấu hình plugin datalabels để ẩn đi label của dataset
                            display: true
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    datasetFill: false,
                    scales: {
                        x: {
                            grid: {
                                display: false, // Ẩn lưới của trục x
                            },
                            stacked: true,
                        },
                        y: {
                            grid: {
                                display: false, // Ẩn lưới của trục x
                            },
                            stacked: true,
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        }
    })
}

function load_phodiem_nganh(iddot){
    $.ajax({
        url: "/admin24/load_phodiem_nganh/"+iddot,
        type: 'get',
        success: function (res) {
            $("#thxt_phodiem_nganh").select2({
                data: res
            });
        }
    })
}

$("#phodiemtheodotts").on('click',function(){
    let iddot = $("#thxt_dotts").val();
    //Load ngành
    if($("#thxt_dotts").val() == -1){
        thongbao('dot_-1')
    }else{
        $('#modal_phodiem').show('slow');
        load_phodiem_nganh(iddot)
        let idnguyenvong = 0
        let khoangdiem = 0.5
        let id_nganh = 0
        load_phodiemtheodotts(iddot,idnguyenvong,khoangdiem,id_nganh)
    }
})

$("#thxt_phodiem_nguyenvong").on('change',function(){
    let iddot = $("#thxt_dotts").val();
    let idnguyenvong = $(this).val();
    let khoangdiem =  $("#thxt_phodiem_khoangdiem").val();
    let id_nganh = $("#thxt_phodiem_nganh").val();
    load_phodiemtheodotts(iddot,idnguyenvong,khoangdiem,id_nganh)
})

$("#thxt_phodiem_khoangdiem").on('change',function(){
    let iddot = $("#thxt_dotts").val();
    let idnguyenvong = $("#thxt_phodiem_nguyenvong").val();
    let khoangdiem = $(this).val();
    let id_nganh = $("#thxt_phodiem_nganh").val();
    load_phodiemtheodotts(iddot,idnguyenvong,khoangdiem,id_nganh)
})

$("#thxt_phodiem_nganh").on('change',function(){
    let iddot = $("#thxt_dotts").val();
    let idnguyenvong = $("#thxt_phodiem_nguyenvong").val();
    let khoangdiem =  $("#thxt_phodiem_khoangdiem").val();
    let id_nganh = $(this).val();
    load_phodiemtheodotts(iddot,idnguyenvong,khoangdiem,id_nganh)
})

$("#themdotxettuyen_popup").on('click',function(){
    $('#modal_dotxettuyen').show('slow');

})

$("#laydulieutheodot").on('click',function(){
    let iddotts = $("#thxt_dotts_xettuyen").val();
    let iddotxt = $("#thxt_dotxt").val();
    if(iddotts == -1 || iddotxt == -1){
        thongbao('dot_-1')
    }else{
        $.ajax({
            type: "get",
            url: "/admin24/laydulieutheodot/"+iddotts+"/"+iddotxt,
            success:function(res){
                if(res.trangthai == 1){
                    toastr.success('Đợt này có '+res.insertedRows1+ ' Nguyện vọng và '+res.insertedRows2+' ngành/chuyên ngành')
                }else{
                    toastr.error("Hệ thống bị lỗi")
                }
            }
        });
    }

})

$("#khoadotxettuyen").on('click',function(){
    let iddotxt = $("#thxt_dotxt").val();
    if(iddotxt == -1){
        thongbao('dot_-1')
    }else{
        $.ajax({
            type: "get",
            url: "/admin24/khoadotxettuyen/"+iddotxt,
            success:function(res){
                if(res.trangthai == 1){
                    toastr.success('Đã khóa thành công!')
                }else{
                    toastr.error("Hệ thống bị lỗi")
                }
            }
        });
    }

})


$("#danhsach_thisinh_locao").on('click',function(){
    let iddotxt = $("#thxt_dotxt").val();
    if(iddotxt == -1){
        thongbao('dot_-1')
    }else{
        window.location.href = '/admin24/danhsach_thisinh_locao/'+iddotxt;
    }
})



$("#xuatdanhsachlocao").on('click',function(){
    let iddotxt = $("#thxt_dotxt").val();
    if(iddotxt == -1){
        thongbao('dot_-1')
    }else{
        window.location.href = '/admin24/xuatdanhsachlocao/'+iddotxt;
    }

})

$("#thongkeketqualocao").on('click',function(){
    let iddotxt = $("#thxt_dotxt").val();
    if(iddotxt == -1){
        thongbao('dot_-1')
    }else{
        window.location.href = '/admin24/thongkeketqualocao/'+iddotxt;
    }

})


$("#importketquanhom").on('click',function(){
    $("#ketquanhom").click();
})
$("#ketquanhom").on('change',function(){
    $('#submit_importketquanhom').submit();
})
$("#submit_importketquanhom").on('submit',function(e){
    e.preventDefault();
    let iddotxt = $("#thxt_dotxt").val();
    if(iddotxt == -1){
        thongbao('dot_-1')
        $('#ketquanhom').val('');
    }else{
        var kiemtradinhdang = kiemtrafileupload('ketquanhom',1)
        if(kiemtradinhdang != 1){
            thongbao(kiemtradinhdang)
            $('#ketquanbo').val('');
        }else{
           var formData = new FormData(this)
           formData.append('iddotxt', iddotxt);
            $.ajax({
                url: "/admin24/submit_importketquanhom",
                type:"post",
                data: formData,
                contentType:false,
                processData:false,
                success:function(data){
                    thongbao(data)
                    $('#ketquanhom').val('');
                    laytieudotcacdotxt()
                }
            });
        }
    }
});


$("#importketquabo").on('click',function(){
    $("#ketquabo").click();
})
$("#ketquabo").on('change',function(){
    $('#submit_importketquabo').submit();
})
$("#submit_importketquabo").on('submit',function(e){
    e.preventDefault();
    let iddotxt = $("#thxt_dotxt").val();
    if(iddotxt == -1){
        thongbao('dot_-1')
        $('#ketquanbo').val('');
    }else{
        var kiemtradinhdang = kiemtrafileupload('ketquabo',1)
        if(kiemtradinhdang != 1){
            thongbao(kiemtradinhdang)
            $('#ketquanbo').val('');
        }else{
           var formData = new FormData(this)
           formData.append('iddotxt', iddotxt);
            $.ajax({
                url: "/admin24/submit_importketquabo",
                type:"post",
                data: formData,
                contentType:false,
                processData:false,
                success:function(data){
                    thongbao(data)
                    $('#ketquanbo').val('');
                    laytieudotcacdotxt()
                }
            });
        }
    }
});




// function thongketheodotxettuyen(iddotts,iddotxt){
//     var myDataTable = $("#thxt_thongketheodotxettuyen").DataTable({
//         processing: true,
//         deferRender: true,
//         ajax: "/admin24/thongketheodotxettuyen/"+iddotts+"/"+iddotxt,
//         columns: [
//             {
//                 title: "STT",
//                 className: 'text-center',
//                 data: "sothutu",
//             },
//             {
//                 name: "tenchuyennganh",
//                 title: "Chuyên ngành/Ngành",
//                 data: "tenchuyennganh",
//             },
//             {
//                 name: "nv1",
//                 title: "NV1",
//                 data: "nv1",
//             },
//             {
//                 name: "nv2",
//                 title: "NV2",
//                 data: "nv2",
//             },
//             {
//                 name: "nv3",
//                 title: "NV3",
//                 data: "nv3",
//             },
//             {
//                 name: "",
//                 title: "Chỉ tiêu",
//                 className: 'text-center',
//                 data: "soluong_chuyennganh",
//             },
//             {
//                 name: "soluong_chuyennganh",
//                 className: 'text-center',
//                 title: "Số lượng",
//                 data: "soluong_chuyennganh",
//                 render: function (data, type, row) {
//                     if(row.id == -1000){
//                         var disabled = "disabled";
//                         var lop = "";
//                     } else {
//                         var lop = "thxt_capnhatsoluongtheonganh";
//                     }
//                     return "<input id_nganh='" + row.id_chuyennganh + "' class='" + lop + "' " + disabled + " onchange='thxt_capnhatsoluongtheonganh(" + row.id + ")' id='thxt_capnhatsoluongtheonganh" + row.id + "' style='width:30px; height:inherit; background-color: inherit; border: none;' value='" + data + "'>";
//                 }
//             },

//             {
//                 name: "soluong_chuyennganh",
//                 title: "Điểm",
//                 data: 'soluong_chuyennganh',
//             },
//             {
//                 name: "soluong_chuyennganh",
//                 title: "Điểm",
//                 data: 'soluong_chuyennganh',
//             },
//             {
//                 name: "soluong_chuyennganh",
//                 title: "Điểm",
//                 data: 'soluong_chuyennganh',
//             },
//             {
//                 name: "soluong_chuyennganh",
//                 title: "Điểm",
//                 data: 'soluong_chuyennganh',
//             },
//             {
//                 name: "soluong_chuyennganh",
//                 title: "Điểm",
//                 data: 'soluong_chuyennganh',
//             },
//             {
//                 name: "soluong_chuyennganh",
//                 title: "Điểm",
//                 data: 'soluong_chuyennganh',
//             },
//             {
//                 name: "soluong_chuyennganh",
//                 title: "Điểm",
//                 data: 'soluong_chuyennganh',
//             },
//             {
//                 name: "soluong_chuyennganh",
//                 title: "Điểm",
//                 data: 'soluong_chuyennganh',
//             },
//             {
//                 name: "soluong_chuyennganh",
//                 title: "Điểm",
//                 data: 'soluong_chuyennganh',
//             },
//             {
//                 name: "soluong_chuyennganh",
//                 title: "Điểm",
//                 data: 'soluong_chuyennganh',
//             },
//             {
//                 name: "soluong_chuyennganh",
//                 title: "Điểm",
//                 data: 'soluong_chuyennganh',
//             },
//             {
//                 name: "soluong_chuyennganh",
//                 title: "Điểm",
//                 data: 'soluong_chuyennganh',
//             },
//             {
//                 name: "soluong_chuyennganh",
//                 title: "Điểm",
//                 data: 'soluong_chuyennganh',
//             },
//             {
//                 name: "nv3",
//                 title: "Trúng tuyển",
//                 data: "nv3",
//                 render: function(id, type, row){
//                     return '<span id="trungtuyen' + row.id_chuyennganh + '"></span>';
//                 }
//             },
//             {
//                 name: "nv3",
//                 title: "Điểm chuẩn",
//                 data: "nv3",
//                 render: function(id, type, row){
//                     return '<span id="diemchuan' + row.id_chuyennganh + '"></span>';
//                 }
//             },
//         ],

//         scrollX: true, // Bật thanh cuộn ngang
//         fixedColumns: {
//             leftColumns: 2 // Cố định 2 cột đầu tiên
//         },
//         scrollCollapse: true,

//         language: {
//             emptyTable: "Không tìm thấy ngành/chuyên ngành",
//             info: " _START_ / _END_ trên _TOTAL_",
//             paginate: {
//                 first: "Trang đầu",
//                 last: "Trang cuối",
//                 next: "Trang sau",
//                 previous: "Trang trước",
//             },
//             search: "Tìm kiếm:",
//             loadingRecords: "Đang tìm kiếm ... ",
//             lengthMenu: "Hiện thị _MENU_",
//             infoEmpty: "",
//         },
//         paging: false,
//         lengthChange: false,
//         searching: false,
//         ordering: false,
//         info: false,
//         autoWidth: false, // Tắt tự động điều chỉnh chiều rộng cột
//     });

//     return myDataTable;
// }

function laytieudotcacdotxt(){
    return new Promise(function(resolve, reject) {
        $.ajax({
            url: "/admin24/laytieudotcacdotxt",
            type: 'post',
            success: function (html) {
                resolve(html)
            }
        });
    });
}


async function thongketheodotxettuyen(){
    //Bước 0: Empty Table
    $("#thxt_thongketheodotxettuyen_remove").empty();
    $("#thxt_thongketheodotxettuyen_remove").append('<table class="row-border table-hover table-striped" style="width:100%"  id="thxt_thongketheodotxettuyen"></table>');
    //B1:
    //Thêm tiêu đề
    var tieude = await laytieudotcacdotxt();
    $("#thxt_thongketheodotxettuyen").append(tieude)
    //B2:
// var noidung = laynoidungcacdotxt();
// $("#thxt_thongketheodotxettuyen").append(noidung)
//B3:
    $("#thxt_thongketheodotxettuyen").DataTable({
        processing: true,
        deferRender: true,
        scrollX: true, // Bật thanh cuộn ngang
        fixedColumns: {
            leftColumns: 5 // Cố định 5 cột đầu tiên
        },
        scrollCollapse: true,
        columnDefs: [
            {
                targets: '_all',
                className: "text-center"
            }
        ],
        language: {
            emptyTable: "Không tìm thấy ngành/chuyên ngành",
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
        paging: false,
        lengthChange: false,
        searching: false,
        ordering: false,
        info: false,
        autoWidth: true, // Tắt tự động điều chỉnh chiều rộng cột
    });
}


function diemlocao(dotts,dotxt,nganh,idphuongthuc){
    var value = $('#diemlocao-dotts'+dotts+'-dotxt'+dotxt+'-nganh'+nganh+'-phuongthuc'+idphuongthuc).val();
    $.ajax({
        url: "/admin24/diemlocao",
        type: 'post',
        data: {
            dotts  : dotts,
            dotxt  : dotxt,
            nganh  : nganh,
            idphuongthuc: idphuongthuc,
            value  : value,
        },
        success: function (res) {
            if(res == 'err_0'){
                thongbao(res)
            }else{
                for (let i = 0; i < res.length; i++) {
                    $('#trungtuyen-dotts'+dotts+'-dotxt'+dotxt+'-phuongthuc2-nganh'+res[i].id_chuyennganh).text(res[i].trungtuyenthpt)
                    $('#diemchuan-dotts'+dotts+'-dotxt'+dotxt+'-phuongthuc2-nganh'+res[i].id_chuyennganh).text(res[i].diemchuanthpt)
                    $('#trungtuyen-dotts'+dotts+'-dotxt'+dotxt+'-phuongthuc1-nganh'+res[i].id_chuyennganh).text(res[i].trungtuyenhocba)
                    $('#trungtuyensom-dotts'+dotts+'-dotxt'+dotxt+'-phuongthuc1-nganh'+res[i].id_chuyennganh).text(res[i].trungtuyensom)
                    $('#diemchuan-dotts'+dotts+'-dotxt'+dotxt+'-phuongthuc1-nganh'+res[i].id_chuyennganh).text(res[i].diemchuanhocba)
                    $('#tong-dotts'+dotts+'-dotxt'+dotxt+'-nganh'+res[i].id_chuyennganh).text(res[i].tong)
                    $('#tile-dotts'+dotts+'-dotxt'+dotxt+'-nganh'+res[i].id_chuyennganh).text(Math.round(res[i].tong/$('#chitieu-dotts'+dotts+'-nganh'+res[i].id_chuyennganh).text()*10000)/100)
                    $('#trungtuyennhom-dotts'+dotts+'-dotxt'+dotxt+'-nganh'+res[i].id_chuyennganh).text(res[i].trungtuyennhom)
                    $('#tile-trungtuyennhom-dotts'+dotts+'-dotxt'+dotxt+'-nganh'+res[i].id_chuyennganh).text(Math.round(res[i].trungtuyennhom/$('#chitieu-dotts'+dotts+'-nganh'+res[i].id_chuyennganh).text()*10000)/100)
                    $('#trungtuyenbo-dotts'+dotts+'-dotxt'+dotxt+'-nganh'+res[i].id_chuyennganh).text(res[i].trungtuyenbo)
                    $('#tile-trungtuyenbo-dotts'+dotts+'-dotxt'+dotxt+'-nganh'+res[i].id_chuyennganh).text(Math.round(res[i].trungtuyenbo/$('#chitieu-dotts'+dotts+'-nganh'+res[i].id_chuyennganh).text()*10000)/100)

                    $('#diemlocaothpt'+dotxt).text(sumForKey('diemlocaothpt'+dotxt)['aveg'])
                    $('#trungtuyenthpt'+dotxt).text(sumForKey('trungtuyenthpt'+dotxt)['total'])
                    $('#diemchuanthpt'+dotxt).text(sumForKey('diemchuanthpt'+dotxt)['aveg'])
                    $('#diemlocaohocba'+dotxt).text(sumForKey('diemlocaohocba'+dotxt)['aveg'])
                    $('#trungtuyenhocba'+dotxt).text(sumForKey('trungtuyenhocba'+dotxt)['total'])
                    $('#trungtuyensom'+dotxt).text(sumForKey('trungtuyensom'+dotxt)['total'])
                    $('#tong'+dotxt).text(sumForKey('tong'+dotxt)['total'])
                    $('#tiletruong'+dotxt).text(sumForKey('tiletruong'+dotxt)['aveg'])
                    $('#trungtuyennhom'+dotxt).text(sumForKey('trungtuyennhom'+dotxt)['total'])
                    $('#tilenhom'+dotxt).text(sumForKey('tilenhom'+dotxt)['aveg'])
                    $('#trungtuyenbo'+dotxt).text(sumForKey('trungtuyenbo'+dotxt)['total'])
                    $('#tilebo'+dotxt).text(sumForKey('tilebo'+dotxt)['aveg'])
                }

            }
        }
    });
}


// $("#thxt_dotxt").on('change',function(){
//     let iddotts = $("#thxt_dotts_xettuyen").val();
//     let iddotxt = $(this).val();
//     var ngvong =$("#thxt_nguyenvong").val();
//     thongketheodotxettuyen(iddotts,iddotxt);
//     setTimeout(() => {
//         thongkedanhsachtrungtuyentamtheodotxt(iddotts,iddotxt,ngvong)
//     }, 2000);
// })

function sum(class_domm){
    var tong = 0;
    for (let i = 0; i < class_domm.length; i++) {
        tong = tong + Number($(class_domm[i]).val())
    }
    return tong;
}

function thxt_capnhatsoluongtheonganh(id){
    var iddotxt = $("#thxt_dotxt").val();
    var iddotts =$("#thxt_dotts_xettuyen").val();
    var ngvong =$("#thxt_nguyenvong").val();
    $('#modal_event').show();
    var soluong = $('#thxt_capnhatsoluongtheonganh'+id).val()
    $.ajax({
        type: "post",
        url: "/admin24/capnhatsoluongtheonganh",
        data: {
            id: id,
            soluong: soluong,
        },
        success:function(res){
            var soluong = document.getElementsByClassName('thxt_capnhatsoluongtheonganh')
            $('#modal_event').hide();
            $('#thxt_capnhatsoluongtheonganh'+id).val(res.noidung)
            $('#thxt_capnhatsoluongtheonganh-1000').val(sum(soluong))
            sum('thxt_capnhatsoluongtheonganh')
            thongbao(res.trangthai)
            thongkedanhsachtrungtuyentamtheodotxt(iddotts,iddotxt,ngvong)
        }
    });
}

function thongkedanhsachtrungtuyentamtheodotxt(iddotts,iddotxt,ngvong){
    $.ajax({
        type: "get",
        url: "/admin24/thongkedanhsachtrungtuyentamtheodotxt/"+iddotts+"/"+iddotxt+'/'+ngvong,
        success:function(res){
            if(res == 'dulieuxettuyen'){
                toastr.warning("Chưa có dữ liệu xét tuyển hoặc chưa có đợt tuyển sinh")
            }else{
                var chuyennganh = document.getElementsByClassName('thxt_capnhatsoluongtheonganh')
                var tongtrungtuyen = 0;
                for (let i = 0; i < res.length; i++) {
                    for (let j = 0; j < chuyennganh.length; j++) {
                        if($(chuyennganh[j]).attr('id_nganh') == res[i].id_chuyennganh){
                            $('#trungtuyen'+res[i].id_chuyennganh).text(res[i].soluong_trungtuyen)
                            $('#diemchuan'+res[i].id_chuyennganh).text(res[i].diemchuan)
                            tongtrungtuyen = res[i].soluong_trungtuyen + tongtrungtuyen;
                            $('#trungtuyen-1000').text(tongtrungtuyen)
                            break;
                        }else{
                            $('#trungtuyen'+res[i]['id_chuyennganh']).text(0)
                        }
                    }
                }
            }
        }
    })
}

$("#thxt_nguyenvong").on('change',function(){
    var iddotxt = $("#thxt_dotxt").val();
    var iddotts =$("#thxt_dotts_xettuyen").val();
    var ngvong =$("#thxt_nguyenvong").val();
    if(iddotxt == -1 || iddotts == -1 || ngvong == -1){
        toastr.warning('Vui lòng chọn Đợt tuyển sinh, Đợt xét tuyển và Nguyện vọng')
    }else{
        thongkedanhsachtrungtuyentamtheodotxt(iddotts,iddotxt,ngvong)
        // var id_dom = 'thxt_danhsachtrungtuyenchinhthuc'
        // danhsachtrungtuyenchinhthuc(id_dom,iddotts,iddotts,0).ajax.url("/admin24/danhsachtrungtuyenchinhthuc/"+iddotts+"/"+iddotxt+"/0").load();
    }
})


$("#luudanhsachtrungtuyentam").on('click',function(){
    var iddotxt = $("#thxt_dotxt").val();
    var iddotts =$("#thxt_dotts_xettuyen").val();
    var ngvong =$("#thxt_nguyenvong").val();
    if(iddotxt == -1 || iddotts == -1 || ngvong == -1){
        toastr.warning('Vui lòng chọn Đợt tuyển sinh, Đợt xét tuyển và Nguyện vọng')
    }else{
        $.ajax({
            type: "get",
            url: "/admin24/luudanhsachtrungtuyentam/"+iddotts+"/"+iddotxt+"/"+ngvong,
            success:function(res){
                thongbao(res)
            }
        })
    }
})

$("#trungtuyenchinhthucdotts").on('click',function(){
    var iddotxt = $("#thxt_dotxt").val();
    if(iddotxt == -1){
        thongbao('dot_-1')
    }else{
        $.ajax({
            type: "get",
            url: "/admin24/trungtuyenchinhthucdotts/"+iddotxt,
            success:function(res){
                if(res.trangthai == 1){
                    toastr.success('Đợt này có '+res.insertedRows1+ ' Nguyện vọng')
                    // thongketrungtuyentheodotts(iddotts).ajax.url("/admin24/thongketrungtuyentheodotts/"+iddotts).load();
                    // danhsachtrungtuyentheodotts(iddotts).ajax.url("/admin24/danhsachtrungtuyentheodotts/"+iddotts).load();
                    // var id_dom = 'thxt_danhsachtrungtuyenchinhthuc'
                    // danhsachtrungtuyenchinhthuc(id_dom,iddotts,iddotts,0).ajax.url("/admin24/danhsachtrungtuyenchinhthuc/"+iddotts+"/"+iddotxt+"/0").load();
                }else{
                    thongbao(res)
                }
            }
        });
    }
})
$("#khoaxettuyendotts").on('click',function(){
    $.ajax({
        type: "post",
        url: "/admin24/khoaxettuyendotts",
        success:function(res){
            thongbao(res)
        }
    });
})
$("#congboketquatheodotxt").on('click',function(){
    $.ajax({
        type: "post",
        url: "/admin24/congboketquatheodotxt",
        success:function(res){
            thongbao(res)
        }
    });
})
$("#dieutraketquatheodotxt").on('click',function(){
    $.ajax({
        type: "get",
        url: "/admin24/dieutraketquatheodotxt",
        success:function(res){
            thongbao(res)
        }
    });
})

function danhsachtrungtuyenchinhthuc(id_dom,iddotts,iddotxt,id_chuyennganh){
    var myDataTable = $("#"+id_dom).DataTable({
        processing: true,
        // serverSide: true,
        deferRender: true,
        ajax: "/admin24/danhsachtrungtuyenchinhthuc/"+iddotts+"/"+iddotxt+"/"+id_chuyennganh,
        columns: [
            {
                title: "STT",
                className: 'text-center',
                data: "sothutu",
            },
            {
                name: "thutu",
                title: "Thứ tự",
                data: "thutu",
            },
            {
                name: "hoten",
                title: "Họ tên thí sinh",
                data: "hoten",
            },
            {
                name: "tenchuyennganh",
                title: "Chuyên ngành/Ngành",
                data: "tenchuyennganh",
            },

            {
                name: "email",
                title: "Email",
                data: "email",
            },
            {
                name: "dienthoai",
                title: "Điện thoại",
                data: "dienthoai",
            },
            {
                name: "diemxettuyen",
                title: "Điểm xét tuyển",
                data: "diemxettuyen",
            },
            {
                name: "iddotxt",
                title: "Đợt xét tuyển",
                data: "iddotxt",
            },
        ],
        // columnDefs: [
        //     {
        //         targets: [0, 1, 2,3,4,5,6,7,8,9,10,11,12],
        //         orderable: false
        //         // className: "text-center"
        //     },
        // ],
        scrollY: 380,
        language: {
            emptyTable: "Không tìm thấy ngành/chuyên ngành",
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
        ordering: false,
        info: true,
        autoWidth: true,
        responsive: false,
        select: true,
    });
    return myDataTable;
}

$("#xuatdanhsachtrungtuyenchinhthuc").on('click',function(){
    var iddot = $("#thxt_dotts").val();
    var id_dom = 'thxt_danhsachtrungtuyentheodotts'
    var rowCount =  danhsachtrungtuyenchinhthuc(id_dom,iddot,0,0).rows().count();
    if(rowCount > 0){
        window.location.href = '/admin24/xuatdanhsachtrungtuyenchinhthuc/'+iddot+'/0/0';
    }else{
        thongbao('table_0')
    }
})



//Hàm gốc để gọi dữ liệu cho Databale (thong qua callback)
// function laygiatritimkiem(start, callback) {
//     var trangthai = 1;
//     var id_trangthai = 'dot_1';
//     var dieukien = {
//         '24_nguyenvong.iddot': -1000,
//         '24_kiemtrahoso.trangthai': -1000,
//         '24_kiemtrahoso.khoa': -1000,
//         '24_kiemtrahoso.duyet': -1000,
//         '24_nguyenvong.thutu': -1000,
//     };

//     if (start !== 0) {
//         if ($('#dsxt_dot').val() == -1) {
//             trangthai = 0;
//             id_trangthai = 'dot_-1';
//         } else {
//             dieukien['24_nguyenvong.iddot'] = $('#dsxt_dot').val();
//             dieukien['24_kiemtrahoso.trangthai'] = $('#dsxt_luu').val();
//             dieukien['24_kiemtrahoso.khoa'] = $('#dsxt_khoa').val();
//             dieukien['24_kiemtrahoso.duyet'] = $('#dsxt_duyet').val();
//             dieukien['24_nguyenvong.thutu'] = $('#dsxt_nguyenvong').val();
//         }
//     }
//     var noidung = JSON.stringify(dieukien);
//     callback({
//         'trangthai': trangthai,
//         'idtrangthai': id_trangthai,
//         'noidung': noidung
//     });

// }




// $('#timdanhsachxetuyentuyentheodot').on('click', function(){
//     //Gom hai thành 1, dũ liệu sẽ được lấy từ hàm trả về trong callbac của laygiatritimkiem
//     laygiatritimkiem(1, function(result) {
//         if(result.trangthai != 1){
//             thongbao(result.idtrangthai);
//         }
//         listnguyenvongDatatables(result.noidung).ajax.url("/admin24/danhsachnguyenvong/"+ result.noidung).load();
//     });
// })

// $('#duyetdanhsachxetuyentuyentheodot').on('click',async function(){
//     $('#modal_event').show();
//     var id_chucnang = 8
//     const check = await laythongtincheckquyen(id_chucnang);
//     var rowCount = listnguyenvongDatatables().rows().count();
//     if(rowCount > 0){
//         laygiatritimkiem(1, function(result) {
//             $.ajax({
//                 type: "post",
//                 url: "/admin24/duyetdanhsachxetuyentuyentheodot",
//                 data:{
//                     dieukien : result.noidung,
//                     //Phân quyền
//                     time: check[1],
//                     id_manhinh: check[0],
//                     id_chucnang: id_chucnang,
//                     active: 1,
//                 },
//                 success: function (res) {
//                     thongbao(res)
//                     listnguyenvongDatatables(result.noidung).ajax.url("/admin24/danhsachnguyenvong/"+ result.noidung).load();
//                     $('#modal_event').hide();
//                 },
//             });
//         });
//     }else{
//         thongbao('table_0')
//         $('#modal_event').hide();
//     }

// })

// async function trangthaidanhsachxettuyen(idnv){
//     $('#modal_event').show();
//     var iddot = $('#dsxt_dot').val();
//     var id_chucnang = 2
//     const kiemtraquyen = await laythongtincheckquyen(id_chucnang);
//     var check =  $('#trangthaidanhsachxettuyen_'+idnv).prop('checked') == true ? 1 : 0;
//     $.ajax({
//         type: "post",
//         url: "/admin24/trangthaidanhsachxettuyen",
//         data: {
//             idnv: idnv,
//             check: check,
//             iddot: iddot,
//             //Phân quyền
//             time: kiemtraquyen[1],
//             id_manhinh: kiemtraquyen[0],
//             id_chucnang: id_chucnang,
//             active: 1,
//         },
//         success: function (res) {
//             if(res.trangthai == 1){
//                 res.noidung == 1 ? $('#trangthaidanhsachxettuyen_'+idnv).prop('checked',true) : $('#trangthaidanhsachxettuyen_'+idnv).prop('checked',false)
//             }
//             $('#modal_event').hide();
//             thongbao(res.idthongbao)
//         },
//     });
// }

// $('#resetsachxetuyentuyentheodot').on('click',async function(){
//     $('#modal_event').show();
//     var rowCount = listnguyenvongDatatables().rows().count();
//     if(rowCount > 0){
//         var id_chucnang = 4
//         const kiemtraquyen = await laythongtincheckquyen(id_chucnang);
//         var iddot = $('#dsxt_dot').val();
//         $.ajax({
//             type: "post",
//             url: "/admin24/resetsachxetuyentuyentheodot",
//             data:{
//                 iddot: iddot,
//                 time: kiemtraquyen[1],
//                 id_manhinh: kiemtraquyen[0],
//                 id_chucnang: id_chucnang,
//                 active: 1,
//             },
//             success: function (res) {
//                 $('#modal_event').hide();
//                 thongbao(res)
//                 laygiatritimkiem(1, function(result) {
//                     listnguyenvongDatatables(result.noidung).ajax.url("/admin24/danhsachnguyenvong/"+ result.noidung).load();
//                 });
//             },
//         });
//     }else{
//         thongbao('table_0')
//         $('#modal_event').hide();
//     }

// })

// $('#xuatexceldanhsachxettuyen').on('click',async function(){

//     // $('#modal_event').show();
//     const kiemtraquyen = await laythongtincheckquyen(id_chucnang);
//     var rowCount = listnguyenvongDatatables().rows().count();
//     if(rowCount > 0){
//         var id_chucnang = 9
//         var iddot = $('#dsxt_dot').val();
//         var time = kiemtraquyen[1];
//         var id_manhinh = kiemtraquyen[0];
//         laygiatritimkiem(1, function(result) {
//             var dieukien = result.noidung
//             window.location.href = '/admin24/xuatexceldanhsachxettuyen/'+iddot+'/'+dieukien+'/'+time+'/'+id_manhinh+'/'+id_chucnang+'/1'
//         })
//     }else{
//         thongbao('table_0')
//         // $('#modal_event').hide();
//     }

// })




