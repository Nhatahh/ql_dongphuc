$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    // $('#hoso_dottuyensinh').select2()
    // $('#hoso_trangthai').select2()
    // $('#hoso_canbo').select2()
    $('#phancongkiemtra_namtuyensinh').select2()
    load_trangthai_pckiemtra()//Load resolve
    .then(
        function(data_option){
            load_danhsachhosokiemtra(data_option).ajax.url('/admin24/hoso_danhsach_kiemtra/-1').load();
        }
    )
});

function namtuyensinh_phancongkiemtra(){
        load_trangthai_pckiemtra()//Load resolve
        .then(
            function(data_option){
                var id_nam = $('#phancongkiemtra_namtuyensinh').val()
                var table = load_danhsachhosokiemtra(data_option).ajax.url('/admin24/hoso_danhsach_kiemtra/'+id_nam).load();
                $('#hosodanhsachkiemtra tbody').on('click', 'td.open_thongtin', function(e) {
                    let tr = e.target.closest('tr');
                    // var tr = $(e.currentTarget);
                    let row = table.row(tr);
                    if (row.child.isShown()) {
                        row.child.hide();
                    }
                    else {
                        row.child(format(row.data())).show();
                    }
                });
            }
        )
}

function load_trangthai_pckiemtra(){
    return new Promise(function(resolve, reject) {
        $.ajax({
            type: "get",
            url: "/admin24/load_trangthai_pckiemtra",
            success: function (res) {
                var html = "";
                html += "<option value = ''></option>";
                for (let i = 0; i < res.length; i++) {
                    html += "<option value = '"+res[i]['id_trangthai']+"'>"+res[i]['tentrangthai']+"</option>";
                }
                resolve(html)
            }
        })
    });
}//Trả ra Kết quả nằm trong thằng resolve

function load_danhsachhosokiemtra(data_option){
    var id_nam = $('#phancongkiemtra_namtuyensinh').val()
    var hoso_danhsach = $("#hosodanhsachkiemtra").DataTable({
        ajax: {
            type: "get",
            url: "/admin24/hoso_danhsach_kiemtra/"+id_nam,
        },
        // dom: 'frtip',
        columns: [
            {
                title: "<input class='check_all_hoso_kiemtra' onclick=check_all_hoso_kiemtra() style = 'height:13px' type = 'checkbox'>",
                data: "id",
                render: function(data,type,row){
                    return "<input email ='"+row.email+"' class='check_hoso_kiemtra check_one_duyet"+data+"' style = 'height:13px' id_hoso_kiemtra = "+data+" id_kiemtra = "+row.id_nhansu+" type = 'checkbox'></input>"
                }
            },
            {
                className: 'text-center open_thongtin',
                title: 'ID',
                data: 'id_taikhoan',
            },
            {
                name: 'hoten',
                title: "<div class = 'title_datatables'>Họ và tên</div><div class = 'div_datatables'><input id='hosodanhsachkiemtra_hoten' onkeyup = search_datatables('hosodanhsachkiemtra_hoten') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "hoten",
                className: 'text-left open_thongtin',
            },

            {
                name: 'email',
                title: "<div class = 'title_datatables'>Email</div><div class = 'div_datatables'><input id='hosodanhsachkiemtra_email' onkeyup = search_datatables('hosodanhsachkiemtra_email') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "email",
                className: 'text-left open_thongtin',

            },
            {
                name: 'emailnhansu',
                title: "<div class = 'title_datatables'>Kiểm tra</div><div class = 'div_datatables'><input id='hosodanhsachkiemtra_emailnhansu' onkeyup = search_datatables('hosodanhsachkiemtra_emailnhansu') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "email_nhansu",
                className: 'text-left open_thongtin',
            },
            {
                name: 'trangthai',
                title: "<div class ='title_datatables'>Trang thái</div><div class = 'div_datatables'> <select class = 'select_datatables' id='hosodanhsachkiemtra_trangthai' onchange = search_datatables('hosodanhsachkiemtra_trangthai')>"+data_option+"</select></div>",
                data: "trangthai",
                className: 'text-center open_thongtin',
                render: function(data,type,row){
                    return '<span class = "search_tmp">'+data+'</span><small class="badge badge-'+row.class_small+' trangthaihoso_kiemtra">'+row.icon+'&nbsp;&nbsp;'+row.tentrangthai+'</small>'
                }
            },
            {
                name: 'trangthaikhoa',
                title: "<div class ='title_datatables'>Khóa</div><div class = 'div_datatables'> <select class = 'select_datatables' id='hosodanhsachkiemtra_trangthaikhoa' onchange = search_datatables('hosodanhsachkiemtra_trangthaikhoa')><option  value =''></option><option value ='1'>Yes</option><option value ='0'>No</option></select></div>",
                data: "trangthaikhoa",
                className: 'text-center',
                render: function(data){
                    var checked = "";
                    data == 1 ? checked = 'checked' : checked = "";
                    return "<span class = 'search_tmp'>"+data+"</span><input  "+checked+"  type = 'checkbox' onclick='return false;' style = 'height:18px;background-color:inhert'>"
                }
            },
            {
                name: 'trangthaiduyet',
                title: "<div class ='title_datatables'>Duyệt</div><div class = 'div_datatables'> <select class = 'select_datatables' id='hosodanhsachkiemtra_trangthaiduyet' onchange = search_datatables('hosodanhsachkiemtra_trangthaiduyet')><option  value =''></option><option value ='1'>Yes</option><option value ='0'>No</option></select></div>",
                data: "trangthaiduyet",
                className: 'text-center',
                render: function(data){
                    var checked = "";
                    data == 1 ? checked = 'checked' : checked = "";
                    return "<span class = 'search_tmp'>"+data+"</span><input  "+checked+"  type = 'checkbox' onclick='return false;' style = 'height:18px;background-color:inhert'>"
                }
            },
        ],
        columnDefs: [
            {
                targets: 0,
                className: "text-center",
            },
            {
                targets: 4,
                className: "text-center",
            },
        ],
        scrollY: 400,
        language: {
            emptyTable: "Không có hồ sơ",
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
    $('#hosodanhsachkiemtra_filter').hide();
    return hoso_danhsach;
}
function format(d) {
    return (
        '<div class = "card card-body" style = "margin: 0rem 0.4rem  0.4rem 0.4rem">' +
            '<div class = "row">' +
                    '<div class = "col-6 col-md-6">' +
                    // '<strong>Email:</strong>&nbsp;&nbsp;' +'<span>' +d.email+ '</span><br>' +
                    '<strong>CCCD/CMND:</strong>&nbsp;&nbsp;' +'<span>' +d.cccd + '</span><br>' +
                    '<strong>Thời gian cập nhật:&nbsp;&nbsp;</strong><span>'+d.thoigiancapnhat+'</span><br>' +
                '</div>'+
                '<div class = "col-6 col-md-6">' +
                    // '<strong>Người khóa:</strong><span>&nbsp;&nbsp;'+d.email_nhansukhoa+'</span><br>' +
                    '<strong>Cập nhật khóa:</strong><span>&nbsp;&nbsp;'+d.thoigiankhoa+'</span><br>' +
                    '<strong>Người Duyệt</strong>&nbsp;&nbsp;<span id="email_duyet_'+d.id+'">'+d.email_duyet+'</span><br>' +
                    '<strong>Cập nhật duyệt:</strong>&nbsp;&nbsp;<span>'+d.thoigianduyet+'</span><br>' +
                '</div>'+
            '</div>'+
        '</div>'
    );
}

var ds_canbo = $("#ds_canbo_kiemtra").DataTable({
    ajax: {
        type: "get",
        url: "/admin24/ds_canbo_kiemtra",
    },
    columns: [
        {
            title: "<input class='check_all_canbo_kiemtra' onclick=check_all_canbo_kiemtra() style = 'height:13px' type = 'checkbox'>",
            data: "id",
            className: "text-center",
            render: function(data,type,row){
                return "<input email ='"+row.email+"' class='check_canbo_kiemtra' style = 'height:13px' id_canbokiemtra = "+data+" type = 'checkbox'></input>"
            }
        },
        { title: "Họ và tên", data: "name" },
        { title: "Email", data: "email" },

        // {
        //     title: "Khóa",
        //     data: "id",
        //     className: "text-center",
        //     render: function(data,type,row){
        //         row.khoa == 1 ? checked = "checked" : checked = "";
        //         return "<input style = 'height:16px;accent-color: #007bff;' id = 'phanquyenkiemtrahoso_"+row.id+"_2' onchange = phanquyenkiemtrahoso("+row.id+",2) "+checked+" id_user = "+row.id+" type = 'checkbox'></input>"
        //     }
        // },
        // {
        //     title: "Đăng ký",
        //     data: "id",
        //     className: "text-center",
        //     render: function(data,type,row){
        //         row.dangky == 1 ? checked = "checked" : checked = "";
        //         return "<input style = 'height:16px;accent-color: #ffc107;' id = 'phanquyenkiemtrahoso_"+row.id+"_3' onchange = phanquyenkiemtrahoso("+row.id+",3) "+checked+" id_user = "+row.id+" type = 'checkbox'></input>"
        //     }
        // },
        // {
        //     title: "Hủy",
        //     data: "id",
        //     className: "text-center",
        //     render: function(data,type,row){
        //         row.huy == 1 ? checked = "checked" : checked = "";
        //         return "<input style = 'height:16px;accent-color: #c82333;' id = 'phanquyenkiemtrahoso_"+row.id+"_4' onchange = phanquyenkiemtrahoso("+row.id+",4) "+checked+" id_user = "+row.id+" type = 'checkbox'></input>"
        //     }
        // },
    ],



    // columnDefs: [
    //     {
    //         targets: 0,
    //         className: "text-center",
    //     },
    //     {
    //         targets: 1,
    //         className: "text-center",
    //     },
    // ],
    scrollY: 400,
    language: {
        emptyTable: "Không có hồ sơ",
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
    searching: false,
    ordering: false,
    info: true,
    autoWidth: false,
    responsive: false,
    select: true,
});

//Lấy danh sách duyệt
function check_all_hoso_kiemtra(){
    let ds_hoso = document.getElementsByClassName("check_hoso_kiemtra");
    if($(".check_all_hoso_kiemtra").prop("checked") == true){
        for (let i = 0; i < ds_hoso.length; i++) {
            if($(ds_hoso[i]).attr('id_kiemtra') == 0){
                $(ds_hoso[i]).prop('checked',true)
            }else{
                $(ds_hoso[i]).prop('checked',false)
            }
        }
    }else{
        $(".check_hoso_kiemtra").prop("checked", false)
    }
}

// check all cán bộ duyệt
function check_all_canbo_kiemtra(){
    $(".check_all_canbo_kiemtra").prop("checked") == true ? $(".check_canbo_kiemtra").prop("checked", true) : $(".check_canbo_kiemtra").prop("checked", false);
}

async function phancong_canbokiemtra(){
    let id_chucnang = 2;
    const check = await laythongtincheckquyen(id_chucnang);
    let ds_hoso = document.getElementsByClassName("check_hoso_kiemtra");
    let array_canbokiemtra = document.getElementsByClassName("check_canbo_kiemtra");
    let arr_json_ds_canbokiemtra = [];
    let arr_json_ds_ds_hoso = [];
    for (let i = 0; i < ds_hoso.length; i++) {
        if ($(ds_hoso[i]).prop("checked")) {
            arr_json_ds_ds_hoso.push({
                id_hoso: $(ds_hoso[i]).attr("id_hoso_kiemtra"),
                email: $(ds_hoso[i]).attr("email"),
            });
        }
    }
    for (let i = 0; i < array_canbokiemtra.length; i++) {
        if ($(array_canbokiemtra[i]).prop("checked")) {
            arr_json_ds_canbokiemtra.push({
                id_canbokiemtra: $(array_canbokiemtra[i]).attr("id_canbokiemtra"),
                email: $(array_canbokiemtra[i]).attr("email"),
            });
        }
    }
    if(arr_json_ds_canbokiemtra.length == 0 || arr_json_ds_ds_hoso.length == 0){
        return toastr.warning("Phải chọn hồ sơ và cán bộ!!")
    }else{
        $.ajax({
            type: "post",
            url: "/admin24/phancong_canbokiemtra",
            data:{
                array_canbokiemtra: arr_json_ds_canbokiemtra,
                ds_hoso: arr_json_ds_ds_hoso,
                //Check quyền
                time: check[1],
                id_manhinh: check[0],
                id_chucnang: id_chucnang,
                active: 1,
            },
            success: function (res) {
                if(['upd_1', 'rol_2', '-100'].includes(res) == true){
                    thongbao(res)
                    ds_canbo.ajax.reload()
                    load_trangthai_pckiemtra().then(function(data_option){
                        load_danhsachhosokiemtra(data_option).ajax.reload();
                    })
                }else{
                    toastr.warning(res)
                }
            },
        });
    }

}

function lammoi_phancongkiemtra(){
    location.reload();
}

// async function phanquyenkiemtrahoso(id_admin, id_chucnang_hoso){
//     id_chucnang = 5;
//     const check = await laythongtincheckquyen(id_chucnang);
//     var quyen = 0;
//     $('#phanquyenkiemtrahoso_'+id_admin+'_'+id_chucnang_hoso).prop('checked') == true ? quyen = 1 : quyen = 0;
//     $.ajax({
//         type: "post",
//         url: "/admin24/phanquyenkiemtrahoso",
//         data:{
//             id_admin: id_admin,
//             quyen: quyen,
//             id_chucnang_hoso: id_chucnang_hoso,
//             //Check quyền
//             time: check[1],
//             id_manhinh: check[0],
//             id_chucnang: id_chucnang,
//             active: 1,
//         },
//         success: function(res){
//             thongbao(res)
//             ds_canbo.ajax.reload();
//         }
//     })


// }
