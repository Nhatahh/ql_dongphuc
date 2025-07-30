$(document).ready(function () {
    $("#dsxt_dot").select2();
    $("#dsxt_luu").select2();
    $("#dsxt_dangky").select2();
    $("#dsxt_khoa").select2();
    $("#dsxt_duyet").select2();
    $("#dsxt_xettuyen").select2();
    $("#dsxt_nguyenvong").select2();


    laygiatritimkiem(0, function(result) {
        listnguyenvongDatatables().ajax.url("/admin24/danhsachnguyenvong/"+ result.noidung).load();;
    });

})

//Hàm gốc để gọi dữ liệu cho Databale (thong qua callback)
function laygiatritimkiem(start, callback) {
    var trangthai = 1;
    var id_trangthai = 'dot_1';
    var dieukien = {
        '24_nguyenvong.iddot': -1000,
        '24_kiemtrahoso.trangthai': -1000,
        '24_kiemtrahoso.khoa': -1000,
        '24_kiemtrahoso.duyet': -1000,
        '24_nguyenvong.thutu': -1000,
    };

    if (start !== 0) {
        if ($('#dsxt_dot').val() == -1) {
            trangthai = 0;
            id_trangthai = 'dot_-1';
        } else {
            dieukien['24_nguyenvong.iddot'] = $('#dsxt_dot').val();
            dieukien['24_kiemtrahoso.trangthai'] = $('#dsxt_luu').val();
            dieukien['24_kiemtrahoso.khoa'] = $('#dsxt_khoa').val();
            dieukien['24_kiemtrahoso.duyet'] = $('#dsxt_duyet').val();
            dieukien['24_nguyenvong.thutu'] = $('#dsxt_nguyenvong').val();
        }
    }
    var noidung = JSON.stringify(dieukien);
    callback({
        'trangthai': trangthai,
        'idtrangthai': id_trangthai,
        'noidung': noidung
    });
}

//Sử dụng Datatable lấy nội dung từ laygiatritimkiem;
function listnguyenvongDatatables(noidung){
    var myDataTable = $("#listnguyenvong").DataTable({
        processing: true,
        // serverSide: true,
        deferRender: true,
        ajax: "/admin24/danhsachnguyenvong/"+noidung,
        columns: [
            {
                title: "STT",
                className: 'text-center',
                data: "sothutu",
            },
            {
                name: "idnv",
                className: 'text-center',
                title: "IDNV",
                data: "id",
            },
            {
                name: "idthisinh",
                className: 'text-center',
                title: "IDTS",
                data: "id_taikhoan",
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
                name: "phuongthuc",
                className: 'text-center',
                title: "Phương thức",
                data: "idphuongthuc",
                render: function(data, type, row){
                    switch (data) {
                        case 1:
                            var html = "Học bạ"
                            break;
                        case 2:
                            var html = "THPT"
                            break;
                        default:
                            break;
                    }
                    return html;
                }
            },
            {
                name: "thutu",
                className: 'text-center',
                title: "TTNV",
                data: "thutu",
            },
            {
                name: "namtotnghiep",
                className: 'text-center',
                title: "Năm TN",
                data: "namtotnghiep",
            },
            {
                name: "id_group",
                className: 'text-center',
                title: "Tổ hợp",
                data: "id_group",
            },
            {
                name: "diemtohop",
                className: 'text-center',
                title: "Điểm TH",
                data: "diemtohop",

            },
            {
                name: "doituong",
                className: 'text-center',
                title: "Đối tượng",
                data: "name_policy_user",
            },
            {
                name: "khuvuc",
                className: 'text-center',
                title: "KVUT",
                data: "id_priority_area",

            },
            {
                name: "diemuutien",
                className: 'text-center',
                title: "Điểm UT",
                data: "diemuutien",
            },
            {
                name: "diemxettuyen",
                className: 'text-center',
                title: "Điểm XT",
                data: "diemxettuyen",
            },
            {
                name: "trangthaixettuyen",
                className: 'text-center',
                title: "DSXT",
                data: "trangthaixettuyen",
                render: function(data, type, row){
                    let checked = "";
                    data == 1 ? checked = "checked" : checked = ""
                    return "<span style = 'display:none'>"+data+"</span><input onclick = trangthaidanhsachxettuyen("+row.id+") id = 'trangthaidanhsachxettuyen_"+row.id+"'  "+checked+"  type = 'checkbox' onclick='return false;' style = 'height:18px;background-color:inhert'>"
                }
            },
        ],
        columnDefs: [
            {
                targets: [0, 1, 2,3,4,5,7,8,9,10,11,12],
                orderable: false
                // className: "text-center"
            },
        ],
        scrollY: 400,
        language: {
            emptyTable: "Không tìm thấy nguyện vọng",
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

$('#timdanhsachxetuyentuyentheodot').on('click', function(){
    //Gom hai thành 1, dũ liệu sẽ được lấy từ hàm trả về trong callbac của laygiatritimkiem
    laygiatritimkiem(1, function(result) {
        if(result.trangthai != 1){
            thongbao(result.idtrangthai);
        }
        listnguyenvongDatatables(result.noidung).ajax.url("/admin24/danhsachnguyenvong/"+ result.noidung).load();
    });
})

$('#duyetdanhsachxetuyentuyentheodot').on('click',async function(){
    $('#modal_event').show();
    var id_chucnang = 8
    const check = await laythongtincheckquyen(id_chucnang);
    var rowCount = listnguyenvongDatatables().rows().count();
    if(rowCount > 0){
        laygiatritimkiem(1, function(result) {
            $.ajax({
                type: "post",
                url: "/admin24/duyetdanhsachxetuyentuyentheodot",
                data:{
                    dieukien : result.noidung,
                    //Phân quyền
                    time: check[1],
                    id_manhinh: check[0],
                    id_chucnang: id_chucnang,
                    active: 1,
                },
                success: function (res) {
                    thongbao(res)
                    listnguyenvongDatatables(result.noidung).ajax.url("/admin24/danhsachnguyenvong/"+ result.noidung).load();
                    $('#modal_event').hide();
                },
            });
        });
    }else{
        thongbao('table_0')
        $('#modal_event').hide();
    }

})

async function trangthaidanhsachxettuyen(idnv){
    $('#modal_event').show();
    var iddot = $('#dsxt_dot').val();
    var id_chucnang = 2
    const kiemtraquyen = await laythongtincheckquyen(id_chucnang);
    var check =  $('#trangthaidanhsachxettuyen_'+idnv).prop('checked') == true ? 1 : 0;
    $.ajax({
        type: "post",
        url: "/admin24/trangthaidanhsachxettuyen",
        data: {
            idnv: idnv,
            check: check,
            iddot: iddot,
            //Phân quyền
            time: kiemtraquyen[1],
            id_manhinh: kiemtraquyen[0],
            id_chucnang: id_chucnang,
            active: 1,
        },
        success: function (res) {
            if(res.trangthai == 1){
                res.noidung == 1 ? $('#trangthaidanhsachxettuyen_'+idnv).prop('checked',true) : $('#trangthaidanhsachxettuyen_'+idnv).prop('checked',false)
            }
            $('#modal_event').hide();
            thongbao(res.idthongbao)
        },
    });
}

$('#resetsachxetuyentuyentheodot').on('click',async function(){
    $('#modal_event').show();
    var rowCount = listnguyenvongDatatables().rows().count();
    if(rowCount > 0){
        var id_chucnang = 4
        const kiemtraquyen = await laythongtincheckquyen(id_chucnang);
        var iddot = $('#dsxt_dot').val();
        $.ajax({
            type: "post",
            url: "/admin24/resetsachxetuyentuyentheodot",
            data:{
                iddot: iddot,
                time: kiemtraquyen[1],
                id_manhinh: kiemtraquyen[0],
                id_chucnang: id_chucnang,
                active: 1,
            },
            success: function (res) {
                $('#modal_event').hide();
                thongbao(res)
                laygiatritimkiem(1, function(result) {
                    listnguyenvongDatatables(result.noidung).ajax.url("/admin24/danhsachnguyenvong/"+ result.noidung).load();
                });
            },
        });
    }else{
        thongbao('table_0')
        $('#modal_event').hide();
    }

})

$('#xuatexceldanhsachxettuyen').on('click',async function(){

    // $('#modal_event').show();
    const kiemtraquyen = await laythongtincheckquyen(id_chucnang);
    var rowCount = listnguyenvongDatatables().rows().count();
    if(rowCount > 0){
        var id_chucnang = 9
        var iddot = $('#dsxt_dot').val();
        var time = kiemtraquyen[1];
        var id_manhinh = kiemtraquyen[0];
        laygiatritimkiem(1, function(result) {
            var dieukien = result.noidung
            window.location.href = '/admin24/xuatexceldanhsachxettuyen/'+iddot+'/'+dieukien+'/'+time+'/'+id_manhinh+'/'+id_chucnang+'/1'
        })
    }else{
        thongbao('table_0')
        // $('#modal_event').hide();
    }

})


