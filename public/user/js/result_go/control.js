$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
if($(document).width() > 992){
    $('#right_instruct').css('min-height','630px')
    $('#left_instruct').css('min-height','630px')
}else{
    $('#right_instruct').css('min-height','0x')
    $('#left_instruct').css('min-height','0px')
}

$(window).resize(function(){
    if($(document).width()>992){
        $('#right_instruct').css('min-height','630px')
        $('#left_instruct').css('min-height','630px')
    }else{
        $('#right_instruct').css('min-height','0x')
        $('#left_instruct').css('min-height','0px')

    }
});
bogddt_result_go()
load_wish();
load_info();
load_result();
});


function load_wish(){
    $.ajax({
        type: "get",
        url: "go_result/load_wish",
        success: function (res) {
            if(res == 0 ){
                $('#result_wish').html('<span style="text-align:center; color:#007bff">Thí sinh chưa đăng ký nguyện vọng</span>')
            }else{
                var html = '<table class="table table-bordered table-hover">'
                    html += '<thead>'
                        html += '<tr>'
                            html += '<th>Đợt xét tuyển</th>'
                            html += '<th>Thứ tự</th>'
                            html += '<th>Phương thức xét tuyển</th>'
                            html += '<th>Ngành đăng ý</th>'
                            html += '<th>Điểm xét tuyển</th>'
                            html += '<th>Kết quả</th>'
                            html += '<th>Ghi chú</th>'
                        html += '</tr>'
                    html += '</thead>'
                    html += '<tbody>'
                        for(let i = 0; i<res.length;i++){
                            if(res[i].result == "Đủ điều kiện trúng tuyển"){
                                var color = "color:#007bff"
                                // var dowload = '<a style = "'+color+'" onclick = "download_result_go()" ><i class="fa fa-download"></i>&nbsp;&nbsp;&nbsp; Tải giấy báo</a>'
                                var dowload = "";
                            }else{
                                var dowload = "";
                                color = "color:red"
                            }
                            html += '<tr data-widget="expandable-table" aria-expanded="false">'
                                html += '<td style ="text-align:center;vertical-align: middle;">'+res[i].name_batch+'</td>'
                                html += '<td style ="text-align:center;vertical-align: middle;">'+res[i].number+'</td>'
                                html += '<td style ="text-align:center;vertical-align: middle;">'+res[i].name_method+'</td>'
                                html += '<td style ="text-align:center;vertical-align: middle;">'+res[i].name_major+'</td>'
                                html += '<td style ="text-align:center;vertical-align: middle;">'+res[i].mark+'</td>'
                                html += '<td style ="text-align:center;vertical-align: middle;'+color+'">'+res[i].result+'</td>'
                                html += '<td style ="text-align:center;vertical-align: middle;">'+dowload+'</td>'
                            html += '</tr>'
                        }
                    html += '</tbody>'
                html += '</table>'
                $('#result_wish').html(html)
            }
        }
    });
}

function load_info(){
    $.ajax({
        type: "get",
        url: "go_result/load_wish",
        success: function (res) {
            var dem = 0;
            if(res.length >0){
                for(let i = 0; i< res.length;i++){
                    if(res[i].result == "Không đủ điều kiện trúng tuyển"){
                        dem++;
                    }
                }
                if(dem == res.length){
                    $('#go_result_info').html('<button type="button" onclick="go_wish()" class="btn btn-block btn-primary btn-xs float_right"><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;&nbsp; Click Đăng ký đợt tiếp theo</button>')
                }else{
                    $('#go_result_info').html('')
                }
            }else{
                $('#go_result_info').html('')
            }
        }
    });
}



function download_result_go(){
    window.open('https://xettuyentest.ctuet.edu.vn/go_result/dowload_result_go','_blank')
    // window.open('https://congmotcua.ctuet.edu.vn/go_result/dowload_result_go','_blank')
}

function bogddt_result_go(){
    $.ajax({
        type: "get",
        url: "go_result/bogddt_result_go",
        success: function (res) {



                if(res.save == 1){
                    if(res.block_all == 0){
                        if(res.trangthai == 1){
                            var disabled = "disabled"
                        }else{
                            if(res.block == 1){
                                var disabled = "disabled"
                            }else{
                                var disabled = ""
                            }
                        }
                    }else{
                        var disabled = "disabled"
                    }

                var html = ''

                html += '<div class="row" >'
                html += '<div class="col-12 col-md-1 col-lg-1" >'
                html += '</div>'
                html += '<div class="col-12 col-md-10 col-lg-10" >'
                    html += '<span style = "color: red"><strong>1. Để Nhà trường cập nhật chính xác thông tin thí sinh đủ điều kiện trúng tuyển sớm trên HỆ THÔNG THI TỐT NGHIỆP THPT. Thí sinh vui lòng cung cấp các thông tin sau:</strong></span><br>'
                    html += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style = ""> -Số Chứng minh nhân dân hoặc Thẻ căn cước mà Trường THPT cấp để đăng ký xét tuyển trên HỆ THỐNG QUẢN LÝ THI TỐT NGHIỆP THPT</span><br>'

                    html += '<div class="col-12 col-md-5 col-lg-5">'
                        html += '<div class="form-group row" style="margin-bottom: 3px">'
                            html += '<label for="cmnd_resutl_go" class="col-sm-6 col-form-label" style="padding-bottom: 0px ">Số CMND/Thẻ căn cước:</label>'
                            html += '<div class="col-sm-6">'
                                html += '<input type="text" class="form-control" old-data = "'+res.id_card_users_bo+'" new-data = "'+res.id_card_users_bo+'" id="id_card_users_bo" style="height:28px" '+disabled+' value = "'+res.id_card_users_bo+'">'
                            html += '</div>'
                        html += '</div>'
                    html += '</div>'




                    html += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style = ""> -Số điện thoại liên hệ chính thức để Nhà trường liên hệ khi cần thiết</span>'


                    html += '<div class="col-12 col-md-5 col-lg-5">'
                        html += '<div class="form-group row" style="margin-bottom: 3px">'
                            html += '<label for="phone_resutl_go" class="col-sm-6 col-form-label" style="padding-bottom: 0px">Số điện thoại:</label>'
                            html += '<div class="col-sm-6">'
                                html += '<input type="text" class="form-control" old-data = "'+res.phone_users_bo+'" new-data = "'+res.phone_users_bo+'" id="phone_users_bo" style="height:28px" '+disabled+' value = "'+res.phone_users_bo+'">'
                            html += '</div>'
                        html += '</div>'
                    html += '</div>'


                    html += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>-<strong style="color: red">Đồng ý đăng ký NGUYỆN VỌNG 1</strong> trên hệ thống HỆ THỐNG QUẢN LÝ THI TỐT NGHIỆP THPT của Bộ GD&ĐT</span><br>'
                    html += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style = ""> Mã trường: <strong style = "color: red">KCC</strong></span><br>'
                    html += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style = ""> Mã ngành: <strong style = "color: red">'+res.id_major+'</strong><br>'
                    html += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style = ""> Tên ngành: <strong style = "color: red">'+res.name_major+'</strong><br>'



                html += '</div>'
                html += '<div class="col-12 col-md-1 col-lg-1" >'
                html += '</div>'
                html += '<div class="col-12 col-md-1 col-lg-1" >'
                html += '</div>'
                html += '<div class="col-12 col-md-1 col-lg-1" >'
                html += '</div>'
                html += ' <div class="col-12 col-md-2 col-lg-2">'
                html += ' <button type="button" '+disabled+' onclick="bogddt_result_go_save('+res.id_wish+')" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp; Đồng ý xác nhận</button>'
                html += ' </div>'

                html += '<div class="col-12 col-md-1 col-lg-1" >'
                html += '</div>'

                html += '<div class="col-12 col-md-1 col-lg-1" >'
                html += '</div>'



                html += '<div class="col-12 col-md-6 col-lg-6" >'
                html += '</div>'
                html += '<div class="col-12 col-md-1 col-lg-1" >'
                html += '</div>'

                html += '<div class="col-12 col-md-10 col-lg-10" >'
                    html += '<span>2. Trường hợp thí sinh không có nhu cầu học tập tại Trường hoặc trúng tuyển trường khác vui lòng click <a><i onclick = "remove_go('+res.id_wish+')" style = "color:blue">tại đây</i> </a></span><br>'
                html += '</div>'
                html += '<div class="col-12 col-md-1 col-lg-1" >'
                html += '</div>'
                html += '<div class="col-12 col-md-1 col-lg-1" >'
                html += '</div>'

                html += '<div class="col-12 col-md-10 col-lg-10" style = "margin-top: 20px">'
                    html += '<span><i>Nhà trường không chịu trách nhiệm cũng như giải quyết mọi khiếu nại nếu thí sinh cung cấp sai thông tin theo yêu cầu và hướng dẫn trên.</i></span><br>'
                html += '</div>'

                html += '<div class="col-12 col-md-1 col-lg-1" >'
                html += '</div>'
                html += '<div class="col-12 col-md-1 col-lg-1" >'
                html += '</div>'
                html += '<div class="col-12 col-md-10 col-lg-10" >'


                    html += '<span> <strong><i>- Chi tiết liên hệ:</i></strong></span><br>'
                    // html += '<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Giảng viên: <strong style = "color: blue">'+res.name_user+'</strong> - <strong style = "color: blue">'+res.phone_users+'</strong> </span><br>'

                    html += '<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Giảng viên: <strong style = "color: blue">'+res.name_user+'</strong> - <strong style = "color: blue"></strong>'+res.phone_users+'</span><br>'
                    html += '<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Phòng Đào tạo:</i></strong><strong style = "color: blue"> 02923.898.167</strong></span><br>'


                html += ' </div>'

                // html += '<div class="col-12 col-md-5 col-lg-5">'
                //     html += '<div class="form-group row" style="margin-bottom: 3px">'
                //         html += '<label for="go_batch" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Khảo sát nhập học:</label>'
                //         html += '<div class="col-sm-8">'
                //             html += '<select class="form-control" '+disabled+' old-data = "'+res.active_bo+'" new-data = "'+res.active_bo+'" id="active_bo" style="width: 100%;">'

                //                 var a = [
                //                     'Chọn tình trạng','Đồng ý Đăng ký NV1 trên cổng của Bộ','Đồng ý Đăng ký NV khác trên cổng của Bộ','Thi sinh chờ kết quả THPT','Không nhập học tại Trường'
                //                 ]
                //                 for(let i = 0;i<a.length;i++){
                //                     if(i == res.active_bo ){
                //                         var selected = "selected"

                //                     }else{
                //                         var selected = ""
                //                     }
                //                     html += '<option value = "'+i+'" '+selected+'>'+a[i]+'</option>'
                //                 }
                //             html += '</select>'
                //         html += '</div>'
                //     html += '</div>'
                // html += '</div>'
                html += '<div class="col-12 col-md-6 col-lg-6" >'
                html += '</div>'
                html += '<div class="col-12 col-md-1 col-lg-1" >'
                html += '</div>'



                html += '<div class="col-12 col-md-6 col-lg-6" >'
                html += '</div>'
                html += '<div class="col-12 col-md-1 col-lg-1" >'
                html += '</div>'



                    html += '<div class="col-12 col-md-6 col-lg-6" >'
                    html += '</div>'
                    html += '<div class="col-12 col-md-1 col-lg-1" >'
                    html += '</div>'
                    html += '<div class="col-12 col-md-3 col-lg-3" >'
                    html += '</div>'


                    html += '<div class="col-12 col-md-1 col-lg-1" >'
                    html += '</div>'

                html += '</div>'



                }else{
                    var html = ''
                }


            $('#bogddt_result_go').html(html)

            // setTimeout(() => {
            //     $('#active_bo').select2();
            // }, 100);
        }
    })
}


function bogddt_result_go_save(id){
    // alert($('#active_bo').val());
    // var active_bo = $('#active_bo').val()
    var active_bo = 1;
    var id_card_users_bo = $('#id_card_users_bo').val()
    var phone_users_bo = $('#phone_users_bo').val()

    if(id_card_users_bo == $('#id_card_users_bo').attr('old-data') && phone_users_bo == $('#phone_users_bo').attr('old-data')){
        toastr.warning("Không có dữ liệu  mới")
    }else{
        if(id_card_users_bo == '' || phone_users_bo == ''){
            toastr.warning("Vui lòng khảo sát và nhập thông tin CMND/TTC hoặc Số điện thoại")
        }else{
            $.ajax({
                type: "get",
                url: "go_result/bogddt_result_go_save",
                data:
                {
                    id_card_users_bo: id_card_users_bo,
                    phone_users_bo: phone_users_bo,
                    id_wish: id,
                    active_bo: 1,
                },
                success: function (res) {
                    if(res == 1){
                        toastr.success("Cập nhật thành công")
                        bogddt_result_go();
                        $('#bogddt_result_go_info').html('<span style = "color: blue">CHÚC MỪNG THÍ SINH ĐẠT KẾT QUẢ ĐỦ ĐIỀU KIỆN TRÚNG TUYỂN SỚM. NHÀ TRƯỜNG RẤT HÂN HẠNH ĐÓN TIẾP THÍ SINH NHẬP HỌC TẠI TRƯỜNG.</span>')
                    }else{
                        toastr.warning("Số CMND phài là 9 hoặc 12 số, Số điện thoại phải là 10 số, vui lòng thử lại hoặc liên hệ 02923898167")
                    }
                }
            })
        }
    }
    }


    function go_wish(){

        $.ajax({
            type: "get",
            url: "go_result/go_wish",
            success: function (res) {
                if(res == 1){
                    $('#loadpageuser').load('registerwish')
                }else{
                    toastr.warning("Trường chưa có đợt xét tuyển mới")
                }
            }
        })



    }

    function remove_go(id){
        $.ajax({
            type: "post",
            url: "go_result/remove_go/"+id,
            success: function (res) {
                if(res == 1){
                    toastr.success("Đã hủy thành công")
                }else{
                    toastr.warning("Hệ thống có thể bị lỗi, Vui lòng thử lại hoặc liên hệ 02923.898.167")
                }
            }
        })
    }
