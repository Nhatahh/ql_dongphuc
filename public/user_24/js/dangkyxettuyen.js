
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.menu4').css('background-color','#2e3192')
    $('.menu4').find('i').css('color','#f4f6f9')
    $('.menu4').find('div').css('color','#f4f6f9')
    $('.menu4').find('strong').css('color','#f4f6f9')
})

$(".increase").on("click",function () {
    var a = 1 + Number($(this).prev().val());
    if(a>3){
        toastr.warning("Thứ tự nguyện vọng phải bé hơn băng 3")
    }else{
        $(this).prev().val(a);
    }
})

$(".decrease").on("click",function () {
    var a =  Number($(this).next().val()) -1;
    if(a < 0){
        toastr.warning("Thứ tự nguyện vọng phải lớn hơn 0")
    }else{
        $(this).next().val(a);
    }
})

function tinhdiemthamkhao(){
    location.reload(true);
}

function hienthiloinguyenvong(nguyenvong){
    for (let i = 0; i < nguyenvong.length; i++) {
        $(nguyenvong[i]).css('border', '')
        if($(nguyenvong[i]).val() > 0 ){
            $(nguyenvong[i]).css('border', '1px solid red')
        }
    }
}

function kiemtrathutunguyenvong(nguyenvong,id_user){
    var luunguyenvong = [];
    var j = 0;
    for (let i = 0; i < nguyenvong.length; i++) {

        if($(nguyenvong[i]).val() > 0 ){
            luunguyenvong[j] = [id_user,$(nguyenvong[i]).attr('nganh'),$(nguyenvong[i]).attr('tohop'),$(nguyenvong[i]).attr('diem'),$(nguyenvong[i]).val(),$(nguyenvong[i]).attr('diemtohop'),$(nguyenvong[i]).attr('diemuutien')]
            j++;
        }
    }
    if(luunguyenvong.length == 0){
        return "chuaconguyenvong"
    }else{
        for (let i = 0; i < luunguyenvong.length; i++) {
            for (let j = i+1; j < luunguyenvong.length; j++) {
                if(luunguyenvong[j][4] < luunguyenvong[i][4]){
                    var tam0 =  luunguyenvong[j][0];
                    luunguyenvong[j][0] = luunguyenvong[i][0];
                    luunguyenvong[i][0] = tam0;

                    var tam1 =  luunguyenvong[j][1];
                    luunguyenvong[j][1] = luunguyenvong[i][1];
                    luunguyenvong[i][1] = tam1;

                    var tam2 =  luunguyenvong[j][2];
                    luunguyenvong[j][2] = luunguyenvong[i][2];
                    luunguyenvong[i][2] = tam2;

                    var tam3 =  luunguyenvong[j][3];
                    luunguyenvong[j][3] = luunguyenvong[i][3];
                    luunguyenvong[i][3] = tam3;

                    var tam4 =  luunguyenvong[j][4];
                    luunguyenvong[j][4] = luunguyenvong[i][4];
                    luunguyenvong[i][4] = tam4;

                    var tam5 =  luunguyenvong[j][5];
                    luunguyenvong[j][5] = luunguyenvong[i][5];
                    luunguyenvong[i][5] = tam5;

                    var tam6 =  luunguyenvong[j][6];
                    luunguyenvong[j][6] = luunguyenvong[i][6];
                    luunguyenvong[i][6] = tam6;

                }
            }
        }
        if(luunguyenvong.length > 3){
            return 'nhieunguyenvong';
        }else{
            var dem = 0;
            for (let i = 1; i <= luunguyenvong.length; i++) {
                if(luunguyenvong[i-1][4] != i){
                    dem++;
                }
            }
            if(dem>0){
                return "loithutunguyenvong";

            }else{
                return luunguyenvong;
            }
        }
    }
}


$('#luunguyenvong').on('click',function(){
    // e.preventDefault();
    $('#modal_event').show();
    setTimeout(() => {
        var id_user = $(this).attr('id_user')
        var nguyenvong = document.getElementsByClassName('nguyenvong')
        var kiemtra = kiemtrathutunguyenvong(nguyenvong,id_user)
        switch (kiemtra) {
            case 'nhieunguyenvong':
                toastr.warning("Đã chọn nhiều hơn 03 nguyện vọng")
                hienthiloinguyenvong(nguyenvong)
                break;
            case 'loithutunguyenvong':
                toastr.warning("Nguyện vọng phải đủ thứ tự. Ví dụ: 01 nguyện vọng là 1; 02 nguyện vọng là 1,2; 03 nguyện vọng là 1,2,3")
                hienthiloinguyenvong(nguyenvong)
                break;
            case 'chuaconguyenvong':
                toastr.warning("Thí sinh chưa chọn nguyện vọng")
                break;
            default:
                $.ajax({
                    url: "/dangkyxettuyen/luunguyenvong",
                    type:'POST',
                    data: {
                        data: kiemtra,
                        id_user: id_user,
                    },
                    success:function(res){
                        if(res == 'nguongdauvao'){
                            toastr.warning("Điểm tổ hợp bé hơn ngưỡng đầu vào (18 điểm)")
                        }else{
                            if(res == "capnhatitnv"){
                                toastr.warning('Thí sinh không được cập nhật ít nguyện vọng hơn số nguyện vọng đã thanh toán lệ phi')
                            }else{
                                if(res == 'khoadangky'){
                                    toastr.warning("Bạn đã đăng ký nguyện vọng, nên không được cập nhật! Vui lòng liên hệ P.Đào tạo - 02923989167")
                                }else{
                                    resutlinfo(res)
                                    $('.nguyenvong').css('border', '')
                                }
                            }
                        }
                    }
                })
                break;
        }
        $('#modal_event').hide();
    }, 3000);
})

$('#dangkyxettuyen').on('click',function(e){
    e.preventDefault();
    $('#modal_event').show();
    setTimeout(() => {
        var id_user = $(this).attr('id_user')
        var nguyenvong = document.getElementsByClassName('nguyenvong')
        var kiemtra = kiemtrathutunguyenvong(nguyenvong,id_user)
        switch (kiemtra) {
            case 'nhieunguyenvong':
                toastr.warning("Đã chọn nhiều hơn 03 nguyện vọng")
                hienthiloinguyenvong(nguyenvong)
                break;
            case 'loithutunguyenvong':
                toastr.warning("Nguyện vọng phải đủ thứ tự. Ví dụ: 01 nguyện vọng là 1; 02 nguyện vọng là 1,2; 03 nguyện vọng là 1,2,3")
                hienthiloinguyenvong(nguyenvong)
                break;
            case 'chuaconguyenvong':
                toastr.warning("Thí sinh chưa chọn nguyện vọng")
                break;
            default:
                $.ajax({
                    url: "/dangkyxettuyen/dangky",
                    type:'POST',
                    data: {
                        id_user: id_user,
                    },
                    success:function(res){
                        switch (res['act']) {
                            case 'ha_hocba':
                                toastr.warning("Vui lòng upload đủ hình 04 trang học bạ")
                                break;
                            case 'ha_cccd':
                                toastr.warning("Vui lòng upload đủ trang trước và trang sau CMND/CCCD")
                                break;
                            case 'ha_doituonguutien':
                                toastr.warning("Vui lòng upload Minh chứng đối tượng ưu tiên")
                                break;
                            case 'ha_namtotnghiep':
                                toastr.warning("Vui lòng upload Bằng Tốt nghiệp trung học phổ thông")
                                break;
                            case 'namtotnghiep':
                                toastr.warning("Vui lòng điền năm tốt nghiệp ở Mục thông tin cá nhân")
                                break;
                            case 'khuvucuutien':
                                toastr.warning("Vui lòng cập nhật Trường THPT")
                                break;
                            case 'thongtincanhan':
                                toastr.warning("Vui lòng điền thông tin cá nhân")
                                break;
                            case 'luunguyenvong':
                                toastr.warning("Vui lòng chọn nguyện vọng, lưu. Sau đó, mới đăng ký xét tuyển")
                                break;
                            case 'khoadangky':
                                toastr.warning("Bạn đã đăng ký xét tuyển, Không đăng ký được thêm nữa, vui lòng liên hệ P. Đào tạo - 02923898167 để được hướng dẫn")
                                break;
                            case '0':
                                toastr.error("Hệ thống có thể bị lỗi, vui lòng liên hệ P.Đào tào - 02923898167")
                                break;
                            case -100:
                                toastr.error("Hệ thống có thể bị lỗi, vui lòng liên hệ P.Đào tào - 02923898167")
                                break;
                            default:
                                resutlinfo(res.act)
                                $('.nguyenvong').css('border', '')
                                break;
                        }
                        if(res['disabled'] == 1){
                            $('#dangkyxettuyen').attr('disabled',true);
                            $('#luunguyenvong').attr('disabled',true);
                            $('#yeucaucapnhat').attr('disabled',false)
                        }else{
                            $('#luunguyenvong').attr('disabled',false);
                        }
                    }
                })
                break;
        }
        $('#modal_event').hide();
    }, 3000);
})

$('#yeucaucapnhat').on('click',function(e){
    e.preventDefault();
    $('#modal_event').show();
    setTimeout(() => {
        var id_user = $(this).attr('id_user')
        $.ajax({
            url: "/dangkyxettuyen/yeucaucapnhat",
            type:'POST',
            data: {
                id_user: id_user,
            },
            success: function(res){
                if(res.code == 0 ){
                    resutlinfo(res.mes)
                    $('#yeucaucapnhat').attr('disabled',true)
                    $('#dangkyxettuyen').attr('disabled',false)
                    $('#luunguyenvong').attr('disabled',false)
                }else{
                if(res.code == 1){
                        resutlinfo(res.mes)
                }else{
                        resutlinfo(res.code)
                }
                }

            }
        });
        $('#modal_event').hide();
    }, 3000);

})






