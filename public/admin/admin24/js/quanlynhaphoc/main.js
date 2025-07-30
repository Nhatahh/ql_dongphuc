$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var duongdan = location.href.split('/').pop();
    let html = '<li class="breadcrumb-item"><a href="#">Trang chủ </a></li>'
    if(duongdan != "main"){
        $.ajax({
            url: "/admin24/contentheader/"+duongdan,
            type: 'get',
            success: function (res) {
                html += '<li class="breadcrumb-item">'+res.level1+'</li>'
                html += '<li class="breadcrumb-item">'+res.level2+'</li>'
                $('#contentheader').html(html);
            }
        });
    }else{
        html += '<li class="breadcrumb-item">Thông tin</li>'
        html += '<li class="breadcrumb-item">Thống kê</li>'
        $('#contentheader').html(html);
    }
});


function userLogout_admin(){
    $.ajax({
        type: "post",
        url: "/admin24/logout",
        success:function(res){

            window.location="/";
        }
    });
}

function thongbao(res){
    switch (res) {
        //Quản lý đồng phục
        case 'ex_0': //Phát đồng phục không thành công
            toastr.error('Phát đồng phục không thành công');
            break;
        case 'ex_1': //Phát đồng phục thành công
            toastr.success('Phát đồng phục thành công');
            break;
        case 'ex_2': //Số lượng tồn nhỏ hơn số lượng phát ra
            toastr.warning('Số lượng tồn nhỏ hơn số lượng phát ra');
            break;
        case 'ex_3': //Không có đồng phục nào được bán
            toastr.warning('Không có đồng phục nào được bán');
            break;
        case 'ex_1_0': //Đã bán hết sản phẩm
            toastr.warning('Đã bán hết sản phẩm');
            break;
            //
        case 'hinhanh':
            toastr.warning('Vui lòng cập nhật hình ảnh tại mục quản lý hình ảnh!')
            break;
        case 'thongtincannhan':
            toastr.warning('Chưa nhập thông tin cá nhân!')
            break;
        case 'khoadangky_ttcn':
            toastr.warning('Thí sinh đã đăng ký xét tuyển, không thay đổi được thông tin đã đăng ký!')
            break;
        case '-99':
            toastr.warning('Tài khoản không được phân quyền')
            break;
        case '-100':
            toastr.error('Hệ thống bị lỗi, vui lòng liên hệ admin')
            break;
        case 'UpOrIns_1':
            toastr.success('Cập nhật thông tin thành công')
            break;
        case 'UpOrIns_0':
            toastr.warning("Không có thông tin mới!!!")
            break;
        case 'UpOrIns_cccd':
            toastr.warning("CMMD/CCCD đã đăng ký tài khoản")
            break;
        case 'edit_0':
            toastr.warning('Cập nhật thất bại!!!')
            break;
        case 'edit_1':
            toastr.success("Cập nhật thành công!!!")
            break;
        case 'del_0':
            toastr.error('Xóa thất bại!!!')
            break;
        case 'del_1':
            toastr.success("Xóa thành công!!!")
            break;
        case 'up_1':
            toastr.success("Cập nhật thành công!!!")
            break;
        case 'up_0':
            toastr.success("Không có dữ liệu mới")
            break;
        case 'up_2':
            toastr.error("Cập nhật thất bại")
            break;
        case 'dangky_chua':
            toastr.warning("Thí sinh chưa đăng ký xét tuyển!!!")
            break;
        case 'mocapnhat':
            toastr.warning("Hệ thống xử lý yêu cầu thí sinh trước 17h!")
            break;
        case 'capnhatitnv':
            toastr.warning('Thí sinh không được cập nhật ít nguyện vọng hơn số nguyện vọng đã thanh toán lệ phi')
            break;

        case 'chuamodot':
            toastr.warning("Hệ thống chưa có đợt tuyển sinh mới!")
            break;
        case 'thanhtoan_pass':
            toastr.warning("Thí sinh đã thanh toán nhiều hơn, không cần thanh toán nữa")
            break;



        default:
            toastr.error("Có lỗi xảy ra!")
        break;
    }
}




