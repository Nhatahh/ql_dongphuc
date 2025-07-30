$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });


    $.ajax({
        type: "get",
        url: "/admin24/load_danhsachquyen",
        success: function (res) {
            $('#themchucnang_manhinh').select2(
                {
                    data: res
                }
            );

        }
    })
});




var importchucnang_table = $('#importchucnang_table').DataTable({

    ajax: {
        type: "get",
        url: "/admin24/load_manhinh_chucnang",
    },

    columns: [
        {
            title : 'STT',
            data: null,
            className: 'text-center',
            width: '3%',
            render: function (data, type, row, meta) {
                return meta.row + 1;  // Tính số thứ tự tự động
            }
        },
        {
            title : 'ID Màn hình',
            data: 'id_manhinh',
            width: '10%',
            className: 'text-center',
        },
        {
            title : 'Màn hình',
            data: 'name',
            width: '30%',
        },

        {
            title : 'Chức năng',
            data: 'danhmuc_chucnang_ten',
            width: '25%'
        },
        {
            title : 'Ghi chú',
            data: 'danhmuc_chucnang_ghichu',
            width: '15%'
        },
        {
            title : 'Delete',
            data: null,
            className: 'text-center',
            width: '5%',
            render: function(data, type, row) {
                return ` <i class="fa-solid fa-trash" onclick="xoa_phanquyen(${row.id_manhinh}, ${row.id_chucnang})"  style="cursor: pointer; color: red;"></i> `;
            }
        },

    ],

        "language": {
            "emptyTable": "Không tìm thấy chức năng",
            "info": " _START_ / _END_ trên _TOTAL_ chức năng",
            "paginate": {
                "first": "Trang đầu",
                "last": "Trang cuối",
                "next": "Trang sau",
                "previous": "Trang trước"
            },
            "search": "Tìm kiếm:",
            "loadingRecords": "Đang tìm kiếm ... ",
            "lengthMenu": "Hiện thị _MENU_ chức năng",
            "infoEmpty": "",
        },
        "retrieve": true,
        "paging": true,
        "pageLength": 15,
        "lengthChange": false,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        scrollY: 370,
    });

    $('#themchucnang_manhinh').select2();

    function xoa_phanquyen(id_manhinh, id_chucnang) {
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa phân quyền này?',
            text: "Hành động này không thể hoàn tác!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '/admin24/add_phanquyen', // Route xử lý xóa phân quyền
                    data: {
                        id_manhinh: id_manhinh,
                        id_chucnang: id_chucnang,
                    },
                    success: function(response) {
                        manhinh(id_manhinh)
                        $('#themchucnang_manhinh').val(id_manhinh).trigger('change');
                        if (response.success) {
                            toastr.success(response.message);
                            importchucnang_table.ajax.reload(); // Reload lại bảng dữ liệu
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Lỗi hệ thống: ' + xhr.responseText);
                    }
                });
            }
        });
    }

function manhinh(id_manhinh){

    if (id_manhinh == 0) {
        toastr.warning('Vui lòng chọn màn hình hiển thị !!!');
        $('#ip_chucnang_danhsachchucnang').empty();  // Xóa hết các checkbox hiện tại
    } else {
        $.ajax({
            type: "get",
            url: "/admin24/load_danhsachchucnang/" + id_manhinh,
            success: function (res) {
                $('#ip_chucnang_danhsachchucnang').empty();
                var html = "";
                for (let i = 0; i < res.length; i++) {
                    html += '<div class="row checkbox_chucnang">';

                    if (res[i].checked == 1) {
                        html += '<input id = "id_chucnang' + res[i].id + '" onchange = "change_chucnang(' + res[i].id_chung + ',' + res[i].id + ')"    type="checkbox" checked class="form-control khoangcach_chucnang change-chucnang" id_chung = "' + res[i].id_chung + '"     data-id="' + res[i].id + '" data-name="' + res[i].danhmuc_chucnang_ten + '">&nbsp;&nbsp;' + res[i].danhmuc_chucnang_ten;
                    } else {
                        html += '<input  id = "id_chucnang' + res[i].id + '" onchange = "change_chucnang(' + res[i].id_chung + ',' + res[i].id + ')"  type="checkbox" class="form-control khoangcach_chucnang  change-chucnang"  id_chung = "' + res[i].id_chung + '"    data-id="' + res[i].id + '" data-name="' + res[i].danhmuc_chucnang_ten + '">&nbsp;&nbsp;' + res[i].danhmuc_chucnang_ten;
                    }

                    html += '</div>';
                }
                $('#ip_chucnang_danhsachchucnang').html(html);

            }
        });
    }
}


function themchucnang_manhinh() {
    var id_manhinh = $('#themchucnang_manhinh').val();
   manhinh(id_manhinh)
}





function change_chucnang(id_chung,id_chucnang){

    var id_manhinh = $('#themchucnang_manhinh').val();  // Lấy ID màn hình
    var checked = $('#id_chucnang'+id_chucnang).prop('checked') ? 1 : 0;  // Kiểm tra xem checkbox có được tick hay không

   // Kiểm tra nếu ID không hợp lệ
    if (!id_manhinh || !id_chucnang) {
        toastr.error('ID màn hình hoặc ID chức năng không hợp lệ!');
        return;
    }


    $.ajax({
        type: 'POST',
        url: '/admin24/add_phanquyen',  // Địa chỉ xử lý ở backend
        data: {
            id_manhinh: id_manhinh,
            id_chucnang: id_chucnang,
            checked: checked,
        },
        success: function(response) {
            importchucnang_table.ajax.reload(null, false);
            if (response.success) {
                toastr.success(response.message);  // Thông báo thành công
                // Cập nhật lại bảng sau khi dữ liệu được lưu thành công

                // loadDanhsachChucnang(id_manhinh);
            } else {
                toastr.error(response.message);  // Thông báo lỗi
            }
        },
        error: function(xhr, status, error) {
            toastr.error('Có lỗi xảy ra, vui lòng thử lại!');
        },


    });
}

