$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $('#hoso_dottuyensinh').select2()
    $('#hoso_trangthai').select2()
    $('#hoso_canbo').select2()
    $('#phancong_namtuyensinh').select2()



    // var aaa = load_danhsachhoso();
    load_trangthai()//Load resolve
    .then(
        function(data_option){
            load_danhsachhoso(data_option).ajax.url('/admin24/hoso_danhsach/-1').load();
        }
    )
});

function namtuyensinh_phancong(){
        load_trangthai()//Load resolve
        .then(
            function(data_option){
                var id_nam = $('#phancong_namtuyensinh').val()
                var table =load_danhsachhoso(data_option).ajax.url('/admin24/hoso_danhsach/'+id_nam).load();
                $('#hosodanhsach tbody').on('click', 'tr', function(e) {
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

function load_trangthai(){
    return new Promise(function(resolve, reject) {
        $.ajax({
            type: "get",
            url: "/admin24/load_trangthai",
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

function load_danhsachhoso(data_option){
    var id_nam = $('#phancong_namtuyensinh').val()
    var hoso_danhsach = $("#hosodanhsach").DataTable({
        ajax: {
            type: "get",
            url: "/admin24/hoso_danhsach/"+id_nam,
        },
        // dom: 'frtip',
        columns: [
            // {
            //     className: 'dt-control remove_click ',
            //     orderable: false,
            //     data: null,
            //     defaultContent: ''
            // },
            {
                title: "<input class='check_all_hoso' onclick=check_all_hoso() style = 'height:13px' type = 'checkbox'>",
                data: "id",
                render: function(data,type,row){
                    // if(row.trangthaikhoa == 1 || row.trangthaiduyet==1){
                    //     return "<input class='' onclick= 'return false' disabled  style = 'height:13px' id_hoso = "+data+" type = 'checkbox'></input>"
                    // }else{
                        return "<input class='check_hoso check_one"+data+"' style = 'height:13px' id_hoso = "+data+" type = 'checkbox'></input>"
                    // }
                }
            },
            {
                name: 'hoten',
                title: "<div class = 'title_datatables'>Họ và tên</div><div class = 'div_datatables'><input id='hosodanhsach_hoten' onkeyup = search_datatables('hosodanhsach_hoten') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "hoten",
                className: 'text-left',
            },

            {
                name: 'email',
                title: "<div class = 'title_datatables'>Email</div><div class = 'div_datatables'><input id='hosodanhsach_email' onkeyup = search_datatables('hosodanhsach_email') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "email",
                className: 'text-left',

            },
            // {
            //     name: "cccd",
            //     data: "cccd",
            //     title: "<div class = 'title_datatables'>CCCD/CMND</div><div class = 'div_datatables'><input id='hosodanhsach_cccd' onkeyup = search_datatables('hosodanhsach_cccd') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
            //     className: 'text-left'
            // },
            {
                name: 'kiemtra',
                title: "<div class = 'title_datatables'>Kiểm tra</div><div class = 'div_datatables'><input id='hosodanhsach_kiemtra' onkeyup = search_datatables('hosodanhsach_kiemtra') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "email_nhansu",
                render: function(data,type,row){
                    return "<span id='email_nhansu"+row.id+"'>"+data+"</span>"
                }
            },
            {
                name: 'trangthai',
                title: "<div class ='title_datatables'>Khóa</div><div class = 'div_datatables'> <select class = 'select_datatables' id='hosodanhsach_trangthai' onchange = search_datatables('hosodanhsach_trangthai')>"+data_option+"</select></div>",
                data: "trangthai",
                className: 'text-center',
                render: function(data,type,row){
                    return '<span class = "search_tmp">'+data+'</span><small class="badge badge-'+row.class_small+' trangthaihoso">'+row.icon+'&nbsp;&nbsp;'+row.tentrangthai+'</small>'
                }
            },
            {
                name: 'trangthaikhoa',
                title: "<div class ='title_datatables'>Khóa</div><div class = 'div_datatables'> <select class = 'select_datatables' id='hosodanhsach_trangthaikhoa' onchange = search_datatables('hosodanhsach_trangthaikhoa')><option  value =''></option><option value ='1'>Đã Khóa</option><option value ='0'>Chưa Khóa</option></select></div>",
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
                title: "<div class ='title_datatables'>Duyệt</div><div class = 'div_datatables'> <select class = 'select_datatables' id='hosodanhsach_trangthaiduyet' onchange = search_datatables('hosodanhsach_trangthaiduyet')><option  value =''></option><option value ='1'>Đã Duyệt</option><option value ='0'>Chưa Duyệt</option></select></div>",
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

        scrollY: 300,
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
        info: false,
        autoWidth: false,
        responsive: true,
        select: true,
    });
    $('#hosodanhsach_filter').hide();

    return hoso_danhsach;
}

//
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
                    '<strong>Người duyệt:</strong>&nbsp;&nbsp;<span id="email_duyet_'+d.id+'">'+d.email_duyet+'</span><br>' +
                    '<strong>Cập nhật duyệt:</strong>&nbsp;&nbsp;<span>'+d.thoigianduyet+'</span><br>' +
                '</div>'+
            '</div>'+
        '</div>'
    );
}

var ds_canbo = $("#ds_canbo").DataTable({
    ajax: {
        type: "get",
        url: "/admin24/ds_canbo",
    },
    columns: [
        {
            title: "<span>Sửa</span><input class='check_all_canbo' onclick=check_all_canbo() style = 'height:13px' type = 'checkbox'>",
            data: "id",
            className: "text-center",
            render: function(data,type,row){
                if(row.quyen_phancong == 0 || row.quyen_phancong == 2){
                    return "<input class='check_canbo' style = 'height:13px' id_canbo = "+data+" type = 'checkbox'></input>"
                }else{
                    return "<input class='' style = 'height:13px' onclick= 'return false' disabled  id_canbo = "+data+" type = 'checkbox'></input>"
                    // return "<input class='' onclick= 'return false' disabled  style = 'height:13px' id_hoso = "+data+" type = 'checkbox'></input>"
                }
            }
         },
        { title: "Họ và tên", data: "name" },
        { title: "Email", data: "email" },
        {
            title: "<span>Duyệt</span><input class='check_all_canbo_duyet' onclick=check_all_canbo_duyet() style = 'height:13px' type = 'checkbox'>",
            data: "id",
            className: "text-center",
            render: function(data,type,row){
                if(row.quyen_phancong == 1 || row.quyen_phancong == 2){
                    return "<input class='check_canbo_duyet' style = 'height:13px' id_canboduyet = "+data+" type = 'checkbox'></input>"
                }else{
                    return "<input class='' style = 'height:13px' onclick= 'return false' disabled  id_canboduyet = "+data+" type = 'checkbox'></input>"
                }
            }
         },
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
    scrollY: 300,
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

// $('#phancongkiemtra').on('click', async function(){
//     let id_chucnang = 2
//     const check = await laythongtincheckquyen(id_chucnang);
//     $.ajax({
//         type: "get",
//         url: "/admin24/kiemtra_pchoso",
//         data:{
//             time: check[1],
//             id_manhinh: check[0],
//             id_chucnang: id_chucnang,
//             active: 1,
//         },
//         success: function (res) {
//             if(['rol_2'].includes(res) == false){
//                 $(".check_all_hoso").prop("checked", false)
//                 $(".check_hoso").prop("checked", false)
//                 $("#phancong_canboduyet").prop("disabled", true)
//                 $("#phancong").prop("disabled", false)
//             }else{
//                 thongbao(res)
//             }
//         },
//     });
// })


$('.radio_phancong').on('click', async function(){
    let val = $(this).prop('checked')
    let trangthai = 0
    let id_chucnang = 0
    if($('#phancongkiemtra').prop('checked') == true){
        trangthai = 0
        id_chucnang = 2
    }
    if($('#phancongduyet').prop('checked') == true){
        trangthai = 1
        id_chucnang = 8
    }
    const check = await laythongtincheckquyen(id_chucnang);
    $.ajax({
        type: "get",
        url: "/admin24/kiemtra_pchoso",
        data:{
            time: check[1],
            id_manhinh: check[0],
            id_chucnang: id_chucnang,
            active: 1,
            trangthai: trangthai,
        },
        success: function (res) {
            if(['rol_2'].includes(res) == false){
                if(trangthai == 0){
                    $("#phancong_canboduyet").prop("disabled", true)
                    $("#phancong").prop("disabled", false)
                }else{
                    $("#phancong").prop("disabled", true)
                    $("#phancong_canboduyet").prop("disabled", false)
                }
                $(".check_hoso").prop("checked", false)
                $(".check_all_hoso").prop("checked", false)
            }else{
                thongbao(res)
            }
        },
    });



})


function check_all_hoso(){
    // let ds_hoso = document.getElementsByClassName("check_hoso");
    // if($(".check_all_hoso").prop("checked") == true){
    //     for (let i = 0; i < ds_hoso.length; i++) {
    //         var id_hoso = $(ds_hoso[i]).attr('id_hoso')
    //         if($('#email_nhansu'+id_hoso).text() == ""){
    //             $('.check_one'+id_hoso).prop('checked',true)
    //         }else{
    //             $('.check_one'+id_hoso).prop('checked',false)
    //         }
    //     }
    // }else{
    //     $(".check_hoso").prop("checked", false)
    // }
    let ds_hoso = document.getElementsByClassName("check_hoso");
    if($(".check_all_hoso").prop("checked") == true){
        var pckiemtra = $('#phancongkiemtra').prop('checked')
        var pcduyet = $('#phancongduyet').prop('checked')
        if(pckiemtra == false &&  pcduyet == false){
            toastr.warning("Vui lòng chọn trạng thái phân công hồ sơ hoặc duyệt hồ sơ")
        }else{
            if( pckiemtra == true){
                for (let i = 0; i < ds_hoso.length; i++) {
                    var id_hoso = $(ds_hoso[i]).attr('id_hoso')
                    if($('#email_nhansu'+id_hoso).text() == ""){
                        $('.check_one'+id_hoso).prop('checked',true)
                    }else{
                        $('.check_one'+id_hoso).prop('checked',false)
                    }
                }
            }
            if(pcduyet == true){
                for (let i = 0; i < ds_hoso.length; i++) {
                    var id_hoso = $(ds_hoso[i]).attr('id_hoso')
                    if($('#email_duyet_'+id_hoso).text() == ""){
                        $('.check_one'+id_hoso).prop('checked',true)
                    }else{
                        $('.check_one'+id_hoso).prop('checked',false)
                    }
                }
            }
        }
    }else{
        $(".check_hoso").prop("checked", false)
    }


}
function check_all_canbo(){
    $(".check_all_canbo").prop("checked") == true ? $(".check_canbo").prop("checked", true) : $(".check_canbo").prop("checked", false);
}
async function phancong(){
    const check = await laythongtincheckquyen(2);
    let ds_hoso = document.getElementsByClassName("check_hoso");
    let array_canbo = document.getElementsByClassName("check_canbo");
    let arr_json_ds_canbo = [];
    let arr_json_ds_ds_hoso = [];
    for (let i = 0; i < ds_hoso.length; i++) {
        if ($(ds_hoso[i]).prop("checked")) {
            arr_json_ds_ds_hoso.push({
                id_hoso: $(ds_hoso[i]).attr("id_hoso"),
            });
        }
    }
    for (let i = 0; i < array_canbo.length; i++) {
        if ($(array_canbo[i]).prop("checked")) {
            arr_json_ds_canbo.push({
                id_canbo: $(array_canbo[i]).attr("id_canbo"),
            });
        }
    }
    if(arr_json_ds_canbo.length == 0 || arr_json_ds_ds_hoso.length == 0){
        return toastr.warning("Phải chọn hồ sơ và cán bộ!!")
    }else{
        $.ajax({
            type: "post",
            url: "/admin24/phancong",
            data:{
                array_canbo:arr_json_ds_canbo,
                ds_hoso:arr_json_ds_ds_hoso,
                //Check quyền
                time: check[1],
                id_manhinh: check[0],
                id_chucnang: 2,
                active: 1,
            },
            success: function (res) {
                thongbao(res)
                ds_canbo.ajax.reload()
                load_trangthai().then(function(data_option){
                    load_danhsachhoso(data_option).ajax.reload();
                }
                )

            },
        });
    }

}

function phancong_exel(){
    var hoten= $('#hosodanhsach_hoten').val();
    var email= $('#hosodanhsach_email').val();
    var kiemtra= $('#hosodanhsach_kiemtra').val();
    var trangthaiduyet= $('#hosodanhsach_trangthaiduyet').val();
    var trangthaikhoa= $('#hosodanhsach_trangthaikhoa').val();
    var trangthai= $('#hosodanhsach_trangthai').val();
    var id_nam = $('#phancong_namtuyensinh').val()
    if(hoten==""){
        hoten=-1
    }

    if(email==""){
        email=-1
    }

    if(kiemtra==""){
        kiemtra=-1
    }

    if(trangthaiduyet==""){
        trangthaiduyet = -1
    }

    if(trangthaikhoa==""){
        trangthaikhoa=-1
    }

    if(trangthai==""){
        trangthai=-1
    }

    if(id_nam==-1){
        return toastr.warning("Vui lòng chọn năm TS!")
    }else{
        window.location.href = '/admin24/phancong_exel/'+hoten+'/'+email+'/'+kiemtra+'/'+trangthaiduyet+'/'+trangthaikhoa+'/'+trangthai+'/'+id_nam
    }
}

// check all cán bộ duyệt
function check_all_canbo_duyet(){
    $(".check_all_canbo_duyet").prop("checked") == true ? $(".check_canbo_duyet").prop("checked", true) : $(".check_canbo_duyet").prop("checked", false);
}

async function phancong_canboduyet(){
    let id_chucnang = 8;
    const check = await laythongtincheckquyen(id_chucnang);
    let ds_hoso = document.getElementsByClassName("check_hoso");
    let array_canboduyet = document.getElementsByClassName("check_canbo_duyet");
    let arr_json_ds_canboduyet = [];
    let arr_json_ds_ds_hoso = [];
    for (let i = 0; i < ds_hoso.length; i++) {
        if ($(ds_hoso[i]).prop("checked")) {
            arr_json_ds_ds_hoso.push({
                id_hoso: $(ds_hoso[i]).attr("id_hoso"),
            });
        }
    }
    for (let i = 0; i < array_canboduyet.length; i++) {
        if ($(array_canboduyet[i]).prop("checked")) {
            arr_json_ds_canboduyet.push({
                id_canboduyet: $(array_canboduyet[i]).attr("id_canboduyet"),
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
                array_canboduyet:arr_json_ds_canboduyet,
                ds_hoso:arr_json_ds_ds_hoso,
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
                    load_trangthai().then(function(data_option){
                        load_danhsachhoso(data_option).ajax.reload();
                    })
                }else{
                    toastr.warning(res)
                }


                // thongbao(res)
                // ds_canbo.ajax.reload()
                // load_trangthai().then(function(data_option){
                //     load_danhsachhoso(data_option).ajax.reload();
                // }
                // )
            },
        });
    }

}
