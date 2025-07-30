$(document).ready(function () {
    $("#find_dot").select2();
    $("#chonmail").select2();
    $("#find_dotmail").select2();

    $.ajax({
        type: "get",
        url: "/admin24/kiemtra_guimail",
        success: function (res) {
            if (res == 1) {
                $('#btt_guimail').attr('disabled', true)
                $('#themds_guimail').attr('disabled', true)
                // $('#btt_xemtientrinh').attr('disabled',false)
                guimail();
            } else {
                $('#btt_guimail').attr('disabled', false)
                $('#themds_guimail').attr('disabled', false)
                // $('#btt_xemtientrinh').attr('disabled',true)
            }
        }
    })
    load_mail_danhsach().ajax.url('/admin24/tt_mail_sinhvien/0/0/0/0').load()
    $("#listmailsv_filter").hide();




});

$(document).keydown(function(event) {
    if (event.key === 'Escape' || event.keyCode === 27) {
        $('#model_tientrinh').hide();
        // $('#modal_event_guimail').hide();
        reload_danhsachguimail()
    }
});


function guimailtest() {
    let email_test = $("#mail_test").val();
    let noidung_mail = $("#summernote").val();
    let tieude_mail = $("#tieude_mail").val();
    let id_nguoidung = $("#btt_guimailtest").attr("id_nguoidung");
    if (tieude_mail == "") {
        return toastr.warning("Vui lòng nhập tiêu đề Email!");
    }
    if (noidung_mail == "") {
        return toastr.warning("Vui lòng nhập nội dung Email!");
    }
    $.ajax({
        type: "post",
        url: "guimail_test",
        data: {
            id_nguoidung: id_nguoidung,
            email_test: email_test,
            noidung_mail: noidung_mail,
            tieude_mail: tieude_mail,
        },
        success: function (res) {
            if (res == 1) {
                return toastr.success("Gửi mail thành công.");
            } else if (res == 0) {
                return toastr.warning("Gửi mail không thành công.");
            } else {
                return toastr.warning(
                    "Gửi mail không thành công.Liên hệ admin"
                );
            }

            // switch (res) {
            //     case 0:
            //         toastr.warning("Gửi mail không thành công.")
            //         break
            //     case 1:
            //         toastr.success("Gửi mail thành công.")
            //         break
            //     default:
            //         toastr.error();("Gửi mail không thành công liên hệ admin.")
            //         break
            // }
        },
    });
}
function mail_laydieukien(tendieukien) {
    var trangthai = -1;
    var check = $('#checked_' + tendieukien).prop('checked')
    var nocheck = $('#nochecked_' + tendieukien).prop('checked')
    if (check == true && nocheck == true) {
        trangthai = 2;
    }
    if (check == true && nocheck == false) {
        trangthai = 1;
    }
    if (check == false && nocheck == true) {
        trangthai = 0;
    }
    if (check == false && nocheck == false) {
        trangthai = -1;
    }
    return trangthai
}

$('.mail_dieukien').on('change', function () {
    reload_danhsachguimail()
})

function load_mail_danhsach(dottuyensinh, dotmail, dangky, lephi) {
    var table = $("#listmailsv").DataTable({
        ajax: "/admin24/tt_mail_sinhvien/" + dottuyensinh + '/'+ dotmail + '/' + dangky + '/' + lephi,
        columns: [
            {
                title: "<div style = 'display: flex;justify-content: center;align-items: center;'><input onclick = 'mail_check_all()' style=' height: auto' id ='mail_check_all' class = 'mail_check_all' type='checkbox'></div><div style='border-top:2px solid  #dee2e6'> <input style='height:28px; width:1px; border:none' ></div>",
                data: "id",
                render: function (data, type, row) {
                    var checked = ""
                    var class_trangthai = "";
                    if(row.trangthai == 1){
                        checked = "checked"
                    }
                    if(row.tinhtrangguimail == 0){
                        class_trangthai = 'guimail_check_all';
                    }
                    return (
                        '<input onchange = "mail_xoadanhsach('+data+')" '+checked+' style = "height: auto" class = "'+class_trangthai+' guimail" id_taikhoan="' + data + '" id = "guimail' + data + '" email="' + row.email + '" type="checkbox">'
                    );
                },
            },
            {
                name: 'id',
                className: "text-center",
                title: "<div class = 'title_datatables'>ID</div><div class = 'div_datatables'><input id='listmailsv_id' onkeyup = search_datatables('listmailsv_id') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "id",
            },
            {
                name: "cccd",
                title: "<div class = 'title_datatables'>CCCD/CMND</div><div class = 'div_datatables'><input id='listmailsv_cccd' onkeyup = search_datatables('listmailsv_cccd') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "cccd",
                render: function (data, type, row) {
                    if (data == null) {
                        return "&nbsp;&nbsp; -";
                    } else {
                        return "&nbsp;&nbsp;" + data;
                    }
                },
            },
            {
                name: "hoten",
                title: "<div class = 'title_datatables'>Họ tên</div><div class = 'div_datatables'><input id='listmailsv_hoten' onkeyup = search_datatables('listmailsv_hoten') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "hoten",
                render: function (data, type, row) {
                    if (data == null) {
                        return "&nbsp;&nbsp; -";
                    } else {
                        return "&nbsp;&nbsp;" + data;
                    }
                },
            },
            {
                name: "email",
                title: "<div class = 'title_datatables'>Email</div><div class = 'div_datatables'><input id='listmailsv_email' onkeyup = search_datatables('listmailsv_email') class='form-control input_text_datatables'><i class='fa-solid fa-magnifying-glass i_input_text_datatables'></i></div>",
                data: "email",
                render: function (data, type, row) {
                    if (data != "") {
                        return "&nbsp;&nbsp;" + data;
                    } else {
                        return "-";
                    }
                },
            },
            {
                name: 'trangthai',
                title: "<div class ='title_datatables'>Trạng thái</div><div class = 'div_datatables'> <select class = 'select_datatables' id='listmailsv_trangthai' onchange = search_datatables('listmailsv_trangthai')><option value = ''></option><option value = 0>Chưa hoàn thành</option><option value = 1>Đã hoàn thành</option></select></div>",
                data: "tinhtrangguimail",
                className: "text-center",
                render: function (data, type, row) {
                    if (data == 1) {
                        return '<span style = "display:none">'+data+'</span><small class="badge badge-primary"><i class="far fa-clock"></i> Đã hoàn thành</small>';
                    } else {
                        return '<span style = "display:none">'+data+'</span><small class="badge badge-warning"><i class="far fa-clock"></i> Chưa hoàn thành</small>';
                    }
                },
            },



        ],
        columnDefs: [
            // { targets: [0, 3, 4, 5, 6], className: "text-center" },
            // { targets: [1, 2], },
            // { targets: [0], searchable: true },
        ],
        scrollY: 350,
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
        paging: false,
        lengthChange: true,
        searching: true,
        ordering: false,
        info: true,
        autoWidth: true,
        responsive: true,
        select: true,
        initComplete: function () {
            // Lặp qua mỗi cột để tạo các bộ lọc
            this.api()
                .columns()
                .every(function () {
                    let column = this;
                    let select = document.createElement("select");
                    select.add(new Option(""));

                    // Lấy dữ liệu duy nhất từ cột và thêm vào các tùy chọn của select
                    column
                        .data()
                        .unique()
                        .sort()
                        .each(function (d, j) {
                            select.add(new Option(d));
                        });

                    // Thêm sự kiện cho select để lọc dữ liệu
                    $(select).on("change", function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());

                        column
                            .search(val ? "^" + val + "$" : "", true, false)
                            .draw();
                    });

                    // Thêm select vào div "selectFilters"
                    $("#selectFilters").append(select);
                });
        },
    });
    return table
}

function mail_check_all(){
    var guimail = document.getElementsByClassName('guimail_check_all')
    if($('#mail_check_all').prop("checked") == true){
        for (let i = 0; i < 100; i++) {
            $(guimail[i]).prop("checked", true)
        }
    }else{
        $(".guimail_check_all").prop("checked", false);
    }
}

async function mail_xoadanhsach(id){
    if($('#guimail'+id).prop('checked') == false){
        var id_chucnang = 6;
        const check = await laythongtincheckquyen(id_chucnang);
        $.ajax({
            type: "post",
            url: "/admin24/mail_xoadanhsach",
            data: {
                id_taikhoan : id,
                //Phân quyền
                time: check[1],
                id_manhinh: check[0],
                id_chucnang: id_chucnang,
                active: 1,
            },
            success: function (res){
                if(['upd_1','rol_2','-100'].includes(res) == true){
                    thongbao(res);
                }
                reload_danhsachguimail()
            }
        })
    }else{
        toastr.warning('Tiếp theo phải chọn "Thêm vào danh sách" và Chọn "Xem tiến trình" để kiểm tra danh sách gửi mail')
    }
}
// tìm mẫu mail
function tim_maumail() {
    let id = $("#chonmail").val();
    if (id == 0) {
        $("#tieude_maumail").val("");
        $("#nd_maumail").html("");
    } else {
        $.ajax({
            type: "get",
            url: "/admin24/tim_maumail/" + id,
            success: function (res) {
                $("#tieude_maumail").val(res.tieude);
                $("#nd_maumail").html(res.noidung);
                $("#themds_guimail").attr("id_mail", res.id);
            },
        });
    }
}

// thêm danh sách gửi mail còn chưa thông báo
async function themds_guimail(id_chucnang) {
    const check = await laythongtincheckquyen(id_chucnang);
    let ds_taikhoan = document.getElementsByClassName("guimail");
    let arr_json_dstaikhoan = [];
    let arr_json_data = [];
    let id_mail = $("#themds_guimail").attr("id_mail");
    let id_nguoigui = $("#themds_guimail").attr("id_nguoigui");
    let id_dotgui = $("#find_dotmail").val();
    for (let i = 0; i < ds_taikhoan.length; i++) {
        if ($(ds_taikhoan[i]).prop("checked")) {
            arr_json_dstaikhoan.push({
                id_taikhoan: $(ds_taikhoan[i]).attr("id_taikhoan"),
                email: $(ds_taikhoan[i]).attr("email"),
                id_mail: id_mail,
                id_nguoigui: id_nguoigui,
                id_dotgui: id_dotgui,
            });
        }
    }
    let active = id_mail == "" ? -1 : arr_json_dstaikhoan.length == 0 ? -2 : 1;
    arr_json_data.push({
        active: active,
    });
    arr_json_data.push({
        data: arr_json_dstaikhoan,
    });
    if(arr_json_data.length > 100){
        toastr.warning("Danh sách nhiều hơn 100 email, vui lòng giảm bớt số lượng email")
    }else{
        $.ajax({
            type: "post",
            url: "/admin24/themds_guimail",
            data: {
                arr_json_data: arr_json_data,
                //Check quyền
                time: check[1],
                id_manhinh: check[0],
                id_chucnang: id_chucnang,
                active: 1,
            },
            success: function (res) {
                if(res.trangthai1 == 'tontai_mail'){
                    toastr.warning('Mail đã có trong danh sách:'+ res.noidung);
                }else{
                    if (res.trangthai == -1) {
                        return toastr.warning("Vui lòng chọn mẫu mail!");
                    } else if (res.trangthai == -2) {
                        return toastr.warning(
                            "Vui lòng chọn mail để thêm vào danh sách!"
                        );
                    } else if (res.trangthai == 1) {
                        return toastr.success("Thêm vào danh sách thành công.");
                    } else if (res.trangthai == "rol_2") {
                        thongbao(res.trangthai)
                    } else {
                        toastr.error("Lỗi hệ thống vui lòng liên hệ Admin!");
                    }
                }
                reload_danhsachguimail()
            },
        });
    }
}

// btt gửi mail (kiểm tra có tiền trình đang gửi không)
async function guimai12(id_chucnang) {
    const check = await laythongtincheckquyen(id_chucnang);
    $.ajax({
        type: "get",
        url: "/admin24/guimail2",
        data: {
            //Check quyền
            time: check[1],
            id_manhinh: check[0],
            id_chucnang: id_chucnang,
            active: 1,
        },
        success: function (res) {
            if (res == 1) {
                guimail();
            } else {
                thongbao(res)
            }
        },
    });
}

// gửi mail
function guimail() {
    // $('#modal_event_guimail').show();
    const eventSource = new EventSource("/admin24/sse");
    eventSource.onmessage = function (event) {
        var data_arr = event.data.split("xxx");
        if (data_arr[0] == 0) {
            table_tientrinh.ajax.reload();
            eventSource.close();
            $('#btt_guimail').attr('disabled', false)
            $('#themds_guimail').attr('disabled', false)
            $('#thanhtientrinh').html(' <span style="color: #8a8c8f">Không có tiến trình</span>')
            window.location.href = '/admin24/xulysauguimail'
            // table_tientrinh.ajax.reload();
            // $('#modal_event_guimail').hide();
        } else {
            // $('#modal_event_guimail').show();
            $('#btt_guimail').attr('disabled', true)
            $('#themds_guimail').attr('disabled', true)
            let email = data_arr[1].split("@");
            $('#icon_' + email[0]).removeClass('fa-solid fa-rotate')
            $('#icon_' + email[0]).addClass('fas fa-check')
            $('#icon_' + email[0]).css('color', '#20c997')
            $('#loader_' + email[0]).removeClass('loader_cho')
            $('#loader_' + email[0]).addClass('loader_xong')
            $('#loader_' + email[0]).css('color', '#20c997')
            $('#email_' + email[0]).css('color', '#20c997')
            $('#thanhtientrinh').html('<div class="loader_tientrinh"><div class="bar1"></div><div class="bar2"></div> <div class="bar3"></div><div class="bar4"></div> <div class="bar5"></div><div class="bar6"></div><div class="bar7"></div><div class="bar8"></div> <div class="bar9"></div><div class="bar10"></div><div class="bar11"></div><div class="bar12"></div></div><span style="color: #770337b5">Tiến trình đang thực hiện</span>')

        }
    };
    eventSource.onmessage("error", function (event) {
        console.error("Error occurred:", event);
    });
}

function loadtientrinh() {
    return new Promise(function (resolve, reject) {
        resolve($('#model_tientrinh').show())
    })
}

async function xemtientrinh() {
    await loadtientrinh()
    table_tientrinh.ajax.reload()
}

var table_tientrinh = $("#tb_tientrinh").DataTable({
    type: "get",
    ajax: "/admin24/xemtientrinh",
    // dom: 'frtip',
    columns: [
        {
            title: "",
            data: "email",
            render: function (data, type, row) {
                let loader = row.email.split("@");
                if (row.status == 1) {
                    // return ' <span  style="color:#20c997;" id = "email_' + loader[0] + '">' + data + '</span><span id = "loader_' + loader[0] + '"class="loader_xong"></span></div>';
                    return ' <div style = "display:flex;color:#20c997;"><span id = "email_' + loader[0] + '">' + data + '</span><span id = "loader_' + loader[0] + '"class="loader_xong"></span></div>';

                } else {
                    return ' <div style = "display:flex"><span id = "email_' + loader[0] + '">' + data + '</span><span id = "loader_' + loader[0] + '"class="loader_cho"></span></div>';
                }
            },
        },
        {
            title: "",
            data: "status",
            render: function (data, type, row) {
                let email_table = row.email.split("@");
                if (row.status == 1) {
                    return ' <div  class=""><i style="color:#20c997;" id ="icon_' + email_table[0] + '" class="fas fa-check"></i></div>';
                } else {
                    return ' <div class=""><i id = "icon_' + email_table[0] + '" class="fa-solid fa-rotate"></i></div>';
                }
            },
        },
    ],
    columnDefs: [{
        targets: 1,
        className: "text-center ",
    },],
    scrollY: 550,
    language: {
        emptyTable: "Danh sách gửi mail đang trống",
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
    retrieve: false,
    paging: false,
    lengthChange: false,
    searching: false,
    ordering: false,
    info: true,
    autoWidth: true,
    responsive: true,
    select: false,
});

function close_model_tientrinh() {
    $("#model_tientrinh").hide();
    reload_danhsachguimail()
}

function reload_danhsachguimail(){
    var dangky = mail_laydieukien('dangkyxettuyen')
    var lephi = mail_laydieukien('lephixettuyen')
    var dottuyensinh = $('#find_dot').val();
    var dotmail = $('#find_dotmail').val();
    load_mail_danhsach(dottuyensinh, dotmail, dangky, lephi).ajax.url('/admin24/tt_mail_sinhvien/' + dottuyensinh + '/' + dotmail + '/'+ dangky + '/' + lephi).load()
}
