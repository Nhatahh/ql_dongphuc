$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#tinh-lop10').select2();
    $('#truong-lop10').select2();
    $('#noisinh').select2();
    $('#thongtin-uutien').select2();
    $('#tinh-lop12').select2();
    $('#truong-lop12').select2();
    $('#tinh-lop11').select2();
    $('#truong-lop11').select2();
    $('#uutien-doituong').select2();
    $('#nguyenvong').select2();
    $('#khuvuc4-lop').select2();
    $('#kiemtra_danhsachhoso_filter').hide();
    // load_danhsach()


    $('#summernote_kiemtrahoso').summernote({
        placeholder: 'Nhập nội dung lỗi...',
        tabsize: 2,
        height: 280,
        tooltip:false,

    });
































});


const swiper2 = new Swiper('.tracuuthisinh-loadimg', {
    zoom: {
        maxRatio: 3,
        minRatio: 1,
    },
    // Optional parameters
    slidesPerView: 1,
    // direction: 'vertical',
    // loop: true,

    // If we need pagination
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },

    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

    // And if we need scrollbar
    // scrollbar: {
    //   el: '.swiper-scrollbar',
    // },
});



var hoso_danhsach = $("#kiemtra_danhsachhoso").DataTable({
    ajax: {
        type: "get",
        url: "/admin24/kiemtra_danhsachhoso",
    },
    // dom: 'frtip',
    columns: [
        {
            className: 'dt-control remove_click',
            orderable: false,
            data: null,
            defaultContent: ''
        },
        {
            title: "<div style ='padding-bottom: 10px;text-align: center;'>ID</div>",
            data: "id_taikhoan" ,
            className: 'remove_click',
        },
        {
            title: "<div style = 'text-align: center;'>Họ và tên</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_hoten' onkeyup = 'search_hoten()' class='form-control' style='width:90%;height:22px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
            data: "hoten" ,
            className: 'remove_click text-left',
        },
        {
            title: "<div>Trạng thái</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'> <select style='height:22px; border:none;color:#8a8c8f;' id='search_trangthai' onchange = 'search_trangthai()'><option  value =''></option><option value ='0'>Lưu nguyện vọng</option><option value ='1'>Đăng ký mới</option><option value ='2'>Mở cập nhật</option><option value ='3'>Đăng ký lại</option></select></div>",
            data: "trangthai",
            className: 'remove_click text-center',
            render: function(data,type,row){
                var html ="";
                switch (data) {
                    case 0:
                        html =  '<span style = "display:none">0</span><small class="badge badge-success"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;</i>Lưu nguyện vọng</small>'
                        break;
                    case 1:
                        html = '<span style = "display:none">1</span><small class="badge badge-primary"><i class="fa-regular fa-registered"></i>&nbsp;&nbsp;</i>Đăng ký mới</small>'
                        break;
                    case 2:
                        html = '<span style = "display:none">2</span><small class="badge badge-secondary"><i class="fa-regular fa-folder-open"></i>&nbsp;&nbsp;</i>Mở cập nhật</small>'
                        break;
                    case 3:
                        html = '<span style = "display:none">3</span><small class="badge badge-primary"><i class="fa-regular fa-registered"></i>&nbsp;&nbsp;</i>Đăng ký lại</small>'
                        break;
                    default:
                        break;
                }
                return html;
            }
        },
        {
            title: "<div>Khóa</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'> <select style='height:22px; border:none;color:#8a8c8f;' id='search_khoa' onchange = 'search_khoa()'><option  value =''></option><option value ='1'>Đã Khóa</option><option value ='0'>Chưa Khoa</option></select></div>",
            data: "trangthaikhoa",
            className: 'remove_click text-center',
            render: function(data){
                var checked = "";
                data == 1 ? checked = 'checked' : checked = "";
                return "<span style = 'display:none'>"+data+"</span><input  "+checked+"  type = 'checkbox' onclick='return false;' style = 'height:18px;background-color:inhert'>"
            }
        },
        {
            title: "<div>Duyệt</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'> <select style='height:22px; border:none;color:#8a8c8f;' id='search_duyet' onchange = 'search_duyet()'><option  value =''></option><option value ='1'>Đã Duyệt</option><option value ='0'>Chưa duyệt</option></select></div>",
            data: "trangthaiduyet",
            className: 'remove_click text-center',
            render: function(data){
                var checked = "";
                data == 1 ? checked = 'checked' : checked = "";
                return "<span style = 'display:none'>"+data+"</span><input  "+checked+"  type = 'checkbox' onclick='return false;' style = 'height:18px;background-color:inhert'>"
            }
        },
        {
            title: "Chức năng",
            data: "id_taikhoan",
            className: 'timkiem_thisinh text-center remove_click',
            render: function(data){
                return '<i style = "color:#007bff;font-size: 16px;" class="fa-solid fa-square-pen"></i>'
            }
        }
    ],
    columnDefs: [
        // {
        //     targets: 0,
        //     className: "text-center",
        // },
        // {
        //     targets: 1,
        //     className: "text-left",
        // },
        // {
        //     targets: 3,
        //     className: "text-center",
        // },
        // {
        //     targets: 4,
        //     className: "text-center",
        // },
        // {
        //     targets: 5,
        //     className: "text-center",
        // },
        // {
        //     targets: 6,
        //     className: "text-center",
        // },
    ],
    "language": {
        "emptyTable": "Không tìm thấy hồ sơ",
        "info": " _START_ / _END_ trên _TOTAL_ hóa đơn",
        "paginate": {
            "first": "Trang đầu",
            "last": "Trang cuối",
            "next": "Trang sau",
            "previous": "Trang trước"
        },
        "search": "Tìm kiếm:",
        "loadingRecords": "Đang tìm kiếm ... ",
        "lengthMenu": "Hiện thị _MENU_ hóa đơn",
        "infoEmpty": "",
    },
    "retrieve": true,
    "paging": false,
    "lengthChange": false,
    "searching": true,
    "ordering": false,
    "info": false,
    "autoWidth": true,
    "responsive": false,
    scrollY: 265,
});
function search_hoten() {
    var value = $('#search_hoten').val()
    hoso_danhsach.column(1).search(value).draw();
}
function search_email() {
    var value = $('#search_email').val()
    hoso_danhsach.column(2).search(value).draw();
}
function search_trangthai() {
    var value = $('#search_trangthai').val()
    hoso_danhsach.column(3).search(value).draw();
}
function search_khoa() {
    hoso_danhsach.column(4).search(value = $('#search_khoa').val()).draw();
}
function search_duyet() {
    hoso_danhsach.column(5).search(value = $('#search_duyet').val()).draw();
}
function format(d) {
    return (
        '<div class = "card card-body" style = "margin: 0rem 0.4rem  0.4rem 0.4rem">' +
            '<div class = "row">' +
                    '<div class = "col-6 col-md-6">' +
                    '<strong>Email:</strong>&nbsp;&nbsp;' +'<span>' +d.email+ '</span><br>' +
                    '<strong>CCCD/CMND:</strong>&nbsp;&nbsp;' +'<span>' +d.cccd + '</span><br>' +
                    '<strong>Thời gian cập nhật:&nbsp;&nbsp;</strong><span>'+d.thoigiancapnhat+'</span><br>' +
                '</div>'+
                '<div class = "col-6 col-md-6">' +
                    '<strong>Người khóa:</strong><span>&nbsp;&nbsp;'+d.email_nhansukhoa+'</span><br>' +
                    '<strong>Cập nhật khóa:</strong><span>&nbsp;&nbsp;'+d.thoigiankhoa+'</span><br>' +
                    '<strong>Người duyệt:</strong>&nbsp;&nbsp;<span>'+d.nguoiduyet+'</span><br>' +
                    '<strong>Cập nhật duyệt:</strong>&nbsp;&nbsp;<span>'+d.thoigianduyet+'</span><br>' +
                '</div>'+
            '</div>'+
        '</div>'
    );
}
$('#kiemtra_danhsachhoso tbody').on('click', 'td.dt-control', function(e) {
    let tr = e.target.closest('tr');
    let row = hoso_danhsach.row(tr);
    if (row.child.isShown()) {
        row.child.hide();
    }
    else {
        row.child(format(row.data())).show();
    }
});
$('#kiemtra_danhsachhoso tbody').on('click', 'td.timkiem_thisinh', function() {
    $('.remove_click').parent().removeClass('tr_click');
    var id_taikhoan = hoso_danhsach.row($(this).closest('tr')).data().id_taikhoan;
    timkiemthisinh(id_taikhoan)
    $(this).closest('tr').addClass('tr_click');
});

function timkiemthisinh(id_taikhoan) {
    $('#modal_event').show();
    $.ajax({
        type: 'get',
        url: '/admin24/timkiemthisinh',
        data: {
            id_taikhoan : id_taikhoan
            // timkiem_cccd: timkiem_cccd,
            // timkiem_email: timkiem_email
        },
        success: function(res) {
            $('#modal_event').hide();
            // alert(res.thongtinthisinh[0].hoten)
            var id_taikhoan = res.id_taikhoan;
            $('#hoten').attr('id_taikhoan', id_taikhoan)
            $('#timkiem-email').attr('id_taikhoan', id_taikhoan)
            if (id_taikhoan != 0) {
                // res.khoahoso == 0 ?  $('#khoahoso').attr('disabled',true) : $('#khoahoso').attr('disabled',false)
                res.khoahoso == 1 ?  $('#khoahoso').html('<i class="fa-solid fa-key"></i>&nbsp;&nbsp;Mở khóa hồ sơ') : $('#khoahoso').html('<i class="fa-solid fa-key"></i>&nbsp;&nbsp;Khóa hồ sơ')
                res.duyethoso == 1 ?  $('#duyethoso').html('<i class="fa-solid fa-key"></i>&nbsp;&nbsp;Hủy duyệt') : $('#duyethoso').html('<i class="fa-solid fa-key"></i>&nbsp;&nbsp;Duyệt hồ sơ')
                $('#hoten').val(res.thongtinthisinh[0].hoten)
                $('#ngaysinh').val(res.thongtinthisinh[0].ngaysinh)
                $('#noisinh').empty()

                $('#noisinh').select2({
                    data: res.tinh
                })
                $('#cccd').val(res.thongtinthisinh[0].cccd)
                $('#email').val(res.thongtinthisinh[0].email)
                $('#email_phu').val(res.thongtinthisinh[0].email_phu)
                $('#dienthoai').val(res.thongtinthisinh[0].dienthoai)
                $('#dienthoai_phu').val(res.thongtinthisinh[0].dienthoai_phu)
                $('#diachi').val(res.thongtinthisinh[0].diachi)

                $('#khuvuc-lop10').text(res.khuvuc10)
                $('#khuvuc-lop11').text(res.khuvuc11)
                $('#khuvuc-lop12').text(res.khuvuc12)

                $('#uutien-khuvuc').text(res.khuvuc)


                if (res.thongtinthisinh[0].gioitinh == 0) {
                    $('#gioitinhnam').attr('checked', true)
                } else {
                    $('#gioitinhnu').attr('checked', true)
                }
                $('#thongtin-noisinh').select2({
                    data: res.tinh
                })

                //Tỉnh và trường lớp 10
                $('#tinh-lop10').empty()
                $('#tinh-lop10').select2({data: res.tinh10})
                $('#truong-lop10').empty()
                $('#truong-lop10').select2({data: res.truongthpt10 })
                //Tỉnh và trường lớp 11
                $('#tinh-lop11').empty()
                $('#tinh-lop11').select2({ data: res.tinh11})
                $('#truong-lop11').empty()
                $('#truong-lop11').select2({data: res.truongthpt11})
                //Tỉnh và trường lớp 12
                $('#tinh-lop12').empty()
                $('#tinh-lop12').select2({  data: res.tinh12 })
                $('#truong-lop12').empty()
                $('#truong-lop12').select2({ data: res.truongthpt12})
                $('#uutien-doituong').empty()
                $('#uutien-doituong').select2({data: res.doituong})

                $('#namtotnghiep').val(res.namtn)
                var html = '<thead>';
                html += '<tr>'
                html += '        <th>Môn</th>'
                html += '        <th>Học kì 1</th>'
                html += '       <th>Học kì 2</th>'
                html += '           <th>Cả năm</th>'
                html += '       </tr>'
                html += '   </thead>'
                html += '<tbody>'
                for (let i = 0; i < res.mons10.length; i++) {
                    html += ' <tr>'
                    html += '<td><input disabled="" style="hight:100%;width:100%;text-align:center;border:none;background-color:transparent" value="' + res.mons10[i].name_subject + '"></td>'
                    html += '<td><input id="ketquahoctap_10_1_' + res.mons10[i].id + '" onchange="capnhatketquahoctap(10,1,' + res.mons10[i].id + ')" id-tohop="tohop1" class="ketquahoctap capnhatketquahoctap" lop="10" hocki="1" id_user="2376" mon="' + res.mons10[i].id + '" style="hight:100%;width:100%;text-align:center;border:none;background-color:transparent" value="' + res.mons10[i].diem10_1 + '"></td>'
                    html += '<td><input id="ketquahoctap_10_2_' + res.mons10[i].id + '" onchange="capnhatketquahoctap(10,2,' + res.mons10[i].id + ')" id-tohop="tohop1" class="ketquahoctap capnhatketquahoctap" lop="10" hocki="2" id_user="2376" mon="' + res.mons10[i].id + '" style="hight:100%;width:100%;text-align:center;border:none;background-color:transparent" value="' + res.mons10[i].diem10_2 + '"></td>'
                    html += '<td><input id="ketquahoctap_10_CN_' + res.mons10[i].id + '" onchange="capnhatketquahoctap(10,-1,' + res.mons10[i].id + ')" id-tohop="tohop1" class="ketquahoctap capnhatketquahoctap" lop="10" hocki="CN" id_user="2376" mon="' + res.mons10[i].id + '" style="hight:100%;width:100%;text-align:center;border:none;background-color:transparent" value="' + res.mons10[i].diem10_CN + '"></td>'
                    html += '</tr>'
                }


                html += '</tbody>'


                $('#diemlop10').html(html)

                var html = '<thead>';
                html += '<tr>'
                html += '        <th>Môn</th>'
                html += '        <th>Học kì 1</th>'
                html += '       <th>Học kì 2</th>'
                html += '           <th>Cả năm</th>'
                html += '       </tr>'
                html += '   </thead>'
                html += '<tbody>'
                for (let i = 0; i < res.mons11.length; i++) {
                    html += ' <tr>'
                    html += '<td><input disabled="" style="hight:100%;width:100%;text-align:center;border:none;background-color:transparent" value="' + res.mons11[i].name_subject + '"></td>'
                    html += '<td><input id="ketquahoctap_11_1_' + res.mons11[i].id + '" onchange="capnhatketquahoctap(11,1,' + res.mons11[i].id + ')" id-tohop="tohop1" class="ketquahoctap capnhatketquahoctap" lop="11" hocki="1" id_user="2376" mon="' + res.mons10[i].id + '" style="hight:100%;width:100%;text-align:center;border:none;background-color:transparent" value="' + res.mons11[i].diem10_1 + '"></td>'
                    html += '<td><input id="ketquahoctap_11_2_' + res.mons11[i].id + '" onchange="capnhatketquahoctap(11,2,' + res.mons11[i].id + ')" id-tohop="tohop1" class="ketquahoctap capnhatketquahoctap" lop="11" hocki="2" id_user="2376" mon="' + res.mons10[i].id + '" style="hight:100%;width:100%;text-align:center;border:none;background-color:transparent" value="' + res.mons11[i].diem10_2 + '"></td>'
                    html += '<td><input id="ketquahoctap_11_CN_' + res.mons11[i].id + '" onchange="capnhatketquahoctap(11,-1,' + res.mons11[i].id + ')" id-tohop="tohop1" class="ketquahoctap capnhatketquahoctap" lop="11" hocki="CN" id_user="2376" mon="' + res.mons10[i].id + '" style="hight:100%;width:100%;text-align:center;border:none;background-color:transparent" value="' + res.mons11[i].diem10_CN + '"></td>'
                    html += '</tr>'
                }


                html += '</tbody>'

                $('#diemlop11').html(html)

                var html = '<thead>';
                html += '<tr>'
                html += '        <th>Môn</th>'
                html += '        <th>Học kì 1</th>'
                html += '       <th>Học kì 2</th>'
                html += '           <th>Cả năm</th>'
                html += '       </tr>'
                html += '   </thead>'
                html += '<tbody>'
                for (let i = 0; i < res.mons12.length; i++) {
                    html += ' <tr>'
                    html += '<td><input disabled="" style="hight:100%;width:100%;text-align:center;border:none;background-color:transparent" value="' + res.mons12[i].name_subject + '"></td>'
                    html += '<td><input id="ketquahoctap_12_1_' + res.mons12[i].id + '" onchange="capnhatketquahoctap(12,1,' + res.mons12[i].id + ')" id-tohop="tohop1" class="ketquahoctap capnhatketquahoctap" lop="12" hocki="1" id_user="2376" mon="' + res.mons10[i].id + '" style="hight:100%;width:100%;text-align:center;border:none;background-color:transparent" value="' + res.mons12[i].diem10_1 + '"></td>'
                    html += '<td><input id="ketquahoctap_12_2_' + res.mons12[i].id + '" onchange="capnhatketquahoctap(12,2,' + res.mons12[i].id + ')" id-tohop="tohop1" class="ketquahoctap capnhatketquahoctap" lop="12" hocki="2" id_user="2376" mon="' + res.mons10[i].id + '" style="hight:100%;width:100%;text-align:center;border:none;background-color:transparent" value="' + res.mons12[i].diem10_2 + '"></td>'
                    html += '<td><input id="ketquahoctap_12_CN_' + res.mons12[i].id + '" onchange="capnhatketquahoctap(12,-1,' + res.mons12[i].id + ')" id-tohop="tohop1" class="ketquahoctap capnhatketquahoctap" lop="12" hocki="CN" id_user="2376" mon="' + res.mons10[i].id + '" style="hight:100%;width:100%;text-align:center;border:none;background-color:transparent" value="' + res.mons12[i].diem10_CN + '"></td>'
                    html += '</tr>'
                }

                html += '</tbody>'
                $('#diemlop12').html(html)


                var html = '<thead>';
                html += '<tr>'
                html += '    <th>STT</th>'
                html += '    <th>Nguyện vọng</th>'
                html += '    <th>Điểm</th>'
                html += '    <th>Ưu tiên</th>'
                html += '    <th>Tổng</th>'
                html += '    <th>Kết quả</th>'
                html += '</tr>'

                html += '</thead>'
                html += '<tbody>'

                for (let i = 0; i < res.nguyenvongs.length; i++) {
                    html += '<tr>'

                    html += '<td>'
                    html += res.nguyenvongs[i].stt
                    html += '</td>'
                    html += '<td>'
                    html += '<div class="col-sm-12">'
                    html += '<select  class="capnhatnguyenvong" id="capnhatnguyenvong_' + res.nguyenvongs[i].id + '_' + res.nguyenvongs[i].stt + '" onchange="capnhatnguyenvong(' + res.nguyenvongs[i].id + ',' + res.nguyenvongs[i].stt + ')" style="width: 310px; height: 28px; background-color: inherit; border: none;">'
                    for (let j = 0; j < res.nguyenvong_all.length; j++) {
                        if (res.nguyenvongs[i].tenchuyennganh == res.nguyenvong_all[j].tenchuyennganh)
                            html += '<option value="' + res.nguyenvong_all[j].id + '" selected>' + res.nguyenvong_all[j].tenchuyennganh + '</option>'
                        else
                            html += '<option value="' + res.nguyenvong_all[j].id + '" >' + res.nguyenvong_all[j].tenchuyennganh + '</option>'

                    }

                    html += '</select>'
                    html += '</div>'
                    html += '</td>'
                    html += '<td>'
                    html += '<input type="text" class="" id="diemtohop_' + res.nguyenvongs[i].stt + '" value="' + res.nguyenvongs[i].diemtohop + '" style="height:28px; width: 100%; border: none; background-color: inherit">'
                    html += '</td>'
                    html += '<td>'
                    html += '<input type="text" disabled class="" id="diemuutien_' + res.nguyenvongs[i].stt + '" value="' + res.nguyenvongs[i].diemuutien + '" style="height:28px; width: 100%; border: none;">'
                    html += '</td>'
                    html += '<td>'
                    html += '<input type="text" disabled class="" id="diemxettuyen_' + res.nguyenvongs[i].stt + '" value="' + res.nguyenvongs[i].diemxettuyen + '" style="height:28px; width: 100%; border: none;">'
                    html += '</td>'
                    html += '<td>'
                    html += '<input type="text" disabled class="" id="" value="Trượt" style="height:28px; width: 100%; border: none;">'
                    html += '</td>'

                    html += '</tr>'
                }

                html += '</tbody>'

                $('#id_nguyenvong').html(html)






                var html = "";

                // html += '<div id = "12222" id_taikhoan2323 = "" class="swiper-slide">'
                // html += '    <div  id_taikhoan2323 = "" class="swiper-container">'
                // html += '       <img  id_taikhoan2323 = "" src="/img/CTUT_logo.png" style="object-fit: fill; height: 510px">'
                // html += '   </div>'
                // html += ' </div>'

                for (let i = 0; i < res.image.length; i++) {
                    html += '<div class="swiper-slide"  style="position: relative">'
                    html += '<div class="swiper-zoom-container">'
                    // html += '<div class="swiper-slide-transform">'
                    html += '<img src="' + res.image[i].path_img + '" style="height: 510px">'
                    html += '</div>'
                    html += '</div>'
                }
                $('#tracuuthusinh-loadimage').html(html)
            } else {
                thongbao('find_no')
                var html = "";
                html += '<div class="swiper-slide">'
                html += '<div class="swiper-container">'
                html += '<img src="/img/CTUT_logo.png" style="object-fit: fill; height: 510px">'
                html += '</div>'
                html += '</div>'
                $('#namtotnghiep').val('')
                $('#tracuuthusinh-loadimage').html(html)
                $('#hoten').val('')
                $('#ngaysinh').val('')
                $('#noisinh').val('')
                $('#noisinh').text('')
                $('#cccd').val('')
                $('#email').val('')
                $('#email_phu').val('')
                $('#dienthoai').val('')
                $('#dienthoai_phu').val('')
                $('#diachi').val('')

                $('#tinh-lop10').val('')
                $('#tinh-lop10').text('')
                $('#truong-lop10').val('')
                $('#truong-lop10').text('')
                $('#tinh-lop11').val('')
                $('#tinh-lop11').text('')
                $('#truong-lop11').val('')
                $('#truong-lop11').text('')
                $('#tinh-lop12').val('')
                $('#tinh-lop12').text('')
                $('#truong-lop12').val('')
                $('#truong-lop12').text('')
                $('#gioitinhnam').attr('checked', false)
                $('#gioitinhnu').attr('checked', false)
                $('#uutien-doituong').val('')
                $('#uutien-doituong').text('')
                $('#khuvuc-lop10').text('')
                $('#khuvuc-lop11').text('')
                $('#khuvuc-lop12').text('')
                $('#uutien-khuvuc').text('')
                var html = '<thead>';
                html += '<tr>'
                html += '        <th>Môn</th>'
                html += '        <th>Học kì 1</th>'
                html += '       <th>Học kì 2</th>'
                html += '           <th>Cả năm</th>'
                html += '       </tr>'
                html += '   </thead>'
                html += '<tbody>'


                html += '</tbody>'


                $('#diemlop10').html(html)

                var html = '<thead>';
                html += '<tr>'
                html += '        <th>Môn</th>'
                html += '        <th>Học kì 1</th>'
                html += '       <th>Học kì 2</th>'
                html += '           <th>Cả năm</th>'
                html += '       </tr>'
                html += '   </thead>'
                html += '<tbody>'


                html += '</tbody>'
                $('#diemlop11').html(html)
                var html = '<thead>';
                html += '<tr>'
                html += '        <th>Môn</th>'
                html += '        <th>Học kì 1</th>'
                html += '       <th>Học kì 2</th>'
                html += '           <th>Cả năm</th>'
                html += '       </tr>'
                html += '   </thead>'
                html += '<tbody>'
                html += '</tbody>'
                $('#diemlop12').html(html)
                var html = '<thead>';
                html += '<tr>'
                html += '    <th>STT</th>'
                html += '    <th>Nguyện vọng</th>'
                html += '    <th>Điểm</th>'
                html += '    <th>Ưu tiên</th>'
                html += '    <th>Tổng</th>'
                html += '    <th>Kết quả</th>'
                html += '</tr>'
                html += '</thead>'
                html += '<tbody>'
                html += '</tbody>'
                $('#id_nguyenvong').html(html)
            }
        }

    })
}
function change_tinh10() {
    $('#truong-lop10').empty();
    $('#khuvuc-lop10').text('Không')
    var idtinh10 = $('#tinh-lop10').val()
    $.ajax({
        type: 'get',
        url: '/admin24/change_tinh10/' + idtinh10,
        success: function(res) {
            $('#truong-lop10').select2({
                data: res
            })
        }
    })
}
function change_tinh11() {
    $('#truong-lop11').empty();
    $('#khuvuc-lop11').text('Không')

    var idtinh11 = $('#tinh-lop11').val()
    $.ajax({
        type: 'get',
        url: '/admin24/change_tinh11/' + idtinh11,
        success: function(res) {
            $('#truong-lop11').select2({
                data: res
            })
        }
    })
}
function change_tinh12() {
    $('#truong-lop12').empty();
    $('#khuvuc-lop12').text('Không')

    var idtinh12 = $('#tinh-lop12').val()
    $.ajax({
        type: 'get',
        url: '/admin24/change_tinh12/' + idtinh12,
        success: function(res) {
            $('#truong-lop12').select2({
                data: res
            })
        }
    })
}
$('.thongtincanhan').on('change', async function() {
    $('#modal_event').show();
    const check = await laythongtincheckquyen(2);
    var id_taikhoan = $('#hoten').attr('id_taikhoan');
    var id = $(this).attr('id')
    var val = $(this).val()
    if (id == 'gioitinhnam' && $(this).prop('checked') == true) {
        val = 0
        id = 'gioitinh'
    }
    if (id == 'gioitinhnu' && $(this).prop('checked') == true) {
        val = 1
        id = 'gioitinh'
    }
    var table = $(this).attr('table')
    $.ajax({
        type: 'post',
        url: '/admin24/capnhatthongtincanhan1',
        data: {
            id_taikhoan: id_taikhoan,
            id: id,
            val: val,
            table: table,
            //Check quyền
            time: check[1],
            id_manhinh: check[0],
            id_chucnang: 2,
            active: 1,
        },
        success: function(res) {
            $('#modal_event').hide();
            if (res.maloi == 'validate') {
                toastr.warning(res.noidung['original']['val'][0])
            } else {
                hoso_danhsach.ajax.reload();
                timkiemthisinh(id_taikhoan)
                thongbao(res.thongbao)
            }
        }
    })
})
$('#namtotnghiep').on('change', async function() {
    $('#modal_event').show();
    const check = await laythongtincheckquyen(2);
    var id_taikhoan = $('#hoten').attr('id_taikhoan');
    var val = $(this).val();
    $.ajax({
        type: 'post',
        url: '/admin24/capnhatnamtn',
        data: {
            id_taikhoan: id_taikhoan,
            val: val,
              //Check quyền
              time: check[1],
              id_manhinh: check[0],
              id_chucnang: 2,
              active: 1,
        },
        success: function(res) {
            $('#modal_event').hide();
            if (res.maloi == 'validate') {
                toastr.warning(res.noidung['original']['val'][0])
            } else {
                timkiemthisinh(id_taikhoan)
                // if (res.thongbao == 'upd_1') {
                //     var data = res.noidung.nguyenvongs;
                //     for (let i = 0; i < data.length; i++) {
                //         $('#diemtohop_' + data[i].stt).val(data[i].diemtohop)
                //         $('#diemuutien_' + data[i].stt).val(data[i].diemuutien)
                //         $('#diemxettuyen_' + data[i].stt).val(data[i].diemxettuyen)
                //     }
                // }
                thongbao(res.thongbao)
            }
        }
    })
})
$('.capnhattruonglop1').on('change', async function() {
    $('#modal_event').show();
    const check = await laythongtincheckquyen(2);
    var id_taikhoan = $('#hoten').attr('id_taikhoan');
    var id = $(this).attr('id_lop')
    var val = $(this).val()
    var table = $(this).attr('table')
    var id_tinh_truong = $(this).attr('id_tinh')
    var id_tinh = $('#' + id_tinh_truong).val()
    $.ajax({
        type: 'post',
        url: '/admin24/capnhattruonglop1',
        data: {
            id_taikhoan: id_taikhoan,
            id: id,
            val: val,
            table: table,
            id_tinh: id_tinh,
            //Check quyền
            time: check[1],
            id_manhinh: check[0],
            id_chucnang: 2,
            active: 1,
        },
        success: function(res) {
            $('#modal_event').hide();
            if (res.maloi == 'validate') {
                toastr.warning(res.noidung['original']['val'][0])
            } else {
                thongbao(res.thongbao)
                timkiemthisinh(id_taikhoan);
            }
        }
    })
})
async function capnhatketquahoctap(lop, hocki, mon) {
    $('#modal_event').show();
    const check = await laythongtincheckquyen(2);
    var id_taikhoan = $('#hoten').attr('id_taikhoan')
    var hocki_fix = 0;
    hocki == -1 ? hocki_fix = 'CN' : hocki_fix = hocki;
    var val = $('#ketquahoctap_' + lop + '_' + hocki_fix + '_' + mon).val();
    var myRe = /^[+-]?((\d+(\.\d*)?)|(\.\d+))$/;
    if (myRe.test(val) == true) {
        $.ajax({
            type: 'post',
            url: '/admin24/capnhatketquahoctap',
            data: {
                id_taikhoan: id_taikhoan,
                val: val,
                lop: lop,
                hocki: hocki_fix,
                mon: mon,
                //Check quyền
                time: check[1],
                id_manhinh: check[0],
                id_chucnang: 2,
                active: 1,
            },
            success: function(res) {
                $('#modal_event').hide();
                if (res.maloi == 'validate') {
                    toastr.warning(res.noidung['original']['val'][0])
                } else {
                    timkiemthisinh(id_taikhoan)
                    thongbao(res.thongbao)
                }
            }
        })
    } else {
        toastr.warning("Điểm là só thập phân, ngăn cách bằng dấu ' . '")
    }
}
async function capnhatdoituong() {
    $('#modal_event').show();
    const check = await laythongtincheckquyen(2);
    var id_taikhoan = $('#hoten').attr('id_taikhoan')
    var val = $('#uutien-doituong').val()
    $.ajax({
        type: 'post',
        url: '/admin24/capnhatdoituong1',
        data: {
            id_taikhoan: id_taikhoan,
            val: val,
            //Check quyền
            time: check[1],
            id_manhinh: check[0],
            id_chucnang: 2,
            active: 1,
        },
        success: function(res) {
            $('#modal_event').hide();
            if (res.maloi == 'validate') {
                toastr.warning(res.noidung['original']['val'][0])
            } else {
                thongbao(res.thongbao);
                timkiemthisinh(id_taikhoan);
            }
        }
    })
}
async function capnhatnguyenvong(id, stt) {
    $('#modal_event').show();
    var id_chucnang = 7;
    const check = await laythongtincheckquyen(id_chucnang);
    var id_taikhoan = $('#hoten').attr('id_taikhoan')
    var val = $('#capnhatnguyenvong_' + id + '_' + stt).val();
    $.ajax({
        type: 'post',
        url: '/admin24/capnhatnguyenvong',
        data: {
            id_taikhoan: id_taikhoan,
            val: val,
            id: id,
            stt: stt,
             //Check quyền
             time: check[1],
             id_manhinh: check[0],
             id_chucnang: id_chucnang,
             active: 1,
        },
        success: function(res) {
            $('#modal_event').hide();
            if (res.maloi == 'validate') {
                toastr.warning(res.noidung['original']['val'][0])
            } else {
                thongbao(res.thongbao)
                timkiemthisinh(id_taikhoan);
            }
        }
    })
}
$('#khoahoso').on('click', async function(){
    $('#modal_event').show();
    var id_chucnang = 2;
    const check = await laythongtincheckquyen(id_chucnang);
    var id_taikhoan = $('#hoten').attr('id_taikhoan')
    $.ajax({
        type: 'post',
        url: '/admin24/khoahoso',
        data: {
            id_taikhoan: id_taikhoan,
            //Check quyền
            time: check[1],
            id_manhinh: check[0],
            id_chucnang: id_chucnang,
            active: 1,
        },
        success: function(res) {
            if(res.trangthai == 'upd_1'){
                toastr.success(res.noidung)
            }else{
                thongbao(res.trangthai)
            }
            hoso_danhsach.ajax.reload();
            timkiemthisinh(id_taikhoan);
            $('#modal_event').hide();
        }
    })
});
$('#duyethoso').on('click', async function(){
    $('#modal_event').show();
    var id_chucnang = 8;
    const check = await laythongtincheckquyen(id_chucnang);
    var id_taikhoan = $('#hoten').attr('id_taikhoan')
    $.ajax({
        type: 'post',
        url: '/admin24/duyethoso',
        data: {
            id_taikhoan: id_taikhoan,
            //Check quyền
            time: check[1],
            id_manhinh: check[0],
            id_chucnang: id_chucnang,
            active: 1,
        },
        success: function(res) {
            hoso_danhsach.ajax.reload();
            timkiemthisinh(id_taikhoan);
            $('#modal_event').hide();
            thongbao(res.trangthai)
        }
    })
});

$('#guimail_kiemtrahoso').on('click', async function(){
    $('#modal_event').show();
    let id_chucnang = 2
    const check = await laythongtincheckquyen(id_chucnang);
    let noidungloi = $('#summernote_kiemtrahoso').val()
    var id_taikhoan = $('#hoten').attr('id_taikhoan')
    $.ajax({
        type: 'post',
        url: '/admin24/guimail_kiemtrahoso',
        data: {
            noidungloi: noidungloi,
            id_taikhoan: id_taikhoan,
            //Check quyền
            time: check[1],
            id_manhinh: check[0],
            id_chucnang: id_chucnang,
            active: 1,
        },
        success: function(res) {
            $('#modal_event').hide();
            if(['send_0','send_1','rol_2','-100','khoa_1'].includes(res) == true){
                thongbao(res)
                $('#summernote_kiemtrahoso').summernote('code','')
            }else{
                values_err = Object.values(res)
                toastr.warning(values_err[0])
            }
        }
    })
})
