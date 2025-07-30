$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.menu5').css('background-color','#2e3192')
    $('.menu5').find('i').css('color','#f4f6f9')
    $('.menu5').find('div').css('color','#f4f6f9')
    $('.menu5').find('strong').css('color','#f4f6f9')

    $.ajax({
        url: "/congboketqua/daxemketqua",
        type:'POST',
        success:function(res){

        }
    })


    $('#id_dantoc').select2()
    $('#noicapcccd').select2();
    $('#id_quoctich').select2();
    $('#id_tongiao').select2();

        //noisinh
    $('#id_tinh_noisinh').select2()
    $('#id_huyen_noisinh').select2()
    $('#id_xa_noisinh').select2()
    //quequan
    $('#id_tinh_quequan').select2()
    $('#id_huyen_quequan').select2()
    $('#id_xa_quequan').select2()
    //ttru
    $('#id_tinh_ttru').select2()
    $('#id_huyen_ttru').select2()
    $('#id_xa_ttru').select2()

    loadthongtinsinhvien()
})

function loadthongtinsinhvien(){
    $.ajax({
        type: "get",
        url: "/congboketqua/loadthongtinsinhvien",
        success: function (res) {
            switch (res['trangthai']) {
                case 'up_2':
                    hsnh_resetformthongtincannhan()
                    toastr.warning('CCCD không khớp với MSSV');
                    break;
                case 'up_3':
                    toastr.warning('Vui lòng nhập CCCD hoặc MSSV');
                    hsnh_resetformthongtincannhan()
                    break;
                case 1:
                    var res = res['data']
                    $('#giaykhaisinh').val(res.giaykhaisinh);
                    // $('#gioitinh').prop('checked', res.gioitinh == 1);
                    $('#id_dantoc').select2({ data: res.dantoc });
                    $('#id_quoctich').select2({ data: res.quoctich });
                    $('#id_tongiao').select2({ data: res.tongiao });
                    $('#ngaycapcccd').val(res.ngaycapcccd);
                    $('#noicapcccd').select2({ data: res.noicapcccd });
                    $('#ngayvaodang').val(res.ngayvaodang);
                    $('#ngayvaodoan').val(res.ngayvaodoan);
                    $('#id_tinh_noisinh').select2({ data: res.noisinh_tinh });
                    $('#id_huyen_noisinh').select2({ data: res.noisinh_huyen });
                    $('#id_xa_noisinh').select2({ data: res.noisinh_xa });
                    $('#id_tinh_quequan').select2({ data: res.quequan_tinh });
                    $('#id_huyen_quequan').select2({ data: res.quequan_huyen });
                    $('#id_xa_quequan').select2({ data: res.quequan_xa });
                    $('#id_tinh_ttru').select2({ data: res.ttru_tinh });
                    $('#id_huyen_ttru').select2({ data: res.ttru_huyen });
                    $('#id_xa_ttru').select2({ data: res.ttru_xa });
                    $('#duoi_xa_quequan').val(res.duoi_xa_quequan);
                    $('#duoi_xa_ttru').val(res.duoi_xa_ttru);
                    $('#hotencha').val(res.hotencha);
                    $('#hotenme').val(res.hotenme);
                    $('#nguoidodau').val(res.nguoidodau);
                    $('#dienthoaicha').val(res.dienthoaicha);
                    $('#dienthoaime').val(res.dienthoaime);
                    $('#dienthoainguoidodau').val(res.dienthoainguoidodau);
                    $('#nghenghiepcha').val(res.nghenghiepcha);
                    $('#nghenghiepme').val(res.nghenghiepme);
                    $('#nghenghiepnguoidodau').val(res.nghenghiepnguoidodau);
                    // $('#khuyettat').select2({ data: res.khuyettat });
                    $('#bhyt').val(res.bhyt);
                    $('#diachilienlac').val(res.diachilienlac);
                    // if(res.mssv == null){
                    //     $('#mssv').attr('disabled',false);
                    // }else{
                    //     $('#mssv').attr('disabled','true');
                    // }
                    // $('#mssv').val(res.mssv);

                break;
            }
        }
    })

}


function loadtinh() {
    $.ajax({
        type: "get",
        url: "congboketqua/loadtinh",
        //load data tỉnh
        success: function (data) {
            $('#id_tinh_noisinh').select2({
                data: data
            })

        }
    });
}
// Hàm load select2 huyện
function loadhuyen() {
    // thay thế vị trí
    $('#id_huyen_noisinh').empty()
    $('#id_xa_noisinh').empty()

    // lấy id tỉnh
    var tinh1 = $('#id_tinh_noisinh').val();
    $.ajax({
        type: "get",
        url: "congboketqua/loadhuyen/" + tinh1,

        // load data huyện
        success: function (res) {
            $('#id_huyen_noisinh').select2({
                data: res
            })

        }
    });
}
// Hàm load select2 xã
function loadxa() {
    // thay thế vị trí
    $('#id_xa_noisinh').empty()

    // lấy id huyện
    var huyen1 = $('#id_huyen_noisinh').val();
    $.ajax({
        type: "get",
        url: "congboketqua/loadxa/" + huyen1,

        // load data xã
        success: function (res) {
            $('#id_xa_noisinh').select2({
                data: res
            })

        }
    });
}
// Hàm load select2 tỉnh
function loadtinh2() {
    $.ajax({
        type: "get",
        url: "congboketqua/loadtinh2",
        //load data tỉnh
        success: function (data) {
            $('#id_tinh_ttru').select2({
                data: data
            })
        }
    });
}
// Hàm load select2 huyện
function loadhuyen2() {
    // thay thế vị trí
    $('#id_huyen_ttru').empty()
    $('#id_xa_ttru').empty()

    // lấy id tỉnh
    var tinh2 = $('#id_tinh_ttru').val();
    $.ajax({
        type: "get",
        url: "congboketqua/loadhuyen2/" + tinh2,

        // load data huyện
        success: function (res) {
            $('#id_huyen_ttru').select2({
                data: res
            })

        }
    });
}
// Hàm load select2 xã
function loadxa2() {
    // thay thế vị trí
    $('#id_xa_ttru').empty()

    // lấy id huyện
    var huyen2 = $('#id_huyen_ttru').val();
    $.ajax({
        type: "get",
        url: "congboketqua/loadxa/" + huyen2,

        // load data xã
        success: function (res) {
            $('#id_xa_ttru').select2({
                data: res
            })


        }
    });
}
//quequan
// Hàm load select3 tỉnh
function loadtinh3() {
    $.ajax({
        type: "get",
        url: "congboketqua/loadtinh3",
        //load data tỉnh
        success: function (data) {
            $('#id_tinh_quequan').select2({
                data: data
            })
        }
    });
}
// Hàm load select3 huyện
function loadhuyen3() {
    // thay thế vị trí
    $('#id_huyen_quequan').empty()
    $('#id_xa_quequan').empty()

    // lấy id tỉnh
    var tinh3 = $('#id_tinh_quequan').val();
    $.ajax({
        type: "get",
        url: "congboketqua/loadhuyen3/" + tinh3,

        // load data huyện
        success: function (res) {
            $('#id_huyen_quequan').select2({
                data: res
            })

        }
    });
}
// Hàm load select3 xã
function loadxa3() {
    // thay thế vị trí
    $('#id_xa_quequan').empty()

    // lấy id huyện
    var huyen3 = $('#id_huyen_quequan').val();
    $.ajax({
        type: "get",
        url: "congboketqua/loadxa/" + huyen3,

        // load data xã
        success: function (res) {
            $('#id_xa_quequan').select2({
                data: res
            })

        }
    });
}

function capnhatthongtincannhan(){
//    alert($('#id_xa_noisinh').val())
    var ttcn = document.getElementsByClassName('capnhatttcn')
    var data = [];
    for (let i = 0; i < ttcn.length; i++) {
        if($(ttcn[i]).val() == null){
           var val = 0
        }else{
            var val = $(ttcn[i]).val()
        }
        data.push([$(ttcn[i]).attr('id'),val]);
    }
    // console.log(data)
    $.ajax({
        type: "post",
        url: "congboketqua/capnhatthongtincannhan",
        data: {
            data: data,
        },
        success: function (res) {
            resutlinfo(res)
        }
    })

}



























function xacnhannhaphoc(id){
    var cccd = $('#xacnhannhaphoc_cccd'+id).val();
    if(cccd == ""){
        toastr.warning("Vui lòng nhập CCCD/CMND")
    }else{
        $.ajax({
            url: "/congboketqua/xacnhannhaphoc",
            type:'POST',
            data: {
                cccd: cccd,
                id:id,
            },
            success:function(res){
                if(res.trangthai == 'khoadot_1'){
                    resutlinfo(res.trangthai)
                }else{
                    if(res.trangthai == -100){
                        toastr.warning('Hệ thống bị lỗi, liên hệ Phòng Đào tạo - 02923898167')
                    }else{
                        if(res.trangthai == 0){
                            toastr.warning('Thí sinh đã xác nhận!!!')
                        }else{
                            $('#xacnhannhaphoc_cccd'+id).attr('disabled',true)
                            $('#xacnhannhaphoc'+id).attr('disabled',true)
                            toastr.success('Xác nhận nhập học thành công! Vui lòng thực hiện bước 2, khi Bộ GD&ĐT cho phép đăng ký nguyện vọng')
                        }
                    }
                }
            }
        })
    }
}




