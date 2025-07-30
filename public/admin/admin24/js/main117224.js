$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // $('#contentheader_manhinh').hide()

    //Cấu hình thông báo toasts
    toastr.options = {
        'closeButton': true,
        'debug': false,
        'newestOnTop': false,
        'progressBar': true,
        'positionClass': 'toast-top-center',
        'preventDuplicates': true,
        'showDuration': '300',
        'hideDuration': '300',
        'timeOut': '1000',
        'extendedTimeOut': '300',
        'showEasing': 'swing',
        'hideEasing': 'linear',
        'showMethod': 'fadeIn',
        'hideMethod': 'slideUp',
    }
    contentheader();



});

function search_datatables(table_column) {
    var tencot = table_column.split('_')
    var table1 = $("#"+tencot[0]).DataTable()
    var index = table1.column(tencot[1]+':name').index();
    var value = $('#'+table_column).val()
    table1.column(index).search(value).draw();



}

function contentheader(){
    return new Promise(function(resolve, reject) {
        var duongdan = location.href.split('/').pop();
        $.ajax({
            url: "/admin24/contentheader/"+duongdan,
            type: 'get',
            success: function (res) {
                $('#contentheader_level1').text(res.level1)
                $('#contentheader_level2').text(res.level2)
                $('#contentheader_level2').attr('id_manhinh',res.id_manhinh)
                resolve(res.id_manhinh)
            }
        });
    });
}

function laythongtincheckquyen(id_chucnang){
    return new Promise(function(resolve, reject) {
        var duongdan = location.href.split('/').pop();
        $.ajax({
            url: "/admin24/lay_id_manhinh/"+duongdan+'/'+id_chucnang,
            type: 'get',
            success: function (res) {
                // var times = res.time;
                var api = [res.id_manhinh,res.time]
                resolve(api)
            }
        });
    })
}

// Lấy id của màn hình
// function lay_id_manhinh() {
//     // return new Promise(function(resolve, reject) {
//         var duongdan = location.href.split('/').pop();
//         $.ajax({
//             url: "/admin24/lay_id_manhinh/"+duongdan,
//             type: 'get',
//             success: function (res) {
//                 localStorage.clear()
//                 localStorage.setItem('api', res.time);
//                 localStorage.setItem('id_manhinh', res.id_manhinh);
//             }
//         });
//     // });
// }

//Kiểm tra màn hình có quyền hay không?
function kiemtraquyenmanhinh(id_manhinh, id_chucnang) {
    return new Promise(function(resolve, reject) {
        $.ajax({
            url: "/admin24/kiemtraquyenmanhinh",
            type: 'post',
            data: {
                id_manhinh  : id_manhinh,
                id_chucnang : id_chucnang,
            },
            success: function (res) {
                resolve(res)
            }
        });
    });
}

//Logout
function userLogout_admin(){
    $.ajax({
        type: "post",
        url: "/admin24/logout",
        success:function(res){
            window.location="/loginadmin";
        }
    });
}

// Đổi mật khẩu
function show_doimatkhau(){
    $('#modal_doimatkhau').show()
}

function modal_cancel_doimatkhau(){
    $('#modal_doimatkhau').hide()
}

function doimatkhau(){
    $('.validate_resetpass').text('');
    var passwordreset_confirm = $('#passwordreset_confirm').val();
    var passwordreset = $('#passwordreset').val();
    var passwordreset_old = $('#passwordreset_old').val();
    $.ajax({
        type: "post",
        url: "/admin24/doimatkhau",
        data: {
            passwordreset_confirm: passwordreset_confirm,
            passwordreset: passwordreset,
            passwordreset_old: passwordreset_old,
        },
        success:function(res){
            switch (res.trangthai) {
                case 0:
                    $('#error_passwordreset_confirm').text(res.noidung)
                    break;
                case 2:
                    $('#error_passwordreset_old').text(res.noidung)
                    break;
                case 3:
                    $('#error_passwordreset').text(res.noidung)
                    break;
                case 1:
                    toastr.success(res.noidung)
                    setTimeout(() => {
                        userLogout_admin()
                    }, 1000);
                    break;
                default:
                    var validate_resetpass = document.getElementsByClassName('validate_resetpass')
                    var keys = Object.keys(res.noidung['original']);
                    validate(res.noidung,keys,validate_resetpass)
                    break;
            }
        }
    });
}

//Thông báo
function thongbao(id){
    switch (id) {
        //Lỗi hệ thống
        case 'err_0': //Thêm thành công
            toastr.error('Lỗi hệ thống, vui lòng dừng sử dụng')
        break;
        //Insert
        case 'ins_0': //Thêm thành công
            toastr.error('Thêm mới dữ liệu thất bại!!!')
        break;
        case 'ins_1': //Thêm thành công
            toastr.success('Thêm mới dữ liệu thành công!')
            break;
        //Update
        case 'upd_0': //Cập nhập thành công
            toastr.error('Cập nhật dữ liệu thất bại')
            break;
        case 'upd_1': //Cập nhật thất bại
            toastr.success('Cập nhật dữ liệu thành công')
            break;
        case 'upd_2': //Không có dữ liệu mới
            toastr.warning('Không có dữ liệu mới')
            break;
        case 'upd_3': //Không có dữ liệu mới
            toastr.warning('Hệ thống đã có tài khoản, không cập nhật trùng được')
            break;


        //Delele
        case 'del_0': //Xóa thất bại
            toastr.error('Xóa thất bại')
            break;
        case 'del_1': //Xóa thất bại
            toastr.success('Xóa thành công')
            break;

        //Kiểm tra quyền
        case 'rol_0': //Cập nhật dữ liệu thất bại
            toastr.error('Cập nhật dữ liệu thất bại')
            break;
        case 'rol_1': //
            toastr.success('Cập nhật dữ liệu thành công')
            break;
        case 'rol_2': //
            toastr.warning('Người dùng chưa được phân quyền')
            break;
        case 'rol_3': //
            toastr.warning('Màn hình không có chức năng')
            break;
        case 'rol_4': //
            toastr.warning('Người dùng không được phân công')
            break;
        case 'duyet_pass':
            toastr.warning('Hồ sơ đã được duyệt');
            break;
        case 'find_no': //Tìm kiếm thí sinh
            toastr.warning('Không tìm thấy thí sinh');
            break;
        //Trang thai dang ky
        case 'dangky_0': //Khóa hồ sơ
            toastr.warning('Thí sinh chưa chính thức đăng ký xét tuyển');
            break;
        case 'dangky_1': //Khóa hồ sơ
            toastr.warning('Thí sinh đã đăng ký xét tuyển!');
            break;


        //Khóa
        case 'khoa_1': //Khóa hồ sơ
            toastr.warning('Hồ sơ đã được khóa, không cập nhật được');
            break;
        case 'khoa_0': //Khóa hồ sơ
            toastr.warning('Hồ sơ chưa khóa!!!');
        break;
        //Duyệt
        case 'duyet_0': //Đã duyệt
            toastr.success('Đã duyệt!!! Cập nhật duyệt hồ sơ thàng công!');
            break;
        case 'duyet_1': //Đã duyệt
            toastr.success('Hủy duyệt thành công!');
        break;

        // Lỗi hệ thống
        case '-100': //Lỗi hệ thống
            toastr.error('Hệ thống bị lỗi vì có người cố ý chỉnh sửa');
        break;
        case 'send_1': //Đã duyệt
            toastr.success('Gửi mail thành công');
        break;
        case 'send_0': //Đã duyệt
            toastr.warning('Gửi mail thất bại');
        break;

        //Trang thai CMND
        case 'cmnd_0': //Khóa hồ sơ
            toastr.warning('Chứng minh nhân dân đã tồn tại trên hệ thống');
            break;

        case 'ngvg_0': //Khóa hồ sơ
            toastr.warning('Thí sinh không có nguyện vọng xét tuyển');
            break;


        //Xét tuyển
        case 'xt_ds_1': //Khóa hồ sơ
            toastr.success('Đã duyệt danh sách xét tuyển');
            break;
        case 'xt_ds_2': //Khóa hồ sơ
            toastr.warning('Thí sinh đã trúng tuyển đợt này!');
            break;

        //Đợt tuyển ính
        case 'dot_1': //Khóa hồ sơ
            toastr.warning('Đợt tuyển sinh đã khóa');
            break;
        case 'dot_-1': //Khóa hồ sơ
            toastr.warning('Vui lòng Chọn đợt xét tuyển!!!');
            break;
        case 'xacnhan_1':
            toastr.warning("Thí sinh hoặc cán bộ đã xác nhận học học")
            break;
        case 'dot_0':
            toastr.warning("Chưa có đợt tuyển sinh")
            break;
        case 'dot_2':
            toastr.warning("Đợt tuyển sinh hiện tại chưa được khóa!!!")
            break;
        //Dư lieu table
        case 'table_0': //Khóa hồ sơ
            toastr.warning('Không có dữ liệu');
            break;

        //Import
        case 'imp_0':
            toastr.error('Hệ thống bị lỗi');
            break;
        case 'imp_1':
            toastr.success('Import dữ liệu thành công');
            break;
        case 'imp_2':
            toastr.warning('Vui lòng chọn dữ liệu upload');
            break;
        case 'imp_3':
            toastr.warning('Vui lòng chọn file exel theo mẫu');
            break;
        case 'imp_4':
            toastr.success('Tính điểm thành công');
            break;
        //Trúng tuyển
        case 'tt_0':
            toastr.warning('Thí sinh chưa trúng tuyển');
            break;

        //Đồng phục
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
        case 'dotnhap_0': //Đã bán hết sản phẩm
            toastr.warning('Đợt đã đóng không thể chỉnh sửa');
            break;
        case 'checksl_0':
            toastr.warning('Quá số lượng cần nhập vui lòng kiểm tra lại');
            break;
        case 'DaNhap_0':
            toastr.warning('Sản phẩm đã nhập không thể xóa');
            break;
        case 'DaNhap_1':
            toastr.warning('Số lượng yêu cầu mới không được nhỏ hơn số lượng đã nhập');
            break;
        // Quản lý đông phục
        case 'newproduct_0':
            toastr.warning('Sản phẩm đã tồn tại');
            break;
        case 'checksl_0':
            toastr.warning('Quá số lượng cần nhập vui lòng kiểm tra lại');
            break;
        case 'DaNhap_0':
            toastr.warning('Sản phẩm đã nhập không thể xóa');
            break;
        case 'DaNhap_1':
            toastr.warning('Số lượng yêu cầu mới không được nhỏ hơn số lượng đã nhập');
            break;
        // Quản lý danh mục
        case 'prod_0':
            toastr.warning('Sản phẩm đã sử dụng không thể thực thi');
            break;
        case 'prod_1':
            toastr.warning('Sản phẩm đang khóa không thể thực thi');
            break;
        case 'prod_2':
            toastr.warning('Sản phẩm đã tồn tại');
            break;

        //Table
        case 'ser_1':
            toastr.warning('Vui lòng chọn một giá trị để tìm kiếm!!!');
            break;

        default:
            break;
    }
}

function thongbao_error(res){
    original = res.noidung.original
    ma_loi = Object.keys(original)
    noidung_error = res.noidung.original[ma_loi[0]][0];
    toastr.warning(noidung_error);
}
function validate_span_error(res, error_validate){
    original = res.noidung.original
    validate_keys = Object.keys(original)
    for(let i = 0; i < error_validate.length; i++){
        $('#'+error_validate[i]).text('')
    }
    for(let i = 0; i < validate_keys.length; i++){
        $('#error_'+validate_keys[i]).text(res.noidung.original[validate_keys[i]][0])
    }
}
function input_error(res){
    $("#nhasanxuat_moi").css("border", "");
    original = res.noidung.original
    validate_keys = Object.keys(original)
    for(let i = 0; i < validate_keys.length; i++){
        $('#'+validate_keys[i]).css("border", "1px solid red");
    }
}

//Validate form
function validate(result,keys,class_dom_validate){
    for (let j = 0; j < class_dom_validate.length; j++) {
        $(class_dom_validate[j]).text('')
        for (let i = 0; i < keys.length; i++) {
            if($(class_dom_validate[j]).attr('id') == 'error_'+keys[i]){
                $('#error_'+keys[i]).text(result['original'][keys[i]])
                break;
            }
        }
    }
}

var trangthai = true;
$('.hiddenpassword').on('click',function(){
    var idlock = $(this).attr('id').split('-')
    if(trangthai == true){
        $('#'+idlock[1]).attr('type','text')
        $(this).removeClass('fa-lock');
        $(this).addClass('fa-unlock');
        trangthai = false;
    }else{
        $('#'+idlock[1]).attr('type','password')
        $(this).removeClass('fa-unlock');
        $(this).addClass('fa-lock');
        trangthai = true;
    }
})


function kiemtrafileupload(id_input,extension){
    var filePath = $('#'+id_input).val();
    var kq = 1;
    switch (extension) {
        case 1:
            var allowedExtensions = /(\.xlsx|\.xls)$/i;
            if(!allowedExtensions.exec(filePath)){
                return 'imp_3';
            }
            break;
        default:
            $kq = 0;
            break;
    }
    return kq;
}

//Tính trung bình, tổng, đếm của cột
function sumForKey(dom_class) {
    var total = 0;
    var count = 0;
    var aveg = "";
    var dom = document.getElementsByClassName(dom_class)
    for(let i = 0; i< dom.length; i++){
        var value = 0;
        $(dom[i]).attr('type') == 'text' ? value = $(dom[i]).val() : value = $(dom[i]).text()
        total += Number(value);
        if(value != 0) {count++}
        count != 0 ? aveg = Math.round(total/count*100)/100 : aveg = ""
    }
    return {
        total: total,
        count: count,
        aveg: aveg
    };
}

//Canh block-left  === block-right
function equalizeHeight(){
    return new Promise (function(resolve, reject){
        var leftHeight = $('.block-left').outerHeight();
        var rightHeight = $('.block-right').outerHeight();
        var maxHeight = Math.max(leftHeight, rightHeight);
        $('.block-left, .block-right').outerHeight(maxHeight);
        resolve(1);
    })
}

function open_preloader(element){
    return new Promise (function(resolve, reject){
        $('#preloader').show();
        var ele = '.load-index'
        if( element != 0 ){ ele = '#'+element }
        $(ele).prepend('<div class="load-index-children"></div>');
        $(ele).find('.load-index-children').addClass('load-index-overlay');
        resolve(true)
    })
}
function await_preloader(time){
    return new Promise (function(resolve, reject){
        setTimeout(() => {}, time);
        resolve(true)
    })
}
function close_preloader(element){
    return new Promise (function(resolve, reject){
        var ele = '.load-index'
        if( element != 0 ){ ele = '#'+element }
        $(ele).find('.load-index-children').addClass('hide'); // Thêm class 'hide' để bắt đầu hiệu ứng ẩn dần
        setTimeout(function() {
            $('#preloader').hide();
            $(ele).find('.load-index-children').removeClass('load-index-overlay hide'); // Loại bỏ class sau khi hiệu ứng kết thúc
            $(ele).find('.load-index-children').removeClass('load-index-overlay');
            $(ele).children().first().remove();
        }, 1000);
        resolve(true)
    })
}

function table_thongtintimkiem(class_dom){
    return new Promise (function(resolve, reject){
        let data = {};
        var tcsv = document.getElementsByClassName(class_dom)
        for (let i = 0; i < tcsv.length; i++) {
            var id = $(tcsv[i]).attr('id')
            data[id] = $(tcsv[i]).val();
        }
        resolve(data);
    })
}
function table_laygiatribandau(class_dom){
    return new Promise (function(resolve, reject){
        let data = {};
        var tcsv = document.getElementsByClassName(class_dom)
        for (let i = 0; i < tcsv.length; i++) {
            var id = $(tcsv[i]).attr('id')
            data[id] = $(tcsv[i]).attr('val-def');
        }
        resolve(data);
    })
}
function table_isEqual(startData,searchData){
    return new Promise (function(resolve, reject){
        var result = {}
        if(startData == 0 || JSON.stringify(startData) === JSON.stringify(searchData) ){
            result.trangthai = 0
            result.data = startData
        }else{
            result.trangthai = 1
            result.data = searchData
        }
        console.log(result)
        resolve(result);
    })
}
function thongtintimkiem_input_reg(class_dom){
    return new Promise (function(resolve, reject){
        var dom = document.getElementsByClassName(class_dom)
        let reg = /[!@#$%^&*(),.?":{}|<>]+/
        var j = 0;
        let result = [];
        let data = JSON.parse(JSON.stringify({}));
        for (let i = 0; i < dom.length; i++) {
            if(reg.test($(dom[i]).val()) == true){
                result.push($('#lb-'+ $(dom[i]).attr('id')).text().trim().slice(0, -1).trim());
                j++;
            }
        }
        if(j>0){
            data.mess = result;
            data.error = 1;
        }else{
            data.mess = '';
            data.error = 0;
        }
        resolve(data);
    })
}
