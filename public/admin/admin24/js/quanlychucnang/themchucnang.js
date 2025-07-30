$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});

function containsSpecialChars(str) {
    // Kiểm tra nếu chuỗi chứa bất kỳ ký tự đặc biệt nào
    const regex = /[!@#$%^&*(),.?":{}|<>]/g;
    return regex.test(str);
}


function add_chucnang(){
    $('#tcn_themchucnang').attr('disabled',true)
    $('#modal_event').show()
    var tcn_id_chucnang =  $('#tcn_id_chucnang').val()
    var tcn_ten_chucnang =  $('#tcn_ten_chucnang').val()
    var tcn_ghichu =  $('#tcn_ghichu').val()
    $('#tcn_id_chucnang').removeClass('is-invalid');
    $('#tcn_ten_chucnang').removeClass('is-invalid');
    let hasError = false; // Biến kiểm tra có lỗi hay không
     // Kiểm tra xem cả hai trường ID và Tên chức năng có bị trống không
    if (!tcn_id_chucnang && !tcn_ten_chucnang) {
        toastr.warning('Vui lòng nhập ID chức năng và Tên chức năng!');
        $('#tcn_id_chucnang').addClass('is-invalid'); // Thêm class is-invalid
        $('#tcn_ten_chucnang').addClass('is-invalid'); // Thêm class is-invalid
        $('#tcn_themchucnang').removeAttr('disabled');
        $('#modal_event').hide();
        return; // Dừng lại nếu cả hai trường đều trống
    }
    // Kiểm tra xem các trường có bị trống không
    if (!tcn_id_chucnang) {
        toastr.warning('Vui lòng nhập ID chức năng!');
        $('#tcn_id_chucnang').addClass('is-invalid'); // Thêm class is-invalid
        $('#tcn_themchucnang').removeAttr('disabled');
        $('#modal_event').hide();
        return; // Dừng lại nếu thiếu dữ liệu ID chức năng
    }

    if (!tcn_ten_chucnang) {
        toastr.warning('Vui lòng nhập tên chức năng!');
        $('#tcn_ten_chucnang').addClass('is-invalid'); // Thêm class is-invalid
        $('#tcn_themchucnang').removeAttr('disabled');
        $('#modal_event').hide();
        return; // Dừng lại nếu thiếu dữ liệu tên chức năng
    }

    if (containsSpecialChars(tcn_id_chucnang)) {
        toastr.warning('ID chức năng không được chứa ký tự đặc biệt!');
        $('#tcn_id_chucnang').addClass('is-invalid');
        $('#tcn_themchucnang').removeAttr('disabled');
        $('#modal_event').hide();
        return;
    }

    if (containsSpecialChars(tcn_ten_chucnang)) {
        toastr.warning('Tên chức năng không được chứa ký tự đặc biệt!');
        $('#tcn_ten_chucnang').addClass('is-invalid');
        $('#tcn_themchucnang').removeAttr('disabled');
        $('#modal_event').hide();
        return;
    }

    if (/^\s/.test(tcn_id_chucnang)) {
        toastr.warning('ID chức năng không được bắt đầu bằng khoảng trắng!');
        $('#tcn_id_chucnang').addClass('is-invalid');
        $('#tcn_themchucnang').removeAttr('disabled');
        $('#modal_event').hide();
        return;
    }

    if (/^\s/.test(tcn_ten_chucnang)) {
        toastr.warning('Tên chức năng không được bắt đầu bằng khoảng trắng!');
        $('#tcn_ten_chucnang').addClass('is-invalid');
        $('#tcn_themchucnang').removeAttr('disabled');
        $('#modal_event').hide();
        return;
    }


    setTimeout(() => {
        $.ajax({
            type: 'post',
            url: '/admin24/add_chucnang',
            data: {
                tcn_id_chucnang: tcn_id_chucnang,
                tcn_ten_chucnang: tcn_ten_chucnang,
                tcn_ghichu: tcn_ghichu,
            },
            success: function(res) {
                console.log(res);
                //Load lai cai noi dung moi
                themchucnang_table.ajax.reload();
                // Xử lý từng trường hợp kết quả từ server
                if (res == 1) {
                    toastr.success('Thêm thành công chức năng!!!');
                    $('#tcn_id_chucnang').val('');
                    $('#tcn_ten_chucnang').val('');
                    $('#tcn_ghichu').val('');
                    $('#tcn_id_chucnang').removeClass('is-invalid');
                    $('#tcn_ten_chucnang').removeClass('is-invalid');
                } else {
                    toastr.error('Hệ thống đang bị lỗi, vui lòng thử lại sau!');
                }

                $('#tcn_themchucnang').removeAttr('disabled')
                $('#modal_event').hide()
            }
        })
    }, 1000);
}

function checkFormFields() {
    var isAnyFieldFilled = false;

    // Kiểm tra nếu bất kỳ trường nào có giá trị
    if ($('#tcn_id_chucnang').val() !== '' ||
        $('#tcn_ten_chucnang').val() !== '' ||
        $('#tcn_ghichu').val() !== '') {
        isAnyFieldFilled = true;
    }

    // Nếu có giá trị, bật nút Reset
    // if (isAnyFieldFilled) {
        $('#tcn_reset').prop('disabled', false); // Bật nút Reset
    // } else {
    //     $('#tcn_reset').prop('disabled', true);  // Giữ nút Reset vô hiệu hóa
    // }
}
function validateRequiredFields() {
    // Kiểm tra xem các trường ID và Tên chức năng có bị trống không
    if ($('#tcn_id_chucnang').val() === '') {
    } else {
        $('#tcn_id_chucnang').removeClass('is-invalid');
    }

    if ($('#tcn_ten_chucnang').val() === '') {
    } else {
        $('#tcn_ten_chucnang').removeClass('is-invalid');
    }
}
    // Gắn sự kiện vào các trường nhập liệu
    $('#tcn_id_chucnang, #tcn_ten_chucnang, #tcn_ghichu').on('input', function() {
        checkFormFields(); // Kiểm tra lại sau mỗi lần người dùng nhập dữ liệu
    });

    // Gán sự kiện click cho nút Reset
    $('#tcn_reset').on('click', function() {
        resetChucnang(); // Reset form khi nút Reset được nhấn
    });

    // Hàm reset form (đã có trước)
function resetChucnang() {
    $('#tcn_id_chucnang').val('');
    $('#tcn_ten_chucnang').val('');
    $('#tcn_ghichu').val('');
    toastr.info('Thông tin được làm mới');
    // Xóa các thông báo đỏ (lớp is-invalid)
    $('#tcn_id_chucnang').removeClass('is-invalid');
    $('#tcn_ten_chucnang').removeClass('is-invalid');
    // Gọi lại checkFormFields để đảm bảo nút Reset sẽ bị vô hiệu hóa sau khi reset
    checkFormFields();
}
// Hàm xử lý khi nhấn nút Xóa
function xoa_chucnang(id) {
    Swal.fire({
        title: 'Bạn có chắc chắn muốn xóa chức năng này?',
        text: "Hành động này không thể hoàn tác!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'post',
                url: '/admin24/xoa_chucnang',
                data: {
                    id: id,
                    _token: $('meta[name="csrf-token"]').attr("content")  // Đừng quên CSRF token
                },
                success: function(res) {
                    if (res == 1) {
                        toastr.success('Xóa chức năng thành công!');
                        themchucnang_table.ajax.reload();  // Reload lại bảng
                    } else {
                        toastr.error('Chức năng không tồn tại hoặc lỗi hệ thống!');
                    }
                }
            });
        }
    });
}

// Kiểm tra lại khi trang vừa tải để đảm bảo nút Reset vô hiệu hóa nếu form trống
checkFormFields();

var themchucnang_table =  $('#themchucnang_table').DataTable({
    ajax: {
        type: "get",
        url: "/admin24/load_chucnang",
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
            title : 'ID',
            data: 'danhmuc_chucnang_id',
            render: function(data, type, row) {
               return '<input id = "sua_id_chucnang'+row.id+'"  onchange = "sua_id_chucnang('+row.id+')"  style = "width:100%; background-color:inherit; border: none; height:18px " value = "'+data+'">'
            }
        },
        {
            title : 'Tên chức năng',
            data: 'danhmuc_chucnang_ten',
            render: function(data, type, row) {
                return '<input id = "sua_ten_chucnang'+row.id+'"  onchange = "sua_ten_chucnang('+row.id+')"  style = "width:100%; background-color:inherit; border: none;height:18px " value = "'+data+'">'
             }
        },
        {
            title : 'Ghi chú',
            data: 'danhmuc_chucnang_ghichu',
            width: '25%',
            render: function(data, type, row) {
                return '<input id = "sua_gc_chucnang'+row.id+'"  onchange = "sua_gc_chucnang('+row.id+')"  style = "width:100%; background-color:inherit; border: none;height:18px " value = "'+data ? data : ''+'">'
             }
        },
        {
            title : 'Trạng thái',
            data: 'trangthai',
            className: 'text-center',  // Canh giữa nội dung trong cột
            render: function(data, type, row) {
                if (data == 1) {
                    return '<input style = "height: 18px" id = "sua_trangthai'+row.id+'"   onchange = "sua_trangthai('+row.id+')"  type = "checkbox" checked>';
                } else {
                    return '<input style = "height: 18px" id = "sua_trangthai'+row.id+'"  onchange = "sua_trangthai('+row.id+')" type = "checkbox">';;
                }
            }
        },
        {
            title: 'Delete',
            data: null,
            className: 'text-center',
            render: function(data, type, row) {
                return ` <i class="fa-solid fa-trash" id="btt_xoachucnang" onclick="xoa_chucnang(${row.id})" style="cursor: pointer; color: red;"></i> `;
            }
        }
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
    "paging": false,
    "lengthChange": false,
    "searching": false,
    "ordering": false,
    "info": false,
    "autoWidth": true,
    "responsive": true,
    scrollY: 400,
});

$('#themchucnang_manhinh').select2();

function sua_id_chucnang(id) {
    var id_chucnang = $('#sua_id_chucnang' + id).val();
    var old_id_chucnang = $('#sua_id_chucnang' + id).data('old-value'); // Lưu trữ giá trị cũ
    // Kiểm tra nếu trường ID chức năng trống
    if (!id_chucnang) {
        toastr.warning('Vui lòng nhập ID chức năng!');
        $('#sua_id_chucnang' + id).addClass('is-invalid');
        // Hiển thị lại giá trị cũ
        $('#sua_id_chucnang' + id).val(old_id_chucnang);
        return; // Dừng lại nếu trường trống
    }

    // Kiểm tra ký tự đặc biệt trong ID chức năng
    if (containsSpecialChars(id_chucnang)) {
        toastr.warning('ID chức năng không được chứa ký tự đặc biệt!');
        $('#sua_id_chucnang' + id).addClass('is-invalid');
        // Hiển thị lại giá trị cũ
        $('#sua_id_chucnang' + id).val(old_id_chucnang);
        return; // Dừng lại nếu có ký tự đặc biệt
    }

    if (/^\s/.test(id_chucnang)) {
        toastr.warning('ID chức năng không được bắt đầu bằng khoảng trắng!');
        $('#sua_id_chucnang' + id).addClass('is-invalid');
        $('#sua_id_chucnang' + id).val(old_id_chucnang); // Khôi phục giá trị cũ
        return;
    }

    $.ajax({
        type: 'post',
        url: '/admin24/sua_id_chucnang',
        data: {
            id: id,
            id_chucnang: id_chucnang,
        },
        success: function(res) {
            // Cập nhật dữ liệu nếu thành công, không cần reload lại trang
            if (res == 1) {
                toastr.success('Cập nhật thành công ID!');
                $('#sua_id_chucnang' + id).removeClass('is-invalid'); // Xóa lỗi nếu có
                // Cập nhật giao diện (ví dụ, bạn có thể cập nhật lại bảng mà không tải lại trang)
                // Nếu bạn đang dùng DataTables
                themchucnang_table.ajax.reload(); // Cập nhật lại bảng mà không phải reload toàn bộ trang
            } else {
                toastr.error('Hệ thống đang bị lỗi, vui lòng thử lại sau!');
                // Hiển thị lại giá trị cũ nếu có lỗi từ server
                $('#sua_id_chucnang' + id).val(old_id_chucnang);
            }
        },
        error: function() {
            toastr.error('Lỗi kết nối, vui lòng thử lại sau!');
            // Hiển thị lại giá trị cũ nếu có lỗi kết nối
            $('#sua_id_chucnang' + id).val(old_id_chucnang);
        }
    });
}


function sua_ten_chucnang(id) {
    var ten_chucnang = $('#sua_ten_chucnang' + id).val();
    var old_ten_chucnang = $('#sua_ten_chucnang' + id).data('old-value'); // Lưu trữ giá trị cũ
    // Kiểm tra nếu trường Tên chức năng trống
    if (!ten_chucnang) {
        toastr.warning('Vui lòng nhập tên chức năng!');
        $('#sua_ten_chucnang' + id).addClass('is-invalid');
        // Hiển thị lại giá trị cũ
        $('#sua_ten_chucnang' + id).val(old_ten_chucnang);
        return; // Dừng lại nếu trường trống
    }
    // Kiểm tra ký tự đặc biệt trong Tên chức năng
    if (containsSpecialChars(ten_chucnang)) {
        toastr.warning('Tên chức năng không được chứa ký tự đặc biệt!');
        $('#sua_ten_chucnang' + id).addClass('is-invalid');
        // Hiển thị lại giá trị cũ
        $('#sua_ten_chucnang' + id).val(old_ten_chucnang);
        return; // Dừng lại nếu có ký tự đặc biệt
    }

    if (/^\s/.test(ten_chucnang)) {
        toastr.warning('Tên chức năng không được bắt đầu bằng khoảng trắng!');
        $('#sua_ten_chucnang' + id).addClass('is-invalid');
        $('#sua_ten_chucnang' + id).val(old_ten_chucnang); // Khôi phục giá trị cũ
        return;
    }

    $.ajax({
        type: 'post',
        url: '/admin24/sua_ten_chucnang',
        data: {
            id: id,
            ten_chucnang: ten_chucnang,
        },
        success: function(res) {
            if (res == 1) {
                toastr.success('Cập nhật thành công tên chức năng!');
                $('#sua_ten_chucnang' + id).removeClass('is-invalid'); // Xóa lỗi nếu có
                // Cập nhật lại dữ liệu (ví dụ, bạn có thể cập nhật lại bảng mà không cần reload trang)
                themchucnang_table.ajax.reload(); // Cập nhật lại bảng mà không phải reload toàn bộ trang
            } else {
                toastr.error('Hệ thống đang bị lỗi, vui lòng thử lại sau!');
                // Hiển thị lại giá trị cũ nếu có lỗi từ server
                $('#sua_ten_chucnang' + id).val(old_ten_chucnang);
            }
        },
        error: function() {
            toastr.error('Lỗi kết nối, vui lòng thử lại sau!');
            // Hiển thị lại giá trị cũ nếu có lỗi kết nối
            $('#sua_ten_chucnang' + id).val(old_ten_chucnang);
        }
    });
}


function sua_gc_chucnang (id){
    // alert(id)
    var gc_chucnang = $('#sua_gc_chucnang'+id).val()
    // alert(id_chucnang)
    $.ajax({
        type: 'post',
        url: '/admin24/sua_gc_chucnang',
        data: {
            id: id,
            gc_chucnang: gc_chucnang,
            // tcn_ghichu: tcn_ghichu,
        },
        success: function(res) {
            // alert(res)
            // console.log(res);
            //Load lai cai  noi noi dung moi
            themchucnang_table.ajax.reload();
            // Xử lý từng trường hợp kết quả từ server
            if (res == 1) {
                toastr.success('Ghi chú đã được cập nhật!!!');
                // $('#tcn_id_chucnang').val('');
                // $('#tcn_ten_chucnang').val('');
                // $('#tcn_ghichu').val('');
                // $('#tcn_id_chucnang').removeClass('is-invalid');
                // $('#tcn_ten_chucnang').removeClass('is-invalid');
            } else {
                toastr.error('Hệ thống đang bị lỗi, vui lòng thử lại sau!');
            }
            // if(res == 1){
            //     toastr.success('Thêm thành công chức năng!!!')
            // }else{
            //     toastr.error('Hệ thống đang bị lỗi !!')
            // }
            // $('#tcn_themchucnang').removeAttr('disabled')
            // $('#modal_event').hide()
        }
    })
}

function sua_trangthai (id){
    // alert(id)
    var check = $('#sua_trangthai'+id).prop('checked') == true ?   1 :  0
    // alert(check)
    // if(check == true){
    //     var checked = 1
    // }else{
    //     var checked = 0
    // }
    $.ajax({
        type: 'post',
        url: '/admin24/sua_trangthai',
        data: {
            id: id,
            check: check,
            // tcn_ghichu: tcn_ghichu,
        },
        success: function(res) {
            // alert(res)
            // console.log(res);
            //Load lai cai  noi noi dung moi
            themchucnang_table.ajax.reload();
            // Xử lý từng trường hợp kết quả từ server
            if (res == 1) {
                toastr.success('Trạng thái đã được cập nhật!!!');
                // $('#tcn_id_chucnang').val('');
                // $('#tcn_ten_chucnang').val('');
                // $('#tcn_ghichu').val('');
                // $('#tcn_id_chucnang').removeClass('is-invalid');
                // $('#tcn_ten_chucnang').removeClass('is-invalid');
            } else {
                toastr.error('Hệ thống đang bị lỗi, vui lòng thử lại sau!');
            }
            // if(res == 1){
            //     toastr.success('Thêm thành công chức năng!!!')
            // }else{
            //     toastr.error('Hệ thống đang bị lỗi !!')
            // }
            // $('#tcn_themchucnang').removeAttr('disabled')
            // $('#modal_event').hide()
        }
    })
}
