$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    // $('#hoso_dottuyensinh').select2()
    // $('#hoso_trangthai').select2()
    // $('#hoso_canbo').select2()
    $('#phancongduyet_namtuyensinh').select2()


    load_trangthai_pcduyet()//Load resolve
    .then(
        function(data_option){
            load_danhsachhosoduyet(data_option).ajax.url('/admin24/hoso_danhsach_duyet/-1').load();
        }
    )
});

function namtuyensinh_phancongduyet(){
        load_trangthai_pcduyet()//Load resolve
        .then(
            function(data_option){
                var id_nam = $('#phancongduyet_namtuyensinh').val()
                var table = load_danhsachhosoduyet(data_option).ajax.url('/admin24/hoso_danhsach_duyet/'+id_nam).load();
                $('#hosodanhsachduyet tbody').on('click', 'td.open_thongtin', function(e) {
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

function load_trangthai_pcduyet(){
    return new Promise(function(resolve, reject) {
        $.ajax({
            type: "get",
            url: "/admin24/load_trangthai_pcduyet",
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

function load_danhsachhosoduyet(data_option){
    var id_nam = $('#phancongduyet_namtuyensinh').val()
    var hoso_danhsach = $("#hosodanhsachduyet").DataTable({
        ajax: {
            type: "get",
            url: "/admin24/hoso_danhsach_duyet/"+id_nam,
        },
        // dom: 'frtip',
        columns: [
            {
                title: "<input class='check_all_hoso_duyet' onclick=check_all_hoso_duyet() style = 'height:13px' type = 'checkbox'>",
                data: "id",
                render: function(data,type,row){
                    return "<input email = '"+row.email+"' class='check_hoso_duyet check_one_duyet"+data+"' style = 'height:13px' id_hoso_duyet = "+data+" id_duyet = "+row.id_nhansuduyet+" type = 'checkbox'></input>"
                }
            },
            {
                className: 'text-center open_thongtin',
                title: 'ID',
                data: 'id_taikhoan',
            },
            {
                name: 'hoten',
                title: "<div class = 'title_datatables'>Họ và tên</div><div class = 'div_datatables'><input id='hosodanhsachduyet_hoten' onkeyup = search_datatables('hosodanhsachduyet_hoten') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "hoten",
                className: 'text-left open_thongtin',
            },

            {
                name: 'email',
                title: "<div class = 'title_datatables'>Email</div><div class = 'div_datatables'><input id='hosodanhsachduyet_email' onkeyup = search_datatables('hosodanhsachduyet_email') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "email",
                className: 'text-left open_thongtin',

            },
            {
                name: 'emailduyet',
                title: "<div class = 'title_datatables'>Người duyệt</div><div class = 'div_datatables'><input id='hosodanhsachduyet_emailduyet' onkeyup = search_datatables('hosodanhsachduyet_emailduyet') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "email_duyet",
                className: 'text-left open_thongtin',
            },
            {
                name: 'trangthai',
                title: "<div class ='title_datatables'>Trang thái</div><div class = 'div_datatables'> <select class = 'select_datatables' id='hosodanhsachduyet_trangthai' onchange = search_datatables('hosodanhsachduyet_trangthai')>"+data_option+"</select></div>",
                data: "trangthai",
                className: 'text-center open_thongtin',
                render: function(data,type,row){
                    return '<span class = "search_tmp">'+data+'</span><small class="badge badge-'+row.class_small+' trangthaihoso_duyet">'+row.icon+'&nbsp;&nbsp;'+row.tentrangthai+'</small>'
                }
            },
            {
                name: 'trangthaikhoa',
                title: "<div class ='title_datatables'>Khóa</div><div class = 'div_datatables'> <select class = 'select_datatables' id='hosodanhsachduyet_trangthaikhoa' onchange = search_datatables('hosodanhsachduyet_trangthaikhoa')><option  value =''></option><option value ='1'>Yes</option><option value ='0'>No</option></select></div>",
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
                title: "<div class ='title_datatables'>Duyệt</div><div class = 'div_datatables'> <select class = 'select_datatables' id='hosodanhsachduyet_trangthaiduyet' onchange = search_datatables('hosodanhsachduyet_trangthaiduyet')><option  value =''></option><option value ='1'>Yes</option><option value ='0'>No</option></select></div>",
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
    $('#hosodanhsachduyet_filter').hide();
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
                    '<strong>Người Khóa:</strong>&nbsp;&nbsp;<span id="email_duyet_'+d.id+'">'+d.email_nhansu+'</span><br>' +
                    '<strong>Cập nhật duyệt:</strong>&nbsp;&nbsp;<span>'+d.thoigianduyet+'</span><br>' +
                '</div>'+
            '</div>'+
        '</div>'
    );
}

var ds_canbo = $("#ds_canbo_duyet").DataTable({
    ajax: {
        type: "get",
        url: "/admin24/ds_canbo_duyet",
    },
    columns: [
        {
            title: "<input class='check_all_canbo_duyet' onclick=check_all_canbo_duyet() style = 'height:13px' type = 'checkbox'>",
            data: "id",
            className: "text-center",
            render: function(data,type,row){
                return "<input email = '"+row.email+"' class='check_canbo_duyet' style = 'height:13px' id_canboduyet = "+data+" type = 'checkbox'></input>"
            }
        },
        { title: "Họ và tên", data: "name" },
        { title: "Email", data: "email" },

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
    scrollY: 450,
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
    info: false,
    autoWidth: false,
    responsive: false,
    select: true,
});

//Lấy danh sách duyệt
function check_all_hoso_duyet(){
    let ds_hoso = document.getElementsByClassName("check_hoso_duyet");
    if($(".check_all_hoso_duyet").prop("checked") == true){
        for (let i = 0; i < ds_hoso.length; i++) {
            if($(ds_hoso[i]).attr('id_duyet') == 0){
                $(ds_hoso[i]).prop('checked',true)
            }else{
                $(ds_hoso[i]).prop('checked',false)
            }
        }
    }else{
        $(".check_hoso_duyet").prop("checked", false)
    }
}

// check all cán bộ duyệt
function check_all_canbo_duyet(){
    $(".check_all_canbo_duyet").prop("checked") == true ? $(".check_canbo_duyet").prop("checked", true) : $(".check_canbo_duyet").prop("checked", false);
}

async function phancong_canboduyet(){
    let id_chucnang = 8;
    const check = await laythongtincheckquyen(id_chucnang);
    let ds_hoso = document.getElementsByClassName("check_hoso_duyet");
    let array_canboduyet = document.getElementsByClassName("check_canbo_duyet");
    let arr_json_ds_canboduyet = [];
    let arr_json_ds_ds_hoso = [];
    for (let i = 0; i < ds_hoso.length; i++) {
        if ($(ds_hoso[i]).prop("checked")) {
            arr_json_ds_ds_hoso.push({
                id_hoso: $(ds_hoso[i]).attr("id_hoso_duyet"),
                email: $(ds_hoso[i]).attr("email"),
            });
        }
    }
    for (let i = 0; i < array_canboduyet.length; i++) {
        if ($(array_canboduyet[i]).prop("checked")) {
            arr_json_ds_canboduyet.push({
                id_canboduyet: $(array_canboduyet[i]).attr("id_canboduyet"),
                email: $(array_canboduyet[i]).attr("email"),
            });
        }
    }
    if(arr_json_ds_canboduyet.length == 0 || arr_json_ds_ds_hoso.length == 0){
        return toastr.warning("Phải chọn hồ sơ và cán bộ!!")
    }else{
        $.ajax({
            type: "post",
            url: "/admin24/phancong_canboduyet",
            data:{
                array_canboduyet: arr_json_ds_canboduyet,
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
                    load_trangthai_pcduyet().then(function(data_option){
                        load_danhsachhosoduyet(data_option).ajax.reload();
                    })
                }else{
                    toastr.warning(res)
                }
            },
        });
    }

}

function lammoi_phancongduyet(){
    location.reload();
}
// function phancong_exel(){
//     var hoten= $('#hosodanhsach_hoten').val();
//     var email= $('#hosodanhsach_email').val();
//     var kiemtra= $('#hosodanhsach_kiemtra').val();
//     var trangthaiduyet= $('#hosodanhsach_trangthaiduyet').val();
//     var trangthaikhoa= $('#hosodanhsach_trangthaikhoa').val();
//     var trangthai= $('#hosodanhsach_trangthai').val();
//     var id_nam = $('#phancong_namtuyensinh').val()
//     if(hoten==""){
//         hoten=-1
//     }

//     if(email==""){
//         email=-1
//     }

//     if(kiemtra==""){
//         kiemtra=-1
//     }

//     if(trangthaiduyet==""){
//         trangthaiduyet = -1
//     }

//     if(trangthaikhoa==""){
//         trangthaikhoa=-1
//     }

//     if(trangthai==""){
//         trangthai=-1
//     }

//     if(id_nam==-1){
//         return toastr.warning("Vui lòng chọn năm TS!")
//     }else{
//         window.location.href = '/admin24/phancong_exel/'+hoten+'/'+email+'/'+kiemtra+'/'+trangthaiduyet+'/'+trangthaikhoa+'/'+trangthai+'/'+id_nam
//     }
// }
